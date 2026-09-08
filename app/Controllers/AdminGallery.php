<?php
declare(strict_types=1);

class AdminGallery
{
    private const UPLOAD_DIR = BASE_PATH . '/public/uploads/gallery/';
    private const ALLOWED_EXT = ['jpg', 'jpeg', 'png', 'webp'];
    private const ALLOWED_MIME = ['image/jpeg', 'image/png', 'image/webp'];

    public static function index(): void
    {
        View::render('admin/gallery/index', [
            'title' => 'Galeri Kegiatan | ' . APP_NAME,
            'items' => Gallery::all(),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');
        unset($_SESSION['flash']);
    }

    public static function create(): void
    {
        View::render('admin/gallery/form', [
            'title' => 'Tambah Foto | ' . APP_NAME,
            'item' => null,
            'action' => url('admin/index.php?page=galeri-simpan'),
        ], 'layouts/admin');
    }

    public static function store(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token tidak valid.', 'error');
            redirect(url('admin/index.php?page=galeri-tambah'));
        }

        $data = self::validate();
        if (isset($data['error'])) {
            self::flash($data['error'], 'error');
            redirect(url('admin/index.php?page=galeri-tambah'));
        }

        $path = self::handleUpload();
        if (!is_string($path)) {
            self::flash($path['error'], 'error');
            redirect(url('admin/index.php?page=galeri-tambah'));
        }

        $data['image_path'] = $path;
        Gallery::create($data);
        self::flash('Foto berhasil ditambahkan.');
        redirect(url('admin/index.php?page=galeri'));
    }

    public static function edit(int $id): void
    {
        $item = Gallery::find($id);
        if (!$item) redirect(url('admin/index.php?page=galeri'));

        View::render('admin/gallery/form', [
            'title' => 'Edit Foto | ' . APP_NAME,
            'item' => $item,
            'action' => url('admin/index.php?page=galeri-update'),
        ], 'layouts/admin');
    }

    public static function update(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token tidak valid.', 'error');
            redirect(url('admin/index.php?page=galeri'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        $old = Gallery::find($id);
        if (!$old) redirect(url('admin/index.php?page=galeri'));

        $data = self::validate();
        if (isset($data['error'])) {
            self::flash($data['error'], 'error');
            redirect(url('admin/index.php?page=galeri-edit&id=' . $id));
        }

        // Gambar baru opsional
        if (!empty($_FILES['image']['name'])) {
            $path = self::handleUpload();
            if (!is_string($path)) {
                self::flash($path['error'], 'error');
                redirect(url('admin/index.php?page=galeri-edit&id=' . $id));
            }
            // Hapus file lama
            if (!empty($old['image_path'])) {
                $f = BASE_PATH . '/public/' . ltrim($old['image_path'], '/');
                if (is_file($f)) @unlink($f);
            }
            $data['image_path'] = $path;
        } else {
            $data['image_path'] = $old['image_path'];
        }

        Gallery::update($id, $data);
        self::flash('Foto berhasil diperbarui.');
        redirect(url('admin/index.php?page=galeri'));
    }

    public static function destroy(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token tidak valid.', 'error');
            redirect(url('admin/index.php?page=galeri'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        $item = Gallery::find($id);
        if ($item) {
            if (!empty($item['image_path'])) {
                $f = BASE_PATH . '/public/' . ltrim($item['image_path'], '/');
                if (is_file($f)) @unlink($f);
            }
            Gallery::delete($id);
        }
        self::flash('Foto berhasil dihapus.');
        redirect(url('admin/index.php?page=galeri'));
    }

    private static function validate(): array
    {
        $title = trim($_POST['title'] ?? '');
        if ($title === '') return ['error' => 'Judul wajib diisi.'];

        return [
            'title' => $title,
            'category' => trim($_POST['category'] ?? '') ?: 'Kegiatan',
            'description' => trim($_POST['description'] ?? ''),
            'event_date' => trim($_POST['event_date'] ?? ''),
        ];
    }

    /** @return string|array Path relatif jika sukses, ['error'=>...] jika gagal */
    private static function handleUpload()
    {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return ['error' => 'Silakan pilih gambar terlebih dahulu.'];
        }

        $file = $_FILES['image'];
        if ($file['size'] > 5 * 1024 * 1024) {
            return ['error' => 'Ukuran gambar maksimal 5MB.'];
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, self::ALLOWED_EXT, true)) {
            return ['error' => 'Format harus JPG / PNG / WEBP.'];
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        if (!in_array($mime, self::ALLOWED_MIME, true)) {
            return ['error' => 'Isi file bukan gambar yang valid.'];
        }

        if (!is_dir(self::UPLOAD_DIR)) {
            mkdir(self::UPLOAD_DIR, 0775, true);
        }

        $name = 'gal-' . date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
        if (!move_uploaded_file($file['tmp_name'], self::UPLOAD_DIR . $name)) {
            return ['error' => 'Gagal menyimpan file.'];
        }

        return 'uploads/gallery/' . $name;
    }

    private static function flash(string $msg, string $type = 'success'): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $msg];
    }
}