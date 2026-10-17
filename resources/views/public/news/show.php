<?php
$words = str_word_count(strip_tags($item['content']));
$readMinutes = max(1, (int) round($words / 200));
$chars = strlen(strip_tags($item['content']));
$paragraphs = substr_count($item['content'], "\n") + 1;

$shareUrl = urlencode(url('public/index.php?page=berita-detail&slug=' . $item['slug']));
$tagList = !empty($itemTags) ? implode(', ', array_map(fn($t) => '#' . $t['name'], $itemTags)) : '';
$shareText = urlencode($item['title'] . ($tagList ? ' ' . $tagList : '') . ' — ' . APP_NAME);

$authorStmt = Database::pdo()->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
$authorStmt->execute([$item['user_id']]);
$author = $authorStmt->fetch();

// Related: primary by tags (lebih relevan), fallback by category jika kurang
$related = Tag::relatedNews((int) $item['id'], 4);
if (count($related) < 3) {
    $relStmt = Database::pdo()->prepare('SELECT * FROM news WHERE status = "published" AND category = ? AND id != ? ORDER BY published_at DESC LIMIT 4');
    $relStmt->execute([$item['category'], $item['id']]);
    $catRelated = $relStmt->fetchAll();
    $relIds = array_column($related, 'id');
    foreach ($catRelated as $cr) {
        if (!in_array($cr['id'], $relIds, true) && count($related) < 4) {
            $related[] = $cr;
            $relIds[] = $cr['id'];
        }
    }
}
if (count($related) < 3) {
    $moreStmt = Database::pdo()->prepare('SELECT * FROM news WHERE status = "published" AND id != ? ORDER BY RAND() LIMIT ' . (3 - count($related)));
    $moreStmt->execute([$item['id']]);
    $related = array_merge($related, $moreStmt->fetchAll());
}

$trendingStmt = Database::pdo()->prepare('SELECT * FROM news WHERE status = "published" AND category = ? AND id != ? ORDER BY published_at DESC LIMIT 3');
$trendingStmt->execute([$item['category'], $item['id']]);
$trending = $trendingStmt->fetchAll();

$pubDaysAgo = (int) ((time() - strtotime($item['published_at'] ?? $item['created_at'])) / 86400);
$pubDate = $item['published_at'] ?? $item['created_at'];

$prevStmt = Database::pdo()->prepare('SELECT * FROM news WHERE status = "published" AND (published_at < ? OR (published_at IS NULL AND created_at < ?)) ORDER BY published_at DESC, created_at DESC LIMIT 1');
$prevStmt->execute([$pubDate, $pubDate]);
$prevArticle = $prevStmt->fetch();

$nextStmt = Database::pdo()->prepare('SELECT * FROM news WHERE status = "published" AND (published_at > ? OR (published_at IS NULL AND created_at > ?)) ORDER BY published_at ASC, created_at ASC LIMIT 1');
$nextStmt->execute([$pubDate, $pubDate]);
$nextArticle = $nextStmt->fetch();

$contentLines = array_filter(array_map('trim', explode("\n", $item['content'])));
$contentLines = array_values($contentLines);
$pullQuote = '';
$maxLen = 0;
foreach (array_slice($contentLines, 0, 5) as $line) {
    $cleanLine = trim($line);
    if (strlen($cleanLine) > $maxLen && strlen($cleanLine) < 200 && strlen($cleanLine) > 60) {
        $maxLen = strlen($cleanLine);
        $pullQuote = $cleanLine;
    }
}

$tocItems = [];
foreach (array_slice($contentLines, 0, 8) as $idx => $line) {
    $cleanLine = trim($line);
    if (strlen($cleanLine) > 30 && strlen($cleanLine) < 120) {
        $tocItems[] = ['id' => 'section-' . $idx, 'text' => excerpt($cleanLine, 50)];
    }
}

$viewCount = (int) ($item['views'] ?? 0);
?>

