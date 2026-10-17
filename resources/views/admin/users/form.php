<style>
    @keyframes ufFade { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:none} }
    @keyframes ufShine { 0%,55%{left:-90%} 100%{left:165%} }

    .uf-head { display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:22px 26px; border-radius:22px; background:linear-gradient(135deg,#1e1b4b 0%,#3730a3 55%,#4f46e5 100%); color:#fff; position:relative; overflow:hidden; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:ufFade .5s both; }
    .uf-head::after { content:''; position:absolute; top:-50%; right:-10%; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.22),transparent 70%); pointer-events:none; }
    .uf-head-ico { width:54px; height:54px; border-radius:16px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:25px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.55),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), 0 6px 16px rgba(217,164,65,.4); position:relative; z-index:1; }
    .uf-head h2 { margin:0; font-family:var(--font-display); font-size:21px; font-weight:900; position:relative; z-index:1; }
    .uf-head p { margin:3px 0 0; font-size:12.5px; opacity:.88; position:relative; z-index:1; }
    .uf-badge { margin-left:auto; padding:4px 12px; border-radius:999px; font-size:10px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; background:rgba(255,255,255,.16); border:1px solid rgba(255,255,255,.32); position:relative; z-index:1; }

    .uf-flash { position:relative; padding:14px 18px; margin-bottom:18px; border-radius:14px; font-size:13.5px; font-weight:700; display:flex; align-items:center; gap:10px; overflow:hidden; }
    .uf-flash.ok { background:linear-gradient(145deg,#d1fae5,#a7f3d0); border:1px solid rgba(16,185,129,.35); color:#065f46; }
    .uf-flash.err { background:linear-gradient(145deg,#fee2e2,#fecaca); border:1px solid rgba(220,38,38,.35); color:#991b1b; }

    .uf-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px 26px; margin-bottom:18px; position:relative; overflow:hidden; animation:ufFade .5s both; }
    .uf-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#818cf8,#4f46e5,var(--gold-strong)); opacity:.85; }
    .uf-card-title { display:flex; align-items:center; gap:10px; font-size:14.5px; font-weight:900; color:#fff; font-family:var(--font-display); margin:0 0 20px; padding-bottom:13px; border-bottom:1px dashed var(--border); }
    .uf-card-title .emo { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:10px; background:linear-gradient(145deg,rgba(255,255,255,.08),rgba(255,255,255,.03)); border:1px solid var(--border); font-size:15px; }
    .uf-card-title .num { margin-left:auto; font-size:10px; font-weight:900; letter-spacing:.1em; color:var(--muted); }

    .uf-field { margin-bottom:18px; }
    .uf-field:last-child { margin-bottom:0; }
    .uf-label { display:flex; align-items:center; gap:8px; font-size:11.5px; font-weight:850; letter-spacing:.08em; text-transform:uppercase; color:#cfe7dd; margin-bottom:8px; }
    .uf-req { padding:1px 8px; border-radius:999px; font-size:8.5px; font-weight:900; background:rgba(220,38,38,.15); color:#fca5a5; border:1px solid rgba(220,38,38,.4); }
    .uf-opt { padding:1px 8px; border-radius:999px; font-size:8.5px; font-weight:800; background:rgba(255,255,255,.08); color:rgba(255,255,255,.6); border:1px solid rgba(255,255,255,.15); }
    .uf-input, .uf-select { width:100%; padding:13px 16px; border-radius:13px; border:2px solid var(--border); background:linear-gradient(145deg,rgba(255,255,255,.05),rgba(255,255,255,.02)); font-size:14px; font-weight:600; color:var(--text); outline:none; transition:all .25s; font-family:inherit; }
    .uf-input::placeholder { color:rgba(255,255,255,.35); font-weight:500; }
    .uf-input:focus, .uf-select:focus { border-color:var(--gold-strong); background:rgba(255,255,255,.08); box-shadow:0 0 0 4px rgba(217,164,65,.16); }
    .uf-select { appearance:none; -webkit-appearance:none; cursor:pointer; padding-right:44px; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23f2c063' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 16px center; }
    .uf-select option { background:#0d1d17; color:#eaf5f0; }
    .uf-row2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    @media(max-width:700px){ .uf-row2{grid-template-columns:1fr;} }
    .uf-hint { margin-top:7px; font-size:11px; color:var(--muted); line-height:1.6; }
    .uf-role-desc { margin-top:8px; padding:10px 14px; border-radius:11px; background:rgba(129,140,248,.1); border:1px solid rgba(129,140,248,.35); color:#c7d2fe; font-size:12px; font-weight:700; }

    .uf-passwrap { position:relative; }
    .uf-passwrap .uf-input { padding-right:96px; font-family:'Courier New',monospace; letter-spacing:.05em; }
    .uf-passbtns { position:absolute; right:8px; top:50%; transform:translateY(-50%); display:flex; gap:5px; }
    .uf-mini { padding:7px 10px; border-radius:9px; border:1px solid var(--border); background:rgba(255,255,255,.05); color:var(--muted); font-size:11px; font-weight:800; cursor:pointer; transition:all .2s; }
    .uf-mini:hover { border-color:rgba(217,164,65,.45); color:var(--gold-strong); }

    .uf-chk { position:relative; cursor:pointer; display:inline-flex; }
    .uf-chk input { position:absolute; inset:0; opacity:0; cursor:pointer; }
    .uf-chk span { display:inline-flex; align-items:center; gap:9px; padding:11px 20px; border-radius:999px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--muted); font-size:12.5px; font-weight:800; transition:all .2s; }
    .uf-chk span::before { content:''; width:16px; height:16px; border-radius:6px; border:2px solid var(--border); transition:all .2s; }
    .uf-chk input:checked + span { background:rgba(16,185,129,.14); border-color:rgba(16,185,129,.5); color:#6ee7b7; }
    .uf-chk input:checked + span::before { content:'✓'; font-size:10px; font-weight:900; color:#03251f; background:linear-gradient(145deg,#6ee7b7,#059669); border-color:transparent; display:flex; align-items:center; justify-content:center; }

    .uf-actions { display:flex; gap:12px; flex-wrap:wrap; }
    .uf-btn-gold { position:relative; overflow:hidden; padding:14px 28px; border:none; border-radius:13px; font-size:14px; font-weight:850; color:#03251f; cursor:pointer; background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441 80%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.7), 0 8px 20px rgba(217,164,65,.4); font-family:var(--font-display); transition:all .25s; }
    .uf-btn-gold::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:ufShine 3s ease-in-out infinite; }
    .uf-btn-gold:hover { transform:translateY(-2px); }
    .uf-btn-ghost { padding:14px 24px; border-radius:13px; font-size:14px; font-weight:700; color:var(--muted); background:rgba(255,255,255,.05); border:2px solid var(--border); text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all .25s; }
    .uf-btn-ghost:hover { border-color:rgba(220,38,38,.45); color:#fca5a5; }
</style>

<?php if (!empty($flash)): ?>
<div class="uf-flash <?= $flash['type'] === 'error' ? 'err' : 'ok' ?>"><?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?></div>
<?php endif; ?>

<div class="uf-head">
    <div class="uf-head-ico">👤</div>
    <div style="position:relative;z-index:1;flex:1;min-width:0;">
        <h2><?= $item !== null ? 'Edit Pengguna' : 'Tambah Pengguna Baru' ?></h2>
        <p><?= $item !== null ? 'Perbarui identitas, role, dan status akun.' : 'Buat akun dengan role & hak akses tertentu.' ?></p>
    </div>
    <span class="uf-badge"><?= $item !== null ? '✎ Edit' : '＋ Baru' ?></span>
</div>

<form method="post" action="<?= e($action) ?>" id="uf-form" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <?php if ($item !== null): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>

    <div class="uf-card">
        <h3 class="uf-card-title"><span class="emo">🪪</span><span>Identitas Akun</span><span class="num">BAGIAN 1 / 4</span></h3>
        <div class="uf-field">
            <label class="uf-label">Nama Lengkap <span class="uf-req">WAJIB</span></label>
            <input class="uf-input" type="text" name="name" required value="<?= e($item['name'] ?? old('name')) ?>" placeholder="Contoh: Dr. Ahmad Budi Santoso, M.Pd.">
        </div>
        <div class="uf-row2">
            <div class="uf-field">
                <label class="uf-label">Email <span class="uf-req">WAJIB</span></label>
                <input class="uf-input" type="email" name="email" required value="<?= e($item['email'] ?? old('email')) ?>" placeholder="nama@unimof.ac.id">
            </div>
            <div class="uf-field">
                <label class="uf-label">No. HP <span class="uf-opt">OPSIONAL</span></label>
                <input class="uf-input" type="text" name="phone" value="<?= e($item['phone'] ?? old('phone')) ?>" placeholder="0812xxxxxxxx">
            </div>
        </div>
    </div>

    <div class="uf-card" style="animation-delay:.06s">
        <h3 class="uf-card-title"><span class="emo">🛡️</span><span>Role & Hak Akses</span><span class="num">BAGIAN 2 / 4</span></h3>
        <div class="uf-field">
            <label class="uf-label">Role Pengguna</label>
            <select class="uf-select" name="role" id="uf-role">
                <?php foreach ($roles as $rk => $rv): ?>
                <option value="<?= e($rk) ?>" data-desc="<?= e($rv['desc']) ?>" <?= ($item['role'] ?? 'admin_lp3m') === $rk ? 'selected' : '' ?>><?= e($rv['label']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="uf-role-desc" id="uf-role-desc"></div>
        </div>
        <div class="uf-field">
            <label class="uf-label">Status Akun</label>
            <label class="uf-chk">
                <input type="checkbox" name="is_active" value="1" <?= ($item['is_active'] ?? 1) ? 'checked' : '' ?>>
                <span>✅ Akun aktif & dapat login</span>
            </label>
        </div>
    </div>

    <div class="uf-card" style="animation-delay:.12s">
        <h3 class="uf-card-title"><span class="emo">🎓</span><span>Profil Dosen</span><span class="num">BAGIAN 3 / 4 · OPSIONAL</span></h3>
        <div class="uf-row2" style="margin-bottom:16px;">
            <div class="uf-field">
                <label class="uf-label">Foto Profil</label>
                <input class="uf-input" type="file" name="photo" accept=".jpg,.jpeg,.png,.webp" style="padding:9px;">
                <?php if (!empty($item['photo'])): ?>
                <div style="margin-top:8px; display:flex; align-items:center; gap:8px;">
                    <img src="<?= e(upload_url($item['photo'])) ?>" alt="Foto" style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:2px solid var(--border);">
                    <span style="font-size:11px; color:var(--muted);">Foto saat ini (akan diganti bila upload baru)</span>
                </div>
                <?php endif; ?>
                <div class="uf-hint">📷 JPG/PNG/WEBP, maks 2 MB.</div>
            </div>
            <div class="uf-field">
                <label class="uf-label">NIDN / NIDK</label>
                <input class="uf-input" type="text" name="nidn" value="<?= e($item['nidn'] ?? '') ?>" placeholder="0012345678">
            </div>
        </div>
        <div class="uf-field" style="margin-bottom:16px;">
            <label class="uf-label">Institusi / Afliasi</label>
            <input class="uf-input" type="text" name="institution" value="<?= e($item['institution'] ?? '') ?>" placeholder="Universitas Muhammadiyah Maumere">
        </div>
        <div class="uf-field" style="margin-bottom:16px;">
            <label class="uf-label">Biografi Singkat</label>
            <textarea class="uf-input" name="bio" rows="4" style="min-height:90px; line-height:1.6; resize:vertical;" placeholder="Riwayat singkat, keahlian, jabatan akademik, dan fokus riset..."><?= e($item['bio'] ?? '') ?></textarea>
        </div>
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:16px;">
            <div class="uf-field">
                <label class="uf-label">🎓 Google Scholar</label>
                <input class="uf-input" type="url" name="scholar_url" value="<?= e($item['scholar_url'] ?? '') ?>" placeholder="https://scholar.google.com/...">
            </div>
            <div class="uf-field">
                <label class="uf-label">📈 SINTA</label>
                <input class="uf-input" type="url" name="sinta_url" value="<?= e($item['sinta_url'] ?? '') ?>" placeholder="https://sinta.kemdikbud.go.id/...">
            </div>
            <div class="uf-field">
                <label class="uf-label">🆔 ORCID</label>
                <input class="uf-input" type="text" name="orcid" value="<?= e($item['orcid'] ?? '') ?>" placeholder="0000-0000-0000-0000">
            </div>
        </div>
        <div class="uf-hint">💡 Data ini akan tampil di Direktori Dosen publik dan profil personal dosen.</div>
    </div>

    <div class="uf-card" style="animation-delay:.18s">
        <h3 class="uf-card-title"><span class="emo">🔑</span><span>Password</span><span class="num">BAGIAN 4 / 4</span></h3>
        <div class="uf-field">
            <label class="uf-label"><?= $item !== null ? 'Password Baru' : 'Password' ?> <span class="uf-opt"><?= $item !== null ? 'KOSONGKAN JIKA TIDAK DIGANTI' : 'MIN. 8 KARAKTER · KOSONG = AUTO' ?></span></label>
            <div class="uf-passwrap">
                <input class="uf-input" type="password" name="password" id="uf-pass" placeholder="••••••••" autocomplete="new-password">
                <div class="uf-passbtns">
                    <button type="button" class="uf-mini" id="uf-gen" title="Generate acak">🎲</button>
                    <button type="button" class="uf-mini" id="uf-eye" title="Lihat/Sembunyikan">👁️</button>
                </div>
            </div>
            <div class="uf-hint">💡 Password disimpan ter-hash (bcrypt). Bila dikosongkan saat tambah baru, sistem membuat password acak 10 karakter dan menampilkannya sekali di flash message.</div>
        </div>
    </div>

    <div class="uf-actions">
        <button type="submit" class="uf-btn-gold" id="uf-save"><?= $item !== null ? '💾 Simpan Perubahan' : '➕ Simpan Pengguna' ?></button>
        <a href="<?= e(url('admin/index.php?page=users')) ?>" class="uf-btn-ghost">✖ Batal</a>
    </div>
</form>

<script>
(function(){
    var role = document.getElementById('uf-role');
    var desc = document.getElementById('uf-role-desc');
    if (role && desc) {
        var u = function(){ var o = role.options[role.selectedIndex]; desc.textContent = '🛡️ ' + (o ? o.getAttribute('data-desc') : ''); };
        role.addEventListener('change', u); u();
    }
    var pass = document.getElementById('uf-pass');
    var gen = document.getElementById('uf-gen');
    var eye = document.getElementById('uf-eye');
    if (gen && pass) gen.addEventListener('click', function(){
        var chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789!@#';
        var s = '';
        for (var i = 0; i < 12; i++) s += chars[Math.floor(Math.random() * chars.length)];
        pass.value = s;
        pass.type = 'text';
        if (eye) eye.textContent = '🙈';
    });
    if (eye && pass) eye.addEventListener('click', function(){
        pass.type = pass.type === 'password' ? 'text' : 'password';
        eye.textContent = pass.type === 'password' ? '👁️' : '🙈';
    });
    var form = document.getElementById('uf-form'), save = document.getElementById('uf-save');
    if (form && save) form.addEventListener('submit', function(){ save.disabled = true; save.textContent = '⏳ Menyimpan...'; });
})();
</script>