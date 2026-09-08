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
    foreach ($pdo->query('SELECT "📰" as icon, title, "Berita" as type, created_at as date FROM news WHERE status="published" ORDER BY created_at DESC LIMIT 3')->fetchAll() as $f) $liveFeed[] = $f;
    foreach ($pdo->query('SELECT "📚" as icon, title, "Publikasi" as type, created_at as date FROM publications WHERE status="published" ORDER BY created_at DESC LIMIT 3')->fetchAll() as $f) $liveFeed[] = $f;
    foreach ($pdo->query('SELECT "🕌" as icon, title, "Kegiatan AIK" as type, created_at as date FROM aik_activities WHERE status="published" ORDER BY created_at DESC LIMIT 3')->fetchAll() as $f) $liveFeed[] = $f;
    foreach ($pdo->query('SELECT "🤝" as icon, title, "Pengabdian" as type, created_at as date FROM community_services WHERE status="published" ORDER BY created_at DESC LIMIT 3')->fetchAll() as $f) $liveFeed[] = $f;
    usort($liveFeed, fn($a, $b) => strtotime($b['date']) <=> strtotime($a['date']));
    $liveFeed = array_slice($liveFeed, 0, 6);
} catch (\Throwable $e) { $liveFeed = []; }

// 🆕 SLIDER IMAGES dari Galeri
$slides = [];
try {
    $pdo = Database::pdo();
    try {
        $slides = $pdo->query("SELECT image_path, title FROM galleries WHERE status='published' ORDER BY id DESC LIMIT 5")->fetchAll();
    } catch (\Throwable $e) {
        $slides = $pdo->query("SELECT image_path, title FROM galleries ORDER BY id DESC LIMIT 5")->fetchAll();
    }
} catch (\Throwable $e) { $slides = []; }

// 🆕 AGENDA MENDATANG
$upEvents = [];
try {
    $upEvents = Database::pdo()->query("SELECT title, start_date, location, event_type FROM events WHERE status='published' AND start_date >= CURDATE() ORDER BY start_date ASC LIMIT 3")->fetchAll();
} catch (\Throwable $e) { $upEvents = []; }

// QUOTE
$quotes = [
    ['"Sebaik-baik manusia adalah yang paling bermanfaat bagi manusia." — HR. Ahmad', '🤝'],
    ['"Ilmu tanpa amal seperti pohon tanpa buah." — Pepatah Arab', '📖'],
    ['"Fastabiqul Khairat — berlomba-lombalah dalam kebaikan." — QS. Al-Baqarah: 148', '🏃'],
    ['"Riset adalah melihat apa yang dilihat semua orang dan memikirkan apa yang tidak dipikirkan siapapun." — Szent-Györgyi', '🔬'],
];
$todayQuote = $quotes[date('z') % count($quotes)];

$hijriMonths = ['Muharram','Safar','Rabiul Awal','Rabiul Akhir','Jumadil Awal','Jumadil Akhir','Rajab','Syaban','Ramadhan','Syawal','Zulkaidah','Zulhijjah'];
$currentHijriMonth = $hijriMonths[((int) date('n') + 5) % 12];

$quickAccess = [
    ['📰', 'Berita', 'Info & pengumuman terbaru', 'berita'],
    ['📁', 'Unduhan', 'Dokumen & template resmi', 'unduhan'],
    ['🤝', 'Pengabdian', 'KKN & desa binaan', 'pengabdian'],
    ['📚', 'Publikasi', 'Jurnal & karya ilmiah', 'publikasi'],
    ['🛡️', 'HAKI', 'Paten & hak cipta', 'publikasi'],
    ['🕌', 'AIK', 'Al-Islam & Kemuhammadiyahan', 'aik'],
];

$marqueeItems = ['Penelitian', 'Pengabdian', 'Publikasi Ilmiah', 'HAKI', 'Al-Islam & Kemuhammadiyahan', 'KKN', 'Desa Binaan', 'Catur Dharma', 'Fastabiqul Khairat', 'Berkemajuan'];
$icons = ['🔬', '', '', '🕌'];
$slideCount = max(3, count($slides));
?>

