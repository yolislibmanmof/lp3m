<?php
declare(strict_types=1);

class Faq
{
    public static function allActive(): array
    {
        return Database::pdo()->query("SELECT * FROM faqs WHERE is_active = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
    }

    public static function all(): array
    {
        return Database::pdo()->query("SELECT * FROM faqs ORDER BY sort_order ASC, id ASC")->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM faqs WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $data): int
    {
        $stmt = Database::pdo()->prepare("INSERT INTO faqs (question, answer, sort_order, is_active) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['question'], $data['answer'], (int)($data['sort_order'] ?? 0), isset($data['is_active']) ? 1 : 0]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $stmt = Database::pdo()->prepare("UPDATE faqs SET question = ?, answer = ?, sort_order = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$data['question'], $data['answer'], (int)($data['sort_order'] ?? 0), isset($data['is_active']) ? 1 : 0, $id]);
    }

    public static function delete(int $id): void
    {
        Database::pdo()->prepare("DELETE FROM faqs WHERE id = ?")->execute([$id]);
    }
}