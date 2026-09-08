<?php
$s = Setting::all();

// --- INFO KONTAK DINAMIS ---
$fc = null;
try { $fc = ContactInfo::get(); } catch (\Throwable $e) { $fc = null; }
$fcAddress = $fc['address']      ?? 'Kampus UNIMOF, Jl. Wairklau, Maumere, NTT';
$fcEmail   = $fc['email']        ?? 'lp3m@unimof.ac.id';
$fcPhone   = $fc['phone']        ?? '+62 380 000 000';
$fcHours   = $fc['office_hours'] ?? 'Senin–Jumat, 08.00–16.00 WITA';

// --- ANTI-DOBEL COPYRIGHT ---
$brand      = e($s['site_brand'] ?? 'LP3M');
$footerText = trim((string)($s['footer_text'] ?? ''));
if ($footerText === '') {
    $footerLine = '&copy; ' . date('Y') . ' ' . $brand . '. All rights reserved.';
} elseif (strpos($footerText, '©') !== false) {
    $footerLine = e($footerText);
} else {
    $footerLine = '&copy; ' . date('Y') . ' ' . $brand . '. ' . e($footerText);
}

// --- LIVE EVENT TICKER ---
$upcomingCount = 0;
$tickerEvents = [];
try {
    $db = Database::pdo();
    $upcomingCount = (int) $db->query("SELECT COUNT(*) FROM events WHERE status='published' AND start_date >= CURDATE() AND start_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)")->fetchColumn();
    if ($upcomingCount > 0) {
        $tickerEvents = $db->query("SELECT title, start_date FROM events WHERE status='published' AND start_date >= CURDATE() ORDER BY start_date ASC LIMIT 4")->fetchAll();
    }
} catch (\Throwable $e) { $upcomingCount = 0; }

// --- PLAGIAT COUNT ---
$publicPlagCount = 0;
try { $publicPlagCount = (int) Database::pdo()->query("SELECT COUNT(*) FROM plagiarism_checks WHERE status='completed'")->fetchColumn(); } catch (\Throwable $e) {}

