<?php

declare(strict_types=1);

class News
{
    public const CATEGORIES = [
        'umum',
        'penelitian',
        'pengabdian',
        'publikasi',
        'haki',
        'aik',
        'pengumuman',
        'agenda',
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

        if (isset($filters['featured']) && $filters['featured'] !== '') {
            $where[] = 'is_featured = ?';
            $params[] = (int) $filters['featured'];
        }

        // Filter berdasarkan tag (slug) — BARU
        if (!empty($filters['tag'])) {
            $where[] = 'id IN (SELECT nt.news_id FROM news_tags nt JOIN tags t ON t.id = nt.tag_id WHERE t.slug = ?)';
            $params[] = $filters['tag'];
        }

        if (!empty($filters['q'])) {
            $where[] = '(title LIKE ? OR content LIKE ?)';
            $like = '%' . $filters['q'] . '%';
            $params[] = $like;
            $params[] = $like;
        }

        $whereSql = $where !== [] ? 'WHERE ' . implode(' AND ', $where) : '';

        $countStmt = Database::pdo()->prepare("SELECT COUNT(*) FROM news $whereSql");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $totalPages));
        $offset = ($page - 1) * $perPage;

        $stmt = Database::pdo()->prepare(
            "SELECT * FROM news $whereSql ORDER BY created_at DESC, id DESC LIMIT $perPage OFFSET $offset"
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
        $stmt = Database::pdo()->prepare('SELECT * FROM news WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);

        $item = $stmt->fetch();

        return $item !== false ? $item : null;
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = Database::pdo()->prepare(
            'SELECT * FROM news WHERE slug = ? AND status = "published" LIMIT 1'
        );
        $stmt->execute([$slug]);

        $item = $stmt->fetch();

        return $item !== false ? $item : null;
    }

    public static function latest(int $limit = 3): array
    {
        $limit = max(1, (int) $limit);

        $stmt = Database::pdo()->prepare(
            "SELECT * FROM news WHERE status = 'published'
             ORDER BY published_at DESC, id DESC LIMIT $limit"
        );
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /** Berita unggulan yang sudah publish (untuk hero slider publik) */
    public static function featured(int $limit = 5): array
    {
        $limit = max(1, (int) $limit);

        $stmt = Database::pdo()->prepare(
            "SELECT * FROM news WHERE status = 'published' AND is_featured = 1
             ORDER BY published_at DESC, id DESC LIMIT $limit"
        );
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $stmt = Database::pdo()->prepare(
            'INSERT INTO news (title, slug, category, content, thumbnail, status, is_featured, published_at, user_id)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );

        $stmt->execute([
            $data['title'],
            $data['slug'],
            $data['category'],
            $data['content'],
            $data['thumbnail'],
            $data['status'],
            (int) ($data['is_featured'] ?? 0),
            $data['published_at'],
            $data['user_id'],
        ]);

        return (int) Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $stmt = Database::pdo()->prepare(
            'UPDATE news
             SET title = ?, slug = ?, category = ?, content = ?, thumbnail = ?, status = ?, is_featured = ?, published_at = ?
             WHERE id = ?'
        );

        $stmt->execute([
            $data['title'],
            $data['slug'],
            $data['category'],
            $data['content'],
            $data['thumbnail'],
            $data['status'],
            (int) ($data['is_featured'] ?? 0),
            $data['published_at'],
            $id,
        ]);
    }

    public static function delete(int $id): void
    {
        Database::pdo()->prepare('DELETE FROM news WHERE id = ?')->execute([$id]);
    }

    /** Tambah 1 views (dipakai halaman detail publik) */
    public static function incrementViews(int $id): void
    {
        Database::pdo()->prepare('UPDATE news SET views = views + 1 WHERE id = ?')->execute([$id]);
    }

    /** Bulk: ubah status banyak berita sekaligus */
    public static function bulkStatus(array $ids, string $status): void
    {
        if ($ids === []) return;
        $ph = implode(',', array_fill(0, count($ids), '?'));

        if ($status === 'published') {
            $sql = "UPDATE news SET status = 'published', published_at = COALESCE(published_at, ?) WHERE id IN ($ph)";
            $params = array_merge([date('Y-m-d H:i:s')], $ids);
        } else {
            $sql = "UPDATE news SET status = 'draft', published_at = NULL WHERE id IN ($ph)";
            $params = $ids;
        }

        Database::pdo()->prepare($sql)->execute($params);
    }

    /** Bulk: tandai / hapus unggulan banyak berita sekaligus */
    public static function bulkFeatured(array $ids, int $featured): void
    {
        if ($ids === []) return;
        $ph = implode(',', array_fill(0, count($ids), '?'));
        $params = array_merge([$featured], $ids);
        Database::pdo()->prepare("UPDATE news SET is_featured = ? WHERE id IN ($ph)")->execute($params);
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = self::slugify($title);
        $slug = $base;
        $i = 2;

        while (true) {
            $stmt = Database::pdo()->prepare('SELECT id FROM news WHERE slug = ? LIMIT 1');
            $stmt->execute([$slug]);
            $row = $stmt->fetch();

            if ($row === false || ($ignoreId !== null && (int) $row['id'] === $ignoreId)) {
                return $slug;
            }

            $slug = $base . '-' . $i;
            $i++;
        }
    }

    private static function slugify(string $text): string
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');

        return $text !== '' ? $text : 'berita-' . time();
    }
}