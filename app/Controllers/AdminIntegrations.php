<?php

declare(strict_types=1);

class AdminIntegrations
{
    private static function guard(): void
    {
        $role = Auth::user()['role'] ?? '';
        if (!in_array($role, ['super_admin', 'admin_lp3m'], true)) {
            self::flash('error', 'Akses ditolak — modul integrasi khusus Super Admin & Admin LP3M.');
            redirect(url('admin/index.php?page=dashboard'));
        }
    }

    public static function index(): void
    {
        self::guard();
        View::render('admin/integrations/index', [
            'title' => 'Integrasi Akademik | ' . APP_NAME,
            'stats' => IntegrationsLog::stats(),
            'logs'  => IntegrationsLog::recent(30),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    /** AJAX: preview metadata DOI tanpa menyimpan */
    public static function fetchDoiLive(): void
    {
        self::guard();
        header('Content-Type: application/json; charset=utf-8');
        $doi = trim($_GET['doi'] ?? $_POST['doi'] ?? '');
        if ($doi === '') { echo json_encode(['ok' => false, 'error' => 'DOI kosong.']); return; }
        $meta = IntegrationsDoi::fetch($doi);
        if ($meta === null) { echo json_encode(['ok' => false, 'error' => 'DOI tidak ditemukan di CrossRef atau koneksi gagal.']); return; }
        echo json_encode(['ok' => true, 'meta' => $meta], JSON_UNESCAPED_UNICODE);
    }

    /** POST: fetch DOI lalu simpan sebagai publikasi */
    public static function fetchDoi(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=integrations')); }

        $doi = IntegrationsDoi::normalize(trim($_POST['doi'] ?? ''));
        if ($doi === '') {
            self::flash('error', 'DOI wajib diisi.');
            redirect(url('admin/index.php?page=integrations'));
        }

        $meta = IntegrationsDoi::fetch($doi);
        if ($meta === null) {
            IntegrationsLog::record([
                'provider' => 'crossref_doi', 'action' => 'fetch', 'input_query' => $doi,
                'status' => 'failed', 'message' => 'DOI tidak ditemukan / koneksi gagal.',
            ]);
            self::flash('error', 'Gagal mengambil metadata DOI "' . $doi . '". Periksa koneksi atau kebenaran DOI.');
            redirect(url('admin/index.php?page=integrations'));
        }

        $pdo = Database::pdo();
        $s = $pdo->prepare('SELECT id FROM publications WHERE doi = ? LIMIT 1');
        $s->execute([$doi]);
        $existing = $s->fetch();

        if ($existing) {
            IntegrationsLog::record([
                'provider' => 'crossref_doi', 'action' => 'fetch', 'entity_type' => 'publications',
                'entity_id' => (int) $existing['id'], 'input_query' => $doi,
                'status' => 'partial', 'message' => 'DOI sudah ada di database, tidak diduplikasi.',
            ]);
            self::flash('error', 'Publikasi dengan DOI ini sudah ada (ID #' . $existing['id'] . '). Tidak diduplikasi.');
            redirect(url('admin/index.php?page=integrations'));
        }

        $pdo->prepare(
            'INSERT INTO publications (title, authors, journal, year, volume, issue, page, doi, doi_verified, publisher, status, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?, NOW())'
        )->execute([
            $meta['title'], $meta['authors'], $meta['journal'], $meta['year'],
            $meta['volume'] ?: null, $meta['issue'] ?: null, $meta['page'] ?: null,
            $doi, $meta['publisher'] ?: null, 'published',
        ]);
        $newId = (int) $pdo->lastInsertId();

        IntegrationsLog::record([
            'provider' => 'crossref_doi', 'action' => 'fetch', 'entity_type' => 'publications',
            'entity_id' => $newId, 'input_query' => $doi, 'items_count' => 1,
            'status' => 'success', 'message' => 'Metadata tersimpan: ' . mb_substr($meta['title'], 0, 120),
            'payload' => $meta,
        ]);

        self::flash('success', 'Publikasi baru tersimpan dari DOI: "' . mb_substr($meta['title'], 0, 80) . '"');
        redirect(url('admin/index.php?page=integrations'));
    }

    /** POST: upload CSV export SINTA */
    public static function importSintaCsv(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=integrations')); }

        $file = $_FILES['csvfile'] ?? null;
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            self::flash('error', 'File CSV tidak terunggah dengan benar.');
            redirect(url('admin/index.php?page=integrations'));
        }
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['csv', 'txt'], true)) {
            self::flash('error', 'Format file harus .csv atau .txt');
            redirect(url('admin/index.php?page=integrations'));
        }
        if (($file['size'] ?? 0) > 5 * 1024 * 1024) {
            self::flash('error', 'Ukuran file maksimal 5 MB.');
            redirect(url('admin/index.php?page=integrations'));
        }

        $parsed = IntegrationsSinta::parseCsv($file['tmp_name']);
        if (empty($parsed['rows'])) {
            IntegrationsLog::record([
                'provider' => 'sinta_csv', 'action' => 'import', 'input_query' => $file['name'],
                'status' => 'failed', 'message' => implode(' | ', array_slice($parsed['errors'], 0, 5)) ?: 'Tidak ada baris valid.',
            ]);
            self::flash('error', 'CSV tidak punya baris valid. Pastikan ada kolom judul (title/judul).');
            redirect(url('admin/index.php?page=integrations'));
        }

        $res = IntegrationsSinta::importPublications($parsed['rows']);
        IntegrationsLog::record([
            'provider' => 'sinta_csv', 'action' => 'import', 'input_query' => $file['name'],
            'items_count' => $res['inserted'], 'status' => $res['inserted'] > 0 ? 'success' : 'partial',
            'message' => 'Insert: ' . $res['inserted'] . ', Skip duplikat: ' . $res['skipped'] . ', Baris dibaca: ' . count($parsed['rows']),
        ]);

        self::flash('success', 'Import SINTA selesai: ' . $res['inserted'] . ' publikasi baru, ' . $res['skipped'] . ' dilewati (duplikat).');
        redirect(url('admin/index.php?page=integrations'));
    }

