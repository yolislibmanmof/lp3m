<?php
// SVG Icon Helper
function renderDosenIcon($name, $size = 24, $color = 'currentColor') {
    $icons = [
        'user-check' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>',
        'shield' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
        'shield-check' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>',
        'star' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>',
        'crown' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="m2 4 3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14"></path></svg>',
        'clipboard' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>',
        'search' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        'sparkle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 3l1.912 5.813a2 2 0 0 0 1.275 1.275L21 12l-5.813 1.912a2 2 0 0 0-1.275 1.275L12 21l-1.912-5.813a2 2 0 0 0-1.275-1.275L3 12l5.813-1.912a2 2 0 0 0 1.275-1.275L12 3z"></path></svg>',
        'users' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'check-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>',
        'arrow-right' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
        'graduation-cap' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>',
        'book' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>',
        'microscope' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M9 3h6v2H9V3zm-3 4h12v2H6V7zm2 4h8v10H8V11z"></path><path d="M10 15h4"></path></svg>',
        'handshake' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'activity' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>',
        'award' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>',
    ];
    return $icons[$name] ?? $icons['sparkle'];
}

$roleLabels = [
    'dosen' => 'Dosen', 
    'admin_lp3m' => 'Admin LP3M', 
    'super_admin' => 'Super Admin',
    'pimpinan' => 'Pimpinan', 
    'reviewer' => 'Reviewer',
];
$roleIcons = [
    'dosen' => 'graduation-cap', 
    'admin_lp3m' => 'shield', 
    'super_admin' => 'star',
    'pimpinan' => 'crown', 
    'reviewer' => 'clipboard',
];
$roleColors = [
    'dosen' => '#059669', 
    'admin_lp3m' => '#6366f1', 
    'super_admin' => '#d97706',
    'pimpinan' => '#7c3aed', 
    'reviewer' => '#0891b2',
];
$activeRole = trim($_GET['role'] ?? '');
?>

