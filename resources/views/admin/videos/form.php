<style>
    @keyframes vfFade { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:none} }
    .vf-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px 26px; margin-bottom:18px; position:relative; overflow:hidden; animation:vfFade .5s both; }
    .vf-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#4338ca,#6366f1,#f2c063); opacity:.85; }
    .vf-title { display:flex; align-items:center; gap:10px; font-size:14.5px; font-weight:900; color:#fff; font-family:var(--font-display); margin:0 0 18px; padding-bottom:13px; border-bottom:1px dashed var(--border); }
    .vf-title .emo { width:32px; height:32px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:15px; background:rgba(99,102,241,.14); }
    .vf-label { display:block; font-size:11px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; color:var(--muted); margin-bottom:7px; }
    .vf-input, .vf-select, .vf-textarea { width:100%; padding:12px 15px; border-radius:12px; border:1px solid var(--border); background:var(--surface); font-size:13.5px; font-weight:600; color:var(--text); font-family:inherit; }
    .vf-textarea { min-height:110px; line-height:1.65; resize:vertical; }
    .vf-input:focus, .vf-select:focus, .vf-textarea:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 4px rgba(99,102,241,.12); }
    .vf-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    @media(max-width:700px){ .vf-row{grid-template-columns:1fr;} }
    .vf-hint { font-size:11px; color:var(--muted); margin-top:6px; line-height:1.6; }
    .vf-prev { margin-top:12px; display:none; }
    .vf-prev img { width:220px; aspect-ratio:16/9; object-fit:cover; border-radius:12px; border:1px solid var(--border); box-shadow:0 8px 20px rgba(0,0,0,.25); }
    .vf-actions { display:flex; gap:12px; }
    .vf-save { padding:14px 28px; border:none; border-radius:13px; font-size:14px; font-weight:900; cursor:pointer; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:0 6px 16px rgba(217,164,65,.35); font-family:var(--font-display); }
    .vf-cancel { padding:14px 24px; border-radius:13px; font-size:14px; font-weight:700; color:var(--muted); background:rgba(255,255,255,.05); border:2px solid var(--border); text-decoration:none; display:inline-flex; align-items:center; }
