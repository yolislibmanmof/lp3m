<style>
    @keyframes pfFade { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:none} }
    .pf-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px 26px; margin-bottom:18px; position:relative; overflow:hidden; animation:pfFade .5s both; }
    .pf-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#ea580c,#f2c063); opacity:.85; }
    .pf-title { display:flex; align-items:center; gap:10px; font-size:14.5px; font-weight:900; color:#fff; font-family:var(--font-display); margin:0 0 18px; padding-bottom:13px; border-bottom:1px dashed var(--border); }
    .pf-title .emo { width:32px; height:32px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:15px; background:rgba(234,88,12,.14); }
    .pf-label { display:block; font-size:11px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; color:var(--muted); margin-bottom:7px; }
    .pf-input, .pf-select, .pf-textarea { width:100%; padding:12px 15px; border-radius:12px; border:1px solid var(--border); background:var(--surface); font-size:13.5px; font-weight:600; color:var(--text); font-family:inherit; }
    .pf-textarea { min-height:110px; line-height:1.65; resize:vertical; }
    .pf-input:focus, .pf-select:focus, .pf-textarea:focus { outline:none; border-color:#ea580c; box-shadow:0 0 0 4px rgba(234,88,12,.12); }
    .pf-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .pf-row3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; }
    @media(max-width:700px){ .pf-row, .pf-row3{grid-template-columns:1fr;} }
    .pf-hint { font-size:11px; color:var(--muted); margin-top:6px; line-height:1.6; }
    .pf-preview { margin-top:14px; display:flex; gap:14px; align-items:center; flex-wrap:wrap; padding:14px; border-radius:12px; background:rgba(234,88,12,.05); border:1px dashed rgba(234,88,12,.3); }
    .pf-preview-cover { width:80px; height:80px; object-fit:cover; border-radius:10px; border:1px solid var(--border); background:#0d1d17; display:flex; align-items:center; justify-content:center; font-size:28px; }
    .pf-preview audio { width:100%; max-width:360px; }
    .pf-actions { display:flex; gap:12px; }
    .pf-save { padding:14px 28px; border:none; border-radius:13px; font-size:14px; font-weight:900; cursor:pointer; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:0 6px 16px rgba(217,164,65,.35); font-family:var(--font-display); }
    .pf-cancel { padding:14px 24px; border-radius:13px; font-size:14px; font-weight:700; color:var(--muted); background:rgba(255,255,255,.05); border:2px solid var(--border); text-decoration:none; display:inline-flex; align-items:center; }
</style>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<form method="post" action="<?= e($action) ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <?php if ($item !== null): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>

    <div class="pf-card">
        <h3 class="pf-title"><span class="emo">🎧</span><span>Informasi Episode</span></h3>
        <div class="pf-row" style="margin-bottom:16px;">
            <div>
                <label class="pf-label">Judul Podcast <span style="color:#fca5a5;">*</span></label>
                <input class="pf-input" type="text" name="title" required value="<?= e($item['title'] ?? '') ?>" placeholder="Contoh: Riset & Inovasi LP3M">
            </div>
            <div>
                <label class="pf-label">Episode (opsional)</label>
                <input class="pf-input" type="text" name="episode" value="<?= e($item['episode'] ?? '') ?>" placeholder="01, 02, ...">
            </div>
        </div>
        <div class="pf-row3">
            <div>
                <label class="pf-label">Kategori</label>
                <select class="pf-select" name="category">
                    <?php foreach ($categories as $k => $l): ?>
                    <option value="<?= e($k) ?>" <?= ($item['category'] ?? 'diskusi') === $k ? 'selected' : '' ?>><?= e($l) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="pf-label">Narasumber (opsional)</label>
                <input class="pf-input" type="text" name="guest" value="<?= e($item['guest'] ?? '') ?>" placeholder="Nama narasumber">
            </div>
            <div>
                <label class="pf-label">Durasi (opsional)</label>
                <input class="pf-input" type="text" name="duration" value="<?= e($item['duration'] ?? '') ?>" placeholder="45:12">
            </div>
        </div>
    </div>

    <div class="pf-card" style="animation-delay:.06s">
        <h3 class="pf-title"><span class="emo">🎙️</span><span>Audio & Cover</span></h3>
        <div style="margin-bottom:16px;">
            <label class="pf-label">Upload File Audio (MP3/M4A/OGG, maks 100 MB)</label>
            <input class="pf-input" type="file" id="pf-audio-file" name="audio_file" accept=".mp3,.m4a,.ogg,.wav" style="padding:9px;">
        </div>
        <div style="margin-bottom:16px;">
            <label class="pf-label">Atau URL Audio Eksternal (SoundCloud / Anchor / Podbean)</label>
            <input class="pf-input" type="url" id="pf-audio-url" name="audio_url" value="<?= e($item['audio_path'] ?? '') ?>" placeholder="https://anchor.fm/s/xxxx/episode.mp3">
            <div class="pf-hint">💡 Bila upload file, URL diabaikan. Pilih salah satu saja.</div>
        </div>
        <div style="margin-bottom:16px;">
            <label class="pf-label">Cover Episode (JPG/PNG, maks 2 MB, disarankan 1400×1400)</label>
            <input class="pf-input" type="file" id="pf-cover-file" name="cover_file" accept=".jpg,.jpeg,.png,.webp" style="padding:9px;">
        </div>

        <div class="pf-preview" id="pf-preview">
            <?php
            $cover = $item !== null ? Podcast::coverUrl($item) : '';
            $audio = $item !== null ? Podcast::audioUrl($item) : '';
            ?>
            <div class="pf-preview-cover" id="pf-cover-box">
                <?php if ($cover !== ''): ?>
                    <img src="<?= e($cover) ?>" id="pf-cover-img" style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
                <?php else: ?>
                    <span id="pf-cover-img">🎙️</span>
                <?php endif; ?>
            </div>
            <div style="flex:1; min-width:200px;">
                <div style="font-weight:800; margin-bottom:6px; color:var(--ink);">Preview Audio</div>
                <?php if ($audio !== ''): ?>
                    <audio controls id="pf-audio-player" src="<?= e($audio) ?>" style="width:100%; max-width:360px;"></audio>
                <?php else: ?>
                    <div id="pf-audio-player" style="color:var(--muted); font-size:12px;">Audio belum dipilih.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="pf-card" style="animation-delay:.12s">
        <h3 class="pf-title"><span class="emo">📝</span><span>Deskripsi & Status</span></h3>
        <div style="margin-bottom:16px;">
            <label class="pf-label">Deskripsi</label>
            <textarea class="pf-textarea" name="description" placeholder="Ringkasan isi episode, topik diskusi, narasumber, takeaway..."><?= e($item['description'] ?? '') ?></textarea>
        </div>
        <div>
            <label class="pf-label">Status</label>
            <select class="pf-select" name="status">
                <option value="published" <?= ($item['status'] ?? 'published') === 'published' ? 'selected' : '' ?>>✅ Published</option>
                <option value="draft" <?= ($item['status'] ?? '') === 'draft' ? 'selected' : '' ?>>📝 Draft</option>
            </select>
        </div>
    </div>

    <div class="pf-actions">
        <button type="submit" class="pf-save">💾 Simpan Podcast</button>
        <a class="pf-cancel" href="<?= e(url('admin/index.php?page=podcast')) ?>">✖ Batal</a>
    </div>
</form>

<script>
(function(){
    var audioFile = document.getElementById('pf-audio-file');
    var audioUrl  = document.getElementById('pf-audio-url');
    var coverFile = document.getElementById('pf-cover-file');
    var coverImg  = document.getElementById('pf-cover-img');
    var coverBox  = document.getElementById('pf-cover-box');
    var audioPlayer = document.getElementById('pf-audio-player');

    if (audioFile) audioFile.addEventListener('change', function(){
        if (this.files && this.files[0]) {
            var url = URL.createObjectURL(this.files[0]);
            if (audioPlayer.tagName === 'AUDIO') {
                audioPlayer.src = url;
            } else {
                var a = document.createElement('audio');
                a.controls = true; a.src = url; a.style.width = '100%'; a.style.maxWidth = '360px';
                audioPlayer.parentNode.replaceChild(a, audioPlayer);
                audioPlayer = a;
            }
            if (audioUrl) audioUrl.value = '';
        }
    });
    if (audioUrl) audioUrl.addEventListener('change', function(){
        if (this.value.trim() !== '') {
            if (audioPlayer.tagName === 'AUDIO') {
                audioPlayer.src = this.value.trim();
            } else {
                var a = document.createElement('audio');
                a.controls = true; a.src = this.value.trim(); a.style.width = '100%'; a.style.maxWidth = '360px';
                audioPlayer.parentNode.replaceChild(a, audioPlayer);
                audioPlayer = a;
            }
        }
    });
    if (coverFile) coverFile.addEventListener('change', function(){
        if (this.files && this.files[0]) {
            var url = URL.createObjectURL(this.files[0]);
            if (coverImg.tagName === 'IMG') {
                coverImg.src = url;
            } else {
                var img = document.createElement('img');
                img.src = url; img.id = 'pf-cover-img';
                img.style.cssText = 'width:100%;height:100%;object-fit:cover;border-radius:10px;';
                coverBox.innerHTML = '';
                coverBox.appendChild(img);
            }
        }
    });
})();
</script>