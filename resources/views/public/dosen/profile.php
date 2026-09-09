<?php
$initials = DosenResolver::initials($user['name'] ?? '');
$slug = DosenResolver::slug($user['name'] ?? '');
$years = $stats['years'] ?? [];
$maxYear = !empty($years) ? max($years) : 1;
$roleLabel = [
    'dosen' => 'Dosen', 'admin_lp3m' => 'Admin LP3M', 'super_admin' => 'Super Admin',
    'pimpinan' => 'Pimpinan', 'reviewer' => 'Reviewer',
][$user['role'] ?? ''] ?? 'Dosen';
?>

<style>
    @keyframes dpFade { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:none} }
    @keyframes dpShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes dpPulse { 0%,100%{box-shadow:0 0 0 0 rgba(16,185,129,.4)} 50%{box-shadow:0 0 0 10px rgba(16,185,129,0)} }

    .dp-wrap { max-width:1100px; margin:0 auto; padding:0 20px; }

    /* ── HERO ─ */
    .dp-hero { position:relative; overflow:hidden; display:flex; gap:24px; align-items:center; padding:36px 40px; border-radius:26px; background:linear-gradient(135deg,#065f46 0%,#059669 55%,#10b981 100%); color:#fff; box-shadow:0 24px 60px rgba(3,37,31,.35); margin-bottom:26px; animation:dpFade .6s both; }
    .dp-hero::before { content:''; position:absolute; inset:0; opacity:.3; background-image:repeating-linear-gradient(45deg,transparent,transparent 30px,rgba(253,230,138,.06) 30px,rgba(253,230,138,.06) 31px); pointer-events:none; }
    .dp-hero::after { content:''; position:absolute; top:-50%; right:-10%; width:380px; height:380px; border-radius:50%; background:radial-gradient(circle,rgba(253,230,138,.25),transparent 70%); pointer-events:none; }
    .dp-avatar { position:relative; width:110px; height:110px; border-radius:50%; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:38px; font-weight:900; color:#03251f; background:radial-gradient(circle at 30% 25%,#fff7c2,#fde68a 20%,#f2c063 55%,#d9a441); box-shadow:inset 0 3px 5px rgba(255,255,255,.7), inset 0 -4px 6px rgba(0,0,0,.22), 0 10px 26px rgba(217,164,65,.45); z-index:1; overflow:hidden; }
    .dp-avatar::before { content:''; position:absolute; top:14px; left:22px; width:32px; height:12px; border-radius:50%; background:rgba(255,255,255,.65); filter:blur(2px); z-index:2; }
    .dp-avatar img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
    .dp-hero-info { flex:1; min-width:0; position:relative; z-index:1; }
    .dp-hero-info .role { display:inline-flex; align-items:center; gap:6px; padding:4px 13px; border-radius:999px; font-size:10.5px; font-weight:900; letter-spacing:.12em; text-transform:uppercase; background:rgba(255,255,255,.16); border:1px solid rgba(255,255,255,.32); margin-bottom:10px; }
    .dp-hero-info h1 { font-family:var(--font-display); font-size:clamp(24px,4vw,36px); font-weight:900; letter-spacing:-.02em; margin:0 0 6px; line-height:1.15; }
    .dp-hero-info .sub { font-size:13px; opacity:.9; margin:0; }
    .dp-hero-actions { display:flex; gap:10px; flex-wrap:wrap; position:relative; z-index:1; }
    .dp-btn { position:relative; overflow:hidden; display:inline-flex; align-items:center; gap:8px; padding:12px 22px; border-radius:13px; font-size:13.5px; font-weight:800; text-decoration:none; transition:all .25s; }
    .dp-btn.gold { color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:inset 0 2px 3px rgba(255,255,255,.65), 0 8px 20px rgba(217,164,65,.4); }
    .dp-btn.gold::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.55),transparent); animation:dpShine 3s ease-in-out infinite; }
    .dp-btn.ghost { color:#fff; background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.3); }
    .dp-btn:hover { transform:translateY(-2px); filter:brightness(1.05); }

    /* ── KPI GRID ─ */
    .dp-kpis { display:grid; grid-template-columns:repeat(auto-fit,minmax(170px,1fr)); gap:14px; margin-bottom:26px; animation:dpFade .6s .08s both; }
    .dp-kpi { position:relative; overflow:hidden; padding:20px; border-radius:18px; background:var(--surface); border:1px solid var(--border); box-shadow:0 8px 22px rgba(3,37,31,.06); }
    .dp-kpi::after { content:''; position:absolute; top:-40px; right:-30px; width:110px; height:110px; border-radius:50%; background:radial-gradient(circle,rgba(var(--rgb),.16),transparent 70%); pointer-events:none; }
    .dp-kpi .ico { font-size:20px; margin-bottom:8px; }
    .dp-kpi b { display:block; font-family:var(--font-display); font-size:30px; font-weight:900; color:var(--ink); line-height:1; position:relative; z-index:1; }
    .dp-kpi span { display:block; font-size:10px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--muted); margin-top:5px; }

    /* ── SECTIONS ─ */
    .dp-2col { display:grid; grid-template-columns:1.4fr 1fr; gap:18px; margin-bottom:22px; }
    @media(max-width:900px){ .dp-2col{grid-template-columns:1fr;} }
    .dp-panel { position:relative; background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px; animation:dpFade .6s .12s both; }
    .dp-panel::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#065f46,#10b981,#f2c063); opacity:.85; border-radius:20px 20px 0 0; }
    .dp-panel h3 { display:flex; align-items:center; gap:10px; margin:0 0 16px; font-family:var(--font-display); font-size:15px; font-weight:900; color:var(--ink); padding-bottom:12px; border-bottom:1px dashed var(--border); }
    .dp-panel h3 .emo { width:32px; height:32px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; background:rgba(var(--rgb,5,150,105),.14); }
    .dp-panel h3 .num { margin-left:auto; font-size:10px; font-weight:900; letter-spacing:.1em; color:var(--muted); }

    /* ── LIST ITEMS ─ */
    .dp-list { list-style:none; margin:0; padding:0; }
    .dp-list li { padding:13px 0; border-bottom:1px dashed var(--border); }
    .dp-list li:last-child { border-bottom:none; }
    .dp-list .title { font-size:13.5px; font-weight:800; color:var(--ink); line-height:1.5; margin-bottom:5px; }
    .dp-list .meta { display:flex; gap:8px; flex-wrap:wrap; font-size:11px; color:var(--muted); }
    .dp-list .meta .tag { padding:2px 9px; border-radius:999px; font-weight:800; font-size:10px; }
    .dp-list .meta .year { background:rgba(5,150,105,.12); color:#047857; }
    .dp-list .meta .type { background:rgba(217,164,65,.14); color:#92400e; }
    .dp-list .meta .link { color:#1d4ed8; text-decoration:none; font-weight:700; }
    .dp-list .meta .link:hover { text-decoration:underline; }

    /* ── BAR CHART TAHUNAN ─ */
    .dp-chart { display:flex; align-items:flex-end; gap:6px; height:140px; padding:8px 4px 0; }
    .dp-bar { flex:1; display:flex; flex-direction:column; align-items:center; gap:5px; height:100%; justify-content:flex-end; }
    .dp-bar i { width:100%; max-width:36px; border-radius:7px 7px 3px 3px; background:linear-gradient(180deg,#10b981,rgba(5,150,105,.55)); box-shadow:inset 0 2px 3px rgba(255,255,255,.35); transition:height .8s cubic-bezier(.16,1,.3,1); position:relative; }
    .dp-bar i::after { content:attr(data-v); position:absolute; top:-17px; left:50%; transform:translateX(-50%); font-size:9.5px; font-weight:900; color:var(--muted); }
    .dp-bar span { font-size:9px; font-weight:800; color:var(--muted); }

    /* ── BIO CHIPS ─ */
    .dp-chips { display:flex; gap:8px; flex-wrap:wrap; margin-top:14px; }
    .dp-chip { padding:8px 14px; border-radius:999px; font-size:11.5px; font-weight:800; text-decoration:none; transition:all .2s; }
    .dp-chip:hover { transform:translateY(-2px); filter:brightness(1.08); }
    .dp-chip.scholar { background:rgba(59,130,246,.1); color:#1d4ed8; border:1px solid rgba(59,130,246,.3); }
    .dp-chip.sinta   { background:rgba(16,185,129,.1); color:#047857; border:1px solid rgba(16,185,129,.3); }
    .dp-chip.orcid   { background:rgba(217,164,65,.12); color:#92400e; border:1px solid rgba(217,164,65,.35); }

    .dp-empty { text-align:center; padding:30px 10px; color:var(--muted); font-size:12.5px; }
</style>

<div class="dp-wrap">

    <!-- HERO -->
    <div class="dp-hero">
        <div class="dp-avatar">
            <?php if (!empty($user['photo'])): ?>
                <img src="<?= e(upload_url($user['photo'])) ?>" alt="<?= e($user['name']) ?>">
            <?php else: ?>
                <?= e($initials) ?>
            <?php endif; ?>
        </div>
        <div class="dp-hero-info">
            <span class="role">🎓 <?= e($roleLabel) ?></span>
            <h1><?= e($user['name']) ?></h1>
            <p class="sub">
                <?= !empty($user['nidn']) ? 'NIDN: ' . e($user['nidn']) . ' · ' : '' ?>
                <?= e($user['institution'] ?? 'LP3M UNIMOF') ?>
            </p>
        </div>
        <div class="dp-hero-actions">
            <a class="dp-btn gold" href="<?= e(url('public/index.php?page=dosen-cv&id=' . $user['id'])) ?>" target="_blank">📥 Export CV</a>
            <button class="dp-btn ghost" type="button" onclick="navigator.clipboard.writeText(location.href).then(()=>{this.textContent='✅ Tersalin!';setTimeout(()=>{this.textContent='🔗 Salin Link'},1500);})">🔗 Salin Link</button>
        </div>
    </div>

    <!-- KPI -->
    <div class="dp-kpis">
        <div class="dp-kpi" style="--rgb:5,150,105">
            <div class="ico">📊</div>
            <b data-count="<?= (int) $stats['total_all'] ?>"><?= number_format($stats['total_all']) ?></b>
            <span>Total Karya</span>
        </div>
        <div class="dp-kpi" style="--rgb:124,58,237">
            <div class="ico">🎯</div>
            <b data-count="<?= (int) $hIndex ?>"><?= (int) $hIndex ?></b>
            <span>h-index (proxy)</span>
        </div>
        <div class="dp-kpi" style="--rgb:59,130,246">
            <div class="ico">📚</div>
            <b data-count="<?= (int) $stats['journal_count'] ?>"><?= number_format($stats['journal_count']) ?></b>
            <span>Artikel Jurnal</span>
        </div>
        <div class="dp-kpi" style="--rgb:16,185,129">
            <div class="ico">🔗</div>
            <b data-count="<?= (int) $stats['doi_count'] ?>"><?= number_format($stats['doi_count']) ?></b>
            <span>Ber-DOI</span>
        </div>
        <div class="dp-kpi" style="--rgb:217,164,65">
            <div class="ico">📅</div>
            <b><?= (int) $stats['first_year'] ?>–<?= (int) $stats['latest_year'] ?></b>
            <span>Tahun Aktif</span>
        </div>
    </div>

    <!-- BIOGRAFI & TAUTAN AKADEMIK -->
    <?php if (!empty($user['bio']) || !empty($user['scholar_url']) || !empty($user['sinta_url']) || !empty($user['orcid'])): ?>
    <div class="dp-panel" style="--rgb:217,164,65; margin-bottom:22px;">
        <h3><span class="emo">🧬</span><span>Biografi & Tautan Akademik</span></h3>
        <?php if (!empty($user['bio'])): ?>
        <p style="font-size:13.5px; line-height:1.8; color:var(--muted); margin:0 0 14px; white-space:pre-line;"><?= e($user['bio']) ?></p>
        <?php endif; ?>
        <div class="dp-chips">
            <?php if (!empty($user['scholar_url'])): ?>
            <a class="dp-chip scholar" href="<?= e($user['scholar_url']) ?>" target="_blank" rel="noopener">🎓 Google Scholar</a>
            <?php endif; ?>
            <?php if (!empty($user['sinta_url'])): ?>
            <a class="dp-chip sinta" href="<?= e($user['sinta_url']) ?>" target="_blank" rel="noopener">📈 SINTA Kemdikbud</a>
            <?php endif; ?>
            <?php if (!empty($user['orcid'])): ?>
            <a class="dp-chip orcid" href="https://orcid.org/<?= e($user['orcid']) ?>" target="_blank" rel="noopener">🆔 ORCID: <?= e($user['orcid']) ?></a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- 2 KOLOM: PENELITIAN + CHART -->
    <div class="dp-2col">
        <div class="dp-panel" style="--rgb:59,130,246">
            <h3><span class="emo">🔬</span><span>Penelitian</span><span class="num"><?= count($researches) ?> ITEM</span></h3>
            <?php if (empty($researches)): ?>
            <div class="dp-empty">📭 Belum ada data penelitian.</div>
            <?php else: ?>
            <ul class="dp-list">
                <?php foreach (array_slice($researches, 0, 8) as $r): ?>
                <li>
                    <div class="title"><?= e($r['title']) ?></div>
                    <div class="meta">
                        <span class="tag year"><?= (int) ($r['year'] ?? date('Y')) ?></span>
                        <span class="tag type"><?= e(ucfirst(str_replace('_', ' ', $r['scheme'] ?? 'Internal'))) ?></span>
                        <?php if (!empty($r['funding'])): ?><span>💰 <?= e($r['funding']) ?></span><?php endif; ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>

        <div class="dp-panel" style="--rgb:16,185,129">
            <h3><span class="emo">📈</span><span>Tren Karya per Tahun</span><span class="num">ALL TIME</span></h3>
            <?php if (empty($years)): ?>
            <div class="dp-empty">📭 Belum ada data.</div>
            <?php else: ?>
            <div class="dp-chart">
                <?php foreach (array_slice($years, -8, 8, true) as $y => $c): ?>
                <div class="dp-bar">
                    <i data-v="<?= (int) $c ?>" style="height:<?= max(6, (int) round($c / $maxYear * 100)) ?>%"></i>
                    <span><?= (int) $y ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- 2 KOLOM: PUBLIKASI + HAKI -->
    <div class="dp-2col">
        <div class="dp-panel" style="--rgb:124,58,237">
            <h3><span class="emo">📚</span><span>Publikasi Ilmiah</span><span class="num"><?= count($publications) ?> ITEM</span></h3>
            <?php if (empty($publications)): ?>
            <div class="dp-empty">📭 Belum ada data publikasi.</div>
            <?php else: ?>
            <ul class="dp-list">
                <?php foreach (array_slice($publications, 0, 8) as $p): ?>
                <li>
                    <div class="title"><?= e($p['title']) ?></div>
                    <div class="meta">
                        <span class="tag year"><?= (int) ($p['year'] ?? date('Y')) ?></span>
                        <?php if (!empty($p['journal'])): ?><span>📖 <?= e($p['journal']) ?></span><?php endif; ?>
                        <?php if (!empty($p['doi'])): ?>
                        <a class="link" href="https://doi.org/<?= e($p['doi']) ?>" target="_blank" rel="noopener">🔗 DOI</a>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>

        <div class="dp-panel" style="--rgb:245,158,11">
            <h3><span class="emo">🛡️</span><span>HAKI Terdaftar</span><span class="num"><?= count($haki) ?> ITEM</span></h3>
            <?php if (empty($haki)): ?>
            <div class="dp-empty">📭 Belum ada data HAKI.</div>
            <?php else: ?>
            <ul class="dp-list">
                <?php foreach (array_slice($haki, 0, 6) as $h): ?>
                <li>
                    <div class="title"><?= e($h['title']) ?></div>
                    <div class="meta">
                        <span class="tag year"><?= (int) ($h['year'] ?? date('Y')) ?></span>
                        <span class="tag type"><?= e(ucfirst(str_replace('_', ' ', $h['type'] ?? 'Hak Cipta'))) ?></span>
                        <?php if (!empty($h['registration_number'])): ?><span>📋 <?= e($h['registration_number']) ?></span><?php endif; ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>

    <!-- PENGABDIAN (FULL WIDTH) -->
    <div class="dp-panel" style="--rgb:16,185,129; margin-bottom:30px;">
        <h3><span class="emo">🤝</span><span>Pengabdian Masyarakat</span><span class="num"><?= count($cs) ?> ITEM</span></h3>
        <?php if (empty($cs)): ?>
        <div class="dp-empty">📭 Belum ada data pengabdian.</div>
        <?php else: ?>
        <ul class="dp-list">
            <?php foreach (array_slice($cs, 0, 6) as $c): ?>
            <li>
                <div class="title"><?= e($c['title']) ?></div>
                <div class="meta">
                    <span class="tag year"><?= (int) ($c['year'] ?? date('Y')) ?></span>
                    <span class="tag type"><?= e(ucfirst(str_replace('_', ' ', $c['type'] ?? 'Reguler'))) ?></span>
                    <?php if (!empty($c['location'])): ?><span>📍 <?= e($c['location']) ?></span><?php endif; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
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
            var p = Math.min((t - start) / 900, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(target * eased).toLocaleString('id-ID');
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    });
})();
</script>