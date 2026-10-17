<?php

declare(strict_types=1);

/**
 * Scrape publikasi dari profil publik Google Scholar (tanpa library eksternal).
 */
class IntegrationsScholar
{
    private const UA = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0 Safari/537.36';

    public static function extractUserId(string $url): string
    {
        if (preg_match('/[?&]user=([a-zA-Z0-9_-]+)/', $url, $m)) return $m[1];
        if (preg_match('/^([a-zA-Z0-9_-]{8,})$/', trim($url), $m)) return $m[1];
        return '';
    }

    public static function fetch(string $url, int $maxItems = 20): array
    {
        $uid = self::extractUserId($url);
        if ($uid === '') return ['ok' => false, 'error' => 'URL atau User ID Scholar tidak valid.', 'items' => []];

        $targetUrl = 'https://scholar.google.com/citations?user=' . urlencode($uid) . '&hl=id&cstart=0&pagesize=100';
        $ch = curl_init($targetUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_HTTPHEADER => ['User-Agent: ' . self::UA, 'Accept-Language: id-ID,id;q=0.9,en;q=0.8'],
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $html = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code !== 200 || empty($html)) {
            return ['ok' => false, 'error' => 'Gagal mengambil profil Scholar (HTTP ' . $code . ').', 'items' => []];
        }
        return ['ok' => true, 'error' => null, 'items' => self::parse($html, $maxItems)];
    }

    private static function parse(string $html, int $max): array
    {
        $items = [];
        $name = '';
        if (preg_match('/<div[^>]*id="gsc_prf_in"[^>]*>([^<]+)</i', $html, $m)) {
            $name = trim(strip_tags($m[1]));
        }
        if (!preg_match_all('/<tr class="gsc_a_tr"[^>]*>(.*?)<\/tr>/is', $html, $matches)) return [];

        foreach (array_slice($matches[1], 0, $max) as $block) {
            $title = ''; $authors = ''; $journal = ''; $year = ''; $citations = 0;
            if (preg_match('/<a[^>]*class="gsc_a_at"[^>]*>(.*?)<\/a>/is', $block, $m)) {
                $title = trim(strip_tags($m[1]));
            }
            if ($title === '') continue;

            if (preg_match_all('/<div class="gs_gray">(.*?)<\/div>/is', $block, $gm)) {
                $authors = isset($gm[1][0]) ? trim(strip_tags($gm[1][0])) : '';
                $journalRaw = isset($gm[1][1]) ? trim(strip_tags($gm[1][1])) : '';
                if (preg_match('/^(.+?),?\s+(\d{4})$/i', $journalRaw, $ym)) {
                    $journal = trim($ym[1]); $year = $ym[2];
                } else { $journal = $journalRaw; }
            }
            if (!$year && preg_match('/<span class="gsc_a_y"[^>]*>\s*<span[^>]*>\s*(\d{4})\s*<\/span>/i', $block, $ym)) {
                $year = $ym[1];
            }
            if (preg_match('/<a[^>]*class="gsc_a_ac"[^>]*>\s*(\d+)\s*<\/a>/i', $block, $cm)) {
                $citations = (int) $cm[1];
            }
            $items[] = [
                'title'     => $title,
                'authors'   => $authors ?: $name,
                'journal'   => $journal,
                'year'      => (int) ($year ?: date('Y')),
                'citations' => $citations,
            ];
        }
        return $items;
    }

    public static function importItems(array $items): array
    {
        $pdo = Database::pdo();
        $inserted = 0; $skipped = 0;
        foreach ($items as $it) {
            if (empty($it['title'])) { $skipped++; continue; }
            $s = $pdo->prepare('SELECT id FROM publications WHERE title = ? LIMIT 1');
            $s->execute([$it['title']]);
            if ($s->fetch()) { $skipped++; continue; }
            try {
                $pdo->prepare('INSERT INTO publications (title, authors, journal, year, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())')
                    ->execute([$it['title'], $it['authors'] ?? '', $it['journal'] ?? '', $it['year'] ?? (int) date('Y'), 'published']);
                $inserted++;
            } catch (\Throwable $e) { $skipped++; }
        }
        return ['inserted' => $inserted, 'skipped' => $skipped];
    }
}