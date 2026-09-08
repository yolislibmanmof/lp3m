<style>
    @keyframes kfFadeUp { from{opacity:0; transform:translateY(14px)} to{opacity:1; transform:none} }
    @keyframes kfShine { 0%{left:-100%} 100%{left:160%} }

    .kf-back { color:var(--muted); text-decoration:none; font-size:13px; font-weight:700; display:inline-flex; align-items:center; gap:6px; transition:all .2s; }
    .kf-back:hover { color:#6ee7b7; transform:translateX(-3px); }
    .kf-head { display:flex; align-items:center; gap:14px; margin:14px 0 22px; animation:kfFadeUp .5s ease both; }
    .kf-head-ico { width:52px; height:52px; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:24px; background:radial-gradient(circle at 30% 25%, rgba(255,255,255,.5), transparent 40%), linear-gradient(145deg,#fde68a,#f2c063 50%,#d9a441); box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -3px 4px rgba(0,0,0,.2), 0 6px 14px rgba(217,164,65,.4); position:relative; flex-shrink:0; }
    .kf-head-ico::before { content:''; position:absolute; top:5px; left:10px; width:16px; height:7px; border-radius:50%; background:rgba(255,255,255,.65); filter:blur(1.5px); }
    .kf-title { font-family:var(--font-display); font-size:24px; font-weight:900; color:#fff; margin:0; }
    .kf-sub { color:var(--muted); font-size:13px; margin:3px 0 0; }

    .kf-card { position:relative; background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:32px; box-shadow:0 10px 30px rgba(0,0,0,.2); max-width:860px; animation:kfFadeUp .5s .05s ease both; }
    .kf-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; border-radius:20px 20px 0 0; background:linear-gradient(90deg,#f2c063,#10b981,#f2c063); opacity:.7; }
    .kf-section-title { display:flex; align-items:center; gap:10px; font-size:14px; font-weight:800; color:#fff; margin:0 0 18px; font-family:var(--font-display); }
    .kf-section-title::before { content:''; width:8px; height:8px; border-radius:50%; background:radial-gradient(circle at 30% 30%, #fde68a, #d9a441); box-shadow:0 0 10px rgba(217,164,65,.6); }

    .kf-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    .kf-group { display:flex; flex-direction:column; gap:8px; }
    .kf-group.full { grid-column:span 2; }
    .kf-label { font-size:11px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; color:#f2c063; display:flex; align-items:center; justify-content:space-between; gap:6px; }
    .kf-input { padding:12px 16px; border-radius:12px; border:1px solid var(--border); background:rgba(255,255,255,.05); color:#fff; font-size:14px; transition:all .25s; font-family:inherit; width:100%; box-sizing:border-box; }
    .kf-input:focus { outline:none; border-color:#10b981; background:rgba(255,255,255,.08); box-shadow:0 0 0 3px rgba(16,185,129,.18), 0 4px 14px rgba(0,0,0,.2); }
    .kf-input::placeholder { color:rgba(255,255,255,.3); }
    textarea.kf-input { resize:vertical; min-height:130px; }
    .kf-hint { color:var(--muted); font-size:11px; }
    .kf-count { font-size:10px; font-weight:800; color:var(--muted); background:rgba(255,255,255,.06); padding:2px 8px; border-radius:999px; }

    /* Toggle Switch */
    .kf-switch { display:flex; align-items:center; gap:12px; cursor:pointer; padding:10px 0; }
    .kf-switch input { position:absolute; opacity:0; width:0; height:0; }
    .kf-slider { width:46px; height:25px; background:rgba(255,255,255,.12); border-radius:999px; position:relative; transition:.3s; border:1px solid var(--border); flex-shrink:0; }
    .kf-slider::after { content:''; position:absolute; top:2px; left:2px; width:19px; height:19px; border-radius:50%; background:#9ca3af; transition:.3s; }
    .kf-switch input:checked + .kf-slider { background:rgba(16,185,129,.4); border-color:rgba(16,185,129,.5); }
    .kf-switch input:checked + .kf-slider::after { left:23px; background:#6ee7b7; box-shadow:0 0 10px rgba(110,231,183,.7); }
    .kf-switch-text { font-size:13px; color:#e2e8f0; font-weight:700; }

    .kf-btn-primary { position:relative; overflow:hidden; background:linear-gradient(145deg,#34d399,#10b981 50%,#059669); color:#fff; padding:12px 26px; border-radius:12px; border:none; font-weight:800; font-size:14px; cursor:pointer; box-shadow: inset 0 2px 3px rgba(255,255,255,.4), inset 0 -2px 3px rgba(0,0,0,.2), 0 8px 18px rgba(5,150,105,.35); transition:all .25s; }
    .kf-btn-primary:hover { transform:translateY(-2px); box-shadow:0 12px 26px rgba(5,150,105,.45); }
    .kf-btn-primary::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); transition:left .6s; }
    .kf-btn-primary:hover::after { left:160%; }
    .kf-btn-ghost { background:transparent; color:var(--muted); padding:12px 24px; border-radius:12px; border:1px solid var(--border); font-weight:700; font-size:14px; text-decoration:none; transition:all .2s; }
    .kf-btn-ghost:hover { background:rgba(255,255,255,.05); color:#fff; border-color:rgba(255,255,255,.2); }

    @media (max-width:700px) { .kf-grid { grid-template-columns:1fr; } .kf-group.full { grid-column:span 1; } }
</style>

<a href="<?= e(url('admin/index.php?page=kontak&tab=faq')) ?>" class="kf-back">← Kembali ke Daftar FAQ</a>

<div class="kf-head">
    <div class="kf-head-ico"><?= $item ? '✏️' : '❓' ?></div>
    <div>
        <h2 class="kf-title"><?= $item ? 'Edit FAQ' : 'Tambah FAQ Baru' ?></h2>
        <p class="kf-sub"><?= $item ? 'Perbarui pertanyaan yang tampil di halaman publik.' : 'Buat pertanyaan umum baru untuk halaman kontak publik.' ?></p>
    </div>
</div>

<div class="kf-card">
    <form method="post" action="<?= e($action) ?>">
        <?= csrf_field() ?>
        <?php if ($item): ?><input type="hidden" name="id" value="<?= $item['id'] ?>"><?php endif; ?>

        <h3 class="kf-section-title">Detail FAQ</h3>
        <div class="kf-grid">
            <div class="kf-group full">
                <label class="kf-label">
                    <span>❓ Pertanyaan *</span>
                    <span class="kf-count" id="qCount">0/250</span>
                </label>
                <input type="text" name="question" id="qInput" maxlength="250" class="kf-input" value="<?= e($item['question'] ?? old('question')) ?>" required placeholder="Contoh: Bagaimana cara mengajukan proposal?">
            </div>

            <div class="kf-group full">
                <label class="kf-label"><span>💬 Jawaban *</span></label>
                <textarea name="answer" class="kf-input" required placeholder="Tulis jawaban lengkap di sini..."><?= e($item['answer'] ?? old('answer')) ?></textarea>
            </div>

            <div class="kf-group">
                <label class="kf-label"><span>🔢 Urutan Tampil</span></label>
                <input type="number" name="sort_order" class="kf-input" value="<?= (int)($item['sort_order'] ?? old('sort_order', 0)) ?>" placeholder="0">
                <small class="kf-hint">Angka lebih kecil muncul lebih atas.</small>
            </div>

            <div class="kf-group">
                <label class="kf-label"><span>⚙️ Status Tampil</span></label>
                <label class="kf-switch">
                    <input type="checkbox" name="is_active" value="1" <?= ($item['is_active'] ?? 1) ? 'checked' : '' ?>>
                    <span class="kf-slider"></span>
                    <span class="kf-switch-text">Aktifkan FAQ di halaman publik</span>
                </label>
            </div>
        </div>

        <div style="display:flex; gap:12px; justify-content:flex-end; margin-top:30px; padding-top:22px; border-top:1px solid var(--border);">
            <a href="<?= e(url('admin/index.php?page=kontak&tab=faq')) ?>" class="kf-btn-ghost">Batal</a>
            <button type="submit" class="kf-btn-primary"><?= $item ? '💾 Simpan Perubahan' : '＋ Tambah FAQ' ?></button>
        </div>
    </form>
</div>

<script>
(function(){
    var q = document.getElementById('qInput');
    var c = document.getElementById('qCount');
    if (q && c) {
        var upd = function(){ c.textContent = q.value.length + '/250'; };
        q.addEventListener('input', upd);
        upd();
    }
})();
</script>