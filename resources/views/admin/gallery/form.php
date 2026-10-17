<style>
    .gf-card { position:relative; background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:32px; box-shadow:0 10px 30px rgba(0,0,0,.2); max-width:760px; }
    .gf-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; border-radius:20px 20px 0 0; background:linear-gradient(90deg,#f2c063,#7c3aed,#f2c063); opacity:.7; }
    .gf-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    .gf-group { display:flex; flex-direction:column; gap:8px; }
    .gf-group.full { grid-column:span 2; }
    .gf-label { font-size:11px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; color:#f2c063; }
    .gf-input { padding:12px 16px; border-radius:12px; border:1px solid var(--border); background:rgba(255,255,255,.05); color:#fff; font-size:14px; transition:all .25s; font-family:inherit; width:100%; box-sizing:border-box; }
    .gf-input:focus { outline:none; border-color:#10b981; background:rgba(255,255,255,.08); box-shadow:0 0 0 3px rgba(16,185,129,.18); }
    .gf-input::placeholder { color:rgba(255,255,255,.3); }
    .gf-preview { margin-top:10px; border-radius:14px; border:1px dashed var(--border); padding:10px; display:none; }
    .gf-preview img { width:100%; max-height:240px; object-fit:cover; border-radius:10px; display:block; }
    @media (max-width:700px){ .gf-grid{grid-template-columns:1fr;} .gf-group.full{grid-column:span 1;} }
</style>

<a href="<?= e(url('admin/index.php?page=galeri')) ?>" style="color:var(--muted); text-decoration:none; font-size:13px; font-weight:700; display:inline-flex; align-items:center; gap:6px; margin-bottom:14px;">← Kembali ke Galeri</a>
<h2 style="font-family:var(--font-display); font-size:24px; font-weight:900; color:#fff; margin:0 0 22px;"><?= $item ? '✏️ Edit Foto' : '📷 Unggah Foto Baru' ?></h2>

<div class="gf-card">
    <form method="post" action="<?= e($action) ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <?php if ($item): ?><input type="hidden" name="id" value="<?= $item['id'] ?>"><?php endif; ?>

        <div class="gf-grid">
            <div class="gf-group full">
                <label class="gf-label">📌 Judul Foto *</label>
                <input type="text" name="title" class="gf-input" value="<?= e($item['title'] ?? '') ?>" required placeholder="Contoh: Workshop Penulisan Jurnal 2026">
            </div>

            <div class="gf-group">
                <label class="gf-label">🏷️ Kategori</label>
                <input type="text" name="category" class="gf-input" value="<?= e($item['category'] ?? 'Kegiatan') ?>" placeholder="Penelitian / Pengabdian / AIK...">
            </div>

            <div class="gf-group">
                <label class="gf-label">📅 Tanggal Kegiatan (opsional)</label>
                <input type="date" name="event_date" class="gf-input" value="<?= e($item['event_date'] ?? '') ?>" style="color-scheme:dark;">
            </div>

            <div class="gf-group full">
                <label class="gf-label">🖼️ Gambar <?= $item ? '(kosongkan jika tidak diganti)' : '*' ?></label>
                <input type="file" name="image" id="gfFile" class="gf-input" accept=".jpg,.jpeg,.png,.webp" <?= $item ? '' : 'required' ?> style="padding:10px;">
                <div class="gf-preview" id="gfPreview"><img id="gfPreviewImg" src="" alt="Preview"></div>
                <?php if ($item): ?>
                    <div style="margin-top:10px;"><img src="<?= e(upload_url($item['image_path'])) ?>" alt="Foto saat ini" style="width:120px; height:80px; object-fit:cover; border-radius:10px; border:1px solid var(--border);"></div>
                <?php endif; ?>
            </div>

            <div class="gf-group full">
                <label class="gf-label">📝 Deskripsi (opsional)</label>
                <textarea name="description" class="gf-input" rows="3" placeholder="Ceritakan singkat kegiatan pada foto ini..."><?= e($item['description'] ?? '') ?></textarea>
            </div>
        </div>

        <div style="display:flex; gap:12px; justify-content:flex-end; margin-top:28px; padding-top:20px; border-top:1px solid var(--border);">
            <a href="<?= e(url('admin/index.php?page=galeri')) ?>" style="background:transparent; color:var(--muted); padding:12px 24px; border-radius:12px; border:1px solid var(--border); font-weight:700; text-decoration:none;">Batal</a>
            <button type="submit" style="background:linear-gradient(145deg,#34d399,#10b981 50%,#059669); color:#fff; padding:12px 26px; border-radius:12px; border:none; font-weight:800; cursor:pointer; box-shadow:0 8px 18px rgba(5,150,105,.35);"><?= $item ? '💾 Simpan Perubahan' : '＋ Unggah Foto' ?></button>
        </div>
    </form>
</div>

<script>
(function(){
    var f = document.getElementById('gfFile');
    var box = document.getElementById('gfPreview');
    var img = document.getElementById('gfPreviewImg');
    if (f && box && img) {
        f.addEventListener('change', function(){
            if (f.files && f.files[0]) {
                img.src = URL.createObjectURL(f.files[0]);
                box.style.display = 'block';
            }
        });
    }
})();
</script>