<style>
    @keyframes showShine { 0%{transform:translateX(-100%) skewX(-20deg)} 100%{transform:translateX(300%) skewX(-20deg)} }
    .bc-3d { display:flex; align-items:center; gap:6px; flex-wrap:wrap; padding:10px 16px; margin-bottom:16px; background:var(--white); border:1px solid var(--border); border-radius:999px; font-size:12.5px; box-shadow:inset 0 1px 1px rgba(255,255,255,0.9),0 2px 5px rgba(0,0,0,0.05); }
    .bc-3d a { color:var(--muted); text-decoration:none; font-weight:600; }
    .bc-3d a:hover { color:var(--primary-dark); }
    .bc-sep { color:var(--border); }
    .bc-current { color:var(--text); font-weight:700; }
    .show-author-3d { display:flex; align-items:center; gap:16px; padding:18px 22px; margin:22px 0; background:linear-gradient(145deg,rgba(5,150,105,0.08),rgba(217,164,65,0.08)); border:1px solid rgba(5,150,105,0.2); border-radius:20px; position:relative; overflow:hidden; }
    .show-author-3d::before { content:''; position:absolute; top:-50%; right:-10%; width:200px; height:200px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,0.12),transparent 70%); }
    .show-avatar-3d { width:58px; height:58px; border-radius:50%; flex-shrink:0; background:radial-gradient(circle at 30% 25%,#fde68a,#d9a441 60%,#a9761b); display:flex; align-items:center; justify-content:center; color:#03251f; font-weight:900; font-size:22px; font-family:var(--font-display); position:relative; overflow:hidden; box-shadow:inset 0 2px 3px rgba(255,255,255,0.6),inset 0 -3px 4px rgba(0,0,0,0.2),0 0 0 3px rgba(217,164,65,0.15),0 6px 16px rgba(217,164,65,0.4); }
    .show-avatar-3d::before { content:''; position:absolute; top:5px; left:12px; width:18px; height:8px; border-radius:50%; background:rgba(255,255,255,0.65); filter:blur(1.5px); }
    .toc-3d { position:relative; padding:26px 28px 22px; background:var(--white); border:1px solid var(--border); border-radius:22px; margin-bottom:24px; box-shadow:0 6px 20px rgba(0,0,0,0.04); }
    .toc-badge-3d { position:absolute; top:-12px; left:22px; padding:4px 14px; border-radius:999px; font-size:10px; font-weight:900; letter-spacing:0.15em; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:inset 0 1px 2px rgba(255,255,255,0.7),inset 0 -2px 3px rgba(0,0,0,0.2),0 3px 8px rgba(217,164,65,0.4); }
    .toc-badge-3d::before { content:''; position:absolute; top:2px; left:6px; width:30%; height:40%; border-radius:50%; background:rgba(255,255,255,0.6); filter:blur(1px); }
    .toc-item-3d { display:flex; align-items:center; gap:12px; padding:10px 12px; border-radius:12px; text-decoration:none; color:var(--text); transition:all 0.25s; font-size:14px; }
    .toc-item-3d:hover { background:rgba(5,150,105,0.06); transform:translateX(4px); }
    .toc-num-3d { width:30px; height:30px; border-radius:10px; flex-shrink:0; background:linear-gradient(145deg,#fde68a,#d9a441); display:flex; align-items:center; justify-content:center; font-weight:900; font-size:12px; color:#03251f; font-family:var(--font-display); box-shadow:inset 0 1px 2px rgba(255,255,255,0.7),inset 0 -1px 2px rgba(0,0,0,0.15); position:relative; }
    .toc-num-3d::before { content:''; position:absolute; top:2px; left:5px; width:35%; height:35%; border-radius:50%; background:rgba(255,255,255,0.6); filter:blur(1px); }
    .pullquote-3d { position:relative; margin:28px 0; padding:30px 34px 30px 80px; background:linear-gradient(135deg,rgba(217,164,65,0.1),rgba(5,150,105,0.05)); border-left:5px solid #d9a441; border-radius:0 20px 20px 0; font-style:italic; font-size:18px; line-height:1.6; color:var(--primary-dark); font-family:var(--font-display); font-weight:600; box-shadow:0 6px 20px rgba(5,150,105,0.08); }
    .pullquote-3d::before { content:'“'; position:absolute; top:6px; left:16px; font-size:68px; line-height:1; color:rgba(217,164,65,0.5); font-family:Georgia,serif; font-weight:900; }
    .show-stats-3d { margin-top:32px; padding:26px; background:linear-gradient(145deg,#f6faf7,#ffffff); border:1px solid var(--border); border-radius:22px; box-shadow:0 6px 20px rgba(0,0,0,0.04); position:relative; overflow:hidden; }
    .show-stats-3d::before { content:''; position:absolute; top:-50%; right:-20%; width:200px; height:200px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,0.08),transparent 70%); }
    .show-stat-item-3d { text-align:center; padding:10px; position:relative; }
    .show-stat-num-3d { font-family:var(--font-display); font-size:28px; font-weight:900; background:linear-gradient(135deg,#fde68a,#f2c063 40%,#d9a441); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; line-height:1; }
    .pn-3d { display:block; padding:18px 20px; background:var(--white); border:1px solid var(--border); border-radius:18px; text-decoration:none; transition:all 0.3s cubic-bezier(0.16,1,0.3,1); }
    .pn-3d:hover { transform:translateY(-3px); box-shadow:0 10px 24px rgba(5,150,105,0.12); border-color:rgba(5,150,105,0.3); }
    .share-sphere-3d { display:inline-flex; align-items:center; gap:6px; padding:8px 14px; border-radius:999px; font-size:12.5px; font-weight:700; text-decoration:none; color:#fff; position:relative; overflow:hidden; transition:transform 0.3s cubic-bezier(0.16,1,0.3,1); box-shadow:inset 0 1px 2px rgba(255,255,255,0.4),inset 0 -2px 3px rgba(0,0,0,0.2),0 4px 10px rgba(0,0,0,0.2); }
    .share-sphere-3d::before { content:''; position:absolute; top:3px; left:10px; width:30%; height:35%; border-radius:50%; background:rgba(255,255,255,0.35); filter:blur(2px); }
    .share-sphere-3d:hover { transform:translateY(-3px) scale(1.04); }
    .sh-wa{background:radial-gradient(circle at 30% 25%,#5ee28a,#25D366 60%,#128C7E)} .sh-fb{background:radial-gradient(circle at 30% 25%,#4dabf7,#1877F2 60%,#0a4fa3)} .sh-tw{background:radial-gradient(circle at 30% 25%,#60a5fa,#1DA1F2 60%,#0d8bd9)} .sh-tg{background:radial-gradient(circle at 30% 25%,#38bdf8,#0088cc 60%,#006699)} .sh-li{background:radial-gradient(circle at 30% 25%,#38bdf8,#0A66C2 60%,#084d94)} .sh-em{background:radial-gradient(circle at 30% 25%,#fde68a,#d9a441 60%,#a9761b);color:#03251f}
    .show-cta-3d { position:relative; display:inline-flex; align-items:center; gap:8px; padding:12px 22px; border-radius:13px; font-weight:700; font-size:14px; overflow:hidden; text-decoration:none; transition:transform 0.3s; }
    .show-cta-3d::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,0.5),transparent); animation:showShine 3s ease-in-out infinite; }
    .show-cta-primary-3d { background:linear-gradient(145deg,#fde68a,#d9a441); color:#03251f; box-shadow:inset 0 2px 3px rgba(255,255,255,0.7),inset 0 -2px 3px rgba(0,0,0,0.15),0 8px 20px rgba(217,164,65,0.4); }
    .show-cta-ghost-3d { background:transparent; color:var(--primary-dark); border:2px solid rgba(5,150,105,0.35); }
    .show-cta-3d:hover { transform:translateY(-3px); }
    .show-trending-3d { display:flex; align-items:center; gap:14px; padding:14px 18px; background:var(--white); border:1px solid var(--border); border-radius:16px; text-decoration:none; transition:all 0.3s; }
    .show-trending-3d:hover { transform:translateY(-3px); box-shadow:0 10px 22px rgba(5,150,105,0.12); border-color:rgba(5,150,105,0.3); }
    .show-rank-3d { width:44px; height:44px; border-radius:14px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-weight:900; font-size:16px; color:white; position:relative; overflow:hidden; box-shadow:inset 0 2px 3px rgba(255,255,255,0.5),inset 0 -2px 3px rgba(0,0,0,0.25); }
    .show-rank-3d::before { content:''; position:absolute; top:4px; left:9px; width:14px; height:6px; border-radius:50%; background:rgba(255,255,255,0.5); filter:blur(1.5px); }
    .sr-gold{background:linear-gradient(145deg,#fde68a,#d9a441 60%,#a9761b);color:#03251f} .sr-green{background:linear-gradient(145deg,#34d399,#10b981 60%,#059669)} .sr-teal{background:linear-gradient(145deg,#5eead4,#14b8a6 60%,#0f766e)}
    .meta-chip-3d { display:inline-flex; align-items:center; gap:6px; padding:6px 12px; border-radius:999px; font-size:12px; font-weight:700; background:linear-gradient(145deg,#fff,#f6faf7); border:1px solid var(--border); color:var(--text); box-shadow:inset 0 1px 1px rgba(255,255,255,0.9); text-decoration:none; transition:all .25s; }
    .meta-chip-3d:hover { transform:translateY(-2px); border-color:rgba(5,150,105,.3); }
    .meta-chip-gold-3d { background:linear-gradient(145deg,#fef3c7,#fde68a); color:#92400e; border-color:rgba(217,164,65,0.4); }
    .meta-chip-views-3d { background:linear-gradient(145deg,#dbeafe,#bfdbfe); color:#1e40af; border-color:rgba(59,130,246,0.4); }
    /* Tag chip khusus (BARU) */
    .meta-chip-tag-3d { background:linear-gradient(145deg,#dcfce7,#bbf7d0); color:#14532d; border-color:rgba(22,163,74,.3); }
    .meta-chip-tag-3d:hover { background:linear-gradient(145deg,#16a34a,#15803d); color:#fff !important; }
</style>

<!-- ================= BREADCRUMBS 3D ================= -->
<nav class="bc-3d">
    <a href="<?= e(url('public/index.php?page=home')) ?>">🏠 Beranda</a>
    <span class="bc-sep">›</span>
    <a href="<?= e(url('public/index.php?page=berita')) ?>">Berita</a>
    <span class="bc-sep">›</span>
    <a href="<?= e(url('public/index.php?page=berita&category=' . urlencode($item['category']))) ?>"><?= e(ucfirst($item['category'])) ?></a>
    <span class="bc-sep">›</span>
    <span class="bc-current"><?= e(excerpt($item['title'], 40)) ?></span>
</nav>

<a class="btn-more" href="<?= e(url('public/index.php?page=berita')) ?>">&larr; Semua Berita</a>

<article class="news-detail reveal" style="margin-top: 14px; position: relative;">

    <!-- Meta bar 3D -->
    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px;">
        <span class="meta-chip-3d meta-chip-gold-3d">🏷️ <?= e(ucfirst($item['category'])) ?></span>
        <span class="meta-chip-3d">📅 <?= e(date('d M Y H:i', strtotime($pubDate))) ?></span>
        <span class="meta-chip-3d">⏱️ <?= $readMinutes ?> mnt</span>
        <span class="meta-chip-3d">📄 <?= number_format($words) ?> kata</span>
        <span class="meta-chip-3d">¶ <?= $paragraphs ?> ¶</span>
        <span class="meta-chip-3d meta-chip-views-3d">👁️ <?= number_format($viewCount) ?> dibaca</span>
        <?php if ($pubDaysAgo === 0): ?>
            <span class="meta-chip-3d meta-chip-gold-3d">🔥 BARU</span>
        <?php elseif ($pubDaysAgo > 0 && $pubDaysAgo < 7): ?>
            <span class="meta-chip-3d">🕒 <?= $pubDaysAgo ?>h lalu</span>
        <?php elseif ($pubDaysAgo >= 7): ?>
            <span class="meta-chip-3d">🕒 <?= (int) floor($pubDaysAgo / 7) ?>mgg lalu</span>
        <?php endif; ?>
    </div>

    <h1 style="margin-top: 16px;"><?= e($item['title']) ?></h1>

    <!-- Tag chips (BARU) -->
    <?php if (!empty($itemTags)): ?>
    <div style="display: flex; gap: 6px; flex-wrap: wrap; margin: 12px 0 18px;">
        <span style="font-size: 11px; font-weight: 800; letter-spacing: 0.12em; color: var(--gold-strong); text-transform: uppercase; padding-top: 6px;">TAGS:</span>
        <?php foreach ($itemTags as $t): ?>
            <a href="<?= e(url('public/index.php?page=berita&tag=' . urlencode($t['slug']))) ?>"
               class="meta-chip-3d meta-chip-tag-3d" title="Lihat semua berita dengan tag <?= e($t['name']) ?>">
                #<?= e($t['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Author 3D -->
    <?php if ($author !== false): ?>
    <div class="show-author-3d">
        <div class="show-avatar-3d"><?= strtoupper(substr($author['name'] ?? 'A', 0, 1)) ?></div>
        <div style="flex: 1; position: relative; z-index: 1;">
            <p style="font-size: 10px; color: var(--gold-strong); letter-spacing: 0.15em; margin-bottom: 2px; font-weight: 800;">DITULIS OLEH</p>
            <p style="font-size: 16px; font-weight: 800; color: var(--ink); margin: 0 0 2px;"><?= e($author['name'] ?? 'Redaksi LP3M') ?></p>
            <p style="font-size: 12px; color: var(--muted); margin: 0;"><?= e(ucfirst($author['role'] ?? 'admin')) ?> · LP3M/LPPAIK UNIMOF</p>
        </div>
        <div style="text-align: right; position: relative; z-index: 1;">
            <p style="font-size: 10px; color: var(--muted); margin: 0;">DIPUBLIKASIKAN</p>
            <p style="font-size: 14px; font-weight: 800; color: var(--ink); margin: 2px 0 0;"><?= e(date('d M Y', strtotime($pubDate))) ?></p>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($item['thumbnail'])): ?>
        <img class="news-detail-img" src="<?= e(upload_url($item['thumbnail'])) ?>" alt="<?= e($item['title']) ?>" style="border-radius: 22px; box-shadow: 0 16px 40px rgba(0,0,0,0.15);">
    <?php endif; ?>

    <!-- ToC 3D -->
    <?php if (count($tocItems) >= 3): ?>
    <div class="toc-3d">
        <span class="toc-badge-3d">📋 ISI ARTIKEL</span>
        <div style="margin-top: 8px; display: flex; flex-direction: column; gap: 4px;">
            <?php foreach ($tocItems as $idx => $toc): ?>
                <a href="#<?= $toc['id'] ?>" class="toc-item-3d">
                    <span class="toc-num-3d"><?= sprintf('%02d', $idx + 1) ?></span>
                    <span><?= e($toc['text']) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Content dengan pull quote 3D -->
    <div class="news-content">
        <?php 
        $lines = array_filter(array_map('trim', explode("\n", $item['content'])));
        $lines = array_values($lines);
        $shownQuote = false;
        foreach ($lines as $idx => $line): 
        ?>
            <p id="section-<?= $idx ?>" style="margin-bottom: 16px; line-height: 1.85; font-size: 15.5px;"><?= e($line) ?></p>
            <?php if (!$shownQuote && $idx === 2 && $pullQuote !== ''): ?>
                <blockquote class="pullquote-3d"><?= e($pullQuote) ?></blockquote>
            <?php $shownQuote = true; endif;
        endforeach; 
        ?>
    </div>
    
    <!-- Stats card 3D -->
    <div class="show-stats-3d">
        <p style="font-size: 11px; font-weight: 900; letter-spacing: 0.2em; color: var(--gold-strong); margin-bottom: 16px; position: relative; z-index: 1;">📊 STATISTIK ARTIKEL</p>
        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; position: relative; z-index: 1;">
            <div class="show-stat-item-3d">
                <div class="show-stat-num-3d"><?= $readMinutes ?></div>
                <div style="font-size: 11px; color: var(--muted); margin-top: 4px; font-weight: 600;">Menit Baca</div>
            </div>
            <div class="show-stat-item-3d">
                <div class="show-stat-num-3d"><?= number_format($words) ?></div>
                <div style="font-size: 11px; color: var(--muted); margin-top: 4px; font-weight: 600;">Kata</div>
            </div>
            <div class="show-stat-item-3d">
                <div class="show-stat-num-3d"><?= $paragraphs ?></div>
                <div style="font-size: 11px; color: var(--muted); margin-top: 4px; font-weight: 600;">Paragraf</div>
            </div>
            <div class="show-stat-item-3d">
                <div class="show-stat-num-3d"><?= number_format($viewCount) ?></div>
                <div style="font-size: 11px; color: var(--muted); margin-top: 4px; font-weight: 600;">👁️ Dibaca</div>
            </div>
            <div class="show-stat-item-3d">
                <div class="show-stat-num-3d"><?= $pubDaysAgo === 0 ? '0' : $pubDaysAgo ?></div>
                <div style="font-size: 11px; color: var(--muted); margin-top: 4px; font-weight: 600;">Hari Lalu</div>
            </div>
        </div>
    </div>

    <!-- Prev/Next 3D -->
    <?php if ($prevArticle !== false || $nextArticle !== false): ?>
    <div style="margin-top: 32px; padding-top: 26px; border-top: 1px solid var(--border);">
        <p style="font-size: 11px; font-weight: 900; letter-spacing: 0.2em; color: var(--gold-strong); margin-bottom: 14px;">🧭 NAVIGASI ARTIKEL</p>
        <div style="display: flex; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
            <?php if ($prevArticle !== false): ?>
            <a href="<?= e(url('public/index.php?page=berita-detail&slug=' . urlencode($prevArticle['slug']))) ?>" class="pn-3d" style="flex: 1; min-width: 220px;">
                <p style="font-size: 10px; color: var(--muted); margin: 0 0 6px; letter-spacing: 0.15em; font-weight: 800;">← SEBELUMNYA</p>
                <p style="color: var(--ink); font-weight: 800; font-size: 14px; line-height: 1.4; margin: 0;"><?= e(excerpt($prevArticle['title'], 70)) ?></p>
                <p style="font-size: 11px; color: var(--muted); margin: 6px 0 0;">📅 <?= e(date('d M Y', strtotime($prevArticle['published_at'] ?? $prevArticle['created_at']))) ?></p>
            </a>
            <?php else: ?><div style="flex: 1;"></div><?php endif; ?>
            
            <?php if ($nextArticle !== false): ?>
            <a href="<?= e(url('public/index.php?page=berita-detail&slug=' . urlencode($nextArticle['slug']))) ?>" class="pn-3d" style="flex: 1; min-width: 220px; text-align: right;">
                <p style="font-size: 10px; color: var(--muted); margin: 0 0 6px; letter-spacing: 0.15em; font-weight: 800;">BERIKUTNYA →</p>
                <p style="color: var(--ink); font-weight: 800; font-size: 14px; line-height: 1.4; margin: 0;"><?= e(excerpt($nextArticle['title'], 70)) ?></p>
                <p style="font-size: 11px; color: var(--muted); margin: 6px 0 0;">📅 <?= e(date('d M Y', strtotime($nextArticle['published_at'] ?? $nextArticle['created_at']))) ?></p>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Share 3D spheres -->
    <div style="margin-top: 28px; padding-top: 24px; border-top: 1px solid var(--border);">
        <p style="font-size: 11px; font-weight: 900; letter-spacing: 0.2em; color: var(--gold-strong); margin-bottom: 14px;">📣 BAGIKAN ARTIKEL INI</p>
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <a class="share-sphere-3d sh-wa" target="_blank" rel="noopener" href="https://wa.me/?text=<?= $shareText ?>%20<?= $shareUrl ?>">💬 WhatsApp</a>
            <a class="share-sphere-3d sh-fb" target="_blank" rel="noopener" href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareUrl ?>">📘 Facebook</a>
            <a class="share-sphere-3d sh-tw" target="_blank" rel="noopener" href="https://twitter.com/intent/tweet?text=<?= $shareText ?>&url=<?= $shareUrl ?>">🐦 Twitter</a>
            <a class="share-sphere-3d sh-tg" target="_blank" rel="noopener" href="https://t.me/share/url?url=<?= $shareUrl ?>&text=<?= $shareText ?>">✈️ Telegram</a>
            <a class="share-sphere-3d sh-li" target="_blank" rel="noopener" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $shareUrl ?>">💼 LinkedIn</a>
            <a class="share-sphere-3d sh-em" target="_blank" rel="noopener" href="mailto:?subject=<?= $shareText ?>&body=<?= $shareUrl ?>">✉️ Email</a>
        </div>
    </div>

    <div class="hero-actions" style="margin-top: 28px; display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="<?= e(url('public/index.php?page=berita')) ?>" class="show-cta-3d show-cta-primary-3d">📰 Kembali ke Berita</a>
        <a href="javascript:window.print()" class="show-cta-3d show-cta-ghost-3d">🖨️ Cetak Artikel</a>
    </div>
</article>

<!-- ================= TRENDING KATEGORI 3D ================= -->
<?php if ($trending !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>🔥 Trending di <span class="gold-text"><?= e(ucfirst($item['category'])) ?></span></h2>
        <span class="chip">Kategori yang sama</span>
    </div>
    <div class="docs-list" style="display: flex; flex-direction: column; gap: 10px;">
        <?php 
        $rankClasses = ['sr-gold', 'sr-green', 'sr-teal'];
        foreach ($trending as $idx => $tr): 
            $rankClass = $rankClasses[$idx] ?? 'sr-teal';
        ?>
            <a href="<?= e(url('public/index.php?page=berita-detail&slug=' . urlencode($tr['slug']))) ?>" class="show-trending-3d">
                <div class="show-rank-3d <?= $rankClass ?>"><?= $idx + 1 ?></div>
                <div style="flex: 1; min-width: 0;">
                    <h3 style="color: var(--ink); font-size: 14.5px; line-height: 1.4; margin: 0 0 4px;"><?= e($tr['title']) ?></h3>
                    <div style="display: flex; gap: 10px; font-size: 11.5px; color: var(--muted); flex-wrap: wrap;">
                        <span>📅 <?= e(date('d M Y', strtotime($tr['published_at'] ?? $tr['created_at']))) ?></span>
                        <span>⏱️ <?= max(1, (int) round(str_word_count(strip_tags($tr['content'])) / 200)) ?> mnt</span>
                        <span>👁️ <?= number_format((int) ($tr['views'] ?? 0)) ?></span>
                    </div>
                </div>
                <div style="flex-shrink: 0; width: 26px; height: 26px; border-radius: 50%; background: linear-gradient(145deg, #059669, #065f46); color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 900; box-shadow: inset 0 1px 1px rgba(255,255,255,0.25);">→</div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= RELATED 3D (UPGRADED: primary by tags) ================= -->
<?php if ($related !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>📰 Berita Terkait</h2>
        <a href="<?= e(url('public/index.php?page=berita')) ?>" class="btn-more">Lihat Semua →</a>
    </div>
    <div class="news-grid">
        <?php foreach ($related as $rel): ?>
            <?php 
            $item = $rel;
            include BASE_PATH . '/resources/views/public/news/_card.php'; 
            ?>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= CTA NEWSLETTER 3D ================= -->
<section class="cta-band reveal">
    <div>
        <h3>📧 Tetap Update dengan LP3M</h3>
        <p>Dapatkan berita terbaru, publikasi, dan kegiatan AIK langsung ke email Anda setiap minggu.</p>
    </div>
    <div class="cta-actions">
        <a href="<?= e(url('public/index.php?page=berita')) ?>" class="show-cta-3d show-cta-primary-3d">📰 Jelajahi Berita</a>
        <a href="<?= e(url('public/index.php?page=aik')) ?>" class="show-cta-3d show-cta-ghost-3d" style="color: #fff; border-color: rgba(255,255,255,0.35);">🕌 Kegiatan AIK</a>
    </div>
</section>