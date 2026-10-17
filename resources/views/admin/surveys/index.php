<style>
    @keyframes svFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    @keyframes svShine { 0%,55%{left:-90%} 100%{left:165%} }
    .sv-head { position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:24px 28px; border-radius:22px; background:linear-gradient(135deg,#4c1d95 0%,#6d28d9 55%,#7c3aed 100%); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:svFade .5s both; }
    .sv-head::after { content:''; position:absolute; top:-50%; right:-8%; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(196,181,253,.22),transparent 70%); pointer-events:none; }
    .sv-head-ico { width:54px; height:54px; border-radius:16px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:25px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.55),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), 0 6px 16px rgba(217,164,65,.4); position:relative; z-index:1; }
    .sv-head h2 { margin:0; font-family:var(--font-display); font-size:21px; font-weight:900; position:relative; z-index:1; }
    .sv-head p { margin:3px 0 0; font-size:12.5px; opacity:.88; position:relative; z-index:1; }
    .sv-stats { display:flex; gap:8px; flex-wrap:wrap; margin-left:auto; position:relative; z-index:1; }
    .sv-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); border-radius:14px; padding:10px 16px; text-align:center; min-width:80px; backdrop-filter:blur(6px); }
    .sv-stat b { display:block; font-family:var(--font-display); font-size:19px; font-weight:900; color:#fde68a; line-height:1.1; }
    .sv-stat span { font-size:9px; letter-spacing:.12em; text-transform:uppercase; opacity:.85; display:block; margin-top:3px; }

    .sv-bar { display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:20px; padding:14px 16px; background:var(--surface); border:1px solid var(--border); border-radius:14px; animation:svFade .5s .05s both; }
    .sv-bar form { display:flex; gap:8px; flex:1; min-width:220px; }
    .sv-bar input { flex:1; padding:9px 14px; border-radius:10px; border:1px solid var(--border); background:var(--surface); font-size:13px; font-weight:700; color:var(--text); }
    .sv-bar input:focus { outline:none; border-color:#7c3aed; box-shadow:0 0 0 4px rgba(124,58,237,.14); }
    .sv-bar button { position:relative; overflow:hidden; padding:9px 18px; border:none; border-radius:10px; font-size:13px; font-weight:900; cursor:pointer; color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:0 4px 12px rgba(217,164,65,.3); }
    .sv-bar .new { padding:9px 18px; border-radius:10px; font-size:13px; font-weight:800; text-decoration:none; color:#fff; background:linear-gradient(145deg,#8b5cf6,#6d28d9); box-shadow:0 4px 12px rgba(124,58,237,.35); }

    .sv-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:18px; }
    .sv-card { position:relative; overflow:hidden; display:flex; flex-direction:column; gap:12px; padding:22px; border-radius:20px; background:var(--surface); border:1px solid var(--border); box-shadow:0 8px 22px rgba(3,37,31,.06); transition:all .3s cubic-bezier(.16,1,.3,1); opacity:0; transform:translateY(16px); }
    .sv-card.in { opacity:1; transform:translateY(0); transition:opacity .5s, transform .5s, box-shadow .3s, border-color .3s; }
    .sv-card.in:hover { transform:translateY(-5px); border-color:rgba(124,58,237,.4); box-shadow:0 18px 36px rgba(124,58,237,.16); }
    .sv-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,#8b5cf6,#c4b5fd); opacity:.85; }
    .sv-card-top { display:flex; align-items:flex-start; gap:12px; }
    .sv-ring { width:56px; height:56px; border-radius:50%; flex-shrink:0; position:relative; display:flex; align-items:center; justify-content:center; }
    .sv-ring b { position:relative; z-index:1; font-family:var(--font-display); font-size:14px; font-weight:900; color:var(--ink); }
    .sv-card-top h3 { margin:0 0 4px; font-family:var(--font-display); font-size:15.5px; font-weight:900; color:var(--text); line-height:1.3; }
    .sv-meta { display:flex; gap:8px; flex-wrap:wrap; font-size:11px; color:var(--muted); }
    .sv-tag { padding:2px 9px; border-radius:999px; font-size:9.5px; font-weight:900; letter-spacing:.06em; }
    .sv-tag.open { background:rgba(16,185,129,.14); color:#047857; border:1px solid rgba(16,185,129,.35); }
    .sv-tag.closed { background:rgba(100,116,139,.12); color:var(--muted); border:1px solid var(--border); }
    .sv-tag.draft { background:rgba(245,158,11,.14); color:#92400e; border:1px solid rgba(245,158,11,.35); }
    .sv-nums { display:grid; grid-template-columns:1fr 1fr 1fr; gap:8px; }
    .sv-num { padding:10px; border-radius:12px; background:rgba(255,255,255,.03); border:1px solid var(--border); text-align:center; }
    .sv-num b { display:block; font-family:var(--font-display); font-size:17px; font-weight:900; color:var(--text); }
    .sv-num span { font-size:9px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; color:var(--muted); }
    .sv-acts { display:flex; gap:7px; flex-wrap:wrap; margin-top:auto; padding-top:12px; border-top:1px dashed var(--border); }
    .sv-btn { padding:8px 13px; border-radius:9px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--muted); font-size:11.5px; font-weight:800; text-decoration:none; cursor:pointer; transition:all .2s; display:inline-flex; align-items:center; gap:5px; }
    .sv-btn:hover { border-color:rgba(124,58,237,.45); color:var(--text); transform:translateY(-2px); }
    .sv-btn.primary { background:linear-gradient(145deg,#8b5cf6,#6d28d9); color:#fff; border-color:transparent; }
    .sv-btn.danger:hover { border-color:rgba(220,38,38,.5); color:#fca5a5; }
    .sv-empty { text-align:center; padding:60px 20px; color:var(--muted); background:var(--surface); border:2px dashed var(--border); border-radius:20px; }
</style>

<div class="sv-head">
    <div class="sv-head-ico">📝</div>
    <div style="position:relative;z-index:1;">
        <h2>Survei Kepuasan & EDOM</h2>
        <p>Kelola kuesioner, pantau indeks kepuasan, dan unduh rekap respons.</p>
    </div>
    <div class="sv-stats">
        <div class="sv-stat"><b><?= (int) $stats['total'] ?></b><span>Survei</span></div>
        <div class="sv-stat"><b><?= (int) $stats['open'] ?></b><span>Terbuka</span></div>
        <div class="sv-stat"><b><?= number_format($stats['answers']) ?></b><span>Respons</span></div>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<div class="sv-bar">
    <form method="get" action="<?= e(url('admin/index.php')) ?>">
        <input type="hidden" name="page" value="survei">
        <input type="text" name="q" value="<?= e($q) ?>" placeholder="🔍 Cari judul survei...">
        <button type="submit">Cari</button>
    </form>
    <a class="new" href="<?= e(url('admin/index.php?page=survei-tambah')) ?>">➕ Buat Survei</a>
</div>

<?php if (empty($items)): ?>
<div class="sv-empty"><div style="font-size:48px;margin-bottom:10px;">📝</div>Belum ada survei. Klik "Buat Survei" untuk memulai.</div>
<?php else: ?>
<div class="sv-grid">
    <?php foreach ($items as $i => $sv):
        $ikm = $sv['ikm'];
        $deg = round(($ikm['index'] / 100) * 360);
    ?>
    <div class="sv-card">
        <div class="sv-card-top">
            <div class="sv-ring" style="background:conic-gradient(<?= e($ikm['color']) ?> <?= $deg ?>deg, rgba(255,255,255,.08) 0);">
                <b><?= $ikm['index'] > 0 ? round($ikm['index']) : '–' ?></b>
            </div>
            <div style="flex:1;min-width:0;">
                <h3><?= e($sv['title']) ?></h3>
                <div class="sv-meta">
                    <span class="sv-tag <?= e($sv['status']) ?>"><?= e(Survey::STATUSES[$sv['status']] ?? $sv['status']) ?></span>
                    <span>🎯 <?= e(Survey::TARGETS[$sv['target_audience']] ?? 'Umum') ?></span>
                </div>
            </div>
        </div>
        <div class="sv-nums">
            <div class="sv-num"><b><?= (int) $sv['questions'] ?></b><span>Pertanyaan</span></div>
            <div class="sv-num"><b><?= number_format($sv['responses']) ?></b><span>Respons</span></div>
            <div class="sv-num"><b style="color:<?= e($ikm['color']) ?>"><?= $ikm['index'] > 0 ? round($ikm['index']) : '–' ?></b><span>IKM</span></div>
        </div>
        <div class="sv-acts">
            <a class="sv-btn primary" href="<?= e(url('admin/index.php?page=survei-hasil&id=' . $sv['id'])) ?>">📊 Hasil</a>
            <a class="sv-btn" href="<?= e(url('admin/index.php?page=survei-edit&id=' . $sv['id'])) ?>">✏️ Edit</a>
            <form method="post" action="<?= e(url('admin/index.php?page=survei-status')) ?>" style="display:inline;">
                <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $sv['id'] ?>">
                <button class="sv-btn" type="submit"><?= $sv['status'] === 'open' ? '🔒 Tutup' : '🔓 Buka' ?></button>
            </form>
            <a class="sv-btn" href="<?= e(url('admin/index.php?page=survei-export&id=' . $sv['id'])) ?>">📥 CSV</a>
            <form method="post" action="<?= e(url('admin/index.php?page=survei-hapus')) ?>" style="display:inline;" onsubmit="return confirm('Hapus survei ini beserta semua respons?');">
                <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $sv['id'] ?>">
                <button class="sv-btn danger" type="submit">🗑️</button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if ($totalPages > 1): ?>
<div style="margin-top:18px; display:flex; justify-content:center; gap:6px; flex-wrap:wrap;">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="<?= e(url('admin/index.php?page=survei&hal=' . $i . '&q=' . urlencode($q))) ?>" class="pag-3d <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>
<?php endif; ?>

<script>
(function(){
    var cards = document.querySelectorAll('.sv-card');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(es){ es.forEach(function(en){ if (en.isIntersecting){ en.target.classList.add('in'); io.unobserve(en.target); } }); }, { threshold: 0.1 });
        cards.forEach(function(c){ io.observe(c); });
    } else { cards.forEach(function(c){ c.classList.add('in'); }); }
})();
</script>