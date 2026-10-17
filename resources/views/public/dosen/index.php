<?php
$roleLabels = [
    'dosen' => '👨‍🏫 Dosen', 'admin_lp3m' => '🛡️ Admin LP3M', 'super_admin' => '⭐ Super Admin',
    'pimpinan' => '🏛️ Pimpinan', 'reviewer' => '📋 Reviewer',
];
$roleColors = [
    'dosen' => '#059669', 'admin_lp3m' => '#6366f1', 'super_admin' => '#d97706',
    'pimpinan' => '#7c3aed', 'reviewer' => '#0891b2',
];
$activeRole = trim($_GET['role'] ?? '');
?>
<style>
    @keyframes drFade { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:none} }
    @keyframes drShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes drFloat { 0%,100%{transform:translateY(0) rotate(-4deg)} 50%{transform:translateY(-10px) rotate(4deg)} }
    @keyframes drPulse { 0%,100%{box-shadow:0 0 0 0 rgba(16,185,129,.5)} 50%{box-shadow:0 0 0 8px rgba(16,185,129,0)} }
    @keyframes drShineCard { 0%,55%{left:-120%} 100%{left:200%} }

    .dr-wrap { max-width:1180px; margin:0 auto; padding:0 20px; }

    /* HERO */
    .dr-hero { position:relative; overflow:hidden; padding:56px 46px; border-radius:28px; background:linear-gradient(135deg,#043b2c 0%,#065f46 45%,#10b981 100%); color:#fff; box-shadow:0 26px 60px rgba(3,37,31,.35); margin-bottom:26px; animation:drFade .6s both; }
    .dr-hero::before { content:''; position:absolute; inset:0; opacity:.3; background-image:repeating-linear-gradient(45deg,transparent,transparent 30px,rgba(253,230,138,.06) 30px,rgba(253,230,138,.06) 31px); pointer-events:none; }
    .dr-hero::after { content:'👨‍🏫'; position:absolute; right:46px; bottom:-14px; font-size:150px; opacity:.14; animation:drFloat 6s ease-in-out infinite; pointer-events:none; }
    .dr-hero .tag { display:inline-flex; align-items:center; gap:8px; padding:6px 15px; border-radius:999px; font-size:10.5px; font-weight:900; letter-spacing:.18em; text-transform:uppercase; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.3); margin-bottom:16px; position:relative; z-index:1; }
    .dr-hero .tag i { width:7px; height:7px; border-radius:50%; background:#6ee7b7; box-shadow:0 0 8px #6ee7b7; animation:drPulse 2s infinite; }
    .dr-hero h1 { font-family:var(--font-display); font-size:clamp(28px,4vw,42px); font-weight:900; letter-spacing:-.02em; margin:0 0 10px; position:relative; z-index:1; }
    .dr-hero h1 em { font-style:normal; background:linear-gradient(135deg,#fde68a,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .dr-hero p { font-size:14.5px; line-height:1.7; opacity:.92; max-width:620px; margin:0 0 22px; position:relative; z-index:1; }
    .dr-hero-stats { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:22px; position:relative; z-index:1; }
    .dr-hero-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); border-radius:14px; padding:10px 18px; text-align:center; min-width:92px; backdrop-filter:blur(6px); }
    .dr-hero-stat b { display:block; font-family:var(--font-display); font-size:19px; font-weight:900; color:#fde68a; line-height:1.1; }
    .dr-hero-stat span { font-size:9px; letter-spacing:.12em; text-transform:uppercase; opacity:.85; display:block; margin-top:3px; }
    .dr-search { position:relative; max-width:460px; z-index:1; }
    .dr-search input { width:100%; padding:14px 18px 14px 48px; border-radius:14px; border:2px solid rgba(255,255,255,.3); background:rgba(255,255,255,.14); backdrop-filter:blur(8px); color:#fff; font-size:14px; font-weight:600; transition:all .2s; }
    .dr-search input::placeholder { color:rgba(255,255,255,.65); }
    .dr-search input:focus { outline:none; border-color:#fde68a; background:rgba(255,255,255,.22); box-shadow:0 0 0 4px rgba(253,230,138,.2); }
    .dr-search .ico { position:absolute; left:16px; top:50%; transform:translateY(-50%); font-size:16px; opacity:.8; }

    /* CHIPS ROLE */
    .dr-chips { display:flex; flex-wrap:wrap; gap:9px; margin-bottom:24px; animation:drFade .6s .06s both; }
    .dr-chip { padding:9px 18px; border-radius:999px; border:1px solid var(--border); background:var(--surface); font-size:12.5px; font-weight:800; color:var(--text); text-decoration:none; transition:all .25s; display:inline-flex; align-items:center; gap:6px; }
    .dr-chip:hover { transform:translateY(-2px); border-color:rgba(5,150,105,.5); color:#047857; box-shadow:0 6px 14px rgba(5,150,105,.15); }
    .dr-chip.on { color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); border-color:transparent; box-shadow:0 5px 14px rgba(217,164,65,.35); }
    .dr-chip b { padding:1px 7px; border-radius:999px; background:rgba(5,150,105,.12); color:#047857; font-size:10px; font-weight:900; }
    .dr-chip.on b { background:rgba(3,37,31,.2); color:#03251f; }

    /* GRID */
    .dr-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:18px; margin-bottom:30px; }
    .dr-card { position:relative; overflow:hidden; display:flex; flex-direction:column; gap:14px; padding:24px 22px; border-radius:22px; background:var(--surface); border:1px solid var(--border); box-shadow:0 8px 22px rgba(3,37,31,.06); text-decoration:none; color:inherit; transition:all .3s cubic-bezier(.16,1,.3,1); opacity:0; transform:translateY(18px); }
    .dr-card.in { opacity:1; transform:none; }
    .dr-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,#065f46,#10b981,#f2c063); opacity:.85; }
    .dr-card::after { content:''; position:absolute; top:0; left:-120%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); transform:skewX(-20deg); pointer-events:none; }
    .dr-card:hover { transform:translateY(-6px); border-color:rgba(5,150,105,.4); box-shadow:0 18px 38px rgba(5,150,105,.16); }
    .dr-card:hover::after { animation:drShineCard .9s ease-out; }
    .dr-card:hover .dr-av { transform:scale(1.08) rotate(-3deg); }
    .dr-card.featured { grid-column:1 / -1; display:grid; grid-template-columns:1.1fr 1fr; gap:24px; padding:30px; background:linear-gradient(135deg,rgba(5,150,105,.06),rgba(253,230,138,.04)), var(--surface); border-color:rgba(5,150,105,.35); }
    .dr-card.featured::before { height:5px; background:linear-gradient(90deg,#fde68a,#10b981,#fde68a); }
    .dr-card.featured::after { content:'⭐ DOSEN UNGGULAN'; position:absolute; top:14px; right:14px; padding:4px 12px; border-radius:999px; background:linear-gradient(145deg,#fde68a,#d9a441); color:#03251f; font-size:9px; font-weight:900; letter-spacing:.1em; box-shadow:0 4px 10px rgba(217,164,65,.35); z-index:2; }
    .dr-top { display:flex; gap:14px; align-items:center; }
    .dr-av { position:relative; width:62px; height:62px; border-radius:50%; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:21px; font-weight:900; color:#03251f; background:radial-gradient(circle at 30% 25%,#fff7c2,#fde68a 20%,#f2c063 55%,#d9a441); box-shadow:inset 0 2px 4px rgba(255,255,255,.65), inset 0 -3px 5px rgba(0,0,0,.2), 0 6px 16px rgba(217,164,65,.4); transition:transform .3s; overflow:hidden; }
    .dr-card.featured .dr-av { width:88px; height:88px; font-size:28px; }
    .dr-av img { width:100%; height:100%; object-fit:cover; }
    .dr-verified { position:absolute; bottom:-2px; right:-2px; width:20px; height:20px; border-radius:50%; background:linear-gradient(145deg,#10b981,#059669); color:#fff; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:900; border:2px solid var(--surface); box-shadow:0 2px 6px rgba(16,185,129,.4); z-index:2; }
    .dr-name { font-family:var(--font-display); font-size:15px; font-weight:900; color:var(--ink); line-height:1.3; margin:0 0 5px; }
    .dr-card.featured .dr-name { font-size:20px; }
    .dr-role { display:inline-flex; padding:2px 10px; border-radius:999px; font-size:9.5px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; border:1px solid; }
    .dr-inst { font-size:11.5px; color:var(--muted); margin-top:5px; }
    .dr-card.featured .dr-bio { font-size:13px; line-height:1.65; color:var(--muted); margin:10px 0; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
    .dr-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:6px; }
    .dr-stat { padding:8px 4px; border-radius:10px; background:rgba(5,150,105,.05); border:1px solid var(--border); text-align:center; transition:all .2s; }
    .dr-card:hover .dr-stat { background:rgba(5,150,105,.1); }
    .dr-stat b { display:block; font-family:var(--font-display); font-size:15px; font-weight:900; color:var(--ink); line-height:1; }
    .dr-stat span { display:block; font-size:8px; font-weight:800; letter-spacing:.06em; text-transform:uppercase; color:var(--muted); margin-top:3px; }
    .dr-cta { margin-top:auto; display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px; border-radius:12px; font-size:12.5px; font-weight:800; color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:0 5px 14px rgba(217,164,65,.35); position:relative; overflow:hidden; }
    .dr-cta::after { content:''; position:absolute; top:0; left:-100%; width:50%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:drShine 3s ease-in-out infinite; }
    .dr-empty { text-align:center; padding:60px 20px; border-radius:22px; background:var(--surface); border:2px dashed var(--border); color:var(--muted); animation:drFade .6s both; }
    .dr-count { text-align:center; font-size:12px; font-weight:800; color:var(--muted); margin-bottom:16px; }
    @media(max-width:760px){ .dr-card.featured { grid-template-columns:1fr; } .dr-card.featured .dr-av { width:80px; height:80px; margin:0 auto; } }
</style>

<div class="dr-wrap">

    <div class="dr-hero">
        <span class="tag"><i></i> Sivitas Akademika</span>
        <h1>Direktori Dosen & <em>Peneliti</em></h1>
        <p>Jelajahi profil akademik dosen LP3M — lengkap dengan rekam jejak penelitian, publikasi ilmiah, HAKI, dan pengabdian kepada masyarakat.</p>

        <?php
        $totalKarya = 0;
        foreach ($users as $uK) {
            $totalKarya += (int) ($uK['counts']['total'] ?? 0);
        }
        ?>
        <div class="dr-hero-stats">
            <div class="dr-hero-stat"><b><?= count($users) ?></b><span>Dosen</span></div>
            <div class="dr-hero-stat"><b><?= number_format($totalKarya) ?></b><span>Total Karya</span></div>
            <div class="dr-hero-stat"><b><?= count(array_unique(array_column($users, 'role'))) ?></b><span>Peran Aktif</span></div>
        </div>

        <form class="dr-search" method="get" action="<?= e(url('public/index.php')) ?>" id="drSearch">
            <input type="hidden" name="page" value="dosen">
            <?php if ($activeRole !== ''): ?><input type="hidden" name="role" value="<?= e($activeRole) ?>"><?php endif; ?>
            <span class="ico">🔍</span>
            <input type="text" name="q" id="drQ" value="<?= e($q) ?>" placeholder="Cari nama dosen, NIDN, atau bidang keahlian...">
        </form>
    </div>

    <div class="dr-chips">
        <a class="dr-chip <?= $activeRole === '' ? 'on' : '' ?>" href="<?= e(url('public/index.php?page=dosen&q=' . urlencode($q))) ?>">
            ✨ Semua <b><?= count($users) ?></b>
        </a>
        <?php foreach ($roleLabels as $k => $l):
            $count = count(array_filter($users, fn($u) => ($u['role'] ?? '') === $k));
            if ($count === 0) continue;
        ?>
        <a class="dr-chip <?= $activeRole === $k ? 'on' : '' ?>" href="<?= e(url('public/index.php?page=dosen&q=' . urlencode($q) . '&role=' . urlencode($k))) ?>">
            <?= e($l) ?> <b><?= $count ?></b>
        </a>
        <?php endforeach; ?>
    </div>

    <div class="dr-count" id="drCount"><?= count($users) ?> dosen ditampilkan</div>

    <?php if (empty($users)): ?>
    <div class="dr-empty">
        <div style="font-size:52px; margin-bottom:12px;">👥</div>
        <h3 style="margin:0 0 6px; color:var(--ink);">Tidak Ada Dosen Ditemukan</h3>
        <p style="margin:0;">Coba kata kunci lain, atau hubungi admin untuk menambahkan data dosen.</p>
    </div>
    <?php else: ?>
    <div class="dr-grid" id="drGrid">
        <?php foreach ($users as $i => $u):
            $init = DosenResolver::initials($u['name'] ?? '');
            $ct = $u['counts'] ?? ['r'=>0,'p'=>0,'h'=>0,'c'=>0];
            $isFeatured = $i === 0 && (($ct['r'] ?? 0) + ($ct['p'] ?? 0) + ($ct['h'] ?? 0) + ($ct['c'] ?? 0)) > 0;
            $roleColor = $roleColors[$u['role'] ?? ''] ?? '#059669';
        ?>
        <a class="dr-card <?= $isFeatured ? 'featured' : '' ?>" style="animation-delay:<?= min($i * 0.04, 0.4) ?>s" href="<?= e(url('public/index.php?page=dosen&id=' . $u['id'])) ?>">
            <div>
                <div class="dr-top">
                    <div class="dr-av">
                        <?php if (!empty($u['photo'])): ?>
                            <img src="<?= e(upload_url($u['photo'])) ?>" alt="<?= e($u['name']) ?>">
                        <?php else: ?>
                            <?= e($init) ?>
                        <?php endif; ?>
                        <?php if (($ct['total'] ?? 0) > 5): ?><span class="dr-verified" title="Terverifikasi">✓</span><?php endif; ?>
                    </div>
                    <div style="min-width:0;">
                        <div class="dr-name"><?= e($u['name']) ?></div>
                        <span class="dr-role" style="color:<?= $roleColor ?>; background:<?= $roleColor ?>14; border-color:<?= $roleColor ?>40;"><?= e($roleLabels[$u['role'] ?? ''] ?? 'Dosen') ?></span>
                        <?php if (!empty($u['nidn'])): ?><div class="dr-inst">NIDN: <?= e($u['nidn']) ?></div><?php endif; ?>
                    </div>
                </div>
                <?php if ($isFeatured && !empty($u['bio'])): ?>
                <p class="dr-bio"><?= e($u['bio']) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <div class="dr-stats">
                    <div class="dr-stat"><b><?= (int) ($ct['r'] ?? 0) ?></b><span>Riset</span></div>
                    <div class="dr-stat"><b><?= (int) ($ct['p'] ?? 0) ?></b><span>Publikasi</span></div>
                    <div class="dr-stat"><b><?= (int) ($ct['h'] ?? 0) ?></b><span>HAKI</span></div>
                    <div class="dr-stat"><b><?= (int) ($ct['c'] ?? 0) ?></b><span>Abdimas</span></div>
                </div>
                <span class="dr-cta">Lihat Profil Lengkap →</span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>

<script>
(function(){
    /* Client-side search + filter */
    var q = document.getElementById('drQ');
    var countEl = document.getElementById('drCount');
    var cards = Array.prototype.slice.call(document.querySelectorAll('.dr-card'));

    if (q) q.addEventListener('input', function(){
        var val = this.value.toLowerCase();
        var n = 0;
        cards.forEach(function(c){
            var show = c.textContent.toLowerCase().indexOf(val) !== -1;
            c.style.display = show ? '' : 'none';
            if (show) n++;
        });
        if (countEl) countEl.textContent = n + ' dosen ditampilkan';
    });

    /* Scroll reveal */
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(es){
            es.forEach(function(en){
                if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
            });
        }, { threshold: .12 });
        cards.forEach(function(c){ io.observe(c); });
    } else {
        cards.forEach(function(c){ c.classList.add('in'); });
    }
})();
</script>