// --- SEO DINAMIS ---
$__page = $_GET['page'] ?? 'home';
$__descMap = [
    'home' => 'Portal resmi LP3M/LPPAIK UNIMOF — pusat informasi penelitian, pengabdian, publikasi, AIK, dan layanan mutu.',
    'tentang' => 'Profil, visi misi, dan struktur organisasi LP3M/LPPAIK UNIMOF.',
    'berita' => 'Berita dan pengumuman terbaru seputar kegiatan lembaga.',
    'galeri' => 'Dokumentasi visual kegiatan penelitian, pengabdian, dan AIK.',
    'penelitian' => 'Rekam jejak penelitian dosen: skema, pendanaan, dan luaran.',
    'pengabdian' => 'Program pengabdian kepada masyarakat, KKN, dan desa binaan.',
    'publikasi' => 'Jurnal, prosiding, dan artikel ilmiah civitas akademika.',
    'haki' => 'Hak kekayaan intelektual: paten, hak cipta, dan merek.',
    'aik' => 'Kegiatan Al-Islam dan Kemuhammadiyahan lembaga.',
    'hibah' => 'Informasi hibah dan pendanaan penelitian serta pengabdian.',
    'unduhan' => 'Pusat unduhan template, formulir, dan dokumen resmi.',
    'kontak' => 'Kontak resmi lembaga dan pertanyaan yang sering diajukan.',
    'panduan' => 'Panduan lengkap menggunakan layanan digital LP3M.',
    'agenda' => 'Kalender dan agenda kegiatan lembaga.',
    'cek-plagiat' => 'Pemeriksaan similaritas dokumen terhadap korpus internal.',
    'verifikasi-sertifikat' => 'Verifikasi keaslian sertifikat digital lembaga.',
];
$__desc      = $seoDescription ?? ($__descMap[$__page] ?? ('Informasi resmi ' . $brand . '.'));
$__canonical = ($__page === 'home') ? url('public/index.php') : url('public/index.php?page=' . $__page);
$__ogImage   = !empty($s['logo_path']) ? upload_url($s['logo_path']) : url('public/assets/img/favicon.svg');
$__pageTitle = $title ?? ($brand . ' — Lembaga Penelitian & Pengabdian');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($__pageTitle) ?></title>
    <meta name="description" content="<?= e($__desc) ?>">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#065f46">
    <link rel="canonical" href="<?= e($__canonical) ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= e($brand) ?>">
    <meta property="og:locale" content="id_ID">
    <meta property="og:title" content="<?= e($__pageTitle) ?>">
    <meta property="og:description" content="<?= e($__desc) ?>">
    <meta property="og:url" content="<?= e($__canonical) ?>">
    <meta property="og:image" content="<?= e($__ogImage) ?>">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?= e($__pageTitle) ?>">
    <meta name="twitter:description" content="<?= e($__desc) ?>">

    <link rel="icon" href="<?= e(!empty($s['favicon_path']) ? upload_url($s['favicon_path']) : url('public/assets/img/favicon.svg')) ?>">
    <link rel="stylesheet" href="<?= e(url('public/assets/css/public.css')) ?>">

    <style>
        /* ============ KEYFRAMES ============ */
        @keyframes topbarIn { from { transform: translateY(-100%); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        @keyframes navPop { from { transform: translateY(-12px) scale(0.85); opacity: 0; } to { transform: translateY(0); scale(1); opacity: 1; } }
        @keyframes fadeUp { from { transform: translateY(24px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        @keyframes wiggle { 0%,100% { transform: rotate(0); } 25% { transform: rotate(-8deg) scale(1.1); } 75% { transform: rotate(8deg) scale(1.1); } }
        @keyframes underlineGlow { 0%,100% { box-shadow: 0 0 6px rgba(217,164,65,0.4); } 50% { box-shadow: 0 0 14px rgba(217,164,65,0.9); } }
        @keyframes wmFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        @keyframes brandPulse { 0%,100% { box-shadow: 0 0 0 3px var(--gold-soft), 0 0 10px rgba(217,164,65,0.5); } 50% { box-shadow: 0 0 0 6px var(--gold-soft), 0 0 18px rgba(217,164,65,0.9); } }
        @keyframes logoFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-3px); } }
        @keyframes orbDrift1 { 0%,100% { transform: translate(0,0); } 50% { transform: translate(30px,-40px); } }
        @keyframes orbDrift2 { 0%,100% { transform: translate(0,0); } 50% { transform: translate(-40px,30px); } }
        @keyframes ringSpin { to { transform: rotate(360deg); } }
        @keyframes monogramPop { 0% { transform: scale(0.4); opacity: 0; } 60% { transform: scale(1.15); } 100% { transform: scale(1); opacity: 1; } }
        @keyframes shimmerText { 0% { background-position: -200% center; } 100% { background-position: 200% center; } }
        @keyframes typingCaret { 0%,100% { border-color: transparent; } 50% { border-color: #f2c063; } }
        @keyframes confettiFall { to { transform: translateY(110vh) rotate(720deg); opacity: 0; } }
        @keyframes dropdownFade { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes tickerScroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        /* ============ SPLASH ============ */
        #splash { position: fixed; inset: 0; z-index: 99999; background: linear-gradient(135deg, #043b2c, #065f46 60%, #059669); display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 18px; transition: opacity 0.8s cubic-bezier(0.4,0,0.2,1), visibility 0.8s, transform 0.8s ease; }
        #splash::before { content: ''; position: absolute; inset: 0; background-image: repeating-linear-gradient(45deg, transparent, transparent 30px, rgba(217,164,65,0.05) 30px, rgba(217,164,65,0.05) 31px), repeating-linear-gradient(-45deg, transparent, transparent 30px, rgba(217,164,65,0.05) 30px, rgba(217,164,65,0.05) 31px); }
        #splash.done { opacity: 0; visibility: hidden; pointer-events: none; transform: scale(1.1); }
        .splash-ring { width: 104px; height: 104px; border-radius: 50%; border: 3px solid rgba(242,192,99,0.2); border-top-color: #f2c063; border-right-color: rgba(242,192,99,0.6); animation: ringSpin 1.1s cubic-bezier(0.6,0.1,0.4,0.9) infinite; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 40px rgba(217,164,65,0.25), inset 0 0 20px rgba(217,164,65,0.1); position: relative; z-index: 1; }
        .splash-logo { font-family: var(--font-display); font-weight: 900; font-size: 30px; color: #fde68a; letter-spacing: -0.03em; animation: monogramPop 0.9s cubic-bezier(0.16,1,0.3,1) both; text-shadow: 0 2px 0 rgba(0,0,0,0.3), 0 8px 24px rgba(217,164,65,0.4); }
        .splash-tag { font-size: 11px; font-weight: 800; letter-spacing: 0.3em; color: rgba(255,255,255,0.8); text-transform: uppercase; position: relative; z-index: 1; border-right: 2px solid #f2c063; padding-right: 4px; animation: fadeUp 0.8s 0.3s both, typingCaret 1s infinite; min-height: 1.2em; }

        /* ============ CURSOR & ORBS ============ */
        #cursor-glow { position: fixed; left: 0; top: 0; width: 360px; height: 360px; margin: -180px 0 0 -180px; border-radius: 50%; pointer-events: none; z-index: 2; background: radial-gradient(circle, rgba(242,192,99,0.13), rgba(16,185,129,0.09) 45%, transparent 70%); opacity: 0; transition: opacity 0.4s ease; will-change: transform; }
        body:hover #cursor-glow { opacity: 1; }
        @media (pointer: coarse) { #cursor-glow { display: none; } }
        .bg-orb { position: fixed; border-radius: 50%; pointer-events: none; z-index: -1; filter: blur(4px); will-change: transform; }
        .bg-orb-1 { width: 260px; height: 260px; top: 18%; left: -90px; background: radial-gradient(circle at 30% 30%, rgba(242,192,99,0.35), rgba(217,164,65,0.12) 60%, transparent); animation: orbDrift1 12s ease-in-out infinite; }
        .bg-orb-2 { width: 320px; height: 320px; bottom: 12%; right: -110px; background: radial-gradient(circle at 70% 70%, rgba(16,185,129,0.30), rgba(5,150,105,0.10) 60%, transparent); animation: orbDrift2 14s ease-in-out infinite; }
        #scroll-progress { position: fixed; top: 0; left: 0; right: 0; height: 4px; z-index: 1002; background: linear-gradient(90deg, #f2c063, #d9a441, #10b981, #059669); transform: scaleX(0); transform-origin: left; box-shadow: 0 1px 8px rgba(217,164,65,0.5); pointer-events: none; }

        /* ============ TOPBAR ============ */
        .topbar { animation: topbarIn 0.6s cubic-bezier(0.16,1,0.3,1) backwards; transition: transform 0.35s ease, background 0.3s ease; }
        .topbar.topbar-hidden { transform: translateY(-110%); }
        .site-logo { animation: logoFloat 5s ease-in-out infinite; }
        .topbar-inner { display: flex; align-items: center; justify-content: space-between; gap: 18px; }
        #main-menu { flex: 1; display: flex; justify-content: center; }
        .menu-toggle { flex: 0 0 auto; }

        /* 🆕 BRAND BESAR & JELAS */
        .brand { display: flex; align-items: center; gap: 13px; text-decoration: none; flex: 0 0 auto; }
        .brand .site-logo { height: 56px; width: auto; border-radius: 15px; box-shadow: 0 8px 20px rgba(3,37,31,.22), inset 0 1px 2px rgba(255,255,255,.4); }
        .brand-txt { display: flex; flex-direction: column; line-height: 1.08; }
        .brand-txt b { font-family: var(--font-display); font-size: 21px; font-weight: 900; color: var(--ink); letter-spacing: -0.02em; }
        .brand-txt span { font-size: 9px; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; color: var(--muted); }

        .menu > li { animation: navPop 0.55s cubic-bezier(0.16,1,0.3,1) both; list-style: none; }
        .menu > li:nth-child(1) { animation-delay: 0.10s; } .menu > li:nth-child(2) { animation-delay: 0.16s; }
        .menu > li:nth-child(3) { animation-delay: 0.22s; } .menu > li:nth-child(4) { animation-delay: 0.28s; }
        .menu > li:nth-child(5) { animation-delay: 0.34s; } .menu > li:nth-child(6) { animation-delay: 0.40s; }
        .menu > li:nth-child(7) { animation-delay: 0.46s; }
        .menu a:hover .nav-ico { animation: wiggle 0.45s ease; }
        .menu a.active::after { animation: underlineGlow 2s ease-in-out infinite; }
        .main { animation: fadeUp 0.7s 0.15s cubic-bezier(0.16,1,0.3,1) both; }

        .nav-ico { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; min-width: 32px; min-height: 32px; border-radius: 9px; font-size: 15px; line-height: 1; flex-shrink: 0; transition: all 0.25s cubic-bezier(0.16,1,0.3,1); }
        .nav-ico svg { width: 18px; height: 18px; stroke-width: 2.2; }
        .menu { display: flex; align-items: center; gap: 4px; flex-wrap: nowrap; padding: 0; margin: 0; }
        .has-dropdown { position: relative; }
        .dropdown-toggle { cursor: pointer; display: flex; align-items: center; gap: 6px; }
        .dropdown-toggle::after { content: '▾'; font-size: 10px; opacity: 0.7; transition: transform 0.3s; }
        .has-dropdown:hover .dropdown-toggle::after { transform: rotate(180deg); }
        .dropdown-menu { position: absolute; top: 100%; left: 50%; transform: translateX(-50%) translateY(10px); background: rgba(255,255,255,0.98); backdrop-filter: blur(12px); border: 1px solid var(--border); border-radius: 16px; padding: 12px; min-width: 230px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); opacity: 0; visibility: hidden; transition: all 0.3s cubic-bezier(0.16,1,0.3,1); z-index: 1000; display: flex; flex-direction: column; gap: 4px; }
        .has-dropdown:hover .dropdown-menu { opacity: 1; visibility: visible; transform: translateX(-50%) translateY(0); }
        .mega-dropdown { min-width: 480px; padding: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .mega-dropdown .dropdown-item { display: flex; align-items: center; gap: 12px; padding: 10px; border-radius: 10px; transition: all 0.2s; text-decoration: none; color: var(--text); }
        .mega-dropdown .dropdown-item:hover { background: linear-gradient(145deg, #10b981, #059669); transform: translateX(4px); box-shadow: 0 4px 12px rgba(5,150,105,0.3); }
        .mega-dropdown .dropdown-item:hover .item-text strong, .mega-dropdown .dropdown-item:hover .item-text span { color: #ffffff !important; }
        .mega-dropdown .dropdown-item:hover .nav-ico { background: rgba(255,255,255,0.2); border-color: transparent; color: white; }
        .mega-dropdown .dropdown-item:hover .nav-ico svg { stroke: white; }
        .mega-dropdown .dropdown-item .nav-ico { width: 36px; height: 36px; background: linear-gradient(145deg, #e9f7ec, #d5ecdd); border: 1px solid var(--border-soft); transition: all 0.2s; }
        .mega-dropdown .item-text strong { display: block; font-size: 13px; font-weight: 700; color: var(--ink); transition: color 0.2s; }
        .mega-dropdown .item-text span { font-size: 11px; color: var(--muted); transition: color 0.2s; }
        .dropdown-menu .dropdown-link { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--text); text-decoration: none; transition: all 0.2s; }
        .dropdown-menu .dropdown-link:hover { background: linear-gradient(145deg, #10b981, #059669); color: #ffffff !important; padding-left: 16px; box-shadow: 0 4px 12px rgba(5,150,105,0.3); }
        .dropdown-menu .dropdown-link:hover svg { stroke: white; opacity: 1; }
        .dropdown-menu .dropdown-link svg { width: 16px; height: 16px; opacity: 0.7; transition: all 0.2s; }
        .dropdown-item-badge { display: inline-flex; align-items: center; justify-content: center; min-width: 18px; height: 18px; border-radius: 999px; background: linear-gradient(145deg, #f2c063, #d9a441); color: #03251f; font-size: 9px; font-weight: 900; padding: 0 5px; margin-left: auto; }

        /* 🆕 LIVE TICKER RAPI — satu baris, teks berputar */
        .live-ticker { display: inline-flex; align-items: center; gap: 9px; max-width: 330px; padding: 7px 14px; border-radius: 999px; background: linear-gradient(145deg, rgba(16,185,129,0.16), rgba(5,150,105,0.08)); border: 1px solid rgba(16,185,129,0.35); text-decoration: none; color: #065f46; overflow: hidden; flex: 0 1 auto; transition: all .25s; }
        .live-ticker:hover { border-color: rgba(16,185,129,.6); box-shadow: 0 6px 16px rgba(16,185,129,.2); transform: translateY(-1px); }
        .live-ticker-dot { width: 8px; height: 8px; border-radius: 50%; background: #10b981; box-shadow: 0 0 0 0 rgba(16,185,129,0.6); animation: brandPulse 2s infinite; flex-shrink: 0; }
        .live-ticker-count { flex-shrink: 0; min-width: 23px; height: 22px; padding: 0 7px; border-radius: 999px; background: linear-gradient(145deg, #fde68a, #d9a441); color: #03251f; font-size: 11px; font-weight: 900; display: inline-flex; align-items: center; justify-content: center; box-shadow: inset 0 1px 2px rgba(255,255,255,.6); }
        .live-ticker-label { flex-shrink: 0; font-size: 10px; font-weight: 900; letter-spacing: .1em; text-transform: uppercase; color: #047857; }
        .live-ticker-text { flex: 1; min-width: 0; font-size: 11.5px; font-weight: 800; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; transition: opacity .35s, transform .35s; }
        .live-ticker-text.swap { opacity: 0; transform: translateY(7px); }
        .live-ticker-arrow { flex-shrink: 0; font-weight: 900; color: #059669; }
        @media (max-width: 1200px) { .live-ticker-text, .live-ticker-label { display: none; } .live-ticker { max-width: none; } }
        @media (max-width: 900px) { .live-ticker { display: none; } }

        @media (max-width: 900px) {
            .topbar-inner { justify-content: space-between; }
            #main-menu { position: absolute; top: 76px; left: 0; width: 100%; justify-content: flex-start; z-index: 999; }
            .menu { flex-direction: column; align-items: stretch; width: 100%; background: white; padding: 20px; border-radius: 0 0 16px 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); display: none; }
            .menu.show { display: flex; }
            .has-dropdown { width: 100%; }
            .dropdown-menu, .mega-dropdown { position: static; transform: none; opacity: 1; visibility: visible; box-shadow: none; border: none; background: rgba(0,0,0,0.03); margin-top: 8px; padding: 10px; display: none; grid-template-columns: 1fr; }
            .has-dropdown.active .dropdown-menu, .has-dropdown.active .mega-dropdown { display: flex; }
            .dropdown-toggle { justify-content: space-between; width: 100%; padding: 12px; background: rgba(0,0,0,0.03); border-radius: 8px; }
            .dropdown-toggle::after { content: '+'; font-size: 16px; }
            .has-dropdown.active .dropdown-toggle::after { content: '-'; }
            .mega-dropdown .dropdown-item:active, .dropdown-menu .dropdown-link:active { background: #059669; color: white; }
            .mega-dropdown .dropdown-item:active .item-text strong, .mega-dropdown .dropdown-item:active .item-text span { color: white; }
        }

        /* ============ FOOTER ============ */
        .soc-3d { position: relative; width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; cursor: pointer; transition: transform 0.35s cubic-bezier(0.16,1,0.3,1), box-shadow 0.35s; overflow: hidden; }
        .soc-3d::before { content: ''; position: absolute; top: 6px; left: 10px; width: 14px; height: 7px; border-radius: 50%; background: rgba(255,255,255,0.5); filter: blur(2px); }
        .soc-3d:hover { transform: translateY(-4px) rotate(-8deg) scale(1.08); }
        .soc-fb { background: radial-gradient(circle at 30% 30%, #4dabf7, #1877F2 60%, #0a4fa3); box-shadow: 0 6px 14px rgba(24,119,242,0.5), inset 0 -4px 8px rgba(0,0,0,0.3); color: white; }
        .soc-ig { background: radial-gradient(circle at 30% 30%, #fec260, #e1306c 50%, #833ab4); box-shadow: 0 6px 14px rgba(225,48,108,0.5), inset 0 -4px 8px rgba(0,0,0,0.3); color: white; }
        .soc-yt { background: radial-gradient(circle at 30% 30%, #ff6b6b, #ff0000 60%, #990000); box-shadow: 0 6px 14px rgba(255,0,0,0.45), inset 0 -4px 8px rgba(0,0,0,0.3); color: white; }
        .soc-em { background: radial-gradient(circle at 30% 30%, #f2c063, #d9a441 60%, #a9761b); box-shadow: 0 6px 14px rgba(217,164,65,0.5), inset 0 -4px 8px rgba(0,0,0,0.3); color: #03251f; }
        .wm-3d { position: absolute; bottom: -0.10em; left: 0; right: 0; text-align: center; font-family: var(--font-display); font-size: clamp(90px, 17vw, 200px); font-weight: 900; letter-spacing: -0.05em; line-height: 1; pointer-events: none; user-select: none; background: linear-gradient(180deg, rgba(242,192,99,0.30) 0%, rgba(217,164,65,0.12) 55%, rgba(217,164,65,0.03) 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; -webkit-text-stroke: 1.5px rgba(242,192,99,0.18); text-shadow: 0 2px 0 rgba(0,0,0,0.28), 0 10px 30px rgba(217,164,65,0.20); animation: wmFloat 7s ease-in-out infinite; }
        .ft-hd { display: inline-flex; align-items: center; gap: 8px; color: #f2c063; font-size: 12px; font-weight: 800; letter-spacing: 0.18em; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 2px solid rgba(217,164,65,0.25); }
        .ft-hd::before { content: ''; width: 8px; height: 8px; border-radius: 50%; background: radial-gradient(circle at 30% 30%, #fde68a, #d9a441); box-shadow: 0 0 10px rgba(217,164,65,0.6); }
        .ft-link { display: inline-flex; align-items: center; gap: 8px; font-size: 14px; color: rgba(255,255,255,0.85); padding: 6px 0; transition: all 0.25s; }
        .ft-link:hover { color: #f2c063; transform: translateX(4px); }
        .ft-link::before { content: '▸'; color: #d9a441; font-weight: 800; }
        .ct-3d { display: flex; align-items: flex-start; gap: 12px; font-size: 13.5px; color: rgba(255,255,255,0.85); line-height: 1.6; }
        .ct-3d-ico { flex-shrink: 0; width: 32px; height: 32px; border-radius: 10px; background: linear-gradient(145deg, rgba(217,164,65,0.2), rgba(169,118,27,0.15)); border: 1px solid rgba(217,164,65,0.3); display: flex; align-items: center; justify-content: center; font-size: 15px; }
        .ft-smart-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 8px; }
        .ft-smart-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); text-decoration: none; color: rgba(255,255,255,0.9); transition: all 0.25s; font-size: 13px; }
        .ft-smart-item:hover { background: rgba(217,164,65,0.12); border-color: rgba(217,164,65,0.35); transform: translateX(4px); color: #f2c063; }
        .ft-smart-item .ft-smart-ico { font-size: 18px; flex-shrink: 0; }
        .ft-smart-item strong { display: block; font-size: 12px; color: inherit; }
        .ft-smart-item small { font-size: 10px; opacity: 0.65; }

        /* ============ SAGE OVERRIDES ============ */
        html, body { overflow-x: clip; }
        body { background: radial-gradient(1100px 560px at 88% -10%, rgba(5,150,105,0.30), transparent 62%), radial-gradient(950px 480px at -8% 28%, rgba(217,164,65,0.24), transparent 58%), linear-gradient(180deg, #9fd2b6 0%, #c0e0cb 45%, #a9d6c0 100%) !important; background-attachment: scroll !important; }
        :root { --bg: #b7dcc4; --white: #eef8f1; --surface: #eef8f1; --glass: rgba(186,224,201,0.92); --border: #a4cdb4; --border-soft: #b6d8c2; --muted: #52705c; --gold-soft: #f3e7c9; }
        .card, .news-card, .mod-card, .doc-row, .feed-3d, .qa-3d, .org-card, .news-detail, .about-box, .mission-list, .form-section-3d, .settings-form-3d, .preview-panel-3d, .section-3d { background: linear-gradient(165deg, #f6fcf7 0%, #e9f6ec 60%, #e0f1e4 100%) !important; border-color: var(--border) !important; }
        .topbar { background: var(--glass) !important; }
        .topbar.scrolled { background: rgba(214,238,222,0.97) !important; }
        .nav-ico { background: linear-gradient(145deg, #e9f7ec, #d5ecdd) !important; border: 1px solid var(--border-soft) !important; box-shadow: inset 0 1px 1px rgba(255,255,255,0.8), 0 2px 4px rgba(3,37,31,0.08) !important; }
        .menu a:last-child .nav-ico { background: linear-gradient(145deg, #065f46, #03251f) !important; border-color: rgba(217,164,65,0.4) !important; }
        .chip, .hijri-chip-3d, .cat-filter-3d, .partner-chip-3d { background: linear-gradient(145deg, #e2f3e6, #cfe9d6) !important; border-color: var(--border) !important; }
        .fg-3d input, .fg-3d select, .fg-3d textarea, .form-group input, .form-group select, .form-group textarea { background: linear-gradient(145deg, #eef9f1, #ddf0e2) !important; border-color: var(--border) !important; }
        .pagination a, .pag-3d a { background: linear-gradient(145deg, #e2f3e6, #cfe9d6) !important; border-color: var(--border) !important; }
        .news-thumb-placeholder, .news-empty { background: linear-gradient(135deg, #cbe7d4, #ddf0e2) !important; }
        ::-webkit-scrollbar-track { background: rgba(164,205,180,0.4); }
        .footer { overflow: hidden !important; }
        .section--cream, .section--teal, .section--lavender { margin-left: 0 !important; margin-right: 0 !important; border-radius: 26px; padding: 42px 30px; }
        .marquee { margin: 36px 0 !important; border-radius: 18px; }
        a.jewel-btn { display: none !important; }
        @media (prefers-reduced-motion: reduce) { #splash { display: none; } #cursor-glow { display: none; } }
        @media print { #splash, #cursor-glow, .bg-orb, #scroll-progress, .back-to-top-jewel, .topbar { display: none !important; } body { background: white !important; } }
        .menu a:last-child { margin-left: 0 !important; padding: 8px 12px !important; border-radius: 10px !important; background: transparent !important; color: var(--text) !important; box-shadow: none !important; }
        .menu a:last-child::before { display: none !important; }
        .menu a:last-child:hover { transform: none !important; background: rgba(5,150,105,0.06) !important; color: var(--primary-dark) !important; box-shadow: none !important; }
        .menu a:last-child .nav-ico { background: linear-gradient(145deg, #e9f7ec, #d5ecdd) !important; border: 1px solid var(--border-soft) !important; box-shadow: inset 0 1px 1px rgba(255,255,255,0.8), 0 2px 4px rgba(3,37,31,0.08) !important; }
        .menu a.active { background: transparent !important; color: var(--primary-dark) !important; box-shadow: none !important; }
    </style>
</head>
<body id="top">

<div id="splash" aria-hidden="true">
    <div class="splash-ring"><span class="splash-logo">LP3M</span></div>
    <span class="splash-tag" id="splash-tag"></span>
</div>
<div id="cursor-glow" aria-hidden="true"></div>
<div class="bg-orb bg-orb-1" aria-hidden="true"></div>
<div class="bg-orb bg-orb-2" aria-hidden="true"></div>
<div id="scroll-progress"></div>

<!-- TOPBAR -->
<header class="topbar">
    <div class="container topbar-inner">
        <a href="<?= e(url('public/index.php?page=home')) ?>" class="brand">
            <?php if (!empty($s['logo_path'])): ?>
                <img class="site-logo" src="<?= e(upload_url($s['logo_path'])) ?>" alt="Logo <?= e($brand) ?>">
            <?php endif; ?>
            
        <?php if ($upcomingCount > 0): ?>
        <a class="live-ticker" href="<?= e(url('public/index.php?page=agenda')) ?>" title="Lihat agenda kegiatan">
            <span class="live-ticker-dot"></span>
            <span class="live-ticker-count"><?= $upcomingCount ?></span>
            <span class="live-ticker-label">Agenda</span>
            <span class="live-ticker-text" id="liveTickerText"><?= e($tickerEvents[0]['title'] ?? 'Kegiatan 30 hari ke depan') ?></span>
            <span class="live-ticker-arrow">→</span>
        </a>
        <?php endif; ?>

        <nav id="main-menu">
            <ul class="menu">
                <li><a href="<?= e(url('public/index.php?page=home')) ?>"><span class="nav-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></span>Beranda</a></li>

                <li class="has-dropdown">
                    <a href="#" class="dropdown-toggle"><span class="nav-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></span>Tentang</a>
                    <div class="dropdown-menu">
                        <a href="<?= e(url('public/index.php?page=tentang')) ?>" class="dropdown-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> Profil Lembaga</a>
                        <a href="<?= e(url('public/index.php?page=tentang#visi')) ?>" class="dropdown-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> Visi & Misi</a>
                        <a href="<?= e(url('public/index.php?page=tentang#struktur')) ?>" class="dropdown-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg> Struktur Organisasi</a>
                        <a href="<?= e(url('public/index.php?page=kontak')) ?>" class="dropdown-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg> Hubungi Kami</a>
                    </div>
                </li>

                <li><a href="<?= e(url('public/index.php?page=berita')) ?>"><span class="nav-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"></path><path d="M18 14h-8"></path><path d="M15 18h-5"></path><path d="M10 6h8v4h-8V6Z"></path></svg></span>Berita</a></li>

                <li><a href="<?= e(url('public/index.php?page=galeri')) ?>"><span class="nav-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg></span>Galeri</a></li>

                <li class="has-dropdown">
                    <a href="#" class="dropdown-toggle"><span class="nav-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg></span>Catur Dharma</a>
                    <div class="dropdown-menu mega-dropdown">
                        <a href="<?= e(url('public/index.php?page=penelitian')) ?>" class="dropdown-item">
                            <span class="nav-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 3h6v2H9V3zm-3 4h12v2H6V7zm2 4h8v10H8V11z"></path><path d="M10 15h4"></path></svg></span>
                            <div class="item-text"><strong>Penelitian</strong><span>Proposal & Laporan</span></div>
                        </a>
                        <a href="<?= e(url('public/index.php?page=pengabdian')) ?>" class="dropdown-item">
                            <span class="nav-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></span>
                            <div class="item-text"><strong>Pengabdian</strong><span>KKN & Desa Binaan</span></div>
                        </a>
                        <a href="<?= e(url('public/index.php?page=publikasi')) ?>" class="dropdown-item">
                            <span class="nav-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg></span>
                            <div class="item-text"><strong>Publikasi</strong><span>Jurnal & Prosiding</span></div>
                        </a>
                        <a href="<?= e(url('public/index.php?page=aik')) ?>" class="dropdown-item">
                            <span class="nav-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 6v6l4 2"></path></svg></span>
                            <div class="item-text"><strong>AIK</strong><span>Al-Islam Kemuhammadiyahan</span></div>
                        </a>
                    </div>
                </li>

                <li class="has-dropdown">
                    <a href="#" class="dropdown-toggle"><span class="nav-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></span>Layanan</a>
                    <div class="dropdown-menu">
                        <a href="<?= e(url('public/index.php?page=agenda')) ?>" class="dropdown-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            Agenda Kegiatan
                            <?php if ($upcomingCount > 0): ?><span class="dropdown-item-badge"><?= $upcomingCount ?></span><?php endif; ?>
                        </a>
                        <a href="<?= e(url('public/index.php?page=survei')) ?>" class="dropdown-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
    Survei Kepuasan
</a>
                        <a href="<?= e(url('public/index.php?page=panduan')) ?>" class="dropdown-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg> Panduan Layanan</a>
                        <a href="<?= e(url('public/index.php?page=unduhan')) ?>" class="dropdown-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> Unduhan Dokumen</a>
                        <a href="<?= e(url('public/index.php?page=hibah')) ?>" class="dropdown-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg> Hibah Aktif</a>
                        <a href="<?= e(url('public/index.php?page=verifikasi-sertifikat')) ?>" class="dropdown-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 15a7 7 0 1 0 0-14 7 7 0 0 0 0 14Z"></path><path d="M8.2 13.9 7 23l5-3 5 3-1.2-9.1"></path></svg> Verifikasi Sertifikat</a>
                        <a href="<?= e(url('public/index.php?page=cek-plagiat')) ?>" class="dropdown-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><path d="M8 11h6"></path><path d="M11 8v6"></path></svg>
                            Cek Plagiarisme
                            <?php if ($publicPlagCount > 0): ?><span class="dropdown-item-badge"><?= $publicPlagCount ?></span><?php endif; ?>
                        </a>
                    </div>
                </li>

                <li><a href="<?= e(url('admin/index.php?page=login')) ?>"><span class="nav-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></span>Login</a></li>
            </ul>
        </nav>

        <button id="menu-toggle" class="menu-toggle" type="button" aria-expanded="false" aria-label="Buka menu">☰</button>
    </div>
</header>

<main class="container main">
    <?= $content ?>
</main>

<!-- FOOTER -->
<footer class="footer">
    <div class="wm-3d" aria-hidden="true">LP3M</div>
    <div aria-hidden="true" style="position: absolute; top: 40px; right: -40px; width: 200px; height: 200px; border-radius: 50%; background: radial-gradient(circle, rgba(217,164,65,0.08), transparent 70%); pointer-events: none;"></div>
    <div aria-hidden="true" style="position: absolute; bottom: 60px; left: -60px; width: 160px; height: 160px; border-radius: 50%; background: radial-gradient(circle, rgba(16,185,129,0.1), transparent 70%); pointer-events: none;"></div>

    <div class="container" style="position: relative; z-index: 1;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 40px; padding: 30px 0 40px;">
            <div>
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <?php if (!empty($s['logo_path'])): ?>
                        <img src="<?= e(upload_url($s['logo_path'])) ?>" alt="Logo" style="height: 52px; border-radius: 14px;">
                    <?php endif; ?>
                    <span style="font-family: var(--font-display); font-weight: 800; font-size: 20px; color: #fff;"><?= e($s['site_brand'] ?? 'LP3M') ?></span>
                </div>
                <p style="font-size: 13.5px; line-height: 1.75; color: rgba(255,255,255,0.78); margin-bottom: 18px;">
                    Lembaga Penelitian, Pengabdian kepada Masyarakat, dan Al-Islam Kemuhammadiyahan
                    <strong style="color: #f2c063;">Universitas Muhammadiyah Gorontalo</strong>.
                </p>
                <p style="font-size: 11px; font-weight: 800; letter-spacing: 0.18em; color: #f2c063; margin-bottom: 10px;">IKUTI KAMI</p>
                <div style="display: flex; gap: 10px;" id="soc-row">
                    <a href="#" class="soc-3d soc-fb" aria-label="Facebook">📘</a>
                    <a href="#" class="soc-3d soc-ig" aria-label="Instagram">📸</a>
                    <a href="#" class="soc-3d soc-yt" aria-label="YouTube">▶️</a>
                    <a href="mailto:<?= e($fcEmail) ?>" class="soc-3d soc-em" aria-label="Email">✉️</a>
                </div>
            </div>

            <div>
                <h4 class="ft-hd">NAVIGASI</h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 2px; margin:0; padding:0;">
                    <li><a class="ft-link" href="<?= e(url('public/index.php?page=home')) ?>">Beranda</a></li>
                    <li><a class="ft-link" href="<?= e(url('public/index.php?page=tentang')) ?>">Tentang Kami</a></li>
                    <li><a class="ft-link" href="<?= e(url('public/index.php?page=berita')) ?>">Berita</a></li>
                    <li><a class="ft-link" href="<?= e(url('public/index.php?page=unduhan')) ?>">Dokumen</a></li>
                    <li><a class="ft-link" href="<?= e(url('public/index.php?page=galeri')) ?>">Galeri</a></li>
                    <li><a class="ft-link" href="<?= e(url('public/index.php?page=panduan')) ?>">Panduan Layanan</a></li>
                </ul>
            </div>

            <div>
                <h4 class="ft-hd">CATUR DHARMA</h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 2px; margin:0; padding:0;">
                    <li><a class="ft-link" href="<?= e(url('public/index.php?page=penelitian')) ?>">🔬 Penelitian</a></li>
                    <li><a class="ft-link" href="<?= e(url('public/index.php?page=pengabdian')) ?>">🤝 Pengabdian</a></li>
                    <li><a class="ft-link" href="<?= e(url('public/index.php?page=publikasi')) ?>">📚 Publikasi</a></li>
                    <li><a class="ft-link" href="<?= e(url('public/index.php?page=haki')) ?>">🛡️ HAKI</a></li>
                    <li><a class="ft-link" href="<?= e(url('public/index.php?page=aik')) ?>">🕌 AIK</a></li>
                </ul>
            </div>

            <div>
                <h4 class="ft-hd">LAYANAN CERDAS ✦</h4>
                <div class="ft-smart-grid">
                    <a href="<?= e(url('public/index.php?page=agenda')) ?>" class="ft-smart-item"><span class="ft-smart-ico">📅</span><div><strong>Agenda</strong><small><?= $upcomingCount ?> kegiatan</small></div></a>
                    <a href="<?= e(url('public/index.php?page=verifikasi-sertifikat')) ?>" class="ft-smart-item"><span class="ft-smart-ico">🎓</span><div><strong>Sertifikat</strong><small>Verifikasi online</small></div></a>
                    <a href="<?= e(url('public/index.php?page=cek-plagiat')) ?>" class="ft-smart-item"><span class="ft-smart-ico">🔍</span><div><strong>Cek Plagiat</strong><small><?= $publicPlagCount ?> laporan</small></div></a>
                    <a href="<?= e(url('public/index.php?page=hibah')) ?>" class="ft-smart-item"><span class="ft-smart-ico">💰</span><div><strong>Hibah</strong><small>Pendanaan riset</small></div></a>
                </div>
            </div>

            <div>
                <h4 class="ft-hd">HUBUNGI KAMI</h4>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div class="ct-3d"><span class="ct-3d-ico">📍</span><span><?= e($fcAddress) ?></span></div>
                    <div class="ct-3d"><span class="ct-3d-ico">✉️</span><span><?= e($fcEmail) ?></span></div>
                    <div class="ct-3d"><span class="ct-3d-ico">📞</span><span><?= e($fcPhone) ?></span></div>
                    <div class="ct-3d"><span class="ct-3d-ico">🕒</span><span><?= e($fcHours) ?></span></div>
                </div>
            </div>
        </div>

        <div style="border-top: 1px solid rgba(255,255,255,0.1); padding: 22px 0; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
            <p style="font-size: 13px; color: rgba(255,255,255,0.6); margin:0;"><?= $footerLine ?></p>
            <p style="font-size: 12px; color: rgba(255,255,255,0.5); margin:0;">⚡ <span style="color: #f2c063; font-weight: 700;">Fastabiqul Khairat</span></p>
        </div>
    </div>
</footer>

<script src="<?= e(url('public/assets/js/public.js')) ?>"></script>

<script>
(function () {
    'use strict';
    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var finePointer = window.matchMedia('(pointer: fine)').matches;

    // Splash
    var splash = document.getElementById('splash');
    var tag = document.getElementById('splash-tag');
    if (splash && tag) {
        var tagline = 'Fastabiqul Khairat';
        var i = 0;
        function type() { if (i <= tagline.length) { tag.textContent = tagline.slice(0, i); i++; setTimeout(type, 80); } }
        type();
        var kill = function () { splash.classList.add('done'); };
        window.addEventListener('load', function () { setTimeout(kill, 600); });
        setTimeout(kill, 3000);
    }

    // Cursor glow
    if (finePointer && !reduced) {
        var glow = document.getElementById('cursor-glow');
        var orb1 = document.querySelector('.bg-orb-1');
        var orb2 = document.querySelector('.bg-orb-2');
        var mx = 0, my = 0, gx = 0, gy = 0, ticking = false;
        document.addEventListener('mousemove', function (e) {
            mx = e.clientX; my = e.clientY;
            if (!ticking) {
                ticking = true;
                requestAnimationFrame(function () {
                    gx += (mx - gx) * 0.12; gy += (my - gy) * 0.12;
                    if (glow) glow.style.transform = 'translate(' + gx + 'px,' + gy + 'px)';
                    var cx = (mx / window.innerWidth - 0.5); var cy = (my / window.innerHeight - 0.5);
                    if (orb1) orb1.style.translate = (cx * 24) + 'px ' + (cy * 18) + 'px';
                    if (orb2) orb2.style.translate = (cx * -30) + 'px ' + (cy * -22) + 'px';
                    ticking = false;
                });
            }
        }, { passive: true });
    }

    // 🆕 Ticker rotator
    var tickerEl = document.getElementById('liveTickerText');
    if (tickerEl) {
        var items = <?= json_encode(array_map(function ($t) { return $t['title'] . ' · ' . date('d M', strtotime($t['start_date'])); }, $tickerEvents), JSON_UNESCAPED_UNICODE) ?>;
        if (items.length > 1) {
            var ti = 0;
            setInterval(function () {
                tickerEl.classList.add('swap');
                setTimeout(function () {
                    ti = (ti + 1) % items.length;
                    tickerEl.textContent = items[ti];
                    tickerEl.classList.remove('swap');
                }, 350);
            }, 3800);
        }
    }

    // Mobile menu
    var toggleBtn = document.getElementById('menu-toggle');
    var menu = document.getElementById('main-menu');
    if (toggleBtn && menu) {
        toggleBtn.addEventListener('click', function () {
            menu.classList.toggle('show');
            toggleBtn.innerHTML = menu.classList.contains('show') ? '✕' : '☰';
        });
        document.querySelectorAll('.has-dropdown > .dropdown-toggle').forEach(function (toggle) {
            toggle.addEventListener('click', function (e) {
                if (window.innerWidth <= 900) {
                    e.preventDefault();
                    this.parentElement.classList.toggle('active');
                }
            });
        });
    }

    // Social pop-in
    var socs = document.querySelectorAll('#soc-row .soc-3d');
    if (socs.length && 'IntersectionObserver' in window && !reduced) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) { if (en.isIntersecting) { socs.forEach(function (s) { s.classList.add('pop'); }); io.disconnect(); } });
        }, { threshold: 0.3 });
        io.observe(document.getElementById('soc-row'));
    }

    // Konami
    var seq = ['ArrowUp','ArrowUp','ArrowDown','ArrowDown','ArrowLeft','ArrowRight','ArrowLeft','ArrowRight','b','a'];
    var pos = 0;
    document.addEventListener('keydown', function (e) {
        if (e.key.toLowerCase() === seq[pos].toLowerCase()) {
            pos++;
            if (pos === seq.length) {
                pos = 0;
                var emojis = ['✨','🌟','💫','⭐','🎉','🕌','💎'];
                for (var i = 0; i < 30; i++) {
                    (function (j) {
                        setTimeout(function () {
                            var em = document.createElement('div');
                            em.className = 'confetti-emoji';
                            em.textContent = emojis[j % emojis.length];
                            em.style.left = (Math.random() * 100) + 'vw';
                            em.style.fontSize = (20 + Math.random() * 20) + 'px';
                            em.style.animationDuration = (2.5 + Math.random() * 1.5) + 's';
                            document.body.appendChild(em);
                            setTimeout(function () { em.remove(); }, 3500);
                        }, j * 60);
                    })(i);
                }
                if (window.showPublicToast) showPublicToast('🎊 Konami Code! Easter egg found!', '✨');
            }
        } else { pos = 0; }
    });
})();
</script>
</body>
</html>