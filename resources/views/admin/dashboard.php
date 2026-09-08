<?php
// FIX ZONA WAKTU: Paksa ke WITA (Maumere) agar greeting akurat
date_default_timezone_set('Asia/Makassar');

$counts = [
    ['📰', 'Berita & Pengumuman', News::paginate([], 1, 1)['total'], 'berita', 'ico-admin-gold'],
    ['📁', 'Dokumen & Unduhan', Document::paginate([], 1, 1)['total'], 'dokumen', 'ico-admin-emerald'],
    ['🔬', 'Penelitian', Research::paginate([], '', [], 1, 1)['total'], 'penelitian', 'ico-admin-blue'], // <-- TAMBAH PENELITIAN
    ['🤝', 'Pengabdian & KKN', CommunityService::paginate([], '', [], 1, 1)['total'], 'pengabdian', 'ico-admin-teal'],
    ['📚', 'Publikasi Ilmiah', Publication::paginate([], '', [], 1, 1)['total'], 'publikasi', 'ico-admin-purple'],
    ['🛡️', 'HAKI', IntellectualProperty::paginate([], '', [], 1, 1)['total'], 'haki', 'ico-admin-red'],
    ['🕌', 'Kegiatan AIK', AikActivity::paginate([], '', [], 1, 1)['total'], 'aik', 'ico-admin-teal'],
    ['💰', 'Hibah Aktif', Grant::paginate([], '', [], 1, 1)['total'], 'hibah', 'ico-admin-gold'], // <-- TAMBAH HIBAH
];

// Recent activity lintas modul
$recentActivity = [];
try {
    $rNews = Database::pdo()->query('SELECT "📰" as icon, title, "Berita" as type, created_at as date FROM news ORDER BY created_at DESC LIMIT 2')->fetchAll();
    foreach ($rNews as $r) $recentActivity[] = $r;
    
    $rRes = Database::pdo()->query('SELECT "🔬" as icon, title, "Penelitian" as type, created_at as date FROM researches ORDER BY created_at DESC LIMIT 2')->fetchAll();
    foreach ($rRes as $r) $recentActivity[] = $r;

    $rPub = Database::pdo()->query('SELECT "📚" as icon, title, "Publikasi" as type, created_at as date FROM publications ORDER BY created_at DESC LIMIT 2')->fetchAll();
    foreach ($rPub as $r) $recentActivity[] = $r;
    
    $rAik = Database::pdo()->query('SELECT "🕌" as icon, title, "AIK" as type, created_at as date FROM aik_activities ORDER BY created_at DESC LIMIT 2')->fetchAll();
    foreach ($rAik as $r) $recentActivity[] = $r;
    
    $rCs = Database::pdo()->query('SELECT "🤝" as icon, title, "Pengabdian" as type, created_at as date FROM community_services ORDER BY created_at DESC LIMIT 2')->fetchAll();
    foreach ($rCs as $r) $recentActivity[] = $r;
    
    usort($recentActivity, fn($a, $b) => strtotime($b['date']) <=> strtotime($a['date']));
    $recentActivity = array_slice($recentActivity, 0, 6);
} catch (\Throwable $e) {
    // Ignore errors if tables missing
}

// Pending drafts
$draftNews = (int) Database::pdo()->query('SELECT COUNT(*) FROM news WHERE status = "draft"')->fetchColumn();
$draftDoc = (int) Database::pdo()->query('SELECT COUNT(*) FROM documents WHERE status = "draft"')->fetchColumn();
$totalDraft = $draftNews + $draftDoc;

// Admin info
$adminName = Auth::user()['name'] ?? 'Admin';
$adminRole = Auth::user()['role'] ?? 'admin';

// LOGIKA WAKTU DINAMIS (WITA)
$hour = (int) date('G');
if ($hour >= 5 && $hour < 11)      { $greeting = 'Selamat Pagi';  $greetIcon = '🌅'; }
elseif ($hour >= 11 && $hour < 15) { $greeting = 'Selamat Siang'; $greetIcon = '☀️'; }
elseif ($hour >= 15 && $hour < 18) { $greeting = 'Selamat Sore';  $greetIcon = '🌇'; }
else                               { $greeting = 'Selamat Malam'; $greetIcon = '🌙'; }

$quickActions = [
    ['➕', 'Tambah Berita', 'berita-tambah', 'qa-gold'],
    ['📤', 'Upload Dokumen', 'dokumen-tambah', 'qa-emerald'],
    ['🔬', 'Input Penelitian', 'penelitian-tambah', 'qa-blue'],
    ['💰', 'Tambah Hibah', 'hibah-tambah', 'qa-gold'],
];
?>

