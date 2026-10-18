<?php
$totalBerita = (int) Database::pdo()->query('SELECT COUNT(*) FROM news WHERE status = "published"')->fetchColumn();
$beritaTahunIni = (int) Database::pdo()->query('SELECT COUNT(*) FROM news WHERE status = "published" AND YEAR(published_at) = ' . (int) date('Y'))->fetchColumn();
$beritaBulanIni = (int) Database::pdo()->query('SELECT COUNT(*) FROM news WHERE status = "published" AND MONTH(published_at) = ' . (int) date('n') . ' AND YEAR(published_at) = ' . (int) date('Y'))->fetchColumn();
$beritaMingguIni = (int) Database::pdo()->query('SELECT COUNT(*) FROM news WHERE status = "published" AND published_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)')->fetchColumn();

// Featured fallback
$featured = (!empty($featuredSlider) ? $featuredSlider[0] : null) ?? News::latest(1)[0] ?? null;
$editorsPicks = News::latest(3);

$timelineStmt = Database::pdo()->query(
    'SELECT DATE_FORMAT(published_at, "%Y-%m") as ym, COUNT(*) as cnt 
     FROM news WHERE status = "published" 
     GROUP BY DATE_FORMAT(published_at, "%Y-%m") 
     ORDER BY ym DESC LIMIT 12'
);
$timeline = $timelineStmt->fetchAll();

// Category icons (key mapping)
$categoryIcons = [
    'umum' => 'newspaper', 'penelitian' => 'microscope', 'pengabdian' => 'handshake',
    'publikasi' => 'book', 'haki' => 'shield', 'aik' => 'mosque',
    'pengumuman' => 'megaphone', 'agenda' => 'calendar',
];

$catStmt = Database::pdo()->query(
    'SELECT category, COUNT(*) as cnt FROM news 
     WHERE status = "published" GROUP BY category'
);
$categoryCounts = [];
foreach ($catStmt->fetchAll() as $row) {
    $categoryCounts[$row['category']] = (int) $row['cnt'];
}
foreach ($categories as $cat) {
    if (!isset($categoryCounts[$cat])) $categoryCounts[$cat] = 0;
}
arsort($categoryCounts);
$topCategories = array_slice($categoryCounts, 0, 5, true);

$trendingStmt = Database::pdo()->query(
    'SELECT * FROM news WHERE status = "published" AND published_at >= DATE_SUB(NOW(), INTERVAL 14 DAY) ORDER BY published_at DESC LIMIT 5'
);
$trendingWeek = $trendingStmt->fetchAll();

$totalWords = (int) Database::pdo()->query('SELECT COALESCE(SUM(CHAR_LENGTH(content)), 0) FROM news WHERE status = "published"')->fetchColumn();

$quotes = [
    ['"Pena para ulama lebih berharga dari darah para syuhada." — HR. Abu Dawud', 'pen'],
    ['"Sebaik-baik manusia adalah yang paling bermanfaat bagi manusia." — HR. Ahmad', 'handshake'],
    ['"Barangsiapa beriman kepada Allah dan hari akhir, hendaklah berkata baik atau diam." — HR. Bukhari', 'message-circle'],
    ['"Informasi adalah mata uang abad ke-21." — Pepatah Modern', 'newspaper'],
    ['"Ilmu yang bermanfaat adalah yang diamalkan." — Imam Syafi\'i', 'book'],
];
$todayQuote = $quotes[date('z') % count($quotes)];

$milestones = [];
if ($totalBerita >= 10) $milestones[] = ['newspaper', '10+ Berita'];
if ($totalBerita >= 50) $milestones[] = ['megaphone', '50+ Berita'];
if ($totalBerita >= 100) $milestones[] = ['book', '100+ Artikel'];

$liveFeed = [];
$pubLatest = Database::pdo()->query('SELECT "book" as icon, title, created_at as date FROM publications WHERE status = "published" ORDER BY created_at DESC LIMIT 2')->fetchAll();
foreach ($pubLatest as $p) $liveFeed[] = $p;
$aikLatest = Database::pdo()->query('SELECT "mosque" as icon, title, created_at as date FROM aik_activities WHERE status = "published" ORDER BY created_at DESC LIMIT 2')->fetchAll();
foreach ($aikLatest as $a) $liveFeed[] = $a;
usort($liveFeed, fn($a, $b) => strtotime($b['date']) <=> strtotime($a['date']));
$liveFeed = array_slice($liveFeed, 0, 4);

// Slider data
$slides = !empty($featuredSlider) ? $featuredSlider : ($featured ? [$featured] : []);

// ICON HELPER FUNCTION
function renderNewsIcon($name, $size = 24, $color = 'currentColor') {
    $icons = [
        'newspaper' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"></path><path d="M18 14h-8"></path><path d="M15 18h-5"></path><path d="M10 6h8v4h-8V6Z"></path></svg>',
        'microscope' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M9 3h6v2H9V3zm-3 4h12v2H6V7zm2 4h8v10H8V11z"></path><path d="M10 15h4"></path></svg>',
        'handshake' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'book' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>',
        'shield' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
        'mosque' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 6v6l4 2"></path></svg>',
        'megaphone' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="m3 11 18-5v12L3 14v-3z"></path><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"></path></svg>',
        'calendar' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
        'fire' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>',
        'pen' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 19l7-7 3 3-7 7-3-3z"></path><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path><path d="M2 2l7.586 7.586"></path><circle cx="11" cy="11" r="2"></circle></svg>',
        'message-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>',
        'sparkle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 3l1.912 5.813a2 2 0 0 0 1.275 1.275L21 12l-5.813 1.912a2 2 0 0 0-1.275 1.275L12 21l-1.912-5.813a2 2 0 0 0-1.275-1.275L3 12l5.813-1.912a2 2 0 0 0 1.275-1.275L12 3z"></path></svg>',
        'search' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        'x' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>',
        'arrow-right' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
        'chevron-left' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>',
        'chevron-right' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>',
        'trophy' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path></svg>',
        'folder' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>',
        'mail' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>',
        'hash' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="4" y1="9" x2="20" y2="9"></line><line x1="4" y1="15" x2="20" y2="15"></line><line x1="10" y1="3" x2="8" y2="21"></line><line x1="16" y1="3" x2="14" y2="21"></line></svg>',
        'activity' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>',
        'zap' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>',
        'eye' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>',
        'clock' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
        'award' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>',
        'star' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>',
        'book-open' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>',
    ];
    return $icons[$name] ?? $icons['sparkle'];
}
?>

