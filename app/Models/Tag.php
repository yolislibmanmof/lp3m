<?php

declare(strict_types=1);

class Tag
{
    public static function slugify(string $text): string
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $slug = trim($text, '-');
        return $slug !== '' ? $slug : 'tag-' . time();
    }

    /** Parse string "a, b, c" jadi array nama tag (max 8, unik) */
    public static function parse(string $raw): array
    {
        $parts = array_map('trim', explode(',', $raw));
        $parts = array_filter($parts, fn($p) => $p !== '');
        $parts = array_slice(array_values($parts), 0, 8);

        $seen = [];
        $out = [];
        foreach ($parts as $p) {
            $key = strtolower($p);
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $out[] = $p;
            }
        }
        return $out;
    }

    public static function findOrCreate(string $name): int
    {
        $slug = self::slugify($name);

        $stmt = Database::pdo()->prepare('SELECT id FROM tags WHERE slug = ? LIMIT 1');
        $stmt->execute([$slug]);
        $row = $stmt->fetch();

        if ($row !== false) {
            return (int) $row['id'];
        }

        $ins = Database::pdo()->prepare('INSERT INTO tags (name, slug) VALUES (?, ?)');
        $ins->execute([$name, $slug]);

        return (int) Database::pdo()->lastInsertId();
    }

    /** Sinkronkan tags untuk satu berita (hapus lama, isi baru) */
    public static function syncForNews(int $newsId, array $names): void
    {
        $pdo = Database::pdo();
        $pdo->prepare('DELETE FROM news_tags WHERE news_id = ?')->execute([$newsId]);

        $ids = [];
        foreach ($names as $n) {
            $ids[] = self::findOrCreate($n);
        }
        $ids = array_unique($ids);

        $ins = $pdo->prepare('INSERT IGNORE INTO news_tags (news_id, tag_id) VALUES (?, ?)');
        foreach ($ids as $tid) {
            $ins->execute([$newsId, $tid]);
        }

        self::pruneUnused();
    }

    public static function tagsForNews(int $newsId): array
    {
        $stmt = Database::pdo()->prepare(
            'SELECT t.* FROM tags t
             JOIN news_tags nt ON nt.tag_id = t.id
             WHERE nt.news_id = ?
             ORDER BY t.name ASC'
        );
        $stmt->execute([$newsId]);
        return $stmt->fetchAll();
    }

    /** Berita terkait berdasarkan tag yang sama (paling relevan dulu) */
    public static function relatedNews(int $newsId, int $limit = 3): array
    {
        $limit = max(1, (int) $limit);
        $stmt = Database::pdo()->prepare(
            'SELECT n.* FROM news n
             JOIN news_tags nt ON nt.news_id = n.id
             WHERE nt.tag_id IN (SELECT tag_id FROM news_tags WHERE news_id = ?)
               AND n.id != ? AND n.status = "published"
             GROUP BY n.id
             ORDER BY COUNT(nt.tag_id) DESC, n.published_at DESC
             LIMIT ' . $limit
        );
        $stmt->execute([$newsId, $newsId]);
        return $stmt->fetchAll();
    }

    /** Tag populer + jumlah artikel (untuk chip di halaman publik) */
    public static function cloud(int $limit = 10): array
    {
        $limit = max(1, (int) $limit);
        return Database::pdo()->query(
            'SELECT t.name, t.slug, COUNT(nt.news_id) as cnt
             FROM tags t
             JOIN news_tags nt ON nt.tag_id = t.id
             GROUP BY t.id, t.name, t.slug
             ORDER BY cnt DESC, t.name ASC
             LIMIT ' . $limit
        )->fetchAll();
    }

    /** Hapus tag yang tidak dipakai berita manapun */
    public static function pruneUnused(): void
    {
        $used = Database::pdo()->query('SELECT DISTINCT tag_id FROM news_tags')->fetchAll(PDO::FETCH_COLUMN);

        if ($used === []) {
            Database::pdo()->exec('DELETE FROM tags');
            return;
        }

        $ph = implode(',', array_map('intval', $used));
        Database::pdo()->exec("DELETE FROM tags WHERE id NOT IN ($ph)");
    }
}