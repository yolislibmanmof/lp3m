<?php

declare(strict_types=1);

class AdminGallery
{
    /**
     * Konvensi path:
     * - File fisik disimpan di: public/uploads/gallery/nama.jpg
     * - Nilai di DB disimpan:  gallery/nama.jpg (relatif terhadap public/uploads/)
     * - URL tampil pakai:      upload_url('gallery/nama.jpg')
     */
    private const UPLOAD_DIR  = BASE_PATH . '/public/uploads/gallery/';
    private const DB_PREFIX   = 'gallery/';
    private const ALLOWED_EXT  = ['jpg', 'jpeg', 'png', 'webp'];
    private const ALLOWED_MIME = ['image/jpeg', 'image/png', 'image/webp'];
    private const MAX_SIZE     = 5 * 1024 * 1024; // 5 MB

    private static function guard(): void
    {
        $role = Auth::user()['role'] ?? '';
        if (!in_array($role, ['super_admin', 'admin_lp3m'], true)) {
            self::flash('Akses ditolak — modul galeri khusus admin.', 'error');
            redirect(url('admin/index.php?page=dashboard'));
        }
    }

    public static function index(): void
    {
        self::guard();
        View::render('admin/gallery/index', [
            'title' => 'Galeri Kegiatan | ' . APP_NAME,
            'items' => Gallery::all(),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function create(): void
    {
        self::guard();
        View::render('admin/gallery/form', [
            'title'  => 'Tambah Foto | ' . APP_NAME,
            'item'   => null,
            'action' => url('admin/index.php?page=galeri-simpan'),
            'flash'  => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function store(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token keamanan tidak valid.', 'error');
            redirect(url('admin/index.php?page=galeri-tambah'));
        }

        $data = self::validate();
        if (isset($data['error'])) {
            self::flash($data['error'], 'error');
            redirect(url('admin/index.php?page=galeri-tambah'));
        }

        $path = self::handleUpload(true);
        if (is_array($path)) {
            self::flash($path['error'], 'error');
            redirect(url('admin/index.php?page=galeri-tambah'));
        }

        $data['image_path'] = $path;
        Gallery::create($data);

        AuditLog::log('create', [
            'entity_type'  => 'galleries',
            'entity_label' => $data['title'],
        ]);

        self::flash('Foto "' . $data['title'] . '" berhasil ditambahkan.');
        redirect(url('admin/index.php?page=galeri'));
    }

    public static function edit(int $id): void
    {
        self::guard();
        $item = Gallery::find($id);
        if (!$item) redirect(url('admin/index.php?page=galeri'));

        View::render('admin/gallery/form', [
            'title'  => 'Edit Foto | ' . APP_NAME,
            'item'   => $item,
            'action' => url('admin/index.php?page=galeri-update'),
            'flash'  => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function update(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token keamanan tidak valid.', 'error');
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
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $path = self::handleUpload(true);
            if (is_array($path)) {
                self::flash($path['error'], 'error');
                redirect(url('admin/index.php?page=galeri-edit&id=' . $id));
            }
            // Hapus file lama (path DB tanpa prefix uploads/)
            self::deleteFile($old['image_path'] ?? '');
            $data['image_path'] = $path;
        } else {
            $data['image_path'] = $old['image_path'];
        }

        Gallery::update($id, $data);

        AuditLog::log('update', [
            'entity_type'  => 'galleries',
            'entity_id'    => $id,
            'entity_label' => $data['title'],
        ]);

        self::flash('Foto "' . $data['title'] . '" berhasil diperbarui.');
        redirect(url('admin/index.php?page=galeri'));
    }

    public static function destroy(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token keamanan tidak valid.', 'error');
            redirect(url('admin/index.php?page=galeri'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        $item = Gallery::find($id);
        if ($item) {
            self::deleteFile($item['image_path'] ?? '');
            Gallery::delete($id);

            AuditLog::log('delete', [
                'entity_type'  => 'galleries',
                'entity_id'    => $id,
                'entity_label' => $item['title'] ?? '',
            ]);
        }

        self::flash('Foto berhasil dihapus.');
        redirect(url('admin/index.php?page=galeri'));
    }

    // ══════════════════════════════════════════════════════
    // INTERNAL
    // ══════════════════════════════════════════════════════

    private static function validate(): array
    {
        $title = trim($_POST['title'] ?? '');
        if ($title === '') return ['error' => 'Judul wajib diisi.'];

        $eventDate = trim($_POST['event_date'] ?? '');
        if ($eventDate !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $eventDate)) {
            $eventDate = '';
        }

        return [
            'title'       => $title,
            'category'    => trim($_POST['category'] ?? '') ?: 'Kegiatan',
            'description' => trim($_POST['description'] ?? ''),
            'event_date'  => $eventDate !== '' ? $eventDate : null,
        ];
    }

    /**
     * Handle upload file gambar.
     * @param bool $required true = wajib ada file, false = boleh kosong
     * @return string|array  string (path DB "gallery/xxx.jpg") atau ['error'=>...]
     */
    private static function handleUpload(bool $required = true)
    {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
            return $required ? ['error' => 'Silakan pilih gambar terlebih dahulu.'] : null;
        }

        $file = $_FILES['image'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['error' => 'Gagal upload: kode error ' . $file['error']];
        }

        if ($file['size'] > self::MAX_SIZE) {
            return ['error' => 'Ukuran gambar maksimal ' . (self::MAX_SIZE / 1024 / 1024) . ' MB.'];
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, self::ALLOWED_EXT, true)) {
            return ['error' => 'Format harus JPG / PNG / WEBP.'];
        }

        // Validasi MIME asli (cegah rename .exe jadi .jpg)
        try {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file['tmp_name']);
            if (!in_array($mime, self::ALLOWED_MIME, true)) {
                return ['error' => 'Isi file bukan gambar yang valid (MIME: ' . $mime . ').'];
            }
        } catch (\Throwable $e) {
            return ['error' => 'Gagal memvalidasi file.'];
        }

        // Pastikan folder tujuan ada
        if (!is_dir(self::UPLOAD_DIR)) {
            if (!@mkdir(self::UPLOAD_DIR, 0775, true)) {
                return ['error' => 'Gagal membuat folder uploads/gallery. Periksa permission.'];
            }
        }

        $name = 'gal-' . date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
        $target = self::UPLOAD_DIR . $name;

        if (!move_uploaded_file($file['tmp_name'], $target)) {
            return ['error' => 'Gagal menyimpan file ke server. Periksa permission folder public/uploads/gallery/'];
        }

        // Return path DB tanpa prefix "uploads/" — konsisten dengan upload_url()
        return self::DB_PREFIX . $name;
    }

    /** Hapus file fisik berdasarkan path DB (relatif terhadap public/uploads/) */
    private static function deleteFile(string $dbPath): void
    {
        if ($dbPath === '') return;
        $path = ltrim($dbPath, '/');
        // Coba beberapa lokasi (kompatibel dengan data lama yang mungkin pakai prefix uploads/)
        $candidates = [
            'public/uploads/' . $path,
            'public/uploads/gallery/' . basename($path),
            'uploads/' . $path,
            'public/' . $path,
        ];
        foreach ($candidates as $c) {
            $full = BASE_PATH . '/' . $c;
            if (is_file($full)) { @unlink($full); return; }
        }
    }

    private static function flash(string $msg, string $type = 'success'): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $msg];
    }

    private static function getFlash(): ?array
    {
        $f = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $f;
    }
}