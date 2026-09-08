<style>
    @keyframes psfFade { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:none} }
    .psf-hero { position:relative; overflow:hidden; border-radius:26px; padding:40px 36px; margin-bottom:26px; color:#fff; background:linear-gradient(135deg,#4c1d95,#7c3aed); box-shadow:0 20px 48px rgba(76,29,149,.3); animation:psfFade .6s both; }
    .psf-hero h1 { font-family:var(--font-display); font-size:clamp(22px,3.4vw,34px); font-weight:900; margin:0 0 10px; letter-spacing:-.02em; }
    .psf-hero p { margin:0; font-size:14px; line-height:1.7; opacity:.92; max-width:640px; }
    .psf-progress { position:sticky; top:76px; z-index:50; margin-bottom:20px; padding:12px 18px; border-radius:14px; background:var(--surface); border:1px solid var(--border); box-shadow:0 6px 18px rgba(3,37,31,.08); display:flex; align-items:center; gap:14px; }
    .psf-progress .track { flex:1; height:8px; border-radius:999px; background:rgba(124,58,237,.12); overflow:hidden; }
    .psf-progress .track i { display:block; height:100%; width:0; border-radius:999px; background:linear-gradient(90deg,#8b5cf6,#c4b5fd); transition:width .4s ease; }
    .psf-progress span { font-size:12px; font-weight:900; color:#6d28d9; white-space:nowrap; }
    .psf-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:26px; margin-bottom:16px; animation:psfFade .5s both; }
    .psf-q { display:flex; gap:12px; align-items:flex-start; margin:0 0 16px; font-size:15px; font-weight:800; color:var(--ink); line-height:1.5; }
    .psf-q .n { flex-shrink:0; width:28px; height:28px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:900; background:linear-gradient(145deg,#8b5cf6,#6d28d9); color:#fff; }
    .psf-q .req { color:#dc2626; }
    .psf-rate { display:flex; gap:10px; flex-wrap:wrap; }
    .psf-rate label { position:relative; cursor:pointer; }
    .psf-rate input { position:absolute; opacity:0; inset:0; }
    .psf-rate span { display:flex; flex-direction:column; align-items:center; gap:4px; padding:12px 16px; border-radius:14px; border:2px solid var(--border); background:var(--surface); font-size:11px; font-weight:800; color:var(--muted); transition:all .2s; min-width:86px; }
    .psf-rate span b { font-size:20px; }
    .psf-rate input:checked + span { border-color:#7c3aed; background:rgba(124,58,237,.1); color:#6d28d9; transform:translateY(-3px); box-shadow:0 8px 18px rgba(124,58,237,.2); }
    .psf-choice { display:flex; flex-direction:column; gap:8px; }
    .psf-choice label { position:relative; cursor:pointer; }
    .psf-choice input { position:absolute; opacity:0; inset:0; }
    .psf-choice span { display:flex; align-items:center; gap:10px; padding:12px 16px; border-radius:12px; border:2px solid var(--border); background:var(--surface); font-size:13.5px; font-weight:700; color:var(--text); transition:all .2s; }
    .psf-choice span::before { content:''; width:16px; height:16px; border-radius:50%; border:2px solid var(--border); flex-shrink:0; transition:all .2s; }
    .psf-choice input:checked + span { border-color:#7c3aed; background:rgba(124,58,237,.08); color:#6d28d9; }
    .psf-choice input:checked + span::before { border-color:#7c3aed; background:radial-gradient(circle,#7c3aed 45%,transparent 50%); }
    .psf-text { width:100%; min-height:110px; padding:14px; border-radius:12px; border:2px solid var(--border); background:var(--surface); font-size:14px; color:var(--text); font-family:inherit; line-height:1.6; resize:vertical; }
    .psf-text:focus { outline:none; border-color:#7c3aed; box-shadow:0 0 0 4px rgba(124,58,237,.12); }
    .psf-id { background:var(--surface); border:1px dashed rgba(124,58,237,.4); border-radius:20px; padding:22px 26px; margin-bottom:16px; }
    .psf-id h3 { margin:0 0 14px; font-size:14px; font-weight:900; color:var(--ink); }
    .psf-id .row { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:12px; }
    .psf-id input, .psf-id select { width:100%; padding:11px 14px; border-radius:11px; border:2px solid var(--border); background:var(--surface); font-size:13.5px; color:var(--text); }
    .psf-id input:focus, .psf-id select:focus { outline:none; border-color:#7c3aed; }
    .psf-submit { display:flex; gap:12px; align-items:center; flex-wrap:wrap; }
    .psf-btn { position:relative; overflow:hidden; padding:15px 32px; border:none; border-radius:14px; font-size:15px; font-weight:900; cursor:pointer; color:#fff; background:linear-gradient(145deg,#8b5cf6,#6d28d9); box-shadow:0 8px 20px rgba(124,58,237,.4); font-family:var(--font-display); }
    .psf-btn:disabled { opacity:.6; cursor:not-allowed; }
    .psf-note { font-size:12px; color:var(--muted); }
</style>

<section class="psf-hero">
    <h1><?= e($item['title']) ?></h1>
    <p><?= e($item['description'] ?: 'Isi seluruh pertanyaan dengan jujur sesuai pengalaman Anda. Jawaban Anda membantu peningkatan mutu layanan lembaga.') ?></p>
</section>

<?php if (!empty($_SESSION['flash'])): $f = $_SESSION['flash']; unset($_SESSION['flash']); ?>
<div class="psf-card" style="border-left:5px solid <?= $f['type'] === 'error' ? '#dc2626' : '#10b981' ?>;">
    <p style="margin:0;font-weight:800;color:var(--ink);"><?= $f['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($f['message']) ?></p>
</div>
<?php endif; ?>

<form method="post" action="<?= e(url('public/index.php?page=survei-kirim')) ?>" id="psf-form">
    <?= csrf_field() ?>
    <input type="hidden" name="survey_id" value="<?= (int) $item['id'] ?>">

    <div class="psf-id">
        <h3>👤 Identitas Responden <span style="font-weight:600;color:var(--muted);font-size:12px;">(opsional — kosongkan untuk anonim)</span></h3>
        <div class="row">
            <input type="text" name="respondent_name" placeholder="Nama lengkap">
            <input type="email" name="respondent_email" placeholder="Email">
            <select name="respondent_role">
                <option value="">— Peran —</option>
                <option value="Mahasiswa">Mahasiswa</option>
                <option value="Dosen">Dosen</option>
                <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                <option value="Mitra">Mitra / Masyarakat</option>
            </select>
        </div>
    </div>

    <div class="psf-progress">
        <span>Progres</span>
        <div class="track"><i id="psf-bar"></i></div>
        <span id="psf-pct">0%</span>
    </div>

    <?php foreach ($questions as $i => $q): $qid = (int) $q['id']; ?>
    <div class="psf-card psf-item">
        <div class="psf-q"><span class="n"><?= $i + 1 ?></span><span><?= e($q['question']) ?> <?= !empty($q['required']) ? '<span class="req">*</span>' : '' ?></span></div>

        <?php if ($q['type'] === 'rating'): ?>
        <div class="psf-rate">
            <?php for ($v = 1; $v <= 5; $v++): ?>
            <label>
                <input type="radio" name="rating[<?= $qid ?>]" value="<?= $v ?>" <?= !empty($q['required']) ? 'required' : '' ?>>
                <span><b><?= $v ?></b><?= e(explode(' ', Survey::RATING_LABELS[$v])[1] ?? '') ?></span>
            </label>
            <?php endfor; ?>
        </div>
        <?php elseif ($q['type'] === 'choice'): ?>
        <div class="psf-choice">
            <?php foreach ($q['options_arr'] as $opt): ?>
            <label>
                <input type="radio" name="choice[<?= $qid ?>]" value="<?= e($opt) ?>" <?= !empty($q['required']) ? 'required' : '' ?>>
                <span><?= e($opt) ?></span>
            </label>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <textarea class="psf-text" name="text[<?= $qid ?>]" placeholder="Tuliskan jawaban / saran Anda di sini..." <?= !empty($q['required']) ? 'required' : '' ?>></textarea>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>

    <div class="psf-submit">
        <button type="submit" class="psf-btn" id="psf-save">📨 Kirim Jawaban</button>
        <span class="psf-note">🔒 Data dijaga kerahasiaannya & hanya dipakai untuk peningkatan mutu.</span>
    </div>
</form>

<script>
(function(){
    var items = document.querySelectorAll('.psf-item');
    var bar = document.getElementById('psf-bar');
    var pct = document.getElementById('psf-pct');
    function update(){
        var done = 0;
        items.forEach(function(it){
            var filled = it.querySelector('input:checked, textarea:not(:placeholder-shown)');
            if (filled) done++;
        });
        var p = items.length ? Math.round(done / items.length * 100) : 0;
        bar.style.width = p + '%';
        pct.textContent = p + '%';
    }
    document.getElementById('psf-form').addEventListener('change', update);
    document.getElementById('psf-form').addEventListener('input', update);
    update();

    document.getElementById('psf-form').addEventListener('submit', function(){
        var b = document.getElementById('psf-save');
        b.disabled = true; b.textContent = '⏳ Mengirim...';
    });
})();
</script>