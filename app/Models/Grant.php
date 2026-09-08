<?php
declare(strict_types=1);

class Grant
{
    public const TYPES = [
        'penelitian' => 'Penelitian',
        'pengabdian' => 'Pengabdian',
        'publikasi'  => 'Publikasi',
        'lainnya'    => 'Lainnya',
    ];

    public const STATUSES = [
        'open'         => 'Dibuka',
        'closing_soon' => 'Segera Tutup',
        'closed'       => 'Ditutup',
    ];

    // --- CRUD DASAR ---

    public static function all(): array
    {
        return Database::pdo()->query("SELECT * FROM grants ORDER BY deadline DESC")->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM grants WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): int
    {
        $stmt = Database::pdo()->prepare("
            INSERT INTO grants (title, source, type, deadline, funding_amount, status, description, link_proposal, link_registration)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['title'], $data['source'], $data['type'], $data['deadline'],
            $data['funding_amount'], $data['status'], $data['description'],
            $data['link_proposal'], $data['link_registration']
        ]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $stmt = Database::pdo()->prepare("
            UPDATE grants SET 
                title = ?, source = ?, type = ?, deadline = ?, funding_amount = ?, 
                status = ?, description = ?, link_proposal = ?, link_registration = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $data['title'], $data['source'], $data['type'], $data['deadline'],
            $data['funding_amount'], $data['status'], $data['description'],
            $data['link_proposal'], $data['link_registration'], $id
        ]);
    }

    public static function delete(int $id): void
    {
        $stmt = Database::pdo()->prepare("DELETE FROM grants WHERE id = ?");
        $stmt->execute([$id]);
    }

    // --- PAGINATION (WAJIB UNTUK DASHBOARD & ADMIN LIST) ---
    
    public static function paginate(array $where = [], string $q = '', array $likeCols = [], int $page = 1, int $perPage = 10, string $order = 'deadline ASC'): array
    {
        $conds = [];
        $params = [];

        foreach ($where as $col => $val) {
            if ($val === '' || $val === null) continue;
            $conds[] = "$col = ?";
            $params[] = $val;
        }

        if ($q !== '' && $likeCols !== []) {
            $group = [];
            foreach ($likeCols as $col) {
                $group[] = "$col LIKE ?";
                $params[] = "%$q%";
            }
            $conds[] = '(' . implode(' OR ', $group) . ')';
        }

        $whereSql = $conds ? 'WHERE ' . implode(' AND ', $conds) : '';

        // Hitung Total
        $countStmt = Database::pdo()->prepare("SELECT COUNT(*) FROM grants $whereSql");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $totalPages));
        $offset = ($page - 1) * $perPage;

        // Ambil Data
        $stmt = Database::pdo()->prepare("SELECT * FROM grants $whereSql ORDER BY $order LIMIT $perPage OFFSET $offset");
        $stmt->execute($params);

        return [
            'items' => $stmt->fetchAll(),
            'total' => $total,
            'page' => $page,
            'total_pages' => $totalPages,
            'totalPages' => $totalPages, // Alias untuk kompatibilitas view
        ];
    }

    // --- HELPERS PUBLIK ---

    public static function getActive(): array
    {
        // Ambil yang belum closed, urutkan deadline terdekat
        $stmt = Database::pdo()->query("
            SELECT * FROM grants 
            WHERE status != 'closed' 
            ORDER BY 
                CASE status WHEN 'closing_soon' THEN 0 ELSE 1 END, 
                deadline ASC
        ");
        return $stmt->fetchAll();
    }

    public static function getClosed(): array
    {
        $stmt = Database::pdo()->query("SELECT * FROM grants WHERE status = 'closed' ORDER BY deadline DESC LIMIT 5");
        return $stmt->fetchAll();
    }
}