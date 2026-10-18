<?php
// SVG Icon Helper
function renderDosenDetailIcon($name, $size = 24, $color = 'currentColor') {
    $icons = [
        'graduation-cap' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>',
        'bar-chart' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>',
        'target' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>',
        'book' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>',
        'link' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>',
        'calendar' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
        'dna' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M2 15c6.667-6 13.333 0 20-6"></path><path d="M9 22c1.798-1.998 2.518-3.995 2.807-5.993"></path><path d="M15 2c-1.798 1.998-2.518 3.995-2.807 5.993"></path><path d="m17 6-2.5-2.5"></path><path d="m14 8-1-1"></path><path d="m7 18 2.5 2.5"></path><path d="m3.5 14.5.5.5"></path><path d="m20 9 .5.5"></path><path d="m6.5 12.5 1 1"></path><path d="m16.5 10.5 1 1"></path><path d="m10 16 1.5 1.5"></path></svg>',
        'microscope' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M9 3h6v2H9V3zm-3 4h12v2H6V7zm2 4h8v10H8V11z"></path><path d="M10 15h4"></path></svg>',
        'trending-up' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>',
        'shield' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
        'handshake' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'dollar-sign' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>',
        'book-open' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>',
        'file-text' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>',
        'map-pin' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>',
        'inbox' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>',
        'download' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>',
        'check-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>',
        'clipboard' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>',
        'external-link' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>',
        'award' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>',
        'sparkle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 3l1.912 5.813a2 2 0 0 0 1.275 1.275L21 12l-5.813 1.912a2 2 0 0 0-1.275 1.275L12 21l-1.912-5.813a2 2 0 0 0-1.275-1.275L3 12l5.813-1.912a2 2 0 0 0 1.275-1.275L12 3z"></path></svg>',
        'copy' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>',
    ];
    return $icons[$name] ?? $icons['sparkle'];
}

$initials = DosenResolver::initials($user['name'] ?? '');
$slug = DosenResolver::slug($user['name'] ?? '');
$years = $stats['years'] ?? [];
$maxYear = !empty($years) ? max($years) : 1;
$roleLabel = [
    'dosen' => 'Dosen', 'admin_lp3m' => 'Admin LP3M', 'super_admin' => 'Super Admin',
    'pimpinan' => 'Pimpinan', 'reviewer' => 'Reviewer',
][$user['role'] ?? ''] ?? 'Dosen';
?>

