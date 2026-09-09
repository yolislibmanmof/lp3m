<?php
$roleLabels = [
    'dosen' => 'Dosen', 'admin_lp3m' => 'Admin LP3M', 'super_admin' => 'Super Admin',
    'pimpinan' => 'Pimpinan', 'reviewer' => 'Reviewer',
];
?>

<style>
    @keyframes drFade { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:none} }
    @keyframes drShine { 0%,55%{left:-90%} 100%{left:165%} }

    .dr-wrap { max-width:1100px; margin:0 auto; padding:0 20px; }

    /* HERO */
    .dr-hero { position:relative; overflow:hidden; padding:52px 44px; border-radius:28px; background:linear-gradient(135deg,#065f46 0%,#059669 55%,#10b981 100%); color:#fff; box-shadow:0 24px 60px rgba(3,37,31,.35); margin-bottom:26px; animation:drFade .6s both; }
    .dr-hero::before { content:''; position:absolute; inset:0; opacity:.3; background-image:repeating-linear-gradient(45deg,transparent,transparent 30px,rgba(253,230,138,.06) 30px,rgba(253,230,138,.06) 31px); pointer-events:none; }
    .dr-hero::after { content:''; position:absolute; top:-50%; right:-10%; width:380px; height:380px; border-radius:50%; background:radial-gradient(circle,rgba(253,230,138,.25),transparent 70%); pointer-events:none; }
    .dr-hero .tag { display:inline-flex; padding:5px 14px; border-radius:999px; font-size:10.5px; font-weight:900; letter-spacing:.18em; text-transform:uppercase; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.3); margin-bottom:14px; position:relative; z-index:1; }
    .dr-hero h1 { font-family:var(--font-display); font-size:clamp(26px,4vw,40px); font-weight:900; letter-spacing:-.02em; margin:0 0 10px; position:relative; z-index:1; }
    .dr-hero p { font-size:14.5px; line-height:1.7; opacity:.92; max-width:620px; margin:0 0 22px; position:relative; z-index:1; }
    .dr-search { position:relative; max-width:460px; z-index:1; }
    .dr-search input { width:100%; padding:13px 18px 13px 46px; border-radius:14px; border:2px solid rgba(255,255,255,.3); background:rgba(255,255,255,.14); backdrop-filter:blur(8px); color:#fff; font-size:14px; font-weight:600; }
    .dr-search input::placeholder { color:rgba(255,255,255,.65); }
    .dr-search input:focus { outline:none; border-color:#fde68a; background:rgba(255,255,255,.2); }
    .dr-search .ico { position:absolute; left:16px; top:50%; transform:translateY(-50%); font-size:16px; opacity:.8; }

    /* GRID */
    .dr-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(250px,1fr)); gap:18px; margin-bottom:30px; }
    .dr-card { position:relative; overflow:hidden; display:flex; flex-direction:column; gap:12px; padding:24px 22px; border-radius:20px; background:var(--surface); border:1px solid var(--border); box-shadow:0 8px 22px rgba(3,37,31,.06); text-decoration:none; color:inherit; transition:all .3s cubic-bezier(.16,1,.3,1); animation:drFade .5s both; }
    .dr-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,#065f46,#10b981,#f2c063); opacity:.85; }
    .dr-card::after { content:''; position:absolute; top:0; left:-120%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); transform:skewX(-20deg); pointer-events:none; }
    .dr-card:hover { transform:translateY(-6px); border-color:rgba(5,150,105,.4); box-shadow:0 18px 38px rgba(5,150,105,.16); }
    .dr-card:hover::after { animation:drShine .9s ease-out; }
    .dr-card:hover .dr-av { transform:scale(1.06) rotate(-3deg); }
    .dr-top { display:flex; gap:14px; align-items:center; }
    .dr-av { width:62px; height:62px; border-radius:50%; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:21px; font-weight:900; color:#03251f; background:radial-gradient(circle at 30% 25%,#fff7c2,#fde68a 20%,#f2c063 55%,#d9a441); box-shadow:inset 0 2px 4px rgba(255,255,255,.65), inset 0 -3px 5px rgba(0,0,0,.2), 0 6px 16px rgba(217,164,65,.4); transition:transform .3s; overflow:hidden; }
    .dr-av img { width:100%; height:100%; object-fit:cover; }
    .dr-name { font-family:var(--font-display); font-size:15px; font-weight:900; color:var(--ink); line-height:1.3; margin:0 0 4px; }
    .dr-role { display:inline-flex; padding:2px 10px; border-radius:999px; font-size:9.5px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; background:rgba(5,150,105,.12); color:#047857; border:1px solid rgba(5,150,105,.3); }
    .dr-inst { font-size:11.5px; color:var(--muted); margin-top:5px; }
    .dr-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:6px; }
    .dr-stat { padding:8px 4px; border-radius:10px; background:rgba(255,255,255,.03); border:1px solid var(--border); text-align:center; }
    .dr-stat b { display:block; font-family:var(--font-display); font-size:15px; font-weight:900; color:var(--ink); line-height:1; }
    .dr-stat span { display:block; font-size:8px; font-weight:800; letter-spacing:.06em; text-transform:uppercase; color:var(--muted); margin-top:3px; }
    .dr-cta { margin-top:auto; display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px; border-radius:12px; font-size:12.5px; font-weight:800; color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:0 5px 14px rgba(217,164,65,.35); }
    .dr-empty { text-align:center; padding:60px 20px; border-radius:22px; background:var(--surface); border:2px dashed var(--border); color:var(--muted); }
</style>

<div class="dr-wrap">

    <div class="dr-hero">
        <span class="tag">👨🏫 Sivitas Akademika</span>
        <h1>Direktori Dosen & Peneliti</h1>
        <p>Jelajahi profil akademik dosen LP3M UNIMOF — lengkap dengan rekam jejak penelitian, publikasi ilmiah, HAKI, dan pengabdian kepada masyarakat.</p>
        <form class="dr-search" method="get" action="<?= e(url('public/index.php')) ?>">
            <input type="hidden" name="page" value="dosen">
            <span class="ico">🔍</span>
            <input type="text" name="q" value="<?= e($q) ?>" placeholder="Cari nama dosen...">
        </form>
    </div>

    <?php if (empty($users)): ?>
    <div class="dr-empty">
        <div style="font-size:52px; margin-bottom:12px;">👥</div>
        <h3 style="margin:0 0 6px; color:var(--ink);">Tidak Ada Dosen Ditemukan</h3>
        <p style="margin:0;">Coba kata kunci lain, atau hubungi admin untuk menambahkan data dosen.</p>
    </div>
    <?php else: ?>
    <div class="dr-grid">
        <?php foreach ($users as $i => $u):
            $init = DosenResolver::initials($u['name'] ?? '');
            $ct = $u['counts'];
        ?>
        <a class="dr-card" style="animation-delay:<?= min($i * 0.04, 0.4) ?>s" href="<?= e(url('public/index.php?page=dosen&id=' . $u['id'])) ?>">
            <div class="dr-top">
                <div class="dr-av">
                    <?php if (!empty($u['photo'])): ?>
                        <img src="<?= e(upload_url($u['photo'])) ?>" alt="<?= e($u['name']) ?>">
                    <?php else: ?>
                        <?= e($init) ?>
                    <?php endif; ?>
                </div>
                <div style="min-width:0;">
                    <div class="dr-name"><?= e($u['name']) ?></div>
                    <span class="dr-role"><?= e($roleLabels[$u['role'] ?? ''] ?? 'Dosen') ?></span>
                    <?php if (!empty($u['nidn'])): ?><div class="dr-inst">NIDN: <?= e($u['nidn']) ?></div><?php endif; ?>
                </div>
            </div>

            <div class="dr-stats">
                <div class="dr-stat"><b><?= (int) $ct['r'] ?></b><span>Riset</span></div>
                <div class="dr-stat"><b><?= (int) $ct['p'] ?></b><span>Publikasi</span></div>
                <div class="dr-stat"><b><?= (int) $ct['h'] ?></b><span>HAKI</span></div>
                <div class="dr-stat"><b><?= (int) $ct['c'] ?></b><span>Abdimas</span></div>
            </div>

            <span class="dr-cta">Lihat Profil Lengkap →</span>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>