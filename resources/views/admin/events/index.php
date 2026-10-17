<?php
[$mY, $mM] = array_map('intval', explode('-', $month));
$firstDow = (int) date('w', mktime(0, 0, 0, $mM, 1, $mY));
$daysIn   = (int) date('t', mktime(0, 0, 0, $mM, 1, $mY));
$todayJ = (int) date('j'); $todayM = (int) date('n'); $todayY = (int) date('Y');
$bulanId = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$prevM = date('Y-m', mktime(0, 0, 0, $mM - 1, 1, $mY));
$nextM = date('Y-m', mktime(0, 0, 0, $mM + 1, 1, $mY));

$map = [];
foreach ($monthEvents as $ev) { $map[(int) date('j', strtotime($ev['start_date']))][] = $ev; }

/* [rgb dasar, teks terang] per jenis kegiatan */
$typeColor = [
    'penelitian' => ['59,130,246',  '#93c5fd'],
    'pengabdian' => ['16,185,129',  '#6ee7b7'],
    'pelatihan'  => ['245,158,11',  '#fcd34d'],
    'seminar'    => ['139,92,246',  '#c4b5fd'],
    'workshop'   => ['6,182,212',   '#67e8f9'],
    'aik'        => ['217,164,65',  '#fde68a'],
    'rapat'      => ['100,116,139', '#cbd5e1'],
    'lainnya'    => ['148,163,184', '#e2e8f0'],
];
?>
<style>
    @keyframes evFade { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:none; } }

    .ev-head { display:flex; align-items:center; gap:16px; margin-bottom:20px; padding:22px 26px; border-radius:22px; background:linear-gradient(135deg,#3b2f0a,#8a6f1a 55%,#d9a441); color:#fff; position:relative; overflow:hidden; box-shadow:0 14px 36px rgba(0,0,0,.3); animation:evFade .5s both; }
    .ev-head-ico { width:54px; height:54px; border-radius:16px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:25px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.55),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), inset 0 -3px 5px rgba(0,0,0,.22); position:relative; z-index:1; }
    .ev-head h2 { margin:0; font-size:21px; font-weight:900; font-family:var(--font-display); position:relative; z-index:1; }
    .ev-head p { margin:3px 0 0; font-size:12.5px; opacity:.9; position:relative; z-index:1; }
    .ev-stats { display:flex; gap:8px; position:relative; z-index:1; flex-wrap:wrap; margin-left:auto; }
    .ev-stat { background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.25); border-radius:14px; padding:10px 16px; text-align:center; min-width:82px; backdrop-filter:blur(6px); }
    .ev-stat b { display:block; font-size:20px; font-weight:900; font-family:var(--font-display); color:#fff; line-height:1.1; }
    .ev-stat span { font-size:9px; letter-spacing:.12em; text-transform:uppercase; opacity:.85; display:block; margin-top:3px; }

    .ev-actions { display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:16px; }
    .ev-btn-gold { display:inline-flex; align-items:center; gap:7px; padding:11px 20px; border-radius:12px; text-decoration:none; font-size:13px; font-weight:800; color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441 80%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.7), 0 6px 16px rgba(217,164,65,.4); transition:transform .25s; }
    .ev-btn-gold:hover { transform:translateY(-2px); }
    .ev-btn-nav { display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:11px; text-decoration:none; font-size:15px; font-weight:900; color:var(--text); background:var(--surface); border:1px solid var(--border); transition:all .2s; }
    .ev-btn-nav:hover { border-color:var(--gold-strong); color:var(--gold-strong); }
    .ev-month-label { font-family:var(--font-display); font-size:16px; font-weight:900; color:#fff; min-width:170px; text-align:center; }
    .ev-btn-today { display:inline-flex; align-items:center; gap:6px; padding:9px 16px; border-radius:11px; text-decoration:none; font-size:12px; font-weight:800; color:var(--gold-strong); background:rgba(217,164,65,.1); border:1px solid rgba(217,164,65,.35); transition:all .2s; }
    .ev-btn-today:hover { background:rgba(217,164,65,.2); }

    /* ===== KALENDER GELAP NATIVE ===== */
    .evc-wrap { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:18px; animation:evFade .5s .05s both; }
    .evc-dow { display:grid; grid-template-columns:repeat(7,1fr); gap:8px; margin-bottom:8px; }
    .evc-dow span { text-align:center; font-size:10.5px; font-weight:900; letter-spacing:.14em; text-transform:uppercase; color:var(--gold-strong); padding:6px 0; }
    .evc-dow span.wk { color:rgba(242,192,99,.55); }
    .evc-grid { display:grid; grid-template-columns:repeat(7,1fr); gap:8px; }
    .evc-cell { position:relative; min-height:98px; border-radius:12px; background:rgba(255,255,255,.035); border:1px solid rgba(255,255,255,.07); padding:8px; display:flex; flex-direction:column; gap:5px; transition:all .2s; }
    .evc-cell:hover { border-color:rgba(217,164,65,.45); background:rgba(255,255,255,.06); transform:translateY(-2px); }
    .evc-cell.wknd { background:rgba(255,255,255,.018); }
    .evc-cell.blank { background:transparent; border-color:transparent; pointer-events:none; }
    .evc-cell.today { border-color:var(--gold-strong); background:rgba(217,164,65,.10); box-shadow:0 0 0 1px rgba(217,164,65,.35), 0 6px 16px rgba(217,164,65,.15); }
    .evc-num { font-family:var(--font-display); font-size:13px; font-weight:900; color:rgba(255,255,255,.85); width:26px; height:26px; display:flex; align-items:center; justify-content:center; border-radius:8px; flex-shrink:0; }
    .evc-cell.wknd .evc-num { color:rgba(255,255,255,.5); }
    .evc-cell.today .evc-num { background:linear-gradient(145deg,#fde68a,#d9a441); color:#03251f; box-shadow:0 3px 8px rgba(217,164,65,.4); }
    .evc-events { display:flex; flex-direction:column; gap:4px; overflow:hidden; }
    .evc-pill { display:block; padding:4px 8px; border-radius:8px; font-size:10.5px; font-weight:700; line-height:1.35; text-decoration:none; border:1px solid; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; transition:all .15s; }
    .evc-pill:hover { filter:brightness(1.25); transform:translateX(2px); }
    .evc-more { font-size:9.5px; font-weight:800; color:var(--muted); padding-left:4px; }
    .evc-legend { display:flex; gap:12px; flex-wrap:wrap; margin-top:14px; padding-top:12px; border-top:1px dashed var(--border); }
    .evc-leg { display:inline-flex; align-items:center; gap:6px; font-size:10.5px; font-weight:700; color:var(--muted); }
    .evc-leg i { width:10px; height:10px; border-radius:3px; display:inline-block; }

    .ev-filter { display:flex; gap:8px; flex-wrap:wrap; margin:16px 0 14px; padding:14px; background:var(--surface); border:1px solid var(--border); border-radius:14px; }
    .ev-filter input[type="text"] { flex:1; min-width:200px; padding:10px 14px; border-radius:10px; border:1px solid var(--border); background:var(--surface-2); color:var(--text); font-size:13px; }
    .ev-filter select { padding:10px 14px; border-radius:10px; border:1px solid var(--border); background:var(--surface-2); color:var(--text); font-size:13px; cursor:pointer; }
    .ev-filter button { padding:10px 20px; border-radius:10px; border:none; background:linear-gradient(145deg,#10b981,#059669); color:#fff; font-weight:800; font-size:13px; cursor:pointer; box-shadow:0 4px 12px rgba(5,150,105,.3); }
    @media (max-width:800px){ .evc-cell { min-height:64px; } .evc-pill { font-size:9px; } }
</style>

<!-- HEADER -->
<div class="ev-head">
    <div class="ev-head-ico">📅</div>
    <div style="position:relative; z-index:1;">
        <h2>Kalender Kegiatan LP3M</h2>
        <p>Semua agenda penelitian, pengabdian, pelatihan, seminar, dan AIK dalam satu tampilan.</p>
    </div>
    <div class="ev-stats">
        <div class="ev-stat"><b><?= (int) $stats['upcoming'] ?></b><span>Mendatang</span></div>
        <div class="ev-stat"><b><?= (int) $stats['this_month'] ?></b><span>Bulan Ini</span></div>
        <div class="ev-stat"><b><?= (int) $stats['total'] ?></b><span>Total</span></div>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<!-- NAVIGASI BULAN -->
<div class="ev-actions">
    <a class="ev-btn-gold" href="<?= e(url('admin/index.php?page=events-tambah')) ?>">➕ Tambah Kegiatan</a>
    <a class="ev-btn-nav" href="<?= e(url('admin/index.php?page=events&month=' . $prevM)) ?>" title="Bulan sebelumnya">◀</a>
    <span class="ev-month-label"><?= $bulanId[$mM - 1] ?> <?= $mY ?></span>
    <a class="ev-btn-nav" href="<?= e(url('admin/index.php?page=events&month=' . $nextM)) ?>" title="Bulan berikutnya">▶</a>
    <a class="ev-btn-today" href="<?= e(url('admin/index.php?page=events&month=' . date('Y-m'))) ?>">🎯 Hari Ini</a>
</div>

<!-- KALENDER -->
<div class="evc-wrap">
    <div class="evc-dow">
        <span class="wk">Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span class="wk">Sab</span>
    </div>
    <div class="evc-grid">
        <?php for ($i = 0; $i < $firstDow; $i++): ?><div class="evc-cell blank"></div><?php endfor; ?>
        <?php for ($d = 1; $d <= $daysIn; $d++):
            $dow = (int) date('w', mktime(0, 0, 0, $mM, $d, $mY));
            $isToday = ($mY === $todayY && $mM === $todayM && $d === $todayJ);
            $evs = $map[$d] ?? [];
        ?>
        <div class="evc-cell <?= $isToday ? 'today' : '' ?> <?= ($dow === 0 || $dow === 6) ? 'wknd' : '' ?>">
            <span class="evc-num"><?= $d ?></span>
            <div class="evc-events">
                <?php foreach (array_slice($evs, 0, 3) as $ev):
                    [$rgb, $light] = $typeColor[$ev['event_type']] ?? $typeColor['lainnya'];
                ?>
                <a class="evc-pill" style="background:rgba(<?= $rgb ?>,.16); border-color:rgba(<?= $rgb ?>,.5); color:<?= $light ?>;"
                   href="<?= e(url('admin/index.php?page=events-edit&id=' . $ev['id'])) ?>"
                   title="<?= e($ev['title']) ?><?= !empty($ev['start_time']) ? ' · ' . e(substr($ev['start_time'], 0, 5)) : '' ?>">
                    <?= !empty($ev['start_time']) ? e(substr($ev['start_time'], 0, 5)) . ' ' : '' ?><?= e($ev['title']) ?>
                </a>
                <?php endforeach; ?>
                <?php if (count($evs) > 3): ?><span class="evc-more">+<?= count($evs) - 3 ?> lagi…</span><?php endif; ?>
            </div>
        </div>
        <?php endfor; ?>
        <?php $trail = (7 - (($firstDow + $daysIn) % 7)) % 7; for ($i = 0; $i < $trail; $i++): ?><div class="evc-cell blank"></div><?php endfor; ?>
    </div>
    <div class="evc-legend">
        <?php foreach ($typeColor as $key => [$rgb, $light]): ?>
        <span class="evc-leg"><i style="background:rgb(<?= $rgb ?>);"></i><?= e(CalendarEvent::TYPES[$key] ?? ucfirst($key)) ?></span>
        <?php endforeach; ?>
    </div>
</div>

<!-- FILTER -->
<form method="get" action="<?= e(url('admin/index.php')) ?>" class="ev-filter">
    <input type="hidden" name="page" value="events">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="🔍 Cari judul / lokasi...">
    <select name="type">
        <option value="">Semua Jenis</option>
        <?php foreach (CalendarEvent::TYPES as $k => $l): ?>
        <option value="<?= e($k) ?>" <?= ($filters['type'] ?? '') === $k ? 'selected' : '' ?>><?= e($l) ?></option>
        <?php endforeach; ?>
    </select>
    <select name="status">
        <option value="">Semua Status</option>
        <?php foreach (CalendarEvent::STATUSES as $k => $l): ?>
        <option value="<?= e($k) ?>" <?= ($filters['status'] ?? '') === $k ? 'selected' : '' ?>><?= e($l) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">🔍 Filter</button>
</form>

<!-- TABEL -->
<table class="admin-table">
    <thead>
        <tr><th>Kegiatan</th><th>Jenis</th><th>Tanggal</th><th>Lokasi</th><th>Status</th><th style="width:120px">Aksi</th></tr>
    </thead>
    <tbody>
    <?php if (empty($items)): ?>
        <tr><td colspan="6" style="text-align:center; padding:40px; opacity:.6;">Belum ada kegiatan.</td></tr>
    <?php endif; ?>
    <?php foreach ($items as $it): ?>
    <tr>
        <td>
            <b style="color:var(--text);"><?= e($it['title']) ?></b>
            <div style="font-size:11px; opacity:.65; margin-top:2px;">🏛️ <?= e($it['organizer'] ?: 'LP3M') ?></div>
        </td>
        <td><?= e(CalendarEvent::TYPES[$it['event_type']] ?? '-') ?></td>
        <td>
            <?= e(date('d M Y', strtotime($it['start_date']))) ?>
            <?php if (!empty($it['end_date']) && $it['end_date'] !== $it['start_date']): ?> – <?= e(date('d M Y', strtotime($it['end_date']))) ?><?php endif; ?>
            <?php if (!empty($it['start_time'])): ?><div style="font-size:11px; opacity:.65;">🕐 <?= e(substr($it['start_time'], 0, 5)) ?><?= !empty($it['end_time']) ? '–' . e(substr($it['end_time'], 0, 5)) : '' ?></div><?php endif; ?>
        </td>
        <td><?= e($it['location'] ?: '-') ?></td>
        <td><span class="status-badge status-<?= e($it['status']) ?>"><?= e(CalendarEvent::STATUSES[$it['status']] ?? $it['status']) ?></span></td>
        <td>
            <div style="display:flex; gap:6px;">
                <a class="btn-admin" href="<?= e(url('admin/index.php?page=events-edit&id=' . $it['id'])) ?>" title="Edit">✏️</a>
                <form method="post" action="<?= e(url('admin/index.php?page=events-hapus')) ?>" onsubmit="return confirm('Hapus kegiatan ini?');" style="display:inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= (int) $it['id'] ?>">
                    <button class="btn-admin btn-danger" type="submit" title="Hapus">🗑️</button>
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
    <a href="<?= e(url('admin/index.php?page=events&hal=' . $i . '&q=' . urlencode($q) . '&type=' . urlencode($filters['type'] ?? '') . '&status=' . urlencode($filters['status'] ?? ''))) ?>"
       class="pag-3d <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>