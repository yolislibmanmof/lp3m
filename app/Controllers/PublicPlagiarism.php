<?php

declare(strict_types=1);

class PublicPlagiarism
{
    public static function index(): void
    {
        $kode = trim($_GET['kode'] ?? '');
        $result = null;
        $sources = [];
        if ($kode !== '') {
            $result = PlagiarismCheck::findByCode($kode);
            if ($result) $sources = PlagiarismCheck::sources((int) $result['id']);
        }
        View::render('public/plagiarism/index', [
            'title' => 'Cek Plagiarisme | ' . APP_NAME,
            'result' => $result, 'sources' => $sources, 'kode' => $kode,
            'stats' => PlagiarismCheck::stats(),
            'flash' => $_SESSION['flash'] ?? null,
        ]);
        unset($_SESSION['flash']);
    }

    public static function submit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect(url('public/index.php?page=cek-plagiat'));
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Token keamanan tidak valid.'];
            redirect(url('public/index.php?page=cek-plagiat'));
        }
        $title = trim($_POST['title'] ?? '');
        $name = trim($_POST['submitter_name'] ?? '');
        $text = trim($_POST['text'] ?? '');
        if ($title === '' || $name === '') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Judul dokumen dan nama penulis wajib diisi.'];
            redirect(url('public/index.php?page=cek-plagiat'));
        }

        $filePath = null; $fileSize = 0;
        $extractMethod = null; $extractPages = 0; $extractChars = 0;
        
        if (!empty($_FILES['document']['name'])) {
            $f = $_FILES['document'];
            $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['txt', 'md', 'pdf', 'docx'], true) || $f['size'] > 10 * 1024 * 1024) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'File harus TXT/MD/PDF/DOCX maks 10 MB.'];
                redirect(url('public/index.php?page=cek-plagiat'));
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

        if ($text === '' && $filePath === null) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Tempel teks dokumen atau unggah file terlebih dahulu.'];
            redirect(url('public/index.php?page=cek-plagiat'));
        }

        $code = PlagiarismCheck::nextCode();
        $id = PlagiarismCheck::create([
            'code' => $code, 'title' => $title, 'submitter_name' => $name,
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
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Analisis selesai. Similaritas: ' . $r['similarity'] . '%'];
        } else {
            $_SESSION['flash'] = ['type' => 'info', 'message' => 'Dokumen PDF/DOCX masuk antrean. Gunakan form "Lengkapi Antrean dengan Teks" di bawah untuk hasil instan.'];
        }
        redirect(url('public/index.php?page=cek-plagiat&kode=' . urlencode($code)));
    }

    public static function completeWithText(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect(url('public/index.php?page=cek-plagiat'));
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Token keamanan tidak valid.'];
            redirect(url('public/index.php?page=cek-plagiat'));
        }
        $code = trim($_POST['kode'] ?? '');
        $text = trim($_POST['text'] ?? '');
        $item = PlagiarismCheck::findByCode($code);
        if (!$item) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Kode tidak ditemukan.'];
            redirect(url('public/index.php?page=cek-plagiat'));
        }
        if ($text === '') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Tempel teks dokumen untuk analisis.'];
            redirect(url('public/index.php?page=cek-plagiat&kode=' . urlencode($code)));
        }
        $r = PlagiarismCheck::analyzeAttached((int) $item['id'], $text);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Analisis selesai. Similaritas: ' . $r['similarity'] . '%'];
        redirect(url('public/index.php?page=cek-plagiat&kode=' . urlencode($code)));
    }
}