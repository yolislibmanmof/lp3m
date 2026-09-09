<?php
$estMin = max(1, ceil(count($questions) * 0.5)); // ~30 detik per pertanyaan
?>
<style>
    @keyframes psfFade { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:none} }
    @keyframes psfPop { 0%{transform:scale(0)} 60%{transform:scale(1.15)} 100%{transform:scale(1)} }
    @keyframes psfPulse { 0%,100%{box-shadow:0 0 0 0 rgba(124,58,237,.3)} 50%{box-shadow:0 0 0 12px rgba(124,58,237,0)} }
    @keyframes psfShine { 0%,55%{left:-100%} 100%{left:200%} }
    @keyframes psfConfetti { 0%{transform:translateY(-10vh) rotate(0);opacity:1} 100%{transform:translateY(110vh) rotate(720deg);opacity:0} }
    @keyframes psfBounce { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }

    .psf-confetti { position:fixed; inset:0; pointer-events:none; z-index:999; overflow:hidden; display:none; }
    .psf-confetti.show { display:block; }
    .psf-confetti i { position:absolute; top:-10%; width:10px; height:14px; border-radius:2px; animation:psfConfetti 3.5s ease-in forwards; }

    .psf-hero { position:relative; overflow:hidden; border-radius:26px; padding:44px 38px; margin-bottom:22px; color:#fff; background:linear-gradient(135deg,#4c1d95,#7c3aed); box-shadow:0 20px 48px rgba(76,29,149,.3); animation:psfFade .6s both; }
    .psf-hero::before { content:''; position:absolute; inset:0; opacity:.3; background-image:repeating-linear-gradient(45deg,transparent,transparent 30px,rgba(253,230,138,.05) 30px,rgba(253,230,138,.05) 31px); pointer-events:none; }
    .psf-hero-top { display:flex; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap; position:relative; z-index:1; }
    .psf-hero h1 { font-family:var(--font-display); font-size:clamp(22px,3.4vw,32px); font-weight:900; margin:0 0 8px; letter-spacing:-.02em; }
    .psf-hero p { margin:0; font-size:13.5px; line-height:1.7; opacity:.92; max-width:640px; }
    .psf-hero-meta { display:flex; gap:8px; flex-wrap:wrap; margin-top:10px; }
    .psf-hero-meta span { padding:4px 12px; border-radius:999px; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.3); font-size:11px; font-weight:800; color:#fff; display:inline-flex; align-items:center; gap:5px; }
    .psf-hero-timer { flex-shrink:0; text-align:center; padding:14px 20px; border-radius:16px; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.25); backdrop-filter:blur(6px); min-width:120px; }
    .psf-hero-timer b { display:block; font-family:var(--font-display); font-size:22px; font-weight:900; color:#fde68a; letter-spacing:.05em; }
    .psf-hero-timer span { font-size:9px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; opacity:.8; display:block; margin-top:3px; }

    .psf-top { display:flex; gap:14px; align-items:center; margin-bottom:16px; flex-wrap:wrap; position:sticky; top:76px; z-index:50; padding:14px 18px; border-radius:14px; background:var(--surface); border:1px solid var(--border); box-shadow:0 6px 18px rgba(3,37,31,.08); }
    .psf-top .track { flex:1; height:10px; border-radius:999px; background:rgba(124,58,237,.12); overflow:hidden; min-width:120px; position:relative; }
    .psf-top .track i { display:block; height:100%; width:0; border-radius:999px; background:linear-gradient(90deg,#8b5cf6,#f2c063); transition:width .4s ease; position:relative; }
    .psf-top .track i::after { content:''; position:absolute; top:0; right:0; bottom:0; width:20px; background:linear-gradient(90deg,transparent,rgba(255,255,255,.6)); }
    .psf-top .pct { font-size:13px; font-weight:900; color:#6d28d9; white-space:nowrap; min-width:44px; text-align:right; }
    .psf-top .save-ind { font-size:10px; font-weight:800; color:#10b981; display:inline-flex; align-items:center; gap:5px; opacity:0; transition:opacity .3s; }
    .psf-top .save-ind.show { opacity:1; }
    .psf-top .save-ind i { width:6px; height:6px; border-radius:50%; background:#10b981; box-shadow:0 0 6px #10b981; }
    .psf-top .kb-hint { display:flex; gap:4px; font-size:10px; color:var(--muted); flex-wrap:wrap; }
    .psf-top .kb-hint kbd { padding:2px 6px; border-radius:4px; background:rgba(124,58,237,.08); border:1px solid var(--border); font-family:'Courier New',monospace; font-weight:800; }

    .psf-minimap { display:flex; gap:5px; flex-wrap:wrap; padding:10px 14px; border-radius:12px; background:var(--surface); border:1px solid var(--border); margin-bottom:20px; }
    .psf-dot { width:28px; height:28px; border-radius:8px; border:1px solid var(--border); background:var(--surface); display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:900; color:var(--muted); cursor:pointer; transition:all .2s; }
    .psf-dot:hover { border-color:#7c3aed; color:#6d28d9; }
    .psf-dot.done { background:linear-gradient(145deg,#8b5cf6,#6d28d9); color:#fff; border-color:transparent; }
    .psf-dot.active { border-color:#f2c063; box-shadow:0 0 0 3px rgba(242,192,99,.25); animation:psfBounce 1.5s ease-in-out infinite; }

    .psf-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px 26px; margin-bottom:14px; animation:psfFade .5s both; transition:all .3s; scroll-margin-top:140px; }
    .psf-card.filled { border-color:rgba(16,185,129,.3); background:linear-gradient(135deg,rgba(16,185,129,.03),var(--surface)); }
    .psf-card.filled::before { content:'✓'; position:absolute; top:-8px; right:-8px; width:24px; height:24px; border-radius:50%; background:linear-gradient(145deg,#10b981,#059669); color:#fff; font-size:13px; font-weight:900; display:flex; align-items:center; justify-content:center; box-shadow:0 3px 8px rgba(16,185,129,.4); }
    .psf-card { position:relative; }
    .psf-q { display:flex; gap:12px; align-items:flex-start; margin:0 0 16px; font-size:15px; font-weight:800; color:var(--ink); line-height:1.5; }
    .psf-q .n { flex-shrink:0; width:28px; height:28px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:900; background:linear-gradient(145deg,#8b5cf6,#6d28d9); color:#fff; transition:all .2s; }
    .psf-card.filled .psf-q .n { background:linear-gradient(145deg,#10b981,#059669); }
    .psf-q .n .check { display:none; animation:psfPop .4s cubic-bezier(.34,1.56,.64,1); }
    .psf-card.filled .psf-q .n .num { display:none; }
    .psf-card.filled .psf-q .n .check { display:inline; }
    .psf-q .req { color:#dc2626; }

    .psf-rate { display:flex; gap:10px; flex-wrap:wrap; }
    .psf-rate label { position:relative; cursor:pointer; }
    .psf-rate input { position:absolute; opacity:0; inset:0; }
    .psf-rate span { display:flex; flex-direction:column; align-items:center; gap:4px; padding:12px 16px; border-radius:14px; border:2px solid var(--border); background:var(--surface); font-size:11px; font-weight:800; color:var(--muted); transition:all .2s; min-width:86px; position:relative; }
    .psf-rate span::after { content:attr(data-kb); position:absolute; top:-6px; right:-6px; width:18px; height:18px; border-radius:50%; background:rgba(124,58,237,.1); border:1px solid rgba(124,58,237,.3); color:#6d28d9; font-size:9px; font-weight:900; display:flex; align-items:center; justify-content:center; }
    .psf-rate span b { font-size:20px; }
    .psf-rate input:checked + span { border-color:#7c3aed; background:rgba(124,58,237,.1); color:#6d28d9; transform:translateY(-3px); box-shadow:0 8px 18px rgba(124,58,237,.2); }
    .psf-rate input:checked + span b { animation:psfPop .4s cubic-bezier(.34,1.56,.64,1); }
    .psf-rate input:checked + span::after { background:#7c3aed; color:#fff; border-color:#7c3aed; }

    .psf-choice { display:flex; flex-direction:column; gap:8px; }
    .psf-choice label { position:relative; cursor:pointer; }
    .psf-choice input { position:absolute; opacity:0; inset:0; }
    .psf-choice span { display:flex; align-items:center; gap:10px; padding:12px 16px; border-radius:12px; border:2px solid var(--border); background:var(--surface); font-size:13.5px; font-weight:700; color:var(--text); transition:all .2s; }
    .psf-choice span::before { content:''; width:16px; height:16px; border-radius:50%; border:2px solid var(--border); flex-shrink:0; transition:all .2s; }
    .psf-choice input:checked + span { border-color:#7c3aed; background:rgba(124,58,237,.08); color:#6d28d9; }
    .psf-choice input:checked + span::before { border-color:#7c3aed; background:radial-gradient(circle,#7c3aed 45%,transparent 50%); animation:psfPop .4s cubic-bezier(.34,1.56,.64,1); }

    .psf-text { width:100%; min-height:110px; padding:14px; border-radius:12px; border:2px solid var(--border); background:var(--surface); font-size:14px; color:var(--text); font-family:inherit; line-height:1.6; resize:vertical; }
    .psf-text:focus { outline:none; border-color:#7c3aed; box-shadow:0 0 0 4px rgba(124,58,237,.12); }
    .psf-char-count { text-align:right; font-size:10px; color:var(--muted); margin-top:4px; }

    .psf-id { background:var(--surface); border:1px dashed rgba(124,58,237,.4); border-radius:20px; padding:22px 26px; margin-bottom:16px; }
    .psf-id h3 { margin:0 0 14px; font-size:14px; font-weight:900; color:var(--ink); display:flex; align-items:center; gap:8px; }
    .psf-id h3 .opt { padding:2px 8px; border-radius:999px; background:rgba(124,58,237,.1); color:#6d28d9; font-size:9px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; }
    .psf-id .row { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:12px; }
    .psf-id input, .psf-id select { width:100%; padding:11px 14px; border-radius:11px; border:2px solid var(--border); background:var(--surface); font-size:13.5px; color:var(--text); }
    .psf-id input:focus, .psf-id select:focus { outline:none; border-color:#7c3aed; }

    .psf-submit { display:flex; gap:12px; align-items:center; flex-wrap:wrap; padding:18px 0; }
    .psf-btn { position:relative; overflow:hidden; padding:15px 32px; border:none; border-radius:14px; font-size:15px; font-weight:900; cursor:pointer; color:#fff; background:linear-gradient(145deg,#8b5cf6,#6d28d9); box-shadow:0 8px 20px rgba(124,58,237,.4); font-family:var(--font-display); transition:all .2s; }
    .psf-btn::after { content:''; position:absolute; top:0; left:-100%; width:50%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.4),transparent); animation:psfShine 3s ease-in-out infinite; }
    .psf-btn:disabled { opacity:.6; cursor:not-allowed; }
    .psf-btn:hover:not(:disabled) { transform:translateY(-2px); filter:brightness(1.08); }
    .psf-note { font-size:12px; color:var(--muted); display:inline-flex; align-items:center; gap:6px; }
</style>

<div class="psf-confetti" id="psfConfetti" aria-hidden="true">
    <?php for ($c = 0; $c < 30; $c++): ?>
    <i style="left:<?= rand(0,100) ?>%; background:hsl(<?= rand(0,360) ?>,80%,60%); animation-delay:<?= $c * 0.05 ?>s;"></i>
    <?php endfor; ?>
</div>

<section class="psf-hero">
    <div class="psf-hero-top">
        <div>
            <h1><?= e($item['title']) ?></h1>
            <p><?= e($item['description'] ?: 'Isi seluruh pertanyaan dengan jujur sesuai pengalaman Anda. Jawaban Anda membantu peningkatan mutu layanan lembaga.') ?></p>
            <div class="psf-hero-meta">
                <span>❓ <?= count($questions) ?> pertanyaan</span>
                <span>⏱️ ~<?= $estMin ?> menit</span>
                <span>🎯 <?= e(Survey::TARGETS[$item['target_audience']] ?? 'Umum') ?></span>
            </div>
        </div>
        <div class="psf-hero-timer">
            <b id="psfTimer">00:00</b>
            <span>Waktu Pengerjaan</span>
        </div>
    </div>
</section>

<?php if (!empty($_SESSION['flash'])): $f = $_SESSION['flash']; unset($_SESSION['flash']); ?>
<div class="psf-card" style="border-left:5px solid <?= $f['type'] === 'error' ? '#dc2626' : '#10b981' ?>;">
    <p style="margin:0;font-weight:800;color:var(--ink);"><?= $f['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($f['message']) ?></p>
</div>
<?php endif; ?>

<form method="post" action="<?= e(url('public/index.php?page=survei-kirim')) ?>" id="psf-form" autocomplete="off">
    <?= csrf_field() ?>
    <input type="hidden" name="survey_id" value="<?= (int) $item['id'] ?>">
    <input type="hidden" name="time_spent" id="psfTimeSpent" value="0">

    <div class="psf-id">
        <h3>👤 Identitas Responden <span class="opt">Opsional · Anonim OK</span></h3>
        <div class="row">
            <input type="text" name="respondent_name" placeholder="Nama lengkap" data-autosave="name">
            <input type="email" name="respondent_email" placeholder="Email" data-autosave="email">
            <select name="respondent_role" data-autosave="role">
                <option value="">— Peran —</option>
                <option value="Mahasiswa">Mahasiswa</option>
                <option value="Dosen">Dosen</option>
                <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                <option value="Mitra">Mitra / Masyarakat</option>
            </select>
        </div>
    </div>

    <div class="psf-top">
        <span style="font-size:11.5px; font-weight:900; color:var(--muted); letter-spacing:.06em; text-transform:uppercase;">Progres</span>
        <div class="track"><i id="psf-bar"></i></div>
        <span class="pct" id="psf-pct">0%</span>
        <span class="save-ind" id="psfSaveInd"><i></i> Auto-saved</span>
        <span class="kb-hint">⌨️ <kbd>1-5</kbd> rating · <kbd>Tab</kbd> pindah</span>
    </div>

    <div class="psf-minimap" id="psf-map">
        <?php foreach ($questions as $i => $q): ?>
        <div class="psf-dot" data-target="psf-q-<?= $i ?>" data-idx="<?= $i ?>"><?= $i + 1 ?></div>
        <?php endforeach; ?>
    </div>

    <?php foreach ($questions as $i => $q): $qid = (int) $q['id']; ?>
    <div class="psf-card psf-item" id="psf-q-<?= $i ?>" data-qid="<?= $qid ?>">
        <div class="psf-q">
            <span class="n"><span class="num"><?= $i + 1 ?></span><span class="check">✓</span></span>
            <span><?= e($q['question']) ?> <?= !empty($q['required']) ? '<span class="req">*</span>' : '' ?></span>
        </div>

        <?php if ($q['type'] === 'rating'): ?>
        <div class="psf-rate" data-quick-key="<?= $i ?>">
            <?php for ($v = 1; $v <= 5; $v++): ?>
            <label>
                <input type="radio" name="rating[<?= $qid ?>]" value="<?= $v ?>" <?= !empty($q['required']) ? 'required' : '' ?> data-autosave="q<?= $qid ?>">
                <span data-kb="<?= $v ?>"><b><?= $v ?></b><?= e(explode(' ', Survey::RATING_LABELS[$v])[1] ?? '') ?></span>
            </label>
            <?php endfor; ?>
        </div>
        <?php elseif ($q['type'] === 'choice'): ?>
        <div class="psf-choice">
            <?php foreach ($q['options_arr'] as $oi => $opt): ?>
            <label>
                <input type="radio" name="choice[<?= $qid ?>]" value="<?= e($opt) ?>" <?= !empty($q['required']) ? 'required' : '' ?> data-autosave="q<?= $qid ?>">
                <span><?= e($opt) ?></span>
            </label>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <textarea class="psf-text" name="text[<?= $qid ?>]" placeholder="Tuliskan jawaban / saran Anda di sini..." <?= !empty($q['required']) ? 'required' : '' ?> maxlength="2000" data-autosave="q<?= $qid ?>"></textarea>
        <div class="psf-char-count"><span id="cc-<?= $qid ?>">0</span> / 2000 karakter</div>
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
    var surveyId = <?= (int) $item['id'] ?>;
    var storageKey = 'survey_draft_' + surveyId;
    var items = Array.prototype.slice.call(document.querySelectorAll('.psf-item'));
    var dots = Array.prototype.slice.call(document.querySelectorAll('.psf-dot'));
    var bar = document.getElementById('psf-bar');
    var pct = document.getElementById('psf-pct');
    var saveInd = document.getElementById('psfSaveInd');
    var form = document.getElementById('psf-form');
    var timerEl = document.getElementById('psfTimer');
    var timeSpentEl = document.getElementById('psfTimeSpent');
    var confetti = document.getElementById('psfConfetti');

    // Timer
    var startTime = Date.now();
    setInterval(function(){
        var elapsed = Math.floor((Date.now() - startTime) / 1000);
        var m = Math.floor(elapsed / 60), s = elapsed % 60;
        timerEl.textContent = (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
        timeSpentEl.value = elapsed;
    }, 1000);

    function filled(it){ return !!it.querySelector('input:checked, textarea:not(:placeholder-shown)'); }

    function update(){
        var done = 0;
        items.forEach(function(it, i){
            if (filled(it)) { it.classList.add('filled'); dots[i] && dots[i].classList.add('done'); done++; }
            else { it.classList.remove('filled'); dots[i] && dots[i].classList.remove('done'); }
        });
        var p = items.length ? Math.round(done / items.length * 100) : 0;
        bar.style.width = p + '%';
        pct.textContent = p + '%';

        if (p === 100) {
            confetti.classList.add('show');
            setTimeout(function(){ confetti.classList.remove('show'); }, 4000);
        }
    }

    // Auto-save to localStorage
    var saveTimer = null;
    function saveDraft(){
        var data = {};
        form.querySelectorAll('[data-autosave]').forEach(function(el){
            var key = el.getAttribute('data-autosave');
            if (el.type === 'radio') {
                if (el.checked) data[key] = el.value;
            } else {
                data[key] = el.value;
            }
        });
        try { localStorage.setItem(storageKey, JSON.stringify(data)); } catch(e){}
        saveInd.classList.add('show');
        clearTimeout(saveTimer);
        saveTimer = setTimeout(function(){ saveInd.classList.remove('show'); }, 1500);
    }

    // Restore draft
    try {
        var saved = JSON.parse(localStorage.getItem(storageKey) || '{}');
        Object.keys(saved).forEach(function(key){
            var el = form.querySelector('[data-autosave="' + key + '"]');
            if (!el) return;
            if (el.type === 'radio') {
                var match = form.querySelector('[data-autosave="' + key + '"][value="' + saved[key] + '"]');
                if (match) match.checked = true;
            } else {
                el.value = saved[key];
            }
        });
    } catch(e){}

    form.addEventListener('change', function(){ update(); saveDraft(); });
    form.addEventListener('input', function(e){
        update();
        saveDraft();
        // Char count for textarea
        if (e.target.classList.contains('psf-text')) {
            var qid = e.target.getAttribute('data-autosave').replace('q', '');
            var cc = document.getElementById('cc-' + qid);
            if (cc) cc.textContent = e.target.value.length;
        }
    });
    update();

    // Minimap navigation
    dots.forEach(function(d){
        d.addEventListener('click', function(){
            var t = document.getElementById(d.getAttribute('data-target'));
            if (t) t.scrollIntoView({ behavior:'smooth', block:'center' });
        });
    });

    // Active dot tracking
    var observer = new IntersectionObserver(function(entries){
        entries.forEach(function(en){
            if (en.isIntersecting) {
                var id = en.target.id;
                dots.forEach(function(dt){ dt.classList.remove('active'); });
                var d = document.querySelector('.psf-dot[data-target="' + id + '"]');
                if (d) d.classList.add('active');
            }
        });
    }, { threshold: 0.5 });
    items.forEach(function(it){ observer.observe(it); });

    // Keyboard shortcuts for rating (1-5)
    document.addEventListener('keydown', function(e){
        if (e.target.tagName === 'TEXTAREA' || e.target.tagName === 'INPUT') return;
        if (e.key >= '1' && e.key <= '5') {
            var active = document.querySelector('.psf-dot.active');
            if (active) {
                var idx = active.getAttribute('data-idx');
                var rateGroup = document.querySelector('[data-quick-key="' + idx + '"]');
                if (rateGroup) {
                    var radio = rateGroup.querySelector('input[value="' + e.key + '"]');
                    if (radio) { radio.checked = true; radio.dispatchEvent(new Event('change', { bubbles: true })); }
                }
            }
        }
    });

    // Submit handler
    form.addEventListener('submit', function(){
        var b = document.getElementById('psf-save');
        b.disabled = true; b.textContent = '⏳ Mengirim...';
        try { localStorage.removeItem(storageKey); } catch(e){}
    });

    // Restore char counts
    form.querySelectorAll('.psf-text').forEach(function(ta){
        var qid = ta.getAttribute('data-autosave').replace('q', '');
        var cc = document.getElementById('cc-' + qid);
        if (cc) cc.textContent = ta.value.length;
    });
})();
</script>