</style>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<form method="post" action="<?= e($action) ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <?php if ($item !== null): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>

    <div class="vf-card">
        <h3 class="vf-title"><span class="emo">🎬</span><span>Informasi Video</span></h3>
        <div style="margin-bottom:16px;">
            <label class="vf-label">Judul Video <span style="color:#fca5a5;">*</span></label>
            <input class="vf-input" type="text" name="title" required value="<?= e($item['title'] ?? '') ?>" placeholder="Contoh: Seminar Nasional Penelitian 2026">
        </div>
        <div class="vf-row">
            <div>
                <label class="vf-label">Kategori</label>
                <select class="vf-select" name="category">
                    <?php foreach ($categories as $k => $l): ?>
                    <option value="<?= e($k) ?>" <?= ($item['category'] ?? 'lainnya') === $k ? 'selected' : '' ?>><?= e($l) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="vf-label">Status</label>
                <select class="vf-select" name="status">
                    <option value="published" <?= ($item['status'] ?? 'published') === 'published' ? 'selected' : '' ?>>✅ Published</option>
                    <option value="draft" <?= ($item['status'] ?? '') === 'draft' ? 'selected' : '' ?>>📝 Draft</option>
                </select>
            </div>
        </div>
    </div>

    <div class="vf-card" style="animation-delay:.06s">
        <h3 class="vf-title"><span class="emo">🔗</span><span>Sumber Video</span></h3>
        <div style="margin-bottom:16px;">
            <label class="vf-label">Platform</label>
            <select class="vf-select" name="source" id="vf-source">
                <?php foreach ($sources as $k => $l): ?>
                <option value="<?= e($k) ?>" <?= ($item['source'] ?? 'youtube') === $k ? 'selected' : '' ?>><?= e($l) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="vf-box-youtube" style="margin-bottom:16px;">
            <label class="vf-label">URL / ID YouTube</label>
            <input class="vf-input" type="text" id="vf-yt" name="youtube_url" value="<?= e($item['youtube_id'] ? 'https://youtu.be/' . $item['youtube_id'] : '') ?>" placeholder="https://youtu.be/dQw4w9WgXcQ">
            <div class="vf-hint">💡 Mendukung format youtu.be, watch?v=, shorts, live, atau ID 11 karakter. Thumbnail otomatis diambil dari YouTube bila tidak upload manual.</div>
        </div>
        <div id="vf-box-url" style="margin-bottom:16px; display:none;">
            <label class="vf-label">URL Video (Vimeo / MP4 eksternal)</label>
            <input class="vf-input" type="text" name="video_url" value="<?= e($item['video_url'] ?? '') ?>" placeholder="https://vimeo.com/123456789 atau https://cdn.contoh.com/video.mp4">
        </div>
        <div id="vf-box-file" style="margin-bottom:16px; display:none;">
            <label class="vf-label">Atau Unggah File MP4/WEBM (maks 200 MB)</label>
            <input class="vf-input" type="file" name="video_file" accept=".mp4,.webm" style="padding:9px;">
            <div class="vf-hint">⚠️ Pastikan <code>upload_max_filesize</code> & <code>post_max_size</code> di php.ini cukup. Untuk video besar, disarankan pakai YouTube.</div>
        </div>
        <div class="vf-row">
            <div>
                <label class="vf-label">Thumbnail Custom (opsional)</label>
                <input class="vf-input" type="file" name="thumb_file" accept=".jpg,.jpeg,.png,.webp" style="padding:9px;">
            </div>
            <div>
                <label class="vf-label">Durasi (opsional)</label>
                <input class="vf-input" type="text" name="duration" value="<?= e($item['duration'] ?? '') ?>" placeholder="12:34">
            </div>
        </div>
        <div class="vf-prev" id="vf-prev"><img id="vf-prev-img" src="" alt="Preview"></div>
    </div>

    <div class="vf-card" style="animation-delay:.12s">
        <h3 class="vf-title"><span class="emo">📝</span><span>Deskripsi</span></h3>
        <textarea class="vf-textarea" name="description" placeholder="Ringkasan isi video, pemateri, tanggal kegiatan..."><?= e($item['description'] ?? '') ?></textarea>
    </div>

    <div class="vf-actions">
        <button type="submit" class="vf-save">💾 Simpan Video</button>
        <a class="vf-cancel" href="<?= e(url('admin/index.php?page=video')) ?>">✖ Batal</a>
    </div>
</form>

<script>
(function(){
    var src = document.getElementById('vf-source');
    var boxYt = document.getElementById('vf-box-youtube');
    var boxUrl = document.getElementById('vf-box-url');
    var boxFile = document.getElementById('vf-box-file');
    var yt = document.getElementById('vf-yt');
    var prev = document.getElementById('vf-prev');
    var prevImg = document.getElementById('vf-prev-img');

    function sync() {
        var v = src.value;
        boxYt.style.display = v === 'youtube' ? '' : 'none';
        boxUrl.style.display = v === 'vimeo' ? '' : (v === 'mp4' ? 'none' : 'none');
        if (v === 'mp4') boxUrl.style.display = ''; // mp4 boleh URL eksternal juga
        boxFile.style.display = v === 'mp4' ? '' : 'none';
        preview();
    }
    function preview() {
        if (src.value === 'youtube' && yt && yt.value.trim() !== '') {
            var m = yt.value.match(/(?:youtu\.be\/|v=|\/embed\/|\/shorts\/|\/live\/)([A-Za-z0-9_-]{11})/) || yt.value.match(/^([A-Za-z0-9_-]{11})$/);
            if (m) { prev.style.display = ''; prevImg.src = 'https://i.ytimg.com/vi/' + m[1] + '/hqdefault.jpg'; return; }
        }
        prev.style.display = 'none';
    }
    if (src) src.addEventListener('change', sync);
    if (yt) yt.addEventListener('input', preview);
    sync();
})();
</script>