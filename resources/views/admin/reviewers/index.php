<style>
.rv-head{display:flex;align-items:center;gap:16px;margin-bottom:22px;padding:22px 26px;border-radius:22px;background:linear-gradient(135deg,#0c2a4d,#1e40af 60%,#3b82f6);color:#fff;position:relative;overflow:hidden;box-shadow:0 14px 36px rgba(0,0,0,.3)}
.rv-head::after{content:'';position:absolute;top:-50%;right:-10%;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,.18),transparent 70%)}
.rv-stat{background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:14px;padding:10px 16px;text-align:center;min-width:96px}
.rv-stat .v{font-size:20px;font-weight:900;color:#fde68a;font-family:var(--font-display)}
.rv-stat .l{font-size:9px;letter-spacing:.14em;text-transform:uppercase;opacity:.75}
.rv-star{color:#fbbf24;letter-spacing:1px;font-size:12px}
.rv-chip{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:999px;font-size:10px;font-weight:800}
.rv-chip.int{background:rgba(16,185,129,.15);color:#6ee7b7;border:1px solid rgba(16,185,129,.35)}
.rv-chip.ext{background:rgba(59,130,246,.15);color:#93c5fd;border:1px solid rgba(59,130,246,.35)}
.rv-exp{display:inline-block;margin:2px;padding:2px 8px;border-radius:6px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);font-size:10px;color:rgba(255,255,255,.75)}
</style>

<div class="rv-head">
    <div style="width:54px;height:54px;border-radius:16px;background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.5),transparent 40%),linear-gradient(145deg,#93c5fd,#3b82f6);display:flex;align-items:center;justify-content:center;font-size:26px;position:relative;z-index:1">👥</div>
    <div style="flex:1;position:relative;z-index:1">
        <h2 style="font-size:22px;font-weight:900;margin:0">Manajemen Reviewer</h2>
        <p style="margin:2px 0 0;font-size:12px;opacity:.8">Database pakar internal & eksternal untuk review penelitian, pengabdian, HAKI, dan plagiarisme.</p>
    </div>
    <div style="display:flex;gap:8px;position:relative;z-index:1">
        <div class="rv-stat"><div class="v"><?= $stats['total'] ?></div><div class="l">Total</div></div>
        <div class="rv-stat"><div class="v"><?= $stats['internal'] ?></div><div class="l">Internal</div></div>
        <div class="rv-stat"><div class="v"><?= $stats['eksternal'] ?></div><div class="l">Eksternal</div></div>
        <div class="rv-stat"><div class="v"><?= number_format($stats['avg_rating'], 2) ?></div><div class="l">Rating</div></div>
        <div class="rv-stat"><div class="v"><?= $stats['pending'] ?></div><div class="l">Tugas Aktif</div></div>
    </div>
</div>

<?php if (!empty($flash)): ?><div class="flash flash-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div><?php endif; ?>

<div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:16px">
    <a class="btn-admin btn-primary" href="<?= e(url('admin/index.php?page=reviewers-tambah')) ?>">➕ Tambah Reviewer</a>
</div>

<form method="get" action="<?= e(url('admin/index.php')) ?>" class="filter-bar" style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px">
    <input type="hidden" name="page" value="reviewers">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="🔍 Cari nama / keahlian / institusi...">
    <select name="type"><option value="">Semua Tipe</option><option value="internal" <?= $filters['type'] === 'internal' ? 'selected' : '' ?>>Internal</option><option value="eksternal" <?= $filters['type'] === 'eksternal' ? 'selected' : '' ?>>Eksternal</option></select>
    <select name="active"><option value="">Semua Status</option><option value="1" <?= $filters['active'] === '1' ? 'selected' : '' ?>>Aktif</option><option value="0" <?= $filters['active'] === '0' ? 'selected' : '' ?>>Nonaktif</option></select>
    <button class="btn-admin" type="submit">Filter</button>
</form>

<table class="admin-table">
    <thead><tr><th>Reviewer</th><th>Keahlian</th><th>Tipe</th><th>Rating</th><th>Beban</th><th style="width:200px">Aksi</th></tr></thead>
    <tbody>
    <?php if (empty($items)): ?><tr><td colspan="6" style="text-align:center;padding:30px;opacity:.6">Belum ada reviewer.</td></tr><?php endif; ?>
    <?php foreach ($items as $it): $stars = round((float) $it['rating']); ?>
    <tr>
        <td>
            <b><?= e($it['name']) ?></b><?php if (!$it['is_active']): ?> <span style="opacity:.5;font-size:10px">(nonaktif)</span><?php endif; ?>
            <div style="font-size:11px;opacity:.65"><?= e($it['institution'] ?: '-') ?><?= !empty($it['nidn']) ? ' · NIDN ' . e($it['nidn']) : '' ?></div>
        </td>
        <td><?php foreach (array_slice(array_filter(array_map('trim', explode(',', (string) $it['expertise']))), 0, 3) as $ex): ?><span class="rv-exp"><?= e($ex) ?></span><?php endforeach; ?></td>
        <td><span class="rv-chip <?= $it['type'] === 'internal' ? 'int' : 'ext' ?>"><?= $it['type'] === 'internal' ? '🏠 Internal' : '🌐 Eksternal' ?></span></td>
        <td><span class="rv-star"><?= str_repeat('★', $stars) . str_repeat('☆', 5 - $stars) ?></span><div style="font-size:10px;opacity:.6"><?= number_format((float) $it['rating'], 2) ?></div></td>
        <td><?= (int) $it['total_completed'] ?>/<?= (int) $it['total_assignments'] ?><div style="font-size:10px;opacity:.6">selesai/tugas</div></td>
        <td>
            <div style="display:flex;gap:6px;flex-wrap:wrap">
                <a class="btn-admin" href="<?= e(url('admin/index.php?page=reviewers-edit&id=' . $it['id'])) ?>">✏️</a>
                <form method="post" action="<?= e(url('admin/index.php?page=reviewers-hapus')) ?>" onsubmit="return confirm('Hapus reviewer ini?');" style="display:inline"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $it['id'] ?>"><button class="btn-admin btn-danger" type="submit">🗑️</button></form>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- QUICK ASSIGN -->
<div class="form-section-3d" style="margin-top:22px">
    <h3 class="form-section-title"><span class="section-emoji">📋</span><span>Quick Assign Reviewer</span><span class="section-num">PENUGASAN CEPAT</span></h3>
    <form method="post" action="<?= e(url('admin/index.php?page=reviewers-assign')) ?>" style="display:grid;grid-template-columns:repeat(5,1fr);gap:10px">
        <?= csrf_field() ?>
        <div class="fg-3d"><label>Reviewer</label><select name="reviewer_id" required><?php foreach ($reviewerList as $rv): ?><option value="<?= (int) $rv['id'] ?>"><?= e($rv['name']) ?> (<?= number_format((float) $rv['rating'], 1) ?>★)</option><?php endforeach; ?></select></div>
        <div class="fg-3d"><label>Modul</label><select name="module_type" required><?php foreach ($modules as $k => $l): ?><option value="<?= e($k) ?>"><?= e($l) ?></option><?php endforeach; ?></select></div>
        <div class="fg-3d"><label>ID Data</label><input type="number" name="module_id" min="1" required placeholder="ID proposal/karya"></div>
        <div class="fg-3d"><label>Deadline</label><input type="date" name="deadline"></div>
        <div class="fg-3d" style="display:flex;align-items:end"><button class="btn-admin btn-primary" type="submit" style="width:100%">🎯 Tugaskan</button></div>
    </form>
</div>