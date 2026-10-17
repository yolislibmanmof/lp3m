<?php

declare(strict_types=1);

class AdminCertificate
{
    public static function index(): void
    {
        $filters = [
            'q' => trim($_GET['q'] ?? ''),
            'status' => $_GET['status'] ?? '',
        ];

        $page = max(1, (int) ($_GET['hal'] ?? 1));
        $data = Certificate::paginate($filters, $page, 10);

        View::render('admin/certificates/index', [
            'title' => 'Sertifikat & Verifikasi | ' . APP_NAME,
            'items' => $data['items'],
            'total' => $data['total'],
            'page' => $data['page'],
            'totalPages' => $data['total_pages'],
            'filters' => $filters,
            'types' => Certificate::TYPES,
            'templates' => Certificate::TEMPLATES,
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash']);
    }

    public static function create(): void
    {
        View::render('admin/certificates/form', [
            'title' => 'Terbitkan Sertifikat | ' . APP_NAME,
            'item' => null,
            'types' => Certificate::TYPES,
            'templates' => Certificate::TEMPLATES,
            'action' => url('admin/index.php?page=sertifikat-simpan'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/index.php?page=sertifikat'));
        }

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token keamanan tidak valid.', 'error');
            redirect(url('admin/index.php?page=sertifikat-tambah'));
        }

        $errors = self::validate();

        if ($errors !== []) {
            $_SESSION['old'] = $_POST;
            self::flash(implode(' ', $errors), 'error');
            redirect(url('admin/index.php?page=sertifikat-tambah'));
        }

        // ===== Handle upload signature =====
        $signature = null;
        if (!empty($_FILES['signature']['name'])) {
            $up = Upload::image($_FILES['signature'], 'signatures');
            if ($up['ok']) {
                $signature = $up['path'];
            } else {
                $_SESSION['old'] = $_POST;
                self::flash($up['error'], 'error');
                redirect(url('admin/index.php?page=sertifikat-tambah'));
            }
        }

        // ===== Validasi template =====
        $template = trim($_POST['template'] ?? 'classic');
        if (!array_key_exists($template, Certificate::TEMPLATES)) {
            $template = 'classic';
        }

        // ===== Validasi kode unik =====
        $code = trim($_POST['code'] ?? '');
        if ($code === '') {
            $code = Certificate::nextCode();
        } elseif (Certificate::findByCode($code) !== null) {
            $_SESSION['old'] = $_POST;
            self::flash('Kode sertifikat sudah dipakai. Kosongkan untuk generate otomatis.', 'error');
            redirect(url('admin/index.php?page=sertifikat-tambah'));
        }

        Certificate::create([
            'code' => $code,
            'holder_name' => trim($_POST['holder_name'] ?? ''),
            'holder_identity' => trim($_POST['holder_identity'] ?? '') ?: null,
            'activity_title' => trim($_POST['activity_title'] ?? ''),
            'activity_type' => $_POST['activity_type'] ?? 'pelatihan',
            'issue_date' => $_POST['issue_date'] ?? date('Y-m-d'),
            'signer_name' => trim($_POST['signer_name'] ?? '') ?: 'Kepala LP3M',
            'signer_title' => trim($_POST['signer_title'] ?? '') ?: 'Kepala LP3M/LPPAIK',
            'signer_signature' => $signature,
            'template' => $template,
            'status' => 'valid',
        ]);

        self::flash('Sertifikat berhasil diterbitkan dengan kode ' . $code . '.');
        redirect(url('admin/index.php?page=sertifikat'));
    }

    public static function edit(int $id): void
    {
        $item = Certificate::find($id);

        if ($item === null) {
            redirect(url('admin/index.php?page=sertifikat'));
        }

        View::render('admin/certificates/form', [
            'title' => 'Edit Sertifikat | ' . APP_NAME,
            'item' => $item,
            'types' => Certificate::TYPES,
            'templates' => Certificate::TEMPLATES,
            'action' => url('admin/index.php?page=sertifikat-update'),
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');

        unset($_SESSION['flash'], $_SESSION['old']);
    }

    public static function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/index.php?page=sertifikat'));
        }

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token keamanan tidak valid.', 'error');
            redirect(url('admin/index.php?page=sertifikat'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        $item = Certificate::find($id);

        if ($item === null) {
            redirect(url('admin/index.php?page=sertifikat'));
        }

        $errors = self::validate();

        if ($errors !== []) {
            $_SESSION['old'] = $_POST;
            self::flash(implode(' ', $errors), 'error');
            redirect(url('admin/index.php?page=sertifikat-edit&id=' . $id));
        }

        // ===== Handle signature: preserve / replace / delete =====
        $signature = $item['signer_signature'] ?? null;

        if (!empty($_FILES['signature']['name'])) {
            $up = Upload::image($_FILES['signature'], 'signatures');
            if ($up['ok']) {
                if (!empty($signature)) Upload::remove($signature);
                $signature = $up['path'];
            } else {
                $_SESSION['old'] = $_POST;
                self::flash($up['error'], 'error');
                redirect(url('admin/index.php?page=sertifikat-edit&id=' . $id));
            }
        } elseif (!empty($_POST['remove_signature'])) {
            if (!empty($signature)) Upload::remove($signature);
            $signature = null;
        }

        // ===== Validasi template =====
        $template = trim($_POST['template'] ?? $item['template'] ?? 'classic');
        if (!array_key_exists($template, Certificate::TEMPLATES)) {
            $template = 'classic';
        }

        Certificate::update($id, [
            'holder_name' => trim($_POST['holder_name'] ?? ''),
            'holder_identity' => trim($_POST['holder_identity'] ?? '') ?: null,
            'activity_title' => trim($_POST['activity_title'] ?? ''),
            'activity_type' => $_POST['activity_type'] ?? 'pelatihan',
            'issue_date' => $_POST['issue_date'] ?? date('Y-m-d'),
            'signer_name' => trim($_POST['signer_name'] ?? '') ?: 'Kepala LP3M',
            'signer_title' => trim($_POST['signer_title'] ?? '') ?: 'Kepala LP3M/LPPAIK',
            'signer_signature' => $signature,
            'template' => $template,
        ]);

        self::flash('Sertifikat berhasil diperbarui.');
        redirect(url('admin/index.php?page=sertifikat'));
    }

    public static function revoke(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/index.php?page=sertifikat'));
        }

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token keamanan tidak valid.', 'error');
            redirect(url('admin/index.php?page=sertifikat'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        $reason = trim($_POST['reason'] ?? '') ?: 'Tidak disebutkan';

        Certificate::setStatus($id, 'revoked', $reason);
        self::flash('Sertifikat dicabut dan kini berstatus TIDAK VALID.');
        redirect(url('admin/index.php?page=sertifikat'));
    }

    public static function restore(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/index.php?page=sertifikat'));
        }

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token keamanan tidak valid.', 'error');
            redirect(url('admin/index.php?page=sertifikat'));
        }

        $id = (int) ($_POST['id'] ?? 0);

        Certificate::setStatus($id, 'valid', null);
        self::flash('Sertifikat diaktifkan kembali.');
        redirect(url('admin/index.php?page=sertifikat'));
    }

    public static function destroy(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(url('admin/index.php?page=sertifikat'));
        }

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token keamanan tidak valid.', 'error');
            redirect(url('admin/index.php?page=sertifikat'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        $item = Certificate::find($id);

        if ($item !== null) {
            // Cleanup signature file before deleting record
            if (!empty($item['signer_signature'])) {
                Upload::remove($item['signer_signature']);
            }
            Certificate::delete($id);
            self::flash('Sertifikat dihapus permanen.');
        }

        redirect(url('admin/index.php?page=sertifikat'));
    }

    private static function validate(): array
    {
        $errors = [];

        if (trim($_POST['holder_name'] ?? '') === '') $errors[] = 'Nama penerima wajib diisi.';
        if (trim($_POST['activity_title'] ?? '') === '') $errors[] = 'Nama kegiatan wajib diisi.';
        if (empty($_POST['issue_date'])) $errors[] = 'Tanggal terbit wajib diisi.';
        if (!in_array($_POST['activity_type'] ?? '', array_keys(Certificate::TYPES), true)) {
            $errors[] = 'Jenis kegiatan tidak valid.';
        }

        return $errors;
    }

    private static function flash(string $message, string $type = 'success'): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}