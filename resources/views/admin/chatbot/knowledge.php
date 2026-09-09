<style>
    @keyframes kbFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    .kb-head { position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:26px 30px; border-radius:22px; background:linear-gradient(135deg,#065f46,#059669 55%,#10b981); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:kbFade .5s both; }
    .kb-head h2 { margin:0 0 4px; font-family:var(--font-display); font-size:22px; font-weight:900; position:relative; z-index:1; }
    .kb-head p { margin:0; font-size:12.5px; opacity:.92; position:relative; z-index:1; }
    .kb-back { display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:800; color:#fff; text-decoration:none; padding:9px 16px; border-radius:10px; background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.3); margin-right:auto; }
    .kb-back:hover { background:rgba(255,255,255,.22); transform:translateX(-3px); }

    .kb-filter { display:flex; gap:8px; flex-wrap:wrap; align-items:center; margin-bottom:18px; padding:14px 16px; background:var(--surface); border:1px solid var(--border); border-radius:14px; animation:kbFade .5s .05s both; }
    .kb-filter .label { font-size:11px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); padding:7px 4px; }
    .kb-filter a { padding:7px 14px; border-radius:999px; font-size:11.5px; font-weight:800; color:var(--muted); background:rgba(255,255,255,.03); border:1px solid var(--border); text-decoration:none; transition:all .2s; }
    .kb-filter a:hover { border-color:rgba(5,150,105,.45); color:var(--text); }
    .kb-filter a.active { background:linear-gradient(145deg,#065f46,#043b2c); color:#fde68a; border-color:transparent; }
    .kb-filter .add { margin-left:auto; padding:9px 18px; border-radius:10px; font-size:13px; font-weight:800; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); text-decoration:none; box-shadow:0 4px 12px rgba(217,164,65,.3); transition:all .2s; }
    .kb-filter .add:hover { transform:translateY(-2px); filter:brightness(1.05); }

    .kb-list { display:flex; flex-direction:column; gap:12px; }
    .kb-item { position:relative; overflow:hidden; padding:18px 22px; border-radius:16px; background:var(--surface); border:1px solid var(--border); box-shadow:0 6px 18px rgba(3,37,31,.06); animation:kbFade .5s both; }
    .kb-item.inactive { opacity:.55; }
    .kb-item::before { content:''; position:absolute; top:0; left:0; bottom:0; width:4px; background:linear-gradient(180deg,#065f46,#10b981); }
    .kb-item.inactive::before { background:linear-gradient(180deg,#94a3b8,#cbd5e1); }
    .kb-top-row { display:flex; gap:12px; align-items:flex-start; margin-bottom:10px; }
    .kb-ico { width:38px; height:38px; border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:17px; background:rgba(5,150,105,.12); flex-shrink:0; }
    .kb-info { flex:1; min-width:0; }
    .kb-q { font-family:var(--font-display); font-size:15px; font-weight:900; color:var(--ink); margin:0 0 4px; line-height:1.4; }
    .kb-meta { display:flex; gap:8px; flex-wrap:wrap; font-size:10.5px; color:var(--muted); }
    .kb-meta .tag { padding:2px 9px; border-radius:999px; font-weight:800; }
    .kb-meta .cat { background:rgba(5,150,105,.12); color:#047857; }
    .kb-meta .prio { background:rgba(217,164,65,.15); color:#92400e; }
    .kb-meta .stat { padding:2px 9px; border-radius:999px; font-weight:800; }
    .kb-meta .stat.on { background:rgba(16,185,129,.14); color:#047857; }
    .kb-meta .stat.off { background:rgba(100,116,139,.15); color:var(--muted); }
    .kb-ans { font-size:12.5px; color:var(--muted); line-height:1.65; background:rgba(255,255,255,.02); border:1px dashed var(--border); border-radius:10px; padding:11px 14px; white-space:pre-wrap; word-break:break-word; margin-bottom:10px; }
    .kb-kw { display:flex; gap:5px; flex-wrap:wrap; margin-bottom:12px; }
    .kb-kw span { padding:3px 10px; border-radius:999px; font-size:10.5px; font-weight:800; background:rgba(217,164,65,.1); color:#92400e; border:1px solid rgba(217,164,65,.3); }
    .kb-acts { display:flex; gap:7px; flex-wrap:wrap; }
    .kb-btn { padding:7px 13px; border-radius:9px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--muted); font-size:11.5px; font-weight:800; cursor:pointer; transition:all .2s; text-decoration:none; display:inline-flex; align-items:center; gap:5px; }
    .kb-btn:hover { border-color:rgba(5,150,105,.45); color:var(--text); transform:translateY(-2px); }
    .kb-btn.danger:hover { border-color:rgba(220,38,38,.5); color:#fca5a5; }

    .kb-empty { text-align:center; padding:50px 20px; color:var(--muted); background:var(--surface); border:2px dashed var(--border); border-radius:20px; }

    /* Modal form */
    .kb-modal { position:fixed; inset:0; z-index:10000; background:rgba(3,37,31,.6); backdrop-filter:blur(6px); display:none; align-items:center; justify-content:center; padding:20px; }
    .kb-modal.open { display:flex; animation:kbFade .25s both; }
    .kb-modal-content { background:var(--surface); border:1px solid var(--border); border-radius:22px; padding:28px; width:100%; max-width:640px; max-height:90vh; overflow-y:auto; box-shadow:0 30px 80px rgba(0,0,0,.4); }
    .kb-modal h3 { display:flex; align-items:center; gap:10px; margin:0 0 18px; font-family:var(--font-display); font-size:17px; font-weight:900; color:#fff; padding-bottom:12px; border-bottom:1px dashed var(--border); }
    .kb-modal h3 .emo { width:34px; height:34px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; background:rgba(5,150,105,.14); }
    .kb-close-x { margin-left:auto; width:30px; height:30px; border-radius:9px; border:none; background:rgba(255,255,255,.05); color:var(--muted); font-size:14px; cursor:pointer; }
    .kb-field { margin-bottom:14px; }
    .kb-field label { display:block; font-size:11px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); margin-bottom:6px; }
    .kb-field input, .kb-field select, .kb-field textarea { width:100%; padding:11px 14px; border-radius:11px; border:1px solid var(--border); background:var(--surface); font-size:13.5px; font-weight:600; color:var(--text); font-family:inherit; }
    .kb-field textarea { min-height:110px; line-height:1.6; resize:vertical; }
    .kb-field input:focus, .kb-field select:focus, .kb-field textarea:focus { outline:none; border-color:#059669; box-shadow:0 0 0 4px rgba(5,150,105,.12); }
    .kb-field-row { display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; }
    .kb-field-row-2 { display:grid; grid-template-columns:1fr 100px; gap:12px; align-items:end; }
    .kb-modal-actions { display:flex; gap:10px; margin-top:18px; }
    .kb-submit { flex:1; padding:13px; border:none; border-radius:12px; font-size:14px; font-weight:900; cursor:pointer; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:0 6px 16px rgba(217,164,65,.35); font-family:var(--font-display); }
    .kb-cancel { padding:13px 22px; border-radius:12px; font-size:14px; font-weight:700; color:var(--muted); background:rgba(255,255,255,.05); border:2px solid var(--border); cursor:pointer; }
</style>

<div class="kb-head">
    <a class="kb-back" href="<?= e(url('admin/index.php?page=chatbot')) ?>">← Dashboard</a>
    <div style="flex:1;">
        <h2>📚 Knowledge Base</h2>
        <p>Kelola pengetahuan yang dikuasai Siti. Tambah pertanyaan-jawaban agar bot lebih pintar.</p>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<div class="kb-filter">
    <span class="label">🏷️ Filter:</span>
    <a href="<?= e(url('admin/index.php?page=chatbot-knowledge')) ?>" class="<?= $currentCat === '' ? 'active' : '' ?>">Semua (<?= count($items) ?>)</a>
    <?php foreach ($categories as $k => $l):
        $cnt = count(array_filter($items, fn($i) => $i['category'] === $k));
    ?>
    <a href="<?= e(url('admin/index.php?page=chatbot-knowledge&cat=' . urlencode($k))) ?>" class="<?= $currentCat === $k ? 'active' : '' ?>"><?= e($l) ?> (<?= $cnt ?>)</a>
    <?php endforeach; ?>
    <button class="add" type="button" onclick="openForm()">➕ Tambah Pengetahuan</button>
</div>

<?php if (empty($items)): ?>
<div class="kb-empty">
    <div style="font-size:48px; margin-bottom:10px;">📭</div>
    <h3 style="margin:0 0 6px; color:var(--ink);">Belum Ada Pengetahuan</h3>
    <p style="margin:0;">Klik "Tambah Pengetahuan" untuk menambahkan pertanyaan & jawaban pertama.</p>
</div>
<?php else: ?>
<div class="kb-list">
    <?php foreach ($items as $i => $it):
        $catLabel = $categories[$it['category']] ?? 'Umum';
        $keywords = array_filter(array_map('trim', explode(',', (string) $it['keywords'])));
    ?>
    <div class="kb-item <?= empty($it['active']) ? 'inactive' : '' ?>">
        <div class="kb-top-row">
            <span class="kb-ico"><?= e(explode(' ', $catLabel)[0] ?? '📋') ?></span>
            <div class="kb-info">
                <div class="kb-q"><?= e($it['question']) ?></div>
                <div class="kb-meta">
                    <span class="tag cat"><?= e($catLabel) ?></span>
                    <span class="tag prio">Priority: <?= (int) $it['priority'] ?></span>
                    <span class="stat <?= !empty($it['active']) ? 'on' : 'off' ?>"><?= !empty($it['active']) ? '✓ Aktif' : '⏸ Nonaktif' ?></span>
                </div>
            </div>
        </div>

        <div class="kb-ans"><?= e($it['answer']) ?></div>

        <div class="kb-kw">
            <span style="background:transparent; color:var(--muted); border:none; padding:0; font-weight:800; font-size:10px; letter-spacing:.1em; text-transform:uppercase;">Keywords:</span>
            <?php foreach ($keywords as $kw): if ($kw === '') continue; ?>
            <span><?= e($kw) ?></span>
            <?php endforeach; ?>
        </div>

        <div class="kb-acts">
            <button class="kb-btn" type="button" onclick='openForm(<?= json_encode($it, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>✏️ Edit</button>
            <form method="post" action="<?= e(url('admin/index.php?page=chatbot-knowledge-toggle')) ?>" style="display:inline;">
                <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $it['id'] ?>">
                <button class="kb-btn" type="submit"><?= !empty($it['active']) ? '⏸ Nonaktifkan' : '✓ Aktifkan' ?></button>
            </form>
            <form method="post" action="<?= e(url('admin/index.php?page=chatbot-knowledge-delete')) ?>" style="display:inline;" onsubmit="return confirm('Hapus pengetahuan ini?');">
                <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $it['id'] ?>">
                <button class="kb-btn danger" type="submit">🗑️ Hapus</button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- MODAL FORM -->
<div class="kb-modal" id="kbModal">
    <div class="kb-modal-content">
        <form method="post" action="<?= e(url('admin/index.php?page=chatbot-knowledge-save')) ?>" id="kbForm">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="f-id" value="0">
            <h3><span class="emo">📝</span><span id="f-title">Tambah Pengetahuan</span><button type="button" class="kb-close-x" onclick="closeForm()">✕</button></h3>

            <div class="kb-field">
                <label>Pertanyaan <span style="color:#fca5a5">*</span></label>
                <input type="text" name="question" id="f-question" required placeholder="Contoh: Bagaimana cara mengajukan proposal penelitian?">
            </div>

            <div class="kb-field">
                <label>Jawaban <span style="color:#fca5a5">*</span></label>
                <textarea name="answer" id="f-answer" required placeholder="Tulis jawaban yang jelas & lengkap. Gunakan baris baru untuk daftar langkah."></textarea>
            </div>

            <div class="kb-field">
                <label>Kata Kunci <span style="color:#fca5a5">*</span> <span style="font-size:10px; text-transform:none; color:var(--muted); font-weight:600;">— pisah dengan koma</span></label>
                <input type="text" name="keywords" id="f-keywords" required placeholder="penelitian, proposal, skema, riset">
            </div>

            <div class="kb-field-row">
                <div class="kb-field">
                    <label>Kategori</label>
                    <select name="category" id="f-category">
                        <?php foreach ($categories as $k => $l): ?>
                        <option value="<?= e($k) ?>"><?= e($l) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="kb-field">
                    <label>Priority</label>
                    <input type="number" name="priority" id="f-priority" min="0" max="100" value="50">
                </div>
                <div class="kb-field">
                    <label>Status</label>
                    <select name="active" id="f-active">
                        <option value="1">✓ Aktif</option>
                        <option value="0">⏸ Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="kb-modal-actions">
                <button type="button" class="kb-cancel" onclick="closeForm()">Batal</button>
                <button type="submit" class="kb-submit">💾 Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
var modal = document.getElementById('kbModal');
function openForm(data) {
    document.getElementById('f-id').value = data ? data.id : 0;
    document.getElementById('f-question').value = data ? data.question : '';
    document.getElementById('f-answer').value = data ? data.answer : '';
    document.getElementById('f-keywords').value = data ? data.keywords : '';
    document.getElementById('f-category').value = data ? data.category : 'umum';
    document.getElementById('f-priority').value = data ? data.priority : 50;
    document.getElementById('f-active').value = data ? (data.active ? '1' : '0') : '1';
    document.getElementById('f-title').textContent = data ? '✏️ Edit Pengetahuan' : '➕ Tambah Pengetahuan';
    modal.classList.add('open');
}
function closeForm() { modal.classList.remove('open'); }
modal.addEventListener('click', function(e){ if (e.target === modal) closeForm(); });
document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && modal.classList.contains('open')) closeForm(); });
</script>