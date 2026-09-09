<?php

declare(strict_types=1);

class PublicSubscribe
{
    public static function subscribe(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect(url('public/index.php?page=home')); }
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::result(false, 'Token keamanan tidak valid. Silakan coba lagi.', '');
        }

        $email = trim($_POST['email'] ?? '');
        $name  = trim($_POST['name'] ?? '');
        $res   = Subscriber::subscribe($email, $name, 'footer');

        if (!$res['ok']) {
            self::result(false, $res['message'], $email);
            return;
        }

        $sent = self::sendWelcome($email, $name);

        self::result(
            true,
            $res['message'] . ($sent
                ? ' Kami telah mengirim email sambutan ke <b>' . e($email) . '</b> — periksa inbox (atau folder Spam).'
                : ' <small style="opacity:.75;">Catatan: email sambutan tertunda karena layanan email sedang sibuk — tetapi langganan Anda tetap aktif.</small>'
            ),
            $email
        );
    }

    public static function unsubscribe(): void
    {
        $token = trim($_GET['token'] ?? '');
        if ($token === '' || !Subscriber::unsubscribeByToken($token)) {
            self::result(false, 'Tautan berhenti berlangganan tidak valid atau sudah digunakan.', '');
            return;
        }
        self::result(true, 'Anda telah berhenti berlangganan newsletter LP3M. Terima kasih atas waktunya — Anda dapat berlangganan kembali kapan saja.', '');
    }

    /** Kirim email welcome ke subscriber baru (silent-fail) */
    private static function sendWelcome(string $email, string $name): bool
    {
        try {
            $sub = Subscriber::getByEmail($email);
            if (!$sub) return false;

            $site = [];
            try { $site = Setting::all(); } catch (\Throwable $e) {}
            $brand = $site['site_brand'] ?? 'LP3M UNIMOF';

            $unsubUrl = url('public/index.php?page=unsubscribe&token=' . $sub['token']);
            $homeUrl  = url('public/index.php?page=home');
            $nama     = ($sub['name'] ?? '') !== '' ? $sub['name'] : 'Rekan Subscriber';

            $viewFile = BASE_PATH . '/resources/views/emails/welcome.php';
            if (!is_file($viewFile)) return false;

            ob_start();
            require $viewFile;
            $html = (string) ob_get_clean();

            return MailSender::sendHtml($email, 'Selamat datang di Newsletter ' . $brand . ' 📬', $html);
        } catch (\Throwable $e) {
            return false;
        }
    }

    private static function result(bool $ok, string $message, string $email): void
    {
        View::render('public/subscribe/result', [
            'title'   => ($ok ? 'Berhasil' : 'Perhatian') . ' | ' . APP_NAME,
            'ok'      => $ok,
            'message' => $message,
            'email'   => $email,
        ]);
        exit;
    }
}