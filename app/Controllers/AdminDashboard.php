<?php

declare(strict_types=1);

class AdminDashboard
{
    public static function index(): void
    {
        $pdo = Database::pdo();
        $user = Auth::user() ?? [];
        $uid = (int) ($user['id'] ?? 0);

        $count = function (string $table, string $where = '') use ($pdo): int {
            return (int) $pdo->query("SELECT COUNT(*) FROM $table" . ($where !== '' ? " WHERE $where" : ''))->fetchColumn();
        };

        /* ===== KPI SEMUA MODUL ===== */
        $kpis = [
            ['label' => 'Berita',       'icon' => '📰', 'count' => $count('news'),                      'link' => 'berita',     'rgb' => '217,164,65'],
            ['label' => 'Dokumen',      'icon' => '📁', 'count' => $count('documents'),                 'link' => 'dokumen',    'rgb' => '217,164,65'],
            ['label' => 'Penelitian',   'icon' => '🔬', 'count' => $count('researches'),                'link' => 'penelitian', 'rgb' => '59,130,246'],
            ['label' => 'Pengabdian',   'icon' => '🤝', 'count' => $count('community_services'),        'link' => 'pengabdian', 'rgb' => '16,185,129'],
            ['label' => 'Publikasi',    'icon' => '📚', 'count' => $count('publications'),               'link' => 'publikasi',  'rgb' => '16,185,129'],
            ['label' => 'HAKI',         'icon' => '🛡️', 'count' => $count('intellectual_properties'),    'link' => 'haki',       'rgb' => '16,185,129'],
            ['label' => 'AIK',          'icon' => '🕌', 'count' => $count('aik_activities'),             'link' => 'aik',        'rgb' => '16,185,129'],
            ['label' => 'Sertifikat',   'icon' => '🎓', 'count' => $count('certificates'),               'link' => 'sertifikat', 'rgb' => '217,164,65'],
            ['label' => 'Reviewer',     'icon' => '👥', 'count' => $count('reviewers'),                   'link' => 'reviewers',  'rgb' => '99,102,241'],
            ['label' => 'Kegiatan',     'icon' => '📅', 'count' => $count('events'),                     'link' => 'events',     'rgb' => '217,164,65'],
            ['label' => 'Cek Plagiat',  'icon' => '🔍', 'count' => $count('plagiarism_checks'),          'link' => 'plagiarism', 'rgb' => '234,88,12'],
            ['label' => 'Hibah',        'icon' => '🔥', 'count' => $count('grants'),                     'link' => 'hibah',      'rgb' => '234,88,12'],
        ];

        /* ===== ANTREAN KERJA (actionable) ===== */
        $queue = [];
        $n = (int) $pdo->query("SELECT COUNT(*) FROM plagiarism_checks WHERE status IN ('queued','processing')")->fetchColumn();
        if ($n > 0) $queue[] = ['icon' => '🔍', 'text' => $n . ' dokumen menunggu analisis plagiat', 'link' => 'plagiarism', 'tone' => 'warn'];
        $n = (int) $pdo->query("SELECT COUNT(*) FROM grants WHERE deadline BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) AND status NOT IN ('closed')")->fetchColumn();
        if ($n > 0) $queue[] = ['icon' => '🔥', 'text' => $n . ' hibah menutup dalam 7 hari', 'link' => 'hibah', 'tone' => 'danger'];
        $n = (int) $pdo->query("SELECT COUNT(*) FROM events WHERE status='published' AND start_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)")->fetchColumn();
        if ($n > 0) $queue[] = ['icon' => '📅', 'text' => $n . ' kegiatan dimulai dalam 7 hari', 'link' => 'events', 'tone' => 'info'];
        $n = Notification::unreadCount($uid);
        if ($n > 0) $queue[] = ['icon' => '🔔', 'text' => $n . ' notifikasi belum dibaca', 'link' => 'notifikasi', 'tone' => 'info'];
        $n = (int) $pdo->query("SELECT COUNT(*) FROM news WHERE status='draft'")->fetchColumn();
        if ($n > 0) $queue[] = ['icon' => '📰', 'text' => $n . ' berita masih draft', 'link' => 'berita', 'tone' => 'warn'];
        $n = (int) $pdo->query("SELECT COUNT(*) FROM documents WHERE status='draft'")->fetchColumn();
        if ($n > 0) $queue[] = ['icon' => '📁', 'text' => $n . ' dokumen masih draft', 'link' => 'dokumen', 'tone' => 'warn'];

        /* ===== CHART: PENELITIAN 5 TAHUN ===== */
        $years = [];
        for ($y = (int) date('Y'); $y > (int) date('Y') - 5; $y--) {
            $s = $pdo->prepare('SELECT COUNT(*) FROM researches WHERE year = ?');
            $s->execute([$y]);
            $years[] = ['year' => $y, 'count' => (int) $s->fetchColumn()];
        }
        $maxYear = max(1, ...array_column($years, 'count'));

        /* ===== CHART: KEGIATAN PER BULAN (TAHUN INI) ===== */
        $s = $pdo->prepare('SELECT MONTH(start_date) m, COUNT(*) c FROM events WHERE YEAR(start_date) = ? GROUP BY MONTH(start_date)');
        $s->execute([(int) date('Y')]);
        $byMonth = [];
        foreach ($s->fetchAll() as $r) $byMonth[(int) $r['m']] = (int) $r['c'];
        $months = [];
        for ($m = 1; $m <= 12; $m++) $months[] = ['m' => $m, 'count' => $byMonth[$m] ?? 0];
        $maxMonth = max(1, ...array_column($months, 'count'));

        /* ===== DONUT PLAGIAT ===== */
        $plagCompleted = (int) $pdo->query("SELECT COUNT(*) FROM plagiarism_checks WHERE status='completed'")->fetchColumn();
        $plagQueued    = (int) $pdo->query("SELECT COUNT(*) FROM plagiarism_checks WHERE status IN ('queued','processing')")->fetchColumn();
        $plagTotal     = $plagCompleted + $plagQueued;
        $donutPct      = $plagTotal > 0 ? (int) round($plagCompleted / $plagTotal * 100) : 0;

        /* ===== ACTIVITY FEED ===== */
        $feed = Notification::forUser($uid, false, 8);

        /* ===== SYSTEM HEALTH ===== */
        $system = [
            'php' => PHP_VERSION,
            'upload' => is_writable(BASE_PATH . '/public/uploads') ? 'OK' : 'NOT WRITABLE',
            'db' => 'OK',
            'time' => date('d M Y · H:i'),
        ];

        View::render('admin/dashboard/index', [
            'title' => 'Dashboard | ' . APP_NAME,
            'user' => $user,
            'kpis' => $kpis,
            'queue' => $queue,
            'years' => $years,
            'maxYear' => $maxYear,
            'months' => $months,
            'maxMonth' => $maxMonth,
            'donutPct' => $donutPct,
            'plagCompleted' => $plagCompleted,
            'plagQueued' => $plagQueued,
            'feed' => $feed,
            'system' => $system,
        ], 'layouts/admin');
    }
}