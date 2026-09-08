<?php
$scheme = $item['scheme'] ?? 'internal';
$schemeLabels = Research::SCHEMES;
$schemeLabel = $schemeLabels[$scheme] ?? ucfirst($scheme);
$fieldLabel = !empty($item['field']) ? (Research::FIELDS[$item['field']] ?? $item['field']) : 'Umum';
$funding = (int) ($item['funding'] ?? 0);
$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Status heuristic (bisa diganti dengan field status sebenarnya jika ada)
$currentYear = (int) date('Y');
$itemYear = (int) ($item['year'] ?? $currentYear);
$status = $itemYear >= $currentYear ? 'ongoing' : 'completed';
$statusLabel = $status === 'ongoing' ? 'Sedang Berjalan' : 'Selesai';

$memberCount = !empty($item['members']) ? count(array_filter(explode(',', $item['members']))) + 1 : 1;
?>
<style>
    @keyframes rsdFadeUp { from{opacity:0;transform:translateY(22px)} to{opacity:1;transform:none} }
    @keyframes rsdFloat1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(26px,-30px)} }
    @keyframes rsdFloat2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-28px,24px)} }
    @keyframes rsdShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes rsdPulse { 0%,100%{box-shadow:0 0 0 0 rgba(217,164,65,.45)} 50%{box-shadow:0 0 0 10px rgba(217,164,65,0)} }

    .rsd-wrap { max-width:1100px; margin:0 auto; padding:0 20px; }

    /* ===== BREADCRUMB ===== */
    .rsd-bread { display:flex; align-items:center; gap:8px; font-size:12px; font-weight:700; color:var(--muted); margin-bottom:20px; padding:10px 16px; background:var(--white); border:1px solid var(--border); border-radius:999px; width:fit-content; box-shadow:0 3px 10px rgba(0,0,0,.04); }
    .rsd-bread a { color:#1d4ed8; text-decoration:none; transition:color .2s; }
    .rsd-bread a:hover { color:#1e3a8a; }
    .rsd-bread .sep { opacity:.4; }

    /* ===== HERO ===== */
    .rsd-hero { position:relative; overflow:hidden; border-radius:28px; padding:50px 46px; margin-bottom:28px; color:#fff; background:linear-gradient(135deg,#0c1f4d 0%,#1e3a8a 45%,#1d4ed8 100%); box-shadow:0 26px 64px rgba(12,31,77,.4); animation:rsdFadeUp .6s cubic-bezier(.16,1,.3,1) both; }
    .rsd-hero::before { content:''; position:absolute; inset:0; opacity:.4; background-image:repeating-linear-gradient(45deg,transparent,transparent 28px,rgba(253,230,138,.06) 28px,rgba(253,230,138,.06) 29px),repeating-linear-gradient(-45deg,transparent,transparent 28px,rgba(253,230,138,.06) 28px,rgba(253,230,138,.06) 29px); pointer-events:none; }
    .rsd-hero::after { content:''; position:absolute; top:-40%; right:-10%; width:500px; height:500px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.3),transparent 70%); pointer-events:none; }
    .rsd-orb { position:absolute; border-radius:50%; pointer-events:none; filter:blur(4px); }
    .rsd-orb-1 { width:220px; height:220px; top:-70px; right:-30px; background:radial-gradient(circle at 30% 30%,rgba(253,230,138,.5),rgba(217,164,65,.18) 60%,transparent); animation:rsdFloat1 13s ease-in-out infinite; }
    .rsd-orb-2 { width:260px; height:260px; bottom:-110px; left:-50px; background:radial-gradient(circle at 70% 70%,rgba(96,165,250,.4),rgba(29,78,216,.16) 60%,transparent); animation:rsdFloat2 16s ease-in-out infinite; }
    .rsd-hero-inner { position:relative; z-index:2; }
    .rsd-badge-row { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:14px; }
    .rsd-badge { display:inline-flex; align-items:center; gap:6px; padding:5px 13px; border-radius:999px; font-size:10.5px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; background:rgba(253,230,138,.18); border:1px solid rgba(253,230,138,.4); color:#fde68a; }
    .rsd-badge.ongoing { background:rgba(16,185,129,.18); border-color:rgba(16,185,129,.4); color:#6ee7b7; }
    .rsd-badge.completed { background:rgba(100,116,139,.2); border-color:rgba(100,116,139,.4); color:#cbd5e1; }
    .rsd-title { font-family:var(--font-display); font-size:clamp(26px,3.8vw,40px); font-weight:900; margin:0 0 12px; line-height:1.18; letter-spacing:-.025em; background:linear-gradient(135deg,#fff,#fde68a 55%,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .rsd-sub { opacity:.92; max-width:720px; font-size:14.5px; line-height:1.65; margin:0 0 24px; }
    .rsd-meta-row { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:24px; }
    .rsd-meta-chip { display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border-radius:10px; font-size:12px; font-weight:800; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); backdrop-filter:blur(6px); }
    .rsd-meta-chip i { width:7px; height:7px; border-radius:50%; background:#fde68a; box-shadow:0 0 6px rgba(253,230,138,.8); }

    /* ===== QUICK STATS ===== */
    .rsd-quick { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:14px; margin-bottom:26px; position:relative; z-index:2; }
    .rsd-q { position:relative; overflow:hidden; padding:20px 22px; border-radius:18px; background:linear-gradient(145deg,rgba(255,255,255,.16),rgba(255,255,255,.06)); border:1px solid rgba(255,255,255,.22); backdrop-filter:blur(10px); animation:rsdFadeUp .55s cubic-bezier(.16,1,.3,1) both; }
    .rsd-q:nth-child(2){animation-delay:.07s} .rsd-q:nth-child(3){animation-delay:.14s} .rsd-q:nth-child(4){animation-delay:.21s}
    .rsd-q::after { content:''; position:absolute; top:-40px; right:-30px; width:100px; height:100px; border-radius:50%; background:radial-gradient(circle,rgba(253,230,138,.22),transparent 70%); pointer-events:none; }
    .rsd-q .ico { font-size:20px; margin-bottom:6px; }
    .rsd-q .v { font-family:var(--font-display); font-size:22px; font-weight:900; line-height:1.1; }
    .rsd-q .v.white { color:#fff; }
    .rsd-q .v.gold { background:linear-gradient(135deg,#f2c063,#d9a441); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .rsd-q .l { font-size:9.5px; font-weight:800; text-transform:uppercase; letter-spacing:.12em; opacity:.85; margin-top:5px; }

    /* ===== ACTIONS BAR ===== */
    .rsd-actions-bar { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:24px; }
    .rsd-btn { display:inline-flex; align-items:center; gap:8px; padding:11px 20px; border-radius:12px; font-size:13px; font-weight:800; text-decoration:none; cursor:pointer; border:2px solid var(--border); background:var(--white); color:var(--muted); transition:all .25s; font-family:inherit; }
    .rsd-btn:hover { transform:translateY(-2px); border-color:rgba(29,78,216,.3); color:#1d4ed8; box-shadow:0 8px 18px rgba(29,78,216,.15); }
    .rsd-btn.primary { color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); border-color:transparent; box-shadow:inset 0 2px 3px rgba(255,255,255,.7), 0 6px 14px rgba(217,164,65,.35); position:relative; overflow:hidden; }
    .rsd-btn.primary::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:rsdShine 3s ease-in-out infinite; }
    .rsd-btn.copied { border-color:rgba(5,150,105,.4); color:#059669; background:rgba(5,150,105,.06); }

    /* ===== CARDS ===== */
    .rsd-card { background:var(--white); border:1px solid var(--border); border-radius:24px; padding:34px 38px; box-shadow:0 12px 34px rgba(3,37,31,.06); margin-bottom:22px; position:relative; overflow:hidden; opacity:0; transform:translateY(20px); transition:opacity .6s, transform .6s; }
    .rsd-card.in { opacity:1; transform:translateY(0); }
    .rsd-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#1d4ed8,#3b82f6,#d9a441); opacity:.85; }
    .rsd-section-label { display:flex; align-items:center; gap:12px; font-family:var(--font-display); font-size:15px; font-weight:900; color:var(--ink); margin:0 0 18px; padding-bottom:13px; border-bottom:1px dashed var(--border); }
    .rsd-section-label .emo { display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:11px; background:linear-gradient(145deg,#dbeafe,#bfdbfe); font-size:15px; box-shadow:0 4px 10px rgba(29,78,216,.15); }
    .rsd-section-label .num { margin-left:auto; font-size:10px; font-weight:900; letter-spacing:.12em; color:#9ca3af; }

    /* ===== INFO GRID ===== */
    .rsd-info { display:grid; grid-template-columns:repeat(2,1fr); gap:14px; }
    .rsd-info .row { display:flex; flex-direction:column; gap:6px; padding:16px 18px; border-radius:14px; background:linear-gradient(145deg,#f6faf7,#eef6f1); border:1px solid var(--border); transition:all .25s; }
    .rsd-info .row:hover { border-color:rgba(29,78,216,.3); transform:translateY(-2px); box-shadow:0 8px 18px rgba(29,78,216,.08); }
    .rsd-info .row.full { grid-column:1/-1; }
    .rsd-info .k { font-size:10.5px; font-weight:900; text-transform:uppercase; letter-spacing:.1em; color:var(--muted); display:flex; align-items:center; gap:6px; }
    .rsd-info .v { font-size:14.5px; font-weight:700; color:var(--ink); line-height:1.55; }
    .rsd-info .v a { color:#1d4ed8; text-decoration:none; font-weight:700; }
    .rsd-info .v a:hover { text-decoration:underline; }

    /* ===== DESKRIPSI ===== */
    .rsd-body { font-size:15.5px; line-height:1.9; color:var(--text); white-space:pre-line; }

    /* ===== LUARAN (aksen emas UNIMOF) ===== */
    .rsd-luaran { position:relative; overflow:hidden; padding:24px 26px; border-radius:18px; background:linear-gradient(135deg,#fef7e3 0%,#fef3c7 100%); border:1px solid rgba(217,164,65,.4); }
    .rsd-luaran::before { content:''; position:absolute; top:-30px; right:-20px; width:120px; height:120px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.25),transparent 70%); pointer-events:none; }
    .rsd-luaran::after { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#d9a441,#f2c063,#d9a441); }
    .rsd-luaran .k { position:relative; z-index:1; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:.12em; color:#78350f; margin-bottom:8px; display:flex; align-items:center; gap:8px; }
    .rsd-luaran .v { position:relative; z-index:1; font-size:14.5px; font-weight:600; color:#4a2d05; line-height:1.75; }

    /* ===== AIK INTEGRATION (aksen emas khas UNIMOF) ===== */
    .rsd-aik { position:relative; overflow:hidden; padding:28px 30px; border-radius:20px; background:linear-gradient(135deg,#fef7e3 0%,#fef3c7 100%); border:1px solid rgba(217,164,65,.4); margin-bottom:22px; box-shadow:0 12px 34px rgba(120,53,15,.08); opacity:0; transform:translateY(20px); transition:opacity .6s, transform .6s; }
    .rsd-aik.in { opacity:1; transform:translateY(0); }
    .rsd-aik::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,#d9a441,#f2c063,#d9a441); }
    .rsd-aik::after { content:''; position:absolute; top:-40%; right:-10%; width:360px; height:360px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.2),transparent 70%); pointer-events:none; }
    .rsd-aik-head { display:flex; align-items:center; gap:12px; margin-bottom:16px; padding-bottom:14px; border-bottom:1px dashed rgba(217,164,65,.4); position:relative; z-index:1; }
    .rsd-aik-head .emo { width:40px; height:40px; border-radius:12px; display:inline-flex; align-items:center; justify-content:center; font-size:18px; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); color:#03251f; box-shadow:inset 0 2px 3px rgba(255,255,255,.6), 0 5px 12px rgba(217,164,65,.35); animation:rsdPulse 2.5s ease-in-out infinite; }
    .rsd-aik-head h2 { margin:0; font-family:var(--font-display); font-size:15px; font-weight:900; color:#78350f; letter-spacing:-.01em; }
    .rsd-aik-head .tag { margin-left:auto; padding:3px 11px; border-radius:999px; font-size:9.5px; font-weight:900; letter-spacing:.12em; text-transform:uppercase; background:rgba(120,53,15,.1); color:#78350f; border:1px solid rgba(120,53,15,.25); }
    .rsd-aik-body { position:relative; z-index:1; font-size:14.5px; line-height:1.85; color:#4a2d05; font-weight:500; }

    /* ===== KEYWORDS ===== */
    .rsd-keywords { display:flex; gap:8px; flex-wrap:wrap; margin-top:16px; }
    .rsd-kw { padding:5px 12px; border-radius:999px; font-size:11px; font-weight:800; background:rgba(29,78,216,.08); color:#1e40af; border:1px solid rgba(29,78,216,.2); }

    /* ===== SHARE SECTION ===== */
    .rsd-share { display:flex; gap:10px; flex-wrap:wrap; align-items:center; padding:20px; background:linear-gradient(135deg,rgba(29,78,216,.04),rgba(29,78,216,.01)); border:1px dashed rgba(29,78,216,.25); border-radius:16px; margin-top:24px; }
    .rsd-share-label { font-size:12px; font-weight:800; color:var(--muted); text-transform:uppercase; letter-spacing:.1em; }
    .rsd-share-btn { width:40px; height:40px; border-radius:11px; display:inline-flex; align-items:center; justify-content:center; font-size:16px; text-decoration:none; transition:all .25s; }
    .rsd-share-btn:hover { transform:translateY(-3px); }
    .rsd-share-btn.wa { background:rgba(37,211,102,.1); color:#128c7e; border:1px solid rgba(37,211,102,.3); }
    .rsd-share-btn.fb { background:rgba(24,119,242,.1); color:#1877f2; border:1px solid rgba(24,119,242,.3); }
    .rsd-share-btn.tw { background:rgba(29,161,242,.1); color:#1da1f2; border:1px solid rgba(29,161,242,.3); }
    .rsd-share-btn.mail { background:rgba(234,67,53,.1); color:#ea4335; border:1px solid rgba(234,67,53,.3); }
    .rsd-share-btn.copy { background:rgba(100,116,139,.1); color:#475569; border:1px solid rgba(100,116,139,.3); }

    /* ===== RELATED ===== */
    .rsd-related { margin-top:40px; }
    .rsd-related-head { display:flex; align-items:flex-end; justify-content:space-between; gap:12px; margin-bottom:20px; }
    .rsd-related-head h2 { margin:0; font-family:var(--font-display); font-size:20px; font-weight:900; color:var(--ink); display:flex; align-items:center; gap:10px; }
    .rsd-related-head h2 i { font-style:normal; font-size:18px; }
    .rsd-related-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:16px; }
    .rsd-rel-card { background:var(--white); border:1px solid var(--border); border-radius:18px; padding:20px; text-decoration:none; color:inherit; transition:all .3s; display:block; position:relative; overflow:hidden; }
    .rsd-rel-card:hover { transform:translateY(-4px); border-color:rgba(29,78,216,.4); box-shadow:0 16px 34px rgba(29,78,216,.12); }
    .rsd-rel-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#1d4ed8,#3b82f6); opacity:.7; }
    .rsd-rel-card .rl-scheme { display:inline-block; padding:3px 10px; border-radius:999px; font-size:9px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; background:rgba(29,78,216,.1); color:#1e40af; margin-bottom:10px; }
    .rsd-rel-card h4 { margin:0 0 8px; font-size:14.5px; font-weight:800; color:var(--ink); line-height:1.35; }
    .rsd-rel-card .meta { font-size:11.5px; color:var(--muted); display:flex; flex-wrap:wrap; gap:10px; }

    @media(max-width:700px){
        .rsd-hero { padding:36px 24px; }
        .rsd-card, .rsd-aik { padding:24px 20px; }
        .rsd-info { grid-template-columns:1fr; }
        .rsd-actions-bar { flex-direction:column; align-items:stretch; }
        .rsd-btn { justify-content:center; }
    }
</style>

<div class="rsd-wrap">
    <!-- BREADCRUMB -->
    <nav class="rsd-bread">
        <a href="<?= e(url('public/index.php')) ?>">Beranda</a>
        <span class="sep">›</span>
        <a href="<?= e(url('public/index.php?page=penelitian')) ?>">Penelitian</a>
        <span class="sep">›</span>
        <span style="color:var(--ink);">Detail</span>
    </nav>

    <!-- ===== HERO ===== -->
    <div class="rsd-hero">
        <div class="rsd-orb rsd-orb-1"></div>
        <div class="rsd-orb rsd-orb-2"></div>
        <div class="rsd-hero-inner">
            <div class="rsd-badge-row">
                <span class="rsd-badge">🔬 <?= e($schemeLabel) ?></span>
                <span class="rsd-badge <?= $status ?>"><?= $status === 'ongoing' ? '⚙️ ' : '✅ ' ?><?= $statusLabel ?></span>
            </div>
            <h1 class="rsd-title"><?= e($item['title']) ?></h1>
            <p class="rsd-sub">Penelitian ini merupakan bagian dari program Catur Dharma LP3M UNIMOF untuk memajukan ilmu pengetahuan dan memberikan dampak nyata bagi masyarakat.</p>

            <div class="rsd-meta-row">
                <span class="rsd-meta-chip"><i></i>📅 Tahun <?= (int)$itemYear ?></span>
                <span class="rsd-meta-chip"><i></i>👤 <?= e($item['leader']) ?></span>
                <span class="rsd-meta-chip"><i></i>👥 <?= $memberCount ?> peneliti</span>
                <span class="rsd-meta-chip"><i></i>🏷️ <?= e($fieldLabel) ?></span>
            </div>

            <div class="rsd-quick">
                <div class="rsd-q">
                    <div class="ico">📅</div>
                    <div class="v white"><?= (int)$itemYear ?></div>
                    <div class="l">Tahun Pelaksanaan</div>
                </div>
                <div class="rsd-q">
                    <div class="ico">💰</div>
                    <div class="v gold">Rp <?= number_format($funding, 0, ',', '.') ?></div>
                    <div class="l">Total Pendanaan</div>
                </div>
                <div class="rsd-q">
                    <div class="ico">👥</div>
                    <div class="v white"><?= $memberCount ?></div>
                    <div class="l">Anggota Tim</div>
                </div>
                <div class="rsd-q">
                    <div class="ico">🏷️</div>
                    <div class="v white"><?= e($fieldLabel) ?></div>
                    <div class="l">Bidang Fokus</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== ACTIONS BAR ===== -->
    <div class="rsd-actions-bar">
        <button type="button" class="rsd-btn primary" onclick="window.print()">🖨️ Cetak Laporan</button>
        <button type="button" class="rsd-btn" id="rsd-copy">🔗 Salin Link</button>
        <a class="rsd-btn" href="<?= e(url('public/index.php?page=penelitian')) ?>">⬅️ Semua Penelitian</a>
    </div>

    <!-- ===== TIM PENELITI ===== -->
    <div class="rsd-card">
        <h2 class="rsd-section-label"><span class="emo">👥</span>Tim Peneliti<span class="num">BAGIAN 1 / 5</span></h2>
        <div class="rsd-info">
            <div class="row">
                <span class="k">👤 Ketua Peneliti</span>
                <span class="v"><?= e($item['leader']) ?></span>
            </div>
            <div class="row">
                <span class="k">🔬 Skema Penelitian</span>
                <span class="v"><?= e($schemeLabel) ?></span>
            </div>
            <div class="row">
                <span class="k">🏷️ Bidang Fokus</span>
                <span class="v"><?= e($fieldLabel) ?></span>
            </div>
            <div class="row">
                <span class="k">📅 Tahun Pelaksanaan</span>
                <span class="v"><?= (int)$itemYear ?></span>
            </div>
            <?php if (!empty($item['members'])): ?>
            <div class="row full">
                <span class="k">👥 Anggota Tim Peneliti</span>
                <span class="v"><?= e($item['members']) ?></span>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ===== DESKRIPSI ===== -->
    <?php if (!empty($item['description'])): ?>
    <div class="rsd-card">
        <h2 class="rsd-section-label"><span class="emo">📖</span>Deskripsi Penelitian<span class="num">BAGIAN 2 / 5</span></h2>
        <div class="rsd-body"><?= e($item['description']) ?></div>
        <?php if (!empty($item['keywords'])): ?>
        <div class="rsd-keywords">
            <?php foreach (array_map('trim', explode(',', $item['keywords'])) as $kw): ?>
                <span class="rsd-kw">#<?= e($kw) ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- ===== TARGET LUARAN ===== -->
    <?php if (!empty($item['output_target'])): ?>
    <div class="rsd-card">
        <h2 class="rsd-section-label"><span class="emo">🎯</span>Target Luaran<span class="num">BAGIAN 3 / 5</span></h2>
        <div class="rsd-luaran">
            <div class="k">🎯 Luaran yang Diharapkan</div>
            <div class="v"><?= e($item['output_target']) ?></div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ===== AIK INTEGRATION (aksen emas UNIMOF Muhammadiyah) ===== -->
    <?php if (!empty($item['aik_integration'])): ?>
    <div class="rsd-aik">
        <div class="rsd-aik-head">
            <span class="emo">🕌</span>
            <h2>Integrasi Al-Islam & Kemuhammadiyahan</h2>
            <span class="tag">Khas UNIMOF</span>
        </div>
        <div class="rsd-aik-body"><?= nl2br(e($item['aik_integration'])) ?></div>
    </div>
    <?php endif; ?>

    <!-- ===== INFORMASI TAMBAHAN ===== -->
    <div class="rsd-card">
        <h2 class="rsd-section-label"><span class="emo">ℹ️</span>Informasi Tambahan<span class="num">BAGIAN 4 / 5</span></h2>
        <div class="rsd-info">
            <div class="row">
                <span class="k">🏛️ Lembaga Penanggung Jawab</span>
                <span class="v">LP3M UNIMOF Maumere</span>
            </div>
            <div class="row">
                <span class="k">📊 Status</span>
                <span class="v" style="color:<?= $status === 'ongoing' ? '#059669' : '#64748b' ?>;"><?= $status === 'ongoing' ? '⚙️ ' : '✅ ' ?><?= $statusLabel ?></span>
            </div>
            <?php if (!empty($item['doi']) || !empty($item['journal_name'])): ?>
            <div class="row full">
                <span class="k">📰 Publikasi Jurnal</span>
                <span class="v">
                    <?php if (!empty($item['journal_name'])): ?>
                        <?= e($item['journal_name']) ?>
                    <?php endif; ?>
                    <?php if (!empty($item['doi'])): ?>
                        · DOI: <a href="https://doi.org/<?= e($item['doi']) ?>" target="_blank" rel="noopener"><?= e($item['doi']) ?></a>
                    <?php endif; ?>
                </span>
            </div>
            <?php endif; ?>
            <div class="row full">
                <span class="k">🌐 Tautan Resmi</span>
                <span class="v"><a href="<?= e($currentUrl) ?>"><?= e($currentUrl) ?></a></span>
            </div>
        </div>

        <!-- SHARE SECTION -->
        <div class="rsd-share">
            <span class="rsd-share-label">🔗 Bagikan:</span>
            <a class="rsd-share-btn wa" target="_blank" rel="noopener" href="https://wa.me/?text=<?= urlencode(e($item['title']) . ' — ' . $currentUrl) ?>" title="WhatsApp">💬</a>
            <a class="rsd-share-btn fb" target="_blank" rel="noopener" href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($currentUrl) ?>" title="Facebook">📘</a>
            <a class="rsd-share-btn tw" target="_blank" rel="noopener" href="https://twitter.com/intent/tweet?text=<?= urlencode(e($item['title'])) ?>&url=<?= urlencode($currentUrl) ?>" title="Twitter">🐦</a>
            <a class="rsd-share-btn mail" href="mailto:?subject=<?= urlencode(e($item['title'])) ?>&body=<?= urlencode('Lihat penelitian ini: ' . $currentUrl) ?>" title="Email">✉️</a>
            <button type="button" class="rsd-share-btn copy" id="rsd-copy-2" title="Salin Link">📋</button>
        </div>
    </div>

    <!-- ===== RELATED ===== -->
    <?php if (!empty($related) && count($related) > 0): ?>
    <div class="rsd-related">
        <div class="rsd-related-head">
            <h2><i>🔗</i> Penelitian Terkait</h2>
            <a class="rsd-btn" href="<?= e(url('public/index.php?page=penelitian')) ?>" style="margin:0;">Lihat Semua →</a>
        </div>
        <div class="rsd-related-grid">
            <?php foreach ($related as $r): ?>
            <a class="rsd-rel-card" href="<?= e(url('public/index.php?page=penelitian-detail&id=' . $r['id'])) ?>">
                <span class="rl-scheme"><?= e($schemeLabels[$r['scheme']] ?? $r['scheme']) ?></span>
                <h4><?= e($r['title']) ?></h4>
                <div class="meta">
                    <span>👤 <?= e($r['leader']) ?></span>
                    <span>📅 <?= (int)$r['year'] ?></span>
                    <?php if ((int)$r['funding'] > 0): ?><span>💰 Rp <?= number_format((int)$r['funding'], 0, ',', '.') ?></span><?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
(function(){
    // Copy link
    var btns = [document.getElementById('rsd-copy'), document.getElementById('rsd-copy-2')];
    var url = window.location.href;
    btns.forEach(function(btn){
        if (!btn) return;
        btn.addEventListener('click', function(){
            if (navigator.clipboard) navigator.clipboard.writeText(url);
            var orig = btn.textContent;
            btn.textContent = '✅ Tersalin!';
            btn.classList.add('copied');
            setTimeout(function(){ btn.textContent = orig; btn.classList.remove('copied'); }, 1800);
        });
    });

    // Reveal on scroll
    var cards = document.querySelectorAll('.rsd-card, .rsd-aik');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(entries){
            entries.forEach(function(en){
                if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
            });
        }, { threshold: 0.1 });
        cards.forEach(function(card){ io.observe(card); });
    } else {
        cards.forEach(function(card){ card.classList.add('in'); });
    }
})();
</script>