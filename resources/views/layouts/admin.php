<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? APP_NAME) ?> — LP3M Admin</title>
    <link rel="icon" href="<?= e(url('public/assets/img/favicon.svg')) ?>">
    <link rel="stylesheet" href="<?= e(url('admin/assets/css/admin.css')) ?>">

    <!-- ==========================================================
         SIDEBAR PREMIUM FINAL — Layout-only enhancement
         Tidak menyentuh admin.css / admin.js
         ========================================================== -->
    <style>
        .sb2 {
            padding: 18px 14px 14px !important;
            border-right: 1px solid rgba(217,164,65,.14);
            background:
                radial-gradient(420px 220px at -25% 0%, rgba(217,164,65,.12), transparent 62%),
                radial-gradient(360px 220px at 115% 18%, rgba(16,185,129,.10), transparent 60%),
                linear-gradient(180deg, #082b21 0%, #052018 55%, #031510 100%);
        }
        @keyframes sb2Shine { 0%, 55% { left: -90%; } 100% { left: 165%; } }
        @keyframes sb2Spin { to { transform: rotate(360deg); } }
        @keyframes sb2Breath { 0%,100% { box-shadow: 0 0 0 0 rgba(16,185,129,.25); } 50% { box-shadow: 0 0 0 5px rgba(16,185,129,0); } }

        .sb2-brand { position: relative; z-index: 2; display: flex; align-items: center; gap: 12px; padding: 2px 6px 16px; margin-bottom: 12px; border-bottom: 1px solid rgba(217,164,65,.14); flex-shrink: 0; }
        .sb2-logo { width: 46px; height: 46px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-family: var(--font-display); font-weight: 900; font-size: 17px; color: #03251f; background: radial-gradient(circle at 30% 25%, #fff7c2 0%, #fde68a 18%, #f2c063 52%, #d9a441 100%); box-shadow: inset 0 2px 3px rgba(255,255,255,.72), inset 0 -3px 4px rgba(0,0,0,.20), 0 6px 16px rgba(217,164,65,.45); position: relative; flex-shrink: 0; overflow: hidden; }
        .sb2-logo::before { content:''; position:absolute; top:6px; left:10px; width:15px; height:6px; border-radius:50%; background:rgba(255,255,255,.70); filter:blur(1.5px); }
        .sb2-logo::after { content:''; position:absolute; top:0; left:-90%; width:52%; height:100%; background:linear-gradient(105deg, transparent, rgba(255,255,255,.72), transparent); transform:skewX(-20deg); animation:sb2Shine 3.4s ease-in-out infinite; }
        .sb2-brand-title { flex: 1; min-width: 0; }
        .sb2-brand-sub { font-size: 9px; color: rgba(255,255,255,.52); font-weight: 800; letter-spacing: .13em; text-transform: uppercase; margin-top: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sb2-ver { font-size: 9px; font-weight: 900; color: #f2c063; background: rgba(217,164,65,.14); border: 1px solid rgba(217,164,65,.35); padding: 2px 7px; border-radius: 999px; letter-spacing: .08em; flex-shrink: 0; }

        .sb2-nav { position: relative; z-index: 1; flex: 1 1 auto; overflow-y: auto; overflow-x: hidden; min-height: 0; scrollbar-width: thin; scrollbar-color: rgba(217,164,65,.30) transparent; padding-right: 4px; }
        .sb2-nav::-webkit-scrollbar { width: 6px; }
        .sb2-nav::-webkit-scrollbar-thumb { background: linear-gradient(180deg, rgba(242,192,99,.45), rgba(16,185,129,.28)); border-radius: 999px; }

        .sb2 .menu-label-3d { margin-top: 14px; margin-bottom: 7px; color: rgba(242,192,99,.88); }
        .sb2 .menu-label-3d:first-child { margin-top: 4px; }
        .sb2 .menu-label-3d::after { content:''; flex: 1; height: 1px; background: linear-gradient(90deg, rgba(217,164,65,.42), transparent); }
        .sb2 .sidebar-menu a { border-radius: 12px; min-height: 42px; }
        .sb2 .sidebar-menu a.active { background: linear-gradient(90deg, rgba(217,164,65,.19), rgba(16,185,129,.11) 62%, transparent); border-color: rgba(217,164,65,.36); box-shadow: 0 6px 16px rgba(0,0,0,.35), inset 0 1px 1px rgba(255,255,255,.06); }
        .sb2 .sidebar-menu a.active::before { width: 4px; background: linear-gradient(180deg, #fde68a, #d9a441); box-shadow: 0 0 12px rgba(242,192,99,.82); }

        .sb2-pulse { flex-shrink: 0; margin-top: 12px; padding: 12px; border-radius: 14px; background: radial-gradient(110px 80px at 105% 0%, rgba(217,164,65,.12), transparent 70%), linear-gradient(145deg, #0d241c, #071a13); border: 1px solid rgba(217,164,65,.22); position: relative; z-index: 2; box-shadow: inset 0 1px 1px rgba(255,255,255,.05), 0 4px 12px rgba(0,0,0,.34); }
        .sb2-pulse-head { display: flex; align-items: center; gap: 8px; font-size: 11px; font-weight: 850; color: #fff; margin-bottom: 8px; }
        .sb2-up { margin-left: auto; font-size: 9px; font-weight: 900; color: #6ee7b7; background: rgba(16,185,129,.15); border: 1px solid rgba(16,185,129,.35); padding: 2px 7px; border-radius: 999px; }
        .sb2-meter { height: 6px; border-radius: 999px; background: rgba(255,255,255,.08); overflow: hidden; }
        .sb2-meter i { display: block; height: 100%; border-radius: 999px; background: linear-gradient(90deg, #10b981, #f2c063); position: relative; overflow: hidden; }
        .sb2-meter i::after { content:''; position:absolute; top:0; left:-60%; width:42%; height:100%; background:linear-gradient(105deg, transparent, rgba(255,255,255,.62), transparent); animation:sb2Shine 2.7s linear infinite; }
        .sb2-meter-row { display: flex; justify-content: space-between; gap: 8px; font-size: 9.5px; color: rgba(255,255,255,.55); margin-top: 6px; font-weight: 750; }

        .sb2-profile { flex-shrink: 0; margin-top: 10px; padding: 10px 12px; border-radius: 14px; background: radial-gradient(120px 70px at 100% 0%, rgba(217,164,65,.11), transparent 70%), linear-gradient(145deg, #0d241c, #071a13); border: 1px solid rgba(217,164,65,.25); display: flex; align-items: center; gap: 10px; position: relative; z-index: 2; box-shadow: inset 0 1px 1px rgba(255,255,255,.05), 0 4px 12px rgba(0,0,0,.35); }
        .sb2-ring { position: relative; width: 42px; height: 42px; flex-shrink: 0; }
        .sb2-ring::before { content:''; position:absolute; inset:-3px; border-radius:50%; background:conic-gradient(from 0deg, #f2c063, #10b981, #f2c063); animation:sb2Spin 4.5s linear infinite; }
        .sb2-ring .profile-avatar-3d { position: relative; width: 42px !important; height: 42px !important; font-size: 13px !important; border: 2px solid #071a13; }
        .sb2-online-dot { width: 9px; height: 9px; flex-shrink: 0; animation: sb2Breath 2s ease-in-out infinite; }
        .sb2-footer-mini { flex-shrink: 0; margin-top: 8px; text-align: center; font-size: 8.5px; color: rgba(255,255,255,.34); letter-spacing: .12em; text-transform: uppercase; position: relative; z-index: 2; }

        /* Notif badge pulsing */
        .bell-3d.live .bell-badge-3d { animation: bellPop 1.2s ease-in-out infinite alternate; }
        @keyframes bellPop { from { transform: scale(1); } to { transform: scale(1.15); } }

        @media (max-width: 900px) {
            .sb2 { overflow: visible !important; padding: 14px !important; }
            .sb2-brand { margin-bottom: 10px; padding-bottom: 12px; }
            .sb2-nav { display: flex !important; flex-direction: row !important; gap: 6px; overflow-x: auto !important; overflow-y: hidden !important; padding-bottom: 6px; padding-right: 0; }
            .sb2-nav .menu-label-3d { display: none !important; }
            .sb2-pulse, .sb2-footer-mini { display: none; }
            .sb2-profile { margin-top: 10px; }
        }
    </style>
</head>
<body>

<?php if (Auth::check()): ?>

<?php
// --- ZONA WAKTU & GREETING ---
date_default_timezone_set('Asia/Makassar');

$bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$tanggal = date('d') . ' ' . $bulan[(int) date('n') - 1] . ' ' . date('Y');

$hour = (int) date('G');
if ($hour >= 4 && $hour < 10)      { $greeting = 'Selamat Pagi';    $greetIcon = '🌅'; }
elseif ($hour >= 10 && $hour < 15) { $greeting = 'Selamat Siang';   $greetIcon = '☀️'; }
elseif ($hour >= 15 && $hour < 18) { $greeting = 'Selamat Sore';    $greetIcon = '🌇'; }
else                               { $greeting = 'Selamat Malam';   $greetIcon = '🌙'; }

// --- DATABASE & COUNTERS ---
$db = Database::pdo();

$cntBerita     = (int) $db->query('SELECT COUNT(*) FROM news')->fetchColumn();
$cntDokumen    = (int) $db->query('SELECT COUNT(*) FROM documents')->fetchColumn();
$cntPengabdian = (int) $db->query('SELECT COUNT(*) FROM community_services')->fetchColumn();
$cntPublikasi  = (int) $db->query('SELECT COUNT(*) FROM publications')->fetchColumn();
$cntHaki       = (int) $db->query('SELECT COUNT(*) FROM intellectual_properties')->fetchColumn();
$cntAik        = (int) $db->query('SELECT COUNT(*) FROM aik_activities')->fetchColumn();
$cntPenelitian = (int) $db->query('SELECT COUNT(*) FROM researches')->fetchColumn();
$cntHibah      = (int) $db->query('SELECT COUNT(*) FROM grants')->fetchColumn();
$cntFaq        = (int) $db->query('SELECT COUNT(*) FROM faqs')->fetchColumn();
$cntGaleri     = (int) $db->query('SELECT COUNT(*) FROM galleries')->fetchColumn();
$cntSertifikat = (int) $db->query('SELECT COUNT(*) FROM certificates')->fetchColumn();
$cntReviewers  = (int) $db->query('SELECT COUNT(*) FROM reviewers')->fetchColumn();
$cntEvents     = (int) $db->query("SELECT COUNT(*) FROM events WHERE status='published'")->fetchColumn();
$cntPlagiarism = (int) $db->query('SELECT COUNT(*) FROM plagiarism_checks')->fetchColumn();
$cntUsers      = (int) $db->query('SELECT COUNT(*) FROM users')->fetchColumn();
$cntSurvey     = (int) $db->query('SELECT COUNT(*) FROM surveys')->fetchColumn();

$adminId     = (int) (Auth::user()['id'] ?? 0);
$unreadNotif = (int) $db->query("SELECT COUNT(*) FROM notifications WHERE is_read = 0 AND (is_global = 1 OR user_id = " . $adminId . ")")->fetchColumn();

$draftBerita = (int) $db->query("SELECT COUNT(*) FROM news WHERE status = 'draft'")->fetchColumn();
$draftDok    = (int) $db->query("SELECT COUNT(*) FROM documents WHERE status = 'draft'")->fetchColumn();
$totalDraft  = $draftBerita + $draftDok;
$totalAll    = $cntBerita + $cntDokumen + $cntPengabdian + $cntPublikasi + $cntHaki + $cntAik + $cntPenelitian + $cntHibah + $cntFaq + $cntGaleri + $cntSertifikat + $cntReviewers + $cntEvents + $cntPlagiarism;

// --- MAINTENANCE STATUS ---
$maintenanceOn = false;
try { $maintenanceOn = Maintenance::isOn(); } catch (\Throwable $e) {}

// --- ADMIN INFO ---
$adminName = Auth::user()['name'] ?? 'Admin';
$adminRole = Auth::user()['role'] ?? 'admin';
$isSuper   = $adminRole === 'super_admin';

$nameParts = explode(' ', trim($adminName));
$initial = strtoupper(substr($nameParts[0] ?? 'A', 0, 1));
if (isset($nameParts[1])) $initial .= strtoupper(substr($nameParts[1], 0, 1));

$roleMap = [
    'super_admin' => ['label' => 'Super Admin', 'rgb' => '217,164,65', 'hex' => '#f2c063'],
    'admin_lp3m'  => ['label' => 'Admin LP3M',  'rgb' => '16,185,129', 'hex' => '#6ee7b7'],
    'dosen'       => ['label' => 'Dosen',       'rgb' => '59,130,246', 'hex' => '#93c5fd'],
    'reviewer'    => ['label' => 'Reviewer',    'rgb' => '124,58,237', 'hex' => '#c4b5fd'],
    'pimpinan'    => ['label' => 'Pimpinan',    'rgb' => '245,158,11', 'hex' => '#fcd34d'],
    'mahasiswa'   => ['label' => 'Mahasiswa',   'rgb' => '20,184,166', 'hex' => '#5eead4'],
];
$role = $roleMap[$adminRole] ?? ['label' => 'Admin', 'rgb' => '16,185,129', 'hex' => '#6ee7b7'];

$uptimeHours = rand(120, 720);
$currentPage = $_GET['page'] ?? 'dashboard';

$pageTitles = [
    'dashboard'       => 'Ringkasan performa lembaga',
    'berita'          => 'Kelola publikasi redaksi',
    'dokumen'         => 'Arsip & dokumen publik',
    'galeri'          => 'Galeri kegiatan & dokumentasi',
    'penelitian'      => 'Kelola penelitian & proposal',
    'pengabdian'      => 'Program pengabdian masyarakat',
    'publikasi'       => 'Jurnal & artikel ilmiah',
    'haki'            => 'Hak kekayaan intelektual',
    'aik'             => 'Al-Islam & Kemuhammadiyahan',
    'hibah'           => 'Manajemen hibah & pendanaan',
    'kontak'          => 'Kontak & FAQ publik',
    'pengaturan'      => 'Konfigurasi tampilan publik',
    'sertifikat'      => 'Sertifikat digital & verifikasi',
    'reviewers'       => 'Database reviewer internal & eksternal',
    'events'          => 'Kalender kegiatan LP3M',
    'plagiarism'      => 'Cek similaritas & plagiarisme',
    'notifikasi'      => 'Pusat notifikasi sistem',
    'users'           => 'Manajemen pengguna & hak akses',
    'users-tambah'    => 'Manajemen pengguna & hak akses',
    'users-edit'      => 'Manajemen pengguna & hak akses',
    'audit'           => 'Jejak aktivitas pengguna',
    'audit-detail'    => 'Detail jejak aktivitas',
    'laporan'         => 'Dashboard laporan & export',
    'laporan-modul'   => 'Detail laporan per modul',
    'laporan-print'   => 'Laporan cetak (PDF)',
    'laporan-tahunan' => 'Laporan tahunan',
    // 🆕 TAHAP G — Survei
    'survei'          => 'Survei kepuasan & EDOM',
    'survei-tambah'   => 'Buat survei baru',
    'survei-edit'     => 'Edit survei',
    'survei-hasil'    => 'Hasil survei & statistik',
    // 🆕 TAHAP D — Backup & Maintenance
    'backup'          => 'Backup database & mode perawatan',
];

$pageSub   = $pageTitles[$currentPage] ?? '';
$firstName = explode(' ', trim($adminName))[0] ?? 'Admin';
?>

<div class="admin-wrapper">

    <!-- ================= SIDEBAR ================= -->
    <aside class="sidebar sb2" style="display:flex; flex-direction:column; overflow:hidden;">
        <div class="sb-wm" aria-hidden="true">LP3M</div>

        <!-- Brand -->
        <div class="sb2-brand">
            <div class="sb2-logo"><span style="position:relative; z-index:1;">LP</span></div>
            <div class="sb2-brand-title">
                <div class="brand-3d" style="font-size:16px; line-height:1.1;">LP3M UNIMOF</div>
                <div class="sb2-brand-sub">Elevate Command Center</div>
            </div>
            <span class="sb2-ver">v4.0</span>
        </div>

        <!-- Menu -->
        <nav class="sidebar-menu sb2-nav">
            <span class="menu-label-3d">Utama</span>
            <a href="<?= e(url('admin/index.php?page=dashboard')) ?>" class="<?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold">🏠</span><span>Dashboard</span>
            </a>

            <span class="menu-label-3d">Konten</span>
            <a href="<?= e(url('admin/index.php?page=berita')) ?>" class="<?= $currentPage === 'berita' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold">📰</span><span>Berita & Pengumuman</span>
                <span class="jewel-badge jewel-gold"><?= $cntBerita ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=dokumen')) ?>" class="<?= $currentPage === 'dokumen' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold">📁</span><span>Dokumen & Unduhan</span>
                <span class="jewel-badge jewel-gold"><?= $cntDokumen ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=galeri')) ?>" class="<?= $currentPage === 'galeri' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-purple">🖼️</span><span>Galeri Kegiatan</span>
                <span class="jewel-badge jewel-gold"><?= $cntGaleri ?></span>
            </a>

            <span class="menu-label-3d">Catur Dharma</span>
            <a href="<?= e(url('admin/index.php?page=penelitian')) ?>" class="<?= $currentPage === 'penelitian' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-blue">🔬</span><span>Penelitian</span>
                <span class="jewel-badge jewel-emerald"><?= $cntPenelitian ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=pengabdian')) ?>" class="<?= $currentPage === 'pengabdian' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-emerald">🤝</span><span>Pengabdian & KKN</span>
                <span class="jewel-badge jewel-emerald"><?= $cntPengabdian ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=publikasi')) ?>" class="<?= $currentPage === 'publikasi' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-emerald">📚</span><span>Publikasi Ilmiah</span>
                <span class="jewel-badge jewel-emerald"><?= $cntPublikasi ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=haki')) ?>" class="<?= $currentPage === 'haki' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-emerald">🛡️</span><span>HAKI</span>
                <span class="jewel-badge jewel-emerald"><?= $cntHaki ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=aik')) ?>" class="<?= $currentPage === 'aik' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-emerald">🕌</span><span>AIK & Catur Dharma</span>
                <span class="jewel-badge jewel-emerald"><?= $cntAik ?></span>
            </a>

            <span class="menu-label-3d">Layanan</span>
            <a href="<?= e(url('admin/index.php?page=hibah')) ?>" class="<?= $currentPage === 'hibah' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold">💰</span><span>Hibah & Pendanaan</span>
                <span class="jewel-badge jewel-gold"><?= $cntHibah ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=sertifikat')) ?>" class="<?= $currentPage === 'sertifikat' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold">🎓</span><span>Sertifikat & Verifikasi</span>
                <span class="jewel-badge jewel-gold"><?= $cntSertifikat ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=kontak')) ?>" class="<?= $currentPage === 'kontak' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-blue">📞</span><span>Kontak & FAQ</span>
                <span class="jewel-badge jewel-gold"><?= $cntFaq ?></span>
            </a>

            <span class="menu-label-3d">Layanan Cerdas ✦</span>
            <a href="<?= e(url('admin/index.php?page=reviewers')) ?>" class="<?= $currentPage === 'reviewers' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-blue">👥</span><span>Reviewer</span>
                <span class="jewel-badge jewel-emerald"><?= $cntReviewers ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=events')) ?>" class="<?= $currentPage === 'events' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold">📅</span><span>Kalender Kegiatan</span>
                <span class="jewel-badge jewel-gold"><?= $cntEvents ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=plagiarism')) ?>" class="<?= $currentPage === 'plagiarism' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-emerald">🔍</span><span>Cek Plagiat</span>
                <span class="jewel-badge jewel-emerald"><?= $cntPlagiarism ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=survei')) ?>" class="<?= strpos($currentPage, 'survei') === 0 ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-purple">📝</span><span>Survei Kepuasan</span>
                <span class="jewel-badge jewel-emerald"><?= $cntSurvey ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=notifikasi')) ?>" class="<?= $currentPage === 'notifikasi' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold">🔔</span><span>Notifikasi</span>
                <?php if ($unreadNotif > 0): ?>
                    <span class="jewel-badge" style="background:linear-gradient(145deg,#f87171,#dc2626);color:#fff;"><?= $unreadNotif ?></span>
                <?php endif; ?>
            </a>

            <span class="menu-label-3d">Sistem</span>
            <?php if ($isSuper): ?>
                <a href="<?= e(url('admin/index.php?page=users')) ?>" class="<?= strpos($currentPage, 'users') === 0 ? 'active' : '' ?>">
                    <span class="ico-3d ico-3d-blue">👤</span><span>Manajemen Pengguna</span>
                    <span class="jewel-badge jewel-gold"><?= $cntUsers ?></span>
                </a>
                <a href="<?= e(url('admin/index.php?page=audit')) ?>" class="<?= strpos($currentPage, 'audit') === 0 ? 'active' : '' ?>">
                    <span class="ico-3d ico-3d-blue">📜</span><span>Audit Log</span>
                    <span class="jewel-badge jewel-emerald">
                        <?= (int) $db->query("SELECT COUNT(*) FROM audit_logs WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn() ?>
                    </span>
                </a>
                <a href="<?= e(url('admin/index.php?page=laporan')) ?>" class="<?= strpos($currentPage, 'laporan') === 0 ? 'active' : '' ?>">
                    <span class="ico-3d ico-3d-gold">📊</span><span>Laporan & Export</span>
                </a>
                <a href="<?= e(url('admin/index.php?page=backup')) ?>" class="<?= strpos($currentPage, 'backup') === 0 ? 'active' : '' ?>">
                    <span class="ico-3d ico-3d-red">💾</span><span>Backup & Maintenance</span>
                </a>
            <?php endif; ?>

            <a href="<?= e(url('admin/index.php?page=pengaturan')) ?>" class="<?= $currentPage === 'pengaturan' ? 'active' : '' ?>">
                <span class="ico-3d">⚙️</span><span>Pengaturan Website</span>
            </a>
            <a href="<?= e(url('public/index.php?page=home')) ?>" target="_blank">
                <span class="ico-3d">🌐</span><span>Lihat Website</span>
                <span style="margin-left:auto; font-size:10px; opacity:.5;">↗</span>
            </a>
            <a href="<?= e(url('admin/index.php?page=logout')) ?>" style="color:#fca5a5;">
                <span class="ico-3d ico-3d-red">🚪</span><span>Logout</span>
            </a>
        </nav>

        <!-- System Pulse -->
        <div class="sb2-pulse">
            <div class="sb2-pulse-head">
                <span class="sys-dot-3d" style="width:9px; height:9px;"></span>
                <span>System Pulse</span>
                <span class="sb2-up"><?= $uptimeHours ?>h</span>
            </div>
            <div class="sb2-meter"><i style="width:78%;"></i></div>
            <div class="sb2-meter-row">
                <span>Database & Storage</span>
                <span>Optimal</span>
            </div>
        </div>

        <!-- Profile -->
        <div class="sb2-profile">
            <div class="sb2-ring">
                <div class="profile-avatar-3d"><?= e($initial) ?></div>
            </div>
            <div style="flex:1; min-width:0;">
                <p style="font-size:12.5px; font-weight:800; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?= e($adminName) ?></p>
                <span style="display:inline-block; margin-top:2px; padding:1px 7px; border-radius:999px; font-size:8.5px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; color:<?= $role['hex'] ?>; background:rgba(<?= $role['rgb'] ?>,.15); border:1px solid rgba(<?= $role['rgb'] ?>,.35);">
                    ✦ <?= e($role['label']) ?>
                </span>
            </div>
            <span class="sys-dot-3d sb2-online-dot" title="Sistem Online"></span>
        </div>

        <div class="sb2-footer-mini">Elevate Edition • Secure Panel</div>
    </aside>

    <!-- ================= MAIN ================= -->
    <div class="admin-content">

        <header class="admin-topbar">
            <div style="display:flex; align-items:center; gap:14px; min-width:0; flex:1;">
                <span class="greet-ico-3d" style="position:relative; flex-shrink:0;"><?= $greetIcon ?></span>
                <div style="min-width:0;">
                    <div style="display:flex; align-items:baseline; gap:6px; flex-wrap:wrap;">
                        <span style="font-size:11px; color:rgba(255,255,255,.55); font-weight:600;"><?= e($greeting) ?>,</span>
                        <span style="background:linear-gradient(135deg,#fff,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; font-weight:900; font-family:var(--font-display); font-size:16px;"><?= e($firstName) ?></span>
                    </div>
                    <div style="font-size:11.5px; color:rgba(255,255,255,.6); margin-top:1px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?= e($pageSub) ?></div>
                </div>
            </div>

            <div class="topbar-right">
                <div style="display:flex; gap:6px; padding:4px 8px; border-radius:12px; background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.06);">
                    <div style="display:flex; align-items:center; gap:6px; padding:4px 9px; border-radius:8px; background:rgba(242,192,99,.08);" title="Total data semua modul">
                        <span style="font-size:11px;">📊</span>
                        <span style="font-size:12px; font-weight:800; color:#f2c063; font-family:var(--font-display);"><?= number_format($totalAll) ?></span>
                    </div>
                    <?php if ($totalDraft > 0): ?>
                    <div style="display:flex; align-items:center; gap:6px; padding:4px 9px; border-radius:8px; background:rgba(220,38,38,.12);" title="Draft menunggu">
                        <span style="font-size:11px;">✏️</span>
                        <span style="font-size:12px; font-weight:800; color:#fca5a5; font-family:var(--font-display);"><?= $totalDraft ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <a href="<?= e(url('admin/index.php?page=notifikasi')) ?>" class="bell-3d <?= $unreadNotif > 0 ? 'live' : '' ?>" title="<?= $unreadNotif ?> notifikasi belum dibaca">
                    <span class="bell-icon-inner" style="position:relative; z-index:1;">🔔</span>
                    <?php if ($unreadNotif > 0): ?><span class="bell-badge-3d"><?= $unreadNotif > 99 ? '99+' : $unreadNotif ?></span><?php endif; ?>
                </a>

                <span class="date-3d">📅 <?= e($tanggal) ?></span>

                <div class="user-3d">
                    <div class="user-avatar-3d"><?= e($initial) ?></div>
                    <div style="display:flex; flex-direction:column; line-height:1.15;">
                        <span style="font-size:12px; font-weight:800;"><?= e($firstName) ?></span>
                        <span style="font-size:8.5px; opacity:.65; letter-spacing:.05em; text-transform:uppercase;"><?= e($role['label']) ?></span>
                    </div>
                </div>
            </div>
        </header>

        <main class="admin-main">
            <?php if ($maintenanceOn): ?>
            <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:18px; padding:13px 18px; border-radius:14px; background:linear-gradient(145deg,rgba(245,158,11,.16),rgba(245,158,11,.08)); border:1px solid rgba(245,158,11,.45); color:#fcd34d; font-size:13px; font-weight:800;">
                🚧 <span>Mode maintenance AKTIF — situs publik sedang ditutup sementara.</span>
                <a href="<?= e(url('admin/index.php?page=backup')) ?>" style="margin-left:auto; padding:6px 14px; border-radius:9px; background:rgba(245,158,11,.2); border:1px solid rgba(245,158,11,.5); color:#fde68a; text-decoration:none; font-size:12px;">Kelola →</a>
            </div>
            <?php endif; ?>

            <?= $content ?>

            <footer style="margin-top:40px; padding:18px 0 4px; border-top:1px solid rgba(255,255,255,.06); display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; font-size:11px; color:rgba(255,255,255,.5);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <span style="font-weight:800; background:linear-gradient(135deg,#fde68a,#d9a441); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;">LP3M UNIMOF</span>
                    <span style="opacity:.5;">•</span>
                    <span>© <?= date('Y') ?> Elevate Edition</span>
                </div>
                <div style="display:flex; gap:14px; align-items:center;">
                    <span style="display:inline-flex; align-items:center; gap:5px;">
                        <span class="sys-dot-3d" style="width:8px; height:8px;"></span>
                        <span>All systems operational</span>
                    </span>
                </div>
            </footer>
        </main>
    </div>
</div>

<?php else: ?>
<?= $content ?>
<?php endif; ?>

<script src="<?= e(url('admin/assets/js/admin.js')) ?>"></script>
</body>
</html>