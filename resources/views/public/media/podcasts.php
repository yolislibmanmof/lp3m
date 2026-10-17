<?php
$basePlay = url('public/index.php?page=podcast-play&id=');
$brandName = e(Setting::all()['site_brand'] ?? 'LP3M');
$totalDur = 0;
?>
<style>
    @keyframes ppFade { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:none} }
    @keyframes ppEq { 0%,100%{height:6px} 50%{height:20px} }
    @keyframes ppSpin { to{transform:rotate(360deg)} }
    @keyframes ppShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes ppFloat { 0%,100%{transform:translateY(0) rotate(-6deg)} 50%{transform:translateY(-12px) rotate(6deg)} }
    @keyframes ppWave { 0%{background-position:0 0} 100%{background-position:240px 0} }

    .pp-wrap { max-width:940px; margin:0 auto; padding:0 20px 150px; }

    /* HERO */
    .pp-hero { position:relative; overflow:hidden; padding:56px 46px; border-radius:28px; background:linear-gradient(135deg,#431407 0%,#7c2d12 45%,#c2410c 100%); color:#fff; box-shadow:0 24px 60px rgba(3,37,31,.32); margin-bottom:26px; animation:ppFade .6s both; }
    .pp-hero::before { content:''; position:absolute; inset:0; opacity:.5; background-image:repeating-linear-gradient(90deg,transparent,transparent 22px,rgba(254,215,170,.05) 22px,rgba(254,215,170,.05) 24px); pointer-events:none; }
    .pp-hero::after { content:'🎙️'; position:absolute; right:46px; bottom:-14px; font-size:140px; opacity:.16; animation:ppFloat 6s ease-in-out infinite; pointer-events:none; }
    .pp-hero .tag { display:inline-flex; align-items:center; gap:8px; padding:6px 15px; border-radius:999px; font-size:10.5px; font-weight:900; letter-spacing:.18em; text-transform:uppercase; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.3); margin-bottom:16px; position:relative; z-index:1; }
    .pp-hero .tag i { width:7px; height:7px; border-radius:50%; background:#fdba74; box-shadow:0 0 8px #fdba74; animation:ppEq 1.4s ease-in-out infinite; }
    .pp-hero h1 { font-family:var(--font-display); font-size:clamp(26px,4vw,42px); font-weight:900; letter-spacing:-.02em; margin:0 0 10px; position:relative; z-index:1; }
    .pp-hero h1 em { font-style:normal; background:linear-gradient(135deg,#fde68a,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .pp-hero p { font-size:14.5px; line-height:1.7; opacity:.92; max-width:620px; margin:0 0 22px; position:relative; z-index:1; }
    .pp-stats { display:flex; gap:10px; flex-wrap:wrap; position:relative; z-index:1; }
    .pp-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); border-radius:14px; padding:10px 18px; text-align:center; min-width:92px; backdrop-filter:blur(6px); }
    .pp-stat b { display:block; font-family:var(--font-display); font-size:19px; font-weight:900; color:#fde68a; line-height:1.1; }
    .pp-stat span { font-size:9px; letter-spacing:.12em; text-transform:uppercase; opacity:.85; display:block; margin-top:3px; }

    /* CHIPS */
    .pp-chips { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:24px; animation:ppFade .6s .06s both; }
    .pp-chip { padding:9px 18px; border-radius:999px; font-size:12.5px; font-weight:800; text-decoration:none; color:var(--muted); background:var(--surface); border:1px solid var(--border); transition:all .2s; }
    .pp-chip:hover { transform:translateY(-2px); border-color:rgba(234,88,12,.5); color:#c2410c; }
    .pp-chip.on { color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); border-color:transparent; box-shadow:0 5px 14px rgba(217,164,65,.35); }

    /* LIST */
    .pp-list { display:flex; flex-direction:column; gap:16px; }
    .pp-card { position:relative; display:flex; gap:18px; align-items:center; padding:18px; border-radius:20px; background:var(--surface); border:1px solid var(--border); box-shadow:0 8px 22px rgba(3,37,31,.07); transition:all .3s cubic-bezier(.16,1,.3,1); opacity:0; transform:translateY(18px); overflow:hidden; }
    .pp-card.in { opacity:1; transform:none; }
    .pp-card:hover { transform:translateY(-4px); border-color:rgba(234,88,12,.4); box-shadow:0 16px 36px rgba(3,37,31,.13); }
    .pp-card.playing { border-color:rgba(234,88,12,.65); box-shadow:0 0 0 3px rgba(234,88,12,.15), 0 16px 36px rgba(3,37,31,.13); }
    .pp-card.playing::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#ea580c,#fde68a,#ea580c); background-size:240px 100%; animation:ppWave 2s linear infinite; }
    .pp-card.featured { background:linear-gradient(135deg,rgba(124,45,18,.08),rgba(234,88,12,.05)), var(--surface); border-color:rgba(234,88,12,.35); }
    .pp-cover { position:relative; width:100px; height:100px; border-radius:16px; flex-shrink:0; overflow:hidden; background:linear-gradient(145deg,#7c2d12,#ea580c); display:flex; align-items:center; justify-content:center; font-size:36px; box-shadow:0 8px 20px rgba(124,45,18,.3); }
    .pp-card.featured .pp-cover { width:130px; height:130px; }
    .pp-cover img { width:100%; height:100%; object-fit:cover; }
    .pp-eq { position:absolute; inset:0; display:none; align-items:flex-end; justify-content:center; gap:3px; padding-bottom:12px; background:rgba(3,37,31,.5); }
    .pp-card.playing .pp-eq { display:flex; }
    .pp-eq i { width:4px; border-radius:2px; background:#fde68a; animation:ppEq 1s ease-in-out infinite; }
    .pp-eq i:nth-child(2){ animation-delay:.2s } .pp-eq i:nth-child(3){ animation-delay:.4s }
    .pp-info { flex:1; min-width:0; }
    .pp-eps { display:inline-flex; padding:2px 10px; border-radius:999px; font-size:9.5px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; background:rgba(234,88,12,.12); color:#c2410c; border:1px solid rgba(234,88,12,.3); margin-bottom:6px; }
    .pp-badge-hot { display:inline-flex; padding:2px 10px; border-radius:999px; font-size:9px; font-weight:900; letter-spacing:.08em; background:linear-gradient(145deg,#f87171,#dc2626); color:#fff; margin-left:6px; }
    .pp-info h3 { font-family:var(--font-display); font-size:16px; font-weight:900; color:var(--ink); line-height:1.4; margin:0 0 6px; }
    .pp-card.featured .pp-info h3 { font-size:20px; }
    .pp-info .m { display:flex; gap:12px; flex-wrap:wrap; font-size:11px; color:var(--muted); margin-bottom:8px; }
    .pp-info p { font-size:12.5px; line-height:1.65; color:var(--muted); margin:0; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .pp-actions { display:flex; flex-direction:column; gap:8px; align-items:center; flex-shrink:0; }
    .pp-playbtn { position:relative; overflow:hidden; width:56px; height:56px; border-radius:50%; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:19px; color:#03251f; background:radial-gradient(circle at 30% 25%,#fff7c2,#fde68a 20%,#d9a441); box-shadow:0 8px 22px rgba(217,164,65,.45); transition:transform .25s; }
    .pp-playbtn::after { content:''; position:absolute; top:0; left:-90%; width:50%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.6),transparent); transform:skewX(-20deg); animation:ppShine 3.4s ease-in-out infinite; }
    .pp-playbtn:hover { transform:scale(1.1); }
    .pp-sharebtn { width:34px; height:34px; border-radius:50%; border:1px solid var(--border); background:transparent; color:var(--muted); font-size:13px; cursor:pointer; transition:all .2s; }
    .pp-sharebtn:hover { border-color:rgba(234,88,12,.5); color:#c2410c; transform:translateY(-2px); }
    .pp-empty { text-align:center; padding:60px 20px; border-radius:22px; background:var(--surface); border:2px dashed var(--border); color:var(--muted); }

    /* PLAYER BAR */
    .pp-bar { position:fixed; left:0; right:0; bottom:0; z-index:9990; display:none; align-items:center; gap:12px; padding:12px 20px; background:rgba(4,59,44,.97); backdrop-filter:blur(16px); border-top:1px solid rgba(253,230,138,.25); box-shadow:0 -12px 40px rgba(0,0,0,.4); }
    .pp-bar.show { display:flex; }
    .pp-bar::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#ea580c,#fde68a,#ea580c); background-size:240px 100%; animation:ppWave 2s linear infinite; }
    .pp-bar-cover { width:50px; height:50px; border-radius:50%; object-fit:cover; background:#7c2d12; flex-shrink:0; border:2px solid rgba(253,230,138,.5); box-shadow:0 4px 14px rgba(0,0,0,.4); }
    .pp-bar-cover.spin { animation:ppSpin 8s linear infinite; }
    .pp-bar-info { min-width:0; max-width:200px; }
    .pp-bar-info b { display:block; font-size:12.5px; font-weight:800; color:#fde68a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .pp-bar-info span { font-size:10.5px; color:rgba(255,255,255,.65); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; display:block; }
    .pp-ctrl { display:flex; align-items:center; gap:8px; }
    .pp-bar-btn { width:46px; height:46px; border-radius:50%; border:none; cursor:pointer; font-size:16px; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); flex-shrink:0; box-shadow:0 5px 16px rgba(217,164,65,.4); transition:transform .2s; }
    .pp-bar-btn:hover { transform:scale(1.08); }
    .pp-skip { width:34px; height:34px; border-radius:50%; border:1px solid rgba(255,255,255,.3); background:transparent; color:#fde68a; font-size:12px; cursor:pointer; transition:all .2s; }
    .pp-skip:hover { background:rgba(255,255,255,.12); }
    .pp-seek { flex:1; height:6px; -webkit-appearance:none; appearance:none; border-radius:999px; background:rgba(255,255,255,.2); outline:none; cursor:pointer; min-width:80px; }
    .pp-seek::-webkit-slider-thumb { -webkit-appearance:none; width:14px; height:14px; border-radius:50%; background:#fde68a; box-shadow:0 0 8px rgba(253,230,138,.7); }
    .pp-time { font-size:11px; color:rgba(255,255,255,.8); font-weight:700; white-space:nowrap; }
    .pp-vol { width:70px; height:4px; -webkit-appearance:none; appearance:none; border-radius:999px; background:rgba(255,255,255,.2); outline:none; cursor:pointer; }
    .pp-vol::-webkit-slider-thumb { -webkit-appearance:none; width:11px; height:11px; border-radius:50%; background:#6ee7b7; }
    .pp-speed { padding:6px 10px; border-radius:8px; border:1px solid rgba(255,255,255,.3); background:transparent; color:#fde68a; font-size:11px; font-weight:900; cursor:pointer; }
    @media(max-width:760px){
        .pp-card { flex-direction:column; align-items:stretch; text-align:center; }
        .pp-cover { width:100%; height:150px; }
        .pp-actions { flex-direction:row; justify-content:center; }
        .pp-bar-info, .pp-vol, .pp-time { display:none; }
    }
</style>

<div class="pp-wrap">
    <div class="pp-hero">
        <span class="tag"><i></i> Audio Series Resmi</span>
        <h1>Podcast <em><?= $brandName ?></em></h1>
        <p>Dengarkan diskusi, wawancara narasumber, dan kisah inspiratif civitas akademika — kapan saja, di mana saja.</p>
        <div class="pp-stats">
            <div class="pp-stat"><b><?= count($pods) ?></b><span>Episode</span></div>
            <div class="pp-stat"><b><?= number_format((int) $stats['plays']) ?></b><span>Total Plays</span></div>
            <div class="pp-stat"><b><?= count($categories) ?></b><span>Kategori</span></div>
        </div>
    </div>

    <div class="pp-chips">
        <a class="pp-chip <?= $currentCat === '' ? 'on' : '' ?>" href="<?= e(url('public/index.php?page=podcast')) ?>">Semua</a>
        <?php foreach ($categories as $k => $l): ?>
        <a class="pp-chip <?= $currentCat === $k ? 'on' : '' ?>" href="<?= e(url('public/index.php?page=podcast&cat=' . urlencode($k))) ?>"><?= e($l) ?></a>
        <?php endforeach; ?>
    </div>

    <?php if (empty($pods)): ?>
    <div class="pp-empty">
        <div style="font-size:52px; margin-bottom:12px;">🎧</div>
        <h3 style="margin:0 0 6px; color:var(--ink);">Belum Ada Episode</h3>
        <p style="margin:0;">Episode podcast akan tampil di sini setelah dipublikasikan admin.</p>
    </div>
    <?php else: ?>
    <div class="pp-list">
        <?php foreach ($pods as $i => $p):
            $cover = Podcast::coverUrl($p);
            $audio = Podcast::audioUrl($p);
        ?>
        <div class="pp-card <?= $i === 0 ? 'featured' : '' ?>"
             data-id="<?= (int) $p['id'] ?>"
             data-audio="<?= e($audio) ?>"
             data-cover="<?= e($cover) ?>"
             data-title="<?= e($p['title']) ?>"
             data-guest="<?= e($p['guest'] ?? '') ?>">
            <div class="pp-cover">
                <?php if ($cover !== ''): ?><img src="<?= e($cover) ?>" alt="" loading="lazy"><?php else: ?>🎙️<?php endif; ?>
                <div class="pp-eq"><i></i><i></i><i></i></div>
            </div>
            <div class="pp-info">
                <span>
                    <?php if (!empty($p['episode'])): ?><span class="pp-eps">Episode <?= e($p['episode']) ?></span><?php endif; ?>
                    <?php if ($i === 0): ?><span class="pp-badge-hot">🔥 TERBARU</span><?php endif; ?>
                </span>
                <h3><?= e($p['title']) ?></h3>
                <div class="m">
                    <span>📅 <?= e(date('d M Y', strtotime($p['published_at'] ?? $p['created_at']))) ?></span>
                    <?php if (!empty($p['guest'])): ?><span>🎤 <?= e($p['guest']) ?></span><?php endif; ?>
                    <?php if (!empty($p['duration'])): ?><span>⏱️ <?= e($p['duration']) ?></span><?php endif; ?>
                    <span>▶️ <?= number_format((int) $p['plays']) ?></span>
                </div>
                <p><?= e($p['description'] ?? '') ?></p>
            </div>
            <div class="pp-actions">
                <button class="pp-playbtn" type="button" aria-label="Putar episode">▶</button>
                <button class="pp-sharebtn" type="button" title="Salin link episode">🔗</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- PLAYER BAR -->
<div class="pp-bar" id="ppBar">
    <img class="pp-bar-cover" id="ppBarCover" src="" alt="">
    <div class="pp-bar-info"><b id="ppBarTitle"></b><span id="ppBarGuest"></span></div>
    <div class="pp-ctrl">
        <button class="pp-skip" id="ppPrev" type="button" title="Episode sebelumnya">⏮</button>
        <button class="pp-bar-btn" id="ppBarBtn" type="button">▶</button>
        <button class="pp-skip" id="ppNext" type="button" title="Episode berikutnya">⏭</button>
    </div>
    <input type="range" class="pp-seek" id="ppSeek" min="0" max="1000" value="0">
    <span class="pp-time" id="ppTime">0:00 / 0:00</span>
    <input type="range" class="pp-vol" id="ppVol" min="0" max="100" value="100" title="Volume">
    <button class="pp-speed" id="ppSpeed" type="button">1×</button>
    <audio id="ppAudio" preload="metadata"></audio>
</div>

<script>
(function(){
    var bar = document.getElementById('ppBar');
    var audio = document.getElementById('ppAudio');
    var barBtn = document.getElementById('ppBarBtn');
    var coverEl = document.getElementById('ppBarCover');
    var seek = document.getElementById('ppSeek');
    var vol = document.getElementById('ppVol');
    var timeEl = document.getElementById('ppTime');
    var speedBtn = document.getElementById('ppSpeed');
    var PLAY_URL = <?= json_encode($basePlay) ?>;
    var cards = Array.prototype.slice.call(document.querySelectorAll('.pp-card'));
    var currentId = null;
    var counted = {};
    var speeds = [1, 1.25, 1.5, 2, 0.75];
    var speedIdx = 0;

    /* Scroll reveal */
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(es){
            es.forEach(function(en){ if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); } });
        }, { threshold: .12 });
        cards.forEach(function(c){ io.observe(c); });
    } else {
        cards.forEach(function(c){ c.classList.add('in'); });
    }

    function fmt(s){
        if (!isFinite(s)) s = 0;
        var m = Math.floor(s / 60), ss = Math.floor(s % 60);
        return m + ':' + (ss < 10 ? '0' : '') + ss;
    }
    function idxOf(card){ return cards.indexOf(card); }
    function currentCard(){
        return cards.filter(function(c){ return c.getAttribute('data-id') === currentId; })[0] || null;
    }
    function setActive(card){
        cards.forEach(function(c){ c.classList.remove('playing'); });
        if (card) card.classList.add('playing');
    }

    function load(card, autoplay){
        var id = card.getAttribute('data-id');
        currentId = id;
        audio.src = card.getAttribute('data-audio');
        document.getElementById('ppBarTitle').textContent = card.getAttribute('data-title');
        document.getElementById('ppBarGuest').textContent = card.getAttribute('data-guest') || 'Podcast <?= $brandName ?>';
        var cov = card.getAttribute('data-cover');
        coverEl.src = cov !== '' ? cov : '';
        bar.classList.add('show');
        setActive(card);
        if (autoplay !== false) audio.play();
        if (!counted[id]) { counted[id] = true; fetch(PLAY_URL + id).catch(function(){}); }
    }

    function nav(dir){
        var c = currentCard();
        if (!c) return;
        var n = idxOf(c) + dir;
        if (n < 0 || n >= cards.length) return;
        load(cards[n]);
    }

    cards.forEach(function(card){
        card.querySelector('.pp-playbtn').addEventListener('click', function(){
            if (currentId === card.getAttribute('data-id')) {
                audio.paused ? audio.play() : audio.pause();
            } else {
                load(card);
            }
        });
        card.querySelector('.pp-sharebtn').addEventListener('click', function(){
            var url = location.href.split('#')[0] + '#p' + card.getAttribute('data-id');
            if (navigator.clipboard) navigator.clipboard.writeText(url);
            this.textContent = '✅';
            var b = this;
            setTimeout(function(){ b.textContent = '🔗'; }, 1500);
        });
    });

    barBtn.addEventListener('click', function(){ audio.paused ? audio.play() : audio.pause(); });
    document.getElementById('ppPrev').addEventListener('click', function(){ nav(-1); });
    document.getElementById('ppNext').addEventListener('click', function(){ nav(1); });

    audio.addEventListener('play', function(){ barBtn.textContent = '⏸'; coverEl.classList.add('spin'); });
    audio.addEventListener('pause', function(){ barBtn.textContent = '▶'; coverEl.classList.remove('spin'); });
    audio.addEventListener('ended', function(){
        /* Auto-next episode */
        var c = currentCard();
        var n = c ? idxOf(c) + 1 : 0;
        if (n < cards.length) { load(cards[n]); }
        else { barBtn.textContent = '▶'; setActive(null); coverEl.classList.remove('spin'); }
    });
    audio.addEventListener('timeupdate', function(){
        if (audio.duration) seek.value = Math.round((audio.currentTime / audio.duration) * 1000);
        timeEl.textContent = fmt(audio.currentTime) + ' / ' + fmt(audio.duration);
    });
    seek.addEventListener('input', function(){
        if (audio.duration) audio.currentTime = (seek.value / 1000) * audio.duration;
    });
    vol.addEventListener('input', function(){ audio.volume = this.value / 100; });
    speedBtn.addEventListener('click', function(){
        speedIdx = (speedIdx + 1) % speeds.length;
        audio.playbackRate = speeds[speedIdx];
        speedBtn.textContent = speeds[speedIdx] + '×';
    });

    /* Deep-link #p12 */
    var h = location.hash;
    if (h && h.indexOf('#p') === 0) {
        var target = cards.filter(function(c){ return c.getAttribute('data-id') === h.slice(2); })[0];
        if (target) setTimeout(function(){ load(target); target.scrollIntoView({ behavior:'smooth', block:'center' }); }, 400);
    }
})();
</script>