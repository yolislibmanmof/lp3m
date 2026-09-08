<style>
    @keyframes gxFadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:none} }
    @keyframes gxZoomIn { from{opacity:0;transform:scale(.92)} to{opacity:1;transform:scale(1)} }

    .gx-wrap { max-width:1200px; margin:0 auto; padding:0 20px; }

    /* ===== HERO ===== */
    .gx-hero { position:relative; overflow:hidden; border-radius:28px; padding:58px 46px; margin-bottom:30px; color:#fff; background:linear-gradient(135deg,#4c1d95 0%,#6d28d9 50%,#7c3aed 100%); box-shadow:0 26px 64px rgba(76,29,149,.35); animation:gxFadeUp .6s cubic-bezier(.16,1,.3,1) both; }
    .gx-hero::before { content:''; position:absolute; inset:0; opacity:.4; background-image:repeating-linear-gradient(45deg,transparent,transparent 28px,rgba(255,255,255,.05) 28px,rgba(255,255,255,.05) 29px),repeating-linear-gradient(-45deg,transparent,transparent 28px,rgba(255,255,255,.05) 28px,rgba(255,255,255,.05) 29px); pointer-events:none; }
    .gx-hero::after { content:''; position:absolute; top:-40%; right:-8%; width:480px; height:480px; border-radius:50%; background:radial-gradient(circle,rgba(253,230,138,.28),transparent 70%); pointer-events:none; }
    .gx-hero-inner { position:relative; z-index:2; }
    .gx-eyebrow { display:inline-flex; align-items:center; gap:7px; padding:5px 14px; border-radius:999px; margin-bottom:16px; font-size:10.5px; font-weight:900; letter-spacing:.16em; text-transform:uppercase; background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.3); color:#ede9fe; }
    .gx-hero h1 { font-family:var(--font-display); font-size:clamp(28px,4vw,44px); font-weight:900; margin:0 0 12px; letter-spacing:-.025em; background:linear-gradient(135deg,#fff,#ede9fe 55%,#c4b5fd); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .gx-hero p { opacity:.92; max-width:640px; font-size:15px; line-height:1.7; margin:0 0 24px; }
    .gx-stats { display:flex; gap:10px; flex-wrap:wrap; }
    .gx-stat { display:inline-flex; align-items:center; gap:9px; padding:9px 16px; border-radius:12px; font-size:12.5px; font-weight:800; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); backdrop-filter:blur(6px); }
    .gx-stat b { font-family:var(--font-display); font-size:16px; font-weight:900; color:#fde68a; }

    /* ===== CHIPS FILTER ===== */
    .gx-chips { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:26px; animation:gxFadeUp .6s .08s both; }
    .gx-chip { padding:9px 18px; border-radius:999px; border:1px solid var(--border); background:linear-gradient(145deg,#ffffff,#f6faf7); font-size:13px; font-weight:800; color:var(--text); text-decoration:none; transition:all .25s; }
    .gx-chip:hover { transform:translateY(-2px); border-color:rgba(124,58,237,.45); color:#6d28d9; box-shadow:0 6px 14px rgba(124,58,237,.15); }
    .gx-chip.active { background:linear-gradient(145deg,#c4b5fd,#a78bfa 50%,#7c3aed); color:#fff; border-color:transparent; box-shadow:0 8px 18px rgba(124,58,237,.35); }

    /* ===== MASONRY GRID ===== */
    .gx-masonry { columns:3; column-gap:20px; }
    @media(max-width:900px){ .gx-masonry{columns:2;} }
    @media(max-width:600px){ .gx-masonry{columns:1;} }
    .gx-item { break-inside:avoid; margin:0 0 20px; border-radius:20px; overflow:hidden; border:1px solid var(--border); background:var(--white); box-shadow:0 6px 18px rgba(3,37,31,.06); cursor:pointer; position:relative; opacity:0; transform:translateY(18px); transition:opacity .6s cubic-bezier(.16,1,.3,1), transform .6s cubic-bezier(.16,1,.3,1), box-shadow .3s; }
    .gx-item.in { opacity:1; transform:translateY(0); }
    .gx-item.in:hover { transform:translateY(-5px); box-shadow:0 20px 40px rgba(3,37,31,.14); }
    .gx-imgwrap { position:relative; overflow:hidden; display:block; }
    .gx-item img { width:100%; display:block; transition:transform .6s; }
    .gx-item:hover img { transform:scale(1.06); }
    .gx-overlay { position:absolute; inset:0; background:linear-gradient(180deg,transparent 45%,rgba(3,37,31,.78)); opacity:0; transition:opacity .3s; display:flex; align-items:flex-end; padding:14px; }
    .gx-item:hover .gx-overlay { opacity:1; }
    .gx-overlay span { color:#fff; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px; }
    .gx-zoom { position:absolute; top:12px; right:12px; width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,.92); display:flex; align-items:center; justify-content:center; font-size:15px; transform:scale(.6); opacity:0; transition:all .3s; box-shadow:0 4px 10px rgba(0,0,0,.2); }
    .gx-item:hover .gx-zoom { transform:scale(1); opacity:1; }
    .gx-cat-badge { position:absolute; top:12px; left:12px; padding:4px 11px; border-radius:999px; font-size:9.5px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; background:rgba(124,58,237,.88); color:#fff; backdrop-filter:blur(4px); }
    .gx-cap { padding:15px 18px; }
    .gx-cap h3 { font-size:15px; font-weight:800; color:var(--ink); margin:0 0 5px; line-height:1.35; }
    .gx-cap span { font-size:11.5px; color:var(--muted); font-weight:700; display:inline-flex; align-items:center; gap:6px; }

    /* ===== EMPTY ===== */
    .gx-empty { text-align:center; padding:64px 24px; background:linear-gradient(145deg,rgba(124,58,237,.05),rgba(124,58,237,.02)); border:2px dashed rgba(124,58,237,.3); border-radius:22px; animation:gxFadeUp .6s both; }
    .gx-empty-ico { font-size:52px; margin-bottom:12px; opacity:.7; }
    .gx-empty h3 { font-family:var(--font-display); font-size:18px; font-weight:900; color:var(--ink); margin:0 0 6px; }
    .gx-empty p { font-size:13.5px; color:var(--muted); margin:0; }

    /* ===== LIGHTBOX ===== */
    .gx-lightbox { position:fixed; inset:0; background:rgba(3,37,31,.92); backdrop-filter:blur(6px); z-index:9999; display:none; align-items:center; justify-content:center; padding:30px; flex-direction:column; gap:14px; }
    .gx-lightbox.show { display:flex; }
    .gx-lightbox img { max-width:90vw; max-height:74vh; border-radius:16px; box-shadow:0 30px 80px rgba(0,0,0,.5); animation:gxZoomIn .35s cubic-bezier(.16,1,.3,1) both; }
    .gx-lb-cap { color:#fff; text-align:center; max-width:720px; }
    .gx-lb-cap b { display:block; font-size:15px; font-weight:800; margin-bottom:4px; }
    .gx-lb-cap span { font-size:12px; opacity:.8; font-weight:700; }
    .gx-lb-bar { display:flex; align-items:center; gap:12px; }
    .gx-lb-btn { width:44px; height:44px; border-radius:50%; border:1px solid rgba(255,255,255,.25); background:rgba(255,255,255,.12); color:#fff; font-size:17px; cursor:pointer; transition:all .2s; display:inline-flex; align-items:center; justify-content:center; }
    .gx-lb-btn:hover { background:rgba(255,255,255,.25); transform:scale(1.06); }
    .gx-counter { color:rgba(255,255,255,.85); font-size:12.5px; font-weight:800; letter-spacing:.08em; min-width:64px; text-align:center; }
    .gx-close { position:absolute; top:20px; right:26px; width:46px; height:46px; border-radius:50%; border:1px solid rgba(255,255,255,.25); background:rgba(255,255,255,.14); color:#fff; font-size:20px; cursor:pointer; transition:all .2s; }
    .gx-close:hover { background:rgba(220,38,38,.7); transform:rotate(90deg); }
    .gx-dl { padding:10px 18px; border-radius:999px; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); color:#03251f; font-size:12px; font-weight:900; text-decoration:none; box-shadow:0 6px 14px rgba(217,164,65,.4); transition:all .2s; }
    .gx-dl:hover { transform:translateY(-2px); }
</style>

<div class="gx-wrap">
    <!-- ===== HERO ===== -->
    <section class="gx-hero">
        <div class="gx-hero-inner">
            <span class="gx-eyebrow">✦ Dokumentasi Visual Lembaga</span>
            <h1>Galeri Kegiatan LP3M</h1>
            <p>Momen terbaik dari perjalanan penelitian, pengabdian, publikasi ilmiah, dan kegiatan AIK LP3M / LPPAIK UNIMOF.</p>
            <div class="gx-stats">
                <span class="gx-stat">📸 <b><?= count($items) ?></b> foto ditampilkan</span>
                <span class="gx-stat">🗂️ <b><?= count($cats) ?></b> kategori</span>
                <?php if ($cat !== ''): ?><span class="gx-stat">🏷️ Filter: <b><?= e($cat) ?></b></span><?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ===== FILTER CHIPS ===== -->
    <div class="gx-chips">
        <a href="<?= e(url('public/index.php?page=galeri')) ?>" class="gx-chip <?= $cat === '' ? 'active' : '' ?>">✨ Semua</a>
        <?php foreach ($cats as $c): ?>
            <a href="<?= e(url('public/index.php?page=galeri&cat=' . urlencode($c))) ?>" class="gx-chip <?= $cat === $c ? 'active' : '' ?>"><?= e($c) ?></a>
        <?php endforeach; ?>
    </div>

    <?php if (empty($items)): ?>
        <div class="gx-empty">
            <div class="gx-empty-ico">📷</div>
            <h3>Belum Ada Foto di Kategori Ini</h3>
            <p>Dokumentasi kegiatan akan segera diunggah oleh admin. Pantau terus halaman ini!</p>
        </div>
    <?php else: ?>
        <!-- ===== MASONRY ===== -->
        <div class="gx-masonry">
            <?php foreach ($items as $i => $item): ?>
            <div class="gx-item"
                 data-img="<?= e(upload_url($item['image_path'])) ?>"
                 data-title="<?= e($item['title']) ?>"
                 data-cat="<?= e($item['category']) ?>"
                 data-date="<?= !empty($item['event_date']) ? e(date('d M Y', strtotime($item['event_date']))) : '' ?>">
                <div class="gx-imgwrap">
                    <img src="<?= e(upload_url($item['image_path'])) ?>" alt="<?= e($item['title']) ?>" loading="lazy">
                    <span class="gx-cat-badge"><?= e($item['category']) ?></span>
                    <span class="gx-zoom">🔍</span>
                    <div class="gx-overlay"><span>🔍 Klik untuk memperbesar</span></div>
                </div>
                <div class="gx-cap">
                    <h3><?= e($item['title']) ?></h3>
                    <span>📅 <?= !empty($item['event_date']) ? e(date('d M Y', strtotime($item['event_date']))) : 'Tanpa tanggal' ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- ===== LIGHTBOX ===== -->
<div class="gx-lightbox" id="gxBox" role="dialog" aria-modal="true">
    <button class="gx-close" id="gxClose" aria-label="Tutup">✕</button>
    <img id="gxImg" src="" alt="">
    <div class="gx-lb-cap">
        <b id="gxTitle"></b>
        <span id="gxMeta"></span>
    </div>
    <div class="gx-lb-bar">
        <button class="gx-lb-btn" id="gxPrev" aria-label="Sebelumnya">◀</button>
        <span class="gx-counter" id="gxCount">1 / 1</span>
        <button class="gx-lb-btn" id="gxNext" aria-label="Berikutnya">▶</button>
        <a class="gx-dl" id="gxDl" href="#" download>⬇️ Unduh</a>
    </div>
</div>

<script>
(function(){
    var box = document.getElementById('gxBox');
    var img = document.getElementById('gxImg');
    var ttl = document.getElementById('gxTitle');
    var meta = document.getElementById('gxMeta');
    var cnt = document.getElementById('gxCount');
    var dl = document.getElementById('gxDl');
    var items = Array.prototype.slice.call(document.querySelectorAll('.gx-item'));
    var idx = 0;

    function show(i){
        idx = (i + items.length) % items.length;
        var el = items[idx];
        img.src = el.getAttribute('data-img');
        img.alt = el.getAttribute('data-title');
        ttl.textContent = el.getAttribute('data-title');
        var c = el.getAttribute('data-cat'), d = el.getAttribute('data-date');
        meta.textContent = (c ? '🗂️ ' + c : '') + (d ? '  ·  📅 ' + d : '');
        cnt.textContent = (idx + 1) + ' / ' + items.length;
        dl.href = img.src;
        dl.setAttribute('download', (el.getAttribute('data-title') || 'foto') + '.jpg');
    }
    function open(i){ show(i); box.classList.add('show'); document.body.style.overflow = 'hidden'; }
    function close(){ box.classList.remove('show'); document.body.style.overflow = ''; }

    items.forEach(function(el, i){
        el.addEventListener('click', function(){ open(i); });
    });
    document.getElementById('gxClose').addEventListener('click', close);
    document.getElementById('gxPrev').addEventListener('click', function(e){ e.stopPropagation(); show(idx - 1); });
    document.getElementById('gxNext').addEventListener('click', function(e){ e.stopPropagation(); show(idx + 1); });
    box.addEventListener('click', function(e){ if (e.target === box) close(); });
    document.addEventListener('keydown', function(e){
        if (!box.classList.contains('show')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') show(idx - 1);
        if (e.key === 'ArrowRight') show(idx + 1);
    });

    // Reveal on scroll
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(entries){
            entries.forEach(function(en){
                if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
            });
        }, { threshold: 0.12 });
        items.forEach(function(el){ io.observe(el); });
    } else {
        items.forEach(function(el){ el.classList.add('in'); });
    }
})();
</script>