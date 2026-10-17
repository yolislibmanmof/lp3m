<?php

declare(strict_types=1);

class AdminCommunity
{
    public static function index(): void
    {
        $filters = [
            'q' => trim($_GET['q'] ?? ''),
            'type' => $_GET['type'] ?? '',
            'status' => $_GET['status'] ?? '',
        ];

        $data = CommunityService::paginate(
            ['status' => $filters['status'], 'type' => $filters['type']],
            $filters['q'],
            ['title', 'leader', 'location'],
            max(1, (int) ($_GET['hal'] ?? 1)),
            10
        );

        View::render('admin/community/index', [
            'title' => 'Pengabdian & KKN | ' . APP_NAME,
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
        View::render('admin/community/form', [
            'title' => 'Tambah Pengabdian | ' . APP_NAME,
            'item' => null,
            'action' => url('admin/index.php?page=pengabdian-simpan'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/index.php?page=pengabdian'));
        }

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token tidak valid.', 'error');
            redirect(url('admin/index.php?page=pengabdian-tambah'));
        }

        $errors = self::validate();

        if ($errors !== []) {
            $_SESSION['old'] = $_POST;
            self::flash(implode(' ', $errors), 'error');
            redirect(url('admin/index.php?page=pengabdian-tambah'));
        }

        CommunityService::create(self::data());
        self::flash('Data pengabdian berhasil disimpan.');
        redirect(url('admin/index.php?page=pengabdian'));
    }

    public static function edit(int $id): void
    {
        $item = CommunityService::find($id);

        if ($item === null) {
            redirect(url('admin/index.php?page=pengabdian'));
        }

        View::render('admin/community/form', [
            'title' => 'Edit Pengabdian | ' . APP_NAME,
            'item' => $item,
            'action' => url('admin/index.php?page=pengabdian-update'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/index.php?page=pengabdian'));
        }

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token tidak valid.', 'error');
            redirect(url('admin/index.php?page=pengabdian'));
        }

        $id = (int) ($_POST['id'] ?? 0);

        if (CommunityService::find($id) === null) {
            redirect(url('admin/index.php?page=pengabdian'));
        }

        $errors = self::validate();

        if ($errors !== []) {
            $_SESSION['old'] = $_POST;
            self::flash(implode(' ', $errors), 'error');
            redirect(url('admin/index.php?page=pengabdian-edit&id=' . $id));
        }

        CommunityService::update($id, self::data());
        self::flash('Data pengabdian berhasil diperbarui.');
        redirect(url('admin/index.php?page=pengabdian'));
    }

    public static function destroy(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Csrf::verify($_POST['_csrf'] ?? null)) {
            redirect(url('admin/index.php?page=pengabdian'));
        }

        $id = (int) ($_POST['id'] ?? 0);

        if (CommunityService::find($id) !== null) {
            CommunityService::delete($id);
            self::flash('Data pengabdian berhasil dihapus.');
        }

        redirect(url('admin/index.php?page=pengabdian'));
    }

    private static function validate(): array
    {
        $errors = [];

        if (trim($_POST['title'] ?? '') === '') $errors[] = 'Judul wajib diisi.';
        if (trim($_POST['leader'] ?? '') === '') $errors[] = 'Ketua pelaksana wajib diisi.';
        if (trim($_POST['location'] ?? '') === '') $errors[] = 'Lokasi wajib diisi.';
        if (!array_key_exists($_POST['type'] ?? '', CommunityService::TYPES)) $errors[] = 'Jenis tidak valid.';

        $year = (int) ($_POST['year'] ?? 0);
        if ($year < 2000 || $year > 2100) $errors[] = 'Tahun tidak valid.';

        return $errors;
    }

    private static function data(): array
    {
        return [
            'title' => trim($_POST['title'] ?? ''),
            'type' => $_POST['type'],
            'leader' => trim($_POST['leader'] ?? ''),
            'members' => trim($_POST['members'] ?? ''),
            'location' => trim($_POST['location'] ?? ''),
            'partner' => trim($_POST['partner'] ?? ''),
            'year' => (int) ($_POST['year'] ?? date('Y')),
            'aik_integration' => trim($_POST['aik_integration'] ?? ''),
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