<?php
$baseView = url('public/index.php?page=video-view&id=');
$brandName = e(Setting::all()['site_brand'] ?? 'LP3M');
?>
<style>
    @keyframes mvFade { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:none} }
    @keyframes mvPop { from{transform:scale(.92);opacity:0} to{transform:scale(1);opacity:1} }
    @keyframes mvShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes mvPulse { 0%,100%{box-shadow:0 0 0 0 rgba(253,230,138,.55)} 50%{box-shadow:0 0 0 14px rgba(253,230,138,0)} }
    @keyframes mvFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }

    .mv-wrap { max-width:1150px; margin:0 auto; padding:0 20px; }

    /* HERO */
    .mv-hero { position:relative; overflow:hidden; padding:56px 46px; border-radius:28px; background:linear-gradient(135deg,#043b2c 0%,#065f46 45%,#059669 100%); color:#fff; box-shadow:0 24px 60px rgba(3,37,31,.32); margin-bottom:26px; animation:mvFade .6s both; }
    .mv-hero::before { content:''; position:absolute; inset:0; opacity:.35; background-image:repeating-linear-gradient(45deg,transparent,transparent 30px,rgba(253,230,138,.06) 30px,rgba(253,230,138,.06) 31px); pointer-events:none; }
    .mv-hero::after { content:'🎥'; position:absolute; right:44px; bottom:-18px; font-size:150px; opacity:.14; animation:mvFloat 6s ease-in-out infinite; pointer-events:none; }
    .mv-hero .tag { display:inline-flex; align-items:center; gap:8px; padding:6px 15px; border-radius:999px; font-size:10.5px; font-weight:900; letter-spacing:.18em; text-transform:uppercase; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.3); margin-bottom:16px; position:relative; z-index:1; }
    .mv-hero .tag i { width:7px; height:7px; border-radius:50%; background:#6ee7b7; box-shadow:0 0 8px #6ee7b7; }
    .mv-hero h1 { font-family:var(--font-display); font-size:clamp(26px,4vw,42px); font-weight:900; letter-spacing:-.02em; margin:0 0 10px; position:relative; z-index:1; }
    .mv-hero h1 em { font-style:normal; background:linear-gradient(135deg,#fde68a,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .mv-hero p { font-size:14.5px; line-height:1.7; opacity:.92; max-width:620px; margin:0 0 22px; position:relative; z-index:1; }
    .mv-stats { display:flex; gap:10px; flex-wrap:wrap; position:relative; z-index:1; }
    .mv-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); border-radius:14px; padding:10px 18px; text-align:center; min-width:92px; backdrop-filter:blur(6px); }
    .mv-stat b { display:block; font-family:var(--font-display); font-size:19px; font-weight:900; color:#fde68a; line-height:1.1; }
    .mv-stat span { font-size:9px; letter-spacing:.12em; text-transform:uppercase; opacity:.85; display:block; margin-top:3px; }

    /* TOOLBAR */
    .mv-tools { display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:22px; animation:mvFade .6s .06s both; }
    .mv-search { position:relative; flex:1; min-width:220px; max-width:340px; }
    .mv-search input { width:100%; padding:11px 16px 11px 42px; border-radius:999px; border:1px solid var(--border); background:var(--surface); font-size:13px; font-weight:600; color:var(--text); outline:none; transition:all .2s; }
    .mv-search input:focus { border-color:#059669; box-shadow:0 0 0 4px rgba(5,150,105,.12); }
    .mv-search .ico { position:absolute; left:15px; top:50%; transform:translateY(-50%); font-size:14px; opacity:.6; }
    .mv-chips { display:flex; gap:8px; flex-wrap:wrap; }
    .mv-chip { padding:9px 18px; border-radius:999px; font-size:12.5px; font-weight:800; text-decoration:none; color:var(--muted); background:var(--surface); border:1px solid var(--border); transition:all .2s; }
    .mv-chip:hover { transform:translateY(-2px); border-color:rgba(5,150,105,.5); color:#047857; }
    .mv-chip.on { color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); border-color:transparent; box-shadow:0 5px 14px rgba(217,164,65,.35); }
    .mv-count { margin-left:auto; font-size:11.5px; font-weight:800; color:var(--muted); }

    /* GRID */
    .mv-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(290px,1fr)); gap:20px; margin-bottom:46px; }
    .mv-card { position:relative; border-radius:18px; overflow:hidden; background:var(--surface); border:1px solid var(--border); box-shadow:0 8px 22px rgba(3,37,31,.08); cursor:pointer; transition:all .3s cubic-bezier(.16,1,.3,1); opacity:0; transform:translateY(18px); }
    .mv-card.in { opacity:1; transform:none; }
    .mv-card.wide { grid-column:1 / -1; display:grid; grid-template-columns:1.2fr 1fr; }
    .mv-card:hover { transform:translateY(-6px); box-shadow:0 18px 40px rgba(3,37,31,.16); border-color:rgba(5,150,105,.4); }
    .mv-thumb { position:relative; aspect-ratio:16/9; background:#0d1d17; overflow:hidden; }
    .mv-card.wide .mv-thumb { aspect-ratio:auto; min-height:280px; }
    .mv-thumb img { width:100%; height:100%; object-fit:cover; transition:transform .6s; }
    .mv-card:hover .mv-thumb img { transform:scale(1.07); }
    .mv-play { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; background:linear-gradient(180deg,transparent 35%,rgba(3,37,31,.6)); transition:opacity .3s; }
    .mv-play span { position:relative; width:58px; height:58px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:20px; color:#03251f; background:radial-gradient(circle at 30% 25%,#fff7c2,#fde68a 20%,#d9a441); box-shadow:0 8px 22px rgba(217,164,65,.5); transition:transform .3s; animation:mvPulse 2.6s ease-in-out infinite; }
    .mv-play span::after { content:''; position:absolute; top:0; left:-90%; width:50%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.6),transparent); transform:skewX(-20deg); animation:mvShine 3.4s ease-in-out infinite; }
    .mv-card:hover .mv-play span { transform:scale(1.14); }
    .mv-dur { position:absolute; right:10px; bottom:10px; padding:3px 9px; border-radius:7px; background:rgba(3,37,31,.85); color:#fde68a; font-size:10.5px; font-weight:900; letter-spacing:.05em; }
    .mv-cat { position:absolute; left:10px; top:10px; padding:4px 11px; border-radius:999px; background:rgba(255,255,255,.94); color:#065f46; font-size:9.5px; font-weight:900; letter-spacing:.06em; text-transform:uppercase; }
    .mv-badge-hot { position:absolute; right:10px; top:10px; padding:4px 10px; border-radius:999px; background:linear-gradient(145deg,#f87171,#dc2626); color:#fff; font-size:9px; font-weight:900; letter-spacing:.08em; }
    .mv-body { padding:16px 18px 18px; display:flex; flex-direction:column; gap:8px; }
    .mv-card.wide .mv-body { padding:26px 28px; justify-content:center; }
    .mv-body h3 { font-family:var(--font-display); font-size:15px; font-weight:900; color:var(--ink); line-height:1.4; margin:0; }
    .mv-card.wide .mv-body h3 { font-size:21px; }
    .mv-card.wide .mv-desc { font-size:13px; line-height:1.7; color:var(--muted); margin:0; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
    .mv-meta { display:flex; gap:12px; font-size:11px; color:var(--muted); }
    .mv-empty { text-align:center; padding:60px 20px; border-radius:22px; background:var(--surface); border:2px dashed var(--border); color:var(--muted); }

    /* MODAL */
    .mv-modal { position:fixed; inset:0; z-index:99990; display:none; align-items:center; justify-content:center; padding:24px; background:rgba(3,37,31,.8); backdrop-filter:blur(10px); }
    .mv-modal.open { display:flex; }
    .mv-box { position:relative; width:100%; max-width:940px; max-height:92vh; overflow-y:auto; border-radius:22px; background:var(--surface); box-shadow:0 40px 90px rgba(0,0,0,.55); animation:mvPop .35s cubic-bezier(.16,1,.3,1) both; }
    .mv-box::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,#065f46,#10b981,#f2c063); z-index:6; border-radius:22px 22px 0 0; }
    .mv-close { position:absolute; top:14px; right:14px; z-index:7; width:38px; height:38px; border-radius:50%; border:none; cursor:pointer; background:rgba(3,37,31,.75); color:#fff; font-size:16px; transition:all .25s; }
    .mv-close:hover { background:#dc2626; transform:rotate(90deg); }
    .mv-player { aspect-ratio:16/9; background:#000; }
    .mv-player iframe, .mv-player video { width:100%; height:100%; border:none; display:block; }
    .mv-info { padding:22px 26px 10px; }
    .mv-info .catline { display:flex; gap:8px; align-items:center; margin-bottom:8px; }
    .mv-info .catline .c { padding:4px 12px; border-radius:999px; background:rgba(5,150,105,.12); color:#047857; font-size:10px; font-weight:900; letter-spacing:.06em; text-transform:uppercase; }
    .mv-info h3 { font-family:var(--font-display); font-size:20px; font-weight:900; color:var(--ink); margin:0 0 8px; line-height:1.35; }
    .mv-info .m { font-size:11.5px; color:var(--muted); margin-bottom:12px; display:flex; gap:14px; flex-wrap:wrap; }
    .mv-info p { font-size:13.5px; line-height:1.8; color:var(--muted); margin:0; white-space:pre-line; }
    .mv-nav { display:flex; align-items:center; gap:10px; padding:16px 26px 24px; }
    .mv-navbtn { padding:10px 18px; border-radius:11px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--muted); font-size:12.5px; font-weight:800; cursor:pointer; transition:all .2s; }
    .mv-navbtn:hover:not(:disabled) { border-color:rgba(5,150,105,.5); color:#047857; transform:translateY(-2px); }
    .mv-navbtn:disabled { opacity:.4; cursor:not-allowed; }
    .mv-share { margin-left:auto; padding:10px 18px; border-radius:11px; border:none; cursor:pointer; font-size:12.5px; font-weight:800; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:0 5px 14px rgba(217,164,65,.35); transition:all .2s; }
    .mv-share:hover { transform:translateY(-2px); }
    @media(max-width:800px){ .mv-card.wide { grid-template-columns:1fr; } .mv-card.wide .mv-thumb { min-height:0; aspect-ratio:16/9; } }
</style>

<div class="mv-wrap">
    <div class="mv-hero">
        <span class="tag"><i></i> Multimedia Lembaga</span>
        <h1>Galeri Video <em><?= $brandName ?></em></h1>
        <p>Dokumentasi visual seminar, workshop, profil lembaga, dan kegiatan Catur Dharma — arsip hidup perjalanan institusi.</p>
        <div class="mv-stats">
            <div class="mv-stat"><b><?= count($videos) ?></b><span>Video</span></div>
            <div class="mv-stat"><b><?= number_format((int) $stats['views']) ?></b><span>Total Views</span></div>
            <div class="mv-stat"><b><?= count($categories) ?></b><span>Kategori</span></div>
        </div>
    </div>

    <div class="mv-tools">
        <div class="mv-search">
            <span class="ico">🔍</span>
            <input type="text" id="mvSearch" placeholder="Cari judul video...">
        </div>
        <div class="mv-chips">
            <a class="mv-chip <?= $currentCat === '' ? 'on' : '' ?>" href="<?= e(url('public/index.php?page=video')) ?>">Semua</a>
            <?php foreach ($categories as $k => $l): ?>
            <a class="mv-chip <?= $currentCat === $k ? 'on' : '' ?>" href="<?= e(url('public/index.php?page=video&cat=' . urlencode($k))) ?>"><?= e($l) ?></a>
            <?php endforeach; ?>
        </div>
        <span class="mv-count" id="mvCount"><?= count($videos) ?> video</span>
    </div>

    <?php if (empty($videos)): ?>
    <div class="mv-empty">
        <div style="font-size:52px; margin-bottom:12px;">🎬</div>
        <h3 style="margin:0 0 6px; color:var(--ink);">Belum Ada Video</h3>
        <p style="margin:0;">Video kegiatan akan tampil di sini setelah dipublikasikan admin.</p>
    </div>
    <?php else: ?>
    <div class="mv-grid" id="mvGrid">
        <?php foreach ($videos as $i => $v):
            $thumb = Video::thumbUrl($v);
            $playUrl = $v['source'] === 'mp4'
                ? (str_starts_with((string) $v['video_url'], 'http') ? $v['video_url'] : upload_url((string) $v['video_url']))
                : Video::embedUrl($v);
        ?>
        <div class="mv-card <?= $i === 0 ? 'wide' : '' ?>"
             data-id="<?= (int) $v['id'] ?>"
             data-source="<?= e($v['source']) ?>"
             data-play="<?= e($playUrl) ?>"
             data-cat="<?= e($categories[$v['category']] ?? 'Video') ?>"
             data-title="<?= e($v['title']) ?>"
             data-meta="<?= e(date('d M Y', strtotime($v['published_at'] ?? $v['created_at']))) ?> · <?= number_format((int) $v['views']) ?> views"
             data-desc="<?= e($v['description'] ?? '') ?>">
            <div class="mv-thumb">
                <?php if ($thumb !== ''): ?><img src="<?= e($thumb) ?>" alt="<?= e($v['title']) ?>" loading="lazy"><?php endif; ?>
                <div class="mv-play"><span>▶</span></div>
                <span class="mv-cat"><?= e($categories[$v['category']] ?? 'Video') ?></span>
                <?php if ($i === 0): ?><span class="mv-badge-hot">🔥 TERBARU</span><?php endif; ?>
                <?php if (!empty($v['duration'])): ?><span class="mv-dur"><?= e($v['duration']) ?></span><?php endif; ?>
            </div>
            <div class="mv-body">
                <h3><?= e($v['title']) ?></h3>
                <?php if ($i === 0 && !empty($v['description'])): ?><p class="mv-desc"><?= e($v['description']) ?></p><?php endif; ?>
                <div class="mv-meta">
                    <span>📅 <?= e(date('d M Y', strtotime($v['published_at'] ?? $v['created_at']))) ?></span>
                    <span>👁️ <?= number_format((int) $v['views']) ?></span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- MODAL -->
<div class="mv-modal" id="mvModal" role="dialog" aria-label="Pemutar video">
    <div class="mv-box">
        <button class="mv-close" id="mvClose" type="button" aria-label="Tutup">✕</button>
        <div class="mv-player" id="mvPlayer"></div>
        <div class="mv-info">
            <div class="catline"><span class="c" id="mvCat"></span></div>
            <h3 id="mvTitle"></h3>
            <div class="m" id="mvMeta"></div>
            <p id="mvDesc"></p>
        </div>
        <div class="mv-nav">
            <button class="mv-navbtn" id="mvPrev" type="button">← Sebelumnya</button>
            <button class="mv-navbtn" id="mvNext" type="button">Berikutnya →</button>
            <button class="mv-share" id="mvShare" type="button">🔗 Salin Link</button>
        </div>
    </div>
</div>

<script>
(function(){
    var modal = document.getElementById('mvModal');
    var player = document.getElementById('mvPlayer');
    var VIEW_URL = <?= json_encode($baseView) ?>;
    var counted = {};
    var cards = Array.prototype.slice.call(document.querySelectorAll('.mv-card'));
    var curIdx = -1;

    /* Scroll reveal */
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(es){
            es.forEach(function(en){ if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); } });
        }, { threshold: .12 });
        cards.forEach(function(c){ io.observe(c); });
    } else {
        cards.forEach(function(c){ c.classList.add('in'); });
    }

    /* Pencarian instan */
    var search = document.getElementById('mvSearch');
    var countEl = document.getElementById('mvCount');
    if (search) search.addEventListener('input', function(){
        var q = this.value.toLowerCase();
        var n = 0;
        cards.forEach(function(c){
            var show = (c.getAttribute('data-title') || '').toLowerCase().indexOf(q) !== -1;
            c.style.display = show ? '' : 'none';
            if (show) n++;
        });
        if (countEl) countEl.textContent = n + ' video';
    });

    function visible(){ return cards.filter(function(c){ return c.style.display !== 'none'; }); }

    function openCard(card){
        var list = visible();
        curIdx = list.indexOf(card);
        var id = card.getAttribute('data-id');
        var src = card.getAttribute('data-source');
        var play = card.getAttribute('data-play');
        document.getElementById('mvCat').textContent = card.getAttribute('data-cat');
        document.getElementById('mvTitle').textContent = card.getAttribute('data-title');
        document.getElementById('mvMeta').textContent = card.getAttribute('data-meta');
        document.getElementById('mvDesc').textContent = card.getAttribute('data-desc') || '';
        if (src === 'mp4') {
            player.innerHTML = '<video controls autoplay playsinline src="' + play + '"></video>';
        } else {
            player.innerHTML = '<iframe src="' + play + '&autoplay=1" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        }
        document.getElementById('mvPrev').disabled = curIdx <= 0;
        document.getElementById('mvNext').disabled = curIdx >= list.length - 1;
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
        if (!counted[id]) { counted[id] = true; fetch(VIEW_URL + id).catch(function(){}); }
    }

    function nav(dir){
        var list = visible();
        var n = curIdx + dir;
        if (n < 0 || n >= list.length) return;
        openCard(list[n]);
    }

    function close(){
        modal.classList.remove('open');
        player.innerHTML = '';
        document.body.style.overflow = '';
    }

    cards.forEach(function(card){ card.addEventListener('click', function(){ openCard(card); }); });
    document.getElementById('mvClose').addEventListener('click', close);
    document.getElementById('mvPrev').addEventListener('click', function(){ nav(-1); });
    document.getElementById('mvNext').addEventListener('click', function(){ nav(1); });
    modal.addEventListener('click', function(e){ if (e.target === modal) close(); });
    document.addEventListener('keydown', function(e){
        if (!modal.classList.contains('open')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') nav(-1);
        if (e.key === 'ArrowRight') nav(1);
    });

    /* Share / salin link deep-link */
    document.getElementById('mvShare').addEventListener('click', function(){
        var list = visible();
        if (curIdx < 0) return;
        var id = list[curIdx].getAttribute('data-id');
        var url = location.href.split('#')[0] + '#v' + id;
        if (navigator.clipboard) navigator.clipboard.writeText(url);
        this.textContent = '✅ Tersalin!';
        var btn = this;
        setTimeout(function(){ btn.textContent = '🔗 Salin Link'; }, 1500);
    });

    /* Deep-link #v12 */
    var h = location.hash;
    if (h && h.indexOf('#v') === 0) {
        var target = cards.filter(function(c){ return c.getAttribute('data-id') === h.slice(2); })[0];
        if (target) setTimeout(function(){ openCard(target); }, 400);
    }
})();
</script>