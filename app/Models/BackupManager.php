<?php

declare(strict_types=1);

class BackupManager
{
    public static function dir(): string
    {
        $dir = BASE_PATH . '/storage/backups';
        if (!is_dir($dir)) @mkdir($dir, 0775, true);
        return $dir;
    }

    public static function human(float $bytes): string
    {
        $u = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($u) - 1) { $bytes /= 1024; $i++; }
        return round($bytes, $i === 0 ? 0 : 1) . ' ' . $u[$i];
    }

    public static function dbSize(): int
    {
        try {
            return (int) Database::pdo()->query(
                'SELECT IFNULL(SUM(data_length + index_length),0) FROM information_schema.TABLES WHERE table_schema = DATABASE()'
            )->fetchColumn();
        } catch (\Throwable $e) { return 0; }
    }

    public static function all(): array
    {
        return Database::pdo()->query('SELECT * FROM backups ORDER BY id DESC')->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $s = Database::pdo()->prepare('SELECT * FROM backups WHERE id = ?'); $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    public static function last(): ?array
    {
        return Database::pdo()->query('SELECT * FROM backups ORDER BY id DESC LIMIT 1')->fetch() ?: null;
    }

    /** 🗄️ Dump seluruh database menjadi file .sql */
    public static function dbBackup(string $note = ''): array
    {
        $pdo = Database::pdo();
        $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);
        $fname = 'db_backup_' . date('Ymd_His') . '.sql';
        $path = self::dir() . '/' . $fname;
        $h = fopen($path, 'wb');
        if ($h === false) throw new \RuntimeException('Gagal membuat file backup (periksa izin folder storage/backups).');

        fwrite($h, "-- ================================================\n");
        fwrite($h, "-- LP3M UNIMOF · DATABASE BACKUP\n");
        fwrite($h, "-- Generated : " . date('Y-m-d H:i:s') . "\n");
        fwrite($h, "-- Database  : " . $pdo->query('SELECT DATABASE()')->fetchColumn() . "\n");
        fwrite($h, "-- Tables    : " . count($tables) . "\n");
        if ($note !== '') fwrite($h, "-- Note      : " . $note . "\n");
        fwrite($h, "-- ================================================\n");
        fwrite($h, "SET FOREIGN_KEY_CHECKS=0;\n");

        foreach ($tables as $t) {
            fwrite($h, "\n-- ----------------------------\n-- Table: $t\n-- ----------------------------\n");
            fwrite($h, "DROP TABLE IF EXISTS `$t`;\n");
            $create = $pdo->query("SHOW CREATE TABLE `$t`")->fetchColumn(1);
            fwrite($h, $create . ";\n");

            $cols = $pdo->query("SHOW COLUMNS FROM `$t`")->fetchAll(\PDO::FETCH_COLUMN);
            $colList = implode(',', array_map(fn($c) => "`$c`", $cols));
            $offset = 0;
            while (true) {
                $rows = $pdo->query("SELECT * FROM `$t` LIMIT 200 OFFSET $offset")->fetchAll(\PDO::FETCH_ASSOC);
                if (empty($rows)) break;
                $vals = [];
                foreach ($rows as $r) {
                    $cells = [];
                    foreach ($r as $v) {
                        $cells[] = $v === null ? 'NULL' : $pdo->quote((string) $v);
                    }
                    $vals[] = '(' . implode(',', $cells) . ')';
                }
                fwrite($h, "INSERT INTO `$t` ($colList) VALUES " . implode(',', $vals) . ";\n");
                $offset += 200;
            }
        }

        fwrite($h, "\nSET FOREIGN_KEY_CHECKS=1;\n-- END OF BACKUP\n");
        fclose($h);

        $size = (int) filesize($path);
        Database::pdo()->prepare(
            'INSERT INTO backups (filename,kind,size_bytes,tables_count,note,created_by) VALUES (?,?,?,?,?,?)'
        )->execute([$fname, 'db', $size, count($tables), $note ?: null, Auth::user()['name'] ?? 'Sistem']);

        return ['filename' => $fname, 'size' => $size, 'tables' => count($tables)];
    }

    /** 📦 Zip folder public/uploads (bila ZipArchive tersedia) */
    public static function zipAvailable(): bool
    {
        return class_exists('ZipArchive');
    }

    public static function zipUploads(): array
    {
        if (!self::zipAvailable()) throw new \RuntimeException('Ekstensi ZipArchive tidak tersedia di server.');
        $src = BASE_PATH . '/public/uploads';
        if (!is_dir($src)) throw new \RuntimeException('Folder uploads tidak ditemukan.');

        $fname = 'uploads_backup_' . date('Ymd_His') . '.zip';
        $path = self::dir() . '/' . $fname;
        $zip = new \ZipArchive();
        if ($zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('Gagal membuat file ZIP.');
        }
        $count = 0;
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($src, \FilesystemIterator::SKIP_DOTS));
        foreach ($it as $file) {
            if ($file->isFile()) {
                $zip->addFile($file->getPathname(), 'uploads/' . substr($file->getPathname(), strlen($src) + 1));
                $count++;
            }
        }
        $zip->close();

        $size = (int) filesize($path);
        Database::pdo()->prepare(
            'INSERT INTO backups (filename,kind,size_bytes,tables_count,note,created_by) VALUES (?,?,?,?,?,?)'
        )->execute([$fname, 'files', $size, $count, 'Backup file uploads', Auth::user()['name'] ?? 'Sistem']);

        return ['filename' => $fname, 'size' => $size, 'tables' => $count];
    }

    /** ♻️ Jalankan restore dari file dump buatan sistem ini */
    public static function restore(string $path): int
    {
        $pdo = Database::pdo();
        $lines = file($path, FILE_IGNORE_SKIP_EMPTY_LINES);
        if ($lines === false) throw new \RuntimeException('File backup tidak dapat dibaca.');

        $pdo->exec('SET FOREIGN_KEY_CHECKS=0');
        $buffer = '';
        $executed = 0;
        foreach ($lines as $raw) {
            $line = rtrim($raw, "\r\n");
            $t = trim($line);
            if ($t === '' || str_starts_with($t, '--')) continue;
            $buffer .= $line . "\n";
            if (str_ends_with($t, ';')) {
                $sql = trim(rtrim(trim($buffer), ';'));
                $buffer = '';
                if ($sql === '' || in_array(strtoupper($sql), ['SET FOREIGN_KEY_CHECKS=0', 'SET FOREIGN_KEY_CHECKS=1'], true)) continue;
                $pdo->exec($sql);
                $executed++;
            }
        }
        $pdo->exec('SET FOREIGN_KEY_CHECKS=1');
        return $executed;
    }

    public static function delete(int $id): void
    {
        $row = self::find($id);
        if (!$row) return;
        $p = self::dir() . '/' . $row['filename'];
        if (is_file($p)) @unlink($p);
        Database::pdo()->prepare('DELETE FROM backups WHERE id = ?')->execute([$id]);
    }
}