<?php

declare(strict_types=1);

/**
 * Helper pencatatan aktivitas integrasi eksternal (SINTA, CrossRef, Scholar, ORCID).
 */
class IntegrationsLog
{
    public const PROVIDERS = [
        'sinta_csv'    => '📊 SINTA CSV',
        'crossref_doi' => '🔗 CrossRef DOI',
        'scholar'      => '🎓 Google Scholar',
        'orcid'        => '🆔 ORCID',
    ];

    public static function record(array $d): int
    {
        $pdo = Database::pdo();
        $pdo->prepare(
            'INSERT INTO integrations_log
             (provider, action, entity_type, entity_id, input_query, items_count, status, message, payload_json, user_id)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        )->execute([
            $d['provider'],
            $d['action'],
            $d['entity_type'] ?? null,
            $d['entity_id'] ?? null,
            isset($d['input_query']) ? mb_substr((string) $d['input_query'], 0, 250) : null,
            (int) ($d['items_count'] ?? 0),
            $d['status'] ?? 'success',
            isset($d['message']) ? mb_substr((string) $d['message'], 0, 1000) : null,
            isset($d['payload']) ? json_encode($d['payload'], JSON_UNESCAPED_UNICODE) : null,
            $d['user_id'] ?? (Auth::user()['id'] ?? null),
        ]);
        return (int) $pdo->lastInsertId();
    }

    public static function recent(int $limit = 50): array
    {
        $s = Database::pdo()->prepare('SELECT * FROM integrations_log ORDER BY id DESC LIMIT ?');
        $s->execute([$limit]);
        return $s->fetchAll();
    }

    public static function stats(): array
    {
        $pdo = Database::pdo();
        $stats = ['total' => 0, 'success' => 0, 'failed' => 0, 'by_provider' => []];
        try {
            $stats['total'] = (int) $pdo->query('SELECT COUNT(*) FROM integrations_log')->fetchColumn();
            $stats['success'] = (int) $pdo->query("SELECT COUNT(*) FROM integrations_log WHERE status='success'")->fetchColumn();
            $stats['failed'] = (int) $pdo->query("SELECT COUNT(*) FROM integrations_log WHERE status='failed'")->fetchColumn();
            $rows = $pdo->query(
                'SELECT provider, COUNT(*) as cnt, SUM(items_count) as items
                 FROM integrations_log GROUP BY provider'
            )->fetchAll();
            foreach ($rows as $r) {
                $stats['by_provider'][$r['provider']] = [
                    'count' => (int) $r['cnt'],
                    'items' => (int) $r['items'],
                    'label' => self::PROVIDERS[$r['provider']] ?? $r['provider'],
                ];
            }
        } catch (\Throwable $e) {}
        return $stats;
    }

    public static function exportAll(): array
    {
        return Database::pdo()->query('SELECT * FROM integrations_log ORDER BY id DESC')->fetchAll();
    }
}