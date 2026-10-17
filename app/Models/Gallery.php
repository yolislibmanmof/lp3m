<?php
declare(strict_types=1);

class Gallery
{
    public static function all(): array
    {
        return Database::pdo()->query("SELECT * FROM galleries ORDER BY created_at DESC, id DESC")->fetchAll();
    }

    public static function categories(): array
    {
        return Database::pdo()->query("SELECT DISTINCT category FROM galleries ORDER BY category ASC")->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function byCategory(string $cat): array
    {
        if ($cat === '') return self::all();
        $stmt = Database::pdo()->prepare("SELECT * FROM galleries WHERE category = ? ORDER BY created_at DESC, id DESC");
        $stmt->execute([$cat]);
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM galleries WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $d): int
    {
        $stmt = Database::pdo()->prepare("INSERT INTO galleries (title, category, image_path, description, event_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$d['title'], $d['category'], $d['image_path'], $d['description'], $d['event_date'] ?: null]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $d): void
    {
        $stmt = Database::pdo()->prepare("UPDATE galleries SET title = ?, category = ?, image_path = ?, description = ?, event_date = ? WHERE id = ?");
        $stmt->execute([$d['title'], $d['category'], $d['image_path'], $d['description'], $d['event_date'] ?: null, $id]);
    }

    public static function delete(int $id): void
    {
        Database::pdo()->prepare("DELETE FROM galleries WHERE id = ?")->execute([$id]);
    }
}