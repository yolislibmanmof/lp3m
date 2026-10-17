<?php

declare(strict_types=1);

class Certificate
{
    public const TYPES = [
        'pelatihan' => 'Pelatihan',
        'workshop' => 'Workshop',
        'seminar' => 'Seminar',
        'kkn' => 'KKN',
        'pengabdian' => 'Pengabdian',
        'penelitian' => 'Penelitian',
        'lainnya' => 'Lainnya',
    ];

    /** 10 template premium sertifikat */
    public const TEMPLATES = [
        'classic'    => 'Classic Gold Ivory',
        'emerald'    => 'Emerald Royal (Dark)',
        'navy'       => 'Navy Regal (Dark)',
        'maroon'     => 'Maroon Academic',
        'minimal'    => 'Minimal Swiss',
        'islamic'    => 'Islamic Green',
        'modern'     => 'Modern Teal',
        'vintage'    => 'Vintage Sepia',
        'executive'  => 'Executive Charcoal',
        'aurora'     => 'Aurora Violet',
    ];

    public static function paginate(array $filters = [], int $page = 1, int $perPage = 10): array
    {
        $where = [];
        $params = [];

        if (!empty($filters['status'])) {
            $where[] = 'status = ?';
            $params[] = $filters['status'];
        }

        if (!empty($filters['q'])) {
            $where[] = '(code LIKE ? OR holder_name LIKE ? OR activity_title LIKE ?)';
            $like = '%' . $filters['q'] . '%';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        $whereSql = $where !== [] ? 'WHERE ' . implode(' AND ', $where) : '';

        $countStmt = Database::pdo()->prepare("SELECT COUNT(*) FROM certificates $whereSql");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $totalPages));
        $offset = ($page - 1) * $perPage;

        $stmt = Database::pdo()->prepare(
            "SELECT * FROM certificates $whereSql ORDER BY created_at DESC, id DESC LIMIT $perPage OFFSET $offset"
        );
        $stmt->execute($params);

        return [
            'items' => $stmt->fetchAll(),
            'total' => $total,
            'page' => $page,
            'total_pages' => $totalPages,
        ];
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare('SELECT * FROM certificates WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row !== false ? $row : null;
    }

    public static function findByCode(string $code): ?array
    {
        $stmt = Database::pdo()->prepare('SELECT * FROM certificates WHERE code = ? LIMIT 1');
        $stmt->execute([$code]);
        $row = $stmt->fetch();
        return $row !== false ? $row : null;
    }

    public static function create(array $d): int
    {
        $stmt = Database::pdo()->prepare(
            'INSERT INTO certificates (code, holder_name, holder_identity, activity_title, activity_type, issue_date, signer_name, signer_title, signer_signature, template, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $d['code'],
            $d['holder_name'],
            $d['holder_identity'],
            $d['activity_title'],
            $d['activity_type'],
            $d['issue_date'],
            $d['signer_name'],
            $d['signer_title'],
            $d['signer_signature'] ?? null,
            $d['template'] ?? 'classic',
            $d['status'],
        ]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $d): void
    {
        $stmt = Database::pdo()->prepare(
            'UPDATE certificates
             SET holder_name = ?, holder_identity = ?, activity_title = ?, activity_type = ?, issue_date = ?, signer_name = ?, signer_title = ?, signer_signature = ?, template = ?
             WHERE id = ?'
        );
        $stmt->execute([
            $d['holder_name'],
            $d['holder_identity'],
            $d['activity_title'],
            $d['activity_type'],
            $d['issue_date'],
            $d['signer_name'],
            $d['signer_title'],
            $d['signer_signature'] ?? null,
            $d['template'] ?? 'classic',
            $id,
        ]);
    }

    public static function setStatus(int $id, string $status, ?string $reason = null): void
    {
        $stmt = Database::pdo()->prepare('UPDATE certificates SET status = ?, revoke_reason = ? WHERE id = ?');
        $stmt->execute([$status, $reason, $id]);
    }

    public static function delete(int $id): void
    {
        Database::pdo()->prepare('DELETE FROM certificates WHERE id = ?')->execute([$id]);
    }

    /** Generate kode unik: LP3M-2026-A1B2C3 */
    public static function nextCode(): string
    {
        do {
            $code = 'LP3M-' . date('Y') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
            $stmt = Database::pdo()->prepare('SELECT id FROM certificates WHERE code = ? LIMIT 1');
            $stmt->execute([$code]);
        } while ($stmt->fetch() !== false);

        return $code;
    }

    /** Helper: label template */
    public static function templateLabel(string $key): string
    {
        return self::TEMPLATES[$key] ?? self::TEMPLATES['classic'];
    }

    /** Helper: label jenis */
    public static function typeLabel(string $key): string
    {
        return self::TYPES[$key] ?? ucfirst($key);
    }
}