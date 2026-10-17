<style>
    .bl-table { width:100%; border-collapse:collapse; background:var(--surface); border:1px solid var(--border); border-radius:18px; overflow:hidden; }
    .bl-table th { padding:11px 14px; text-align:left; font-size:10px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); border-bottom:1px solid var(--border); }
    .bl-table td { padding:12px 14px; border-bottom:1px solid var(--border); font-size:12.5px; color:var(--text); }
    .bl-table tr:last-child td { border-bottom:none; }
    .bl-tag { padding:3px 10px; border-radius:999px; font-size:9.5px; font-weight:900; }
    .bl-tag.sent { background:rgba(16,185,129,.14); color:#047857; }
    .bl-tag.failed { background:rgba(220,38,38,.14); color:#991b1b; }
</style>

<a class="bc-btn ghost" style="padding:10px 18px; border-radius:12px; font-size:13px; font-weight:800; text-decoration:none; color:var(--muted); background:var(--surface); border:1px solid var(--border); display:inline-flex; margin-bottom:18px;" href="<?= e(url('admin/index.php?page=broadcast')) ?>">← Kembali ke Broadcast</a>

<div class="bc-head" style="position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:26px 30px; border-radius:22px; background:linear-gradient(135deg,#7c2d12 0%,#c2410c 55%,#ea580c 100%); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3);">
    <div style="width:56px;height:56px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:26px;background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.55),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b);">📜</div>
    <div style="flex:1; min-width:0;">
        <h2 style="margin:0;font-family:var(--font-display);font-size:20px;font-weight:900;"><?= e($item['title']) ?></h2>
        <p style="margin:4px 0 0;font-size:12.5px;opacity:.9;">
            Status: <?= e(strtoupper($item['status'])) ?> ·
            ✅ <?= (int) $item['sent_count'] ?> terkirim ·
            ❌ <?= (int) $item['fail_count'] ?> gagal ·
            Segment: <?= e($item['segment']) ?>
        </p>
    </div>
</div>

<?php if (empty($logs)): ?>
<div style="text-align:center; padding:50px 20px; color:var(--muted); background:var(--surface); border:2px dashed var(--border); border-radius:20px;">
    <div style="font-size:48px; margin-bottom:10px;">📭</div>Belum ada log pengiriman untuk broadcast ini.
</div>
<?php else: ?>
<div style="overflow-x:auto;">
<table class="bl-table">
    <thead><tr><th>#</th><th>Email Penerima</th><th>Status</th><th>Error</th><th>Waktu</th></tr></thead>
    <tbody>
    <?php foreach ($logs as $i => $l): ?>
    <tr>
        <td style="color:var(--muted);"><?= $i + 1 ?></td>
        <td style="font-weight:800;"><?= e($l['email']) ?></td>
        <td><span class="bl-tag <?= e($l['status']) ?>"><?= e(strtoupper($l['status'])) ?></span></td>
        <td style="color:var(--muted);"><?= e($l['error'] ?? '—') ?></td>
        <td style="color:var(--muted); white-space:nowrap;"><?= e(date('d M Y · H:i:s', strtotime($l['created_at']))) ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php endif; ?>