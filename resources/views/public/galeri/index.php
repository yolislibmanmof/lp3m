<style>
    .gx-hero { position:relative; overflow:hidden; border-radius:28px; padding:56px 44px; margin-bottom:32px; color:#fff; background:linear-gradient(135deg,#4c1d95 0%,#6d28d9 50%,#7c3aed 100%); box-shadow:0 24px 60px rgba(76,29,149,.35); }
    .gx-hero h1 { font-family:var(--font-display); font-size:clamp(28px,4vw,42px); font-weight:900; margin:0 0 12px; }
    .gx-hero p { opacity:.9; max-width:600px; font-size:16px; line-height:1.6; margin:0; }
    .gx-chips { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:26px; }
    .gx-chip { padding:9px 18px; border-radius:999px; border:1px solid var(--border); background:linear-gradient(145deg,#ffffff,#f6faf7); font-size:13px; font-weight:700; color:var(--text); text-decoration:none; transition:all .25s; }
    .gx-chip:hover { transform:translateY(-2px); border-color:rgba(124,58,237,.4); }
    .gx-chip.active { background:linear-gradient(145deg,#c4b5fd,#a78bfa 50%,#7c3aed); color:#fff; border-color:transparent; box-shadow:0 8px 18px rgba(124,58,237,.35); }
    .gx-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
    @media(max-width:900px){ .gx-grid{grid-template-columns:repeat(2,1fr);} }
    @media(max-width:600px){ .gx-grid{grid-template-columns:1fr;} }
    .gx-item { border-radius:20px; overflow:hidden; border:1px solid var(--border); background:var(--white); box-shadow:0 4px 14px rgba(0,0,0,.05); cursor:pointer; transition:all .3s; }
    .gx-item:hover { transform:translateY(-5px); box-shadow:0 18px 36px rgba(0,0,0,.12); }
    .gx-item img { width:100%; height:220px; object-fit:cover; display:block; transition:transform .6s; }
    .gx-item:hover img { transform:scale(1.06); }
    .gx-cap { padding:16px 18px; }
    .gx-cap h3 { font-size:15px; font-weight:800; color:var(--ink); margin:0 0 6px; }
    .gx-cap span { font-size:12px; color:var(--muted); font-weight:600; }
    .gx-lightbox { position:fixed; inset:0; background:rgba(3,37,31,.88); z-index:9999; display:none; align-items:center; justify-content:center; padding:30px; flex-direction:column; gap:14px; }
    .gx-lightbox.show { display:flex; }
    .gx-lightbox img { max-width:90vw; max-height:78vh; border-radius:16px; box-shadow:0 30px 80px rgba(0,0,0,.5); }
    .gx-lightbox p { color:#fff; font-size:14px; font-weight:700; margin:0; text-align:center; }
    .gx-close { position:absolute; top:20px; right:26px; width:44px; height:44px; border-radius:50%; border:none; background:rgba(255,255,255,.15); color:#fff; font-size:20px; cursor:pointer; }
</style>

<section class="gx-hero">
    <h1>🖼️ Galeri Kegiatan</h1>
    <p>Dokumentasi visual perjalanan penelitian, pengabdian, publikasi, dan kegiatan AIK LP3M.</p>
</section>

<div class="gx-chips">
    <a href="<?= e(url('public/index.php?page=galeri')) ?>" class="gx-chip <?= $cat === '' ? 'active' : '' ?>">Semua</a>
    <?php foreach ($cats as $c): ?>
        <a href="<?= e(url('public/index.php?page=galeri&cat=' . urlencode($c))) ?>" class="gx-chip <?= $cat === $c ? 'active' : '' ?>"><?= e($c) ?></a>
    <?php endforeach; ?>
</div>

<?php if (empty($items)): ?>
    <div style="text-align:center; padding:50px 20px; background:var(--white); border:2px dashed var(--border); border-radius:20px; color:var(--muted); font-weight:600;">
        📷 Belum ada foto pada kategori ini.
    </div>
<?php else: ?>
    <div class="gx-grid">
        <?php foreach ($items as $item): ?>
        <div class="gx-item" data-img="<?= e(upload_url($item['image_path'])) ?>" data-title="<?= e($item['title']) ?>">
            <img src="<?= e(upload_url($item['image_path'])) ?>" alt="<?= e($item['title']) ?>" loading="lazy">
            <div class="gx-cap">
                <h3><?= e($item['title']) ?></h3>
                <span><?= e($item['category']) ?><?= !empty($item['event_date']) ? ' · ' . date('d M Y', strtotime($item['event_date'])) : '' ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Lightbox -->
<div class="gx-lightbox" id="gxBox">
    <button class="gx-close" id="gxClose" aria-label="Tutup">✕</button>
    <img id="gxImg" src="" alt="">
    <p id="gxTitle"></p>
</div>

<script>
(function(){
    var box = document.getElementById('gxBox');
    var img = document.getElementById('gxImg');
    var ttl = document.getElementById('gxTitle');
    document.querySelectorAll('.gx-item').forEach(function(el){
        el.addEventListener('click', function(){
            img.src = el.getAttribute('data-img');
            ttl.textContent = el.getAttribute('data-title');
            box.classList.add('show');
        });
    });
    document.getElementById('gxClose').addEventListener('click', function(){ box.classList.remove('show'); });
    box.addEventListener('click', function(e){ if (e.target === box) box.classList.remove('show'); });
})();
</script>