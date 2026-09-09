<?php
$now = time();
$totalResponses = array_sum(array_column($surveys, 'responses'));
$activeSurveys = array_filter($surveys, fn($s) => empty($s['end_date']) || strtotime($s['end_date']) > $now);
?>
<style>
    @keyframes psvFade { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:none} }
    @keyframes psvShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes psvPulse { 0%,100%{box-shadow:0 0 0 0 rgba(251,191,36,.5)} 50%{box-shadow:0 0 0 10px rgba(251,191,36,0)} }
    @keyframes psvFloat { 0%,100%{transform:translateY(0) rotate(-4deg)} 50%{transform:translateY(-10px) rotate(4deg)} }
    @keyframes psvTicker { from{transform:translateX(100%)} to{transform:translateX(-100%)} }
    @keyframes psvGlow { 0%,100%{filter:drop-shadow(0 0 8px rgba(16,185,129,.6))} 50%{filter:drop-shadow(0 0 16px rgba(16,185,129,.9))} }

    .psv-wrap { max-width:1180px; margin:0 auto; padding:0 20px; }

    /* HERO */
    .psv-hero { position:relative; overflow:hidden; border-radius:28px; padding:56px 46px; margin-bottom:28px; color:#fff; background:linear-gradient(135deg,#4c1d95 0%,#6d28d9 55%,#8b5cf6 100%); box-shadow:0 26px 60px rgba(76,29,149,.35); animation:psvFade .6s both; }
    .psv-hero::before { content:''; position:absolute; inset:0; opacity:.35; background-image:repeating-linear-gradient(45deg,transparent,transparent 30px,rgba(253,230,138,.05) 30px,rgba(253,230,138,.05) 31px); pointer-events:none; }
    .psv-hero::after { content:'📝'; position:absolute; right:46px; bottom:-14px; font-size:140px; opacity:.14; animation:psvFloat 6s ease-in-out infinite; pointer-events:none; }
    .psv-hero .tag { display:inline-flex; align-items:center; gap:8px; padding:6px 15px; border-radius:999px; font-size:10.5px; font-weight:900; letter-spacing:.18em; text-transform:uppercase; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.3); margin-bottom:16px; position:relative; z-index:1; }
    .psv-hero .tag i { width:7px; height:7px; border-radius:50%; background:#c4b5fd; box-shadow:0 0 8px #c4b5fd; animation:psvGlow 2s infinite; }
    .psv-hero h1 { font-family:var(--font-display); font-size:clamp(28px,4vw,42px); font-weight:900; margin:0 0 10px; letter-spacing:-.02em; position:relative; z-index:1; }
    .psv-hero h1 em { font-style:normal; background:linear-gradient(135deg,#fde68a,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .psv-hero p { font-size:14.5px; line-height:1.7; opacity:.92; max-width:620px; margin:0 0 22px; position:relative; z-index:1; }
    .psv-stats { display:flex; gap:10px; flex-wrap:wrap; position:relative; z-index:1; }
    .psv-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); border-radius:14px; padding:10px 18px; text-align:center; min-width:92px; backdrop-filter:blur(6px); }
    .psv-stat b { display:block; font-family:var(--font-display); font-size:19px; font-weight:900; color:#fde68a; line-height:1.1; }
    .psv-stat span { font-size:9px; letter-spacing:.12em; text-transform:uppercase; opacity:.85; display:block; margin-top:3px; }

    /* LIVE TICKER */
    .psv-ticker { margin-bottom:22px; padding:12px 18px; border-radius:14px; background:var(--surface); border:1px solid var(--border); box-shadow:0 6px 16px rgba(3,37,31,.06); display:flex; align-items:center; gap:14px; overflow:hidden; animation:psvFade .6s .06s both; }
    .psv-ticker-lbl { flex-shrink:0; display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:999px; background:linear-gradient(145deg,#10b981,#059669); color:#fff; font-size:10px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; }
    .psv-ticker-lbl i { width:6px; height:6px; border-radius:50%; background:#fff; box-shadow:0 0 6px #fff; animation:psvGlow 1.5s infinite; }
    .psv-ticker-track { flex:1; overflow:hidden; position:relative; mask-image:linear-gradient(90deg,transparent,#000 10%,#000 90%,transparent); -webkit-mask-image:linear-gradient(90deg,transparent,#000 10%,#000 90%,transparent); }
    .psv-ticker-inner { display:flex; gap:28px; white-space:nowrap; animation:psvTicker 30s linear infinite; }
    .psv-ticker-inner span { font-size:12px; font-weight:700; color:var(--muted); display:inline-flex; align-items:center; gap:6px; }
    .psv-ticker-inner span b { color:var(--ink); }

    /* TOOLS */
    .psv-tools { display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:22px; animation:psvFade .6s .08s both; }
    .psv-search { position:relative; flex:1; min-width:220px; max-width:340px; }
    .psv-search input { width:100%; padding:11px 16px 11px 42px; border-radius:999px; border:1px solid var(--border); background:var(--surface); font-size:13px; font-weight:600; color:var(--text); outline:none; transition:all .2s; }
    .psv-search input:focus { border-color:#7c3aed; box-shadow:0 0 0 4px rgba(124,58,237,.12); }
    .psv-search .ico { position:absolute; left:15px; top:50%; transform:translateY(-50%); font-size:14px; opacity:.6; }
    .psv-filter { padding:9px 16px; border-radius:999px; border:1px solid var(--border); background:var(--surface); font-size:12.5px; font-weight:800; color:var(--text); cursor:pointer; transition:all .2s; }
    .psv-filter:hover { border-color:rgba(124,58,237,.4); color:#6d28d9; }
    .psv-filter.on { background:linear-gradient(145deg,#8b5cf6,#6d28d9); color:#fff; border-color:transparent; }
    .psv-count { margin-left:auto; font-size:11.5px; font-weight:800; color:var(--muted); }

    /* GRID */
    .psv-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:20px; }
    .psv-card { position:relative; overflow:hidden; display:flex; flex-direction:column; gap:14px; padding:26px; border-radius:22px; background:var(--surface); border:1px solid var(--border); box-shadow:0 10px 26px rgba(3,37,31,.07); transition:all .3s; animation:psvFade .5s both; }
    .psv-card:hover { transform:translateY(-6px); border-color:rgba(124,58,237,.4); box-shadow:0 20px 40px rgba(124,58,237,.16); }
    .psv-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,#8b5cf6,#c4b5fd); }
    .psv-card.featured { grid-column:1 / -1; display:grid; grid-template-columns:1.2fr 1fr; gap:28px; padding:34px; background:linear-gradient(135deg,rgba(124,58,237,.05),rgba(253,230,138,.04)), var(--surface); border-color:rgba(124,58,237,.4); }
    .psv-card.featured::before { height:5px; background:linear-gradient(90deg,#fde68a,#8b5cf6,#fde68a); }
    .psv-card.featured::after { content:'🔥 SURVEI UNGGULAN'; position:absolute; top:14px; right:14px; padding:4px 12px; border-radius:999px; background:linear-gradient(145deg,#fde68a,#d9a441); color:#03251f; font-size:9px; font-weight:900; letter-spacing:.1em; box-shadow:0 4px 10px rgba(217,164,65,.35); animation:psvPulse 2.5s ease-in-out infinite; }
    .psv-card.closed { opacity:.65; }
    .psv-card.closed::before { background:linear-gradient(90deg,#94a3b8,#64748b); }
    .psv-status { display:inline-flex; align-items:center; gap:6px; padding:3px 10px; border-radius:999px; font-size:9.5px; font-weight:900; letter-spacing:.06em; text-transform:uppercase; margin-bottom:4px; width:fit-content; }
    .psv-status.open { background:rgba(16,185,129,.12); color:#047857; border:1px solid rgba(16,185,129,.3); }
    .psv-status.open i { width:6px; height:6px; border-radius:50%; background:#10b981; box-shadow:0 0 6px #10b981; animation:psvPulse 2s infinite; }
    .psv-status.closed { background:rgba(100,116,139,.1); color:var(--muted); border:1px solid var(--border); }
    .psv-countdown { display:inline-flex; align-items:center; gap:8px; padding:6px 12px; border-radius:10px; background:rgba(251,191,36,.1); border:1px solid rgba(251,191,36,.3); font-size:11px; font-weight:900; color:#b45309; margin-bottom:8px; }
    .psv-countdown.urgent { background:rgba(220,38,38,.1); border-color:rgba(220,38,38,.3); color:#991b1b; animation:psvPulse 1.5s infinite; }
    .psv-countdown b { font-family:var(--font-display); font-size:13px; }
    .psv-card h3 { margin:0; font-family:var(--font-display); font-size:18px; font-weight:900; color:var(--ink); line-height:1.35; }
    .psv-card.featured h3 { font-size:24px; }
    .psv-card p { margin:0; font-size:13px; color:var(--muted); line-height:1.6; flex:1; }
    .psv-card.featured p { font-size:14px; }
    .psv-progress { margin:10px 0; }
    .psv-progress-bar { height:6px; border-radius:999px; background:rgba(124,58,237,.1); overflow:hidden; margin-bottom:4px; }
    .psv-progress-fill { height:100%; border-radius:999px; background:linear-gradient(90deg,#8b5cf6,#f2c063); transition:width .6s ease; }
    .psv-progress-txt { font-size:10px; font-weight:800; color:var(--muted); display:flex; justify-content:space-between; }
    .psv-meta { display:flex; gap:8px; flex-wrap:wrap; font-size:11px; color:var(--muted); }
    .psv-meta span { padding:3px 10px; border-radius:999px; background:rgba(124,58,237,.08); border:1px solid rgba(124,58,237,.25); color:#6d28d9; font-weight:800; }
    .psv-card.featured .psv-meta span { padding:4px 12px; font-size:11.5px; }
    .psv-cta { display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:13px 24px; border-radius:13px; font-size:14px; font-weight:800; text-decoration:none; color:#fff; background:linear-gradient(145deg,#8b5cf6,#6d28d9); box-shadow:0 6px 16px rgba(124,58,237,.35); transition:all .25s; position:relative; overflow:hidden; align-self:flex-start; }
    .psv-cta::after { content:''; position:absolute; top:0; left:-100%; width:50%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.4),transparent); animation:psvShine 3s ease-in-out infinite; }
    .psv-cta:hover { transform:translateY(-2px); filter:brightness(1.08); }
    .psv-cta.disabled { background:linear-gradient(145deg,#cbd5e1,#94a3b8); pointer-events:none; box-shadow:none; }
    .psv-empty { text-align:center; padding:70px 24px; border-radius:22px; background:var(--surface); border:2px dashed var(--border); color:var(--muted); animation:psvFade .6s both; }
    @media(max-width:780px){ .psv-card.featured { grid-template-columns:1fr; } }
</style>

<div class="psv-wrap">
    <section class="psv-hero">
        <span class="tag"><i></i> Suara Anda Berarti</span>
        <h1>Survei Kepuasan Layanan <em>LP3M</em></h1>
        <p>Bantu kami meningkatkan mutu layanan penelitian, pengabdian, dan akademik. Isi survei berikut — hanya butuh beberapa menit dan dapat dilakukan anonim.</p>
        <div class="psv-stats">
            <div class="psv-stat"><b><?= count($surveys) ?></b><span>Survei</span></div>
            <div class="psv-stat"><b><?= number_format($totalResponses) ?></b><span>Total Responden</span></div>
            <div class="psv-stat"><b><?= count($activeSurveys) ?></b><span>Aktif</span></div>
        </div>
    </section>

    <?php if (!empty($activeSurveys)): ?>
    <div class="psv-ticker">
        <span class="psv-ticker-lbl"><i></i> LIVE</span>
        <div class="psv-ticker-track">
            <div class="psv-ticker-inner">
                <?php for ($r = 0; $r < 2; $r++): // duplicate for seamless loop ?>
                    <?php foreach (array_slice($activeSurveys, 0, 5) as $sv): ?>
                        <span>📊 <b><?= number_format($sv['responses']) ?></b> responden di <b><?= e($sv['title']) ?></b></span>
                        <span>•</span>
                    <?php endforeach; ?>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="psv-tools">
        <div class="psv-search">
            <span class="ico">🔍</span>
            <input type="text" id="psvSearch" placeholder="Cari survei berdasarkan judul...">
        </div>
        <button type="button" class="psv-filter on" data-filter="all">Semua</button>
        <button type="button" class="psv-filter" data-filter="open">🟢 Aktif</button>
        <button type="button" class="psv-filter" data-filter="closed">🔒 Ditutup</button>
        <span class="psv-count" id="psvCount"><?= count($surveys) ?> survei tersedia</span>
    </div>

    <?php if (empty($surveys)): ?>
    <div class="psv-empty">
        <div style="font-size:52px;margin-bottom:12px;">📭</div>
        <h3 style="margin:0 0 6px;color:var(--ink);">Belum Ada Survei Terbuka</h3>
        <p style="margin:0;">Saat ini tidak ada survei yang sedang berlangsung. Silakan kunjungi kembali beberapa waktu lagi.</p>
    </div>
    <?php else: ?>
    <div class="psv-grid" id="psvGrid">
        <?php foreach ($surveys as $i => $sv):
            $isOpen = empty($sv['end_date']) || strtotime($sv['end_date']) > $now;
            $remaining = $isOpen && !empty($sv['end_date']) ? strtotime($sv['end_date']) - $now : 0;
            $target = (int) ($sv['target_responses'] ?? 100);
            $progress = min(100, round(($sv['responses'] / max(1, $target)) * 100));
        ?>
        <div class="psv-card <?= $i === 0 && $isOpen ? 'featured' : '' ?> <?= !$isOpen ? 'closed' : '' ?>"
             style="animation-delay:<?= min($i * 0.06, 0.4) ?>s"
             data-status="<?= $isOpen ? 'open' : 'closed' ?>"
             data-title="<?= e(strtolower($sv['title'])) ?>">
            <div>
                <span class="psv-status <?= $isOpen ? 'open' : 'closed' ?>">
                    <?php if ($isOpen): ?><i></i> Sedang Berlangsung<?php else: ?>🔒 Ditutup<?php endif; ?>
                </span>
                <?php if ($isOpen && $remaining > 0 && $remaining < 7 * 86400): ?>
                    <?php $days = floor($remaining / 86400); $hours = floor(($remaining % 86400) / 3600); ?>
                    <div class="psv-countdown <?= $remaining < 3 * 86400 ? 'urgent' : '' ?>">
                        ⏰ Sisa <b><?= $days > 0 ? $days . 'h ' : '' ?><?= $hours ?>j</b>
                    </div>
                <?php endif; ?>
                <h3><?= e($sv['title']) ?></h3>
                <?php if (!empty($sv['description'])): ?><p><?= e($sv['description']) ?></p><?php endif; ?>

                <?php if ($isOpen && $target > 0): ?>
                <div class="psv-progress">
                    <div class="psv-progress-bar">
                        <div class="psv-progress-fill" style="width:<?= $progress ?>%"></div>
                    </div>
                    <div class="psv-progress-txt">
                        <span><?= number_format($sv['responses']) ?> / <?= number_format($target) ?> target</span>
                        <span><?= $progress ?>%</span>
                    </div>
                </div>
                <?php endif; ?>

                <div class="psv-meta" style="margin-top:14px;">
                    <span>🎯 <?= e(Survey::TARGETS[$sv['target_audience']] ?? 'Umum') ?></span>
                    <span>❓ <?= (int) $sv['questions'] ?> pertanyaan</span>
                    <span>👥 <?= number_format($sv['responses']) ?> responden</span>
                    <?php if (!empty($sv['end_date'])): ?><span>⏳ s/d <?= e(date('d M Y', strtotime($sv['end_date']))) ?></span><?php endif; ?>
                </div>
            </div>
            <div style="display:flex; flex-direction:column; justify-content:<?= $i === 0 && $isOpen ? 'center' : 'flex-end' ?>;">
                <?php if ($isOpen): ?>
                <a class="psv-cta" href="<?= e(url('public/index.php?page=survei-isi&id=' . $sv['id'])) ?>">✍️ Isi Survei Sekarang →</a>
                <?php else: ?>
                <span class="psv-cta disabled">Survei Telah Berakhir</span>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<script>
(function(){
    var s = document.getElementById('psvSearch');
    var c = document.getElementById('psvCount');
    var cards = Array.prototype.slice.call(document.querySelectorAll('.psv-card'));
    var filters = Array.prototype.slice.call(document.querySelectorAll('.psv-filter'));
    var activeFilter = 'all';

    function apply(){
        var q = s ? s.value.toLowerCase() : '';
        var n = 0;
        cards.forEach(function(cd){
            var matchText = cd.textContent.toLowerCase().indexOf(q) !== -1;
            var matchFilter = activeFilter === 'all' || cd.getAttribute('data-status') === activeFilter;
            var show = matchText && matchFilter;
            cd.style.display = show ? '' : 'none';
            if (show) n++;
        });
        if (c) c.textContent = n + ' survei tersedia';
    }

    if (s) s.addEventListener('input', apply);
    filters.forEach(function(f){
        f.addEventListener('click', function(){
            filters.forEach(function(x){ x.classList.remove('on'); });
            this.classList.add('on');
            activeFilter = this.getAttribute('data-filter');
            apply();
        });
    });
})();
</script>