<?php

declare(strict_types=1);

class AdminVideo
{
    private static function guard(): void
    {
        $role = Auth::user()['role'] ?? '';
        if (!in_array($role, ['super_admin', 'admin_lp3m'], true)) {
            self::flash('error', 'Akses ditolak — modul video khusus admin.');
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
        $r = Video::paginate($filters, $q, max(1, (int) ($_GET['hal'] ?? 1)), 10);
        View::render('admin/videos/index', [
            'title'      => 'Galeri Video | ' . APP_NAME,
            'items'      => $r['items'], 'total' => $r['total'], 'page' => $r['page'], 'totalPages' => $r['totalPages'],
            'filters'    => $filters, 'q' => $q,
            'stats'      => Video::stats(),
            'categories' => Video::CATEGORIES,
            'sources'    => Video::SOURCES,
            'flash'      => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function create(): void
    {
        self::guard();
        View::render('admin/videos/form', [
            'title'      => 'Tambah Video | ' . APP_NAME,
            'item'       => null,
            'categories' => Video::CATEGORIES,
            'sources'    => Video::SOURCES,
            'action'     => url('admin/index.php?page=video-simpan'),
            'flash'      => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function edit(int $id): void
    {
        self::guard();
        $item = Video::find($id);
        if (!$item) { redirect(url('admin/index.php?page=video')); }
        View::render('admin/videos/form', [
            'title'      => 'Edit Video | ' . APP_NAME,
            'item'       => $item,
            'categories' => Video::CATEGORIES,
            'sources'    => Video::SOURCES,
            'action'     => url('admin/index.php?page=video-update'),
            'flash'      => self::getFlash(),
        ], 'layouts/admin');
    }

    // ══════════════════════════════════════════════════════
    // AKSI
    // ══════════════════════════════════════════════════════

    public static function store(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=video')); }
        $data = self::collect(null);
        if ($data === null) return;
        $data['created_by'] = (int) (Auth::user()['id'] ?? 0);
        $id = Video::create($data);
        AuditLog::log('create', ['entity_type' => 'videos', 'entity_id' => $id, 'entity_label' => $data['title']]);
        self::flash('success', 'Video "' . $data['title'] . '" tersimpan.');
        redirect(url('admin/index.php?page=video'));
    }

    public static function update(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=video')); }
        $id = (int) ($_POST['id'] ?? 0);
        $item = Video::find($id);
        if (!$item) { redirect(url('admin/index.php?page=video')); }
        $data = self::collect($item);
        if ($data === null) return;
        Video::update($id, $data);
        AuditLog::log('update', ['entity_type' => 'videos', 'entity_id' => $id, 'entity_label' => $data['title']]);
        self::flash('success', 'Perubahan video disimpan.');
        redirect(url('admin/index.php?page=video'));
    }

    public static function destroy(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=video')); }
        $id = (int) ($_POST['id'] ?? 0);
        $v = Video::find($id);
        Video::delete($id);
        AuditLog::log('delete', ['entity_type' => 'videos', 'entity_id' => $id, 'entity_label' => $v['title'] ?? null]);
        self::flash('success', 'Video dihapus.');
        redirect(url('admin/index.php?page=video'));
    }

    public static function toggle(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=video')); }
        Video::toggleStatus((int) ($_POST['id'] ?? 0));
        self::flash('success', 'Status video diubah.');
        redirect(url('admin/index.php?page=video'));
    }

    // ══════════════════════════════════════════════════════
    // INTERNAL
    // ══════════════════════════════════════════════════════

    /** Kumpulkan & validasi input; return array data atau null (sudah flash+redirect) */
    private static function collect(?array $item): ?array
    {
        $back = url('admin/index.php?page=' . ($item ? 'video-edit&id=' . $item['id'] : 'video-tambah'));

        $title = trim($_POST['title'] ?? '');
        if ($title === '') {
            self::flash('error', 'Judul video wajib diisi.'); redirect($back); return null;
        }
        $category = $_POST['category'] ?? 'lainnya';
        if (!array_key_exists($category, Video::CATEGORIES)) $category = 'lainnya';
        $source = $_POST['source'] ?? 'youtube';
        if (!array_key_exists($source, Video::SOURCES)) $source = 'youtube';
        $status = ($_POST['status'] ?? 'published') === 'draft' ? 'draft' : 'published';
        $duration = trim($_POST['duration'] ?? '');
        $description = trim($_POST['description'] ?? '');

        $youtubeId = $item['youtube_id'] ?? null;
        $videoUrl  = $item['video_url'] ?? null;

        if ($source === 'youtube') {
            $raw = trim($_POST['youtube_url'] ?? '');
            if ($raw !== '') {
                $youtubeId = Video::extractYoutubeId($raw) ?: null;
                if ($youtubeId === null) {
                    self::flash('error', 'URL/ID YouTube tidak valid. Contoh: https://youtu.be/dQw4w9WgXcQ'); redirect($back); return null;
                }
            }
            if ($youtubeId === null) {
                self::flash('error', 'Sumber YouTube membutuhkan URL atau ID video.'); redirect($back); return null;
            }
            $videoUrl = null;
        } elseif ($source === 'vimeo') {
            $u = trim($_POST['video_url'] ?? '');
            if ($u !== '') $videoUrl = $u;
            if (!$videoUrl) {
                self::flash('error', 'Sumber Vimeo membutuhkan URL video.'); redirect($back); return null;
            }
            $youtubeId = null;
        } else { // mp4
            $up = self::handleUpload($_FILES['video_file'] ?? null, 'video', ['mp4', 'webm'], 200 * 1024 * 1024);
            if ($up !== null) {
                if ($videoUrl && !str_starts_with($videoUrl, 'http')) {
                    $old = BASE_PATH . '/public/uploads/' . ltrim($videoUrl, '/');
                    if (is_file($old)) @unlink($old);
                }
                $videoUrl = $up;
            } else {
                $ext = trim($_POST['video_url'] ?? '');
                if ($ext !== '') $videoUrl = $ext;
            }
            if (!$videoUrl) {
                self::flash('error', 'Sumber MP4: unggah file video ATAU isi URL video eksternal.'); redirect($back); return null;
            }
            $youtubeId = null;
        }

        // Thumbnail opsional
        $thumb = $item['thumbnail'] ?? null;
        $tUp = self::handleUpload($_FILES['thumb_file'] ?? null, 'video', ['jpg', 'jpeg', 'png', 'webp'], 2 * 1024 * 1024);
        if ($tUp !== null) {
            if ($thumb) {
                $old = BASE_PATH . '/public/uploads/' . ltrim($thumb, '/');
                if (is_file($old)) @unlink($old);
            }
            $thumb = $tUp;
        }

        return [
            'title' => $title, 'description' => $description, 'category' => $category,
            'source' => $source, 'youtube_id' => $youtubeId, 'video_url' => $videoUrl,
            'thumbnail' => $thumb, 'duration' => $duration !== '' ? $duration : null, 'status' => $status,
        ];
    }

    /** Upload file ke public/uploads/{subdir}; return path relatif atau null */
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