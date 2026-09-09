<?php

declare(strict_types=1);

/**
 * Fetch metadata DOI via CrossRef API (gratis, tanpa API key).
 */
class IntegrationsDoi
{
    private const API = 'https://api.crossref.org/works/';
    private const UA = 'LP3M-UNIMOF/1.0 (mailto:lp3m@unimof.ac.id)';

    public static function fetch(string $doi): ?array
    {
        $doi = self::normalize($doi);
        if ($doi === '') return null;

        $ch = curl_init(self::API . urlencode($doi));
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_HTTPHEADER => ['Accept: application/json', 'User-Agent: ' . self::UA],
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code !== 200 || !$resp) return null;
        $data = json_decode($resp, true);
        if (!is_array($data) || ($data['status'] ?? '') !== 'ok') return null;
        return self::extract($data['message'] ?? [], $doi);
    }

    public static function normalize(string $doi): string
    {
        $doi = trim($doi);
        $doi = preg_replace('#^https?://(doi\.org|dx\.doi\.org)/#i', '', $doi);
        return trim((string) $doi);
    }

    private static function formatAuthors(array $msg): string
    {
        $authors = $msg['author'] ?? [];
        $names = [];
        foreach ($authors as $a) {
            $given = trim($a['given'] ?? '');
            $family = trim($a['family'] ?? '');
            if ($family !== '' && $given !== '') $names[] = $family . ', ' . $given;
            elseif ($family !== '') $names[] = $family;
            elseif ($given !== '') $names[] = $given;
        }
        return implode('; ', $names);
    }

    private static function extract(array $msg, string $doi): array
    {
        $title = '';
        if (!empty($msg['title']) && is_array($msg['title'])) $title = (string) $msg['title'][0];

        $year = (int) date('Y');
        foreach (['published-print', 'published-online', 'issued', 'created'] as $k) {
            if (isset($msg[$k]['date-parts'][0][0])) { $year = (int) $msg[$k]['date-parts'][0][0]; break; }
        }

        return [
            'doi'        => $doi,
            'title'      => $title,
            'authors'    => self::formatAuthors($msg),
            'journal'    => $msg['container-title'][0] ?? '',
            'publisher'  => $msg['publisher'] ?? '',
            'year'       => $year,
            'volume'     => $msg['volume'] ?? '',
            'issue'      => $msg['issue'] ?? '',
            'page'       => $msg['page'] ?? '',
            'url'        => $msg['URL'] ?? ('https://doi.org/' . $doi),
            'type'       => $msg['type'] ?? 'journal-article',
            'issn'       => $msg['ISSN'][0] ?? '',
            'subject'    => implode(', ', $msg['subject'] ?? []),
            'references' => (int) ($msg['reference-count'] ?? 0),
            'citations'  => (int) ($msg['is-referenced-by-count'] ?? 0),
        ];
    }
}