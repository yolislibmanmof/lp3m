<style>
    @keyframes bfFade { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:none} }
    .bf-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:26px; margin-bottom:18px; animation:bfFade .5s both; position:relative; overflow:hidden; }
    .bf-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#ea580c,#f2c063); opacity:.85; }
    .bf-label { display:block; font-size:11px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; color:var(--muted); margin-bottom:7px; }
    .bf-input, .bf-select, .bf-textarea { width:100%; padding:12px 15px; border-radius:12px; border:1px solid var(--border); background:var(--surface); font-size:13.5px; font-weight:600; color:var(--text); font-family:inherit; }
    .bf-textarea { min-height:220px; line-height:1.7; resize:vertical; }
    .bf-input:focus, .bf-select:focus, .bf-textarea:focus { outline:none; border-color:#ea580c; box-shadow:0 0 0 4px rgba(234,88,12,.12); }
    .bf-hint { font-size:11px; color:var(--muted); margin-top:6px; line-height:1.6; }
    .bf-actions { display:flex; gap:12px; }
    .bf-save { padding:14px 28px; border:none; border-radius:13px; font-size:14px; font-weight:900; cursor:pointer; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:0 6px 16px rgba(217,164,65,.35); font-family:var(--font-display); }
    .bf-cancel { padding:14px 24px; border-radius:13px; font-size:14px; font-weight:700; color:var(--muted); background:rgba(255,255,255,.05); border:2px solid var(--border); text-decoration:none; display:inline-flex; align-items:center; }
</style>

<div class="bc-head" style="position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:26px 30px; border-radius:22px; background:linear-gradient(135deg,#7c2d12 0%,#c2410c 55%,#ea580c 100%); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3);">
    <div style="width:56px;height:56px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:26px;background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.55),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b);">✍️</div>
    <div><h2 style="margin:0;font-family:var(--font-display);font-size:21px;font-weight:900;">Tulis Broadcast Baru</h2>
    <p style="margin:3px 0 0;font-size:12.5px;opacity:.9;">Komposisikan pengumuman — tersimpan sebagai draft hingga Anda klik Kirim.</p></div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<form method="post" action="<?= e(url('admin/index.php?page=broadcast-simpan')) ?>">
    <?= csrf_field() ?>
    <div class="bf-card">
        <div style="margin-bottom:16px;">
            <label class="bf-label">Judul / Subjek Email <span style="color:#fca5a5;">*</span></label>
            <input class="bf-input" type="text" name="title" required placeholder="Contoh: Pembukaan Hibah Internal Penelitian 2026">
        </div>
        <div style="margin-bottom:16px;">
            <label class="bf-label">Segment Penerima</label>
            <select class="bf-select" name="segment">
                <?php foreach ($segments as $k => $l): ?>
                <option value="<?= e($k) ?>"><?= e($l) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="bf-hint">💡 <b>Subscriber Publik</b> = pendaftar footer website. Segment role = pengguna aktif dengan role terkait. Email dideduplikasi otomatis.</div>
        </div>
        <div>
            <label class="bf-label">Isi Pengumuman <span style="color:#fca5a5;">*</span></label>
            <textarea class="bf-textarea" name="content" required placeholder="Tulis isi pengumuman di sini...&#10;&#10;Baris baru akan ditampilkan sebagai paragraf pada email."></textarea>
            <div class="bf-hint">✉️ Email dikirim dengan template resmi LP3M (header hijau-emas + footer unsubscribe otomatis untuk subscriber).</div>
        </div>
    </div>
    <div class="bf-actions">
        <button type="submit" class="bf-save">💾 Simpan sebagai Draft</button>
        <a class="bf-cancel" href="<?= e(url('admin/index.php?page=broadcast')) ?>">✖ Batal</a>
    </div>
</form>