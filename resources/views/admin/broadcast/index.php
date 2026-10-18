<?php
$mailCfg   = MailSender::config();
$totalSent = (int) array_sum(array_column($items, 'sent_count'));
$totalFail = (int) array_sum(array_column($items, 'fail_count'));

// SVG Icon Helper untuk Broadcast
function renderBroadcastIcon($name, $size = 16, $color = 'currentColor') {
    $icons = [
        'mail' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>',
        'users' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'check-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>',
        'alert-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>',
        'edit' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
        'server' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>',
        'send' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>',
        'refresh' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>',
        'file-text' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>',
        'trash' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',
        'info' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>',
    ];
    return $icons[$name] ?? $icons['mail'];
}
?>

<style>
    @keyframes bcFade { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
    @keyframes bcShine { 0%, 55% { left: -90%; } 100% { left: 165%; } }
    @keyframes iconRotate { 0%, 100% { transform: rotate(0deg) scale(1); } 25% { transform: rotate(-5deg) scale(1.05); } 75% { transform: rotate(5deg) scale(1.05); } }

    .bc-svg { display: inline-flex; align-items: center; justify-content: center; vertical-align: middle; }
    .bc-svg svg { display: block; transition: all 0.3s ease; }

    .bc-head {
        position: relative; overflow: hidden; display: flex; align-items: center; gap: 18px;
        margin-bottom: 24px; padding: 28px 32px; border-radius: 24px;
        background: linear-gradient(135deg, #7c2d12 0%, #c2410c 55%, #ea580c 100%);
        color: #fff; box-shadow: 0 20px 50px rgba(0,0,0,.3);
        animation: bcFade .5s cubic-bezier(.16,1,.3,1) both;
    }
    .bc-head::after {
        content: ''; position: absolute; top: -50%; right: -8%;
        width: 340px; height: 340px; border-radius: 50%;
        background: radial-gradient(circle, rgba(254,215,170,.22), transparent 70%);
        pointer-events: none;
    }
    .bc-head-ico {
        width: 60px; height: 60px; border-radius: 17px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.55), transparent 45%),
                    linear-gradient(145deg, #fde68a, #f2c063 55%, #a9761b);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.6), 0 8px 20px rgba(217,164,65,.4);
        position: relative; z-index: 1;
        transition: transform 0.3s ease;
    }
    .bc-head-ico:hover { transform: scale(1.05) rotate(-5deg); }
    .bc-head-ico svg { width: 28px; height: 28px; stroke: #03251f; stroke-width: 2.2; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2)); }
    
    .bc-head h2 {
        margin: 0 0 5px; font-family: var(--font-display); font-size: 23px; font-weight: 900;
        position: relative; z-index: 1; letter-spacing: -0.02em;
    }
    .bc-head p { margin: 0; font-size: 13px; opacity: .9; position: relative; z-index: 1; }
    .bc-head .drv {
        display: inline-flex; align-items: center; gap: 7px; margin-top: 10px;
        padding: 5px 13px; border-radius: 999px; font-size: 10.5px; font-weight: 900;
        letter-spacing: .08em; text-transform: uppercase;
        background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.32);
        position: relative; z-index: 1;
    }
    .bc-head .drv svg { width: 12px; height: 12px; stroke: currentColor; stroke-width: 2.5; }

    .bc-stats { display: flex; gap: 10px; flex-wrap: wrap; margin-left: auto; position: relative; z-index: 1; }
    .bc-stat {
        background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.22);
        border-radius: 15px; padding: 12px 18px; text-align: center; min-width: 90px;
        backdrop-filter: blur(8px); transition: all 0.3s ease;
    }
    .bc-stat:hover { background: rgba(255,255,255,.18); transform: translateY(-2px); }
    .bc-stat b {
        display: block; font-family: var(--font-display); font-size: 20px; font-weight: 900;
        color: #fed7aa; line-height: 1.1; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }
    .bc-stat span {
        font-size: 9.5px; letter-spacing: .12em; text-transform: uppercase;
        opacity: .85; display: block; margin-top: 4px;
    }

    .bc-bar { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 20px; animation: bcFade .5s .05s both; }
    .bc-btn {
        position: relative; overflow: hidden; padding: 12px 22px; border-radius: 13px;
        font-size: 13.5px; font-weight: 800; text-decoration: none;
        display: inline-flex; align-items: center; gap: 8px;
        transition: all .25s cubic-bezier(.16,1,.3,1); border: none; cursor: pointer;
    }
    .bc-btn svg { width: 16px; height: 16px; stroke: currentColor; stroke-width: 2.2; transition: all 0.3s ease; }
    .bc-btn.gold {
        color: #03251f; background: linear-gradient(145deg, #fde68a, #d9a441);
        box-shadow: 0 6px 16px rgba(217,164,65,.35);
    }
    .bc-btn.gold::after {
        content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent);
        animation: bcShine 3s ease-in-out infinite;
    }
    .bc-btn.ghost {
        color: var(--muted); background: var(--surface); border: 1px solid var(--border);
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.04);
    }
    .bc-btn:hover { transform: translateY(-2px); filter: brightness(1.05); }
    .bc-btn:hover svg { animation: iconRotate 0.5s ease; }

    .bc-table {
        width: 100%; border-collapse: separate; border-spacing: 0;
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 20px; overflow: hidden; animation: bcFade .5s .08s both;
        box-shadow: 0 6px 20px rgba(0,0,0,.05);
    }
    .bc-table th {
        padding: 14px 18px; text-align: left; font-size: 11px; font-weight: 900;
        letter-spacing: .1em; text-transform: uppercase; color: #fde68a;
        background: linear-gradient(145deg, #7c2d12, #c2410c);
        border-bottom: 1px solid rgba(254,215,170,0.2);
    }
    .bc-table td {
        padding: 15px 18px; border-bottom: 1px solid var(--border);
        font-size: 13px; color: var(--text); vertical-align: middle;
    }
    .bc-table tr:last-child td { border-bottom: none; }
    .bc-table tbody tr { transition: background .2s; }
    .bc-table tbody tr:hover { background: rgba(234,88,12,.04); }

    .bc-tag {
        display: inline-flex; align-items: center; gap: 5px; padding: 4px 11px;
        border-radius: 999px; font-size: 10.5px; font-weight: 900; letter-spacing: .05em; white-space: nowrap;
    }
    .bc-tag svg { width: 10px; height: 10px; stroke: currentColor; stroke-width: 2.5; }
    .bc-tag.draft { background: rgba(100,116,139,.15); color: var(--muted); }
    .bc-tag.sent { background: rgba(16,185,129,.14); color: #047857; }
    .bc-tag.failed { background: rgba(220,38,38,.14); color: #991b1b; }

    .bc-mini {
        padding: 8px 12px; border-radius: 10px; border: 1px solid var(--border);
        background: rgba(255,255,255,.04); color: var(--muted);
        font-size: 12px; font-weight: 800; cursor: pointer; text-decoration: none;
        transition: all .2s; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;
    }
    .bc-mini svg { width: 13px; height: 13px; stroke: currentColor; stroke-width: 2.2; transition: all 0.3s ease; }
    .bc-mini:hover { transform: translateY(-2px); }
    .bc-mini:hover svg { animation: iconRotate 0.5s ease; }
    .bc-mini.send { color: #047857; border-color: rgba(16,185,129,.4); }
    .bc-mini.send:hover { border-color: rgba(16,185,129,.6); color: #059669; background: rgba(16,185,129,0.08); }
    .bc-mini.log:hover { border-color: rgba(59,130,246,.5); color: #3b82f6; background: rgba(59,130,246,0.08); }
    .bc-mini.danger:hover { border-color: rgba(220,38,38,.5); color: #fca5a5; background: rgba(220,38,38,0.08); }

    .bc-empty {
        text-align: center; padding: 60px 24px; color: var(--muted);
        background: var(--surface); border: 2px dashed var(--border);
        border-radius: 22px; animation: bcFade .5s .08s both;
    }
    .bc-empty-ico {
        width: 80px; height: 80px; margin: 0 auto 16px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; background: linear-gradient(145deg, rgba(234,88,12,0.15), rgba(234,88,12,0.05));
        border: 2px dashed rgba(234,88,12,0.3);
    }
    .bc-empty-ico svg { width: 40px; height: 40px; stroke: var(--muted); stroke-width: 1.5; opacity: 0.6; }

    /* Flash messages */
    .flash-3d {
        position: relative; padding: 15px 20px; margin-bottom: 22px; border-radius: 14px;
        font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 10px;
        overflow: hidden; box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.05), 0 6px 16px rgba(0,0,0,.1);
        animation: bcFade .5s cubic-bezier(.16,1,.3,1) both;
    }
    .flash-3d svg { width: 20px; height: 20px; stroke-width: 2.2; flex-shrink: 0; }
    .flash-3d::after {
        content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent);
        animation: bcShine 3s ease-in-out infinite; pointer-events: none;
    }
    .flash-success-3d { background: linear-gradient(145deg, #d1fae5, #a7f3d0); border: 1px solid rgba(16,185,129,.35); color: #065f46; }
    .flash-success-3d svg { stroke: #065f46; }
    .flash-error-3d { background: linear-gradient(145deg, #fee2e2, #fecaca); border: 1px solid rgba(220,38,38,.35); color: #991b1b; }
    .flash-error-3d svg { stroke: #991b1b; }
</style>

<!-- HEADER -->
<div class="bc-head">
    <div class="bc-head-ico">
        <?= renderBroadcastIcon('mail', 28, '#03251f') ?>
    </div>
    <div style="position:relative; z-index:1; flex:1; min-width:0;">
        <h2>Newsletter & Broadcast</h2>
        <p>Kirim pengumuman massal ke subscriber publik atau pengguna berdasarkan role.</p>
        <span class="drv">
            <?= renderBroadcastIcon('server', 12, 'currentColor') ?>
            <span>Driver: <?= e(strtoupper($mailCfg['driver'])) ?><?= $mailCfg['driver'] === 'smtp' ? ' · ' . e($mailCfg['host']) : ' · aktifkan SMTP di config/mail.php' ?></span>
        </span>
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
    <?= $flash['type'] === 'error' ? renderBroadcastIcon('alert-circle', 20, 'currentColor') : renderBroadcastIcon('check-circle', 20, 'currentColor') ?>
    <span><?= e($flash['message']) ?></span>
</div>
<?php endif; ?>

<!-- ACTION BAR -->
<div class="bc-bar">
    <a class="bc-btn gold" href="<?= e(url('admin/index.php?page=broadcast-tambah')) ?>">
        <?= renderBroadcastIcon('edit', 16, 'currentColor') ?>
        <span>Tulis Broadcast</span>
    </a>
    <a class="bc-btn ghost" href="<?= e(url('admin/index.php?page=broadcast-subscribers')) ?>">
        <?= renderBroadcastIcon('users', 16, 'currentColor') ?>
        <span>Kelola Subscriber (<?= (int) $subStats['total'] ?>)</span>
    </a>
    <a class="bc-btn ghost" href="<?= e(url('admin/index.php?page=broadcast-test')) ?>">
        <?= renderBroadcastIcon('server', 16, 'currentColor') ?>
        <span>Test Koneksi SMTP</span>
    </a>
</div>

<?php if (empty($items)): ?>
<div class="bc-empty">
    <div class="bc-empty-ico">
        <?= renderBroadcastIcon('mail', 40, 'currentColor') ?>
    </div>
    <h3 style="margin:0 0 8px; color:var(--ink); font-size:18px; font-weight:900;">Belum Ada Broadcast</h3>
    <p style="margin:0; font-size:14px;">Klik "Tulis Broadcast" untuk membuat pengumuman massal pertama Anda.</p>
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
            <th style="width:240px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $b): ?>
    <tr>
        <td style="font-weight:800; max-width:280px; color:var(--ink);"><?= e($b['title']) ?></td>
        <td style="color:var(--muted);"><?= e($segments[$b['segment']] ?? $b['segment']) ?></td>
        <td>
            <span class="bc-tag <?= e($b['status']) ?>">
                <?= $b['status'] === 'sent' ? renderBroadcastIcon('check-circle', 10, 'currentColor') : ($b['status'] === 'failed' ? renderBroadcastIcon('alert-circle', 10, 'currentColor') : renderBroadcastIcon('info', 10, 'currentColor')) ?>
                <?= e(strtoupper($b['status'])) ?>
            </span>
        </td>
        <td>
            <span style="color:#047857; font-weight:900;"><?= (int) $b['sent_count'] ?></span>
            <?php if ((int) $b['fail_count'] > 0): ?>
                <span style="color:#991b1b; font-weight:900;"> / <?= (int) $b['fail_count'] ?> gagal</span>
            <?php endif; ?>
        </td>
        <td style="color:var(--muted); white-space:nowrap; font-size:12.5px;"><?= e(date('d M Y · H:i', strtotime($b['created_at']))) ?></td>
        <td>
            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                <form method="post" action="<?= e(url('admin/index.php?page=broadcast-kirim')) ?>" style="display:inline;" onsubmit="return confirm('Kirim broadcast ini ke semua penerima segment?');">
                    <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $b['id'] ?>">
                    <button class="bc-mini send" type="submit">
                        <?= $b['status'] === 'sent' ? renderBroadcastIcon('refresh', 13, 'currentColor') : renderBroadcastIcon('send', 13, 'currentColor') ?>
                        <span><?= $b['status'] === 'sent' ? 'Ulang' : 'Kirim' ?></span>
                    </button>
                </form>
                <a class="bc-mini log" href="<?= e(url('admin/index.php?page=broadcast-log&id=' . $b['id'])) ?>">
                    <?= renderBroadcastIcon('file-text', 13, 'currentColor') ?>
                    <span>Log</span>
                </a>
                <form method="post" action="<?= e(url('admin/index.php?page=broadcast-hapus')) ?>" style="display:inline;" onsubmit="return confirm('Hapus broadcast ini?');">
                    <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $b['id'] ?>">
                    <button class="bc-mini danger" type="submit" title="Hapus">
                        <?= renderBroadcastIcon('trash', 13, 'currentColor') ?>
                    </button>
                </form>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php endif; ?>