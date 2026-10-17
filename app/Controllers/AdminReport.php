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

    private static function flash(string $t, string $m): void { $_SESSION['flash'] = ['type' => $t, 'message' => $m]; }
    private static function getFlash() { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
}