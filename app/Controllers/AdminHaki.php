<?php

declare(strict_types=1);

class AdminHaki
{
    public static function index(): void
    {
        $filters = [
            'q' => trim($_GET['q'] ?? ''),
            'type' => $_GET['type'] ?? '',
            'status' => $_GET['status'] ?? '',
        ];

        $data = IntellectualProperty::paginate(
            ['status' => $filters['status'], 'type' => $filters['type']],
            $filters['q'],
            ['title', 'inventors'],
            max(1, (int) ($_GET['hal'] ?? 1)),
            10,
            'year DESC, created_at DESC'
        );

        View::render('admin/haki/index', [
            'title' => 'HAKI | ' . APP_NAME,
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
        View::render('admin/haki/form', [
            'title' => 'Tambah HAKI | ' . APP_NAME,
            'item' => null,
            'action' => url('admin/index.php?page=haki-simpan'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Csrf::verify($_POST['_csrf'] ?? null)) {
            redirect(url('admin/index.php?page=haki'));
        }

        $errors = self::validate();

        if ($errors !== []) {
            $_SESSION['old'] = $_POST;
            self::flash(implode(' ', $errors), 'error');
            redirect(url('admin/index.php?page=haki-tambah'));
        }

        IntellectualProperty::create(self::data());
        self::flash('HAKI berhasil disimpan.');
        redirect(url('admin/index.php?page=haki'));
    }

    public static function edit(int $id): void
    {
        $item = IntellectualProperty::find($id);

        if ($item === null) {
            redirect(url('admin/index.php?page=haki'));
        }

        View::render('admin/haki/form', [
            'title' => 'Edit HAKI | ' . APP_NAME,
            'item' => $item,
            'action' => url('admin/index.php?page=haki-update'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Csrf::verify($_POST['_csrf'] ?? null)) {
            redirect(url('admin/index.php?page=haki'));
        }

        $id = (int) ($_POST['id'] ?? 0);

        if (IntellectualProperty::find($id) === null) {
            redirect(url('admin/index.php?page=haki'));
        }

        $errors = self::validate();

        if ($errors !== []) {
            $_SESSION['old'] = $_POST;
            self::flash(implode(' ', $errors), 'error');
            redirect(url('admin/index.php?page=haki-edit&id=' . $id));
        }

        IntellectualProperty::update($id, self::data());
        self::flash('HAKI berhasil diperbarui.');
        redirect(url('admin/index.php?page=haki'));
    }

    public static function destroy(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Csrf::verify($_POST['_csrf'] ?? null)) {
            redirect(url('admin/index.php?page=haki'));
        }

        $id = (int) ($_POST['id'] ?? 0);

        if (IntellectualProperty::find($id) !== null) {
            IntellectualProperty::delete($id);
            self::flash('HAKI berhasil dihapus.');
        }

        redirect(url('admin/index.php?page=haki'));
    }

    private static function validate(): array
    {
        $errors = [];

        if (trim($_POST['title'] ?? '') === '') $errors[] = 'Judul wajib diisi.';
        if (trim($_POST['inventors'] ?? '') === '') $errors[] = 'Inventor/pencipta wajib diisi.';
        if (!array_key_exists($_POST['type'] ?? '', IntellectualProperty::TYPES)) $errors[] = 'Jenis tidak valid.';
        if (!array_key_exists($_POST['status'] ?? '', IntellectualProperty::STATUSES)) $errors[] = 'Status tidak valid.';

        $year = (int) ($_POST['year'] ?? 0);
        if ($year < 2000 || $year > 2100) $errors[] = 'Tahun tidak valid.';

        return $errors;
    }

    private static function data(): array
    {
        return [
            'title' => trim($_POST['title'] ?? ''),
            'type' => $_POST['type'],
            'inventors' => trim($_POST['inventors'] ?? ''),
            'registration_number' => trim($_POST['registration_number'] ?? ''),
            'status' => $_POST['status'],
            'year' => (int) ($_POST['year'] ?? date('Y')),
            'description' => trim($_POST['description'] ?? ''),
            'user_id' => Auth::user()['id'] ?? null,
        ];
    }

    private static function flash(string $message, string $type = 'success'): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}