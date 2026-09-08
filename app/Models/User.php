<?php

declare(strict_types=1);

class User
{
    public const ROLES = [
        'super_admin' => ['label' => 'Super Admin', 'rgb' => '217,164,65', 'hex' => '#f2c063', 'desc' => 'Akses penuh seluruh modul termasuk manajemen pengguna.'],
        'admin_lp3m'  => ['label' => 'Admin LP3M',  'rgb' => '16,185,129', 'hex' => '#6ee7b7', 'desc' => 'Kelola konten, layanan, dan dokumen lembaga.'],
        'dosen'       => ['label' => 'Dosen',       'rgb' => '59,130,246', 'hex' => '#93c5fd', 'desc' => 'Kelola penelitian & pengabdian milik sendiri.'],
        'reviewer'    => ['label' => 'Reviewer',    'rgb' => '124,58,237', 'hex' => '#c4b5fd', 'desc' => 'Menilai proposal & dokumen penugasan.'],
        'pimpinan'    => ['label' => 'Pimpinan',    'rgb' => '245,158,11', 'hex' => '#fcd34d', 'desc' => 'Dashboard & laporan eksekutif (read-only).'],
        'mahasiswa'   => ['label' => 'Mahasiswa',   'rgb' => '20,184,166', 'hex' => '#5eead4', 'desc' => 'Akses layanan publik terbatas.'],
    ];

    public static function roleInfo(string $role): array
    {
        return self::ROLES[$role] ?? ['label' => ucfirst($role), 'rgb' => '148,163,184', 'hex' => '#cbd5e1', 'desc' => ''];
    }

    public static function paginate(array $filters = [], string $q = '', int $page = 1, int $perPage = 10): array
    {
        $where = []; $params = [];
        if (!empty($filters['role'])) { $where[] = 'role = ?'; $params[] = $filters['role']; }
        if (($filters['status'] ?? '') !== '') { $where[] = 'is_active = ?'; $params[] = (int) $filters['status']; }
        if (trim($q) !== '') {
            $like = '%' . trim($q) . '%';
            $where[] = '(name LIKE ? OR email LIKE ?)';
            $params = array_merge($params, [$like, $like]);
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $pdo = Database::pdo();
        $c = $pdo->prepare("SELECT COUNT(*) FROM users $whereSql"); $c->execute($params);
        $total = (int) $c->fetchColumn();
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $totalPages));
        $s = $pdo->prepare("SELECT id,name,email,phone,role,is_active,last_login_at,created_at FROM users $whereSql ORDER BY FIELD(role,'super_admin','admin_lp3m','dosen','reviewer','pimpinan','mahasiswa'), name ASC LIMIT $perPage OFFSET " . (($page - 1) * $perPage));
        $s->execute($params);
        return ['items' => $s->fetchAll(), 'total' => $total, 'page' => $page, 'totalPages' => $totalPages];
    }

    public static function find(int $id): ?array
    {
        $s = Database::pdo()->prepare('SELECT * FROM users WHERE id = ?'); $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    public static function findByEmail(string $email): ?array
    {
        $s = Database::pdo()->prepare('SELECT * FROM users WHERE email = ?'); $s->execute([strtolower($email)]);
        return $s->fetch() ?: null;
    }

    public static function create(array $d): int
    {
        $s = Database::pdo()->prepare('INSERT INTO users (name,email,phone,password,role,is_active) VALUES (?,?,?,?,?,?)');
        $s->execute([
            $d['name'], strtolower($d['email']), $d['phone'] ?? null,
            password_hash($d['password'], PASSWORD_DEFAULT),
            $d['role'], (int) ($d['is_active'] ?? 1),
        ]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $d, ?string $newPassword = null): void
    {
        if ($newPassword !== null) {
            $s = Database::pdo()->prepare('UPDATE users SET name=?,email=?,phone=?,role=?,is_active=?,password=? WHERE id=?');
            $s->execute([$d['name'], strtolower($d['email']), $d['phone'] ?? null, $d['role'], (int) ($d['is_active'] ?? 1), password_hash($newPassword, PASSWORD_DEFAULT), $id]);
        } else {
            $s = Database::pdo()->prepare('UPDATE users SET name=?,email=?,phone=?,role=?,is_active=? WHERE id=?');
            $s->execute([$d['name'], strtolower($d['email']), $d['phone'] ?? null, $d['role'], (int) ($d['is_active'] ?? 1), $id]);
        }
    }

    public static function setPassword(int $id, string $plain): void
    {
        Database::pdo()->prepare('UPDATE users SET password=? WHERE id=?')->execute([password_hash($plain, PASSWORD_DEFAULT), $id]);
    }

    public static function toggleActive(int $id): int
    {
        $pdo = Database::pdo();
        $u = self::find($id);
        $new = $u && (int) $u['is_active'] === 1 ? 0 : 1;
        $pdo->prepare('UPDATE users SET is_active=? WHERE id=?')->execute([$new, $id]);
        return $new;
    }

    public static function delete(int $id): void
    {
        Database::pdo()->prepare('DELETE FROM users WHERE id = ?')->execute([$id]);
    }

    public static function touchLogin(int $id): void
    {
        Database::pdo()->prepare('UPDATE users SET last_login_at=NOW() WHERE id=?')->execute([$id]);
    }

    public static function countRole(string $role, bool $activeOnly = false): int
    {
        $sql = 'SELECT COUNT(*) FROM users WHERE role = ?' . ($activeOnly ? ' AND is_active = 1' : '');
        $s = Database::pdo()->prepare($sql); $s->execute([$role]);
        return (int) $s->fetchColumn();
    }

    public static function stats(): array
    {
        $pdo = Database::pdo();
        return [
            'total' => (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn(),
            'active' => (int) $pdo->query('SELECT COUNT(*) FROM users WHERE is_active = 1')->fetchColumn(),
            'inactive' => (int) $pdo->query('SELECT COUNT(*) FROM users WHERE is_active = 0')->fetchColumn(),
            'new_month' => (int) $pdo->query("SELECT COUNT(*) FROM users WHERE YEAR(created_at)=YEAR(CURDATE()) AND MONTH(created_at)=MONTH(CURDATE())")->fetchColumn(),
        ];
    }

    public static function generatePassword(int $len = 10): string
    {
        return substr(str_replace(['/', '+', '='], '', base64_encode(random_bytes(18))), 0, $len);
    }
}