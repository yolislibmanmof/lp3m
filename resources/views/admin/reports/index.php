<style>
    @keyframes rpFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    @keyframes rpShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes rpPulse { 0%,100%{box-shadow:0 0 0 0 rgba(217,164,65,.4)} 50%{box-shadow:0 0 0 8px rgba(217,164,65,0)} }
    @keyframes rpCount { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:none} }

    .rp-head { position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:26px 30px; border-radius:22px; background:linear-gradient(135deg,#78350f 0%,#b45309 55%,#d97706 100%); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:rpFade .5s both; }
    .rp-head::before { content:''; position:absolute; inset:0; opacity:.25; background-image:repeating-linear-gradient(45deg,transparent,transparent 26px,rgba(253,230,138,.08) 26px,rgba(253,230,138,.08) 27px); pointer-events:none; }
    .rp-head::after { content:''; position:absolute; top:-50%; right:-8%; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(253,230,138,.22),transparent 70%); pointer-events:none; }
    .rp-head-ico { width:58px; height:58px; border-radius:17px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:26px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.6),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.65), 0 6px 16px rgba(217,164,65,.4); position:relative; z-index:1; }
    .rp-head-title { position:relative; z-index:1; flex:1; min-width:0; }
    .rp-head h2 { margin:0 0 4px; font-family:var(--font-display); font-size:22px; font-weight:900; letter-spacing:-.015em; }
    .rp-head p { margin:0; font-size:12.5px; opacity:.9; }
    .rp-head .rp-badge-top { display:inline-flex; align-items:center; gap:6px; padding:5px 13px; border-radius:999px; font-size:10.5px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; background:rgba(255,255,255,.16); border:1px solid rgba(255,255,255,.3); margin-bottom:8px; position:relative; z-index:1; }
    .rp-head .rp-badge-top i { width:7px; height:7px; border-radius:50%; background:#fde68a; box-shadow:0 0 6px rgba(253,230,138,.9); animation:rpPulse 2s infinite; }

    .rp-presets { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:14px; padding:12px; background:var(--surface); border:1px solid var(--border); border-radius:14px; animation:rpFade .5s .04s both; }
    .rp-preset { padding:7px 14px; border-radius:999px; border:1px solid var(--border); background:transparent; font-size:11.5px; font-weight:800; color:var(--text); cursor:pointer; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:6px; }
    .rp-preset:hover { border-color:rgba(217,164,65,.45); color:var(--gold-strong); transform:translateY(-2px); }
    .rp-preset.active { background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); color:#03251f; border-color:transparent; box-shadow:0 4px 10px rgba(217,164,65,.3); }
    .rp-preset b { font-size:9.5px; padding:1px 6px; border-radius:999px; background:rgba(255,255,255,.25); }

    .rp-filter { display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end; margin-bottom:22px; padding:18px 20px; background:var(--surface); border:1px solid var(--border); border-radius:16px; animation:rpFade .5s .08s both; }
    .rp-filter label { display:block; font-size:11px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); margin-bottom:6px; }
    .rp-filter input { padding:9px 14px; border-radius:10px; border:1px solid var(--border); background:var(--surface); font-size:13px; font-weight:700; color:var(--text); }
    .rp-filter input:focus { outline:none; border-color:var(--gold-strong); box-shadow:0 0 0 4px rgba(217,164,65,.15); }
    .rp-filter button { position:relative; overflow:hidden; padding:9px 18px; border-radius:10px; border:none; font-size:13px; font-weight:900; cursor:pointer; color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:inset 0 1px 2px rgba(255,255,255,.6), 0 4px 12px rgba(217,164,65,.3); transition:all .2s; font-family:var(--font-display); }
    .rp-filter button::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:rpShine 3s ease-in-out infinite; }
    .rp-filter button:hover { transform:translateY(-2px); filter:brightness(1.05); }
    .rp-filter .spacer { flex:1; }
    .rp-filter a { padding:9px 18px; border-radius:10px; font-size:13px; font-weight:800; text-decoration:none; color:#fff; background:linear-gradient(145deg,#3b82f6,#1e3a8a); box-shadow:0 4px 12px rgba(59,130,246,.3); transition:all .2s; display:inline-flex; align-items:center; gap:6px; }
    .rp-filter a:hover { transform:translateY(-2px); filter:brightness(1.05); }
    .rp-filter a.ghost { background:rgba(255,255,255,.05); border:1px solid var(--border); color:var(--text); box-shadow:none; }
    .rp-filter a.ghost:hover { border-color:rgba(217,164,65,.4); color:var(--gold-strong); }

    .rp-quick { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:14px; margin-bottom:26px; animation:rpFade .5s .12s both; }
    .rp-qcard { position:relative; overflow:hidden; padding:22px; border-radius:18px; background:linear-gradient(135deg,#065f46,#043b2c); color:#fff; box-shadow:0 10px 26px rgba(3,37,31,.25); }
    .rp-qcard::after { content:''; position:absolute; top:-40px; right:-30px; width:140px; height:140px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.2),transparent 70%); pointer-events:none; }
    .rp-qcard::before { content:''; position:absolute; bottom:-30px; left:-20px; width:100px; height:100px; border-radius:50%; background:radial-gradient(circle,rgba(110,231,183,.15),transparent 70%); pointer-events:none; }
    .rp-qcard-ico { font-size:20px; margin-bottom:8px; opacity:.8; }
    .rp-qcard b { display:block; font-family:var(--font-display); font-size:30px; font-weight:900; color:#fde68a; line-height:1; position:relative; z-index:1; }
    .rp-qcard span { font-size:10px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; opacity:.85; margin-top:6px; display:block; position:relative; z-index:1; }
    .rp-qcard .trend { display:inline-flex; align-items:center; gap:4px; margin-top:8px; padding:3px 9px; border-radius:999px; font-size:10px; font-weight:900; position:relative; z-index:1; }
    .rp-qcard .trend.up { background:rgba(16,185,129,.2); color:#6ee7b7; border:1px solid rgba(16,185,129,.4); }
    .rp-qcard .trend.down { background:rgba(220,38,38,.2); color:#fca5a5; border:1px solid rgba(220,38,38,.4); }
    .rp-qcard .trend.neutral { background:rgba(255,255,255,.1); color:rgba(255,255,255,.8); border:1px solid rgba(255,255,255,.2); }

    .rp-2col { display:grid; grid-template-columns:2fr 1fr; gap:18px; margin-bottom:26px; animation:rpFade .5s .16s both; }
    @media(max-width:900px){ .rp-2col{grid-template-columns:1fr;} }
    .rp-panel { background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:22px; position:relative; overflow:hidden; }
    .rp-panel h3 { display:flex; align-items:center; gap:10px; margin:0 0 18px; font-family:var(--font-display); font-size:14px; font-weight:900; color:#fff; padding-bottom:12px; border-bottom:1px dashed var(--border); }
    .rp-panel h3 .emo { width:32px; height:32px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:15px; background:rgba(217,164,65,.14); }
    .rp-panel h3 .num { margin-left:auto; font-size:10px; font-weight:900; letter-spacing:.1em; color:var(--muted); }

    /* Pie chart */
    .rp-pie { width:180px; height:180px; border-radius:50%; margin:0 auto; position:relative; box-shadow:inset 0 0 20px rgba(0,0,0,.05); }
    .rp-pie-center { position:absolute; inset:25%; border-radius:50%; background:var(--surface); display:flex; flex-direction:column; align-items:center; justify-content:center; border:2px solid var(--border); }
    .rp-pie-center b { font-family:var(--font-display); font-size:22px; font-weight:900; color:var(--ink); line-height:1; }
    .rp-pie-center span { font-size:9px; font-weight:800; color:var(--muted); letter-spacing:.1em; text-transform:uppercase; margin-top:3px; }
    .rp-pie-legend { display:flex; flex-direction:column; gap:6px; margin-top:16px; }
    .rp-pie-item { display:flex; align-items:center; gap:8px; padding:6px 10px; border-radius:8px; background:rgba(255,255,255,.02); transition:all .2s; }
    .rp-pie-item:hover { background:rgba(var(--rgb),.08); }
    .rp-pie-dot { width:12px; height:12px; border-radius:4px; background:rgb(var(--rgb)); flex-shrink:0; }
    .rp-pie-item span { font-size:11.5px; color:var(--text); flex:1; }
    .rp-pie-item b { font-family:var(--font-display); font-size:12px; font-weight:900; color:rgb(var(--rgb)); }
    .rp-pie-item em { font-style:normal; font-size:10px; color:var(--muted); margin-left:2px; }

    /* Top modules */
    .rp-top { display:flex; flex-direction:column; gap:10px; }
    .rp-top-item { display:flex; align-items:center; gap:12px; padding:10px 12px; border-radius:12px; background:rgba(255,255,255,.02); border:1px solid var(--border); transition:all .25s; }
    .rp-top-item:hover { border-color:rgba(var(--rgb),.4); transform:translateX(3px); }
    .rp-top-rank { width:28px; height:28px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:12px; font-weight:900; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); flex-shrink:0; }
    .rp-top-rank.r2 { background:linear-gradient(145deg,#e5e7eb,#9ca3af); color:#fff; }
    .rp-top-rank.r3 { background:linear-gradient(145deg,#fdba74,#c2410c); color:#fff; }
    .rp-top-rank.r4 { background:rgba(255,255,255,.08); color:var(--muted); }
    .rp-top-ico { font-size:18px; flex-shrink:0; }
    .rp-top-info { flex:1; min-width:0; }
    .rp-top-info b { display:block; font-size:12.5px; font-weight:800; color:var(--text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .rp-top-info span { font-size:10px; color:var(--muted); }
    .rp-top-count { font-family:var(--font-display); font-size:15px; font-weight:900; color:rgb(var(--rgb)); }

    /* Cards grid */
    .rp-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(270px, 1fr)); gap:18px; margin-bottom:30px; }
    .rp-card { position:relative; overflow:hidden; display:flex; flex-direction:column; gap:10px; padding:24px; border-radius:20px; background:var(--surface); border:1px solid var(--border); box-shadow:0 8px 22px rgba(3,37,31,.06); text-decoration:none; color:inherit; transition:all .3s cubic-bezier(.16,1,.3,1); opacity:0; transform:translateY(16px); }
    .rp-card.in { opacity:1; transform:translateY(0); transition:opacity .5s, transform .5s, box-shadow .3s, border-color .3s; }
    .rp-card.in:hover { transform:translateY(-6px); border-color:rgba(var(--rgb),.45); box-shadow:0 18px 36px rgba(var(--rgb),.18); }
    .rp-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,rgb(var(--rgb)),rgba(var(--rgb),.5)); opacity:.85; }
    .rp-card-top { display:flex; align-items:center; gap:12px; }
    .rp-card-ico { width:48px; height:48px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:22px; background:rgba(var(--rgb),.12); box-shadow:inset 0 2px 4px rgba(255,255,255,.5), 0 4px 10px rgba(var(--rgb),.2); }
    .rp-card h3 { margin:0; font-family:var(--font-display); font-size:16px; font-weight:900; color:var(--text); flex:1; min-width:0; }
    .rp-card-topper { display:inline-flex; align-items:center; gap:4px; padding:2px 8px; border-radius:999px; font-size:9px; font-weight:900; letter-spacing:.08em; background:rgba(245,158,11,.15); color:#f59e0b; border:1px solid rgba(245,158,11,.35); }
    .rp-card-count { font-family:var(--font-display); font-size:34px; font-weight:900; line-height:1; background:linear-gradient(135deg,rgb(var(--rgb)),rgba(var(--rgb),.7)); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .rp-card .sub { font-size:11.5px; color:var(--muted); }
    .rp-card .trend-mini { display:inline-flex; align-items:center; gap:4px; font-size:10.5px; font-weight:800; padding:3px 9px; border-radius:999px; }
    .rp-card .trend-mini.up { background:rgba(16,185,129,.12); color:#047857; border:1px solid rgba(16,185,129,.3); }
    .rp-card .trend-mini.down { background:rgba(220,38,38,.12); color:#991b1b; border:1px solid rgba(220,38,38,.3); }
    .rp-card .trend-mini.neutral { background:rgba(100,116,139,.1); color:var(--muted); border:1px solid var(--border); }
    
    /* Sparkline mini */
    .rp-spark { display:flex; align-items:flex-end; gap:2px; height:28px; margin-top:4px; }
    .rp-spark i { flex:1; background:linear-gradient(180deg,rgb(var(--rgb)),rgba(var(--rgb),.5)); border-radius:2px 2px 0 0; transition:height .6s cubic-bezier(.16,1,.3,1); min-height:2px; }

    .rp-card-acts { display:flex; gap:8px; margin-top:auto; padding-top:14px; border-top:1px dashed var(--border); }
    .rp-card-btn { padding:8px 14px; border-radius:9px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--muted); font-size:11.5px; font-weight:800; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:5px; }
    .rp-card-btn:hover { border-color:rgba(var(--rgb),.45); color:var(--text); transform:translateY(-2px); }
    .rp-card-btn.primary { background:linear-gradient(145deg,rgb(var(--rgb)),rgba(var(--rgb),.8)); color:#fff; border-color:transparent; box-shadow:0 3px 8px rgba(var(--rgb),.3); }
</style>

<?php
$totalAll = array_sum(array_column($summary, 'count'));
$sorted = $summary; uasort($sorted, fn($a,$b) => $b['count'] <=> $a['count']);
$top = array_slice($sorted, 0, 5, true);

// Preset dates
$presets = [
    'today'  => ['label' => '📅 Hari Ini',     's' => date('Y-m-d'), 'e' => date('Y-m-d')],
    'week'   => ['label' => '📆 7 Hari',       's' => date('Y-m-d', strtotime('-6 days')), 'e' => date('Y-m-d')],
    'month'  => ['label' => '🗓️ Bulan Ini',   's' => date('Y-m-01'), 'e' => date('Y-m-d')],
    'year'   => ['label' => '📊 Tahun Ini',    's' => date('Y-01-01'), 'e' => date('Y-m-d')],
    'last'   => ['label' => '⏪ Bulan Lalu',   's' => date('Y-m-01', strtotime('-1 month')), 'e' => date('Y-m-t', strtotime('-1 month'))],
    'q1'     => ['label' => '🎯 Q1',           's' => date('Y-01-01'), 'e' => date('Y-03-31')],
    'q2'     => ['label' => '🎯 Q2',           's' => date('Y-04-01'), 'e' => date('Y-06-30')],
    'q3'     => ['label' => '🎯 Q3',           's' => date('Y-07-01'), 'e' => date('Y-09-30')],
    'q4'     => ['label' => '🎯 Q4',           's' => date('Y-10-01'), 'e' => date('Y-12-31')],
];
$activePreset = '';
foreach ($presets as $k => $p) { if ($p['s'] === $start && $p['e'] === $end) { $activePreset = $k; break; } }

// Pie data
$pieData = [];
$pieColors = [];
foreach ($sorted as $k => $s) { if ($s['count'] > 0) { $pieData[] = [$s['label'], $s['count'], $s['ico'], $s['rgb']]; } }
$pieTotal = max(1, array_sum(array_column($pieData, 1)));
$pieCss = '';
$acc = 0;
foreach ($pieData as $p) {
    $pct = ($p[1] / $pieTotal) * 100;
    $pieCss .= ($pieCss ? ',' : 'conic-gradient(') . 'rgb(' . $p[3] . ') ' . $acc . '% ' . ($acc + $pct) . '%';
    $acc += $pct;
}
if ($pieCss !== '') $pieCss .= ')'; else $pieCss = 'linear-gradient(135deg,#e5e7eb,#cbd5e1)';

// Trend: bandingkan dengan periode sebelumnya (sebelum start)
$prevStart = date('Y-m-d', strtotime($start . ' -' . ((strtotime($end) - strtotime($start)) / 86400 + 1) . ' days'));
$prevEnd   = date('Y-m-d', strtotime($start . ' -1 day'));
$prevSummary = Report::summary($prevStart, $prevEnd);
$prevTotal = array_sum(array_column($prevSummary, 'count'));
$trendPct = $prevTotal > 0 ? round((($totalAll - $prevTotal) / $prevTotal) * 100) : 0;
$trendDir = $trendPct > 0 ? 'up' : ($trendPct < 0 ? 'down' : 'neutral');

// Top performer
$topKey = array_key_first($sorted);
$topCount = $topKey !== null ? $sorted[$topKey]['count'] : 0;
?>

<div class="rp-head">
    <div class="rp-head-ico">📊</div>
    <div class="rp-head-title">
        <span class="rp-badge-top"><i></i> Command Report Center</span>
        <h2>Laporan & Export</h2>
        <p>Dashboard analitik rekap data seluruh modul, grafik distribusi, dan export CSV/PDF untuk laporan pimpinan.</p>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<!-- PRESET FILTER CEPAT -->
<div class="rp-presets">
    <span style="font-size:11px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); padding:7px 4px;">⚡ Preset:</span>
    <?php foreach ($presets as $k => $p): ?>
    <a class="rp-preset <?= $activePreset === $k ? 'active' : '' ?>" href="<?= e(url('admin/index.php?page=laporan&start=' . urlencode($p['s']) . '&end=' . urlencode($p['e']))) ?>">
        <?= e($p['label']) ?>
    </a>
    <?php endforeach; ?>
</div>

<!-- FILTER FORM -->
<form method="get" action="<?= e(url('admin/index.php')) ?>" class="rp-filter">
    <input type="hidden" name="page" value="laporan">
    <div>
        <label>📅 Dari Tanggal</label>
        <input type="date" name="start" value="<?= e($start) ?>">
    </div>
    <div>
        <label>📅 Sampai Tanggal</label>
        <input type="date" name="end" value="<?= e($end) ?>">
    </div>
    <button type="submit">🔍 Terapkan</button>
    <span class="spacer"></span>
    <a href="<?= e(url('admin/index.php?page=laporan-print&start=' . urlencode($start) . '&end=' . urlencode($end))) ?>" target="_blank">🖨️ Print / PDF</a>
    <a class="ghost" href="<?= e(url('admin/index.php?page=laporan-tahunan&tahun=' . date('Y'))) ?>">📅 Laporan Tahunan</a>
</form>

<!-- QUICK STATS -->
<div class="rp-quick">
    <div class="rp-qcard">
        <div class="rp-qcard-ico">📊</div>
        <b data-count="<?= $totalAll ?>"><?= number_format($totalAll) ?></b>
        <span>Total Data Periode</span>
        <span class="trend <?= $trendDir ?>">
            <?= $trendDir === 'up' ? '▲' : ($trendDir === 'down' ? '▼' : '—') ?>
            <?= abs($trendPct) ?>% vs periode lalu
        </span>
    </div>
    <div class="rp-qcard">
        <div class="rp-qcard-ico">🧩</div>
        <b data-count="<?= count($summary) ?>"><?= count($summary) ?></b>
        <span>Modul Terlibat</span>
        <span class="trend neutral">Seluruh modul LP3M</span>
    </div>
    <div class="rp-qcard">
        <div class="rp-qcard-ico">⭐</div>
        <b data-count="<?= $topCount ?>"><?= number_format($topCount) ?></b>
        <span>Top Performer</span>
        <span class="trend up"><?= $topKey !== null ? Report::moduleInfo($topKey)['ico'] . ' ' . e(Report::moduleInfo($topKey)['label']) : '—' ?></span>
    </div>
    <div class="rp-qcard">
        <div class="rp-qcard-ico">📅</div>
        <b><?= e(date('d M', strtotime($start))) ?></b>
        <span><?= e(date('d M Y', strtotime($end))) ?></span>
        <span class="trend neutral"><?= ((strtotime($end) - strtotime($start)) / 86400) + 1 ?> hari</span>
    </div>
</div>

<!-- 2 KOLOM: PIE + TOP -->
<div class="rp-2col">
    <!-- PIE CHART -->
    <div class="rp-panel">
        <h3><span class="emo">🎨</span><span>Distribusi Data Per Modul</span><span class="num">PIE CHART</span></h3>
        <div style="display:grid; grid-template-columns:200px 1fr; gap:24px; align-items:center;">
            <div class="rp-pie" style="background:<?= $pieCss ?>;">
                <div class="rp-pie-center">
                    <b data-count="<?= $totalAll ?>"><?= number_format($totalAll) ?></b>
                    <span>Total</span>
                </div>
            </div>
            <div class="rp-pie-legend">
                <?php foreach ($pieData as $p): $pct = round(($p[1] / $pieTotal) * 100); ?>
                <div class="rp-pie-item" style="--rgb:<?= $p[3] ?>">
                    <span class="rp-pie-dot"></span>
                    <span><?= $p[2] ?> <?= e($p[0]) ?></span>
                    <b><?= $p[1] ?></b>
                    <em>(<?= $pct ?>%)</em>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- TOP 5 MODULES -->
    <div class="rp-panel">
        <h3><span class="emo">🏆</span><span>Top 5 Modul</span><span class="num">RANKING</span></h3>
        <div class="rp-top">
            <?php $rank = 0; foreach ($top as $k => $s): $rank++; 
                $rankClass = $rank === 1 ? '' : ($rank === 2 ? 'r2' : ($rank === 3 ? 'r3' : 'r4'));
                $info = Report::moduleInfo($k);
            ?>
            <div class="rp-top-item" style="--rgb:<?= $s['rgb'] ?>">
                <span class="rp-top-rank <?= $rankClass ?>"><?= $rank ?></span>
                <span class="rp-top-ico"><?= $s['ico'] ?></span>
                <div class="rp-top-info">
                    <b><?= e($s['label']) ?></b>
                    <span><?= round(($s['count'] / $pieTotal) * 100) ?>% dari total</span>
                </div>
                <span class="rp-top-count"><?= number_format($s['count']) ?></span>
            </div>
            <?php endforeach; ?>
            <?php if (empty($top)): ?>
            <div style="text-align:center; padding:20px; color:var(--muted); font-size:12px;">Belum ada data.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- MODULE CARDS -->
<div class="rp-grid">
    <?php $idx = 0; foreach ($summary as $key => $s): 
        $info = Report::moduleInfo($key);
        $prev = $prevSummary[$key]['count'] ?? 0;
        $tPct = $prev > 0 ? round((($s['count'] - $prev) / $prev) * 100) : ($s['count'] > 0 ? 100 : 0);
        $tDir = $tPct > 0 ? 'up' : ($tPct < 0 ? 'down' : 'neutral');
        
        // Mini sparkline: 6 bar (6 bulan terakhir)
        $sparkTrend = Report::monthlyTrend($key);
        $last6 = array_slice($sparkTrend, -6);
        $maxSpark = max(1, ...array_column($last6, 'count'));
        $isTop = $key === $topKey;
        $idx++;
    ?>
    <div class="rp-card" style="--rgb:<?= $s['rgb'] ?>; animation-delay:<?= min($idx * 0.04, 0.4) ?>s">
        <div class="rp-card-top">
            <div class="rp-card-ico"><?= $s['ico'] ?></div>
            <h3><?= e($s['label']) ?></h3>
            <?php if ($isTop): ?><span class="rp-card-topper">⭐ TOP</span><?php endif; ?>
        </div>
        <div style="display:flex; align-items:flex-end; justify-content:space-between; gap:12px;">
            <b class="rp-card-count" data-count="<?= (int) $s['count'] ?>"><?= number_format($s['count']) ?></b>
            <span class="trend-mini <?= $tDir ?>">
                <?= $tDir === 'up' ? '▲' : ($tDir === 'down' ? '▼' : '—') ?>
                <?= abs($tPct) ?>%
            </span>
        </div>
        <span class="sub">data dalam periode ini</span>
        
        <!-- Sparkline -->
        <?php if (!empty($last6)): ?>
        <div class="rp-spark">
            <?php foreach ($last6 as $sp): ?>
            <i style="height:<?= max(6, (int) round($sp['count'] / $maxSpark * 100)) ?>%; --rgb:<?= $s['rgb'] ?>"></i>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="rp-card-acts">
            <a class="rp-card-btn primary" href="<?= e(url('admin/index.php?page=laporan-modul&modul=' . urlencode($key) . '&start=' . urlencode($start) . '&end=' . urlencode($end))) ?>">📈 Detail</a>
            <a class="rp-card-btn" href="<?= e(url('admin/index.php?page=laporan-export-csv&modul=' . urlencode($key) . '&start=' . urlencode($start) . '&end=' . urlencode($end))) ?>">📥 CSV</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
(function(){
    // Count-up
    document.querySelectorAll('[data-count]').forEach(function(el){
        var target = parseInt(el.getAttribute('data-count'), 10) || 0;
        if (target === 0) { el.textContent = '0'; return; }
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

    // Reveal cards
    var cards = document.querySelectorAll('.rp-card');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(es){
            es.forEach(function(en){ if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); } });
        }, { threshold: 0.1 });
        cards.forEach(function(c){ io.observe(c); });
    } else {
        cards.forEach(function(c){ c.classList.add('in'); });
    }
})();
</script>