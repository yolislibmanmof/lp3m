<?php

declare(strict_types=1);

class AdminReport
{
    private static function guard(): void
    {
        if ((Auth::user()['role'] ?? '') !== 'super_admin') {
            self::flash('error', 'Akses ditolak — laporan khusus Super Admin.');
            redirect(url('admin/index.php?page=dashboard'));
        }
    }

    public static function index(): void
    {
        self::guard();
        $start = $_GET['start'] ?? date('Y-m-01');
        $end = $_GET['end'] ?? date('Y-m-d');
        $summary = Report::summary($start, $end);
        View::render('admin/reports/index', [
            'title' => 'Laporan & Export | ' . APP_NAME,
            'summary' => $summary,
            'start' => $start,
            'end' => $end,
            'modules' => Report::MODULES,
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function module(string $modul, ?string $start = null, ?string $end = null): void
    {
        self::guard();
        $info = Report::moduleInfo($modul);
        $monthly = Report::monthlyTrend($modul);
        $yearly = Report::yearlyTrend($modul);
        $data = Report::raw($modul, $start, $end);
        View::render('admin/reports/module', [
            'title' => $info['label'] . ' | Laporan | ' . APP_NAME,
            'modul' => $modul,
            'info' => $info,
            'monthly' => $monthly,
            'yearly' => $yearly,
            'data' => $data,
            'start' => $start,
            'end' => $end,
        ], 'layouts/admin');
    }

    public static function exportCsv(string $modul, ?string $start = null, ?string $end = null): void
    {
        self::guard();
        $info = Report::moduleInfo($modul);
        $data = Report::raw($modul, $start, $end);
        $filename = 'laporan-' . $modul . '-' . date('Ymd-His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
        if (!empty($data)) {
            fputcsv($out, array_keys($data[0]));
            foreach ($data as $row) fputcsv($out, $row);
        }
        fclose($out);
        exit;
    }

public static function printView(?string $start = null, ?string $end = null): void
{
    self::guard();
    $summary = Report::summary($start, $end);
    $title   = 'Laporan Cetak | ' . APP_NAME;
    $modules = Report::MODULES;

    // Render view tanpa melalui View::render (karena ini standalone HTML)
    $viewFile = BASE_PATH . '/resources/views/admin/reports/print.php';
    if (!is_file($viewFile)) {
        http_response_code(404);
        echo 'View file not found.';
        return;
    }

    ob_start();
    extract([
        'title'   => $title,
        'summary' => $summary,
        'start'   => $start,
        'end'     => $end,
        'modules' => $modules,
    ]);
    require $viewFile;
    echo ob_get_clean();
}

    public static function annualReport(int $year): void
    {
        self::guard();
        $report = Report::annual($year);
        View::render('admin/reports/annual', [
            'title' => 'Laporan Tahunan ' . $year . ' | ' . APP_NAME,
            'report' => $report,
            'modules' => Report::MODULES,
        ], 'layouts/admin');
    }

        /**
     * 🚀 FITUR BARU: Export Laporan Kinerja Tahunan per Fakultas/Institusi
     */
    public static function exportAnnual(): void
    {
        self::guard(); // Hanya super_admin yang diizinkan (sudah dihandle oleh guard)

        $year = (int) ($_GET['year'] ?? date('Y'));
        $pdo = Database::pdo();

        // Query Agregasi Kinerja per Fakultas/Institusi
        // Catatan: researches & community_services menggunakan 'leader' (nama), publications menggunakan 'user_id'
        $sql = "
            SELECT 
                u.institution AS fakultas,
                COUNT(DISTINCT r.id) AS total_penelitian,
                COALESCE(SUM(r.funding), 0) AS total_dana_penelitian,
                COUNT(DISTINCT p.id) AS total_publikasi,
                COUNT(DISTINCT cs.id) AS total_pengabdian
            FROM users u
            LEFT JOIN researches r ON u.name = r.leader AND r.year = ?
            LEFT JOIN publications p ON u.id = p.user_id AND p.year = ?
            LEFT JOIN community_services cs ON u.name = cs.leader AND cs.year = ?
            WHERE u.role IN ('dosen', 'reviewer', 'pimpinan') 
              AND u.institution IS NOT NULL 
              AND u.institution != ''
            GROUP BY u.institution
            ORDER BY total_penelitian DESC
        ";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$year, $year, $year]);
        $data = $stmt->fetchAll();

        // Generate File CSV (Excel-Ready dengan UTF-8 BOM)
        $filename = 'Laporan_Kinerja_LP3M_Tahun_' . $year . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $out = fopen('php://output', 'w');
        
        // UTF-8 BOM agar Excel membaca karakter Indonesia (é, á, dll) dengan benar
        fwrite($out, "\xEF\xBB\xBF"); 
        
        // Header Kolom
        fputcsv($out, [
            'No', 
            'Fakultas / Institusi', 
            'Jumlah Penelitian', 
            'Total Dana Penelitian (Rp)', 
            'Jumlah Publikasi', 
            'Jumlah Pengabdian'
        ]);

        // Isi Data
        $no = 1;
        foreach ($data as $row) {
            fputcsv($out, [
                $no++,
                $row['fakultas'],
                $row['total_penelitian'],
                number_format($row['total_dana_penelitian'], 0, ',', '.'),
                $row['total_publikasi'],
                $row['total_pengabdian']
            ]);
        }
        
        fclose($out);
        exit;
    }

    private static function flash(string $t, string $m): void { $_SESSION['flash'] = ['type' => $t, 'message' => $m]; }
    private static function getFlash() { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
}