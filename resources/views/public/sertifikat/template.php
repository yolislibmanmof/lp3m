<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($title ?? 'Sertifikat') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700;900&family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    @page { size: A4 landscape; margin: 0; }

    body {
        background: radial-gradient(circle at 20% 10%, rgba(217,164,65,.08), transparent 50%),
                    radial-gradient(circle at 80% 90%, rgba(16,185,129,.06), transparent 50%),
                    linear-gradient(135deg, #2d2820 0%, #1a1814 100%);
        min-height:100vh; display:flex; flex-direction:column; align-items:center;
        padding:28px 12px 60px;
        font-family:'Playfair Display','Cormorant Garamond',Georgia,serif;
    }

    /* ============ TOOLBAR (layar saja) ============ */
    .toolbar { display:flex; gap:10px; flex-wrap:wrap; align-items:center; max-width:1123px; width:96vw; margin-bottom:22px; padding:14px 18px; border-radius:16px; background:rgba(255,255,255,0.08); backdrop-filter:blur(18px); -webkit-backdrop-filter:blur(18px); border:1px solid rgba(255,255,255,0.15); box-shadow:0 8px 32px rgba(0,0,0,.3); }
    .toolbar button, .toolbar a { padding:11px 20px; border-radius:11px; border:none; cursor:pointer; font-size:13px; font-weight:700; text-decoration:none; font-family:'Cinzel',serif; letter-spacing:.04em; transition:all .3s cubic-bezier(.16,1,.3,1); position:relative; overflow:hidden; display:inline-flex; align-items:center; gap:7px; }
    .toolbar button { background:linear-gradient(145deg,#10b981,#059669); color:#fff; box-shadow:0 4px 14px rgba(5,150,105,.4), inset 0 1px 1px rgba(255,255,255,.25); }
    .toolbar button::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.45),transparent); animation:tbShine 3.5s ease-in-out infinite; }
    .toolbar a.gold { background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441 80%,#a9761b); color:#03251f; box-shadow:0 4px 14px rgba(217,164,65,.5), inset 0 1px 1px rgba(255,255,255,.5); }
    .toolbar a.ghost { background:rgba(255,255,255,.06); color:#fff; border:1px solid rgba(255,255,255,.2); }
    .toolbar button:hover, .toolbar a:hover { transform:translateY(-2px); }
    .tpl-select { padding:10px 14px; border-radius:10px; border:1px solid rgba(255,255,255,.25); background:rgba(255,255,255,.12); color:#fff; font-family:'Cinzel',serif; font-size:12px; font-weight:700; cursor:pointer; }
    .tpl-select option { color:#111; background:#fff; }
    .toolbar .tip { font-size:11.5px; color:rgba(255,255,255,.75); flex:1; min-width:200px; font-family:'Inter',sans-serif; line-height:1.5; }
    .toolbar .tip b { color:#fde68a; }
    @keyframes tbShine { 0%,55% { left:-100%; } 100% { left:160%; } }

    /* ============ HALAMAN + TEMA DEFAULT (CLASSIC) ============ */
    .cert-page {
        --cp-bg: radial-gradient(ellipse at 50% 0%, rgba(253,230,138,.22), transparent 55%), radial-gradient(ellipse at 50% 100%, rgba(16,185,129,.08), transparent 55%), linear-gradient(180deg,#fffdf8 0%,#fcf8ed 50%,#fffdf8 100%);
        --cp-solid:#fffdf8;
        --cp-ink:#0b3d2e; --cp-sub:#4a5b52; --cp-name:#123f30;
        --cp-gold:#d9a441; --cp-gold2:#f2c063; --cp-gold-deep:#a9761b;
        --cp-orn:rgba(217,164,65,.05); --cp-wm:rgba(217,164,65,.055);
        --cp-font-title:'Cinzel',serif; --cp-font-name:'Great Vibes',cursive;
        --cp-title-grad:linear-gradient(135deg,#d9a441 0%,#f2c063 30%,#a9761b 50%,#f2c063 70%,#d9a441 100%);
        --cp-name-shadow:0 1px 0 rgba(255,255,255,.8), 0 2px 4px rgba(0,0,0,.10);
        position:relative; width:1123px; max-width:96vw; aspect-ratio:1123/794; overflow:hidden;
        box-shadow:0 30px 80px rgba(0,0,0,.4), 0 0 0 1px rgba(0,0,0,.05);
        -webkit-print-color-adjust:exact; print-color-adjust:exact;
        background:var(--cp-bg); color:var(--cp-ink);
    }

    /* ============ 10 TEMPLATE PREMIUM ============ */
    .tpl-emerald { --cp-bg:radial-gradient(ellipse at 50% 0%,rgba(253,230,138,.10),transparent 55%),linear-gradient(160deg,#062e22,#043b2c 45%,#065f46); --cp-solid:#043b2c; --cp-ink:#f3e7c9; --cp-sub:rgba(243,231,201,.75); --cp-name:#fde68a; --cp-orn:rgba(242,192,99,.07); --cp-wm:rgba(242,192,99,.06); --cp-title-grad:linear-gradient(135deg,#fde68a,#f2c063 40%,#d9a441 70%,#fde68a); --cp-name-shadow:0 2px 8px rgba(0,0,0,.45); }
    .tpl-navy { --cp-bg:radial-gradient(ellipse at 50% 0%,rgba(255,255,255,.08),transparent 55%),linear-gradient(160deg,#0a1830,#122b52 50%,#0a1830); --cp-solid:#0a1830; --cp-ink:#e8eefb; --cp-sub:rgba(232,238,251,.72); --cp-name:#e6c65c; --cp-gold:#c9a227; --cp-gold2:#e6c65c; --cp-gold-deep:#8a6f1a; --cp-orn:rgba(230,198,92,.07); --cp-wm:rgba(230,198,92,.06); --cp-title-grad:linear-gradient(135deg,#e6c65c,#fff3c4 40%,#c9a227 70%,#e6c65c); --cp-font-title:'Playfair Display',serif; --cp-name-shadow:0 2px 8px rgba(0,0,0,.45); }
    .tpl-maroon { --cp-bg:linear-gradient(180deg,#fffaf5,#fdf3ec); --cp-solid:#fffaf5; --cp-ink:#5c1212; --cp-sub:#7a4a4a; --cp-name:#5c1212; --cp-gold:#8c1f1f; --cp-gold2:#c96a3a; --cp-gold-deep:#6d1414; --cp-orn:rgba(140,31,31,.05); --cp-wm:rgba(140,31,31,.05); --cp-title-grad:linear-gradient(135deg,#8c1f1f,#c96a3a 40%,#6d1414 60%,#c96a3a); --cp-font-title:'Playfair Display',serif; }
    .tpl-minimal { --cp-bg:#ffffff; --cp-solid:#ffffff; --cp-ink:#111111; --cp-sub:#555555; --cp-name:#111111; --cp-gold:#111111; --cp-gold2:#333333; --cp-gold-deep:#000000; --cp-orn:rgba(0,0,0,.04); --cp-wm:rgba(0,0,0,.04); --cp-title-grad:linear-gradient(90deg,#111,#111); --cp-font-title:'Inter',sans-serif; --cp-font-name:'Playfair Display',serif; --cp-name-shadow:none; }
    .tpl-islamic { --cp-bg:radial-gradient(circle at 50% 0%,rgba(16,185,129,.12),transparent 60%),linear-gradient(180deg,#f2faf5,#e8f5ec); --cp-solid:#f2faf5; --cp-ink:#065f46; --cp-sub:#3f6b58; --cp-name:#065f46; --cp-gold:#b8860b; --cp-gold2:#d9a441; --cp-gold-deep:#8a6f1a; --cp-orn:rgba(15,118,110,.08); --cp-wm:rgba(15,118,110,.06); --cp-title-grad:linear-gradient(135deg,#0f766e,#10b981 40%,#065f46 70%,#10b981); }
    .tpl-modern { --cp-bg:radial-gradient(circle at 0% 0%,rgba(13,148,136,.18),transparent 45%),radial-gradient(circle at 100% 100%,rgba(59,130,246,.14),transparent 45%),#ffffff; --cp-solid:#ffffff; --cp-ink:#0f172a; --cp-sub:#475569; --cp-name:#0f172a; --cp-gold:#0d9488; --cp-gold2:#2dd4bf; --cp-gold-deep:#0f766e; --cp-orn:rgba(13,148,136,.06); --cp-wm:rgba(13,148,136,.05); --cp-title-grad:linear-gradient(90deg,#0d9488,#2dd4bf 50%,#0ea5e9); --cp-font-title:'Inter',sans-serif; --cp-font-name:'Playfair Display',serif; --cp-name-shadow:none; }
    .tpl-vintage { --cp-bg:linear-gradient(180deg,#f6ecd9,#efe3c8); --cp-solid:#f6ecd9; --cp-ink:#4a3418; --cp-sub:#6b5638; --cp-name:#4a3418; --cp-gold:#7a5a24; --cp-gold2:#a3803a; --cp-gold-deep:#5c421a; --cp-orn:rgba(122,90,36,.07); --cp-wm:rgba(122,90,36,.07); --cp-title-grad:linear-gradient(135deg,#7a5a24,#a3803a 40%,#5c421a 70%,#a3803a); --cp-font-title:'Playfair Display',serif; }
    .tpl-executive { --cp-bg:linear-gradient(160deg,#141416,#232326 50%,#141416); --cp-solid:#141416; --cp-ink:#e8e6e1; --cp-sub:rgba(232,230,225,.7); --cp-name:#e8c766; --cp-gold:#c9a227; --cp-gold2:#e8c766; --cp-gold-deep:#8a6f1a; --cp-orn:rgba(232,199,102,.06); --cp-wm:rgba(232,199,102,.05); --cp-title-grad:linear-gradient(135deg,#e8c766,#fff0c0 40%,#c9a227 70%,#e8c766); --cp-name-shadow:0 2px 8px rgba(0,0,0,.45); }
    .tpl-aurora { --cp-bg:radial-gradient(circle at 20% 10%,rgba(167,139,250,.20),transparent 50%),radial-gradient(circle at 80% 90%,rgba(236,72,153,.14),transparent 50%),linear-gradient(180deg,#faf7ff,#f3ecff); --cp-solid:#faf7ff; --cp-ink:#4c1d95; --cp-sub:#6b5b8a; --cp-name:#5b21b6; --cp-gold:#7c3aed; --cp-gold2:#a78bfa; --cp-gold-deep:#5b21b6; --cp-orn:rgba(124,58,237,.06); --cp-wm:rgba(124,58,237,.05); --cp-title-grad:linear-gradient(90deg,#7c3aed,#a78bfa 40%,#ec4899 70%,#7c3aed); }

    .tpl-emerald .cert-name, .tpl-navy .cert-name, .tpl-executive .cert-name { text-shadow:var(--cp-name-shadow); }
    .tpl-minimal .corner-orn, .tpl-minimal .sunburst, .tpl-minimal .wm-center, .tpl-minimal .ribbon-official { display:none; }
    .tpl-minimal .border-outer { border:2px solid #111; background:none; }
    .tpl-minimal .border-middle, .tpl-minimal .border-inner { display:none; }
    .tpl-vintage .border-outer { border:8px double var(--cp-gold); background:none; }
    .tpl-islamic .pattern-bg { opacity:.85; }

    /* ============ LAYER DEKORATIF ============ */
    .wm-center { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); font-family:var(--cp-font-title); font-weight:900; font-size:240px; letter-spacing:.05em; color:var(--cp-wm); pointer-events:none; user-select:none; z-index:1; }
    .pattern-bg { position:absolute; inset:0; pointer-events:none; z-index:0; opacity:.35; background-image:radial-gradient(circle at 25% 25%, var(--cp-orn) 1px, transparent 1.5px), radial-gradient(circle at 75% 75%, var(--cp-orn) 1px, transparent 1.5px); background-size:42px 42px; }
    .pattern-inner { position:absolute; inset:0; pointer-events:none; z-index:0; color:var(--cp-gold); opacity:.10; background-image:repeating-linear-gradient(45deg, currentColor 0 1px, transparent 1px 28px), repeating-linear-gradient(-45deg, currentColor 0 1px, transparent 1px 28px); }
    .sunburst { position:absolute; inset:0; z-index:1; pointer-events:none; color:var(--cp-gold); opacity:.10; background:repeating-conic-gradient(from 0deg at 50% 46%, currentColor 0deg 1.2deg, transparent 1.2deg 6deg); -webkit-mask-image:radial-gradient(circle at 50% 46%, rgba(0,0,0,.9) 0%, transparent 52%); mask-image:radial-gradient(circle at 50% 46%, rgba(0,0,0,.9) 0%, transparent 52%); }

    .border-outer { position:absolute; inset:20px; pointer-events:none; z-index:2; border:5px solid transparent; background:linear-gradient(var(--cp-solid),var(--cp-solid)) padding-box, linear-gradient(135deg,var(--cp-gold) 0%,var(--cp-gold2) 25%,var(--cp-gold-deep) 50%,var(--cp-gold2) 75%,var(--cp-gold) 100%) border-box; }
    .border-middle { position:absolute; inset:32px; pointer-events:none; z-index:2; border:1.5px dashed var(--cp-gold); opacity:.55; }
    .border-inner { position:absolute; inset:40px; pointer-events:none; z-index:2; border:1px solid var(--cp-gold); opacity:.4; }

    .corner-orn { position:absolute; width:92px; height:92px; pointer-events:none; z-index:3; color:var(--cp-gold); }
    .corner-orn svg { width:100%; height:100%; display:block; }
    .c-tl { top:14px; left:14px; } .c-tr { top:14px; right:14px; transform:scaleX(-1); }
    .c-bl { bottom:14px; left:14px; transform:scaleY(-1); } .c-br { bottom:14px; right:14px; transform:scale(-1,-1); }

    .ribbon-official { position:absolute; top:68px; left:-38px; z-index:5; transform:rotate(-42deg); width:190px; padding:7px 18px; text-align:center; font-family:'Cinzel',serif; font-weight:900; font-size:10px; letter-spacing:.3em; color:#03251f; background:linear-gradient(180deg,#fde68a 0%,#f2c063 35%,#d9a441 55%,#a9761b 100%); box-shadow:inset 0 1px 1px rgba(255,255,255,.8), inset 0 -2px 3px rgba(0,0,0,.25), 0 4px 10px rgba(0,0,0,.25); }

    /* ============ KONTEN ============ */
    .cert-content { position:relative; z-index:4; height:100%; display:flex; flex-direction:column; align-items:center; text-align:center; padding:50px 100px 22px; }

    .cert-head { display:flex; align-items:center; width:100%; border-bottom:3px double var(--cp-gold); padding-bottom:12px; }
    .head-side { width:200px; flex-shrink:0; }
    .head-left { text-align:left; }
    .head-center { flex:1; padding:0 20px; }
    .cert-logo { width:62px; height:62px; object-fit:contain; }
    .cert-logo-fallback { width:62px; height:62px; border-radius:16px; margin:0 auto; background:radial-gradient(circle at 30% 25%,#fff7c2 0%,#fde68a 20%,#f2c063 55%,#d9a441 100%); color:#03251f; display:flex; align-items:center; justify-content:center; font-family:'Cinzel',serif; font-weight:900; font-size:21px; }
    .inst-name { font-family:var(--cp-font-title); font-size:25px; font-weight:700; letter-spacing:.1em; color:var(--cp-ink); text-transform:uppercase; }
    .inst-sub { font-size:11.5px; color:var(--cp-sub); margin-top:3px; line-height:1.4; font-family:'Cormorant Garamond',serif; font-weight:500; }
    .inst-addr { font-size:10px; color:var(--cp-sub); margin-top:4px; font-style:italic; }

    .cert-title-wrap { margin-top:16px; text-align:center; width:100%; }
    .cert-title { font-family:var(--cp-font-title); font-weight:700; font-size:60px; letter-spacing:.3em; text-indent:.3em; background:var(--cp-title-grad); background-size:200% auto; -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; line-height:1; }
    @media screen { .cert-title { animation:foilShift 7s linear infinite; } }
    @keyframes foilShift { to { background-position:200% center; } }
    .cert-subtitle { font-family:var(--cp-font-title); font-size:13px; font-weight:600; letter-spacing:.5em; text-indent:.5em; color:var(--cp-ink); margin-top:8px; text-transform:uppercase; }
    .flourish-divider { margin:12px auto 10px; width:260px; height:22px; color:var(--cp-gold); }
    .flourish-divider svg { width:100%; height:100%; }

    .cert-given { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:15px; color:var(--cp-sub); }
    .cert-given .lang-sep { color:var(--cp-gold); margin:0 6px; font-style:normal; }
    .cert-given .lang-en { opacity:.75; font-size:13px; }
    .cert-name { font-family:var(--cp-font-name); font-size:54px; line-height:1.1; color:var(--cp-name); margin-top:2px; max-width:880px; word-break:break-word; text-shadow:var(--cp-name-shadow); }
    .name-flourish { margin-top:4px; width:230px; height:10px; color:var(--cp-gold); }
    .name-flourish svg { width:100%; height:100%; }
    .cert-identity { font-family:'Cormorant Garamond',serif; font-weight:600; font-size:12.5px; color:var(--cp-sub); margin-top:2px; letter-spacing:.15em; text-transform:uppercase; }
    .cert-for { margin-top:9px; font-family:'Cormorant Garamond',serif; font-size:14px; color:var(--cp-sub); max-width:760px; line-height:1.5; font-style:italic; }
    .cert-activity { margin-top:5px; font-family:'Playfair Display',serif; font-size:21px; font-weight:700; color:var(--cp-ink); max-width:860px; line-height:1.35; padding:0 10px; }
    .cert-date { margin-top:5px; font-family:'Cormorant Garamond',serif; font-size:13.5px; color:var(--cp-sub); font-style:italic; }
    .cert-hijri { font-size:11px; color:var(--cp-sub); margin-top:3px; font-family:'Cormorant Garamond',serif; font-style:italic; }

    /* ================================================================
       KAKI PRESISI — GRID 3 KOLOM:
       QR (kiri) | MEDALI AWARDED (tengah presisi) | TTD (kanan)
       (cap/stempel & barcode SUDAH DIHAPUS)
       ================================================================ */
    .cert-foot { margin-top:auto; width:100%; display:grid; grid-template-columns:1fr auto 1fr; align-items:end; column-gap:24px; padding:0 24px; }
    .foot-left { justify-self:start; }
    .foot-center { justify-self:center; align-self:end; display:flex; align-items:center; justify-content:center; padding-bottom:4px; }
    .foot-right { justify-self:end; width:320px; text-align:center; }

    .qr-frame { display:inline-block; padding:8px; background:#fff; border:2px solid transparent; background-image:linear-gradient(#fff,#fff), linear-gradient(135deg,var(--cp-gold),var(--cp-gold2),var(--cp-gold-deep)); background-origin:border-box; background-clip:padding-box,border-box; border-radius:8px; box-shadow:0 6px 16px rgba(0,0,0,.15); }
    .qr-frame img { width:104px; height:104px; display:block; border-radius:2px; }

    /* 🏅 MEDALI AWARDED — pengganti cap, di tengah presisi */
    .medallion {
        width:96px; height:96px;
        display:flex; align-items:center; justify-content:center; border-radius:50%;
        background:radial-gradient(circle at 30% 25%,#fff7c2 0%,#fde68a 20%,#f2c063 55%,#d9a441 80%,#a9761b 100%);
        box-shadow:
            inset 0 2px 4px rgba(255,255,255,.7),
            inset 0 -3px 5px rgba(0,0,0,.2),
            0 8px 18px rgba(217,164,65,.45),
            0 0 0 3px var(--cp-solid),
            0 0 0 5px var(--cp-gold);
        transform:rotate(-12deg);
    }
    .medallion-inner { text-align:center; color:#03251f; font-family:'Cinzel',serif; font-weight:900; line-height:1.1; transform:rotate(12deg); }
    .medallion-inner .med-top { font-size:7px; letter-spacing:.15em; }
    .medallion-inner .med-icon { font-size:24px; line-height:1; margin:2px 0; }
    .medallion-inner .med-bot { font-size:6px; letter-spacing:.12em; text-transform:uppercase; }

    .sign-title { font-family:'Cormorant Garamond',serif; font-weight:600; font-size:13px; color:var(--cp-sub); letter-spacing:.03em; }
    .sign-space { height:64px; display:flex; align-items:flex-end; justify-content:center; }
    .sign-sig { font-family:'Great Vibes',cursive; font-size:32px; color:var(--cp-ink); margin-bottom:4px; line-height:1; }
    .sign-img { max-height:58px; max-width:220px; object-fit:contain; margin-bottom:4px; }
    .sign-line { width:100%; height:1.5px; position:relative; background:linear-gradient(90deg,transparent,var(--cp-gold) 20%,var(--cp-gold-deep) 50%,var(--cp-gold) 80%,transparent); }
    .sign-line::before, .sign-line::after { content:''; position:absolute; top:-2px; width:6px; height:6px; background:var(--cp-gold); border-radius:50%; }
    .sign-line::before { left:15%; } .sign-line::after { right:15%; }
    .sign-name { font-family:var(--cp-font-title); font-weight:700; font-size:13.5px; color:var(--cp-ink); margin-top:6px; letter-spacing:.04em; }

    /* ============ SECURITY STACK (tanpa barcode) ============ */
    .cert-security { width:100%; margin-top:12px; display:flex; flex-direction:column; align-items:center; gap:3px; }
    .holo-strip { width:100%; height:7px; border-radius:2px; background:linear-gradient(90deg,rgba(255,0,150,.4) 0%,rgba(255,215,0,.5) 18%,rgba(0,255,150,.5) 36%,rgba(0,150,255,.5) 54%,rgba(150,0,255,.5) 72%,rgba(255,0,150,.4) 100%); background-size:200% 100%; box-shadow:inset 0 1px 1px rgba(255,255,255,.5); }
    @media screen { .holo-strip { animation:holoShift 8s linear infinite; } }
    @keyframes holoShift { to { background-position:200% 0; } }
    .microtext { width:100%; margin-top:2px; text-align:center; font-family:'Courier New',monospace; font-size:4.5px; letter-spacing:.12em; color:var(--cp-gold); opacity:.45; white-space:nowrap; overflow:hidden; user-select:none; }
    .cert-verify-line { margin-top:4px; padding-top:5px; border-top:1px solid var(--cp-gold); width:100%; font-family:'Courier New',monospace; font-size:9px; color:var(--cp-sub); letter-spacing:.03em; word-break:break-all; text-align:center; opacity:.85; }

    .revoked-watermark { position:absolute; inset:0; z-index:6; pointer-events:none; display:flex; align-items:center; justify-content:center; font-family:'Cinzel',serif; font-weight:900; font-size:150px; letter-spacing:.25em; color:rgba(185,28,28,.18); transform:rotate(-24deg); user-select:none; background-image:repeating-linear-gradient(45deg,transparent,transparent 40px,rgba(185,28,28,.04) 40px,rgba(185,28,28,.04) 42px); }

    @media print {
        body { background:#fff; padding:0; }
        .toolbar { display:none !important; }
        .cert-page { width:297mm; height:209mm; max-width:none; aspect-ratio:auto; box-shadow:none; }
        * { -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important; }
    }
</style>
</head>
<body>

<?php
$hijriYear = (int) date('Y', strtotime($cert['issue_date'])) - 579;
$microText = str_repeat('LP3M • VERIFIED • ' . $cert['code'] . ' • OFFICIAL • ', 8);
$tpl = $cert['template'] ?? 'classic';
if (!array_key_exists($tpl, Certificate::TEMPLATES)) $tpl = 'classic';
$qrUrl = urlencode(url('public/index.php?page=verifikasi-sertifikat&code=' . urlencode($cert['code'])));
$cornerSvg = '<svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 5 L35 5 L35 12 L12 12 L12 35 L5 35 Z" fill="currentColor"/><circle cx="20" cy="20" r="6" fill="currentColor" fill-opacity=".75"/><circle cx="20" cy="20" r="3" fill="currentColor" fill-opacity=".4"/><path d="M35 12 Q50 18 45 35" stroke="currentColor" stroke-width="1.5"/><path d="M12 35 Q18 50 35 45" stroke="currentColor" stroke-width="1.5"/><circle cx="50" cy="28" r="2" fill="currentColor"/><circle cx="28" cy="50" r="2" fill="currentColor"/></svg>';
?>

<!-- ============== TOOLBAR (layar saja) ============== -->
<div class="toolbar">
    <button onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
    <select id="tpl-switch" class="tpl-select" title="Ganti template (live preview)">
        <?php foreach (Certificate::TEMPLATES as $tKey => $tLabel): ?>
            <option value="<?= e($tKey) ?>" <?= $tpl === $tKey ? 'selected' : '' ?>>🎨 <?= e($tLabel) ?></option>
        <?php endforeach; ?>
    </select>
    <a class="gold" target="_blank" href="<?= e(url('public/index.php?page=verifikasi-sertifikat&code=' . urlencode($cert['code']))) ?>">🔍 Halaman Verifikasi</a>
    <a class="ghost" href="javascript:history.back()">⬅ Kembali</a>
    <span class="tip">💡 Kertas <b>A4</b>, orientasi <b>Landscape</b>, margin <b>None</b>, centang <b>Background graphics</b>.</span>
</div>

<!-- ============== HALAMAN SERTIFIKAT ============== -->
<div class="cert-page tpl-<?= e($tpl) ?>" id="cert-page">
    <div class="pattern-bg"></div>
    <div class="sunburst"></div>
    <div class="wm-center" aria-hidden="true"><?= e(mb_strtoupper($site['site_brand'] ?? 'LP3M')) ?></div>
    <div class="pattern-inner"></div>

    <div class="border-outer"></div>
    <div class="border-middle"></div>
    <div class="border-inner"></div>

    <div class="corner-orn c-tl"><?= $cornerSvg ?></div>
    <div class="corner-orn c-tr"><?= $cornerSvg ?></div>
    <div class="corner-orn c-bl"><?= $cornerSvg ?></div>
    <div class="corner-orn c-br"><?= $cornerSvg ?></div>

    <?php if ($cert['status'] !== 'valid'): ?>
        <div class="revoked-watermark">DICABUT</div>
    <?php else: ?>
        <div class="ribbon-official">★ OFFICIAL ★</div>
    <?php endif; ?>

    <div class="cert-content">
        <!-- KOP -->
        <header class="cert-head">
            <div class="head-side head-left">
                <?php if (!empty($site['logo_path'])): ?>
                    <img class="cert-logo" src="<?= e(upload_url($site['logo_path'])) ?>" alt="Logo">
                <?php else: ?>
                    <div class="cert-logo-fallback">LP</div>
                <?php endif; ?>
            </div>
            <div class="head-center">
                <div class="inst-name"><?= e($site['site_brand'] ?? 'LP3M') ?></div>
                <div class="inst-sub">Lembaga Penelitian, Pengabdian kepada Masyarakat, dan Al-Islam Kemuhammadiyahan</div>
                <?php if (!empty($contactLine)): ?><div class="inst-addr"><?= e($contactLine) ?></div><?php endif; ?>
            </div>
            <div class="head-side" aria-hidden="true"></div>
        </header>

        <!-- JUDUL -->
        <div class="cert-title-wrap">
            <div class="cert-title">SERTIFIKAT</div>
            <div class="cert-subtitle"><?= e(strtoupper($types[$cert['activity_type']] ?? 'KEGIATAN')) ?></div>
        </div>

        <div class="flourish-divider">
            <svg viewBox="0 0 260 22" xmlns="http://www.w3.org/2000/svg">
                <line x1="0" y1="11" x2="90" y2="11" stroke="currentColor" stroke-width="1"/>
                <line x1="170" y1="11" x2="260" y2="11" stroke="currentColor" stroke-width="1"/>
                <circle cx="130" cy="11" r="5" fill="none" stroke="currentColor" stroke-width="1.2"/>
                <circle cx="130" cy="11" r="2" fill="currentColor"/>
                <circle cx="95" cy="11" r="1.5" fill="currentColor"/>
                <circle cx="165" cy="11" r="1.5" fill="currentColor"/>
                <path d="M105 11 Q115 4 120 11" stroke="currentColor" stroke-width="1"/>
                <path d="M140 11 Q145 18 155 11" stroke="currentColor" stroke-width="1"/>
            </svg>
        </div>

        <!-- ISI -->
        <div class="cert-given"><span>Diberikan kepada</span><span class="lang-sep">·</span><span class="lang-en">Awarded to</span></div>
        <div class="cert-name"><?= e($cert['holder_name']) ?></div>
        <div class="name-flourish">
            <svg viewBox="0 0 230 10" xmlns="http://www.w3.org/2000/svg">
                <line x1="0" y1="5" x2="95" y2="5" stroke="currentColor" stroke-width="0.8"/>
                <line x1="135" y1="5" x2="230" y2="5" stroke="currentColor" stroke-width="0.8"/>
                <path d="M115 1 L119 5 L115 9 L111 5 Z" fill="currentColor"/>
            </svg>
        </div>
        <?php if (!empty($cert['holder_identity'])): ?><div class="cert-identity"><?= e($cert['holder_identity']) ?></div><?php endif; ?>

        <div class="cert-for">atas partisipasi dan kontribusinya dalam kegiatan <em>— for participation and contribution in —</em></div>
        <div class="cert-activity"><?= e($cert['activity_title']) ?></div>
        <div class="cert-date">yang diselenggarakan pada <strong><?= e(date('d F Y', strtotime($cert['issue_date']))) ?></strong></div>
        <div class="cert-hijri">Tahun Hijriah: <strong><?= $hijriYear ?> H</strong></div>

        <!-- KAKI: QR | MEDALI AWARDED (tengah presisi, pengganti cap) | TTD -->
        <footer class="cert-foot">
            <div class="foot-left">
                <div class="qr-frame">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&margin=0&data=<?= $qrUrl ?>" alt="QR Verifikasi">
                </div>
            </div>

            <div class="foot-center">
                <?php if ($cert['status'] === 'valid'): ?>
                <div class="medallion" aria-hidden="true">
                    <div class="medallion-inner">
                        <div class="med-top">AWARDED</div>
                        <div class="med-icon">🏆</div>
                        <div class="med-bot"><?= e(date('Y', strtotime($cert['issue_date']))) ?></div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="foot-right">
                <div class="sign-title"><?= e($cert['signer_title']) ?></div>
                <div class="sign-space">
                    <?php if (!empty($cert['signer_signature'])): ?>
                        <img class="sign-img" src="<?= e(upload_url($cert['signer_signature'])) ?>" alt="Tanda tangan">
                    <?php else: ?>
                        <div class="sign-sig"><?= e(explode(' ', trim($cert['signer_name']))[0] ?? 'LP3M') ?></div>
                    <?php endif; ?>
                </div>
                <div class="sign-line"></div>
                <div class="sign-name"><?= e($cert['signer_name']) ?></div>
            </div>
        </footer>

        <!-- SECURITY STACK (holo + microtext + verify line, TANPA barcode) -->
        <div class="cert-security">
            <div class="holo-strip"></div>
            <div class="microtext"><?= e($microText) ?></div>
            <div class="cert-verify-line">🔗 <?= e(url('public/index.php?page=verifikasi-sertifikat&code=' . urlencode($cert['code']))) ?></div>
        </div>
    </div>
</div>

<script>
(function(){
    var sel = document.getElementById('tpl-switch');
    var page = document.getElementById('cert-page');
    if (sel && page) {
        sel.addEventListener('change', function(){
            page.className = 'cert-page tpl-' + sel.value;
        });
    }
})();
</script>

</body>
</html>