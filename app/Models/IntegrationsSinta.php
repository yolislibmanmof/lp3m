<?php

declare(strict_types=1);

/**
 * Import data dari CSV export SINTA (Kemdikbud).
 * Auto-map header (title/judul, authors/penulis, dll).
 */
class IntegrationsSinta
{
    public const HEADER_MAPS = [
        'title'   => ['title', 'judul', 'article title', 'publication title'],
        'authors' => ['authors', 'author', 'penulis', 'nama'],
        'journal' => ['journal', 'jurnal', 'source title', 'publication'],
        'year'    => ['year', 'tahun', 'publication year'],
        'volume'  => ['volume', 'vol'],
        'issue'   => ['issue', 'no', 'number'],
        'page'    => ['page', 'pages', 'halaman'],
        'doi'     => ['doi', 'digital object identifier'],
        'sinta_id'=> ['sinta id', 'sinta_id', 'id sinta'],
    ];

    public static function parseCsv(string $path): array
    {
        if (!is_file($path)) return ['rows' => [], 'errors' => ['File tidak ditemukan.']];
        $h = fopen($path, 'rb');
        if ($h === false) return ['rows' => [], 'errors' => ['Gagal baca file.']];

        $bom = fread($h, 3);
        if ($bom !== "\xEF\xBB\xBF") rewind($h);

        $rows = [];
        $errors = [];
        $lineNo = 0;
        $headers = null;

        while (($data = fgetcsv($h, 0, ',', '"', '\\')) !== false) {
            $lineNo++;
            if ($lineNo === 1) {
                $headers = self::mapHeaders($data);
                if (empty($headers['title'])) {
                    $errors[] = "Baris 1: tidak ditemukan kolom judul.";
                    break;
                }
                continue;
            }
            if (empty(array_filter($data, fn($v) => trim((string) $v) !== ''))) continue;

            $row = [];
            foreach ($headers as $key => $idx) {
                if ($idx === null) continue;
                $row[$key] = isset($data[$idx]) ? trim((string) $data[$idx]) : '';
            }
            if (empty($row['title'])) { $errors[] = "Baris $lineNo: judul kosong."; continue; }
            $row['year'] = (int) preg_replace('/[^0-9]/', '', $row['year'] ?? '');
            $rows[] = $row;
        }
        fclose($h);
        return ['rows' => $rows, 'errors' => $errors];
    }

    private static function mapHeaders(array $csvHeaders): array
    {
        $mapped = [];
        $lower = array_map(fn($h) => strtolower(trim((string) $h)), $csvHeaders);
        foreach (self::HEADER_MAPS as $field => $candidates) {
            $mapped[$field] = null;
            foreach ($candidates as $c) {
                $idx = array_search(strtolower($c), $lower, true);
                if ($idx !== false) { $mapped[$field] = $idx; break; }
            }
        }
        return $mapped;
    }

    public static function importPublications(array $rows, ?int $userId = null): array
    {
        $pdo = Database::pdo();
        $inserted = 0;
        $skipped = 0;

        foreach ($rows as $r) {
            $doi = !empty($r['doi']) ? IntegrationsDoi::normalize($r['doi']) : '';
            if ($doi !== '') {
                $s = $pdo->prepare('SELECT id FROM publications WHERE doi = ? LIMIT 1');
                $s->execute([$doi]);
                if ($s->fetch()) { $skipped++; continue; }
            } else {
                $s = $pdo->prepare('SELECT id FROM publications WHERE title = ? LIMIT 1');
                $s->execute([$r['title']]);
                if ($s->fetch()) { $skipped++; continue; }
            }
            try {
                $pdo->prepare(
                    'INSERT INTO publications (title, authors, journal, year, volume, issue, page, doi, doi_verified, sinta_id, status, created_at)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())'
                )->execute([
                    $r['title'], $r['authors'] ?? '', $r['journal'] ?? '',
                    $r['year'] ?: (int) date('Y'),
                    $r['volume'] ?? null, $r['issue'] ?? null, $r['page'] ?? null,
                    $doi ?: null, $doi !== '' ? 1 : 0, $r['sinta_id'] ?? null, 'published',
                ]);
                $inserted++;
            } catch (\Throwable $e) { $skipped++; }
        }
        return ['inserted' => $inserted, 'skipped' => $skipped];
    }
}