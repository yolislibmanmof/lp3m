<?php

declare(strict_types=1);

class Broadcast
{
    public const SEGMENTS = [
        'subscribers' => '📬 Subscriber Publik',
        'all_users'   => '👥 Semua Pengguna Aktif',
        'dosen'       => '🎓 Dosen',
        'mahasiswa'   => '🧑‍🎓 Mahasiswa',
        'pimpinan'    => '🏛️ Pimpinan',
        'admin_lp3m'  => '🛡️ Admin LP3M',
    ];

    public static function all(): array
    {
        return Database::pdo()->query('SELECT * FROM broadcasts ORDER BY id DESC')->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $s = Database::pdo()->prepare('SELECT * FROM broadcasts WHERE id = ?');
        $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    public static function create(string $title, string $content, string $segment, ?int $userId): int
    {
        $pdo = Database::pdo();
        $pdo->prepare('INSERT INTO broadcasts (title, content, segment, status, created_by) VALUES (?, ?, ?, ?, ?)')
            ->execute([$title, $content, $segment, 'draft', $userId]);
        return (int) $pdo->lastInsertId();
    }

    public static function delete(int $id): void
    {
        $pdo = Database::pdo();
        $pdo->prepare('DELETE FROM broadcast_logs WHERE broadcast_id = ?')->execute([$id]);
        $pdo->prepare('DELETE FROM broadcasts WHERE id = ?')->execute([$id]);
    }

    public static function logs(int $id): array
    {
        $s = Database::pdo()->prepare('SELECT * FROM broadcast_logs WHERE broadcast_id = ? ORDER BY id DESC LIMIT 200');
        $s->execute([$id]);
        return $s->fetchAll();
    }

    public static function recipients(string $segment): array
    {
        $pdo = Database::pdo();
        $out = [];
        $seen = [];
        $push = function (string $email, string $name, ?string $token, ?string $role) use (&$out, &$seen): void {
            $email = strtolower(trim($email));
            if ($email === '' || isset($seen[$email])) return;
            $seen[$email] = true;
            $out[] = ['email' => $email, 'name' => $name, 'token' => $token, 'role' => $role];
        };

        if ($segment === 'subscribers' || $segment === 'all') {
            foreach (Subscriber::activeEmails() as $s) {
                $push($s['email'], (string) ($s['name'] ?? ''), $s['token'], 'subscriber');
            }
        }
        if ($segment !== 'subscribers') {
            $role = $segment === 'all_users' || $segment === 'all' ? null : $segment;
            $sql = 'SELECT email, name, role FROM users WHERE is_active = 1 AND email IS NOT NULL' . ($role ? ' AND role = ?' : '');
            $st = $pdo->prepare($sql);
            if ($role) $st->execute([$role]); else $st->execute();
            foreach ($st->fetchAll() as $u) {
                $push($u['email'], (string) $u['name'], null, $u['role']);
            }
        }
        return $out;
    }

    public static function send(int $id): array
    {
        $b = self::find($id);
        if (!$b) return ['sent' => 0, 'failed' => 0, 'error' => 'Broadcast tidak ditemukan.'];

        $recipients = self::recipients($b['segment']);
        if (empty($recipients)) {
            Database::pdo()->prepare("UPDATE broadcasts SET status='failed', sent_at=NOW() WHERE id=?")->execute([$id]);
            return ['sent' => 0, 'failed' => 0, 'error' => 'Tidak ada penerima untuk segment ini.'];
        }

        $pdo = Database::pdo();
        $sent = 0; $failed = 0;
        $logIns = $pdo->prepare('INSERT INTO broadcast_logs (broadcast_id, email, status, error) VALUES (?, ?, ?, ?)');

        foreach ($recipients as $r) {
            $html = self::renderEmail($b, $r);
            $ok = MailSender::sendHtml($r['email'], $b['title'], $html);
            if ($ok) { $sent++; $logIns->execute([$id, $r['email'], 'sent', null]); }
            else { $failed++; $logIns->execute([$id, $r['email'], 'failed', 'mail() mengembalikan false']); }
        }

        $status = $failed === 0 ? 'sent' : ($sent === 0 ? 'failed' : 'sent');
        $pdo->prepare('UPDATE broadcasts SET status=?, sent_at=NOW(), sent_count=?, fail_count=? WHERE id=?')
            ->execute([$status, $sent, $failed, $id]);

        return ['sent' => $sent, 'failed' => $failed, 'error' => null];
    }

    private static function renderEmail(array $b, array $r): string
    {
        $viewFile = BASE_PATH . '/resources/views/emails/broadcast.php';
        $site = [];
        try { $site = Setting::all(); } catch (\Throwable $e) {}
        $unsubUrl = $r['token'] ? url('public/index.php?page=unsubscribe&token=' . $r['token']) : '';
        ob_start();
        require $viewFile;
        return (string) ob_get_clean();
    }
}