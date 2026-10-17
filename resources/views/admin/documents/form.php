<style>
    @keyframes docFormShine { 0%{transform:translateX(-100%) skewX(-20deg)} 100%{transform:translateX(300%) skewX(-20deg)} }
    @keyframes docFormPulse { 0%,100%{box-shadow: 0 0 0 0 rgba(5,150,105,0.4);} 50%{box-shadow: 0 0 0 6px rgba(5,150,105,0);} }
    @keyframes docFormFadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }
    @keyframes docReqPulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.2); } }
    @keyframes docIcoSpin { from { transform: rotate(-5deg); } 50% { transform: rotate(5deg); } to { transform: rotate(-5deg); } }

    /* ===== FORM HEAD 3D ===== */
    .doc-form-head {
        display: flex; align-items: center; gap: 16px; margin-bottom: 24px;
        padding: 22px 26px; border-radius: 22px;
        background: linear-gradient(135deg, #043b2c 0%, #065f46 55%, #059669 100%);
        color: white; position: relative; overflow: hidden;
        box-shadow: 0 16px 40px rgba(0,0,0,.30);
        animation: docFormFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    .doc-form-head::before {
        content:''; position:absolute; inset:0;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 25px, rgba(217,164,65,.04) 25px, rgba(217,164,65,.04) 26px),
            repeating-linear-gradient(-45deg, transparent, transparent 25px, rgba(217,164,65,.04) 25px, rgba(217,164,65,.04) 26px);
    }
    .doc-form-head::after {
        content:''; position:absolute; top:-50%; right:-10%;
        width: 320px; height: 320px; border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,.25), transparent 70%);
        pointer-events: none;
    }
    .doc-form-ico {
        width: 56px; height: 56px; border-radius: 16px; flex-shrink: 0;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.5), transparent 40%),
                    linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441);
        display: flex; align-items: center; justify-content: center;
        font-size: 26px; position: relative;
        box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -3px 4px rgba(0,0,0,.2), 0 6px 16px rgba(217,164,65,.45);
    }
    .doc-form-ico::before {
        content:''; position:absolute; top:5px; left:10px;
        width:16px; height:7px; border-radius:50%;
        background: rgba(255,255,255,.65); filter: blur(1.5px);
    }
    .doc-form-title {
        font-family: var(--font-display); font-size: 22px; font-weight: 900;
        letter-spacing: -.02em; margin: 0; position: relative; z-index: 1;
        background: linear-gradient(135deg, #fff 0%, #fde68a 100%);
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .doc-form-sub { font-size: 12.5px; opacity: .85; margin: 4px 0 0; position: relative; z-index: 1; }
    .doc-form-mode {
        margin-left: auto; padding: 4px 12px; border-radius: 999px;
        font-size: 10px; font-weight: 900; letter-spacing: .1em; text-transform: uppercase;
        position: relative; z-index: 1; flex-shrink: 0;
    }
    .doc-form-mode.edit {
        background: linear-gradient(145deg, #fde68a, #d9a441); color: #03251f;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -1px 2px rgba(0,0,0,.15);
    }
    .doc-form-mode.new {
        background: rgba(255,255,255,.15); color: #fff;
        border: 1px solid rgba(255,255,255,.3);
    }

    /* ===== FLASH 3D ===== */
    .flash-3d {
        position: relative; padding: 14px 18px; margin-bottom: 20px;
        border-radius: 14px; font-size: 13.5px; font-weight: 700;
        display: flex; align-items: center; gap: 10px; overflow: hidden;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.05), 0 4px 12px rgba(0,0,0,.1);
        animation: docFormFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    .flash-3d::after {
        content:''; position:absolute; top:0; left:-100%;
        width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent);
        animation: docFormShine 3s ease-in-out infinite; pointer-events: none;
    }
    .flash-success-3d { background: linear-gradient(145deg, #d1fae5, #a7f3d0); border: 1px solid rgba(16,185,129,.35); color: #065f46; }
    .flash-error-3d { background: linear-gradient(145deg, #fee2e2, #fecaca); border: 1px solid rgba(220,38,38,.35); color: #991b1b; }

    /* ===== FORM SECTION 3D ===== */
    .form-section-3d {
        background: var(--white); border: 1px solid var(--border);
        border-radius: 20px; padding: 26px; margin-bottom: 20px;
        box-shadow: 0 4px 14px rgba(0,0,0,.04);
        position: relative; overflow: hidden;
        animation: docFormFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    .form-section-3d:nth-of-type(2) { animation-delay: .08s; }
    .form-section-3d:nth-of-type(3) { animation-delay: .16s; }
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
        animation: docReqPulse 1.5s ease-in-out infinite;
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
        padding-right: 44px; cursor: pointer;
    }
    .fg-3d select option { background: #f6faf7; color: #03251f; padding: 8px; }
    .fg-3d textarea { resize: vertical; min-height: 90px; line-height: 1.6; }

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
        animation: docFormPulse 2s ease-in-out infinite;
    }
    .status-preview-3d.draft .sp-dot { background: #64748b; }

    .form-row-3d { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media (max-width: 640px) { .form-row-3d { grid-template-columns: 1fr; } }

    /* ===== DROPZONE 3D ===== */
    .dropzone-3d {
        position: relative; padding: 36px 24px; border-radius: 18px;
        border: 3px dashed rgba(217,164,65,.5);
        background: linear-gradient(145deg, rgba(253,230,138,.08), rgba(217,164,65,.04));
        text-align: center; cursor: pointer;
        transition: all .3s cubic-bezier(0.16,1,0.3,1);
        overflow: hidden;
    }
    .dropzone-3d::before {
        content:''; position:absolute; inset:0;
        background-image: repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(217,164,65,.03) 20px, rgba(217,164,65,.03) 21px);
        pointer-events: none;
    }
    .dropzone-3d:hover {
        border-color: #059669;
        background: linear-gradient(145deg, rgba(16,185,129,.08), rgba(5,150,105,.04));
        box-shadow: 0 8px 24px rgba(5,150,105,.12);
        transform: translateY(-2px);
    }
    .dropzone-3d.dragover {
        border-color: #059669;
        background: linear-gradient(145deg, rgba(16,185,129,.15), rgba(5,150,105,.08));
        transform: translateY(-3px);
    }
    .dropzone-3d.has-file {
        border-style: solid; border-color: rgba(16,185,129,.4);
        background: linear-gradient(145deg, rgba(16,185,129,.06), rgba(5,150,105,.03));
    }
    .dropzone-3d.has-error {
        border-color: rgba(220,38,38,.5);
        background: linear-gradient(145deg, rgba(254,226,226,.3), rgba(252,165,165,.08));
    }
    .dropzone-3d input[type="file"] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer;
    }
    .dz-ico-3d {
        width: 64px; height: 64px; border-radius: 20px; margin: 0 auto 14px;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.5), transparent 40%),
                    linear-gradient(145deg, #34d399, #10b981 50%, #059669);
        display: flex; align-items: center; justify-content: center;
        font-size: 30px; position: relative;
        box-shadow: inset 0 2px 3px rgba(255,255,255,.6), inset 0 -3px 4px rgba(0,0,0,.25), 0 6px 16px rgba(5,150,105,.35);
    }
    .dropzone-3d:hover .dz-ico-3d { animation: docIcoSpin 0.6s ease-in-out; }
    .dz-ico-3d::before {
        content:''; position:absolute; top:6px; left:12px;
        width:18px; height:8px; border-radius:50%;
        background: rgba(255,255,255,.6); filter: blur(1.5px);
    }
    .dz-title-3d {
        font-size: 15px; font-weight: 800; color: var(--ink);
        margin-bottom: 6px; font-family: var(--font-display);
    }
    .dz-sub-3d { font-size: 12px; color: var(--muted); margin-bottom: 10px; }
    .dz-formats {
        display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;
    }
    .dz-format-chip {
        padding: 3px 10px; border-radius: 999px; font-size: 10px; font-weight: 800;
        background: rgba(5,150,105,.1); color: var(--primary-dark);
        border: 1px solid rgba(5,150,105,.25);
    }

    /* ===== FILE PREVIEW (saat file dipilih) ===== */
    .file-preview-3d {
        display: none; align-items: center; gap: 14px;
        padding: 16px 18px; margin-top: 14px; border-radius: 14px;
        background: linear-gradient(145deg, #f6faf7, #ffffff);
        border: 1px solid rgba(16,185,129,.35);
        box-shadow: inset 0 1px 1px rgba(255,255,255,.9), 0 3px 10px rgba(16,185,129,.1);
        animation: docFormFadeUp 0.3s ease-out;
    }
    .file-preview-3d.show { display: flex; }
    .file-preview-3d .fp-info { flex: 1; min-width: 0; }
    .file-preview-3d .fp-name {
        font-size: 13px; font-weight: 800; color: var(--ink);
        margin: 0 0 3px;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .file-preview-3d .fp-meta {
        font-size: 11px; color: var(--muted); font-weight: 600;
        display: flex; gap: 8px; align-items: center; flex-wrap: wrap;
    }
    .file-preview-3d .fp-type-chip {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 1px 7px; border-radius: 999px;
        font-size: 9px; font-weight: 900; letter-spacing: .05em;
        color: white;
    }
    .fp-type-pdf { background: linear-gradient(145deg, #fca5a5, #dc2626); }
    .fp-type-doc, .fp-type-docx { background: linear-gradient(145deg, #93c5fd, #2563eb); }
    .fp-type-xls, .fp-type-xlsx { background: linear-gradient(145deg, #86efac, #16a34a); }
    .fp-type-ppt, .fp-type-pptx { background: linear-gradient(145deg, #fdba74, #ea580c); }
    .fp-type-default { background: linear-gradient(145deg, #a78bfa, #7c3aed); }
    .file-preview-3d .fp-remove {
        padding: 4px 10px; border-radius: 8px; border: none; cursor: pointer;
        background: rgba(220,38,38,.08); color: #dc2626;
        font-size: 11px; font-weight: 800;
        transition: all .2s;
    }
    .file-preview-3d .fp-remove:hover {
        background: #dc2626; color: white;
    }

    /* ===== FILE WARNING ===== */
    .file-warning-3d {
        display: none; align-items: center; gap: 10px;
        padding: 10px 14px; margin-top: 10px; border-radius: 11px;
        background: linear-gradient(145deg, rgba(220,38,38,.10), rgba(220,38,38,.05));
        border: 1px solid rgba(220,38,38,.3);
        color: #991b1b; font-size: 12px; font-weight: 700;
        animation: docFormFadeUp 0.3s ease-out;
    }
    .file-warning-3d.show { display: flex; }

    /* ===== FILE CURRENT CARD 3D (edit mode) ===== */
    .file-current-3d {
        display: flex; align-items: center; gap: 14px;
        padding: 16px 18px; margin-top: 14px; border-radius: 14px;
        background: linear-gradient(145deg, #f6faf7, #ffffff);
        border: 1px solid rgba(217,164,65,.25);
        box-shadow: inset 0 1px 1px rgba(255,255,255,.9), 0 3px 10px rgba(0,0,0,.05);
    }
    .file-ico-3d {
        width: 46px; height: 46px; border-radius: 13px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display); font-weight: 900; font-size: 11px;
        color: white; position: relative; overflow: hidden;
        box-shadow: inset 0 2px 3px rgba(255,255,255,.5), inset 0 -2px 3px rgba(0,0,0,.2), 0 3px 8px rgba(0,0,0,.15);
    }
    .file-ico-3d::before {
        content:''; position:absolute; top:4px; left:8px;
        width:14px; height:6px; border-radius:50%;
        background: rgba(255,255,255,.55); filter: blur(1px);
    }
    .fi-pdf { background: linear-gradient(145deg, #fca5a5, #dc2626 60%, #991b1b); }
    .fi-doc, .fi-docx { background: linear-gradient(145deg, #93c5fd, #2563eb 60%, #1e3a8a); }
    .fi-xls, .fi-xlsx { background: linear-gradient(145deg, #86efac, #16a34a 60%, #14532d); }
    .fi-ppt, .fi-pptx { background: linear-gradient(145deg, #fdba74, #ea580c 60%, #9a3412); }
    .fi-default { background: linear-gradient(145deg, #a78bfa, #7c3aed 60%, #5b21b6); }

    .file-download-bar {
        margin-top: 8px; height: 5px; border-radius: 99px;
        background: rgba(100,116,139,.1); overflow: hidden;
    }
    .file-download-bar i {
        display: block; height: 100%; border-radius: 99px;
        background: linear-gradient(90deg, #10b981, #f2c063);
        position: relative; overflow: hidden;
    }
    .file-download-bar i::after {
        content:''; position:absolute; top:0; left:-60%;
        width: 42%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,.6), transparent);
        animation: docFormShine 2.7s linear infinite;
    }

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
        animation: docFormShine 3s ease-in-out infinite;
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
</style>

<?php
$fileIcoClass = 'fi-default';
if ($item !== null) {
    $ftLower = strtolower($item['file_type'] ?? '');
    $map = [
        'pdf' => 'fi-pdf', 'doc' => 'fi-doc', 'docx' => 'fi-docx',
        'xls' => 'fi-xls', 'xlsx' => 'fi-xlsx', 'ppt' => 'fi-ppt', 'pptx' => 'fi-pptx',
    ];
    $fileIcoClass = $map[$ftLower] ?? 'fi-default';
}
?>

<!-- ================= HEADER 3D ================= -->
<div class="doc-form-head">
    <div class="doc-form-ico">📁</div>
    <div style="position: relative; z-index: 1; flex: 1; min-width: 0;">
        <h2 class="doc-form-title"><?= $item !== null ? 'Edit Dokumen' : 'Tambah Dokumen' ?></h2>
        <p class="doc-form-sub">
            <?= $item !== null ? 'Perbarui informasi dan file dokumen.' : 'Upload dokumen resmi LP3M/LPPAIK UNIMOF untuk arsip publik.' ?>
        </p>
    </div>
    <span class="doc-form-mode <?= $item !== null ? 'edit' : 'new' ?>">
        <?= $item !== null ? '✎ Edit' : '+ Baru' ?>
    </span>
</div>

<?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" action="<?= e($action) ?>" id="doc-form">
    <?= csrf_field() ?>
    <?php if ($item !== null): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>

    <!-- SECTION 1: INFORMASI DASAR -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-emoji">📋</span>
            <span>Informasi Dasar</span>
            <span class="section-num">BAGIAN 1 / 2</span>
        </h3>

        <div class="fg-3d">
            <label for="f-title">
                <span class="field-ico">✏️</span>
                Judul Dokumen
                <span class="req-badge">Wajib</span>
            </label>
            <input type="text" id="f-title" name="title"
                   value="<?= e($item['title'] ?? old('title')) ?>"
                   required maxlength="200"
                   placeholder="Contoh: Pedoman Penelitian 2025"
                   autocomplete="off">
            <div class="field-helper">
                <span class="helper-tip">💡 Judul yang jelas dan deskriptif (max 200 karakter)</span>
                <span class="field-counter" id="title-counter">0 / 200</span>
            </div>
        </div>

        <div class="form-row-3d">
            <div class="fg-3d">
                <label for="f-category">
                    <span class="field-ico">🏷️</span>
                    Kategori
                    <span class="req-badge">Wajib</span>
                </label>
                <select id="f-category" name="category" required>
                    <?php foreach (Document::CATEGORY_LABELS as $key => $label): ?>
                        <option value="<?= e($key) ?>" <?= ($item['category'] ?? 'template') === $key ? 'selected' : '' ?>>
                            <?= e($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="field-helper">
                    <span class="helper-tip">💡 Pilih kategori sesuai jenis dokumen</span>
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
                        🟢 Published — Tampil di halaman Unduhan
                    </option>
                    <option value="draft" <?= ($item['status'] ?? '') === 'draft' ? 'selected' : '' ?>>
                        ⚪ Draft — Hanya tersimpan, belum publik
                    </option>
                </select>
                <div class="status-preview-3d published" id="status-preview">
                    <span class="sp-dot"></span>
                    <span id="status-preview-text">🟢 Dokumen akan langsung tampil di halaman Unduhan</span>
                </div>
            </div>
        </div>

        <div class="fg-3d">
            <label for="f-description">
                <span class="field-ico">📖</span>
                Deskripsi
                <span class="opt-badge">Opsional</span>
            </label>
            <textarea id="f-description" name="description" rows="4"
                      maxlength="2000"
                      placeholder="Jelaskan isi, tujuan, dan manfaat dokumen ini..."><?= e($item['description'] ?? old('description')) ?></textarea>
            <div class="field-helper">
                <span class="helper-tip">💡 Bantu pengguna memahami isi dokumen (max 2000 karakter)</span>
                <span class="field-counter" id="desc-counter">0 / 2000</span>
            </div>
        </div>
    </div>

    <!-- SECTION 2: UPLOAD FILE -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-emoji">📤</span>
            <span>Upload File</span>
            <span class="section-num">BAGIAN 2 / 2</span>
        </h3>

        <div class="fg-3d">
            <label for="f-file">
                <span class="field-ico">📎</span>
                File Dokumen
                <span class="req-badge" <?= $item !== null ? 'style="display:none"' : '' ?>>Wajib</span>
                <?php if ($item !== null): ?><span class="opt-badge">Ganti Opsional</span><?php endif; ?>
            </label>

            <div class="dropzone-3d" id="dropzone">
                <input type="file" id="f-file" name="file"
                       accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                       <?= $item === null ? 'required' : '' ?>>
                <div class="dz-ico-3d">📤</div>
                <div class="dz-title-3d" id="dz-title">
                    <?= $item !== null ? 'Ganti File (Opsional)' : 'Klik atau Seret File ke Sini' ?>
                </div>
                <div class="dz-sub-3d">Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX · Maks 10 MB</div>
                <div class="dz-formats">
                    <span class="dz-format-chip">PDF</span>
                    <span class="dz-format-chip">DOC</span>
                    <span class="dz-format-chip">DOCX</span>
                    <span class="dz-format-chip">XLS</span>
                    <span class="dz-format-chip">XLSX</span>
                    <span class="dz-format-chip">PPT</span>
                    <span class="dz-format-chip">PPTX</span>
                </div>
            </div>

            <!-- File Preview (muncul saat file dipilih) -->
            <div class="file-preview-3d" id="file-preview">
                <div class="file-ico-3d" id="fp-ico" style="background:linear-gradient(145deg,#a78bfa,#7c3aed 60%,#5b21b6);">FILE</div>
                <div class="fp-info">
                    <p class="fp-name" id="fp-name">—</p>
                    <div class="fp-meta">
                        <span class="fp-type-chip fp-type-default" id="fp-type-chip">FILE</span>
                        <span>📦 <span id="fp-size">—</span></span>
                        <span>✅ Siap diupload</span>
                    </div>
                </div>
                <button type="button" class="fp-remove" id="fp-remove">✕ Hapus</button>
            </div>

            <!-- File Warning -->
            <div class="file-warning-3d" id="file-warning">
                <span>⚠️</span>
                <span id="file-warning-text">—</span>
            </div>

            <?php if ($item !== null): ?>
                <div class="file-current-3d">
                    <div class="file-ico-3d <?= $fileIcoClass ?>"><?= e(strtoupper($item['file_type'] ?? 'FILE')) ?></div>
                    <div style="flex: 1; min-width: 0;">
                        <p style="margin: 0; font-size: 13px; font-weight: 700; color: var(--ink);">
                            📦 File saat ini
                        </p>
                        <p style="margin: 3px 0 0; font-size: 12px; color: var(--muted);">
                            <?= e(format_bytes((int) ($item['file_size'] ?? 0))) ?>
                            · ⬇️ <?= number_format((int) ($item['download_count'] ?? 0)) ?> kali diunduh
                        </p>
                        <?php
                        $downloadCount = (int) ($item['download_count'] ?? 0);
                        $target = 100;
                        $pct = min(100, ($downloadCount / max(1, $target)) * 100);
                        ?>
                        <div class="file-download-bar">
                            <i style="width: <?= $pct ?>%;"></i>
                        </div>
                    </div>
                    <span style="font-size: 10.5px; color: var(--muted); font-weight: 600; text-align: right; line-height: 1.4;">
                        Upload file baru<br>untuk mengganti
                    </span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ACTIONS -->
    <div class="form-actions-3d">
        <button type="submit" class="btn-save-3d" id="btn-save">
            <?= $item !== null ? '💾 Simpan Perubahan' : '📤 Upload Dokumen' ?>
        </button>
        <a href="<?= e(url('admin/index.php?page=dokumen')) ?>" class="btn-cancel-3d">
            ✖ Batal
        </a>
        <span class="form-actions-spacer"></span>
        <span class="form-tip-box">
            💡 File tersimpan aman di server
        </span>
    </div>
</form>

<script>
(function(){
    // ===== Helpers =====
    function formatBytes(bytes) {
        if (bytes === 0) return '0 B';
        var k = 1024, sizes = ['B', 'KB', 'MB', 'GB'];
        var i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }

    function getFileType(filename) {
        var ext = (filename.split('.').pop() || '').toLowerCase();
        var map = { pdf:'pdf', doc:'doc', docx:'docx', xls:'xls', xlsx:'xlsx', ppt:'ppt', pptx:'pptx' };
        return map[ext] || 'default';
    }

    var ALLOWED_EXTS = ['pdf','doc','docx','xls','xlsx','ppt','pptx'];
    var MAX_SIZE = 10 * 1024 * 1024; // 10 MB

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
    attachCounter('f-description', 'desc-counter', 2000);

    // ===== Status preview =====
    var statusSelect = document.getElementById('f-status');
    var statusPreview = document.getElementById('status-preview');
    var statusText = document.getElementById('status-preview-text');
    function updateStatus() {
        if (!statusSelect || !statusPreview) return;
        if (statusSelect.value === 'published') {
            statusPreview.className = 'status-preview-3d published';
            statusText.textContent = '🟢 Dokumen akan langsung tampil di halaman Unduhan';
        } else {
            statusPreview.className = 'status-preview-3d draft';
            statusText.textContent = '⚪ Hanya tersimpan sebagai draft, belum publik';
        }
    }
    if (statusSelect) {
        statusSelect.addEventListener('change', updateStatus);
        updateStatus();
    }

    // ===== File upload handling =====
    var fileInput = document.getElementById('f-file');
    var dropzone = document.getElementById('dropzone');
    var dzTitle = document.getElementById('dz-title');
    var filePreview = document.getElementById('file-preview');
    var fpIco = document.getElementById('fp-ico');
    var fpName = document.getElementById('fp-name');
    var fpTypeChip = document.getElementById('fp-type-chip');
    var fpSize = document.getElementById('fp-size');
    var fpRemove = document.getElementById('fp-remove');
    var fileWarning = document.getElementById('file-warning');
    var fileWarningText = document.getElementById('file-warning-text');

    var fileIcoStyles = {
        pdf: 'linear-gradient(145deg,#fca5a5,#dc2626 60%,#991b1b)',
        doc: 'linear-gradient(145deg,#93c5fd,#2563eb 60%,#1e3a8a)',
        docx: 'linear-gradient(145deg,#93c5fd,#2563eb 60%,#1e3a8a)',
        xls: 'linear-gradient(145deg,#86efac,#16a34a 60%,#14532d)',
        xlsx: 'linear-gradient(145deg,#86efac,#16a34a 60%,#14532d)',
        ppt: 'linear-gradient(145deg,#fdba74,#ea580c 60%,#9a3412)',
        pptx: 'linear-gradient(145deg,#fdba74,#ea580c 60%,#9a3412)',
        default: 'linear-gradient(145deg,#a78bfa,#7c3aed 60%,#5b21b6)'
    };

    function showWarning(msg) {
        fileWarningText.textContent = msg;
        fileWarning.classList.add('show');
        dropzone.classList.add('has-error');
        dropzone.classList.remove('has-file');
        filePreview.classList.remove('show');
    }
    function clearWarning() {
        fileWarning.classList.remove('show');
        dropzone.classList.remove('has-error');
    }

    function handleFile(file) {
        clearWarning();

        if (!file) {
            filePreview.classList.remove('show');
            dropzone.classList.remove('has-file');
            dzTitle.textContent = 'Klik atau Seret File ke Sini';
            return;
        }

        var ext = (file.name.split('.').pop() || '').toLowerCase();
        if (ALLOWED_EXTS.indexOf(ext) === -1) {
            showWarning('Format "' + ext.toUpperCase() + '" tidak didukung. Gunakan PDF/DOC/DOCX/XLS/XLSX/PPT/PPTX.');
            fileInput.value = '';
            return;
        }

        if (file.size > MAX_SIZE) {
            showWarning('File terlalu besar (' + formatBytes(file.size) + '). Maksimal 10 MB.');
            fileInput.value = '';
            return;
        }

        var type = getFileType(file.name);
        var typeLabel = type.toUpperCase();

        // Update preview
        fpIco.style.background = fileIcoStyles[type] || fileIcoStyles.default;
        fpIco.textContent = typeLabel;
        fpName.textContent = file.name;
        fpTypeChip.className = 'fp-type-chip fp-type-' + type;
        fpTypeChip.textContent = typeLabel;
        fpSize.textContent = formatBytes(file.size);

        filePreview.classList.add('show');
        dropzone.classList.add('has-file');
        dzTitle.textContent = '📎 File dipilih — Klik untuk ganti';
    }

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            handleFile(e.target.files[0]);
        });
    }

    if (fpRemove) {
        fpRemove.addEventListener('click', function() {
            fileInput.value = '';
            handleFile(null);
            clearWarning();
        });
    }

    // Drag & drop visual feedback
    if (dropzone) {
        ['dragenter','dragover'].forEach(function(evt){
            dropzone.addEventListener(evt, function(e){
                e.preventDefault();
                dropzone.classList.add('dragover');
            });
        });
        ['dragleave','drop'].forEach(function(evt){
            dropzone.addEventListener(evt, function(e){
                e.preventDefault();
                dropzone.classList.remove('dragover');
            });
        });
    }

    // ===== Submit progress =====
    var form = document.getElementById('doc-form');
    var btnSave = document.getElementById('btn-save');
    if (form) {
        form.addEventListener('submit', function() {
            if (btnSave) {
                btnSave.disabled = true;
                btnSave.textContent = '⏳ Mengupload...';
            }
        });
    }
})();
</script>