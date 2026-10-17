<?php
$now = new DateTime();
$totalFunding = 0;
$activeCount = count($active ?? []);
$closedCount = count($closed ?? []);
$avgDaysLeft = 0;
$daysLeftArr = [];

// Hitung statistik
foreach ($active ?? [] as $g) {
    if (!empty($g['funding_amount'])) {
        $amt = preg_replace('/[^0-9]/', '', $g['funding_amount']);
        $totalFunding += (int) $amt;
    }
    $end = new DateTime($g['deadline']);
    $diff = $now->diff($end);
    $daysLeftArr[] = $diff->days;
}
if (count($daysLeftArr) > 0) {
    $avgDaysLeft = round(array_sum($daysLeftArr) / count($daysLeftArr));
}

// Format total funding
if ($totalFunding >= 1000000000) {
    $totalFundingStr = 'Rp ' . number_format($totalFunding / 1000000000, 1) . ' M';
} elseif ($totalFunding >= 1000000) {
    $totalFundingStr = 'Rp ' . number_format($totalFunding / 1000000, 0) . ' Jt';
} else {
    $totalFundingStr = 'Rp ' . number_format($totalFunding, 0);
}
?>
<style>
    @keyframes grFadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:none} }
    @keyframes grShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes grPulse { 0%{box-shadow:0 0 0 0 rgba(234,88,12,.4)} 70%{box-shadow:0 0 0 10px rgba(234,88,12,0)} 100%{box-shadow:0 0 0 0 rgba(234,88,12,0)} }

    .gr-wrap { max-width:1200px; margin:0 auto; padding:0 20px; }

    /* ===== HERO ===== */
    .gr-hero { position:relative; overflow:hidden; border-radius:28px; padding:58px 46px; margin-bottom:32px; color:#fff; background:linear-gradient(135deg,#7c2d12 0%,#ea580c 50%,#f59e0b 100%); box-shadow:0 26px 64px rgba(124,45,18,.35); animation:grFadeUp .6s cubic-bezier(.16,1,.3,1) both; }
    .gr-hero::before { content:''; position:absolute; inset:0; opacity:.35; background-image:repeating-linear-gradient(45deg,transparent,transparent 28px,rgba(255,255,255,.06) 28px,rgba(255,255,255,.06) 29px),repeating-linear-gradient(-45deg,transparent,transparent 28px,rgba(255,255,255,.06) 28px,rgba(255,255,255,.06) 29px); pointer-events:none; }
    .gr-hero::after { content:''; position:absolute; top:-40%; right:-8%; width:500px; height:500px; border-radius:50%; background:radial-gradient(circle,rgba(253,230,138,.3),transparent 70%); pointer-events:none; }
    .gr-hero-inner { position:relative; z-index:2; }
    .gr-eyebrow { display:inline-flex; align-items:center; gap:7px; padding:5px 14px; border-radius:999px; margin-bottom:16px; font-size:10.5px; font-weight:900; letter-spacing:.16em; text-transform:uppercase; background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.3); color:#fef3c7; }
    .gr-hero h1 { font-family:var(--font-display); font-size:clamp(28px,4vw,44px); font-weight:900; margin:0 0 12px; letter-spacing:-.025em; background:linear-gradient(135deg,#fff,#fef3c7 55%,#fde68a); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .gr-hero p { opacity:.92; max-width:640px; font-size:15px; line-height:1.7; margin:0 0 24px; }
    .gr-stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:12px; }
    .gr-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); border-radius:16px; padding:16px 20px; backdrop-filter:blur(8px); }
    .gr-stat b { display:block; font-family:var(--font-display); font-size:26px; font-weight:900; color:#fef3c7; line-height:1; }
    .gr-stat span { display:block; font-size:10px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; opacity:.88; margin-top:5px; }

    /* ===== FILTER & SORT ===== */
    .gr-controls { display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:26px; padding:14px 18px; background:var(--surface); border:1px solid var(--border); border-radius:16px; animation:grFadeUp .6s .08s both; }
    .gr-filter-chips { display:flex; gap:8px; flex-wrap:wrap; flex:1; }
    .gr-chip { padding:8px 16px; border-radius:999px; border:1px solid var(--border); background:var(--white); font-size:12.5px; font-weight:800; color:var(--text); text-decoration:none; transition:all .25s; cursor:pointer; }
    .gr-chip:hover { border-color:rgba(234,88,12,.4); color:#ea580c; transform:translateY(-2px); }
    .gr-chip.active { background:linear-gradient(145deg,#ea580c,#c2410c); color:#fff; border-color:transparent; box-shadow:0 6px 14px rgba(234,88,12,.3); }
    .gr-sort { padding:8px 14px; border-radius:10px; border:1px solid var(--border); background:var(--white); font-size:12px; font-weight:700; color:var(--text); cursor:pointer; }

    /* ===== GRID ===== */
    .gr-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(340px, 1fr)); gap:22px; margin-bottom:40px; }
    .gr-card { background:#fff; border:1px solid var(--border); border-radius:22px; padding:26px; position:relative; overflow:hidden; transition:all .3s; display:flex; flex-direction:column; opacity:0; transform:translateY(18px); }
    .gr-card.in { opacity:1; transform:translateY(0); transition:opacity .6s cubic-bezier(.16,1,.3,1), transform .6s cubic-bezier(.16,1,.3,1), box-shadow .3s, border-color .3s; }
    .gr-card.in:hover { transform:translateY(-6px); box-shadow:0 22px 44px rgba(124,45,18,.12); border-color:rgba(234,88,12,.35); }
    .gr-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; }
    .gr-card.open::before { background:linear-gradient(90deg,#10b981,#059669); }
    .gr-card.closing::before { background:linear-gradient(90deg,#ea580c,#c2410c); }

    .gr-badge { display:inline-flex; align-items:center; gap:6px; padding:5px 13px; border-radius:999px; font-size:10.5px; font-weight:900; text-transform:uppercase; letter-spacing:.1em; margin-bottom:14px; width:fit-content; }
    .gr-badge.open { background:rgba(5,150,105,.1); color:#047857; border:1px solid rgba(5,150,105,.3); }
    .gr-badge.closing { background:rgba(234,88,12,.12); color:#c2410c; border:1px solid rgba(234,88,12,.35); animation:grPulse 2s infinite; }
    .gr-badge.popular { background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); color:#03251f; border:1px solid rgba(217,164,65,.5); margin-left:8px; position:relative; overflow:hidden; }
    .gr-badge.popular::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:grShine 3s ease-in-out infinite; }

    .gr-source { font-size:11px; font-weight:900; color:var(--muted); text-transform:uppercase; letter-spacing:.12em; margin-bottom:8px; }
    .gr-title { font-family:var(--font-display); font-size:18px; font-weight:800; color:var(--ink); margin:0 0 14px; line-height:1.4; letter-spacing:-.01em; }
    .gr-meta { display:flex; flex-direction:column; gap:8px; margin-bottom:18px; font-size:13px; color:var(--text); }
    .gr-meta span { display:flex; align-items:center; gap:8px; }
    .gr-funding { font-weight:800; color:#047857; font-size:15px; background:rgba(5,150,105,.08); padding:2px 10px; border-radius:8px; display:inline-block; }

    /* Progress bar deadline */
    .gr-progress { margin-bottom:16px; }
    .gr-progress-head { display:flex; justify-content:space-between; margin-bottom:6px; font-size:11px; font-weight:800; }
    .gr-progress-head .label { color:var(--muted); text-transform:uppercase; letter-spacing:.08em; }
    .gr-progress-head .value { color:var(--ink); }
    .gr-bar { height:8px; border-radius:999px; background:rgba(0,0,0,.06); overflow:hidden; }
    .gr-bar i { display:block; height:100%; border-radius:999px; transition:width 1s cubic-bezier(.16,1,.3,1); }
    .gr-card.open .gr-bar i { background:linear-gradient(90deg,#10b981,#059669); }
    .gr-card.closing .gr-bar i { background:linear-gradient(90deg,#ea580c,#c2410c); }

    /* Countdown */
    .gr-countdown { display:flex; gap:8px; margin-bottom:16px; }
    .gr-cd { flex:1; background:rgba(234,88,12,.06); border:1px solid rgba(234,88,12,.18); border-radius:10px; padding:8px 6px; text-align:center; }
    .gr-cd b { display:block; font-family:var(--font-display); font-size:18px; font-weight:900; color:#c2410c; line-height:1; }
    .gr-cd span { font-size:8.5px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--muted); margin-top:3px; display:block; }

    .gr-deadline { margin-top:auto; padding-top:16px; border-top:1px dashed var(--border); display:flex; justify-content:space-between; align-items:center; gap:10px; }
    .gr-deadline-text { font-size:12px; font-weight:800; color:#c2410c; }
    .gr-btn-group { display:flex; gap:8px; }
    .gr-btn { padding:9px 16px; border-radius:11px; font-size:12px; font-weight:800; text-decoration:none; transition:all .25s; display:inline-flex; align-items:center; gap:6px; position:relative; overflow:hidden; }
    .gr-btn-primary { color:#fff; background:linear-gradient(145deg,#ea580c,#c2410c); box-shadow:0 6px 14px rgba(234,88,12,.3); }
    .gr-btn-primary::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:grShine 3s ease-in-out infinite; }
    .gr-btn-primary:hover { transform:translateY(-2px); filter:brightness(1.08); }
    .gr-btn-ghost { color:#047857; background:rgba(5,150,105,.08); border:1px solid rgba(5,150,105,.3); }
    .gr-btn-ghost:hover { background:rgba(5,150,105,.15); }

    /* ===== EMPTY ===== */
    .gr-empty { text-align:center; padding:70px 24px; background:linear-gradient(145deg,rgba(234,88,12,.05),rgba(234,88,12,.02)); border:2px dashed rgba(234,88,12,.3); border-radius:24px; animation:grFadeUp .6s both; }
    .gr-empty-ico { font-size:56px; margin-bottom:14px; opacity:.7; }
    .gr-empty h3 { font-family:var(--font-display); font-size:20px; font-weight:900; color:var(--ink); margin:0 0 8px; }
    .gr-empty p { font-size:14px; color:var(--muted); margin:0; max-width:420px; margin-left:auto; margin-right:auto; }

    /* ===== ARSIP ACCORDION ===== */
    .gr-archive { margin-top:50px; animation:grFadeUp .6s .2s both; }
    .gr-archive-head { display:flex; align-items:center; gap:12px; padding:18px 22px; background:var(--surface); border:1px solid var(--border); border-radius:16px; cursor:pointer; transition:all .25s; margin-bottom:16px; }
    .gr-archive-head:hover { border-color:rgba(234,88,12,.3); background:rgba(234,88,12,.03); }
    .gr-archive-head h3 { margin:0; font-family:var(--font-display); font-size:16px; font-weight:900; color:var(--ink); flex:1; display:flex; align-items:center; gap:10px; }
    .gr-archive-head .count { padding:3px 11px; border-radius:999px; font-size:10px; font-weight:900; background:rgba(220,38,38,.1); color:#dc2626; border:1px solid rgba(220,38,38,.3); }
    .gr-archive-head .arrow { font-size:14px; color:var(--muted); transition:transform .3s; }
    .gr-archive-head.open .arrow { transform:rotate(180deg); }
    .gr-archive-body { display:none; flex-direction:column; gap:10px; }
    .gr-archive-body.open { display:flex; }
    .gr-archive-item { padding:16px 20px; background:var(--surface); border:1px solid var(--border); border-radius:12px; display:flex; justify-content:space-between; align-items:center; opacity:.75; transition:all .25s; }
    .gr-archive-item:hover { opacity:1; border-color:rgba(234,88,12,.25); }
    .gr-archive-item .info h4 { margin:0 0 4px; font-size:14px; font-weight:800; color:var(--ink); }
    .gr-archive-item .info span { font-size:12px; color:var(--muted); }
    .gr-archive-item .status { font-size:10px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:#dc2626; background:rgba(220,38,38,.1); padding:4px 11px; border-radius:8px; border:1px solid rgba(220,38,38,.3); }

    @media(max-width:768px){
        .gr-stats { grid-template-columns:1fr; }
        .gr-controls { flex-direction:column; align-items:stretch; }
        .gr-filter-chips { flex-wrap:wrap; }
    }
</style>

<div class="gr-wrap">
    <!-- ===== HERO ===== -->
    <section class="gr-hero">
        <div class="gr-hero-inner">
            <span class="gr-eyebrow">🔥 Peluang Pendanaan Aktif</span>
            <h1>Hibah Penelitian & Pengabdian</h1>
            <p>Jangan lewatkan kesempatan pendanaan untuk proposal penelitian dan pengabdian Anda. Cek deadline dan segera ajukan!</p>
            <div class="gr-stats">
                <div class="gr-stat"><b><?= $activeCount ?></b><span>Hibah Aktif</span></div>
                <div class="gr-stat"><b><?= $totalFundingStr ?></b><span>Total Pendanaan</span></div>
                <div class="gr-stat"><b><?= $avgDaysLeft ?> hari</b><span>Rata-rata Deadline</span></div>
            </div>
        </div>
    </section>

    <!-- ===== FILTER & SORT ===== -->
    <?php if (!empty($active)): ?>
    <div class="gr-controls">
        <div class="gr-filter-chips">
            <button type="button" class="gr-chip active" data-filter="all">✨ Semua</button>
            <button type="button" class="gr-chip" data-filter="open">✅ Dibuka</button>
            <button type="button" class="gr-chip" data-filter="closing">⚠️ Segera Tutup</button>
        </div>
        <select class="gr-sort" id="gr-sort">
            <option value="deadline-asc">⏰ Deadline Terdekat</option>
            <option value="deadline-desc">📅 Deadline Terlama</option>
            <option value="funding-desc">💰 Pendanaan Terbesar</option>
            <option value="funding-asc">💵 Pendanaan Terkecil</option>
        </select>
    </div>
    <?php endif; ?>

    <!-- ===== GRID HIBAH ===== -->
    <?php if (empty($active)): ?>
        <div class="gr-empty">
            <div class="gr-empty-ico">📭</div>
            <h3>Belum Ada Hibah Aktif</h3>
            <p>Saat ini belum ada peluang pendanaan yang dibuka. Silakan cek kembali nanti atau hubungi sekretariat LP3M untuk informasi terbaru.</p>
        </div>
    <?php else: ?>
        <div class="gr-grid" id="gr-grid">
            <?php foreach ($active as $i => $g): 
                $now = new DateTime();
                $end = new DateTime($g['deadline']);
                $diff = $now->diff($end);
                $daysLeft = $diff->days;
                $isClosing = ($g['status'] === 'closing_soon' || $daysLeft <= 7);
                $cardClass = $isClosing ? 'closing' : 'open';
                
                // Hitung progress (asumsi hibah dibuka 60 hari sebelum deadline)
                $start = clone $end;
                $start->modify('-60 days');
                $totalDays = 60;
                $daysPassed = $now->diff($start)->days;
                $progress = min(100, max(0, ($daysPassed / $totalDays) * 100));
                
                // Parse funding amount untuk sorting
                $fundingNum = 0;
                if (!empty($g['funding_amount'])) {
                    $fundingNum = (int) preg_replace('/[^0-9]/', '', $g['funding_amount']);
                }
            ?>
            <div class="gr-card <?= $cardClass ?>" 
                 data-status="<?= $cardClass ?>" 
                 data-deadline="<?= strtotime($g['deadline']) ?>"
                 data-funding="<?= $fundingNum ?>"
                 data-end="<?= $end->getTimestamp() ?>">
                
                <div>
                    <span class="gr-badge <?= $cardClass ?>">
                        <?= $isClosing ? '⚠️ Segera Tutup' : '✅ Dibuka' ?>
                    </span>
                    <?php if (!empty($g['popular'])): ?>
                    <span class="gr-badge popular">🔥 Populer</span>
                    <?php endif; ?>
                </div>
                
                <div class="gr-source"><?= e($g['source']) ?></div>
                <h3 class="gr-title"><?= e($g['title']) ?></h3>
                
                <div class="gr-meta">
                    <span>🏷️ <?= e(ucfirst(str_replace('_', ' ', $g['type']))) ?></span>
                    <?php if (!empty($g['funding_amount'])): ?>
                        <span>💰 <span class="gr-funding"><?= e($g['funding_amount']) ?></span></span>
                    <?php endif; ?>
                    <span>📅 <?= e(date('d M Y', strtotime($g['deadline']))) ?></span>
                </div>

                <!-- Progress bar -->
                <div class="gr-progress">
                    <div class="gr-progress-head">
                        <span class="label">Progress Deadline</span>
                        <span class="value"><?= round($progress) ?>%</span>
                    </div>
                    <div class="gr-bar"><i style="width:0%;"></i></div>
                </div>

                <!-- Countdown (hanya untuk yang closing soon) -->
                <?php if ($isClosing && $daysLeft <= 14): ?>
                <div class="gr-countdown" data-end="<?= $end->getTimestamp() ?>">
                    <div class="gr-cd"><b data-d><?= $daysLeft ?></b><span>Hari</span></div>
                    <div class="gr-cd"><b data-h>0</b><span>Jam</span></div>
                    <div class="gr-cd"><b data-m>0</b><span>Menit</span></div>
                    <div class="gr-cd"><b data-s>0</b><span>Detik</span></div>
                </div>
                <?php endif; ?>

                <div class="gr-deadline">
                    <span class="gr-deadline-text">
                        <?= $daysLeft > 0 ? "Sisa $daysLeft hari" : "Tutup hari ini!" ?>
                    </span>
                    <div class="gr-btn-group">
                        <?php if (!empty($g['link_proposal'])): ?>
                            <a href="<?= e($g['link_proposal']) ?>" target="_blank" rel="noopener" class="gr-btn gr-btn-ghost">📄 Panduan</a>
                        <?php endif; ?>
                        <?php if (!empty($g['link_registration'])): ?>
                            <a href="<?= e($g['link_registration']) ?>" target="_blank" rel="noopener" class="gr-btn gr-btn-primary">Daftar →</a>
                        <?php else: ?>
                            <span style="font-size:11px; color:var(--muted); align-self:center; padding:8px;">Via Admin</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- ===== ARSIP ===== -->
    <?php if (!empty($closed)): ?>
    <div class="gr-archive">
        <div class="gr-archive-head" id="gr-archive-toggle">
            <h3>📂 Arsip Hibah <span class="count"><?= $closedCount ?> ditutup</span></h3>
            <span class="arrow">▼</span>
        </div>
        <div class="gr-archive-body" id="gr-archive-body">
            <?php foreach ($closed as $g): ?>
                <div class="gr-archive-item">
                    <div class="info">
                        <h4><?= e($g['title']) ?></h4>
                        <span>📅 Tutup pada <?= e(date('d M Y', strtotime($g['deadline']))) ?> · <?= e($g['source']) ?></span>
                    </div>
                    <span class="status">CLOSED</span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
(function(){
    var cards = Array.prototype.slice.call(document.querySelectorAll('.gr-card'));
    var chips = document.querySelectorAll('.gr-chip');
    var sort = document.getElementById('gr-sort');
    var grid = document.getElementById('gr-grid');

    // Filter
    chips.forEach(function(chip){
        chip.addEventListener('click', function(){
            chips.forEach(function(c){ c.classList.remove('active'); });
            chip.classList.add('active');
            var filter = chip.dataset.filter;
            cards.forEach(function(card){
                var status = card.dataset.status;
                card.style.display = (filter === 'all' || status === filter) ? '' : 'none';
            });
        });
    });

    // Sort
    if (sort && grid) {
        sort.addEventListener('change', function(){
            var val = sort.value;
            var sorted = cards.slice().sort(function(a, b){
                if (val === 'deadline-asc') return parseInt(a.dataset.deadline) - parseInt(b.dataset.deadline);
                if (val === 'deadline-desc') return parseInt(b.dataset.deadline) - parseInt(a.dataset.deadline);
                if (val === 'funding-desc') return parseInt(b.dataset.funding) - parseInt(a.dataset.funding);
                if (val === 'funding-asc') return parseInt(a.dataset.funding) - parseInt(b.dataset.funding);
                return 0;
            });
            sorted.forEach(function(card){ grid.appendChild(card); });
        });
    }

    // Progress bar animation
    setTimeout(function(){
        document.querySelectorAll('.gr-bar i').forEach(function(bar){
            var card = bar.closest('.gr-card');
            var progress = card ? card.querySelector('.gr-progress-head .value').textContent : '0%';
            bar.style.width = progress;
        });
    }, 100);

    // Countdown real-time
    var countdowns = document.querySelectorAll('.gr-countdown');
    if (countdowns.length) {
        setInterval(function(){
            countdowns.forEach(function(cd){
                var end = parseInt(cd.dataset.end, 10) * 1000;
                var diff = Math.max(0, end - Date.now());
                var d = Math.floor(diff / 86400000);
                var h = Math.floor((diff % 86400000) / 3600000);
                var m = Math.floor((diff % 3600000) / 60000);
                var s = Math.floor((diff % 60000) / 1000);
                var de = cd.querySelector('[data-d]'), he = cd.querySelector('[data-h]');
                var me = cd.querySelector('[data-m]'), se = cd.querySelector('[data-s]');
                if (de) de.textContent = d;
                if (he) he.textContent = h;
                if (me) me.textContent = m;
                if (se) se.textContent = s;
            });
        }, 1000);
    }

    // Archive accordion
    var archiveToggle = document.getElementById('gr-archive-toggle');
    var archiveBody = document.getElementById('gr-archive-body');
    if (archiveToggle && archiveBody) {
        archiveToggle.addEventListener('click', function(){
            archiveToggle.classList.toggle('open');
            archiveBody.classList.toggle('open');
        });
    }

    // Reveal on scroll
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(entries){
            entries.forEach(function(en){
                if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
            });
        }, { threshold: 0.12 });
        cards.forEach(function(card){ io.observe(card); });
    } else {
        cards.forEach(function(card){ card.classList.add('in'); });
    }
})();
</script>