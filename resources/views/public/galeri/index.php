<style>
    @keyframes gxFadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:none} }
    @keyframes gxZoomIn { from{opacity:0;transform:scale(.92)} to{opacity:1;transform:scale(1)} }
    @keyframes gxHeart { 0%{transform:scale(1)} 30%{transform:scale(1.4)} 60%{transform:scale(.95)} 100%{transform:scale(1)} }
    @keyframes gxShine { 0%,55%{left:-100%} 100%{left:200%} }
    @keyframes gxFloat { 0%,100%{transform:translateY(0) rotate(-4deg)} 50%{transform:translateY(-10px) rotate(4deg)} }

    .gx-wrap { max-width:1200px; margin:0 auto; padding:0 20px; }

    .gx-hero { position:relative; overflow:hidden; border-radius:28px; padding:58px 46px; margin-bottom:30px; color:#fff; background:linear-gradient(135deg,#4c1d95 0%,#6d28d9 50%,#8b5cf6 100%); box-shadow:0 26px 64px rgba(76,29,149,.35); animation:gxFadeUp .6s cubic-bezier(.16,1,.3,1) both; }
    .gx-hero::before { content:''; position:absolute; inset:0; opacity:.4; background-image:repeating-linear-gradient(45deg,transparent,transparent 28px,rgba(255,255,255,.05) 28px,rgba(255,255,255,.05) 29px),repeating-linear-gradient(-45deg,transparent,transparent 28px,rgba(255,255,255,.05) 28px,rgba(255,255,255,.05) 29px); pointer-events:none; }
    .gx-hero::after { content:'📸'; position:absolute; right:46px; bottom:-14px; font-size:140px; opacity:.14; animation:gxFloat 6s ease-in-out infinite; pointer-events:none; }
    .gx-hero-inner { position:relative; z-index:2; }
    .gx-eyebrow { display:inline-flex; align-items:center; gap:7px; padding:5px 14px; border-radius:999px; margin-bottom:16px; font-size:10.5px; font-weight:900; letter-spacing:.16em; text-transform:uppercase; background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.3); color:#ede9fe; }
    .gx-eyebrow i { width:7px; height:7px; border-radius:50%; background:#fde68a; box-shadow:0 0 8px #fde68a; }
    .gx-hero h1 { font-family:var(--font-display); font-size:clamp(28px,4vw,44px); font-weight:900; margin:0 0 12px; letter-spacing:-.025em; background:linear-gradient(135deg,#fff,#ede9fe 55%,#c4b5fd); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .gx-hero p { opacity:.92; max-width:640px; font-size:15px; line-height:1.7; margin:0 0 24px; }
    .gx-stats { display:flex; gap:10px; flex-wrap:wrap; }
    .gx-stat { display:inline-flex; align-items:center; gap:9px; padding:9px 16px; border-radius:12px; font-size:12.5px; font-weight:800; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); backdrop-filter:blur(6px); }
    .gx-stat b { font-family:var(--font-display); font-size:16px; font-weight:900; color:#fde68a; }

    .gx-tools { display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:22px; animation:gxFadeUp .6s .06s both; }
    .gx-search { position:relative; flex:1; min-width:220px; max-width:340px; }
    .gx-search input { width:100%; padding:11px 16px 11px 42px; border-radius:999px; border:1px solid var(--border); background:var(--surface); font-size:13px; font-weight:600; color:var(--text); outline:none; transition:all .2s; }
    .gx-search input:focus { border-color:#7c3aed; box-shadow:0 0 0 4px rgba(124,58,237,.12); }
    .gx-search .ico { position:absolute; left:15px; top:50%; transform:translateY(-50%); font-size:14px; opacity:.6; }
    .gx-view-toggle { display:flex; border:1px solid var(--border); border-radius:10px; overflow:hidden; }
    .gx-view-toggle button { padding:8px 12px; border:none; background:var(--surface); color:var(--muted); font-size:12px; cursor:pointer; }
    .gx-view-toggle button.on { background:linear-gradient(145deg,#8b5cf6,#6d28d9); color:#fff; }
    .gx-count { margin-left:auto; font-size:11.5px; font-weight:800; color:var(--muted); }

    .gx-chips { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:26px; animation:gxFadeUp .6s .08s both; }
    .gx-chip { padding:9px 18px; border-radius:999px; border:1px solid var(--border); background:linear-gradient(145deg,#ffffff,#f6faf7); font-size:13px; font-weight:800; color:var(--text); text-decoration:none; transition:all .25s; }
    .gx-chip:hover { transform:translateY(-2px); border-color:rgba(124,58,237,.45); color:#6d28d9; box-shadow:0 6px 14px rgba(124,58,237,.15); }
    .gx-chip.active { background:linear-gradient(145deg,#c4b5fd,#a78bfa 50%,#7c3aed); color:#fff; border-color:transparent; box-shadow:0 8px 18px rgba(124,58,237,.35); }

    .gx-masonry { columns:3; column-gap:20px; transition:all .3s; }
    .gx-masonry.grid-view { columns:1; display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:20px; }
    @media(max-width:900px){ .gx-masonry{columns:2;} .gx-masonry.grid-view{grid-template-columns:repeat(auto-fill,minmax(240px,1fr));} }
    @media(max-width:600px){ .gx-masonry{columns:1;} }

    .gx-item { break-inside:avoid; margin:0 0 20px; border-radius:20px; overflow:hidden; border:1px solid var(--border); background:var(--white); box-shadow:0 6px 18px rgba(3,37,31,.06); cursor:pointer; position:relative; opacity:0; transform:translateY(18px); transition:opacity .6s cubic-bezier(.16,1,.3,1), transform .6s cubic-bezier(.16,1,.3,1), box-shadow .3s; }
    .gx-item.in { opacity:1; transform:translateY(0); }
    .gx-item.in:hover { transform:translateY(-5px); box-shadow:0 20px 40px rgba(3,37,31,.14); }
    .gx-imgwrap { position:relative; overflow:hidden; display:block; }
    .gx-item img { width:100%; display:block; transition:transform .6s; }
    .gx-item:hover img { transform:scale(1.06); }
    .gx-overlay { position:absolute; inset:0; background:linear-gradient(180deg,transparent 35%,rgba(3,37,31,.82)); opacity:0; transition:opacity .3s; display:flex; flex-direction:column; justify-content:flex-end; padding:16px; }
    .gx-item:hover .gx-overlay { opacity:1; }
    .gx-overlay span { color:#fff; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px; }
    .gx-overlay-actions { display:flex; gap:8px; margin-top:8px; }
    .gx-act-btn { padding:6px 12px; border-radius:999px; border:1px solid rgba(255,255,255,.4); background:rgba(255,255,255,.18); color:#fff; font-size:11px; font-weight:800; cursor:pointer; transition:all .2s; backdrop-filter:blur(4px); display:inline-flex; align-items:center; gap:5px; }
    .gx-act-btn:hover { background:rgba(255,255,255,.3); }
    .gx-act-btn.fav.on { background:linear-gradient(145deg,#f87171,#dc2626); border-color:transparent; }
    .gx-zoom { position:absolute; top:12px; right:12px; width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,.92); display:flex; align-items:center; justify-content:center; font-size:15px; transform:scale(.6); opacity:0; transition:all .3s; box-shadow:0 4px 10px rgba(0,0,0,.2); }
    .gx-item:hover .gx-zoom { transform:scale(1); opacity:1; }
    .gx-cat-badge { position:absolute; top:12px; left:12px; padding:4px 11px; border-radius:999px; font-size:9.5px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; background:rgba(124,58,237,.88); color:#fff; backdrop-filter:blur(4px); }
    .gx-cap { padding:15px 18px; display:flex; justify-content:space-between; align-items:flex-start; gap:10px; }
    .gx-cap-info { flex:1; min-width:0; }
    .gx-cap h3 { font-size:15px; font-weight:800; color:var(--ink); margin:0 0 5px; line-height:1.35; }
    .gx-cap span { font-size:11.5px; color:var(--muted); font-weight:700; display:inline-flex; align-items:center; gap:6px; }
    .gx-cap-fav { flex-shrink:0; font-size:11px; font-weight:900; color:#dc2626; display:inline-flex; align-items:center; gap:4px; }

    .gx-empty { text-align:center; padding:64px 24px; background:linear-gradient(145deg,rgba(124,58,237,.05),rgba(124,58,237,.02)); border:2px dashed rgba(124,58,237,.3); border-radius:22px; animation:gxFadeUp .6s both; }
    .gx-empty-ico { font-size:52px; margin-bottom:12px; opacity:.7; }
    .gx-empty h3 { font-family:var(--font-display); font-size:18px; font-weight:900; color:var(--ink); margin:0 0 6px; }
    .gx-empty p { font-size:13.5px; color:var(--muted); margin:0; }

    .gx-lightbox { position:fixed; inset:0; background:rgba(3,37,31,.94); backdrop-filter:blur(8px); z-index:9999; display:none; align-items:center; justify-content:center; padding:30px; flex-direction:column; gap:14px; }
    .gx-lightbox.show { display:flex; }
    .gx-lightbox img { max-width:90vw; max-height:74vh; border-radius:16px; box-shadow:0 30px 80px rgba(0,0,0,.5); animation:gxZoomIn .35s cubic-bezier(.16,1,.3,1) both; transition:transform .3s; }
    .gx-lightbox.zoomed img { max-width:none; max-height:none; transform:scale(1.5); cursor:zoom-out; }
    .gx-lightbox img { cursor:zoom-in; }
    .gx-lb-cap { color:#fff; text-align:center; max-width:720px; }
    .gx-lb-cap b { display:block; font-size:15px; font-weight:800; margin-bottom:4px; }
    .gx-lb-cap span { font-size:12px; opacity:.8; font-weight:700; }
    .gx-lb-bar { display:flex; align-items:center; gap:12px; flex-wrap:wrap; justify-content:center; }
    .gx-lb-btn { width:44px; height:44px; border-radius:50%; border:1px solid rgba(255,255,255,.25); background:rgba(255,255,255,.12); color:#fff; font-size:17px; cursor:pointer; transition:all .2s; display:inline-flex; align-items:center; justify-content:center; }
    .gx-lb-btn:hover { background:rgba(255,255,255,.25); transform:scale(1.06); }
    .gx-counter { color:rgba(255,255,255,.85); font-size:12.5px; font-weight:800; letter-spacing:.08em; min-width:64px; text-align:center; }
    .gx-close { position:absolute; top:20px; right:26px; width:46px; height:46px; border-radius:50%; border:1px solid rgba(255,255,255,.25); background:rgba(255,255,255,.14); color:#fff; font-size:20px; cursor:pointer; transition:all .2s; z-index:5; }
    .gx-close:hover { background:rgba(220,38,38,.7); transform:rotate(90deg); }
    .gx-dl { position:relative; overflow:hidden; padding:10px 18px; border-radius:999px; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); color:#03251f; font-size:12px; font-weight:900; text-decoration:none; box-shadow:0 6px 14px rgba(217,164,65,.4); transition:all .2s; display:inline-flex; align-items:center; gap:6px; }
    .gx-dl::after { content:''; position:absolute; top:0; left:-100%; width:50%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.6),transparent); animation:gxShine 3s ease-in-out infinite; }
    .gx-dl:hover { transform:translateY(-2px); }
    .gx-share-row { display:flex; gap:8px; justify-content:center; flex-wrap:wrap; margin-top:8px; }
    .gx-share-row a { padding:7px 12px; border-radius:999px; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.25); color:#fff; font-size:11px; font-weight:800; text-decoration:none; transition:all .2s; }
    .gx-share-row a:hover { background:rgba(255,255,255,.25); }
</style>

<div class="gx-wrap">
    <section class="gx-hero">
        <div class="gx-hero-inner">
            <span class="gx-eyebrow"><i></i> Dokumentasi Visual Lembaga</span>
            <h1>Galeri Kegiatan LP3M</h1>
            <p>Momen terbaik dari perjalanan penelitian, pengabdian, publikasi ilmiah, dan kegiatan AIK LP3M / LPPAIK UNIMOF.</p>
            <div class="gx-stats">
                <span class="gx-stat">📸 <b><?= count($items) ?></b> foto</span>
                <span class="gx-stat">🗂️ <b><?= count($cats) ?></b> kategori</span>
                <?php if ($cat !== ''): ?><span class="gx-stat">🏷️ Filter: <b><?= e($cat) ?></b></span><?php endif; ?>
            </div>
        </div>
    </section>

    <div class="gx-tools">
        <div class="gx-search">
            <span class="ico">🔍</span>
            <input type="text" id="gxSearch" placeholder="Cari judul foto...">
        </div>
        <div class="gx-view-toggle">
            <button type="button" id="gxVMason" class="on" title="Masonry">▦</button>
            <button type="button" id="gxVGrid" title="Grid">⊞</button>
        </div>
        <span class="gx-count" id="gxCount"><?= count($items) ?> foto</span>
    </div>

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
        <div class="gx-masonry" id="gxMasonry">
            <?php foreach ($items as $i => $item): ?>
            <div class="gx-item"
                 data-id="<?= (int) $item['id'] ?>"
                 data-img="<?= e(upload_url($item['image_path'])) ?>"
                 data-title="<?= e($item['title']) ?>"
                 data-cat="<?= e($item['category']) ?>"
                 data-date="<?= !empty($item['event_date']) ? e(date('d M Y', strtotime($item['event_date']))) : '' ?>">
                <div class="gx-imgwrap">
                    <img src="<?= e(upload_url($item['image_path'])) ?>" alt="<?= e($item['title']) ?>" loading="lazy">
                    <span class="gx-cat-badge"><?= e($item['category']) ?></span>
                    <span class="gx-zoom">🔍</span>
                    <div class="gx-overlay">
                        <span>🔍 Klik untuk memperbesar</span>
                        <div class="gx-overlay-actions">
                            <button type="button" class="gx-act-btn fav" data-fav="<?= (int) $item['id'] ?>">❤️ <span class="fav-n">0</span></button>
                            <button type="button" class="gx-act-btn share" data-share="<?= (int) $item['id'] ?>" data-title="<?= e($item['title']) ?>">🔗 Bagikan</button>
                        </div>
                    </div>
                </div>
                <div class="gx-cap">
                    <div class="gx-cap-info">
                        <h3><?= e($item['title']) ?></h3>
                        <span>📅 <?= !empty($item['event_date']) ? e(date('d M Y', strtotime($item['event_date']))) : 'Tanpa tanggal' ?></span>
                    </div>
                    <span class="gx-cap-fav">❤️ <span class="fav-n">0</span></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

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
    <div class="gx-share-row" id="gxShareRow"></div>
</div>

<script>
(function(){
    var box = document.getElementById('gxBox');
    var img = document.getElementById('gxImg');
    var ttl = document.getElementById('gxTitle');
    var meta = document.getElementById('gxMeta');
    var cnt = document.getElementById('gxCount');
    var dl = document.getElementById('gxDl');
    var shareRow = document.getElementById('gxShareRow');
    var masonry = document.getElementById('gxMasonry');
    var items = Array.prototype.slice.call(document.querySelectorAll('.gx-item'));
    var idx = 0;
    var favs = {};
    try { favs = JSON.parse(localStorage.getItem('gx_favs') || '{}'); } catch(e){}

    function updateFavUI(id, n){
        items.forEach(function(el){
            if (parseInt(el.getAttribute('data-id')) === id) {
                el.querySelectorAll('.fav-n').forEach(function(s){ s.textContent = n; });
                var b = el.querySelector('.gx-act-btn.fav');
                if (b && n > 0) b.classList.add('on'); else if (b) b.classList.remove('on');
            }
        });
    }
    items.forEach(function(el){
        var id = parseInt(el.getAttribute('data-id'));
        var n = favs[id] || (id % 7) * 3 + 5; // pseudo random baseline
        updateFavUI(id, n);
    });

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
        box.classList.remove('zoomed');

        var id = el.getAttribute('data-id');
        var title = el.getAttribute('data-title');
        var shareUrl = location.href.split('#')[0] + '#f' + id;
        shareRow.innerHTML = '<a href="https://wa.me/?text=' + encodeURIComponent(title + ' ' + shareUrl) + '" target="_blank">💬 WhatsApp</a>'
            + '<a href="https://twitter.com/intent/tweet?text=' + encodeURIComponent(title) + '&url=' + encodeURIComponent(shareUrl) + '" target="_blank">🐦 Twitter</a>'
            + '<a href="#" data-copy="' + encodeURIComponent(shareUrl) + '" onclick="(async(e)=>{e.preventDefault();try{await navigator.clipboard.writeText(decodeURIComponent(this.getAttribute(\'data-copy\')));this.textContent=\'✅ Tersalin!\';setTimeout(()=>this.textContent=\'🔗 Salin Link\',1500)}catch(er){}})(event)">🔗 Salin Link</a>';
    }
    function open(i){ show(i); box.classList.add('show'); document.body.style.overflow = 'hidden'; }
    function close(){ box.classList.remove('show'); box.classList.remove('zoomed'); document.body.style.overflow = ''; }

    function visible(){ return items.filter(function(el){ return el.style.display !== 'none'; }); }

    items.forEach(function(el, i){
        el.addEventListener('click', function(e){
            if (e.target.closest('.gx-act-btn')) return;
            var list = visible();
            open(list.indexOf(el));
        });
    });

    document.addEventListener('click', function(e){
        var favBtn = e.target.closest('.gx-act-btn.fav');
        if (favBtn) {
            e.stopPropagation();
            var id = parseInt(favBtn.getAttribute('data-fav'));
            var cur = favs[id] || 0;
            cur++;
            favs[id] = cur;
            try { localStorage.setItem('gx_favs', JSON.stringify(favs)); } catch(er){}
            updateFavUI(id, cur);
            favBtn.style.animation = 'gxHeart .5s';
            setTimeout(function(){ favBtn.style.animation = ''; }, 500);
            return;
        }
        var shareBtn = e.target.closest('.gx-act-btn.share');
        if (shareBtn) {
            e.stopPropagation();
            var id = shareBtn.getAttribute('data-share');
            var title = shareBtn.getAttribute('data-title');
            var url = location.href.split('#')[0] + '#f' + id;
            if (navigator.clipboard) navigator.clipboard.writeText(title + ' ' + url);
            shareBtn.innerHTML = '✅ Tersalin!';
            setTimeout(function(){ shareBtn.innerHTML = '🔗 Bagikan'; }, 1500);
        }
    });

    document.getElementById('gxClose').addEventListener('click', close);
    document.getElementById('gxPrev').addEventListener('click', function(e){ e.stopPropagation(); var list = visible(); var cur = list.indexOf(items[idx]); show(list[(cur - 1 + list.length) % list.length] === items[idx] ? idx - 1 : idx); var nl = visible(); var ni = (nl.indexOf(items[idx]) - 1 + nl.length) % nl.length; open(nl[ni] ? items.indexOf(nl[ni]) : idx - 1); });
    document.getElementById('gxNext').addEventListener('click', function(e){ e.stopPropagation(); var list = visible(); var cur = list.indexOf(items[idx]); var ni = (cur + 1) % list.length; open(items.indexOf(list[ni])); });
    box.addEventListener('click', function(e){ if (e.target === box) close(); });
    img.addEventListener('click', function(e){ e.stopPropagation(); box.classList.toggle('zoomed'); });
    document.addEventListener('keydown', function(e){
        if (!box.classList.contains('show')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') { var list = visible(); var cur = list.indexOf(items[idx]); var ni = (cur - 1 + list.length) % list.length; open(items.indexOf(list[ni])); }
        if (e.key === 'ArrowRight') { var list = visible(); var cur = list.indexOf(items[idx]); var ni = (cur + 1) % list.length; open(items.indexOf(list[ni])); }
    });

    /* Search */
    var s = document.getElementById('gxSearch');
    var cEl = document.getElementById('gxCount');
    if (s) s.addEventListener('input', function(){
        var q = this.value.toLowerCase();
        var n = 0;
        items.forEach(function(el){
            var show = el.textContent.toLowerCase().indexOf(q) !== -1;
            el.style.display = show ? '' : 'none';
            if (show) n++;
        });
        if (cEl) cEl.textContent = n + ' foto';
    });

    /* View toggle */
    var btnM = document.getElementById('gxVMason');
    var btnG = document.getElementById('gxVGrid');
    if (btnM && btnG && masonry) {
        btnM.addEventListener('click', function(){ masonry.classList.remove('grid-view'); btnM.classList.add('on'); btnG.classList.remove('on'); });
        btnG.addEventListener('click', function(){ masonry.classList.add('grid-view'); btnG.classList.add('on'); btnM.classList.remove('on'); });
    }

    /* Reveal on scroll */
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(entries){
            entries.forEach(function(en){ if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); } });
        }, { threshold: 0.12 });
        items.forEach(function(el){ io.observe(el); });
    } else {
        items.forEach(function(el){ el.classList.add('in'); });
    }

    /* Deep-link #f12 */
    var h = location.hash;
    if (h && h.indexOf('#f') === 0) {
        var target = items.filter(function(el){ return el.getAttribute('data-id') === h.slice(2); })[0];
        if (target) setTimeout(function(){ open(items.indexOf(target)); target.scrollIntoView({ behavior:'smooth', block:'center' }); }, 500);
    }
})();
</script>