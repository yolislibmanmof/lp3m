<?php
declare(strict_types=1);

class Notification
{
    public static function push(string $type, string $title, string $message, string $category = 'info', ?string $link = null, string $icon = '🔔', ?int $userId = null, bool $global = true, ?string $moduleType = null, ?int $moduleId = null): int
    {
        $s = Database::pdo()->prepare('INSERT INTO notifications (user_id,type,category,title,message,link,icon,is_global,module_type,module_id) VALUES (?,?,?,?,?,?,?,?,?,?)');
        $s->execute([$userId, $type, $category, $title, $message, $link, $icon, (int) $global, $moduleType, $moduleId]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function forUser(?int $userId, bool $unreadOnly = false, int $limit = 60): array
    {
        $sql = 'SELECT * FROM notifications WHERE (is_global = 1 OR user_id ' . ($userId ? '= ' . (int) $userId : 'IS NULL') . ')' . ($unreadOnly ? ' AND is_read = 0' : '') . ' ORDER BY created_at DESC LIMIT ' . (int) $limit;
        return Database::pdo()->query($sql)->fetchAll();
    }

    public static function unreadCount(?int $userId): int
    {
        $sql = 'SELECT COUNT(*) FROM notifications WHERE is_read = 0 AND (is_global = 1 OR user_id ' . ($userId ? '= ' . (int) $userId : 'IS NULL') . ')';
        return (int) Database::pdo()->query($sql)->fetchColumn();
    }

    public static function markRead(int $id): void
    {
        Database::pdo()->prepare('UPDATE notifications SET is_read = 1, read_at = NOW() WHERE id = ?')->execute([$id]);
    }

    public static function markAllRead(?int $userId): void
    {
        Database::pdo()->exec('UPDATE notifications SET is_read = 1, read_at = NOW() WHERE is_read = 0 AND (is_global = 1 OR user_id ' . ($userId ? (int) $userId : 'NULL') . ')');
    }

    public static function delete(int $id): void { Database::pdo()->prepare('DELETE FROM notifications WHERE id = ?')->execute([$id]); }

    public static function stats(): array
    {
        $pdo = Database::pdo();
        return [
            'total' => (int) $pdo->query('SELECT COUNT(*) FROM notifications')->fetchColumn(),
            'unread' => (int) $pdo->query('SELECT COUNT(*) FROM notifications WHERE is_read = 0')->fetchColumn(),
            'today' => (int) $pdo->query('SELECT COUNT(*) FROM notifications WHERE DATE(created_at) = CURDATE()')->fetchColumn(),
        ];
    }
}