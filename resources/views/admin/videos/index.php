<style>
    @keyframes vdFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    .vd-head { position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:26px 30px; border-radius:22px; background:linear-gradient(135deg,#312e81 0%,#4338ca 55%,#6366f1 100%); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:vdFade .5s both; }
    .vd-head-ico { width:56px; height:56px; border-radius:16px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:26px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.55),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), 0 6px 16px rgba(217,164,65,.4); position:relative; z-index:1; }
    .vd-head h2 { margin:0 0 4px; font-family:var(--font-display); font-size:21px; font-weight:900; position:relative; z-index:1; }
    .vd-head p { margin:0; font-size:12.5px; opacity:.9; position:relative; z-index:1; }
    .vd-stats { display:flex; gap:8px; flex-wrap:wrap; margin-left:auto; position:relative; z-index:1; }
    .vd-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); border-radius:14px; padding:10px 16px; text-align:center; min-width:86px; }
    .vd-stat b { display:block; font-family:var(--font-display); font-size:18px; font-weight:900; color:#c7d2fe; line-height:1.1; }
    .vd-stat span { font-size:9px; letter-spacing:.12em; text-transform:uppercase; opacity:.85; display:block; margin-top:3px; }
    .vd-bar { display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:16px; padding:14px 16px; background:var(--surface); border:1px solid var(--border); border-radius:14px; animation:vdFade .5s .05s both; }
    .vd-bar input, .vd-bar select { padding:10px 14px; border-radius:10px; border:1px solid var(--border); background:var(--surface); font-size:13px; color:var(--text); }
    .vd-bar input { flex:1; min-width:180px; }
    .vd-btn { padding:10px 18px; border-radius:10px; font-size:13px; font-weight:800; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:6px; border:none; transition:all .2s; }
    .vd-btn.gold { color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:0 5px 14px rgba(217,164,65,.35); }
    .vd-btn:hover { transform:translateY(-2px); filter:brightness(1.05); }
    .vd-table { width:100%; border-collapse:collapse; background:var(--surface); border:1px solid var(--border); border-radius:18px; overflow:hidden; animation:vdFade .5s .08s both; }
    .vd-table th { padding:11px 14px; text-align:left; font-size:10px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); border-bottom:1px solid var(--border); }
    .vd-table td { padding:11px 14px; border-bottom:1px solid var(--border); font-size:12.5px; color:var(--text); vertical-align:middle; }
    .vd-table tr:last-child td { border-bottom:none; }
    .vd-thumb { width:104px; height:58px; object-fit:cover; border-radius:9px; border:1px solid var(--border); background:#0d1d17; }
    .vd-tag { padding:3px 10px; border-radius:999px; font-size:9.5px; font-weight:900; white-space:nowrap; }
    .vd-tag.published { background:rgba(16,185,129,.14); color:#047857; }
    .vd-tag.draft { background:rgba(100,116,139,.15); color:var(--muted); }
    .vd-mini { padding:7px 11px; border-radius:9px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--muted); font-size:11.5px; font-weight:800; cursor:pointer; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:5px; }
    .vd-mini:hover { border-color:rgba(99,102,241,.5); color:#818cf8; transform:translateY(-2px); }
    .vd-mini.danger:hover { border-color:rgba(220,38,38,.5); color:#fca5a5; }
    .vd-empty { text-align:center; padding:50px 20px; color:var(--muted); background:var(--surface); border:2px dashed var(--border); border-radius:20px; }
    .vd-pag { display:flex; gap:6px; justify-content:center; margin-top:16px; }
    .vd-pag a { padding:8px 13px; border-radius:9px; border:1px solid var(--border); background:var(--surface); color:var(--muted); font-size:12px; font-weight:800; text-decoration:none; }
    .vd-pag a.on { background:linear-gradient(145deg,#4338ca,#312e81); color:#fff; border-color:transparent; }
</style>

<div class="vd-head">
    <div class="vd-head-ico">🎥</div>
    <div style="position:relative;z-index:1;">
        <h2>Galeri Video</h2>
        <p>Kelola video seminar, workshop, profil lembaga, dan dokumentasi kegiatan.</p>
    </div>
    <div class="vd-stats">
        <div class="vd-stat"><b><?= (int) $stats['total'] ?></b><span>Total</span></div>
        <div class="vd-stat"><b><?= (int) $stats['published'] ?></b><span>Published</span></div>
        <div class="vd-stat"><b><?= number_format((int) $stats['views']) ?></b><span>Views</span></div>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<form class="vd-bar" method="get" action="<?= e(url('admin/index.php')) ?>">
    <input type="hidden" name="page" value="video">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="🔍 Cari judul video...">
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
    <button class="vd-btn gold" type="submit">Filter</button>
    <a class="vd-btn gold" href="<?= e(url('admin/index.php?page=video-tambah')) ?>">➕ Tambah Video</a>
</form>

<?php if (empty($items)): ?>
<div class="vd-empty">
    <div style="font-size:48px; margin-bottom:10px;">🎬</div>
    <h3 style="margin:0 0 6px; color:var(--ink);">Belum Ada Video</h3>
    <p style="margin:0;">Klik "Tambah Video" untuk menambahkan video pertama (YouTube/Vimeo/MP4).</p>
</div>
<?php else: ?>
<div style="overflow-x:auto;">
<table class="vd-table">
    <thead><tr><th>Thumbnail</th><th>Judul</th><th>Kategori</th><th>Sumber</th><th>Durasi</th><th>Views</th><th>Status</th><th style="width:150px;">Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($items as $v): $thumb = Video::thumbUrl($v); ?>
    <tr>
        <td>
            <?php if ($thumb !== ''): ?><img class="vd-thumb" src="<?= e($thumb) ?>" alt=""><?= else: ?><div class="vd-thumb"></div><?php endif; ?>
        </td>
        <td style="font-weight:800; max-width:260px;"><?= e($v['title']) ?></td>
        <td style="color:var(--muted);"><?= e($categories[$v['category']] ?? $v['category']) ?></td>
        <td style="color:var(--muted);"><?= e($sources[$v['source']] ?? $v['source']) ?></td>
        <td style="color:var(--muted);"><?= e($v['duration'] ?: '—') ?></td>
        <td style="font-weight:900; color:#818cf8;"><?= number_format((int) $v['views']) ?></td>
        <td><span class="vd-tag <?= e($v['status']) ?>"><?= e(strtoupper($v['status'])) ?></span></td>
        <td>
            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                <a class="vd-mini" href="<?= e(url('admin/index.php?page=video-edit&id=' . $v['id'])) ?>">✏️</a>
                <form method="post" action="<?= e(url('admin/index.php?page=video-toggle')) ?>" style="display:inline;">
                    <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $v['id'] ?>">
                    <button class="vd-mini" type="submit"><?= $v['status'] === 'published' ? '⏸' : '✅' ?></button>
                </form>
                <form method="post" action="<?= e(url('admin/index.php?page=video-hapus')) ?>" style="display:inline;" onsubmit="return confirm('Hapus video ini?');">
                    <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $v['id'] ?>">
                    <button class="vd-mini danger" type="submit">🗑️</button>
                </form>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

<?php if ($totalPages > 1): ?>
<div class="vd-pag">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a class="<?= $i === $page ? 'on' : '' ?>" href="<?= e(url('admin/index.php?page=video&hal=' . $i . '&q=' . urlencode($q) . '&category=' . urlencode($filters['category']) . '&status=' . urlencode($filters['status']))) ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>
<?php endif; ?>