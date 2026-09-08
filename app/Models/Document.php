<?php

declare(strict_types=1);

class Document
{
    public const CATEGORIES = [
        'template',
        'pedoman',
        'sop',
        'formulir',
        'surat',
        'aik',
        'lainnya',
    ];

    public const CATEGORY_LABELS = [
        'template' => 'Template Dokumen',
        'pedoman' => 'Pedoman',
        'sop' => 'SOP',
        'formulir' => 'Formulir',
        'surat' => 'Contoh Surat',
        'aik' => 'Dokumen AIK',
        'lainnya' => 'Lainnya',
    ];

    public static function paginate(array $filters = [], int $page = 1, int $perPage = 10): array
    {
        $where = [];
        $params = [];

        if (!empty($filters['status'])) {
            $where[] = 'status = ?';
            $params[] = $filters['status'];
        }

        if (!empty($filters['category'])) {
            $where[] = 'category = ?';
            $params[] = $filters['category'];
        }

        if (!empty($filters['q'])) {
            $where[] = '(title LIKE ? OR description LIKE ?)';
            $like = '%' . $filters['q'] . '%';
            $params[] = $like;
            $params[] = $like;
        }

        $whereSql = $where !== [] ? 'WHERE ' . implode(' AND ', $where) : '';

        $countStmt = Database::pdo()->prepare("SELECT COUNT(*) FROM documents $whereSql");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $totalPages));
        $offset = ($page - 1) * $perPage;

        $stmt = Database::pdo()->prepare(
            "SELECT * FROM documents $whereSql ORDER BY created_at DESC, id DESC LIMIT $perPage OFFSET $offset"
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
        $stmt = Database::pdo()->prepare('SELECT * FROM documents WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);

        $item = $stmt->fetch();

        return $item !== false ? $item : null;
    }

    public static function create(array $data): int
    {
        $stmt = Database::pdo()->prepare(
            'INSERT INTO documents (title, category, description, file_path, file_type, file_size, status, user_id)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );

        $stmt->execute([
            $data['title'],
            $data['category'],
            $data['description'],
            $data['file_path'],
            $data['file_type'],
            $data['file_size'],
            $data['status'],
            $data['user_id'],
        ]);

        return (int) Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $stmt = Database::pdo()->prepare(
            'UPDATE documents
             SET title = ?, category = ?, description = ?, file_path = ?, file_type = ?, file_size = ?, status = ?
             WHERE id = ?'
        );

        $stmt->execute([
            $data['title'],
            $data['category'],
            $data['description'],
            $data['file_path'],
            $data['file_type'],
            $data['file_size'],
            $data['status'],
            $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $stmt = Database::pdo()->prepare('DELETE FROM documents WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function incrementDownload(int $id): void
    {
        $stmt = Database::pdo()->prepare('UPDATE documents SET download_count = download_count + 1 WHERE id = ?');
        $stmt->execute([$id]);
    }
}