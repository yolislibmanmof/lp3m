<?php

declare(strict_types=1);

class AdminAik
{
    public static function index(): void
    {
        $filters = [
            'q' => trim($_GET['q'] ?? ''),
            'category' => $_GET['category'] ?? '',
            'status' => $_GET['status'] ?? '',
        ];

        $data = AikActivity::paginate(
            ['status' => $filters['status'], 'category' => $filters['category']],
            $filters['q'],
            ['title', 'location'],
            max(1, (int) ($_GET['hal'] ?? 1)),
            10,
            'activity_date DESC, id DESC'
        );

        View::render('admin/aik/index', [
            'title' => 'AIK & Catur Dharma | ' . APP_NAME,
            'items' => $data['items'],
            'total' => $data['total'],
            'page' => $data['page'],
            'totalPages' => $data['total_pages'],
            'filters' => $filters,
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash']);
    }

    public static function create(): void
    {
        View::render('admin/aik/form', [
            'title' => 'Tambah Kegiatan AIK | ' . APP_NAME,
            'item' => null,
            'action' => url('admin/index.php?page=aik-simpan'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Csrf::verify($_POST['_csrf'] ?? null)) {
            redirect(url('admin/index.php?page=aik'));
        }

        $errors = self::validate();

        if ($errors !== []) {
            $_SESSION['old'] = $_POST;
            self::flash(implode(' ', $errors), 'error');
            redirect(url('admin/index.php?page=aik-tambah'));
        }

        AikActivity::create(self::data());
        self::flash('Kegiatan AIK berhasil disimpan.');
        redirect(url('admin/index.php?page=aik'));
    }

    public static function edit(int $id): void
    {
        $item = AikActivity::find($id);

        if ($item === null) {
            redirect(url('admin/index.php?page=aik'));
        }

        View::render('admin/aik/form', [
            'title' => 'Edit Kegiatan AIK | ' . APP_NAME,
            'item' => $item,
            'action' => url('admin/index.php?page=aik-update'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Csrf::verify($_POST['_csrf'] ?? null)) {
            redirect(url('admin/index.php?page=aik'));
        }

        $id = (int) ($_POST['id'] ?? 0);

        if (AikActivity::find($id) === null) {
            redirect(url('admin/index.php?page=aik'));
        }

        $errors = self::validate();

        if ($errors !== []) {
            $_SESSION['old'] = $_POST;
            self::flash(implode(' ', $errors), 'error');
            redirect(url('admin/index.php?page=aik-edit&id=' . $id));
        }

        AikActivity::update($id, self::data());
        self::flash('Kegiatan AIK berhasil diperbarui.');
        redirect(url('admin/index.php?page=aik'));
    }

    public static function destroy(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Csrf::verify($_POST['_csrf'] ?? null)) {
            redirect(url('admin/index.php?page=aik'));
        }

        $id = (int) ($_POST['id'] ?? 0);

        if (AikActivity::find($id) !== null) {
            AikActivity::delete($id);
            self::flash('Kegiatan AIK berhasil dihapus.');
        }

        redirect(url('admin/index.php?page=aik'));
    }

    private static function validate(): array
    {
        $errors = [];

        if (trim($_POST['title'] ?? '') === '') $errors[] = 'Judul wajib diisi.';
        if (trim($_POST['location'] ?? '') === '') $errors[] = 'Lokasi wajib diisi.';
        if (trim($_POST['activity_date'] ?? '') === '') $errors[] = 'Tanggal wajib diisi.';
        if (!array_key_exists($_POST['category'] ?? '', AikActivity::CATEGORIES)) $errors[] = 'Kategori tidak valid.';

        return $errors;
    }

    private static function data(): array
    {
        return [
            'title' => trim($_POST['title'] ?? ''),
            'category' => $_POST['category'],
            'activity_date' => $_POST['activity_date'],
            'location' => trim($_POST['location'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'status' => ($_POST['status'] ?? 'published') === 'draft' ? 'draft' : 'published',
            'user_id' => Auth::user()['id'] ?? null,
        ];
    }

    private static function flash(string $message, string $type = 'success'): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}