<style>
    /* ============ ICON ORBS ============ */
    .ico-3d { display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; border-radius: 18px; font-size: 26px; background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #34d399, #10b981 50%, #059669); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(5,150,105,0.35); position: relative; overflow: hidden; }
    .ico-3d::before { content: ''; position: absolute; top: 6px; left: 10px; width: 18px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.6); filter: blur(2px); }
    .ico-3d-lg { width: 72px; height: 72px; border-radius: 22px; font-size: 34px; }
    .ico-3d-sm { width: 44px; height: 44px; border-radius: 14px; font-size: 20px; }
    .ico-3d-gold { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%), linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441); box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -3px 4px rgba(0,0,0,0.2), 0 6px 16px rgba(217,164,65,0.4); }
    .ico-3d-blue { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #60a5fa, #3b82f6 50%, #1d4ed8); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(59,130,246,0.35); }
    .ico-3d-purple { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #c4b5fd, #a78bfa 50%, #7c3aed); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(124,58,237,0.35); }

    /* ============ 🆕 HERO SLIDER SINEMATIK ============ */
    @keyframes hxKb { from { transform: scale(1.02); } to { transform: scale(1.14); } }
    @keyframes hxUp { from { opacity: 0; transform: translateY(26px); } to { opacity: 1; transform: none; } }
    @keyframes hxPulse { 0%,100% { box-shadow: 0 0 0 0 rgba(110,231,183,.6); } 50% { box-shadow: 0 0 0 9px rgba(110,231,183,0); } }
    .hx-hero { position: relative; overflow: hidden; border-radius: 30px; min-height: 580px; margin-bottom: 30px; box-shadow: 0 30px 70px rgba(3,37,31,.35); }
    .hx-slide { position: absolute; inset: 0; background-size: cover; background-position: center; opacity: 0; transform: scale(1.06); transition: opacity 1.2s ease; }
    .hx-slide::after { content: ''; position: absolute; inset: 0; background-image: repeating-linear-gradient(45deg, transparent, transparent 34px, rgba(255,255,255,0.03) 34px, rgba(255,255,255,0.03) 35px), repeating-linear-gradient(-45deg, transparent, transparent 34px, rgba(255,255,255,0.03) 34px, rgba(255,255,255,0.03) 35px); }
    .hx-slide.active { opacity: 1; animation: hxKb 9s ease-out both; }
    .hx-fb-1 { background-image: linear-gradient(135deg, #043b2c 0%, #065f46 55%, #059669 100%); }
    .hx-fb-2 { background-image: linear-gradient(135deg, #0c1f4d 0%, #1e3a8a 55%, #3b82f6 100%); }
    .hx-fb-3 { background-image: linear-gradient(135deg, #3b2f0a 0%, #8a6f1a 55%, #d9a441 100%); }
    .hx-overlay { position: absolute; inset: 0; background: linear-gradient(115deg, rgba(2,26,20,.9) 0%, rgba(4,59,44,.72) 45%, rgba(4,59,44,.28) 75%, rgba(4,59,44,.15) 100%); }
    .hx-overlay::after { content: ''; position: absolute; left: 0; right: 0; bottom: 0; height: 140px; background: linear-gradient(180deg, transparent, rgba(2,26,20,.75)); }
    .hx-content { position: relative; z-index: 3; padding: 84px 52px 120px; max-width: 760px; color: #fff; }
    .hx-eyebrow { display: inline-flex; align-items: center; gap: 9px; padding: 6px 15px; border-radius: 999px; font-size: 10.5px; font-weight: 900; letter-spacing: .2em; text-transform: uppercase; background: rgba(253,230,138,.16); border: 1px solid rgba(253,230,138,.4); color: #fde68a; backdrop-filter: blur(6px); animation: hxUp .7s .1s both; }
    .hx-eyebrow i { width: 7px; height: 7px; border-radius: 50%; background: #fde68a; box-shadow: 0 0 8px rgba(253,230,138,.9); }
    .hx-content h1 { font-family: var(--font-display); font-size: clamp(32px, 5vw, 56px); font-weight: 900; letter-spacing: -0.03em; line-height: 1.06; margin: 18px 0 16px; animation: hxUp .7s .2s both; }
    .hx-content h1 em { font-style: normal; background: linear-gradient(135deg, #fde68a, #f2c063 60%, #d9a441); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
    .hx-content p { font-size: 16px; line-height: 1.7; opacity: .92; max-width: 620px; margin: 0 0 26px; animation: hxUp .7s .3s both; }
    .hx-actions { display: flex; gap: 12px; flex-wrap: wrap; animation: hxUp .7s .4s both; }
    .hx-chips { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 26px; animation: hxUp .7s .5s both; }
    .hx-chip { display: inline-flex; align-items: center; gap: 7px; padding: 7px 14px; border-radius: 999px; font-size: 11.5px; font-weight: 800; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.25); backdrop-filter: blur(8px); }
    .hx-live { position: absolute; z-index: 4; top: 24px; right: 24px; display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 999px; background: rgba(16,185,129,.25); border: 1px solid rgba(110,231,183,.4); color: #fff; font-size: 12px; font-weight: 800; backdrop-filter: blur(8px); }
    .hx-live i { width: 9px; height: 9px; border-radius: 50%; background: radial-gradient(circle at 30% 30%, #6ee7b7, #10b981); animation: hxPulse 2s infinite; }
    .hx-ui { position: absolute; z-index: 4; left: 52px; right: 52px; bottom: 26px; display: flex; align-items: center; gap: 14px; }
    .hx-btn { width: 42px; height: 42px; border-radius: 50%; border: 1px solid rgba(255,255,255,.3); background: rgba(255,255,255,.12); color: #fff; font-size: 18px; cursor: pointer; backdrop-filter: blur(8px); transition: all .25s; display: flex; align-items: center; justify-content: center; }
    .hx-btn:hover { background: rgba(253,230,138,.9); color: #03251f; border-color: transparent; transform: scale(1.08); }
    .hx-dots { display: flex; gap: 8px; flex: 1; justify-content: center; }
    .hx-dot { width: 10px; height: 10px; border-radius: 999px; border: none; background: rgba(255,255,255,.35); cursor: pointer; transition: all .35s; padding: 0; }
    .hx-dot.active { width: 34px; background: linear-gradient(90deg, #fde68a, #d9a441); box-shadow: 0 0 12px rgba(253,230,138,.6); }
    .hx-counter { font-family: var(--font-display); font-size: 13px; font-weight: 900; color: rgba(255,255,255,.85); letter-spacing: .1em; }
    .hx-counter b { color: #fde68a; font-size: 17px; }
    .hx-progress { position: absolute; z-index: 4; left: 0; right: 0; bottom: 0; height: 4px; background: rgba(255,255,255,.15); }
    .hx-progress i { display: block; height: 100%; width: 0; background: linear-gradient(90deg, #fde68a, #d9a441); }
    .hx-progress i.run { animation: hxBar 6.5s linear both; }
    @keyframes hxBar { from { width: 0; } to { width: 100%; } }
    @media (max-width: 760px) { .hx-hero { min-height: 520px; } .hx-content { padding: 60px 26px 110px; } .hx-ui { left: 26px; right: 26px; } .hx-live { top: 16px; right: 16px; } }

    /* ============ 🆕 AGENDA STRIP ============ */
    .agx-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    @media (max-width: 900px) { .agx-grid { grid-template-columns: 1fr; } }
    .agx-card { display: flex; gap: 14px; padding: 18px; border-radius: 18px; background: var(--surface); border: 1px solid var(--border); text-decoration: none; color: inherit; transition: all .3s cubic-bezier(.16,1,.3,1); }
    .agx-card:hover { transform: translateY(-4px); box-shadow: 0 14px 30px rgba(5,150,105,.16); border-color: rgba(5,150,105,.35); }
    .agx-date { width: 58px; height: 62px; border-radius: 14px; background: linear-gradient(145deg, #065f46, #043b2c); color: #fde68a; display: flex; flex-direction: column; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: inset 0 1px 2px rgba(255,255,255,.15), 0 6px 14px rgba(3,37,31,.3); }
    .agx-date b { font-family: var(--font-display); font-size: 21px; line-height: 1; }
    .agx-date span { font-size: 9px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; opacity: .85; margin-top: 3px; }
    .agx-in { flex: 1; min-width: 0; }
    .agx-in h4 { margin: 0 0 5px; font-size: 14px; font-weight: 800; color: var(--ink); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .agx-meta { font-size: 11.5px; color: var(--muted); display: flex; gap: 8px; flex-wrap: wrap; }
    .agx-days { margin-top: 8px; display: inline-flex; padding: 3px 10px; border-radius: 999px; font-size: 10px; font-weight: 900; background: rgba(234,88,12,.12); color: #c2410c; border: 1px solid rgba(234,88,12,.3); }

    /* ============ EXISTING HOME STYLES ============ */
    .stat-3d { position: relative; padding: 28px; border-radius: 22px; background: linear-gradient(145deg, #065f46, #043b2c); border: 1px solid rgba(217,164,65,0.25); overflow: hidden; box-shadow: inset 0 1px 1px rgba(255,255,255,0.08), 0 10px 30px rgba(0,0,0,0.25); }
    .stat-3d::before { content: ''; position: absolute; top: -50%; right: -30%; width: 200px; height: 200px; border-radius: 50%; background: radial-gradient(circle, rgba(217,164,65,0.2), transparent 70%); }
    .stat-3d-num { font-family: var(--font-display); font-size: 42px; font-weight: 900; background: linear-gradient(135deg, #fde68a, #f2c063 40%, #d9a441); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; line-height: 1; }
    .counter-3d { font-family: var(--font-display); font-size: 44px; font-weight: 900; line-height: 1; background: linear-gradient(135deg, #fde68a, #f2c063 40%, #d9a441); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
    .quote-3d { position: relative; padding: 28px; border-radius: 22px; background: linear-gradient(145deg, #065f46, #03251f); border: 1px solid rgba(217,164,65,0.25); overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
    .quote-3d::before { content: ''; position: absolute; top: -60%; right: -20%; width: 250px; height: 250px; border-radius: 50%; background: radial-gradient(circle, rgba(217,164,65,0.25), transparent 70%); }
    .quote-mark-3d { position: absolute; top: 10px; left: 14px; font-size: 80px; line-height: 1; color: rgba(217,164,65,0.15); font-family: Georgia, serif; }
    .featured-badge-3d { display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px; border-radius: 999px; font-size: 11px; font-weight: 800; letter-spacing: 0.12em; color: #03251f; background: linear-gradient(145deg, #fde68a, #d9a441); box-shadow: inset 0 1px 2px rgba(255,255,255,0.7), 0 4px 10px rgba(217,164,65,0.4); }
    .card-num-3d { position: absolute; top: 14px; right: 14px; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-family: var(--font-display); font-weight: 900; font-size: 15px; color: #03251f; background: linear-gradient(145deg, #fde68a, #d9a441); box-shadow: inset 0 1px 2px rgba(255,255,255,0.7), 0 3px 8px rgba(217,164,65,0.3); }
    .feed-3d { display: flex; align-items: center; gap: 14px; padding: 14px 18px; background: var(--surface); border: 1px solid var(--border); border-radius: 18px; transition: all 0.3s cubic-bezier(0.16,1,0.3,1); }
    .feed-3d:hover { transform: translateY(-3px); box-shadow: 0 10px 24px rgba(5,150,105,0.15); border-color: rgba(5,150,105,0.3); }
    .qa-3d { position: relative; padding: 28px 18px; background: var(--surface); border: 1px solid var(--border); border-radius: 22px; text-align: center; transition: all 0.35s cubic-bezier(0.16,1,0.3,1); overflow: hidden; display: block; }
    .qa-3d::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--gold), var(--primary)); transform: scaleX(0); transform-origin: left; transition: transform 0.4s ease; }
    .qa-3d:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(5,150,105,0.18); border-color: rgba(5,150,105,0.3); }
    .qa-3d:hover::before { transform: scaleX(1); }
    .qa-3d:hover .ico-3d { transform: scale(1.12) rotate(-5deg); }
    .impact-num-3d { font-family: var(--font-display); font-size: clamp(56px, 10vw, 88px); font-weight: 900; line-height: 1; background: linear-gradient(135deg, #fde68a 0%, #f2c063 40%, #d9a441 70%, #a9761b); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; display: inline-block; }
    .cta-3d { position: relative; display: inline-flex; align-items: center; gap: 8px; padding: 14px 26px; border-radius: 14px; font-weight: 700; font-size: 14.5px; overflow: hidden; transition: all 0.3s cubic-bezier(0.16,1,0.3,1); text-decoration: none; }
    .cta-3d-primary { background: linear-gradient(145deg, #fde68a, #d9a441); color: #03251f; box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), 0 8px 20px rgba(217,164,65,0.4); }
    .cta-3d-ghost { background: transparent; color: #fff; border: 2px solid rgba(255,255,255,0.35); }
    .cta-3d:hover { transform: translateY(-3px); }
    .live-mini { display: inline-flex; align-items: center; gap: 8px; padding: 6px 12px; border-radius: 999px; font-size: 11px; font-weight: 800; letter-spacing: 0.1em; background: rgba(16,185,129,0.15); border: 1px solid rgba(110,231,183,0.3); color: #6ee7b7; }
    .mini-stat-3d { padding: 14px; border-radius: 16px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); text-align: center; }
</style>

<!-- ============ 🆕 HERO SLIDER ============ -->
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

    <div class="hx-live"><i></i> LIVE · <?= number_format($totalKarya) ?>+ Karya</div>

    <div class="hx-content">
        <span class="hx-eyebrow"><i></i> LP3M · Catur Dharma</span>
        <h1><?= e($s['home_hero_title']) ?></h1>
        <p><?= e($s['home_hero_text']) ?></p>
        <div class="hx-actions">
            <a href="<?= e(url('public/index.php?page=tentang')) ?>" class="cta-3d cta-3d-primary"><?= e($s['home_hero_button_text']) ?></a>
            <a href="<?= e(url('public/index.php?page=publikasi')) ?>" class="cta-3d cta-3d-ghost">📚 Jelajahi Publikasi</a>
        </div>
        <div class="hx-chips">
            <span class="hx-chip">🔬 Penelitian</span>
            <span class="hx-chip">🤝 Pengabdian</span>
            <span class="hx-chip">📚 Publikasi</span>
            <span class="hx-chip">🕌 AIK</span>
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
        <div style="position: relative; z-index: 1; display: flex; align-items: center; gap: 18px;">
            <div class="ico-3d ico-3d-lg ico-3d-gold"><?= $todayQuote[1] ?></div>
            <div style="flex: 1;">
                <p style="font-size: 16px; line-height: 1.6; margin-bottom: 8px; font-style: italic; color: #f2c063; font-family: var(--font-display);"><?= $todayQuote[0] ?></p>
                <p style="font-size: 12px; opacity: 0.7; display: flex; align-items: center; gap: 8px;">📅 Bulan <?= $currentHijriMonth ?> · <?= date('d M Y') ?></p>
            </div>
        </div>
    </div>

    <div class="stat-3d stagger-2" style="grid-column: span 2;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; position: relative; z-index: 1;">
            <span style="font-size: 11px; letter-spacing: 0.15em; color: #f2c063; font-weight: 800;">🟢 STATUS LEMBAGA</span>
            <span class="live-mini"><span style="width:7px;height:7px;background:#6ee7b7;border-radius:50%;"></span> LIVE</span>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; position: relative; z-index: 1;">
            <div class="mini-stat-3d"><div class="stat-3d-num"><?= (int) $statBerita ?></div><div style="font-size: 10px; opacity: 0.8; margin-top: 4px; color: rgba(255,255,255,0.8);">📰 Berita</div></div>
            <div class="mini-stat-3d"><div class="stat-3d-num"><?= (int) $statDokumen ?></div><div style="font-size: 10px; opacity: 0.8; margin-top: 4px; color: rgba(255,255,255,0.8);">📁 Dokumen</div></div>
            <div class="mini-stat-3d"><div class="stat-3d-num"><?= number_format($totalKarya) ?></div><div style="font-size: 10px; opacity: 0.8; margin-top: 4px; color: rgba(255,255,255,0.8);">✨ Total</div></div>
        </div>
    </div>
</section>

<!-- STATS COUNTER -->
<section class="stats" aria-label="Statistik lembaga">
    <div class="stat reveal stagger-1"><div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;"><div class="ico-3d">🤝</div><div><div class="counter-3d" data-count="<?= (int) $statPengabdian ?>" data-suffix="+">0</div><div class="stat-label">Pengabdian & KKN</div></div></div></div>
    <div class="stat reveal stagger-2"><div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;"><div class="ico-3d ico-3d-gold">📚</div><div><div class="counter-3d" data-count="<?= (int) $statPublikasi ?>" data-suffix="+">0</div><div class="stat-label">Publikasi Ilmiah</div></div></div></div>
    <div class="stat reveal stagger-3"><div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;"><div class="ico-3d ico-3d-blue">🛡️</div><div><div class="counter-3d" data-count="<?= (int) $statHaki ?>" data-suffix="+">0</div><div class="stat-label">HAKI Terdaftar</div></div></div></div>
    <div class="stat reveal stagger-4"><div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;"><div class="ico-3d ico-3d-purple">🕌</div><div><div class="counter-3d" data-count="<?= (int) $statAik ?>" data-suffix="+">0</div><div class="stat-label">Kegiatan AIK</div></div></div></div>
</section>

<!-- 🆕 AGENDA MENDATANG -->
<?php if (!empty($upEvents)): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>📅 Agenda Mendatang</h2>
        <a class="btn-more" href="<?= e(url('public/index.php?page=agenda')) ?>">Lihat Semua →</a>
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
                    <span>📍 <?= e($ev['location'] ?: 'TBA') ?></span>
                    <span>🏷️ <?= e(ucfirst(str_replace('_', ' ', $ev['event_type']))) ?></span>
                </div>
                <span class="agx-days"><?= $daysLeft === 0 ? ' Hari ini!' : '⏳ ' . $daysLeft . ' hari lagi' ?></span>
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
        <div style="padding: 36px;">
            <span class="featured-badge-3d">🔥 SOROTAN TERBARU</span>
            <h2 style="font-size: clamp(22px, 3vw, 30px); font-weight: 800; margin: 16px 0; letter-spacing: -0.02em; line-height: 1.25;"><?= e($featured['title']) ?></h2>
            <p style="color: rgba(255,255,255,0.85); margin-bottom: 20px; line-height: 1.6;"><?= e(excerpt($featured['content'], 170)) ?></p>
            <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 22px; font-size: 12px; color: rgba(255,255,255,0.7); flex-wrap: wrap;">
                <span class="badge" style="background: rgba(217,164,65,0.3); color: #f2c063; border: 1px solid rgba(217,164,65,0.4);"><?= e(ucfirst($featured['category'])) ?></span>
                <span>📅 <?= e(date('d M Y', strtotime($featured['published_at'] ?? $featured['created_at']))) ?></span>
                <span>⏱️ <?= max(1, (int) round(str_word_count(strip_tags($featured['content'])) / 200)) ?> mnt</span>
            </div>
            <a class="cta-3d cta-3d-primary" href="<?= e(url('public/index.php?page=berita-detail&slug=' . urlencode($featured['slug']))) ?>">Baca Lengkap →</a>
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
    <div class="section-head"><h2><?= e($s['home_section_title']) ?></h2></div>
    <div class="grid">
        <?php for ($i = 1; $i <= 4; $i++): ?>
            <div class="card reveal stagger-<?= $i ?>">
                <div class="card-num-3d">0<?= $i ?></div>
                <div class="card-icon"><span class="ico-3d"><?= $icons[$i - 1] ?></span></div>
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
        <h2>⚡ Aktivitas Terbaru Lembaga</h2>
        <span class="live-mini"><span style="width:7px;height:7px;background:#6ee7b7;border-radius:50%;"></span> LIVE</span>
    </div>
    <div class="docs-list">
        <?php foreach ($liveFeed as $f): ?>
            <div class="feed-3d reveal">
                <div class="ico-3d ico-3d-sm"><?= $f['icon'] ?></div>
                <div style="flex: 1; min-width: 0;">
                    <h3 style="font-size: 15px; margin-bottom: 4px; color: var(--ink);"><?= e($f['title']) ?></h3>
                    <div style="display: flex; gap: 10px; font-size: 12px; color: var(--muted); flex-wrap: wrap;">
                        <span class="badge" style="font-size: 10px; padding: 2px 8px;"><?= e($f['type']) ?></span>
                        <span>📅 <?= e(date('d M Y', strtotime($f['date']))) ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- QUICK ACCESS -->
<section class="section section--teal">
    <div class="section-head"><h2>🚀 Akses Cepat</h2></div>
    <div class="grid" style="grid-template-columns: repeat(<?= min(count($quickAccess), 3) ?>, 1fr);">
        <?php foreach ($quickAccess as $idx => $qa): ?>
            <a href="<?= e(url('public/index.php?page=' . $qa[3])) ?>" class="qa-3d reveal stagger-<?= ($idx % 4) + 1 ?>">
                <div style="display: flex; justify-content: center; margin-bottom: 14px;"><div class="ico-3d ico-3d-lg"><?= $qa[0] ?></div></div>
                <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 4px;"><?= e($qa[1]) ?></h3>
                <p style="font-size: 13px; color: var(--muted);"><?= e($qa[2]) ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- BERITA TERBARU -->
<?php if (!empty($latest)): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>Berita Terbaru</h2>
        <a class="btn-more" href="<?= e(url('public/index.php?page=berita')) ?>">Lihat Semua →</a>
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
    <div style="background: linear-gradient(135deg, #043b2c 0%, #065f46 60%, #059669 100%); color: white; padding: 52px 44px; border-radius: 28px; text-align: center; box-shadow: 0 30px 70px rgba(0,0,0,0.4); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -80px; right: -60px; width: 260px; height: 260px; border-radius: 50%; background: radial-gradient(circle, rgba(217,164,65,0.3), transparent 70%);"></div>
        <div style="position: absolute; bottom: -80px; left: -40px; width: 200px; height: 200px; border-radius: 50%; background: radial-gradient(circle, rgba(110,231,183,0.25), transparent 70%);"></div>
        <div style="position: relative; z-index: 1;">
            <span class="featured-badge-3d" style="margin: 0 auto 16px;">✦ JEJAK KAMI</span>
            <div class="impact-num-3d"><?= number_format($totalKarya + $statBerita + $statDokumen) ?>+</div>
            <p style="font-size: 17px; opacity: 0.9; max-width: 540px; margin: 12px auto 0; line-height: 1.6;">Karya ilmiah, pengabdian, HAKI, kegiatan AIK, berita, dan dokumen yang telah kami dokumentasikan.</p>
            <div style="margin-top: 30px; display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
                <a href="<?= e(url('public/index.php?page=publikasi')) ?>" class="cta-3d cta-3d-primary">📚 Jelajahi Publikasi</a>
                <a href="<?= e(url('public/index.php?page=pengabdian')) ?>" class="cta-3d cta-3d-ghost">🤝 Lihat Pengabdian</a>
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
        <a href="<?= e(url('public/index.php?page=unduhan')) ?>" class="cta-3d cta-3d-primary">📁 Dokumen & Unduhan</a>
        <a href="<?= e(url('public/index.php?page=pengabdian')) ?>" class="cta-3d cta-3d-ghost">🤝 Pengabdian & KKN</a>
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