<style>
    @keyframes drFade { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:none} }
    @keyframes drShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes drFloat { 0%,100%{transform:translateY(0) rotate(-4deg)} 50%{transform:translateY(-10px) rotate(4deg)} }
    @keyframes drPulse { 0%,100%{box-shadow:0 0 0 0 rgba(16,185,129,.5)} 50%{box-shadow:0 0 0 8px rgba(16,185,129,0)} }
    @keyframes drShineCard { 0%,55%{left:-120%} 100%{left:200%} }
    @keyframes drOrbPulse {
        0%, 100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.1); }
    }
    @keyframes iconRotate {
        0%, 100% { transform: rotate(0deg) scale(1); }
        25% { transform: rotate(-5deg) scale(1.05); }
        75% { transform: rotate(5deg) scale(1.05); }
    }

    .dr-wrap { max-width:1180px; margin:0 auto; padding:0 20px; }

    /* ===== SVG BASE ===== */
    .dr-svg {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        vertical-align: middle;
    }
    .dr-svg svg {
        display: block;
        transition: all 0.3s ease;
    }

    /* ===== HERO ===== */
    .dr-hero { 
        position:relative; 
        overflow:hidden; 
        padding:60px 50px; 
        border-radius:28px; 
        background:linear-gradient(135deg,#043b2c 0%,#065f46 45%,#10b981 100%); 
        color:#fff; 
        box-shadow:0 26px 60px rgba(3,37,31,.35); 
        margin-bottom:28px; 
        animation:drFade .6s both; 
    }
    .dr-hero::before { 
        content:''; 
        position:absolute; 
        inset:0; 
        opacity:.3; 
        background-image:repeating-linear-gradient(45deg,transparent,transparent 30px,rgba(253,230,138,.06) 30px,rgba(253,230,138,.06) 31px); 
        pointer-events:none; 
    }
    .dr-hero-bg-icon {
        position:absolute;
        right:40px;
        bottom:-20px;
        opacity:.12;
        pointer-events:none;
        animation: drFloat 6s ease-in-out infinite;
    }
    .dr-hero-bg-icon svg {
        width: 160px;
        height: 160px;
        stroke: #fde68a;
        stroke-width: 1;
    }
    .dr-hero .tag { 
        display:inline-flex; 
        align-items:center; 
        gap:10px; 
        padding:8px 18px; 
        border-radius:999px; 
        font-size:11px; 
        font-weight:900; 
        letter-spacing:.18em; 
        text-transform:uppercase; 
        background:rgba(255,255,255,.15); 
        border:1px solid rgba(255,255,255,.3); 
        margin-bottom:18px; 
        position:relative; 
        z-index:1;
        backdrop-filter: blur(8px);
    }
    .dr-hero .tag .ticker-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #6ee7b7, #10b981);
        animation: drPulse 2s infinite;
        box-shadow: 0 0 10px rgba(110,231,183,0.6);
    }
    .dr-hero h1 { 
        font-family:var(--font-display); 
        font-size:clamp(30px,4.5vw,46px); 
        font-weight:900; 
        letter-spacing:-.02em; 
        margin:0 0 12px; 
        position:relative; 
        z-index:1; 
    }
    .dr-hero h1 em { 
        font-style:normal; 
        background:linear-gradient(135deg,#fde68a,#f2c063); 
        -webkit-background-clip:text; 
        background-clip:text; 
        -webkit-text-fill-color:transparent;
        filter: drop-shadow(0 2px 8px rgba(217,164,65,0.4));
    }
    .dr-hero p { 
        font-size:15px; 
        line-height:1.7; 
        opacity:.92; 
        max-width:620px; 
        margin:0 0 24px; 
        position:relative; 
        z-index:1; 
    }
    .dr-hero-stats { 
        display:flex; 
        gap:12px; 
        flex-wrap:wrap; 
        margin-bottom:24px; 
        position:relative; 
        z-index:1; 
    }
    .dr-hero-stat { 
        background:rgba(255,255,255,.12); 
        border:1px solid rgba(255,255,255,.22); 
        border-radius:16px; 
        padding:14px 20px; 
        text-align:center; 
        min-width:105px; 
        backdrop-filter:blur(8px);
        transition: all 0.3s ease;
    }
    .dr-hero-stat:hover {
        background: rgba(255,255,255,.18);
        transform: translateY(-2px);
    }
    .dr-hero-stat b { 
        display:block; 
        font-family:var(--font-display); 
        font-size:22px; 
        font-weight:900; 
        color:#fde68a; 
        line-height:1.1;
        filter: drop-shadow(0 2px 4px rgba(217,164,65,0.3));
    }
    .dr-hero-stat span { 
        font-size:10px; 
        letter-spacing:.12em; 
        text-transform:uppercase; 
        opacity:.85; 
        display:block; 
        margin-top:4px; 
    }

    /* ===== SEARCH ===== */
    .dr-search { 
        position:relative; 
        max-width:480px; 
        z-index:1; 
    }
    .dr-search input { 
        width:100%; 
        padding:15px 20px 15px 52px; 
        border-radius:14px; 
        border:2px solid rgba(255,255,255,.3); 
        background:rgba(255,255,255,.14); 
        backdrop-filter:blur(8px); 
        color:#fff; 
        font-size:14px; 
        font-weight:600; 
        transition:all .25s;
        outline: none;
    }
    .dr-search input::placeholder { color:rgba(255,255,255,.65); }
    .dr-search input:focus { 
        border-color:#fde68a; 
        background:rgba(255,255,255,.22); 
        box-shadow:0 0 0 4px rgba(253,230,138,.25); 
    }
    .dr-search .ico { 
        position:absolute; 
        left:18px; 
        top:50%; 
        transform:translateY(-50%);
        display: flex;
        align-items: center;
    }
    .dr-search .ico svg {
        width: 18px;
        height: 18px;
        stroke: rgba(255,255,255,0.7);
        stroke-width: 2.2;
    }

    /* ===== CHIPS ROLE ===== */
    .dr-chips { 
        display:flex; 
        flex-wrap:wrap; 
        gap:10px; 
        margin-bottom:26px; 
        animation:drFade .6s .06s both; 
    }
    .dr-chip { 
        padding:10px 20px; 
        border-radius:999px; 
        border:1px solid var(--border); 
        background:var(--surface); 
        font-size:13px; 
        font-weight:800; 
        color:var(--text); 
        text-decoration:none; 
        transition:all .25s; 
        display:inline-flex; 
        align-items:center; 
        gap:8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    }
    .dr-chip svg {
        width: 16px;
        height: 16px;
        stroke: currentColor;
        stroke-width: 2.2;
        transition: all 0.25s;
    }
    .dr-chip:hover { 
        transform:translateY(-2px); 
        border-color:rgba(5,150,105,.5); 
        color:#047857; 
        box-shadow:0 6px 14px rgba(5,150,105,.15); 
    }
    .dr-chip:hover svg {
        animation: iconRotate 0.5s ease;
    }
    .dr-chip.on { 
        color:#03251f; 
        background:linear-gradient(145deg,#fde68a,#d9a441); 
        border-color:transparent; 
        box-shadow:0 5px 14px rgba(217,164,65,.35); 
    }
    .dr-chip b { 
        padding:2px 8px; 
        border-radius:999px; 
        background:rgba(5,150,105,.12); 
        color:#047857; 
        font-size:10px; 
        font-weight:900; 
    }
    .dr-chip.on b { 
        background:rgba(3,37,31,.2); 
        color:#03251f; 
    }

    /* ===== GRID ===== */
    .dr-grid { 
        display:grid; 
        grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); 
        gap:20px; 
        margin-bottom:32px; 
    }
    .dr-card { 
        position:relative; 
        overflow:hidden; 
        display:flex; 
        flex-direction:column; 
        gap:16px; 
        padding:26px 24px; 
        border-radius:22px; 
        background:var(--surface); 
        border:1px solid var(--border); 
        box-shadow:0 8px 22px rgba(3,37,31,.06); 
        text-decoration:none; 
        color:inherit; 
        transition:all .3s cubic-bezier(.16,1,.3,1); 
        opacity:0; 
        transform:translateY(18px); 
    }
    .dr-card.in { opacity:1; transform:none; }
    .dr-card::before { 
        content:''; 
        position:absolute; 
        top:0; 
        left:0; 
        right:0; 
        height:4px; 
        background:linear-gradient(90deg,#065f46,#10b981,#f2c063); 
        opacity:.85; 
    }
    .dr-card::after { 
        content:''; 
        position:absolute; 
        top:0; 
        left:-120%; 
        width:60%; 
        height:100%; 
        background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); 
        transform:skewX(-20deg); 
        pointer-events:none; 
    }
    .dr-card:hover { 
        transform:translateY(-6px); 
        border-color:rgba(5,150,105,.4); 
        box-shadow:0 18px 38px rgba(5,150,105,.16); 
    }
    .dr-card:hover::after { animation:drShineCard .9s ease-out; }
    .dr-card:hover .dr-av { transform:scale(1.08) rotate(-3deg); }

    /* ===== FEATURED CARD ===== */
    .dr-card.featured { 
        grid-column:1 / -1; 
        display:grid; 
        grid-template-columns:1.1fr 1fr; 
        gap:28px; 
        padding:34px; 
        background:linear-gradient(135deg,rgba(5,150,105,.06),rgba(253,230,138,.04)), var(--surface); 
        border-color:rgba(5,150,105,.35);
        box-shadow: 0 12px 32px rgba(5,150,105,.12);
    }
    .dr-card.featured::before { 
        height:5px; 
        background:linear-gradient(90deg,#fde68a,#10b981,#fde68a); 
    }
    .dr-card.featured::after { 
        content:''; 
        display:none;
    }
    .dr-featured-badge {
        position:absolute;
        top:16px;
        right:16px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding:5px 14px;
        border-radius:999px;
        background:linear-gradient(145deg,#fde68a,#d9a441);
        color:#03251f;
        font-size:10px;
        font-weight:900;
        letter-spacing:.1em;
        box-shadow:0 4px 10px rgba(217,164,65,.35);
        z-index:2;
        text-transform: uppercase;
    }
    .dr-featured-badge svg {
        width: 14px;
        height: 14px;
        stroke: #03251f;
        stroke-width: 2.5;
    }

    .dr-top { display:flex; gap:16px; align-items:center; }
    .dr-av { 
        position:relative; 
        width:68px; 
        height:68px; 
        border-radius:50%; 
        flex-shrink:0; 
        display:flex; 
        align-items:center; 
        justify-content:center; 
        font-family:var(--font-display); 
        font-size:22px; 
        font-weight:900; 
        color:#03251f; 
        background:radial-gradient(circle at 30% 25%,#fff7c2,#fde68a 20%,#f2c063 55%,#d9a441); 
        box-shadow:inset 0 2px 4px rgba(255,255,255,.65), inset 0 -3px 5px rgba(0,0,0,.2), 0 6px 16px rgba(217,164,65,.4); 
        transition:transform .3s; 
        overflow:hidden; 
    }
    .dr-card.featured .dr-av { width:96px; height:96px; font-size:30px; }
    .dr-av img { width:100%; height:100%; object-fit:cover; }
    .dr-verified { 
        position:absolute; 
        bottom:-2px; 
        right:-2px; 
        width:22px; 
        height:22px; 
        border-radius:50%; 
        background:linear-gradient(145deg,#10b981,#059669); 
        color:#fff; 
        display:flex; 
        align-items:center; 
        justify-content:center; 
        border:2px solid var(--surface); 
        box-shadow:0 2px 6px rgba(16,185,129,.4); 
        z-index:2; 
    }
    .dr-verified svg {
        width: 12px;
        height: 12px;
        stroke: #ffffff;
        stroke-width: 3;
    }
    .dr-name { 
        font-family:var(--font-display); 
        font-size:16px; 
        font-weight:900; 
        color:var(--ink); 
        line-height:1.3; 
        margin:0 0 6px; 
    }
    .dr-card.featured .dr-name { font-size:22px; }
    .dr-role { 
        display:inline-flex;
        align-items: center;
        gap: 6px;
        padding:4px 12px; 
        border-radius:999px; 
        font-size:10px; 
        font-weight:900; 
        letter-spacing:.08em; 
        text-transform:uppercase; 
        border:1px solid;
    }
    .dr-role svg {
        width: 12px;
        height: 12px;
        stroke: currentColor;
        stroke-width: 2.5;
    }
    .dr-inst { font-size:12px; color:var(--muted); margin-top:6px; }
    .dr-card.featured .dr-bio { 
        font-size:14px; 
        line-height:1.7; 
        color:var(--muted); 
        margin:12px 0; 
        display:-webkit-box; 
        -webkit-line-clamp:3; 
        -webkit-box-orient:vertical; 
        overflow:hidden; 
    }

    /* ===== STATS ===== */
    .dr-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:8px; }
    .dr-stat { 
        padding:10px 6px; 
        border-radius:12px; 
        background:rgba(5,150,105,.05); 
        border:1px solid var(--border); 
        text-align:center; 
        transition:all .25s;
        position: relative;
    }
    .dr-card:hover .dr-stat { 
        background:rgba(5,150,105,.1); 
        border-color: rgba(5,150,105,.2);
    }
    .dr-stat-icon {
        width: 24px;
        height: 24px;
        margin: 0 auto 4px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .dr-stat-icon svg {
        width: 16px;
        height: 16px;
        stroke: var(--primary);
        stroke-width: 2.2;
        opacity: 0.7;
    }
    .dr-stat b { 
        display:block; 
        font-family:var(--font-display); 
        font-size:16px; 
        font-weight:900; 
        color:var(--ink); 
        line-height:1; 
    }
    .dr-stat span { 
        display:block; 
        font-size:9px; 
        font-weight:800; 
        letter-spacing:.06em; 
        text-transform:uppercase; 
        color:var(--muted); 
        margin-top:4px; 
    }

    /* ===== CTA ===== */
    .dr-cta { 
        margin-top:auto; 
        display:inline-flex; 
        align-items:center; 
        justify-content:center; 
        gap:10px; 
        padding:13px; 
        border-radius:13px; 
        font-size:13px; 
        font-weight:800; 
        color:#03251f; 
        background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); 
        box-shadow:0 5px 14px rgba(217,164,65,.35); 
        position:relative; 
        overflow:hidden;
        transition: all 0.3s ease;
    }
    .dr-cta svg {
        width: 16px;
        height: 16px;
        stroke: #03251f;
        stroke-width: 2.5;
        transition: all 0.3s ease;
    }
    .dr-cta::after { 
        content:''; 
        position:absolute; 
        top:0; 
        left:-100%; 
        width:50%; 
        height:100%; 
        background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); 
        animation:drShine 3s ease-in-out infinite; 
    }
    .dr-cta:hover svg {
        transform: translateX(4px);
    }

    /* ===== EMPTY STATE ===== */
    .dr-empty { 
        text-align:center; 
        padding:70px 24px; 
        border-radius:22px; 
        background:var(--surface); 
        border:2px dashed var(--border); 
        color:var(--muted); 
        animation:drFade .6s both; 
    }
    .dr-empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: linear-gradient(145deg, #e9f7ec, #d5ecdd);
        border: 2px dashed var(--border);
    }
    .dr-empty-icon svg {
        width: 40px;
        height: 40px;
        stroke: var(--muted);
        stroke-width: 1.5;
        opacity: 0.6;
    }
    .dr-empty h3 { 
        margin:0 0 8px; 
        color:var(--ink);
        font-size: 18px;
    }
    .dr-empty p {
        margin: 0;
        font-size: 14px;
    }
    .dr-count { 
        text-align:center; 
        font-size:13px; 
        font-weight:800; 
        color:var(--muted); 
        margin-bottom:18px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .dr-count svg {
        width: 16px;
        height: 16px;
        stroke: currentColor;
        stroke-width: 2.2;
    }

    /* ===== RESPONSIVE ===== */
    @media(max-width:760px){ 
        .dr-card.featured { grid-template-columns:1fr; } 
        .dr-card.featured .dr-av { width:84px; height:84px; margin:0 auto; } 
        .dr-hero { padding: 40px 28px; }
        .dr-hero-bg-icon { display: none; }
        .dr-stats { grid-template-columns: repeat(2, 1fr); }
    }
</style>

<div class="dr-wrap">

    <!-- ===== HERO ===== -->
    <div class="dr-hero">
        <!-- Background decorative icon -->
        <div class="dr-hero-bg-icon">
            <?= renderDosenIcon('graduation-cap', 160, '#fde68a') ?>
        </div>

        <span class="tag">
            <span class="ticker-dot"></span>
            <?= renderDosenIcon('users', 14, '#ffffff') ?>
            <span>Sivitas Akademika</span>
        </span>
        <h1>Direktori Dosen & <em>Peneliti</em></h1>
        <p>Jelajahi profil akademik dosen LP3M — lengkap dengan rekam jejak penelitian, publikasi ilmiah, HAKI, dan pengabdian kepada masyarakat.</p>

        <?php
        $totalKarya = 0;
        foreach ($users as $uK) {
            $totalKarya += (int) ($uK['counts']['total'] ?? 0);
        }
        ?>
        <div class="dr-hero-stats">
            <div class="dr-hero-stat">
                <b><?= count($users) ?></b>
                <span>Dosen</span>
            </div>
            <div class="dr-hero-stat">
                <b><?= number_format($totalKarya) ?></b>
                <span>Total Karya</span>
            </div>
            <div class="dr-hero-stat">
                <b><?= count(array_unique(array_column($users, 'role'))) ?></b>
                <span>Peran Aktif</span>
            </div>
        </div>

        <form class="dr-search" method="get" action="<?= e(url('public/index.php')) ?>" id="drSearch">
            <input type="hidden" name="page" value="dosen">
            <?php if ($activeRole !== ''): ?><input type="hidden" name="role" value="<?= e($activeRole) ?>"><?php endif; ?>
            <span class="ico"><?= renderDosenIcon('search', 18, 'rgba(255,255,255,0.7)') ?></span>
            <input type="text" name="q" id="drQ" value="<?= e($q) ?>" placeholder="Cari nama dosen, NIDN, atau bidang keahlian...">
        </form>
    </div>

    <!-- ===== ROLE CHIPS ===== -->
    <div class="dr-chips">
        <a class="dr-chip <?= $activeRole === '' ? 'on' : '' ?>" href="<?= e(url('public/index.php?page=dosen&q=' . urlencode($q))) ?>">
            <?= renderDosenIcon('sparkle', 16, 'currentColor') ?>
            <span>Semua</span>
            <b><?= count($users) ?></b>
        </a>
        <?php foreach ($roleLabels as $k => $l):
            $count = count(array_filter($users, fn($u) => ($u['role'] ?? '') === $k));
            if ($count === 0) continue;
        ?>
        <a class="dr-chip <?= $activeRole === $k ? 'on' : '' ?>" href="<?= e(url('public/index.php?page=dosen&q=' . urlencode($q) . '&role=' . urlencode($k))) ?>">
            <?= renderDosenIcon($roleIcons[$k] ?? 'user-check', 16, 'currentColor') ?>
            <span><?= e($l) ?></span>
            <b><?= $count ?></b>
        </a>
        <?php endforeach; ?>
    </div>

    <div class="dr-count" id="drCount">
        <?= renderDosenIcon('activity', 16, 'currentColor') ?>
        <span><?= count($users) ?> dosen ditampilkan</span>
    </div>

    <?php if (empty($users)): ?>
    <!-- ===== EMPTY STATE ===== -->
    <div class="dr-empty">
        <div class="dr-empty-icon">
            <?= renderDosenIcon('users', 40, 'currentColor') ?>
        </div>
        <h3>Tidak Ada Dosen Ditemukan</h3>
        <p>Coba kata kunci lain, atau hubungi admin untuk menambahkan data dosen.</p>
    </div>
    <?php else: ?>
    <!-- ===== DOSEN GRID ===== -->
    <div class="dr-grid" id="drGrid">
        <?php foreach ($users as $i => $u):
            $init = DosenResolver::initials($u['name'] ?? '');
            $ct = $u['counts'] ?? ['r'=>0,'p'=>0,'h'=>0,'c'=>0];
            $isFeatured = $i === 0 && (($ct['r'] ?? 0) + ($ct['p'] ?? 0) + ($ct['h'] ?? 0) + ($ct['c'] ?? 0)) > 0;
            $roleColor = $roleColors[$u['role'] ?? ''] ?? '#059669';
            $roleIcon = $roleIcons[$u['role'] ?? ''] ?? 'user-check';
        ?>
        <a class="dr-card <?= $isFeatured ? 'featured' : '' ?>" style="animation-delay:<?= min($i * 0.04, 0.4) ?>s" href="<?= e(url('public/index.php?page=dosen&id=' . $u['id'])) ?>">
            <div>
                <?php if ($isFeatured): ?>
                    <span class="dr-featured-badge">
                        <?= renderDosenIcon('star', 14, '#03251f') ?>
                        <span>Dosen Unggulan</span>
                    </span>
                <?php endif; ?>
                
                <div class="dr-top">
                    <div class="dr-av">
                        <?php if (!empty($u['photo'])): ?>
                            <img src="<?= e(upload_url($u['photo'])) ?>" alt="<?= e($u['name']) ?>">
                        <?php else: ?>
                            <?= e($init) ?>
                        <?php endif; ?>
                        <?php if (($ct['total'] ?? 0) > 5): ?>
                            <span class="dr-verified" title="Terverifikasi">
                                <?= renderDosenIcon('check-circle', 12, '#ffffff') ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div style="min-width:0; flex:1;">
                        <div class="dr-name"><?= e($u['name']) ?></div>
                        <span class="dr-role" style="color:<?= $roleColor ?>; background:<?= $roleColor ?>14; border-color:<?= $roleColor ?>40;">
                            <?= renderDosenIcon($roleIcon, 12, $roleColor) ?>
                            <span><?= e($roleLabels[$u['role'] ?? ''] ?? 'Dosen') ?></span>
                        </span>
                        <?php if (!empty($u['nidn'])): ?>
                            <div class="dr-inst">NIDN: <?= e($u['nidn']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($isFeatured && !empty($u['bio'])): ?>
                <p class="dr-bio"><?= e($u['bio']) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <div class="dr-stats">
                    <div class="dr-stat">
                        <div class="dr-stat-icon"><?= renderDosenIcon('microscope', 16, 'currentColor') ?></div>
                        <b><?= (int) ($ct['r'] ?? 0) ?></b>
                        <span>Riset</span>
                    </div>
                    <div class="dr-stat">
                        <div class="dr-stat-icon"><?= renderDosenIcon('book', 16, 'currentColor') ?></div>
                        <b><?= (int) ($ct['p'] ?? 0) ?></b>
                        <span>Publikasi</span>
                    </div>
                    <div class="dr-stat">
                        <div class="dr-stat-icon"><?= renderDosenIcon('shield-check', 16, 'currentColor') ?></div>
                        <b><?= (int) ($ct['h'] ?? 0) ?></b>
                        <span>HAKI</span>
                    </div>
                    <div class="dr-stat">
                        <div class="dr-stat-icon"><?= renderDosenIcon('handshake', 16, 'currentColor') ?></div>
                        <b><?= (int) ($ct['c'] ?? 0) ?></b>
                        <span>Abdimas</span>
                    </div>
                </div>
                <span class="dr-cta">
                    <span>Lihat Profil Lengkap</span>
                    <?= renderDosenIcon('arrow-right', 16, '#03251f') ?>
                </span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>

<script>
(function(){
    /* Client-side search + filter */
    var q = document.getElementById('drQ');
    var countEl = document.getElementById('drCount');
    var cards = Array.prototype.slice.call(document.querySelectorAll('.dr-card'));

    if (q) q.addEventListener('input', function(){
        var val = this.value.toLowerCase();
        var n = 0;
        cards.forEach(function(c){
            var show = c.textContent.toLowerCase().indexOf(val) !== -1;
            c.style.display = show ? '' : 'none';
            if (show) n++;
        });
        if (countEl) countEl.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg> <span>' + n + ' dosen ditampilkan</span>';
    });

    /* Scroll reveal */
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(es){
            es.forEach(function(en){
                if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
            });
        }, { threshold: .12 });
        cards.forEach(function(c){ io.observe(c); });
    } else {
        cards.forEach(function(c){ c.classList.add('in'); });
    }
})();
</script>