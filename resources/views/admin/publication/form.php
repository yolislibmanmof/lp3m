<style>
    @keyframes pubFormShine { 0%{transform:translateX(-100%) skewX(-20deg)} 100%{transform:translateX(300%) skewX(-20deg)} }
    @keyframes pubFormFadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }
    @keyframes pubFormPulse { 0%,100%{box-shadow: 0 0 0 0 rgba(5,150,105,0.4);} 50%{box-shadow: 0 0 0 6px rgba(5,150,105,0);} }
    @keyframes pubReqPulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.2); } }
    @keyframes pubChipPop { from { opacity: 0; transform: scale(0.8); } to { opacity: 1; transform: scale(1); } }

    /* ===== FORM HEAD 3D ===== */
    .pub-form-head {
        display: flex; align-items: center; gap: 16px; margin-bottom: 24px;
        padding: 22px 26px; border-radius: 22px;
        background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 55%, #a78bfa 100%);
        color: white; position: relative; overflow: hidden;
        box-shadow: 0 16px 40px rgba(76,29,149,.30);
        animation: pubFormFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    .pub-form-head::before {
        content:''; position:absolute; inset:0;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 25px, rgba(217,164,65,.04) 25px, rgba(217,164,65,.04) 26px),
            repeating-linear-gradient(-45deg, transparent, transparent 25px, rgba(217,164,65,.04) 25px, rgba(217,164,65,.04) 26px);
    }
    .pub-form-head::after {
        content:''; position:absolute; top:-50%; right:-10%;
        width: 320px; height: 320px; border-radius: 50%;
        background: radial-gradient(circle, rgba(253,230,138,.25), transparent 70%);
        pointer-events: none;
    }
    .pub-form-ico {
        width: 56px; height: 56px; border-radius: 16px; flex-shrink: 0;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.5), transparent 40%),
                    linear-gradient(145deg, #c4b5fd, #a78bfa 50%, #7c3aed);
        display: flex; align-items: center; justify-content: center;
        font-size: 26px; position: relative;
        box-shadow: inset 0 2px 3px rgba(255,255,255,.6), inset 0 -3px 4px rgba(0,0,0,.25), 0 6px 14px rgba(124,58,237,.4);
    }
    .pub-form-ico::before {
        content:''; position:absolute; top:5px; left:10px;
        width:16px; height:7px; border-radius:50%;
        background: rgba(255,255,255,.6); filter: blur(1.5px);
    }
    .pub-form-title {
        font-family: var(--font-display); font-size: 22px; font-weight: 900;
        letter-spacing: -.02em; margin: 0; position: relative; z-index: 1;
        background: linear-gradient(135deg, #fff 0%, #fde68a 100%);
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .pub-form-sub { font-size: 12.5px; opacity: .90; margin: 4px 0 0; position: relative; z-index: 1; }
    .pub-form-mode {
        margin-left: auto; padding: 4px 12px; border-radius: 999px;
        font-size: 10px; font-weight: 900; letter-spacing: .1em; text-transform: uppercase;
        position: relative; z-index: 1; flex-shrink: 0;
    }
    .pub-form-mode.edit {
        background: linear-gradient(145deg, #fde68a, #d9a441); color: #03251f;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -1px 2px rgba(0,0,0,.15);
    }
    .pub-form-mode.new {
        background: rgba(255,255,255,.18); color: #fff;
        border: 1px solid rgba(255,255,255,.35);
    }

    /* ===== FLASH 3D ===== */
    .flash-3d {
        position: relative; padding: 14px 18px; margin-bottom: 20px;
        border-radius: 14px; font-size: 13.5px; font-weight: 700;
        display: flex; align-items: center; gap: 10px; overflow: hidden;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.05), 0 4px 12px rgba(0,0,0,.1);
        animation: pubFormFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    .flash-3d::after {
        content:''; position:absolute; top:0; left:-100%;
        width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent);
        animation: pubFormShine 3s ease-in-out infinite; pointer-events: none;
    }
    .flash-success-3d { background: linear-gradient(145deg, #d1fae5, #a7f3d0); border: 1px solid rgba(16,185,129,.35); color: #065f46; }
    .flash-error-3d { background: linear-gradient(145deg, #fee2e2, #fecaca); border: 1px solid rgba(220,38,38,.35); color: #991b1b; }

    /* ===== FORM SECTION 3D ===== */
    .form-section-3d {
        background: var(--white); border: 1px solid var(--border);
        border-radius: 20px; padding: 26px; margin-bottom: 20px;
        box-shadow: 0 4px 14px rgba(0,0,0,.04);
        position: relative; overflow: hidden;
        animation: pubFormFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    .form-section-3d:nth-of-type(2) { animation-delay: .08s; }
    .form-section-3d:nth-of-type(3) { animation-delay: .16s; }
    .form-section-3d:nth-of-type(4) { animation-delay: .24s; }
    .form-section-3d::before {
        content:''; position:absolute; top:0; left:0; right:0; height: 3px;
        background: linear-gradient(90deg, #c4b5fd, #7c3aed);
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
        color: #6d28d9; margin-bottom: 9px;
    }
    .fg-3d label .field-ico {
        display: inline-flex; align-items: center; justify-content: center;
        width: 22px; height: 22px; border-radius: 7px;
        background: linear-gradient(145deg, rgba(124,58,237,.15), rgba(167,139,250,.08));
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
        animation: pubReqPulse 1.5s ease-in-out infinite;
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
    .fg-3d input[type="number"],
    .fg-3d input[type="url"],
    .fg-3d input[type="date"],
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
        caret-color: #7c3aed !important;
        transition: background-color 99999s ease-in-out 0s;
        border-color: var(--border) !important;
    }
    .fg-3d select {
        appearance: none; -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%237c3aed' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 16px center !important;
        background-size: 12px 8px !important;
        padding-right: 44px; cursor: pointer;
    }
    .fg-3d select option { background: #f6faf7; color: #03251f; padding: 8px; }
    .fg-3d textarea { resize: vertical; min-height: 90px; line-height: 1.6; }

    .fg-3d input:focus, .fg-3d select:focus, .fg-3d textarea:focus {
        outline: none; border-color: #7c3aed; background: #ffffff;
        color: #03251f !important;
        -webkit-text-fill-color: #03251f !important;
        box-shadow: inset 0 2px 4px rgba(0,0,0,.06), 0 0 0 4px rgba(124,58,237,.12), 0 4px 12px rgba(124,58,237,.15);
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
    .fg-3d .field-helper .helper-tip { display: inline-flex; align-items: center; gap: 4px; }
    .fg-3d .field-counter {
        font-family: var(--font-display); font-weight: 850;
        font-size: 11px; color: var(--muted);
        padding: 2px 8px; border-radius: 6px;
        background: rgba(100,116,139,.08);
        transition: color .2s;
    }
    .fg-3d .field-counter.warn { color: #f2c063; background: rgba(242,192,99,.12); }
    .fg-3d .field-counter.danger { color: #dc2626; background: rgba(220,38,38,.12); }

    .form-row-3d { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media (max-width: 640px) { .form-row-3d { grid-template-columns: 1fr; } }

    /* ===== LEVEL HINTS CHIPS ===== */
    .level-hints {
        display: flex; gap: 6px; flex-wrap: wrap; margin-top: 10px;
    }
    .level-hint-chip {
        padding: 4px 11px; border-radius: 999px;
        font-size: 10.5px; font-weight: 850; cursor: pointer;
        background: rgba(124,58,237,.08); color: #6d28d9;
        border: 1px solid rgba(124,58,237,.25);
        transition: all .25s;
        user-select: none;
    }
    .level-hint-chip:hover {
        background: linear-gradient(145deg, #c4b5fd, #a78bfa);
        color: white; border-color: transparent;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(124,58,237,.25);
    }
    .level-hint-chip.active {
        background: linear-gradient(145deg, #7c3aed, #6d28d9);
        color: white; border-color: transparent;
        box-shadow: 0 4px 10px rgba(124,58,237,.35);
    }

    /* ===== LEVEL BADGE PREVIEW ===== */
    .level-badge-preview {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px; margin-top: 10px; border-radius: 999px;
        font-size: 12px; font-weight: 850;
        border: 1px solid transparent;
        transition: all .3s;
        animation: pubChipPop 0.3s ease-out;
    }
    .level-badge-preview .lb-dot { width: 8px; height: 8px; border-radius: 50%; }
    .level-badge-preview.intl {
        background: radial-gradient(circle at 30% 25%, rgba(253,230,138,.5), transparent 40%), linear-gradient(145deg, #fde68a, #d9a441);
        color: #03251f;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -1px 2px rgba(0,0,0,.15), 0 3px 8px rgba(217,164,65,.4);
    }
    .level-badge-preview.intl::after { content: '⭐'; font-size: 10px; }
    .level-badge-preview.sinta12 {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.4), transparent 40%), linear-gradient(145deg, #6ee7b7, #10b981);
        color: #064e3b;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.6), inset 0 -1px 2px rgba(0,0,0,.2), 0 3px 8px rgba(16,185,129,.4);
    }
    .level-badge-preview.sinta12::after { content: '🏆'; font-size: 10px; }
    .level-badge-preview.sinta {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.4), transparent 40%), linear-gradient(145deg, #93c5fd, #3b82f6);
        color: white;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.5), inset 0 -1px 2px rgba(0,0,0,.2), 0 3px 8px rgba(59,130,246,.35);
    }
    .level-badge-preview.sinta::after { content: '📘'; font-size: 10px; }
    .level-badge-preview.nas {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.4), transparent 40%), linear-gradient(145deg, #5eead4, #14b8a6);
        color: #134e4a;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.6), inset 0 -1px 2px rgba(0,0,0,.2), 0 3px 8px rgba(20,184,166,.35);
    }
    .level-badge-preview.nas::after { content: '🇮🇩'; font-size: 10px; }
    .level-badge-preview.default {
        background: rgba(100,116,139,.08);
        color: #475569; border-color: rgba(100,116,139,.2);
    }
    .level-badge-preview.default::after { content: '📄'; font-size: 10px; }

    /* ===== AUTHORS PREVIEW ===== */
    .authors-preview {
        display: flex; flex-wrap: wrap; gap: 6px;
        margin-top: 8px; min-height: 26px;
    }
    .author-chip {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px 4px 4px; border-radius: 999px;
        background: linear-gradient(145deg, rgba(124,58,237,.12), rgba(167,139,250,.06));
        border: 1px solid rgba(124,58,237,.25);
        font-size: 11px; font-weight: 700; color: #5b21b6;
        animation: pubChipPop 0.2s ease-out;
    }
    .author-chip .author-avatar {
        width: 22px; height: 22px; border-radius: 50%;
        background: linear-gradient(145deg, #c4b5fd, #a78bfa);
        color: white; font-size: 10px; font-weight: 900;
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display);
    }
    .author-chip:first-child {
        background: linear-gradient(145deg, rgba(217,164,65,.15), rgba(217,164,65,.08));
        border-color: rgba(217,164,65,.35); color: #92400e;
    }
    .author-chip:first-child .author-avatar {
        background: linear-gradient(145deg, #fde68a, #d9a441);
    }
    .authors-count {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 9px; border-radius: 999px;
        background: rgba(124,58,237,.10);
        color: #7c3aed; font-size: 10px; font-weight: 850;
        font-family: var(--font-display);
    }

    /* ===== URL PREVIEW ===== */
    .url-preview {
        display: none; align-items: center; gap: 10px;
        padding: 10px 14px; margin-top: 10px; border-radius: 11px;
        background: linear-gradient(145deg, rgba(5,150,105,.08), rgba(5,150,105,.03));
        border: 1px solid rgba(5,150,105,.25);
        animation: pubChipPop 0.3s ease-out;
    }
    .url-preview.show { display: flex; }
    .url-preview .url-favicon {
        width: 24px; height: 24px; border-radius: 6px; flex-shrink: 0;
        background: white; padding: 3px;
        border: 1px solid var(--border);
    }
    .url-preview .url-info { flex: 1; min-width: 0; }
    .url-preview .url-domain {
        font-size: 12px; font-weight: 800; color: var(--primary-dark);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .url-preview .url-full {
        font-size: 10.5px; color: var(--muted);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        font-family: 'Courier New', monospace;
        margin-top: 1px;
    }
    .url-preview .url-open {
        padding: 4px 10px; border-radius: 8px;
        background: rgba(5,150,105,.15); color: var(--primary-dark);
        border: 1px solid rgba(5,150,105,.3);
        font-size: 10.5px; font-weight: 800;
        text-decoration: none;
        transition: all .2s;
    }
    .url-preview .url-open:hover {
        background: var(--primary-dark); color: white;
    }

    /* ===== YEAR WARNING ===== */
    .year-warning {
        display: none; align-items: center; gap: 8px;
        padding: 8px 12px; margin-top: 8px; border-radius: 9px;
        background: linear-gradient(145deg, rgba(242,192,99,.12), rgba(242,192,99,.06));
        border: 1px solid rgba(242,192,99,.3);
        color: #92400e; font-size: 11px; font-weight: 700;
    }
    .year-warning.show { display: flex; }

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
    .status-preview-3d .sp-dot { width: 8px; height: 8px; border-radius: 50%; }
    .status-preview-3d.published .sp-dot {
        background: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,.2);
        animation: pubFormPulse 2s ease-in-out infinite;
    }
    .status-preview-3d.draft .sp-dot { background: #64748b; }

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
        animation: pubFormShine 3s ease-in-out infinite;
        pointer-events: none;
    }
    .btn-save-3d:hover {
        transform: translateY(-2px);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.8), 0 14px 30px rgba(217,164,65,.55);
    }
    .btn-save-3d:active { transform: translateY(0); }
    .btn-save-3d:disabled { opacity: .6; cursor: not-allowed; }

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

    @media (max-width: 640px) {
        .pub-form-head { padding: 18px 20px; }
        .pub-form-ico { width: 48px; height: 48px; font-size: 22px; }
        .pub-form-title { font-size: 18px; }
        .url-preview .url-full { display: none; }
    }
</style>

<!-- ================= HEADER 3D ================= -->
<div class="pub-form-head">
    <div class="pub-form-ico">📚</div>
    <div style="position: relative; z-index: 1; flex: 1; min-width: 0;">
        <h2 class="pub-form-title"><?= $item !== null ? 'Edit Publikasi' : 'Tambah Publikasi' ?></h2>
        <p class="pub-form-sub">
            <?= $item !== null ? 'Perbarui data publikasi ilmiah.' : 'Catat publikasi ilmiah baru untuk rekam jejak dosen.' ?>
        </p>
    </div>
    <span class="pub-form-mode <?= $item !== null ? 'edit' : 'new' ?>">
        <?= $item !== null ? '✎ Edit' : '+ Baru' ?>
    </span>
</div>

<?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= e($action) ?>" id="pub-form">
    <?= csrf_field() ?>
    <?php if ($item !== null): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>

    <!-- SECTION 1: INFORMASI PUBLIKASI -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-emoji">📋</span>
            <span>Informasi Publikasi</span>
            <span class="section-num">BAGIAN 1 / 3</span>
        </h3>

        <div class="fg-3d">
            <label for="f-title">
                <span class="field-ico">✏️</span>
                Judul Publikasi
                <span class="req-badge">Wajib</span>
            </label>
            <input type="text" id="f-title" name="title"
                   value="<?= e($item['title'] ?? old('title')) ?>"
                   required maxlength="300"
                   placeholder="Contoh: Analisis Dampak AI terhadap Pembelajaran Berbasis Proyek"
                   autocomplete="off">
            <div class="field-helper">
                <span class="helper-tip">💡 Judul lengkap sesuai yang tertera di jurnal/prosiding (max 300 karakter)</span>
                <span class="field-counter" id="title-counter">0 / 300</span>
            </div>
        </div>

        <div class="form-row-3d">
            <div class="fg-3d">
                <label for="f-type">
                    <span class="field-ico">🏷️</span>
                    Tipe
                    <span class="req-badge">Wajib</span>
                </label>
                <select id="f-type" name="type" required>
                    <?php foreach (Publication::TYPES as $key => $label): ?>
                        <option value="<?= e($key) ?>" <?= ($item['type'] ?? 'jurnal') === $key ? 'selected' : '' ?>>
                            <?= e($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="field-helper">
                    <span class="helper-tip">💡 Jenis karya ilmiah</span>
                </div>
            </div>

            <div class="fg-3d">
                <label for="f-level">
                    <span class="field-ico">🏆</span>
                    Level / Indeks
                    <span class="req-badge">Wajib</span>
                </label>
                <input type="text" id="f-level" name="level"
                       value="<?= e($item['level'] ?? old('level', 'Nasional')) ?>"
                       maxlength="100"
                       placeholder="Scopus Q1, SINTA 2, Nasional..."
                       autocomplete="off"
                       list="level-datalist">
                <datalist id="level-datalist">
                    <option value="Scopus Q1">
                    <option value="Scopus Q2">
                    <option value="Scopus Q3">
                    <option value="Scopus Q4">
                    <option value="Web of Science">
                    <option value="SINTA 1">
                    <option value="SINTA 2">
                    <option value="SINTA 3">
                    <option value="SINTA 4">
                    <option value="SINTA 5">
                    <option value="SINTA 6">
                    <option value="Nasional">
                </datalist>

                <div class="level-hints" id="level-hints">
                    <span class="level-hint-chip" data-value="Scopus Q1">⭐ Scopus Q1</span>
                    <span class="level-hint-chip" data-value="Scopus Q2">⭐ Scopus Q2</span>
                    <span class="level-hint-chip" data-value="Web of Science">🌐 WoS</span>
                    <span class="level-hint-chip" data-value="SINTA 1">🏆 SINTA 1</span>
                    <span class="level-hint-chip" data-value="SINTA 2">🏆 SINTA 2</span>
                    <span class="level-hint-chip" data-value="SINTA 3">📘 SINTA 3</span>
                    <span class="level-hint-chip" data-value="SINTA 4">📘 SINTA 4</span>
                    <span class="level-hint-chip" data-value="Nasional">🇮🇩 Nasional</span>
                </div>

                <div id="level-badge-wrap" style="min-height: 32px;">
                    <span class="level-badge-preview default" id="level-badge">
                        <span class="lb-dot" style="background:#64748b;"></span>
                        <span id="level-badge-text">Nasional</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: PENULIS & SUMBER -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-emoji">👤</span>
            <span>Penulis & Sumber</span>
            <span class="section-num">BAGIAN 2 / 3</span>
        </h3>

        <div class="fg-3d">
            <label for="f-authors">
                <span class="field-ico">✍️</span>
                Penulis
                <span class="req-badge">Wajib</span>
            </label>
            <input type="text" id="f-authors" name="authors"
                   value="<?= e($item['authors'] ?? old('authors')) ?>"
                   required maxlength="500"
                   placeholder="Contoh: Ahmad Fauzi, Siti Aminah, Budi Santoso"
                   autocomplete="off">
            <div class="field-helper">
                <span class="helper-tip">💡 Pisahkan setiap penulis dengan tanda koma (,)</span>
                <span class="field-counter" id="authors-counter">0 / 500</span>
            </div>
            <div class="authors-preview" id="authors-preview"></div>
        </div>

        <div class="form-row-3d">
            <div class="fg-3d">
                <label for="f-source">
                    <span class="field-ico">📖</span>
                    Sumber (Jurnal/Penerbit)
                    <span class="opt-badge">Opsional</span>
                </label>
                <input type="text" id="f-source" name="source"
                       value="<?= e($item['source'] ?? old('source')) ?>"
                       maxlength="200"
                       placeholder="Contoh: Jurnal Pendidikan Indonesia"
                       autocomplete="off">
                <div class="field-helper">
                    <span class="helper-tip">💡 Nama jurnal, prosiding, atau penerbit</span>
                </div>
            </div>

            <div class="fg-3d">
                <label for="f-year">
                    <span class="field-ico">📅</span>
                    Tahun
                    <span class="req-badge">Wajib</span>
                </label>
                <input type="number" id="f-year" name="year"
                       min="2000" max="2100"
                       value="<?= e($item['year'] ?? old('year', (string) date('Y'))) ?>"
                       required>
                <div class="field-helper">
                    <span class="helper-tip">💡 Tahun antara 2000 - 2100</span>
                </div>
                <div class="year-warning" id="year-warning">
                    <span>⚠️</span>
                    <span id="year-warning-text">—</span>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 3: LINK & STATUS -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-emoji">🔗</span>
            <span>Link & Status</span>
            <span class="section-num">BAGIAN 3 / 3</span>
        </h3>

        <div class="fg-3d">
            <label for="f-link">
                <span class="field-ico">🔗</span>
                Link URL
                <span class="opt-badge">Opsional</span>
            </label>
            <input type="url" id="f-link" name="link"
                   value="<?= e($item['link'] ?? old('link')) ?>"
                   maxlength="500"
                   placeholder="https://doi.org/... atau https://jurnal.unimof.ac.id/..."
                   autocomplete="off">
            <div class="field-helper">
                <span class="helper-tip">💡 DOI, URL jurnal, atau repository (harus dimulai https://)</span>
            </div>

            <div class="url-preview" id="url-preview">
                <img class="url-favicon" id="url-favicon" src="" alt="favicon" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22><circle cx=%2212%22 cy=%2212%22 r=%2210%22 fill=%22%237c3aed%22/><text x=%2212%22 y=%2217%22 font-size=%2214%22 text-anchor=%22middle%22 fill=%22white%22>🔗</text></svg>'">
                <div class="url-info">
                    <div class="url-domain" id="url-domain">—</div>
                    <div class="url-full" id="url-full">—</div>
                </div>
                <a href="#" target="_blank" rel="noopener noreferrer" class="url-open" id="url-open">
                    ↗ Buka
                </a>
            </div>
        </div>

        <div class="fg-3d">
            <label for="f-status">
                <span class="field-ico">🚦</span>
                Status
                <span class="req-badge">Wajib</span>
            </label>
            <select id="f-status" name="status" required>
                <option value="published" <?= ($item['status'] ?? 'published') === 'published' ? 'selected' : '' ?>>
                    🟢 Published — Tampil di halaman publikasi
                </option>
                <option value="draft" <?= ($item['status'] ?? '') === 'draft' ? 'selected' : '' ?>>
                    ⚪ Draft — Hanya tersimpan, belum publik
                </option>
            </select>
            <div class="status-preview-3d published" id="status-preview">
                <span class="sp-dot"></span>
                <span id="status-preview-text">🟢 Publikasi akan langsung tampil di halaman publikasi</span>
            </div>
        </div>
    </div>

    <!-- ACTIONS -->
    <div class="form-actions-3d">
        <button type="submit" class="btn-save-3d" id="btn-save">
            <?= $item !== null ? '💾 Simpan Perubahan' : '📚 Simpan Publikasi' ?>
        </button>
        <a href="<?= e(url('admin/index.php?page=publikasi')) ?>" class="btn-cancel-3d">
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
    // ===== Helpers =====
    function normalize(str) { return (str || '').toLowerCase().trim(); }

    function detectLevelClass(level) {
        var l = normalize(level);
        if (!l) return 'default';
        if (l.includes('scopus') || l.includes('wos') || l.includes('web of science')
            || l.includes('q1') || l.includes('q2') || l.includes('q3') || l.includes('q4')
            || l.includes('internasional')) return 'intl';
        if (l.includes('sinta 1') || l.includes('sinta 2')) return 'sinta12';
        if (l.includes('sinta')) return 'sinta';
        if (l.includes('nasional')) return 'nas';
        return 'default';
    }

    function detectLevelIcon(level) {
        var cls = detectLevelClass(level);
        return { intl: '⭐', sinta12: '🏆', sinta: '📘', nas: '🇮🇩', default: '📄' }[cls];
    }

    function getInitials(name) {
        var parts = name.trim().split(/\s+/);
        var first = (parts[0] || '').charAt(0).toUpperCase();
        var last = (parts[parts.length - 1] || '').charAt(0).toUpperCase();
        return (first + (parts.length > 1 ? last : '')).substring(0, 2);
    }

    function isValidUrl(str) {
        try {
            var u = new URL(str);
            return u.protocol === 'http:' || u.protocol === 'https:';
        } catch (e) { return false; }
    }

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
    attachCounter('f-title', 'title-counter', 300);
    attachCounter('f-authors', 'authors-counter', 500);

    // ===== Level input + hints + badge =====
    var levelInput = document.getElementById('f-level');
    var levelBadge = document.getElementById('level-badge');
    var levelBadgeText = document.getElementById('level-badge-text');
    var levelHints = document.querySelectorAll('#level-hints .level-hint-chip');

    function updateLevelBadge() {
        if (!levelInput || !levelBadge) return;
        var val = levelInput.value.trim();
        var cls = detectLevelClass(val);

        levelBadge.className = 'level-badge-preview ' + cls;
        levelBadgeText.textContent = val || '—';

        // Active state untuk hint chips
        levelHints.forEach(function(chip) {
            if (normalize(chip.dataset.value) === normalize(val)) {
                chip.classList.add('active');
            } else {
                chip.classList.remove('active');
            }
        });
    }

    if (levelInput) {
        levelInput.addEventListener('input', updateLevelBadge);
        updateLevelBadge();
    }

    levelHints.forEach(function(chip) {
        chip.addEventListener('click', function() {
            if (levelInput) {
                levelInput.value = chip.dataset.value;
                levelInput.focus();
                updateLevelBadge();
            }
        });
    });

    // ===== Authors preview =====
    var authorsInput = document.getElementById('f-authors');
    var authorsPreview = document.getElementById('authors-preview');

    function updateAuthorsPreview() {
        if (!authorsInput || !authorsPreview) return;
        var val = authorsInput.value.trim();
        if (!val) { authorsPreview.innerHTML = ''; return; }

        var parts = val.split(',').map(function(s){ return s.trim(); }).filter(Boolean);
        if (parts.length === 0) { authorsPreview.innerHTML = ''; return; }

        var html = '';
        parts.forEach(function(name, idx) {
            var initials = getInitials(name);
            var isCorresponding = idx === 0;
            html += '<span class="author-chip">';
            html += '<span class="author-avatar">' + initials + '</span>';
            html += '<span>' + name + '</span>';
            html += '</span>';
        });
        html += '<span class="authors-count">' + parts.length + ' penulis</span>';
        authorsPreview.innerHTML = html;
    }

    if (authorsInput) {
        authorsInput.addEventListener('input', updateAuthorsPreview);
        updateAuthorsPreview();
    }

    // ===== Year validation =====
    var yearInput = document.getElementById('f-year');
    var yearWarning = document.getElementById('year-warning');
    var yearWarningText = document.getElementById('year-warning-text');

    function updateYearWarning() {
        if (!yearInput || !yearWarning) return;
        var year = parseInt(yearInput.value, 10);
        var currentYear = new Date().getFullYear();

        if (isNaN(year) || !yearInput.value) {
            yearWarning.classList.remove('show');
            return;
        }

        if (year > currentYear) {
            yearWarningText.textContent = 'Tahun di masa depan. Periksa kembali.';
            yearWarning.classList.add('show');
        } else if (year < currentYear - 10) {
            yearWarningText.textContent = 'Publikasi ini sudah lebih dari 10 tahun.';
            yearWarning.classList.add('show');
        } else {
            yearWarning.classList.remove('show');
        }
    }

    if (yearInput) {
        yearInput.addEventListener('input', updateYearWarning);
        yearInput.addEventListener('blur', updateYearWarning);
        updateYearWarning();
    }

    // ===== URL preview =====
    var linkInput = document.getElementById('f-link');
    var urlPreview = document.getElementById('url-preview');
    var urlFavicon = document.getElementById('url-favicon');
    var urlDomain = document.getElementById('url-domain');
    var urlFull = document.getElementById('url-full');
    var urlOpen = document.getElementById('url-open');

    function updateUrlPreview() {
        if (!linkInput || !urlPreview) return;
        var val = linkInput.value.trim();

        if (!val || !isValidUrl(val)) {
            urlPreview.classList.remove('show');
            return;
        }

        try {
            var u = new URL(val);
            var domain = u.hostname.replace(/^www\./, '');

            if (urlDomain) urlDomain.textContent = domain;
            if (urlFull) urlFull.textContent = val;
            if (urlOpen) urlOpen.href = val;
            if (urlFavicon) {
                urlFavicon.src = 'https://www.google.com/s2/favicons?domain=' + domain + '&sz=64';
            }
            urlPreview.classList.add('show');
        } catch (e) {
            urlPreview.classList.remove('show');
        }
    }

    if (linkInput) {
        linkInput.addEventListener('input', updateUrlPreview);
        linkInput.addEventListener('blur', updateUrlPreview);
        updateUrlPreview();
    }

    // ===== Status preview =====
    var statusSelect = document.getElementById('f-status');
    var statusPreview = document.getElementById('status-preview');
    var statusText = document.getElementById('status-preview-text');

    function updateStatus() {
        if (!statusSelect || !statusPreview) return;
        if (statusSelect.value === 'published') {
            statusPreview.className = 'status-preview-3d published';
            statusText.textContent = '🟢 Publikasi akan langsung tampil di halaman publikasi';
        } else {
            statusPreview.className = 'status-preview-3d draft';
            statusText.textContent = '⚪ Hanya tersimpan sebagai draft, belum publik';
        }
    }
    if (statusSelect) {
        statusSelect.addEventListener('change', updateStatus);
        updateStatus();
    }

    // ===== Submit progress =====
    var form = document.getElementById('pub-form');
    var btnSave = document.getElementById('btn-save');
    if (form) {
        form.addEventListener('submit', function() {
            if (btnSave) {
                btnSave.disabled = true;
                btnSave.textContent = '⏳ Menyimpan...';
            }
        });
    }
})();
</script>