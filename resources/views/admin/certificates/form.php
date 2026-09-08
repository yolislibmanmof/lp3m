<style>
    /* ===== HEADER ===== */
    .cert-form-head { display:flex; align-items:center; gap:16px; margin-bottom:24px; padding:22px 26px; border-radius:22px; background:linear-gradient(135deg,#043b2c 0%,#065f46 55%,#059669 100%); color:#fff; position:relative; overflow:hidden; box-shadow:0 16px 40px rgba(0,0,0,.30); }
    .cert-form-head::before { content:''; position:absolute; inset:0; background-image:repeating-linear-gradient(45deg,transparent,transparent 25px,rgba(217,164,65,.04) 25px,rgba(217,164,65,.04) 26px),repeating-linear-gradient(-45deg,transparent,transparent 25px,rgba(217,164,65,.04) 25px,rgba(217,164,65,.04) 26px); }
    .cert-form-head::after { content:''; position:absolute; top:-50%; right:-10%; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.25),transparent 70%); pointer-events:none; }
    .cert-form-ico { width:56px; height:56px; border-radius:16px; flex-shrink:0; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.5),transparent 40%),linear-gradient(145deg,#fde68a,#f2c063 50%,#d9a441); display:flex; align-items:center; justify-content:center; font-size:26px; position:relative; box-shadow:inset 0 2px 3px rgba(255,255,255,.7),inset 0 -3px 4px rgba(0,0,0,.2),0 6px 16px rgba(217,164,65,.45); }
    .cert-form-ico::before { content:''; position:absolute; top:5px; left:10px; width:16px; height:7px; border-radius:50%; background:rgba(255,255,255,.65); filter:blur(1.5px); }
    .cert-form-title { font-family:var(--font-display); font-size:22px; font-weight:900; letter-spacing:-.02em; margin:0; position:relative; z-index:1; background:linear-gradient(135deg,#fff 0%,#fde68a 100%); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .cert-form-sub { font-size:12.5px; opacity:.85; margin:4px 0 0; position:relative; z-index:1; }
    .cert-form-mode { margin-left:auto; padding:4px 12px; border-radius:999px; font-size:10px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; position:relative; z-index:1; flex-shrink:0; }
    .cert-form-mode.edit { background:linear-gradient(145deg,#fde68a,#d9a441); color:#03251f; box-shadow:inset 0 1px 2px rgba(255,255,255,.7),inset 0 -1px 2px rgba(0,0,0,.15); }
    .cert-form-mode.new { background:rgba(255,255,255,.15); color:#fff; border:1px solid rgba(255,255,255,.3); }

    /* ===== LAYOUT 2 KOLOM ===== */
    .cert-layout { display:grid; grid-template-columns:minmax(0,1fr) 340px; gap:20px; align-items:start; }
    .cert-side { position:sticky; top:86px; display:flex; flex-direction:column; gap:16px; }
    @media(max-width:1000px) { .cert-layout { grid-template-columns:1fr; } .cert-side { position:static; } }

    /* ===== SECTION CARD GELAP ===== */
    .cert-section-3d { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:26px; margin-bottom:20px; box-shadow:0 6px 20px rgba(0,0,0,.2); position:relative; overflow:hidden; }
    .cert-section-3d::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,var(--gold-strong),var(--primary)); opacity:.7; }
    .cert-section-title { display:flex; align-items:center; gap:10px; font-size:15px; font-weight:900; color:#fff; font-family:var(--font-display); margin:0 0 22px; padding-bottom:14px; border-bottom:1px dashed var(--border); }
    .cert-section-title .section-emoji { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:10px; background:linear-gradient(145deg,rgba(255,255,255,.08),rgba(255,255,255,.03)); border:1px solid var(--border); font-size:15px; box-shadow:inset 0 1px 1px rgba(255,255,255,.06); }
    .cert-section-title .section-num { margin-left:auto; font-size:10px; font-weight:900; letter-spacing:.1em; color:var(--muted); }

    /* ===== FIELD GROUP ===== */
    .cert-fg-3d { margin-bottom:20px; position:relative; }
    .cert-fg-3d:last-child { margin-bottom:0; }
    .cert-fg-3d label { display:flex; align-items:center; gap:8px; font-size:11.5px; font-weight:850; letter-spacing:.08em; text-transform:uppercase; color:#cfe7dd; margin-bottom:9px; }
    .cert-fg-3d label .field-ico { display:inline-flex; align-items:center; justify-content:center; width:22px; height:22px; border-radius:7px; background:linear-gradient(145deg,rgba(16,185,129,.18),rgba(5,150,105,.10)); font-size:11px; }
    .cert-fg-3d label .req-badge { display:inline-flex; align-items:center; gap:4px; padding:1px 7px; border-radius:999px; font-size:8.5px; font-weight:900; letter-spacing:.08em; background:rgba(220,38,38,.15); color:#fca5a5; border:1px solid rgba(220,38,38,.4); margin-left:4px; text-transform:uppercase; }
    .cert-fg-3d label .opt-badge { padding:1px 7px; border-radius:999px; font-size:8.5px; font-weight:800; letter-spacing:.08em; background:rgba(255,255,255,.08); color:rgba(255,255,255,.6); border:1px solid rgba(255,255,255,.15); text-transform:uppercase; }
    .cert-counter { margin-left:auto; font-family:var(--font-display); font-size:10px; font-weight:800; color:var(--muted); background:rgba(255,255,255,.06); padding:2px 8px; border-radius:6px; }

    /* ===== INPUT GELAP ===== */
    .cert-fg-3d input[type="text"],.cert-fg-3d input[type="date"],.cert-fg-3d select {
        width:100%; padding:13px 16px; border-radius:13px; border:2px solid var(--border);
        background:linear-gradient(145deg,rgba(255,255,255,0.05),rgba(255,255,255,0.02));
        font-size:14px; font-weight:600; color:var(--text); outline:none;
        transition:all .3s cubic-bezier(.16,1,.3,1); color-scheme:dark;
    }
    .cert-fg-3d input::placeholder { color:rgba(255,255,255,.35); font-weight:500; }
    .cert-fg-3d select {
        appearance:none; -webkit-appearance:none; cursor:pointer; padding-right:44px;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23f2c063' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:right 16px center; background-size:12px 8px;
    }
    .cert-fg-3d select option { background:#0d1d17; color:#eaf5f0; }
    .cert-fg-3d input:focus,.cert-fg-3d select:focus {
        border-color:var(--gold-strong); background:rgba(255,255,255,0.08);
        box-shadow:inset 0 2px 4px rgba(0,0,0,.18),0 0 0 4px rgba(217,164,65,0.18),0 4px 14px rgba(217,164,65,0.15);
    }
    .cert-fg-3d input:-webkit-autofill,.cert-fg-3d input:-webkit-autofill:hover,.cert-fg-3d input:-webkit-autofill:focus {
        -webkit-box-shadow:0 0 0 1000px #0d1d17 inset !important; -webkit-text-fill-color:#eaf5f0 !important; caret-color:#f2c063 !important;
    }
    .cert-fg-3d .field-helper { display:flex; align-items:center; justify-content:space-between; gap:8px; margin-top:7px; font-size:11px; color:var(--muted); flex-wrap:wrap; }
    .cert-fg-3d .field-helper .helper-tip { display:inline-flex; align-items:center; gap:4px; }

    /* ===== CODE PREVIEW ===== */
    .cert-code-preview { margin-top:10px; padding:14px 18px; border-radius:12px; background:linear-gradient(145deg,rgba(16,185,129,.10),rgba(16,185,129,.04)); border:2px dashed rgba(110,231,183,.35); }
    .cert-code-preview .code-label { font-size:10px; font-weight:900; letter-spacing:.15em; color:#6ee7b7; text-transform:uppercase; margin-bottom:6px; }
    .cert-code-preview .code-value { font-family:'Courier New',monospace; font-size:15px; font-weight:900; color:#6ee7b7; letter-spacing:.03em; word-break:break-all; }
    .cert-code-preview .code-hint { font-size:10.5px; color:var(--muted); margin-top:6px; }

    .cert-row-3d { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    @media(max-width:640px) { .cert-row-3d { grid-template-columns:1fr; } }

    /* ===== UPLOAD TANDA TANGAN ===== */
    .cert-sig-drop { position:relative; border:2px dashed var(--border); border-radius:12px; padding:14px; text-align:center; cursor:pointer; transition:all .25s; background:rgba(255,255,255,.03); }
    .cert-sig-drop:hover, .cert-sig-drop.dragover { border-color:var(--gold-strong); background:rgba(217,164,65,.08); }
    .cert-sig-drop input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; }
    .sig-drop-inner { display:flex; align-items:center; justify-content:center; gap:10px; font-size:12px; color:var(--muted); font-weight:600; }
    .sig-drop-ico { font-size:20px; }
    .cert-sig-preview { margin-top:10px; padding:10px; border:1px solid var(--border); border-radius:12px; background:#fffdf8; display:flex; align-items:center; gap:12px; }
    .cert-sig-preview img { max-height:64px; max-width:180px; object-fit:contain; }
    .sig-preview-meta { font-size:11px; color:var(--muted); }
    .cert-sig-current { margin-top:10px; padding:10px; border:1px dashed rgba(110,231,183,.35); border-radius:12px; background:rgba(16,185,129,.06); display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
    .cert-sig-current img { max-height:64px; max-width:180px; object-fit:contain; background:#fffdf8; border-radius:8px; padding:4px; }
    .cert-check { display:flex; align-items:center; gap:8px; font-size:12px; color:#fca5a5; font-weight:700; cursor:pointer; text-transform:none; letter-spacing:0; }
    .cert-check input { width:16px; height:16px; accent-color:#dc2626; cursor:pointer; }

    /* ===== LIVE PREVIEW ===== */
    .cert-preview-panel,.cert-tools-panel { background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:16px; box-shadow:0 6px 20px rgba(0,0,0,.2); }
    .cpp-title,.ctp-title { font-size:10px; font-weight:900; letter-spacing:.15em; color:var(--gold-strong); text-transform:uppercase; margin-bottom:12px; display:flex; align-items:center; gap:6px; }
    .cpp-page { position:relative; aspect-ratio:297/210; background:#fffdf8; border-radius:6px; overflow:hidden; box-shadow:0 10px 26px rgba(0,0,0,.4); }
    .cpp-border { position:absolute; inset:6px; border:2px solid #d9a441; pointer-events:none; }
    .cpp-inner { position:absolute; inset:10px; display:flex; flex-direction:column; align-items:center; text-align:center; padding:8px 12px; }
    .cpp-inst { font-family:Georgia,serif; font-size:9px; font-weight:700; color:#0b3d2e; letter-spacing:.04em; }
    .cpp-doc { font-family:Georgia,serif; font-size:15px; font-weight:700; letter-spacing:.22em; text-indent:.22em; color:#0b3d2e; margin-top:4px; }
    .cpp-type { font-size:6.5px; font-weight:800; letter-spacing:.3em; text-indent:.3em; color:#b8860b; }
    .cpp-given { font-size:6.5px; color:#4a5b52; font-style:italic; margin-top:6px; }
    .cpp-name { font-family:'Segoe Script','Brush Script MT',Georgia,cursive; font-size:13px; color:#123f30; line-height:1.2; max-width:92%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .cpp-id { font-size:6px; color:#6b7a6e; }
    .cpp-for { font-size:6.5px; color:#4a5b52; margin-top:4px; }
    .cpp-act { font-size:8.5px; font-weight:800; color:#0b3d2e; line-height:1.3; max-width:92%; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .cpp-date { font-size:6.5px; color:#4a5b52; margin-top:3px; }
    .cpp-foot { margin-top:auto; width:100%; display:flex; justify-content:space-between; align-items:flex-end; padding:0 6px; }
    .cpp-qr { width:26px; height:26px; border:1px solid #ddd; background:#fff; display:flex; align-items:center; justify-content:center; font-size:14px; color:#333; }
    .cpp-sign { text-align:center; width:45%; }
    .cpp-sign-title { font-size:6.5px; color:#4a5b52; }
    .cpp-sign-space { height:14px; display:flex; align-items:center; justify-content:center; }
    .cpp-sign-name { font-size:7px; font-weight:800; color:#0b3d2e; text-decoration:underline; }
    .cpp-code { margin-top:4px; font-family:'Courier New',monospace; font-size:6px; color:#8a978d; }
    .cpp-hint { font-size:10px; color:var(--muted); margin-top:8px; text-align:center; }

    /* ===== ALAT BANTU ===== */
    .ctp-grid { display:flex; flex-direction:column; gap:8px; }
    .ctp-btn { display:flex; align-items:center; gap:8px; padding:9px 12px; border-radius:10px; border:1px solid var(--border); background:linear-gradient(145deg,rgba(255,255,255,.06),rgba(255,255,255,.03)); color:var(--text); font-size:12px; font-weight:700; cursor:pointer; transition:all .2s; text-align:left; font-family:inherit; }
    .ctp-btn:hover { border-color:rgba(217,164,65,.5); color:#f2c063; transform:translateY(-1px); }
    .ctp-select { width:100%; padding:9px 12px; border-radius:10px; border:1px solid var(--border); background:rgba(255,255,255,.05); color:var(--text); font-size:12px; font-weight:600; cursor:pointer; }
    .ctp-select option { background:#0d1d17; color:#eaf5f0; }
    .ctp-note { font-size:10px; color:var(--muted); line-height:1.5; }

    /* ===== ACTIONS ===== */
    .cert-actions-3d { display:flex; gap:12px; flex-wrap:wrap; align-items:center; padding-top:8px; }
    .cert-btn-save-3d { position:relative; padding:14px 28px; border:none; border-radius:13px; font-size:14px; font-weight:850; color:#03251f; cursor:pointer; background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441 80%,#a9761b); overflow:hidden; transition:all .3s cubic-bezier(.16,1,.3,1); box-shadow:inset 0 2px 3px rgba(255,255,255,.7),inset 0 -2px 3px rgba(0,0,0,.15),0 8px 20px rgba(217,164,65,.4); font-family:var(--font-display); }
    .cert-btn-save-3d::before { content:''; position:absolute; top:3px; left:10%; width:35%; height:35%; border-radius:50%; background:rgba(255,255,255,.6); filter:blur(2px); pointer-events:none; }
    .cert-btn-save-3d::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:certShine 3s ease-in-out infinite; pointer-events:none; }
    .cert-btn-save-3d:hover { transform:translateY(-2px); box-shadow:inset 0 2px 3px rgba(255,255,255,.8),0 14px 30px rgba(217,164,65,.55); }
    .cert-btn-save-3d:disabled { opacity:.6; cursor:not-allowed; }
    .cert-btn-cancel-3d { padding:14px 24px; border-radius:13px; text-decoration:none; font-size:14px; font-weight:700; color:var(--muted); background:linear-gradient(145deg,rgba(255,255,255,.06),rgba(255,255,255,.03)); border:2px solid var(--border); transition:all .25s; box-shadow:inset 0 2px 4px rgba(0,0,0,.15); display:inline-flex; align-items:center; gap:6px; }
    .cert-btn-cancel-3d:hover { transform:translateY(-2px); border-color:rgba(220,38,38,.45); color:#fca5a5; box-shadow:0 6px 14px rgba(220,38,38,.15); }
    .cert-actions-spacer { flex:1; }
    .cert-tip-box { display:flex; align-items:center; gap:8px; padding:8px 12px; border-radius:10px; background:linear-gradient(145deg,rgba(217,164,65,.10),rgba(217,164,65,.05)); border:1px solid rgba(217,164,65,.3); font-size:11px; color:#f2c063; font-weight:600; }

    @keyframes certShine { 0%{transform:translateX(-100%) skewX(-20deg)} 100%{transform:translateX(300%) skewX(-20deg)} }
    @keyframes certFadeUp { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:none} }

    .flash-3d { position:relative; padding:14px 18px; margin-bottom:20px; border-radius:14px; font-size:13.5px; font-weight:700; display:flex; align-items:center; gap:10px; overflow:hidden; box-shadow:inset 0 1px 2px rgba(255,255,255,.7),inset 0 -2px 3px rgba(0,0,0,.05),0 4px 12px rgba(0,0,0,.1); animation:certFadeUp .5s cubic-bezier(.16,1,.3,1) both; }
    .flash-3d::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:certShine 3s ease-in-out infinite; pointer-events:none; }
    .flash-success-3d { background:linear-gradient(145deg,#d1fae5,#a7f3d0); border:1px solid rgba(16,185,129,.35); color:#065f46; }
    .flash-error-3d { background:linear-gradient(145deg,#fee2e2,#fecaca); border:1px solid rgba(220,38,38,.35); color:#991b1b; }
</style>

<!-- ================= HEADER 3D ================= -->
<div class="cert-form-head">
    <div class="cert-form-ico">🎓</div>
    <div style="position: relative; z-index: 1; flex: 1; min-width: 0;">
        <h2 class="cert-form-title"><?= $item !== null ? 'Edit Sertifikat' : 'Terbitkan Sertifikat' ?></h2>
        <p class="cert-form-sub">
            <?= $item !== null ? 'Perbarui data sertifikat yang sudah diterbitkan.' : 'Buat sertifikat digital dengan kode unik yang dapat diverifikasi publik.' ?>
        </p>
    </div>
    <span class="cert-form-mode <?= $item !== null ? 'edit' : 'new' ?>">
        <?= $item !== null ? '✎ Edit' : '+ Baru' ?>
    </span>
</div>

<?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<div class="cert-layout">
    <!-- ========== KOLOM KIRI: FORM ========== -->
    <div>
        <form method="post" enctype="multipart/form-data" action="<?= e($action) ?>" id="cert-form">
            <?= csrf_field() ?>
            <?php if ($item !== null): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>

            <!-- SECTION 1: KODE SERTIFIKAT & TEMPLATE -->
            <div class="cert-section-3d">
                <h3 class="cert-section-title">
                    <span class="section-emoji">🔐</span>
                    <span>Kode & Template Sertifikat</span>
                    <span class="section-num">BAGIAN 1 / 3</span>
                </h3>

                <div class="cert-fg-3d">
                    <label for="f-code">
                        <span class="field-ico">🔑</span>
                        Kode Unik
                        <span class="opt-badge">Otomatis jika kosong</span>
                    </label>
                    <input type="text" id="f-code" name="code"
                           value="<?= e($item['code'] ?? old('code')) ?>"
                           placeholder="LP3M-2026-A1B2C3 (kosongkan untuk generate otomatis)"
                           autocomplete="off">
                    <div class="field-helper">
                        <span class="helper-tip">💡 Format: LP3M-TAHUN-XXXXXX. Kosongkan untuk auto-generate.</span>
                    </div>
                    <?php if ($item !== null && !empty($item['code'])): ?>
                    <div class="cert-code-preview">
                        <div class="code-label">🔗 Link Verifikasi Publik:</div>
                        <div class="code-value"><?= e(url('public/index.php?page=verifikasi-sertifikat&code=' . urlencode($item['code']))) ?></div>
                        <div class="code-hint">Salin link ini untuk dikirim ke penerima sertifikat.</div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- 🎨 FIELD TEMPLATE DESAIN (BARU) -->
                <div class="cert-fg-3d">
                    <label for="f-template">
                        <span class="field-ico">🎨</span>
                        Template Desain
                        <span class="opt-badge">10 pilihan premium</span>
                    </label>
                    <select id="f-template" name="template">
                        <?php foreach (Certificate::TEMPLATES as $tKey => $tLabel): ?>
                            <option value="<?= e($tKey) ?>" <?= ($item['template'] ?? 'classic') === $tKey ? 'selected' : '' ?>>
                                <?= e($tLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="field-helper">
                        <span class="helper-tip">💡 Pilih desain sertifikat. Bisa juga di-preview live di halaman cetak.</span>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: DATA PENERIMA -->
            <div class="cert-section-3d">
                <h3 class="cert-section-title">
                    <span class="section-emoji">👤</span>
                    <span>Data Penerima</span>
                    <span class="section-num">BAGIAN 2 / 3</span>
                </h3>

                <div class="cert-fg-3d">
                    <label for="f-holder-name">
                        <span class="field-ico">👤</span>
                        Nama Penerima
                        <span class="req-badge">Wajib</span>
                        <span class="cert-counter" id="cnt-name">0 / 150</span>
                    </label>
                    <input type="text" id="f-holder-name" name="holder_name"
                           value="<?= e($item['holder_name'] ?? old('holder_name')) ?>"
                           required maxlength="150"
                           placeholder="Contoh: Dr. Ahmad Fauzi, M.Pd."
                           autocomplete="off">
                    <div class="field-helper">
                        <span class="helper-tip">💡 Nama lengkap dengan gelar (max 150 karakter)</span>
                    </div>
                </div>

                <div class="cert-fg-3d">
                    <label for="f-holder-identity">
                        <span class="field-ico">🆔</span>
                        NIM / NIDN / Identitas
                        <span class="opt-badge">Opsional</span>
                    </label>
                    <input type="text" id="f-holder-identity" name="holder_identity"
                           value="<?= e($item['holder_identity'] ?? old('holder_identity')) ?>"
                           placeholder="Contoh: 202110012345 atau 0312058901"
                           autocomplete="off">
                    <div class="field-helper">
                        <span class="helper-tip">💡 Nomor identitas resmi (opsional)</span>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: KEGIATAN & PENANDATANGAN -->
            <div class="cert-section-3d">
                <h3 class="cert-section-title">
                    <span class="section-emoji">📜</span>
                    <span>Kegiatan & Penandatanganan</span>
                    <span class="section-num">BAGIAN 3 / 3</span>
                </h3>

                <div class="cert-fg-3d">
                    <label for="f-activity-title">
                        <span class="field-ico">🎯</span>
                        Nama Kegiatan
                        <span class="req-badge">Wajib</span>
                        <span class="cert-counter" id="cnt-act">0 / 200</span>
                    </label>
                    <input type="text" id="f-activity-title" name="activity_title"
                           value="<?= e($item['activity_title'] ?? old('activity_title')) ?>"
                           required maxlength="200"
                           placeholder="Contoh: Workshop Penulisan Jurnal Bereputasi Scopus 2026"
                           autocomplete="off">
                    <div class="field-helper">
                        <span class="helper-tip">💡 Nama lengkap kegiatan (max 200 karakter)</span>
                    </div>
                </div>

                <div class="cert-row-3d">
                    <div class="cert-fg-3d">
                        <label for="f-activity-type">
                            <span class="field-ico">🏷️</span>
                            Jenis Kegiatan
                            <span class="req-badge">Wajib</span>
                        </label>
                        <select id="f-activity-type" name="activity_type" required>
                            <?php foreach ($types as $key => $label): ?>
                                <option value="<?= e($key) ?>" <?= ($item['activity_type'] ?? 'pelatihan') === $key ? 'selected' : '' ?>>
                                    <?= e($label) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="cert-fg-3d">
                        <label for="f-issue-date">
                            <span class="field-ico">📅</span>
                            Tanggal Terbit
                            <span class="req-badge">Wajib</span>
                        </label>
                        <input type="date" id="f-issue-date" name="issue_date"
                               value="<?= e($item['issue_date'] ?? old('issue_date', date('Y-m-d'))) ?>"
                               required>
                        <div class="field-helper">
                            <span class="helper-tip">💡 Tanggal sertifikat diterbitkan</span>
                        </div>
                    </div>
                </div>

                <div class="cert-row-3d">
                    <div class="cert-fg-3d">
                        <label for="f-signer-name">
                            <span class="field-ico">✍️</span>
                            Nama Penandatangan
                            <span class="opt-badge">Default: Kepala LP3M</span>
                        </label>
                        <input type="text" id="f-signer-name" name="signer_name"
                               value="<?= e($item['signer_name'] ?? old('signer_name', 'Kepala LP3M')) ?>"
                               maxlength="150"
                               placeholder="Contoh: Prof. Dr. H. Ahmad, M.Pd."
                               autocomplete="off">
                    </div>

                    <div class="cert-fg-3d">
                        <label for="f-signer-title">
                            <span class="field-ico">🏷️</span>
                            Jabatan Penandatangan
                            <span class="opt-badge">Default: Kepala LP3M/LPPAIK</span>
                        </label>
                        <input type="text" id="f-signer-title" name="signer_title"
                               value="<?= e($item['signer_title'] ?? old('signer_title', 'Kepala LP3M/LPPAIK')) ?>"
                               maxlength="150"
                               placeholder="Contoh: Kepala LP3M UNIMOF"
                               autocomplete="off">
                    </div>
                </div>

                <!-- FIELD TANDA TANGAN -->
                <div class="cert-fg-3d">
                    <label for="f-signature">
                        <span class="field-ico">✒️</span>
                        Gambar Tanda Tangan
                        <span class="opt-badge">PNG transparan disarankan</span>
                    </label>
                    <div class="cert-sig-drop" id="sig-drop">
                        <input type="file" id="f-signature" name="signature" accept=".png,.jpg,.jpeg,.webp">
                        <div class="sig-drop-inner">
                            <span class="sig-drop-ico">✒️</span>
                            <span>Klik / seret gambar tanda tangan (maks 2 MB)</span>
                        </div>
                    </div>
                    <div class="cert-sig-preview" id="sig-preview" style="display:none;">
                        <img id="sig-preview-img" src="" alt="Preview tanda tangan">
                        <div class="sig-preview-meta" id="sig-preview-name"></div>
                    </div>
                    <?php if ($item !== null && !empty($item['signer_signature'])): ?>
                    <div class="cert-sig-current">
                        <img src="<?= e(upload_url($item['signer_signature'])) ?>" alt="Tanda tangan saat ini">
                        <label class="cert-check"><input type="checkbox" name="remove_signature" value="1"> Hapus tanda tangan saat ini</label>
                    </div>
                    <?php endif; ?>
                    <div class="field-helper">
                        <span class="helper-tip">💡 Jika kosong, sertifikat memakai tanda tangan tulisan (script) otomatis dari nama penandatangan.</span>
                    </div>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="cert-actions-3d">
                <button type="submit" class="cert-btn-save-3d" id="btn-save">
                    <?= $item !== null ? '💾 Simpan Perubahan' : '🎓 Terbitkan Sertifikat' ?>
                </button>
                <a href="<?= e(url('admin/index.php?page=sertifikat')) ?>" class="cert-btn-cancel-3d">
                    ✖ Batal
                </a>
                <span class="cert-actions-spacer"></span>
                <span class="cert-tip-box">
                    💡 Kode unik akan otomatis digenerate jika dikosongkan
                </span>
            </div>
        </form>
    </div>

    <!-- ========== KOLOM KANAN: PREVIEW + ALAT BANTU ========== -->
    <aside class="cert-side">
        <!-- LIVE PREVIEW -->
        <div class="cert-preview-panel">
            <div class="cpp-title">🖼️ Live Preview Cetak</div>
            <div class="cpp-page">
                <div class="cpp-border"></div>
                <div class="cpp-inner">
                    <div class="cpp-inst"><?= e(APP_NAME) ?></div>
                    <div class="cpp-doc">SERTIFIKAT</div>
                    <div class="cpp-type" id="pv-type">PELATIHAN</div>
                    <div class="cpp-given">Diberikan kepada</div>
                    <div class="cpp-name" id="pv-name">Nama Penerima</div>
                    <div class="cpp-id" id="pv-id"></div>
                    <div class="cpp-for">atas partisipasi dalam</div>
                    <div class="cpp-act" id="pv-act">Nama Kegiatan</div>
                    <div class="cpp-date" id="pv-date"></div>
                    <div class="cpp-foot">
                        <div class="cpp-qr">▣</div>
                        <div class="cpp-sign">
                            <div class="cpp-sign-title" id="pv-sign-title">Kepala LP3M/LPPAIK</div>
                            <div class="cpp-sign-space">
                                <img id="pv-sign-img"
                                     src="<?= ($item !== null && !empty($item['signer_signature'])) ? e(upload_url($item['signer_signature'])) : '' ?>"
                                     style="<?= ($item !== null && !empty($item['signer_signature'])) ? '' : 'display:none;' ?>max-height:12px; max-width:44px; object-fit:contain;">
                            </div>
                            <div class="cpp-sign-name" id="pv-sign-name">Kepala LP3M</div>
                        </div>
                    </div>
                    <div class="cpp-code" id="pv-code">KODE: AUTO-GENERATE</div>
                </div>
            </div>
            <div class="cpp-hint">Preview mendekati hasil cetak A4 landscape.</div>
        </div>

        <!-- ALAT BANTU CEPAT -->
        <div class="cert-tools-panel">
            <div class="ctp-title">⚡ Alat Bantu Cepat</div>
            <div class="ctp-grid">
                <select class="ctp-select" id="tpl-activity">
                    <option value="">🎯 Template kegiatan cepat...</option>
                    <option value="workshop|Workshop Penulisan Artikel Jurnal Bereputasi Internasional">Workshop Jurnal</option>
                    <option value="pelatihan|Pelatihan Pekerti / Applied Approach (AA)">Pelatihan Pekerti/AA</option>
                    <option value="seminar|Seminar Nasional Hasil Penelitian & Pengabdian">Seminar Nasional</option>
                    <option value="kkn|Pembekalan & Penerjunan KKN Tematik">KKN Tematik</option>
                    <option value="pengabdian|Program Pengabdian kepada Masyarakat Desa Binaan">Pengabdian Desa</option>
                    <option value="penelitian|Penelitian Skema Internal LP3M">Penelitian Internal</option>
                </select>
                <button type="button" class="ctp-btn" id="btn-today">📅 Isi tanggal hari ini</button>
                <button type="button" class="ctp-btn" id="btn-gen-code">🔑 Generate kode acak</button>
                <?php if ($item !== null && !empty($item['code'])): ?>
                <button type="button" class="ctp-btn" id="btn-copy-link">📋 Salin link verifikasi</button>
                <?php endif; ?>
                <p class="ctp-note">💡 Template kegiatan hanya mengisi judul jika kolom judul masih kosong; jenis kegiatan selalu disesuaikan.</p>
            </div>
        </div>
    </aside>
</div>

<script>
(function(){
    var TYPE_LABELS = <?= json_encode($types, JSON_UNESCAPED_UNICODE) ?>;
    var VERIFY_URL = <?= json_encode($item !== null && !empty($item['code']) ? url('public/index.php?page=verifikasi-sertifikat&code=' . urlencode($item['code'])) : '') ?>;
    var MONTHS = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    function $(id){ return document.getElementById(id); }

    // ===== Live preview =====
    var fName = $('f-holder-name'), fId = $('f-holder-identity'), fAct = $('f-activity-title'),
        fType = $('f-activity-type'), fDate = $('f-issue-date'), fSign = $('f-signer-name'),
        fSignT = $('f-signer-title'), fCode = $('f-code');

    function fmtDate(iso){
        if (!iso) return '';
        var p = iso.split('-');
        if (p.length !== 3) return iso;
        return parseInt(p[2],10) + ' ' + MONTHS[parseInt(p[1],10)-1] + ' ' + p[0];
    }
    function updatePreview(){
        if ($('pv-name')) $('pv-name').textContent = fName && fName.value.trim() ? fName.value.trim() : 'Nama Penerima';
        if ($('pv-id')) $('pv-id').textContent = fId && fId.value.trim() ? fId.value.trim() : '';
        if ($('pv-act')) $('pv-act').textContent = fAct && fAct.value.trim() ? fAct.value.trim() : 'Nama Kegiatan';
        if ($('pv-type')) $('pv-type').textContent = (TYPE_LABELS[fType ? fType.value : ''] || 'KEGIATAN').toUpperCase();
        if ($('pv-date')) $('pv-date').textContent = fmtDate(fDate ? fDate.value : '');
        if ($('pv-sign-name')) $('pv-sign-name').textContent = fSign && fSign.value.trim() ? fSign.value.trim() : 'Kepala LP3M';
        if ($('pv-sign-title')) $('pv-sign-title').textContent = fSignT && fSignT.value.trim() ? fSignT.value.trim() : 'Kepala LP3M/LPPAIK';
        if ($('pv-code')) $('pv-code').textContent = 'KODE: ' + (fCode && fCode.value.trim() ? fCode.value.trim() : 'AUTO-GENERATE');
    }
    [fName,fId,fAct,fType,fDate,fSign,fSignT,fCode].forEach(function(el){
        if (el) el.addEventListener('input', updatePreview);
        if (el) el.addEventListener('change', updatePreview);
    });
    updatePreview();

    // ===== Character counters =====
    function counter(inputId, counterId, max){
        var inp = $(inputId), cnt = $(counterId);
        if (!inp || !cnt) return;
        function up(){ cnt.textContent = inp.value.length + ' / ' + max; }
        inp.addEventListener('input', up); up();
    }
    counter('f-holder-name', 'cnt-name', 150);
    counter('f-activity-title', 'cnt-act', 200);

    // ===== Alat bantu: template kegiatan =====
    var tpl = $('tpl-activity');
    if (tpl) tpl.addEventListener('change', function(){
        if (!tpl.value) return;
        var parts = tpl.value.split('|');
        if (fType) fType.value = parts[0];
        if (fAct && fAct.value.trim() === '') fAct.value = parts[1];
        updatePreview();
        tpl.value = '';
    });

    // ===== Alat bantu: tanggal hari ini =====
    var btnToday = $('btn-today');
    if (btnToday) btnToday.addEventListener('click', function(){
        if (!fDate) return;
        var d = new Date();
        var iso = d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0');
        fDate.value = iso;
        updatePreview();
    });

    // ===== Alat bantu: generate kode =====
    var btnGen = $('btn-gen-code');
    if (btnGen) btnGen.addEventListener('click', function(){
        if (!fCode) return;
        var hex = '';
        for (var i=0;i<6;i++) hex += '0123456789ABCDEF'[Math.floor(Math.random()*16)];
        fCode.value = 'LP3M-' + new Date().getFullYear() + '-' + hex;
        updatePreview();
    });

    // ===== Alat bantu: salin link verifikasi =====
    var btnCopy = $('btn-copy-link');
    if (btnCopy && VERIFY_URL) btnCopy.addEventListener('click', function(){
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(VERIFY_URL).then(function(){
                btnCopy.textContent = '✅ Tersalin!';
                setTimeout(function(){ btnCopy.textContent = '📋 Salin link verifikasi'; }, 1800);
            });
        } else {
            var ta = document.createElement('textarea');
            ta.value = VERIFY_URL; document.body.appendChild(ta);
            ta.select(); document.execCommand('copy'); document.body.removeChild(ta);
            btnCopy.textContent = '✅ Tersalin!';
            setTimeout(function(){ btnCopy.textContent = '📋 Salin link verifikasi'; }, 1800);
        }
    });

    // ===== Signature preview =====
    var fSig = $('f-signature');
    var sigDrop = $('sig-drop');
    var sigPrev = $('sig-preview');
    var sigPrevImg = $('sig-preview-img');
    var sigPrevName = $('sig-preview-name');
    var pvSignImg = $('pv-sign-img');
    var rmSig = document.querySelector('input[name="remove_signature"]');

    function sigShow(url, name){
        if (sigPrev) sigPrev.style.display = 'flex';
        if (sigPrevImg) sigPrevImg.src = url;
        if (sigPrevName) sigPrevName.textContent = name || '';
        if (pvSignImg) { pvSignImg.src = url; pvSignImg.style.display = 'inline-block'; }
        if (rmSig) rmSig.checked = false;
    }
    if (fSig) fSig.addEventListener('change', function(){
        var f = fSig.files && fSig.files[0];
        if (!f) return;
        sigShow(URL.createObjectURL(f), f.name);
    });
    if (sigDrop) {
        ['dragenter','dragover'].forEach(function(ev){ sigDrop.addEventListener(ev, function(e){ e.preventDefault(); sigDrop.classList.add('dragover'); }); });
        ['dragleave','drop'].forEach(function(ev){ sigDrop.addEventListener(ev, function(e){ e.preventDefault(); sigDrop.classList.remove('dragover'); }); });
    }
    if (rmSig) rmSig.addEventListener('change', function(){
        if (pvSignImg) pvSignImg.style.display = rmSig.checked ? 'none' : (pvSignImg.getAttribute('src') ? 'inline-block' : 'none');
    });

    // ===== Submit progress =====
    var form = document.getElementById('cert-form');
    var btnSave = document.getElementById('btn-save');
    if (form && btnSave) {
        form.addEventListener('submit', function() {
            btnSave.disabled = true;
            btnSave.textContent = '⏳ Menyimpan...';
        });
    }
})();
</script>