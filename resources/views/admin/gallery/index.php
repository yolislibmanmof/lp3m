<style>
    @keyframes glFade { from{opacity:0; transform:translateY(14px)} to{opacity:1; transform:none} }
    .gl-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:18px; }
    .gl-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,.2); transition:transform .25s, box-shadow .25s; animation:glFade .5s ease both; }
    .gl-card:hover { transform:translateY(-4px); box-shadow:0 12px 28px rgba(0,0,0,.3); }
    .gl-thumb { position:relative; height:160px; }
    .gl-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
    .gl-cat { position:absolute; top:10px; left:10px; padding:3px 10px; border-radius:999px; font-size:10px; font-weight:800; background:rgba(3,37,31,.7); color:#fde68a; border:1px solid rgba(217,164,65,.4); }
    .gl-body { padding:14px 16px 10px; }
    .gl-title { font-size:14px; font-weight:700; color:#fff; margin:0 0 4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .gl-date { font-size:11px; color:var(--muted); }
    .gl-actions { display:flex; gap:8px; justify-content:flex-end; padding:0 16px 14px; }
    .gl-act { padding:7px 12px; border-radius:9px; font-size:12px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:5px; transition:all .2s; border:1px solid transparent; cursor:pointer; font-family:inherit; }
    .gl-act.edit { background:rgba(59,130,246,.12); color:#93c5fd; border-color:rgba(59,130,246,.25); }
    .gl-act.edit:hover { background:#2563eb; color:#fff; }
    .gl-act.del { background:rgba(239,68,68,.12); color:#fca5a5; border-color:rgba(239,68,68,.25); }
    .gl-act.del:hover { background:#dc2626; color:#fff; }
    .gl-empty { text-align:center; padding:60px 20px; color:var(--muted); background:var(--surface); border:1px dashed var(--border); border-radius:16px; }
</style>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div style="display:flex; align-items:center; gap:14px;">
        <div style="width:52px;height:52px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:24px;background:radial-gradient(circle at 30% 25%, rgba(255,255,255,.5), transparent 40%), linear-gradient(145deg,#c4b5fd,#a78bfa 50%,#7c3aed);box-shadow:inset 0 2px 3px rgba(255,255,255,.6), inset 0 -3px 4px rgba(0,0,0,.25), 0 6px 14px rgba(124,58,237,.35);">🖼️</div>
        <div>
            <h2 style="font-family:var(--font-display); font-size:24px; font-weight:900; color:#fff; margin:0;">Galeri Kegiatan</h2>
            <p style="color:var(--muted); font-size:13px; margin:3px 0 0;">Dokumentasi visual kegiatan lembaga yang tampil di publik.</p>
        </div>
    </div>
    <a href="<?= e(url('admin/index.php?page=galeri-tambah')) ?>" style="position:relative; overflow:hidden; display:inline-flex; align-items:center; gap:8px; background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441); color:#03251f; padding:11px 20px; border-radius:12px; text-decoration:none; font-weight:800; font-size:13px; box-shadow:inset 0 2px 3px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.15), 0 8px 18px rgba(217,164,65,.35);">＋ Unggah Foto</a>
</div>

<?php if (!empty($flash)): ?>
    <div style="padding:13px 18px; border-radius:14px; margin-bottom:20px; font-size:14px; font-weight:700; background:<?= $flash['type'] === 'error' ? 'rgba(239,68,68,.12)' : 'rgba(16,185,129,.12)' ?>; color:<?= $flash['type'] === 'error' ? '#fca5a5' : '#6ee7b7' ?>; border:1px solid <?= $flash['type'] === 'error' ? 'rgba(239,68,68,.3)' : 'rgba(16,185,129,.3)' ?>;">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<?php if (empty($items)): ?>
    <div class="gl-empty">
        <span style="font-size:40px; display:block; margin-bottom:10px;">📷</span>
        Belum ada foto di galeri. Klik <strong>＋ Unggah Foto</strong> untuk memulai.
    </div>
<?php else: ?>
    <div class="gl-grid">
        <?php foreach ($items as $item): ?>
        <div class="gl-card">
            <div class="gl-thumb">
                <img src="<?= e(upload_url($item['image_path'])) ?>" alt="<?= e($item['title']) ?>" loading="lazy">
                <span class="gl-cat"><?= e($item['category']) ?></span>
            </div>
            <div class="gl-body">
                <p class="gl-title"><?= e($item['title']) ?></p>
                <span class="gl-date"><?= !empty($item['event_date']) ? '📅 ' . date('d M Y', strtotime($item['event_date'])) : '🕒 ' . date('d M Y', strtotime($item['created_at'])) ?></span>
            </div>
            <div class="gl-actions">
                <a href="<?= e(url('admin/index.php?page=galeri-edit&id=' . $item['id'])) ?>" class="gl-act edit">✏️ Edit</a>
                <form method="post" action="<?= e(url('admin/index.php?page=galeri-hapus')) ?>" style="display:inline;" onsubmit="return confirm('Hapus foto ini?');">
                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="gl-act del">🗑️ Hapus</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>