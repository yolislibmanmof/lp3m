<?php

declare(strict_types=1);

class AdminSettings
{
    public static function edit(): void
    {
        View::render('admin/settings/form', [
            'title' => 'Pengaturan Website | ' . APP_NAME,
            's' => Setting::all(),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash']);
    }

    public static function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/index.php?page=pengaturan'));
        }

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Token keamanan tidak valid.'];
            redirect(url('admin/index.php?page=pengaturan'));
        }

        $textKeys = array_diff(array_keys(Setting::defaults()), ['logo_path', 'favicon_path']);

        foreach ($textKeys as $key) {
            Setting::set($key, trim($_POST[$key] ?? ''));
        }

        // Hapus logo (jika dicentang) dulu, baru upload logo baru
        if (!empty($_POST['remove_logo'])) {
            Upload::remove(Setting::get('logo_path'));
            Setting::set('logo_path', '');
        }

        if (!empty($_FILES['logo']['name'])) {
            $up = Upload::image($_FILES['logo'], 'settings', 1048576);

            if ($up['ok']) {
                Upload::remove(Setting::get('logo_path'));
                Setting::set('logo_path', $up['path']);
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => $up['error']];
                redirect(url('admin/index.php?page=pengaturan'));
            }
        }

        // Hapus favicon (jika dicentang) dulu, baru upload favicon baru
        if (!empty($_POST['remove_favicon'])) {
            Upload::remove(Setting::get('favicon_path'));
            Setting::set('favicon_path', '');
        }

        if (!empty($_FILES['favicon']['name'])) {
            $up = Upload::image($_FILES['favicon'], 'settings', 1048576, ['png', 'ico']);

            if ($up['ok']) {
                Upload::remove(Setting::get('favicon_path'));
                Setting::set('favicon_path', $up['path']);
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => $up['error']];
                redirect(url('admin/index.php?page=pengaturan'));
            }
        }

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Pengaturan berhasil disimpan.'];
        redirect(url('admin/index.php?page=pengaturan'));
    }
}