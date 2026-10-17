<?php
$typeLabels = [
    'pengabdian'  => 'Pengabdian Dosen',
    'kkn'         => 'Kuliah Kerja Nyata',
    'desa_binaan' => 'Desa Binaan',
];
$typeColor = [
    'pengabdian'  => ['16,185,129', '#047857'],
    'kkn'         => ['245,158,11', '#92400e'],
    'desa_binaan' => ['139,92,246', '#5b21b6'],
];
$tk = $item['type'] ?? 'pengabdian';
[$rgb, $dark] = $typeColor[$tk] ?? $typeColor['pengabdian'];
$label = $typeLabels[$tk] ?? ucfirst($tk);
$memberCount = !empty($item['members']) ? count(array_filter(explode(',', $item['members']))) + 1 : 1;
$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<style>
    @keyframes cdFadeUp { from{opacity:0;transform:translateY(22px)} to{opacity:1;transform:none} }
    @keyframes cdShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes cdPulse { 0%,100%{box-shadow:0 0 0 0 rgba(217,164,65,.45)} 50%{box-shadow:0 0 0 10px rgba(217,164,65,0)} }

    .cd-wrap { max-width:1100px; margin:0 auto; padding:0 20px; }

    .cd-back { display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:800; color:#059669; text-decoration:none; margin-bottom:24px; padding:9px 18px; border-radius:999px; background:#fff; border:1px solid #e3ebe5; transition:all .25s; box-shadow:0 4px 12px rgba(0,0,0,.05); }
    .cd-back:hover { transform:translateX(-4px); color:#065f46; border-color:rgba(5,150,105,.4); box-shadow:0 8px 20px rgba(5,150,105,.18); }

    /* ===== HERO ===== */
    .cd-hero { position:relative; overflow:hidden; border-radius:28px; padding:50px 46px 40px; margin-bottom:28px; color:#fff; background:linear-gradient(135deg,#064e3b 0%,#065f46 45%,#059669 100%); box-shadow:0 26px 64px rgba(6,78,59,.35); animation:cdFadeUp .6s cubic-bezier(.16,1,.3,1) both; }
    .cd-hero::before { content:''; position:absolute; inset:0; opacity:.35; background-image:repeating-linear-gradient(45deg,transparent,transparent 28px,rgba(253,230,138,.06) 28px,rgba(253,230,138,.06) 29px),repeating-linear-gradient(-45deg,transparent,transparent 28px,rgba(253,230,138,.06) 28px,rgba(253,230,138,.06) 29px); pointer-events:none; }
    .cd-hero::after { content:''; position:absolute; top:-40%; right:-8%; width:500px; height:500px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.32),transparent 70%); pointer-events:none; }
    .cd-hero-inner { position:relative; z-index:2; }
    .cd-bread { display:inline-flex; align-items:center; gap:7px; font-size:11px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; color:rgba(253,230,138,.9); margin-bottom:16px; }
    .cd-bread a { color:rgba(253,230,138,.8); text-decoration:none; transition:color .2s; }
    .cd-bread a:hover { color:#fde68a; }
    .cd-badge { display:inline-flex; align-items:center; gap:7px; padding:5px 14px; border-radius:999px; margin-bottom:14px; font-size:10.5px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; background:rgba(253,230,138,.18); border:1px solid rgba(253,230,138,.4); color:#fde68a; }
    .cd-title { font-family:var(--font-display); font-size:clamp(28px,4vw,44px); font-weight:900; margin:0 0 14px; line-height:1.15; letter-spacing:-.025em; background:linear-gradient(135deg,#fff,#fde68a 60%,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; max-width:860px; }
    .cd-sub { font-size:14.5px; line-height:1.7; opacity:.92; max-width:720px; margin:0 0 26px; }
    .cd-hero-meta { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:28px; }
    .cd-meta-chip { display:inline-flex; align-items:center; gap:7px; padding:7px 14px; border-radius:10px; font-size:12px; font-weight:800; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); backdrop-filter:blur(6px); }
    .cd-meta-chip i { width:8px; height:8px; border-radius:50%; background:#fde68a; box-shadow:0 0 8px rgba(253,230,138,.8); }

    /* Stats di hero */
    .cd-stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:10px; position:relative; z-index:2; }
    .cd-stat { background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2); border-radius:16px; padding:14px 18px; backdrop-filter:blur(8px); text-align:left; }
    .cd-stat b { display:block; font-family:var(--font-display); font-size:24px; font-weight:900; color:#fde68a; line-height:1; }
    .cd-stat span { display:block; font-size:10px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; opacity:.85; margin-top:5px; }

    /* ===== CARDS ===== */
    .cd-card { background:#fff; border:1px solid #e3ebe5; border-radius:24px; padding:34px 38px; box-shadow:0 12px 34px rgba(3,37,31,.06); margin-bottom:22px; animation:cdFadeUp .6s cubic-bezier(.16,1,.3,1) .1s both; position:relative; overflow:hidden; }
    .cd-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#059669,#10b981,#d9a441); opacity:.85; }
    .cd-card:nth-child(2) { animation-delay:.15s; }
    .cd-card:nth-child(3) { animation-delay:.2s; }
    .cd-card:nth-child(4) { animation-delay:.25s; }

    .cd-label { display:flex; align-items:center; gap:11px; font-family:var(--font-display); font-size:15px; font-weight:900; color:#0f2419; margin:0 0 18px; padding-bottom:13px; border-bottom:1px dashed #e3ebe5; }
    .cd-label .emo { display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:11px; background:linear-gradient(145deg,#d1fae5,#a7f3d0); font-size:15px; box-shadow:0 4px 10px rgba(16,185,129,.2); }
    .cd-label .num { margin-left:auto; font-size:10px; font-weight:900; letter-spacing:.12em; color:#9ca3af; }

    .cd-info { display:grid; grid-template-columns:repeat(2,1fr); gap:14px; }
    .cd-info .row { display:flex; flex-direction:column; gap:6px; padding:16px 18px; border-radius:14px; background:linear-gradient(145deg,#f6faf7,#eef6f1); border:1px solid #e3ebe5; transition:all .25s; }
    .cd-info .row:hover { border-color:rgba(5,150,105,.3); transform:translateY(-2px); box-shadow:0 6px 16px rgba(5,150,105,.08); }
    .cd-info .row.full { grid-column:1/-1; }
    .cd-info .k { font-size:10.5px; font-weight:900; text-transform:uppercase; letter-spacing:.1em; color:#5b7365; display:flex; align-items:center; gap:6px; }
    .cd-info .v { font-size:14.5px; font-weight:700; color:#0f2419; line-height:1.55; }

    .cd-body { font-size:15.5px; line-height:1.9; color:#374151; white-space:pre-line; }

    /* ===== AIK INTEGRATION (aksen emas khas UNIMOF) ===== */
    .cd-aik-wrap { background:linear-gradient(135deg,#fef7e3 0%,#fef3c7 100%); border:1px solid rgba(217,164,65,.4); border-radius:24px; padding:34px 38px; margin-bottom:22px; position:relative; overflow:hidden; box-shadow:0 14px 38px rgba(120,53,15,.1); animation:cdFadeUp .6s cubic-bezier(.16,1,.3,1) .3s both; }
    .cd-aik-wrap::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,#d9a441,#f2c063,#d9a441); }
    .cd-aik-wrap::after { content:''; position:absolute; top:-40%; right:-10%; width:360px; height:360px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.18),transparent 70%); pointer-events:none; }
    .cd-aik-head { display:flex; align-items:center; gap:12px; margin-bottom:18px; padding-bottom:14px; border-bottom:1px dashed rgba(217,164,65,.4); position:relative; z-index:1; }
    .cd-aik-head .emo { width:40px; height:40px; border-radius:12px; display:inline-flex; align-items:center; justify-content:center; font-size:18px; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); color:#03251f; box-shadow:inset 0 2px 3px rgba(255,255,255,.6), 0 5px 12px rgba(217,164,65,.35); animation:cdPulse 2.5s ease-in-out infinite; }
    .cd-aik-head h2 { margin:0; font-family:var(--font-display); font-size:15px; font-weight:900; color:#78350f; letter-spacing:-.01em; }
    .cd-aik-head .tag { margin-left:auto; padding:3px 11px; border-radius:999px; font-size:9.5px; font-weight:900; letter-spacing:.12em; text-transform:uppercase; background:rgba(120,53,15,.1); color:#78350f; border:1px solid rgba(120,53,15,.25); }
    .cd-aik-body { position:relative; z-index:1; font-size:14.5px; line-height:1.85; color:#4a2d05; font-weight:500; }
    .cd-aik-body b { color:#78350f; }

    /* ===== GALLERY ===== */
    .cd-gallery { display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:10px; }
    .cd-photo { aspect-ratio:1; border-radius:14px; background:linear-gradient(135deg,#d1fae5,#a7f3d0); border:1px solid #e3ebe5; display:flex; align-items:center; justify-content:center; font-size:30px; color:#059669; cursor:pointer; transition:all .25s; }
    .cd-photo:hover { transform:scale(1.03); box-shadow:0 8px 20px rgba(5,150,105,.15); }

    /* ===== ACTIONS ===== */
    .cd-actions { display:flex; gap:12px; flex-wrap:wrap; margin-top:10px; margin-bottom:28px; }
    .cd-action-btn { display:inline-flex; align-items:center; gap:8px; padding:11px 20px; border-radius:12px; font-size:13px; font-weight:800; text-decoration:none; transition:all .25s; cursor:pointer; border:none; font-family:inherit; }
    .cd-action-btn.primary { color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:inset 0 2px 3px rgba(255,255,255,.7), 0 6px 14px rgba(217,164,65,.35); position:relative; overflow:hidden; }
    .cd-action-btn.primary::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:cdShine 3s ease-in-out infinite; }
    .cd-action-btn.ghost { color:#059669; background:transparent; border:2px solid rgba(5,150,105,.3); }
    .cd-action-btn:hover { transform:translateY(-2px); }

    /* ===== RELATED ===== */
    .cd-related { margin-top:40px; }
    .cd-related-head { display:flex; align-items:flex-end; justify-content:space-between; gap:12px; margin-bottom:20px; }
    .cd-related-head h2 { margin:0; font-family:var(--font-display); font-size:22px; font-weight:900; color:#0f2419; display:flex; align-items:center; gap:10px; }
    .cd-related-head h2 i { font-style:normal; font-size:20px; }
    .cd-related-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:16px; }
    .cd-rel-card { background:#fff; border:1px solid #e3ebe5; border-radius:18px; padding:20px; text-decoration:none; color:inherit; transition:all .3s; display:block; position:relative; overflow:hidden; }
    .cd-rel-card:hover { transform:translateY(-4px); border-color:rgba(5,150,105,.4); box-shadow:0 16px 34px rgba(3,37,31,.1); }
    .cd-rel-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#059669,#10b981); opacity:.7; }
    .cd-rel-card .rl-type { display:inline-block; padding:3px 10px; border-radius:999px; font-size:9px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; background:rgba(5,150,105,.1); color:#047857; margin-bottom:10px; }
    .cd-rel-card h4 { margin:0 0 8px; font-size:15px; font-weight:800; color:#0f2419; line-height:1.35; }
    .cd-rel-card .meta { font-size:12px; color:var(--muted); display:flex; flex-wrap:wrap; gap:10px; }

    @media(max-width:640px){
        .cd-card, .cd-aik-wrap { padding:24px 20px; }
        .cd-hero { padding:32px 24px; }
        .cd-info { grid-template-columns:1fr; }
        .cd-actions { flex-direction:column; align-items:stretch; }
        .cd-action-btn { justify-content:center; }
    }
</style>

<div class="cd-wrap">
    <a class="cd-back" href="<?= e(url('public/index.php?page=pengabdian')) ?>">← Kembali ke Daftar Pengabdian</a>

    <!-- ===== HERO ===== -->
    <div class="cd-hero">
        <div class="cd-hero-inner">
            <div class="cd-bread">
                <a href="<?= e(url('public/index.php')) ?>">Beranda</a>
                <span>›</span>
                <a href="<?= e(url('public/index.php?page=pengabdian')) ?>">Pengabdian</a>
                <span>›</span>
                <span>Detail</span>
            </div>
            <span class="cd-badge">🤝 <?= e($label) ?></span>
            <h1 class="cd-title"><?= e($item['title']) ?></h1>
            <p class="cd-sub">Kegiatan pengabdian kepada masyarakat yang dilaksanakan oleh tim dosen UNIMOF sebagai wujud implementasi Tri Dharma Perguruan Tinggi.</p>

            <div class="cd-hero-meta">
                <span class="cd-meta-chip"><i></i>📅 Tahun <?= (int)$item['year'] ?></span>
                <span class="cd-meta-chip"><i></i>📍 <?= e($item['location'] ?: 'Lokasi TBA') ?></span>
                <span class="cd-meta-chip"><i></i>👥 <?= $memberCount ?> anggota tim</span>
                <?php if (!empty($item['partner'])): ?>
                <span class="cd-meta-chip"><i></i>🤝 <?= e(excerpt($item['partner'], 30)) ?></span>
                <?php endif; ?>
            </div>

            <div class="cd-stats">
                <div class="cd-stat"><b><?= (int)$item['year'] ?></b><span>Tahun Pelaksanaan</span></div>
                <div class="cd-stat"><b><?= $memberCount ?></b><span>Anggota Tim</span></div>
                <div class="cd-stat"><b><?= !empty($item['partner']) ? '✓' : '—' ?></b><span>Mitra Pendamping</span></div>
                <div class="cd-stat"><b><?= !empty($item['aik_integration']) ? '✓' : '—' ?></b><span>Integrasi AIK</span></div>
            </div>
        </div>
    </div>

    <!-- ===== AKSI ===== -->
    <div class="cd-actions">
        <button type="button" class="cd-action-btn primary" onclick="window.print()">🖨️ Cetak Laporan</button>
        <button type="button" class="cd-action-btn ghost" id="cd-copy">📋 Salin Link</button>
        <a class="cd-action-btn ghost" href="<?= e(url('public/index.php?page=pengabdian')) ?>">⬅️ Semua Kegiatan</a>
    </div>

    <!-- ===== INFORMASI KEGIATAN ===== -->
    <div class="cd-card">
        <h2 class="cd-label"><span class="emo">📋</span>Informasi Kegiatan<span class="num">BAGIAN 1 / 4</span></h2>
        <div class="cd-info">
            <div class="row">
                <span class="k">👤 Ketua Pelaksana</span>
                <span class="v"><?= e($item['leader']) ?></span>
            </div>
            <div class="row">
                <span class="k">📅 Tahun Pelaksanaan</span>
                <span class="v"><?= (int)$item['year'] ?></span>
            </div>
            <div class="row">
                <span class="k">📍 Lokasi Kegiatan</span>
                <span class="v"><?= e($item['location'] ?: 'Akan Diumumkan') ?></span>
            </div>
            <div class="row">
                <span class="k">🤝 Mitra Kerjasama</span>
                <span class="v"><?= e($item['partner'] ?: 'Tidak ada') ?></span>
            </div>
            <div class="row">
                <span class="k">🏷️ Jenis Kegiatan</span>
                <span class="v"><?= e($label) ?></span>
            </div>
            <div class="row">
                <span class="k">🎯 Status</span>
                <span class="v" style="color:#047857;">✓ Terselesaikan</span>
            </div>
            <?php if (!empty($item['members'])): ?>
            <div class="row full">
                <span class="k">👥 Anggota Tim</span>
                <span class="v"><?= e($item['members']) ?></span>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ===== DESKRIPSI ===== -->
    <?php if (!empty($item['description'])): ?>
    <div class="cd-card">
        <h2 class="cd-label"><span class="emo">📖</span>Deskripsi Kegiatan<span class="num">BAGIAN 2 / 4</span></h2>
        <div class="cd-body"><?= e($item['description']) ?></div>
    </div>
    <?php endif; ?>

    <!-- ===== INTEGRASI AIK (aksen emas UNIMOF Muhammadiyah) ===== -->
    <?php if (!empty($item['aik_integration'])): ?>
    <div class="cd-aik-wrap">
        <div class="cd-aik-head">
            <span class="emo">🕌</span>
            <h2>Integrasi Al-Islam & Kemuhammadiyahan</h2>
            <span class="tag">Khas UNIMOF</span>
        </div>
        <div class="cd-aik-body"><?= e($item['aik_integration']) ?></div>
    </div>
    <?php endif; ?>

    <!-- ===== DOKUMENTASI (placeholder) ===== -->
    <div class="cd-card">
        <h2 class="cd-label"><span class="emo">📸</span>Dokumentasi Kegiatan<span class="num">BAGIAN 3 / 4</span></h2>
        <div class="cd-gallery">
            <div class="cd-photo">📷</div>
            <div class="cd-photo">📷</div>
            <div class="cd-photo">📷</div>
            <div class="cd-photo">📷</div>
        </div>
        <p style="font-size:12px; color:var(--muted); margin-top:12px; text-align:center;">Dokumentasi foto akan ditampilkan setelah diunggah oleh admin.</p>
    </div>

    <!-- ===== INFO TAMBAHAN ===== -->
    <div class="cd-card">
        <h2 class="cd-label"><span class="emo">ℹ️</span>Informasi Tambahan<span class="num">BAGIAN 4 / 4</span></h2>
        <div class="cd-info">
            <div class="row">
                <span class="k">🏛️ Lembaga Penanggung Jawab</span>
                <span class="v">LP3M UNIMOF Maumere</span>
            </div>
            <div class="row">
                <span class="k">📞 Narahubung</span>
                <span class="v">Sekretariat LP3M</span>
            </div>
            <div class="row full">
                <span class="k">🌐 Tautan Resmi</span>
                <span class="v"><a href="<?= e($currentUrl) ?>" style="color:#059669; text-decoration:none; font-weight:800;"><?= e($currentUrl) ?></a></span>
            </div>
        </div>
    </div>

    <!-- ===== RELATED ===== -->
    <?php if (!empty($related) && count($related) > 0): ?>
    <div class="cd-related">
        <div class="cd-related-head">
            <h2><i>🔗</i> Kegiatan Pengabdian Lain</h2>
            <a class="cd-back" href="<?= e(url('public/index.php?page=pengabdian')) ?>" style="margin:0;">Lihat Semua →</a>
        </div>
        <div class="cd-related-grid">
            <?php foreach ($related as $r): ?>
            <a class="cd-rel-card" href="<?= e(url('public/index.php?page=pengabdian-detail&id=' . $r['id'])) ?>">
                <span class="rl-type"><?= e($typeLabels[$r['type']] ?? $r['type']) ?></span>
                <h4><?= e($r['title']) ?></h4>
                <div class="meta">
                    <span>📅 <?= (int)$r['year'] ?></span>
                    <span>👤 <?= e($r['leader']) ?></span>
                    <span>📍 <?= e(excerpt($r['location'], 25)) ?></span>
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
    var btn = document.getElementById('cd-copy');
    if (btn) btn.addEventListener('click', function(){
        var txt = window.location.href;
        if (navigator.clipboard) navigator.clipboard.writeText(txt);
        var orig = btn.textContent;
        btn.textContent = '✅ Tersalin!';
        setTimeout(function(){ btn.textContent = orig; }, 1800);
    });
})();
</script>