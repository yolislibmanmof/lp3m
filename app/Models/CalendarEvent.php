<?php
declare(strict_types=1);

class CalendarEvent
{
    public const TYPES = ['penelitian' => '🔬 Penelitian', 'pengabdian' => '🤝 Pengabdian', 'pelatihan' => '🎓 Pelatihan', 'seminar' => '🎤 Seminar', 'workshop' => '🛠️ Workshop', 'aik' => '🕌 AIK', 'rapat' => '🏛️ Rapat', 'lainnya' => '📌 Lainnya'];
    public const STATUSES = ['draft' => 'Draft', 'published' => 'Published', 'cancelled' => 'Dibatalkan', 'completed' => 'Selesai'];

    public static function paginate(array $filters = [], string $q = '', int $page = 1, int $perPage = 12): array
    {
        $where = []; $params = [];
        if (!empty($filters['type'])) { $where[] = 'event_type = ?'; $params[] = $filters['type']; }
        if (!empty($filters['status'])) { $where[] = 'status = ?'; $params[] = $filters['status']; }
        if (!empty($filters['month'])) { $where[] = "DATE_FORMAT(start_date,'%Y-%m') = ?"; $params[] = $filters['month']; }
        if (trim($q) !== '') { $like = '%' . trim($q) . '%'; $where[] = '(title LIKE ? OR location LIKE ?)'; $params = array_merge($params, [$like, $like]); }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $c = Database::pdo()->prepare("SELECT COUNT(*) FROM events $whereSql"); $c->execute($params);
        $total = (int) $c->fetchColumn();
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $totalPages));
        $s = Database::pdo()->prepare("SELECT * FROM events $whereSql ORDER BY start_date DESC LIMIT $perPage OFFSET " . (($page - 1) * $perPage));
        $s->execute($params);
        return ['items' => $s->fetchAll(), 'total' => $total, 'page' => $page, 'totalPages' => $totalPages];
    }

    public static function find(int $id): ?array
    {
        $s = Database::pdo()->prepare('SELECT * FROM events WHERE id = ?'); $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    public static function upcoming(int $limit = 12, bool $publishedOnly = true): array
    {
        $sql = 'SELECT * FROM events WHERE start_date >= CURDATE()' . ($publishedOnly ? " AND status='published'" : '') . ' ORDER BY start_date ASC LIMIT ' . (int) $limit;
        return Database::pdo()->query($sql)->fetchAll();
    }

    public static function byMonth(string $ym, bool $publishedOnly = true): array
    {
        $sql = 'SELECT * FROM events WHERE DATE_FORMAT(start_date,"%Y-%m") = ?' . ($publishedOnly ? " AND status='published'" : '') . ' ORDER BY start_date ASC';
        $s = Database::pdo()->prepare($sql); $s->execute([$ym]);
        return $s->fetchAll();
    }

    public static function create(array $d): int
    {
        $s = Database::pdo()->prepare('INSERT INTO events (title,description,event_type,start_date,end_date,start_time,end_time,is_all_day,location,organizer,max_participants,registration_link,status,reminder_h7,reminder_h3,reminder_h1) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $s->execute([$d['title'], $d['description'] ?: null, $d['event_type'], $d['start_date'], $d['end_date'] ?: null, $d['start_time'] ?: null, $d['end_time'] ?: null, (int) ($d['is_all_day'] ?? 0), $d['location'] ?: null, $d['organizer'] ?: null, $d['max_participants'] ?: null, $d['registration_link'] ?: null, $d['status'], (int) ($d['reminder_h7'] ?? 1), (int) ($d['reminder_h3'] ?? 1), (int) ($d['reminder_h1'] ?? 1)]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $d): void
    {
        $s = Database::pdo()->prepare('UPDATE events SET title=?,description=?,event_type=?,start_date=?,end_date=?,start_time=?,end_time=?,is_all_day=?,location=?,organizer=?,max_participants=?,registration_link=?,status=?,reminder_h7=?,reminder_h3=?,reminder_h1=? WHERE id=?');
        $s->execute([$d['title'], $d['description'] ?: null, $d['event_type'], $d['start_date'], $d['end_date'] ?: null, $d['start_time'] ?: null, $d['end_time'] ?: null, (int) ($d['is_all_day'] ?? 0), $d['location'] ?: null, $d['organizer'] ?: null, $d['max_participants'] ?: null, $d['registration_link'] ?: null, $d['status'], (int) ($d['reminder_h7'] ?? 1), (int) ($d['reminder_h3'] ?? 1), (int) ($d['reminder_h1'] ?? 1), $id]);
    }

    public static function delete(int $id): void { Database::pdo()->prepare('DELETE FROM events WHERE id = ?')->execute([$id]); }

    public static function stats(): array
    {
        $pdo = Database::pdo();
        return [
            'total' => (int) $pdo->query('SELECT COUNT(*) FROM events')->fetchColumn(),
            'upcoming' => (int) $pdo->query("SELECT COUNT(*) FROM events WHERE start_date >= CURDATE() AND status='published'")->fetchColumn(),
            'this_month' => (int) $pdo->query("SELECT COUNT(*) FROM events WHERE DATE_FORMAT(start_date,'%Y-%m') = DATE_FORMAT(CURDATE(),'%Y-%m')")->fetchColumn(),
            'completed' => (int) $pdo->query("SELECT COUNT(*) FROM events WHERE status='completed' OR (end_date IS NOT NULL AND end_date < CURDATE())")->fetchColumn(),
        ];
    }
}