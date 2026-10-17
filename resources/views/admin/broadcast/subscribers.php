<style>
    .bs-table { width:100%; border-collapse:collapse; background:var(--surface); border:1px solid var(--border); border-radius:18px; overflow:hidden; }
    .bs-table th { padding:11px 14px; text-align:left; font-size:10px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); border-bottom:1px solid var(--border); }
    .bs-table td { padding:12px 14px; border-bottom:1px solid var(--border); font-size:12.5px; color:var(--text); }
    .bs-table tr:last-child td { border-bottom:none; }
    .bs-tag { padding:3px 10px; border-radius:999px; font-size:9.5px; font-weight:900; }
    .bs-tag.active { background:rgba(16,185,129,.14); color:#047857; }
    .bs-tag.unsubscribed { background:rgba(100,116,139,.15); color:var(--muted); }
</style>

<div class="bc-head" style="position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:26px 30px; border-radius:22px; background:linear-gradient(135deg,#7c2d12 0%,#c2410c 55%,#ea580c 100%); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3);">
    <div style="width:56px;height:56px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:26px;background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.55),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b);">👥</div>
    <div><h2 style="margin:0;font-family:var(--font-display);font-size:21px;font-weight:900;">Manajemen Subscriber</h2>
    <p style="margin:3px 0 0;font-size:12.5px;opacity:.9;"><?= (int) $stats['active'] ?> aktif · <?= (int) $stats['unsub'] ?> berhenti · total <?= (int) $stats['total'] ?></p></div>
    <div style="margin-left:auto; display:flex; gap:8px;">
        <a class="bc-btn gold" style="padding:11px 20px; border-radius:12px; font-size:13px; font-weight:800; text-decoration:none; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441);" href="<?= e(url('admin/index.php?page=broadcast-subscriber-export')) ?>">📥 Export CSV</a>
        <a class="bc-btn ghost" style="padding:11px 20px; border-radius:12px; font-size:13px; font-weight:800; text-decoration:none; color:var(--muted); background:var(--surface); border:1px solid var(--border);" href="<?= e(url('admin/index.php?page=broadcast')) ?>">← Kembali</a>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<form method="get" action="<?= e(url('admin/index.php')) ?>" style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:16px; padding:14px 16px; background:var(--surface); border:1px solid var(--border); border-radius:14px;">
    <input type="hidden" name="page" value="broadcast-subscribers">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="🔍 Cari email / nama..." style="flex:1; min-width:200px; padding:10px 14px; border-radius:10px; border:1px solid var(--border); background:var(--surface); font-size:13px; color:var(--text);">
    <select name="status" style="padding:10px 14px; border-radius:10px; border:1px solid var(--border); background:var(--surface); font-size:13px; color:var(--text);">
        <option value="">Semua Status</option>
        <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Aktif</option>
        <option value="unsubscribed" <?= $status === 'unsubscribed' ? 'selected' : '' ?>>Berhenti</option>
    </select>
    <button type="submit" style="padding:10px 18px; border:none; border-radius:10px; font-weight:800; cursor:pointer; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441);">Filter</button>
</form>

<?php if (empty($items)): ?>
<div class="bc-empty" style="text-align:center; padding:50px 20px; color:var(--muted); background:var(--surface); border:2px dashed var(--border); border-radius:20px;">
    <div style="font-size:48px; margin-bottom:10px;">📭</div>Belum ada subscriber.
</div>
<?php else: ?>
<div style="overflow-x:auto;">
<table class="bs-table">
    <thead><tr><th>Email</th><th>Nama</th><th>Status</th><th>Sumber</th><th>Terdaftar</th><th style="width:70px;">Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($items as $s): ?>
    <tr>
        <td style="font-weight:800;"><?= e($s['email']) ?></td>
        <td style="color:var(--muted);"><?= e($s['name'] ?: '—') ?></td>
        <td><span class="bs-tag <?= e($s['status']) ?>"><?= e(strtoupper($s['status'])) ?></span></td>
        <td style="color:var(--muted);"><?= e($s['source']) ?></td>
        <td style="color:var(--muted); white-space:nowrap;"><?= e(date('d M Y', strtotime($s['created_at']))) ?></td>
        <td>
            <form method="post" action="<?= e(url('admin/index.php?page=broadcast-subscriber-hapus')) ?>" onsubmit="return confirm('Hapus subscriber ini?');">
                <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $s['id'] ?>">
                <button type="submit" style="padding:6px 10px; border-radius:8px; border:1px solid rgba(220,38,38,.35); background:rgba(220,38,38,.08); color:#fca5a5; cursor:pointer;">🗑️</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php endif; ?>