<?php

declare(strict_types=1);

class AdminUser
{
    /** Hanya Super Admin yang boleh masuk modul ini */
    private static function guard(): void
    {
        if ((Auth::user()['role'] ?? '') !== 'super_admin') {
            self::flash('error', 'Akses ditolak — modul pengguna khusus Super Admin.');
            redirect(url('admin/index.php?page=dashboard'));
        }
    }

    private static function meId(): int
    {
        return (int) (Auth::user()['id'] ?? 0);
    }

    public static function index(): void
    {
        self::guard();
        $filters = ['role' => $_GET['role'] ?? '', 'status' => $_GET['status'] ?? ''];
        $q = trim($_GET['q'] ?? '');
        $r = User::paginate($filters, $q, max(1, (int) ($_GET['hal'] ?? 1)), 10);
        View::render('admin/users/index', [
            'title' => 'Manajemen Pengguna | ' . APP_NAME,
            'items' => $r['items'], 'total' => $r['total'], 'page' => $r['page'], 'totalPages' => $r['totalPages'],
            'filters' => $filters, 'q' => $q,
            'stats' => User::stats(),
            'roles' => User::ROLES,
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function create(): void
    {
        self::guard();
        View::render('admin/users/form', [
            'title' => 'Tambah Pengguna | ' . APP_NAME,
            'item' => null, 'roles' => User::ROLES,
            'action' => url('admin/index.php?page=users-simpan'),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function store(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error', 'Token tidak valid.'); redirect(url('admin/index.php?page=users')); }

        $name = trim($_POST['name'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $role = $_POST['role'] ?? 'admin_lp3m';

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::flash('error', 'Nama dan email valid wajib diisi.'); redirect(url('admin/index.php?page=users-tambah'));
        }
        if (!array_key_exists($role, User::ROLES)) { self::flash('error', 'Role tidak valid.'); redirect(url('admin/index.php?page=users-tambah')); }
        if (User::findByEmail($email)) { self::flash('error', 'Email sudah terdaftar.'); redirect(url('admin/index.php?page=users-tambah')); }

        $plain = trim($_POST['password'] ?? '');
        $generated = '';
        if ($plain === '') { $plain = User::generatePassword(); $generated = $plain; }
        if (strlen($plain) < 8) { self::flash('error', 'Password minimal 8 karakter.'); redirect(url('admin/index.php?page=users-tambah')); }

        User::create([
            'name' => $name, 'email' => $email, 'phone' => trim($_POST['phone'] ?? ''),
            'role' => $role, 'is_active' => isset($_POST['is_active']) ? 1 : 0, 'password' => $plain,
        ]);

        self::flash('success', 'Pengguna "' . $name . '" dibuat.' . ($generated !== '' ? ' Password sementara: ' . $generated : ''));
        redirect(url('admin/index.php?page=users'));
    }

    public static function edit(int $id): void
    {
        self::guard();
        $item = User::find($id);
        if (!$item) { redirect(url('admin/index.php?page=users')); }
        View::render('admin/users/form', [
            'title' => 'Edit Pengguna | ' . APP_NAME,
            'item' => $item, 'roles' => User::ROLES,
            'action' => url('admin/index.php?page=users-update'),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function update(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error', 'Token tidak valid.'); redirect(url('admin/index.php?page=users')); }

        $id = (int) ($_POST['id'] ?? 0);
        $item = User::find($id);
        if (!$item) { redirect(url('admin/index.php?page=users')); }

        $name = trim($_POST['name'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $role = $_POST['role'] ?? $item['role'];

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::flash('error', 'Nama dan email valid wajib diisi.'); redirect(url('admin/index.php?page=users-edit&id=' . $id));
        }
        if (!array_key_exists($role, User::ROLES)) { self::flash('error', 'Role tidak valid.'); redirect(url('admin/index.php?page=users-edit&id=' . $id)); }
        $dup = User::findByEmail($email);
        if ($dup && (int) $dup['id'] !== $id) { self::flash('error', 'Email sudah dipakai pengguna lain.'); redirect(url('admin/index.php?page=users-edit&id=' . $id)); }

        // Cegah menurunkan role super_admin terakhir
        if ($item['role'] === 'super_admin' && $role !== 'super_admin' && User::countRole('super_admin') <= 1) {
            self::flash('error', 'Tidak dapat mengubah role Super Admin terakhir.'); redirect(url('admin/index.php?page=users-edit&id=' . $id));
        }

        $newPass = trim($_POST['password'] ?? '');
        if ($newPass !== '' && strlen($newPass) < 8) {
            self::flash('error', 'Password minimal 8 karakter.'); redirect(url('admin/index.php?page=users-edit&id=' . $id));
        }

        User::update($id, [
            'name' => $name, 'email' => $email, 'phone' => trim($_POST['phone'] ?? ''),
            'role' => $role, 'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ], $newPass !== '' ? $newPass : null);

        self::flash('success', 'Perubahan pengguna disimpan.' . ($newPass !== '' ? ' Password diperbarui.' : ''));
        redirect(url('admin/index.php?page=users'));
    }

    public static function toggle(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=users')); }
        $id = (int) ($_POST['id'] ?? 0);
        if ($id === self::meId()) { self::flash('error', 'Tidak dapat menonaktifkan akun sendiri.'); redirect(url('admin/index.php?page=users')); }
        $u = User::find($id);
        if (!$u) { redirect(url('admin/index.php?page=users')); }
        if ($u['role'] === 'super_admin' && (int) $u['is_active'] === 1 && User::countRole('super_admin', true) <= 1) {
            self::flash('error', 'Tidak dapat menonaktifkan Super Admin aktif terakhir.'); redirect(url('admin/index.php?page=users'));
        }
        $new = User::toggleActive($id);
        self::flash('success', 'Pengguna ' . ($new === 1 ? 'diaktifkan' : 'dinonaktifkan') . '.');
        redirect(url('admin/index.php?page=users'));
    }

    public static function reset(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=users')); }
        $id = (int) ($_POST['id'] ?? 0);
        $u = User::find($id);
        if (!$u) { redirect(url('admin/index.php?page=users')); }

        $plain = trim($_POST['password'] ?? '');
        $generated = '';
        if ($plain === '') { $plain = User::generatePassword(); $generated = $plain; }
        if (strlen($plain) < 8) { self::flash('error', 'Password minimal 8 karakter.'); redirect(url('admin/index.php?page=users')); }

        User::setPassword($id, $plain);
        self::flash('success', 'Password "' . $u['name'] . '" direset.' . ($generated !== '' ? ' Password baru: ' . $generated : ''));
        redirect(url('admin/index.php?page=users'));
    }

    public static function destroy(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=users')); }
        $id = (int) ($_POST['id'] ?? 0);
        if ($id === self::meId()) { self::flash('error', 'Tidak dapat menghapus akun sendiri.'); redirect(url('admin/index.php?page=users')); }
        $u = User::find($id);
        if (!$u) { redirect(url('admin/index.php?page=users')); }
        if ($u['role'] === 'super_admin' && User::countRole('super_admin') <= 1) {
            self::flash('error', 'Tidak dapat menghapus Super Admin terakhir.'); redirect(url('admin/index.php?page=users'));
        }
        User::delete($id);
        self::flash('success', 'Pengguna dihapus.');
        redirect(url('admin/index.php?page=users'));
    }

    private static function flash(string $t, string $m): void { $_SESSION['flash'] = ['type' => $t, 'message' => $m]; }
    private static function getFlash() { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
}