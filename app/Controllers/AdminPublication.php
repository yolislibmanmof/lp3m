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

        // 🛡️ PATCH: IDOR Protection (Cek Kepemilikan)
        $currentUser = Auth::user();
        if ($currentUser['role'] !== 'super_admin' && (int)($item['user_id'] ?? 0) !== (int)$currentUser['id']) {
            self::flash('Anda tidak memiliki izin untuk mengedit publikasi ini.', 'error');
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
        $item = Publication::find($id);

        if ($item === null) {
            redirect(url('admin/index.php?page=publikasi'));
        }

        // 🛡️ PATCH: IDOR Protection (Cek Kepemilikan)
        $currentUser = Auth::user();
        if ($currentUser['role'] !== 'super_admin' && (int)($item['user_id'] ?? 0) !== (int)$currentUser['id']) {
            self::flash('Akses ditolak.', 'error');
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
        $item = Publication::find($id);

        if ($item !== null) {
            // 🛡️ PATCH: IDOR Protection (Cek Kepemilikan)
            $currentUser = Auth::user();
            if ($currentUser['role'] !== 'super_admin' && (int)($item['user_id'] ?? 0) !== (int)$currentUser['id']) {
                self::flash('Akses ditolak.', 'error');
            } else {
                Publication::delete($id);
                self::flash('Publikasi berhasil dihapus.');
            }
        }
        redirect(url('admin/index.php?page=publikasi'));
    }

    // 🌟 PATCH: Fitur Unik Auto-Fetch DOI dari Crossref API
    public static function fetchDoi(): void
    {
        header('Content-Type: application/json');
        $doi = trim($_GET['doi'] ?? $_POST['doi'] ?? '');
        
        if (empty($doi)) {
            echo json_encode(['error' => 'DOI tidak boleh kosong']);
            exit;
        }

        // Bersihkan DOI (hapus URL prefix jika user paste full URL)
        $doi = preg_replace('/^https?:\/\/doi\.org\//i', '', $doi);

        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 5,
                    'header' => "Accept: application/json\r\nUser-Agent: LP3M-UNIMOF/1.0\r\n"
                ]
            ]);
            $url = 'https://api.crossref.org/works/' . urlencode($doi);
            $response = @file_get_contents($url, false, $context);
            
            if ($response === false) {
                echo json_encode(['error' => 'Gagal menghubungi API Crossref. Periksa koneksi.']);
                exit;
            }

            $data = json_decode($response, true);
            
            if (isset($data['message'])) {
                $msg = $data['message'];
                $result = [
                    'title' => $msg['title'][0] ?? '',
                    'authors' => isset($msg['author']) ? implode(', ', array_map(fn($a) => trim(($a['given'] ?? '') . ' ' . ($a['family'] ?? '')), $msg['author'])) : '',
                    'source' => $msg['container-title'][0] ?? ($msg['publisher'] ?? ''),
                    'year' => isset($msg['published']['date-parts'][0][0]) ? (int)$msg['published']['date-parts'][0][0] : date('Y'),
                    'link' => $msg['URL'] ?? ('https://doi.org/' . $doi),
                    'type' => 'jurnal'
                ];
                echo json_encode(['success' => true, 'data' => $result]);
            } else {
                echo json_encode(['error' => 'DOI tidak ditemukan di database Crossref.']);
            }
        } catch (\Throwable $e) {
            echo json_encode(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
        exit;
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