<style>
    @keyframes newsFloat1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(20px,-15px)} }
    @keyframes newsFloat2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-15px,20px)} }
    @keyframes newsShine { 0%{transform:translateX(-100%) skewX(-20deg)} 100%{transform:translateX(300%) skewX(-20deg)} }
    @keyframes newsGlow { 0%,100%{text-shadow:0 0 20px rgba(242,192,99,0.5),0 0 40px rgba(217,164,65,0.3)} 50%{text-shadow:0 0 30px rgba(242,192,99,0.8),0 0 60px rgba(217,164,65,0.5)} }
    @keyframes slideFade { from{opacity:0;transform:scale(1.04)} to{opacity:1;transform:scale(1)} }
    @keyframes iconRotate {
        0%, 100% { transform: rotate(0deg) scale(1); }
        25% { transform: rotate(-5deg) scale(1.05); }
        75% { transform: rotate(5deg) scale(1.05); }
    }
    @keyframes orbPulse {
        0%, 100% { box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.2), 0 6px 16px rgba(5,150,105,0.35); }
        50%      { box-shadow: inset 0 2px 3px rgba(255,255,255,0.8), inset 0 -3px 4px rgba(0,0,0,0.2), 0 8px 22px rgba(5,150,105,0.5); }
    }

    /* ===== SVG ICON BASE ===== */
    .nsvg {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        vertical-align: middle;
    }
    .nsvg svg {
        display: block;
        transition: all 0.3s ease;
    }

    .news-orb { position:absolute; border-radius:50%; pointer-events:none; z-index:0; }
    .news-orb-1 { width:140px; height:140px; top:10%; right:8%; background:radial-gradient(circle at 30% 30%,rgba(253,230,138,0.6),rgba(217,164,65,0.3) 60%,transparent); filter:blur(2px); animation:newsFloat1 8s ease-in-out infinite; }
    .news-orb-2 { width:200px; height:200px; bottom:15%; left:5%; background:radial-gradient(circle at 70% 70%,rgba(110,231,183,0.4),rgba(16,185,129,0.2) 60%,transparent); filter:blur(3px); animation:newsFloat2 10s ease-in-out infinite; }

    /* ===== HERO SLIDER 3D ===== */
    .hero-slider-3d { 
        position:relative; 
        border-radius:28px; 
        overflow:hidden; 
        box-shadow:0 24px 60px rgba(0,0,0,.35); 
        margin-bottom:32px; 
        min-height:420px; 
        background:linear-gradient(135deg,#043b2c,#065f46); 
    }
    .hero-slide-3d { 
        position:absolute; 
        inset:0; 
        display:grid; 
        grid-template-columns:1.2fr 1fr; 
        opacity:0; 
        visibility:hidden; 
        transition:opacity .8s ease, visibility .8s ease; 
    }
    .hero-slide-3d.active { opacity:1; visibility:visible; z-index:2; }
    .hero-slide-3d.active .hero-slide-img { animation:slideFade 1s ease both; }
    .hero-slide-img { width:100%; height:100%; object-fit:cover; min-height:420px; display:block; }
    .hero-slide-img-empty { 
        width:100%; 
        height:100%; 
        min-height:420px; 
        background:linear-gradient(135deg,#065f46,#043b2c); 
        display:flex; 
        align-items:center; 
        justify-content:center; 
        opacity:.4;
        color: #f2c063;
    }
    .hero-slide-img-empty svg {
        width: 80px;
        height: 80px;
        stroke: #f2c063;
        stroke-width: 1.5;
    }
    .hero-slide-content { 
        padding:48px; 
        position:relative; 
        z-index:3; 
        display:flex; 
        flex-direction:column; 
        justify-content:center; 
    }
    .hero-slide-content::before { 
        content:''; 
        position:absolute; 
        top:-40%; 
        right:-20%; 
        width:300px; 
        height:300px; 
        border-radius:50%; 
        background:radial-gradient(circle,rgba(217,164,65,.2),transparent 70%); 
        pointer-events:none; 
        animation: orbPulse 5s ease-in-out infinite;
    }
    .hero-dots-3d { position:absolute; bottom:24px; left:50%; transform:translateX(-50%); z-index:5; display:flex; gap:8px; }
    .hero-dot-3d { 
        width:10px; 
        height:10px; 
        border-radius:50%; 
        border:none; 
        cursor:pointer; 
        background:rgba(255,255,255,.35); 
        transition:all .3s; 
        padding:0; 
    }
    .hero-dot-3d.active { 
        background:#f2c063; 
        width:32px; 
        border-radius:999px; 
        box-shadow:0 0 12px rgba(242,192,99,.6); 
    }
    .hero-arrow-3d { 
        position:absolute; 
        top:50%; 
        transform:translateY(-50%); 
        z-index:5; 
        width:48px; 
        height:48px; 
        border-radius:50%; 
        border:none; 
        cursor:pointer; 
        background:rgba(255,255,255,.15); 
        backdrop-filter:blur(8px); 
        color:#fff; 
        font-size:18px; 
        font-weight:900; 
        display:flex; 
        align-items:center; 
        justify-content:center; 
        transition:all .3s; 
        border:1px solid rgba(255,255,255,.2); 
    }
    .hero-arrow-3d svg {
        width: 24px;
        height: 24px;
        stroke: currentColor;
        stroke-width: 2.5;
    }
    .hero-arrow-3d:hover { 
        background:rgba(242,192,99,.9); 
        color:#03251f;
        transform: translateY(-50%) scale(1.08);
    }
    .hero-arrow-prev { left:16px; }
    .hero-arrow-next { right:16px; }
    @media(max-width:768px){ 
        .hero-slide-3d{grid-template-columns:1fr;} 
        .hero-slide-img,.hero-slide-img-empty{display:none;} 
        .hero-slide-content{padding:28px;} 
        .hero-slider-3d{min-height:auto;} 
    }

    /* ===== NEWS TICKER 3D ===== */
    .news-ticker-3d { 
        position:absolute; 
        bottom:20px; 
        right:20px; 
        padding:10px 18px; 
        border-radius:999px; 
        background:linear-gradient(145deg,rgba(16,185,129,0.3),rgba(5,150,105,0.15)); 
        border:1px solid rgba(110,231,183,0.3); 
        backdrop-filter:blur(10px); 
        color:#fff; 
        font-size:13px; 
        font-weight:700; 
        display:inline-flex; 
        align-items:center; 
        gap:10px; 
        box-shadow:inset 0 1px 1px rgba(255,255,255,0.2),0 4px 12px rgba(0,0,0,0.3); 
        z-index:6; 
    }
    .news-ticker-3d svg {
        width: 18px;
        height: 18px;
        stroke: #6ee7b7;
        stroke-width: 2.2;
    }
    .ticker-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #6ee7b7, #10b981);
        animation: orbPulse 2s infinite;
        box-shadow: 0 0 10px rgba(110,231,183,0.6);
    }

    /* ===== QUOTE 3D ===== */
    .news-quote-3d { 
        position:relative; 
        padding:34px; 
        border-radius:24px; 
        background:linear-gradient(145deg,#065f46,#03251f); 
        border:1px solid rgba(217,164,65,0.25); 
        overflow:hidden; 
        box-shadow:inset 0 1px 1px rgba(255,255,255,0.08),0 16px 40px rgba(0,0,0,0.35);
        transition: all 0.4s ease;
    }
    .news-quote-3d:hover {
        transform: translateY(-4px);
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.12), 0 20px 50px rgba(0,0,0,0.4);
    }
    .news-quote-3d::before { 
        content:''; 
        position:absolute; 
        top:-60%; 
        right:-20%; 
        width:300px; 
        height:300px; 
        border-radius:50%; 
        background:radial-gradient(circle,rgba(217,164,65,0.3),transparent 70%);
        animation: orbPulse 5s ease-in-out infinite;
    }
    .news-quote-ico-3d { 
        display:inline-flex; 
        align-items:center; 
        justify-content:center; 
        width:68px; 
        height:68px; 
        border-radius:20px; 
        flex-shrink:0; 
        background:radial-gradient(circle at 30% 25%,rgba(255,255,255,0.5),transparent 40%),linear-gradient(145deg,#fde68a,#f2c063 50%,#d9a441); 
        box-shadow:inset 0 2px 3px rgba(255,255,255,0.7),inset 0 -3px 4px rgba(0,0,0,0.2),0 6px 16px rgba(217,164,65,0.4); 
        position:relative;
        transition: all 0.4s ease;
    }
    .news-quote-ico-3d svg {
        width: 34px;
        height: 34px;
        stroke: #03251f;
        stroke-width: 2.2;
        position: relative;
        z-index: 2;
    }
    .news-quote-ico-3d::before { 
        content:''; 
        position:absolute; 
        top:6px; 
        left:12px; 
        width:20px; 
        height:8px; 
        border-radius:50%; 
        background:rgba(255,255,255,0.6); 
        filter:blur(2px);
        z-index: 1;
    }
    .news-quote-3d:hover .news-quote-ico-3d {
        transform: scale(1.08) rotate(-5deg);
    }

    .news-stat-mini-3d { 
        padding:14px; 
        border-radius:16px; 
        background:rgba(255,255,255,0.05); 
        border:1px solid rgba(255,255,255,0.08); 
        text-align:center; 
        position:relative; 
        overflow:hidden;
        transition: all 0.3s ease;
    }
    .news-stat-mini-3d:hover {
        background: rgba(255,255,255,0.08);
        transform: translateY(-2px);
    }
    .news-stat-mini-3d::before { 
        content:''; 
        position:absolute; 
        inset:0; 
        background:radial-gradient(circle at 50% 0%,rgba(217,164,65,0.15),transparent 60%); 
    }
    .news-stat-num-3d { 
        font-family:var(--font-display); 
        font-size:26px; 
        font-weight:900; 
        color:#f2c063; 
        line-height:1;
        filter: drop-shadow(0 2px 4px rgba(217,164,65,0.3));
    }

    /* ===== FEATURED BADGE ===== */
    .news-featured-badge-3d { 
        display:inline-flex; 
        align-items:center; 
        gap:8px; 
        padding:7px 16px; 
        border-radius:999px; 
        font-size:11.5px; 
        font-weight:900; 
        letter-spacing:0.12em; 
        color:#03251f; 
        background:linear-gradient(145deg,#fde68a,#d9a441); 
        box-shadow:inset 0 1px 2px rgba(255,255,255,0.7),inset 0 -2px 3px rgba(0,0,0,0.2),0 4px 10px rgba(217,164,65,0.4); 
        position:relative; 
        overflow:hidden;
        text-transform: uppercase;
    }
    .news-featured-badge-3d svg {
        width: 14px;
        height: 14px;
        stroke: #03251f;
        stroke-width: 2.5;
    }
    .news-featured-badge-3d::before { 
        content:''; 
        position:absolute; 
        top:2px; 
        left:6px; 
        width:30%; 
        height:40%; 
        border-radius:50%; 
        background:rgba(255,255,255,0.6); 
        filter:blur(1.5px); 
    }

    .news-featured-cta-3d { 
        position:relative; 
        display:inline-flex; 
        align-items:center; 
        gap:10px; 
        padding:13px 24px; 
        border-radius:13px; 
        font-weight:800; 
        font-size:14.5px; 
        overflow:hidden; 
        background:linear-gradient(145deg,#fde68a,#d9a441); 
        color:#03251f; 
        text-decoration:none; 
        box-shadow:inset 0 2px 3px rgba(255,255,255,0.7),inset 0 -2px 3px rgba(0,0,0,0.15),0 8px 20px rgba(217,164,65,0.4); 
        transition:transform 0.3s;
    }
    .news-featured-cta-3d svg {
        width: 18px;
        height: 18px;
        stroke: #03251f;
        stroke-width: 2.5;
        transition: all 0.3s ease;
    }
    .news-featured-cta-3d::after { 
        content:''; 
        position:absolute; 
        top:0; 
        left:-100%; 
        width:60%; 
        height:100%; 
        background:linear-gradient(105deg,transparent,rgba(255,255,255,0.5),transparent); 
        animation:newsShine 3s ease-in-out infinite; 
    }
    .news-featured-cta-3d:hover { 
        transform:translateY(-3px); 
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.8), 0 14px 30px rgba(217,164,65,0.55);
    }
    .news-featured-cta-3d:hover svg {
        transform: translateX(4px);
    }

    .news-counter-3d { 
        font-family:var(--font-display); 
        font-size:44px; 
        font-weight:900; 
        line-height:1; 
        background:linear-gradient(135deg,#fde68a,#f2c063 40%,#d9a441); 
        -webkit-background-clip:text; 
        background-clip:text; 
        -webkit-text-fill-color:transparent;
        filter: drop-shadow(0 2px 8px rgba(217,164,65,0.4));
    }

    /* ===== STAT ICONS 3D ===== */
    .news-stat-ico-3d { 
        display:inline-flex; 
        align-items:center; 
        justify-content:center; 
        width:56px; 
        height:56px; 
        border-radius:16px; 
        flex-shrink:0; 
        position:relative;
        transition: all 0.3s ease;
    }
    .news-stat-ico-3d svg {
        width: 26px;
        height: 26px;
        stroke: #ffffff;
        stroke-width: 2.2;
        position: relative;
        z-index: 2;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }
    .news-stat-ico-3d::before { 
        content:''; 
        position:absolute; 
        top:5px; 
        left:10px; 
        width:16px; 
        height:7px; 
        border-radius:50%; 
        background:rgba(255,255,255,0.55); 
        filter:blur(1.5px);
        z-index: 1;
    }
    .stat:hover .news-stat-ico-3d {
        transform: scale(1.1) rotate(-5deg);
    }
    .nsi-gold { background:radial-gradient(circle at 30% 25%,rgba(255,255,255,0.5),transparent 40%),linear-gradient(145deg,#fde68a,#f2c063 50%,#d9a441); box-shadow:inset 0 2px 3px rgba(255,255,255,0.7),inset 0 -3px 4px rgba(0,0,0,0.2),0 6px 16px rgba(217,164,65,0.4); }
    .nsi-emerald { background:radial-gradient(circle at 30% 25%,rgba(255,255,255,0.4),transparent 40%),linear-gradient(145deg,#34d399,#10b981 50%,#059669); box-shadow:inset 0 2px 3px rgba(255,255,255,0.6),inset 0 -3px 4px rgba(0,0,0,0.25),0 6px 16px rgba(5,150,105,0.35); }
    .nsi-blue { background:radial-gradient(circle at 30% 25%,rgba(255,255,255,0.4),transparent 40%),linear-gradient(145deg,#60a5fa,#3b82f6 50%,#1d4ed8); box-shadow:inset 0 2px 3px rgba(255,255,255,0.6),inset 0 -3px 4px rgba(0,0,0,0.25),0 6px 16px rgba(59,130,246,0.35); }
    .nsi-purple { background:radial-gradient(circle at 30% 25%,rgba(255,255,255,0.4),transparent 40%),linear-gradient(145deg,#c4b5fd,#a78bfa 50%,#7c3aed); box-shadow:inset 0 2px 3px rgba(255,255,255,0.6),inset 0 -3px 4px rgba(0,0,0,0.25),0 6px 16px rgba(124,58,237,0.35); }

    /* ===== MILESTONES ===== */
    .news-milestone-3d { 
        position:relative; 
        padding:24px; 
        text-align:center; 
        background:var(--white); 
        border:1px solid var(--border); 
        border-radius:20px; 
        overflow:hidden; 
        transition:all 0.35s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }
    .news-milestone-3d:hover { 
        transform:translateY(-6px); 
        box-shadow:0 16px 32px rgba(5,150,105,0.15);
        border-color: rgba(5,150,105,0.3);
    }
    .news-milestone-ico-3d { 
        width:68px; 
        height:68px; 
        border-radius:18px; 
        background:radial-gradient(circle at 30% 25%,rgba(255,255,255,0.5),transparent 40%),linear-gradient(145deg,#fde68a,#f2c063 50%,#d9a441); 
        display:flex; 
        align-items:center; 
        justify-content:center; 
        margin:0 auto 14px; 
        box-shadow:inset 0 2px 3px rgba(255,255,255,0.7),inset 0 -3px 4px rgba(0,0,0,0.2),0 6px 16px rgba(217,164,65,0.4); 
        position:relative;
        transition: all 0.3s ease;
    }
    .news-milestone-ico-3d svg {
        width: 32px;
        height: 32px;
        stroke: #03251f;
        stroke-width: 2.2;
        position: relative;
        z-index: 2;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }
    .news-milestone-ico-3d::before { 
        content:''; 
        position:absolute; 
        top:5px; 
        left:11px; 
        width:18px; 
        height:7px; 
        border-radius:50%; 
        background:rgba(255,255,255,0.6); 
        filter:blur(1.5px);
        z-index: 1;
    }
    .news-milestone-3d:hover .news-milestone-ico-3d {
        transform: scale(1.1) rotate(-6deg);
    }

    /* ===== RUBRIK ===== */
    .rubrik-3d { 
        position:relative; 
        padding:26px 18px; 
        text-align:center; 
        background:var(--white); 
        border:1px solid var(--border); 
        border-radius:20px; 
        text-decoration:none; 
        color:inherit; 
        display:block; 
        transition:all 0.35s cubic-bezier(0.16,1,0.3,1); 
        overflow:hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }
    .rubrik-3d::before { 
        content:''; 
        position:absolute; 
        top:0; 
        left:0; 
        right:0; 
        height:4px; 
        background:linear-gradient(90deg,#d9a441,#059669); 
        transform:scaleX(0); 
        transform-origin:left; 
        transition:transform 0.4s ease; 
    }
    .rubrik-3d:hover { 
        transform:translateY(-6px); 
        box-shadow:0 16px 32px rgba(5,150,105,0.18); 
        border-color:rgba(5,150,105,0.3);
    }
    .rubrik-3d:hover::before { transform:scaleX(1); }
    .rubrik-3d:hover .rubrik-orb-3d { transform:scale(1.1) rotate(-6deg); }
    .rubrik-orb-3d { 
        width:68px; 
        height:68px; 
        border-radius:18px; 
        display:flex; 
        align-items:center; 
        justify-content:center; 
        margin:0 auto 14px; 
        background:radial-gradient(circle at 30% 25%,rgba(255,255,255,0.5),transparent 40%),linear-gradient(145deg,#34d399,#10b981 50%,#059669); 
        box-shadow:inset 0 2px 3px rgba(255,255,255,0.6),inset 0 -3px 4px rgba(0,0,0,0.25),0 6px 16px rgba(5,150,105,0.35); 
        position:relative; 
        transition:transform 0.3s;
    }
    .rubrik-orb-3d svg {
        width: 32px;
        height: 32px;
        stroke: #ffffff;
        stroke-width: 2.2;
        position: relative;
        z-index: 2;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }
    .rubrik-orb-3d::before { 
        content:''; 
        position:absolute; 
        top:6px; 
        left:12px; 
        width:20px; 
        height:8px; 
        border-radius:50%; 
        background:rgba(255,255,255,0.6); 
        filter:blur(2px);
        z-index: 1;
    }

    /* ===== TRENDING ROWS ===== */
    .trending-row-3d { 
        display:flex; 
        align-items:center; 
        gap:16px; 
        padding:18px 22px; 
        background:var(--white); 
        border:1px solid var(--border); 
        border-radius:18px; 
        text-decoration:none; 
        transition:all 0.3s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }
    .trending-row-3d:hover { 
        transform:translateY(-3px); 
        box-shadow:0 12px 24px rgba(5,150,105,0.12); 
        border-color:rgba(5,150,105,0.3);
    }
    .trending-rank-3d { 
        width:56px; 
        height:56px; 
        border-radius:16px; 
        display:flex; 
        align-items:center; 
        justify-content:center; 
        font-family:var(--font-display); 
        font-weight:900; 
        font-size:20px; 
        color:white; 
        flex-shrink:0; 
        position:relative; 
        overflow:hidden; 
        box-shadow:inset 0 2px 3px rgba(255,255,255,0.5),inset 0 -3px 4px rgba(0,0,0,0.25),0 6px 14px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
    .trending-rank-3d svg {
        width: 24px;
        height: 24px;
        stroke: currentColor;
        stroke-width: 2.5;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }
    .trending-rank-3d::before { 
        content:''; 
        position:absolute; 
        top:5px; 
        left:10px; 
        width:16px; 
        height:7px; 
        border-radius:50%; 
        background:rgba(255,255,255,0.5); 
        filter:blur(1.5px);
        z-index: 1;
    }
    .trending-row-3d:hover .trending-rank-3d {
        transform: scale(1.08) rotate(-3deg);
    }
    .tr-gold{background:linear-gradient(145deg,#fde68a,#d9a441 60%,#a9761b);color:#03251f} 
    .tr-silver{background:linear-gradient(145deg,#e2e8f0,#94a3b8 60%,#64748b)} 
    .tr-bronze{background:linear-gradient(145deg,#fdba74,#b45309 60%,#92400e)} 
    .tr-teal{background:linear-gradient(145deg,#5eead4,#14b8a6 60%,#0f766e)} 
    .tr-green{background:linear-gradient(145deg,#34d399,#10b981 60%,#059669)}
    .tr-arrow {
        flex-shrink: 0;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(145deg, #059669, #065f46);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.25), inset 0 -2px 2px rgba(0,0,0,0.25);
        transition: all 0.3s ease;
    }
    .tr-arrow svg {
        width: 16px;
        height: 16px;
        stroke: #ffffff;
        stroke-width: 2.5;
    }
    .trending-row-3d:hover .tr-arrow {
        background: linear-gradient(145deg, #fde68a, #d9a441);
        transform: translateX(4px);
    }
    .trending-row-3d:hover .tr-arrow svg {
        stroke: #03251f;
    }

    /* ===== HEATMAP ===== */
    .heatmap-bar-3d { flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; }
    .heatmap-bar-inner-3d { 
        width:100%; 
        border-radius:8px 8px 0 0; 
        background:linear-gradient(180deg,#fde68a,#f2c063 40%,#d9a441 80%,#a9761b); 
        box-shadow:inset 0 2px 3px rgba(255,255,255,0.5),inset 0 -2px 3px rgba(0,0,0,0.2),0 2px 6px rgba(217,164,65,0.3); 
        position:relative; 
        transition:transform 0.3s;
    }
    .heatmap-bar-inner-3d:hover { transform:translateY(-4px); }
    .heatmap-bar-inner-3d::before { 
        content:''; 
        position:absolute; 
        top:4px; 
        left:15%; 
        width:30%; 
        height:25%; 
        border-radius:50%; 
        background:rgba(255,255,255,0.4); 
        filter:blur(1.5px); 
    }

    /* ===== FILTERS ===== */
    .filter-3d { 
        display:inline-flex; 
        align-items:center; 
        gap:7px; 
        padding:8px 16px; 
        border-radius:999px; 
        font-size:12.5px; 
        font-weight:700; 
        background:linear-gradient(145deg,#fff,#f6faf7); 
        border:1px solid var(--border); 
        color:var(--text); 
        text-decoration:none; 
        box-shadow:inset 0 1px 1px rgba(255,255,255,0.9),0 2px 5px rgba(0,0,0,0.05); 
        transition:all 0.25s;
    }
    .filter-3d svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2.2;
        transition: all 0.25s;
    }
    .filter-3d:hover,.filter-3d.active { 
        transform:translateY(-2px); 
        background:linear-gradient(145deg,#065f46,#043b2c); 
        color:#f2c063; 
        border-color:transparent; 
        box-shadow:inset 0 1px 1px rgba(255,255,255,0.1),0 6px 14px rgba(5,150,105,0.3); 
    }

    /* ===== CTA BUTTONS ===== */
    .news-cta-3d { 
        position:relative; 
        display:inline-flex; 
        align-items:center; 
        gap:10px; 
        padding:14px 26px; 
        border-radius:13px; 
        font-weight:700; 
        font-size:14.5px; 
        overflow:hidden; 
        transition:transform 0.3s cubic-bezier(0.16,1,0.3,1); 
        text-decoration:none;
    }
    .news-cta-3d svg {
        width: 20px;
        height: 20px;
        stroke: currentColor;
        stroke-width: 2.2;
        transition: all 0.3s ease;
    }
    .news-cta-3d::after { 
        content:''; 
        position:absolute; 
        top:0; 
        left:-100%; 
        width:60%; 
        height:100%; 
        background:linear-gradient(105deg,transparent,rgba(255,255,255,0.5),transparent); 
        animation:newsShine 3s ease-in-out infinite; 
    }
    .news-cta-primary-3d { 
        background:linear-gradient(145deg,#fde68a,#d9a441); 
        color:#03251f; 
        box-shadow:inset 0 2px 3px rgba(255,255,255,0.7),inset 0 -2px 3px rgba(0,0,0,0.15),0 8px 20px rgba(217,164,65,0.4); 
    }
    .news-cta-ghost-3d { 
        background:transparent; 
        color:#fff; 
        border:2px solid rgba(255,255,255,0.35);
        backdrop-filter: blur(8px);
    }
    .news-cta-3d:hover { 
        transform:translateY(-3px); 
    }
    .news-cta-3d:hover svg {
        transform: translateX(4px);
    }
    .news-cta-primary-3d:hover { 
        box-shadow:inset 0 2px 3px rgba(255,255,255,0.8),0 14px 30px rgba(217,164,65,0.55); 
    }
    .news-cta-ghost-3d:hover { 
        background:rgba(255,255,255,0.12); 
        border-color:rgba(255,255,255,0.6);
        box-shadow: 0 10px 24px rgba(0,0,0,0.2);
    }

    /* ===== SEARCH INPUT ===== */
    .news-search-input {
        flex: 1;
        padding: 13px 18px;
        border-radius: 12px;
        border: 2px solid var(--border);
        background: linear-gradient(145deg, #f6faf7, #fff);
        font-size: 14px;
        font-weight: 600;
        color: var(--ink);
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.04);
        transition: all 0.25s;
        outline: none;
    }
    .news-search-input:focus {
        border-color: #059669;
        box-shadow: 0 0 0 4px rgba(5,150,105,0.12);
    }
    .news-search-btn {
        padding: 13px 24px;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        font-size: 13px;
        font-weight: 800;
        color: #fff;
        background: linear-gradient(145deg, #34d399, #10b981 50%, #059669);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.5), inset 0 -2px 3px rgba(0,0,0,0.2), 0 5px 12px rgba(5,150,105,0.3);
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .news-search-btn svg {
        width: 16px;
        height: 16px;
        stroke: #ffffff;
        stroke-width: 2.5;
    }
    .news-search-btn:hover {
        transform: translateY(-2px);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -2px 3px rgba(0,0,0,0.2), 0 8px 18px rgba(5,150,105,0.4);
    }
    .news-reset-btn {
        padding: 13px 18px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        color: #991b1b;
        background: rgba(220,38,38,0.08);
        border: 1px solid rgba(220,38,38,0.25);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.25s;
    }
    .news-reset-btn svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2.5;
    }
    .news-reset-btn:hover {
        background: rgba(220,38,38,0.15);
        transform: translateY(-2px);
    }

    /* ===== HERO CHIPS ENHANCED ===== */
    .hero-chip svg {
        width: 14px;
        height: 14px;
        stroke: #ffffff;
        stroke-width: 2.2;
        filter: drop-shadow(0 1px 2px rgba(0,0,0,0.3));
    }

    /* ===== SECTION HEADS ENHANCED ===== */
    .section-head h2 {
        display: inline-flex;
        align-items: center;
        gap: 12px;
    }
    .section-head h2 svg {
        width: 32px;
        height: 32px;
        stroke-width: 2;
        filter: drop-shadow(0 2px 6px rgba(5,150,105,0.3));
    }

    /* ===== ACTIVE FILTER INFO ===== */
    .filter-active-pill {
        padding: 5px 14px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 800;
        background: linear-gradient(145deg, #065f46, #043b2c);
        color: #f2c063;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .filter-active-pill svg {
        width: 12px;
        height: 12px;
        stroke: currentColor;
        stroke-width: 2.5;
    }
    .filter-active-pill a {
        color: #fca5a5;
        text-decoration: none;
        margin-left: 2px;
        transition: all 0.2s;
    }
    .filter-active-pill a:hover {
        color: #ffffff;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .news-stat-ico-3d { width: 48px; height: 48px; }
        .news-stat-ico-3d svg { width: 22px; height: 22px; }
        .news-milestone-ico-3d { width: 56px; height: 56px; }
        .news-milestone-ico-3d svg { width: 28px; height: 28px; }
        .rubrik-orb-3d { width: 58px; height: 58px; }
        .rubrik-orb-3d svg { width: 28px; height: 28px; }
        .news-counter-3d { font-size: 36px; }
        .trending-rank-3d { width: 48px; height: 48px; font-size: 18px; }
        .news-quote-ico-3d { width: 56px; height: 56px; }
        .news-quote-ico-3d svg { width: 28px; height: 28px; }
    }

    @media (max-width: 480px) {
        .stats { grid-template-columns: 1fr !important; }
        .grid { grid-template-columns: 1fr !important; }
        .news-orb { display: none; }
    }
</style>

<!-- ================= HERO 3D (HEADER) ================= -->
<section class="news-hero" style="position:relative; overflow:hidden;">
    <div class="news-orb news-orb-1"></div>
    <div class="news-orb news-orb-2"></div>
    
    <span class="hero-chip c1" style="z-index:2;">
        <?= renderNewsIcon('newspaper', 14, 'currentColor') ?>
        <span>Info Terkini</span>
    </span>
    <span class="hero-chip c2" style="z-index:2;">
        <?= renderNewsIcon('sparkle', 14, 'currentColor') ?>
        <span>Catur Dharma</span>
    </span>
    
    <span class="eyebrow eyebrow-light" style="z-index:2;">Informasi Lembaga</span>
    <h1 style="z-index:2;">Berita & <span class="gold-text">Pengumuman</span></h1>
    <p style="z-index:2;">Informasi terbaru seputar kegiatan LP3M/LPPAIK UNIMOF.</p>
    
    <div class="news-ticker-3d">
        <span class="ticker-dot"></span>
        <span style="color:#6ee7b7; font-weight:900;">LIVE</span>
        <span style="opacity:0.5;">·</span>
        <?= renderNewsIcon('activity', 16, '#6ee7b7') ?>
        <span><?= $beritaMingguIni ?> berita minggu ini</span>
    </div>
</section>

<!-- ================= HERO SLIDER UNGGULAN 3D ================= -->
<?php if (!empty($slides)): ?>
<section class="reveal">
    <div class="hero-slider-3d" id="heroSlider">
        <?php foreach ($slides as $idx => $sl): ?>
        <div class="hero-slide-3d <?= $idx === 0 ? 'active' : '' ?>" data-slide="<?= $idx ?>">
            <?php if (!empty($sl['thumbnail'])): ?>
                <img class="hero-slide-img" src="<?= e(upload_url($sl['thumbnail'])) ?>" alt="<?= e($sl['title']) ?>" loading="<?= $idx === 0 ? 'eager' : 'lazy' ?>" decoding="async">
            <?php else: ?>
                <div class="hero-slide-img-empty">
                    <?= renderNewsIcon('newspaper', 80, '#f2c063') ?>
                </div>
            <?php endif; ?>
            <div class="hero-slide-content">
                <span class="news-featured-badge-3d">
                    <?= renderNewsIcon('star', 14, '#03251f') ?>
                    <span><?= count($slides) > 1 ? 'UNGGULAN ' . ($idx + 1) : 'SOROTAN UTAMA' ?></span>
                </span>
                <h2 style="font-size:clamp(22px,2.8vw,30px); font-weight:800; margin:18px 0; letter-spacing:-0.02em; line-height:1.25; color:#fff;"><?= e($sl['title']) ?></h2>
                <p style="color:rgba(255,255,255,0.85); margin-bottom:20px; line-height:1.7; font-size:14.5px;"><?= e(excerpt($sl['content'], 170)) ?></p>
                <div style="display:flex; gap:12px; align-items:center; margin-bottom:22px; font-size:12px; color:rgba(255,255,255,0.7); flex-wrap:wrap;">
                    <span style="background:rgba(217,164,65,0.3); color:#f2c063; padding:4px 12px; border-radius:999px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <?= renderNewsIcon($categoryIcons[$sl['category']] ?? 'newspaper', 14, '#f2c063') ?>
                        <span><?= e(ucfirst($sl['category'])) ?></span>
                    </span>
                    <span style="display:inline-flex; align-items:center; gap:6px;">
                        <?= renderNewsIcon('calendar', 14, 'currentColor') ?>
                        <span><?= e(date('d M Y', strtotime($sl['published_at'] ?? $sl['created_at']))) ?></span>
                    </span>
                    <span style="display:inline-flex; align-items:center; gap:6px;">
                        <?= renderNewsIcon('eye', 14, 'currentColor') ?>
                        <span><?= number_format((int) ($sl['views'] ?? 0)) ?></span>
                    </span>
                </div>
                <a class="news-featured-cta-3d" href="<?= e(url('public/index.php?page=berita-detail&slug=' . urlencode($sl['slug']))) ?>">
                    <span>Baca Lengkap</span>
                    <?= renderNewsIcon('arrow-right', 18, '#03251f') ?>
                </a>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (count($slides) > 1): ?>
        <button class="hero-arrow-3d hero-arrow-prev" id="heroPrev" aria-label="Sebelumnya">
            <?= renderNewsIcon('chevron-left', 24, 'currentColor') ?>
        </button>
        <button class="hero-arrow-3d hero-arrow-next" id="heroNext" aria-label="Berikutnya">
            <?= renderNewsIcon('chevron-right', 24, 'currentColor') ?>
        </button>
        <div class="hero-dots-3d" id="heroDots">
            <?php foreach ($slides as $idx => $sl): ?>
                <button class="hero-dot-3d <?= $idx === 0 ? 'active' : '' ?>" data-dot="<?= $idx ?>" aria-label="Slide <?= $idx + 1 ?>"></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= QUOTE + STATUS 3D ================= -->
<section class="stats reveal">
    <div class="news-quote-3d" style="grid-column: span 2;">
        <div style="position: relative; z-index: 1; display: flex; align-items: center; gap: 22px; flex-wrap: wrap;">
            <div class="news-quote-ico-3d">
                <?= renderNewsIcon($todayQuote[1], 34, '#03251f') ?>
            </div>
            <div style="flex: 1; min-width: 240px;">
                <p style="font-family: var(--font-display); font-size: 17px; line-height: 1.55; margin-bottom: 10px; font-style: italic; color: #f2c063; font-weight: 600;">
                    <?= $todayQuote[0] ?>
                </p>
                <p style="font-size: 12px; opacity: 0.7; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                    <span style="display:inline-flex; align-items:center; gap:6px;">
                        <?= renderNewsIcon('calendar', 12, 'currentColor') ?>
                        <span><?= date('d M Y') ?></span>
                    </span>
                    <span>·</span>
                    <span style="display:inline-flex; align-items:center; gap:6px;">
                        <?= renderNewsIcon('pen', 12, 'currentColor') ?>
                        <span><?= number_format($totalWords / 1000) ?>K+ kata dipublikasikan</span>
                    </span>
                </p>
            </div>
        </div>
    </div>

    <div class="stat-3d stagger-2" style="grid-column: span 2; position: relative; padding: 28px; border-radius: 22px; background: linear-gradient(145deg, #065f46, #043b2c); border: 1px solid rgba(217,164,65,0.25); overflow: hidden; box-shadow: inset 0 1px 1px rgba(255,255,255,0.08), 0 10px 30px rgba(0,0,0,0.25);">
        <div style="position: absolute; top: -50%; right: -30%; width: 200px; height: 200px; border-radius: 50%; background: radial-gradient(circle, rgba(217,164,65,0.2), transparent 70%);"></div>
        <p style="font-size: 11px; letter-spacing: 0.15em; color: #f2c063; font-weight: 800; margin-bottom: 14px; position: relative; z-index: 1; display: flex; align-items: center; gap: 8px;">
            <span class="ticker-dot"></span>
            <span>STATUS REDAKSI</span>
        </p>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; position: relative; z-index: 1;">
            <div class="news-stat-mini-3d">
                <div class="news-stat-num-3d"><?= $beritaMingguIni ?></div>
                <div style="font-size: 10px; opacity: 0.8; margin-top: 4px; color: rgba(255,255,255,0.8);">Minggu Ini</div>
            </div>
            <div class="news-stat-mini-3d">
                <div class="news-stat-num-3d"><?= $beritaBulanIni ?></div>
                <div style="font-size: 10px; opacity: 0.8; margin-top: 4px; color: rgba(255,255,255,0.8);">Bulan Ini</div>
            </div>
            <div class="news-stat-mini-3d">
                <div class="news-stat-num-3d"><?= count($categories) ?></div>
                <div style="font-size: 10px; opacity: 0.8; margin-top: 4px; color: rgba(255,255,255,0.8);">Rubrik</div>
            </div>
        </div>
    </div>
</section>

<!-- ================= FEATURED FALLBACK 3D ================= -->
<?php if (empty($slides) && $featured !== null): ?>
<section class="reveal" style="margin-bottom: 32px;">
    <div style="background: linear-gradient(135deg, #043b2c, #065f46); color: white; border-radius: 28px; overflow: hidden; box-shadow: 0 24px 60px rgba(0,0,0,0.35); display: grid; grid-template-columns: 1.2fr 1fr; position: relative;">
        <div style="position: absolute; top: -40%; right: -10%; width: 400px; height: 400px; border-radius: 50%; background: radial-gradient(circle, rgba(217,164,65,0.25), transparent 70%); pointer-events: none;"></div>
        <?php if (!empty($featured['thumbnail'])): ?>
        <img src="<?= e(upload_url($featured['thumbnail'])) ?>" alt="<?= e($featured['title']) ?>" loading="eager" decoding="async" style="width: 100%; height: 100%; object-fit: cover; min-height: 300px;">
        <?php endif; ?>
        <div style="padding: 40px; position: relative; z-index: 1;">
            <span class="news-featured-badge-3d">
                <?= renderNewsIcon('fire', 14, '#03251f') ?>
                <span>SOROTAN UTAMA</span>
            </span>
            <h2 style="font-size: clamp(22px, 3vw, 30px); font-weight: 800; margin: 18px 0; letter-spacing: -0.02em; line-height: 1.25;"><?= e($featured['title']) ?></h2>
            <p style="color: rgba(255,255,255,0.85); margin-bottom: 22px; line-height: 1.7;"><?= e(excerpt($featured['content'], 180)) ?></p>
            <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 24px; font-size: 12px; color: rgba(255,255,255,0.7); flex-wrap: wrap;">
                <span style="background: rgba(217,164,65,0.3); color: #f2c063; padding: 4px 12px; border-radius: 999px; font-weight: 700; display:inline-flex; align-items:center; gap:6px;">
                    <?= renderNewsIcon($categoryIcons[$featured['category']] ?? 'newspaper', 14, '#f2c063') ?>
                    <span><?= e(ucfirst($featured['category'])) ?></span>
                </span>
                <span style="display:inline-flex; align-items:center; gap:6px;">
                    <?= renderNewsIcon('calendar', 14, 'currentColor') ?>
                    <span><?= e(date('d M Y', strtotime($featured['published_at'] ?? $featured['created_at']))) ?></span>
                </span>
                <span style="display:inline-flex; align-items:center; gap:6px;">
                    <?= renderNewsIcon('clock', 14, 'currentColor') ?>
                    <span><?= max(1, (int) round(str_word_count(strip_tags($featured['content'])) / 200)) ?> mnt</span>
                </span>
                <span style="display:inline-flex; align-items:center; gap:6px;">
                    <?= renderNewsIcon('eye', 14, 'currentColor') ?>
                    <span><?= number_format((int) ($featured['views'] ?? 0)) ?></span>
                </span>
            </div>
            <a class="news-featured-cta-3d" href="<?= e(url('public/index.php?page=berita-detail&slug=' . urlencode($featured['slug']))) ?>">
                <span>Baca Lengkap</span>
                <?= renderNewsIcon('arrow-right', 18, '#03251f') ?>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================= STATS COUNTER 3D ================= -->
<section class="stats">
    <div class="stat reveal stagger-1" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(217,164,65,0.2), transparent 70%);"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="news-stat-ico-3d nsi-gold">
                <?= renderNewsIcon('newspaper', 26, '#ffffff') ?>
            </div>
            <div>
                <div class="news-counter-3d" data-count="<?= $totalBerita ?>" data-suffix="+">0</div>
                <div class="stat-label">Total Berita</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-2" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(16,185,129,0.2), transparent 70%);"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="news-stat-ico-3d nsi-emerald">
                <?= renderNewsIcon('calendar', 26, '#ffffff') ?>
            </div>
            <div>
                <div class="news-counter-3d" data-count="<?= $beritaTahunIni ?>" data-suffix="+">0</div>
                <div class="stat-label">Terbit Tahun <?= date('Y') ?></div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-3" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(59,130,246,0.2), transparent 70%);"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="news-stat-ico-3d nsi-blue">
                <?= renderNewsIcon('calendar', 26, '#ffffff') ?>
            </div>
            <div>
                <div class="news-counter-3d" data-count="<?= $beritaBulanIni ?>">0</div>
                <div class="stat-label">Bulan Ini</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-4" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(124,58,237,0.2), transparent 70%);"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="news-stat-ico-3d nsi-purple">
                <?= renderNewsIcon('hash', 26, '#ffffff') ?>
            </div>
            <div>
                <div class="news-counter-3d" data-count="<?= count($categories) ?>">0</div>
                <div class="stat-label">Rubrik</div>
            </div>
        </div>
    </div>
</section>

<!-- ================= MILESTONES 3D ================= -->
<?php if ($milestones !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>
            <?= renderNewsIcon('trophy', 32, 'currentColor') ?>
            <span>Milestone Redaksi</span>
        </h2>
    </div>
    <div class="grid" style="grid-template-columns: repeat(<?= min(count($milestones), 3) ?>, 1fr);">
        <?php foreach ($milestones as $m): ?>
            <div class="news-milestone-3d reveal">
                <div class="news-milestone-ico-3d">
                    <?= renderNewsIcon($m[0], 32, '#03251f') ?>
                </div>
                <h3><?= e($m[1]) ?></h3>
                <p>Pencapaian publikasi LP3M/LPPAIK UNIMOF.</p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= MARQUEE ================= -->
<div class="marquee" aria-hidden="true">
    <div class="marquee-track">
        <?php foreach (array_merge(array_keys($categoryCounts), array_keys($categoryCounts)) as $m): ?>
            <span class="marquee-item" style="display:inline-flex; align-items:center; gap:10px;">
                <?= renderNewsIcon($categoryIcons[$m] ?? 'newspaper', 18, 'currentColor') ?>
                <span><?= e(ucfirst($m)) ?></span>
            </span>
        <?php endforeach; ?>
    </div>
</div>

<!-- ================= RUBRIK 3D ================= -->
<?php if ($topCategories !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>
            <?= renderNewsIcon('hash', 32, 'currentColor') ?>
            <span>Rubrik Populer</span>
        </h2>
        <span class="chip">Pilih sesuai minat</span>
    </div>
    <div class="grid" style="grid-template-columns: repeat(<?= min(count($topCategories), 5) ?>, 1fr);">
        <?php foreach ($topCategories as $cat => $cnt): ?>
            <a href="<?= e(url('public/index.php?page=berita&category=' . $cat)) ?>" class="rubrik-3d reveal">
                <div class="rubrik-orb-3d">
                    <?= renderNewsIcon($categoryIcons[$cat] ?? 'newspaper', 32, '#ffffff') ?>
                </div>
                <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 4px;"><?= e(ucfirst($cat)) ?></h3>
                <p style="font-size: 13px; color: var(--muted); margin: 0;"><strong style="color: var(--primary-dark);"><?= (int) $cnt ?></strong> artikel</p>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= TRENDING 3D ================= -->
<?php if ($trendingWeek !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>
            <?= renderNewsIcon('fire', 32, 'currentColor') ?>
            <span>Trending 2 Minggu Terakhir</span>
        </h2>
        <span class="chip"><?= count($trendingWeek) ?> artikel</span>
    </div>
    <div class="docs-list">
        <?php 
        $rankClasses = ['tr-gold', 'tr-silver', 'tr-bronze', 'tr-teal', 'tr-green'];
        foreach ($trendingWeek as $idx => $tw): 
            $rankClass = $rankClasses[$idx] ?? 'tr-green';
        ?>
            <a href="<?= e(url('public/index.php?page=berita-detail&slug=' . urlencode($tw['slug']))) ?>" class="trending-row-3d reveal">
                <div class="trending-rank-3d <?= $rankClass ?>">
                    <?php if ($idx === 0): ?>
                        <?= renderNewsIcon('fire', 24, 'currentColor') ?>
                    <?php else: ?>
                        <?= $idx + 1 ?>
                    <?php endif; ?>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <h3 style="color: var(--ink); font-size: 15px; line-height: 1.4; margin: 0 0 6px;"><?= e($tw['title']) ?></h3>
                    <div class="doc-meta" style="display: flex; gap: 10px; font-size: 12px; color: var(--muted); flex-wrap: wrap; align-items: center;">
                        <span style="font-size: 10px; padding: 3px 10px; background: rgba(5,150,105,.1); border: 1px solid rgba(5,150,105,.25); border-radius: 999px; color: var(--primary-dark); font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                            <?= renderNewsIcon($categoryIcons[$tw['category']] ?? 'newspaper', 12, 'currentColor') ?>
                            <span><?= e(ucfirst($tw['category'])) ?></span>
                        </span>
                        <span style="display:inline-flex; align-items:center; gap:5px;">
                            <?= renderNewsIcon('calendar', 12, 'currentColor') ?>
                            <span><?= e(date('d M Y', strtotime($tw['published_at'] ?? $tw['created_at']))) ?></span>
                        </span>
                        <span style="display:inline-flex; align-items:center; gap:5px;">
                            <?= renderNewsIcon('clock', 12, 'currentColor') ?>
                            <span><?= max(1, (int) round(str_word_count(strip_tags($tw['content'])) / 200)) ?> mnt</span>
                        </span>
                        <span style="display:inline-flex; align-items:center; gap:5px;">
                            <?= renderNewsIcon('eye', 12, 'currentColor') ?>
                            <span><?= number_format((int) ($tw['views'] ?? 0)) ?></span>
                        </span>
                    </div>
                </div>
                <div class="tr-arrow">
                    <?= renderNewsIcon('arrow-right', 16, '#ffffff') ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= HEATMAP 3D ================= -->
<?php if ($timeline !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>
            <?= renderNewsIcon('activity', 32, 'currentColor') ?>
            <span>Heatmap Publikasi 12 Bulan</span>
        </h2>
    </div>
    <?php
    $maxCnt = max(array_column($timeline, 'cnt'));
    $maxCnt = max(1, $maxCnt);
    $bulanNama = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    ?>
    <div style="background: var(--white); border: 1px solid var(--border); border-radius: 22px; padding: 26px; margin-bottom: 16px; box-shadow: 0 6px 20px rgba(0,0,0,0.04);">
        <div style="display: flex; align-items: flex-end; gap: 10px; height: 180px;">
            <?php foreach (array_reverse($timeline) as $t):
                $ym = explode('-', $t['ym']);
                $h = max(12, (int) (($t['cnt'] / $maxCnt) * 130));
            ?>
                <div class="heatmap-bar-3d" title="<?= (int) $t['cnt'] ?> artikel">
                    <span style="font-size: 11px; font-weight: 800; color: var(--primary-dark);"><?= (int) $t['cnt'] ?></span>
                    <div class="heatmap-bar-inner-3d" style="height: <?= $h ?>px;"></div>
                    <span style="font-size: 10px; color: var(--muted); font-weight: 600;"><?= $bulanNama[(int)$ym[1]-1] ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div style="margin-bottom: 0; display: flex; gap: 8px; flex-wrap: wrap;">
        <?php foreach ($timeline as $t): ?>
            <?php $ym = explode('-', $t['ym']); $label = $bulanNama[(int)$ym[1]-1] . ' ' . $ym[0]; ?>
            <span class="filter-3d" style="cursor: default;">
                <?= renderNewsIcon('calendar', 14, 'currentColor') ?>
                <span><?= e($label) ?></span>
                <span style="opacity:0.5;">·</span>
                <strong><?= (int) $t['cnt'] ?></strong>
            </span>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= LIVE FEED ================= -->
<?php if ($liveFeed !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>
            <?= renderNewsIcon('zap', 32, 'currentColor') ?>
            <span>Aktivitas Terbaru di LP3M</span>
        </h2>
        <span class="chip">Dari modul lain</span>
    </div>
    <div style="margin-bottom: 0; display: flex; gap: 8px; flex-wrap: wrap;">
        <?php foreach ($liveFeed as $lf): ?>
            <span class="filter-3d" style="cursor: default;">
                <?= renderNewsIcon($lf['icon'], 14, 'currentColor') ?>
                <span><?= e(excerpt($lf['title'], 40)) ?></span>
            </span>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= EDITORS PICKS ================= -->
<?php if ($editorsPicks !== [] && count($editorsPicks) >= 2): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>
            <?= renderNewsIcon('star', 32, 'currentColor') ?>
            <span>Pilihan Redaksi</span>
        </h2>
        <span class="chip">Artikel terbaru</span>
    </div>
    <div class="news-grid">
        <?php foreach (array_slice($editorsPicks, 0, 3) as $item): ?>
            <?php include BASE_PATH . '/resources/views/public/news/_card.php'; ?>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= SEARCH + TAG CLOUD ================= -->
<section class="section reveal" style="margin-bottom: 24px;">
    <div style="background: var(--white); border: 1px solid var(--border); border-radius: 22px; padding: 26px; box-shadow: 0 6px 20px rgba(0,0,0,0.04);">
        <!-- Search form -->
        <form method="get" action="<?= e(url('public/index.php')) ?>" style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
            <input type="hidden" name="page" value="berita">
            <?php if ($currentCategory !== ''): ?>
                <input type="hidden" name="category" value="<?= e($currentCategory) ?>">
            <?php endif; ?>
            <input type="text" name="q" value="<?= e($searchQ ?? '') ?>"
                   placeholder="Cari berita... (judul atau isi)"
                   class="news-search-input">
            <button type="submit" class="news-search-btn">
                <?= renderNewsIcon('search', 16, '#ffffff') ?>
                <span>Cari</span>
            </button>
            <?php if (!empty($searchQ)): ?>
                <a href="<?= e(url('public/index.php?page=berita')) ?>" class="news-reset-btn">
                    <?= renderNewsIcon('x', 14, 'currentColor') ?>
                    <span>Reset</span>
                </a>
            <?php endif; ?>
        </form>

        <!-- Tag cloud -->
        <?php if (!empty($tagCloud)): ?>
        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <span style="font-size: 11px; font-weight: 900; letter-spacing: 0.15em; color: var(--gold-strong); text-transform: uppercase; display: inline-flex; align-items: center; gap: 8px;">
                <?= renderNewsIcon('hash', 14, 'currentColor') ?>
                <span>TAGS POPULER</span>
            </span>
            <?php foreach ($tagCloud as $tc): ?>
                <a href="<?= e(url('public/index.php?page=berita&tag=' . urlencode($tc['slug']))) ?>"
                   class="filter-3d <?= ($currentTag ?? '') === $tc['slug'] ? 'active' : '' ?>"
                   style="font-size: 12px;">
                    <?= renderNewsIcon('hash', 12, 'currentColor') ?>
                    <span><?= e($tc['name']) ?></span>
                    <span style="opacity: 0.6; font-size: 10px;">(<?= (int) $tc['cnt'] ?>)</span>
                </a>
            <?php endforeach; ?>
            <?php if (!empty($currentTag)): ?>
                <a href="<?= e(url('public/index.php?page=berita' . ($currentCategory !== '' ? '&category=' . urlencode($currentCategory) : ''))) ?>"
                   class="news-reset-btn" style="padding: 6px 14px; font-size: 11px;">
                    <?= renderNewsIcon('x', 12, 'currentColor') ?>
                    <span>Hapus filter tag</span>
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ================= INFO FILTER AKTIF ================= -->
<?php if (!empty($currentTag) || !empty($searchQ)): ?>
<div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 18px; padding: 16px 20px; background: linear-gradient(145deg, rgba(217,164,65,0.08), rgba(217,164,65,0.03)); border: 1px solid rgba(217,164,65,0.25); border-radius: 14px; align-items: center;">
    <span style="font-size: 12.5px; font-weight: 800; color: var(--ink); display: inline-flex; align-items: center; gap: 8px;">
        <?= renderNewsIcon('search', 16, 'currentColor') ?>
        <span>Filter aktif:</span>
    </span>
    <?php if (!empty($currentTag)): ?>
        <span class="filter-active-pill">
            <?= renderNewsIcon('hash', 12, 'currentColor') ?>
            <span><?= e($currentTag) ?></span>
            <a href="<?= e(url('public/index.php?page=berita' . (!empty($searchQ) ? '&q=' . urlencode($searchQ) : ''))) ?>" aria-label="Hapus filter tag">
                <?= renderNewsIcon('x', 12, 'currentColor') ?>
            </a>
        </span>
    <?php endif; ?>
    <?php if (!empty($searchQ)): ?>
        <span class="filter-active-pill">
            <?= renderNewsIcon('search', 12, 'currentColor') ?>
            <span>"<?= e($searchQ) ?>"</span>
            <a href="<?= e(url('public/index.php?page=berita' . (!empty($currentTag) ? '&tag=' . urlencode($currentTag) : '') . ($currentCategory !== '' ? '&category=' . urlencode($currentCategory) : ''))) ?>" aria-label="Hapus filter search">
                <?= renderNewsIcon('x', 12, 'currentColor') ?>
            </a>
        </span>
    <?php endif; ?>
    <a href="<?= e(url('public/index.php?page=berita')) ?>"
       style="margin-left: auto; padding: 6px 14px; border-radius: 999px; font-size: 11px; font-weight: 700; color: #991b1b; background: rgba(220,38,38,.08); border: 1px solid rgba(220,38,38,.25); text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
        <?= renderNewsIcon('x', 12, 'currentColor') ?>
        <span>Reset semua</span>
    </a>
</div>
<?php endif; ?>

<!-- ================= FILTER KATEGORI 3D ================= -->
<div class="news-filter" style="display: flex; gap: 8px; flex-wrap: wrap; margin: 20px 0;">
    <a href="<?= e(url('public/index.php?page=berita')) ?>" class="filter-3d <?= $currentCategory === '' ? 'active' : '' ?>">
        <?= renderNewsIcon('newspaper', 14, 'currentColor') ?>
        <span>Semua</span>
    </a>
    <?php foreach ($categories as $cat): ?>
        <a href="<?= e(url('public/index.php?page=berita&category=' . $cat)) ?>" class="filter-3d <?= $currentCategory === $cat ? 'active' : '' ?>">
            <?= renderNewsIcon($categoryIcons[$cat] ?? 'newspaper', 14, 'currentColor') ?>
            <span><?= e(ucfirst($cat)) ?></span>
        </a>
    <?php endforeach; ?>
</div>

<p class="filter-count" style="display: inline-flex; align-items: center; gap: 8px;">
    <?= renderNewsIcon('activity', 14, 'currentColor') ?>
    <span>Menampilkan <?= count($items) ?> dari <?= (int) $totalBerita ?> berita tersedia.</span>
</p>

<?php if ($items === []): ?>
    <p class="news-empty" style="display: flex; align-items: center; gap: 12px; justify-content: center;">
        <?= renderNewsIcon('newspaper', 24, 'currentColor') ?>
        <span>Belum ada berita yang dipublikasikan.</span>
    </p>
<?php else: ?>
    <div class="news-grid">
        <?php foreach ($items as $item): ?>
            <?php include BASE_PATH . '/resources/views/public/news/_card.php'; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if ($totalPages > 1): ?>
    <div class="pagination" style="display: flex; gap: 6px; flex-wrap: wrap; margin-top: 22px;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= e(url('public/index.php?page=berita&hal=' . $i . ($currentCategory !== '' ? '&category=' . urlencode($currentCategory) : ''))) ?>" class="filter-3d <?= $i === $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

<!-- ================= CTA NEWSLETTER 3D ================= -->
<section class="cta-band reveal">
    <div>
        <h3 style="display: flex; align-items: center; gap: 12px;">
            <?= renderNewsIcon('mail', 32, '#f2c063') ?>
            <span>Jangan Lewatkan Informasi Penting</span>
        </h3>
        <p>Dapatkan ringkasan berita, publikasi ilmiah, dan kegiatan AIK langsung ke email Anda setiap minggu.</p>
    </div>
    <div class="cta-actions">
        <a href="<?= e(url('public/index.php?page=unduhan')) ?>" class="news-cta-3d news-cta-primary-3d">
            <?= renderNewsIcon('folder', 20, 'currentColor') ?>
            <span>Dokumen & Unduhan</span>
        </a>
        <a href="<?= e(url('public/index.php?page=aik')) ?>" class="news-cta-3d news-cta-ghost-3d">
            <?= renderNewsIcon('mosque', 20, 'currentColor') ?>
            <span>Kegiatan AIK</span>
        </a>
    </div>
</section>

<!-- ================= JAVASCRIPT: HERO SLIDER ================= -->
<?php if (!empty($slides) && count($slides) > 1): ?>
<script>
(function () {
    'use strict';
    var slider = document.getElementById('heroSlider');
    if (!slider) return;

    var slides = Array.prototype.slice.call(slider.querySelectorAll('.hero-slide-3d'));
    var dots = Array.prototype.slice.call(slider.querySelectorAll('.hero-dot-3d'));
    var prevBtn = document.getElementById('heroPrev');
    var nextBtn = document.getElementById('heroNext');
    var total = slides.length;
    var current = 0;
    var timer = null;
    var INTERVAL = 5000;

    function goTo(idx) {
        if (idx < 0) idx = total - 1;
        if (idx >= total) idx = 0;
        slides.forEach(function (s, i) { s.classList.toggle('active', i === idx); });
        dots.forEach(function (d, i) { d.classList.toggle('active', i === idx); });
        current = idx;
    }

    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }

    function startAuto() {
        stopAuto();
        timer = setInterval(next, INTERVAL);
    }
    function stopAuto() {
        if (timer) { clearInterval(timer); timer = null; }
    }

    if (nextBtn) nextBtn.addEventListener('click', function () { next(); startAuto(); });
    if (prevBtn) prevBtn.addEventListener('click', function () { prev(); startAuto(); });

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            goTo(parseInt(dot.getAttribute('data-dot'), 10));
            startAuto();
        });
    });

    slider.addEventListener('mouseenter', stopAuto);
    slider.addEventListener('mouseleave', startAuto);

    var startX = 0;
    slider.addEventListener('touchstart', function (e) {
        startX = e.touches[0].clientX;
        stopAuto();
    }, { passive: true });
    slider.addEventListener('touchend', function (e) {
        var diff = e.changedTouches[0].clientX - startX;
        if (Math.abs(diff) > 40) { diff < 0 ? next() : prev(); }
        startAuto();
    }, { passive: true });

    startAuto();
})();
</script>
<?php endif; ?>