<?php
function al_ago(?string $d): string {
    if (!$d) return '—';
    $diff = time() - strtotime($d);
    if ($diff < 60) return 'Baru saja';
    if ($diff < 3600) return floor($diff / 60) . ' menit lalu';
    if ($diff < 86400) return floor($diff / 3600) . ' jam lalu';
    if ($diff < 604800) return floor($diff / 86400) . ' hari lalu';
    return date('d M Y · H:i', strtotime($d));
}
?>
<style>
    @keyframes alFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }

    .al-head { position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:24px 28px; border-radius:22px; background:linear-gradient(135deg,#1e3a8a 0%,#3b82f6 55%,#60a5fa 100%); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:alFade .5s both; }
    .al-head::after { content:''; position:absolute; top:-50%; right:-8%; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.22),transparent 70%); pointer-events:none; }
    .al-head-ico { width:54px; height:54px; border-radius:16px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:25px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.55),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), 0 6px 16px rgba(217,164,65,.4); position:relative; z-index:1; }
    .al-head h2 { margin:0; font-family:var(--font-display); font-size:21px; font-weight:900; position:relative; z-index:1; }
    .al-head p { margin:3px 0 0; font-size:12.5px; opacity:.88; position:relative; z-index:1; }
    .al-stats { display:flex; gap:8px; flex-wrap:wrap; margin-left:auto; position:relative; z-index:1; }
    .al-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); border-radius:14px; padding:10px 16px; text-align:center; min-width:86px; backdrop-filter:blur(6px); }
    .al-stat b { display:block; font-family:var(--font-display); font-size:19px; font-weight:900; color:#fde68a; line-height:1.1; }
    .al-stat b.warn { color:#fca5a5; }
    .al-stat span { font-size:9px; letter-spacing:.12em; text-transform:uppercase; opacity:.85; display:block; margin-top:3px; }

    .al-bar { display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:16px; padding:14px 18px; background:var(--surface); border:1px solid var(--border); border-radius:16px; animation:alFade .5s .06s both; }
    .al-bar select, .al-bar input { padding:9px 14px; border-radius:10px; border:1px solid var(--border); background:var(--surface); font-size:12.5px; font-weight:700; color:var(--text); }
    .al-bar select { cursor:pointer; min-width:150px; }
    .al-bar input[type="text"] { min-width:220px; }
    .al-bar select:focus, .al-bar input:focus { outline:none; border-color:#3b82f6; box-shadow:0 0 0 4px rgba(59,130,246,.14); }
    .al-bar .spacer { flex:1; }
    .al-export { padding:9px 16px; border-radius:10px; font-size:12.5px; font-weight:800; text-decoration:none; color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:0 4px 12px rgba(217,164,65,.3); transition:all .2s; }
    .al-export:hover { transform:translateY(-2px); filter:brightness(1.05); }

    .al-chips { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:16px; animation:alFade .5s .1s both; }
    .al-chip { padding:7px 14px; border-radius:999px; border:1px solid var(--border); background:var(--surface); font-size:11.5px; font-weight:800; color:var(--text); text-decoration:none; transition:all .25s; display:inline-flex; align-items:center; gap:6px; }
    .al-chip:hover { border-color:rgba(59,130,246,.45); color:#3b82f6; transform:translateY(-2px); }
    .al-chip.active { background:linear-gradient(145deg,#3b82f6,#1e3a8a); color:#fff; border-color:transparent; box-shadow:0 6px 14px rgba(59,130,246,.35); }
    .al-chip b { font-size:9.5px; background:rgba(255,255,255,.18); padding:1px 7px; border-radius:999px; }

    .al-tl { position:relative; padding-left:30px; animation:alFade .5s .14s both; }
    .al-tl::before { content:''; position:absolute; left:12px; top:6px; bottom:6px; width:2px; background:linear-gradient(180deg,rgba(59,130,246,.5),rgba(59,130,246,.1)); border-radius:2px; }
    .al-item { position:relative; margin-bottom:12px; padding:14px 18px; border-radius:14px; background:var(--surface); border:1px solid var(--border); transition:all .3s; display:flex; gap:14px; align-items:flex-start; }
    .al-item:hover { border-color:rgba(59,130,246,.35); transform:translateX(3px); box-shadow:0 8px 18px rgba(3,37,31,.07); }
    .al-item::before { content:''; position:absolute; left:-26px; top:18px; width:14px; height:14px; border-radius:50%; background:rgb(var(--rgb,59,130,246)); box-shadow:0 0 0 3px var(--surface), 0 0 10px rgba(var(--rgb,59,130,246),.5); }
    .al-ico { width:40px; height:40px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; background:rgba(var(--rgb,59,130,246),.14); color:var(--hex,#3b82f6); }
    .al-body { flex:1; min-width:0; }
    .al-title { display:flex; align-items:center; gap:8px; flex-wrap:wrap; font-size:13px; font-weight:800; color:var(--text); margin-bottom:4px; }
    .al-user { color:var(--ink); }
    .al-action { padding:2px 9px; border-radius:999px; font-size:9.5px; font-weight:900; letter-spacing:.06em; background:rgba(var(--rgb,59,130,246),.14); color:var(--hex,#3b82f6); border:1px solid rgba(var(--rgb,59,130,246),.35); }
    .al-entity { font-size:12px; color:var(--muted); margin-bottom:4px; }
    .al-entity b { color:var(--ink); font-weight:700; }
    .al-meta { display:flex; gap:14px; flex-wrap:wrap; font-size:11px; color:var(--muted); }
    .al-meta span { display:inline-flex; align-items:center; gap:4px; }
    .al-act { display:flex; gap:6px; flex-shrink:0; align-items:center; }
    .al-btn { padding:7px 10px; border-radius:9px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--muted); font-size:12px; cursor:pointer; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:4px; }
    .al-btn:hover { border-color:rgba(59,130,246,.45); color:#3b82f6; transform:translateY(-2px); }
    .al-btn.danger:hover { border-color:rgba(220,38,38,.5); color:#fca5a5; }

    .al-empty { text-align:center; padding:60px 20px; color:var(--muted); background:var(--surface); border:2px dashed var(--border); border-radius:20px; }

    .al-purge { display:flex; align-items:center; gap:10px; padding:12px 16px; background:rgba(220,38,38,.06); border:1px dashed rgba(220,38,38,.3); border-radius:12px; margin-top:18px; font-size:12px; color:#991b1b; flex-wrap:wrap; }
</style>

<div class="al-head">
    <div class="al-head-ico">📜</div>
    <div style="position:relative;z-index:1;">
        <h2>Audit Log · Activity Trail</h2>
        <p>Jejak lengkap aktivitas pengguna untuk akuntabilitas SPMI dan audit AMI.</p>
    </div>
    <div class="al-stats">
        <div class="al-stat"><b><?= number_format($stats['total']) ?></b><span>Total Log</span></div>
        <div class="al-stat"><b><?= number_format($stats['today']) ?></b><span>Hari Ini</span></div>
        <div class="al-stat"><b><?= number_format($stats['week']) ?></b><span>7 Hari</span></div>
        <div class="al-stat"><b><?= number_format($stats['unique']) ?></b><span>Pengguna</span></div>
        <?php if ($stats['login_fail'] > 0): ?>
        <div class="al-stat"><b class="warn"><?= (int) $stats['login_fail'] ?></b><span>Login Gagal</span></div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<!-- FILTER BAR -->
<form method="get" action="<?= e(url('admin/index.php')) ?>" class="al-bar">
    <input type="hidden" name="page" value="audit">
    <select name="period">
        <option value="" <?= $filters['period'] === '' ? 'selected' : '' ?>>📅 Semua Waktu</option>
        <option value="today" <?= $filters['period'] === 'today' ? 'selected' : '' ?>>📅 Hari Ini</option>
        <option value="week" <?= $filters['period'] === 'week' ? 'selected' : '' ?>>📅 7 Hari Terakhir</option>
        <option value="month" <?= $filters['period'] === 'month' ? 'selected' : '' ?>>📅 30 Hari Terakhir</option>
    </select>
    <select name="user_id">
        <option value="">👤 Semua Pengguna</option>
        <?php foreach ($users as $u): ?>
        <option value="<?= (int) $u['user_id'] ?>" <?= (string) $filters['user_id'] === (string) $u['user_id'] ? 'selected' : '' ?>><?= e($u['user_name']) ?></option>
        <?php endforeach; ?>
    </select>
    <select name="entity">
        <option value="">🗂️ Semua Entitas</option>
        <?php foreach ($entityTypes as $et): ?>
        <option value="<?= e($et) ?>" <?= $filters['entity'] === $et ? 'selected' : '' ?>><?= e($et) ?></option>
        <?php endforeach; ?>
    </select>
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="🔍 Cari pengguna, URL, IP...">
    <button type="submit" class="al-export" style="background:linear-gradient(145deg,#3b82f6,#1e3a8a); color:#fff;">🔍 Filter</button>
    <span class="spacer"></span>
    <a class="al-export" href="<?= e(url('admin/index.php?page=audit-export&' . http_build_query($filters + ['q' => $q]))) ?>">📥 Export CSV</a>
</form>

<!-- ACTION CHIPS -->
<div class="al-chips">
    <a class="al-chip <?= $filters['action'] === '' ? 'active' : '' ?>" href="<?= e(url('admin/index.php?page=audit&period=' . urlencode($filters['period']) . '&user_id=' . urlencode($filters['user_id']) . '&entity=' . urlencode($filters['entity']) . '&q=' . urlencode($q))) ?>">✨ Semua <b><?= number_format($stats['total']) ?></b></a>
    <?php foreach ($actions as $ak => $av): ?>
    <a class="al-chip <?= $filters['action'] === $ak ? 'active' : '' ?>" href="<?= e(url('admin/index.php?page=audit&action=' . urlencode($ak) . '&period=' . urlencode($filters['period']) . '&user_id=' . urlencode($filters['user_id']) . '&entity=' . urlencode($filters['entity']) . '&q=' . urlencode($q))) ?>" style="--rgb:<?= $av['rgb'] ?>; --hex:<?= $av['hex'] ?>;">
        <?= $av['ico'] ?> <?= e($av['label']) ?>
    </a>
    <?php endforeach; ?>
</div>

<?php if (empty($items)): ?>
    <div class="al-empty"><div style="font-size:48px; margin-bottom:10px;">📜</div>Tidak ada log yang cocok dengan filter.</div>
<?php else: ?>
<div class="al-tl">
    <?php foreach ($items as $row):
        $ai = AuditLog::actionInfo($row['action']);
    ?>
    <div class="al-item" style="--rgb:<?= $ai['rgb'] ?>; --hex:<?= $ai['hex'] ?>;">
        <div class="al-ico"><?= $ai['ico'] ?></div>
        <div class="al-body">
            <div class="al-title">
                <span class="al-user"><?= e($row['user_name'] ?? 'Sistem') ?></span>
                <span class="al-action"><?= e($ai['label']) ?></span>
                <span style="font-size:11px; color:var(--muted); font-weight:700;"><?= e(ucfirst($row['user_role'] ?? '')) ?></span>
            </div>
            <?php if (!empty($row['entity_type'])): ?>
            <div class="al-entity">🗂️ <b><?= e($row['entity_type']) ?></b><?= !empty($row['entity_label']) ? ' · <i>' . e($row['entity_label']) . '</i>' : '' ?><?= !empty($row['entity_id']) ? ' (#' . (int) $row['entity_id'] . ')' : '' ?></div>
            <?php endif; ?>
            <div class="al-meta">
                <span>🕐 <?= e(al_ago($row['created_at'])) ?></span>
                <span>🌐 <?= e($row['ip_address'] ?? '—') ?></span>
                <?php if (!empty($row['url'])): ?><span>🔗 <?= e(substr($row['url'], 0, 50)) ?><?= strlen($row['url'] ?? '') > 50 ? '…' : '' ?></span><?php endif; ?>
            </div>
        </div>
        <div class="al-act">
            <a class="al-btn" href="<?= e(url('admin/index.php?page=audit-detail&id=' . $row['id'])) ?>" title="Detail">🔍</a>
            <form method="post" action="<?= e(url('admin/index.php?page=audit-hapus')) ?>" style="display:inline;" onsubmit="return confirm('Hapus log ini?');">
                <?= csrf_field() ?><input type="hidden" name="purge_action" value="one"><input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                <button class="al-btn danger" type="submit" title="Hapus">🗑️</button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if ($totalPages > 1): ?>
<div style="margin-top:18px; display:flex; justify-content:center; gap:6px; flex-wrap:wrap;">
    <?php
    $qp = http_build_query(array_filter([
        'period' => $filters['period'], 'action' => $filters['action'],
        'user_id' => $filters['user_id'], 'entity' => $filters['entity'], 'q' => $q,
    ]));
    for ($i = 1; $i <= $totalPages; $i++):
    ?>
    <a href="<?= e(url('admin/index.php?page=audit&hal=' . $i . '&' . $qp)) ?>" class="pag-3d <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<form method="post" action="<?= e(url('admin/index.php?page=audit-hapus')) ?>" class="al-purge" onsubmit="return confirm('Hapus semua log yang lebih lama dari 90 hari? Aksi tidak dapat dibatalkan.');">
    <?= csrf_field() ?><input type="hidden" name="purge_action" value="old">
    <span>🧹 <b>Pembersihan Otomatis:</b> hapus log yang lebih lama dari 90 hari untuk menjaga ukuran tabel.</span>
    <button type="submit" class="al-btn danger" style="margin-left:auto;">Hapus Log Lama</button>
</form>
<?php endif; ?>