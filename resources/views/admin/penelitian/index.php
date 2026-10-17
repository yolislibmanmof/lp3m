<style>
    .rs-status { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:999px; font-size:10px; font-weight:800; }
    .rs-draft { background:rgba(100,116,139,.12); color:#475569; }
    .rs-diajukan,.rs-review { background:rgba(59,130,246,.12); color:#1e40af; }
    .rs-didanai,.rs-berlangsung { background:rgba(16,185,129,.14); color:#065f46; }
    .rs-selesai { background:rgba(217,164,65,.16); color:#92400e; }
    .rs-ditolak { background:rgba(220,38,38,.12); color:#991b1b; }
</style>

<div style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:20px;">
    <div>
        <h2 style="font-size:24px; font-weight:900; color:#fff; margin:0 0 4px;">🔬 Penelitian</h2>
        <p style="color:rgba(255,255,255,.6); font-size:13px; margin:0;"><?= $total ?> proposal penelitian tercatat.</p>
    </div>
    <a href="<?= e(url('admin/index.php?page=penelitian-tambah')) ?>" class="btn-admin btn-primary">➕ Tambah Penelitian</a>
</div>

<?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
        <?= $flash['type'] === 'error' ? '️' : '✅' ?> <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<form method="get" action="<?= e(url('admin/index.php')) ?>" class="filter-bar">
    <input type="hidden" name="page" value="penelitian">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="🔍 Cari judul / ketua...">
    <select name="status">
        <option value="">Semua Status</option>
        <?php foreach (Research::STATUSES as $k => $l): ?>
            <option value="<?= e($k) ?>" <?= $status === $k ? 'selected' : '' ?>><?= e($l) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn-admin">Filter</button>
</form>

<table class="admin-table">
    <thead><tr><th>Judul</th><th>Skema</th><th>Ketua</th><th>Tahun</th><th>Status</th><th style="width:140px;">Aksi</th></tr></thead>
    <tbody>
    <?php if (empty($items)): ?>
        <tr><td colspan="6" style="text-align:center; padding:30px; color:rgba(255,255,255,.5);">Belum ada penelitian.</td></tr>
    <?php else: foreach ($items as $it): ?>
        <tr>
            <td style="font-weight:700;"><?= e($it['title']) ?></td>
            <td><?= e(Research::SCHEMES[$it['scheme']] ?? $it['scheme']) ?></td>
            <td><?= e($it['leader']) ?></td>
            <td><?= (int)$it['year'] ?></td>
            <td><span class="rs-status rs-<?= e($it['status']) ?>"><?= e(Research::STATUSES[$it['status']] ?? $it['status']) ?></span></td>
            <td>
                <div class="row-actions">
                    <a class="btn-admin" href="<?= e(url('admin/index.php?page=penelitian-edit&id=' . $it['id'])) ?>">✏️</a>
                    <form method="post" action="<?= e(url('admin/index.php?page=penelitian-hapus')) ?>" onsubmit="return confirm('Hapus penelitian ini?');" style="display:inline;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
                        <button class="btn-admin btn-danger" type="submit">🗑️</button>
                    </form>
                </div>
            </td>
        </tr>
    <?php endforeach; endif; ?>
    </tbody>
</table>

<?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= e(url('admin/index.php?page=penelitian&hal=' . $i . ($status ? '&status=' . $status : '') . ($q ? '&q=' . urlencode($q) : ''))) ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>