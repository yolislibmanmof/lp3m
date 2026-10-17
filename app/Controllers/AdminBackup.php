<?php

declare(strict_types=1);

class AdminBackup
{
    private static function guard(): void
    {
        if ((Auth::user()['role'] ?? '') !== 'super_admin') {
            self::flash('error', 'Akses ditolak — modul backup khusus Super Admin.');
            redirect(url('admin/index.php?page=dashboard'));
        }
    }

    public static function index(): void
    {
        self::guard();
        View::render('admin/backup/index', [
            'title' => 'Backup & Maintenance | ' . APP_NAME,
            'backups' => BackupManager::all(),
            'dbSize' => BackupManager::dbSize(),
            'last' => BackupManager::last(),
            'maintenance' => Maintenance::isOn(),
            'maintenanceMessage' => Maintenance::message(),
            'zipOk' => BackupManager::zipAvailable(),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function create(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=backup')); }
        try {
            $r = BackupManager::dbBackup(trim($_POST['note'] ?? ''));
            AuditLog::log('create', ['entity_type' => 'backups', 'entity_label' => $r['filename'], 'new_value' => $r]);
            self::flash('success', 'Backup database berhasil: ' . $r['filename'] . ' (' . BackupManager::human($r['size']) . ', ' . $r['tables'] . ' tabel).');
        } catch (\Throwable $e) {
            self::flash('error', 'Backup gagal: ' . $e->getMessage());
        }
        redirect(url('admin/index.php?page=backup'));
    }

    public static function zipUploads(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=backup')); }
        try {
            $r = BackupManager::zipUploads();
            AuditLog::log('create', ['entity_type' => 'backups', 'entity_label' => $r['filename']]);
            self::flash('success', 'Backup file uploads berhasil: ' . $r['filename'] . ' (' . $r['tables'] . ' file).');
        } catch (\Throwable $e) {
            self::flash('error', 'Backup file gagal: ' . $e->getMessage());
        }
        redirect(url('admin/index.php?page=backup'));
    }

    public static function download(): void
    {
        self::guard();
        $row = BackupManager::find((int) ($_GET['id'] ?? 0));
        if (!$row) { redirect(url('admin/index.php?page=backup')); }
        $path = BackupManager::dir() . '/' . $row['filename'];
        if (!is_file($path)) {
            self::flash('error', 'File backup tidak ditemukan di server.');
            redirect(url('admin/index.php?page=backup'));
        }
        $mime = $row['kind'] === 'db' ? 'application/sql' : 'application/zip';
        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . $row['filename'] . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

    public static function destroy(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=backup')); }
        $id = (int) ($_POST['id'] ?? 0);
        $row = BackupManager::find($id);
        BackupManager::delete($id);
        AuditLog::log('delete', ['entity_type' => 'backups', 'entity_label' => $row['filename'] ?? '']);
        self::flash('success', 'Arsip backup dihapus.');
        redirect(url('admin/index.php?page=backup'));
    }

    public static function restore(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=backup')); }

        $f = $_FILES['sqlfile'] ?? null;
        if (!$f || $f['error'] !== UPLOAD_ERR_OK) {
            self::flash('error', 'Unggahan file backup tidak valid.');
            redirect(url('admin/index.php?page=backup'));
        }
        if ($f['size'] > 25 * 1024 * 1024) {
            self::flash('error', 'Ukuran file maksimal 25 MB.');
            redirect(url('admin/index.php?page=backup'));
        }
        if (strtolower(pathinfo($f['name'], PATHINFO_EXTENSION)) !== 'sql') {
            self::flash('error', 'File harus berekstensi .sql');
            redirect(url('admin/index.php?page=backup'));
        }

        $tmp = $f['tmp_name'];
        try {
            $n = BackupManager::restore($tmp);
            AuditLog::log('restore', ['entity_type' => 'backups', 'entity_label' => $f['name'], 'new_value' => ['statements' => $n]]);
            self::flash('success', 'Restore selesai: ' . number_format($n) . ' pernyataan SQL dieksekusi.');
        } catch (\Throwable $e) {
            AuditLog::log('login_fail', ['entity_type' => 'backups', 'entity_label' => 'Restore gagal: ' . $f['name']]);
            self::flash('error', 'Restore gagal: ' . $e->getMessage());
        }
        redirect(url('admin/index.php?page=backup'));
    }

    public static function toggleMaintenance(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=backup')); }
        $on = (($_POST['maintenance'] ?? '0') === '1');
        Maintenance::set($on, $_POST['message'] ?? null);
        AuditLog::log('toggle', ['entity_type' => 'system', 'entity_label' => 'Maintenance mode', 'new_value' => ['on' => $on]]);
        self::flash('success', $on ? '🚧 Maintenance mode DIAKTIFKAN — situs publik ditutup.' : '✅ Maintenance mode dimatikan — situs publik terbuka.');
        redirect(url('admin/index.php?page=backup'));
    }

    private static function flash(string $t, string $m): void { $_SESSION['flash'] = ['type' => $t, 'message' => $m]; }
    private static function getFlash() { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
}