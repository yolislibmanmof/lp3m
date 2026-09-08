<style>
    @keyframes sfFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    .sf-head { display:flex; align-items:center; gap:16px; margin-bottom:20px; padding:22px 26px; border-radius:22px; background:linear-gradient(135deg,#4c1d95,#7c3aed); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:sfFade .5s both; }
    .sf-head h2 { margin:0; font-family:var(--font-display); font-size:20px; font-weight:900; }
    .sf-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px; margin-bottom:18px; animation:sfFade .5s .05s both; }
    .sf-card h3 { display:flex; align-items:center; gap:10px; margin:0 0 18px; font-family:var(--font-display); font-size:14px; font-weight:900; color:#fff; padding-bottom:12px; border-bottom:1px dashed var(--border); }
    .sf-label { display:block; font-size:11px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); margin-bottom:6px; }
    .sf-input, .sf-select, .sf-textarea { width:100%; padding:11px 14px; border-radius:11px; border:1px solid var(--border); background:var(--surface); font-size:13.5px; font-weight:600; color:var(--text); font-family:inherit; }
    .sf-input:focus, .sf-select:focus, .sf-textarea:focus { outline:none; border-color:#7c3aed; box-shadow:0 0 0 4px rgba(124,58,237,.14); }
    .sf-textarea { min-height:80px; resize:vertical; line-height:1.6; }
    .sf-row { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:14px; }
    .q-row { position:relative; padding:16px; border:1px solid var(--border); border-radius:14px; background:rgba(255,255,255,.02); margin-bottom:12px; animation:sfFade .4s both; }
    .q-row .q-top { display:grid; grid-template-columns:1fr 150px 40px; gap:10px; align-items:center; margin-bottom:10px; }
    .q-row .q-opts { margin-top:10px; }
    .q-row .q-req { display:flex; align-items:center; gap:8px; margin-top:10px; font-size:12px; font-weight:700; color:var(--muted); cursor:pointer; }
    .q-del { width:36px; height:36px; border-radius:10px; border:1px solid rgba(220,38,38,.35); background:rgba(220,38,38,.08); color:#fca5a5; font-size:15px; cursor:pointer; transition:all .2s; }
    .q-del:hover { background:rgba(220,38,38,.2); transform:scale(1.05); }
    .q-num { position:absolute; top:-9px; left:14px; padding:2px 10px; border-radius:999px; font-size:10px; font-weight:900; background:linear-gradient(145deg,#8b5cf6,#6d28d9); color:#fff; }
    .sf-add { width:100%; padding:13px; border-radius:12px; border:2px dashed rgba(124,58,237,.4); background:rgba(124,58,237,.05); color:#a78bfa; font-size:13px; font-weight:800; cursor:pointer; transition:all .2s; }
    .sf-add:hover { background:rgba(124,58,237,.12); border-color:#7c3aed; }
    .sf-actions { display:flex; gap:12px; }
    .sf-save { position:relative; overflow:hidden; padding:13px 26px; border:none; border-radius:12px; font-size:14px; font-weight:900; cursor:pointer; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:0 6px 16px rgba(217,164,65,.35); font-family:var(--font-display); }
    .sf-cancel { padding:13px 22px; border-radius:12px; font-size:14px; font-weight:700; color:var(--muted); background:rgba(255,255,255,.05); border:2px solid var(--border); text-decoration:none; }
</style>

<div class="sf-head">
    <div style="flex:1;"><h2><?= $item !== null ? '✏️ Edit Survei' : '➕ Buat Survei Baru' ?></h2></div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<form method="post" action="<?= e($action) ?>" id="sf-form">
    <?= csrf_field() ?>
    <?php if ($item !== null): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>

    <div class="sf-card">
        <h3>📋 Informasi Survei</h3>
        <div style="margin-bottom:14px;">
            <label class="sf-label">Judul Survei <span style="color:#fca5a5;">*</span></label>
            <input class="sf-input" type="text" name="title" required value="<?= e($item['title'] ?? '') ?>" placeholder="Contoh: Survei Kepuasan Layanan LP3M 2026">
        </div>
        <div style="margin-bottom:14px;">
            <label class="sf-label">Deskripsi / Pengantar</label>
            <textarea class="sf-textarea" name="description" placeholder="Penjelasan singkat tujuan survei..."><?= e($item['description'] ?? '') ?></textarea>
        </div>
        <div class="sf-row">
            <div>
                <label class="sf-label">Target Responden</label>
                <select class="sf-select" name="target_audience">
                    <?php foreach (Survey::TARGETS as $k => $l): ?>
                    <option value="<?= e($k) ?>" <?= ($item['target_audience'] ?? 'umum') === $k ? 'selected' : '' ?>><?= e($l) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="sf-label">Status</label>
                <select class="sf-select" name="status">
                    <?php foreach (Survey::STATUSES as $k => $l): ?>
                    <option value="<?= e($k) ?>" <?= ($item['status'] ?? 'draft') === $k ? 'selected' : '' ?>><?= e($l) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="sf-label">Mulai</label>
                <input class="sf-input" type="date" name="start_date" value="<?= e($item['start_date'] ?? '') ?>">
            </div>
            <div>
                <label class="sf-label">Berakhir</label>
                <input class="sf-input" type="date" name="end_date" value="<?= e($item['end_date'] ?? '') ?>">
            </div>
        </div>
    </div>

    <div class="sf-card">
        <h3>❓ Daftar Pertanyaan <span style="margin-left:auto;font-size:10px;color:var(--muted);">Rating = skala 1–5 · Pilihan = opsi baris baru · Esai = teks bebas</span></h3>
        <div id="q-list">
            <?php
            $rows = $questions ?: [['question' => '', 'type' => 'rating', 'options' => '', 'options_arr' => [], 'required' => 1]];
            $idx = 0;
            foreach ($rows as $q):
                $optsText = is_array($q['options_arr'] ?? null) ? implode("\n", $q['options_arr']) : ($q['options'] ?? '');
            ?>
            <div class="q-row" data-idx="<?= $idx ?>">
                <span class="q-num">P<?= $idx + 1 ?></span>
                <div class="q-top">
                    <input class="sf-input q-text" type="text" name="q_text[<?= $idx ?>]" value="<?= e($q['question']) ?>" placeholder="Tulis pertanyaan...">
                    <select class="sf-select q-type" name="q_type[<?= $idx ?>]">
                        <option value="rating" <?= ($q['type'] ?? 'rating') === 'rating' ? 'selected' : '' ?>>⭐ Rating 1–5</option>
                        <option value="choice" <?= ($q['type'] ?? '') === 'choice' ? 'selected' : '' ?>>🔘 Pilihan Ganda</option>
                        <option value="text" <?= ($q['type'] ?? '') === 'text' ? 'selected' : '' ?>>✍️ Esai</option>
                    </select>
                    <button type="button" class="q-del" title="Hapus pertanyaan">✕</button>
                </div>
                <div class="q-opts" style="display:<?= ($q['type'] ?? 'rating') === 'choice' ? 'block' : 'none' ?>;">
                    <label class="sf-label">Opsi (satu per baris)</label>
                    <textarea class="sf-textarea q-options" name="q_options[<?= $idx ?>]" placeholder="Sangat puas&#10;Puas&#10;Kurang puas"><?= e($optsText) ?></textarea>
                </div>
                <label class="q-req">
                    <input type="hidden" name="q_required[<?= $idx ?>]" value="0">
                    <input type="checkbox" name="q_required[<?= $idx ?>]" value="1" <?= !empty($q['required']) ? 'checked' : '' ?>>
                    Wajib diisi
                </label>
            </div>
            <?php $idx++; endforeach; ?>
        </div>
        <button type="button" class="sf-add" id="q-add">➕ Tambah Pertanyaan</button>
    </div>

    <div class="sf-actions">
        <button type="submit" class="sf-save">💾 Simpan Survei</button>
        <a class="sf-cancel" href="<?= e(url('admin/index.php?page=survei')) ?>">✖ Batal</a>
    </div>
</form>

<script>
(function(){
    var list = document.getElementById('q-list');
    var counter = list.querySelectorAll('.q-row').length;

    function bindRow(row){
        var type = row.querySelector('.q-type');
        var opts = row.querySelector('.q-opts');
        type.addEventListener('change', function(){ opts.style.display = type.value === 'choice' ? 'block' : 'none'; });
        row.querySelector('.q-del').addEventListener('click', function(){
            if (list.querySelectorAll('.q-row').length <= 1) { alert('Minimal satu pertanyaan.'); return; }
            row.remove(); renumber();
        });
    }
    function renumber(){
        list.querySelectorAll('.q-row').forEach(function(r, i){ r.querySelector('.q-num').textContent = 'P' + (i + 1); });
    }
    list.querySelectorAll('.q-row').forEach(bindRow);

    document.getElementById('q-add').addEventListener('click', function(){
        var i = counter++;
        var div = document.createElement('div');
        div.className = 'q-row';
        div.innerHTML =
            '<span class="q-num">P' + (i + 1) + '</span>' +
            '<div class="q-top">' +
              '<input class="sf-input q-text" type="text" name="q_text[' + i + ']" placeholder="Tulis pertanyaan...">' +
              '<select class="sf-select q-type" name="q_type[' + i + ']">' +
                '<option value="rating">⭐ Rating 1–5</option><option value="choice">🔘 Pilihan Ganda</option><option value="text">✍️ Esai</option>' +
              '</select>' +
              '<button type="button" class="q-del" title="Hapus">✕</button>' +
            '</div>' +
            '<div class="q-opts" style="display:none;"><label class="sf-label">Opsi (satu per baris)</label>' +
              '<textarea class="sf-textarea q-options" name="q_options[' + i + ']" placeholder="Opsi A&#10;Opsi B"></textarea></div>' +
            '<label class="q-req"><input type="hidden" name="q_required[' + i + ']" value="0">' +
              '<input type="checkbox" name="q_required[' + i + ']" value="1" checked> Wajib diisi</label>';
        list.appendChild(div);
        bindRow(div);
        div.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });

    document.getElementById('sf-form').addEventListener('submit', function(e){
        var empty = false;
        list.querySelectorAll('.q-text').forEach(function(t){ if (t.value.trim() === '') empty = true; });
        if (empty) { e.preventDefault(); alert('Semua pertanyaan wajib diisi teksnya (hapus baris kosong bila tidak dipakai).'); }
    });
})();
</script>