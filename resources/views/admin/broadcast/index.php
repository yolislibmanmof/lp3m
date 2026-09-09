<?php
$mailCfg   = MailSender::config();
$totalSent = (int) array_sum(array_column($items, 'sent_count'));
$totalFail = (int) array_sum(array_column($items, 'fail_count'));
?>

<style>
    @keyframes bcFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    @keyframes bcShine { 0%,55%{left:-90%} 100%{left:165%} }

    .bc-head { position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:26px 30px; border-radius:22px; background:linear-gradient(135deg,#7c2d12 0%,#c2410c 55%,#ea580c 100%); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:bcFade .5s both; }
    .bc-head::after { content:''; position:absolute; top:-50%; right:-8%; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(254,215,170,.22),transparent 70%); pointer-events:none; }
    .bc-head-ico { width:56px; height:56px; border-radius:16px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:26px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.55),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), 0 6px 16px rgba(217,164,65,.4); position:relative; z-index:1; }
    .bc-head h2 { margin:0 0 4px; font-family:var(--font-display); font-size:21px; font-weight:900; position:relative; z-index:1; }
    .bc-head p { margin:0; font-size:12.5px; opacity:.9; position:relative; z-index:1; }
    .bc-head .drv { display:inline-flex; align-items:center; gap:6px; margin-top:8px; padding:3px 11px; border-radius:999px; font-size:9.5px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; background:rgba(255,255,255,.16); border:1px solid rgba(255,255,255,.32); position:relative; z-index:1; }
    .bc-stats { display:flex; gap:8px; flex-wrap:wrap; margin-left:auto; position:relative; z-index:1; }
    .bc-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); border-radius:14px; padding:10px 16px; text-align:center; min-width:86px; backdrop-filter:blur(6px); }
    .bc-stat b { display:block; font-family:var(--font-display); font-size:18px; font-weight:900; color:#fed7aa; line-height:1.1; }
    .bc-stat span { font-size:9px; letter-spacing:.12em; text-transform:uppercase; opacity:.85; display:block; margin-top:3px; }

    .bc-bar { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:18px; animation:bcFade .5s .05s both; }
    .bc-btn { position:relative; overflow:hidden; padding:11px 20px; border-radius:12px; font-size:13px; font-weight:800; text-decoration:none; display:inline-flex; align-items:center; gap:7px; transition:all .2s; border:none; cursor:pointer; }
    .bc-btn.gold { color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:0 5px 14px rgba(217,164,65,.35); }
    .bc-btn.gold::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:bcShine 3s ease-in-out infinite; }
    .bc-btn.ghost { color:var(--muted); background:var(--surface); border:1px solid var(--border); }
    .bc-btn:hover { transform:translateY(-2px); filter:brightness(1.05); }

    .bc-table { width:100%; border-collapse:collapse; background:var(--surface); border:1px solid var(--border); border-radius:18px; overflow:hidden; animation:bcFade .5s .08s both; }
    .bc-table th { padding:11px 14px; text-align:left; font-size:10px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); border-bottom:1px solid var(--border); }
    .bc-table td { padding:13px 14px; border-bottom:1px solid var(--border); font-size:12.5px; color:var(--text); vertical-align:middle; }
    .bc-table tr:last-child td { border-bottom:none; }
    .bc-table tbody tr { transition:background .2s; }
    .bc-table tbody tr:hover { background:rgba(234,88,12,.04); }

    .bc-tag { padding:3px 10px; border-radius:999px; font-size:9.5px; font-weight:900; letter-spacing:.05em; white-space:nowrap; }
    .bc-tag.draft { background:rgba(100,116,139,.15); color:var(--muted); }
    .bc-tag.sent { background:rgba(16,185,129,.14); color:#047857; }
    .bc-tag.failed { background:rgba(220,38,38,.14); color:#991b1b; }

    .bc-mini { padding:7px 12px; border-radius:9px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--muted); font-size:11.5px; font-weight:800; cursor:pointer; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:5px; white-space:nowrap; }
    .bc-mini:hover { border-color:rgba(234,88,12,.45); color:#ea580c; transform:translateY(-2px); }
    .bc-mini.send { color:#047857; border-color:rgba(16,185,129,.4); }
    .bc-mini.send:hover { border-color:rgba(16,185,129,.6); color:#059669; }
    .bc-mini.log:hover { border-color:rgba(59,130,246,.5); color:#3b82f6; }
    .bc-mini.danger:hover { border-color:rgba(220,38,38,.5); color:#fca5a5; }

    .bc-empty { text-align:center; padding:50px 20px; color:var(--muted); background:var(--surface); border:2px dashed var(--border); border-radius:20px; animation:bcFade .5s .08s both; }
</style>

<!-- HEADER -->
<div class="bc-head">
    <div class="bc-head-ico">📧</div>
    <div style="position:relative;z-index:1;">
        <h2>Newsletter & Broadcast</h2>
        <p>Kirim pengumuman massal ke subscriber publik atau pengguna berdasarkan role.</p>
        <span class="drv">⚙️ Driver: <?= e(strtoupper($mailCfg['driver'])) ?><?= $mailCfg['driver'] === 'smtp' ? ' · ' . e($mailCfg['host']) : ' · aktifkan SMTP di config/mail.php' ?></span>
    </div>
    <div class="bc-stats">
        <div class="bc-stat"><b><?= (int) $subStats['active'] ?></b><span>Subscriber</span></div>
        <div class="bc-stat"><b><?= count($items) ?></b><span>Broadcast</span></div>
        <div class="bc-stat"><b><?= $totalSent ?></b><span>Terkirim</span></div>
        <div class="bc-stat"><b><?= $totalFail ?></b><span>Gagal</span></div>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<!-- ACTION BAR -->
<div class="bc-bar">
    <a class="bc-btn gold" href="<?= e(url('admin/index.php?page=broadcast-tambah')) ?>">✍️ Tulis Broadcast</a>
    <a class="bc-btn ghost" href="<?= e(url('admin/index.php?page=broadcast-subscribers')) ?>">👥 Kelola Subscriber (<?= (int) $subStats['total'] ?>)</a>
    <a class="bc-btn ghost" href="<?= e(url('admin/index.php?page=broadcast-test')) ?>">🔌 Test Koneksi SMTP</a>
</div>

<?php if (empty($items)): ?>
<div class="bc-empty">
    <div style="font-size:48px; margin-bottom:10px;">📭</div>
    <h3 style="margin:0 0 6px; color:var(--ink);">Belum Ada Broadcast</h3>
    <p style="margin:0;">Klik "Tulis Broadcast" untuk membuat pengumuman massal pertama Anda.</p>
</div>
<?php else: ?>
<div style="overflow-x:auto;">
<table class="bc-table">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Segment</th>
            <th>Status</th>
            <th>Terkirim</th>
            <th>Tanggal</th>
            <th style="width:230px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $b): ?>
    <tr>
        <td style="font-weight:800; max-width:280px;"><?= e($b['title']) ?></td>
        <td style="color:var(--muted);"><?= e($segments[$b['segment']] ?? $b['segment']) ?></td>
        <td><span class="bc-tag <?= e($b['status']) ?>"><?= e(strtoupper($b['status'])) ?></span></td>
        <td>
            <span style="color:#047857; font-weight:900;"><?= (int) $b['sent_count'] ?></span>
            <?php if ((int) $b['fail_count'] > 0): ?>
                <span style="color:#991b1b; font-weight:900;"> / <?= (int) $b['fail_count'] ?> gagal</span>
            <?php endif; ?>
        </td>
        <td style="color:var(--muted); white-space:nowrap;"><?= e(date('d M Y · H:i', strtotime($b['created_at']))) ?></td>
        <td>
            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                <form method="post" action="<?= e(url('admin/index.php?page=broadcast-kirim')) ?>" style="display:inline;" onsubmit="return confirm('Kirim broadcast ini ke semua penerima segment?');">
                    <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $b['id'] ?>">
                    <button class="bc-mini send" type="submit"><?= $b['status'] === 'sent' ? '🔄 Kirim Ulang' : '📨 Kirim' ?></button>
                </form>
                <a class="bc-mini log" href="<?= e(url('admin/index.php?page=broadcast-log&id=' . $b['id'])) ?>">📜 Log</a>
                <form method="post" action="<?= e(url('admin/index.php?page=broadcast-hapus')) ?>" style="display:inline;" onsubmit="return confirm('Hapus broadcast ini?');">
                    <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $b['id'] ?>">
                    <button class="bc-mini danger" type="submit">🗑️</button>
                </form>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php endif; ?>