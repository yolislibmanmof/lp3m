<style>
    @keyframes csFormShine { 0%{transform:translateX(-100%) skewX(-20deg)} 100%{transform:translateX(300%) skewX(-20deg)} }
    @keyframes csFormFadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }
    @keyframes csFormPulse { 0%,100% { box-shadow: 0 0 0 0 rgba(5,150,105,0.4); } 50% { box-shadow: 0 0 0 5px rgba(5,150,105,0); } }
    @keyframes csReqPulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.2); } }
    @keyframes aikBadgePop { 0% { opacity: 0; transform: scale(0.8); } 100% { opacity: 1; transform: scale(1); } }

    /* ===== FORM HEAD 3D ===== */
    .cs-form-head {
        display: flex; align-items: center; gap: 16px; margin-bottom: 24px;
        padding: 22px 26px; border-radius: 22px;
        background: linear-gradient(135deg, #043b2c 0%, #065f46 55%, #059669 100%);
        color: white; position: relative; overflow: hidden;
        box-shadow: 0 16px 40px rgba(0,0,0,.30);
        animation: csFormFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    .cs-form-head::before {
        content:''; position:absolute; inset:0;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 25px, rgba(217,164,65,.04) 25px, rgba(217,164,65,.04) 26px),
            repeating-linear-gradient(-45deg, transparent, transparent 25px, rgba(217,164,65,.04) 25px, rgba(217,164,65,.04) 26px);
    }
    .cs-form-head::after {
        content:''; position:absolute; top:-50%; right:-10%;
        width: 320px; height: 320px; border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,.25), transparent 70%);
        pointer-events: none;
    }
    .cs-form-ico {
        width: 56px; height: 56px; border-radius: 16px; flex-shrink: 0;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.5), transparent 40%),
                    linear-gradient(145deg, #34d399, #10b981 50%, #059669);
        display: flex; align-items: center; justify-content: center;
        font-size: 26px; position: relative;
        box-shadow: inset 0 2px 3px rgba(255,255,255,.6), inset 0 -3px 4px rgba(0,0,0,.25), 0 6px 16px rgba(5,150,105,.45);
    }
    .cs-form-ico::before {
        content:''; position:absolute; top:5px; left:10px;
        width:16px; height:7px; border-radius:50%;
        background: rgba(255,255,255,.6); filter: blur(1.5px);
    }
    .cs-form-title {
        font-family: var(--font-display); font-size: 22px; font-weight: 900;
        letter-spacing: -.02em; margin: 0; position: relative; z-index: 1;
        background: linear-gradient(135deg, #fff 0%, #fde68a 100%);
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .cs-form-sub { font-size: 12.5px; opacity: .85; margin: 4px 0 0; position: relative; z-index: 1; }
    .cs-form-mode {
        margin-left: auto; padding: 4px 12px; border-radius: 999px;
        font-size: 10px; font-weight: 900; letter-spacing: .1em; text-transform: uppercase;
        position: relative; z-index: 1; flex-shrink: 0;
    }
    .cs-form-mode.edit {
        background: linear-gradient(145deg, #fde68a, #d9a441);
        color: #03251f;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -1px 2px rgba(0,0,0,.15);
    }
    .cs-form-mode.new {
        background: rgba(255,255,255,.15); color: #fff;
        border: 1px solid rgba(255,255,255,.3);
    }

    /* ===== FLASH 3D ===== */
    .flash-3d {
        position: relative; padding: 14px 18px; margin-bottom: 20px;
        border-radius: 14px; font-size: 13.5px; font-weight: 700;
        display: flex; align-items: center; gap: 10px; overflow: hidden;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.05), 0 4px 12px rgba(0,0,0,.1);
        animation: csFormFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    .flash-3d::after {
        content:''; position:absolute; top:0; left:-100%;
        width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent);
        animation: csFormShine 3s ease-in-out infinite;
        pointer-events: none;
    }
    .flash-success-3d { background: linear-gradient(145deg, #d1fae5, #a7f3d0); border: 1px solid rgba(16,185,129,.35); color: #065f46; }
    .flash-error-3d { background: linear-gradient(145deg, #fee2e2, #fecaca); border: 1px solid rgba(220,38,38,.35); color: #991b1b; }

    /* ===== FORM SECTION 3D ===== */
    .form-section-3d {
        background: var(--white); border: 1px solid var(--border);
        border-radius: 20px; padding: 26px; margin-bottom: 20px;
        box-shadow: 0 4px 14px rgba(0,0,0,.04);
        position: relative; overflow: hidden;
        animation: csFormFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    .form-section-3d:nth-of-type(2) { animation-delay: .08s; }
    .form-section-3d:nth-of-type(3) { animation-delay: .16s; }
    .form-section-3d:nth-of-type(4) { animation-delay: .24s; }
    .form-section-3d::before {
        content:''; position:absolute; top:0; left:0; right:0; height: 3px;
        background: linear-gradient(90deg, var(--gold-strong), var(--primary));
        opacity: .7;
    }
    .form-section-title {
        display: flex; align-items: center; gap: 10px;
        font-size: 15px; font-weight: 900; color: var(--ink);
        font-family: var(--font-display); margin: 0 0 22px;
        padding-bottom: 14px; border-bottom: 1px dashed var(--border);
    }
    .form-section-title .section-emoji {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px; border-radius: 10px;
        background: linear-gradient(145deg, #f6faf7, #ffffff);
        border: 1px solid var(--border); font-size: 15px;
        box-shadow: inset 0 1px 1px rgba(255,255,255,.9);
    }
    .form-section-title::before { display: none; }
    .form-section-title .section-num {
        margin-left: auto; font-size: 10px; font-weight: 900;
        letter-spacing: .1em; color: var(--muted);
    }

    /* ===== FORM GROUP 3D ===== */
    .fg-3d { margin-bottom: 20px; position: relative; }
    .fg-3d:last-child { margin-bottom: 0; }

    .fg-3d label {
        display: flex; align-items: center; gap: 8px;
        font-size: 11.5px; font-weight: 850;
        letter-spacing: .08em; text-transform: uppercase;
        color: var(--primary-dark); margin-bottom: 9px;
    }
    .fg-3d label .field-ico {
        display: inline-flex; align-items: center; justify-content: center;
        width: 22px; height: 22px; border-radius: 7px;
        background: linear-gradient(145deg, rgba(16,185,129,.15), rgba(5,150,105,.08));
        font-size: 11px;
    }
    .fg-3d label .req-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 1px 7px; border-radius: 999px;
        font-size: 8.5px; font-weight: 900; letter-spacing: .08em;
        background: rgba(220,38,38,.10); color: #dc2626;
        border: 1px solid rgba(220,38,38,.25);
        margin-left: 4px; text-transform: uppercase;
    }
    .fg-3d label .req-badge::before {
        content:''; width: 5px; height: 5px; border-radius: 50%;
        background: #dc2626;
        animation: csReqPulse 1.5s ease-in-out infinite;
    }
    .fg-3d label .opt-badge {
        padding: 1px 7px; border-radius: 999px;
        font-size: 8.5px; font-weight: 800; letter-spacing: .08em;
        background: rgba(100,116,139,.12); color: #64748b;
        border: 1px solid rgba(100,116,139,.25);
        text-transform: uppercase;
    }

    /* ===== FORCE LIGHT SCHEME + AUTOFILL FIX ===== */
    .fg-3d input[type="text"],
    .fg-3d input[type="date"],
    .fg-3d input[type="number"],
    .fg-3d input[type="url"],
    .fg-3d input[type="email"],
    .fg-3d select,
    .fg-3d textarea {
        width: 100%; padding: 13px 16px; border-radius: 13px;
        border: 2px solid var(--border);
        background: linear-gradient(145deg, #f6faf7, #ffffff);
        font-size: 14px; font-weight: 600;
        color: #03251f !important;
        -webkit-text-fill-color: #03251f !important;
        transition: all .3s cubic-bezier(0.16,1,0.3,1);
        box-shadow: inset 0 2px 4px rgba(0,0,0,.04), inset 0 -1px 0 rgba(255,255,255,.8);
        color-scheme: light;
        font-family: var(--font-body);
    }
    .fg-3d input:-webkit-autofill,
    .fg-3d input:-webkit-autofill:hover,
    .fg-3d input:-webkit-autofill:focus,
    .fg-3d select:-webkit-autofill,
    .fg-3d textarea:-webkit-autofill {
        -webkit-box-shadow: 0 0 0 1000px #f6faf7 inset !important;
        -webkit-text-fill-color: #03251f !important;
        caret-color: #059669 !important;
        transition: background-color 99999s ease-in-out 0s;
        border-color: var(--border) !important;
    }

    .fg-3d select {
        appearance: none; -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23059669' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 16px center !important;
        background-size: 12px 8px !important;
        padding-right: 44px;
        cursor: pointer;
    }
    .fg-3d select option {
        background: #f6faf7;
        color: #03251f;
        padding: 8px;
    }
    .fg-3d textarea { resize: vertical; min-height: 80px; line-height: 1.6; }

    .fg-3d input:focus, .fg-3d select:focus, .fg-3d textarea:focus {
        outline: none; border-color: #059669; background: #ffffff;
        color: #03251f !important;
        -webkit-text-fill-color: #03251f !important;
        box-shadow: inset 0 2px 4px rgba(0,0,0,.06), 0 0 0 4px rgba(5,150,105,.12), 0 4px 12px rgba(5,150,105,.15);
    }
    .fg-3d input:invalid:not(:placeholder-shown),
    .fg-3d textarea:invalid:not(:placeholder-shown) {
        border-color: rgba(220,38,38,.5);
    }

    .fg-3d .field-helper {
        display: flex; align-items: center; justify-content: space-between;
        gap: 8px; margin-top: 7px; font-size: 11px; color: var(--muted);
        flex-wrap: wrap;
    }
    .fg-3d .field-helper .helper-tip {
        display: inline-flex; align-items: center; gap: 4px;
    }
    .fg-3d .field-counter {
        font-family: var(--font-display); font-weight: 850;
        font-size: 11px; color: var(--muted);
        padding: 2px 8px; border-radius: 6px;
        background: rgba(100,116,139,.08);
        transition: color .2s;
    }
    .fg-3d .field-counter.warn { color: #f2c063; background: rgba(242,192,99,.12); }
    .fg-3d .field-counter.danger { color: #dc2626; background: rgba(220,38,38,.12); }

    /* ===== STATUS PREVIEW 3D ===== */
    .status-preview-3d {
        margin-top: 10px; padding: 10px 14px; border-radius: 11px;
        display: flex; align-items: center; gap: 10px;
        font-size: 12px; font-weight: 700;
        border: 1px solid;
        transition: all .3s;
    }
    .status-preview-3d.published {
        background: linear-gradient(145deg, rgba(16,185,129,.10), rgba(5,150,105,.05));
        color: #065f46; border-color: rgba(16,185,129,.3);
    }
    .status-preview-3d.draft {
        background: linear-gradient(145deg, rgba(100,116,139,.08), rgba(100,116,139,.04));
        color: #475569; border-color: rgba(100,116,139,.25);
    }
    .status-preview-3d .sp-dot {
        width: 8px; height: 8px; border-radius: 50%;
    }
    .status-preview-3d.published .sp-dot {
        background: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,.2);
        animation: csFormPulse 2s ease-in-out infinite;
    }
    .status-preview-3d.draft .sp-dot { background: #64748b; }

    /* ===== AIK INTEGRATION BADGE (khas pengabdian) ===== */
    .aik-integration-badge {
        display: none; align-items: center; gap: 8px;
        margin-top: 10px; padding: 10px 14px; border-radius: 11px;
        background: linear-gradient(145deg, rgba(124,58,237,.10), rgba(167,139,250,.05));
        border: 1px solid rgba(124,58,237,.3);
        color: #5b21b6; font-size: 12px; font-weight: 700;
        animation: aikBadgePop 0.3s ease-out;
    }
    .aik-integration-badge.show { display: flex; }
    .aik-integration-badge .aik-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124,58,237,.2);
        animation: csFormPulse 2s ease-in-out infinite;
    }

    /* ===== TEAM PREVIEW CHIPS ===== */
    .team-preview {
        display: flex; flex-wrap: wrap; gap: 6px;
        margin-top: 8px; min-height: 24px;
    }
    .team-chip {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 999px;
        background: linear-gradient(145deg, rgba(16,185,129,.12), rgba(5,150,105,.06));
        border: 1px solid rgba(5,150,105,.25);
        font-size: 11px; font-weight: 700; color: #065f46;
        animation: aikBadgePop 0.2s ease-out;
    }
    .team-chip::before { content: '👤'; font-size: 10px; }
    .team-chip.leader {
        background: linear-gradient(145deg, rgba(217,164,65,.15), rgba(217,164,65,.08));
        border-color: rgba(217,164,65,.35); color: #92400e;
    }
    .team-chip.leader::before { content: '⭐'; }
    .team-count {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 2px 8px; border-radius: 6px;
        background: rgba(16,185,129,.10);
        color: #059669; font-size: 10px; font-weight: 850;
        font-family: var(--font-display);
    }

    .form-row-3d { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media (max-width: 640px) { .form-row-3d { grid-template-columns: 1fr; } }

    /* ===== BUTTONS ===== */
    .form-actions-3d {
        display: flex; gap: 12px; flex-wrap: wrap; align-items: center;
        padding-top: 8px;
    }
    .btn-save-3d {
        position: relative; padding: 14px 28px; border: none; border-radius: 13px;
        font-size: 14px; font-weight: 850; color: #03251f; cursor: pointer;
        background: linear-gradient(145deg, #fde68a, #f2c063 40%, #d9a441 80%, #a9761b);
        overflow: hidden; transition: all .3s cubic-bezier(0.16,1,0.3,1);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.15), 0 8px 20px rgba(217,164,65,.4);
        font-family: var(--font-display);
    }
    .btn-save-3d::before {
        content:''; position:absolute; top:3px; left:10%;
        width: 35%; height: 35%; border-radius: 50%;
        background: rgba(255,255,255,.6); filter: blur(2px);
        pointer-events: none;
    }
    .btn-save-3d::after {
        content:''; position:absolute; top:0; left:-100%;
        width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent);
        animation: csFormShine 3s ease-in-out infinite;
        pointer-events: none;
    }
    .btn-save-3d:hover {
        transform: translateY(-2px);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.8), 0 14px 30px rgba(217,164,65,.55);
    }
    .btn-save-3d:active { transform: translateY(0); }

    .btn-cancel-3d {
        padding: 14px 24px; border-radius: 13px; text-decoration: none;
        font-size: 14px; font-weight: 700; color: var(--muted);
        background: linear-gradient(145deg, #f6faf7, #ffffff);
        border: 2px solid var(--border);
        transition: all .25s;
        box-shadow: inset 0 2px 4px rgba(0,0,0,.04);
        display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-cancel-3d:hover {
        transform: translateY(-2px); border-color: rgba(220,38,38,.35);
        color: #991b1b; box-shadow: 0 6px 14px rgba(220,38,38,.12);
    }
    .form-actions-spacer { flex: 1; }
    .form-tip-box {
        display: flex; align-items: center; gap: 8px;
        padding: 8px 12px; border-radius: 10px;
        background: linear-gradient(145deg, rgba(217,164,65,.08), rgba(217,164,65,.04));
        border: 1px solid rgba(217,164,65,.2);
        font-size: 11px; color: #92400e; font-weight: 600;
    }
</style>

<!-- ================= HEADER 3D ================= -->
<div class="cs-form-head">
    <div class="cs-form-ico">🤝</div>
    <div style="position: relative; z-index: 1; flex: 1; min-width: 0;">
        <h2 class="cs-form-title"><?= $item !== null ? 'Edit Pengabdian/KKN' : 'Tambah Pengabdian/KKN' ?></h2>
        <p class="cs-form-sub">
            <?= $item !== null ? 'Perbarui informasi kegiatan pengabdian kepada masyarakat.' : 'Catat kegiatan pengabdian, KKN, atau desa binaan baru untuk portofolio lembaga.' ?>
        </p>
    </div>
    <span class="cs-form-mode <?= $item !== null ? 'edit' : 'new' ?>">
        <?= $item !== null ? '✎ Edit' : '+ Baru' ?>
    </span>
</div>

<?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= e($action) ?>" id="cs-form">
    <?= csrf_field() ?>
    <?php if ($item !== null): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>

    <!-- SECTION 1: INFORMASI DASAR -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-emoji">📋</span>
            <span>Informasi Dasar</span>
            <span class="section-num">BAGIAN 1 / 3</span>
        </h3>

        <div class="fg-3d">
            <label for="f-title">
                <span class="field-ico">✏️</span>
                Judul Kegiatan
                <span class="req-badge">Wajib</span>
            </label>
            <input type="text" id="f-title" name="title"
                   value="<?= e($item['title'] ?? old('title')) ?>"
                   required maxlength="200"
                   placeholder="Contoh: Pemberdayaan UMKM Desa Nita Melalui Digital Marketing"
                   autocomplete="off">
            <div class="field-helper">
                <span class="helper-tip">💡 Gunakan judul yang informatif (max 200 karakter)</span>
                <span class="field-counter" id="title-counter">0 / 200</span>
            </div>
        </div>

        <div class="form-row-3d">
            <div class="fg-3d">
                <label for="f-type">
                    <span class="field-ico">🏷️</span>
                    Jenis Kegiatan
                    <span class="req-badge">Wajib</span>
                </label>
                <select id="f-type" name="type" required>
                    <?php foreach (CommunityService::TYPES as $key => $label): ?>
                        <option value="<?= e($key) ?>" <?= ($item['type'] ?? 'pengabdian') === $key ? 'selected' : '' ?>>
                            <?= e($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="field-helper">
                    <span class="helper-tip">💡 Pilih jenis sesuai kategori kegiatan</span>
                </div>
            </div>

            <div class="fg-3d">
                <label for="f-year">
                    <span class="field-ico">📅</span>
                    Tahun Pelaksanaan
                    <span class="req-badge">Wajib</span>
                </label>
                <input type="number" id="f-year" name="year" min="2000" max="2100"
                       value="<?= e($item['year'] ?? old('year', (string) date('Y'))) ?>"
                       required>
                <div class="field-helper">
                    <span class="helper-tip">💡 Tahun antara 2000 - 2100</span>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: TIM & LOKASI -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-emoji">👥</span>
            <span>Tim & Lokasi</span>
            <span class="section-num">BAGIAN 2 / 3</span>
        </h3>

        <div class="form-row-3d">
            <div class="fg-3d">
                <label for="f-leader">
                    <span class="field-ico">⭐</span>
                    Ketua Pelaksana
                    <span class="req-badge">Wajib</span>
                </label>
                <input type="text" id="f-leader" name="leader"
                       value="<?= e($item['leader'] ?? old('leader')) ?>"
                       required maxlength="100"
                       placeholder="Nama ketua pelaksana"
                       autocomplete="off">
                <div class="field-helper">
                    <span class="helper-tip">💡 Penanggung jawab utama kegiatan</span>
                </div>
            </div>

            <div class="fg-3d">
                <label for="f-location">
                    <span class="field-ico">📍</span>
                    Lokasi
                    <span class="req-badge">Wajib</span>
                </label>
                <input type="text" id="f-location" name="location"
                       value="<?= e($item['location'] ?? old('location')) ?>"
                       required maxlength="150"
                       placeholder="Contoh: Desa Nita, Sikka, NTT"
                       autocomplete="off">
                <div class="field-helper">
                    <span class="helper-tip">💡 Nama tempat lengkap (max 150 karakter)</span>
                </div>
            </div>
        </div>

        <div class="fg-3d">
            <label for="f-members">
                <span class="field-ico">👥</span>
                Anggota Tim
                <span class="opt-badge">Opsional</span>
            </label>
            <input type="text" id="f-members" name="members"
                   value="<?= e($item['members'] ?? old('members')) ?>"
                   maxlength="500"
                   placeholder="Nama anggota 1, Nama anggota 2, Nama anggota 3"
                   autocomplete="off">
            <div class="field-helper">
                <span class="helper-tip">💡 Pisahkan setiap anggota dengan tanda koma (,)</span>
                <span class="field-counter" id="members-counter">0 / 500</span>
            </div>
            <div class="team-preview" id="team-preview"></div>
        </div>

        <div class="fg-3d">
            <label for="f-partner">
                <span class="field-ico">🤝</span>
                Mitra / Partner
                <span class="opt-badge">Opsional</span>
            </label>
            <input type="text" id="f-partner" name="partner"
                   value="<?= e($item['partner'] ?? old('partner')) ?>"
                   maxlength="200"
                   placeholder="Contoh: PCM Maumere, Aisyiyah, Pemda Sikka"
                   autocomplete="off">
            <div class="field-helper">
                <span class="helper-tip">💡 Institusi atau organisasi mitra kegiatan</span>
            </div>
        </div>
    </div>

    <!-- SECTION 3: DETAIL & AIK -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-emoji">🕌</span>
            <span>Detail & Integrasi AIK</span>
            <span class="section-num">BAGIAN 3 / 3</span>
        </h3>

        <div class="fg-3d">
            <label for="f-aik">
                <span class="field-ico">🕌</span>
                Integrasi AIK
                <span class="opt-badge">Opsional</span>
            </label>
            <textarea id="f-aik" name="aik_integration" rows="3"
                      maxlength="1000"
                      placeholder="Contoh: pembinaan masjid binaan, kerja sama dengan Aisyiyah, kajian Islam untuk warga..."><?= e($item['aik_integration'] ?? old('aik_integration')) ?></textarea>
            <div class="field-helper">
                <span class="helper-tip">💡 Jelaskan penjiwaan Al-Islam & Kemuhammadiyahan dalam kegiatan</span>
                <span class="field-counter" id="aik-counter">0 / 1000</span>
            </div>
            <div class="aik-integration-badge" id="aik-badge">
                <span class="aik-dot"></span>
                <span>🕌 Kegiatan ini terintegrasi dengan nilai Al-Islam & Kemuhammadiyahan</span>
            </div>
        </div>

        <div class="fg-3d">
            <label for="f-description">
                <span class="field-ico">📖</span>
                Deskripsi Kegiatan
                <span class="opt-badge">Opsional</span>
            </label>
            <textarea id="f-description" name="description" rows="5"
                      maxlength="3000"
                      placeholder="Jelaskan tujuan, sasaran, proses, dan dampak kegiatan..."><?= e($item['description'] ?? old('description')) ?></textarea>
            <div class="field-helper">
                <span class="helper-tip">💡 Ceritakan detail kegiatan (max 3000 karakter)</span>
                <span class="field-counter" id="desc-counter">0 / 3000</span>
            </div>
        </div>

        <div class="fg-3d">
            <label for="f-status">
                <span class="field-ico">🚦</span>
                Status Publikasi
                <span class="req-badge">Wajib</span>
            </label>
            <select id="f-status" name="status" required>
                <option value="published" <?= ($item['status'] ?? 'published') === 'published' ? 'selected' : '' ?>>
                    🟢 Published — Tampil di website publik
                </option>
                <option value="draft" <?= ($item['status'] ?? '') === 'draft' ? 'selected' : '' ?>>
                    ⚪ Draft — Hanya tersimpan, belum dipublikasikan
                </option>
            </select>
            <div class="status-preview-3d published" id="status-preview">
                <span class="sp-dot"></span>
                <span id="status-preview-text">🟢 Kegiatan akan langsung tampil di halaman publik Pengabdian</span>
            </div>
        </div>
    </div>

    <!-- ACTIONS -->
    <div class="form-actions-3d">
        <button type="submit" class="btn-save-3d">
            <?= $item !== null ? '💾 Simpan Perubahan' : '✨ Simpan Kegiatan' ?>
        </button>
        <a href="<?= e(url('admin/index.php?page=pengabdian')) ?>" class="btn-cancel-3d">
            ✖ Batal
        </a>
        <span class="form-actions-spacer"></span>
        <span class="form-tip-box">
            💡 Data tersimpan aman di database
        </span>
    </div>
</form>

<script>
(function(){
    // ===== Character counters =====
    function attachCounter(inputId, counterId, max) {
        var input = document.getElementById(inputId);
        var counter = document.getElementById(counterId);
        if (!input || !counter) return;

        function update() {
            var len = input.value.length;
            counter.textContent = len + ' / ' + max;
            counter.className = 'field-counter'
                + (len > max * 0.9 ? ' danger' : (len > max * 0.7 ? ' warn' : ''));
        }
        input.addEventListener('input', update);
        update();
    }

    attachCounter('f-title', 'title-counter', 200);
    attachCounter('f-members', 'members-counter', 500);
    attachCounter('f-aik', 'aik-counter', 1000);
    attachCounter('f-description', 'desc-counter', 3000);

    // ===== Status preview =====
    var statusSelect = document.getElementById('f-status');
    var statusPreview = document.getElementById('status-preview');
    var statusText = document.getElementById('status-preview-text');
    function updateStatus() {
        if (!statusSelect || !statusPreview) return;
        if (statusSelect.value === 'published') {
            statusPreview.className = 'status-preview-3d published';
            statusText.textContent = '🟢 Kegiatan akan langsung tampil di halaman publik Pengabdian';
        } else {
            statusPreview.className = 'status-preview-3d draft';
            statusText.textContent = '⚪ Hanya tersimpan sebagai draft, belum dipublikasikan';
        }
    }
    if (statusSelect) {
        statusSelect.addEventListener('change', updateStatus);
        updateStatus();
    }

    // ===== AIK Integration Badge (FITUR KHAS PENGABDIAN) =====
    var aikInput = document.getElementById('f-aik');
    var aikBadge = document.getElementById('aik-badge');
    function updateAikBadge() {
        if (!aikInput || !aikBadge) return;
        if (aikInput.value.trim().length >= 10) {
            aikBadge.classList.add('show');
        } else {
            aikBadge.classList.remove('show');
        }
    }
    if (aikInput) {
        aikInput.addEventListener('input', updateAikBadge);
        updateAikBadge();
    }

    // ===== Team Preview Chips (FITUR KHAS PENGABDIAN) =====
    var membersInput = document.getElementById('f-members');
    var teamPreview = document.getElementById('team-preview');
    function updateTeamPreview() {
        if (!membersInput || !teamPreview) return;
        var val = membersInput.value.trim();
        if (!val) { teamPreview.innerHTML = ''; return; }

        var leaderInput = document.getElementById('f-leader');
        var leader = leaderInput ? leaderInput.value.trim() : '';

        var parts = val.split(',').map(function(s){ return s.trim(); }).filter(Boolean);

        var html = '';
        if (leader) {
            html += '<span class="team-chip leader">' + leader + '</span>';
        }
        parts.forEach(function(name) {
            html += '<span class="team-chip">' + name + '</span>';
        });
        html += '<span class="team-count">' + (parts.length + (leader ? 1 : 0)) + ' anggota</span>';
        teamPreview.innerHTML = html;
    }
    if (membersInput) {
        membersInput.addEventListener('input', updateTeamPreview);
        updateTeamPreview();
    }
    var leaderInput = document.getElementById('f-leader');
    if (leaderInput) {
        leaderInput.addEventListener('input', updateTeamPreview);
    }

    // ===== Submit progress =====
    var form = document.getElementById('cs-form');
    if (form) {
        form.addEventListener('submit', function() {
            var btn = form.querySelector('.btn-save-3d');
            if (btn) {
                btn.disabled = true;
                btn.textContent = '⏳ Menyimpan...';
                btn.style.opacity = '0.7';
                btn.style.cursor = 'not-allowed';
            }
        });
    }
})();
</script>