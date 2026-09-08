<?php
$totalDocs = Document::paginate(['status' => 'published'], 1, 1)['total'];
$totalUnduhan = (int) Database::pdo()->query('SELECT COALESCE(SUM(download_count), 0) FROM documents WHERE status = "published"')->fetchColumn();
$topDoc = Database::pdo()->query('SELECT * FROM documents WHERE status = "published" ORDER BY download_count DESC LIMIT 1')->fetch();
$docLabels = array_values(Document::CATEGORY_LABELS);

$yearStmt = Database::pdo()->query('SELECT YEAR(created_at) as year, COUNT(*) as cnt FROM documents WHERE status = "published" GROUP BY YEAR(created_at) ORDER BY year DESC LIMIT 5');
$yearTimeline = $yearStmt->fetchAll();

$categoryStats = [];
$totalByCat = 0;
foreach (Document::CATEGORY_LABELS as $key => $label) {
    $stmt = Database::pdo()->prepare('SELECT COUNT(*) FROM documents WHERE status = "published" AND category = ?');
    $stmt->execute([$key]);
    $count = (int) $stmt->fetchColumn();
    $categoryStats[$key] = ['label' => $label, 'count' => $count];
    $totalByCat += $count;
}
arsort($categoryStats);

$fileTypeStats = [];
$typeStmt = Database::pdo()->query('SELECT file_type, COUNT(*) as cnt FROM documents WHERE status = "published" GROUP BY file_type ORDER BY cnt DESC');
foreach ($typeStmt->fetchAll() as $t) {
    $fileTypeStats[strtoupper($t['file_type'])] = (int) $t['cnt'];
}

$top3Stmt = Database::pdo()->query('SELECT * FROM documents WHERE status = "published" ORDER BY download_count DESC LIMIT 3');
$top3Docs = $top3Stmt->fetchAll();

$weekAgo = date('Y-m-d', strtotime('-7 days'));
$newThisWeek = (int) Database::pdo()->query('SELECT COUNT(*) FROM documents WHERE status = "published" AND created_at >= "' . $weekAgo . '"')->fetchColumn();
$thisMonth = (int) Database::pdo()->query('SELECT COUNT(*) FROM documents WHERE status = "published" AND MONTH(created_at) = ' . (int) date('n') . ' AND YEAR(created_at) = ' . (int) date('Y'))->fetchColumn();
$totalSize = (int) Database::pdo()->query('SELECT COALESCE(SUM(file_size), 0) FROM documents WHERE status = "published"')->fetchColumn();

$quotes = [
    ['"Ilmu tanpa amal bagai pohon tanpa buah." — Pepatah Arab', '📚'],
    ['"Baca dengan nama Tuhanmu yang menciptakan." — QS. Al-Alaq: 1', '📖'],
    ['"Tinta para ulama lebih berharga dari darah para syuhada." — HR. Abu Dawud', '✒️'],
    ['"Pengetahuan adalah harta yang tidak akan dicuri." — Pepatah', '💎'],
];
$todayQuote = $quotes[date('z') % count($quotes)];

$milestones = [];
if ($totalDocs >= 10) $milestones[] = ['📁', '10+ Dokumen'];
if ($totalDocs >= 25) $milestones[] = ['🗂️', '25+ Dokumen'];
if ($totalUnduhan >= 100) $milestones[] = ['⬇️', '100+ Unduhan'];
if ($totalUnduhan >= 500) $milestones[] = ['🔥', '500+ Unduhan'];
?>

