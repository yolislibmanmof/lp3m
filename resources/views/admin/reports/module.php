<style>
    @keyframes rpmFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    @keyframes rpmShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes rpmPulse { 0%,100%{box-shadow:0 0 0 0 rgba(217,164,65,.4)} 50%{box-shadow:0 0 0 8px rgba(217,164,65,0)} }

    .rpm-back { display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:800; color:#d97706; text-decoration:none; margin-bottom:18px; padding:9px 18px; border-radius:999px; background:var(--surface); border:1px solid var(--border); transition:all .25s; }
    .rpm-back:hover { transform:translateX(-4px); border-color:rgba(217,164,65,.45); box-shadow:0 6px 14px rgba(217,164,65,.15); }

    .rpm-head { position:relative; overflow:hidden; display:flex; gap:16px; padding:24px 28px; border-radius:22px; background:linear-gradient(135deg,rgba(var(--rgb),.16),rgba(var(--rgb),.04)); border:1px solid rgba(var(--rgb),.35); margin-bottom:20px; animation:rpmFade .5s both; }
    .rpm-head::before { content:''; position:absolute; inset:0; opacity:.15; background-image:repeating-linear-gradient(45deg,transparent,transparent 26px,rgba(var(--rgb),.15) 26px,rgba(var(--rgb),.15) 27px); pointer-events:none; }
    .rpm-head::after { content:''; position:absolute; top:-50%; right:-8%; width:280px; height:280px; border-radius:50%; background:radial-gradient(circle,rgba(var(--rgb),.2),transparent 70%); pointer-events:none; }
    .rpm-head .ico { width:56px; height:56px; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:26px; flex-shrink:0; background:rgba(var(--rgb),.18); color:rgb(var(--rgb)); border:1px solid rgba(var(--rgb),.35); position:relative; z-index:1; }
    .rpm-head-info { flex:1; min-width:0; position:relative; z-index:1; }
    .rpm-head-info .tag { display:inline-flex; align-items:center; gap:6px; padding:3px 11px; border-radius:999px; font-size:9.5px; font-weight:900; letter-spacing:.12em; text-transform:uppercase; background:rgba(var(--rgb),.14); color:rgb(var(--rgb)); border:1px solid rgba(var(--rgb),.35); margin-bottom:8px; }
    .rpm-head-info .tag i { width:6px; height:6px; border-radius:50%; background:rgb(var(--rgb)); animation:rpmPulse 2s infinite; }
    .rpm-head h2 { margin:0 0 4px; font-family:var(--font-display); font-size:20px; font-weight:900; color:var(--ink); letter-spacing:-.015em; }
    .rpm-head p { margin:0; font-size:12.5px; color:var(--muted); }
    .rpm-head b { font-family:var(--font-display); font-size:38px; font-weight:900; color:rgb(var(--rgb)); margin-left:auto; line-height:1; position:relative; z-index:1; }

    /* MINI STATS */
    .rpm-stats { display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:12px; margin-bottom:20px; animation:rpmFade .5s .05s both; }
    .rpm-stat { position:relative; overflow:hidden; padding:18px; border-radius:14px; background:var(--surface); border:1px solid var(--border); box-shadow:0 6px 16px rgba(3,37,31,.06); }
    .rpm-stat::after { content:''; position:absolute; top:-30px; right:-25px; width:90px; height:90px; border-radius:50%; background:radial-gradient(circle,rgba(var(--rgb),.15),transparent 70%); pointer-events:none; }
    .rpm-stat .ico { font-size:18px; margin-bottom:6px; opacity:.8; }
    .rpm-stat b { font-family:var(--font-display); font-size:22px; font-weight:900; color:var(--text); line-height:1; display:block; }
    .rpm-stat span { font-size:9.5px; font-weight:800; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); margin-top:4px; display:block; }

    /* CHARTS */
    .rpm-charts { display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:20px; }
    @media(max-width:900px){ .rpm-charts{grid-template-columns:1fr;} }
    .rpm-chart { position:relative; overflow:hidden; background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:22px; animation:rpmFade .5s .08s both; }
    .rpm-chart::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,rgb(var(--rgb)),rgba(var(--rgb),.4)); opacity:.85; }
    .rpm-chart h3 { display:flex; align-items:center; gap:8px; margin:0 0 18px; font-family:var(--font-display); font-size:14px; font-weight:900; color:#fff; }
    .rpm-chart h3 .emo { width:28px; height:28px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:14px; background:rgba(var(--rgb),.14); }
    .rpm-chart h3 .num { margin-left:auto; font-size:10px; font-weight:900; letter-spacing:.1em; color:var(--muted); }
    .rpm-bars { display:flex; align-items:flex-end; gap:8px; height:170px; padding:6px 2px 0; }
    .rpm-bar { flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; height:100%; justify-content:flex-end; }
    .rpm-bar i { width:100%; max-width:40px; border-radius:8px 8px 4px 4px; background:linear-gradient(180deg,rgb(var(--rgb)),rgba(var(--rgb),.55)); box-shadow:inset 0 2px 3px rgba(255,255,255,.35); transition:height .8s cubic-bezier(.16,1,.3,1); position:relative; }
    .rpm-bar i::after { content:attr(data-v); position:absolute; top:-18px; left:50%; transform:translateX(-50%); font-size:10px; font-weight:900; color:var(--muted); }
    .rpm-bar span { font-size:9px; font-weight:800; color:var(--muted); }

    /* TABLE + ACTIONS */
    .rpm-actions { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:18px; padding:14px 16px; background:var(--surface); border:1px solid var(--border); border-radius:14px; animation:rpmFade .5s .1s both; }
    .rpm-btn { position:relative; overflow:hidden; padding:9px 18px; border-radius:10px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--text); font-size:12.5px; font-weight:800; text-decoration:none; transition:all .25s; display:inline-flex; align-items:center; gap:7px; }
    .rpm-btn:hover { border-color:rgba(var(--rgb),.45); transform:translateY(-2px); box-shadow:0 6px 14px rgba(var(--rgb),.15); }
    .rpm-btn.primary { background:linear-gradient(145deg,rgb(var(--rgb)),rgba(var(--rgb),.8)); color:#fff; border-color:transparent; box-shadow:inset 0 1px 2px rgba(255,255,255,.5), 0 4px 12px rgba(var(--rgb),.3); }
    .rpm-btn.primary::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:rpmShine 3s ease-in-out infinite; }

    .rpm-table { width:100%; border-collapse:collapse; background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; animation:rpmFade .5s .14s both; }
    .rpm-table th { padding:12px 16px; text-align:left; font-size:10px; font-weight:900; letter-spacing:.12em; text-transform:uppercase; color:var(--muted); background:rgba(255,255,255,.03); border-bottom:1px solid var(--border); }
    .rpm-table td { padding:12px 16px; border-bottom:1px solid var(--border); font-size:13px; color:var(--text); max-width:220px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .rpm-table tr:last-child td { border-bottom:none; }
    .rpm-table tr:hover td { background:rgba(var(--rgb),.04); }
    .rpm-empty { text-align:center; padding:60px 20px; color:var(--muted); background:var(--surface); border:2px dashed var(--border); border-radius:20px; animation:rpmFade .5s both; }
    .rpm-empty-ico { font-size:52px; margin-bottom:12px; opacity:.7; }
    .rpm-empty h3 { margin:0 0 6px; font-family:var(--font-display); font-size:17px; font-weight:900; color:var(--text); }
    .rpm-empty p { margin:0; font-size:13px; }
    .rpm-note { margin-top:14px; padding:12px 16px; border-radius:12px; background:rgba(var(--rgb),.06); border:1px dashed rgba(var(--rgb),.3); font-size:12px; color:var(--muted); display:flex; align-items:center; gap:8px; animation:rpmFade .5s .18s both; }
    .rpm-note b { color:var(--text); }
</style>

<?php
$counts = array_column($data, null);
$avg = count($monthly) > 0 ? round(array_sum(array_column($monthly, 'count')) / count($monthly), 1) : 0;
$maxMonth = !empty($monthly) ? max($monthly, fn($a,$b) => $a['count'] <=> $b['count']) : null;
$minMonth = !empty($monthly) ? min($monthly, fn($a,$b) => $a['count'] <=> $b['count']) : null;
$monthNames = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
?>

<a class="rpm-back" href="<?= e(url('admin/index.php?page=laporan&start=' . urlencode($start) . '&end=' . urlencode($end))) ?>">← Kembali ke Dashboard Laporan</a>

<div class="rpm-head" style="--rgb:<?= $info['rgb'] ?>">
    <div class="ico"><?= $info['ico'] ?></div>
    <div class="rpm-head-info">
        <span class="tag"><i></i> Laporan Per Modul</span>
        <h2>Laporan <?= e($info['label']) ?></h2>
        <p>Periode: <b><?= e(date('d M Y', strtotime($start))) ?></b> → <b><?= e(date('d M Y', strtotime($end))) ?></b></p>
    </div>
    <b data-count="<?= count($data) ?>"><?= number_format(count($data)) ?></b>
</div>

<!-- MINI STATS -->
<div class="rpm-stats" style="--rgb:<?= $info['rgb'] ?>">
    <div class="rpm-stat">
        <div class="ico">📊</div>
        <b data-count="<?= count($data) ?>"><?= number_format(count($data)) ?></b>
        <span>Total Periode</span>
    </div>
    <div class="rpm-stat">
        <div class="ico">📅</div>
        <b><?= number_format($avg, 1) ?></b>
        <span>Rata-rata / Bulan</span>
    </div>
    <div class="rpm-stat">
        <div class="ico">📈</div>
        <b><?= $maxMonth ? number_format($maxMonth['count']) : '0' ?></b>
        <span>Puncak (<?= $maxMonth ? $monthNames[(int) date('n', strtotime($maxMonth['month'].'-01')) - 1] : '—' ?>)</span>
    </div>
    <div class="rpm-stat">
        <div class="ico">📉</div>
        <b><?= $minMonth ? number_format($minMonth['count']) : '0' ?></b>
        <span>Terendah (<?= $minMonth ? $monthNames[(int) date('n', strtotime($minMonth['month'].'-01')) - 1] : '—' ?>)</span>
    </div>
    <div class="rpm-stat">
        <div class="ico">🗓️</div>
        <b><?= ((strtotime($end) - strtotime($start)) / 86400) + 1 ?></b>
        <span>Rentang Hari</span>
    </div>
</div>

<!-- CHARTS -->
<div class="rpm-charts" style="--rgb:<?= $info['rgb'] ?>">
    <div class="rpm-chart">
        <h3><span class="emo">📅</span><span>Trend Bulanan (12 Bulan Terakhir)</span><span class="num">BAR CHART</span></h3>
        <div class="rpm-bars">
            <?php 
            $maxM = max(1, ...array_column($monthly, 'count'));
            foreach ($monthly as $m): 
            ?>
            <div class="rpm-bar">
                <i data-v="<?= (int) $m['count'] ?>" style="height:<?= max(4, (int) round($m['count'] / $maxM * 100)) ?>%"></i>
                <span><?= $monthNames[(int) date('n', strtotime($m['month'].'-01')) - 1] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="rpm-chart">
        <h3><span class="emo">📊</span><span>Trend Tahunan (5 Tahun Terakhir)</span><span class="num">5 YEAR</span></h3>
        <div class="rpm-bars">
            <?php 
            $maxY = max(1, ...array_column($yearly, 'count'));
            foreach ($yearly as $y): 
            ?>
            <div class="rpm-bar">
                <i data-v="<?= (int) $y['count'] ?>" style="height:<?= max(4, (int) round($y['count'] / $maxY * 100)) ?>%"></i>
                <span><?= (int) $y['year'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- ACTIONS -->
<div class="rpm-actions" style="--rgb:<?= $info['rgb'] ?>">
    <a class="rpm-btn primary" href="<?= e(url('admin/index.php?page=laporan-export-csv&modul=' . urlencode($modul) . '&start=' . urlencode($start) . '&end=' . urlencode($end))) ?>">📥 Export CSV Lengkap</a>
    <a class="rpm-btn" href="<?= e(url('admin/index.php?page=' . $modul)) ?>">🔗 Buka Modul</a>
    <a class="rpm-btn" href="<?= e(url('admin/index.php?page=laporan-print&start=' . urlencode($start) . '&end=' . urlencode($end))) ?>" target="_blank">🖨️ Print Rekap</a>
</div>

<!-- TABLE -->
<?php if (empty($data)): ?>
    <div class="rpm-empty">
        <div class="rpm-empty-ico">📭</div>
        <h3>Tidak Ada Data</h3>
        <p>Tidak ada data pada modul ini untuk periode yang dipilih.</p>
    </div>
<?php else: ?>
<table class="rpm-table">
    <thead>
        <tr>
            <th style="width:40px;">#</th>
            <?php foreach (array_keys($data[0]) as $col): ?>
            <th><?= e(str_replace('_', ' ', ucfirst($col))) ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
    <?php foreach (array_slice($data, 0, 100) as $i => $row): ?>
    <tr>
        <td style="color:var(--muted); font-weight:900;"><?= $i + 1 ?></td>
        <?php foreach ($row as $v): ?>
        <td title="<?= e($v ?? '') ?>"><?= e($v !== null && $v !== '' ? (string) $v : '—') ?></td>
        <?php endforeach; ?>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php if (count($data) > 100): ?>
<div class="rpm-note" style="--rgb:<?= $info['rgb'] ?>">
    💡 <span>Menampilkan <b>100</b> dari <b><?= count($data) ?></b> data terbaru. Klik <b>Export CSV</b> untuk mengunduh data lengkap.</span>
</div>
<?php endif; ?>
<?php endif; ?>

<script>
(function(){
    document.querySelectorAll('[data-count]').forEach(function(el){
        var target = parseInt(el.getAttribute('data-count'), 10) || 0;
        if (target === 0) return;
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