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

// LIVE ACTIVITY FEED
$liveFeed = [];
$feedNews = Database::pdo()->query('SELECT "📰" as icon, title, "Berita" as type, created_at as date FROM news WHERE status = "published" ORDER BY created_at DESC LIMIT 3')->fetchAll();
foreach ($feedNews as $f) $liveFeed[] = $f;
$feedPub = Database::pdo()->query('SELECT "📚" as icon, title, "Publikasi" as type, created_at as date FROM publications WHERE status = "published" ORDER BY created_at DESC LIMIT 3')->fetchAll();
foreach ($feedPub as $f) $liveFeed[] = $f;
$feedAik = Database::pdo()->query('SELECT "🕌" as icon, title, "Kegiatan AIK" as type, created_at as date FROM aik_activities WHERE status = "published" ORDER BY created_at DESC LIMIT 3')->fetchAll();
foreach ($feedAik as $f) $liveFeed[] = $f;
$feedCs = Database::pdo()->query('SELECT "🤝" as icon, title, "Pengabdian" as type, created_at as date FROM community_services WHERE status = "published" ORDER BY created_at DESC LIMIT 3')->fetchAll();
foreach ($feedCs as $f) $liveFeed[] = $f;
usort($liveFeed, fn($a, $b) => strtotime($b['date']) <=> strtotime($a['date']));
$liveFeed = array_slice($liveFeed, 0, 6);

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

$marqueeItems = [
    'Penelitian', 'Pengabdian', 'Publikasi Ilmiah', 'HAKI',
    'Al-Islam & Kemuhammadiyahan', 'KKN', 'Desa Binaan', 'Catur Dharma',
    'Fastabiqul Khairat', 'Berkemajuan',
];

$icons = ['🔬', '🤝', '📚', '🕌'];
?>

