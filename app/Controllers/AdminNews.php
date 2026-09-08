<?php

declare(strict_types=1);

class AdminNews
{
    public static function index(): void
    {
        $filters = [
            'q' => trim($_GET['q'] ?? ''),
            'category' => $_GET['category'] ?? '',
            'status' => $_GET['status'] ?? '',
            'featured' => $_GET['featured'] ?? '',
        ];

        $page = max(1, (int) ($_GET['hal'] ?? 1));
        $data = News::paginate($filters, $page, 10);

        View::render('admin/news/index', [
            'title' => 'Manajemen Berita | ' . APP_NAME,
            'items' => $data['items'],
            'total' => $data['total'],
            'page' => $data['page'],
            'totalPages' => $data['total_pages'],
            'filters' => $filters,
            'categories' => News::CATEGORIES,
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash']);
    }

    public static function create(): void
    {
        View::render('admin/news/form', [
            'title' => 'Tambah Berita | ' . APP_NAME,
            'item' => null,
            'itemTags' => null,
            'categories' => News::CATEGORIES,
            'action' => url('admin/index.php?page=berita-simpan'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/index.php?page=berita'));
        }

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token keamanan tidak valid.', 'error');
            redirect(url('admin/index.php?page=berita-tambah'));
        }

        $title = trim($_POST['title'] ?? '');
        $category = $_POST['category'] ?? 'umum';
        $content = trim($_POST['content'] ?? '');
        $status = ($_POST['status'] ?? 'draft') === 'published' ? 'published' : 'draft';
        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;

        $errors = [];

        if ($title === '') $errors[] = 'Judul wajib diisi.';
        if ($content === '') $errors[] = 'Isi berita wajib diisi.';
        if (!in_array($category, News::CATEGORIES, true)) $errors[] = 'Kategori tidak valid.';

        $thumbnail = null;

        if (!empty($_FILES['thumbnail']['name'])) {
            $up = Upload::image($_FILES['thumbnail'], 'news');

            if ($up['ok']) {
                $thumbnail = $up['path'];
            } else {
                $errors[] = $up['error'];
            }
        }

        if ($errors !== []) {
            $_SESSION['old'] = $_POST;
            self::flash(implode(' ', $errors), 'error');
            redirect(url('admin/index.php?page=berita-tambah'));
        }

        $newsId = News::create([
            'title' => $title,
            'slug' => News::uniqueSlug($title),
            'category' => $category,
            'content' => $content,
            'thumbnail' => $thumbnail,
            'status' => $status,
            'is_featured' => $isFeatured,
            'published_at' => $status === 'published' ? date('Y-m-d H:i:s') : null,
            'user_id' => Auth::user()['id'] ?? null,
        ]);

        // Sinkronisasi tags (BARU)
        Tag::syncForNews($newsId, Tag::parse($_POST['tags'] ?? ''));

        self::flash('Berita berhasil disimpan.');
        redirect(url('admin/index.php?page=berita'));
    }

    public static function edit(int $id): void
    {
        $item = News::find($id);

        if ($item === null) {
            redirect(url('admin/index.php?page=berita'));
        }

        View::render('admin/news/form', [
            'title' => 'Edit Berita | ' . APP_NAME,
            'item' => $item,
            'itemTags' => implode(', ', array_column(Tag::tagsForNews($id), 'name')),
            'categories' => News::CATEGORIES,
            'action' => url('admin/index.php?page=berita-update'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/index.php?page=berita'));
        }

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token keamanan tidak valid.', 'error');
            redirect(url('admin/index.php?page=berita'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        $item = News::find($id);

        if ($item === null) {
            redirect(url('admin/index.php?page=berita'));
        }

        $title = trim($_POST['title'] ?? '');
        $category = $_POST['category'] ?? 'umum';
        $content = trim($_POST['content'] ?? '');
        $status = ($_POST['status'] ?? 'draft') === 'published' ? 'published' : 'draft';
        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;

        $errors = [];

        if ($title === '') $errors[] = 'Judul wajib diisi.';
        if ($content === '') $errors[] = 'Isi berita wajib diisi.';
        if (!in_array($category, News::CATEGORIES, true)) $errors[] = 'Kategori tidak valid.';

        $thumbnail = $item['thumbnail'];

        if (!empty($_FILES['thumbnail']['name'])) {
            $up = Upload::image($_FILES['thumbnail'], 'news');

            if ($up['ok']) {
                Upload::remove($item['thumbnail']);
                $thumbnail = $up['path'];
            } else {
                $errors[] = $up['error'];
            }
        }

        if ($errors !== []) {
            $_SESSION['old'] = $_POST;
            self::flash(implode(' ', $errors), 'error');
            redirect(url('admin/index.php?page=berita-edit&id=' . $id));
        }

        News::update($id, [
            'title' => $title,
            'slug' => News::uniqueSlug($title, $id),
            'category' => $category,
            'content' => $content,
            'thumbnail' => $thumbnail,
            'status' => $status,
            'is_featured' => $isFeatured,
            'published_at' => $status === 'published'
                ? ($item['published_at'] ?? date('Y-m-d H:i:s'))
                : null,
        ]);

        // Sinkronisasi tags (BARU)
        Tag::syncForNews($id, Tag::parse($_POST['tags'] ?? ''));

        self::flash('Berita berhasil diperbarui.');
        redirect(url('admin/index.php?page=berita'));
    }

    public static function destroy(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/index.php?page=berita'));
        }

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token keamanan tidak valid.', 'error');
            redirect(url('admin/index.php?page=berita'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        $item = News::find($id);

        if ($item !== null) {
            Upload::remove($item['thumbnail']);
            News::delete($id);
            Tag::pruneUnused(); // Hapus tag orphan (BARU)
            self::flash('Berita berhasil dihapus.');
        }

        redirect(url('admin/index.php?page=berita'));
    }

    /** Bulk action: publish / draft / feature / unfeature / delete massal */
    public static function bulk(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/index.php?page=berita'));
        }

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token keamanan tidak valid.', 'error');
            redirect(url('admin/index.php?page=berita'));
        }

        $action = $_POST['bulk_action'] ?? '';
        $ids = array_map('intval', (array) ($_POST['ids'] ?? []));
        $ids = array_values(array_filter($ids, fn($v) => $v > 0));

        if ($ids === []) {
            self::flash('Tidak ada berita yang dipilih.', 'error');
            redirect(url('admin/index.php?page=berita'));
        }

        $n = count($ids);

        switch ($action) {
            case 'publish':
                News::bulkStatus($ids, 'published');
                self::flash("$n berita dipublikasikan.");
                break;

            case 'draft':
                News::bulkStatus($ids, 'draft');
                self::flash("$n berita dijadikan draft.");
                break;

            case 'feature':
                News::bulkFeatured($ids, 1);
                self::flash("$n berita ditandai unggulan. ⭐");
                break;

            case 'unfeature':
                News::bulkFeatured($ids, 0);
                self::flash("$n berita dihapus dari unggulan.");
                break;

            case 'delete':
                foreach ($ids as $id) {
                    $item = News::find($id);
                    if ($item !== null) {
                        Upload::remove($item['thumbnail']);
                        News::delete($id);
                    }
                }
                Tag::pruneUnused(); // Hapus tag orphan (BARU)
                self::flash("$n berita dihapus.");
                break;

            default:
                self::flash('Aksi tidak valid.', 'error');
        }

        redirect(url('admin/index.php?page=berita'));
    }

    private static function flash(string $message, string $type = 'success'): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}