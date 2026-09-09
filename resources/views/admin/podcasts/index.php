<style>
    @keyframes pdFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    .pd-head { position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:26px 30px; border-radius:22px; background:linear-gradient(135deg,#7c2d12 0%,#c2410c 55%,#ea580c 100%); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:pdFade .5s both; }
    .pd-head-ico { width:56px; height:56px; border-radius:16px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:26px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.55),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), 0 6px 16px rgba(217,164,65,.4); position:relative; z-index:1; }
    .pd-head h2 { margin:0 0 4px; font-family:var(--font-display); font-size:21px; font-weight:900; position:relative; z-index:1; }
    .pd-head p { margin:0; font-size:12.5px; opacity:.9; position:relative; z-index:1; }
    .pd-stats { display:flex; gap:8px; flex-wrap:wrap; margin-left:auto; position:relative; z-index:1; }
    .pd-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); border-radius:14px; padding:10px 16px; text-align:center; min-width:86px; }
    .pd-stat b { display:block; font-family:var(--font-display); font-size:18px; font-weight:900; color:#fed7aa; line-height:1.1; }
    .pd-stat span { font-size:9px; letter-spacing:.12em; text-transform:uppercase; opacity:.85; display:block; margin-top:3px; }
    .pd-bar { display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:16px; padding:14px 16px; background:var(--surface); border:1px solid var(--border); border-radius:14px; animation:pdFade .5s .05s both; }
    .pd-bar input, .pd-bar select { padding:10px 14px; border-radius:10px; border:1px solid var(--border); background:var(--surface); font-size:13px; color:var(--text); }
    .pd-bar input { flex:1; min-width:180px; }
    .pd-btn { padding:10px 18px; border-radius:10px; font-size:13px; font-weight:800; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:6px; border:none; transition:all .2s; }
    .pd-btn.gold { color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:0 5px 14px rgba(217,164,65,.35); }
    .pd-btn:hover { transform:translateY(-2px); filter:brightness(1.05); }
    .pd-table { width:100%; border-collapse:collapse; background:var(--surface); border:1px solid var(--border); border-radius:18px; overflow:hidden; animation:pdFade .5s .08s both; }
    .pd-table th { padding:11px 14px; text-align:left; font-size:10px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); border-bottom:1px solid var(--border); }
    .pd-table td { padding:11px 14px; border-bottom:1px solid var(--border); font-size:12.5px; color:var(--text); vertical-align:middle; }
    .pd-table tr:last-child td { border-bottom:none; }
    .pd-cover { width:56px; height:56px; object-fit:cover; border-radius:10px; border:1px solid var(--border); background:#0d1d17; }
    .pd-tag { padding:3px 10px; border-radius:999px; font-size:9.5px; font-weight:900; white-space:nowrap; }
    .pd-tag.published { background:rgba(16,185,129,.14); color:#047857; }
    .pd-tag.draft { background:rgba(100,116,139,.15); color:var(--muted); }
    .pd-mini { padding:7px 11px; border-radius:9px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--muted); font-size:11.5px; font-weight:800; cursor:pointer; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:5px; }
    .pd-mini:hover { border-color:rgba(234,88,12,.5); color:#ea580c; transform:translateY(-2px); }
    .pd-mini.danger:hover { border-color:rgba(220,38,38,.5); color:#fca5a5; }
    .pd-empty { text-align:center; padding:50px 20px; color:var(--muted); background:var(--surface); border:2px dashed var(--border); border-radius:20px; }
    .pd-pag { display:flex; gap:6px; justify-content:center; margin-top:16px; }
    .pd-pag a { padding:8px 13px; border-radius:9px; border:1px solid var(--border); background:var(--surface); color:var(--muted); font-size:12px; font-weight:800; text-decoration:none; }
    .pd-pag a.on { background:linear-gradient(145deg,#ea580c,#7c2d12); color:#fff; border-color:transparent; }
    .pd-audio-mini { width:200px; height:32px; }
</style>

<div class="pd-head">
    <div class="pd-head-ico">🎙️</div>
    <div style="position:relative;z-index:1;">
        <h2>Podcast LP3M</h2>
        <p>Kelola episode podcast: diskusi, wawancara, kuliah tamu, dan kisah inspiratif.</p>
    </div>
    <div class="pd-stats">
        <div class="pd-stat"><b><?= (int) $stats['total'] ?></b><span>Total</span></div>
        <div class="pd-stat"><b><?= (int) $stats['published'] ?></b><span>Published</span></div>
        <div class="pd-stat"><b><?= number_format((int) $stats['plays']) ?></b><span>Plays</span></div>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<form class="pd-bar" method="get" action="<?= e(url('admin/index.php')) ?>">
    <input type="hidden" name="page" value="podcast">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="🔍 Cari judul / narasumber...">
    <select name="category">
        <option value="">Semua Kategori</option>
        <?php foreach ($categories as $k => $l): ?>
        <option value="<?= e($k) ?>" <?= $filters['category'] === $k ? 'selected' : '' ?>><?= e($l) ?></option>
        <?php endforeach; ?>
    </select>
    <select name="status">
        <option value="">Semua Status</option>
        <option value="published" <?= $filters['status'] === 'published' ? 'selected' : '' ?>>Published</option>
        <option value="draft" <?= $filters['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
    </select>
    <button class="pd-btn gold" type="submit">Filter</button>
    <a class="pd-btn gold" href="<?= e(url('admin/index.php?page=podcast-tambah')) ?>">➕ Tambah Podcast</a>
</form>

<?php if (empty($items)): ?>
<div class="pd-empty">
    <div style="font-size:48px; margin-bottom:10px;">🎧</div>
    <h3 style="margin:0 0 6px; color:var(--ink);">Belum Ada Podcast</h3>
    <p style="margin:0;">Klik "Tambah Podcast" untuk menambahkan episode pertama (upload MP3 atau URL).</p>
</div>
<?php else: ?>
<div style="overflow-x:auto;">
<table class="pd-table">
    <thead><tr><th>Cover</th><th>Judul</th><th>Kategori</th><th>Durasi</th><th>Narasumber</th><th>Plays</th><th>Status</th><th>Preview</th><th style="width:150px;">Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($items as $p): $cover = Podcast::coverUrl($p); $audio = Podcast::audioUrl($p); ?>
    <tr>
        <td>
            <?php if ($cover !== ''): ?>
                <img class="pd-cover" src="<?= e($cover) ?>" alt="">
            <?php else: ?>
                <div class="pd-cover" style="display:flex;align-items:center;justify-content:center;font-size:20px;">🎙️</div>
            <?php endif; ?>
        </td>
        <td>
            <div style="font-weight:800; max-width:220px;"><?= e($p['title']) ?></div>
            <?php if (!empty($p['episode'])): ?>
            <div style="font-size:11px; color:var(--muted); margin-top:2px;">Eps. <?= e($p['episode']) ?></div>
            <?php endif; ?>
        </td>
        <td style="color:var(--muted);"><?= e($categories[$p['category']] ?? $p['category']) ?></td>
        <td style="color:var(--muted);"><?= e($p['duration'] ?: '—') ?></td>
        <td style="color:var(--muted); max-width:180px;"><?= e($p['guest'] ?: '—') ?></td>
        <td style="font-weight:900; color:#ea580c;"><?= number_format((int) $p['plays']) ?></td>
        <td><span class="pd-tag <?= e($p['status']) ?>"><?= e(strtoupper($p['status'])) ?></span></td>
        <td>
            <?php if ($audio !== ''): ?>
            <audio class="pd-audio-mini" controls preload="none">
                <source src="<?= e($audio) ?>" type="audio/mpeg">
                <source src="<?= e($audio) ?>" type="audio/mp4">
                <source src="<?= e($audio) ?>" type="audio/ogg">
            </audio>
            <?php else: ?>
            <span style="color:var(--muted); font-size:11px;">—</span>
            <?php endif; ?>
        </td>
        <td>
            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                <a class="pd-mini" href="<?= e(url('admin/index.php?page=podcast-edit&id=' . $p['id'])) ?>">✏️</a>
                <form method="post" action="<?= e(url('admin/index.php?page=podcast-toggle')) ?>" style="display:inline;">
                    <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                    <button class="pd-mini" type="submit"><?= $p['status'] === 'published' ? '⏸' : '✅' ?></button>
                </form>
                <form method="post" action="<?= e(url('admin/index.php?page=podcast-hapus')) ?>" style="display:inline;" onsubmit="return confirm('Hapus podcast ini?');">
                    <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                    <button class="pd-mini danger" type="submit">🗑️</button>
                </form>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

<?php if ($totalPages > 1): ?>
<div class="pd-pag">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a class="<?= $i === $page ? 'on' : '' ?>" href="<?= e(url('admin/index.php?page=podcast&hal=' . $i . '&q=' . urlencode($q) . '&category=' . urlencode($filters['category']) . '&status=' . urlencode($filters['status']))) ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>
<?php endif; ?>