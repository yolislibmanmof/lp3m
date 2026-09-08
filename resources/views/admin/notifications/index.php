<?php
$catColor = [
    'info'     => ['#3b82f6', '#93c5fd'],
    'success'  => ['#10b981', '#6ee7b7'],
    'warning'  => ['#f59e0b', '#fcd34d'],
    'error'    => ['#dc2626', '#fca5a5'],
    'reminder' => ['#8b5cf6', '#c4b5fd'],
];
$catLabel = [
    'info' => '📢 Info', 'success' => '✅ Sukses', 'warning' => '⚠️ Peringatan',
    'error' => '❌ Error', 'reminder' => '🔔 Reminder',
];

// Helper waktu relatif
function nt_timeAgo(string $date): string {
    $diff = time() - strtotime($date);
    if ($diff < 60) return 'Baru saja';
    if ($diff < 3600) return floor($diff / 60) . ' menit lalu';
    if ($diff < 86400) return floor($diff / 3600) . ' jam lalu';
    if ($diff < 172800) return 'Kemarin';
    if ($diff < 604800) return floor($diff / 86400) . ' hari lalu';
    return date('d M Y', strtotime($date));
}

// Grouping by date
$groups = [];
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
$weekAgo = date('Y-m-d', strtotime('-7 days'));

foreach ($items as $n) {
    $d = date('Y-m-d', strtotime($n['created_at']));
    if ($d === $today) $g = 'Hari Ini';
    elseif ($d === $yesterday) $g = 'Kemarin';
    elseif ($d >= $weekAgo) $g = 'Minggu Ini';
    else $g = 'Lebih Lama';
    $groups[$g][] = $n;
}
$groupOrder = ['Hari Ini', 'Kemarin', 'Minggu Ini', 'Lebih Lama'];