<style>
    @keyframes dpFade { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:none} }
    @keyframes dpShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes dpPulse { 0%,100%{box-shadow:0 0 0 0 rgba(16,185,129,.4)} 50%{box-shadow:0 0 0 10px rgba(16,185,129,0)} }
    @keyframes iconRotate {
        0%, 100% { transform: rotate(0deg) scale(1); }
        25% { transform: rotate(-5deg) scale(1.05); }
        75% { transform: rotate(5deg) scale(1.05); }
    }
    @keyframes barGrow {
        from { height: 0; }
    }
    @keyframes orbPulse {
        0%, 100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.1); }
    }

    .dp-wrap { max-width:1100px; margin:0 auto; padding:0 20px; }

    /* ===== SVG BASE ===== */
    .dp-svg {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        vertical-align: middle;
    }
    .dp-svg svg {
        display: block;
        transition: all 0.3s ease;
    }

    /* ===== HERO ===== */
    .dp-hero { 
        position:relative; 
        overflow:hidden; 
        display:flex; 
        gap:28px; 
        align-items:center; 
        padding:40px 44px; 
        border-radius:28px; 
        background:linear-gradient(135deg,#065f46 0%,#059669 55%,#10b981 100%); 
        color:#fff; 
        box-shadow:0 24px 60px rgba(3,37,31,.35); 
        margin-bottom:28px; 
        animation:dpFade .6s both; 
    }
    .dp-hero::before { 
        content:''; 
        position:absolute; 
        inset:0; 
        opacity:.3; 
        background-image:repeating-linear-gradient(45deg,transparent,transparent 30px,rgba(253,230,138,.06) 30px,rgba(253,230,138,.06) 31px); 
        pointer-events:none; 
    }
    .dp-hero::after { 
        content:''; 
        position:absolute; 
        top:-50%; 
        right:-10%; 
        width:380px; 
        height:380px; 
        border-radius:50%; 
        background:radial-gradient(circle,rgba(253,230,138,.25),transparent 70%); 
        pointer-events:none;
        animation: orbPulse 5s ease-in-out infinite;
    }
    
    .dp-avatar { 
        position:relative; 
        width:120px; 
        height:120px; 
        border-radius:50%; 
        flex-shrink:0; 
        display:flex; 
        align-items:center; 
        justify-content:center; 
        font-family:var(--font-display); 
        font-size:40px; 
        font-weight:900; 
        color:#03251f; 
        background:radial-gradient(circle at 30% 25%,#fff7c2,#fde68a 20%,#f2c063 55%,#d9a441); 
        box-shadow:inset 0 3px 5px rgba(255,255,255,.7), inset 0 -4px 6px rgba(0,0,0,.22), 0 10px 26px rgba(217,164,65,.45); 
        z-index:1; 
        overflow:hidden;
        transition: all 0.3s ease;
    }
    .dp-avatar:hover {
        transform: scale(1.05) rotate(-3deg);
    }
    .dp-avatar::before { 
        content:''; 
        position:absolute; 
        top:14px; 
        left:22px; 
        width:32px; 
        height:12px; 
        border-radius:50%; 
        background:rgba(255,255,255,.65); 
        filter:blur(2px); 
        z-index:2; 
    }
    .dp-avatar img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
    
    .dp-hero-info { flex:1; min-width:0; position:relative; z-index:1; }
    .dp-hero-info .role { 
        display:inline-flex; 
        align-items:center; 
        gap:8px; 
        padding:5px 14px; 
        border-radius:999px; 
        font-size:11px; 
        font-weight:900; 
        letter-spacing:.12em; 
        text-transform:uppercase; 
        background:rgba(255,255,255,.16); 
        border:1px solid rgba(255,255,255,.32); 
        margin-bottom:12px;
        backdrop-filter: blur(8px);
    }
    .dp-hero-info .role svg {
        width: 14px;
        height: 14px;
        stroke: #ffffff;
        stroke-width: 2.5;
    }
    .dp-hero-info h1 { 
        font-family:var(--font-display); 
        font-size:clamp(26px,4.5vw,40px); 
        font-weight:900; 
        letter-spacing:-.02em; 
        margin:0 0 8px; 
        line-height:1.15;
        text-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .dp-hero-info .sub { 
        font-size:14px; 
        opacity:.9; 
        margin:0;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .dp-hero-info .sub svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2;
        opacity: 0.7;
    }
    
    .dp-hero-actions { display:flex; gap:12px; flex-wrap:wrap; position:relative; z-index:1; }
    .dp-btn { 
        position:relative; 
        overflow:hidden; 
        display:inline-flex; 
        align-items:center; 
        gap:10px; 
        padding:13px 24px; 
        border-radius:13px; 
        font-size:14px; 
        font-weight:800; 
        text-decoration:none; 
        transition:all .25s;
        border: none;
        cursor: pointer;
    }
    .dp-btn svg {
        width: 18px;
        height: 18px;
        stroke: currentColor;
        stroke-width: 2.2;
        transition: all 0.3s ease;
    }
    .dp-btn.gold { 
        color:#03251f; 
        background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); 
        box-shadow:inset 0 2px 3px rgba(255,255,255,.65), 0 8px 20px rgba(217,164,65,.4); 
    }
    .dp-btn.gold::after { 
        content:''; 
        position:absolute; 
        top:0; 
        left:-100%; 
        width:60%; 
        height:100%; 
        background:linear-gradient(105deg,transparent,rgba(255,255,255,.55),transparent); 
        animation:dpShine 3s ease-in-out infinite; 
    }
    .dp-btn.ghost { 
        color:#fff; 
        background:rgba(255,255,255,.14); 
        border:1px solid rgba(255,255,255,.3);
        backdrop-filter: blur(8px);
    }
    .dp-btn:hover { 
        transform:translateY(-2px); 
        filter:brightness(1.05);
    }
    .dp-btn:hover svg {
        animation: iconRotate 0.5s ease;
    }
    .dp-btn.gold:hover svg {
        transform: translateY(-2px);
    }

    /* ===== KPI GRID ===== */
    .dp-kpis { 
        display:grid; 
        grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); 
        gap:16px; 
        margin-bottom:28px; 
        animation:dpFade .6s .08s both; 
    }
    .dp-kpi { 
        position:relative; 
        overflow:hidden; 
        padding:22px; 
        border-radius:20px; 
        background:var(--surface); 
        border:1px solid var(--border); 
        box-shadow:0 8px 22px rgba(3,37,31,.06);
        transition: all 0.3s ease;
    }
    .dp-kpi:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(5,150,105,0.15);
        border-color: rgba(5,150,105,0.3);
    }
    .dp-kpi::after { 
        content:''; 
        position:absolute; 
        top:-40px; 
        right:-30px; 
        width:110px; 
        height:110px; 
        border-radius:50%; 
        background:radial-gradient(circle,rgba(var(--rgb),.16),transparent 70%); 
        pointer-events:none;
        animation: orbPulse 4s ease-in-out infinite;
    }
    .dp-kpi-ico { 
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        background: linear-gradient(145deg, rgba(var(--rgb), 0.15), rgba(var(--rgb), 0.08));
        border: 1px solid rgba(var(--rgb), 0.2);
        transition: all 0.3s ease;
    }
    .dp-kpi:hover .dp-kpi-ico {
        transform: scale(1.1) rotate(-5deg);
    }
    .dp-kpi-ico svg {
        width: 24px;
        height: 24px;
        stroke: rgb(var(--rgb));
        stroke-width: 2.2;
        filter: drop-shadow(0 2px 4px rgba(var(--rgb), 0.3));
    }
    .dp-kpi b { 
        display:block; 
        font-family:var(--font-display); 
        font-size:32px; 
        font-weight:900; 
        color:var(--ink); 
        line-height:1; 
        position:relative; 
        z-index:1;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }
    .dp-kpi span { 
        display:block; 
        font-size:11px; 
        font-weight:800; 
        letter-spacing:.12em; 
        text-transform:uppercase; 
        color:var(--muted); 
        margin-top:6px; 
    }

    /* ===== SECTIONS ===== */
    .dp-2col { 
        display:grid; 
        grid-template-columns:1.4fr 1fr; 
        gap:20px; 
        margin-bottom:24px; 
    }
    @media(max-width:900px){ 
        .dp-2col{grid-template-columns:1fr;} 
    }
    .dp-panel { 
        position:relative; 
        background:var(--surface); 
        border:1px solid var(--border); 
        border-radius:22px; 
        padding:26px; 
        animation:dpFade .6s .12s both;
        box-shadow: 0 6px 18px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }
    .dp-panel:hover {
        box-shadow: 0 10px 28px rgba(5,150,105,0.1);
    }
    .dp-panel::before { 
        content:''; 
        position:absolute; 
        top:0; 
        left:0; 
        right:0; 
        height:4px; 
        background:linear-gradient(90deg,#065f46,#10b981,#f2c063); 
        opacity:.85; 
        border-radius:22px 22px 0 0; 
    }
    .dp-panel h3 { 
        display:flex; 
        align-items:center; 
        gap:12px; 
        margin:0 0 18px; 
        font-family:var(--font-display); 
        font-size:16px; 
        font-weight:900; 
        color:var(--ink); 
        padding-bottom:14px; 
        border-bottom:1px dashed var(--border); 
    }
    .dp-panel h3 .emo { 
        width:36px; 
        height:36px; 
        border-radius:11px; 
        display:flex; 
        align-items:center; 
        justify-content:center; 
        background:rgba(var(--rgb,5,150,105),.14);
        border: 1px solid rgba(var(--rgb,5,150,105), 0.2);
        transition: all 0.3s ease;
    }
    .dp-panel h3 .emo svg {
        width: 20px;
        height: 20px;
        stroke: rgb(var(--rgb, 5,150,105));
        stroke-width: 2.2;
    }
    .dp-panel:hover h3 .emo {
        transform: scale(1.1) rotate(-5deg);
    }
    .dp-panel h3 .num { 
        margin-left:auto; 
        font-size:11px; 
        font-weight:900; 
        letter-spacing:.1em; 
        color:var(--muted);
        padding: 4px 10px;
        background: rgba(5,150,105,0.08);
        border-radius: 999px;
        border: 1px solid rgba(5,150,105,0.15);
    }

    /* ===== LIST ITEMS ===== */
    .dp-list { list-style:none; margin:0; padding:0; }
    .dp-list li { 
        padding:14px 0; 
        border-bottom:1px dashed var(--border);
        transition: all 0.25s ease;
    }
    .dp-list li:last-child { border-bottom:none; }
    .dp-list li:hover {
        background: rgba(5,150,105,0.03);
        padding-left: 8px;
        margin-left: -8px;
        border-radius: 8px;
    }
    .dp-list .title { 
        font-size:14px; 
        font-weight:800; 
        color:var(--ink); 
        line-height:1.5; 
        margin-bottom:6px; 
    }
    .dp-list .meta { 
        display:flex; 
        gap:10px; 
        flex-wrap:wrap; 
        font-size:12px; 
        color:var(--muted);
        align-items: center;
    }
    .dp-list .meta svg {
        width: 13px;
        height: 13px;
        stroke: currentColor;
        stroke-width: 2.2;
        opacity: 0.7;
    }
    .dp-list .meta .tag { 
        padding:3px 10px; 
        border-radius:999px; 
        font-weight:800; 
        font-size:10.5px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .dp-list .meta .year { 
        background:rgba(5,150,105,.12); 
        color:#047857;
        border: 1px solid rgba(5,150,105,0.2);
    }
    .dp-list .meta .type { 
        background:rgba(217,164,65,.14); 
        color:#92400e;
        border: 1px solid rgba(217,164,65,0.25);
    }
    .dp-list .meta .link { 
        color:#1d4ed8; 
        text-decoration:none; 
        font-weight:700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
    }
    .dp-list .meta .link:hover { 
        text-decoration:underline;
        color: #2563eb;
    }
    .dp-list .meta .link svg {
        width: 14px;
        height: 14px;
    }

    /* ===== BAR CHART TAHUNAN ===== */
    .dp-chart { 
        display:flex; 
        align-items:flex-end; 
        gap:8px; 
        height:160px; 
        padding:10px 6px 0;
    }
    .dp-bar { 
        flex:1; 
        display:flex; 
        flex-direction:column; 
        align-items:center; 
        gap:6px; 
        height:100%; 
        justify-content:flex-end;
    }
    .dp-bar i { 
        width:100%; 
        max-width:40px; 
        border-radius:8px 8px 3px 3px; 
        background:linear-gradient(180deg,#10b981,rgba(5,150,105,.55)); 
        box-shadow:inset 0 2px 3px rgba(255,255,255,.35), 0 4px 10px rgba(5,150,105,0.2); 
        transition:all 0.8s cubic-bezier(.16,1,.3,1); 
        position:relative;
        animation: barGrow 1s ease-out;
    }
    .dp-bar i::before {
        content: '';
        position: absolute;
        top: 4px;
        left: 15%;
        width: 35%;
        height: 30%;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        filter: blur(1.5px);
    }
    .dp-bar i:hover {
        transform: translateY(-4px);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.45), 0 8px 16px rgba(5,150,105,0.3);
    }
    .dp-bar i::after { 
        content:attr(data-v); 
        position:absolute; 
        top:-20px; 
        left:50%; 
        transform:translateX(-50%); 
        font-size:10px; 
        font-weight:900; 
        color:var(--muted);
        padding: 2px 6px;
        background: var(--surface);
        border-radius: 4px;
        border: 1px solid var(--border);
    }
    .dp-bar span { 
        font-size:10px; 
        font-weight:800; 
        color:var(--muted); 
    }

    /* ===== BIO CHIPS ===== */
    .dp-chips { display:flex; gap:10px; flex-wrap:wrap; margin-top:16px; }
    .dp-chip { 
        padding:10px 16px; 
        border-radius:999px; 
        font-size:12px; 
        font-weight:800; 
        text-decoration:none; 
        transition:all .25s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .dp-chip svg {
        width: 16px;
        height: 16px;
        stroke: currentColor;
        stroke-width: 2.2;
        transition: all 0.25s;
    }
    .dp-chip:hover { 
        transform:translateY(-3px); 
        filter:brightness(1.08);
    }
    .dp-chip:hover svg {
        animation: iconRotate 0.5s ease;
    }
    .dp-chip.scholar { 
        background:rgba(59,130,246,.1); 
        color:#1d4ed8; 
        border:1px solid rgba(59,130,246,.3);
        box-shadow: 0 2px 8px rgba(59,130,246,0.15);
    }
    .dp-chip.scholar:hover {
        background: rgba(59,130,246,.15);
        box-shadow: 0 4px 12px rgba(59,130,246,0.25);
    }
    .dp-chip.sinta { 
        background:rgba(16,185,129,.1); 
        color:#047857; 
        border:1px solid rgba(16,185,129,.3);
        box-shadow: 0 2px 8px rgba(16,185,129,0.15);
    }
    .dp-chip.sinta:hover {
        background: rgba(16,185,129,.15);
        box-shadow: 0 4px 12px rgba(16,185,129,0.25);
    }
    .dp-chip.orcid { 
        background:rgba(217,164,65,.12); 
        color:#92400e; 
        border:1px solid rgba(217,164,65,.35);
        box-shadow: 0 2px 8px rgba(217,164,65,0.15);
    }
    .dp-chip.orcid:hover {
        background: rgba(217,164,65,.18);
        box-shadow: 0 4px 12px rgba(217,164,65,0.25);
    }

    .dp-empty { 
        text-align:center; 
        padding:36px 12px; 
        color:var(--muted); 
        font-size:13px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }
    .dp-empty svg {
        width: 48px;
        height: 48px;
        stroke: currentColor;
        stroke-width: 1.5;
        opacity: 0.4;
    }

    /* ===== RESPONSIVE ===== */
    @media(max-width:768px){ 
        .dp-hero { 
            flex-direction: column;
            text-align: center;
            padding: 32px 28px;
        }
        .dp-avatar {
            width: 100px;
            height: 100px;
            font-size: 34px;
        }
        .dp-hero-actions {
            justify-content: center;
        }
        .dp-kpis {
            grid-template-columns: repeat(2, 1fr);
        }
        .dp-kpi b {
            font-size: 26px;
        }
        .dp-chart {
            height: 120px;
        }
    }

    @media(max-width:480px){
        .dp-kpis {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dp-wrap">

    <!-- ===== HERO ===== -->
    <div class="dp-hero">
        <div class="dp-avatar">
            <?php if (!empty($user['photo'])): ?>
                <img src="<?= e(upload_url($user['photo'])) ?>" alt="<?= e($user['name']) ?>">
            <?php else: ?>
                <?= e($initials) ?>
            <?php endif; ?>
        </div>
        <div class="dp-hero-info">
            <span class="role">
                <?= renderDosenDetailIcon('graduation-cap', 14, '#ffffff') ?>
                <span><?= e($roleLabel) ?></span>
            </span>
            <h1><?= e($user['name']) ?></h1>
            <p class="sub">
                <?php if (!empty($user['nidn'])): ?>
                    <?= renderDosenDetailIcon('clipboard', 14, 'currentColor') ?>
                    <span>NIDN: <?= e($user['nidn']) ?></span>
                    <span>·</span>
                <?php endif; ?>
                <?= renderDosenDetailIcon('award', 14, 'currentColor') ?>
                <span><?= e($user['institution'] ?? 'LP3M UNIMOF') ?></span>
            </p>
        </div>
        <div class="dp-hero-actions">
            <a class="dp-btn gold" href="<?= e(url('public/index.php?page=dosen-cv&id=' . $user['id'])) ?>" target="_blank">
                <?= renderDosenDetailIcon('download', 18, 'currentColor') ?>
                <span>Export CV</span>
            </a>
            <button class="dp-btn ghost" type="button" onclick="navigator.clipboard.writeText(location.href).then(()=>{this.innerHTML='<?= htmlspecialchars(renderDosenDetailIcon('check-circle', 18, 'currentColor'), ENT_QUOTES) ?> <span>Tersalin!</span>';setTimeout(()=>{this.innerHTML='<?= htmlspecialchars(renderDosenDetailIcon('copy', 18, 'currentColor'), ENT_QUOTES) ?> <span>Salin Link</span>'},1500);})">
                <?= renderDosenDetailIcon('copy', 18, 'currentColor') ?>
                <span>Salin Link</span>
            </button>
        </div>
    </div>

    <!-- ===== KPI ===== -->
    <div class="dp-kpis">
        <div class="dp-kpi" style="--rgb:5,150,105">
            <div class="dp-kpi-ico">
                <?= renderDosenDetailIcon('bar-chart', 24, 'currentColor') ?>
            </div>
            <b data-count="<?= (int) $stats['total_all'] ?>"><?= number_format($stats['total_all']) ?></b>
            <span>Total Karya</span>
        </div>
        <div class="dp-kpi" style="--rgb:124,58,237">
            <div class="dp-kpi-ico">
                <?= renderDosenDetailIcon('target', 24, 'currentColor') ?>
            </div>
            <b data-count="<?= (int) $hIndex ?>"><?= (int) $hIndex ?></b>
            <span>h-index (proxy)</span>
        </div>
        <div class="dp-kpi" style="--rgb:59,130,246">
            <div class="dp-kpi-ico">
                <?= renderDosenDetailIcon('book', 24, 'currentColor') ?>
            </div>
            <b data-count="<?= (int) $stats['journal_count'] ?>"><?= number_format($stats['journal_count']) ?></b>
            <span>Artikel Jurnal</span>
        </div>
        <div class="dp-kpi" style="--rgb:16,185,129">
            <div class="dp-kpi-ico">
                <?= renderDosenDetailIcon('link', 24, 'currentColor') ?>
            </div>
            <b data-count="<?= (int) $stats['doi_count'] ?>"><?= number_format($stats['doi_count']) ?></b>
            <span>Ber-DOI</span>
        </div>
        <div class="dp-kpi" style="--rgb:217,164,65">
            <div class="dp-kpi-ico">
                <?= renderDosenDetailIcon('calendar', 24, 'currentColor') ?>
            </div>
            <b><?= (int) $stats['first_year'] ?>–<?= (int) $stats['latest_year'] ?></b>
            <span>Tahun Aktif</span>
        </div>
    </div>

    <!-- ===== BIOGRAFI & TAUTAN AKADEMIK ===== -->
    <?php if (!empty($user['bio']) || !empty($user['scholar_url']) || !empty($user['sinta_url']) || !empty($user['orcid'])): ?>
    <div class="dp-panel" style="--rgb:217,164,65; margin-bottom:24px;">
        <h3>
            <span class="emo"><?= renderDosenDetailIcon('dna', 20, 'currentColor') ?></span>
            <span>Biografi & Tautan Akademik</span>
        </h3>
        <?php if (!empty($user['bio'])): ?>
        <p style="font-size:14px; line-height:1.8; color:var(--muted); margin:0 0 16px; white-space:pre-line;"><?= e($user['bio']) ?></p>
        <?php endif; ?>
        <div class="dp-chips">
            <?php if (!empty($user['scholar_url'])): ?>
            <a class="dp-chip scholar" href="<?= e($user['scholar_url']) ?>" target="_blank" rel="noopener">
                <?= renderDosenDetailIcon('graduation-cap', 16, 'currentColor') ?>
                <span>Google Scholar</span>
                <?= renderDosenDetailIcon('external-link', 14, 'currentColor') ?>
            </a>
            <?php endif; ?>
            <?php if (!empty($user['sinta_url'])): ?>
            <a class="dp-chip sinta" href="<?= e($user['sinta_url']) ?>" target="_blank" rel="noopener">
                <?= renderDosenDetailIcon('trending-up', 16, 'currentColor') ?>
                <span>SINTA Kemdikbud</span>
                <?= renderDosenDetailIcon('external-link', 14, 'currentColor') ?>
            </a>
            <?php endif; ?>
            <?php if (!empty($user['orcid'])): ?>
            <a class="dp-chip orcid" href="https://orcid.org/<?= e($user['orcid']) ?>" target="_blank" rel="noopener">
                <?= renderDosenDetailIcon('award', 16, 'currentColor') ?>
                <span>ORCID: <?= e($user['orcid']) ?></span>
                <?= renderDosenDetailIcon('external-link', 14, 'currentColor') ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- ===== 2 KOLOM: PENELITIAN + CHART ===== -->
    <div class="dp-2col">
        <div class="dp-panel" style="--rgb:59,130,246">
            <h3>
                <span class="emo"><?= renderDosenDetailIcon('microscope', 20, 'currentColor') ?></span>
                <span>Penelitian</span>
                <span class="num"><?= count($researches) ?> ITEM</span>
            </h3>
            <?php if (empty($researches)): ?>
            <div class="dp-empty">
                <?= renderDosenDetailIcon('inbox', 48, 'currentColor') ?>
                <span>Belum ada data penelitian.</span>
            </div>
            <?php else: ?>
            <ul class="dp-list">
                <?php foreach (array_slice($researches, 0, 8) as $r): ?>
                <li>
                    <div class="title"><?= e($r['title']) ?></div>
                    <div class="meta">
                        <span class="tag year">
                            <?= renderDosenDetailIcon('calendar', 13, 'currentColor') ?>
                            <span><?= (int) ($r['year'] ?? date('Y')) ?></span>
                        </span>
                        <span class="tag type">
                            <?= renderDosenDetailIcon('award', 13, 'currentColor') ?>
                            <span><?= e(ucfirst(str_replace('_', ' ', $r['scheme'] ?? 'Internal'))) ?></span>
                        </span>
                        <?php if (!empty($r['funding'])): ?>
                            <span style="display: inline-flex; align-items: center; gap: 5px;">
                                <?= renderDosenDetailIcon('dollar-sign', 13, 'currentColor') ?>
                                <span><?= e($r['funding']) ?></span>
                            </span>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>

        <div class="dp-panel" style="--rgb:16,185,129">
            <h3>
                <span class="emo"><?= renderDosenDetailIcon('trending-up', 20, 'currentColor') ?></span>
                <span>Tren Karya per Tahun</span>
                <span class="num">ALL TIME</span>
            </h3>
            <?php if (empty($years)): ?>
            <div class="dp-empty">
                <?= renderDosenDetailIcon('inbox', 48, 'currentColor') ?>
                <span>Belum ada data.</span>
            </div>
            <?php else: ?>
            <div class="dp-chart">
                <?php foreach (array_slice($years, -8, 8, true) as $y => $c): ?>
                <div class="dp-bar">
                    <i data-v="<?= (int) $c ?>" style="height:<?= max(6, (int) round($c / $maxYear * 100)) ?>%"></i>
                    <span><?= (int) $y ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ===== 2 KOLOM: PUBLIKASI + HAKI ===== -->
    <div class="dp-2col">
        <div class="dp-panel" style="--rgb:124,58,237">
            <h3>
                <span class="emo"><?= renderDosenDetailIcon('book-open', 20, 'currentColor') ?></span>
                <span>Publikasi Ilmiah</span>
                <span class="num"><?= count($publications) ?> ITEM</span>
            </h3>
            <?php if (empty($publications)): ?>
            <div class="dp-empty">
                <?= renderDosenDetailIcon('inbox', 48, 'currentColor') ?>
                <span>Belum ada data publikasi.</span>
            </div>
            <?php else: ?>
            <ul class="dp-list">
                <?php foreach (array_slice($publications, 0, 8) as $p): ?>
                <li>
                    <div class="title"><?= e($p['title']) ?></div>
                    <div class="meta">
                        <span class="tag year">
                            <?= renderDosenDetailIcon('calendar', 13, 'currentColor') ?>
                            <span><?= (int) ($p['year'] ?? date('Y')) ?></span>
                        </span>
                        <?php if (!empty($p['journal'])): ?>
                            <span style="display: inline-flex; align-items: center; gap: 5px;">
                                <?= renderDosenDetailIcon('book', 13, 'currentColor') ?>
                                <span><?= e($p['journal']) ?></span>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($p['doi'])): ?>
                        <a class="link" href="https://doi.org/<?= e($p['doi']) ?>" target="_blank" rel="noopener">
                            <?= renderDosenDetailIcon('link', 14, 'currentColor') ?>
                            <span>DOI</span>
                            <?= renderDosenDetailIcon('external-link', 12, 'currentColor') ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>

        <div class="dp-panel" style="--rgb:245,158,11">
            <h3>
                <span class="emo"><?= renderDosenDetailIcon('shield', 20, 'currentColor') ?></span>
                <span>HAKI Terdaftar</span>
                <span class="num"><?= count($haki) ?> ITEM</span>
            </h3>
            <?php if (empty($haki)): ?>
            <div class="dp-empty">
                <?= renderDosenDetailIcon('inbox', 48, 'currentColor') ?>
                <span>Belum ada data HAKI.</span>
            </div>
            <?php else: ?>
            <ul class="dp-list">
                <?php foreach (array_slice($haki, 0, 6) as $h): ?>
                <li>
                    <div class="title"><?= e($h['title']) ?></div>
                    <div class="meta">
                        <span class="tag year">
                            <?= renderDosenDetailIcon('calendar', 13, 'currentColor') ?>
                            <span><?= (int) ($h['year'] ?? date('Y')) ?></span>
                        </span>
                        <span class="tag type">
                            <?= renderDosenDetailIcon('shield', 13, 'currentColor') ?>
                            <span><?= e(ucfirst(str_replace('_', ' ', $h['type'] ?? 'Hak Cipta'))) ?></span>
                        </span>
                        <?php if (!empty($h['registration_number'])): ?>
                            <span style="display: inline-flex; align-items: center; gap: 5px;">
                                <?= renderDosenDetailIcon('file-text', 13, 'currentColor') ?>
                                <span><?= e($h['registration_number']) ?></span>
                            </span>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>

    <!-- ===== PENGABDIAN (FULL WIDTH) ===== -->
    <div class="dp-panel" style="--rgb:16,185,129; margin-bottom:32px;">
        <h3>
            <span class="emo"><?= renderDosenDetailIcon('handshake', 20, 'currentColor') ?></span>
            <span>Pengabdian Masyarakat</span>
            <span class="num"><?= count($cs) ?> ITEM</span>
        </h3>
        <?php if (empty($cs)): ?>
        <div class="dp-empty">
            <?= renderDosenDetailIcon('inbox', 48, 'currentColor') ?>
            <span>Belum ada data pengabdian.</span>
        </div>
        <?php else: ?>
        <ul class="dp-list">
            <?php foreach (array_slice($cs, 0, 6) as $c): ?>
            <li>
                <div class="title"><?= e($c['title']) ?></div>
                <div class="meta">
                    <span class="tag year">
                        <?= renderDosenDetailIcon('calendar', 13, 'currentColor') ?>
                        <span><?= (int) ($c['year'] ?? date('Y')) ?></span>
                    </span>
                    <span class="tag type">
                        <?= renderDosenDetailIcon('award', 13, 'currentColor') ?>
                        <span><?= e(ucfirst(str_replace('_', ' ', $c['type'] ?? 'Reguler'))) ?></span>
                    </span>
                    <?php if (!empty($c['location'])): ?>
                        <span style="display: inline-flex; align-items: center; gap: 5px;">
                            <?= renderDosenDetailIcon('map-pin', 13, 'currentColor') ?>
                            <span><?= e($c['location']) ?></span>
                        </span>
                    <?php endif; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>

</div>

<script>
(function(){
    // Counter animation
    document.querySelectorAll('[data-count]').forEach(function(el){
        var target = parseInt(el.getAttribute('data-count'), 10) || 0;
        if (target === 0) return;
        var start = null;
        function step(t){
            if (!start) start = t;
            var p = Math.min((t - start) / 900, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(target * eased).toLocaleString('id-ID');
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    });
    
    // Bar chart animation on scroll
    if ('IntersectionObserver' in window) {
        var bars = document.querySelectorAll('.dp-bar i');
        var io = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'barGrow 1s ease-out';
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });
        bars.forEach(function(bar) { io.observe(bar); });
    }
})();
</script>