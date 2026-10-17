<?php

declare(strict_types=1);

/**
 * ══════════════════════════════════════════════════════════════
 *  Model Video — Galeri Video LP3M UNIMOF
 * ══════════════════════════════════════════════════════════════
 *
 *  Mendukung 3 sumber video:
 *    - youtube : URL/ID YouTube (auto thumbnail + embed privacy-enhanced)
 *    - vimeo   : URL Vimeo
 *    - mp4     : upload file MP4/WEBM atau URL eksternal
 *
 *  Kategori: Seminar, Workshop, Profil, Dokumentasi, Tutorial, Lainnya.
 * ══════════════════════════════════════════════════════════════
 */
class Video
{
    public const CATEGORIES = [
        'seminar'     => '🎓 Seminar',
        'workshop'    => '🛠️ Workshop',
        'profil'      => '🏛️ Profil Lembaga',
        'dokumentasi' => '📸 Dokumentasi',
        'tutorial'    => '📚 Tutorial',
        'lainnya'     => '📦 Lainnya',
    ];

    public const SOURCES = [
        'youtube' => '▶️ YouTube',
        'vimeo'   => '🎬 Vimeo',
        'mp4'     => '💾 File MP4 (upload)',
    ];

    public static function paginate(array $filters = [], string $q = '', int $page = 1, int $perPage = 12): array
    {
        $where = []; $params = [];
        if (!empty($filters['category'])) { $where[] = 'category = ?'; $params[] = $filters['category']; }
        if (!empty($filters['status']))   { $where[] = 'status = ?';   $params[] = $filters['status']; }
        if (trim($q) !== '') {
            $like = '%' . trim($q) . '%';
            $where[] = '(title LIKE ? OR description LIKE ?)';
            $params[] = $like; $params[] = $like;
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $pdo = Database::pdo();
        $c = $pdo->prepare("SELECT COUNT(*) FROM videos $whereSql"); $c->execute($params);
        $total = (int) $c->fetchColumn();
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $totalPages));
        $s = $pdo->prepare("SELECT * FROM videos $whereSql ORDER BY published_at DESC, id DESC LIMIT $perPage OFFSET " . (($page - 1) * $perPage));
        $s->execute($params);
        return ['items' => $s->fetchAll(), 'total' => $total, 'page' => $page, 'totalPages' => $totalPages];
    }

    public static function published(string $category = ''): array
    {
        $pdo = Database::pdo();
        if ($category !== '') {
            $s = $pdo->prepare("SELECT * FROM videos WHERE status='published' AND category = ? ORDER BY published_at DESC, id DESC LIMIT 60");
            $s->execute([$category]);
            return $s->fetchAll();
        }
        return $pdo->query("SELECT * FROM videos WHERE status='published' ORDER BY published_at DESC, id DESC LIMIT 60")->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $s = Database::pdo()->prepare('SELECT * FROM videos WHERE id = ?');
        $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    public static function create(array $d): int
    {
        $pdo = Database::pdo();
        $pdo->prepare(
            'INSERT INTO videos (title, description, category, source, youtube_id, video_url, thumbnail, duration, status, published_at, created_by)
             VALUES (?,?,?,?,?,?,?,?,?,?,?)'
        )->execute([
            $d['title'], $d['description'] ?? null, $d['category'], $d['source'],
            $d['youtube_id'] ?? null, $d['video_url'] ?? null, $d['thumbnail'] ?? null,
            $d['duration'] ?? null, $d['status'],
            $d['status'] === 'published' ? date('Y-m-d H:i:s') : null,
            $d['created_by'] ?? null,
        ]);
        return (int) $pdo->lastInsertId();
    }

    public static function update(int $id, array $d): void
    {
        Database::pdo()->prepare(
            "UPDATE videos SET title=?, description=?, category=?, source=?, youtube_id=?, video_url=?, thumbnail=?, duration=?, status=?,
             published_at = CASE WHEN ? = 'published' AND published_at IS NULL THEN NOW() ELSE published_at END
             WHERE id=?"
        )->execute([
            $d['title'], $d['description'] ?? null, $d['category'], $d['source'],
            $d['youtube_id'] ?? null, $d['video_url'] ?? null, $d['thumbnail'] ?? null,
            $d['duration'] ?? null, $d['status'], $d['status'], $id,
        ]);
    }

    /** Hapus video + file thumbnail & MP4 lokal (skip URL eksternal) */
    public static function delete(int $id): void
    {
        $v = self::find($id);
        if ($v) {
            foreach (['thumbnail', 'video_url'] as $f) {
                $p = (string) ($v[$f] ?? '');
                if ($p !== '' && !str_starts_with($p, 'http')) {
                    $file = BASE_PATH . '/public/uploads/' . ltrim($p, '/');
                    if (is_file($file)) @unlink($file);
                }
            }
        }
        Database::pdo()->prepare('DELETE FROM videos WHERE id = ?')->execute([$id]);
    }

    public static function toggleStatus(int $id): void
    {
        $pdo = Database::pdo();
        $pdo->prepare("UPDATE videos SET status = IF(status='published','draft','published'), published_at = IF(status='draft', NOW(), published_at) WHERE id=?")->execute([$id]);
    }

    public static function incrViews(int $id): void
    {
        Database::pdo()->prepare('UPDATE videos SET views = views + 1 WHERE id = ?')->execute([$id]);
    }

    public static function stats(): array
    {
        $pdo = Database::pdo();
        return [
            'total'     => (int) $pdo->query('SELECT COUNT(*) FROM videos')->fetchColumn(),
            'published' => (int) $pdo->query("SELECT COUNT(*) FROM videos WHERE status='published'")->fetchColumn(),
            'views'     => (int) $pdo->query('SELECT COALESCE(SUM(views),0) FROM videos')->fetchColumn(),
        ];
    }

    /** Ekstrak ID YouTube dari berbagai format URL */
    public static function extractYoutubeId(string $url): string
    {
        $url = trim($url);
        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $url)) return $url;
        if (preg_match('/(?:youtu\.be\/|v=|\/embed\/|\/shorts\/|\/live\/)([A-Za-z0-9_-]{11})/', $url, $m)) return $m[1];
        return '';
    }

    /** URL embed untuk player (YouTube pakai privacy-enhanced) */
    public static function embedUrl(array $v): string
    {
        if ($v['source'] === 'youtube' && !empty($v['youtube_id'])) {
            return 'https://www.youtube-nocookie.com/embed/' . $v['youtube_id'] . '?rel=0&modestbranding=1';
        }
        if ($v['source'] === 'vimeo') {
            if (preg_match('/vimeo\.com\/(\d+)/', (string) $v['video_url'], $m)) {
                return 'https://player.vimeo.com/video/' . $m[1];
            }
            return (string) $v['video_url'];
        }
        return (string) $v['video_url']; // mp4
    }

    /** URL thumbnail (auto dari YouTube bila tidak upload custom) */
    public static function thumbUrl(array $v): string
    {
        if (!empty($v['thumbnail'])) return upload_url($v['thumbnail']);
        if ($v['source'] === 'youtube' && !empty($v['youtube_id'])) {
            return 'https://i.ytimg.com/vi/' . $v['youtube_id'] . '/hqdefault.jpg';
        }
        return '';
    }
}