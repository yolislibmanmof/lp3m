<?php
// SVG Icon Helper
function renderAgendaIcon($name, $size = 24, $color = 'currentColor') {
    $icons = [
        'calendar' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
        'clock' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
        'timer' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="13" r="8"></circle><path d="M12 9v4l2 2"></path><path d="M5 3 2 6"></path><path d="m22 3-3 3"></path><path d="M10 2h4"></path></svg>',
        'clipboard-list' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect><line x1="8" y1="10" x2="16" y2="10"></line><line x1="8" y1="14" x2="16" y2="14"></line><line x1="8" y1="18" x2="12" y2="18"></line></svg>',
        'inbox' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>',
        'map-pin' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>',
        'building' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>',
        'edit' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
        'target' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>',
        'bell' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>',
        'folder' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>',
        'info' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>',
        'users' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'sparkle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 3l1.912 5.813a2 2 0 0 0 1.275 1.275L21 12l-5.813 1.912a2 2 0 0 0-1.275 1.275L12 21l-1.912-5.813a2 2 0 0 0-1.275-1.275L3 12l5.813-1.912a2 2 0 0 0 1.275-1.275L12 3z"></path></svg>',
        'chevron-left' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>',
        'chevron-right' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>',
        'arrow-right' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
        'external-link' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>',
        'filter' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>',
        'zap' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>',
        'activity' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>',
        'award' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>',
        'search' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        'check' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>',
        'hash' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="4" y1="9" x2="20" y2="9"></line><line x1="4" y1="15" x2="20" y2="15"></line><line x1="10" y1="3" x2="8" y2="21"></line><line x1="16" y1="3" x2="14" y2="21"></line></svg>',
    ];
    return $icons[$name] ?? $icons['sparkle'];
}

$bulanId = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
[$mY, $mM] = array_map('intval', explode('-', $month));
$firstDow = (int) date('w', mktime(0, 0, 0, $mM, 1, $mY));
$daysIn   = (int) date('t', mktime(0, 0, 0, $mM, 1, $mY));
$todayJ = (int) date('j'); $todayM = (int) date('n'); $todayY = (int) date('Y');
$prevM = date('Y-m', mktime(0, 0, 0, $mM - 1, 1, $mY));
$nextM = date('Y-m', mktime(0, 0, 0, $mM + 1, 1, $mY));

$map = [];
foreach ($monthEvents as $ev) { $map[(int) date('j', strtotime($ev['start_date']))][] = $ev; }

$typeColor = [
    'penelitian' => ['5,150,105',   '#047857'],
    'pengabdian' => ['16,185,129',  '#065f46'],
    'pelatihan'  => ['245,158,11',  '#92400e'],
    'seminar'    => ['139,92,246',  '#5b21b6'],
    'workshop'   => ['6,182,212',   '#155e75'],
    'aik'        => ['217,164,65',  '#78350f'],
    'rapat'      => ['100,116,139', '#334155'],
    'lainnya'    => ['148,163,184', '#475569'],
];

$typeIcons = [
    'penelitian' => 'search',
    'pengabdian' => 'users',
    'pelatihan'  => 'award',
    'seminar'    => 'activity',
    'workshop'   => 'edit',
    'aik'        => 'sparkle',
    'rapat'      => 'clipboard-list',
    'lainnya'    => 'hash',
];

$typesAll = CalendarEvent::TYPES;
?>

