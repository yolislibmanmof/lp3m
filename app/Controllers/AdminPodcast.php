<?php

declare(strict_types=1);

class AdminPodcast
{
    private static function guard(): void
    {
        $role = Auth::user()['role'] ?? '';
        if (!in_array($role, ['super_admin', 'admin_lp3m'], true)) {
            self::flash('error', 'Akses ditolak — modul podcast khusus admin.');
            redirect(url('admin/index.php?page=dashboard'));
        }
    }

    // ══════════════════════════════════════════════════════
    // HALAMAN
    // ══════════════════════════════════════════════════════

    public static function index(): void
    {
        self::guard();
        $filters = ['category' => $_GET['category'] ?? '', 'status' => $_GET['status'] ?? ''];
        $q = trim($_GET['q'] ?? '');
        $r = Podcast::paginate($filters, $q, max(1, (int) ($_GET['hal'] ?? 1)), 10);
        View::render('admin/podcasts/index', [
            'title'      => 'Podcast LP3M | ' . APP_NAME,
            'items'      => $r['items'], 'total' => $r['total'], 'page' => $r['page'], 'totalPages' => $r['totalPages'],
            'filters'    => $filters, 'q' => $q,
            'stats'      => Podcast::stats(),
            'categories' => Podcast::CATEGORIES,
            'flash'      => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function create(): void
    {
        self::guard();
        View::render('admin/podcasts/form', [
            'title'      => 'Tambah Podcast | ' . APP_NAME,
            'item'       => null,
            'categories' => Podcast::CATEGORIES,
            'action'     => url('admin/index.php?page=podcast-simpan'),
            'flash'      => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function edit(int $id): void
    {
        self::guard();
        $item = Podcast::find($id);
        if (!$item) { redirect(url('admin/index.php?page=podcast')); }
        View::render('admin/podcasts/form', [
            'title'      => 'Edit Podcast | ' . APP_NAME,
            'item'       => $item,
            'categories' => Podcast::CATEGORIES,
            'action'     => url('admin/index.php?page=podcast-update'),
            'flash'      => self::getFlash(),
        ], 'layouts/admin');
    }

    // ══════════════════════════════════════════════════════
    // AKSI
    // ══════════════════════════════════════════════════════

    public static function store(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=podcast')); }
        $data = self::collect(null);
        if ($data === null) return;
        $data['created_by'] = (int) (Auth::user()['id'] ?? 0);
        $id = Podcast::create($data);
        AuditLog::log('create', ['entity_type' => 'podcasts', 'entity_id' => $id, 'entity_label' => $data['title']]);
        self::flash('success', 'Podcast "' . $data['title'] . '" tersimpan.');
        redirect(url('admin/index.php?page=podcast'));
    }

    public static function update(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=podcast')); }
        $id = (int) ($_POST['id'] ?? 0);
        $item = Podcast::find($id);
        if (!$item) { redirect(url('admin/index.php?page=podcast')); }
        $data = self::collect($item);
        if ($data === null) return;
        Podcast::update($id, $data);
        AuditLog::log('update', ['entity_type' => 'podcasts', 'entity_id' => $id, 'entity_label' => $data['title']]);
        self::flash('success', 'Perubahan podcast disimpan.');
        redirect(url('admin/index.php?page=podcast'));
    }

    public static function destroy(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=podcast')); }
        $id = (int) ($_POST['id'] ?? 0);
        $p = Podcast::find($id);
        Podcast::delete($id);
        AuditLog::log('delete', ['entity_type' => 'podcasts', 'entity_id' => $id, 'entity_label' => $p['title'] ?? null]);
        self::flash('success', 'Podcast dihapus.');
        redirect(url('admin/index.php?page=podcast'));
    }

    public static function toggle(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=podcast')); }
        Podcast::toggleStatus((int) ($_POST['id'] ?? 0));
        self::flash('success', 'Status podcast diubah.');
        redirect(url('admin/index.php?page=podcast'));
    }

    // ══════════════════════════════════════════════════════
    // INTERNAL
    // ══════════════════════════════════════════════════════

    private static function collect(?array $item): ?array
    {
        $back = url('admin/index.php?page=' . ($item ? 'podcast-edit&id=' . $item['id'] : 'podcast-tambah'));

        $title = trim($_POST['title'] ?? '');
        if ($title === '') {
            self::flash('error', 'Judul podcast wajib diisi.'); redirect($back); return null;
        }
        $category = $_POST['category'] ?? 'lainnya';
        if (!array_key_exists($category, Podcast::CATEGORIES)) $category = 'lainnya';
        $status = ($_POST['status'] ?? 'published') === 'draft' ? 'draft' : 'published';

        // Audio: upload ATAU URL eksternal
        $audio = $item['audio_path'] ?? '';
        $up = self::handleUpload($_FILES['audio_file'] ?? null, 'podcast', ['mp3', 'm4a', 'ogg', 'wav'], 100 * 1024 * 1024);
        if ($up !== null) {
            if ($audio && !str_starts_with($audio, 'http')) {
                $old = BASE_PATH . '/public/uploads/' . ltrim($audio, '/');
                if (is_file($old)) @unlink($old);
            }
            $audio = $up;
        } else {
            $ext = trim($_POST['audio_url'] ?? '');
            if ($ext !== '') {
                if ($audio && !str_starts_with($audio, 'http')) {
                    $old = BASE_PATH . '/public/uploads/' . ltrim($audio, '/');
                    if (is_file($old)) @unlink($old);
                }
                $audio = $ext;
            }
        }
        if ($audio === '') {
            self::flash('error', 'Audio wajib diisi: upload file MP3 ATAU isi URL eksternal.'); redirect($back); return null;
        }

        // Cover opsional
        $cover = $item['cover'] ?? null;
        $cUp = self::handleUpload($_FILES['cover_file'] ?? null, 'podcast', ['jpg', 'jpeg', 'png', 'webp'], 2 * 1024 * 1024);
        if ($cUp !== null) {
            if ($cover) {
                $old = BASE_PATH . '/public/uploads/' . ltrim($cover, '/');
                if (is_file($old)) @unlink($old);
            }
            $cover = $cUp;
        }

        return [
            'title'       => $title,
            'episode'     => trim($_POST['episode'] ?? '') ?: null,
            'description' => trim($_POST['description'] ?? ''),
            'category'    => $category,
            'audio_path'  => $audio,
            'cover'       => $cover,
            'duration'    => trim($_POST['duration'] ?? '') ?: null,
            'guest'       => trim($_POST['guest'] ?? '') ?: null,
            'status'      => $status,
        ];
    }

    private static function handleUpload(?array $file, string $subdir, array $exts, int $max): ?string
    {
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return null;
        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) return null;
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $exts, true)) return null;
        if (($file['size'] ?? 0) > $max) return null;
        $dir = BASE_PATH . '/public/uploads/' . $subdir;
        if (!is_dir($dir)) @mkdir($dir, 0775, true);
        $name = $subdir . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $dir . '/' . $name)) return $subdir . '/' . $name;
        return null;
    }

    private static function flash(string $t, string $m): void { $_SESSION['flash'] = ['type' => $t, 'message' => $m]; }
    private static function getFlash() { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
}