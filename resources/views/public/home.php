<?php
$s = Setting::all();

// LIVE STATS
$statPengabdian = CommunityService::paginate(['status' => 'published'], '', [], 1, 1)['total'];
$statPublikasi  = Publication::paginate(['status' => 'published'], '', [], 1, 1)['total'];
$statHaki       = IntellectualProperty::paginate([], '', [], 1, 1)['total'];
$statAik        = AikActivity::paginate(['status' => 'published'], '', [], 1, 1)['total'];
$statBerita     = News::paginate([], 1, 1)['total'];
$statDokumen    = Document::paginate(['status' => 'published'], 1, 1)['total'];
$totalKarya = $statPengabdian + $statPublikasi + $statHaki + $statAik;

$featured = News::latest(1)[0] ?? null;

// LIVE FEED
$liveFeed = [];
try {
    $pdo = Database::pdo();
    foreach ($pdo->query('SELECT "news" as icon, title, "Berita" as type, created_at as date FROM news WHERE status="published" ORDER BY created_at DESC LIMIT 3')->fetchAll() as $f) $liveFeed[] = $f;
    foreach ($pdo->query('SELECT "book" as icon, title, "Publikasi" as type, created_at as date FROM publications WHERE status="published" ORDER BY created_at DESC LIMIT 3')->fetchAll() as $f) $liveFeed[] = $f;
    foreach ($pdo->query('SELECT "mosque" as icon, title, "Kegiatan AIK" as type, created_at as date FROM aik_activities WHERE status="published" ORDER BY created_at DESC LIMIT 3')->fetchAll() as $f) $liveFeed[] = $f;
    foreach ($pdo->query('SELECT "handshake" as icon, title, "Pengabdian" as type, created_at as date FROM community_services WHERE status="published" ORDER BY created_at DESC LIMIT 3')->fetchAll() as $f) $liveFeed[] = $f;
    usort($liveFeed, fn($a, $b) => strtotime($b['date']) <=> strtotime($a['date']));
    $liveFeed = array_slice($liveFeed, 0, 6);
} catch (\Throwable $e) { $liveFeed = []; }

// SLIDER IMAGES
$slides = [];
try {
    $pdo = Database::pdo();
    try {
        $slides = $pdo->query("SELECT image_path, title FROM galleries WHERE status='published' ORDER BY id DESC LIMIT 5")->fetchAll();
    } catch (\Throwable $e) {
        $slides = $pdo->query("SELECT image_path, title FROM galleries ORDER BY id DESC LIMIT 5")->fetchAll();
    }
} catch (\Throwable $e) { $slides = []; }

// AGENDA MENDATANG
$upEvents = [];
try {
    $upEvents = Database::pdo()->query("SELECT title, start_date, location, event_type FROM events WHERE status='published' AND start_date >= CURDATE() ORDER BY start_date ASC LIMIT 3")->fetchAll();
} catch (\Throwable $e) { $upEvents = []; }

// QUOTE
$quotes = [
    ['"Sebaik-baik manusia adalah yang paling bermanfaat bagi manusia." — HR. Ahmad', 'handshake'],
    ['"Ilmu tanpa amal seperti pohon tanpa buah." — Pepatah Arab', 'book'],
    ['"Fastabiqul Khairat — berlomba-lombalah dalam kebaikan." — QS. Al-Baqarah: 148', 'lightning'],
    ['"Riset adalah melihat apa yang dilihat semua orang dan memikirkan apa yang tidak dipikirkan siapapun." — Szent-Györgyi', 'microscope'],
];
$todayQuote = $quotes[date('z') % count($quotes)];

$hijriMonths = ['Muharram','Safar','Rabiul Awal','Rabiul Akhir','Jumadil Awal','Jumadil Akhir','Rajab','Syaban','Ramadhan','Syawal','Zulkaidah','Zulhijjah'];
$currentHijriMonth = $hijriMonths[((int) date('n') + 5) % 12];

$quickAccess = [
    ['newspaper', 'Berita', 'Info & pengumuman terbaru', 'berita'],
    ['folder-open', 'Unduhan', 'Dokumen & template resmi', 'unduhan'],
    ['handshake', 'Pengabdian', 'KKN & desa binaan', 'pengabdian'],
    ['book-open', 'Publikasi', 'Jurnal & karya ilmiah', 'publikasi'],
    ['shield-check', 'HAKI', 'Paten & hak cipta', 'publikasi'],
    ['mosque', 'AIK', 'Al-Islam & Kemuhammadiyahan', 'aik'],
];

$marqueeItems = ['Penelitian', 'Pengabdian', 'Publikasi Ilmiah', 'HAKI', 'Al-Islam & Kemuhammadiyahan', 'KKN', 'Desa Binaan', 'Catur Dharma', 'Fastabiqul Khairat', 'Berkemajuan'];
$icons = ['microscope', 'handshake', 'book-open', 'mosque'];
$slideCount = max(3, count($slides));