<style>
    @keyframes dashFloat1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(15px,-10px)} }
    @keyframes dashFloat2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-10px,15px)} }
    @keyframes dashShine { 0%{transform:translateX(-100%) skewX(-20deg)} 100%{transform:translateX(300%) skewX(-20deg)} }
    @keyframes dashGlow { 0%,100%{text-shadow:0 0 14px rgba(242,192,99,0.5)} 50%{text-shadow:0 0 24px rgba(242,192,99,0.8),0 0 40px rgba(217,164,65,0.4)} }

    /* ===== WELCOME BANNER 3D ===== */
    .welcome-3d {
        position: relative; padding: 32px 36px; margin-bottom: 28px;
        border-radius: 24px; overflow: hidden; color: white;
        background: linear-gradient(135deg, #043b2c 0%, #065f46 55%, #059669 100%);
        box-shadow: 0 20px 50px rgba(0,0,0,0.25);
    }
    .welcome-3d::before {
        content: ''; position: absolute; inset: 0;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 25px, rgba(217,164,65,0.04) 25px, rgba(217,164,65,0.04) 26px),
            repeating-linear-gradient(-45deg, transparent, transparent 25px, rgba(217,164,65,0.04) 25px, rgba(217,164,65,0.04) 26px);
    }
    .welcome-3d::after {
        content: ''; position: absolute; top: -40%; right: -10%;
        width: 300px; height: 300px; border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,0.25), transparent 70%);
        pointer-events: none;
    }
    .welcome-orb-1 { position: absolute; top: 10%; right: 5%; width: 100px; height: 100px; border-radius: 50%; background: radial-gradient(circle at 30% 30%, rgba(253,230,138,0.5), transparent 70%); filter: blur(2px); animation: dashFloat1 8s ease-in-out infinite; }
    .welcome-orb-2 { position: absolute; bottom: -20%; left: 8%; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle at 70% 70%, rgba(110,231,183,0.3), transparent 70%); filter: blur(3px); animation: dashFloat2 10s ease-in-out infinite; }
    .greet-ico-3d {
        display: inline-flex; align-items: center; justify-content: center;
        width: 54px; height: 54px; border-radius: 16px;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%),
                    linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441);
        font-size: 24px; flex-shrink: 0;
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -3px 4px rgba(0,0,0,0.2), 0 6px 16px rgba(217,164,65,0.45);
        position: relative;
    }
    .greet-ico-3d::before {
        content: ''; position: absolute; top: 5px; left: 10px;
        width: 16px; height: 7px; border-radius: 50%;
        background: rgba(255,255,255,0.65); filter: blur(1.5px);
    }
    .welcome-name-3d {
        background: linear-gradient(135deg, #fff 0%, #fde68a 100%);
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent;
        font-family: var(--font-display); font-weight: 900;
    }
    .welcome-role-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 12px; border-radius: 999px;
        font-size: 10.5px; font-weight: 800; letter-spacing: 0.1em;
        background: rgba(217,164,65,0.25); border: 1px solid rgba(217,164,65,0.4);
        color: #fde68a; text-transform: uppercase;
    }

    /* ===== 3D STATS CARDS ===== */
    .stats-grid-3d { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 28px; }
    .stat-card-3d {
        position: relative; padding: 22px; border-radius: 20px;
        background: var(--surface); border: 1px solid var(--border);
        text-decoration: none; color: inherit; overflow: hidden;
        transition: all 0.35s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
        display: flex; flex-direction: column; gap: 12px;
    }
    .stat-card-3d::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, #d9a441, #059669);
        transform: scaleX(0); transform-origin: left;
        transition: transform 0.4s ease;
    }
    .stat-card-3d::after {
        content: ''; position: absolute; bottom: -40%; right: -20%;
        width: 140px; height: 140px; border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,0.06), transparent 70%);
        pointer-events: none;
    }
    .stat-card-3d:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 36px rgba(5,150,105,0.18);
        border-color: rgba(5,150,105,0.3);
    }
    .stat-card-3d:hover::before { transform: scaleX(1); }
    .stat-card-3d:hover .stat-ico-3d { transform: scale(1.12) rotate(-6deg); }
    .stat-ico-3d {
        width: 52px; height: 52px; border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 24px; flex-shrink: 0; position: relative;
        transition: transform 0.35s cubic-bezier(0.16,1,0.3,1);
    }
    .stat-ico-3d::before {
        content: ''; position: absolute; top: 5px; left: 10px;
        width: 16px; height: 7px; border-radius: 50%;
        background: rgba(255,255,255,0.6); filter: blur(1.5px);
    }
    .ico-admin-gold { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%), linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441); box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -3px 4px rgba(0,0,0,0.2), 0 6px 14px rgba(217,164,65,0.4); }
    .ico-admin-emerald { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #34d399, #10b981 50%, #059669); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 14px rgba(5,150,105,0.35); }
    .ico-admin-blue { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #60a5fa, #3b82f6 50%, #1d4ed8); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 14px rgba(59,130,246,0.35); }
    .ico-admin-purple { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #c4b5fd, #a78bfa 50%, #7c3aed); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 14px rgba(124,58,237,0.35); }
    .ico-admin-red { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #fca5a5, #f87171 50%, #dc2626); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 14px rgba(220,38,38,0.35); }
    .ico-admin-teal { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #5eead4, #14b8a6 50%, #0f766e); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 14px rgba(20,184,166,0.35); }
    
    .stat-num-3d { font-family: var(--font-display); font-size: 32px; font-weight: 900; line-height: 1; background: linear-gradient(135deg, #fde68a, #f2c063 40%, #d9a441); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; animation: dashGlow 3s ease-in-out infinite; }
    .stat-label-3d { font-size: 13px; color: var(--muted); font-weight: 600; }
    .stat-arrow-3d { position: absolute; top: 20px; right: 20px; width: 28px; height: 28px; border-radius: 50%; background: rgba(5,150,105,0.1); color: var(--primary-dark); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 900; transition: all 0.3s; }
    .stat-card-3d:hover .stat-arrow-3d { background: linear-gradient(145deg, #fde68a, #d9a441); color: #03251f; transform: translateX(3px); }

    /* ===== DASHBOARD LAYOUT 2 COLS ===== */
    .dash-2col { display: grid; grid-template-columns: 2fr 1fr; gap: 22px; }
    @media (max-width: 900px) { .dash-2col { grid-template-columns: 1fr; } }

    /* ===== SECTION 3D CARD ===== */
    .section-3d { background: var(--surface); border: 1px solid var(--border); border-radius: 22px; padding: 24px; overflow: hidden; box-shadow: 0 4px 14px rgba(0,0,0,0.04); }
    .section-3d-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px dashed var(--border); }
    .section-3d-title { display: flex; align-items: center; gap: 10px; font-size: 16px; font-weight: 800; color: var(--ink); font-family: var(--font-display); margin: 0; }
    .section-3d-title::before { content: ''; width: 8px; height: 8px; border-radius: 50%; background: radial-gradient(circle at 30% 30%, #fde68a, #d9a441); box-shadow: 0 0 10px rgba(217,164,65,0.6); }

    /* ===== QUICK ACTIONS 3D ===== */
    .qa-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .qa-btn-3d { position: relative; display: flex; align-items: center; gap: 10px; padding: 14px 16px; border-radius: 14px; text-decoration: none; color: var(--ink); background: linear-gradient(145deg, #f6faf7, #ffffff); border: 1px solid var(--border); font-weight: 700; font-size: 13px; transition: all 0.25s cubic-bezier(0.16,1,0.3,1); overflow: hidden; }
    .qa-btn-3d::after { content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%; background: linear-gradient(105deg, transparent, rgba(255,255,255,0.6), transparent); transition: left 0.6s; }
    .qa-btn-3d:hover { transform: translateY(-2px); border-color: rgba(5,150,105,0.3); box-shadow: 0 8px 18px rgba(5,150,105,0.15); }
    .qa-btn-3d:hover::after { left: 150%; }
    .qa-ico-3d { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; position: relative; }
    .qa-ico-3d::before { content: ''; position: absolute; top: 3px; left: 7px; width: 12px; height: 5px; border-radius: 50%; background: rgba(255,255,255,0.6); filter: blur(1px); }
    .qa-gold { background: linear-gradient(145deg, #fde68a, #d9a441); box-shadow: inset 0 1px 2px rgba(255,255,255,0.7), inset 0 -1px 2px rgba(0,0,0,0.15); }
    .qa-emerald { background: linear-gradient(145deg, #34d399, #10b981); box-shadow: inset 0 1px 2px rgba(255,255,255,0.6), inset 0 -1px 2px rgba(0,0,0,0.2); }
    .qa-blue { background: linear-gradient(145deg, #60a5fa, #3b82f6); box-shadow: inset 0 1px 2px rgba(255,255,255,0.6), inset 0 -1px 2px rgba(0,0,0,0.2); }
    .qa-purple { background: linear-gradient(145deg, #c4b5fd, #a78bfa); box-shadow: inset 0 1px 2px rgba(255,255,255,0.6), inset 0 -1px 2px rgba(0,0,0,0.2); }

    /* ===== ACTIVITY ROW 3D ===== */
    .act-row-3d { display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 14px; transition: background 0.25s; border-bottom: 1px solid var(--border); }
    .act-row-3d:last-child { border-bottom: none; }
    .act-row-3d:hover { background: rgba(5,150,105,0.04); }
    .act-ico-3d { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; background: linear-gradient(145deg, #f6faf7, #ffffff); border: 1px solid var(--border); box-shadow: inset 0 1px 1px rgba(255,255,255,0.9); }
    .act-title-3d { font-size: 13px; font-weight: 700; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 0; }
    .act-meta-3d { font-size: 10.5px; color: var(--muted); display: flex; gap: 6px; align-items: center; margin-top: 2px; }
    .act-type-badge { padding: 1px 7px; border-radius: 999px; font-size: 9px; font-weight: 800; letter-spacing: 0.05em; background: rgba(5,150,105,0.12); color: var(--primary-dark); }

    /* ===== SYSTEM HEALTH 3D ===== */
    .sys-row-3d { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border); }
    .sys-row-3d:last-child { border-bottom: none; }
    .sys-label-3d { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--ink); font-weight: 600; }
    .sys-dot-3d { width: 10px; height: 10px; border-radius: 50%; background: radial-gradient(circle at 30% 30%, #6ee7b7, #10b981); box-shadow: inset 0 -1px 2px rgba(0,0,0,0.2), 0 0 8px rgba(16,185,129,0.6); animation: dashGlow 2s ease-in-out infinite; }
    .sys-val-3d { font-family: var(--font-display); font-weight: 900; color: var(--primary-dark); font-size: 13px; }

    /* ===== DRAFT ALERT 3D ===== */
    .draft-alert-3d { display: flex; align-items: center; gap: 14px; padding: 14px 18px; margin-bottom: 20px; background: linear-gradient(145deg, #fef3c7, #fde68a); border: 1px solid rgba(217,164,65,0.4); border-radius: 16px; box-shadow: inset 0 1px 2px rgba(255,255,255,0.7), inset 0 -2px 3px rgba(0,0,0,0.05), 0 6px 16px rgba(217,164,65,0.2); position: relative; overflow: hidden; }
    .draft-alert-3d::after { content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%; background: linear-gradient(105deg, transparent, rgba(255,255,255,0.5), transparent); animation: dashShine 3s ease-in-out infinite; }
    .draft-ico-3d { width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0; background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.6), transparent 40%), linear-gradient(145deg, #f87171, #dc2626 60%, #991b1b); display: flex; align-items: center; justify-content: center; font-size: 18px; box-shadow: inset 0 2px 3px rgba(255,255,255,0.5), inset 0 -2px 3px rgba(0,0,0,0.25), 0 4px 10px rgba(220,38,38,0.3); position: relative; }
    .draft-ico-3d::before { content: ''; position: absolute; top: 4px; left: 8px; width: 14px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.5); filter: blur(1.5px); }
    .draft-count-3d { font-family: var(--font-display); font-size: 20px; font-weight: 900; color: #92400e; margin-right: 4px; }
</style>

<!-- ================= WELCOME BANNER 3D ================= -->
<div class="welcome-3d">
    <div class="welcome-orb-1"></div>
    <div class="welcome-orb-2"></div>

    <div style="position: relative; z-index: 1; display: flex; align-items: center; gap: 18px; flex-wrap: wrap;">
        <div class="greet-ico-3d"><?= $greetIcon ?></div>
        <div style="flex: 1; min-width: 240px;">
            <!-- HAPUS NAMA DI SINI BIAR TIDAK DOBEL DENGAN TOPBAR -->
            <h2 style="margin: 0 0 6px; font-size: clamp(20px, 2.6vw, 26px); font-weight: 900; letter-spacing: -0.02em;">
                <?= $greeting ?>, <span class="welcome-name-3d">Admin</span> 👋
            </h2>
            <p style="margin: 0 0 10px; opacity: 0.85; font-size: 14px; line-height: 1.5;">
                Kelola penelitian, pengabdian, publikasi, HAKI, dan Catur Dharma dari satu panel kendali.
            </p>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <span class="welcome-role-badge">✦ <?= e(ucfirst(str_replace('_', ' ', $adminRole))) ?></span>
                <span class="welcome-role-badge" style="background: rgba(16,185,129,0.2); border-color: rgba(16,185,129,0.35); color: #6ee7b7;">
                    📅 <?= e(date('d M Y')) ?>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- ================= DRAFT ALERT 3D ================= -->
<?php if ($totalDraft > 0): ?>
<div class="draft-alert-3d">
    <div class="draft-ico-3d">⚠️</div>
    <div style="flex: 1; position: relative; z-index: 1;">
        <p style="margin: 0; font-size: 14px; color: #92400e; font-weight: 700;">
            Ada <span class="draft-count-3d"><?= $totalDraft ?></span> draft menunggu review Anda
        </p>
        <p style="margin: 2px 0 0; font-size: 11.5px; color: #a9761b;">
            <?= $draftNews ?> berita · <?= $draftDoc ?> dokumen
        </p>
    </div>
    <a href="<?= e(url('admin/index.php?page=berita')) ?>" style="position: relative; z-index: 1; padding: 8px 16px; border-radius: 10px; background: linear-gradient(145deg, #043b2c, #065f46); color: #fde68a; text-decoration: none; font-size: 12px; font-weight: 800; box-shadow: inset 0 1px 1px rgba(255,255,255,0.1), 0 3px 8px rgba(0,0,0,0.2);">
        Review →
    </a>
</div>
<?php endif; ?>

<!-- ================= STATS CARDS 3D ================= -->
<div class="stats-grid-3d">
    <?php foreach ($counts as $c): ?>
        <a class="stat-card-3d" href="<?= e(url('admin/index.php?page=' . $c[3])) ?>">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div class="stat-ico-3d <?= $c[4] ?>"><?= $c[0] ?></div>
                <div>
                    <div class="stat-num-3d"><?= (int) $c[2] ?></div>
                    <div class="stat-label-3d"><?= e($c[1]) ?></div>
                </div>
            </div>
            <div class="stat-arrow-3d">→</div>
        </a>
    <?php endforeach; ?>
</div>

<!-- ================= 2 COL LAYOUT ================= -->
<div class="dash-2col">

    <!-- LEFT: RECENT ACTIVITY -->
    <div class="section-3d">
        <div class="section-3d-head">
            <h3 class="section-3d-title">⚡ Aktivitas Terbaru</h3>
            <span style="font-size: 10px; font-weight: 800; letter-spacing: 0.1em; color: var(--muted);">LIVE</span>
        </div>

        <?php if (empty($recentActivity)): ?>
            <p style="font-size: 13px; color: var(--muted); text-align: center; padding: 20px 0;">Belum ada aktivitas.</p>
        <?php else: ?>
            <?php foreach ($recentActivity as $r): ?>
                <div class="act-row-3d">
                    <div class="act-ico-3d"><?= $r['icon'] ?></div>
                    <div style="flex: 1; min-width: 0;">
                        <p class="act-title-3d"><?= e($r['title']) ?></p>
                        <div class="act-meta-3d">
                            <span class="act-type-badge"><?= e($r['type']) ?></span>
                            <span>📅 <?= e(date('d M Y', strtotime($r['date']))) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- RIGHT: QUICK ACTIONS + HEALTH -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        <!-- Quick Actions -->
        <div class="section-3d">
            <div class="section-3d-head">
                <h3 class="section-3d-title">🚀 Aksi Cepat</h3>
            </div>
            <div class="qa-grid">
                <?php foreach ($quickActions as $qa): ?>
                    <a href="<?= e(url('admin/index.php?page=' . $qa[2])) ?>" class="qa-btn-3d">
                        <div class="qa-ico-3d <?= $qa[3] ?>"><?= $qa[0] ?></div>
                        <span><?= e($qa[1]) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- System Health -->
        <div class="section-3d">
            <div class="section-3d-head">
                <h3 class="section-3d-title">💚 Kesehatan Sistem</h3>
            </div>
            <div class="sys-row-3d">
                <div class="sys-label-3d"><span class="sys-dot-3d"></span> Database</div>
                <div class="sys-val-3d">Online</div>
            </div>
            <div class="sys-row-3d">
                <div class="sys-label-3d"><span class="sys-dot-3d"></span> Upload Storage</div>
                <div class="sys-val-3d">OK</div>
            </div>
            <div class="sys-row-3d">
                <div class="sys-label-3d"><span class="sys-dot-3d"></span> Session Aktif</div>
                <div class="sys-val-3d"><?= e(explode(' ', $adminName)[0]) ?></div>
            </div>
            <div class="sys-row-3d">
                <div class="sys-label-3d"><span class="sys-dot-3d"></span> Versi</div>
                <div class="sys-val-3d">v4.0 Elevate</div>
            </div>
        </div>
    </div>
</div>