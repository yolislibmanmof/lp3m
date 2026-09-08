<?php
$typeIcons = [
    'pengabdian' => '🤝',
    'kkn' => '🎓',
    'desa_binaan' => '🏡',
];

$cPengabdian = CommunityService::paginate(['status' => 'published', 'type' => 'pengabdian'], '', [], 1, 1)['total'];
$cKkn = CommunityService::paginate(['status' => 'published', 'type' => 'kkn'], '', [], 1, 1)['total'];
$cDesa = CommunityService::paginate(['status' => 'published', 'type' => 'desa_binaan'], '', [], 1, 1)['total'];
$cTotal = $cPengabdian + $cKkn + $cDesa;

$yearStmt = Database::pdo()->query('SELECT year, COUNT(*) as cnt FROM community_services WHERE status = "published" GROUP BY year ORDER BY year DESC LIMIT 5');
$yearTimeline = $yearStmt->fetchAll();

$locationStmt = Database::pdo()->query('SELECT location, COUNT(*) as cnt FROM community_services WHERE status = "published" GROUP BY location ORDER BY cnt DESC LIMIT 8');
$locations = $locationStmt->fetchAll();

$partnerStmt = Database::pdo()->query('SELECT partner, COUNT(*) as cnt FROM community_services WHERE status = "published" AND partner != "" GROUP BY partner ORDER BY cnt DESC LIMIT 8');
$partners = $partnerStmt->fetchAll();

$aikStmt = Database::pdo()->query('SELECT COUNT(*) FROM community_services WHERE status = "published" AND aik_integration != ""');
$aikCount = (int) $aikStmt->fetchColumn();

$leaderStmt = Database::pdo()->query('SELECT leader, COUNT(*) as cnt FROM community_services WHERE status = "published" GROUP BY leader ORDER BY cnt DESC LIMIT 5');
$topLeaders = $leaderStmt->fetchAll();

$thisYear = (int) Database::pdo()->query('SELECT COUNT(*) FROM community_services WHERE status = "published" AND year = ' . (int) date('Y'))->fetchColumn();
$totalMitra = count($partners);

$quotes = [
    ['"Sebaik-baik manusia adalah yang paling bermanfaat bagi manusia." — HR. Ahmad', '🤝'],
    ['"Tangan di atas lebih baik daripada tangan di bawah." — HR. Bukhari-Muslim', '✋'],
    ['"Fastabiqul Khairat — berlomba-lomba dalam kebaikan." — QS. Al-Baqarah: 148', '🏃'],
    ['"Pengabdian adalah wujud cinta kepada sesama." — Pepatah', '❤️'],
];
$todayQuote = $quotes[date('z') % count($quotes)];

$sdgsMap = [
    ['🎯', 'Tanpa Kemiskinan', 'SDG 1'],
    ['🌾', 'Tanpa Kelaparan', 'SDG 2'],
    ['💊', 'Kehidupan Sehat', 'SDG 3'],
    ['📚', 'Pendidikan Berkualitas', 'SDG 4'],
    ['⚖️', 'Kesetaraan Gender', 'SDG 5'],
    ['💧', 'Air Bersih', 'SDG 6'],
    ['⚡', 'Energi Bersih', 'SDG 7'],
    ['💼', 'Pekerjaan Layak', 'SDG 8'],
];
shuffle($sdgsMap);
$sdgsSelected = array_slice($sdgsMap, 0, 4);

$marqueeWords = ['Desa Binaan', 'KKN Tematik', 'Pemberdayaan Masyarakat', 'Mitra Strategis', 'Integrasi AIK', 'Berkemajuan', 'SDGs', 'Fastabiqul Khairat'];
?>