<style>
    /* 3D icon orbs untuk CARD (bukan navbar) */
    .ico-3d {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 56px; height: 56px;
        border-radius: 18px;
        font-size: 26px;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #34d399, #10b981 50%, #059669);
        box-shadow:
            inset 0 2px 3px rgba(255,255,255,0.6),
            inset 0 -3px 4px rgba(0,0,0,0.25),
            0 6px 16px rgba(5,150,105,0.35);
        position: relative;
        overflow: hidden;
    }
    .ico-3d::before {
        content: '';
        position: absolute;
        top: 6px; left: 10px;
        width: 18px; height: 8px;
        border-radius: 50%;
        background: rgba(255,255,255,0.6);
        filter: blur(2px);
    }
    .ico-3d-lg { width: 72px; height: 72px; border-radius: 22px; font-size: 34px; }
    .ico-3d-sm { width: 44px; height: 44px; border-radius: 14px; font-size: 20px; }
    .ico-3d-gold {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%),
                    linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -3px 4px rgba(0,0,0,0.2), 0 6px 16px rgba(217,164,65,0.4);
    }
    .ico-3d-blue {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #60a5fa, #3b82f6 50%, #1d4ed8);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(59,130,246,0.35);
    }
    .ico-3d-purple {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #c4b5fd, #a78bfa 50%, #7c3aed);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(124,58,237,0.35);
    }

    /* Stat 3D */
    .stat-3d {
        position: relative;
        padding: 28px;
        border-radius: 22px;
        background: linear-gradient(145deg, #065f46, #043b2c);
        border: 1px solid rgba(217,164,65,0.25);
        overflow: hidden;
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.08), 0 10px 30px rgba(0,0,0,0.25);
    }
    .stat-3d::before {
        content: '';
        position: absolute;
        top: -50%; right: -30%;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,0.2), transparent 70%);
    }
    .stat-3d-num {
        font-family: var(--font-display);
        font-size: 42px; font-weight: 900;
        background: linear-gradient(135deg, #fde68a, #f2c063 40%, #d9a441);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1;
    }

    .counter-3d {
        font-family: var(--font-display);
        font-size: 44px; font-weight: 900;
        line-height: 1;
        background: linear-gradient(135deg, #fde68a, #f2c063 40%, #d9a441);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .quote-3d {
        position: relative;
        padding: 28px;
        border-radius: 22px;
        background: linear-gradient(145deg, #065f46, #03251f);
        border: 1px solid rgba(217,164,65,0.25);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .quote-3d::before {
        content: '';
        position: absolute;
        top: -60%; right: -20%;
        width: 250px; height: 250px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,0.25), transparent 70%);
    }
    .quote-mark-3d {
        position: absolute;
        top: 10px; left: 14px;
        font-size: 80px; line-height: 1;
        color: rgba(217,164,65,0.15);
        font-family: Georgia, serif;
    }

    .featured-badge-3d {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 11px; font-weight: 800;
        letter-spacing: 0.12em;
        color: #03251f;
        background: linear-gradient(145deg, #fde68a, #d9a441);
        box-shadow: inset 0 1px 2px rgba(255,255,255,0.7), 0 4px 10px rgba(217,164,65,0.4);
    }

    .card-num-3d {
        position: absolute;
        top: 14px; right: 14px;
        width: 40px; height: 40px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display);
        font-weight: 900; font-size: 15px;
        color: #03251f;
        background: linear-gradient(145deg, #fde68a, #d9a441);
        box-shadow: inset 0 1px 2px rgba(255,255,255,0.7), 0 3px 8px rgba(217,164,65,0.3);
    }

    .feed-3d {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 18px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 18px;
        transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
    }
    .feed-3d:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(5,150,105,0.15);
        border-color: rgba(5,150,105,0.3);
    }

    .qa-3d {
        position: relative;
        padding: 28px 18px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 22px;
        text-align: center;
        transition: all 0.35s cubic-bezier(0.16,1,0.3,1);
        overflow: hidden;
        display: block;
    }
    .qa-3d::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--gold), var(--primary));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }
    .qa-3d:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(5,150,105,0.18);
        border-color: rgba(5,150,105,0.3);
    }
    .qa-3d:hover::before { transform: scaleX(1); }
    .qa-3d:hover .ico-3d { transform: scale(1.12) rotate(-5deg); }

    .impact-num-3d {
        font-family: var(--font-display);
        font-size: clamp(56px, 10vw, 88px);
        font-weight: 900; line-height: 1;
        background: linear-gradient(135deg, #fde68a 0%, #f2c063 40%, #d9a441 70%, #a9761b);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .cta-3d {
        position: relative;
        display: inline-flex; align-items: center; gap: 8px;
        padding: 14px 26px;
        border-radius: 14px;
        font-weight: 700; font-size: 14.5px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
    }
    .cta-3d-primary {
        background: linear-gradient(145deg, #fde68a, #d9a441);
        color: #03251f;
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), 0 8px 20px rgba(217,164,65,0.4);
    }
    .cta-3d-ghost {
        background: transparent;
        color: #fff;
        border: 2px solid rgba(255,255,255,0.35);
    }
    .cta-3d:hover { transform: translateY(-3px); }

    .live-mini {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 11px; font-weight: 800;
        letter-spacing: 0.1em;
        background: rgba(16,185,129,0.15);
        border: 1px solid rgba(110,231,183,0.3);
        color: #6ee7b7;
    }

    .mini-stat-3d {
        padding: 14px;
        border-radius: 16px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        text-align: center;
    }

    .ticker-3d {
        position: absolute;
        bottom: 20px; right: 20px;
        padding: 8px 16px;
        border-radius: 999px;
        background: rgba(16,185,129,0.25);
        border: 1px solid rgba(110,231,183,0.3);
        color: #fff;
        font-size: 12px; font-weight: 700;
        display: inline-flex; align-items: center; gap: 8px;
    }
    .ticker-dot-3d {
        width: 9px; height: 9px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #6ee7b7, #10b981);
        animation: livePulse3D 2s infinite;
    }

    @keyframes livePulse3D {
        0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(16,185,129,0.7); }
        50%      { transform: scale(1.25); box-shadow: 0 0 0 8px rgba(16,185,129,0); }
    }
</style>

