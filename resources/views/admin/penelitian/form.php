<style>
    /* ===== Header ===== */
    .rs-form-head { display:flex; align-items:center; gap:16px; margin-bottom:24px; padding:22px 26px; border-radius:22px; background:linear-gradient(135deg,#043b2c,#065f46); color:#fff; position:relative; overflow:hidden; box-shadow:0 12px 32px rgba(0,0,0,.25); }
    .rs-form-ico { width:54px; height:54px; border-radius:16px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:26px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.5),transparent 40%),linear-gradient(145deg,#60a5fa,#3b82f6 50%,#1d4ed8); box-shadow:inset 0 2px 3px rgba(255,255,255,.6),inset 0 -3px 4px rgba(0,0,0,.25),0 6px 14px rgba(59,130,246,.4); position:relative; }
    .rs-form-ico::before { content:''; position:absolute; top:5px; left:10px; width:16px; height:7px; border-radius:50%; background:rgba(255,255,255,.6); filter:blur(1.5px); }
    .rs-form-title { font-family:var(--font-display); font-size:22px; font-weight:900; margin:0; background:linear-gradient(135deg,#fff,#fde68a); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }

    /* ===== Form card ===== */
    .rs-form-card { background:var(--white); border:1px solid var(--border); border-radius:22px; padding:28px; box-shadow:0 6px 20px rgba(0,0,0,.05); }

    /* ===== Field group ===== */
    .fg-3d { margin-bottom:18px; }
    .fg-3d:last-child { margin-bottom:0; }
    .fg-3d > label {
        display:flex; align-items:center; gap:6px;
        font-size:11.5px; font-weight:800; letter-spacing:.06em; text-transform:uppercase;
        color:#065f46; margin-bottom:8px;
    }
    .fg-3d .req { color:#dc2626; }

    .fg-3d input[type="text"],
    .fg-3d input[type="number"],
    .fg-3d select,
    .fg-3d textarea {
        width:100%; padding:12px 14px; border-radius:12px;
        border:2px solid var(--border);
        background:linear-gradient(145deg,#f6faf7,#ffffff);
        font-size:14px; font-weight:600;
        color:#03251f !important; -webkit-text-fill-color:#03251f !important;
        color-scheme:light; font-family:var(--font-body);
        transition:border-color .25s, box-shadow .25s;
        box-shadow:inset 0 2px 4px rgba(0,0,0,.04);
    }
    .fg-3d input:-webkit-autofill,
    .fg-3d input:-webkit-autofill:hover,
    .fg-3d input:-webkit-autofill:focus {
        -webkit-box-shadow:0 0 0 1000px #ffffff inset !important;
        -webkit-text-fill-color:#03251f !important;
        transition:background-color 99999s ease-in-out 0s;
    }
    .fg-3d input::placeholder, .fg-3d textarea::placeholder { color:#9ca3af !important; -webkit-text-fill-color:#9ca3af !important; font-weight:500; }
    .fg-3d input:focus, .fg-3d select:focus, .fg-3d textarea:focus {
        outline:none; border-color:#059669;
        box-shadow:inset 0 2px 4px rgba(0,0,0,.06), 0 0 0 4px rgba(5,150,105,.12);
    }
    .fg-3d select {
        appearance:none; -webkit-appearance:none; cursor:pointer; padding-right:40px;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23059669' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") !important;
        background-repeat:no-repeat !important; background-position:right 14px center !important; background-size:12px 8px !important;
    }
    .fg-3d textarea { resize:vertical; min-height:90px; line-height:1.6; }

    /* ===== Grid 2 kolom ===== */
    .form-row-3d { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    @media (max-width:640px){ .form-row-3d { grid-template-columns:1fr; } }

    /* ===== Status hint ===== */
    .rs-status-hint { display:inline-flex; align-items:center; gap:6px; margin-top:8px; font-size:11.5px; font-weight:700; color:#475569; }
    .rs-status-hint .dot { width:8px; height:8px; border-radius:50%; background:#64748b; }
    .rs-status-hint.is-pub { color:#065f46; }
    .rs-status-hint.is-pub .dot { background:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,.2); }

    /* ===== Buttons ===== */
    .rs-actions { display:flex; gap:12px; flex-wrap:wrap; margin-top:24px; padding-top:20px; border-top:1px dashed var(--border); }
    .btn-save-3d {
        position:relative; overflow:hidden; padding:13px 26px; border:none; border-radius:13px;
        font-size:14px; font-weight:800; color:#03251f; cursor:pointer; font-family:var(--font-display);
        background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441 80%,#a9761b);
        box-shadow:inset 0 2px 3px rgba(255,255,255,.7),inset 0 -2px 3px rgba(0,0,0,.15),0 8px 20px rgba(217,164,65,.4);
        transition:transform .25s, box-shadow .25s;
    }
    .btn-save-3d:hover { transform:translateY(-2px); box-shadow:inset 0 2px 3px rgba(255,255,255,.8),0 14px 30px rgba(217,164,65,.55); }
    .btn-cancel-3d {
        display:inline-flex; align-items:center; gap:6px; padding:13px 22px; border-radius:13px;
        border:2px solid var(--border); text-decoration:none; font-size:14px; font-weight:700; color:var(--muted);
        background:linear-gradient(145deg,#f6faf7,#ffffff); transition:all .25s;
    }
    .btn-cancel-3d:hover { transform:translateY(-2px); border-color:rgba(220,38,38,.35); color:#991b1b; }
</style>

<div class="rs-form-head">
    <div class="rs-form-ico">🔬</div>
    <div><h2 class="rs-form-title"><?= $item !== null ? 'Edit Penelitian' : 'Tambah Penelitian' ?></h2></div>
</div>

<?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= e($action) ?>" class="rs-form-card" id="rs-form">
    <?= csrf_field() ?>
    <?php if ($item !== null): ?><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><?php endif; ?>

    <div class="fg-3d">
        <label>Judul Penelitian <span class="req">*</span></label>
        <input type="text" name="title" id="rs-title" maxlength="200"
               value="<?= e($item['title'] ?? old('title')) ?>" required
               placeholder="Contoh: Analisis Dampak AI terhadap Pembelajaran">
        <div class="field-helper" style="display:flex;justify-content:space-between;margin-top:6px;font-size:11px;color:var(--muted);">
            <span>💡 Judul lengkap penelitian</span>
            <span id="rs-title-count" style="font-weight:800;">0 / 200</span>
        </div>
    </div>

    <div class="form-row-3d">
        <div class="fg-3d">
            <label>Skema</label>
            <select name="scheme">
                <?php foreach (Research::SCHEMES as $k => $l): ?>
                    <option value="<?= e($k) ?>" <?= ($item['scheme'] ?? 'internal') === $k ? 'selected' : '' ?>><?= e($l) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="fg-3d">
            <label>Tahun</label>
            <input type="number" name="year" min="2000" max="2100"
                   value="<?= e($item['year'] ?? old('year', (string)date('Y'))) ?>" required>
        </div>
    </div>

    <div class="form-row-3d">
        <div class="fg-3d">
            <label>Ketua Peneliti <span class="req">*</span></label>
            <input type="text" name="leader" value="<?= e($item['leader'] ?? old('leader')) ?>" required placeholder="Nama ketua peneliti">
        </div>
        <div class="fg-3d">
            <label>Bidang Fokus</label>
            <select name="field">
                <option value="">— Pilih bidang —</option>
                <?php foreach (Research::FIELDS as $k => $l): ?>
                    <option value="<?= e($k) ?>" <?= ($item['field'] ?? '') === $k ? 'selected' : '' ?>><?= e($l) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="fg-3d">
        <label>Anggota Tim <span style="font-weight:600;text-transform:none;letter-spacing:0;color:var(--muted);">(pisahkan koma)</span></label>
        <input type="text" name="members" value="<?= e($item['members'] ?? old('members')) ?>" placeholder="Anggota 1, Anggota 2, ...">
    </div>

    <div class="form-row-3d">
        <div class="fg-3d">
            <label>Dana (Rp)</label>
            <input type="number" name="funding" min="0" value="<?= e($item['funding'] ?? old('funding', '0')) ?>">
        </div>
        <div class="fg-3d">
            <label>Status</label>
            <select name="status" id="rs-status">
                <?php foreach (Research::STATUSES as $k => $l): ?>
                    <option value="<?= e($k) ?>" <?= ($item['status'] ?? 'draft') === $k ? 'selected' : '' ?>><?= e($l) ?></option>
                <?php endforeach; ?>
            </select>
            <span class="rs-status-hint" id="rs-status-hint"><span class="dot"></span><span id="rs-status-text">Hanya tersimpan sebagai draft</span></span>
        </div>
    </div>

    <div class="fg-3d">
        <label>Target Luaran</label>
        <input type="text" name="output_target" value="<?= e($item['output_target'] ?? old('output_target')) ?>" placeholder="Contoh: Publikasi SINTA 2 / HAKI">
    </div>

    <div class="fg-3d">
        <label>Deskripsi</label>
        <textarea name="description" rows="4" placeholder="Ringkasan tujuan, metode, dan luaran..."><?= e($item['description'] ?? old('description')) ?></textarea>
    </div>

    <div class="rs-actions">
        <button type="submit" class="btn-save-3d"><?= $item !== null ? '💾 Simpan Perubahan' : '🔬 Simpan Penelitian' ?></button>
        <a href="<?= e(url('admin/index.php?page=penelitian')) ?>" class="btn-cancel-3d">✖ Batal</a>
    </div>
</form>

<script>
(function(){
    // Counter judul
    var t = document.getElementById('rs-title'), c = document.getElementById('rs-title-count');
    function uc(){ if(!t||!c) return; var n=t.value.length; c.textContent=n+' / 200'; c.style.color = n>180?'#dc2626':(n>140?'#f2c063':'var(--muted)'); }
    if(t){ t.addEventListener('input', uc); uc(); }

    // Hint status
    var sel = document.getElementById('rs-status'), hint = document.getElementById('rs-status-hint'), txt = document.getElementById('rs-status-text');
    var pub = ['didanai','berlangsung','selesai'];
    function us(){
        if(!sel||!hint) return;
        if(pub.indexOf(sel.value) !== -1){ hint.classList.add('is-pub'); txt.textContent='Akan tampil di halaman publik'; }
        else { hint.classList.remove('is-pub'); txt.textContent='Hanya tersimpan sebagai draft'; }
    }
    if(sel){ sel.addEventListener('change', us); us(); }
})();
</script>