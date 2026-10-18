<?php
// SVG Icon Helper untuk Subscriber Management
function renderSubIcon($name, $size = 16, $color = 'currentColor') {
    $icons = [
        'users' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'arrow-left' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
        'download' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>',
        'search' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        'filter' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>',
        'check-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>',
        'x-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>',
        'mail' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>',
        'user' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>',
        'calendar' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
        'trash' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',
        'inbox' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>',
        'alert-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>',
        'chevron-down' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>',
    ];
    return $icons[$name] ?? $icons['users'];
}
?>

<style>
    @keyframes bsFade { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
    @keyframes bsShine { 0%, 55% { left: -90%; } 100% { left: 165%; } }
    @keyframes iconRotate { 0%, 100% { transform: rotate(0deg) scale(1); } 25% { transform: rotate(-5deg) scale(1.05); } 75% { transform: rotate(5deg) scale(1.05); } }

    .bs-svg { display: inline-flex; align-items: center; justify-content: center; vertical-align: middle; }
    .bs-svg svg { display: block; transition: all 0.3s ease; }

    /* ===== HEADER ===== */
    .bs-head {
        position: relative; overflow: hidden; display: flex; align-items: center; gap: 18px;
        margin-bottom: 24px; padding: 28px 32px; border-radius: 24px;
        background: linear-gradient(135deg, #7c2d12 0%, #c2410c 55%, #ea580c 100%);
        color: #fff; box-shadow: 0 20px 50px rgba(0,0,0,.3);
        animation: bsFade .5s cubic-bezier(.16,1,.3,1) both;
    }
    .bs-head::after {
        content: ''; position: absolute; top: -50%; right: -8%;
        width: 340px; height: 340px; border-radius: 50%;
        background: radial-gradient(circle, rgba(254,215,170,.22), transparent 70%);
        pointer-events: none;
    }
    .bs-head-ico {
        width: 60px; height: 60px; border-radius: 17px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.55), transparent 45%),
                    linear-gradient(145deg, #fde68a, #f2c063 55%, #a9761b);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.6), 0 8px 20px rgba(217,164,65,.4);
        position: relative; z-index: 1;
        transition: transform 0.3s ease;
    }
    .bs-head-ico:hover { transform: scale(1.05) rotate(-5deg); }
    .bs-head-ico svg { width: 28px; height: 28px; stroke: #03251f; stroke-width: 2.2; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2)); }
    
    .bs-head h2 {
        margin: 0 0 6px; font-family: var(--font-display); font-size: 23px; font-weight: 900;
        position: relative; z-index: 1; letter-spacing: -0.02em;
    }
    .bs-head p {
        margin: 0; font-size: 13px; opacity: .9; position: relative; z-index: 1;
        display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
    }
    .bs-head p span { display: inline-flex; align-items: center; gap: 5px; }
    .bs-head p svg { width: 14px; height: 14px; stroke: currentColor; stroke-width: 2.2; }

    .bs-head-actions {
        margin-left: auto; display: flex; gap: 10px; position: relative; z-index: 1;
    }
    .bs-btn {
        position: relative; overflow: hidden; padding: 12px 22px; border-radius: 13px;
        font-size: 13.5px; font-weight: 800; text-decoration: none;
        display: inline-flex; align-items: center; gap: 8px;
        transition: all .25s cubic-bezier(.16,1,.3,1); border: none; cursor: pointer;
    }
    .bs-btn svg { width: 16px; height: 16px; stroke: currentColor; stroke-width: 2.2; transition: all 0.3s ease; }
    .bs-btn.gold {
        color: #03251f; background: linear-gradient(145deg, #fde68a, #d9a441);
        box-shadow: 0 6px 16px rgba(217,164,65,.35);
    }
    .bs-btn.gold::after {
        content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent);
        animation: bsShine 3s ease-in-out infinite;
    }
    .bs-btn.ghost {
        color: var(--muted); background: var(--surface); border: 1px solid var(--border);
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.04);
    }
    .bs-btn:hover { transform: translateY(-2px); filter: brightness(1.05); }
    .bs-btn:hover svg { animation: iconRotate 0.5s ease; }

    /* ===== FLASH ===== */
    .flash-3d {
        position: relative; padding: 15px 20px; margin-bottom: 22px; border-radius: 14px;
        font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 10px;
        overflow: hidden; box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.05), 0 6px 16px rgba(0,0,0,.1);
        animation: bsFade .5s cubic-bezier(.16,1,.3,1) both;
    }
    .flash-3d svg { width: 20px; height: 20px; stroke-width: 2.2; flex-shrink: 0; }
    .flash-3d::after {
        content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent);
        animation: bsShine 3s ease-in-out infinite; pointer-events: none;
    }
    .flash-success-3d { background: linear-gradient(145deg, #d1fae5, #a7f3d0); border: 1px solid rgba(16,185,129,.35); color: #065f46; }
    .flash-success-3d svg { stroke: #065f46; }
    .flash-error-3d { background: linear-gradient(145deg, #fee2e2, #fecaca); border: 1px solid rgba(220,38,38,.35); color: #991b1b; }
    .flash-error-3d svg { stroke: #991b1b; }

    /* ===== FILTER BAR ===== */
    .bs-filter {
        display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 20px;
        padding: 18px 20px; background: var(--surface); border: 1px solid var(--border);
        border-radius: 18px; box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        animation: bsFade .5s .05s both;
        position: relative;
    }
    .bs-filter::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, #ea580c, #f2c063); opacity: 0.8;
        border-radius: 18px 18px 0 0;
    }
    .bs-filter input[type="text"], .bs-filter select {
        padding: 11px 16px; border-radius: 11px; border: 2px solid var(--border);
        background: linear-gradient(145deg, #f6faf7, #fff); font-size: 13.5px; font-weight: 600;
        color: var(--text); transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: inset 0 2px 4px rgba(0,0,0,.04);
        outline: none;
    }
    .bs-filter input[type="text"] { flex: 1; min-width: 220px; }
    .bs-filter input[type="text"]::placeholder { color: var(--muted); }
    
    .bs-filter select {
        appearance: none; -webkit-appearance: none; -moz-appearance: none;
        cursor: pointer; min-width: 170px; padding-right: 44px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='none' stroke='%23ea580c' stroke-width='2.5' viewBox='0 0 24 24'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 14px center !important;
        background-size: 18px 18px !important;
    }
    .bs-filter select:hover {
        border-color: rgba(234, 88, 12, 0.4); background-color: #ffffff;
        transform: translateY(-1px); box-shadow: inset 0 2px 4px rgba(0,0,0,.04), 0 6px 16px rgba(234,88,12,0.12);
    }
    .bs-filter select:focus {
        border-color: #ea580c; background-color: #ffffff;
        box-shadow: inset 0 2px 4px rgba(0,0,0,.04), 0 0 0 4px rgba(234, 88, 12, 0.15), 0 6px 16px rgba(234,88,12,0.15);
    }
    .bs-filter select option { background: #ffffff; color: #03251f; padding: 10px; font-weight: 600; }

    .bs-filter-btn {
        padding: 11px 22px; border-radius: 11px; border: none; cursor: pointer;
        font-size: 13.5px; font-weight: 800; color: #03251f;
        background: linear-gradient(145deg, #fde68a, #f2c063 55%, #d9a441);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.15), 0 6px 16px rgba(217,164,65,.35);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex; align-items: center; gap: 8px;
    }
    .bs-filter-btn svg { width: 16px; height: 16px; stroke: #03251f; stroke-width: 2.2; }
    .bs-filter-btn:hover { transform: translateY(-2px); box-shadow: inset 0 2px 3px rgba(255,255,255,.8), 0 10px 24px rgba(217,164,65,.45); }

    /* ===== TABLE ===== */
    .bs-table {
        width: 100%; border-collapse: separate; border-spacing: 0;
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 20px; overflow: hidden; animation: bsFade .5s .08s both;
        box-shadow: 0 6px 20px rgba(0,0,0,.05);
    }
    .bs-table th {
        padding: 14px 18px; text-align: left; font-size: 11px; font-weight: 900;
        letter-spacing: .1em; text-transform: uppercase; color: #fde68a;
        background: linear-gradient(145deg, #7c2d12, #c2410c);
        border-bottom: 1px solid rgba(254,215,170,0.2);
    }
    .bs-table td {
        padding: 14px 18px; border-bottom: 1px solid var(--border);
        font-size: 13px; color: var(--text); vertical-align: middle;
    }
    .bs-table tr:last-child td { border-bottom: none; }
    .bs-table tbody tr { transition: background .2s; }
    .bs-table tbody tr:hover { background: rgba(234,88,12,.04); }

    .bs-tag {
        display: inline-flex; align-items: center; gap: 5px; padding: 4px 11px;
        border-radius: 999px; font-size: 10.5px; font-weight: 900; letter-spacing: .05em; white-space: nowrap;
    }
    .bs-tag svg { width: 10px; height: 10px; stroke: currentColor; stroke-width: 2.5; }
    .bs-tag.active { background: rgba(16,185,129,.14); color: #047857; }
    .bs-tag.unsubscribed { background: rgba(100,116,139,.15); color: var(--muted); }

    .bs-del-btn {
        padding: 8px 11px; border-radius: 10px; border: 1px solid rgba(220,38,38,.35);
        background: rgba(220,38,38,.08); color: #fca5a5; cursor: pointer;
        font-size: 12px; font-weight: 800; transition: all 0.25s ease;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .bs-del-btn svg { width: 13px; height: 13px; stroke: currentColor; stroke-width: 2.2; }
    .bs-del-btn:hover {
        border-color: rgba(220,38,38,.5); color: #dc2626;
        background: rgba(220,38,38,.15); transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(220,38,38,0.15);
    }
    .bs-del-btn:hover svg { animation: iconRotate 0.5s ease; }

    /* ===== EMPTY STATE ===== */
    .bs-empty {
        text-align: center; padding: 60px 24px; color: var(--muted);
        background: var(--surface); border: 2px dashed var(--border);
        border-radius: 22px; animation: bsFade .5s .08s both;
    }
    .bs-empty-ico {
        width: 80px; height: 80px; margin: 0 auto 16px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; background: linear-gradient(145deg, rgba(234,88,12,0.15), rgba(234,88,12,0.05));
        border: 2px dashed rgba(234,88,12,0.3);
    }
    .bs-empty-ico svg { width: 40px; height: 40px; stroke: var(--muted); stroke-width: 1.5; opacity: 0.6; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .bs-head { flex-direction: column; align-items: flex-start; padding: 22px; }
        .bs-head-actions { margin-left: 0; margin-top: 12px; width: 100%; }
        .bs-btn { flex: 1; justify-content: center; }
        .bs-filter { flex-direction: column; }
        .bs-filter input[type="text"], .bs-filter select, .bs-filter-btn { width: 100%; min-width: 0; }
    }
</style>

<!-- HEADER -->
<div class="bs-head">
    <div class="bs-head-ico">
        <?= renderSubIcon('users', 28, '#03251f') ?>
    </div>
    <div style="flex:1; min-width:0; position:relative; z-index:1;">
        <h2>Manajemen Subscriber</h2>
        <p>
            <span>
                <?= renderSubIcon('check-circle', 14, '#6ee7b7') ?>
                <?= (int) $stats['active'] ?> aktif
            </span>
            <span>
                <?= renderSubIcon('x-circle', 14, '#fca5a5') ?>
                <?= (int) $stats['unsub'] ?> berhenti
            </span>
            <span>
                <?= renderSubIcon('users', 14, '#fed7aa') ?>
                total <?= (int) $stats['total'] ?>
            </span>
        </p>
    </div>
    <div class="bs-head-actions">
        <a class="bs-btn gold" href="<?= e(url('admin/index.php?page=broadcast-subscriber-export')) ?>">
            <?= renderSubIcon('download', 16, 'currentColor') ?>
            <span>Export CSV</span>
        </a>
        <a class="bs-btn ghost" href="<?= e(url('admin/index.php?page=broadcast')) ?>">
            <?= renderSubIcon('arrow-left', 16, 'currentColor') ?>
            <span>Kembali</span>
        </a>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? renderSubIcon('alert-circle', 20, 'currentColor') : renderSubIcon('check-circle', 20, 'currentColor') ?>
    <span><?= e($flash['message']) ?></span>
</div>
<?php endif; ?>

<!-- FILTER BAR -->
<form method="get" action="<?= e(url('admin/index.php')) ?>" class="bs-filter">
    <input type="hidden" name="page" value="broadcast-subscribers">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="Cari email / nama...">
    <select name="status">
        <option value="">Semua Status</option>
        <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Aktif</option>
        <option value="unsubscribed" <?= $status === 'unsubscribed' ? 'selected' : '' ?>>Berhenti</option>
    </select>
    <button type="submit" class="bs-filter-btn">
        <?= renderSubIcon('filter', 16, 'currentColor') ?>
        <span>Filter</span>
    </button>
</form>

<!-- CONTENT -->
<?php if (empty($items)): ?>
<div class="bs-empty">
    <div class="bs-empty-ico">
        <?= renderSubIcon('inbox', 40, 'currentColor') ?>
    </div>
    <h3 style="margin:0 0 8px; color:var(--ink); font-size:18px; font-weight:900;">Belum Ada Subscriber</h3>
    <p style="margin:0; font-size:14px;">Subscriber akan muncul di sini setelah ada yang mendaftar melalui website publik.</p>
</div>
<?php else: ?>
<div style="overflow-x:auto;">
<table class="bs-table">
    <thead>
        <tr>
            <th style="width:60px;">#</th>
            <th>Email</th>
            <th>Nama</th>
            <th style="width:120px;">Status</th>
            <th>Sumber</th>
            <th style="width:140px;">Terdaftar</th>
            <th style="width:80px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $idx => $s): ?>
    <tr>
        <td style="color:var(--muted); font-weight:700;"><?= $idx + 1 ?></td>
        <td style="font-weight:700; color:var(--ink);">
            <span style="display:inline-flex; align-items:center; gap:6px;">
                <?= renderSubIcon('mail', 14, 'currentColor') ?>
                <?= e($s['email']) ?>
            </span>
        </td>
        <td style="color:var(--muted);">
            <span style="display:inline-flex; align-items:center; gap:6px;">
                <?= renderSubIcon('user', 14, 'currentColor') ?>
                <?= e($s['name'] ?: '—') ?>
            </span>
        </td>
        <td>
            <span class="bs-tag <?= e($s['status']) ?>">
                <?= $s['status'] === 'active' ? renderSubIcon('check-circle', 10, 'currentColor') : renderSubIcon('x-circle', 10, 'currentColor') ?>
                <?= e(strtoupper($s['status'])) ?>
            </span>
        </td>
        <td style="color:var(--muted); font-size:12.5px;"><?= e($s['source']) ?></td>
        <td style="color:var(--muted); white-space:nowrap; font-size:12.5px;">
            <span style="display:inline-flex; align-items:center; gap:5px;">
                <?= renderSubIcon('calendar', 12, 'currentColor') ?>
                <?= e(date('d M Y', strtotime($s['created_at']))) ?>
            </span>
        </td>
        <td>
            <form method="post" action="<?= e(url('admin/index.php?page=broadcast-subscriber-hapus')) ?>" onsubmit="return confirm('Hapus subscriber ini?');" style="display:inline;">
                <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $s['id'] ?>">
                <button type="submit" class="bs-del-btn" title="Hapus subscriber">
                    <?= renderSubIcon('trash', 13, 'currentColor') ?>
                </button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php endif; ?>