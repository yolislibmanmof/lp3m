<?php
class Research
{
    public const SCHEMES = [
        'internal'      => 'Penelitian Internal',
        'nasional'      => 'Penelitian Nasional',
        'kompetitif'    => 'Kompetitif Nasional',
        'internasional' => 'Penelitian Internasional',
        'kerjasama'     => 'Kerjasama / Kolaborasi',
    ];

    public const STATUSES = [
        'draft'       => 'Draft',
        'diajukan'    => 'Diajukan',
        'review'      => 'Review',
        'didanai'     => 'Didanai',
        'berlangsung' => 'Berlangsung',
        'selesai'     => 'Selesai',
        'ditolak'     => 'Ditolak',
    ];

    public const FIELDS = [
        'pendidikan' => 'Pendidikan',
        'kesehatan'  => 'Kesehatan',
        'teknologi'  => 'Teknologi & AI',
        'lingkungan' => 'Lingkungan',
        'ekonomi'    => 'Ekonomi & UMKM',
        'sosial'     => 'Sosial & Budaya',
        'pertanian'  => 'Pertanian',
        'hukum'      => 'Hukum',
    ];

    public static function paginate(array $filters = [], $search = '', array $searchCols = [], int $page = 1, int $perPage = 10, string $orderBy = 'created_at DESC')
    {
        $where = []; $params = [];

        if (!empty($filters['status'])) { $where[] = 'status = ?'; $params[] = $filters['status']; }
        if (!empty($filters['year']))   { $where[] = 'year = ?';   $params[] = $filters['year']; }
        if (!empty($filters['scheme'])) { $where[] = 'scheme = ?'; $params[] = $filters['scheme']; }

        if (is_string($search) && trim($search) !== '') {
            $cols = $searchCols ?: ['title', 'leader'];
            $like = [];
            foreach ($cols as $c) { $like[] = "$c LIKE ?"; $params[] = '%' . trim($search) . '%'; }
            $where[] = '(' . implode(' OR ', $like) . ')';
        }

        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $allowed = ['created_at DESC','created_at ASC','year DESC','title ASC','funding DESC'];
        if (!in_array($orderBy, $allowed, true)) $orderBy = 'created_at DESC';

        $cstmt = Database::pdo()->prepare("SELECT COUNT(*) FROM researches $whereSql");
        $cstmt->execute($params);
        $total = (int) $cstmt->fetchColumn();

        $totalPages = max(1, (int) ceil($total / $perPage));
        $offset = max(0, ($page - 1) * $perPage);

        $stmt = Database::pdo()->prepare("SELECT * FROM researches $whereSql ORDER BY $orderBy LIMIT " . (int)$perPage . " OFFSET " . $offset);
        $stmt->execute($params);

        return ['items' => $stmt->fetchAll(), 'total' => $total, 'totalPages' => $totalPages, 'page' => $page];
    }

    public static function find($id)
    {
        $stmt = Database::pdo()->prepare('SELECT * FROM researches WHERE id = ?');
        $stmt->execute([(int)$id]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $d): int
    {
        $stmt = Database::pdo()->prepare(
            'INSERT INTO researches (title, year, scheme, field, leader, members, funding, status, output_target, description)
             VALUES (?,?,?,?,?,?,?,?,?,?)'
        );
        $stmt->execute([
            $d['title'], (int)$d['year'], $d['scheme'], $d['field'] ?? null,
            $d['leader'], $d['members'] ?? null, (int)($d['funding'] ?? 0),
            $d['status'] ?? 'draft', $d['output_target'] ?? null, $d['description'] ?? null,
        ]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function update($id, array $d): void
    {
        $stmt = Database::pdo()->prepare(
            'UPDATE researches SET title=?, year=?, scheme=?, field=?, leader=?, members=?, funding=?, status=?, output_target=?, description=? WHERE id=?'
        );
        $stmt->execute([
            $d['title'], (int)$d['year'], $d['scheme'], $d['field'] ?? null,
            $d['leader'], $d['members'] ?? null, (int)($d['funding'] ?? 0),
            $d['status'] ?? 'draft', $d['output_target'] ?? null, $d['description'] ?? null,
            (int)$id,
        ]);
    }

    public static function delete($id): void
    {
        $stmt = Database::pdo()->prepare('DELETE FROM researches WHERE id = ?');
        $stmt->execute([(int)$id]);
    }

    public const PUBLIC_STATUSES = ['didanai', 'berlangsung', 'selesai'];

    public static function publicList(array $filters = [], string $search = '', int $page = 1, int $perPage = 9)
    {
        $in = implode(',', array_fill(0, count(self::PUBLIC_STATUSES), '?'));
        $where = ["status IN ($in)"];
        $params = self::PUBLIC_STATUSES;
        if (!empty($filters['scheme'])) { $where[] = 'scheme = ?'; $params[] = $filters['scheme']; }
        if (!empty($filters['year']))   { $where[] = 'year = ?';   $params[] = $filters['year']; }
        if (trim($search) !== '') {
            $where[] = '(title LIKE ? OR leader LIKE ?)';
            $params[] = '%' . trim($search) . '%';
            $params[] = '%' . trim($search) . '%';
        }
        $whereSql = 'WHERE ' . implode(' AND ', $where);
        $c = Database::pdo()->prepare("SELECT COUNT(*) FROM researches $whereSql");
        $c->execute($params);
        $total = (int) $c->fetchColumn();
        $totalPages = max(1, (int) ceil($total / $perPage));
        $offset = max(0, ($page - 1) * $perPage);
        $stmt = Database::pdo()->prepare("SELECT * FROM researches $whereSql ORDER BY year DESC, created_at DESC LIMIT " . (int)$perPage . " OFFSET " . $offset);
        $stmt->execute($params);
        return ['items' => $stmt->fetchAll(), 'total' => $total, 'totalPages' => $totalPages, 'page' => $page];
    }

    public static function publicStats()
    {
        $in = implode(',', array_fill(0, count(self::PUBLIC_STATUSES), '?'));
        $pdo = Database::pdo();
        $s = $pdo->prepare("SELECT COUNT(*) FROM researches WHERE status IN ($in)");
        $s->execute(self::PUBLIC_STATUSES);
        $total = (int) $s->fetchColumn();
        $f = $pdo->prepare("SELECT COALESCE(SUM(funding),0) FROM researches WHERE status IN ($in)");
        $f->execute(self::PUBLIC_STATUSES);
        $funding = (int) $f->fetchColumn();
        $y = $pdo->prepare("SELECT COUNT(DISTINCT year) FROM researches WHERE status IN ($in)");
        $y->execute(self::PUBLIC_STATUSES);
        $years = (int) $y->fetchColumn();
        return ['total' => $total, 'funding' => $funding, 'years' => $years];
    }
}