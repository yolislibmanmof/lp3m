<?php

declare(strict_types=1);

trait Crud
{
    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare('SELECT * FROM ' . static::TABLE . ' WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row !== false ? $row : null;
    }

    public static function delete(int $id): void
    {
        $stmt = Database::pdo()->prepare('DELETE FROM ' . static::TABLE . ' WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function create(array $data): int
    {
        $cols = array_keys($data);
        $placeholders = rtrim(str_repeat('?,', count($cols)), ',');

        $stmt = Database::pdo()->prepare(
            'INSERT INTO ' . static::TABLE . ' (' . implode(', ', $cols) . ') VALUES (' . $placeholders . ')'
        );
        $stmt->execute(array_values($data));

        return (int) Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $sets = implode(', ', array_map(static fn(string $c): string => $c . ' = ?', array_keys($data)));
        $params = array_values($data);
        $params[] = $id;

        $stmt = Database::pdo()->prepare('UPDATE ' . static::TABLE . ' SET ' . $sets . ' WHERE id = ?');
        $stmt->execute($params);
    }

    public static function paginate(
        array $where = [],
        string $q = '',
        array $likeCols = [],
        int $page = 1,
        int $perPage = 10,
        string $order = 'created_at DESC, id DESC'
    ): array {
        $conds = [];
        $params = [];

        foreach ($where as $col => $val) {
            if ($val === '' || $val === null) {
                continue;
            }
            $conds[] = $col . ' = ?';
            $params[] = $val;
        }

        if ($q !== '' && $likeCols !== []) {
            $group = [];
            foreach ($likeCols as $col) {
                $group[] = $col . ' LIKE ?';
                $params[] = '%' . $q . '%';
            }
            $conds[] = '(' . implode(' OR ', $group) . ')';
        }

        $whereSql = $conds !== [] ? 'WHERE ' . implode(' AND ', $conds) : '';

        $count = Database::pdo()->prepare('SELECT COUNT(*) FROM ' . static::TABLE . ' ' . $whereSql);
        $count->execute($params);
        $total = (int) $count->fetchColumn();

        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $totalPages));
        $offset = ($page - 1) * $perPage;

        $stmt = Database::pdo()->prepare(
            'SELECT * FROM ' . static::TABLE . ' ' . $whereSql . ' ORDER BY ' . $order . ' LIMIT ' . $perPage . ' OFFSET ' . $offset
        );
        $stmt->execute($params);

        return [
            'items'       => $stmt->fetchAll(),
            'total'       => $total,
            'page'        => $page,
            'total_pages' => $totalPages,
            'totalPages'  => $totalPages,   // ← alias: kompatibel dgn view lama & baru
        ];
    }
}