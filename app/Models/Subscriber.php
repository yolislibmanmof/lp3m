<?php

declare(strict_types=1);

/**
 * Model Subscriber — newsletter publik LP3M.
 * Status: 'active' (berlangganan) atau 'unsubscribed' (berhenti).
 * Token: 32 karakter hex unik untuk link unsubscribe aman.
 */
class Subscriber
{
    public static function subscribe(string $email, string $name = '', string $source = 'footer'): array
    {
        $email = strtolower(trim($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['ok' => false, 'message' => 'Format email tidak valid.'];
        }

        $pdo = Database::pdo();
        $s = $pdo->prepare('SELECT * FROM subscribers WHERE email = ? LIMIT 1');
        $s->execute([$email]);
        $existing = $s->fetch();

        if ($existing && $existing['status'] === 'active') {
            return ['ok' => false, 'message' => 'Email ini sudah berlangganan sebelumnya.'];
        }

        if ($existing) {
            $pdo->prepare("UPDATE subscribers SET status='active', name=?, source=? WHERE id=?")
                ->execute([
                    $name !== '' ? $name : ($existing['name'] ?? null),
                    $source,
                    $existing['id'],
                ]);
            return ['ok' => true, 'message' => 'Langganan Anda berhasil diaktifkan kembali.'];
        }

        $token = bin2hex(random_bytes(16));
        $pdo->prepare('INSERT INTO subscribers (email, name, token, status, source) VALUES (?, ?, ?, ?, ?)')
            ->execute([$email, $name !== '' ? $name : null, $token, 'active', $source]);

        return ['ok' => true, 'message' => 'Terima kasih! Anda berhasil berlangganan info LP3M.'];
    }

    public static function unsubscribeByToken(string $token): bool
    {
        $s = Database::pdo()->prepare("UPDATE subscribers SET status='unsubscribed' WHERE token = ?");
        $s->execute([$token]);
        return $s->rowCount() > 0;
    }

    public static function getByEmail(string $email): ?array
    {
        $s = Database::pdo()->prepare('SELECT * FROM subscribers WHERE email = ? LIMIT 1');
        $s->execute([strtolower(trim($email))]);
        return $s->fetch() ?: null;
    }

    public static function getByToken(string $token): ?array
    {
        $s = Database::pdo()->prepare('SELECT * FROM subscribers WHERE token = ? LIMIT 1');
        $s->execute([$token]);
        return $s->fetch() ?: null;
    }

    public static function all(string $status = '', string $q = ''): array
    {
        $where = [];
        $params = [];
        if ($status !== '') { $where[] = 'status = ?'; $params[] = $status; }
        if ($q !== '') {
            $like = '%' . $q . '%';
            $where[] = '(email LIKE ? OR name LIKE ?)';
            $params[] = $like;
            $params[] = $like;
        }
        $sql = 'SELECT * FROM subscribers' . ($where ? ' WHERE ' . implode(' AND ', $where) : '') . ' ORDER BY id DESC';
        $s = Database::pdo()->prepare($sql);
        $s->execute($params);
        return $s->fetchAll();
    }

    public static function activeEmails(): array
    {
        return Database::pdo()->query("SELECT email, name, token FROM subscribers WHERE status='active' ORDER BY id")->fetchAll();
    }

    public static function stats(): array
    {
        $pdo = Database::pdo();
        return [
            'total'  => (int) $pdo->query('SELECT COUNT(*) FROM subscribers')->fetchColumn(),
            'active' => (int) $pdo->query("SELECT COUNT(*) FROM subscribers WHERE status='active'")->fetchColumn(),
            'unsub'  => (int) $pdo->query("SELECT COUNT(*) FROM subscribers WHERE status='unsubscribed'")->fetchColumn(),
        ];
    }

    public static function delete(int $id): void
    {
        Database::pdo()->prepare('DELETE FROM subscribers WHERE id = ?')->execute([$id]);
    }
}