<!-- HERO -->
<section class="hero" style="position: relative; overflow: hidden;">
    <span class="hero-chip c1" style="z-index: 2;">✦ Catur Dharma</span>
    <span class="hero-chip c2" style="z-index: 2;">🕌 Berkemajuan</span>
    <span class="eyebrow eyebrow-light" style="z-index: 2;">LP3M</span>

    <h1 style="z-index: 2;"><?= e($s['home_hero_title']) ?></h1>
    <p style="z-index: 2;"><?= e($s['home_hero_text']) ?></p>

    <div class="hero-actions" style="z-index: 2;">
        <a href="<?= e(url('public/index.php?page=tentang')) ?>" class="cta-3d cta-3d-primary"><?= e($s['home_hero_button_text']) ?></a>
        <a href="<?= e(url('public/index.php?page=publikasi')) ?>" class="cta-3d cta-3d-ghost">📚 Jelajahi Publikasi</a>
    </div>

    <div class="ticker-3d" style="z-index: 2;">
        <span class="ticker-dot-3d"></span>
        <span>LIVE</span>
        <span style="opacity: 0.6;">·</span>
        <span><?= number_format($totalKarya) ?>+ Karya</span>
    </div>
</section>

<!-- QUOTE + STATUS -->
<section class="stats reveal">
    <div class="quote-3d" style="grid-column: span 2;">
        <div class="quote-mark-3d">"</div>
        <div style="position: relative; z-index: 1; display: flex; align-items: center; gap: 18px;">
            <div class="ico-3d ico-3d-lg ico-3d-gold"><?= $todayQuote[1] ?></div>
            <div style="flex: 1;">
                <p style="font-size: 16px; line-height: 1.6; margin-bottom: 8px; font-style: italic; color: #f2c063; font-family: var(--font-display);">
                    <?= $todayQuote[0] ?>
                </p>
                <p style="font-size: 12px; opacity: 0.7; display: flex; align-items: center; gap: 8px;">
                    📅 Bulan <?= $currentHijriMonth ?> · <?= date('d M Y') ?>
                </p>
            </div>
        </div>
    </div>

    <div class="stat-3d stagger-2" style="grid-column: span 2;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; position: relative; z-index: 1;">
            <span style="font-size: 11px; letter-spacing: 0.15em; color: #f2c063; font-weight: 800;">🟢 STATUS LEMBAGA</span>
            <span class="live-mini"><span class="live-mini-dot" style="width:7px;height:7px;background:#6ee7b7;border-radius:50%;"></span> LIVE</span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; position: relative; z-index: 1;">
            <div class="mini-stat-3d">
                <div class="stat-3d-num"><?= (int) $statBerita ?></div>
                <div style="font-size: 10px; opacity: 0.8; margin-top: 4px; color: rgba(255,255,255,0.8);">📰 Berita</div>
            </div>
            <div class="mini-stat-3d">
                <div class="stat-3d-num"><?= (int) $statDokumen ?></div>
                <div style="font-size: 10px; opacity: 0.8; margin-top: 4px; color: rgba(255,255,255,0.8);">📁 Dokumen</div>
            </div>
            <div class="mini-stat-3d">
                <div class="stat-3d-num"><?= number_format($totalKarya) ?></div>
                <div style="font-size: 10px; opacity: 0.8; margin-top: 4px; color: rgba(255,255,255,0.8);">✨ Total</div>
            </div>
        </div>
    </div>
</section>

<!-- STATS COUNTER -->
<section class="stats" aria-label="Statistik lembaga">
    <div class="stat reveal stagger-1">
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-3d">🤝</div>
            <div>
                <div class="counter-3d" data-count="<?= (int) $statPengabdian ?>" data-suffix="+">0</div>
                <div class="stat-label">Pengabdian & KKN</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-2">
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-3d ico-3d-gold">📚</div>
            <div>
                <div class="counter-3d" data-count="<?= (int) $statPublikasi ?>" data-suffix="+">0</div>
                <div class="stat-label">Publikasi Ilmiah</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-3">
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-3d ico-3d-blue">🛡️</div>
            <div>
                <div class="counter-3d" data-count="<?= (int) $statHaki ?>" data-suffix="+">0</div>
                <div class="stat-label">HAKI Terdaftar</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-4">
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-3d ico-3d-purple">🕌</div>
            <div>
                <div class="counter-3d" data-count="<?= (int) $statAik ?>" data-suffix="+">0</div>
                <div class="stat-label">Kegiatan AIK</div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURED -->
