<?php
$bulanId = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
[$mY, $mM] = array_map('intval', explode('-', $month));
$firstDow = (int) date('w', mktime(0, 0, 0, $mM, 1, $mY));
$daysIn   = (int) date('t', mktime(0, 0, 0, $mM, 1, $mY));
$todayJ = (int) date('j'); $todayM = (int) date('n'); $todayY = (int) date('Y');
$prevM = date('Y-m', mktime(0, 0, 0, $mM - 1, 1, $mY));
$nextM = date('Y-m', mktime(0, 0, 0, $mM + 1, 1, $mY));

$map = [];
foreach ($monthEvents as $ev) { $map[(int) date('j', strtotime($ev['start_date']))][] = $ev; }

$typeColor = [
    'penelitian' => ['5,150,105',   '#047857'],
    'pengabdian' => ['16,185,129',  '#065f46'],
    'pelatihan'  => ['245,158,11',  '#92400e'],
    'seminar'    => ['139,92,246',  '#5b21b6'],
    'workshop'   => ['6,182,212',   '#155e75'],
    'aik'        => ['217,164,65',  '#78350f'],
    'rapat'      => ['100,116,139', '#334155'],
    'lainnya'    => ['148,163,184', '#475569'],
];
$typesAll = CalendarEvent::TYPES;
?>
<style>
    @keyframes agFade { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:none; } }
    @keyframes agShine { 0%,55% { left:-90%; } 100% { left:165%; } }
    @keyframes agPulse { 0%,100% { transform:scale(1); } 50% { transform:scale(1.08); } }

    .ag-hero { position:relative; padding:70px 24px 60px; margin-bottom:40px; border-radius:26px; background:linear-gradient(135deg,#043b2c 0%,#065f46 45%,#059669 100%); color:#fff; overflow:hidden; box-shadow:0 24px 60px rgba(3,37,31,.25); }
    .ag-hero::before { content:''; position:absolute; top:-40%; right:-10%; width:480px; height:480px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.35),transparent 70%); pointer-events:none; }
    .ag-hero::after { content:''; position:absolute; bottom:-30%; left:-5%; width:380px; height:380px; border-radius:50%; background:radial-gradient(circle,rgba(255,255,255,.1),transparent 70%); pointer-events:none; }
    .ag-hero-inner { position:relative; z-index:2; max-width:1200px; margin:0 auto; }
    .ag-eyebrow { display:inline-block; padding:4px 14px; border-radius:999px; font-size:10.5px; font-weight:900; letter-spacing:.18em; text-transform:uppercase; background:rgba(217,164,65,.25); border:1px solid rgba(217,164,65,.5); color:#fde68a; margin-bottom:18px; }
    .ag-hero h1 { font-family:var(--font-display); font-size:clamp(28px, 5vw, 44px); font-weight:900; letter-spacing:-.02em; margin:0 0 14px; background:linear-gradient(135deg,#fff,#fde68a 60%,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .ag-hero p { font-size:15px; line-height:1.7; opacity:.92; max-width:680px; margin:0 0 26px; }
    .ag-stats { display:flex; gap:10px; flex-wrap:wrap; }
    .ag-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.2); border-radius:14px; padding:10px 18px; backdrop-filter:blur(6px); display:inline-flex; align-items:center; gap:9px; font-size:13px; font-weight:700; }
    .ag-stat b { font-family:var(--font-display); font-size:17px; font-weight:900; color:#fde68a; }

    .ag-section { max-width:1200px; margin:0 auto 50px; padding:0 24px; }
    .ag-head { display:flex; align-items:flex-end; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:22px; }
    .ag-head h2 { font-family:var(--font-display); font-size:24px; font-weight:900; color:var(--ink); margin:0; letter-spacing:-.02em; display:flex; align-items:center; gap:10px; }
    .ag-head h2 i { width:38px; height:38px; border-radius:12px; display:inline-flex; align-items:center; justify-content:center; font-style:normal; font-size:18px; background:linear-gradient(145deg,#d1fae5,#a7f3d0); box-shadow:0 6px 14px rgba(16,185,129,.25); }
    .ag-head .ag-sub { font-size:12.5px; color:var(--muted); margin-top:4px; }
    .ag-chip { display:inline-flex; align-items:center; gap:6px; padding:5px 14px; border-radius:999px; font-size:11.5px; font-weight:800; background:rgba(5,150,105,.1); color:#065f46; border:1px solid rgba(5,150,105,.3); }
    .ag-nav { display:inline-flex; align-items:center; gap:6px; }
    .ag-nav-btn { width:38px; height:38px; border-radius:11px; border:1px solid var(--border); background:var(--surface); color:var(--ink); text-decoration:none; display:inline-flex; align-items:center; justify-content:center; font-size:13px; font-weight:900; transition:all .2s; }
    .ag-nav-btn:hover { border-color:#059669; color:#059669; transform:translateY(-2px); box-shadow:0 6px 14px rgba(5,150,105,.15); }
    .ag-nav-label { font-family:var(--font-display); font-size:14px; font-weight:800; color:var(--ink); min-width:160px; text-align:center; padding:0 6px; }
    .ag-nav-today { padding:8px 14px; border-radius:10px; font-size:11px; font-weight:800; color:#059669; background:rgba(5,150,105,.08); border:1px solid rgba(5,150,105,.25); text-decoration:none; transition:all .2s; }
    .ag-nav-today:hover { background:rgba(5,150,105,.15); }

    /* ===== UPCOMING LIST ===== */
    .ag-upcoming { display:flex; flex-direction:column; gap:14px; }
    .ag-up-card { position:relative; display:flex; gap:20px; padding:22px 24px; border-radius:20px; background:linear-gradient(145deg,#fff,#f6fcf7); border:1px solid var(--border); box-shadow:0 8px 22px rgba(3,37,31,.06); transition:all .3s; overflow:hidden; }
    .ag-up-card:hover { transform:translateY(-3px); box-shadow:0 16px 36px rgba(3,37,31,.12); }
    .ag-up-card::before { content:''; position:absolute; left:0; top:0; bottom:0; width:5px; }
    .ag-up-card.upcoming::before { background:linear-gradient(180deg,#10b981,#047857); }
    .ag-up-card.soon::before { background:linear-gradient(180deg,#f59e0b,#b45309); }
    .ag-up-card.today::before { background:linear-gradient(180deg,#dc2626,#7f1d1d); }
    .ag-up-date { flex-shrink:0; width:82px; padding:12px 6px; border-radius:16px; text-align:center; background:linear-gradient(145deg,#ecfdf5,#d1fae5); border:1px solid rgba(16,185,129,.25); }
    .ag-up-date b { display:block; font-family:var(--font-display); font-size:28px; font-weight:900; color:#065f46; line-height:1; }
    .ag-up-date span { display:block; font-size:10px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; color:#059669; margin-top:3px; }
    .ag-up-card.today .ag-up-date { background:linear-gradient(145deg,#fee2e2,#fecaca); border-color:rgba(220,38,38,.25); }
    .ag-up-card.today .ag-up-date b { color:#991b1b; }
    .ag-up-card.today .ag-up-date span { color:#dc2626; }
    .ag-up-card.soon .ag-up-date { background:linear-gradient(145deg,#fef3c7,#fde68a); border-color:rgba(245,158,11,.3); }
    .ag-up-card.soon .ag-up-date b { color:#92400e; }
    .ag-up-card.soon .ag-up-date span { color:#b45309; }
    .ag-up-body { flex:1; min-width:0; }
    .ag-up-title { font-size:16px; font-weight:800; color:var(--ink); margin:0 0 8px; letter-spacing:-.01em; }
    .ag-up-meta { display:flex; gap:14px; flex-wrap:wrap; font-size:12px; color:var(--muted); margin-bottom:10px; }
    .ag-up-meta span { display:inline-flex; align-items:center; gap:5px; }
    .ag-up-countdown { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:12px; }
    .ag-up-cd { background:rgba(5,150,105,.08); border:1px solid rgba(5,150,105,.2); border-radius:10px; padding:6px 10px; text-align:center; min-width:54px; }
    .ag-up-cd b { display:block; font-family:var(--font-display); font-size:16px; font-weight:900; color:#059669; line-height:1; }
    .ag-up-cd span { font-size:8.5px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--muted); margin-top:3px; display:block; }
    .ag-up-card.today .ag-up-cd { background:rgba(220,38,38,.08); border-color:rgba(220,38,38,.2); }
    .ag-up-card.today .ag-up-cd b { color:#dc2626; }
    .ag-up-card.soon .ag-up-cd { background:rgba(245,158,11,.08); border-color:rgba(245,158,11,.25); }
    .ag-up-card.soon .ag-up-cd b { color:#b45309; }
    .ag-up-cta { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:11px; font-size:12.5px; font-weight:800; color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:inset 0 2px 3px rgba(255,255,255,.7), 0 5px 12px rgba(217,164,65,.35); text-decoration:none; transition:all .2s; position:relative; overflow:hidden; }
    .ag-up-cta::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:agShine 3s ease-in-out infinite; }
    .ag-up-cta:hover { transform:translateY(-2px); filter:brightness(1.05); }
    .ag-up-right { display:flex; flex-direction:column; align-items:flex-end; gap:10px; flex-shrink:0; }
    .ag-up-tag { display:inline-flex; align-items:center; gap:5px; padding:4px 11px; border-radius:8px; font-size:10px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; }
    .ag-up-tag.upcoming { background:rgba(16,185,129,.12); color:#047857; border:1px solid rgba(16,185,129,.3); }
    .ag-up-tag.soon { background:rgba(245,158,11,.12); color:#92400e; border:1px solid rgba(245,158,11,.3); animation:agPulse 2s ease-in-out infinite; }
    .ag-up-tag.today { background:rgba(220,38,38,.12); color:#991b1b; border:1px solid rgba(220,38,38,.3); animation:agPulse 1.4s ease-in-out infinite; }

    /* ===== CALENDAR ===== */
    .ag-cal-wrap { background:var(--surface); border:1px solid var(--border); border-radius:22px; padding:18px; box-shadow:0 10px 30px rgba(3,37,31,.06); }
    .ag-cal-dow { display:grid; grid-template-columns:repeat(7,1fr); gap:8px; margin-bottom:8px; }
    .ag-cal-dow span { text-align:center; font-size:10.5px; font-weight:900; letter-spacing:.14em; text-transform:uppercase; color:var(--muted); padding:6px 0; }
    .ag-cal-dow span.wk { color:#dc2626; }
    .ag-cal-grid { display:grid; grid-template-columns:repeat(7,1fr); gap:8px; }
    .ag-cal-cell { position:relative; min-height:104px; border-radius:12px; background:rgba(5,150,105,.03); border:1px solid rgba(5,150,105,.08); padding:8px; display:flex; flex-direction:column; gap:5px; transition:all .2s; }
    .ag-cal-cell:hover { border-color:rgba(217,164,65,.45); background:rgba(217,164,65,.04); transform:translateY(-2px); }
    .ag-cal-cell.wknd { background:rgba(220,38,38,.02); border-color:rgba(220,38,38,.08); }
    .ag-cal-cell.blank { background:transparent; border-color:transparent; pointer-events:none; }
    .ag-cal-cell.today { border-color:#059669; background:rgba(5,150,105,.08); box-shadow:0 0 0 1px rgba(5,150,105,.35), 0 8px 18px rgba(5,150,105,.18); }
    .ag-cal-num { font-family:var(--font-display); font-size:13px; font-weight:900; color:var(--ink); width:26px; height:26px; display:flex; align-items:center; justify-content:center; border-radius:8px; flex-shrink:0; }
    .ag-cal-cell.wknd .ag-cal-num { color:rgba(220,38,38,.6); }
    .ag-cal-cell.today .ag-cal-num { background:linear-gradient(145deg,#10b981,#059669); color:#fff; box-shadow:0 3px 8px rgba(5,150,105,.3); }
    .ag-cal-events { display:flex; flex-direction:column; gap:4px; overflow:hidden; }
    .ag-cal-pill { display:block; padding:4px 8px; border-radius:8px; font-size:10.5px; font-weight:700; line-height:1.35; text-decoration:none; border:1px solid; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; transition:all .15s; }
    .ag-cal-pill:hover { filter:brightness(.95); transform:translateX(2px); }
    .ag-cal-more { font-size:9.5px; font-weight:800; color:var(--muted); padding-left:4px; }
    .ag-legend { display:flex; gap:12px; flex-wrap:wrap; margin-top:14px; padding-top:12px; border-top:1px dashed var(--border); }
    .ag-leg { display:inline-flex; align-items:center; gap:6px; font-size:10.5px; font-weight:700; color:var(--muted); }
    .ag-leg i { width:10px; height:10px; border-radius:3px; display:inline-block; }

    /* ===== MONTH CARDS ===== */
    .ag-filter { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:20px; padding:12px; background:var(--surface); border:1px solid var(--border); border-radius:14px; }
    .ag-filter-chip { padding:7px 14px; border-radius:999px; font-size:11.5px; font-weight:800; color:var(--muted); background:transparent; border:1px solid var(--border); cursor:pointer; transition:all .2s; }
    .ag-filter-chip:hover { border-color:#059669; color:#059669; }
    .ag-filter-chip.active { background:linear-gradient(145deg,#10b981,#059669); color:#fff; border-color:transparent; box-shadow:0 4px 10px rgba(5,150,105,.3); }
    .ag-month-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:18px; }
    .ag-card { position:relative; padding:22px; border-radius:20px; background:linear-gradient(160deg,#fff,#f6fcf7 60%,#e9f6ec); border:1px solid var(--border); box-shadow:0 8px 22px rgba(3,37,31,.06); transition:all .3s; overflow:hidden; }
    .ag-card:hover { transform:translateY(-4px); box-shadow:0 18px 40px rgba(3,37,31,.12); }
    .ag-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; }
    .ag-card-top { display:flex; gap:16px; align-items:flex-start; margin-bottom:14px; }
    .ag-card-day { flex-shrink:0; width:64px; padding:10px 4px; border-radius:14px; text-align:center; background:linear-gradient(145deg,#ecfdf5,#d1fae5); border:1px solid rgba(16,185,129,.3); }
    .ag-card-day b { display:block; font-family:var(--font-display); font-size:24px; font-weight:900; color:#065f46; line-height:1; }
    .ag-card-day span { display:block; font-size:9px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; color:#059669; margin-top:2px; }
    .ag-card-body h3 { font-size:16px; font-weight:800; color:var(--ink); margin:0 0 6px; letter-spacing:-.01em; line-height:1.3; }
    .ag-card-tag { display:inline-block; padding:3px 10px; border-radius:999px; font-size:9.5px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; }
    .ag-card-desc { font-size:13px; color:var(--muted); line-height:1.6; margin:10px 0 14px; }
    .ag-card-info { display:flex; flex-direction:column; gap:6px; margin-bottom:14px; font-size:12px; color:var(--muted); }
    .ag-card-info span { display:inline-flex; align-items:center; gap:6px; }
    .ag-card-info b { color:var(--ink); font-weight:700; }
    .ag-card-actions { display:flex; gap:8px; flex-wrap:wrap; }
    .ag-card-btn { padding:9px 16px; border-radius:10px; font-size:12px; font-weight:800; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:6px; }
    .ag-card-btn-primary { color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:0 4px 10px rgba(217,164,65,.3); }
    .ag-card-btn-primary:hover { transform:translateY(-2px); filter:brightness(1.05); }
    .ag-card-btn-ghost { color:#059669; background:rgba(5,150,105,.08); border:1px solid rgba(5,150,105,.25); }
    .ag-card-btn-ghost:hover { background:rgba(5,150,105,.15); }

    /* ===== EMPTY STATE ===== */
    .ag-empty { text-align:center; padding:60px 24px; border-radius:20px; background:linear-gradient(145deg,rgba(5,150,105,.04),rgba(5,150,105,.01)); border:1px dashed rgba(5,150,105,.25); }
    .ag-empty-ico { font-size:50px; margin-bottom:12px; opacity:.6; }
    .ag-empty h3 { font-family:var(--font-display); font-size:18px; font-weight:900; color:var(--ink); margin:0 0 6px; }
    .ag-empty p { font-size:13.5px; color:var(--muted); margin:0; }

    @media (max-width:768px){
        .ag-up-card { flex-direction:column; align-items:stretch; }
        .ag-up-right { flex-direction:row; align-items:center; justify-content:flex-start; }
        .ag-cal-cell { min-height:70px; }
        .ag-cal-pill { font-size:8.5px; padding:2px 5px; }
        .ag-card-day { width:54px; }
    }
</style>

<!-- ============ HERO ============ -->
<section class="ag-hero">
    <div class="ag-hero-inner">
        <span class="ag-eyebrow">✦ LP3M UNIMOF · Agenda Resmi</span>
        <h1>Agenda Kegiatan Lembaga</h1>
        <p>Jadwal lengkap penelitian, pengabdian, pelatihan, seminar, workshop, dan kegiatan AIK LP3M / LPPAIK UNIMOF — diperbarui real-time.</p>
        <div class="ag-stats">
            <span class="ag-stat">⏳ <b><?= count($upcoming) ?></b> Mendatang</span>
            <span class="ag-stat">📆 <b><?= count($monthEvents) ?></b> Bulan Ini</span>
            <span class="ag-stat">📅 <?= $bulanId[$mM - 1] ?> <?= $mY ?></span>
        </div>
    </div>
</section>

<!-- ============ KEGIATAN MENDATANG ============ -->
<section class="ag-section reveal">
    <div class="ag-head">
        <div>
            <h2><i>⏳</i> Kegiatan Mendatang</h2>
            <div class="ag-sub">Agenda yang akan segera dilaksanakan</div>
        </div>
        <span class="ag-chip">🔔 <?= count($upcoming) ?> acara</span>
    </div>

    <?php if (empty($upcoming)): ?>
    <div class="ag-empty">
        <div class="ag-empty-ico">📭</div>
        <h3>Belum Ada Agenda Mendatang</h3>
        <p>Kegiatan baru akan segera dijadwalkan. Pantau terus halaman ini!</p>
    </div>
    <?php else: ?>
    <div class="ag-upcoming">
        <?php foreach ($upcoming as $u):
            $ts = strtotime($u['start_date'] . ' ' . ($u['start_time'] ?: '08:00'));
            $diff = max(0, $ts - time());
            $days = floor($diff / 86400); $hrs = floor(($diff % 86400) / 3600);
            $min = floor(($diff % 3600) / 60); $sec = $diff % 60;
            $state = $days === 0 ? 'today' : ($days <= 3 ? 'soon' : 'upcoming');
            $tag = $state === 'today' ? 'HARI INI' : ($state === 'soon' ? 'SEGERA' : 'MENDATANG');
            $typeKey = $u['event_type'] ?? 'lainnya';
            [$rgb, $dark] = $typeColor[$typeKey] ?? $typeColor['lainnya'];
            $borderColor = 'style="border-left-color:rgb(' . $rgb . ');"';
        ?>
        <div class="ag-up-card <?= $state ?>" data-end="<?= $ts ?>" style="--c:<?= $rgb ?>">
            <div class="ag-up-date">
                <b><?= date('d', strtotime($u['start_date'])) ?></b>
                <span><?= substr($bulanId[(int) date('n', strtotime($u['start_date'])) - 1], 0, 3) ?></span>
            </div>
            <div class="ag-up-body">
                <h3 class="ag-up-title"><?= e($u['title']) ?></h3>
                <div class="ag-up-meta">
                    <span>📅 <?= e(date('d M Y', strtotime($u['start_date']))) ?></span>
                    <?php if (!empty($u['start_time'])): ?><span>🕐 <?= e(substr($u['start_time'], 0, 5)) ?> WITA</span><?php endif; ?>
                    <span>📍 <?= e($u['location'] ?: 'Akan Diumumkan') ?></span>
                    <span>🏛️ <?= e($u['organizer'] ?: 'LP3M') ?></span>
                </div>
                <div class="ag-up-countdown">
                    <div class="ag-up-cd"><b data-d><?= $days ?></b><span>Hari</span></div>
                    <div class="ag-up-cd"><b data-h><?= $hrs ?></b><span>Jam</span></div>
                    <div class="ag-up-cd"><b data-m><?= $min ?></b><span>Menit</span></div>
                    <div class="ag-up-cd"><b data-s><?= $sec ?></b><span>Detik</span></div>
                </div>
                <?php if (!empty($u['registration_link'])): ?>
                <a class="ag-up-cta" target="_blank" rel="noopener" href="<?= e($u['registration_link']) ?>">📝 Daftar Sekarang →</a>
                <?php endif; ?>
            </div>
            <div class="ag-up-right">
                <span class="ag-up-tag <?= $state ?>"><?= $tag ?></span>
                <span class="ag-card-tag" style="background:rgba(<?= $rgb ?>,.14); color:<?= $dark ?>; border:1px solid rgba(<?= $rgb ?>,.4);">
                    <?= e(CalendarEvent::TYPES[$typeKey] ?? ucfirst($typeKey)) ?>
                </span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>

<!-- ============ CALENDAR ============ -->
<section class="ag-section reveal">
    <div class="ag-head">
        <div>
            <h2><i>📆</i> Kalender <?= $bulanId[$mM - 1] ?> <?= $mY ?></h2>
            <div class="ag-sub">Tampilan kalender bulanan dengan indikator jenis kegiatan</div>
        </div>
        <div class="ag-nav">
            <a class="ag-nav-btn" href="?page=agenda&month=<?= e($prevM) ?>" title="Bulan sebelumnya">◀</a>
            <span class="ag-nav-label"><?= $bulanId[$mM - 1] ?> <?= $mY ?></span>
            <a class="ag-nav-btn" href="?page=agenda&month=<?= e($nextM) ?>" title="Bulan berikutnya">▶</a>
            <a class="ag-nav-today" href="?page=agenda&month=<?= e(date('Y-m')) ?>">🎯 Hari Ini</a>
        </div>
    </div>

    <div class="ag-cal-wrap">
        <div class="ag-cal-dow">
            <span class="wk">Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span class="wk">Sab</span>
        </div>
        <div class="ag-cal-grid">
            <?php for ($i = 0; $i < $firstDow; $i++): ?><div class="ag-cal-cell blank"></div><?php endfor; ?>
            <?php for ($d = 1; $d <= $daysIn; $d++):
                $dow = (int) date('w', mktime(0, 0, 0, $mM, $d, $mY));
                $isToday = ($mY === $todayY && $mM === $todayM && $d === $todayJ);
                $evs = $map[$d] ?? [];
            ?>
            <div class="ag-cal-cell <?= $isToday ? 'today' : '' ?> <?= ($dow === 0 || $dow === 6) ? 'wknd' : '' ?>">
                <span class="ag-cal-num"><?= $d ?></span>
                <div class="ag-cal-events">
                    <?php foreach (array_slice($evs, 0, 3) as $ev):
                        $k = $ev['event_type'] ?? 'lainnya';
                        [$rgb, $dark] = $typeColor[$k] ?? $typeColor['lainnya'];
                    ?>
                    <a class="ag-cal-pill" href="#ev-<?= (int) $ev['id'] ?>"
                       style="background:rgba(<?= $rgb ?>,.16); border-color:rgba(<?= $rgb ?>,.5); color:<?= $dark ?>;"
                       title="<?= e($ev['title']) ?><?= !empty($ev['start_time']) ? ' · ' . e(substr($ev['start_time'], 0, 5)) : '' ?>">
                        <?= !empty($ev['start_time']) ? e(substr($ev['start_time'], 0, 5)) . ' ' : '' ?><?= e($ev['title']) ?>
                    </a>
                    <?php endforeach; ?>
                    <?php if (count($evs) > 3): ?><span class="ag-cal-more">+<?= count($evs) - 3 ?> lagi</span><?php endif; ?>
                </div>
            </div>
            <?php endfor; ?>
            <?php $trail = (7 - (($firstDow + $daysIn) % 7)) % 7; for ($i = 0; $i < $trail; $i++): ?><div class="ag-cal-cell blank"></div><?php endfor; ?>
        </div>
        <div class="ag-legend">
            <?php foreach ($typeColor as $key => [$rgb, $dark]): ?>
            <span class="ag-leg"><i style="background:rgb(<?= $rgb ?>);"></i><?= e(CalendarEvent::TYPES[$key] ?? ucfirst($key)) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ DAFTAR AGENDA BULAN INI ============ -->
<section class="ag-section reveal">
    <div class="ag-head">
        <div>
            <h2><i>📋</i> Daftar Agenda Bulan Ini</h2>
            <div class="ag-sub">Detail lengkap kegiatan pada <?= $bulanId[$mM - 1] ?> <?= $mY ?></div>
        </div>
        <span class="ag-chip">🗂️ <?= count($monthEvents) ?> kegiatan</span>
    </div>

    <?php if (!empty($monthEvents)): ?>
    <!-- FILTER PILLS -->
    <div class="ag-filter" id="ag-filter">
        <button type="button" class="ag-filter-chip active" data-type="">Semua</button>
        <?php foreach ($typesAll as $k => $l): ?>
        <button type="button" class="ag-filter-chip" data-type="<?= e($k) ?>"><?= e($l) ?></button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (empty($monthEvents)): ?>
    <div class="ag-empty">
        <div class="ag-empty-ico">📅</div>
        <h3>Tidak Ada Kegiatan Bulan Ini</h3>
        <p>Coba pindah ke bulan lain menggunakan tombol navigasi di atas.</p>
    </div>
    <?php else: ?>
    <div class="ag-month-grid" id="ag-grid">
        <?php foreach ($monthEvents as $ev):
            $k = $ev['event_type'] ?? 'lainnya';
            [$rgb, $dark] = $typeColor[$k] ?? $typeColor['lainnya'];
        ?>
        <div class="ag-card" id="ev-<?= (int) $ev['id'] ?>" data-type="<?= e($k) ?>"
             style="--c:<?= $rgb ?>;">
            <div style="position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg, rgb(<?= $rgb ?>), rgb(<?= $rgb ?>,.5));"></div>
            <div class="ag-card-top">
                <div class="ag-card-day">
                    <b><?= date('d', strtotime($ev['start_date'])) ?></b>
                    <span><?= substr($bulanId[(int) date('n', strtotime($ev['start_date'])) - 1], 0, 3) ?></span>
                </div>
                <div class="ag-card-body">
                    <span class="ag-card-tag" style="background:rgba(<?= $rgb ?>,.14); color:<?= $dark ?>; border:1px solid rgba(<?= $rgb ?>,.4); margin-bottom:8px;">
                        <?= e(CalendarEvent::TYPES[$k] ?? ucfirst($k)) ?>
                    </span>
                    <h3><?= e($ev['title']) ?></h3>
                </div>
            </div>
            <?php if (!empty($ev['description'])): ?>
            <p class="ag-card-desc"><?= e(excerpt($ev['description'], 130)) ?></p>
            <?php endif; ?>
            <div class="ag-card-info">
                <span>📅 <b><?= e(date('d M Y', strtotime($ev['start_date']))) ?></b>
                    <?php if (!empty($ev['end_date']) && $ev['end_date'] !== $ev['start_date']): ?> – <?= e(date('d M Y', strtotime($ev['end_date']))) ?><?php endif; ?>
                </span>
                <?php if (!empty($ev['start_time'])): ?>
                <span>🕐 <b><?= e(substr($ev['start_time'], 0, 5)) ?><?= !empty($ev['end_time']) ? ' – ' . e(substr($ev['end_time'], 0, 5)) : '' ?></b> WITA</span>
                <?php endif; ?>
                <span>📍 <?= e($ev['location'] ?: 'Akan Diumumkan') ?></span>
                <span>🏛️ <?= e($ev['organizer'] ?: 'LP3M UNIMOF') ?></span>
                <?php if ((int) ($ev['max_participants'] ?? 0) > 0): ?>
                <span>👥 Kuota <b><?= (int) $ev['max_participants'] ?></b> peserta</span>
                <?php endif; ?>
            </div>
            <div class="ag-card-actions">
                <?php if (!empty($ev['registration_link'])): ?>
                <a class="ag-card-btn ag-card-btn-primary" target="_blank" rel="noopener" href="<?= e($ev['registration_link']) ?>">📝 Daftar Sekarang</a>
                <?php endif; ?>
                <a class="ag-card-btn ag-card-btn-ghost" href="?page=agenda&month=<?= e($month) ?>&event=<?= (int) $ev['id'] ?>#ev-<?= (int) $ev['id'] ?>">ℹ️ Detail</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>

<script>
(function(){
    // Countdown real-time
    var cards = document.querySelectorAll('.ag-up-card');
    if (cards.length) {
        setInterval(function(){
            cards.forEach(function(c){
                var end = parseInt(c.dataset.end, 10) * 1000;
                var diff = Math.max(0, end - Date.now());
                var d = Math.floor(diff / 86400000);
                var h = Math.floor((diff % 86400000) / 3600000);
                var m = Math.floor((diff % 3600000) / 60000);
                var s = Math.floor((diff % 60000) / 1000);
                var de = c.querySelector('[data-d]'), he = c.querySelector('[data-h]');
                var me = c.querySelector('[data-m]'), se = c.querySelector('[data-s]');
                if (de) de.textContent = d;
                if (he) he.textContent = h;
                if (me) me.textContent = m;
                if (se) se.textContent = s;
            });
        }, 1000);
    }

    // Filter pills
    var chips = document.querySelectorAll('.ag-filter-chip');
    var items = document.querySelectorAll('#ag-grid .ag-card');
    chips.forEach(function(chip){
        chip.addEventListener('click', function(){
            chips.forEach(function(c){ c.classList.remove('active'); });
            chip.classList.add('active');
            var type = chip.dataset.type;
            items.forEach(function(it){
                it.style.display = (type === '' || it.dataset.type === type) ? '' : 'none';
            });
        });
    });

    // Smooth scroll ke card jika ada hash #ev-ID
    if (window.location.hash && window.location.hash.startsWith('#ev-')) {
        var target = document.querySelector(window.location.hash);
        if (target) setTimeout(function(){ target.scrollIntoView({behavior:'smooth', block:'center'}); target.animate([{boxShadow:'0 0 0 0 rgba(217,164,65,.5)'},{boxShadow:'0 0 0 12px rgba(217,164,65,0)'}], {duration:1200}); }, 300);
    }
})();
</script>