// Filter stats
$unreadCount = $stats['unread'] ?? 0;
$todayCount = $stats['today'] ?? 0;
$totalCount = $stats['total'] ?? count($items);
$readCount = $totalCount - $unreadCount;
?>
<style>
    @keyframes ntFade { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:none; } }
    @keyframes ntPulse { 0%,100%{box-shadow:0 0 0 0 rgba(217,164,65,.4)} 50%{box-shadow:0 0 0 8px rgba(217,164,65,0)} }
    @keyframes ntShine { 0%,55%{left:-90%} 100%{left:165%} }

    .nt-wrap { max-width:1100px; margin:0 auto; padding:0 20px; }

    /* ===== HERO ===== */
    .nt-hero { position:relative; overflow:hidden; border-radius:28px; padding:50px 46px; margin-bottom:26px; color:#fff; background:linear-gradient(135deg,#312e81 0%,#4338ca 55%,#6366f1 100%); box-shadow:0 26px 64px rgba(49,46,129,.4); animation:ntFade .6s cubic-bezier(.16,1,.3,1) both; }
    .nt-hero::before { content:''; position:absolute; inset:0; opacity:.35; background-image:repeating-linear-gradient(45deg,transparent,transparent 28px,rgba(253,230,138,.06) 28px,rgba(253,230,138,.06) 29px),repeating-linear-gradient(-45deg,transparent,transparent 28px,rgba(253,230,138,.06) 28px,rgba(253,230,138,.06) 29px); pointer-events:none; }
    .nt-hero::after { content:''; position:absolute; top:-40%; right:-8%; width:500px; height:500px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.3),transparent 70%); pointer-events:none; }
    .nt-hero-inner { position:relative; z-index:2; }
    .nt-eyebrow { display:inline-flex; align-items:center; gap:7px; padding:5px 14px; border-radius:999px; margin-bottom:16px; font-size:10.5px; font-weight:900; letter-spacing:.16em; text-transform:uppercase; background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.3); color:#fde68a; }
    .nt-hero h1 { font-family:var(--font-display); font-size:clamp(28px,4vw,42px); font-weight:900; margin:0 0 10px; letter-spacing:-.025em; background:linear-gradient(135deg,#fff,#fde68a 55%,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .nt-hero p { opacity:.92; max-width:640px; font-size:15px; line-height:1.7; margin:0 0 24px; }
    .nt-stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:12px; }
    .nt-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); border-radius:16px; padding:16px 20px; backdrop-filter:blur(10px); position:relative; overflow:hidden; }
    .nt-stat::after { content:''; position:absolute; top:-40px; right:-30px; width:110px; height:110px; border-radius:50%; background:radial-gradient(circle,rgba(253,230,138,.2),transparent 70%); pointer-events:none; }
    .nt-stat b { display:block; font-family:var(--font-display); font-size:24px; font-weight:900; color:#fde68a; line-height:1; position:relative; z-index:1; }
    .nt-stat b.white { color:#fff; }
    .nt-stat span { display:block; font-size:9.5px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; opacity:.88; margin-top:5px; position:relative; z-index:1; }
    .nt-stat.unread b { animation:ntPulse 2s ease-in-out infinite; }

    /* ===== CONTROLS ===== */
    .nt-controls { display:flex; gap:12px; flex-wrap:wrap; align-items:center; margin-bottom:20px; padding:14px 18px; background:var(--surface); border:1px solid var(--border); border-radius:16px; animation:ntFade .55s .08s both; }
    .nt-filter-chips { display:flex; gap:8px; flex-wrap:wrap; flex:1; }
    .nt-chip { padding:8px 16px; border-radius:999px; border:1px solid var(--border); background:var(--white); font-size:12.5px; font-weight:800; color:var(--text); cursor:pointer; transition:all .25s; display:inline-flex; align-items:center; gap:6px; }
    .nt-chip:hover { border-color:rgba(99,102,241,.4); color:#6366f1; transform:translateY(-2px); }
    .nt-chip.active { background:linear-gradient(145deg,#6366f1,#4f46e5); color:#fff; border-color:transparent; box-shadow:0 6px 14px rgba(99,102,241,.35); }
    .nt-chip b { background:rgba(255,255,255,.2); padding:1px 8px; border-radius:999px; font-size:10px; margin-left:4px; }
    .nt-chip.active b { background:rgba(255,255,255,.3); color:#fff; }
    .nt-search { position:relative; min-width:260px; }
    .nt-search input { width:100%; padding:10px 14px 10px 38px; border-radius:11px; border:1px solid var(--border); background:var(--white); font-size:13px; font-weight:600; color:var(--ink); transition:all .25s; }
    .nt-search::before { content:'🔍'; position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:13px; opacity:.5; }
    .nt-search input:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 4px rgba(99,102,241,.12); }

    /* ===== BULK BAR ===== */
    .nt-bulk { display:none; gap:10px; align-items:center; padding:12px 18px; background:linear-gradient(135deg,rgba(217,164,65,.12),rgba(217,164,65,.04)); border:1px solid rgba(217,164,65,.35); border-radius:14px; margin-bottom:16px; animation:ntFade .4s both; }
    .nt-bulk.show { display:flex; }
    .nt-bulk-info { flex:1; font-size:13px; font-weight:800; color:#92400e; }
    .nt-bulk-info b { color:#78350f; }
    .nt-bulk-btn { padding:8px 16px; border-radius:10px; border:none; font-size:12px; font-weight:800; cursor:pointer; transition:all .2s; display:inline-flex; align-items:center; gap:6px; }
    .nt-bulk-btn.primary { background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); color:#03251f; box-shadow:0 4px 10px rgba(217,164,65,.3); }
    .nt-bulk-btn.ghost { background:transparent; color:var(--muted); border:1px solid var(--border); }
    .nt-bulk-btn:hover { transform:translateY(-2px); }

    /* ===== MARK ALL ===== */
    .nt-mark-all { display:inline-flex; align-items:center; gap:8px; padding:9px 18px; border-radius:11px; font-size:12.5px; font-weight:800; color:#6366f1; background:rgba(99,102,241,.08); border:1px solid rgba(99,102,241,.3); text-decoration:none; transition:all .25s; }
    .nt-mark-all:hover { background:rgba(99,102,241,.14); transform:translateY(-2px); box-shadow:0 6px 14px rgba(99,102,241,.15); }

    /* ===== GROUP ===== */
    .nt-group { margin-bottom:26px; }
    .nt-group-head { display:flex; align-items:center; gap:10px; padding:8px 14px; background:var(--surface); border:1px solid var(--border); border-radius:11px; margin-bottom:12px; font-size:11px; font-weight:900; letter-spacing:.12em; text-transform:uppercase; color:var(--muted); }
    .nt-group-head b { color:var(--ink); margin-right:4px; }
    .nt-group-count { margin-left:auto; padding:2px 10px; border-radius:999px; background:rgba(255,255,255,.06); font-size:10px; }

    /* ===== ITEM ===== */
    .nt-item { display:flex; gap:14px; align-items:flex-start; padding:16px 18px; border-radius:16px; border:1px solid var(--border); background:var(--white); margin-bottom:10px; transition:all .25s; position:relative; overflow:hidden; opacity:0; transform:translateY(14px); }
    .nt-item.in { opacity:1; transform:translateY(0); transition:opacity .5s, transform .5s, box-shadow .25s, border-color .25s; }
    .nt-item.in:hover { transform:translateX(4px); box-shadow:0 8px 20px rgba(99,102,241,.1); border-color:rgba(99,102,241,.25); }
    .nt-item::before { content:''; position:absolute; left:0; top:0; bottom:0; width:4px; }
    .nt-item.cat-info::before { background:#3b82f6; }
    .nt-item.cat-success::before { background:#10b981; }
    .nt-item.cat-warning::before { background:#f59e0b; }
    .nt-item.cat-error::before { background:#dc2626; }
    .nt-item.cat-reminder::before { background:#8b5cf6; }
    .nt-item.unread { background:linear-gradient(90deg,rgba(217,164,65,.08),var(--white) 40%); border-color:rgba(217,164,65,.3); }
    .nt-item.unread::after { content:''; position:absolute; top:14px; right:14px; width:8px; height:8px; border-radius:50%; background:#d9a441; box-shadow:0 0 0 3px rgba(217,164,65,.25); animation:ntPulse 2s infinite; }
    .nt-item.hidden { display:none; }

    .nt-check { flex-shrink:0; width:20px; height:20px; border-radius:6px; border:2px solid var(--border); cursor:pointer; margin-top:12px; position:relative; transition:all .2s; background:transparent; }
    .nt-check:hover { border-color:#6366f1; }
    .nt-check.checked { background:linear-gradient(145deg,#6366f1,#4f46e5); border-color:transparent; }
    .nt-check.checked::after { content:'✓'; position:absolute; inset:0; display:flex; align-items:center; justify-content:center; color:#fff; font-size:12px; font-weight:900; }

    .nt-ico { width:44px; height:44px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:19px; flex-shrink:0; border:1px solid var(--border); }
    .nt-ico.cat-info { background:rgba(59,130,246,.12); color:#1e40af; }
    .nt-ico.cat-success { background:rgba(16,185,129,.12); color:#047857; }
    .nt-ico.cat-warning { background:rgba(245,158,11,.12); color:#92400e; }
    .nt-ico.cat-error { background:rgba(220,38,38,.12); color:#991b1b; }
    .nt-ico.cat-reminder { background:rgba(139,92,246,.12); color:#5b21b6; }

    .nt-body { flex:1; min-width:0; cursor:pointer; }
    .nt-head { display:flex; align-items:center; gap:8px; margin-bottom:4px; flex-wrap:wrap; }
    .nt-title { font-size:14px; font-weight:800; color:var(--ink); }
    .nt-unread-dot { display:inline-block; width:6px; height:6px; border-radius:50%; background:#d9a441; }
    .nt-cat { padding:2px 9px; border-radius:999px; font-size:9px; font-weight:900; letter-spacing:.06em; text-transform:uppercase; color:#fff; }
    .nt-msg { margin:4px 0 6px; font-size:13px; color:var(--muted); line-height:1.55; }
    .nt-time { font-size:11px; color:var(--muted); font-weight:700; display:inline-flex; align-items:center; gap:5px; }
    .nt-time.new { color:#6366f1; font-weight:800; }

    .nt-actions { display:flex; gap:6px; flex-shrink:0; align-items:flex-start; }
    .nt-btn { padding:8px 14px; border-radius:10px; font-size:12px; font-weight:800; text-decoration:none; cursor:pointer; border:1px solid var(--border); background:var(--white); color:var(--muted); transition:all .2s; display:inline-flex; align-items:center; gap:5px; }
    .nt-btn:hover { transform:translateY(-2px); }
    .nt-btn.primary { background:linear-gradient(145deg,#6366f1,#4f46e5); color:#fff; border-color:transparent; box-shadow:0 4px 10px rgba(99,102,241,.25); }
    .nt-btn.read { background:rgba(16,185,129,.08); color:#047857; border-color:rgba(16,185,129,.3); }
    .nt-btn.danger { background:rgba(220,38,38,.06); color:#dc2626; border-color:rgba(220,38,38,.25); }
    .nt-btn.danger:hover { background:rgba(220,38,38,.12); }

    /* ===== EMPTY ===== */
    .nt-empty { text-align:center; padding:70px 24px; background:linear-gradient(145deg,rgba(99,102,241,.05),rgba(99,102,241,.01)); border:2px dashed rgba(99,102,241,.3); border-radius:22px; animation:ntFade .6s both; }
    .nt-empty-ico { font-size:56px; margin-bottom:12px; opacity:.7; }
    .nt-empty h3 { font-family:var(--font-display); font-size:20px; font-weight:900; color:var(--ink); margin:0 0 8px; }
    .nt-empty p { font-size:14px; color:var(--muted); margin:0; max-width:420px; margin-left:auto; margin-right:auto; }

    @media(max-width:768px){
        .nt-stats { grid-template-columns:1fr 1fr; }
        .nt-controls { flex-direction:column; align-items:stretch; }
        .nt-search { min-width:100%; }
        .nt-actions { flex-direction:column; }
        .nt-item { flex-wrap:wrap; }
        .nt-body { flex-basis:100%; order:3; }
    }
</style>

<div class="nt-wrap">
    <!-- ===== HERO ===== -->
    <section class="nt-hero">
        <div class="nt-hero-inner">
            <span class="nt-eyebrow">🔔 Pusat Informasi Admin</span>
            <h1>Pusat Notifikasi</h1>
            <p>Pantau aktivitas sistem, pemberitahuan kegiatan, reminder tugas, dan notifikasi penting lainnya dalam satu tampilan terpusat.</p>
            <div class="nt-stats">
                <div class="nt-stat"><b class="white"><?= number_format($totalCount) ?></b><span>Total Notifikasi</span></div>
                <div class="nt-stat unread"><b><?= number_format($unreadCount) ?></b><span>Belum Dibaca</span></div>
                <div class="nt-stat"><b class="white"><?= number_format($todayCount) ?></b><span>Hari Ini</span></div>
                <div class="nt-stat"><b class="white"><?= number_format($readCount) ?></b><span>Sudah Dibaca</span></div>
            </div>
        </div>
    </section>

    <?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
    </div>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <div class="nt-empty">
            <div class="nt-empty-ico">🔕</div>
            <h3>Belum Ada Notifikasi</h3>
            <p>Semua aktivitas sistem akan tampil di sini. Anda sudah melihat semua!</p>
        </div>
    <?php else: ?>

        <!-- ===== CONTROLS ===== -->
        <div class="nt-controls">
            <div class="nt-filter-chips">
                <button type="button" class="nt-chip active" data-filter="all">✨ Semua <b><?= $totalCount ?></b></button>
                <button type="button" class="nt-chip" data-filter="unread">🔔 Belum Dibaca <b><?= $unreadCount ?></b></button>
                <button type="button" class="nt-chip" data-filter="today">📅 Hari Ini <b><?= $todayCount ?></b></button>
                <button type="button" class="nt-chip" data-filter="info">📢 Info</button>
                <button type="button" class="nt-chip" data-filter="warning">⚠️ Peringatan</button>
                <button type="button" class="nt-chip" data-filter="error">❌ Error</button>
            </div>
            <div class="nt-search">
                <input type="text" id="nt-search" placeholder="Cari notifikasi...">
            </div>
        </div>

        <!-- ===== BULK ACTION BAR ===== -->
        <div class="nt-bulk" id="nt-bulk">
            <span class="nt-bulk-info"><b id="nt-bulk-count">0</b> notifikasi dipilih</span>
            <form method="post" action="<?= e(url('admin/index.php?page=notifikasi-bulk-baca')) ?>" id="nt-bulk-form" style="display:flex; gap:8px;">
                <?= csrf_field() ?>
                <div id="nt-bulk-inputs"></div>
                <button type="submit" class="nt-bulk-btn primary">✅ Tandai Dibaca</button>
                <button type="button" class="nt-bulk-btn ghost" id="nt-bulk-clear">Batal</button>
            </form>
        </div>

        <!-- ===== MARK ALL ===== -->
        <?php if ($unreadCount > 0): ?>
        <div style="display:flex; justify-content:flex-end; margin-bottom:14px;">
            <a class="nt-mark-all" href="<?= e(url('admin/index.php?page=notifikasi-baca-semua')) ?>">✅ Tandai Semua Dibaca (<?= $unreadCount ?>)</a>
        </div>
        <?php endif; ?>

        <!-- ===== GROUPS ===== -->
        <?php foreach ($groupOrder as $gname): 
            if (empty($groups[$gname])) continue;
            $gitems = $groups[$gname];
        ?>
        <div class="nt-group" data-group="<?= e($gname) ?>">
            <div class="nt-group-head">
                <span><?= $gname === 'Hari Ini' ? '📅' : ($gname === 'Kemarin' ? '📆' : ($gname === 'Minggu Ini' ? '🗓️' : '📂')) ?></span>
                <b><?= e($gname) ?></b>
                <span style="color:var(--muted); text-transform:none; letter-spacing:0; font-weight:700;"><?= count($gitems) ?> notifikasi</span>
            </div>
            <?php foreach ($gitems as $n): 
                $cat = $n['category'] ?? 'info';
                [$catPrimary, $catLight] = $catColor[$cat] ?? $catColor['info'];
                $label = $catLabel[$cat] ?? ucfirst($cat);
                $isUnread = !$n['is_read'];
                $relativeTime = nt_timeAgo($n['created_at']);
            ?>
            <div class="nt-item <?= $isUnread ? 'unread' : '' ?> cat-<?= e($cat) ?>"
                 data-read="<?= $isUnread ? '0' : '1' ?>"
                 data-cat="<?= e($cat) ?>"
                 data-date="<?= e(date('Y-m-d', strtotime($n['created_at']))) ?>"
                 data-text="<?= e(strtolower($n['title'] . ' ' . $n['message'])) ?>"
                 data-id="<?= (int) $n['id'] ?>">
                <button type="button" class="nt-check" data-id="<?= (int) $n['id'] ?>" title="Pilih"></button>
                <div class="nt-ico cat-<?= e($cat) ?>"><?= e($n['icon'] ?: '🔔') ?></div>
                <div class="nt-body" data-link="<?= !empty($n['link']) ? e(url('admin/index.php?page=notifikasi-baca&id=' . $n['id'] . '&goto=' . urlencode($n['link']))) : ($isUnread ? e(url('admin/index.php?page=notifikasi-baca&id=' . $n['id'])) : '') ?>">
                    <div class="nt-head">
                        <span class="nt-title"><?= e($n['title']) ?></span>
                        <span class="nt-cat" style="background:<?= $catPrimary ?>;"><?= e($label) ?></span>
                    </div>
                    <div class="nt-msg"><?= e($n['message']) ?></div>
                    <span class="nt-time <?= $isUnread ? 'new' : '' ?>">
                        🕐 <?= e($relativeTime) ?><?= $isUnread && $relativeTime !== 'Baru saja' ? ' · <b>BARU</b>' : '' ?>
                    </span>
                </div>
                <div class="nt-actions">
                    <?php if (!empty($n['link'])): ?>
                        <a class="nt-btn primary" href="<?= e(url('admin/index.php?page=notifikasi-baca&id=' . $n['id'] . '&goto=' . urlencode($n['link']))) ?>">Buka →</a>
                    <?php elseif ($isUnread): ?>
                        <a class="nt-btn read" href="<?= e(url('admin/index.php?page=notifikasi-baca&id=' . $n['id'])) ?>">✓ Baca</a>
                    <?php endif; ?>
                    <form method="post" action="<?= e(url('admin/index.php?page=notifikasi-hapus')) ?>" style="display:inline" onsubmit="return confirm('Hapus notifikasi ini?');">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= (int) $n['id'] ?>">
                        <button class="nt-btn danger" type="submit" title="Hapus">🗑️</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
(function(){
    var items = Array.prototype.slice.call(document.querySelectorAll('.nt-item'));
    var chips = document.querySelectorAll('.nt-chip');
    var search = document.getElementById('nt-search');
    var bulk = document.getElementById('nt-bulk');
    var bulkCount = document.getElementById('nt-bulk-count');
    var bulkInputs = document.getElementById('nt-bulk-inputs');
    var bulkClear = document.getElementById('nt-bulk-clear');
    var selected = new Set();

    // Filter + search
    function applyFilter(){
        var filter = document.querySelector('.nt-chip.active').dataset.filter;
        var q = (search ? search.value : '').toLowerCase().trim();
        var today = '<?= date('Y-m-d') ?>';
        var shown = 0;
        items.forEach(function(it){
            var match = true;
            if (filter === 'unread' && it.dataset.read !== '0') match = false;
            if (filter === 'today' && it.dataset.date !== today) match = false;
            if (['info','warning','error','success','reminder'].indexOf(filter) !== -1 && it.dataset.cat !== filter) match = false;
            if (q && it.dataset.text.indexOf(q) === -1) match = false;
            if (match) { it.classList.remove('hidden'); shown++; }
            else it.classList.add('hidden');
        });
        // Hide empty groups
        document.querySelectorAll('.nt-group').forEach(function(g){
            var visible = g.querySelectorAll('.nt-item:not(.hidden)').length;
            g.style.display = visible === 0 ? 'none' : '';
        });
    }
    chips.forEach(function(c){ c.addEventListener('click', function(){
        chips.forEach(function(x){ x.classList.remove('active'); });
        c.classList.add('active');
        applyFilter();
    }); });
    if (search) search.addEventListener('input', applyFilter);

    // Klik body → buka link atau tandai baca
    document.querySelectorAll('.nt-body').forEach(function(b){
        b.addEventListener('click', function(){
            var link = b.dataset.link;
            if (link) window.location.href = link;
        });
    });

    // Checkbox bulk select
    document.querySelectorAll('.nt-check').forEach(function(ch){
        ch.addEventListener('click', function(e){
            e.stopPropagation();
            var id = ch.dataset.id;
            if (selected.has(id)) {
                selected.delete(id);
                ch.classList.remove('checked');
            } else {
                selected.add(id);
                ch.classList.add('checked');
            }
            updateBulk();
        });
    });

    function updateBulk(){
        bulkCount.textContent = selected.size;
        if (selected.size > 0) bulk.classList.add('show');
        else bulk.classList.remove('show');
        bulkInputs.innerHTML = '';
        selected.forEach(function(id){
            var inp = document.createElement('input');
            inp.type = 'hidden';
            inp.name = 'ids[]';
            inp.value = id;
            bulkInputs.appendChild(inp);
        });
    }
    if (bulkClear) bulkClear.addEventListener('click', function(){
        selected.clear();
        document.querySelectorAll('.nt-check.checked').forEach(function(c){ c.classList.remove('checked'); });
        updateBulk();
    });

    // Reveal on scroll
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(entries){
            entries.forEach(function(en){
                if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
            });
        }, { threshold: 0.08 });
        items.forEach(function(it){ io.observe(it); });
    } else {
        items.forEach(function(it){ it.classList.add('in'); });
    }
})();
</script>