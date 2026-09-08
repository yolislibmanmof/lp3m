<?php

declare(strict_types=1);

class AdminDocuments
{
    private const ALLOWED_EXT = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

    public static function index(): void
    {
        $filters = [
            'q' => trim($_GET['q'] ?? ''),
            'category' => $_GET['category'] ?? '',
            'status' => $_GET['status'] ?? '',
        ];

        $page = max(1, (int) ($_GET['hal'] ?? 1));
        $data = Document::paginate($filters, $page, 10);

        View::render('admin/documents/index', [
            'title' => 'Manajemen Dokumen | ' . APP_NAME,
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
        View::render('admin/documents/form', [
            'title' => 'Tambah Dokumen | ' . APP_NAME,
            'item' => null,
            'action' => url('admin/index.php?page=dokumen-simpan'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/index.php?page=dokumen'));
        }

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token keamanan tidak valid.', 'error');
            redirect(url('admin/index.php?page=dokumen-tambah'));
        }

        $title = trim($_POST['title'] ?? '');
        $category = $_POST['category'] ?? 'template';
        $description = trim($_POST['description'] ?? '');
        $status = ($_POST['status'] ?? 'published') === 'draft' ? 'draft' : 'published';

        $errors = [];

        if ($title === '') $errors[] = 'Judul dokumen wajib diisi.';
        if (!in_array($category, Document::CATEGORIES, true)) $errors[] = 'Kategori tidak valid.';

        if (empty($_FILES['file']['name'])) {
            $errors[] = 'File wajib diunggah.';
        }

        $filePath = null;
        $fileType = '';
        $fileSize = 0;

        if ($errors === []) {
            $up = Upload::file($_FILES['file'], 'documents', 10485760, self::ALLOWED_EXT, 'storage');

            if ($up['ok']) {
                $filePath = $up['path'];
                $fileType = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
                $fileSize = (int) $_FILES['file']['size'];
            } else {
                $errors[] = $up['error'];
            }
        }

        if ($errors !== []) {
            $_SESSION['old'] = $_POST;
            self::flash(implode(' ', $errors), 'error');
            redirect(url('admin/index.php?page=dokumen-tambah'));
        }

        Document::create([
            'title' => $title,
            'category' => $category,
            'description' => $description,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'status' => $status,
            'user_id' => Auth::user()['id'] ?? null,
        ]);

        self::flash('Dokumen berhasil disimpan.');
        redirect(url('admin/index.php?page=dokumen'));
    }

    public static function edit(int $id): void
    {
        $item = Document::find($id);

        if ($item === null) {
            redirect(url('admin/index.php?page=dokumen'));
        }

        View::render('admin/documents/form', [
            'title' => 'Edit Dokumen | ' . APP_NAME,
            'item' => $item,
            'action' => url('admin/index.php?page=dokumen-update'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/index.php?page=dokumen'));
        }

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token keamanan tidak valid.', 'error');
            redirect(url('admin/index.php?page=dokumen'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        $item = Document::find($id);

        if ($item === null) {
            redirect(url('admin/index.php?page=dokumen'));
        }

        $title = trim($_POST['title'] ?? '');
        $category = $_POST['category'] ?? 'template';
        $description = trim($_POST['description'] ?? '');
        $status = ($_POST['status'] ?? 'published') === 'draft' ? 'draft' : 'published';

        $errors = [];

        if ($title === '') $errors[] = 'Judul dokumen wajib diisi.';
        if (!in_array($category, Document::CATEGORIES, true)) $errors[] = 'Kategori tidak valid.';

        $filePath = $item['file_path'];
        $fileType = $item['file_type'];
        $fileSize = (int) $item['file_size'];

        if (!empty($_FILES['file']['name'])) {
            $up = Upload::file($_FILES['file'], 'documents', 10485760, self::ALLOWED_EXT, 'storage');

            if ($up['ok']) {
                Upload::remove($item['file_path'], 'storage');
                $filePath = $up['path'];
                $fileType = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
                $fileSize = (int) $_FILES['file']['size'];
            } else {
                $errors[] = $up['error'];
            }
        }

        if ($errors !== []) {
            $_SESSION['old'] = $_POST;
            self::flash(implode(' ', $errors), 'error');
            redirect(url('admin/index.php?page=dokumen-edit&id=' . $id));
        }

        Document::update($id, [
            'title' => $title,
            'category' => $category,
            'description' => $description,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'status' => $status,
        ]);

        self::flash('Dokumen berhasil diperbarui.');
        redirect(url('admin/index.php?page=dokumen'));
    }

    public static function destroy(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/index.php?page=dokumen'));
        }

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token keamanan tidak valid.', 'error');
            redirect(url('admin/index.php?page=dokumen'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        $item = Document::find($id);

        if ($item !== null) {
            Upload::remove($item['file_path'], 'storage');
            Document::delete($id);
            self::flash('Dokumen berhasil dihapus.');
        }

        redirect(url('admin/index.php?page=dokumen'));
    }

    private static function flash(string $message, string $type = 'success'): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}