<style>
    @keyframes agFade { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:none; } }
    @keyframes agShine { 0%,55% { left:-90%; } 100% { left:165%; } }
    @keyframes agPulse { 0%,100% { transform:scale(1); } 50% { transform:scale(1.08); } }
    @keyframes iconRotate {
        0%, 100% { transform: rotate(0deg) scale(1); }
        25% { transform: rotate(-5deg) scale(1.05); }
        75% { transform: rotate(5deg) scale(1.05); }
    }
    @keyframes orbPulse {
        0%, 100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.1); }
    }
    @keyframes countdownPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(5,150,105,0.4); }
        50% { box-shadow: 0 0 0 8px rgba(5,150,105,0); }
    }

    .ag-wrap { max-width: 1200px; margin: 0 auto; }

    /* ===== SVG BASE ===== */
    .ag-svg {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        vertical-align: middle;
    }
    .ag-svg svg {
        display: block;
        transition: all 0.3s ease;
    }

    /* ===== HERO ===== */
    .ag-hero { 
        position:relative; 
        padding:70px 24px 60px; 
        margin-bottom:40px; 
        border-radius:28px; 
        background:linear-gradient(135deg,#043b2c 0%,#065f46 45%,#059669 100%); 
        color:#fff; 
        overflow:hidden; 
        box-shadow:0 24px 60px rgba(3,37,31,.25);
    }
    .ag-hero::before { 
        content:''; 
        position:absolute; 
        top:-40%; 
        right:-10%; 
        width:480px; 
        height:480px; 
        border-radius:50%; 
        background:radial-gradient(circle,rgba(217,164,65,.35),transparent 70%); 
        pointer-events:none;
        animation: orbPulse 5s ease-in-out infinite;
    }
    .ag-hero::after { 
        content:''; 
        position:absolute; 
        bottom:-30%; 
        left:-5%; 
        width:380px; 
        height:380px; 
        border-radius:50%; 
        background:radial-gradient(circle,rgba(255,255,255,.1),transparent 70%); 
        pointer-events:none;
        animation: orbPulse 6s ease-in-out infinite;
        animation-delay: 2s;
    }
    .ag-hero-bg-icon {
        position: absolute;
        right: 40px;
        bottom: -30px;
        opacity: 0.08;
        pointer-events: none;
        animation: iconRotate 8s ease-in-out infinite;
    }
    .ag-hero-bg-icon svg {
        width: 220px;
        height: 220px;
        stroke: #fde68a;
        stroke-width: 1;
    }
    .ag-hero-inner { position:relative; z-index:2; max-width:1200px; margin:0 auto; }
    .ag-eyebrow { 
        display:inline-flex; 
        align-items: center;
        gap: 10px;
        padding:6px 16px; 
        border-radius:999px; 
        font-size:11px; 
        font-weight:900; 
        letter-spacing:.18em; 
        text-transform:uppercase; 
        background:rgba(217,164,65,.25); 
        border:1px solid rgba(217,164,65,.5); 
        color:#fde68a; 
        margin-bottom:20px;
        backdrop-filter: blur(8px);
    }
    .ag-eyebrow svg {
        width: 14px;
        height: 14px;
        stroke: #fde68a;
        stroke-width: 2.5;
    }
    .ag-hero h1 { 
        font-family:var(--font-display); 
        font-size:clamp(28px, 5vw, 44px); 
        font-weight:900; 
        letter-spacing:-.02em; 
        margin:0 0 14px; 
        background:linear-gradient(135deg,#fff,#fde68a 60%,#f2c063); 
        -webkit-background-clip:text; 
        background-clip:text; 
        -webkit-text-fill-color:transparent;
        filter: drop-shadow(0 2px 8px rgba(0,0,0,0.2));
    }
    .ag-hero p { 
        font-size:15px; 
        line-height:1.7; 
        opacity:.92; 
        max-width:680px; 
        margin:0 0 26px; 
    }
    .ag-stats { display:flex; gap:12px; flex-wrap:wrap; }
    .ag-stat { 
        background:rgba(255,255,255,.12); 
        border:1px solid rgba(255,255,255,.2); 
        border-radius:14px; 
        padding:12px 20px; 
        backdrop-filter:blur(8px); 
        display:inline-flex; 
        align-items:center; 
        gap:10px; 
        font-size:13.5px; 
        font-weight:700;
        transition: all 0.3s ease;
    }
    .ag-stat:hover {
        background: rgba(255,255,255,.18);
        transform: translateY(-2px);
    }
    .ag-stat svg {
        width: 18px;
        height: 18px;
        stroke: #fde68a;
        stroke-width: 2.2;
        filter: drop-shadow(0 2px 4px rgba(217,164,65,0.3));
    }
    .ag-stat b { 
        font-family:var(--font-display); 
        font-size:18px; 
        font-weight:900; 
        color:#fde68a;
        filter: drop-shadow(0 2px 4px rgba(217,164,65,0.3));
    }

    /* ===== SECTIONS ===== */
    .ag-section { max-width:1200px; margin:0 auto 50px; padding:0 24px; }
    .ag-head { 
        display:flex; 
        align-items:flex-end; 
        justify-content:space-between; 
        gap:16px; 
        flex-wrap:wrap; 
        margin-bottom:22px; 
    }
    .ag-head h2 { 
        font-family:var(--font-display); 
        font-size:24px; 
        font-weight:900; 
        color:var(--ink); 
        margin:0; 
        letter-spacing:-.02em; 
        display:flex; 
        align-items:center; 
        gap:12px;
    }
    .ag-head h2 .ag-head-ico { 
        width:42px; 
        height:42px; 
        border-radius:13px; 
        display:inline-flex; 
        align-items:center; 
        justify-content:center; 
        background:linear-gradient(145deg,#d1fae5,#a7f3d0); 
        box-shadow:0 6px 14px rgba(16,185,129,.25);
        transition: all 0.3s ease;
    }
    .ag-head h2:hover .ag-head-ico {
        transform: scale(1.1) rotate(-5deg);
    }
    .ag-head h2 .ag-head-ico svg {
        width: 22px;
        height: 22px;
        stroke: #065f46;
        stroke-width: 2.2;
        filter: drop-shadow(0 1px 2px rgba(0,0,0,0.15));
    }
    .ag-head .ag-sub { 
        font-size:12.5px; 
        color:var(--muted); 
        margin-top:4px; 
    }
    .ag-chip { 
        display:inline-flex; 
        align-items:center; 
        gap:8px; 
        padding:6px 16px; 
        border-radius:999px; 
        font-size:12px; 
        font-weight:800; 
        background:rgba(5,150,105,.1); 
        color:#065f46; 
        border:1px solid rgba(5,150,105,.3);
        transition: all 0.25s;
    }
    .ag-chip svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2.2;
    }
    .ag-chip:hover {
        background: rgba(5,150,105,.15);
        transform: translateY(-2px);
    }

    /* ===== NAV ===== */
    .ag-nav { display:inline-flex; align-items:center; gap:8px; }
    .ag-nav-btn { 
        width:40px; 
        height:40px; 
        border-radius:12px; 
        border:1px solid var(--border); 
        background:var(--surface); 
        color:var(--ink); 
        text-decoration:none; 
        display:inline-flex; 
        align-items:center; 
        justify-content:center; 
        transition:all .25s;
    }
    .ag-nav-btn svg {
        width: 18px;
        height: 18px;
        stroke: currentColor;
        stroke-width: 2.5;
    }
    .ag-nav-btn:hover { 
        border-color:#059669; 
        color:#059669; 
        transform:translateY(-2px); 
        box-shadow:0 6px 14px rgba(5,150,105,.15);
    }
    .ag-nav-btn:hover svg {
        animation: iconRotate 0.5s ease;
    }
    .ag-nav-label { 
        font-family:var(--font-display); 
        font-size:14.5px; 
        font-weight:800; 
        color:var(--ink); 
        min-width:170px; 
        text-align:center; 
        padding:0 8px;
    }
    .ag-nav-today { 
        padding:10px 16px; 
        border-radius:11px; 
        font-size:12px; 
        font-weight:800; 
        color:#059669; 
        background:rgba(5,150,105,.08); 
        border:1px solid rgba(5,150,105,.25); 
        text-decoration:none; 
        transition:all .25s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .ag-nav-today svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2.5;
    }
    .ag-nav-today:hover { 
        background:rgba(5,150,105,.15);
        transform: translateY(-2px);
    }

    /* ===== UPCOMING LIST ===== */
    .ag-upcoming { display:flex; flex-direction:column; gap:16px; }
    .ag-up-card { 
        position:relative; 
        display:flex; 
        gap:20px; 
        padding:24px 26px; 
        border-radius:22px; 
        background:linear-gradient(145deg,#fff,#f6fcf7); 
        border:1px solid var(--border); 
        box-shadow:0 8px 22px rgba(3,37,31,.06); 
        transition:all .35s cubic-bezier(0.16,1,0.3,1); 
        overflow:hidden;
    }
    .ag-up-card:hover { 
        transform:translateY(-4px); 
        box-shadow:0 20px 44px rgba(3,37,31,.12);
        border-color: rgba(5,150,105,0.3);
    }
    .ag-up-card::before { 
        content:''; 
        position:absolute; 
        left:0; 
        top:0; 
        bottom:0; 
        width:5px; 
    }
    .ag-up-card.upcoming::before { background:linear-gradient(180deg,#10b981,#047857); }
    .ag-up-card.soon::before { background:linear-gradient(180deg,#f59e0b,#b45309); }
    .ag-up-card.today::before { background:linear-gradient(180deg,#dc2626,#7f1d1d); }

    .ag-up-date { 
        flex-shrink:0; 
        width:86px; 
        padding:14px 8px; 
        border-radius:17px; 
        text-align:center; 
        background:linear-gradient(145deg,#ecfdf5,#d1fae5); 
        border:1px solid rgba(16,185,129,.25);
        transition: all 0.3s ease;
    }
    .ag-up-card:hover .ag-up-date {
        transform: scale(1.05) rotate(-3deg);
    }
    .ag-up-date b { 
        display:block; 
        font-family:var(--font-display); 
        font-size:30px; 
        font-weight:900; 
        color:#065f46; 
        line-height:1;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }
    .ag-up-date span { 
        display:block; 
        font-size:10px; 
        font-weight:800; 
        letter-spacing:.14em; 
        text-transform:uppercase; 
        color:#059669; 
        margin-top:4px; 
    }
    .ag-up-card.today .ag-up-date { background:linear-gradient(145deg,#fee2e2,#fecaca); border-color:rgba(220,38,38,.25); }
    .ag-up-card.today .ag-up-date b { color:#991b1b; }
    .ag-up-card.today .ag-up-date span { color:#dc2626; }
    .ag-up-card.soon .ag-up-date { background:linear-gradient(145deg,#fef3c7,#fde68a); border-color:rgba(245,158,11,.3); }
    .ag-up-card.soon .ag-up-date b { color:#92400e; }
    .ag-up-card.soon .ag-up-date span { color:#b45309; }

    .ag-up-body { flex:1; min-width:0; }
    .ag-up-title { 
        font-size:17px; 
        font-weight:800; 
        color:var(--ink); 
        margin:0 0 10px; 
        letter-spacing:-.01em; 
    }
    .ag-up-meta { 
        display:flex; 
        gap:14px; 
        flex-wrap:wrap; 
        font-size:12.5px; 
        color:var(--muted); 
        margin-bottom:12px;
        align-items: center;
    }
    .ag-up-meta span { 
        display:inline-flex; 
        align-items:center; 
        gap:6px; 
    }
    .ag-up-meta svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2;
        opacity: 0.7;
    }
    .ag-up-countdown { 
        display:flex; 
        gap:10px; 
        flex-wrap:wrap; 
        margin-bottom:14px; 
    }
    .ag-up-cd { 
        background:rgba(5,150,105,.08); 
        border:1px solid rgba(5,150,105,.2); 
        border-radius:11px; 
        padding:8px 12px; 
        text-align:center; 
        min-width:58px;
        transition: all 0.3s ease;
    }
    .ag-up-card.today .ag-up-cd { animation: countdownPulse 2s ease-in-out infinite; }
    .ag-up-cd b { 
        display:block; 
        font-family:var(--font-display); 
        font-size:18px; 
        font-weight:900; 
        color:#059669; 
        line-height:1; 
    }
    .ag-up-cd span { 
        font-size:9px; 
        font-weight:800; 
        letter-spacing:.12em; 
        text-transform:uppercase; 
        color:var(--muted); 
        margin-top:3px; 
        display:block; 
    }
    .ag-up-card.today .ag-up-cd { background:rgba(220,38,38,.08); border-color:rgba(220,38,38,.2); }
    .ag-up-card.today .ag-up-cd b { color:#dc2626; }
    .ag-up-card.soon .ag-up-cd { background:rgba(245,158,11,.08); border-color:rgba(245,158,11,.25); }
    .ag-up-card.soon .ag-up-cd b { color:#b45309; }

    .ag-up-cta { 
        display:inline-flex; 
        align-items:center; 
        gap:8px; 
        padding:11px 22px; 
        border-radius:12px; 
        font-size:13px; 
        font-weight:800; 
        color:#03251f; 
        background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); 
        box-shadow:inset 0 2px 3px rgba(255,255,255,.7), 0 5px 12px rgba(217,164,65,.35); 
        text-decoration:none; 
        transition:all .25s; 
        position:relative; 
        overflow:hidden;
    }
    .ag-up-cta svg {
        width: 16px;
        height: 16px;
        stroke: #03251f;
        stroke-width: 2.5;
        transition: all 0.3s ease;
    }
    .ag-up-cta::after { 
        content:''; 
        position:absolute; 
        top:0; 
        left:-100%; 
        width:60%; 
        height:100%; 
        background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); 
        animation:agShine 3s ease-in-out infinite; 
    }
    .ag-up-cta:hover { 
        transform:translateY(-2px); 
        filter:brightness(1.05);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.8), 0 10px 22px rgba(217,164,65,.45);
    }
    .ag-up-cta:hover svg {
        transform: translateX(4px);
    }

    .ag-up-right { 
        display:flex; 
        flex-direction:column; 
        align-items:flex-end; 
        gap:10px; 
        flex-shrink:0; 
    }
    .ag-up-tag { 
        display:inline-flex; 
        align-items:center; 
        gap:6px; 
        padding:5px 12px; 
        border-radius:9px; 
        font-size:10.5px; 
        font-weight:900; 
        letter-spacing:.08em; 
        text-transform:uppercase;
    }
    .ag-up-tag svg {
        width: 12px;
        height: 12px;
        stroke: currentColor;
        stroke-width: 2.5;
    }
    .ag-up-tag.upcoming { background:rgba(16,185,129,.12); color:#047857; border:1px solid rgba(16,185,129,.3); }
    .ag-up-tag.soon { background:rgba(245,158,11,.12); color:#92400e; border:1px solid rgba(245,158,11,.3); animation:agPulse 2s ease-in-out infinite; }
    .ag-up-tag.today { background:rgba(220,38,38,.12); color:#991b1b; border:1px solid rgba(220,38,38,.3); animation:agPulse 1.4s ease-in-out infinite; }

    .ag-card-tag { 
        display:inline-flex; 
        align-items: center;
        gap: 6px;
        padding:4px 12px; 
        border-radius:999px; 
        font-size:10.5px; 
        font-weight:900; 
        letter-spacing:.08em; 
        text-transform:uppercase;
    }
    .ag-card-tag svg {
        width: 12px;
        height: 12px;
        stroke: currentColor;
        stroke-width: 2.5;
    }

    /* ===== CALENDAR ===== */
    .ag-cal-wrap { 
        background:var(--surface); 
        border:1px solid var(--border); 
        border-radius:24px; 
        padding:22px; 
        box-shadow:0 10px 30px rgba(3,37,31,.06);
        position: relative;
        overflow: hidden;
    }
    .ag-cal-wrap::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #065f46, #10b981, #f2c063);
        border-radius: 24px 24px 0 0;
    }
    .ag-cal-dow { 
        display:grid; 
        grid-template-columns:repeat(7,1fr); 
        gap:8px; 
        margin-bottom:10px; 
    }
    .ag-cal-dow span { 
        text-align:center; 
        font-size:11px; 
        font-weight:900; 
        letter-spacing:.14em; 
        text-transform:uppercase; 
        color:var(--muted); 
        padding:8px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }
    .ag-cal-dow span.wk { 
        color:#dc2626;
    }
    .ag-cal-grid { 
        display:grid; 
        grid-template-columns:repeat(7,1fr); 
        gap:8px; 
    }
    .ag-cal-cell { 
        position:relative; 
        min-height:108px; 
        border-radius:13px; 
        background:rgba(5,150,105,.03); 
        border:1px solid rgba(5,150,105,.08); 
        padding:9px; 
        display:flex; 
        flex-direction:column; 
        gap:5px; 
        transition:all .25s;
    }
    .ag-cal-cell:hover { 
        border-color:rgba(217,164,65,.45); 
        background:rgba(217,164,65,.04); 
        transform:translateY(-2px);
        box-shadow: 0 8px 20px rgba(217,164,65,0.1);
    }
    .ag-cal-cell.wknd { 
        background:rgba(220,38,38,.02); 
        border-color:rgba(220,38,38,.08); 
    }
    .ag-cal-cell.blank { 
        background:transparent; 
        border-color:transparent; 
        pointer-events:none; 
    }
    .ag-cal-cell.today { 
        border-color:#059669; 
        background:rgba(5,150,105,.08); 
        box-shadow:0 0 0 2px rgba(5,150,105,.35), 0 8px 18px rgba(5,150,105,.18);
    }
    .ag-cal-num { 
        font-family:var(--font-display); 
        font-size:14px; 
        font-weight:900; 
        color:var(--ink); 
        width:28px; 
        height:28px; 
        display:flex; 
        align-items:center; 
        justify-content:center; 
        border-radius:9px; 
        flex-shrink:0;
    }
    .ag-cal-cell.wknd .ag-cal-num { color:rgba(220,38,38,.6); }
    .ag-cal-cell.today .ag-cal-num { 
        background:linear-gradient(145deg,#10b981,#059669); 
        color:#fff; 
        box-shadow:0 3px 8px rgba(5,150,105,.3);
    }
    .ag-cal-events { 
        display:flex; 
        flex-direction:column; 
        gap:4px; 
        overflow:hidden; 
    }
    .ag-cal-pill { 
        display:flex;
        align-items: center;
        gap: 5px;
        padding:5px 9px; 
        border-radius:8px; 
        font-size:10.5px; 
        font-weight:700; 
        line-height:1.35; 
        text-decoration:none; 
        border:1px solid; 
        white-space:nowrap; 
        overflow:hidden; 
        text-overflow:ellipsis; 
        transition:all .2s;
    }
    .ag-cal-pill svg {
        width: 11px;
        height: 11px;
        stroke: currentColor;
        stroke-width: 2.5;
        flex-shrink: 0;
    }
    .ag-cal-pill:hover { 
        filter:brightness(.95); 
        transform:translateX(2px);
    }
    .ag-cal-more { 
        font-size:10px; 
        font-weight:800; 
        color:var(--muted); 
        padding-left:4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .ag-cal-more svg {
        width: 12px;
        height: 12px;
    }

    .ag-legend { 
        display:flex; 
        gap:14px; 
        flex-wrap:wrap; 
        margin-top:16px; 
        padding-top:14px; 
        border-top:1px dashed var(--border);
    }
    .ag-leg { 
        display:inline-flex; 
        align-items:center; 
        gap:8px; 
        font-size:11px; 
        font-weight:700; 
        color:var(--muted);
        padding: 4px 10px;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .ag-leg:hover {
        background: rgba(5,150,105,0.05);
    }
    .ag-leg i { 
        width:12px; 
        height:12px; 
        border-radius:4px; 
        display:inline-block;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .ag-leg svg {
        width: 12px;
        height: 12px;
        stroke: currentColor;
        stroke-width: 2.2;
        opacity: 0.7;
    }

    /* ===== FILTER ===== */
    .ag-filter { 
        display:flex; 
        gap:8px; 
        flex-wrap:wrap; 
        margin-bottom:22px; 
        padding:14px; 
        background:var(--surface); 
        border:1px solid var(--border); 
        border-radius:16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }
    .ag-filter-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 800;
        color: var(--muted);
        padding: 8px 0;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }
    .ag-filter-label svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2.2;
    }
    .ag-filter-chip { 
        padding:8px 16px; 
        border-radius:999px; 
        font-size:12px; 
        font-weight:800; 
        color:var(--muted); 
        background:transparent; 
        border:1px solid var(--border); 
        cursor:pointer; 
        transition:all .25s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .ag-filter-chip svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2.2;
        transition: all 0.25s;
    }
    .ag-filter-chip:hover { 
        border-color:#059669; 
        color:#059669;
        transform: translateY(-2px);
    }
    .ag-filter-chip:hover svg {
        animation: iconRotate 0.5s ease;
    }
    .ag-filter-chip.active { 
        background:linear-gradient(145deg,#10b981,#059669); 
        color:#fff; 
        border-color:transparent; 
        box-shadow:0 4px 10px rgba(5,150,105,.3);
    }

    /* ===== MONTH CARDS ===== */
    .ag-month-grid { 
        display:grid; 
        grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); 
        gap:18px; 
    }
    .ag-card { 
        position:relative; 
        padding:24px; 
        border-radius:22px; 
        background:linear-gradient(160deg,#fff,#f6fcf7 60%,#e9f6ec); 
        border:1px solid var(--border); 
        box-shadow:0 8px 22px rgba(3,37,31,.06); 
        transition:all .35s cubic-bezier(0.16,1,0.3,1); 
        overflow:hidden;
    }
    .ag-card:hover { 
        transform:translateY(-6px); 
        box-shadow:0 20px 44px rgba(3,37,31,.14);
        border-color: rgba(5,150,105,0.3);
    }
    .ag-card::before { 
        content:''; 
        position:absolute; 
        top:0; 
        left:0; 
        right:0; 
        height:4px; 
    }
    .ag-card-top { 
        display:flex; 
        gap:16px; 
        align-items:flex-start; 
        margin-bottom:16px; 
    }
    .ag-card-day { 
        flex-shrink:0; 
        width:68px; 
        padding:12px 6px; 
        border-radius:15px; 
        text-align:center; 
        background:linear-gradient(145deg,#ecfdf5,#d1fae5); 
        border:1px solid rgba(16,185,129,.3);
        transition: all 0.3s ease;
    }
    .ag-card:hover .ag-card-day {
        transform: scale(1.05) rotate(-3deg);
    }
    .ag-card-day b { 
        display:block; 
        font-family:var(--font-display); 
        font-size:26px; 
        font-weight:900; 
        color:#065f46; 
        line-height:1;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }
    .ag-card-day span { 
        display:block; 
        font-size:9.5px; 
        font-weight:800; 
        letter-spacing:.14em; 
        text-transform:uppercase; 
        color:#059669; 
        margin-top:3px; 
    }
    .ag-card-body h3 { 
        font-size:17px; 
        font-weight:800; 
        color:var(--ink); 
        margin:0 0 8px; 
        letter-spacing:-.01em; 
        line-height:1.35; 
    }
    .ag-card-desc { 
        font-size:13.5px; 
        color:var(--muted); 
        line-height:1.65; 
        margin:10px 0 16px; 
    }
    .ag-card-info { 
        display:flex; 
        flex-direction:column; 
        gap:7px; 
        margin-bottom:16px; 
        font-size:12.5px; 
        color:var(--muted); 
    }
    .ag-card-info span { 
        display:inline-flex; 
        align-items:center; 
        gap:7px; 
    }
    .ag-card-info svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2;
        opacity: 0.7;
    }
    .ag-card-info b { 
        color:var(--ink); 
        font-weight:700; 
    }
    .ag-card-actions { 
        display:flex; 
        gap:8px; 
        flex-wrap:wrap; 
    }
    .ag-card-btn { 
        padding:10px 18px; 
        border-radius:11px; 
        font-size:12.5px; 
        font-weight:800; 
        text-decoration:none; 
        transition:all .25s; 
        display:inline-flex; 
        align-items:center; 
        gap:7px;
    }
    .ag-card-btn svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2.2;
        transition: all 0.3s ease;
    }
    .ag-card-btn-primary { 
        color:#03251f; 
        background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); 
        box-shadow:0 4px 10px rgba(217,164,65,.3);
        position: relative;
        overflow: hidden;
    }
    .ag-card-btn-primary::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,0.5), transparent);
        animation: agShine 3s ease-in-out infinite;
    }
    .ag-card-btn-primary:hover { 
        transform:translateY(-2px); 
        filter:brightness(1.05);
        box-shadow: 0 8px 18px rgba(217,164,65,.4);
    }
    .ag-card-btn-primary:hover svg {
        transform: translateX(3px);
    }
    .ag-card-btn-ghost { 
        color:#059669; 
        background:rgba(5,150,105,.08); 
        border:1px solid rgba(5,150,105,.25); 
    }
    .ag-card-btn-ghost:hover { 
        background:rgba(5,150,105,.15);
        transform: translateY(-2px);
    }

    /* ===== EMPTY STATE ===== */
    .ag-empty { 
        text-align:center; 
        padding:70px 24px; 
        border-radius:22px; 
        background:linear-gradient(145deg,rgba(5,150,105,.04),rgba(5,150,105,.01)); 
        border:1px dashed rgba(5,150,105,.25);
    }
    .ag-empty-ico { 
        width: 80px;
        height: 80px;
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: linear-gradient(145deg, #e9f7ec, #d5ecdd);
        border: 2px dashed rgba(5,150,105,0.3);
        opacity: 0.7;
    }
    .ag-empty-ico svg {
        width: 40px;
        height: 40px;
        stroke: var(--muted);
        stroke-width: 1.5;
    }
    .ag-empty h3 { 
        font-family:var(--font-display); 
        font-size:18px; 
        font-weight:900; 
        color:var(--ink); 
        margin:0 0 8px; 
    }
    .ag-empty p { 
        font-size:14px; 
        color:var(--muted); 
        margin:0; 
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width:768px){
        .ag-up-card { 
            flex-direction:column; 
            align-items:stretch; 
        }
        .ag-up-right { 
            flex-direction:row; 
            align-items:center; 
            justify-content:flex-start; 
        }
        .ag-cal-cell { min-height:74px; }
        .ag-cal-pill { font-size:9px; padding:3px 6px; }
        .ag-cal-pill svg { display: none; }
        .ag-card-day { width:58px; }
        .ag-hero-bg-icon { display: none; }
    }

    @media (max-width: 480px) {
        .ag-cal-cell { min-height: 60px; padding: 5px; }
        .ag-cal-num { width: 22px; height: 22px; font-size: 11px; }
        .ag-cal-pill { font-size: 8px; padding: 2px 4px; }
        .ag-cal-dow span { font-size: 9px; letter-spacing: 0.1em; }
    }
</style>

<div class="ag-wrap">

    <!-- ===== HERO ===== -->
    <section class="ag-hero">
        <div class="ag-hero-bg-icon">
            <?= renderAgendaIcon('calendar', 220, '#fde68a') ?>
        </div>
        <div class="ag-hero-inner">
            <span class="ag-eyebrow">
                <?= renderAgendaIcon('sparkle', 14, '#fde68a') ?>
                <span>LP3M UNIMOF · Agenda Resmi</span>
            </span>
            <h1>Agenda Kegiatan Lembaga</h1>
            <p>Jadwal lengkap penelitian, pengabdian, pelatihan, seminar, workshop, dan kegiatan AIK LP3M / LPPAIK UNIMOF — diperbarui real-time.</p>
            <div class="ag-stats">
                <span class="ag-stat">
                    <?= renderAgendaIcon('timer', 18, '#fde68a') ?>
                    <b><?= count($upcoming) ?></b>
                    <span>Mendatang</span>
                </span>
                <span class="ag-stat">
                    <?= renderAgendaIcon('calendar', 18, '#fde68a') ?>
                    <b><?= count($monthEvents) ?></b>
                    <span>Bulan Ini</span>
                </span>
                <span class="ag-stat">
                    <?= renderAgendaIcon('activity', 18, '#fde68a') ?>
                    <span><?= $bulanId[$mM - 1] ?> <?= $mY ?></span>
                </span>
            </div>
        </div>
    </section>

    <!-- ===== KEGIATAN MENDATANG ===== -->
    <section class="ag-section reveal">
        <div class="ag-head">
            <div>
                <h2>
                    <span class="ag-head-ico"><?= renderAgendaIcon('timer', 22, '#065f46') ?></span>
                    <span>Kegiatan Mendatang</span>
                </h2>
                <div class="ag-sub">Agenda yang akan segera dilaksanakan</div>
            </div>
            <span class="ag-chip">
                <?= renderAgendaIcon('bell', 14, 'currentColor') ?>
                <span><?= count($upcoming) ?> acara</span>
            </span>
        </div>

        <?php if (empty($upcoming)): ?>
        <div class="ag-empty">
            <div class="ag-empty-ico">
                <?= renderAgendaIcon('inbox', 40, 'currentColor') ?>
            </div>
            <h3>Belum Ada Agenda Mendatang</h3>
            <p>Kegiatan baru akan segera dijadwalkan. Pantau terus halaman ini!</p>
        </div>
        <?php else: ?>
        <div class="ag-upcoming">
            <?php foreach ($upcoming as $u):
                $ts = strtotime($u['start_date'] . ' ' . ($u['start_time'] ?: '08:00'));
                $diff = max(0, $ts - time());
                $days = floor($diff / 86400); $hrs = floor(($diff % 86400) / 3600);
                $min = floor(($diff % 3600) / 60); $sec = $diff % 60;
                $state = $days === 0 ? 'today' : ($days <= 3 ? 'soon' : 'upcoming');
                $tag = $state === 'today' ? 'HARI INI' : ($state === 'soon' ? 'SEGERA' : 'MENDATANG');
                $tagIcon = $state === 'today' ? 'zap' : ($state === 'soon' ? 'bell' : 'clock');
                $typeKey = $u['event_type'] ?? 'lainnya';
                [$rgb, $dark] = $typeColor[$typeKey] ?? $typeColor['lainnya'];
                $typeIcon = $typeIcons[$typeKey] ?? 'hash';
                $borderColor = 'style="border-left-color:rgb(' . $rgb . ');"';
            ?>
            <div class="ag-up-card <?= $state ?>" data-end="<?= $ts ?>" style="--c:<?= $rgb ?>">
                <div class="ag-up-date">
                    <b><?= date('d', strtotime($u['start_date'])) ?></b>
                    <span><?= substr($bulanId[(int) date('n', strtotime($u['start_date'])) - 1], 0, 3) ?></span>
                </div>
                <div class="ag-up-body">
                    <h3 class="ag-up-title"><?= e($u['title']) ?></h3>
                    <div class="ag-up-meta">
                        <span>
                            <?= renderAgendaIcon('calendar', 14, 'currentColor') ?>
                            <span><?= e(date('d M Y', strtotime($u['start_date']))) ?></span>
                        </span>
                        <?php if (!empty($u['start_time'])): ?>
                        <span>
                            <?= renderAgendaIcon('clock', 14, 'currentColor') ?>
                            <span><?= e(substr($u['start_time'], 0, 5)) ?> WITA</span>
                        </span>
                        <?php endif; ?>
                        <span>
                            <?= renderAgendaIcon('map-pin', 14, 'currentColor') ?>
                            <span><?= e($u['location'] ?: 'Akan Diumumkan') ?></span>
                        </span>
                        <span>
                            <?= renderAgendaIcon('building', 14, 'currentColor') ?>
                            <span><?= e($u['organizer'] ?: 'LP3M') ?></span>
                        </span>
                    </div>
                    <div class="ag-up-countdown">
                        <div class="ag-up-cd"><b data-d><?= $days ?></b><span>Hari</span></div>
                        <div class="ag-up-cd"><b data-h><?= $hrs ?></b><span>Jam</span></div>
                        <div class="ag-up-cd"><b data-m><?= $min ?></b><span>Menit</span></div>
                        <div class="ag-up-cd"><b data-s><?= $sec ?></b><span>Detik</span></div>
                    </div>
                    <?php if (!empty($u['registration_link'])): ?>
                    <a class="ag-up-cta" target="_blank" rel="noopener" href="<?= e($u['registration_link']) ?>">
                        <?= renderAgendaIcon('edit', 16, '#03251f') ?>
                        <span>Daftar Sekarang</span>
                        <?= renderAgendaIcon('arrow-right', 14, '#03251f') ?>
                    </a>
                    <?php endif; ?>
                </div>
                <div class="ag-up-right">
                    <span class="ag-up-tag <?= $state ?>">
                        <?= renderAgendaIcon($tagIcon, 12, 'currentColor') ?>
                        <span><?= $tag ?></span>
                    </span>
                    <span class="ag-card-tag" style="background:rgba(<?= $rgb ?>,.14); color:<?= $dark ?>; border:1px solid rgba(<?= $rgb ?>,.4);">
                        <?= renderAgendaIcon($typeIcon, 12, 'currentColor') ?>
                        <span><?= e(CalendarEvent::TYPES[$typeKey] ?? ucfirst($typeKey)) ?></span>
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </section>

    <!-- ===== CALENDAR ===== -->
    <section class="ag-section reveal">
        <div class="ag-head">
            <div>
                <h2>
                    <span class="ag-head-ico"><?= renderAgendaIcon('calendar', 22, '#065f46') ?></span>
                    <span>Kalender <?= $bulanId[$mM - 1] ?> <?= $mY ?></span>
                </h2>
                <div class="ag-sub">Tampilan kalender bulanan dengan indikator jenis kegiatan</div>
            </div>
            <div class="ag-nav">
                <a class="ag-nav-btn" href="?page=agenda&month=<?= e($prevM) ?>" title="Bulan sebelumnya">
                    <?= renderAgendaIcon('chevron-left', 18, 'currentColor') ?>
                </a>
                <span class="ag-nav-label"><?= $bulanId[$mM - 1] ?> <?= $mY ?></span>
                <a class="ag-nav-btn" href="?page=agenda&month=<?= e($nextM) ?>" title="Bulan berikutnya">
                    <?= renderAgendaIcon('chevron-right', 18, 'currentColor') ?>
                </a>
                <a class="ag-nav-today" href="?page=agenda&month=<?= e(date('Y-m')) ?>">
                    <?= renderAgendaIcon('target', 14, 'currentColor') ?>
                    <span>Hari Ini</span>
                </a>
            </div>
        </div>

        <div class="ag-cal-wrap">
            <div class="ag-cal-dow">
                <span class="wk">Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span class="wk">Sab</span>
            </div>
            <div class="ag-cal-grid">
                <?php for ($i = 0; $i < $firstDow; $i++): ?><div class="ag-cal-cell blank"></div><?php endfor; ?>
                <?php for ($d = 1; $d <= $daysIn; $d++):
                    $dow = (int) date('w', mktime(0, 0, 0, $mM, $d, $mY));
                    $isToday = ($mY === $todayY && $mM === $todayM && $d === $todayJ);
                    $evs = $map[$d] ?? [];
                ?>
                <div class="ag-cal-cell <?= $isToday ? 'today' : '' ?> <?= ($dow === 0 || $dow === 6) ? 'wknd' : '' ?>">
                    <span class="ag-cal-num"><?= $d ?></span>
                    <div class="ag-cal-events">
                        <?php foreach (array_slice($evs, 0, 3) as $ev):
                            $k = $ev['event_type'] ?? 'lainnya';
                            [$rgb, $dark] = $typeColor[$k] ?? $typeColor['lainnya'];
                            $evIcon = $typeIcons[$k] ?? 'hash';
                        ?>
                        <a class="ag-cal-pill" href="#ev-<?= (int) $ev['id'] ?>"
                           style="background:rgba(<?= $rgb ?>,.16); border-color:rgba(<?= $rgb ?>,.5); color:<?= $dark ?>;"
                           title="<?= e($ev['title']) ?><?= !empty($ev['start_time']) ? ' · ' . e(substr($ev['start_time'], 0, 5)) : '' ?>">
                            <?= renderAgendaIcon($evIcon, 11, 'currentColor') ?>
                            <span><?= !empty($ev['start_time']) ? e(substr($ev['start_time'], 0, 5)) . ' ' : '' ?><?= e($ev['title']) ?></span>
                        </a>
                        <?php endforeach; ?>
                        <?php if (count($evs) > 3): ?>
                            <span class="ag-cal-more">
                                <?= renderAgendaIcon('activity', 12, 'currentColor') ?>
                                <span>+<?= count($evs) - 3 ?> lagi</span>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endfor; ?>
                <?php $trail = (7 - (($firstDow + $daysIn) % 7)) % 7; for ($i = 0; $i < $trail; $i++): ?><div class="ag-cal-cell blank"></div><?php endfor; ?>
            </div>
            <div class="ag-legend">
                <?php foreach ($typeColor as $key => [$rgb, $dark]): ?>
                <span class="ag-leg">
                    <i style="background:rgb(<?= $rgb ?>);"></i>
                    <?= renderAgendaIcon($typeIcons[$key] ?? 'hash', 12, 'currentColor') ?>
                    <span><?= e(CalendarEvent::TYPES[$key] ?? ucfirst($key)) ?></span>
                </span>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ===== DAFTAR AGENDA BULAN INI ===== -->
    <section class="ag-section reveal">
        <div class="ag-head">
            <div>
                <h2>
                    <span class="ag-head-ico"><?= renderAgendaIcon('clipboard-list', 22, '#065f46') ?></span>
                    <span>Daftar Agenda Bulan Ini</span>
                </h2>
                <div class="ag-sub">Detail lengkap kegiatan pada <?= $bulanId[$mM - 1] ?> <?= $mY ?></div>
            </div>
            <span class="ag-chip">
                <?= renderAgendaIcon('folder', 14, 'currentColor') ?>
                <span><?= count($monthEvents) ?> kegiatan</span>
            </span>
        </div>

        <?php if (!empty($monthEvents)): ?>
        <!-- FILTER PILLS -->
        <div class="ag-filter" id="ag-filter">
            <span class="ag-filter-label">
                <?= renderAgendaIcon('filter', 14, 'currentColor') ?>
                <span>Filter:</span>
            </span>
            <button type="button" class="ag-filter-chip active" data-type="">
                <?= renderAgendaIcon('sparkle', 14, 'currentColor') ?>
                <span>Semua</span>
            </button>
            <?php foreach ($typesAll as $k => $l): ?>
            <button type="button" class="ag-filter-chip" data-type="<?= e($k) ?>">
                <?= renderAgendaIcon($typeIcons[$k] ?? 'hash', 14, 'currentColor') ?>
                <span><?= e($l) ?></span>
            </button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (empty($monthEvents)): ?>
        <div class="ag-empty">
            <div class="ag-empty-ico">
                <?= renderAgendaIcon('calendar', 40, 'currentColor') ?>
            </div>
            <h3>Tidak Ada Kegiatan Bulan Ini</h3>
            <p>Coba pindah ke bulan lain menggunakan tombol navigasi di atas.</p>
        </div>
        <?php else: ?>
        <div class="ag-month-grid" id="ag-grid">
            <?php foreach ($monthEvents as $ev):
                $k = $ev['event_type'] ?? 'lainnya';
                [$rgb, $dark] = $typeColor[$k] ?? $typeColor['lainnya'];
                $evIcon = $typeIcons[$k] ?? 'hash';
            ?>
            <div class="ag-card" id="ev-<?= (int) $ev['id'] ?>" data-type="<?= e($k) ?>"
                 style="--c:<?= $rgb ?>;">
                <div style="position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg, rgb(<?= $rgb ?>), rgb(<?= $rgb ?>,.5));"></div>
                <div class="ag-card-top">
                    <div class="ag-card-day">
                        <b><?= date('d', strtotime($ev['start_date'])) ?></b>
                        <span><?= substr($bulanId[(int) date('n', strtotime($ev['start_date'])) - 1], 0, 3) ?></span>
                    </div>
                    <div class="ag-card-body">
                        <span class="ag-card-tag" style="background:rgba(<?= $rgb ?>,.14); color:<?= $dark ?>; border:1px solid rgba(<?= $rgb ?>,.4); margin-bottom:8px;">
                            <?= renderAgendaIcon($evIcon, 12, 'currentColor') ?>
                            <span><?= e(CalendarEvent::TYPES[$k] ?? ucfirst($k)) ?></span>
                        </span>
                        <h3><?= e($ev['title']) ?></h3>
                    </div>
                </div>
                <?php if (!empty($ev['description'])): ?>
                <p class="ag-card-desc"><?= e(excerpt($ev['description'], 130)) ?></p>
                <?php endif; ?>
                <div class="ag-card-info">
                    <span>
                        <?= renderAgendaIcon('calendar', 14, 'currentColor') ?>
                        <b><?= e(date('d M Y', strtotime($ev['start_date']))) ?></b>
                        <?php if (!empty($ev['end_date']) && $ev['end_date'] !== $ev['start_date']): ?> 
                            <span>– <?= e(date('d M Y', strtotime($ev['end_date']))) ?></span>
                        <?php endif; ?>
                    </span>
                    <?php if (!empty($ev['start_time'])): ?>
                    <span>
                        <?= renderAgendaIcon('clock', 14, 'currentColor') ?>
                        <b><?= e(substr($ev['start_time'], 0, 5)) ?><?= !empty($ev['end_time']) ? ' – ' . e(substr($ev['end_time'], 0, 5)) : '' ?></b> 
                        <span>WITA</span>
                    </span>
                    <?php endif; ?>
                    <span>
                        <?= renderAgendaIcon('map-pin', 14, 'currentColor') ?>
                        <span><?= e($ev['location'] ?: 'Akan Diumumkan') ?></span>
                    </span>
                    <span>
                        <?= renderAgendaIcon('building', 14, 'currentColor') ?>
                        <span><?= e($ev['organizer'] ?: 'LP3M UNIMOF') ?></span>
                    </span>
                    <?php if ((int) ($ev['max_participants'] ?? 0) > 0): ?>
                    <span>
                        <?= renderAgendaIcon('users', 14, 'currentColor') ?>
                        <span>Kuota <b><?= (int) $ev['max_participants'] ?></b> peserta</span>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="ag-card-actions">
                    <?php if (!empty($ev['registration_link'])): ?>
                    <a class="ag-card-btn ag-card-btn-primary" target="_blank" rel="noopener" href="<?= e($ev['registration_link']) ?>">
                        <?= renderAgendaIcon('edit', 14, 'currentColor') ?>
                        <span>Daftar Sekarang</span>
                        <?= renderAgendaIcon('external-link', 12, 'currentColor') ?>
                    </a>
                    <?php endif; ?>
                    <a class="ag-card-btn ag-card-btn-ghost" href="?page=agenda&month=<?= e($month) ?>&event=<?= (int) $ev['id'] ?>#ev-<?= (int) $ev['id'] ?>">
                        <?= renderAgendaIcon('info', 14, 'currentColor') ?>
                        <span>Detail</span>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </section>

</div>

<script>
(function(){
    // Countdown real-time
    var cards = document.querySelectorAll('.ag-up-card');
    if (cards.length) {
        setInterval(function(){
            cards.forEach(function(c){
                var end = parseInt(c.dataset.end, 10) * 1000;
                var diff = Math.max(0, end - Date.now());
                var d = Math.floor(diff / 86400000);
                var h = Math.floor((diff % 86400000) / 3600000);
                var m = Math.floor((diff % 3600000) / 60000);
                var s = Math.floor((diff % 60000) / 1000);
                var de = c.querySelector('[data-d]'), he = c.querySelector('[data-h]');
                var me = c.querySelector('[data-m]'), se = c.querySelector('[data-s]');
                if (de) de.textContent = d;
                if (he) he.textContent = h;
                if (me) me.textContent = m;
                if (se) se.textContent = s;
            });
        }, 1000);
    }

    // Filter pills
    var chips = document.querySelectorAll('.ag-filter-chip');
    var items = document.querySelectorAll('#ag-grid .ag-card');
    chips.forEach(function(chip){
        chip.addEventListener('click', function(){
            chips.forEach(function(c){ c.classList.remove('active'); });
            chip.classList.add('active');
            var type = chip.dataset.type;
            items.forEach(function(it){
                it.style.display = (type === '' || it.dataset.type === type) ? '' : 'none';
            });
        });
    });

    // Smooth scroll ke card jika ada hash #ev-ID
    if (window.location.hash && window.location.hash.startsWith('#ev-')) {
        var target = document.querySelector(window.location.hash);
        if (target) setTimeout(function(){ 
            target.scrollIntoView({behavior:'smooth', block:'center'}); 
            target.animate([
                {boxShadow:'0 0 0 0 rgba(217,164,65,.5)'},
                {boxShadow:'0 0 0 12px rgba(217,164,65,0)'}
            ], {duration:1200}); 
        }, 300);
    }
})();
</script>