<?php if ($featured !== null): ?>
<section class="reveal" style="margin-bottom: 32px;">
    <div style="background: linear-gradient(135deg, #043b2c, #065f46); color: white; border-radius: 28px; overflow: hidden; box-shadow: 0 24px 54px rgba(0,0,0,0.35); display: grid; grid-template-columns: <?= !empty($featured['thumbnail']) ? '1.2fr 1fr' : '1fr' ?>;">
        <?php if (!empty($featured['thumbnail'])): ?>
            <img src="<?= e(upload_url($featured['thumbnail'])) ?>" alt="<?= e($featured['title']) ?>" style="width: 100%; height: 100%; object-fit: cover; min-height: 300px;">
        <?php endif; ?>
        <div style="padding: 36px;">
            <span class="featured-badge-3d">🔥 SOROTAN TERBARU</span>
            <h2 style="font-size: clamp(22px, 3vw, 30px); font-weight: 800; margin: 16px 0; letter-spacing: -0.02em; line-height: 1.25;">
                <?= e($featured['title']) ?>
            </h2>
            <p style="color: rgba(255,255,255,0.85); margin-bottom: 20px; line-height: 1.6;">
                <?= e(excerpt($featured['content'], 170)) ?>
            </p>
            <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 22px; font-size: 12px; color: rgba(255,255,255,0.7); flex-wrap: wrap;">
                <span class="badge" style="background: rgba(217,164,65,0.3); color: #f2c063; border: 1px solid rgba(217,164,65,0.4);">
                    <?= e(ucfirst($featured['category'])) ?>
                </span>
                <span>📅 <?= e(date('d M Y', strtotime($featured['published_at'] ?? $featured['created_at']))) ?></span>
                <span>⏱️ <?= max(1, (int) round(str_word_count(strip_tags($featured['content'])) / 200)) ?> mnt</span>
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

<!-- CATUR DHARMA (section--cream background) -->
<section class="section section--cream">
    <div class="section-head">
        <h2><?= e($s['home_section_title']) ?></h2>
    </div>
    <div class="grid">
        <?php for ($i = 1; $i <= 4; $i++): ?>
            <div class="card reveal stagger-<?= $i ?>">
                <div class="card-num-3d">0<?= $i ?></div>
                <div class="card-icon">
                    <span class="ico-3d" style="width:56px;height:56px;font-size:26px;"><?= $icons[$i - 1] ?></span>
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
        <h2>⚡ Aktivitas Terbaru Lembaga</h2>
        <span class="live-mini"><span class="live-mini-dot" style="width:7px;height:7px;background:#6ee7b7;border-radius:50%;"></span> LIVE</span>
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

<!-- QUICK ACCESS (section--teal background) -->
<section class="section section--teal">
    <div class="section-head">
        <h2>🚀 Akses Cepat</h2>
    </div>
    <div class="grid" style="grid-template-columns: repeat(<?= min(count($quickAccess), 3) ?>, 1fr);">
        <?php foreach ($quickAccess as $idx => $qa): ?>
            <a href="<?= e(url('public/index.php?page=' . $qa[3])) ?>" class="qa-3d reveal stagger-<?= ($idx % 4) + 1 ?>">
                <div style="display: flex; justify-content: center; margin-bottom: 14px;">
                    <div class="ico-3d ico-3d-lg"><?= $qa[0] ?></div>
                </div>
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

<!-- IMPACT BOX -->
<section class="section reveal">
    <div style="background: linear-gradient(135deg, #043b2c 0%, #065f46 60%, #059669 100%); color: white; padding: 52px 44px; border-radius: 28px; text-align: center; box-shadow: 0 30px 70px rgba(0,0,0,0.4); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -80px; right: -60px; width: 260px; height: 260px; border-radius: 50%; background: radial-gradient(circle, rgba(217,164,65,0.3), transparent 70%);"></div>
        <div style="position: absolute; bottom: -80px; left: -40px; width: 200px; height: 200px; border-radius: 50%; background: radial-gradient(circle, rgba(110,231,183,0.25), transparent 70%);"></div>

        <div style="position: relative; z-index: 1;">
            <span class="featured-badge-3d" style="margin: 0 auto 16px;">✦ JEJAK KAMI</span>
            <div class="impact-num-3d"><?= number_format($totalKarya + $statBerita + $statDokumen) ?>+</div>
            <p style="font-size: 17px; opacity: 0.9; max-width: 540px; margin: 12px auto 0; line-height: 1.6;">
                Karya ilmiah, pengabdian, HAKI, kegiatan AIK, berita, dan dokumen yang telah kami dokumentasikan.
            </p>
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