// ICON HELPER FUNCTION
function renderIcon($name, $size = 24, $color = 'currentColor') {
    $icons = [
        'newspaper' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="'.$color.'" viewBox="0 0 256 256"><path d="M208,32H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32Zm0,176H48V48H208V208Zm-96-80v48a8,8,0,0,1-16,0V128a8,8,0,0,1,16,0Zm48,0v48a8,8,0,0,1-16,0V128a8,8,0,0,1,16,0Zm48,0v48a8,8,0,0,1-16,0V128a8,8,0,0,1,16,0Z"/></svg>',
        'folder-open' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="'.$color.'" viewBox="0 0 256 256"><path d="M216,72H131.31L104,44.69A8,8,0,0,0,98.34,42H40A16,16,0,0,0,24,58V198a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V88A16,16,0,0,0,216,72Zm0,126H40V58H95.31l27.32,27.31A8,8,0,0,0,128.28,88H216V198Z"/></svg>',
        'handshake' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="'.$color.'" viewBox="0 0 256 256"><path d="M200,128a8,8,0,0,1-8,8H176a8,8,0,0,1,0-16h16A8,8,0,0,1,200,128ZM80,120H64a8,8,0,0,0,0,16H80a8,8,0,0,0,0-16Zm144-8H216V88a16,16,0,0,0-16-16H56A16,16,0,0,0,40,88v24H32a8,8,0,0,0,0,16h8v24a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V128h8a8,8,0,0,0,0-16ZM56,88H200v64H56V88Z"/></svg>',
        'book-open' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="'.$color.'" viewBox="0 0 256 256"><path d="M239.84,53.46A16,16,0,0,0,224,40H176V32a8,8,0,0,0-16,0v8H96V32a8,8,0,0,0-16,0v8H32A16,16,0,0,0,16.16,53.46,7.93,7.93,0,0,0,16,56v80a8,8,0,0,0,16,0V64H80V216H32V176a8,8,0,0,0-16,0v40a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V56A7.93,7.93,0,0,0,239.84,53.46ZM224,216H96V64H224V216Z"/></svg>',
        'shield-check' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="'.$color.'" viewBox="0 0 256 256"><path d="M128,24l96,48v40c0,58.4-38.6,107.4-96,120C70.6,219.4,32,170.4,32,112V72Zm0,176c50.2-13.4,80-54.8,80-104V84L128,48,48,84v28c0,49.2,29.8,90.6,80,104Zm44.5-88.5a8,8,0,0,1,0,11.3l-48,48a8,8,0,0,1-11.3,0l-24-24a8,8,0,0,1,11.3-11.3l18.3,18.3,42.3-42.3A8,8,0,0,1,172.5,111.5Z"/></svg>',
        'mosque' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="'.$color.'" viewBox="0 0 256 256"><path d="M216,128V80a8,8,0,0,0-16,0v48H176V88a48,48,0,0,0-96,0v40H56V80a8,8,0,0,0-16,0v48H24a8,8,0,0,0-8,8v80a8,8,0,0,0,8,8H232a8,8,0,0,0,8-8V136A8,8,0,0,0,216,128ZM96,88a32,32,0,0,1,64,0v40H96V88ZM224,208H32V144H224v64Z"/></svg>',
        'microscope' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="'.$color.'" viewBox="0 0 256 256"><path d="M216,192H184V120a8,8,0,0,0-8-8H144a8,8,0,0,0,0,16h24v64H40a8,8,0,0,0,0,16H216a8,8,0,0,0,0-16Zm-56-80V56a24,24,0,0,0-48,0v56a24,24,0,0,0,48,0Zm-16,0a8,8,0,0,1-16,0V56a8,8,0,0,1,16,0v56Z"/></svg>',
        'calendar' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="'.$color.'" viewBox="0 0 256 256"><path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32Zm0,176H48V80H208V208ZM176,104a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h80A8,8,0,0,1,176,104Zm0,32a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h80A8,8,0,0,1,176,136Zm0,32a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h80A8,8,0,0,1,176,168Z"/></svg>',
        'map-pin' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="'.$color.'" viewBox="0 0 256 256"><path d="M128,64a40,40,0,1,0,40,40A40,40,0,0,0,128,64Zm0,64a24,24,0,1,1,24-24A24,24,0,0,1,128,128Zm0-104a88.1,88.1,0,0,0-88,88c0,31.4,14.51,64.68,42,96.25a254.19,254.19,0,0,0,41.45,36.8,8.09,8.09,0,0,0,9.18,0A254.19,254.19,0,0,0,174,208.25c27.45-31.57,42-64.85,42-96.25A88.1,88.1,0,0,0,128,24Zm34.09,173.71C145.56,216.23,128,224,128,224s-17.56-7.77-34.09-26.29C70.08,169.57,56,139.39,56,112a72,72,0,0,1,144,0C200,139.39,185.92,169.57,162.09,197.71Z"/></svg>',
        'clock' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="'.$color.'" viewBox="0 0 256 256"><path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm40-72a8,8,0,0,1-8,8H128a8,8,0,0,1-8-8V80a8,8,0,0,1,16,0v56h24A8,8,0,0,1,168,144Z"/></svg>',
        'sparkle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="'.$color.'" viewBox="0 0 256 256"><path d="M128,24a8,8,0,0,1,8,8v32a8,8,0,0,1-16,0V32A8,8,0,0,1,128,24Zm72,80a8,8,0,0,0,8,8h32a8,8,0,0,0,0-16H208A8,8,0,0,0,200,104Zm-8,128a8,8,0,0,1-8,8H128a8,8,0,0,1,0-16h56A8,8,0,0,1,192,232ZM24,128a8,8,0,0,0,8,8H96a8,8,0,0,0,0-16H32A8,8,0,0,0,24,128Zm64,80a8,8,0,0,1-8,8H32a8,8,0,0,1,0-16H72A8,8,0,0,1,80,208Zm120-96a8,8,0,0,0,8,8h32a8,8,0,0,0,0-16H208A8,8,0,0,0,200,120Z"/></svg>',
        'lightning' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="'.$color.'" viewBox="0 0 256 256"><path d="M213.66,117.66a8,8,0,0,1-11.32,0L136,51.31,69.66,117.66a8,8,0,0,1-11.32-11.32l72-72a8,8,0,0,1,11.32,0l72,72A8,8,0,0,1,213.66,117.66Z"/></svg>',
        'news' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="'.$color.'" viewBox="0 0 256 256"><path d="M208,32H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32Zm0,176H48V48H208V208Zm-96-80v48a8,8,0,0,1-16,0V128a8,8,0,0,1,16,0Zm48,0v48a8,8,0,0,1-16,0V128a8,8,0,0,1,16,0Zm48,0v48a8,8,0,0,1-16,0V128a8,8,0,0,1,16,0Z"/></svg>',
        'book' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="'.$color.'" viewBox="0 0 256 256"><path d="M208,24H72A32,32,0,0,0,40,56V208a16,16,0,0,0,16,16H208a8,8,0,0,0,0-16H56V192H208a8,8,0,0,0,8-8V32A8,8,0,0,0,208,24Zm-8,16V176H56V56A16,16,0,0,1,72,40H200Z"/></svg>',
    ];
    return $icons[$name] ?? $icons['sparkle'];
}
?>

