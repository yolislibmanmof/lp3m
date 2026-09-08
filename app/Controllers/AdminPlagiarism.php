<?php

declare(strict_types=1);

class AdminPlagiarism
{
    public static function index(): void
    {
        $filters = ['status' => $_GET['status'] ?? '', 'doc' => $_GET['doc'] ?? ''];
        $q = trim($_GET['q'] ?? '');
        $r = PlagiarismCheck::paginate($filters, $q, max(1, (int) ($_GET['hal'] ?? 1)), 10);
        View::render('admin/plagiarism/index', [
            'title' => 'Cek Plagiat | ' . APP_NAME,
            'items' => $r['items'], 'total' => $r['total'], 'page' => $r['page'], 'totalPages' => $r['totalPages'],
            'filters' => $filters, 'q' => $q,
            'stats' => PlagiarismCheck::stats(),
            'dist' => PlagiarismCheck::distribution(),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function create(): void
    {
        View::render('admin/plagiarism/form', ['title' => 'Submit Cek Plagiat | ' . APP_NAME, 'flash' => self::getFlash()], 'layouts/admin');
    }

    public static function store(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error', 'Token tidak valid.'); redirect(url('admin/index.php?page=plagiarism-tambah')); }
        $title = trim($_POST['title'] ?? '');
        $submitter = trim($_POST['submitter_name'] ?? '');
        $text = trim($_POST['text'] ?? '');
        if ($title === '' || $submitter === '') { self::flash('error', 'Judul dan nama penulis wajib diisi.'); redirect(url('admin/index.php?page=plagiarism-tambah')); }

        $filePath = null; $fileSize = 0;
        $extractMethod = null; $extractPages = 0; $extractChars = 0;
        
        if (!empty($_FILES['document']['name'])) {
            $f = $_FILES['document'];
            $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['txt', 'md', 'pdf', 'docx'], true) || $f['size'] > 10 * 1024 * 1024) {
                self::flash('error', 'File harus TXT/MD/PDF/DOCX maks 10MB.'); redirect(url('admin/index.php?page=plagiarism-tambah'));
            }
            $dir = BASE_PATH . '/public/uploads/plagiarism/';
            if (!is_dir($dir)) @mkdir($dir, 0755, true);
            $filePath = 'uploads/plagiarism/' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            move_uploaded_file($f['tmp_name'], BASE_PATH . '/public/' . $filePath);
            $fileSize = (int) $f['size'];
            
            // ⚡ AUTO-EXTRACT untuk semua format
            if (in_array($ext, ['txt', 'md'], true)) {
                $text = (string) file_get_contents(BASE_PATH . '/public/' . $filePath);
                $extractMethod = 'direct';
                $extractPages = 1;
                $extractChars = strlen($text);
            } else {
                // Coba extract dari PDF/DOCX
                $result = PlagiarismCheck::extractFromFile($filePath, $ext);
                $extractMethod = $result['method'];
                $extractPages = $result['pages'];
                $extractChars = $result['chars'];
                
                if (strlen($result['text']) > 50) {
                    $text = $result['text'];
                }
            }
        }

        if ($text === '' && $filePath === null) { self::flash('error', 'Isi dokumen atau file wajib diisi.'); redirect(url('admin/index.php?page=plagiarism-tambah')); }

        $code = PlagiarismCheck::nextCode();
        $id = PlagiarismCheck::create([
            'code' => $code, 'title' => $title, 'submitter_name' => $submitter,
            'submitter_email' => trim($_POST['submitter_email'] ?? ''),
            'submitter_identity' => trim($_POST['submitter_identity'] ?? ''),
            'document_type' => $_POST['document_type'] ?? 'lainnya',
            'file_path' => $filePath, 'file_size' => $fileSize, 'word_count' => 0,
            'status' => $text !== '' ? 'processing' : 'queued',
            'source_text' => $text !== '' ? mb_substr($text, 0, 200000) : null,
            'extract_method' => $extractMethod,
            'extract_pages' => $extractPages,
            'extract_chars' => $extractChars,
        ]);

        if ($text !== '') {
            $r = PlagiarismCheck::analyze($text);
            PlagiarismCheck::finish($id, $r);
            Notification::push('plagiarism_done', 'Cek plagiat selesai', $title . ' → similaritas ' . $r['similarity'] . '%.', $r['similarity'] >= PlagiarismCheck::THRESHOLD ? 'warning' : 'success', url('admin/index.php?page=plagiarism-lihat&id=' . $id), '🔍');
            self::flash('success', 'Analisis selesai. Similaritas: ' . $r['similarity'] . '%');
        } else {
            Notification::push('plagiarism_queued', 'Dokumen masuk antrean', $title . ' menunggu teks untuk analisis.', 'info', url('admin/index.php?page=plagiarism-lihat&id=' . $id), '⏳');
            self::flash('success', 'Tersimpan sebagai antrean. Buka laporan → klik "⚡ Analisis Sekarang" setelah menempel teks dokumen.');
        }
        redirect(url('admin/index.php?page=plagiarism'));
    }

    public static function show(int $id): void
    {
        $item = PlagiarismCheck::find($id);
        if (!$item) redirect(url('admin/index.php?page=plagiarism'));
        View::render('admin/plagiarism/report', [
            'title' => 'Laporan | ' . APP_NAME,
            'item' => $item,
            'sources' => PlagiarismCheck::sources($id),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function analyzeNow(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=plagiarism')); }
        $id = (int) ($_POST['id'] ?? 0);
        $text = trim($_POST['text'] ?? '');
        if ($text === '') {
            self::flash('error', 'Tempel teks dokumen terlebih dahulu.');
            redirect(url('admin/index.php?page=plagiarism-lihat&id=' . $id));
        }
        $r = PlagiarismCheck::analyzeAttached($id, $text);
        Notification::push('plagiarism_done', 'Cek plagiat selesai', 'Dokumen #' . $id . ' → similaritas ' . $r['similarity'] . '%.', $r['similarity'] >= PlagiarismCheck::THRESHOLD ? 'warning' : 'success', url('admin/index.php?page=plagiarism-lihat&id=' . $id), '🔍');
        self::flash('success', 'Analisis selesai. Similaritas: ' . $r['similarity'] . '%');
        redirect(url('admin/index.php?page=plagiarism-lihat&id=' . $id));
    }

    public static function manualScore(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=plagiarism')); }
        $id = (int) ($_POST['id'] ?? 0);
        PlagiarismCheck::manualScore($id, (float) ($_POST['similarity'] ?? 0), (float) ($_POST['ai'] ?? 0), trim($_POST['note'] ?? ''));
        self::flash('success', 'Skor manual disimpan.');
        redirect(url('admin/index.php?page=plagiarism-lihat&id=' . $id));
    }

    public static function destroy(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=plagiarism')); }
        $id = (int) ($_POST['id'] ?? 0);
        $item = PlagiarismCheck::find($id);
        if ($item && !empty($item['file_path']) && is_file(BASE_PATH . '/public/' . $item['file_path'])) @unlink(BASE_PATH . '/public/' . $item['file_path']);
        PlagiarismCheck::delete($id);
        self::flash('success', 'Data cek plagiat dihapus.');
        redirect(url('admin/index.php?page=plagiarism'));
    }

    public static function recheck(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=plagiarism')); }
        $id = (int) ($_POST['id'] ?? 0);
        $r = PlagiarismCheck::recheck($id);
        if ($r === null) self::flash('error', 'Teks dokumen tidak tersimpan — analisis ulang tidak tersedia.');
        else self::flash('success', 'Analisis ulang selesai. Similaritas: ' . $r['similarity'] . '%');
        redirect(url('admin/index.php?page=plagiarism-lihat&id=' . $id));
    }

    public static function export(): void
    {
        $rows = Database::pdo()->query('SELECT code,title,submitter_name,document_type,similarity_score,unique_score,ai_score,status,created_at FROM plagiarism_checks ORDER BY created_at DESC')->fetchAll();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="laporan-cek-plagiat-' . date('Ymd') . '.csv"');
        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, ['Kode', 'Judul', 'Penulis', 'Jenis', 'Similaritas %', 'Keunikan %', 'AI %', 'Status', 'Tanggal']);
        foreach ($rows as $r) {
            fputcsv($out, [$r['code'], $r['title'], $r['submitter_name'], PlagiarismCheck::DOC_TYPES[$r['document_type']] ?? $r['document_type'], $r['similarity_score'], $r['unique_score'], $r['ai_score'], $r['status'], $r['created_at']]);
        }
        fclose($out);
        exit;
    }

    /** 🔁 Ekstrak ulang file tersimpan tanpa upload ulang, lalu analisis */
    public static function reextract(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=plagiarism')); }
        $id = (int) ($_POST['id'] ?? 0);
        $item = PlagiarismCheck::find($id);
        if (!$item || empty($item['file_path'])) {
            self::flash('error', 'File tersimpan tidak ditemukan.');
            redirect(url('admin/index.php?page=plagiarism-lihat&id=' . $id));
        }

        $ext = strtolower(pathinfo($item['file_path'], PATHINFO_EXTENSION));
        $r = PlagiarismCheck::extractFromFile($item['file_path'], $ext);

        $pdo = Database::pdo();
        $pdo->prepare('UPDATE plagiarism_checks SET extract_method=?, extract_pages=?, extract_chars=? WHERE id=?')
            ->execute([substr((string) $r['method'], 0, 100), (int) $r['pages'], (int) $r['chars'], $id]);

        if (mb_strlen($r['text']) >= 50) {
            $pdo->prepare('UPDATE plagiarism_checks SET source_text=? WHERE id=?')
                ->execute([mb_substr(PlagiarismCheck::sanitizeText($r['text']), 0, 200000), $id]);
            $a = PlagiarismCheck::analyze($r['text']);
            PlagiarismCheck::finish($id, $a);
            self::flash('success', 'Ekstraksi ulang berhasil! Similaritas: ' . $a['similarity'] . '%');
        } else {
            self::flash('error', 'Ekstraksi masih gagal (' . e($r['method']) . '). File kemungkinan scan/gambar atau terenkripsi.');
        }
        redirect(url('admin/index.php?page=plagiarism-lihat&id=' . $id));
    }

    private static function flash(string $t, string $m): void { $_SESSION['flash'] = ['type' => $t, 'message' => $m]; }
    private static function getFlash() { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
}