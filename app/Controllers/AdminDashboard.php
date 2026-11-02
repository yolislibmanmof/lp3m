<?php

declare(strict_types=1);

class AdminDashboard
{
    public static function index(): void
    {
        $pdo = Database::pdo();
        $user = Auth::user() ?? [];
        $uid = (int) ($user['id'] ?? 0);

        /* ===== 🚀 KPI SEMUA MODUL (Optimized: 1 Query UNION ALL) ===== */
        $kpiData = [
            'berita' => 0, 'dokumen' => 0, 'researches' => 0, 'community_services' => 0,
            'publications' => 0, 'intellectual_properties' => 0, 'aik_activities' => 0,
            'certificates' => 0, 'reviewers' => 0, 'events' => 0, 'plagiarism_checks' => 0, 'grants' => 0
        ];
        
        try {
            $sql = "
                SELECT 'berita' as tbl, COUNT(*) as cnt FROM news UNION ALL
                SELECT 'dokumen', COUNT(*) FROM documents UNION ALL
                SELECT 'researches', COUNT(*) FROM researches UNION ALL
                SELECT 'community_services', COUNT(*) FROM community_services UNION ALL
                SELECT 'publications', COUNT(*) FROM publications UNION ALL
                SELECT 'intellectual_properties', COUNT(*) FROM intellectual_properties UNION ALL
                SELECT 'aik_activities', COUNT(*) FROM aik_activities UNION ALL
                SELECT 'certificates', COUNT(*) FROM certificates UNION ALL
                SELECT 'reviewers', COUNT(*) FROM reviewers UNION ALL
                SELECT 'events', COUNT(*) FROM events UNION ALL
                SELECT 'plagiarism_checks', COUNT(*) FROM plagiarism_checks UNION ALL
                SELECT 'grants', COUNT(*) FROM grants
            ";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $kpiData[$row['tbl']] = (int) $row['cnt'];
            }
        } catch (\Throwable $e) {
            // Fallback aman jika query gagal
        }

        $kpis = [
            ['label' => 'Berita',       'icon' => '📰', 'count' => $kpiData['berita'],                'link' => 'berita',     'rgb' => '217,164,65'],
            ['label' => 'Dokumen',      'icon' => '📁', 'count' => $kpiData['dokumen'],               'link' => 'dokumen',    'rgb' => '217,164,65'],
            ['label' => 'Penelitian',   'icon' => '🔬', 'count' => $kpiData['researches'],            'link' => 'penelitian', 'rgb' => '59,130,246'],
            ['label' => 'Pengabdian',   'icon' => '🤝', 'count' => $kpiData['community_services'],    'link' => 'pengabdian', 'rgb' => '16,185,129'],
            ['label' => 'Publikasi',    'icon' => '📚', 'count' => $kpiData['publications'],          'link' => 'publikasi',  'rgb' => '16,185,129'],
            ['label' => 'HAKI',         'icon' => '🛡️', 'count' => $kpiData['intellectual_properties'],'link' => 'haki',       'rgb' => '16,185,129'],
            ['label' => 'AIK',          'icon' => '🕌', 'count' => $kpiData['aik_activities'],         'link' => 'aik',        'rgb' => '16,185,129'],
            ['label' => 'Sertifikat',   'icon' => '🎓', 'count' => $kpiData['certificates'],          'link' => 'sertifikat', 'rgb' => '217,164,65'],
            ['label' => 'Reviewer',     'icon' => '👥', 'count' => $kpiData['reviewers'],              'link' => 'reviewers',  'rgb' => '99,102,241'],
            ['label' => 'Kegiatan',     'icon' => '📅', 'count' => $kpiData['events'],                'link' => 'events',     'rgb' => '217,164,65'],
            ['label' => 'Cek Plagiat',  'icon' => '🔍', 'count' => $kpiData['plagiarism_checks'],     'link' => 'plagiarism', 'rgb' => '234,88,12'],
            ['label' => 'Hibah',        'icon' => '🔥', 'count' => $kpiData['grants'],                'link' => 'hibah',      'rgb' => '234,88,12'],
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

        /* ===== 🚀 CHART: PENELITIAN 5 TAHUN (Optimized: 1 Query GROUP BY) ===== */
        $startYear = (int) date('Y') - 4;
        $s = $pdo->prepare('SELECT year, COUNT(*) as cnt FROM researches WHERE year >= ? GROUP BY year ORDER BY year ASC');
        $s->execute([$startYear]);
        $rawYears = $s->fetchAll(PDO::FETCH_KEY_PAIR); // Format: ['2020' => 5, '2021' => 12, ...]
        
        $years = [];
        $maxYear = 1; // 🛡️ Cegah division by zero di view
        for ($y = $startYear; $y <= (int) date('Y'); $y++) {
            $count = (int) ($rawYears[$y] ?? 0);
            if ($count > $maxYear) $maxYear = $count;
            $years[] = ['year' => $y, 'count' => $count];
        }

        /* ===== CHART: KEGIATAN PER BULAN (TAHUN INI) ===== */
        $s = $pdo->prepare('SELECT MONTH(start_date) as m, COUNT(*) as c FROM events WHERE YEAR(start_date) = ? GROUP BY MONTH(start_date)');
        $s->execute([(int) date('Y')]);
        $byMonth = [];
        foreach ($s->fetchAll() as $r) {
            $byMonth[(int) $r['m']] = (int) $r['c'];
        }
        
        $months = [];
        $maxMonth = 1; // 🛡️ Cegah division by zero di view
        for ($m = 1; $m <= 12; $m++) {
            $count = $byMonth[$m] ?? 0;
            if ($count > $maxMonth) $maxMonth = $count;
            $months[] = ['m' => $m, 'count' => $count];
        }

        /* ===== 🚀 DONUT PLAGIAT (Optimized: 1 Query Conditional Aggregation) ===== */
        $s = $pdo->query("SELECT 
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN status IN ('queued', 'processing') THEN 1 ELSE 0 END) as queued
            FROM plagiarism_checks");
        $plagStats = $s->fetch(PDO::FETCH_ASSOC);
        
        $plagCompleted = (int) ($plagStats['completed'] ?? 0);
        $plagQueued    = (int) ($plagStats['queued'] ?? 0);
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