<?php
function usr_ago(?string $d): string {
    if (!$d) return 'Belum pernah';
    $diff = time() - strtotime($d);
    if ($diff < 60) return 'Baru saja';
    if ($diff < 3600) return floor($diff / 60) . ' menit lalu';
    if ($diff < 86400) return floor($diff / 3600) . ' jam lalu';
    if ($diff < 604800) return floor($diff / 86400) . ' hari lalu';
    return date('d M Y', strtotime($d));
}
$meId = (int) (Auth::user()['id'] ?? 0);
?>
<style>
    @keyframes usrFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    @keyframes usrShine { 0%,55%{left:-90%} 100%{left:165%} }

    .usr-head { position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:24px 28px; border-radius:22px; background:linear-gradient(135deg,#1e1b4b 0%,#3730a3 55%,#4f46e5 100%); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:usrFade .5s both; }
    .usr-head::after { content:''; position:absolute; top:-50%; right:-8%; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.22),transparent 70%); pointer-events:none; }
    .usr-head-ico { width:54px; height:54px; border-radius:16px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:25px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.55),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), 0 6px 16px rgba(217,164,65,.4); position:relative; z-index:1; }
    .usr-head h2 { margin:0; font-family:var(--font-display); font-size:21px; font-weight:900; position:relative; z-index:1; }
    .usr-head p { margin:3px 0 0; font-size:12.5px; opacity:.88; position:relative; z-index:1; }
    .usr-stats { display:flex; gap:8px; flex-wrap:wrap; margin-left:auto; position:relative; z-index:1; }
    .usr-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); border-radius:14px; padding:10px 16px; text-align:center; min-width:76px; backdrop-filter:blur(6px); }
    .usr-stat b { display:block; font-family:var(--font-display); font-size:19px; font-weight:900; color:#fde68a; line-height:1.1; }
    .usr-stat span { font-size:9px; letter-spacing:.12em; text-transform:uppercase; opacity:.85; display:block; margin-top:3px; }

    .usr-bar { display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:16px; }
    .usr-chips { display:flex; gap:8px; flex-wrap:wrap; flex:1; }
    .usr-chip { padding:8px 15px; border-radius:999px; border:1px solid var(--border); background:var(--surface); font-size:12px; font-weight:800; color:var(--text); text-decoration:none; transition:all .25s; display:inline-flex; align-items:center; gap:6px; }
    .usr-chip:hover { border-color:rgba(99,102,241,.45); color:#818cf8; transform:translateY(-2px); }
    .usr-chip.active { background:linear-gradient(145deg,#818cf8,#4f46e5); color:#fff; border-color:transparent; box-shadow:0 6px 14px rgba(99,102,241,.35); }
    .usr-chip b { font-size:10px; background:rgba(255,255,255,.18); padding:1px 7px; border-radius:999px; }
    .usr-search { position:relative; min-width:240px; }
    .usr-search input { width:100%; padding:10px 14px 10px 38px; border-radius:11px; border:1px solid var(--border); background:var(--surface); font-size:13px; font-weight:600; color:var(--text); }
    .usr-search::before { content:'🔍'; position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:13px; opacity:.5; }
    .usr-search input:focus { outline:none; border-color:#818cf8; box-shadow:0 0 0 4px rgba(99,102,241,.14); }

    .usr-table { width:100%; border-collapse:collapse; background:var(--surface); border:1px solid var(--border); border-radius:18px; overflow:hidden; }
    .usr-table th { padding:13px 16px; text-align:left; font-size:10.5px; font-weight:900; letter-spacing:.12em; text-transform:uppercase; color:var(--muted); background:rgba(255,255,255,.03); border-bottom:1px solid var(--border); }
    .usr-table td { padding:14px 16px; border-bottom:1px solid var(--border); font-size:13px; color:var(--text); vertical-align:middle; }
    .usr-table tr:last-child td { border-bottom:none; }
    .usr-table tr:hover td { background:rgba(255,255,255,.02); }

    .usr-av { width:40px; height:40px; border-radius:12px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:14px; font-weight:900; color:#03251f; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.5),transparent 45%),linear-gradient(145deg,rgb(var(--rgb)),rgba(var(--rgb),.7)); box-shadow:inset 0 2px 3px rgba(255,255,255,.5), 0 4px 10px rgba(var(--rgb),.35); }
    .usr-role { display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:999px; font-size:10.5px; font-weight:900; letter-spacing:.05em; color:var(--hex); background:rgba(var(--rgb),.14); border:1px solid rgba(var(--rgb),.4); }
    .usr-status { display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:999px; font-size:10.5px; font-weight:900; }
    .usr-status.on { color:#6ee7b7; background:rgba(16,185,129,.12); border:1px solid rgba(16,185,129,.4); }
    .usr-status.off { color:#fca5a5; background:rgba(220,38,38,.12); border:1px solid rgba(220,38,38,.4); }
    .usr-status i { width:7px; height:7px; border-radius:50%; background:currentColor; box-shadow:0 0 6px currentColor; }
    .usr-act { display:flex; gap:6px; flex-wrap:wrap; }
    .usr-btn { padding:7px 11px; border-radius:9px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--muted); font-size:12px; cursor:pointer; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:5px; }
    .usr-btn:hover { transform:translateY(-2px); border-color:rgba(217,164,65,.45); color:var(--gold-strong); }
    .usr-btn.danger:hover { border-color:rgba(220,38,38,.5); color:#fca5a5; }
    .usr-btn.me { opacity:.4; pointer-events:none; }

    .usr-empty { text-align:center; padding:60px 20px; color:var(--muted); background:var(--surface); border:2px dashed var(--border); border-radius:20px; }
</style>

<div class="usr-head">
    <div class="usr-head-ico">👤</div>
    <div style="position:relative;z-index:1;">
        <h2>Manajemen Pengguna</h2>
        <p>Kelola akun admin, dosen, reviewer, dan pimpinan beserta hak aksesnya.</p>
    </div>
    <div class="usr-stats">
        <div class="usr-stat"><b><?= (int) $stats['total'] ?></b><span>Total</span></div>
        <div class="usr-stat"><b><?= (int) $stats['active'] ?></b><span>Aktif</span></div>
        <div class="usr-stat"><b><?= (int) $stats['inactive'] ?></b><span>Nonaktif</span></div>
        <div class="usr-stat"><b><?= (int) $stats['new_month'] ?></b><span>Bulan Ini</span></div>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<div class="usr-bar">
    <div class="usr-chips">
        <a class="usr-chip <?= $filters['role'] === '' ? 'active' : '' ?>" href="<?= e(url('admin/index.php?page=users')) ?>">✨ Semua <b><?= (int) $stats['total'] ?></b></a>
        <?php foreach ($roles as $rk => $rv): ?>
        <a class="usr-chip <?= $filters['role'] === $rk ? 'active' : '' ?>" href="<?= e(url('admin/index.php?page=users&role=' . urlencode($rk))) ?>">
            <?= e($rv['label']) ?> <b><?= User::countRole($rk) ?></b>
        </a>
        <?php endforeach; ?>
    </div>
    <form method="get" action="<?= e(url('admin/index.php')) ?>" class="usr-search" style="position:relative;">
        <input type="hidden" name="page" value="users">
        <input type="text" name="q" value="<?= e($q) ?>" placeholder="Cari nama / email...">
    </form>
    <a class="usr-chip active" style="background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); color:#03251f; border-color:transparent;" href="<?= e(url('admin/index.php?page=users-tambah')) ?>">➕ Tambah Pengguna</a>
</div>

<?php if (empty($items)): ?>
    <div class="usr-empty"><div style="font-size:48px; margin-bottom:10px;">👥</div>Tidak ada pengguna yang cocok.</div>
<?php else: ?>
<table class="usr-table">
    <thead>
        <tr><th>Pengguna</th><th>Role</th><th>Status</th><th>Login Terakhir</th><th style="width:190px;">Aksi</th></tr>
    </thead>
    <tbody>
    <?php foreach ($items as $u):
        $ri = User::roleInfo($u['role']);
        $isMe = (int) $u['id'] === $meId;
        $parts = array_values(array_filter(explode(' ', trim((string) $u['name']))));
        $init = strtoupper(substr($parts[0] ?? 'A', 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
    ?>
    <tr>
        <td>
            <div style="display:flex; align-items:center; gap:12px;">
                <span class="usr-av" style="--rgb:<?= $ri['rgb'] ?>; --hex:<?= $ri['hex'] ?>;"><?= e($init) ?></span>
                <div>
                    <b style="color:var(--text);"><?= e($u['name']) ?><?= $isMe ? ' <span style="font-size:10px; color:var(--gold-strong);">(Anda)</span>' : '' ?></b>
                    <div style="font-size:11px; opacity:.65; margin-top:2px;"><?= e($u['email']) ?><?= !empty($u['phone']) ? ' · ' . e($u['phone']) : '' ?></div>
                </div>
            </div>
        </td>
        <td><span class="usr-role" style="--rgb:<?= $ri['rgb'] ?>; --hex:<?= $ri['hex'] ?>;"><?= e($ri['label']) ?></span></td>
        <td><span class="usr-status <?= (int) $u['is_active'] === 1 ? 'on' : 'off' ?>"><i></i><?= (int) $u['is_active'] === 1 ? 'Aktif' : 'Nonaktif' ?></span></td>
        <td style="font-size:12px; opacity:.8;"><?= e(usr_ago($u['last_login_at'] ?? null)) ?></td>
        <td>
            <div class="usr-act">
                <a class="usr-btn" href="<?= e(url('admin/index.php?page=users-edit&id=' . $u['id'])) ?>" title="Edit">✏️</a>
                <form method="post" action="<?= e(url('admin/index.php?page=users-reset')) ?>" style="display:inline;" onsubmit="return confirm('Reset password <?= e($u['name']) ?>? Kosongkan kolom password untuk generate otomatis.');">
                    <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $u['id'] ?>"><input type="hidden" name="password" value="">
                    <button class="usr-btn" type="submit" title="Reset password">🔑</button>
                </form>
                <form method="post" action="<?= e(url('admin/index.php?page=users-toggle')) ?>" style="display:inline;" onsubmit="return confirm('Ubah status aktif pengguna ini?');">
                    <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
                    <button class="usr-btn <?= $isMe ? 'me' : '' ?>" type="submit" title="Aktif/Nonaktif"><?= (int) $u['is_active'] === 1 ? '🚫' : '✅' ?></button>
                </form>
                <form method="post" action="<?= e(url('admin/index.php?page=users-hapus')) ?>" style="display:inline;" onsubmit="return confirm('Hapus pengguna <?= e($u['name']) ?>? Tindakan permanen!');">
                    <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
                    <button class="usr-btn danger <?= $isMe ? 'me' : '' ?>" type="submit" title="Hapus">🗑️</button>
                </form>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if ($totalPages > 1): ?>
<div style="margin-top:18px; display:flex; justify-content:center; gap:6px; flex-wrap:wrap;">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="<?= e(url('admin/index.php?page=users&hal=' . $i . '&q=' . urlencode($q) . '&role=' . urlencode($filters['role']))) ?>" class="pag-3d <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>
<?php endif; ?>