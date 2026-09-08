<?php
date_default_timezone_set('Asia/Makassar');
$hour = (int) date('G');
if ($hour >= 4 && $hour < 10)      { $greet = 'Selamat Pagi';  $gico = '🌅'; }
elseif ($hour >= 10 && $hour < 15) { $greet = 'Selamat Siang'; $gico = '☀️'; }
elseif ($hour >= 15 && $hour < 18) { $greet = 'Selamat Sore';  $gico = '🌇'; }
else                               { $greet = 'Selamat Malam'; $gico = '🌙'; }
$firstName = explode(' ', trim((string) ($user['name'] ?? 'Admin')))[0] ?? 'Admin';
$roleLabel = ['super_admin' => 'Super Admin', 'admin_lp3m' => 'Admin LP3M', 'dosen' => 'Dosen', 'reviewer' => 'Reviewer', 'pimpinan' => 'Pimpinan'][$user['role'] ?? ''] ?? 'Admin';
$bulanId = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$monthNames = ['J','F','M','A','M','J','J','A','S','O','N','D'];
?>
<style>
    @keyframes dbFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    @keyframes dbShine { 0%,55%{left:-90%} 100%{left:165%} }

    .db-hero { position:relative; overflow:hidden; border-radius:24px; padding:30px 34px; margin-bottom:22px; color:#fff; background:linear-gradient(135deg,#043b2c 0%,#065f46 55%,#059669 100%); box-shadow:0 18px 44px rgba(3,37,31,.35); animation:dbFade .5s both; }
    .db-hero::after { content:''; position:absolute; top:-50%; right:-8%; width:380px; height:380px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.25),transparent 70%); pointer-events:none; }
    .db-hero-inner { position:relative; z-index:2; display:flex; gap:18px; align-items:center; flex-wrap:wrap; }
    .db-hero h1 { margin:0; font-family:var(--font-display); font-size:clamp(20px,3vw,28px); font-weight:900; letter-spacing:-.02em; }
    .db-hero h1 span { background:linear-gradient(135deg,#fde68a,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .db-hero p { margin:6px 0 0; font-size:13px; opacity:.88; }
    .db-sys { display:flex; gap:8px; flex-wrap:wrap; margin-left:auto; }
    .db-sys span { padding:6px 12px; border-radius:999px; font-size:10.5px; font-weight:800; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); backdrop-filter:blur(6px); }
    .db-sys span.ok { color:#6ee7b7; }
    .db-sys span.bad { color:#fca5a5; }

    /* KPI */
    .db-kpis { display:grid; grid-template-columns:repeat(6,1fr); gap:12px; margin-bottom:22px; }
    @media(max-width:1100px){ .db-kpis{grid-template-columns:repeat(4,1fr);} }
    @media(max-width:760px){ .db-kpis{grid-template-columns:repeat(2,1fr);} }
    .db-kpi { position:relative; overflow:hidden; display:flex; flex-direction:column; gap:6px; padding:16px 16px 14px; border-radius:16px; text-decoration:none; background:var(--surface); border:1px solid var(--border); transition:all .25s; animation:dbFade .5s both; }
    .db-kpi::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:rgb(var(--rgb)); opacity:.8; }
    .db-kpi:hover { transform:translateY(-4px); border-color:rgba(var(--rgb),.5); box-shadow:0 12px 26px rgba(var(--rgb),.18); }
    .db-kpi .ico { font-size:20px; }
    .db-kpi b { font-family:var(--font-display); font-size:24px; font-weight:900; color:var(--text); line-height:1; }
    .db-kpi .l { font-size:10px; font-weight:800; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); }

    /* LAYOUT 2 KOLOM */
    .db-cols { display:grid; grid-template-columns:1.4fr 1fr; gap:18px; margin-bottom:22px; }
    @media(max-width:1000px){ .db-cols{grid-template-columns:1fr;} }
    .db-panel { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:22px 24px; position:relative; overflow:hidden; animation:dbFade .5s .08s both; }
    .db-panel::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,var(--gold-strong),#10b981); opacity:.8; }
    .db-panel h2 { display:flex; align-items:center; gap:10px; margin:0 0 16px; font-family:var(--font-display); font-size:15px; font-weight:900; color:#fff; }
    .db-panel h2 .n { margin-left:auto; font-size:10px; font-weight:900; letter-spacing:.1em; color:var(--muted); }

    /* QUEUE */
    .db-q { display:flex; align-items:center; gap:12px; padding:12px 14px; border-radius:13px; border:1px solid var(--border); background:rgba(255,255,255,.03); margin-bottom:9px; text-decoration:none; transition:all .2s; }
    .db-q:hover { transform:translateX(4px); border-color:rgba(217,164,65,.4); }
    .db-q .qi { width:38px; height:38px; border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0; }
    .db-q.warn .qi { background:rgba(245,158,11,.14); }
    .db-q.danger .qi { background:rgba(220,38,38,.14); }
    .db-q.info .qi { background:rgba(59,130,246,.14); }
    .db-q .qt { flex:1; font-size:13px; font-weight:700; color:var(--text); }
    .db-q .qa { color:var(--muted); font-size:14px; }
    .db-q-empty { text-align:center; padding:26px 10px; color:var(--muted); font-size:13px; font-weight:700; }

    /* CHARTS */
    .db-chart { display:flex; align-items:flex-end; gap:10px; height:130px; padding:6px 2px 0; }
    .db-bar { flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; height:100%; justify-content:flex-end; }
    .db-bar i { width:100%; max-width:34px; border-radius:8px 8px 4px 4px; background:linear-gradient(180deg,#f2c063,#d9a441); box-shadow:inset 0 2px 3px rgba(255,255,255,.4); transition:height .8s cubic-bezier(.16,1,.3,1); position:relative; }
    .db-bar.blue i { background:linear-gradient(180deg,#60a5fa,#2563eb); }
    .db-bar i::after { content:attr(data-v); position:absolute; top:-18px; left:50%; transform:translateX(-50%); font-size:10px; font-weight:900; color:var(--muted); }
    .db-bar span { font-size:9.5px; font-weight:800; color:var(--muted); }
    .db-chart-title { font-size:11px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); margin:18px 0 8px; }

    /* DONUT */
    .db-donut-row { display:flex; align-items:center; gap:18px; margin-top:18px; }
    .db-donut { width:110px; height:110px; border-radius:50%; background:conic-gradient(#10b981 <?= (int) $donutPct ?>%, rgba(255,255,255,.1) 0); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .db-donut b { width:74px; height:74px; border-radius:50%; background:var(--surface); display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:18px; font-weight:900; color:#6ee7b7; }
    .db-donut-legend { font-size:12px; color:var(--muted); line-height:1.9; }
    .db-donut-legend i { display:inline-block; width:10px; height:10px; border-radius:3px; margin-right:6px; }

    /* FEED */
    .db-feed { display:flex; gap:12px; align-items:flex-start; padding:11px 4px; border-bottom:1px dashed var(--border); }
    .db-feed:last-child { border-bottom:none; }
    .db-feed .fi { width:34px; height:34px; border-radius:10px; background:rgba(255,255,255,.06); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:15px; flex-shrink:0; }
    .db-feed .ft { font-size:12.5px; font-weight:700; color:var(--text); }
    .db-feed .fm { font-size:11.5px; color:var(--muted); margin-top:2px; }
    .db-feed .fh { font-size:10px; color:var(--muted); margin-top:3px; opacity:.8; }

    /* QUICK ACTIONS */
    .db-qa { display:grid; grid-template-columns:repeat(6,1fr); gap:10px; }
    @media(max-width:1000px){ .db-qa{grid-template-columns:repeat(3,1fr);} }
    @media(max-width:600px){ .db-qa{grid-template-columns:repeat(2,1fr);} }
    .db-qa a { position:relative; overflow:hidden; display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px 10px; border-radius:15px; text-decoration:none; font-size:11.5px; font-weight:800; color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), 0 6px 14px rgba(217,164,65,.3); transition:all .25s; }
    .db-qa a.green { background:linear-gradient(145deg,#6ee7b7,#10b981 55%,#047857); color:#03251f; box-shadow:inset 0 2px 3px rgba(255,255,255,.5), 0 6px 14px rgba(16,185,129,.3); }
    .db-qa a:hover { transform:translateY(-3px); filter:brightness(1.05); }
    .db-qa a::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:dbShine 3.4s ease-in-out infinite; }
    .db-qa .qi { font-size:20px; }
</style>

<!-- HERO -->
<div class="db-hero">
    <div class="db-hero-inner">
        <div>
            <h1><?= $gico ?> <?= e($greet) ?>, <span><?= e($firstName) ?></span></h1>
            <p>📅 <?= date('d') ?> <?= $bulanId[(int) date('n') - 1] ?> <?= date('Y') ?> · <?= e($roleLabel) ?> · Berikut ringkasan kinerja lembaga hari ini.</p>
        </div>
        <div class="db-sys">
            <span>🐘 PHP <?= e($system['php']) ?></span>
            <span class="ok">🗄️ DB <?= e($system['db']) ?></span>
            <span class="<?= $system['upload'] === 'OK' ? 'ok' : 'bad' ?>">📂 Upload <?= e($system['upload']) ?></span>
            <span>🕐 <?= e($system['time']) ?></span>
        </div>
    </div>
</div>

<!-- KPI -->
<div class="db-kpis">
    <?php foreach ($kpis as $i => $k): ?>
    <a class="db-kpi" style="--rgb:<?= $k['rgb'] ?>; animation-delay:<?= min($i * 0.03, 0.3) ?>s" href="<?= e(url('admin/index.php?page=' . $k['link'])) ?>">
        <span class="ico"><?= $k['icon'] ?></span>
        <b data-count="<?= (int) $k['count'] ?>">0</b>
        <span class="l"><?= e($k['label']) ?></span>
    </a>
    <?php endforeach; ?>
</div>

<!-- 2 KOLOM -->
<div class="db-cols">
    <!-- KIRI: ANTREAN + FEED -->
    <div>
        <div class="db-panel">
            <h2>⚡ Antrean Kerja <span class="n"><?= count($queue) ?> ITEM</span></h2>
            <?php if (empty($queue)): ?>
                <div class="db-q-empty">🎉 Semua pekerjaan selesai. Tidak ada antrean!</div>
            <?php else: foreach ($queue as $q): ?>
                <a class="db-q <?= e($q['tone']) ?>" href="<?= e(url('admin/index.php?page=' . $q['link'])) ?>">
                    <span class="qi"><?= $q['icon'] ?></span>
                    <span class="qt"><?= e($q['text']) ?></span>
                    <span class="qa">→</span>
                </a>
            <?php endforeach; endif; ?>
        </div>

        <div class="db-panel" style="margin-top:18px;">
            <h2>🕘 Aktivitas Terbaru <span class="n">FEED</span></h2>
            <?php if (empty($feed)): ?>
                <div class="db-q-empty">Belum ada aktivitas tercatat.</div>
            <?php else: foreach ($feed as $f): ?>
                <div class="db-feed">
                    <span class="fi"><?= e($f['icon'] ?: '🔔') ?></span>
                    <div style="flex:1;min-width:0;">
                        <div class="ft"><?= e($f['title']) ?></div>
                        <div class="fm"><?= e($f['message']) ?></div>
                        <div class="fh">🕐 <?= e(date('d M Y · H:i', strtotime($f['created_at']))) ?></div>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>

    <!-- KANAN: CHARTS -->
    <div>
        <div class="db-panel">
            <h2>📊 Analitik Lembaga</h2>

            <div class="db-chart-title">🔬 Penelitian · 5 Tahun Terakhir</div>
            <div class="db-chart">
                <?php foreach ($years as $y): ?>
                <div class="db-bar">
                    <i data-v="<?= (int) $y['count'] ?>" style="height:<?= max(6, (int) round($y['count'] / $maxYear * 100)) ?>%"></i>
                    <span><?= (int) $y['year'] ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="db-chart-title">📅 Kegiatan per Bulan · <?= date('Y') ?></div>
            <div class="db-chart" style="height:100px;">
                <?php foreach ($months as $m): ?>
                <div class="db-bar blue">
                    <i data-v="<?= (int) $m['count'] ?>" style="height:<?= max(4, (int) round($m['count'] / $maxMonth * 100)) ?>%"></i>
                    <span><?= $monthNames[$m['m'] - 1] ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="db-chart-title">🔍 Penyelesaian Cek Plagiat</div>
            <div class="db-donut-row">
                <div class="db-donut"><b><?= (int) $donutPct ?>%</b></div>
                <div class="db-donut-legend">
                    <div><i style="background:#10b981;"></i>Selesai · <?= (int) $plagCompleted ?> dokumen</div>
                    <div><i style="background:rgba(255,255,255,.18);"></i>Antrean · <?= (int) $plagQueued ?> dokumen</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QUICK ACTIONS -->
<div class="db-panel">
    <h2>🚀 Aksi Cepat</h2>
    <div class="db-qa">
        <a href="<?= e(url('admin/index.php?page=berita-tambah')) ?>"><span class="qi">📰</span>Tulis Berita</a>
        <a href="<?= e(url('admin/index.php?page=sertifikat-tambah')) ?>"><span class="qi">🎓</span>Terbitkan Sertifikat</a>
        <a class="green" href="<?= e(url('admin/index.php?page=plagiarism-tambah')) ?>"><span class="qi">🔍</span>Cek Plagiat</a>
        <a href="<?= e(url('admin/index.php?page=events-tambah')) ?>"><span class="qi">📅</span>Jadwalkan Kegiatan</a>
        <a class="green" href="<?= e(url('admin/index.php?page=reviewers-tambah')) ?>"><span class="qi">👥</span>Tambah Reviewer</a>
        <a href="<?= e(url('admin/index.php?page=plagiarism-export')) ?>"><span class="qi">📥</span>Export Laporan</a>
    </div>
</div>

<script>
(function(){
    // Count-up KPI
    document.querySelectorAll('[data-count]').forEach(function(el){
        var target = parseInt(el.getAttribute('data-count'), 10) || 0;
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
})();
</script>