<style>
    /* ============ PREMIUM ICON SYSTEM ============ */
    .ico-3d { 
        display: inline-flex; 
        align-items: center; 
        justify-content: center; 
        width: 56px; 
        height: 56px; 
        border-radius: 18px; 
        font-size: 26px; 
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #34d399, #10b981 50%, #059669); 
        box-shadow: 
            inset 0 2px 3px rgba(255,255,255,0.6), 
            inset 0 -3px 4px rgba(0,0,0,0.25), 
            0 6px 16px rgba(5,150,105,0.35); 
        position: relative; 
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .ico-3d::before { 
        content: ''; 
        position: absolute; 
        top: 6px; 
        left: 10px; 
        width: 18px; 
        height: 8px; 
        border-radius: 50%; 
        background: rgba(255,255,255,0.6); 
        filter: blur(2px);
        z-index: 1;
    }
    .ico-3d svg { 
        position: relative; 
        z-index: 2;
        filter: drop-shadow(0 1px 2px rgba(0,0,0,0.2));
    }
    .ico-3d-lg { 
        width: 72px; 
        height: 72px; 
        border-radius: 22px; 
        font-size: 34px; 
    }
    .ico-3d-sm { 
        width: 44px; 
        height: 44px; 
        border-radius: 14px; 
        font-size: 20px; 
    }
    .ico-3d-gold { 
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%), linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441); 
        box-shadow: 
            inset 0 2px 3px rgba(255,255,255,0.7), 
            inset 0 -3px 4px rgba(0,0,0,0.2), 
            0 6px 16px rgba(217,164,65,0.4); 
    }
    .ico-3d-blue { 
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #60a5fa, #3b82f6 50%, #1d4ed8); 
        box-shadow: 
            inset 0 2px 3px rgba(255,255,255,0.6), 
            inset 0 -3px 4px rgba(0,0,0,0.25), 
            0 6px 16px rgba(59,130,246,0.35); 
    }
    .ico-3d-purple { 
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #c4b5fd, #a78bfa 50%, #7c3aed); 
        box-shadow: 
            inset 0 2px 3px rgba(255,255,255,0.6), 
            inset 0 -3px 4px rgba(0,0,0,0.25), 
            0 6px 16px rgba(124,58,237,0.35); 
    }
    .ico-3d-red { 
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #fca5a5, #ef4444 50%, #dc2626); 
        box-shadow: 
            inset 0 2px 3px rgba(255,255,255,0.6), 
            inset 0 -3px 4px rgba(0,0,0,0.25), 
            0 6px 16px rgba(239,68,68,0.35); 
    }

    /* ============ FULL-PAGE HERO SLIDER ============ */
    @keyframes hxKb { 
        from { transform: scale(1.02); } 
        to { transform: scale(1.14); } 
    }
    @keyframes hxUp { 
        from { 
            opacity: 0; 
            transform: translateY(26px); 
        } 
        to { 
            opacity: 1; 
            transform: none; 
        } 
    }
    @keyframes hxPulse { 
        0%,100% { 
            box-shadow: 0 0 0 0 rgba(110,231,183,.6); 
        } 
        50% { 
            box-shadow: 0 0 0 9px rgba(110,231,183,0); 
        } 
    }
    @keyframes hxFloat {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    @keyframes hxGlow {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 0.6; }
    }
    
    .hx-hero { 
        position: relative; 
        overflow: hidden; 
        border-radius: 30px; 
        height: 100vh;
        min-height: 700px;
        margin-bottom: 30px; 
        box-shadow: 0 30px 70px rgba(3,37,31,.35);
        margin-top: -36px; /* Compensate for main padding */
    }
    
    .hx-slide { 
        position: absolute; 
        inset: 0; 
        background-size: cover; 
        background-position: center; 
        opacity: 0; 
        transform: scale(1.06); 
        transition: opacity 1.2s ease; 
    }
    .hx-slide::after { 
        content: ''; 
        position: absolute; 
        inset: 0; 
        background-image: 
            repeating-linear-gradient(45deg, transparent, transparent 34px, rgba(255,255,255,0.03) 34px, rgba(255,255,255,0.03) 35px), 
            repeating-linear-gradient(-45deg, transparent, transparent 34px, rgba(255,255,255,0.03) 34px, rgba(255,255,255,0.03) 35px); 
    }
    .hx-slide.active { 
        opacity: 1; 
        animation: hxKb 9s ease-out both; 
    }
    
    .hx-fb-1 { background-image: linear-gradient(135deg, #043b2c 0%, #065f46 55%, #059669 100%); }
    .hx-fb-2 { background-image: linear-gradient(135deg, #0c1f4d 0%, #1e3a8a 55%, #3b82f6 100%); }
    .hx-fb-3 { background-image: linear-gradient(135deg, #3b2f0a 0%, #8a6f1a 55%, #d9a441 100%); }
    
    .hx-overlay { 
        position: absolute; 
        inset: 0; 
        background: 
            linear-gradient(115deg, rgba(2,26,20,.9) 0%, rgba(4,59,44,.72) 45%, rgba(4,59,44,.28) 75%, rgba(4,59,44,.15) 100%);
        backdrop-filter: blur(1px);
    }
    .hx-overlay::after { 
        content: ''; 
        position: absolute; 
        left: 0; 
        right: 0; 
        bottom: 0; 
        height: 140px; 
        background: linear-gradient(180deg, transparent, rgba(2,26,20,.75)); 
    }
    
    /* Premium floating orbs */
    .hx-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        animation: hxGlow 4s ease-in-out infinite;
        pointer-events: none;
    }
    .hx-orb-1 {
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(217,164,65,0.4), transparent);
        top: 10%;
        right: 5%;
    }
    .hx-orb-2 {
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(110,231,183,0.35), transparent);
        bottom: 15%;
        left: 10%;
        animation-delay: 1.5s;
    }
    .hx-orb-3 {
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(59,130,246,0.3), transparent);
        top: 50%;
        right: 40%;
        animation-delay: 3s;
    }
    
    .hx-content { 
        position: relative; 
        z-index: 3; 
        padding: 0 80px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        max-width: 900px; 
        color: #fff;
    }
    
    .hx-eyebrow { 
        display: inline-flex; 
        align-items: center; 
        gap: 9px; 
        padding: 8px 18px; 
        border-radius: 999px; 
        font-size: 11px; 
        font-weight: 900; 
        letter-spacing: .2em; 
        text-transform: uppercase; 
        background: rgba(253,230,138,.16); 
        border: 1px solid rgba(253,230,138,.4); 
        color: #fde68a; 
        backdrop-filter: blur(10px);
        animation: hxUp .7s .1s both;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .hx-eyebrow i { 
        width: 8px; 
        height: 8px; 
        border-radius: 50%; 
        background: #fde68a; 
        box-shadow: 0 0 8px rgba(253,230,138,.9);
        animation: hxPulse 2s infinite;
    }
    
    .hx-content h1 { 
        font-family: var(--font-display); 
        font-size: clamp(36px, 6vw, 68px); 
        font-weight: 900; 
        letter-spacing: -0.03em; 
        line-height: 1.06; 
        margin: 24px 0 20px; 
        animation: hxUp .7s .2s both;
        text-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }
    .hx-content h1 em { 
        font-style: normal; 
        background: linear-gradient(135deg, #fde68a, #f2c063 60%, #d9a441); 
        -webkit-background-clip: text; 
        background-clip: text; 
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 2px 8px rgba(217,164,65,0.4));
    }
    
    .hx-content p { 
        font-size: 18px; 
        line-height: 1.7; 
        opacity: .92; 
        max-width: 700px; 
        margin: 0 0 32px; 
        animation: hxUp .7s .3s both;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    .hx-actions { 
        display: flex; 
        gap: 14px; 
        flex-wrap: wrap; 
        animation: hxUp .7s .4s both;
        margin-bottom: 32px;
    }
    
    .hx-chips { 
        display: flex; 
        gap: 12px; 
        flex-wrap: wrap; 
        animation: hxUp .7s .5s both; 
    }
    .hx-chip { 
        display: inline-flex; 
        align-items: center; 
        gap: 8px; 
        padding: 9px 16px; 
        border-radius: 999px; 
        font-size: 12px; 
        font-weight: 800; 
        background: rgba(255,255,255,.12); 
        border: 1px solid rgba(255,255,255,.25); 
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }
    .hx-chip:hover {
        background: rgba(255,255,255,.18);
        border-color: rgba(255,255,255,.35);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.2);
    }
    .hx-chip svg {
        filter: drop-shadow(0 1px 2px rgba(0,0,0,0.3));
    }
    
    .hx-live { 
        position: absolute; 
        z-index: 4; 
        top: 32px; 
        right: 32px; 
        display: inline-flex; 
        align-items: center; 
        gap: 10px; 
        padding: 10px 20px; 
        border-radius: 999px; 
        background: rgba(16,185,129,.25); 
        border: 1px solid rgba(110,231,183,.4); 
        color: #fff; 
        font-size: 13px; 
        font-weight: 800; 
        backdrop-filter: blur(12px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.2);
        animation: hxFloat 3s ease-in-out infinite;
    }
    .hx-live i { 
        width: 10px; 
        height: 10px; 
        border-radius: 50%; 
        background: radial-gradient(circle at 30% 30%, #6ee7b7, #10b981); 
        animation: hxPulse 2s infinite;
        box-shadow: 0 0 12px rgba(110,231,183,0.6);
    }
    
    .hx-ui { 
        position: absolute; 
        z-index: 4; 
        left: 80px; 
        right: 80px; 
        bottom: 40px; 
        display: flex; 
        align-items: center; 
        gap: 16px; 
    }
    
    .hx-btn { 
        width: 48px; 
        height: 48px; 
        border-radius: 50%; 
        border: 1px solid rgba(255,255,255,.3); 
        background: rgba(255,255,255,.12); 
        color: #fff; 
        font-size: 20px; 
        cursor: pointer; 
        backdrop-filter: blur(12px); 
        transition: all .25s; 
        display: flex; 
        align-items: center; 
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    .hx-btn:hover { 
        background: rgba(253,230,138,.9); 
        color: #03251f; 
        border-color: transparent; 
        transform: scale(1.12);
        box-shadow: 0 6px 20px rgba(253,230,138,0.4);
    }
    
    .hx-dots { 
        display: flex; 
        gap: 10px; 
        flex: 1; 
        justify-content: center; 
    }
    .hx-dot { 
        width: 12px; 
        height: 12px; 
        border-radius: 999px; 
        border: none; 
        background: rgba(255,255,255,.35); 
        cursor: pointer; 
        transition: all .35s; 
        padding: 0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    .hx-dot.active { 
        width: 42px; 
        background: linear-gradient(90deg, #fde68a, #d9a441); 
        box-shadow: 0 0 16px rgba(253,230,138,.6), 0 4px 12px rgba(0,0,0,0.3); 
    }
    
    .hx-counter { 
        font-family: var(--font-display); 
        font-size: 14px; 
        font-weight: 900; 
        color: rgba(255,255,255,.85); 
        letter-spacing: .1em;
        text-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
    .hx-counter b { 
        color: #fde68a; 
        font-size: 18px;
        filter: drop-shadow(0 1px 3px rgba(217,164,65,0.4));
    }
    
    .hx-progress { 
        position: absolute; 
        z-index: 4; 
        left: 0; 
        right: 0; 
        bottom: 0; 
        height: 5px; 
        background: rgba(255,255,255,.15);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .hx-progress i { 
        display: block; 
        height: 100%; 
        width: 0; 
        background: linear-gradient(90deg, #fde68a, #d9a441);
        box-shadow: 0 0 12px rgba(253,230,138,0.6);
    }
    .hx-progress i.run { 
        animation: hxBar 6.5s linear both; 
    }
    @keyframes hxBar { 
        from { width: 0; } 
        to { width: 100%; } 
    }
    
    @media (max-width: 768px) { 
        .hx-hero { 
            height: auto;
            min-height: 600px; 
        } 
        .hx-content { 
            padding: 80px 26px 140px; 
        } 
        .hx-ui { 
            left: 26px; 
            right: 26px; 
            bottom: 30px;
        } 
        .hx-live { 
            top: 20px; 
            right: 20px; 
        }
        .hx-orb { display: none; }
    }

    /* ============ PREMIUM AGENDA STRIP ============ */
    .agx-grid { 
        display: grid; 
        grid-template-columns: repeat(3, 1fr); 
        gap: 20px; 
    }
    @media (max-width: 900px) { 
        .agx-grid { 
            grid-template-columns: 1fr; 
        } 
    }
    .agx-card { 
        display: flex; 
        gap: 16px; 
        padding: 22px; 
        border-radius: 20px; 
        background: var(--surface); 
        border: 1px solid var(--border); 
        text-decoration: none; 
        color: inherit; 
        transition: all .3s cubic-bezier(.16,1,.3,1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .agx-card:hover { 
        transform: translateY(-6px); 
        box-shadow: 0 16px 36px rgba(5,150,105,.18); 
        border-color: rgba(5,150,105,.35);
    }
    .agx-date { 
        width: 66px; 
        height: 70px; 
        border-radius: 16px; 
        background: linear-gradient(145deg, #065f46, #043b2c); 
        color: #fde68a; 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center; 
        flex-shrink: 0; 
        box-shadow: 
            inset 0 1px 2px rgba(255,255,255,.15), 
            0 6px 14px rgba(3,37,31,.3);
        transition: transform 0.3s ease;
    }
    .agx-card:hover .agx-date {
        transform: scale(1.05) rotate(-3deg);
    }
    .agx-date b { 
        font-family: var(--font-display); 
        font-size: 24px; 
        line-height: 1;
        filter: drop-shadow(0 1px 2px rgba(0,0,0,0.3));
    }
    .agx-date span { 
        font-size: 10px; 
        font-weight: 800; 
        letter-spacing: .1em; 
        text-transform: uppercase; 
        opacity: .85; 
        margin-top: 4px; 
    }
    .agx-in { 
        flex: 1; 
        min-width: 0; 
    }
    .agx-in h4 { 
        margin: 0 0 8px; 
        font-size: 15px; 
        font-weight: 800; 
        color: var(--ink); 
        display: -webkit-box; 
        -webkit-line-clamp: 2; 
        -webkit-box-orient: vertical; 
        overflow: hidden;
        line-height: 1.4;
    }
    .agx-meta { 
        font-size: 12px; 
        color: var(--muted); 
        display: flex; 
        gap: 10px; 
        flex-wrap: wrap;
        align-items: center;
    }
    .agx-meta svg {
        filter: drop-shadow(0 1px 2px rgba(0,0,0,0.1));
    }
    .agx-days { 
        margin-top: 10px; 
        display: inline-flex; 
        align-items: center;
        gap: 6px;
        padding: 4px 12px; 
        border-radius: 999px; 
        font-size: 11px; 
        font-weight: 900; 
        background: rgba(234,88,12,.12); 
        color: #c2410c; 
        border: 1px solid rgba(234,88,12,.3);
        box-shadow: 0 2px 6px rgba(234,88,12,0.15);
    }

    /* ============ PREMIUM STATS & QUOTE ============ */
    .stat-3d { 
        position: relative; 
        padding: 32px; 
        border-radius: 24px; 
        background: linear-gradient(145deg, #065f46, #043b2c); 
        border: 1px solid rgba(217,164,65,0.25); 
        overflow: hidden; 
        box-shadow: 
            inset 0 1px 1px rgba(255,255,255,0.08), 
            0 10px 30px rgba(0,0,0,0.25);
    }
    .stat-3d::before { 
        content: ''; 
        position: absolute; 
        top: -50%; 
        right: -30%; 
        width: 200px; 
        height: 200px; 
        border-radius: 50%; 
        background: radial-gradient(circle, rgba(217,164,65,0.2), transparent 70%);
        animation: hxGlow 5s ease-in-out infinite;
    }
    .stat-3d-num { 
        font-family: var(--font-display); 
        font-size: 48px; 
        font-weight: 900; 
        background: linear-gradient(135deg, #fde68a, #f2c063 40%, #d9a441); 
        -webkit-background-clip: text; 
        background-clip: text; 
        -webkit-text-fill-color: transparent; 
        line-height: 1;
        filter: drop-shadow(0 2px 4px rgba(217,164,65,0.3));
    }
    .counter-3d { 
        font-family: var(--font-display); 
        font-size: 48px; 
        font-weight: 900; 
        line-height: 1; 
        background: linear-gradient(135deg, #fde68a, #f2c063 40%, #d9a441); 
        -webkit-background-clip: text; 
        background-clip: text; 
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 2px 4px rgba(217,164,65,0.3));
    }
    .quote-3d { 
        position: relative; 
        padding: 32px; 
        border-radius: 24px; 
        background: linear-gradient(145deg, #065f46, #03251f); 
        border: 1px solid rgba(217,164,65,0.25); 
        overflow: hidden; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .quote-3d::before { 
        content: ''; 
        position: absolute; 
        top: -60%; 
        right: -20%; 
        width: 250px; 
        height: 250px; 
        border-radius: 50%; 
        background: radial-gradient(circle, rgba(217,164,65,0.25), transparent 70%);
        animation: hxGlow 6s ease-in-out infinite;
    }
    .quote-mark-3d { 
        position: absolute; 
        top: 12px; 
        left: 18px; 
        font-size: 90px; 
        line-height: 1; 
        color: rgba(217,164,65,0.15); 
        font-family: Georgia, serif;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }
    
    .featured-badge-3d { 
        display: inline-flex; 
        align-items: center; 
        gap: 8px; 
        padding: 8px 18px; 
        border-radius: 999px; 
        font-size: 12px; 
        font-weight: 800; 
        letter-spacing: 0.12em; 
        color: #03251f; 
        background: linear-gradient(145deg, #fde68a, #d9a441); 
        box-shadow: 
            inset 0 1px 2px rgba(255,255,255,0.7), 
            0 4px 10px rgba(217,164,65,0.4);
        text-transform: uppercase;
    }
    
    .card-num-3d { 
        position: absolute; 
        top: 16px; 
        right: 16px; 
        width: 44px; 
        height: 44px; 
        border-radius: 14px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-family: var(--font-display); 
        font-weight: 900; 
        font-size: 16px; 
        color: #03251f; 
        background: linear-gradient(145deg, #fde68a, #d9a441); 
        box-shadow: 
            inset 0 1px 2px rgba(255,255,255,0.7), 
            0 3px 8px rgba(217,164,65,0.3);
        transition: transform 0.3s ease;
    }
    .card:hover .card-num-3d {
        transform: scale(1.1) rotate(-5deg);
    }
    
    .feed-3d { 
        display: flex; 
        align-items: center; 
        gap: 16px; 
        padding: 18px 22px; 
        background: var(--surface); 
        border: 1px solid var(--border); 
        border-radius: 20px; 
        transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .feed-3d:hover { 
        transform: translateY(-4px); 
        box-shadow: 0 12px 28px rgba(5,150,105,0.18); 
        border-color: rgba(5,150,105,0.3);
    }
    .feed-3d .ico-3d {
        transition: all 0.3s ease;
    }
    .feed-3d:hover .ico-3d {
        transform: scale(1.1) rotate(-3deg);
    }
    
    .qa-3d { 
        position: relative; 
        padding: 32px 20px; 
        background: var(--surface); 
        border: 1px solid var(--border); 
        border-radius: 24px; 
        text-align: center; 
        transition: all 0.35s cubic-bezier(0.16,1,0.3,1); 
        overflow: hidden; 
        display: block;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .qa-3d::before { 
        content: ''; 
        position: absolute; 
        top: 0; 
        left: 0; 
        right: 0; 
        height: 4px; 
        background: linear-gradient(90deg, var(--gold), var(--primary)); 
        transform: scaleX(0); 
        transform-origin: left; 
        transition: transform 0.4s ease; 
    }
    .qa-3d:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 24px 48px rgba(5,150,105,0.22); 
        border-color: rgba(5,150,105,0.3);
    }
    .qa-3d:hover::before { 
        transform: scaleX(1); 
    }
    .qa-3d:hover .ico-3d { 
        transform: scale(1.15) rotate(-6deg); 
    }
    
    .impact-num-3d { 
        font-family: var(--font-display); 
        font-size: clamp(64px, 12vw, 100px); 
        font-weight: 900; 
        line-height: 1; 
        background: linear-gradient(135deg, #fde68a 0%, #f2c063 40%, #d9a441 70%, #a9761b); 
        -webkit-background-clip: text; 
        background-clip: text; 
        -webkit-text-fill-color: transparent; 
        display: inline-block;
        filter: drop-shadow(0 4px 12px rgba(217,164,65,0.4));
    }
    
    .cta-3d { 
        position: relative; 
        display: inline-flex; 
        align-items: center; 
        gap: 10px; 
        padding: 16px 30px; 
        border-radius: 16px; 
        font-weight: 700; 
        font-size: 15px; 
        overflow: hidden; 
        transition: all 0.3s cubic-bezier(0.16,1,0.3,1); 
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .cta-3d svg {
        filter: drop-shadow(0 1px 2px rgba(0,0,0,0.2));
    }
    .cta-3d-primary { 
        background: linear-gradient(145deg, #fde68a, #d9a441); 
        color: #03251f; 
        box-shadow: 
            inset 0 2px 3px rgba(255,255,255,0.7), 
            0 8px 20px rgba(217,164,65,0.4); 
    }
    .cta-3d-ghost { 
        background: transparent; 
        color: #fff; 
        border: 2px solid rgba(255,255,255,0.35);
        backdrop-filter: blur(8px);
    }
    .cta-3d:hover { 
        transform: translateY(-4px);
    }
    .cta-3d-primary:hover {
        box-shadow: 
            inset 0 2px 3px rgba(255,255,255,0.8), 
            0 12px 28px rgba(217,164,65,0.5);
    }
    .cta-3d-ghost:hover {
        background: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.5);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    
    .live-mini { 
        display: inline-flex; 
        align-items: center; 
        gap: 10px; 
        padding: 7px 14px; 
        border-radius: 999px; 
        font-size: 12px; 
        font-weight: 800; 
        letter-spacing: 0.1em; 
        background: rgba(16,185,129,0.15); 
        border: 1px solid rgba(110,231,183,0.3); 
        color: #6ee7b7;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .mini-stat-3d { 
        padding: 16px; 
        border-radius: 18px; 
        background: rgba(255,255,255,0.05); 
        border: 1px solid rgba(255,255,255,0.08); 
        text-align: center;
        transition: all 0.3s ease;
    }
    .mini-stat-3d:hover {
        background: rgba(255,255,255,0.08);
        border-color: rgba(255,255,255,0.15);
        transform: translateY(-2px);
    }

    /* ============ PREMIUM CARD ENHANCEMENTS ============ */
    .card {
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 24px 48px rgba(5,150,105,0.22);
    }
    .card:hover .ico-3d {
        transform: scale(1.15) rotate(-6deg);
    }
    .card:hover .card-num-3d {
        transform: scale(1.1) rotate(-5deg);
    }
    
    /* ============ PREMIUM SECTION HEADINGS ============ */
    .section-head h2 {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 12px;
    }
    .section-head h2 svg {
        filter: drop-shadow(0 2px 4px rgba(5,150,105,0.3));
    }
    
    /* ============ RESPONSIVE ENHANCEMENTS ============ */
    @media (max-width: 768px) {
        .stat-3d, .quote-3d {
            padding: 24px;
        }
        .stat-3d-num, .counter-3d {
            font-size: 36px;
        }
        .agx-card {
            padding: 18px;
        }
        .agx-date {
            width: 58px;
            height: 62px;
        }
        .agx-date b {
            font-size: 20px;
        }
        .qa-3d {
            padding: 24px 16px;
        }
        .ico-3d {
            width: 48px;
            height: 48px;
        }
        .ico-3d-lg {
            width: 64px;
            height: 64px;
        }
        .cta-3d {
            padding: 14px 24px;
            font-size: 14px;
        }
    }
</style>

<!-- ============ FULL-PAGE HERO SLIDER ============ -->
<section class="hx-hero" id="hxHero">
    <div class="hx-slides">
        <?php if (!empty($slides)): ?>
            <?php foreach ($slides as $i => $sl): ?>
            <div class="hx-slide <?= $i === 0 ? 'active' : '' ?>" style="background-image:url('<?= e(upload_url($sl['image_path'])) ?>')" data-title="<?= e($sl['title']) ?>"></div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="hx-slide hx-fb-1 active"></div>
            <div class="hx-slide hx-fb-2"></div>
            <div class="hx-slide hx-fb-3"></div>
        <?php endif; ?>
    </div>
    <div class="hx-overlay"></div>
    
    <!-- Premium floating orbs -->
    <div class="hx-orb hx-orb-1"></div>
    <div class="hx-orb hx-orb-2"></div>
    <div class="hx-orb hx-orb-3"></div>

    <div class="hx-live">
        <i></i> 
        <span>LIVE · <?= number_format($totalKarya) ?>+ Karya</span>
    </div>

    <div class="hx-content">
        <span class="hx-eyebrow"><i></i> LP3M · Catur Dharma</span>
        <h1><?= e($s['home_hero_title']) ?></h1>
        <p><?= e($s['home_hero_text']) ?></p>
        <div class="hx-actions">
            <a href="<?= e(url('public/index.php?page=tentang')) ?>" class="cta-3d cta-3d-primary">
                <?= e($s['home_hero_button_text']) ?>
            </a>
            <a href="<?= e(url('public/index.php?page=publikasi')) ?>" class="cta-3d cta-3d-ghost">
                <?= renderIcon('book-open', 20, 'currentColor') ?>
                <span>Jelajahi Publikasi</span>
            </a>
        </div>
        <div class="hx-chips">
            <span class="hx-chip">
                <?= renderIcon('microscope', 18, 'currentColor') ?>
                <span>Penelitian</span>
            </span>
            <span class="hx-chip">
                <?= renderIcon('handshake', 18, 'currentColor') ?>
                <span>Pengabdian</span>
            </span>
            <span class="hx-chip">
                <?= renderIcon('book-open', 18, 'currentColor') ?>
                <span>Publikasi</span>
            </span>
            <span class="hx-chip">
                <?= renderIcon('mosque', 18, 'currentColor') ?>
                <span>AIK</span>
            </span>
        </div>
    </div>

    <div class="hx-ui">
        <button class="hx-btn" id="hxPrev" aria-label="Sebelumnya">‹</button>
        <div class="hx-dots" id="hxDots"></div>
        <button class="hx-btn" id="hxNext" aria-label="Berikutnya">›</button>
        <span class="hx-counter"><b id="hxNow">01</b> / <span id="hxTotal"><?= str_pad((string) $slideCount, 2, '0', STR_PAD_LEFT) ?></span></span>
    </div>
    <div class="hx-progress"><i id="hxBar"></i></div>
</section>

<!-- QUOTE + STATUS -->
<section class="stats reveal">
    <div class="quote-3d" style="grid-column: span 2;">
        <div class="quote-mark-3d">"</div>
        <div style="position: relative; z-index: 1; display: flex; align-items: center; gap: 20px;">
            <div class="ico-3d ico-3d-lg ico-3d-gold">
                <?= renderIcon($todayQuote[1], 32, '#ffffff') ?>
            </div>
            <div style="flex: 1;">
                <p style="font-size: 17px; line-height: 1.6; margin-bottom: 10px; font-style: italic; color: #f2c063; font-family: var(--font-display);"><?= $todayQuote[0] ?></p>
                <p style="font-size: 13px; opacity: 0.7; display: flex; align-items: center; gap: 10px;">
                    <?= renderIcon('calendar', 16, 'currentColor') ?>
                    <span>Bulan <?= $currentHijriMonth ?> · <?= date('d M Y') ?></span>
                </p>
            </div>
        </div>
    </div>

    <div class="stat-3d stagger-2" style="grid-column: span 2;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; position: relative; z-index: 1;">
            <span style="font-size: 12px; letter-spacing: 0.15em; color: #f2c063; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <span style="width:8px;height:8px;background:#6ee7b7;border-radius:50%;"></span>
                STATUS LEMBAGA
            </span>
            <span class="live-mini">
                <span style="width:8px;height:8px;background:#6ee7b7;border-radius:50%;animation: hxPulse 2s infinite;"></span> 
                LIVE
            </span>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; position: relative; z-index: 1;">
            <div class="mini-stat-3d">
                <div class="stat-3d-num"><?= (int) $statBerita ?></div>
                <div style="font-size: 11px; opacity: 0.8; margin-top: 6px; color: rgba(255,255,255,0.8); display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <?= renderIcon('news', 14, 'currentColor') ?>
                    <span>Berita</span>
                </div>
            </div>
            <div class="mini-stat-3d">
                <div class="stat-3d-num"><?= (int) $statDokumen ?></div>
                <div style="font-size: 11px; opacity: 0.8; margin-top: 6px; color: rgba(255,255,255,0.8); display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <?= renderIcon('folder-open', 14, 'currentColor') ?>
                    <span>Dokumen</span>
                </div>
            </div>
            <div class="mini-stat-3d">
                <div class="stat-3d-num"><?= number_format($totalKarya) ?></div>
                <div style="font-size: 11px; opacity: 0.8; margin-top: 6px; color: rgba(255,255,255,0.8); display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <?= renderIcon('sparkle', 14, 'currentColor') ?>
                    <span>Total</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS COUNTER -->
<section class="stats" aria-label="Statistik lembaga">
    <div class="stat reveal stagger-1">
        <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
            <div class="ico-3d">
                <?= renderIcon('handshake', 26, '#ffffff') ?>
            </div>
            <div>
                <div class="counter-3d" data-count="<?= (int) $statPengabdian ?>" data-suffix="+">0</div>
                <div class="stat-label">Pengabdian & KKN</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-2">
        <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
            <div class="ico-3d ico-3d-gold">
                <?= renderIcon('book-open', 26, '#ffffff') ?>
            </div>
            <div>
                <div class="counter-3d" data-count="<?= (int) $statPublikasi ?>" data-suffix="+">0</div>
                <div class="stat-label">Publikasi Ilmiah</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-3">
        <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
            <div class="ico-3d ico-3d-blue">
                <?= renderIcon('shield-check', 26, '#ffffff') ?>
            </div>
            <div>
                <div class="counter-3d" data-count="<?= (int) $statHaki ?>" data-suffix="+">0</div>
                <div class="stat-label">HAKI Terdaftar</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-4">
        <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
            <div class="ico-3d ico-3d-purple">
                <?= renderIcon('mosque', 26, '#ffffff') ?>
            </div>
            <div>
                <div class="counter-3d" data-count="<?= (int) $statAik ?>" data-suffix="+">0</div>
                <div class="stat-label">Kegiatan AIK</div>
            </div>
        </div>
    </div>
</section>

<!-- AGENDA MENDATANG -->
<?php if (!empty($upEvents)): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>
            <?= renderIcon('calendar', 28, 'currentColor') ?>
            <span>Agenda Mendatang</span>
        </h2>
        <a class="btn-more" href="<?= e(url('public/index.php?page=agenda')) ?>">
            Lihat Semua →
        </a>
    </div>
    <div class="agx-grid">
        <?php foreach ($upEvents as $ev):
            $daysLeft = (int) ((strtotime($ev['start_date']) - strtotime(date('Y-m-d'))) / 86400);
        ?>
        <a class="agx-card" href="<?= e(url('public/index.php?page=agenda')) ?>">
            <div class="agx-date">
                <b><?= date('d', strtotime($ev['start_date'])) ?></b>
                <span><?= strtoupper(date('M', strtotime($ev['start_date']))) ?></span>
            </div>
            <div class="agx-in">
                <h4><?= e($ev['title']) ?></h4>
                <div class="agx-meta">
                    <span style="display: flex; align-items: center; gap: 6px;">
                        <?= renderIcon('map-pin', 14, 'currentColor') ?>
                        <span><?= e($ev['location'] ?: 'TBA') ?></span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 6px;">
                        <?= renderIcon('sparkle', 14, 'currentColor') ?>
                        <span><?= e(ucfirst(str_replace('_', ' ', $ev['event_type']))) ?></span>
                    </span>
                </div>
                <span class="agx-days">
                    <?= renderIcon('clock', 14, 'currentColor') ?>
                    <span><?= $daysLeft === 0 ? ' Hari ini!' : $daysLeft . ' hari lagi' ?></span>
                </span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- FEATURED -->
<?php if ($featured !== null): ?>
<section class="reveal" style="margin-bottom: 32px;">
    <div style="background: linear-gradient(135deg, #043b2c, #065f46); color: white; border-radius: 28px; overflow: hidden; box-shadow: 0 24px 54px rgba(0,0,0,0.35); display: grid; grid-template-columns: <?= !empty($featured['thumbnail']) ? '1.2fr 1fr' : '1fr' ?>;">
        <?php if (!empty($featured['thumbnail'])): ?>
            <img src="<?= e(upload_url($featured['thumbnail'])) ?>" alt="<?= e($featured['title']) ?>" style="width: 100%; height: 100%; object-fit: cover; min-height: 300px;" loading="lazy">
        <?php endif; ?>
        <div style="padding: 40px;">
            <span class="featured-badge-3d">
                <?= renderIcon('lightning', 16, 'currentColor') ?>
                <span>SOROTAN TERBARU</span>
            </span>
            <h2 style="font-size: clamp(24px, 3.5vw, 34px); font-weight: 800; margin: 20px 0; letter-spacing: -0.02em; line-height: 1.25;"><?= e($featured['title']) ?></h2>
            <p style="color: rgba(255,255,255,0.85); margin-bottom: 24px; line-height: 1.7;"><?= e(excerpt($featured['content'], 170)) ?></p>
            <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 26px; font-size: 13px; color: rgba(255,255,255,0.7); flex-wrap: wrap;">
                <span class="badge" style="background: rgba(217,164,65,0.3); color: #f2c063; border: 1px solid rgba(217,164,65,0.4); display: flex; align-items: center; gap: 6px;">
                    <?= renderIcon('sparkle', 14, 'currentColor') ?>
                    <span><?= e(ucfirst($featured['category'])) ?></span>
                </span>
                <span style="display: flex; align-items: center; gap: 6px;">
                    <?= renderIcon('calendar', 14, 'currentColor') ?>
                    <span><?= e(date('d M Y', strtotime($featured['published_at'] ?? $featured['created_at']))) ?></span>
                </span>
                <span style="display: flex; align-items: center; gap: 6px;">
                    <?= renderIcon('clock', 14, 'currentColor') ?>
                    <span><?= max(1, (int) round(str_word_count(strip_tags($featured['content'])) / 200)) ?> mnt</span>
                </span>
            </div>
            <a class="cta-3d cta-3d-primary" href="<?= e(url('public/index.php?page=berita-detail&slug=' . urlencode($featured['slug']))) ?>">
                Baca Lengkap →
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- MARQUEE -->
<div class="marquee" aria-hidden="true">
    <div class="marquee-track">
        <?php foreach (array_merge($marqueeItems, $marqueeItems) as $m): ?>
            <span class="marquee-item"><?= e($m) ?></span>
        <?php endforeach; ?>
    </div>
</div>

<!-- CATUR DHARMA -->
<section class="section section--cream">
    <div class="section-head">
        <h2>
            <?= renderIcon('sparkle', 28, 'currentColor') ?>
            <span><?= e($s['home_section_title']) ?></span>
        </h2>
    </div>
    <div class="grid">
        <?php for ($i = 1; $i <= 4; $i++): ?>
            <div class="card reveal stagger-<?= $i ?>">
                <div class="card-num-3d">0<?= $i ?></div>
                <div class="card-icon">
                    <span class="ico-3d">
                        <?= renderIcon($icons[$i - 1], 26, '#ffffff') ?>
                    </span>
                </div>
                <h3><?= e($s['home_card' . $i . '_title']) ?></h3>
                <p><?= e($s['home_card' . $i . '_text']) ?></p>
            </div>
        <?php endfor; ?>
    </div>
</section>

<!-- LIVE FEED -->
<?php if ($liveFeed !== []): ?>
<section class="section">
    <div class="section-head">
        <h2>
            <?= renderIcon('lightning', 28, 'currentColor') ?>
            <span>Aktivitas Terbaru Lembaga</span>
        </h2>
        <span class="live-mini">
            <span style="width:8px;height:8px;background:#6ee7b7;border-radius:50%;animation: hxPulse 2s infinite;"></span> 
            LIVE
        </span>
    </div>
    <div class="docs-list">
        <?php foreach ($liveFeed as $f): ?>
            <div class="feed-3d reveal">
                <div class="ico-3d ico-3d-sm">
                    <?= renderIcon($f['icon'], 22, '#ffffff') ?>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <h3 style="font-size: 16px; margin-bottom: 6px; color: var(--ink); line-height: 1.4;"><?= e($f['title']) ?></h3>
                    <div style="display: flex; gap: 12px; font-size: 13px; color: var(--muted); flex-wrap: wrap; align-items: center;">
                        <span class="badge" style="font-size: 11px; padding: 3px 10px; display: flex; align-items: center; gap: 5px;">
                            <?= renderIcon('sparkle', 12, 'currentColor') ?>
                            <span><?= e($f['type']) ?></span>
                        </span>
                        <span style="display: flex; align-items: center; gap: 6px;">
                            <?= renderIcon('calendar', 13, 'currentColor') ?>
                            <span><?= e(date('d M Y', strtotime($f['date']))) ?></span>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- QUICK ACCESS -->
<section class="section section--teal">
    <div class="section-head">
        <h2>
            <?= renderIcon('lightning', 28, 'currentColor') ?>
            <span>Akses Cepat</span>
        </h2>
    </div>
    <div class="grid" style="grid-template-columns: repeat(<?= min(count($quickAccess), 3) ?>, 1fr);">
        <?php foreach ($quickAccess as $idx => $qa): ?>
            <a href="<?= e(url('public/index.php?page=' . $qa[3])) ?>" class="qa-3d reveal stagger-<?= ($idx % 4) + 1 ?>">
                <div style="display: flex; justify-content: center; margin-bottom: 16px;">
                    <div class="ico-3d ico-3d-lg">
                        <?= renderIcon($qa[0], 32, '#ffffff') ?>
                    </div>
                </div>
                <h3 style="font-size: 19px; font-weight: 800; margin-bottom: 6px;"><?= e($qa[1]) ?></h3>
                <p style="font-size: 14px; color: var(--muted);"><?= e($qa[2]) ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- BERITA TERBARU -->
<?php if (!empty($latest)): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>
            <?= renderIcon('news', 28, 'currentColor') ?>
            <span>Berita Terbaru</span>
        </h2>
        <a class="btn-more" href="<?= e(url('public/index.php?page=berita')) ?>">
            Lihat Semua →
        </a>
    </div>
    <div class="news-grid">
        <?php foreach ($latest as $item): ?>
            <?php include BASE_PATH . '/resources/views/public/news/_card.php'; ?>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- IMPACT -->
<section class="section reveal">
    <div style="background: linear-gradient(135deg, #043b2c 0%, #065f46 60%, #059669 100%); color: white; padding: 60px 50px; border-radius: 28px; text-align: center; box-shadow: 0 30px 70px rgba(0,0,0,0.4); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -80px; right: -60px; width: 260px; height: 260px; border-radius: 50%; background: radial-gradient(circle, rgba(217,164,65,0.3), transparent 70%); animation: hxGlow 5s ease-in-out infinite;"></div>
        <div style="position: absolute; bottom: -80px; left: -40px; width: 200px; height: 200px; border-radius: 50%; background: radial-gradient(circle, rgba(110,231,183,0.25), transparent 70%); animation: hxGlow 6s ease-in-out infinite; animation-delay: 2s;"></div>
        <div style="position: relative; z-index: 1;">
            <span class="featured-badge-3d" style="margin: 0 auto 20px;">
                <?= renderIcon('sparkle', 16, 'currentColor') ?>
                <span>JEJAK KAMI</span>
            </span>
            <div class="impact-num-3d"><?= number_format($totalKarya + $statBerita + $statDokumen) ?>+</div>
            <p style="font-size: 18px; opacity: 0.9; max-width: 600px; margin: 16px auto 0; line-height: 1.7;">Karya ilmiah, pengabdian, HAKI, kegiatan AIK, berita, dan dokumen yang telah kami dokumentasikan.</p>
            <div style="margin-top: 34px; display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                <a href="<?= e(url('public/index.php?page=publikasi')) ?>" class="cta-3d cta-3d-primary">
                    <?= renderIcon('book-open', 20, 'currentColor') ?>
                    <span>Jelajahi Publikasi</span>
                </a>
                <a href="<?= e(url('public/index.php?page=pengabdian')) ?>" class="cta-3d cta-3d-ghost">
                    <?= renderIcon('handshake', 20, 'currentColor') ?>
                    <span>Lihat Pengabdian</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- CTA BAND -->
<section class="cta-band reveal">
    <div>
        <h3>Jelajahi layanan & karya civitas akademika</h3>
        <p>Unduh dokumen resmi, telusuri program pengabdian, dan ikuti kegiatan AIK terbaru.</p>
    </div>
    <div class="cta-actions">
        <a href="<?= e(url('public/index.php?page=unduhan')) ?>" class="cta-3d cta-3d-primary">
            <?= renderIcon('folder-open', 20, 'currentColor') ?>
            <span>Dokumen & Unduhan</span>
        </a>
        <a href="<?= e(url('public/index.php?page=pengabdian')) ?>" class="cta-3d cta-3d-ghost">
            <?= renderIcon('handshake', 20, 'currentColor') ?>
            <span>Pengabdian & KKN</span>
        </a>
    </div>
</section>

<script>
(function () {
    var hero = document.getElementById('hxHero');
    if (!hero) return;
    var slides = Array.prototype.slice.call(hero.querySelectorAll('.hx-slide'));
    var dotsWrap = document.getElementById('hxDots');
    var nowEl = document.getElementById('hxNow');
    var bar = document.getElementById('hxBar');
    var idx = 0, timer = null;
    var DELAY = 6500;

    slides.forEach(function (_, i) {
        var d = document.createElement('button');
        d.className = 'hx-dot' + (i === 0 ? ' active' : '');
        d.setAttribute('aria-label', 'Slide ' + (i + 1));
        d.addEventListener('click', function () { go(i); restart(); });
        dotsWrap.appendChild(d);
    });
    var dots = Array.prototype.slice.call(dotsWrap.children);

    function pad(n) { return (n < 10 ? '0' : '') + n; }

    function go(i) {
        idx = (i + slides.length) % slides.length;
        slides.forEach(function (s, k) { s.classList.toggle('active', k === idx); });
        dots.forEach(function (d, k) { d.classList.toggle('active', k === idx); });
        if (nowEl) nowEl.textContent = pad(idx + 1);
        if (bar) { bar.classList.remove('run'); void bar.offsetWidth; bar.classList.add('run'); }
    }
    function next() { go(idx + 1); }
    function restart() { clearInterval(timer); timer = setInterval(next, DELAY); }

    document.getElementById('hxNext').addEventListener('click', function () { next(); restart(); });
    document.getElementById('hxPrev').addEventListener('click', function () { go(idx - 1); restart(); });

    hero.addEventListener('mouseenter', function () { clearInterval(timer); });
    hero.addEventListener('mouseleave', restart);

    // Swipe mobile
    var sx = 0;
    hero.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
    hero.addEventListener('touchend', function (e) {
        var dx = e.changedTouches[0].clientX - sx;
        if (Math.abs(dx) > 45) { dx < 0 ? next() : go(idx - 1); restart(); }
    }, { passive: true });

    go(0); restart();
})();
</script>