<style>
    @keyframes docFloat1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(20px,-15px)} }
    @keyframes docFloat2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-15px,20px)} }
    @keyframes docGlow { 0%,100%{text-shadow:0 0 20px rgba(242,192,99,0.5)} 50%{text-shadow:0 0 30px rgba(242,192,99,0.8),0 0 60px rgba(217,164,65,0.5)} }
    @keyframes docShine { 0%{transform:translateX(-100%) skewX(-20deg)} 100%{transform:translateX(300%) skewX(-20deg)} }

    .doc-orb { position:absolute; border-radius:50%; pointer-events:none; z-index:0; }
    .doc-orb-1 { width:140px; height:140px; top:12%; right:8%; background:radial-gradient(circle at 30% 30%, rgba(253,230,138,0.6), rgba(217,164,65,0.3) 60%, transparent); filter:blur(2px); animation:docFloat1 8s ease-in-out infinite; }
    .doc-orb-2 { width:200px; height:200px; bottom:15%; left:5%; background:radial-gradient(circle at 70% 70%, rgba(110,231,183,0.4), rgba(16,185,129,0.2) 60%, transparent); filter:blur(3px); animation:docFloat2 10s ease-in-out infinite; }

    .ico-doc { display:inline-flex; align-items:center; justify-content:center; width:52px; height:52px; border-radius:16px; font-size:24px; flex-shrink:0; background:radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #34d399, #10b981 50%, #059669); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(5,150,105,0.35); position:relative; overflow:hidden; }
    .ico-doc::before { content:''; position:absolute; top:5px; left:10px; width:16px; height:7px; border-radius:50%; background:rgba(255,255,255,0.6); filter:blur(2px); }
    .ico-doc-lg { width:68px; height:68px; border-radius:20px; font-size:32px; }
    .ico-doc-gold { background:radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%), linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441); box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -3px 4px rgba(0,0,0,0.2), 0 6px 16px rgba(217,164,65,0.4); }
    .ico-doc-blue { background:radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #60a5fa, #3b82f6 50%, #1d4ed8); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(59,130,246,0.35); }
    .ico-doc-purple { background:radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #c4b5fd, #a78bfa 50%, #7c3aed); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(124,58,237,0.35); }
    .ico-doc-red { background:radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%), linear-gradient(145deg, #fca5a5, #f87171 50%, #dc2626); box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(220,38,38,0.35); }

    .doc-quote-3d { position:relative; padding:30px; border-radius:24px; background:linear-gradient(145deg, #065f46, #03251f); border:1px solid rgba(217,164,65,0.25); overflow:hidden; box-shadow: inset 0 1px 1px rgba(255,255,255,0.08), 0 16px 40px rgba(0,0,0,0.35); }
    .doc-quote-3d::before { content:''; position:absolute; top:-60%; right:-20%; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle, rgba(217,164,65,0.3), transparent 70%); }
    .doc-quote-mark { position:absolute; top:4px; left:12px; font-size:90px; line-height:1; color:rgba(217,164,65,0.12); font-family:Georgia,serif; pointer-events:none; }

    .doc-counter-3d { font-family:var(--font-display); font-size:44px; font-weight:900; line-height:1; background:linear-gradient(135deg, #fde68a, #f2c063 40%, #d9a441); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; animation:docGlow 3s ease-in-out infinite; }

    .doc-mini-stat { padding:14px; border-radius:16px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); text-align:center; position:relative; overflow:hidden; }
    .doc-mini-stat::before { content:''; position:absolute; inset:0; background:radial-gradient(circle at 50% 0%, rgba(217,164,65,0.15), transparent 60%); pointer-events:none; }
    .doc-mini-num { font-family:var(--font-display); font-size:26px; font-weight:900; color:#f2c063; line-height:1; }

    /* TOP 3 PODIUM 3D */
    .podium-3d { display:grid; grid-template-columns:1fr 1.15fr 1fr; gap:14px; align-items:end; padding:10px 0; }
    @media (max-width: 640px) { .podium-3d { grid-template-columns:1fr; } }
    .podium-item-3d { position:relative; padding:22px 16px; border-radius:22px; background:var(--white); border:1px solid var(--border); text-align:center; transition:all 0.35s; box-shadow:0 6px 20px rgba(0,0,0,0.06); overflow:hidden; }
    .podium-item-3d:hover { transform:translateY(-6px); box-shadow:0 18px 40px rgba(217,164,65,0.2); border-color:rgba(217,164,65,0.4); }
    .podium-rank-3d { position:absolute; top:12px; left:12px; width:42px; height:42px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-weight:900; font-size:18px; color:white; box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.3), 0 6px 14px rgba(0,0,0,0.25); position:relative; overflow:hidden; }
    .podium-rank-3d::before { content:''; position:absolute; top:4px; left:8px; width:14px; height:6px; border-radius:50%; background:rgba(255,255,255,0.55); filter:blur(1.5px); }
    .pr-gold { background:radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%), linear-gradient(145deg, #fde68a, #f2c063 50%, #a9761b); color:#03251f; }
    .pr-silver { background:radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%), linear-gradient(145deg, #e2e8f0, #94a3b8 50%, #64748b); }
    .pr-bronze { background:radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%), linear-gradient(145deg, #fdba74, #b45309 50%, #92400e); }
    .podium-1 { padding-top:30px; padding-bottom:30px; border-color:rgba(217,164,65,0.3); }
    .podium-1::before { content:''; position:absolute; inset:0; background:radial-gradient(circle at 50% 0%, rgba(217,164,65,0.08), transparent 60%); pointer-events:none; }

    .doc-milestone-3d { position:relative; padding:22px; text-align:center; background:var(--white); border:1px solid var(--border); border-radius:22px; overflow:hidden; transition:all 0.35s cubic-bezier(0.16,1,0.3,1); box-shadow:0 4px 14px rgba(0,0,0,0.05); }
    .doc-milestone-3d::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg, #d9a441, #059669); transform:scaleX(0); transform-origin:left; transition:transform 0.4s ease; }
    .doc-milestone-3d:hover { transform:translateY(-6px); box-shadow:0 18px 36px rgba(5,150,105,0.18); border-color:rgba(5,150,105,0.3); }
    .doc-milestone-3d:hover::before { transform:scaleX(1); }
    .doc-milestone-3d:hover .ico-doc { transform:scale(1.1) rotate(-6deg); }

    .doc-bar-3d { height:12px; border-radius:999px; background:rgba(5,150,105,0.08); overflow:hidden; position:relative; box-shadow: inset 0 1px 2px rgba(0,0,0,0.08); }
    .doc-bar-fill-3d { height:100%; border-radius:999px; background:linear-gradient(145deg, #fde68a, #f2c063 40%, #d9a441 80%, #a9761b); position:relative; overflow:hidden; box-shadow: inset 0 1px 2px rgba(255,255,255,0.6), inset 0 -1px 2px rgba(0,0,0,0.15), 0 2px 6px rgba(217,164,65,0.3); }
    .doc-bar-fill-3d::before { content:''; position:absolute; top:1px; left:4px; right:4px; height:40%; border-radius:999px; background:linear-gradient(180deg, rgba(255,255,255,0.5), transparent); }

    .heatmap-bar-3d { flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; }
    .heatmap-inner-3d { width:100%; border-radius:8px 8px 0 0; background:linear-gradient(180deg, #fde68a, #f2c063 40%, #d9a441 80%, #a9761b); box-shadow: inset 0 2px 3px rgba(255,255,255,0.5), inset 0 -2px 3px rgba(0,0,0,0.2), 0 2px 6px rgba(217,164,65,0.3); position:relative; transition:transform 0.3s; }
    .heatmap-inner-3d:hover { transform:translateY(-4px); }
    .heatmap-inner-3d::before { content:''; position:absolute; top:4px; left:15%; width:30%; height:25%; border-radius:50%; background:rgba(255,255,255,0.4); filter:blur(1.5px); }

    .doc-tip-3d { position:relative; padding:26px 22px; background:var(--white); border:1px solid var(--border); border-radius:22px; overflow:hidden; transition:all 0.35s cubic-bezier(0.16,1,0.3,1); box-shadow:0 4px 14px rgba(0,0,0,0.05); }
    .doc-tip-3d::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg, #d9a441, #059669); transform:scaleX(0); transform-origin:left; transition:transform 0.4s ease; }
    .doc-tip-3d:hover { transform:translateY(-6px); box-shadow:0 18px 36px rgba(5,150,105,0.18); }
    .doc-tip-3d:hover::before { transform:scaleX(1); }

    .doc-row-3d { display:flex; align-items:center; gap:16px; padding:18px 20px; background:var(--white); border:1px solid var(--border); border-radius:20px; transition:all 0.3s cubic-bezier(0.16,1,0.3,1); }
    .doc-row-3d:hover { transform:translateY(-3px); box-shadow:0 12px 28px rgba(5,150,105,0.15); border-color:rgba(5,150,105,0.3); }
    .file-type-3d { width:54px; height:54px; border-radius:16px; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-weight:900; font-size:13px; flex-shrink:0; position:relative; overflow:hidden; color:white; box-shadow: inset 0 2px 3px rgba(255,255,255,0.5), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 14px rgba(0,0,0,0.2); letter-spacing:0.02em; }
    .file-type-3d::before { content:''; position:absolute; top:5px; left:10px; width:16px; height:7px; border-radius:50%; background:rgba(255,255,255,0.55); filter:blur(1.5px); }
    .ft-pdf { background:linear-gradient(145deg, #fca5a5, #dc2626 60%, #991b1b); }
    .ft-doc, .ft-docx { background:linear-gradient(145deg, #93c5fd, #2563eb 60%, #1e3a8a); }
    .ft-xls, .ft-xlsx { background:linear-gradient(145deg, #86efac, #16a34a 60%, #14532d); }
    .ft-ppt, .ft-pptx { background:linear-gradient(145deg, #fdba74, #ea580c 60%, #9a3412); }
    .ft-default { background:linear-gradient(145deg, #a78bfa, #7c3aed 60%, #5b21b6); }

    .download-btn-3d { position:relative; display:inline-flex; align-items:center; gap:6px; padding:10px 18px; border-radius:12px; font-weight:800; font-size:13px; text-decoration:none; background:linear-gradient(145deg, #fde68a, #d9a441); color:#03251f; overflow:hidden; box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -2px 3px rgba(0,0,0,0.15), 0 6px 14px rgba(217,164,65,0.35); transition:all 0.25s; flex-shrink:0; }
    .download-btn-3d::before { content:''; position:absolute; top:2px; left:6px; width:30%; height:35%; border-radius:50%; background:rgba(255,255,255,0.6); filter:blur(1px); }
    .download-btn-3d::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg, transparent, rgba(255,255,255,0.5), transparent); animation:docShine 3s ease-in-out infinite; }
    .download-btn-3d:hover { transform:translateY(-2px) scale(1.04); box-shadow: inset 0 2px 3px rgba(255,255,255,0.8), 0 10px 20px rgba(217,164,65,0.5); }

    .cat-filter-3d { display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border-radius:999px; font-size:12.5px; font-weight:700; background:linear-gradient(145deg, #fff, #f6faf7); border:1px solid var(--border); color:var(--text); text-decoration:none; box-shadow: inset 0 1px 1px rgba(255,255,255,0.9), 0 2px 5px rgba(0,0,0,0.05); transition:all 0.25s; }
    .cat-filter-3d:hover, .cat-filter-3d.active { transform:translateY(-2px); background:linear-gradient(145deg, #065f46, #043b2c); color:#f2c063; border-color:transparent; box-shadow: inset 0 1px 1px rgba(255,255,255,0.1), 0 6px 14px rgba(5,150,105,0.3); }

    .doc-cta-3d { position:relative; display:inline-flex; align-items:center; gap:8px; padding:13px 24px; border-radius:13px; font-weight:700; font-size:14px; overflow:hidden; transition:transform 0.3s; text-decoration:none; }
    .doc-cta-3d::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg, transparent, rgba(255,255,255,0.5), transparent); animation:docShine 3s ease-in-out infinite; }
    .doc-cta-primary { background:linear-gradient(145deg, #fde68a, #d9a441); color:#03251f; box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -2px 3px rgba(0,0,0,0.15), 0 8px 20px rgba(217,164,65,0.4); }
    .doc-cta-ghost { background:transparent; color:#fff; border:2px solid rgba(255,255,255,0.35); }
    .doc-cta-3d:hover { transform:translateY(-3px); }
</style>

<!-- ================= HERO 3D ================= -->
<section class="news-hero" style="position:relative; overflow:hidden;">
    <div class="doc-orb doc-orb-1"></div>
    <div class="doc-orb doc-orb-2"></div>

    <span class="hero-chip c1" style="z-index:2;">📁 Arsip Resmi</span>
    <span class="hero-chip c2" style="z-index:2;">⬇ Unduh Cepat</span>

    <span class="eyebrow eyebrow-light" style="z-index:2;">Layanan Dokumen</span>
    <h1 style="z-index:2;">Dokumen & <span class="gold-text">Unduhan</span></h1>
    <p style="z-index:2;">Template, pedoman, SOP, formulir, dan dokumen resmi LP3M/LPPAIK UNIMOF.</p>
</section>

<!-- ================= QUOTE + LIVE STATUS 3D ================= -->
<section class="stats reveal">
    <div class="doc-quote-3d" style="grid-column: span 2;">
        <div class="doc-quote-mark">"</div>
        <div style="position:relative; z-index:1; display:flex; align-items:center; gap:18px; flex-wrap:wrap;">
            <div class="ico-doc ico-doc-lg ico-doc-gold"><?= $todayQuote[1] ?></div>
            <div style="flex:1; min-width:240px;">
                <p style="font-family:var(--font-display); font-size:16px; line-height:1.55; margin-bottom:8px; font-style:italic; color:#f2c063; font-weight:600;">
                    <?= $todayQuote[0] ?>
                </p>
                <p style="font-size:12px; opacity:0.7;">
                    📅 <?= date('d M Y') ?> · 📊 Total <?= format_bytes($totalSize) ?> arsip digital
                </p>
            </div>
        </div>
    </div>

    <div style="grid-column: span 2; position:relative; padding:28px; border-radius:22px; background:linear-gradient(145deg, #065f46, #043b2c); border:1px solid rgba(217,164,65,0.25); overflow:hidden; box-shadow: inset 0 1px 1px rgba(255,255,255,0.08), 0 10px 30px rgba(0,0,0,0.25);">
        <div style="position:absolute; top:-50%; right:-30%; width:200px; height:200px; border-radius:50%; background:radial-gradient(circle, rgba(217,164,65,0.2), transparent 70%);"></div>
        <p style="font-size:11px; letter-spacing:0.15em; color:#f2c063; font-weight:800; margin-bottom:14px; position:relative; z-index:1;">🟢 STATUS ARSIP LIVE</p>
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:10px; position:relative; z-index:1;">
            <div class="doc-mini-stat"><div class="doc-mini-num"><?= $thisMonth ?></div><div style="font-size:10px; opacity:0.8; margin-top:4px; color:rgba(255,255,255,0.8);">Baru Bulan Ini</div></div>
            <div class="doc-mini-stat"><div class="doc-mini-num"><?= $newThisWeek ?></div><div style="font-size:10px; opacity:0.8; margin-top:4px; color:rgba(255,255,255,0.8);">Minggu Ini</div></div>
            <div class="doc-mini-stat"><div class="doc-mini-num"><?= format_bytes($totalSize) ?></div><div style="font-size:10px; opacity:0.8; margin-top:4px; color:rgba(255,255,255,0.8);">Total Ukuran</div></div>
        </div>
    </div>
</section>

<!-- ================= TOP DOC CTA 3D ================= -->
<?php if ($topDoc !== false && (int) $topDoc['download_count'] > 0): ?>
<section class="cta-band reveal" style="margin-top:0; margin-bottom:28px;">
    <div style="flex:1; min-width:260px;">
        <span class="eyebrow eyebrow-light">🏆 Juara Unduhan</span>
        <h3><?= e($topDoc['title']) ?></h3>
        <p><?= e(Document::CATEGORY_LABELS[$topDoc['category']] ?? $topDoc['category']) ?> · <?= e(format_bytes((int) $topDoc['file_size'])) ?> · 🏆 <?= (int) $topDoc['download_count'] ?>x unduhan</p>
    </div>
    <div class="cta-actions">
        <a class="doc-cta-3d doc-cta-primary" href="<?= e(url('public/index.php?page=unduhan-unduh&id=' . (int) $topDoc['id'])) ?>">⬇ Unduh Sekarang</a>
    </div>
</section>
<?php endif; ?>

<!-- ================= STATS COUNTER 3D ================= -->
<section class="stats">
    <div class="stat reveal stagger-1" style="position:relative; overflow:hidden;">
        <div style="position:absolute; top:-40px; right:-40px; width:140px; height:140px; border-radius:50%; background:radial-gradient(circle, rgba(217,164,65,0.2), transparent 70%);"></div>
        <div style="display:flex; align-items:center; gap:14px; position:relative; z-index:1;">
            <div class="ico-doc ico-doc-gold">📁</div>
            <div><div class="doc-counter-3d" data-count="<?= (int) $totalDocs ?>" data-suffix="+">0</div><div class="stat-label">Dokumen Tersedia</div></div>
        </div>
    </div>
    <div class="stat reveal stagger-2" style="position:relative; overflow:hidden;">
        <div style="position:absolute; top:-40px; right:-40px; width:140px; height:140px; border-radius:50%; background:radial-gradient(circle, rgba(16,185,129,0.2), transparent 70%);"></div>
        <div style="display:flex; align-items:center; gap:14px; position:relative; z-index:1;">
            <div class="ico-doc">⬇️</div>
            <div><div class="doc-counter-3d" data-count="<?= (int) $totalUnduhan ?>" data-suffix="+">0</div><div class="stat-label">Total Unduhan</div></div>
        </div>
    </div>
    <div class="stat reveal stagger-3" style="position:relative; overflow:hidden;">
        <div style="position:absolute; top:-40px; right:-40px; width:140px; height:140px; border-radius:50%; background:radial-gradient(circle, rgba(59,130,246,0.2), transparent 70%);"></div>
        <div style="display:flex; align-items:center; gap:14px; position:relative; z-index:1;">
            <div class="ico-doc ico-doc-blue">🏷️</div>
            <div><div class="doc-counter-3d" data-count="<?= count(Document::CATEGORY_LABELS) ?>">0</div><div class="stat-label">Kategori</div></div>
        </div>
    </div>
    <div class="stat reveal stagger-4" style="position:relative; overflow:hidden;">
        <div style="position:absolute; top:-40px; right:-40px; width:140px; height:140px; border-radius:50%; background:radial-gradient(circle, rgba(124,58,237,0.2), transparent 70%);"></div>
        <div style="display:flex; align-items:center; gap:14px; position:relative; z-index:1;">
            <div class="ico-doc ico-doc-purple">📋</div>
            <div><div class="doc-counter-3d" data-count="<?= count($fileTypeStats) ?>">0</div><div class="stat-label">Format File</div></div>
        </div>
    </div>
</section>

<!-- ================= MILESTONES 3D ================= -->
<?php if ($milestones !== []): ?>
<section class="section reveal">
    <div class="section-head"><h2>🏆 Milestone Arsip</h2></div>
    <div class="grid" style="grid-template-columns: repeat(<?= min(count($milestones), 4) ?>, 1fr);">
        <?php foreach ($milestones as $m): ?>
            <div class="doc-milestone-3d reveal">
                <div style="display:flex; justify-content:center; margin-bottom:12px;"><div class="ico-doc ico-doc-lg ico-doc-gold"><?= $m[0] ?></div></div>
                <h3 style="font-size:17px;"><?= e($m[1]) ?></h3>
                <p>Pencapaian arsip digital LP3M.</p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= TOP 3 PODIUM 3D ================= -->
<?php if ($top3Docs !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>🔥 Top 3 Dokumen Paling Dicari</h2>
        <span class="chip">Hall of Fame</span>
    </div>

    <div class="podium-3d">
        <?php
        $order = [1, 0, 2]; // Silver, Gold, Bronze
        $rankClass = ['pr-silver', 'pr-gold', 'pr-bronze'];
        foreach ($order as $displayIdx):
            if (!isset($top3Docs[$displayIdx])) continue;
            $top = $top3Docs[$displayIdx];
            $isCenter = $displayIdx === 0;
        ?>
            <div class="podium-item-3d <?= $isCenter ? 'podium-1' : '' ?>">
                <div class="podium-rank-3d <?= $rankClass[$displayIdx] ?>">
                    <?= $displayIdx === 0 ? '👑' : ($displayIdx + 1) ?>
                </div>
                <div style="display:flex; justify-content:center; margin:14px 0 12px;">
                    <div class="ico-doc ico-doc-lg ico-doc-gold">🏆</div>
                </div>
                <h3 style="font-size:<?= $isCenter ? '17px' : '15px' ?>; line-height:1.35; margin-bottom:10px; min-height:<?= $isCenter ? '48px' : '42px' ?>;">
                    <?= e($top['title']) ?>
                </h3>
                <div style="font-size:11px; color:var(--muted); display:flex; flex-direction:column; gap:3px; margin-bottom:10px;">
                    <span><?= e(Document::CATEGORY_LABELS[$top['category']] ?? $top['category']) ?></span>
                    <span><?= e(format_bytes((int) $top['file_size'])) ?></span>
                </div>
                <div style="font-family:var(--font-display); font-size:24px; font-weight:900; color:var(--gold-strong); margin-bottom:12px;">
                    <?= (int) $top['download_count'] ?>x
                </div>
                <a class="download-btn-3d" href="<?= e(url('public/index.php?page=unduhan-unduh&id=' . (int) $top['id'])) ?>" style="width:100%; justify-content:center;">⬇ Unduh</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= DISTRIBUSI KATEGORI 3D ================= -->
<?php if ($totalByCat > 0): ?>
<section class="section reveal">
    <div class="section-head"><h2>📊 Distribusi Kategori Dokumen</h2></div>
    <div style="background:var(--white); border:1px solid var(--border); border-radius:22px; padding:26px; box-shadow:0 6px 20px rgba(0,0,0,0.04);">
        <?php foreach ($categoryStats as $key => $stat):
            $pct = $totalByCat > 0 ? round(($stat['count']/$totalByCat)*100) : 0;
        ?>
            <div style="margin-bottom:18px;">
                <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:13.5px; align-items:center;">
                    <span style="font-weight:800; color:var(--ink);"><?= e($stat['label']) ?></span>
                    <span style="color:var(--muted); font-weight:600;"><strong style="color:var(--primary-dark);"><?= $stat['count'] ?></strong> (<?= $pct ?>%)</span>
                </div>
                <div class="doc-bar-3d"><div class="doc-bar-fill-3d" style="width:<?= $pct ?>%;"></div></div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= FORMAT FILE ================= -->
<?php if ($fileTypeStats !== []): ?>
<section class="section reveal">
    <div class="section-head"><h2>📋 Breakdown Format File</h2></div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <?php foreach ($fileTypeStats as $type => $cnt): 
            $ftClass = 'ft-' . strtolower($type);
        ?>
            <span class="cat-filter-3d" style="cursor:default;">
                <span class="file-type-3d <?= $ftClass ?>" style="width:26px; height:26px; border-radius:8px; font-size:8px;"><?= e($type) ?></span>
                <strong><?= (int) $cnt ?></strong> file
            </span>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= JELAJAHI KATEGORI ================= -->
<?php if ($categoryStats !== []): ?>
<section class="section reveal">
    <div class="section-head"><h2>🏷️ Jelajahi per Kategori</h2></div>
    <div style="display:flex; gap:8px; flex-wrap:wrap;">
        <?php foreach ($categoryStats as $key => $stat): ?>
            <a href="<?= e(url('public/index.php?page=unduhan&category=' . $key)) ?>" class="cat-filter-3d <?= $currentCategory === $key ? 'active' : '' ?>">
                <?= e($stat['label']) ?> <span style="opacity:0.5;">·</span> <strong><?= $stat['count'] ?></strong>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= HEATMAP TIMELINE 3D ================= -->
<?php if ($yearTimeline !== []): ?>
<section class="section reveal">
    <div class="section-head"><h2>📅 Timeline Arsip</h2></div>
    <?php $maxCnt = max(1, max(array_column($yearTimeline, 'cnt'))); ?>
    <div style="background:var(--white); border:1px solid var(--border); border-radius:22px; padding:26px; margin-bottom:16px; box-shadow:0 6px 20px rgba(0,0,0,0.04);">
        <div style="display:flex; align-items:flex-end; gap:10px; height:180px;">
            <?php foreach (array_reverse($yearTimeline) as $y):
                $h = max(12, (int)(($y['cnt']/$maxCnt)*130));
            ?>
                <div class="heatmap-bar-3d" title="<?= (int)$y['cnt'] ?> dokumen">
                    <span style="font-size:11px; font-weight:800; color:var(--primary-dark);"><?= (int)$y['cnt'] ?></span>
                    <div class="heatmap-inner-3d" style="height:<?= $h ?>px;"></div>
                    <span style="font-size:10px; color:var(--muted); font-weight:600;"><?= (int)$y['year'] ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================= MARQUEE ================= -->
<div class="marquee" aria-hidden="true">
    <div class="marquee-track">
        <?php foreach (array_merge($docLabels, $docLabels) as $m): ?>
            <span class="marquee-item"><?= e($m) ?></span>
        <?php endforeach; ?>
    </div>
</div>

<!-- ================= TIPS 3D ================= -->
<section class="section reveal">
    <div class="section-head"><h2>💡 Tips Menggunakan Layanan Ini</h2></div>
    <div class="grid" style="grid-template-columns: repeat(3, 1fr);">
        <div class="doc-tip-3d">
            <div style="display:flex; justify-content:flex-start; margin-bottom:12px;"><div class="ico-doc ico-doc-blue">🔍</div></div>
            <h3>Filter Kategori</h3>
            <p>Gunakan chip kategori untuk menyaring dokumen sesuai kebutuhan.</p>
        </div>
        <div class="doc-tip-3d">
            <div style="display:flex; justify-content:flex-start; margin-bottom:12px;"><div class="ico-doc ico-doc-gold">⬇️</div></div>
            <h3>Unduh Instan</h3>
            <p>Klik tombol "Unduh" — file akan otomatis terunduh tanpa perlu login.</p>
        </div>
        <div class="doc-tip-3d">
            <div style="display:flex; justify-content:flex-start; margin-bottom:12px;"><div class="ico-doc">🔄</div></div>
            <h3>Update Berkala</h3>
            <p>Dokumen terus diperbarui oleh admin. Periksa berkala untuk versi terbaru.</p>
        </div>
    </div>
</section>

<!-- ================= FILTER ================= -->
<div style="display:flex; gap:8px; flex-wrap:wrap; margin:20px 0;">
    <a href="<?= e(url('public/index.php?page=unduhan')) ?>" class="cat-filter-3d <?= $currentCategory === '' ? 'active' : '' ?>">📁 Semua</a>
    <?php foreach (Document::CATEGORY_LABELS as $key => $label): ?>
        <a href="<?= e(url('public/index.php?page=unduhan&category=' . $key)) ?>" class="cat-filter-3d <?= $currentCategory === $key ? 'active' : '' ?>"><?= e($label) ?></a>
    <?php endforeach; ?>
</div>

<?php if ($items === []): ?>
    <p class="news-empty">Belum ada dokumen yang dipublikasikan.</p>
<?php else: ?>
    <p class="filter-count">Menampilkan <?= count($items) ?> dari <?= (int) $totalDocs ?> dokumen.</p>
    <div style="display:flex; flex-direction:column; gap:10px;">
        <?php foreach ($items as $item):
            $ftClass = 'ft-' . strtolower($item['file_type']);
        ?>
            <div class="doc-row-3d reveal">
                <div class="file-type-3d <?= $ftClass ?>"><?= e(strtoupper($item['file_type'])) ?></div>
                <div style="flex:1; min-width:0;">
                    <h3 style="color:var(--ink); font-size:15px; font-weight:800; line-height:1.4; margin:0 0 6px;"><?= e($item['title']) ?></h3>
                    <div style="display:flex; gap:10px; font-size:12px; color:var(--muted); flex-wrap:wrap;">
                        <span class="cat-filter-3d" style="padding:3px 9px; font-size:11px;"><?= e(Document::CATEGORY_LABELS[$item['category']] ?? $item['category']) ?></span>
                        <span>📦 <?= e(format_bytes((int) $item['file_size'])) ?></span>
                        <span>🏆 <?= (int) $item['download_count'] ?>x</span>
                        <span>📅 <?= e(date('d M Y', strtotime($item['created_at']))) ?></span>
                    </div>
                    <?php if (!empty($item['description'])): ?>
                        <p style="font-size:12.5px; color:var(--muted); margin:8px 0 0; line-height:1.5;"><?= e($item['description']) ?></p>
                    <?php endif; ?>
                </div>
                <a class="download-btn-3d" href="<?= e(url('public/index.php?page=unduhan-unduh&id=' . (int) $item['id'])) ?>">⬇ Unduh</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if ($totalPages > 1): ?>
    <div style="display:flex; gap:6px; flex-wrap:wrap; margin-top:22px;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= e(url('public/index.php?page=unduhan&hal=' . $i . ($currentCategory !== '' ? '&category=' . urlencode($currentCategory) : ''))) ?>" class="cat-filter-3d <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

<!-- ================= CTA 3D ================= -->
<section class="cta-band reveal">
    <div>
        <h3>Butuh bantuan?</h3>
        <p>Hubungi admin LP3M jika Anda kesulitan menemukan atau mengunduh dokumen.</p>
    </div>
    <div class="cta-actions">
        <a href="<?= e(url('public/index.php?page=tentang')) ?>" class="doc-cta-3d doc-cta-primary">📞 Kontak Kami</a>
        <a href="<?= e(url('public/index.php?page=berita')) ?>" class="doc-cta-3d doc-cta-ghost">📰 Berita Terbaru</a>
    </div>
</section>