<?php
declare(strict_types=1);

class AdminGrant
{
    public static function index(): void
    {
        $items = Grant::all();
        View::render('admin/grant/index', [
            'title' => 'Manajemen Hibah | ' . APP_NAME,
            'items' => $items,
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');
        unset($_SESSION['flash']);
    }

    public static function create(): void
    {
        View::render('admin/grant/form', [
            'title' => 'Tambah Hibah | ' . APP_NAME,
            'item' => null,
            'action' => url('admin/index.php?page=hibah-simpan'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');
        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function store(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token tidak valid.', 'error');
            redirect(url('admin/index.php?page=hibah-tambah'));
        }

        $data = self::validateAndSanitize();
        if (isset($data['error'])) {
            $_SESSION['old'] = $_POST;
            self::flash($data['error'], 'error');
            redirect(url('admin/index.php?page=hibah-tambah'));
        }

        Grant::create($data);
        self::flash('Hibah berhasil ditambahkan.');
        redirect(url('admin/index.php?page=hibah'));
    }

    public static function edit(int $id): void
    {
        $item = Grant::find($id);
        if (!$item) {
            redirect(url('admin/index.php?page=hibah'));
        }

        View::render('admin/grant/form', [
            'title' => 'Edit Hibah | ' . APP_NAME,
            'item' => $item,
            'action' => url('admin/index.php?page=hibah-update'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');
        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function update(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token tidak valid.', 'error');
            redirect(url('admin/index.php?page=hibah'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        $data = self::validateAndSanitize();
        
        if (isset($data['error'])) {
            $_SESSION['old'] = $_POST;
            self::flash($data['error'], 'error');
            redirect(url('admin/index.php?page=hibah-edit&id=' . $id));
        }

        Grant::update($id, $data);
        self::flash('Hibah berhasil diperbarui.');
        redirect(url('admin/index.php?page=hibah'));
    }

    public static function destroy(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token tidak valid.', 'error');
            redirect(url('admin/index.php?page=hibah'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        Grant::delete($id);
        self::flash('Hibah berhasil dihapus.');
        redirect(url('admin/index.php?page=hibah'));
    }

    private static function validateAndSanitize(): array
    {
        $title = trim($_POST['title'] ?? '');
        $source = trim($_POST['source'] ?? '');
        $deadline = trim($_POST['deadline'] ?? '');

        if ($title === '' || $source === '' || $deadline === '') {
            return ['error' => 'Judul, Sumber, dan Deadline wajib diisi.'];
        }

        return [
            'title' => $title,
            'source' => $source,
            'type' => $_POST['type'] ?? 'penelitian',
            'deadline' => $deadline,
            'funding_amount' => trim($_POST['funding_amount'] ?? ''),
            'status' => $_POST['status'] ?? 'open',
            'description' => trim($_POST['description'] ?? ''),
            'link_proposal' => trim($_POST['link_proposal'] ?? ''),
            'link_registration' => trim($_POST['link_registration'] ?? ''),
        ];
    }

    private static function flash(string $message, string $type = 'success'): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}