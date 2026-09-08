<?php

declare(strict_types=1);

class AdminPublication
{
    public static function index(): void
    {
        $filters = [
            'q' => trim($_GET['q'] ?? ''),
            'type' => $_GET['type'] ?? '',
            'status' => $_GET['status'] ?? '',
        ];

        $data = Publication::paginate(
            ['status' => $filters['status'], 'type' => $filters['type']],
            $filters['q'],
            ['title', 'authors'],
            max(1, (int) ($_GET['hal'] ?? 1)),
            10,
            'year DESC, created_at DESC'
        );

        View::render('admin/publication/index', [
            'title' => 'Publikasi Ilmiah | ' . APP_NAME,
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
        View::render('admin/publication/form', [
            'title' => 'Tambah Publikasi | ' . APP_NAME,
            'item' => null,
            'action' => url('admin/index.php?page=publikasi-simpan'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Csrf::verify($_POST['_csrf'] ?? null)) {
            redirect(url('admin/index.php?page=publikasi'));
        }

        $errors = self::validate();

        if ($errors !== []) {
            $_SESSION['old'] = $_POST;
            self::flash(implode(' ', $errors), 'error');
            redirect(url('admin/index.php?page=publikasi-tambah'));
        }

        Publication::create(self::data());
        self::flash('Publikasi berhasil disimpan.');
        redirect(url('admin/index.php?page=publikasi'));
    }

    public static function edit(int $id): void
    {
        $item = Publication::find($id);

        if ($item === null) {
            redirect(url('admin/index.php?page=publikasi'));
        }

        View::render('admin/publication/form', [
            'title' => 'Edit Publikasi | ' . APP_NAME,
            'item' => $item,
            'action' => url('admin/index.php?page=publikasi-update'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Csrf::verify($_POST['_csrf'] ?? null)) {
            redirect(url('admin/index.php?page=publikasi'));
        }

        $id = (int) ($_POST['id'] ?? 0);

        if (Publication::find($id) === null) {
            redirect(url('admin/index.php?page=publikasi'));
        }

        $errors = self::validate();

        if ($errors !== []) {
            $_SESSION['old'] = $_POST;
            self::flash(implode(' ', $errors), 'error');
            redirect(url('admin/index.php?page=publikasi-edit&id=' . $id));
        }

        Publication::update($id, self::data());
        self::flash('Publikasi berhasil diperbarui.');
        redirect(url('admin/index.php?page=publikasi'));
    }

    public static function destroy(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Csrf::verify($_POST['_csrf'] ?? null)) {
            redirect(url('admin/index.php?page=publikasi'));
        }

        $id = (int) ($_POST['id'] ?? 0);

        if (Publication::find($id) !== null) {
            Publication::delete($id);
            self::flash('Publikasi berhasil dihapus.');
        }

        redirect(url('admin/index.php?page=publikasi'));
    }

    private static function validate(): array
    {
        $errors = [];

        if (trim($_POST['title'] ?? '') === '') $errors[] = 'Judul wajib diisi.';
        if (trim($_POST['authors'] ?? '') === '') $errors[] = 'Penulis wajib diisi.';
        if (!array_key_exists($_POST['type'] ?? '', Publication::TYPES)) $errors[] = 'Tipe tidak valid.';

        $year = (int) ($_POST['year'] ?? 0);
        if ($year < 2000 || $year > 2100) $errors[] = 'Tahun tidak valid.';

        return $errors;
    }

    private static function data(): array
    {
        return [
            'title' => trim($_POST['title'] ?? ''),
            'type' => $_POST['type'],
            'level' => trim($_POST['level'] ?? 'Nasional'),
            'authors' => trim($_POST['authors'] ?? ''),
            'source' => trim($_POST['source'] ?? ''),
            'year' => (int) ($_POST['year'] ?? date('Y')),
            'link' => trim($_POST['link'] ?? ''),
            'status' => ($_POST['status'] ?? 'published') === 'draft' ? 'draft' : 'published',
            'user_id' => Auth::user()['id'] ?? null,
        ];
    }

    private static function flash(string $message, string $type = 'success'): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}