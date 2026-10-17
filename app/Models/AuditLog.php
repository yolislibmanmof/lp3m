<?php

declare(strict_types=1);

class AuditLog
{
    public const ACTIONS = [
        'login'     => ['label' => 'Login',              'rgb' => '124,58,237', 'hex' => '#c4b5fd', 'ico' => '🔐'],
        'logout'    => ['label' => 'Logout',             'rgb' => '100,116,139', 'hex' => '#cbd5e1', 'ico' => '🚪'],
        'create'    => ['label' => 'Membuat',            'rgb' => '16,185,129',  'hex' => '#6ee7b7', 'ico' => '➕'],
        'update'    => ['label' => 'Memperbarui',        'rgb' => '59,130,246',  'hex' => '#93c5fd', 'ico' => '✏️'],
        'delete'    => ['label' => 'Menghapus',          'rgb' => '220,38,38',   'hex' => '#fca5a5', 'ico' => '🗑️'],
        'toggle'    => ['label' => 'Mengubah Status',    'rgb' => '245,158,11',  'hex' => '#fcd34d', 'ico' => '🔄'],
        'reset'     => ['label' => 'Reset Password',     'rgb' => '245,158,11',  'hex' => '#fcd34d', 'ico' => '🔑'],
        'upload'    => ['label' => 'Mengunggah File',    'rgb' => '6,182,212',   'hex' => '#67e8f9', 'ico' => '📤'],
        'revoke'    => ['label' => 'Mencabut',           'rgb' => '220,38,38',   'hex' => '#fca5a5', 'ico' => '🚫'],
        'restore'   => ['label' => 'Memulihkan',         'rgb' => '16,185,129',  'hex' => '#6ee7b7', 'ico' => '♻️'],
        'login_fail'=> ['label' => 'Login Gagal',        'rgb' => '220,38,38',   'hex' => '#fca5a5', 'ico' => '⚠️'],
    ];

    public static function actionInfo(string $action): array
    {
        return self::ACTIONS[$action] ?? ['label' => ucfirst($action), 'rgb' => '148,163,184', 'hex' => '#cbd5e1', 'ico' => '📝'];
    }

    /** Catat aksi ke log. Panggil dari controller setelah aksi berhasil. */
    public static function log(string $action, array $payload = []): void
    {
        try {
            $user = Auth::check() ? Auth::user() : null;
            $pdo = Database::pdo();
            $s = $pdo->prepare(
                'INSERT INTO audit_logs (user_id,user_name,user_role,action,entity_type,entity_id,entity_label,old_value,new_value,ip_address,user_agent,url,created_at)
                 VALUES (?,?,?,?,?,?,?,?,?,?,?,?,NOW())'
            );
            $s->execute([
                $user['id'] ?? null,
                $user['name'] ?? ($payload['user_name'] ?? 'Sistem'),
                $user['role'] ?? ($payload['user_role'] ?? 'system'),
                $action,
                $payload['entity_type'] ?? null,
                $payload['entity_id'] ?? null,
                $payload['entity_label'] ?? null,
                isset($payload['old_value']) ? self::jsonSafe($payload['old_value']) : null,
                isset($payload['new_value']) ? self::jsonSafe($payload['new_value']) : null,
                self::clientIp(),
                substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 250),
                substr($_SERVER['REQUEST_URI'] ?? '', 0, 500),
            ]);
        } catch (\Throwable $e) {
            // Jangan gagalkan aksi utama jika log gagal
            error_log('AuditLog::log failed: ' . $e->getMessage());
        }
    }

    private static function jsonSafe($v): string
    {
        if (is_string($v)) return $v;
        $j = json_encode($v, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return $j === false ? '' : $j;
    }

    private static function clientIp(): string
    {
        foreach (['HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'] as $k) {
            if (!empty($_SERVER[$k])) {
                $ip = explode(',', (string) $_SERVER[$k])[0];
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP)) return $ip;
            }
        }
        return '127.0.0.1';
    }

    public static function paginate(array $filters = [], string $q = '', int $page = 1, int $perPage = 20): array
    {
        $where = []; $params = [];
        if (!empty($filters['action'])) { $where[] = 'action = ?'; $params[] = $filters['action']; }
        if (!empty($filters['user_id'])) { $where[] = 'user_id = ?'; $params[] = (int) $filters['user_id']; }
        if (!empty($filters['entity'])) { $where[] = 'entity_type = ?'; $params[] = $filters['entity']; }
        if (($filters['period'] ?? '') !== '') {
            switch ($filters['period']) {
                case 'today': $where[] = 'DATE(created_at) = CURDATE()'; break;
                case 'week':  $where[] = 'created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)'; break;
                case 'month': $where[] = 'created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)'; break;
            }
        }
        if (trim($q) !== '') {
            $like = '%' . trim($q) . '%';
            $where[] = '(user_name LIKE ? OR entity_label LIKE ? OR entity_type LIKE ? OR url LIKE ? OR ip_address LIKE ?)';
            $params = array_merge($params, [$like, $like, $like, $like, $like]);
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $pdo = Database::pdo();
        $c = $pdo->prepare("SELECT COUNT(*) FROM audit_logs $whereSql"); $c->execute($params);
        $total = (int) $c->fetchColumn();
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $totalPages));
        $s = $pdo->prepare("SELECT * FROM audit_logs $whereSql ORDER BY id DESC LIMIT $perPage OFFSET " . (($page - 1) * $perPage));
        $s->execute($params);
        return ['items' => $s->fetchAll(), 'total' => $total, 'page' => $page, 'totalPages' => $totalPages];
    }

    public static function find(int $id): ?array
    {
        $s = Database::pdo()->prepare('SELECT * FROM audit_logs WHERE id = ?'); $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    public static function stats(): array
    {
        $pdo = Database::pdo();
        return [
            'total'      => (int) $pdo->query('SELECT COUNT(*) FROM audit_logs')->fetchColumn(),
            'today'      => (int) $pdo->query('SELECT COUNT(*) FROM audit_logs WHERE DATE(created_at) = CURDATE()')->fetchColumn(),
            'week'       => (int) $pdo->query('SELECT COUNT(*) FROM audit_logs WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)')->fetchColumn(),
            'unique'     => (int) $pdo->query('SELECT COUNT(DISTINCT user_id) FROM audit_logs WHERE user_id IS NOT NULL')->fetchColumn(),
            'login_fail' => (int) $pdo->query("SELECT COUNT(*) FROM audit_logs WHERE action='login_fail' AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn(),
        ];
    }

    public static function entityTypes(): array
    {
        $s = Database::pdo()->query("SELECT DISTINCT entity_type FROM audit_logs WHERE entity_type IS NOT NULL ORDER BY entity_type");
        return $s->fetchAll(\PDO::FETCH_COLUMN);
    }

    public static function recent(int $limit = 10): array
    {
        $s = Database::pdo()->prepare('SELECT * FROM audit_logs ORDER BY id DESC LIMIT ?');
        $s->execute([$limit]);
        return $s->fetchAll();
    }

    public static function delete(int $id): void
    {
        Database::pdo()->prepare('DELETE FROM audit_logs WHERE id = ?')->execute([$id]);
    }

    public static function purge(int $days = 90): int
    {
        $s = Database::pdo()->prepare('DELETE FROM audit_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)');
        $s->execute([$days]);
        return (int) $s->rowCount();
    }
}