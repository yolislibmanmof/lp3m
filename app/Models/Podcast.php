<?php

declare(strict_types=1);

/**
 * Model Podcast — episode audio lembaga (upload MP3 atau URL eksternal).
 */
class Podcast
{
    public const CATEGORIES = [
        'diskusi'   => '🎙️ Diskusi',
        'wawancara' => '🎤 Wawancara',
        'kuliah'    => '📚 Kuliah Tamu',
        'kisah'     => '🌟 Kisah Inspiratif',
        'lainnya'   => '📦 Lainnya',
    ];

    public static function paginate(array $filters = [], string $q = '', int $page = 1, int $perPage = 10): array
    {
        $where = []; $params = [];
        if (!empty($filters['category'])) { $where[] = 'category = ?'; $params[] = $filters['category']; }
        if (!empty($filters['status']))   { $where[] = 'status = ?';   $params[] = $filters['status']; }
        if (trim($q) !== '') {
            $like = '%' . trim($q) . '%';
            $where[] = '(title LIKE ? OR guest LIKE ?)';
            $params[] = $like; $params[] = $like;
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $pdo = Database::pdo();
        $c = $pdo->prepare("SELECT COUNT(*) FROM podcasts $whereSql"); $c->execute($params);
        $total = (int) $c->fetchColumn();
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $totalPages));
        $s = $pdo->prepare("SELECT * FROM podcasts $whereSql ORDER BY published_at DESC, id DESC LIMIT $perPage OFFSET " . (($page - 1) * $perPage));
        $s->execute($params);
        return ['items' => $s->fetchAll(), 'total' => $total, 'page' => $page, 'totalPages' => $totalPages];
    }

    public static function published(string $category = ''): array
    {
        $pdo = Database::pdo();
        if ($category !== '') {
            $s = $pdo->prepare("SELECT * FROM podcasts WHERE status='published' AND category = ? ORDER BY published_at DESC, id DESC LIMIT 50");
            $s->execute([$category]);
            return $s->fetchAll();
        }
        return $pdo->query("SELECT * FROM podcasts WHERE status='published' ORDER BY published_at DESC, id DESC LIMIT 50")->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $s = Database::pdo()->prepare('SELECT * FROM podcasts WHERE id = ?'); $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    public static function create(array $d): int
    {
        $pdo = Database::pdo();
        $pdo->prepare(
            'INSERT INTO podcasts (title, episode, description, category, audio_path, cover, duration, guest, status, published_at, created_by)
             VALUES (?,?,?,?,?,?,?,?,?,?,?)'
        )->execute([
            $d['title'], $d['episode'] ?? null, $d['description'] ?? null, $d['category'],
            $d['audio_path'], $d['cover'] ?? null, $d['duration'] ?? null, $d['guest'] ?? null,
            $d['status'],
            $d['status'] === 'published' ? date('Y-m-d H:i:s') : null,
            $d['created_by'] ?? null,
        ]);
        return (int) $pdo->lastInsertId();
    }

    public static function update(int $id, array $d): void
    {
        Database::pdo()->prepare(
            'UPDATE podcasts SET title=?, episode=?, description=?, category=?, audio_path=?, cover=?, duration=?, guest=?, status=?,
             published_at = CASE WHEN ? = \'published\' AND published_at IS NULL THEN NOW() ELSE published_at END
             WHERE id=?'
        )->execute([
            $d['title'], $d['episode'] ?? null, $d['description'] ?? null, $d['category'],
            $d['audio_path'], $d['cover'] ?? null, $d['duration'] ?? null, $d['guest'] ?? null,
            $d['status'], $d['status'], $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $p = self::find($id);
        if ($p) {
            foreach (['audio_path', 'cover'] as $f) {
                $path = $p[$f] ?? '';
                if ($path && !str_starts_with($path, 'http')) {
                    $file = BASE_PATH . '/public/' . ltrim($path, '/');
                    if (is_file($file)) @unlink($file);
                }
            }
        }
        Database::pdo()->prepare('DELETE FROM podcasts WHERE id = ?')->execute([$id]);
    }

    public static function toggleStatus(int $id): void
    {
        Database::pdo()->prepare("UPDATE podcasts SET status = IF(status='published','draft','published'), published_at = IF(status='draft', NOW(), published_at) WHERE id=?")->execute([$id]);
    }

    public static function incrPlays(int $id): void
    {
        Database::pdo()->prepare('UPDATE podcasts SET plays = plays + 1 WHERE id = ?')->execute([$id]);
    }

    public static function stats(): array
    {
        $pdo = Database::pdo();
        return [
            'total'     => (int) $pdo->query('SELECT COUNT(*) FROM podcasts')->fetchColumn(),
            'published' => (int) $pdo->query("SELECT COUNT(*) FROM podcasts WHERE status='published'")->fetchColumn(),
            'plays'     => (int) $pdo->query('SELECT COALESCE(SUM(plays),0) FROM podcasts')->fetchColumn(),
        ];
    }

    /** URL audio (dukung upload lokal ATAU URL eksternal https://) */
    public static function audioUrl(array $p): string
    {
        $path = (string) ($p['audio_path'] ?? '');
        return str_starts_with($path, 'http') ? $path : upload_url($path);
    }

    public static function coverUrl(array $p): string
    {
        $path = (string) ($p['cover'] ?? '');
        return $path !== '' ? (str_starts_with($path, 'http') ? $path : upload_url($path)) : '';
    }
}