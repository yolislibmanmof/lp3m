<style>
    @keyframes pgShine { 0%,55% { left:-90%; } 100% { left:165%; } }
    @keyframes pgFade { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:none; } }
    @keyframes pgPulse { 0%,100% { box-shadow:0 0 0 0 rgba(16,185,129,.35); } 50% { box-shadow:0 0 0 6px rgba(16,185,129,0); } }

    .pg-head { display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:22px 26px; border-radius:22px; background:linear-gradient(135deg,#043b2c 0%,#065f46 55%,#059669 100%); color:#fff; position:relative; overflow:hidden; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:pgFade .5s both; }
    .pg-head::after { content:''; position:absolute; top:-50%; right:-10%; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.22),transparent 70%); pointer-events:none; }
    .pg-head-ico { width:54px; height:54px; border-radius:16px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:25px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.5),transparent 40%),linear-gradient(145deg,#6ee7b7,#10b981 55%,#047857); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), inset 0 -3px 5px rgba(0,0,0,.25), 0 6px 16px rgba(5,150,105,.4); position:relative; z-index:1; }
    .pg-title { font-family:var(--font-display); font-size:21px; font-weight:900; letter-spacing:-.02em; margin:0; background:linear-gradient(135deg,#fff,#fde68a); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; position:relative; z-index:1; }
    .pg-sub { font-size:12.5px; opacity:.85; margin:3px 0 0; position:relative; z-index:1; }
    .pg-badge { margin-left:auto; padding:4px 12px; border-radius:999px; font-size:10px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.3); position:relative; z-index:1; }

    .pg-flash { position:relative; padding:14px 18px; margin-bottom:18px; border-radius:14px; font-size:13.5px; font-weight:700; display:flex; align-items:center; gap:10px; overflow:hidden; animation:pgFade .4s both; }
    .pg-flash::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:pgShine 3s ease-in-out infinite; }
    .pg-flash.ok { background:linear-gradient(145deg,#d1fae5,#a7f3d0); border:1px solid rgba(16,185,129,.35); color:#065f46; }
    .pg-flash.err { background:linear-gradient(145deg,#fee2e2,#fecaca); border:1px solid rgba(220,38,38,.35); color:#991b1b; }

    .pg-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px 26px; margin-bottom:18px; position:relative; overflow:hidden; animation:pgFade .5s both; }
    .pg-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,var(--gold-strong),#10b981); opacity:.75; }
    .pg-card-title { display:flex; align-items:center; gap:10px; font-size:14.5px; font-weight:900; color:#fff; font-family:var(--font-display); margin:0 0 20px; padding-bottom:13px; border-bottom:1px dashed var(--border); }
    .pg-card-title .emo { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:10px; background:linear-gradient(145deg,rgba(255,255,255,.08),rgba(255,255,255,.03)); border:1px solid var(--border); font-size:15px; }
    .pg-card-title .num { margin-left:auto; font-size:10px; font-weight:900; letter-spacing:.1em; color:var(--muted); }

    .pg-field { margin-bottom:18px; }
    .pg-field:last-child { margin-bottom:0; }
    .pg-label { display:flex; align-items:center; gap:8px; font-size:11.5px; font-weight:850; letter-spacing:.08em; text-transform:uppercase; color:#cfe7dd; margin-bottom:8px; }
    .pg-req { padding:1px 8px; border-radius:999px; font-size:8.5px; font-weight:900; background:rgba(220,38,38,.15); color:#fca5a5; border:1px solid rgba(220,38,38,.4); }
    .pg-opt { padding:1px 8px; border-radius:999px; font-size:8.5px; font-weight:800; background:rgba(255,255,255,.08); color:rgba(255,255,255,.6); border:1px solid rgba(255,255,255,.15); }
    .pg-count { margin-left:auto; font-family:var(--font-display); font-size:10px; font-weight:800; color:var(--muted); background:rgba(255,255,255,.06); padding:2px 8px; border-radius:6px; }

    .pg-input, .pg-select, .pg-textarea { width:100%; padding:13px 16px; border-radius:13px; border:2px solid var(--border); background:linear-gradient(145deg,rgba(255,255,255,.05),rgba(255,255,255,.02)); font-size:14px; font-weight:600; color:var(--text); outline:none; transition:all .25s; font-family:inherit; }
    .pg-input::placeholder, .pg-textarea::placeholder { color:rgba(255,255,255,.35); font-weight:500; }
    .pg-input:focus, .pg-select:focus, .pg-textarea:focus { border-color:var(--gold-strong); background:rgba(255,255,255,.08); box-shadow:0 0 0 4px rgba(217,164,65,.16), 0 4px 12px rgba(217,164,65,.14); }
    .pg-select { appearance:none; -webkit-appearance:none; cursor:pointer; padding-right:44px; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23f2c063' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 16px center; }
    .pg-select option { background:#0d1d17; color:#eaf5f0; }
    .pg-textarea { min-height:160px; resize:vertical; line-height:1.7; }
    .pg-row2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    @media (max-width:700px){ .pg-row2 { grid-template-columns:1fr; } }
    .pg-hint { display:flex; justify-content:space-between; gap:10px; margin-top:7px; font-size:11px; color:var(--muted); flex-wrap:wrap; }

    .pg-drop { position:relative; border:2px dashed rgba(110,231,183,.4); border-radius:16px; padding:24px; text-align:center; cursor:pointer; transition:all .25s; background:rgba(16,185,129,.05); }
    .pg-drop:hover, .pg-drop.drag { border-color:#f2c063; background:rgba(217,164,65,.08); transform:translateY(-2px); }
    .pg-drop input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; }
    .pg-drop-ico { font-size:30px; display:block; margin-bottom:6px; animation:pgPulse 2.5s infinite; border-radius:50%; width:64px; height:64px; line-height:64px; margin:0 auto 8px; background:rgba(16,185,129,.12); }
    .pg-drop b { color:#6ee7b7; font-size:13.5px; }
    .pg-drop small { display:block; color:var(--muted); font-size:11px; margin-top:4px; }
    .pg-chip { display:none; margin-top:10px; padding:8px 14px; border-radius:999px; background:linear-gradient(145deg,rgba(16,185,129,.18),rgba(16,185,129,.1)); border:1px solid rgba(16,185,129,.4); color:#6ee7b7; font-size:12px; font-weight:800; }
    .pg-warn { display:none; margin-top:10px; padding:10px 14px; border-radius:12px; background:rgba(220,38,38,.12); border:1px solid rgba(220,38,38,.4); color:#fca5a5; font-size:12px; font-weight:700; }

    .pg-info { margin-top:4px; padding:14px 16px; border-radius:14px; background:rgba(217,164,65,.08); border:1px solid rgba(217,164,65,.25); font-size:12px; color:#f2c063; line-height:1.7; }
    .pg-info b { color:#fde68a; }

    .pg-actions { display:flex; gap:12px; flex-wrap:wrap; align-items:center; }
    .pg-btn-gold { position:relative; overflow:hidden; padding:14px 28px; border:none; border-radius:13px; font-size:14px; font-weight:850; color:#03251f; cursor:pointer; background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441 80%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.15), 0 8px 20px rgba(217,164,65,.4); font-family:var(--font-display); transition:all .25s; }
    .pg-btn-gold::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:pgShine 3s ease-in-out infinite; }
    .pg-btn-gold:hover { transform:translateY(-2px); }
    .pg-btn-gold:disabled { opacity:.6; cursor:not-allowed; }
    .pg-btn-ghost { padding:14px 24px; border-radius:13px; font-size:14px; font-weight:700; color:var(--muted); background:linear-gradient(145deg,rgba(255,255,255,.06),rgba(255,255,255,.03)); border:2px solid var(--border); text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all .25s; }
    .pg-btn-ghost:hover { border-color:rgba(220,38,38,.45); color:#fca5a5; transform:translateY(-2px); }
</style>

<div class="pg-head">
    <div class="pg-head-ico">🔍</div>
    <div style="position:relative; z-index:1; flex:1; min-width:0;">
        <h2 class="pg-title">Submit Dokumen untuk Cek Plagiat</h2>
        <p class="pg-sub">Analisis similaritas terhadap korpus internal LP3M (berita, proposal, laporan).</p>
    </div>
    <span class="pg-badge">Form Baru</span>
</div>

<?php if (!empty($flash)): ?>
<div class="pg-flash <?= $flash['type'] === 'error' ? 'err' : 'ok' ?>"><?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?></div>
<?php endif; ?>

<form method="post" action="<?= e(url('admin/index.php?page=plagiarism-simpan')) ?>" enctype="multipart/form-data" id="pg-form">
    <?= csrf_field() ?>

    <div class="pg-card">
        <h3 class="pg-card-title"><span class="emo">📋</span><span>Informasi Dokumen</span><span class="num">BAGIAN 1 / 2</span></h3>
        <div class="pg-field">
            <label class="pg-label">Judul Dokumen <span class="pg-req">WAJIB</span><span class="pg-count" id="pg-tcount">0/250</span></label>
            <input class="pg-input" type="text" name="title" id="pg-title" required maxlength="250" placeholder="Contoh: Skripsi: Analisis Sistem Informasi LP3M">
        </div>
        <div class="pg-row2">
            <div class="pg-field">
                <label class="pg-label">Nama Penulis <span class="pg-req">WAJIB</span></label>
                <input class="pg-input" type="text" name="submitter_name" required placeholder="Nama mahasiswa / dosen">
            </div>
            <div class="pg-field">
                <label class="pg-label">NIM / NIDN <span class="pg-opt">OPSIONAL</span></label>
                <input class="pg-input" type="text" name="submitter_identity" placeholder="Nomor identitas">
            </div>
        </div>
        <div class="pg-row2">
            <div class="pg-field">
                <label class="pg-label">Email <span class="pg-opt">OPSIONAL</span></label>
                <input class="pg-input" type="email" name="submitter_email" placeholder="nama@email.ac.id">
            </div>
            <div class="pg-field">
                <label class="pg-label">Jenis Dokumen</label>
                <select class="pg-select" name="document_type">
                    <?php foreach (PlagiarismCheck::DOC_TYPES as $k => $l): ?>
                    <option value="<?= e($k) ?>"><?= e($l) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="pg-card" style="animation-delay:.08s">
        <h3 class="pg-card-title"><span class="emo">📄</span><span>Konten Dokumen</span><span class="num">BAGIAN 2 / 2</span></h3>
        <div class="pg-field">
            <label class="pg-label">Unggah File <span class="pg-opt">AUTO-EXTRACT PDF/DOCX</span></label>
            <div class="pg-drop" id="pg-drop">
                <input type="file" name="document" id="pg-file" accept=".txt,.md,.pdf,.docx">
                <span class="pg-drop-ico">📎</span>
                <b>Klik atau seret file ke sini</b>
                <small>Maks 10 MB · Format: TXT, MD, PDF, DOCX</small>
            </div>
            <span class="pg-chip" id="pg-chip"></span>
            <span class="pg-warn" id="pg-warn"></span>
        </div>
        <div class="pg-field">
            <label class="pg-label">Atau Tempel Teks Langsung <span class="pg-count" id="pg-wcount">0 kata</span></label>
            <textarea class="pg-textarea" name="text" id="pg-text" placeholder="Tempel seluruh isi dokumen di sini untuk analisis otomatis..."></textarea>
            <div class="pg-hint"><span>💡 Teks minimal ±50 kata agar analisis shingle akurat.</span></div>
        </div>
        <div class="pg-info">
            <b>⚙️ Cara kerja mesin:</b> dokumen dipecah menjadi shingle 6-kata, lalu dibandingkan dengan korpus internal
            (berita terbit, proposal penelitian, laporan pengabdian). Skor = 60% kemiripan eksternal + 40% duplikasi internal.
            <br><br>
            <b>⚡ Auto-Extract:</b> PDF dan DOCX akan dibaca otomatis. Jika PDF terenkripsi atau hanya gambar, akan masuk antrean untuk review manual.
        </div>
    </div>

    <div class="pg-actions">
        <button type="submit" class="pg-btn-gold" id="pg-save">🔍 Jalankan Pemeriksaan</button>
        <a href="<?= e(url('admin/index.php?page=plagiarism')) ?>" class="pg-btn-ghost">✖ Batal</a>
    </div>
</form>

<script>
(function(){
    var t = document.getElementById('pg-title'), tc = document.getElementById('pg-tcount');
    if (t && tc) { var ut = function(){ tc.textContent = t.value.length + '/250'; }; t.addEventListener('input', ut); ut(); }

    var ta = document.getElementById('pg-text'), wc = document.getElementById('pg-wcount');
    if (ta && wc) { var uw = function(){ var v = ta.value.trim(); wc.textContent = (v === '' ? 0 : v.split(/\s+/).length) + ' kata'; }; ta.addEventListener('input', uw); uw(); }

    var file = document.getElementById('pg-file'), chip = document.getElementById('pg-chip'),
        warn = document.getElementById('pg-warn'), drop = document.getElementById('pg-drop');
    function showFile(){
        var f = file.files && file.files[0];
        warn.style.display = 'none';
        if (!f) { chip.style.display = 'none'; return; }
        var mb = f.size / 1048576;
        if (mb > 10) { warn.textContent = '⚠️ File ' + mb.toFixed(2) + ' MB melebihi batas 10 MB.'; warn.style.display = 'block'; file.value = ''; chip.style.display = 'none'; return; }
        chip.style.display = 'inline-block';
        chip.textContent = '📎 ' + f.name + ' · ' + mb.toFixed(2) + ' MB';
    }
    if (file) file.addEventListener('change', showFile);
    if (drop) {
        ['dragenter','dragover'].forEach(function(ev){ drop.addEventListener(ev, function(e){ e.preventDefault(); drop.classList.add('drag'); }); });
        ['dragleave','drop'].forEach(function(ev){ drop.addEventListener(ev, function(e){ e.preventDefault(); drop.classList.remove('drag'); }); });
    }

    var form = document.getElementById('pg-form'), save = document.getElementById('pg-save');
    if (form && save) form.addEventListener('submit', function(){ save.disabled = true; save.textContent = '⏳ Menganalisis...'; });
})();
</script>