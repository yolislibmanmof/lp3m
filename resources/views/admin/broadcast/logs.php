<?php
// SVG Icon Helper untuk Broadcast Log
function renderLogIcon($name, $size = 16, $color = 'currentColor') {
    $icons = [
        'arrow-left' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
        'list' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>',
        'check-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>',
        'x-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>',
        'mail' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>',
        'clock' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
        'alert-triangle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>',
    ];
    return $icons[$name] ?? $icons['list'];
}
?>

<style>
    @keyframes blFade { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
    @keyframes iconRotate { 0%, 100% { transform: rotate(0deg) scale(1); } 25% { transform: rotate(-5deg) scale(1.05); } 75% { transform: rotate(5deg) scale(1.05); } }

    .bl-svg { display: inline-flex; align-items: center; justify-content: center; vertical-align: middle; }
    .bl-svg svg { display: block; transition: all 0.3s ease; }

    .bl-back-btn {
        padding: 10px 18px; border-radius: 12px; font-size: 13px; font-weight: 800;
        text-decoration: none; color: var(--muted); background: var(--surface);
        border: 1px solid var(--border); display: inline-flex; align-items: center; gap: 8px;
        margin-bottom: 20px; transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.04);
    }
    .bl-back-btn svg { width: 16px; height: 16px; stroke: currentColor; stroke-width: 2.2; transition: all 0.3s ease; }
    .bl-back-btn:hover {
        transform: translateX(-3px); border-color: rgba(234,88,12,0.4); color: #ea580c;
        background: rgba(234,88,12,0.05);
    }
    .bl-back-btn:hover svg { animation: iconRotate 0.5s ease; }

    .bl-head {
        position: relative; overflow: hidden; display: flex; align-items: center; gap: 18px;
        margin-bottom: 24px; padding: 28px 32px; border-radius: 24px;
        background: linear-gradient(135deg, #7c2d12 0%, #c2410c 55%, #ea580c 100%);
        color: #fff; box-shadow: 0 20px 50px rgba(0,0,0,.3);
        animation: blFade .5s cubic-bezier(.16,1,.3,1) both;
    }
    .bl-head::after {
        content: ''; position: absolute; top: -50%; right: -8%;
        width: 340px; height: 340px; border-radius: 50%;
        background: radial-gradient(circle, rgba(254,215,170,.22), transparent 70%);
        pointer-events: none;
    }
    .bl-head-ico {
        width: 60px; height: 60px; border-radius: 17px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.55), transparent 45%),
                    linear-gradient(145deg, #fde68a, #f2c063 55%, #a9761b);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.6), 0 8px 20px rgba(217,164,65,.4);
        position: relative; z-index: 1;
        transition: transform 0.3s ease;
    }
    .bl-head-ico:hover { transform: scale(1.05) rotate(-5deg); }
    .bl-head-ico svg { width: 28px; height: 28px; stroke: #03251f; stroke-width: 2.2; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2)); }
    
    .bl-head h2 {
        margin: 0 0 6px; font-family: var(--font-display); font-size: 22px; font-weight: 900;
        position: relative; z-index: 1; letter-spacing: -0.02em;
    }
    .bl-head p {
        margin: 0; font-size: 13px; opacity: .9; position: relative; z-index: 1;
        display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
    }
    .bl-head p span { display: inline-flex; align-items: center; gap: 5px; }
    .bl-head p svg { width: 14px; height: 14px; stroke: currentColor; stroke-width: 2.2; }

    .bl-table {
        width: 100%; border-collapse: separate; border-spacing: 0;
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 20px; overflow: hidden; animation: blFade .5s .08s both;
        box-shadow: 0 6px 20px rgba(0,0,0,.05);
    }
    .bl-table th {
        padding: 14px 18px; text-align: left; font-size: 11px; font-weight: 900;
        letter-spacing: .1em; text-transform: uppercase; color: #fde68a;
        background: linear-gradient(145deg, #7c2d12, #c2410c);
        border-bottom: 1px solid rgba(254,215,170,0.2);
    }
    .bl-table td {
        padding: 14px 18px; border-bottom: 1px solid var(--border);
        font-size: 13px; color: var(--text); vertical-align: middle;
    }
    .bl-table tr:last-child td { border-bottom: none; }
    .bl-table tbody tr { transition: background .2s; }
    .bl-table tbody tr:hover { background: rgba(234,88,12,.04); }

    .bl-tag {
        display: inline-flex; align-items: center; gap: 5px; padding: 4px 11px;
        border-radius: 999px; font-size: 10.5px; font-weight: 900; letter-spacing: .05em; white-space: nowrap;
    }
    .bl-tag svg { width: 10px; height: 10px; stroke: currentColor; stroke-width: 2.5; }
    .bl-tag.sent { background: rgba(16,185,129,.14); color: #047857; }
    .bl-tag.failed { background: rgba(220,38,38,.14); color: #991b1b; }

    .bl-empty {
        text-align: center; padding: 60px 24px; color: var(--muted);
        background: var(--surface); border: 2px dashed var(--border);
        border-radius: 22px; animation: blFade .5s .08s both;
    }
    .bl-empty-ico {
        width: 80px; height: 80px; margin: 0 auto 16px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; background: linear-gradient(145deg, rgba(234,88,12,0.15), rgba(234,88,12,0.05));
        border: 2px dashed rgba(234,88,12,0.3);
    }
    .bl-empty-ico svg { width: 40px; height: 40px; stroke: var(--muted); stroke-width: 1.5; opacity: 0.6; }
</style>

<!-- BACK BUTTON -->
<a class="bl-back-btn" href="<?= e(url('admin/index.php?page=broadcast')) ?>">
    <?= renderLogIcon('arrow-left', 16, 'currentColor') ?>
    <span>Kembali ke Broadcast</span>
</a>

<!-- HEADER -->
<div class="bl-head">
    <div class="bl-head-ico">
        <?= renderLogIcon('list', 28, '#03251f') ?>
    </div>
    <div style="flex:1; min-width:0; position:relative; z-index:1;">
        <h2><?= e($item['title']) ?></h2>
        <p>
            <span>
                <?= $item['status'] === 'sent' ? renderLogIcon('check-circle', 14, '#6ee7b7') : renderLogIcon('alert-triangle', 14, '#fca5a5') ?>
                Status: <?= e(strtoupper($item['status'])) ?>
            </span>
            <span>
                <?= renderLogIcon('check-circle', 14, '#6ee7b7') ?>
                <?= (int) $item['sent_count'] ?> terkirim
            </span>
            <span>
                <?= renderLogIcon('x-circle', 14, '#fca5a5') ?>
                <?= (int) $item['fail_count'] ?> gagal
            </span>
            <span>
                <?= renderLogIcon('mail', 14, '#fed7aa') ?>
                Segment: <?= e($item['segment']) ?>
            </span>
        </p>
    </div>
</div>

<!-- CONTENT -->
<?php if (empty($logs)): ?>
<div class="bl-empty">
    <div class="bl-empty-ico">
        <?= renderLogIcon('mail', 40, 'currentColor') ?>
    </div>
    <h3 style="margin:0 0 8px; color:var(--ink); font-size:18px; font-weight:900;">Belum Ada Log Pengiriman</h3>
    <p style="margin:0; font-size:14px;">Broadcast ini belum diproses atau tidak memiliki catatan log.</p>
</div>
<?php else: ?>
<div style="overflow-x:auto;">
<table class="bl-table">
    <thead>
        <tr>
            <th style="width:60px;">#</th>
            <th>Email Penerima</th>
            <th style="width:120px;">Status</th>
            <th>Error</th>
            <th style="width:180px;">Waktu</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($logs as $i => $l): ?>
    <tr>
        <td style="color:var(--muted); font-weight:700;"><?= $i + 1 ?></td>
        <td style="font-weight:700; color:var(--ink);"><?= e($l['email']) ?></td>
        <td>
            <span class="bl-tag <?= e($l['status']) ?>">
                <?= $l['status'] === 'sent' ? renderLogIcon('check-circle', 10, 'currentColor') : renderLogIcon('x-circle', 10, 'currentColor') ?>
                <?= e(strtoupper($l['status'])) ?>
            </span>
        </td>
        <td style="color:var(--muted); font-size:12.5px; font-family:'Courier New', monospace;">
            <?= e($l['error'] ?? '—') ?>
        </td>
        <td style="color:var(--muted); white-space:nowrap; font-size:12.5px;">
            <span style="display:inline-flex; align-items:center; gap:5px;">
                <?= renderLogIcon('clock', 12, 'currentColor') ?>
                <?= e(date('d M Y · H:i:s', strtotime($l['created_at']))) ?>
            </span>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php endif; ?>