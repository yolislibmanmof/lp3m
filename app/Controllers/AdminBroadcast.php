<?php

declare(strict_types=1);

class AdminBroadcast
{
    private static function guard(): void
    {
        $role = Auth::user()['role'] ?? '';
        if (!in_array($role, ['super_admin', 'admin_lp3m'], true)) {
            self::flash('error', 'Akses ditolak — modul broadcast khusus admin.');
            redirect(url('admin/index.php?page=dashboard'));
        }
    }

    // ══════════════════════════════════════════════════════
    // HALAMAN
    // ══════════════════════════════════════════════════════

    public static function index(): void
    {
        self::guard();
        View::render('admin/broadcast/index', [
            'title'    => 'Newsletter & Broadcast | ' . APP_NAME,
            'items'    => Broadcast::all(),
            'subStats' => Subscriber::stats(),
            'segments' => Broadcast::SEGMENTS,
            'flash'    => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function create(): void
    {
        self::guard();
        View::render('admin/broadcast/form', [
            'title'    => 'Tulis Broadcast | ' . APP_NAME,
            'segments' => Broadcast::SEGMENTS,
            'flash'    => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function subscribers(): void
    {
        self::guard();
        $status = $_GET['status'] ?? '';
        $q = trim($_GET['q'] ?? '');
        View::render('admin/broadcast/subscribers', [
            'title'  => 'Manajemen Subscriber | ' . APP_NAME,
            'items'  => Subscriber::all($status, $q),
            'stats'  => Subscriber::stats(),
            'status' => $status,
            'q'      => $q,
            'flash'  => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function logs(): void
    {
        self::guard();
        $id = (int) ($_GET['id'] ?? 0);
        $b = Broadcast::find($id);
        if (!$b) { redirect(url('admin/index.php?page=broadcast')); }
        View::render('admin/broadcast/logs', [
            'title' => 'Log Pengiriman | ' . APP_NAME,
            'item'  => $b,
            'logs'  => Broadcast::logs($id),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    // ══════════════════════════════════════════════════════
    // AKSI
    // ══════════════════════════════════════════════════════

    public static function store(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=broadcast')); }

        $title   = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $segment = $_POST['segment'] ?? 'subscribers';

        if ($title === '' || $content === '') {
            self::flash('error', 'Judul dan isi broadcast wajib diisi.');
            redirect(url('admin/index.php?page=broadcast-tambah'));
        }
        if (!array_key_exists($segment, Broadcast::SEGMENTS)) $segment = 'subscribers';

        Broadcast::create($title, $content, $segment, (int) (Auth::user()['id'] ?? 0));
        self::flash('success', 'Broadcast tersimpan sebagai draft. Klik "Kirim" untuk mengirim.');
        redirect(url('admin/index.php?page=broadcast'));
    }

    public static function sendNow(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=broadcast')); }

        $id  = (int) ($_POST['id'] ?? 0);
        $res = Broadcast::send($id);

        if (!empty($res['error'])) {
            self::flash('error', $res['error']);
        } else {
            self::flash('success', 'Broadcast terkirim: ' . $res['sent'] . ' sukses, ' . $res['failed'] . ' gagal.');
        }
        redirect(url('admin/index.php?page=broadcast'));
    }

    public static function destroy(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=broadcast')); }
        Broadcast::delete((int) ($_POST['id'] ?? 0));
        self::flash('success', 'Broadcast dihapus.');
        redirect(url('admin/index.php?page=broadcast'));
    }

    public static function subscriberDelete(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=broadcast-subscribers')); }
        Subscriber::delete((int) ($_POST['id'] ?? 0));
        self::flash('success', 'Subscriber dihapus.');
        redirect(url('admin/index.php?page=broadcast-subscribers'));
    }

    public static function subscriberExport(): void
    {
        self::guard();
        $rows = Subscriber::all();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="subscribers-' . date('Ymd-His') . '.csv"');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($out, ['ID', 'Email', 'Nama', 'Status', 'Sumber', 'Terdaftar']);
        foreach ($rows as $r) {
            fputcsv($out, [$r['id'], $r['email'], $r['name'], $r['status'], $r['source'], $r['created_at']]);
        }
        fclose($out);
        exit;
    }

    /**
     * 🔌 Test koneksi & login SMTP tanpa mengirim email.
     * Mendukung SSL (465) dan TLS dengan STARTTLS (587 — wajib untuk Brevo).
     */
    public static function testSmtp(): void
    {
        self::guard();
        $cfg = MailSender::config();

        if ($cfg['driver'] !== 'smtp' || $cfg['host'] === '') {
            self::flash('error', 'Driver masih "mail". Ubah config/mail.php ke driver "smtp" dahulu.');
            redirect(url('admin/index.php?page=broadcast'));
        }

        $remote = ($cfg['encryption'] === 'ssl' ? 'ssl://' : '') . $cfg['host'];
        $ctx = stream_context_create(['ssl' => [
            'allow_self_signed' => true, 'verify_peer' => false, 'verify_peer_name' => false,
        ]]);
        $fp = @stream_socket_client($remote . ':' . (int) $cfg['port'], $errno, $errstr, 12, STREAM_CLIENT_CONNECT, $ctx);

        if (!$fp) {
            self::flash('error', "Koneksi SMTP gagal: $errstr ($errno). Periksa host, port, atau firewall server.");
            redirect(url('admin/index.php?page=broadcast'));
        }

        stream_set_timeout($fp, 12);
        $read = function () use ($fp): string {
            $d = '';
            while (($l = fgets($fp, 512)) !== false) {
                $d .= $l;
                if (isset($l[3]) && $l[3] === ' ') break;
            }
            return $d;
        };

        try {
            $read();
            $ehlo = parse_url(BASE_URL, PHP_URL_HOST) ?: 'lp3m-test';
            fwrite($fp, "EHLO $ehlo\r\n"); $read();

            if ($cfg['encryption'] === 'tls') {
                fwrite($fp, "STARTTLS\r\n");
                $st = $read();
                if (strpos($st, '220') !== 0) {
                    @fclose($fp);
                    self::flash('error', 'Server menolak STARTTLS: ' . trim($st));
                    redirect(url('admin/index.php?page=broadcast'));
                }
                if (!stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                    @fclose($fp);
                    self::flash('error', 'Gagal mengaktifkan enkripsi TLS setelah STARTTLS.');
                    redirect(url('admin/index.php?page=broadcast'));
                }
                fwrite($fp, "EHLO $ehlo\r\n"); $read();
            }

            $authMsg = '';
            if ($cfg['username'] !== '') {
                fwrite($fp, "AUTH LOGIN\r\n");
                $r1 = $read();
                if (strpos($r1, '334') !== 0) {
                    $authMsg = 'Server menolak AUTH: ' . trim($r1);
                } else {
                    fwrite($fp, base64_encode($cfg['username']) . "\r\n");
                    $read();
                    fwrite($fp, base64_encode(str_replace(' ', '', (string) $cfg['password'])) . "\r\n");
                    $r3 = $read();
                    if (strpos($r3, '235') !== 0) {
                        $authMsg = $r3 === ''
                            ? 'Server menutup koneksi setelah password (kredensial ditolak atau IP belum diotorisasi).'
                            : 'Login ditolak: ' . trim($r3);
                    }
                }
            }

            @fwrite($fp, "QUIT\r\n");
            @fclose($fp);

            if ($authMsg === '') {
                self::flash('success', '✅ Koneksi & login SMTP BERHASIL ke ' . $cfg['host'] . ':' . $cfg['port'] . ' — siap kirim broadcast.');
            } else {
                self::flash('error', '⚠️ Koneksi OK tapi autentikasi gagal — ' . $authMsg);
            }
        } catch (\Throwable $e) {
            @fclose($fp);
            self::flash('error', 'Error: ' . $e->getMessage());
        }
        redirect(url('admin/index.php?page=broadcast'));
    }

    private static function flash(string $t, string $m): void { $_SESSION['flash'] = ['type' => $t, 'message' => $m]; }
    private static function getFlash() { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
}