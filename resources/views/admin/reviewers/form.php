<style>
    @keyframes rvfFade { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:none; } }
    @keyframes rvfShine { 0%,55% { left:-90%; } 100% { left:165%; } }

    .rvf-head { display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:22px 26px; border-radius:22px; background:linear-gradient(135deg,#1e1b4b 0%,#3730a3 55%,#4f46e5 100%); color:#fff; position:relative; overflow:hidden; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:rvfFade .5s both; }
    .rvf-head::after { content:''; position:absolute; top:-50%; right:-10%; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.22),transparent 70%); pointer-events:none; }
    .rvf-avatar { width:58px; height:58px; border-radius:18px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-size:22px; font-weight:900; color:#03251f; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.6),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), inset 0 -3px 5px rgba(0,0,0,.22), 0 6px 16px rgba(217,164,65,.4); position:relative; z-index:1; letter-spacing:.02em; }
    .rvf-title { font-family:var(--font-display); font-size:21px; font-weight:900; letter-spacing:-.02em; margin:0; color:#fff; position:relative; z-index:1; }
    .rvf-sub { font-size:12.5px; opacity:.88; margin:3px 0 0; position:relative; z-index:1; }
    .rvf-badge { margin-left:auto; padding:4px 12px; border-radius:999px; font-size:10px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; background:rgba(255,255,255,.16); border:1px solid rgba(255,255,255,.32); position:relative; z-index:1; }

    .rvf-flash { position:relative; padding:14px 18px; margin-bottom:18px; border-radius:14px; font-size:13.5px; font-weight:700; display:flex; align-items:center; gap:10px; overflow:hidden; animation:rvfFade .4s both; }
    .rvf-flash::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:rvfShine 3s ease-in-out infinite; }
    .rvf-flash.ok { background:linear-gradient(145deg,#d1fae5,#a7f3d0); border:1px solid rgba(16,185,129,.35); color:#065f46; }
    .rvf-flash.err { background:linear-gradient(145deg,#fee2e2,#fecaca); border:1px solid rgba(220,38,38,.35); color:#991b1b; }

    .rvf-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px 26px; margin-bottom:18px; position:relative; overflow:hidden; animation:rvfFade .5s both; }
    .rvf-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#818cf8,#4f46e5,var(--gold-strong)); opacity:.8; }
    .rvf-card-title { display:flex; align-items:center; gap:10px; font-size:14.5px; font-weight:900; color:#fff; font-family:var(--font-display); margin:0 0 20px; padding-bottom:13px; border-bottom:1px dashed var(--border); }
    .rvf-card-title .emo { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:10px; background:linear-gradient(145deg,rgba(255,255,255,.08),rgba(255,255,255,.03)); border:1px solid var(--border); font-size:15px; }
    .rvf-card-title .num { margin-left:auto; font-size:10px; font-weight:900; letter-spacing:.1em; color:var(--muted); }

    .rvf-field { margin-bottom:18px; }
    .rvf-field:last-child { margin-bottom:0; }
    .rvf-label { display:flex; align-items:center; gap:8px; font-size:11.5px; font-weight:850; letter-spacing:.08em; text-transform:uppercase; color:#cfe7dd; margin-bottom:8px; }
    .rvf-req { padding:1px 8px; border-radius:999px; font-size:8.5px; font-weight:900; background:rgba(220,38,38,.15); color:#fca5a5; border:1px solid rgba(220,38,38,.4); }
    .rvf-opt { padding:1px 8px; border-radius:999px; font-size:8.5px; font-weight:800; background:rgba(255,255,255,.08); color:rgba(255,255,255,.6); border:1px solid rgba(255,255,255,.15); }
    .rvf-count { margin-left:auto; font-family:var(--font-display); font-size:10px; font-weight:800; color:var(--muted); background:rgba(255,255,255,.06); padding:2px 8px; border-radius:6px; }
    .rvf-rp { margin-left:auto; font-family:var(--font-display); font-size:11px; font-weight:900; color:#fde68a; background:rgba(217,164,65,.14); border:1px solid rgba(217,164,65,.3); padding:2px 10px; border-radius:6px; }

    .rvf-input, .rvf-select, .rvf-textarea { width:100%; padding:13px 16px; border-radius:13px; border:2px solid var(--border); background:linear-gradient(145deg,rgba(255,255,255,.05),rgba(255,255,255,.02)); font-size:14px; font-weight:600; color:var(--text); outline:none; transition:all .25s; font-family:inherit; color-scheme:dark; }
    .rvf-input::placeholder, .rvf-textarea::placeholder { color:rgba(255,255,255,.35); font-weight:500; }
    .rvf-input:focus, .rvf-select:focus, .rvf-textarea:focus { border-color:var(--gold-strong); background:rgba(255,255,255,.08); box-shadow:0 0 0 4px rgba(217,164,65,.16), 0 4px 12px rgba(217,164,65,.14); }
    .rvf-select { appearance:none; -webkit-appearance:none; cursor:pointer; padding-right:44px; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23f2c063' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 16px center; }
    .rvf-select option { background:#0d1d17; color:#eaf5f0; }
    .rvf-textarea { min-height:110px; resize:vertical; line-height:1.7; }
    .rvf-row2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    @media (max-width:700px){ .rvf-row2 { grid-template-columns:1fr; } }
    .rvf-hint { margin-top:7px; font-size:11px; color:var(--muted); }

    /* Preview chip keahlian */
    .rvf-chips { display:flex; gap:7px; flex-wrap:wrap; margin-top:10px; min-height:4px; }
    .rvf-chipx { display:inline-flex; align-items:center; gap:6px; padding:5px 13px; border-radius:999px; font-size:11.5px; font-weight:800; background:rgba(129,140,248,.14); color:#c7d2fe; border:1px solid rgba(129,140,248,.4); animation:rvfFade .3s both; }
    .rvf-chipx i { font-style:normal; opacity:.6; font-size:10px; }

    /* Toggle chip aktif */
    .rvf-chk { position:relative; cursor:pointer; display:inline-flex; }
    .rvf-chk input { position:absolute; inset:0; opacity:0; cursor:pointer; }
    .rvf-chk span { display:inline-flex; align-items:center; gap:9px; padding:11px 20px; border-radius:999px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--muted); font-size:12.5px; font-weight:800; transition:all .2s; }
    .rvf-chk span::before { content:''; width:16px; height:16px; border-radius:6px; border:2px solid var(--border); background:transparent; transition:all .2s; flex-shrink:0; }
    .rvf-chk:hover span { border-color:rgba(217,164,65,.4); color:var(--text); }
    .rvf-chk input:checked + span { background:rgba(16,185,129,.14); border-color:rgba(16,185,129,.5); color:#6ee7b7; }
    .rvf-chk input:checked + span::before { content:'✓'; font-size:10px; font-weight:900; color:#03251f; background:linear-gradient(145deg,#6ee7b7,#059669); border-color:transparent; display:flex; align-items:center; justify-content:center; }

    .rvf-actions { display:flex; gap:12px; flex-wrap:wrap; align-items:center; }
    .rvf-btn-gold { position:relative; overflow:hidden; padding:14px 28px; border:none; border-radius:13px; font-size:14px; font-weight:850; color:#03251f; cursor:pointer; background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441 80%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.15), 0 8px 20px rgba(217,164,65,.4); font-family:var(--font-display); transition:all .25s; }
    .rvf-btn-gold::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:rvfShine 3s ease-in-out infinite; }
    .rvf-btn-gold:hover { transform:translateY(-2px); }
    .rvf-btn-gold:disabled { opacity:.6; cursor:not-allowed; }
    .rvf-btn-ghost { padding:14px 24px; border-radius:13px; font-size:14px; font-weight:700; color:var(--muted); background:linear-gradient(145deg,rgba(255,255,255,.06),rgba(255,255,255,.03)); border:2px solid var(--border); text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all .25s; }
    .rvf-btn-ghost:hover { border-color:rgba(220,38,38,.45); color:#fca5a5; transform:translateY(-2px); }
</style>

<?php if (!empty($flash)): ?>
<div class="rvf-flash <?= $flash['type'] === 'error' ? 'err' : 'ok' ?>"><?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?></div>
<?php endif; ?>

<div class="rvf-head">
    <div class="rvf-avatar" id="rvf-avatar">👤</div>
    <div style="position:relative; z-index:1; flex:1; min-width:0;">
        <h2 class="rvf-title"><?= $item !== null ? 'Edit Data Reviewer' : 'Tambah Reviewer Baru' ?></h2>
        <p class="rvf-sub"><?= $item !== null ? 'Perbarui profil, keahlian, dan informasi honorarium reviewer.' : 'Daftarkan dosen/reviewer internal maupun eksternal untuk penugasan review.' ?></p>
    </div>
    <span class="rvf-badge"><?= $item !== null ? '✎ Edit' : '＋ Baru' ?></span>
</div>

<form method="post" action="<?= e($action) ?>" id="rvf-form">
    <?= csrf_field() ?>
    <?php if ($item !== null): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>

    <!-- BAGIAN 1 -->
    <div class="rvf-card">
        <h3 class="rvf-card-title"><span class="emo">🪪</span><span>Identitas Reviewer</span><span class="num">BAGIAN 1 / 3</span></h3>
        <div class="rvf-field">
            <label class="rvf-label">Nama Lengkap & Gelar <span class="rvf-req">WAJIB</span><span class="rvf-count" id="rvf-ncount">0/120</span></label>
            <input class="rvf-input" type="text" name="name" id="rvf-name" maxlength="120" required
                   value="<?= e($item['name'] ?? old('name')) ?>" placeholder="Contoh: Prof. Dr. Ahmad Zaini, M.Pd.">
        </div>
        <div class="rvf-row2">
            <div class="rvf-field">
                <label class="rvf-label">Email <span class="rvf-opt">OPSIONAL</span></label>
                <input class="rvf-input" type="email" name="email" value="<?= e($item['email'] ?? old('email')) ?>" placeholder="nama@kampus.ac.id">
            </div>
            <div class="rvf-field">
                <label class="rvf-label">No. HP / WhatsApp <span class="rvf-opt">OPSIONAL</span></label>
                <input class="rvf-input" type="text" name="phone" value="<?= e($item['phone'] ?? old('phone')) ?>" placeholder="0812xxxxxxxx">
            </div>
        </div>
        <div class="rvf-row2">
            <div class="rvf-field">
                <label class="rvf-label">NIDN / NIP <span class="rvf-opt">OPSIONAL</span></label>
                <input class="rvf-input" type="text" name="nidn" value="<?= e($item['nidn'] ?? old('nidn')) ?>" placeholder="Nomor induk dosen/pegawai">
            </div>
            <div class="rvf-field">
                <label class="rvf-label">Institusi <span class="rvf-opt">OPSIONAL</span></label>
                <input class="rvf-input" type="text" name="institution" value="<?= e($item['institution'] ?? old('institution')) ?>" placeholder="UNIMOF / kampus lain">
            </div>
        </div>
    </div>

    <!-- BAGIAN 2 -->
    <div class="rvf-card" style="animation-delay:.06s">
        <h3 class="rvf-card-title"><span class="emo">🎓</span><span>Keahlian & Klasifikasi</span><span class="num">BAGIAN 2 / 3</span></h3>
        <div class="rvf-field">
            <label class="rvf-label">Bidang Keahlian <span class="rvf-opt">PISAHKAN KOMA</span></label>
            <input class="rvf-input" type="text" name="expertise" id="rvf-exp"
                   value="<?= e($item['expertise'] ?? old('expertise')) ?>" placeholder="Pendidikan, Kurikulum, Evaluasi Pembelajaran">
            <div class="rvf-chips" id="rvf-chips"></div>
            <div class="rvf-hint">💡 Chip di atas adalah preview bidang keahlian yang tersimpan.</div>
        </div>
        <div class="rvf-row2">
            <div class="rvf-field">
                <label class="rvf-label">Tipe Reviewer</label>
                <select class="rvf-select" name="type" id="rvf-type">
                    <option value="internal" <?= ($item['type'] ?? 'internal') === 'internal' ? 'selected' : '' ?>>🏠 Internal — Dosen LP3M UNIMOF</option>
                    <option value="eksternal" <?= ($item['type'] ?? '') === 'eksternal' ? 'selected' : '' ?>>🌐 Eksternal — Reviewer luar institusi</option>
                </select>
                <div class="rvf-hint" id="rvf-type-hint">Reviewer internal tidak memerlukan honorarium transfer antar-bank.</div>
            </div>
            <div class="rvf-field">
                <label class="rvf-label">Status Penugasan</label>
                <label class="rvf-chk">
                    <input type="checkbox" name="is_active" value="1" <?= ($item['is_active'] ?? 1) ? 'checked' : '' ?>>
                    <span>✅ Reviewer aktif & dapat ditugaskan</span>
                </label>
            </div>
        </div>
    </div>

    <!-- BAGIAN 3 -->
    <div class="rvf-card" style="animation-delay:.12s">
        <h3 class="rvf-card-title"><span class="emo">💰</span><span>Honorarium & Catatan</span><span class="num">BAGIAN 3 / 3</span></h3>
        <div class="rvf-row2">
            <div class="rvf-field">
                <label class="rvf-label">Honorarium Standar (Rp)<span class="rvf-rp" id="rvf-rp">Rp 0</span></label>
                <input class="rvf-input" type="number" name="honorarium_standard" id="rvf-honor" min="0"
                       value="<?= e($item['honorarium_standard'] ?? old('honorarium_standard', '0')) ?>">
                <div class="rvf-hint">💰 Nilai per paket review yang menjadi standar penugasan.</div>
            </div>
            <div class="rvf-field">
                <label class="rvf-label">Rekening Bank <span class="rvf-opt">OPSIONAL</span></label>
                <input class="rvf-input" type="text" name="bank_account" value="<?= e($item['bank_account'] ?? old('bank_account')) ?>" placeholder="Bank XXX 123456789 a.n. Nama">
            </div>
        </div>
        <div class="rvf-field">
            <label class="rvf-label">Catatan Internal <span class="rvf-opt">OPSIONAL</span></label>
            <textarea class="rvf-textarea" name="notes" rows="3" placeholder="Catatan khusus: ketersediaan waktu, beban review maksimal, dll..."><?= e($item['notes'] ?? old('notes')) ?></textarea>
        </div>
    </div>

    <div class="rvf-actions">
        <button type="submit" class="rvf-btn-gold" id="rvf-save"><?= $item !== null ? '💾 Simpan Perubahan' : '➕ Simpan Reviewer' ?></button>
        <a href="<?= e(url('admin/index.php?page=reviewers')) ?>" class="rvf-btn-ghost">✖ Batal</a>
    </div>
</form>

<script>
(function(){
    // Avatar inisial + counter nama
    var name = document.getElementById('rvf-name');
    var av = document.getElementById('rvf-avatar');
    var nc = document.getElementById('rvf-ncount');
    if (name) {
        var un = function(){
            if (nc) nc.textContent = name.value.length + '/120';
            if (av) {
                var parts = name.value.trim().split(/\s+/).filter(function(w){ return w.length > 1 && !/^[.,]/.test(w); });
                if (parts.length === 0) { av.textContent = '👤'; return; }
                var init = (parts[0][0] || '') + (parts[1] ? parts[1][0] : (parts[0][1] || ''));
                av.textContent = init.toUpperCase();
            }
        };
        name.addEventListener('input', un); un();
    }

    // Preview chip keahlian
    var exp = document.getElementById('rvf-exp');
    var chips = document.getElementById('rvf-chips');
    if (exp && chips) {
        var ue = function(){
            chips.innerHTML = '';
            exp.value.split(',').forEach(function(s){
                var t = s.trim();
                if (t === '') return;
                var el = document.createElement('span');
                el.className = 'rvf-chipx';
                el.innerHTML = '<i>🎓</i>' + t.replace(/[<>&]/g, '');
                chips.appendChild(el);
            });
        };
        exp.addEventListener('input', ue); ue();
    }

    // Format honorarium live
    var honor = document.getElementById('rvf-honor');
    var rp = document.getElementById('rvf-rp');
    if (honor && rp) {
        var uh = function(){
            var v = parseInt(honor.value || '0', 10);
            if (isNaN(v)) v = 0;
            rp.textContent = 'Rp ' + v.toLocaleString('id-ID');
        };
        honor.addEventListener('input', uh); uh();
    }

    // Hint tipe reviewer
    var type = document.getElementById('rvf-type');
    var th = document.getElementById('rvf-type-hint');
    if (type && th) {
        var ut = function(){
            th.textContent = type.value === 'internal'
                ? 'Reviewer internal tidak memerlukan honorarium transfer antar-bank.'
                : 'Reviewer eksternal: pastikan rekening bank terisi untuk transfer honorarium.';
        };
        type.addEventListener('change', ut); ut();
    }

    // Disable tombol saat submit
    var form = document.getElementById('rvf-form'), save = document.getElementById('rvf-save');
    if (form && save) form.addEventListener('submit', function(){ save.disabled = true; save.textContent = '⏳ Menyimpan...'; });
})();
</script>