<style>
    @keyframes csFloat1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(20px,-15px)} }
    @keyframes csFloat2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-15px,20px)} }
    @keyframes csGlow { 0%,100%{text-shadow:0 0 20px rgba(242,192,99,0.5)} 50%{text-shadow:0 0 30px rgba(242,192,99,0.8),0 0 60px rgba(217,164,65,0.5)} }
    @keyframes csShine { 0%{transform:translateX(-100%) skewX(-20deg)} 100%{transform:translateX(300%) skewX(-20deg)} }

    .cs-orb { position:absolute; border-radius:50%; pointer-events:none; z-index:0; }
    .cs-orb-1 { width:140px; height:140px; top:12%; right:8%; background:radial-gradient(circle at 30% 30%, rgba(253,230,138,0.6), rgba(217,164,65,0.3) 60%, transparent); filter:blur(2px); animation:csFloat1 8s ease-in-out infinite; }
    .cs-orb-2 { width:200px; height:200px; bottom:15%; left:5%; background:radial-gradient(circle at 70% 70%, rgba(110,231,183,0.4), rgba(16,185,129,0.2) 60%, transparent); filter:blur(3px); animation:csFloat2 10s ease-in-out infinite; }

    .ico-cs { display:inline-flex; align-items:center; justify-content:center; width:52px; height:52px; border-radius:16px; font-size:24px; flex-shrink:0; background:radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #34d399, #10b981 50%, #059669); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(5,150,105,0.35); position:relative; overflow:hidden; }
    .ico-cs::before { content:''; position:absolute; top:5px; left:10px; width:16px; height:7px; border-radius:50%; background:rgba(255,255,255,0.6); filter:blur(2px); }
    .ico-cs-lg { width:68px; height:68px; border-radius:20px; font-size:32px; }
    .ico-cs-gold { background:radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%), linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441); box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -3px 4px rgba(0,0,0,0.2), 0 6px 16px rgba(217,164,65,0.4); }
    .ico-cs-blue { background:radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #60a5fa, #3b82f6 50%, #1d4ed8); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(59,130,246,0.35); }
    .ico-cs-purple { background:radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #c4b5fd, #a78bfa 50%, #7c3aed); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(124,58,237,0.35); }
    .ico-cs-red { background:radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #fca5a5, #f87171 50%, #dc2626); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(220,38,38,0.35); }

    .cs-quote-3d { position:relative; padding:30px; border-radius:24px; background:linear-gradient(145deg, #065f46, #03251f); border:1px solid rgba(217,164,65,0.25); overflow:hidden; box-shadow: inset 0 1px 1px rgba(255,255,255,0.08), 0 16px 40px rgba(0,0,0,0.35); }
    .cs-quote-3d::before { content:''; position:absolute; top:-60%; right:-20%; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle, rgba(217,164,65,0.3), transparent 70%); }
    .cs-quote-mark { position:absolute; top:4px; left:12px; font-size:90px; line-height:1; color:rgba(217,164,65,0.12); font-family:Georgia,serif; pointer-events:none; }

    .cs-counter-3d { font-family:var(--font-display); font-size:44px; font-weight:900; line-height:1; background:linear-gradient(135deg, #fde68a, #f2c063 40%, #d9a441); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; animation:csGlow 3s ease-in-out infinite; }

    .cs-mini-stat { padding:14px; border-radius:16px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); text-align:center; position:relative; overflow:hidden; }
    .cs-mini-stat::before { content:''; position:absolute; inset:0; background:radial-gradient(circle at 50% 0%, rgba(217,164,65,0.15), transparent 60%); pointer-events:none; }
    .cs-mini-num { font-family:var(--font-display); font-size:26px; font-weight:900; color:#f2c063; line-height:1; }

    .sdg-card-3d { position:relative; padding:24px 18px; background:var(--white); border:1px solid var(--border); border-radius:22px; text-align:center; overflow:hidden; transition:all 0.35s cubic-bezier(0.16,1,0.3,1); box-shadow:0 4px 14px rgba(0,0,0,0.05); }
    .sdg-card-3d::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg, #d9a441, #059669); transform:scaleX(0); transform-origin:left; transition:transform 0.4s ease; }
    .sdg-card-3d:hover { transform:translateY(-6px); box-shadow:0 18px 36px rgba(5,150,105,0.18); border-color:rgba(5,150,105,0.3); }
    .sdg-card-3d:hover::before { transform:scaleX(1); }

    .leader-row-3d { display:flex; align-items:center; gap:16px; padding:16px 20px; background:var(--white); border:1px solid var(--border); border-radius:18px; transition:all 0.3s; box-shadow:0 4px 12px rgba(0,0,0,0.04); }
    .leader-row-3d:hover { transform:translateY(-3px); box-shadow:0 12px 28px rgba(5,150,105,0.15); border-color:rgba(5,150,105,0.3); }
    .leader-rank { width:52px; height:52px; border-radius:16px; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-weight:900; font-size:22px; flex-shrink:0; position:relative; overflow:hidden; box-shadow: inset 0 2px 3px rgba(255,255,255,0.5), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(0,0,0,0.25); }
    .leader-rank::before { content:''; position:absolute; top:6px; left:11px; width:18px; height:8px; border-radius:50%; background:rgba(255,255,255,0.55); filter:blur(2px); }
    .lr-gold { background:linear-gradient(145deg, #fde68a, #d9a441 60%, #a9761b); color:#03251f; }
    .lr-silver { background:linear-gradient(145deg, #e2e8f0, #94a3b8 60%, #64748b); }
    .lr-bronze { background:linear-gradient(145deg, #fdba74, #b45309 60%, #92400e); }
    .lr-emerald { background:linear-gradient(145deg, #34d399, #10b981 60%, #059669); }
    .leader-avatar { width:44px; height:44px; border-radius:50%; background:radial-gradient(circle at 30% 25%, #fde68a, #d9a441 60%, #a9761b); display:flex; align-items:center; justify-content:center; color:#03251f; font-weight:900; font-size:15px; font-family:var(--font-display); flex-shrink:0; position:relative; overflow:hidden; box-shadow: inset 0 2px 2px rgba(255,255,255,0.6), inset 0 -2px 3px rgba(0,0,0,0.2), 0 3px 8px rgba(217,164,65,0.35); }
    .leader-avatar::before { content:''; position:absolute; top:4px; left:9px; width:13px; height:6px; border-radius:50%; background:rgba(255,255,255,0.65); filter:blur(1.5px); }

    .heatmap-bar-3d { flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; }
    .heatmap-inner-3d { width:100%; border-radius:8px 8px 0 0; background:linear-gradient(180deg, #fde68a, #f2c063 40%, #d9a441 80%, #a9761b); box-shadow: inset 0 2px 3px rgba(255,255,255,0.5), inset 0 -2px 3px rgba(0,0,0,0.2), 0 2px 6px rgba(217,164,65,0.3); position:relative; transition:transform 0.3s; }
    .heatmap-inner-3d:hover { transform:translateY(-4px); }
    .heatmap-inner-3d::before { content:''; position:absolute; top:4px; left:15%; width:30%; height:25%; border-radius:50%; background:rgba(255,255,255,0.4); filter:blur(1.5px); }

    .loc-pin-3d { width:48px; height:48px; border-radius:50% 50% 50% 0; transform:rotate(-45deg); background:radial-gradient(circle at 30% 30%, rgba(255,255,255,0.5), transparent 40%), linear-gradient(145deg, #f87171, #dc2626 60%, #991b1b); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow: inset 0 2px 3px rgba(255,255,255,0.5), inset 0 -3px 4px rgba(0,0,0,0.3), 0 6px 14px rgba(220,38,38,0.35); position:relative; }
    .loc-pin-3d span { transform:rotate(45deg); font-size:18px; }
    .loc-pin-3d::before { content:''; position:absolute; top:6px; left:10px; width:16px; height:7px; border-radius:50%; background:rgba(255,255,255,0.55); filter:blur(1.5px); transform:rotate(45deg); }

    .partner-chip-3d { display:inline-flex; align-items:center; gap:8px; padding:8px 16px; border-radius:999px; background:var(--white); border:1px solid var(--border); font-size:13px; font-weight:700; color:var(--ink); box-shadow: inset 0 1px 1px rgba(255,255,255,0.9), 0 4px 12px rgba(0,0,0,0.06); transition:all 0.25s; }
    .partner-chip-3d:hover { transform:translateY(-2px); box-shadow:0 8px 18px rgba(5,150,105,0.15); border-color:rgba(5,150,105,0.3); }
    .partner-dot { width:10px; height:10px; border-radius:50%; background:radial-gradient(circle at 30% 30%, #60a5fa, #1d4ed8); box-shadow:0 0 6px rgba(59,130,246,0.5); }

    .progress-3d { height:14px; border-radius:999px; background:rgba(5,150,105,0.08); overflow:hidden; position:relative; box-shadow: inset 0 1px 2px rgba(0,0,0,0.08); }
    .progress-fill-3d { height:100%; border-radius:999px; background:linear-gradient(145deg, #fde68a, #f2c063 40%, #d9a441 80%, #a9761b); position:relative; overflow:hidden; box-shadow: inset 0 1px 2px rgba(255,255,255,0.6), inset 0 -1px 2px rgba(0,0,0,0.15), 0 2px 6px rgba(217,164,65,0.3); }
    .progress-fill-3d::before { content:''; position:absolute; top:1px; left:4px; right:4px; height:40%; border-radius:999px; background:linear-gradient(180deg, rgba(255,255,255,0.5), transparent); }
    .progress-fill-3d::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg, transparent, rgba(255,255,255,0.5), transparent); animation:csShine 3s ease-in-out infinite; }

    .impact-sphere-3d { position:relative; padding:44px 36px; background:linear-gradient(135deg, #043b2c 0%, #065f46 55%, #059669 100%); color:white; border-radius:28px; text-align:center; box-shadow:0 24px 60px rgba(0,0,0,0.4); overflow:hidden; }
    .impact-sphere-3d::before { content:''; position:absolute; top:-50%; right:-10%; width:400px; height:400px; border-radius:50%; background:radial-gradient(circle, rgba(217,164,65,0.3), transparent 70%); pointer-events:none; }
    .impact-sphere-3d::after { content:''; position:absolute; bottom:-40%; left:-10%; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle, rgba(110,231,183,0.25), transparent 70%); pointer-events:none; }
    .impact-num-3d { font-family:var(--font-display); font-size:clamp(56px, 10vw, 88px); font-weight:900; line-height:1; background:linear-gradient(135deg, #fde68a 0%, #f2c063 40%, #d9a441 70%, #a9761b); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; animation:csGlow 3s ease-in-out infinite; position:relative; z-index:1; }

    .mod-3d { position:relative; padding:24px; background:var(--white); border:1px solid var(--border); border-radius:22px; overflow:hidden; transition:all 0.35s cubic-bezier(0.16,1,0.3,1); box-shadow:0 4px 14px rgba(0,0,0,0.05); }
    .mod-3d::after { content:''; position:absolute; bottom:0; right:0; width:120px; height:120px; border-radius:50%; background:radial-gradient(circle, rgba(217,164,65,0.06), transparent 70%); pointer-events:none; }
    .mod-3d:hover { transform:translateY(-6px); box-shadow:0 18px 36px rgba(5,150,105,0.18); border-color:rgba(5,150,105,0.3); }
    .mod-type-badge { display:inline-flex; align-items:center; gap:6px; padding:4px 11px; border-radius:999px; font-size:11px; font-weight:800; background:linear-gradient(145deg, #fde68a, #d9a441); color:#03251f; box-shadow: inset 0 1px 2px rgba(255,255,255,0.7), inset 0 -2px 3px rgba(0,0,0,0.2), 0 3px 8px rgba(217,164,65,0.35); }

    .cs-cta-3d { position:relative; display:inline-flex; align-items:center; gap:8px; padding:13px 24px; border-radius:13px; font-weight:700; font-size:14px; overflow:hidden; transition:transform 0.3s; text-decoration:none; }
    .cs-cta-3d::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg, transparent, rgba(255,255,255,0.5), transparent); animation:csShine 3s ease-in-out infinite; }
    .cs-cta-primary { background:linear-gradient(145deg, #fde68a, #d9a441); color:#03251f; box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -2px 3px rgba(0,0,0,0.15), 0 8px 20px rgba(217,164,65,0.4); }
    .cs-cta-ghost { background:transparent; color:#fff; border:2px solid rgba(255,255,255,0.35); }
    .cs-cta-3d:hover { transform:translateY(-3px); }
</style>

<!-- ================= HERO 3D ================= -->
<section class="news-hero" style="position:relative; overflow:hidden;">
    <div class="cs-orb cs-orb-1"></div>
    <div class="cs-orb cs-orb-2"></div>

    <span class="hero-chip c1" style="z-index:2;">🤝 Dharma Ketiga</span>
    <span class="hero-chip c2" style="z-index:2;">🏡 Desa Binaan</span>

    <span class="eyebrow eyebrow-light" style="z-index:2;">Dharma Ketiga</span>
    <h1 style="z-index:2;">Pengabdian & <span class="gold-text">KKN</span></h1>
    <p style="z-index:2;">Program pengabdian kepada masyarakat, KKN, dan desa binaan LP3M/LPPAIK UNIMOF.</p>
</section>

<!-- ================= QUOTE + DAMPAK 3D ================= -->
<section class="stats reveal">
    <div class="cs-quote-3d" style="grid-column: span 2;">
        <div class="cs-quote-mark">"</div>
        <div style="position:relative; z-index:1; display:flex; align-items:center; gap:18px; flex-wrap:wrap;">
            <div class="ico-cs ico-cs-lg ico-cs-gold"><?= $todayQuote[1] ?></div>
            <div style="flex:1; min-width:240px;">
                <p style="font-family:var(--font-display); font-size:16px; line-height:1.55; margin-bottom:8px; font-style:italic; color:#f2c063; font-weight:600;">
                    <?= $todayQuote[0] ?>
                </p>
                <p style="font-size:12px; opacity:0.7;">
                    📅 <?= date('d M Y') ?> · 🎯 <?= $thisYear ?> kegiatan tahun ini
                </p>
            </div>
        </div>
    </div>

    <div style="grid-column: span 2; position:relative; padding:28px; border-radius:22px; background:linear-gradient(145deg, #065f46, #043b2c); border:1px solid rgba(217,164,65,0.25); overflow:hidden; box-shadow: inset 0 1px 1px rgba(255,255,255,0.08), 0 10px 30px rgba(0,0,0,0.25);">
        <div style="position:absolute; top:-50%; right:-30%; width:200px; height:200px; border-radius:50%; background:radial-gradient(circle, rgba(217,164,65,0.2), transparent 70%);"></div>
        <p style="font-size:11px; letter-spacing:0.15em; color:#f2c063; font-weight:800; margin-bottom:14px; position:relative; z-index:1;">🌍 DAMPAK KAMI UNTUK INDONESIA</p>
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:10px; position:relative; z-index:1;">
            <div class="cs-mini-stat"><div class="cs-mini-num"><?= count($locations) ?></div><div style="font-size:10px; opacity:0.8; margin-top:4px; color:rgba(255,255,255,0.8);">📍 Lokasi</div></div>
            <div class="cs-mini-stat"><div class="cs-mini-num"><?= $totalMitra ?></div><div style="font-size:10px; opacity:0.8; margin-top:4px; color:rgba(255,255,255,0.8);">🤝 Mitra</div></div>
            <div class="cs-mini-stat"><div class="cs-mini-num"><?= $aikCount ?></div><div style="font-size:10px; opacity:0.8; margin-top:4px; color:rgba(255,255,255,0.8);">🕌 AIK</div></div>
        </div>
    </div>
</section>

<!-- ================= STATS COUNTER 3D ================= -->
<section class="stats">
    <div class="stat reveal stagger-1" style="position:relative; overflow:hidden;">
        <div style="position:absolute; top:-40px; right:-40px; width:140px; height:140px; border-radius:50%; background:radial-gradient(circle, rgba(217,164,65,0.2), transparent 70%);"></div>
        <div style="display:flex; align-items:center; gap:14px; position:relative; z-index:1;">
            <div class="ico-cs ico-cs-gold">🤝</div>
            <div><div class="cs-counter-3d" data-count="<?= (int) $cTotal ?>" data-suffix="+">0</div><div class="stat-label">Total Kegiatan</div></div>
        </div>
    </div>
    <div class="stat reveal stagger-2" style="position:relative; overflow:hidden;">
        <div style="position:absolute; top:-40px; right:-40px; width:140px; height:140px; border-radius:50%; background:radial-gradient(circle, rgba(16,185,129,0.2), transparent 70%);"></div>
        <div style="display:flex; align-items:center; gap:14px; position:relative; z-index:1;">
            <div class="ico-cs">👨‍🏫</div>
            <div><div class="cs-counter-3d" data-count="<?= (int) $cPengabdian ?>" data-suffix="+">0</div><div class="stat-label">Pengabdian Dosen</div></div>
        </div>
    </div>
    <div class="stat reveal stagger-3" style="position:relative; overflow:hidden;">
        <div style="position:absolute; top:-40px; right:-40px; width:140px; height:140px; border-radius:50%; background:radial-gradient(circle, rgba(59,130,246,0.2), transparent 70%);"></div>
        <div style="display:flex; align-items:center; gap:14px; position:relative; z-index:1;">
            <div class="ico-cs ico-cs-blue">🎓</div>
            <div><div class="cs-counter-3d" data-count="<?= (int) $cKkn ?>" data-suffix="+">0</div><div class="stat-label">KKN Mahasiswa</div></div>
        </div>
    </div>
    <div class="stat reveal stagger-4" style="position:relative; overflow:hidden;">
        <div style="position:absolute; top:-40px; right:-40px; width:140px; height:140px; border-radius:50%; background:radial-gradient(circle, rgba(124,58,237,0.2), transparent 70%);"></div>
        <div style="display:flex; align-items:center; gap:14px; position:relative; z-index:1;">
            <div class="ico-cs ico-cs-purple">🏡</div>
            <div><div class="cs-counter-3d" data-count="<?= (int) $cDesa ?>" data-suffix="+">0</div><div class="stat-label">Desa Binaan</div></div>
        </div>
    </div>
    <div class="stat reveal stagger-5" style="position:relative; overflow:hidden;">
        <div style="position:absolute; top:-40px; right:-40px; width:140px; height:140px; border-radius:50%; background:radial-gradient(circle, rgba(220,38,38,0.2), transparent 70%);"></div>
        <div style="display:flex; align-items:center; gap:14px; position:relative; z-index:1;">
            <div class="ico-cs ico-cs-red">📅</div>
            <div><div class="cs-counter-3d" data-count="<?= $thisYear ?>">0</div><div class="stat-label">Kegiatan <?= date('Y') ?></div></div>
        </div>
    </div>
</section>

<!-- ================= MARQUEE ================= -->
<div class="marquee" aria-hidden="true">
    <div class="marquee-track">
        <?php foreach (array_merge($marqueeWords, $marqueeWords) as $m): ?>
            <span class="marquee-item"><?= e($m) ?></span>
        <?php endforeach; ?>
    </div>
</div>

<!-- ================= SDGs 3D ================= -->
<section class="section reveal">
    <div class="section-head">
        <h2>🎯 Kontribusi untuk SDGs</h2>
        <span class="chip">Sustainable Development Goals</span>
    </div>
    <div class="grid" style="grid-template-columns: repeat(<?= count($sdgsSelected) ?>, 1fr);">
        <?php foreach ($sdgsSelected as $sdg): ?>
            <div class="sdg-card-3d reveal">
                <div style="display:flex; justify-content:center; margin-bottom:12px;">
                    <div class="ico-cs ico-cs-lg"><?= $sdg[0] ?></div>
                </div>
                <h3 style="font-size:16px; margin-bottom:6px;"><?= e($sdg[1]) ?></h3>
                <p style="font-size:12px;"><?= e($sdg[2]) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ================= TOP KETUA 3D ================= -->
<?php if ($topLeaders !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>👨‍🔬 Top Ketua Pelaksana</h2>
        <span class="chip">Dosen paling aktif mengabdi</span>
    </div>
    <div style="display:flex; flex-direction:column; gap:10px;">
        <?php
        $rankClasses = ['lr-gold', 'lr-silver', 'lr-bronze', 'lr-emerald', 'lr-emerald'];
        foreach ($topLeaders as $idx => $l):
            $rc = $rankClasses[$idx] ?? 'lr-emerald';
            $initial = strtoupper(substr(trim($l['leader']), 0, 1));
        ?>
            <div class="leader-row-3d reveal">
                <div class="leader-rank <?= $rc ?>">
                    <?= $idx === 0 ? '👑' : ($idx + 1) ?>
                </div>
                <div class="leader-avatar"><?= e($initial) ?></div>
                <div style="flex:1; min-width:0;">
                    <h3 style="color:var(--ink); font-size:15px; font-weight:800; margin:0 0 4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        <?= e($l['leader']) ?>
                    </h3>
                    <div style="display:flex; gap:8px; font-size:12px; color:var(--muted);">
                        <span>🤝 <strong style="color:var(--primary-dark);"><?= (int) $l['cnt'] ?></strong> kegiatan</span>
                        <?php if ($idx === 0): ?>
                            <span class="mod-type-badge">⭐ TOP CHAMPION</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div style="flex-shrink:0; font-family:var(--font-display); font-weight:900; font-size:24px; color:var(--gold-strong);">
                    #<?= $idx + 1 ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= HEATMAP 3D ================= -->
<?php if ($yearTimeline !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>📅 Heatmap Tahun Kegiatan</h2>
    </div>
    <?php $maxCnt = max(1, max(array_column($yearTimeline, 'cnt'))); ?>
    <div style="background:var(--white); border:1px solid var(--border); border-radius:22px; padding:26px; margin-bottom:16px; box-shadow:0 6px 20px rgba(0,0,0,0.04);">
        <div style="display:flex; align-items:flex-end; gap:10px; height:180px;">
            <?php foreach (array_reverse($yearTimeline) as $y):
                $h = max(12, (int)(($y['cnt']/$maxCnt)*130));
            ?>
                <div class="heatmap-bar-3d" title="<?= (int)$y['cnt'] ?> kegiatan">
                    <span style="font-size:11px; font-weight:800; color:var(--primary-dark);"><?= (int)$y['cnt'] ?></span>
                    <div class="heatmap-inner-3d" style="height:<?= $h ?>px;"></div>
                    <span style="font-size:10px; color:var(--muted); font-weight:600;"><?= (int)$y['year'] ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================= LOKASI 3D ================= -->
<?php if ($locations !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>📍 Jejak Lokasi Pengabdian</h2>
        <span class="chip"><?= count($locations) ?> titik</span>
    </div>
    <div style="display:flex; flex-direction:column; gap:10px;">
        <?php foreach ($locations as $idx => $loc): ?>
            <div class="leader-row-3d reveal">
                <div class="loc-pin-3d"><span>📍</span></div>
                <div style="flex:1; min-width:0;">
                    <h3 style="color:var(--ink); font-size:15px; font-weight:800; margin:0 0 4px;"><?= e($loc['location']) ?></h3>
                    <div style="font-size:12px; color:var(--muted);">🗺️ <strong style="color:var(--primary-dark);"><?= (int)$loc['cnt'] ?></strong> kegiatan</div>
                </div>
                <?php if ($idx === 0): ?>
                    <span class="mod-type-badge">🏆 TOP LOKASI</span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= MITRA 3D ================= -->
<?php if ($partners !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>🤝 Mitra Kami</h2>
        <span class="chip"><?= $totalMitra ?> mitra aktif</span>
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <?php foreach ($partners as $p): ?>
            <span class="partner-chip-3d">
                <span class="partner-dot"></span>
                <?= e($p['partner']) ?>
                <span style="opacity:0.5;">·</span>
                <strong><?= (int)$p['cnt'] ?></strong>
            </span>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= PROGRESS AIK 3D ================= -->
<?php if ($cTotal > 0): 
    $aikPct = round(($aikCount/$cTotal)*100);
?>
<section class="section reveal">
    <div class="section-head">
        <h2>🕌 Tingkat Integrasi AIK</h2>
    </div>
    <div style="background:var(--white); border:1px solid var(--border); border-radius:22px; padding:26px; box-shadow:0 6px 20px rgba(0,0,0,0.04);">
        <div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:13.5px; align-items:center;">
            <span style="font-weight:800; color:var(--ink);">🕌 Kegiatan dengan integrasi AIK</span>
            <span style="color:var(--muted); font-weight:600;"><strong style="color:var(--primary-dark);"><?= $aikCount ?></strong> dari <?= $cTotal ?> (<?= $aikPct ?>%)</span>
        </div>
        <div class="progress-3d">
            <div class="progress-fill-3d" style="width:<?= $aikPct ?>%;"></div>
        </div>
        <p style="margin-top:14px; font-size:13px; color:var(--muted); line-height:1.6;">
            Setiap kegiatan pengabdian dan KKN diupayakan mengintegrasikan nilai Al-Islam dan Kemuhammadiyahan.
        </p>
    </div>
</section>
<?php endif; ?>

<!-- ================= FILTER ================= -->
<div class="news-filter">
    <a href="<?= e(url('public/index.php?page=pengabdian')) ?>" class="chip <?= $currentType === '' ? 'active' : '' ?>">Semua</a>
    <?php foreach (CommunityService::TYPES as $key => $label): ?>
        <a href="<?= e(url('public/index.php?page=pengabdian&type=' . $key)) ?>" class="chip <?= $currentType === $key ? 'active' : '' ?>"><?= e($label) ?></a>
    <?php endforeach; ?>
</div>

<?php if ($items === []): ?>
    <p class="news-empty">Belum ada data yang dipublikasikan.</p>
<?php else: ?>
    <p class="filter-count">Menampilkan <?= count($items) ?> dari <?= $cTotal ?> kegiatan.</p>
    <div class="mod-grid">
        <?php foreach ($items as $item): ?>
            <div class="mod-3d reveal">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                    <div class="ico-cs" style="width:44px; height:44px; border-radius:13px; font-size:20px;">
                        <?= $typeIcons[$item['type']] ?? '🤝' ?>
                    </div>
                    <div style="display:flex; gap:6px; flex-wrap:wrap;">
                        <span class="mod-type-badge"><?= e(CommunityService::TYPES[$item['type']] ?? $item['type']) ?></span>
                        <span style="font-size:11px; color:var(--muted); font-weight:700;">📅 <?= (int)$item['year'] ?></span>
                        <?php if (!empty($item['aik_integration'])): ?>
                            <span class="mod-type-badge" style="background:linear-gradient(145deg, #c4b5fd, #7c3aed); color:#fff;">🕌 AIK</span>
                        <?php endif; ?>
                    </div>
                </div>
                <h3 style="font-size:16px; margin-bottom:10px;"><?= e($item['title']) ?></h3>
                <div style="display:flex; flex-direction:column; gap:6px; font-size:12.5px; color:var(--muted);">
                    <span>👤 <b>Ketua:</b> <?= e($item['leader']) ?></span>
                    <span>📍 <b>Lokasi:</b> <?= e($item['location']) ?></span>
                    <?php if (!empty($item['partner'])): ?><span>🤝 <b>Mitra:</b> <?= e($item['partner']) ?></span><?php endif; ?>
                    <?php if (!empty($item['members'])): ?><span>👥 <b>Tim:</b> <?= e(excerpt($item['members'], 70)) ?></span><?php endif; ?>
                    <?php if (!empty($item['aik_integration'])): ?><span>🕌 <b>AIK:</b> <?= e($item['aik_integration']) ?></span><?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if ($totalPages > 1): ?>
    <div class="pagination" style="display:flex; gap:6px; flex-wrap:wrap; margin-top:22px;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= e(url('public/index.php?page=pengabdian&hal=' . $i . ($currentType !== '' ? '&type=' . urlencode($currentType) : ''))) ?>" class="chip <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

<!-- ================= IMPACT SPHERE 3D ================= -->
<section class="section reveal">
    <div class="section-head"><h2>💫 Dampak Kami untuk Masyarakat</h2></div>
    <div class="impact-sphere-3d">
        <div style="position:relative; z-index:1;">
            <p style="font-size:12px; font-weight:900; letter-spacing:0.2em; opacity:0.8; margin-bottom:12px;">TOTAL KARYA PENGABDIAN</p>
            <div class="impact-num-3d"><?= number_format($cTotal) ?>+</div>
            <p style="font-size:15px; opacity:0.9; max-width:520px; margin:12px auto 0; line-height:1.6;">
                Kegiatan pengabdian telah dilaksanakan di <strong><?= count($locations) ?>+ lokasi</strong>
                dengan <strong><?= $totalMitra ?>+ mitra</strong> dan <strong><?= $thisYear ?> kegiatan</strong> tahun ini.
            </p>
        </div>
    </div>
</section>

<!-- ================= CTA 3D ================= -->
<section class="cta-band reveal">
    <div>
        <h3>Karya dosen kami terdokumentasi</h3>
        <p>Lihat publikasi ilmiah dan HAKI yang lahir dari kegiatan pengabdian masyarakat.</p>
    </div>
    <div class="cta-actions">
        <a href="<?= e(url('public/index.php?page=publikasi')) ?>" class="cs-cta-3d cs-cta-primary">📚 Publikasi & HAKI</a>
        <a href="<?= e(url('public/index.php?page=aik')) ?>" class="cs-cta-3d cs-cta-ghost">🕌 Kegiatan AIK</a>
    </div>
</section>