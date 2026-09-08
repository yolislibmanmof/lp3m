<?php

declare(strict_types=1);

class AdminNotification
{
    /** Daftar notifikasi (grouping & filter dikerjakan di view) */
    public static function index(): void
    {
        $uid = (int) (Auth::user()['id'] ?? 0);
        View::render('admin/notifications/index', [
            'title' => 'Notifikasi | ' . APP_NAME,
            'items' => Notification::forUser($uid, false, 200),
            'stats' => Notification::stats(),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    /** Tandai 1 notifikasi dibaca, lalu lanjut ke link tujuan (jika ada) */
    public static function markRead(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            Notification::markRead($id);
        }
        $link = trim($_GET['goto'] ?? '');
        redirect($link !== '' ? $link : url('admin/index.php?page=notifikasi'));
    }

    /** Tandai SEMUA notifikasi pengguna sebagai dibaca */
    public static function markAll(): void
    {
        Notification::markAllRead((int) (Auth::user()['id'] ?? 0));
        self::flash('success', 'Semua notifikasi ditandai dibaca.');
        redirect(url('admin/index.php?page=notifikasi'));
    }

    /** ✅ BULK: tandai beberapa notifikasi sekaligus (form ids[] dari view) */
    public static function bulkMarkRead(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            redirect(url('admin/index.php?page=notifikasi'));
        }

        $ids = $_POST['ids'] ?? [];
        if (!is_array($ids)) $ids = [];
        $ids = array_values(array_filter(array_map('intval', $ids), fn($i) => $i > 0));

        if (empty($ids)) {
            self::flash('error', 'Pilih minimal satu notifikasi.');
            redirect(url('admin/index.php?page=notifikasi'));
        }

        foreach ($ids as $id) {
            Notification::markRead($id);
        }

        self::flash('success', count($ids) . ' notifikasi ditandai sebagai dibaca.');
        redirect(url('admin/index.php?page=notifikasi'));
    }

    /** 🧹 Bersihkan semua notifikasi yang SUDAH dibaca */
    public static function clearRead(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            redirect(url('admin/index.php?page=notifikasi'));
        }

        $uid = (int) (Auth::user()['id'] ?? 0);
        $stmt = Database::pdo()->prepare('DELETE FROM notifications WHERE is_read = 1 AND (is_global = 1 OR user_id = ?)');
        $stmt->execute([$uid]);
        $count = (int) $stmt->rowCount();

        self::flash('success', $count . ' notifikasi terbaca dibersihkan.');
        redirect(url('admin/index.php?page=notifikasi'));
    }

    /** Hapus 1 notifikasi */
    public static function destroy(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            redirect(url('admin/index.php?page=notifikasi'));
        }
        Notification::delete((int) ($_POST['id'] ?? 0));
        self::flash('success', 'Notifikasi dihapus.');
        redirect(url('admin/index.php?page=notifikasi'));
    }

    private static function flash(string $t, string $m): void
    {
        $_SESSION['flash'] = ['type' => $t, 'message' => $m];
    }

    private static function getFlash()
    {
        $f = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $f;
    }
}