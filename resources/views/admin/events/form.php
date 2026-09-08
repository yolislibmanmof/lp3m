<style>
    @keyframes evfFade { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:none; } }
    @keyframes evfShine { 0%,55% { left:-90%; } 100% { left:165%; } }

    .evf-head { display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:22px 26px; border-radius:22px; background:linear-gradient(135deg,#3b2f0a,#8a6f1a 55%,#d9a441); color:#fff; position:relative; overflow:hidden; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:evfFade .5s both; }
    .evf-head::after { content:''; position:absolute; top:-50%; right:-10%; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle,rgba(255,255,255,.18),transparent 70%); pointer-events:none; }
    .evf-head-ico { width:54px; height:54px; border-radius:16px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:25px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.55),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), inset 0 -3px 5px rgba(0,0,0,.22); position:relative; z-index:1; }
    .evf-title { font-family:var(--font-display); font-size:21px; font-weight:900; letter-spacing:-.02em; margin:0; color:#fff; position:relative; z-index:1; }
    .evf-sub { font-size:12.5px; opacity:.9; margin:3px 0 0; position:relative; z-index:1; }
    .evf-badge { margin-left:auto; padding:4px 12px; border-radius:999px; font-size:10px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; background:rgba(255,255,255,.18); border:1px solid rgba(255,255,255,.35); position:relative; z-index:1; }

    .evf-flash { position:relative; padding:14px 18px; margin-bottom:18px; border-radius:14px; font-size:13.5px; font-weight:700; display:flex; align-items:center; gap:10px; overflow:hidden; animation:evfFade .4s both; }
    .evf-flash::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:evfShine 3s ease-in-out infinite; }
    .evf-flash.ok { background:linear-gradient(145deg,#d1fae5,#a7f3d0); border:1px solid rgba(16,185,129,.35); color:#065f46; }
    .evf-flash.err { background:linear-gradient(145deg,#fee2e2,#fecaca); border:1px solid rgba(220,38,38,.35); color:#991b1b; }

    .evf-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px 26px; margin-bottom:18px; position:relative; overflow:hidden; animation:evfFade .5s both; }
    .evf-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,var(--gold-strong),#10b981); opacity:.75; }
    .evf-card-title { display:flex; align-items:center; gap:10px; font-size:14.5px; font-weight:900; color:#fff; font-family:var(--font-display); margin:0 0 20px; padding-bottom:13px; border-bottom:1px dashed var(--border); }
    .evf-card-title .emo { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:10px; background:linear-gradient(145deg,rgba(255,255,255,.08),rgba(255,255,255,.03)); border:1px solid var(--border); font-size:15px; }
    .evf-card-title .num { margin-left:auto; font-size:10px; font-weight:900; letter-spacing:.1em; color:var(--muted); }

    .evf-field { margin-bottom:18px; }
    .evf-field:last-child { margin-bottom:0; }
    .evf-label { display:flex; align-items:center; gap:8px; font-size:11.5px; font-weight:850; letter-spacing:.08em; text-transform:uppercase; color:#cfe7dd; margin-bottom:8px; }
    .evf-req { padding:1px 8px; border-radius:999px; font-size:8.5px; font-weight:900; background:rgba(220,38,38,.15); color:#fca5a5; border:1px solid rgba(220,38,38,.4); }
    .evf-opt { padding:1px 8px; border-radius:999px; font-size:8.5px; font-weight:800; background:rgba(255,255,255,.08); color:rgba(255,255,255,.6); border:1px solid rgba(255,255,255,.15); }
    .evf-count { margin-left:auto; font-family:var(--font-display); font-size:10px; font-weight:800; color:var(--muted); background:rgba(255,255,255,.06); padding:2px 8px; border-radius:6px; }

    .evf-input, .evf-select, .evf-textarea {
        width:100%; padding:13px 16px; border-radius:13px; border:2px solid var(--border);
        background:linear-gradient(145deg,rgba(255,255,255,.05),rgba(255,255,255,.02));
        font-size:14px; font-weight:600; color:var(--text); outline:none;
        transition:all .25s; font-family:inherit; color-scheme:dark;
    }
    .evf-input::placeholder, .evf-textarea::placeholder { color:rgba(255,255,255,.35); font-weight:500; }
    .evf-input:focus, .evf-select:focus, .evf-textarea:focus { border-color:var(--gold-strong); background:rgba(255,255,255,.08); box-shadow:0 0 0 4px rgba(217,164,65,.16), 0 4px 12px rgba(217,164,65,.14); }
    .evf-input:disabled { opacity:.4; cursor:not-allowed; }
    .evf-select { appearance:none; -webkit-appearance:none; cursor:pointer; padding-right:44px; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23f2c063' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 16px center; }
    .evf-select option { background:#0d1d17; color:#eaf5f0; }
    .evf-textarea { min-height:120px; resize:vertical; line-height:1.7; }
    .evf-row2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    @media (max-width:700px){ .evf-row2 { grid-template-columns:1fr; } }
    .evf-hint { display:flex; justify-content:space-between; gap:10px; margin-top:7px; font-size:11px; color:var(--muted); flex-wrap:wrap; }

    .evf-pub-hint { display:none; margin-top:8px; padding:8px 12px; border-radius:10px; background:rgba(16,185,129,.1); border:1px solid rgba(16,185,129,.35); color:#6ee7b7; font-size:11.5px; font-weight:700; }
    .evf-pub-hint.show { display:flex; align-items:center; gap:7px; }
    .evf-pub-hint i { width:8px; height:8px; border-radius:50%; background:#10b981; box-shadow:0 0 8px rgba(16,185,129,.8); }

    /* Checkbox chip toggle */
    .evf-checks { display:flex; gap:10px; flex-wrap:wrap; }
    .evf-chk { position:relative; cursor:pointer; }
    .evf-chk input { position:absolute; inset:0; opacity:0; cursor:pointer; }
    .evf-chk span { display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:999px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--muted); font-size:12px; font-weight:800; transition:all .2s; }
    .evf-chk span::before { content:''; width:15px; height:15px; border-radius:5px; border:2px solid var(--border); background:transparent; transition:all .2s; flex-shrink:0; }
    .evf-chk:hover span { border-color:rgba(217,164,65,.4); color:var(--text); }
    .evf-chk input:checked + span { background:rgba(16,185,129,.14); border-color:rgba(16,185,129,.5); color:#6ee7b7; }
    .evf-chk input:checked + span::before { content:'✓'; font-size:10px; font-weight:900; color:#03251f; background:linear-gradient(145deg,#6ee7b7,#059669); border-color:transparent; display:flex; align-items:center; justify-content:center; }

    .evf-actions { display:flex; gap:12px; flex-wrap:wrap; align-items:center; }
    .evf-btn-gold { position:relative; overflow:hidden; padding:14px 28px; border:none; border-radius:13px; font-size:14px; font-weight:850; color:#03251f; cursor:pointer; background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441 80%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.15), 0 8px 20px rgba(217,164,65,.4); font-family:var(--font-display); transition:all .25s; }
    .evf-btn-gold::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:evfShine 3s ease-in-out infinite; }
    .evf-btn-gold:hover { transform:translateY(-2px); }
    .evf-btn-gold:disabled { opacity:.6; cursor:not-allowed; }
    .evf-btn-ghost { padding:14px 24px; border-radius:13px; font-size:14px; font-weight:700; color:var(--muted); background:linear-gradient(145deg,rgba(255,255,255,.06),rgba(255,255,255,.03)); border:2px solid var(--border); text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all .25s; }
    .evf-btn-ghost:hover { border-color:rgba(220,38,38,.45); color:#fca5a5; transform:translateY(-2px); }
</style>

<?php if (!empty($flash)): ?>
<div class="evf-flash <?= $flash['type'] === 'error' ? 'err' : 'ok' ?>"><?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?></div>
<?php endif; ?>

<div class="evf-head">
    <div class="evf-head-ico">📅</div>
    <div style="position:relative; z-index:1; flex:1; min-width:0;">
        <h2 class="evf-title"><?= $item !== null ? 'Edit Kegiatan' : 'Tambah Kegiatan Baru' ?></h2>
        <p class="evf-sub"><?= $item !== null ? 'Perbarui detail agenda kegiatan lembaga.' : 'Jadwalkan agenda penelitian, pengabdian, pelatihan, seminar, atau AIK.' ?></p>
    </div>
    <span class="evf-badge"><?= $item !== null ? '✎ Edit' : '＋ Baru' ?></span>
</div>

<form method="post" action="<?= e($action) ?>" id="evf-form">
    <?= csrf_field() ?>
    <?php if ($item !== null): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>

    <!-- BAGIAN 1 -->
    <div class="evf-card">
        <h3 class="evf-card-title"><span class="emo">📋</span><span>Informasi Kegiatan</span><span class="num">BAGIAN 1 / 3</span></h3>
        <div class="evf-field">
            <label class="evf-label">Judul Kegiatan <span class="evf-req">WAJIB</span><span class="evf-count" id="evf-tcount">0/100</span></label>
            <input class="evf-input" type="text" name="title" id="evf-title" maxlength="100" required
                   value="<?= e($item['title'] ?? old('title')) ?>" placeholder="Contoh: Workshop Penulisan Jurnal Scopus Q1-Q2">
        </div>
        <div class="evf-row2">
            <div class="evf-field">
                <label class="evf-label">Jenis Kegiatan</label>
                <select class="evf-select" name="event_type">
                    <?php foreach (CalendarEvent::TYPES as $k => $l): ?>
                    <option value="<?= e($k) ?>" <?= ($item['event_type'] ?? 'lainnya') === $k ? 'selected' : '' ?>><?= e($l) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="evf-field">
                <label class="evf-label">Status</label>
                <select class="evf-select" name="status" id="evf-status">
                    <?php foreach (CalendarEvent::STATUSES as $k => $l): ?>
                    <option value="<?= e($k) ?>" <?= ($item['status'] ?? 'published') === $k ? 'selected' : '' ?>><?= e($l) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="evf-pub-hint" id="evf-pub-hint"><i></span></i><i></i> Akan tampil di website publik</div>
            </div>
        </div>
    </div>

    <!-- BAGIAN 2 -->
    <div class="evf-card" style="animation-delay:.06s">
        <h3 class="evf-card-title"><span class="emo">🕐</span><span>Waktu & Tempat</span><span class="num">BAGIAN 2 / 3</span></h3>
        <div class="evf-row2">
            <div class="evf-field">
                <label class="evf-label">Tanggal Mulai <span class="evf-req">WAJIB</span></label>
                <input class="evf-input" type="date" name="start_date" id="evf-start" required
                       value="<?= e($item['start_date'] ?? old('start_date', date('Y-m-d'))) ?>">
            </div>
            <div class="evf-field">
                <label class="evf-label">Tanggal Selesai <span class="evf-opt">OPSIONAL</span></label>
                <input class="evf-input" type="date" name="end_date" id="evf-end"
                       value="<?= e($item['end_date'] ?? old('end_date')) ?>">
            </div>
        </div>
        <div class="evf-row2">
            <div class="evf-field">
                <label class="evf-label">Jam Mulai <span class="evf-opt">OPSIONAL</span></label>
                <input class="evf-input evf-time" type="time" name="start_time"
                       value="<?= e($item['start_time'] ?? old('start_time')) ?>">
            </div>
            <div class="evf-field">
                <label class="evf-label">Jam Selesai <span class="evf-opt">OPSIONAL</span></label>
                <input class="evf-input evf-time" type="time" name="end_time"
                       value="<?= e($item['end_time'] ?? old('end_time')) ?>">
            </div>
        </div>
        <div class="evf-row2">
            <div class="evf-field">
                <label class="evf-label">Lokasi</label>
                <input class="evf-input" type="text" name="location"
                       value="<?= e($item['location'] ?? old('location')) ?>" placeholder="Aula UNIMOF / Zoom Meeting">
            </div>
            <div class="evf-field">
                <label class="evf-label">Penyelenggara</label>
                <input class="evf-input" type="text" name="organizer"
                       value="<?= e($item['organizer'] ?? old('organizer', 'LP3M UNIMOF')) ?>">
            </div>
        </div>
    </div>

    <!-- BAGIAN 3 -->
    <div class="evf-card" style="animation-delay:.12s">
        <h3 class="evf-card-title"><span class="emo">⚙️</span><span>Detail & Notifikasi</span><span class="num">BAGIAN 3 / 3</span></h3>
        <div class="evf-row2">
            <div class="evf-field">
                <label class="evf-label">Maks Peserta</label>
                <input class="evf-input" type="number" name="max_participants" min="0"
                       value="<?= e($item['max_participants'] ?? old('max_participants', '0')) ?>">
            </div>
            <div class="evf-field">
                <label class="evf-label">Link Pendaftaran <span class="evf-opt">OPSIONAL</span></label>
                <input class="evf-input" type="url" name="registration_link"
                       value="<?= e($item['registration_link'] ?? old('registration_link')) ?>" placeholder="https://...">
            </div>
        </div>
        <div class="evf-field">
            <label class="evf-label">Deskripsi Kegiatan</label>
            <textarea class="evf-textarea" name="description" rows="4" placeholder="Ringkasan tujuan, sasaran, dan susunan acara..."><?= e($item['description'] ?? old('description')) ?></textarea>
        </div>
        <div class="evf-field">
            <label class="evf-label">Reminder Otomatis & Opsi Waktu</label>
            <div class="evf-checks">
                <label class="evf-chk"><input type="checkbox" name="reminder_h7" value="1" <?= ($item['reminder_h7'] ?? 1) ? 'checked' : '' ?>><span>🔔 H-7</span></label>
                <label class="evf-chk"><input type="checkbox" name="reminder_h3" value="1" <?= ($item['reminder_h3'] ?? 1) ? 'checked' : '' ?>><span>🔔 H-3</span></label>
                <label class="evf-chk"><input type="checkbox" name="reminder_h1" value="1" <?= ($item['reminder_h1'] ?? 1) ? 'checked' : '' ?>><span>🔔 H-1</span></label>
                <label class="evf-chk"><input type="checkbox" name="is_all_day" value="1" id="evf-allday" <?= ($item['is_all_day'] ?? 0) ? 'checked' : '' ?>><span>📆 Acara seharian</span></label>
            </div>
        </div>
    </div>

    <div class="evf-actions">
        <button type="submit" class="evf-btn-gold" id="evf-save"><?= $item !== null ? '💾 Simpan Perubahan' : '➕ Simpan Kegiatan' ?></button>
        <a href="<?= e(url('admin/index.php?page=events')) ?>" class="evf-btn-ghost">✖ Batal</a>
    </div>
</form>

<script>
(function(){
    var t = document.getElementById('evf-title'), tc = document.getElementById('evf-tcount');
    if (t && tc) { var u = function(){ tc.textContent = t.value.length + '/100'; }; t.addEventListener('input', u); u(); }

    // Status → hint publik
    var st = document.getElementById('evf-status'), hint = document.getElementById('evf-pub-hint');
    if (st && hint) {
        var uh = function(){ hint.classList.toggle('show', st.value === 'published'); };
        st.addEventListener('change', uh); uh();
    }

    // Acara seharian → disable jam
    var allday = document.getElementById('evf-allday');
    var times = document.querySelectorAll('.evf-time');
    if (allday) {
        var ua = function(){
            times.forEach(function(el){
                el.disabled = allday.checked;
                if (allday.checked) el.value = '';
            });
        };
        allday.addEventListener('change', ua); ua();
    }

    // Sinkron tanggal selesai
    var s = document.getElementById('evf-start'), e2 = document.getElementById('evf-end');
    if (s && e2) {
        s.addEventListener('change', function(){
            if (!e2.value || e2.value < s.value) e2.value = s.value;
        });
    }

    var form = document.getElementById('evf-form'), save = document.getElementById('evf-save');
    if (form && save) form.addEventListener('submit', function(){ save.disabled = true; save.textContent = '⏳ Menyimpan...'; });
})();
</script>