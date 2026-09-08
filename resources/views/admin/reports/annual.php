<style>
    @keyframes rpaFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    @keyframes rpaShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes rpaCount { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:none} }

    .rpa-head { position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:26px 30px; border-radius:22px; background:linear-gradient(135deg,#78350f 0%,#b45309 55%,#d97706 100%); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:rpaFade .5s both; }
    .rpa-head::before { content:''; position:absolute; inset:0; opacity:.25; background-image:repeating-linear-gradient(45deg,transparent,transparent 26px,rgba(253,230,138,.08) 26px,rgba(253,230,138,.08) 27px); pointer-events:none; }
    .rpa-head::after { content:''; position:absolute; top:-50%; right:-8%; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(253,230,138,.22),transparent 70%); pointer-events:none; }
    .rpa-head-ico { width:58px; height:58px; border-radius:17px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:26px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.6),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.65), 0 6px 16px rgba(217,164,65,.4); position:relative; z-index:1; }
    .rpa-head-title { flex:1; min-width:0; position:relative; z-index:1; }
    .rpa-head-title .tag { display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:999px; font-size:10px; font-weight:900; letter-spacing:.12em; text-transform:uppercase; background:rgba(255,255,255,.16); border:1px solid rgba(255,255,255,.3); margin-bottom:8px; }
    .rpa-head h2 { margin:0 0 4px; font-family:var(--font-display); font-size:22px; font-weight:900; letter-spacing:-.015em; }
    .rpa-head p { margin:0; font-size:12.5px; opacity:.9; }
    .rpa-head b { font-family:var(--font-display); font-size:64px; font-weight:900; color:#fde68a; margin-left:auto; line-height:.9; text-shadow:0 4px 14px rgba(0,0,0,.25); position:relative; z-index:1; }

    /* TOTAL HERO */
    .rpa-total { position:relative; overflow:hidden; padding:34px 36px; border-radius:22px; background:linear-gradient(135deg,#065f46 0%,#043b2c 100%); color:#fff; text-align:center; margin-bottom:24px; box-shadow:0 20px 44px rgba(3,37,31,.35); animation:rpaFade .5s .06s both; }
    .rpa-total::before { content:''; position:absolute; top:-60%; right:-10%; width:380px; height:380px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.25),transparent 70%); pointer-events:none; }
    .rpa-total::after { content:''; position:absolute; bottom:-50%; left:-10%; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle,rgba(110,231,183,.18),transparent 70%); pointer-events:none; }
    .rpa-total .tag { display:inline-flex; align-items:center; gap:6px; padding:5px 14px; border-radius:999px; font-size:10.5px; font-weight:900; letter-spacing:.12em; text-transform:uppercase; background:rgba(253,230,138,.18); border:1px solid rgba(253,230,138,.4); color:#fde68a; margin-bottom:12px; position:relative; z-index:1; }
    .rpa-total b { display:block; font-family:var(--font-display); font-size:72px; font-weight:900; color:#fde68a; line-height:1; text-shadow:0 4px 18px rgba(0,0,0,.35); position:relative; z-index:1; background:linear-gradient(135deg,#fde68a,#f2c063 55%,#d9a441); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .rpa-total span { font-size:13px; opacity:.88; position:relative; z-index:1; display:block; margin-top:10px; }

    /* 3 COLOM CHART TAHUNAN */
    .rpa-charts { display:grid; grid-template-columns:2fr 1fr; gap:18px; margin-bottom:24px; }
    @media(max-width:900px){ .rpa-charts{grid-template-columns:1fr;} }
    .rpa-chart { background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:22px; position:relative; overflow:hidden; animation:rpaFade .5s .1s both; }
    .rpa-chart::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#d97706,#f59e0b,#fde68a); opacity:.85; }
    .rpa-chart h3 { display:flex; align-items:center; gap:10px; margin:0 0 18px; font-family:var(--font-display); font-size:14px; font-weight:900; color:#fff; padding-bottom:12px; border-bottom:1px dashed var(--border); }
    .rpa-chart h3 .emo { width:32px; height:32px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:15px; background:rgba(217,164,65,.14); }
    .rpa-chart h3 .num { margin-left:auto; font-size:10px; font-weight:900; letter-spacing:.1em; color:var(--muted); }

    /* Combined bar chart */
    .rpa-combined { display:flex; align-items:flex-end; gap:8px; height:180px; padding:6px 2px 0; }
    .rpa-comb { flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; height:100%; justify-content:flex-end; }
    .rpa-comb-i { width:100%; max-width:40px; border-radius:8px 8px 4px 4px; background:linear-gradient(180deg,#d97706,rgba(217,119,6,.5)); box-shadow:inset 0 2px 3px rgba(255,255,255,.35); transition:height .8s cubic-bezier(.16,1,.3,1); position:relative; }
    .rpa-comb-i::after { content:attr(data-v); position:absolute; top:-18px; left:50%; transform:translateX(-50%); font-size:10px; font-weight:900; color:var(--muted); white-space:nowrap; }
    .rpa-comb span { font-size:9px; font-weight:800; color:var(--muted); }

    /* Milestones */
    .rpa-mile { display:flex; flex-direction:column; gap:10px; }
    .rpa-mile-item { display:flex; align-items:center; gap:12px; padding:10px 12px; border-radius:12px; background:rgba(255,255,255,.02); border:1px solid var(--border); transition:all .25s; }
    .rpa-mile-item:hover { border-color:rgba(217,164,65,.4); transform:translateX(3px); }
    .rpa-mile-ico { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:17px; background:rgba(var(--rgb),.14); color:rgb(var(--rgb)); flex-shrink:0; }
    .rpa-mile-info { flex:1; min-width:0; }
    .rpa-mile-info b { display:block; font-size:12.5px; font-weight:800; color:var(--text); }
    .rpa-mile-info span { font-size:10px; color:var(--muted); }
    .rpa-mile-count { font-family:var(--font-display); font-size:16px; font-weight:900; color:rgb(var(--rgb)); }

    /* GRID MODUL */
    .rpa-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(250px, 1fr)); gap:16px; margin-bottom:26px; }
    .rpa-card { position:relative; overflow:hidden; padding:22px; border-radius:18px; background:var(--surface); border:1px solid var(--border); box-shadow:0 8px 22px rgba(3,37,31,.06); transition:all .3s; animation:rpaFade .5s both; }
    .rpa-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,rgb(var(--rgb)),rgba(var(--rgb),.4)); opacity:.85; }
    .rpa-card:hover { transform:translateY(-4px); border-color:rgba(var(--rgb),.4); box-shadow:0 16px 32px rgba(var(--rgb),.15); }
    .rpa-card-top { display:flex; align-items:center; gap:12px; margin-bottom:10px; }
    .rpa-card-ico { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; background:rgba(var(--rgb),.14); color:rgb(var(--rgb)); }
    .rpa-card h3 { margin:0; font-family:var(--font-display); font-size:15px; font-weight:900; color:var(--text); flex:1; min-width:0; }
    .rpa-card-rank { display:inline-flex; align-items:center; justify-content:center; width:24px; height:24px; border-radius:8px; font-family:var(--font-display); font-size:10.5px; font-weight:900; background:rgba(255,255,255,.06); color:var(--muted); flex-shrink:0; }
    .rpa-card-rank.gold { background:linear-gradient(145deg,#fde68a,#d9a441); color:#03251f; }
    .rpa-card-rank.silver { background:linear-gradient(145deg,#e5e7eb,#9ca3af); color:#fff; }
    .rpa-card-rank.bronze { background:linear-gradient(145deg,#fdba74,#c2410c); color:#fff; }
    .rpa-card b { font-family:var(--font-display); font-size:30px; font-weight:900; color:rgb(var(--rgb)); line-height:1; }
    .rpa-card .sub { display:block; font-size:11px; color:var(--muted); margin-top:5px; }

    /* Monthly sparkline */
    .rpa-spark { display:flex; align-items:flex-end; gap:2px; height:30px; margin-top:8px; }
    .rpa-spark i { flex:1; background:linear-gradient(180deg,rgb(var(--rgb)),rgba(var(--rgb),.4)); border-radius:2px 2px 0 0; min-height:2px; transition:height .6s cubic-bezier(.16,1,.3,1); }

    /* Perbandingan YoY */
    .rpa-yoy { background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:22px; animation:rpaFade .5s .2s both; }
    .rpa-yoy h3 { display:flex; align-items:center; gap:10px; margin:0 0 16px; font-family:var(--font-display); font-size:14px; font-weight:900; color:#fff; padding-bottom:12px; border-bottom:1px dashed var(--border); }
    .rpa-yoy-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:12px; }
    .rpa-yoy-item { padding:14px; border-radius:12px; background:rgba(255,255,255,.02); border:1px solid var(--border); }
    .rpa-yoy-item .l { font-size:10px; font-weight:800; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); margin-bottom:6px; }
    .rpa-yoy-item .v { display:flex; align-items:baseline; gap:8px; }
    .rpa-yoy-item .v b { font-family:var(--font-display); font-size:20px; font-weight:900; color:var(--text); }
    .rpa-yoy-item .v em { font-style:normal; font-size:11px; font-weight:800; padding:2px 8px; border-radius:999px; }
    .rpa-yoy-item .v em.up { background:rgba(16,185,129,.12); color:#047857; border:1px solid rgba(16,185,129,.3); }
    .rpa-yoy-item .v em.down { background:rgba(220,38,38,.12); color:#991b1b; border:1px solid rgba(220,38,38,.3); }
    .rpa-yoy-item .v em.neutral { background:rgba(100,116,139,.1); color:var(--muted); }
</style>

<?php
// Perbandingan YoY
$prevYear = (int) $report['year'] - 1;
$prevReport = Report::annual($prevYear);
$yoyTotal = $prevReport['total'] > 0 ? round((($report['total'] - $prevReport['total']) / $prevReport['total']) * 100) : 0;
$yoyDir = $yoyTotal > 0 ? 'up' : ($yoyTotal < 0 ? 'down' : 'neutral');

// Ranking modul
$ranked = $report['summary'];
uasort($ranked, fn($a,$b) => $b['count'] <=> $a['count']);

// Monthly total (12 bulan)
$monthlyTotals = [];
$monthNames = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
for ($m = 1; $m <= 12; $m++) {
    $monthlyTotals[$m] = 0;
}
foreach ($report['trends'] as $modul => $trend) {
    foreach ($trend as $t) {
        $mn = (int) date('n', strtotime($t['month'].'-01'));
        $monthlyTotals[$mn] += $t['count'];
    }
}
$maxMonthTotal = max(1, max($monthlyTotals));
?>

<div class="rpa-head">
    <div class="rpa-head-ico">📅</div>
    <div class="rpa-head-title">
        <span class="tag">🎯 Annual Executive Report</span>
        <h2>Laporan Tahunan</h2>
        <p>Rekap lengkap seluruh modul sepanjang tahun <?= (int) $report['year'] ?> — untuk laporan pimpinan dan akreditasi.</p>
    </div>
    <b><?= (int) $report['year'] ?></b>
</div>

<!-- TOTAL HERO -->
<div class="rpa-total">
    <span class="tag">✨ TOTAL KARYA TAHUN <?= (int) $report['year'] ?></span>
    <b data-count="<?= $report['total'] ?>"><?= number_format($report['total']) ?></b>
    <span>entri di seluruh modul LP3M · YoY <b><?= $yoyDir === 'up' ? '▲' : ($yoyDir === 'down' ? '▼' : '—') ?> <?= abs($yoyTotal) ?>%</b> dibanding <?= $prevYear ?></span>
</div>

<!-- CHARTS -->
<div class="rpa-charts">
    <div class="rpa-chart">
        <h3><span class="emo">📊</span><span>Distribusi Bulanan (<?= (int) $report['year'] ?>)</span><span class="num">ALL MODULES</span></h3>
        <div class="rpa-combined">
            <?php foreach ($monthlyTotals as $m => $count): ?>
            <div class="rpa-comb">
                <div class="rpa-comb-i" data-v="<?= number_format($count) ?>" style="height:<?= max(4, (int) round($count / $maxMonthTotal * 100)) ?>%"></div>
                <span><?= $monthNames[$m - 1] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="rpa-chart">
        <h3><span class="emo">🏆</span><span>Milestone Teratas</span><span class="num">TOP 5</span></h3>
        <div class="rpa-mile">
            <?php $i = 0; foreach (array_slice($ranked, 0, 5, true) as $k => $s): $i++;
                $info = Report::moduleInfo($k);
            ?>
            <div class="rpa-mile-item" style="--rgb:<?= $s['rgb'] ?>">
                <div class="rpa-mile-ico"><?= $s['ico'] ?></div>
                <div class="rpa-mile-info">
                    <b><?= e($s['label']) ?></b>
                    <span>#<?= $i ?> modul teraktif</span>
                </div>
                <div class="rpa-mile-count"><?= number_format($s['count']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- GRID MODUL -->
<div class="rpa-grid">
    <?php $rank = 0; foreach ($ranked as $key => $s): $rank++;
        $info = Report::moduleInfo($key);
        $rankClass = $rank === 1 ? 'gold' : ($rank === 2 ? 'silver' : ($rank === 3 ? 'bronze' : ''));
        $trend = $report['trends'][$key] ?? [];
        $maxT = max(1, ...array_column($trend, 'count'));
    ?>
    <div class="rpa-card" style="--rgb:<?= $s['rgb'] ?>; animation-delay:<?= min($rank * 0.04, 0.4) ?>s">
        <div class="rpa-card-top">
            <div class="rpa-card-ico"><?= $s['ico'] ?></div>
            <h3><?= e($s['label']) ?></h3>
            <span class="rpa-card-rank <?= $rankClass ?>">#<?= $rank ?></span>
        </div>
        <b data-count="<?= (int) $s['count'] ?>"><?= number_format($s['count']) ?></b>
        <span class="sub">entri pada tahun <?= (int) $report['year'] ?></span>
        <?php if (!empty($trend)): ?>
        <div class="rpa-spark">
            <?php foreach ($trend as $t): ?>
            <i style="height:<?= max(6, (int) round($t['count'] / $maxT * 100)) ?>%; --rgb:<?= $s['rgb'] ?>"></i>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>

<!-- YOY COMPARISON -->
<div class="rpa-yoy">
    <h3>📈 Perbandingan Year-over-Year (<?= (int) $report['year'] ?> vs <?= $prevYear ?>)</h3>
    <div class="rpa-yoy-grid">
        <?php foreach ($ranked as $key => $s):
            $info = Report::moduleInfo($key);
            $prev = $prevReport['summary'][$key]['count'] ?? 0;
            $diff = $s['count'] - $prev;
            $pct = $prev > 0 ? round(($diff / $prev) * 100) : ($s['count'] > 0 ? 100 : 0);
            $dir = $pct > 0 ? 'up' : ($pct < 0 ? 'down' : 'neutral');
        ?>
        <div class="rpa-yoy-item">
            <div class="l"><?= $s['ico'] ?> <?= e($s['label']) ?></div>
            <div class="v">
                <b><?= number_format($s['count']) ?></b>
                <em class="<?= $dir ?>"><?= $dir === 'up' ? '▲' : ($dir === 'down' ? '▼' : '—') ?> <?= abs($pct) ?>%</em>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
(function(){
    document.querySelectorAll('[data-count]').forEach(function(el){
        var target = parseInt(el.getAttribute('data-count'), 10) || 0;
        if (target === 0) return;
        var start = null;
        function step(t){
            if (!start) start = t;
            var p = Math.min((t - start) / 1100, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(target * eased).toLocaleString('id-ID');
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    });
})();
</script>