    /** POST: tarik publikasi dari profil Google Scholar */
    public static function fetchScholar(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=integrations')); }

        $url = trim($_POST['scholar_url'] ?? '');
        if ($url === '') {
            self::flash('error', 'URL profil Google Scholar wajib diisi.');
            redirect(url('admin/index.php?page=integrations'));
        }

        $r = IntegrationsScholar::fetch($url, 20);
        if (!$r['ok'] || empty($r['items'])) {
            IntegrationsLog::record([
                'provider' => 'scholar', 'action' => 'scrape', 'input_query' => $url,
                'status' => 'failed', 'message' => $r['error'] ?? 'Tidak ada item ter-parse.',
            ]);
            self::flash('error', $r['error'] ?? 'Gagal mengambil data Scholar (mungkin diblokir Google).');
            redirect(url('admin/index.php?page=integrations'));
        }

        $res = IntegrationsScholar::importItems($r['items']);
        IntegrationsLog::record([
            'provider' => 'scholar', 'action' => 'scrape', 'input_query' => $url,
            'items_count' => $res['inserted'], 'status' => $res['inserted'] > 0 ? 'success' : 'partial',
            'message' => 'Insert: ' . $res['inserted'] . ', Skip: ' . $res['skipped'] . ', Diparse: ' . count($r['items']),
        ]);

        self::flash('success', 'Scholar: ' . $res['inserted'] . ' publikasi baru diimport, ' . $res['skipped'] . ' dilewati.');
        redirect(url('admin/index.php?page=integrations'));
    }

    /** GET: export log integrasi ke CSV */
    public static function exportLog(): void
    {
        self::guard();
        $rows = IntegrationsLog::exportAll();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="integrations-log-' . date('Ymd-His') . '.csv"');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($out, ['ID', 'Waktu', 'Provider', 'Aksi', 'Entitas', 'Entity ID', 'Input', 'Jumlah', 'Status', 'Pesan', 'User ID']);
        foreach ($rows as $r) {
            fputcsv($out, [
                $r['id'], $r['created_at'], $r['provider'], $r['action'],
                $r['entity_type'], $r['entity_id'], $r['input_query'],
                $r['items_count'], $r['status'], $r['message'], $r['user_id'],
            ]);
        }
        fclose($out);
        exit;
    }

    private static function flash(string $t, string $m): void { $_SESSION['flash'] = ['type' => $t, 'message' => $m]; }
    private static function getFlash() { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
}