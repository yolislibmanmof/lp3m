<style>
    @keyframes hakiFormShine { 0%{transform:translateX(-100%) skewX(-20deg)} 100%{transform:translateX(300%) skewX(-20deg)} }
    @keyframes hakiFormFadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }
    @keyframes hakiFormPulse { 0%,100%{box-shadow: 0 0 0 0 rgba(5,150,105,0.4);} 50%{box-shadow: 0 0 0 6px rgba(5,150,105,0);} }
    @keyframes hakiReqPulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.2); } }
    @keyframes hakiChipPop { from { opacity: 0; transform: scale(0.8); } to { opacity: 1; transform: scale(1); } }
    @keyframes hakiPipelinePulse { 0%,100%{box-shadow: 0 0 0 0 rgba(59,130,246,0.5);} 50%{box-shadow: 0 0 0 6px rgba(59,130,246,0);} }

    /* ===== FORM HEAD 3D (TEMA BIRU HAKI) ===== */
    .haki-form-head {
        display: flex; align-items: center; gap: 16px; margin-bottom: 24px;
        padding: 22px 26px; border-radius: 22px;
        background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 55%, #3b82f6 100%);
        color: white; position: relative; overflow: hidden;
        box-shadow: 0 16px 40px rgba(30,58,138,.30);
        animation: hakiFormFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    .haki-form-head::before {
        content:''; position:absolute; inset:0;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 25px, rgba(253,230,138,.05) 25px, rgba(253,230,138,.05) 26px),
            repeating-linear-gradient(-45deg, transparent, transparent 25px, rgba(253,230,138,.05) 25px, rgba(253,230,138,.05) 26px);
    }
    .haki-form-head::after {
        content:''; position:absolute; top:-50%; right:-10%;
        width: 320px; height: 320px; border-radius: 50%;
        background: radial-gradient(circle, rgba(253,230,138,.25), transparent 70%);
        pointer-events: none;
    }
    .haki-form-ico {
        width: 56px; height: 56px; border-radius: 16px; flex-shrink: 0;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.5), transparent 40%),
                    linear-gradient(145deg, #60a5fa, #3b82f6 50%, #1d4ed8);
        display: flex; align-items: center; justify-content: center;
        font-size: 26px; position: relative;
        box-shadow: inset 0 2px 3px rgba(255,255,255,.6), inset 0 -3px 4px rgba(0,0,0,.25), 0 6px 14px rgba(59,130,246,.4);
    }
    .haki-form-ico::before {
        content:''; position:absolute; top:5px; left:10px;
        width:16px; height:7px; border-radius:50%;
        background: rgba(255,255,255,.6); filter: blur(1.5px);
    }
    .haki-form-title {
        font-family: var(--font-display); font-size: 22px; font-weight: 900;
        letter-spacing: -.02em; margin: 0; position: relative; z-index: 1;
        background: linear-gradient(135deg, #fff 0%, #fde68a 100%);
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .haki-form-sub { font-size: 12.5px; opacity: .90; margin: 4px 0 0; position: relative; z-index: 1; }
    .haki-form-mode {
        margin-left: auto; padding: 4px 12px; border-radius: 999px;
        font-size: 10px; font-weight: 900; letter-spacing: .1em; text-transform: uppercase;
        position: relative; z-index: 1; flex-shrink: 0;
    }
    .haki-form-mode.edit {
        background: linear-gradient(145deg, #fde68a, #d9a441); color: #03251f;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -1px 2px rgba(0,0,0,.15);
    }
    .haki-form-mode.new {
        background: rgba(255,255,255,.18); color: #fff;
        border: 1px solid rgba(255,255,255,.35);
    }

    /* ===== FLASH 3D ===== */
    .flash-3d {
        position: relative; padding: 14px 18px; margin-bottom: 20px;
        border-radius: 14px; font-size: 13.5px; font-weight: 700;
        display: flex; align-items: center; gap: 10px; overflow: hidden;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.05), 0 4px 12px rgba(0,0,0,.1);
        animation: hakiFormFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    .flash-3d::after {
        content:''; position:absolute; top:0; left:-100%;
        width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent);
        animation: hakiFormShine 3s ease-in-out infinite; pointer-events: none;
    }
    .flash-success-3d { background: linear-gradient(145deg, #d1fae5, #a7f3d0); border: 1px solid rgba(16,185,129,.35); color: #065f46; }
    .flash-error-3d { background: linear-gradient(145deg, #fee2e2, #fecaca); border: 1px solid rgba(220,38,38,.35); color: #991b1b; }

    /* ===== FORM SECTION 3D ===== */
    .form-section-3d {
        background: var(--white); border: 1px solid var(--border);
        border-radius: 20px; padding: 26px; margin-bottom: 20px;
        box-shadow: 0 4px 14px rgba(0,0,0,.04);
        position: relative; overflow: hidden;
        animation: hakiFormFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    .form-section-3d:nth-of-type(2) { animation-delay: .08s; }
    .form-section-3d:nth-of-type(3) { animation-delay: .16s; }
    .form-section-3d:nth-of-type(4) { animation-delay: .24s; }
    .form-section-3d:nth-of-type(5) { animation-delay: .32s; }
    .form-section-3d::before {
        content:''; position:absolute; top:0; left:0; right:0; height: 3px;
        background: linear-gradient(90deg, #60a5fa, #1d4ed8);
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
        color: #1e40af; margin-bottom: 9px;
    }
    .fg-3d label .field-ico {
        display: inline-flex; align-items: center; justify-content: center;
        width: 22px; height: 22px; border-radius: 7px;
        background: linear-gradient(145deg, rgba(59,130,246,.15), rgba(29,78,216,.08));
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
        animation: hakiReqPulse 1.5s ease-in-out infinite;
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
    .fg-3d input[type="date"],
    .fg-3d input[type="url"],
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
        caret-color: #1d4ed8 !important;
        transition: background-color 99999s ease-in-out 0s;
        border-color: var(--border) !important;
    }
    .fg-3d select {
        appearance: none; -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%231d4ed8' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 16px center !important;
        background-size: 12px 8px !important;
        padding-right: 44px; cursor: pointer;
    }
    .fg-3d select option { background: #f6faf7; color: #03251f; padding: 8px; }
    .fg-3d textarea { resize: vertical; min-height: 100px; line-height: 1.6; }

    .fg-3d input:focus, .fg-3d select:focus, .fg-3d textarea:focus {
        outline: none; border-color: #1d4ed8; background: #ffffff;
        color: #03251f !important;
        -webkit-text-fill-color: #03251f !important;
        box-shadow: inset 0 2px 4px rgba(0,0,0,.06), 0 0 0 4px rgba(29,78,216,.12), 0 4px 12px rgba(29,78,216,.15);
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

    /* ===== JENIS HAKI BADGE PREVIEW ===== */
    .haki-type-preview {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 14px; margin-top: 10px; border-radius: 11px;
        background: linear-gradient(145deg, rgba(59,130,246,.10), rgba(29,78,216,.05));
        border: 1px solid rgba(59,130,246,.25);
        font-size: 12px; font-weight: 700; color: #1e40af;
        animation: hakiChipPop 0.3s ease-out;
    }
    .haki-type-preview .ht-emoji { font-size: 16px; }
    .haki-type-preview .ht-desc {
        font-size: 11px; color: var(--muted); font-weight: 600;
        margin-left: 4px;
    }

    /* ===== INVENTORS PREVIEW ===== */
    .inventors-preview {
        display: flex; flex-wrap: wrap; gap: 6px;
        margin-top: 8px; min-height: 26px;
    }
    .inventor-chip {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px 4px 4px; border-radius: 999px;
        background: linear-gradient(145deg, rgba(59,130,246,.12), rgba(29,78,216,.06));
        border: 1px solid rgba(59,130,246,.25);
        font-size: 11px; font-weight: 700; color: #1e40af;
        animation: hakiChipPop 0.2s ease-out;
    }
    .inventor-chip .inv-avatar {
        width: 22px; height: 22px; border-radius: 50%;
        background: linear-gradient(145deg, #60a5fa, #3b82f6);
        color: white; font-size: 10px; font-weight: 900;
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display);
    }
    .inventor-chip:first-child {
        background: linear-gradient(145deg, rgba(217,164,65,.15), rgba(217,164,65,.08));
        border-color: rgba(217,164,65,.35); color: #92400e;
    }
    .inventor-chip:first-child .inv-avatar {
        background: linear-gradient(145deg, #fde68a, #d9a441);
    }
    .inventors-count {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 9px; border-radius: 999px;
        background: rgba(59,130,246,.10);
        color: #1d4ed8; font-size: 10px; font-weight: 850;
        font-family: var(--font-display);
    }

    /* ===== PIPELINE INFO INTERAKTIF ===== */
    .pipeline-info-3d {
        display: flex; gap: 8px; flex-wrap: wrap; margin-top: 12px;
        padding: 16px 18px; border-radius: 14px;
        background: linear-gradient(145deg, rgba(59,130,246,.06), rgba(29,78,216,.03));
        border: 1px solid rgba(59,130,246,.2);
        position: relative; overflow: hidden;
    }
    .pipeline-info-3d::before {
        content:''; position:absolute; top:0; right:0;
        width: 120px; height: 120px; border-radius: 50%;
        background: radial-gradient(circle, rgba(59,130,246,.08), transparent 70%);
        pointer-events: none;
    }
    .pipeline-label {
        font-size: 10.5px; font-weight: 900; letter-spacing: .12em;
        color: #1e40af; width: 100%; margin-bottom: 8px;
        display: flex; align-items: center; gap: 6px;
        position: relative; z-index: 1;
    }
    .pipeline-label::after {
        content:''; flex: 1; height: 1px;
        background: linear-gradient(90deg, rgba(59,130,246,.25), transparent);
    }
    .pipeline-steps {
        display: flex; flex-wrap: wrap; gap: 8px; align-items: center;
        position: relative; z-index: 1;
    }
    .pipeline-step-3d {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 999px;
        font-size: 10.5px; font-weight: 800;
        background: rgba(255,255,255,.8);
        border: 1px solid var(--border);
        color: var(--muted);
        transition: all .3s;
    }
    .pipeline-step-3d.past {
        background: linear-gradient(145deg, #d1fae5, #a7f3d0);
        border-color: rgba(16,185,129,.4); color: #065f46;
    }
    .pipeline-step-3d.active {
        background: linear-gradient(145deg, #60a5fa, #3b82f6);
        border-color: transparent; color: white;
        box-shadow: 0 3px 8px rgba(59,130,246,.35);
        animation: hakiPipelinePulse 2s ease-in-out infinite;
    }
    .pipeline-step-3d.current {
        background: linear-gradient(145deg, #fde68a, #d9a441);
        border-color: transparent; color: #03251f;
        box-shadow: 0 3px 8px rgba(217,164,65,.4);
        animation: hakiPipelinePulse 2s ease-in-out infinite;
    }
    .pipeline-step-3d.final.done {
        background: linear-gradient(145deg, #fde68a, #d9a441);
        border-color: transparent; color: #03251f;
        box-shadow: 0 3px 8px rgba(217,164,65,.4);
    }
    .pipeline-arrow { color: var(--muted); font-size: 12px; font-weight: 900; }

    /* ===== REGISTRATION NUMBER STATUS ===== */
    .reg-status {
        display: none; align-items: center; gap: 8px;
        margin-top: 8px; padding: 8px 12px; border-radius: 9px;
        font-size: 11.5px; font-weight: 700;
        animation: hakiChipPop 0.3s ease-out;
    }
    .reg-status.show { display: flex; }
    .reg-status.valid {
        background: linear-gradient(145deg, rgba(16,185,129,.10), rgba(5,150,105,.05));
        border: 1px solid rgba(16,185,129,.3);
        color: #065f46;
    }
    .reg-status.invalid {
        background: linear-gradient(145deg, rgba(220,38,38,.08), rgba(220,38,38,.03));
        border: 1px solid rgba(220,38,38,.25);
        color: #991b1b;
    }
    .reg-status.partial {
        background: linear-gradient(145deg, rgba(242,192,99,.10), rgba(242,192,99,.05));
        border: 1px solid rgba(242,192,99,.3);
        color: #92400e;
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
    .status-preview-3d .sp-dot { width: 8px; height: 8px; border-radius: 50%; }
    .status-preview-3d.draft_internal {
        background: linear-gradient(145deg, rgba(100,116,139,.10), rgba(100,116,139,.05));
        color: #475569; border-color: rgba(100,116,139,.3);
    }
    .status-preview-3d.draft_internal .sp-dot { background: #64748b; }
    .status-preview-3d.review_internal {
        background: linear-gradient(145deg, rgba(242,192,99,.10), rgba(242,192,99,.05));
        color: #92400e; border-color: rgba(242,192,99,.35);
    }
    .status-preview-3d.review_internal .sp-dot {
        background: #f2c063; animation: hakiPipelinePulse 2s ease-in-out infinite;
    }
    .status-preview-3d.diajukan_djki {
        background: linear-gradient(145deg, rgba(59,130,246,.10), rgba(29,78,216,.05));
        color: #1e40af; border-color: rgba(59,130,246,.35);
    }
    .status-preview-3d.diajukan_djki .sp-dot {
        background: #3b82f6; animation: hakiPipelinePulse 2s ease-in-out infinite;
    }
    .status-preview-3d.perbaikan {
        background: linear-gradient(145deg, rgba(234,88,12,.10), rgba(234,88,12,.05));
        color: #7c2d12; border-color: rgba(234,88,12,.35);
    }
    .status-preview-3d.perbaikan .sp-dot {
        background: #ea580c; animation: hakiPipelinePulse 1.5s ease-in-out infinite;
    }
    .status-preview-3d.sertifikat_terbit {
        background: linear-gradient(145deg, rgba(217,164,65,.15), rgba(217,164,65,.08));
        color: #92400e; border-color: rgba(217,164,65,.4);
    }
    .status-preview-3d.sertifikat_terbit .sp-dot {
        background: #d9a441; box-shadow: 0 0 0 3px rgba(217,164,65,.3);
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
        animation: hakiFormShine 3s ease-in-out infinite;
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
        .haki-form-head { padding: 18px 20px; }
        .haki-form-ico { width: 48px; height: 48px; font-size: 22px; }
        .haki-form-title { font-size: 18px; }
        .pipeline-steps { gap: 4px; }
        .pipeline-step-3d { padding: 4px 9px; font-size: 9.5px; }
        .pipeline-arrow { font-size: 10px; }
    }
</style>

<!-- ================= HEADER 3D ================= -->
<div class="haki-form-head">
    <div class="haki-form-ico">🛡️</div>
    <div style="position: relative; z-index: 1; flex: 1; min-width: 0;">
        <h2 class="haki-form-title"><?= $item !== null ? 'Edit HAKI' : 'Tambah HAKI' ?></h2>
        <p class="haki-form-sub">
            <?= $item !== null ? 'Perbarui data kekayaan intelektual.' : 'Daftarkan karya intelektual baru untuk perlindungan hukum.' ?>
        </p>
    </div>
    <span class="haki-form-mode <?= $item !== null ? 'edit' : 'new' ?>">
        <?= $item !== null ? '✎ Edit' : '+ Baru' ?>
    </span>
</div>

<?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= e($action) ?>" id="haki-form">
    <?= csrf_field() ?>
    <?php if ($item !== null): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>

    <!-- SECTION 1: INFORMASI KARYA -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-emoji">📋</span>
            <span>Informasi Karya</span>
            <span class="section-num">BAGIAN 1 / 4</span>
        </h3>

        <div class="fg-3d">
            <label for="f-title">
                <span class="field-ico">✏️</span>
                Judul Karya / Inovasi
                <span class="req-badge">Wajib</span>
            </label>
            <input type="text" id="f-title" name="title"
                   value="<?= e($item['title'] ?? old('title')) ?>"
                   required maxlength="250"
                   placeholder="Contoh: Aplikasi Pembelajaran Bahasa Daerah Berbasis Android"
                   autocomplete="off">
            <div class="field-helper">
                <span class="helper-tip">💡 Judul lengkap karya yang akan didaftarkan (max 250 karakter)</span>
                <span class="field-counter" id="title-counter">0 / 250</span>
            </div>
        </div>

        <div class="form-row-3d">
            <div class="fg-3d">
                <label for="f-type">
                    <span class="field-ico">🏷️</span>
                    Jenis HAKI
                    <span class="req-badge">Wajib</span>
                </label>
                <select id="f-type" name="type" required>
                    <?php foreach (IntellectualProperty::TYPES as $key => $label): ?>
                        <option value="<?= e($key) ?>" <?= ($item['type'] ?? 'hak_cipta') === $key ? 'selected' : '' ?>>
                            <?= e($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="haki-type-preview" id="haki-type-preview">
                    <span class="ht-emoji">©️</span>
                    <span id="haki-type-text">Hak Cipta</span>
                    <span class="ht-desc" id="haki-type-desc">— Karya seni, sastra, ilmu pengetahuan</span>
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
                    <span class="helper-tip">💡 Tahun penciptaan atau pendaftaran</span>
                </div>
                <div class="year-warning" id="year-warning">
                    <span>⚠️</span>
                    <span id="year-warning-text">—</span>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: INVENTOR -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-emoji">👤</span>
            <span>Inventor / Pencipta</span>
            <span class="section-num">BAGIAN 2 / 4</span>
        </h3>

        <div class="fg-3d">
            <label for="f-inventors">
                <span class="field-ico">✍️</span>
                Inventor / Pencipta
                <span class="req-badge">Wajib</span>
            </label>
            <input type="text" id="f-inventors" name="inventors"
                   value="<?= e($item['inventors'] ?? old('inventors')) ?>"
                   required maxlength="500"
                   placeholder="Nama inventor 1, Nama inventor 2, Nama inventor 3"
                   autocomplete="off">
            <div class="field-helper">
                <span class="helper-tip">💡 Pisahkan setiap inventor dengan tanda koma (,)</span>
                <span class="field-counter" id="inventors-counter">0 / 500</span>
            </div>
            <div class="inventors-preview" id="inventors-preview"></div>
        </div>
    </div>

    <!-- SECTION 3: PENDAFTARAN & STATUS -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-emoji">🛡️</span>
            <span>Pendaftaran & Status</span>
            <span class="section-num">BAGIAN 3 / 4</span>
        </h3>

        <div class="form-row-3d">
            <div class="fg-3d">
                <label for="f-regnum">
                    <span class="field-ico">📜</span>
                    No. Pendaftaran / Sertifikat
                    <span class="opt-badge">Opsional</span>
                </label>
                <input type="text" id="f-regnum" name="registration_number"
                       value="<?= e($item['registration_number'] ?? old('registration_number')) ?>"
                       maxlength="50"
                       placeholder="EC002025000123 atau nomor sertifikat"
                       autocomplete="off">
                <div class="field-helper">
                    <span class="helper-tip">💡 Format: EC00YYYYxxxxxx atau nomor sertifikat DJKI</span>
                </div>
                <div class="reg-status" id="reg-status">
                    <span id="reg-status-icon">—</span>
                    <span id="reg-status-text">—</span>
                </div>
            </div>

            <div class="fg-3d">
                <label for="f-status">
                    <span class="field-ico">🚦</span>
                    Status Pipeline
                    <span class="req-badge">Wajib</span>
                </label>
                <select id="f-status" name="status" required>
                    <?php foreach (IntellectualProperty::STATUSES as $key => $label): ?>
                        <option value="<?= e($key) ?>" <?= ($item['status'] ?? 'draft_internal') === $key ? 'selected' : '' ?>>
                            <?= e($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="status-preview-3d draft_internal" id="status-preview">
                    <span class="sp-dot"></span>
                    <span id="status-preview-text">📝 Draft internal, belum direview</span>
                </div>
            </div>
        </div>

        <!-- PIPELINE VISUALIZATION -->
        <div class="pipeline-info-3d">
            <div class="pipeline-label">
                <span>📋 ALUR PENDAFTARAN HAKI</span>
            </div>
            <div class="pipeline-steps">
                <span class="pipeline-step-3d current" data-step="draft_internal">📝 Draft Internal</span>
                <span class="pipeline-arrow">→</span>
                <span class="pipeline-step-3d" data-step="review_internal">🔍 Review Internal</span>
                <span class="pipeline-arrow">→</span>
                <span class="pipeline-step-3d" data-step="diajukan_djki">📤 Diajukan ke DJKI</span>
                <span class="pipeline-arrow">→</span>
                <span class="pipeline-step-3d" data-step="perbaikan">✏️ Perbaikan</span>
                <span class="pipeline-arrow">→</span>
                <span class="pipeline-step-3d final" data-step="sertifikat_terbit">🏅 Sertifikat Terbit</span>
            </div>
        </div>
    </div>

    <!-- SECTION 4: DESKRIPSI -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-emoji">📝</span>
            <span>Deskripsi Karya</span>
            <span class="section-num">BAGIAN 4 / 4</span>
        </h3>

        <div class="fg-3d">
            <label for="f-description">
                <span class="field-ico">📖</span>
                Deskripsi
                <span class="opt-badge">Opsional</span>
            </label>
            <textarea id="f-description" name="description" rows="5"
                      maxlength="3000"
                      placeholder="Jelaskan karya, manfaat, nilai inovasi, dan keunggulan kompetitifnya..."><?= e($item['description'] ?? old('description')) ?></textarea>
            <div class="field-helper">
                <span class="helper-tip">💡 Deskripsi lengkap untuk dokumentasi internal (max 3000 karakter)</span>
                <span class="field-counter" id="desc-counter">0 / 3000</span>
            </div>
        </div>
    </div>

    <!-- ACTIONS -->
    <div class="form-actions-3d">
        <button type="submit" class="btn-save-3d" id="btn-save">
            <?= $item !== null ? '💾 Simpan Perubahan' : '🛡️ Daftarkan HAKI' ?>
        </button>
        <a href="<?= e(url('admin/index.php?page=haki')) ?>" class="btn-cancel-3d">
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
    function getInitials(name) {
        var parts = name.trim().split(/\s+/);
        var first = (parts[0] || '').charAt(0).toUpperCase();
        var last = (parts[parts.length - 1] || '').charAt(0).toUpperCase();
        return (first + (parts.length > 1 ? last : '')).substring(0, 2);
    }

    var HAKI_TYPE_INFO = {
        'hak_cipta': { emoji: '©️', desc: 'Karya seni, sastra, ilmu pengetahuan' },
        'paten': { emoji: '⚙️', desc: 'Invensi di bidang teknologi' },
        'paten_sederhana': { emoji: '🔧', desc: 'Invensi sederhana / utility model' },
        'merek': { emoji: '™️', desc: 'Logo, nama dagang, brand' },
        'desain_industri': { emoji: '🎨', desc: 'Desain tampilan produk' },
        'rahasia_dagang': { emoji: '🔐', desc: 'Informasi rahasia bernilai ekonomi' },
        'indikasi_geografis': { emoji: '🗺️', desc: 'Tanda asal daerah produk' },
        'dtlst': { emoji: '💾', desc: 'Desain tata letak sirkuit terpadu' },
        'pvl': { emoji: '🌱', desc: 'Perlindungan varietas tanaman' }
    };

    var STATUS_ORDER = [
        'draft_internal',
        'review_internal',
        'diajukan_djki',
        'perbaikan',
        'sertifikat_terbit'
    ];

    var STATUS_MESSAGES = {
        'draft_internal': '📝 Draft internal, belum direview',
        'review_internal': '🔍 Sedang direview tim internal LP3M',
        'diajukan_djki': '📤 Sudah diajukan ke DJKI, menunggu verifikasi',
        'perbaikan': '✏️ Perlu perbaikan berdasarkan catatan DJKI',
        'sertifikat_terbit': '🏅 Sertifikat HAKI telah terbit resmi'
    };

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
    attachCounter('f-title', 'title-counter', 250);
    attachCounter('f-inventors', 'inventors-counter', 500);
    attachCounter('f-description', 'desc-counter', 3000);

    // ===== HAKI Type Preview =====
    var typeSelect = document.getElementById('f-type');
    var typeText = document.getElementById('haki-type-text');
    var typeDesc = document.getElementById('haki-type-desc');
    var typeEmoji = document.querySelector('.ht-emoji');

    function updateTypePreview() {
        if (!typeSelect) return;
        var key = typeSelect.value;
        var text = typeSelect.options[typeSelect.selectedIndex].text;
        var info = HAKI_TYPE_INFO[key] || { emoji: '📄', desc: '—' };

        if (typeText) typeText.textContent = text;
        if (typeDesc) typeDesc.textContent = '— ' + info.desc;
        if (typeEmoji) typeEmoji.textContent = info.emoji;
    }
    if (typeSelect) {
        typeSelect.addEventListener('change', updateTypePreview);
        updateTypePreview();
    }

    // ===== Year Validation =====
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
            yearWarningText.textContent = 'Karya ini sudah lebih dari 10 tahun.';
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

    // ===== Inventors Preview =====
    var inventorsInput = document.getElementById('f-inventors');
    var inventorsPreview = document.getElementById('inventors-preview');

    function updateInventorsPreview() {
        if (!inventorsInput || !inventorsPreview) return;
        var val = inventorsInput.value.trim();
        if (!val) { inventorsPreview.innerHTML = ''; return; }

        var parts = val.split(',').map(function(s){ return s.trim(); }).filter(Boolean);
        if (parts.length === 0) { inventorsPreview.innerHTML = ''; return; }

        var html = '';
        parts.forEach(function(name, idx) {
            var initials = getInitials(name);
            html += '<span class="inventor-chip">';
            html += '<span class="inv-avatar">' + initials + '</span>';
            html += '<span>' + name + '</span>';
            html += '</span>';
        });
        html += '<span class="inventors-count">' + parts.length + ' inventor</span>';
        inventorsPreview.innerHTML = html;
    }
    if (inventorsInput) {
        inventorsInput.addEventListener('input', updateInventorsPreview);
        updateInventorsPreview();
    }

    // ===== Registration Number Validator =====
    var regInput = document.getElementById('f-regnum');
    var regStatus = document.getElementById('reg-status');
    var regStatusIcon = document.getElementById('reg-status-icon');
    var regStatusText = document.getElementById('reg-status-text');

    function updateRegStatus() {
        if (!regInput || !regStatus) return;
        var val = regInput.value.trim();

        if (!val) {
            regStatus.classList.remove('show');
            return;
        }

        // Format EC: EC00YYYYxxxxxx (DJKI Hak Cipta)
        var ecMatch = val.match(/^EC(\d{4})(\d{6,})$/);
        if (ecMatch) {
            var year = parseInt(ecMatch[1], 10);
            regStatus.className = 'reg-status show valid';
            regStatusIcon.textContent = '✅';
            regStatusText.textContent = 'Format DJKI Hak Cipta valid · Tahun ' + year;
            return;
        }

        // Format paten: P00YYYYxxxxxx
        var patenMatch = val.match(/^P(\d{2})(\d{4})(\d{5,})$/);
        if (patenMatch) {
            var year = parseInt(patenMatch[2], 10);
            regStatus.className = 'reg-status show valid';
            regStatusIcon.textContent = '✅';
            regStatusText.textContent = 'Format DJKI Paten valid · Tahun ' + year;
            return;
        }

        // Format merek: IDM00xxxxxxxx
        var merekMatch = val.match(/^IDM(\d{7,})$/i);
        if (merekMatch) {
            regStatus.className = 'reg-status show valid';
            regStatusIcon.textContent = '✅';
            regStatusText.textContent = 'Format DJKI Merek valid';
            return;
        }

        // Hanya angka (format sertifikat lama)
        if (/^\d{6,}$/.test(val)) {
            regStatus.className = 'reg-status show partial';
            regStatusIcon.textContent = '📜';
            regStatusText.textContent = 'Format nomor sertifikat (angka)';
            return;
        }

        // Tidak dikenal
        regStatus.className = 'reg-status show invalid';
        regStatusIcon.textContent = '⚠️';
        regStatusText.textContent = 'Format tidak dikenali. Contoh: EC002025000123';
    }
    if (regInput) {
        regInput.addEventListener('input', updateRegStatus);
        regInput.addEventListener('blur', updateRegStatus);
        updateRegStatus();
    }

    // ===== Status Preview + Pipeline Interaktif =====
    var statusSelect = document.getElementById('f-status');
    var statusPreview = document.getElementById('status-preview');
    var statusText = document.getElementById('status-preview-text');
    var pipelineSteps = document.querySelectorAll('.pipeline-step-3d');

    function updatePipeline() {
        if (!statusSelect) return;
        var currentStatus = statusSelect.value;
        var currentIdx = STATUS_ORDER.indexOf(currentStatus);

        // Update preview box
        if (statusPreview) {
            statusPreview.className = 'status-preview-3d ' + currentStatus;
            if (statusText) statusText.textContent = STATUS_MESSAGES[currentStatus] || currentStatus;
        }

        // Update pipeline steps
        pipelineSteps.forEach(function(step) {
            var stepStatus = step.dataset.step;
            var stepIdx = STATUS_ORDER.indexOf(stepStatus);

            step.classList.remove('past', 'active', 'current', 'done');

            if (stepIdx < currentIdx) {
                step.classList.add('past');
            } else if (stepIdx === currentIdx) {
                // Final step (sertifikat terbit) pakai 'current' gold
                if (stepStatus === 'sertifikat_terbit') {
                    step.classList.add('final', 'done');
                } else {
                    step.classList.add('current');
                }
            }
        });
    }
    if (statusSelect) {
        statusSelect.addEventListener('change', updatePipeline);
        updatePipeline();
    }

    // ===== Submit progress =====
    var form = document.getElementById('haki-form');
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