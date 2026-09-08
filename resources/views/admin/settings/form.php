<style>
    @keyframes settingsShine { 0%{transform:translateX(-100%) skewX(-20deg)} 100%{transform:translateX(300%) skewX(-20deg)} }
    @keyframes settingsSpin { from{transform:rotate(0)} to{transform:rotate(360deg)} }
    @keyframes settingsPulse { 0%,100%{opacity:0.6; box-shadow: 0 0 0 0 rgba(16,185,129,0.4);} 50%{opacity:1; box-shadow: 0 0 0 5px rgba(16,185,129,0);} }
    @keyframes settingsFadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }

    /* ===== HEADER 3D ===== */
    .settings-head-3d {
        display: flex; align-items: center; gap: 16px; margin-bottom: 24px;
        padding: 22px 26px; border-radius: 22px;
        background: linear-gradient(135deg, #043b2c 0%, #065f46 55%, #059669 100%);
        color: white; position: relative; overflow: hidden;
        box-shadow: 0 16px 40px rgba(0,0,0,.30);
        animation: settingsFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    .settings-head-3d::before {
        content:''; position:absolute; inset:0;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 25px, rgba(217,164,65,.04) 25px, rgba(217,164,65,.04) 26px),
            repeating-linear-gradient(-45deg, transparent, transparent 25px, rgba(217,164,65,.04) 25px, rgba(217,164,65,.04) 26px);
    }
    .settings-head-3d::after {
        content:''; position:absolute; top:-50%; right:-10%;
        width: 320px; height: 320px; border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,.25), transparent 70%);
        pointer-events: none;
    }
    .settings-gear-3d {
        width: 56px; height: 56px; border-radius: 18px; flex-shrink: 0;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.5), transparent 40%),
                    linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441);
        display: flex; align-items: center; justify-content: center;
        font-size: 28px; position: relative;
        box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -3px 4px rgba(0,0,0,.2), 0 6px 14px rgba(217,164,65,.45);
        animation: settingsSpin 12s linear infinite;
    }
    .settings-gear-3d::before {
        content:''; position:absolute; top:5px; left:11px;
        width:18px; height:8px; border-radius:50%;
        background: rgba(255,255,255,.65); filter: blur(1.5px);
    }
    .settings-title-3d {
        font-family: var(--font-display); font-size: 24px; font-weight: 900;
        letter-spacing: -.02em; margin: 0; position: relative; z-index: 1;
        background: linear-gradient(135deg, #fff 0%, #fde68a 100%);
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .settings-sub-3d { font-size: 12.5px; opacity: .90; margin: 4px 0 0; position: relative; z-index: 1; }
    .settings-progress {
        margin-left: auto; text-align: right; position: relative; z-index: 1; flex-shrink: 0;
    }
    .settings-progress .sp-value {
        font-family: var(--font-display); font-size: 24px; font-weight: 900;
        background: linear-gradient(135deg, #fff, #fde68a);
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1;
    }
    .settings-progress .sp-label {
        font-size: 9.5px; font-weight: 800; letter-spacing: .1em;
        text-transform: uppercase; color: rgba(255,255,255,.7);
        margin-top: 3px;
    }
    .settings-progress .sp-bar {
        width: 100px; height: 5px; border-radius: 999px;
        background: rgba(255,255,255,.15);
        margin-top: 6px; overflow: hidden;
    }
    .settings-progress .sp-bar i {
        display: block; height: 100%; border-radius: 999px;
        background: linear-gradient(90deg, #fde68a, #10b981);
        transition: width .4s;
    }

    /* ===== FLASH 3D ===== */
    .flash-3d {
        position: relative; padding: 14px 18px; margin-bottom: 20px;
        border-radius: 14px; font-size: 13.5px; font-weight: 700;
        display: flex; align-items: center; gap: 10px; overflow: hidden;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.05), 0 4px 12px rgba(0,0,0,.1);
        animation: settingsFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }
    .flash-3d::after {
        content:''; position:absolute; top:0; left:-100%;
        width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent);
        animation: settingsShine 3s ease-in-out infinite;
        pointer-events: none;
    }
    .flash-success-3d { background: linear-gradient(145deg, #d1fae5, #a7f3d0); border: 1px solid rgba(16,185,129,.35); color: #065f46; }
    .flash-error-3d { background: linear-gradient(145deg, #fee2e2, #fecaca); border: 1px solid rgba(220,38,38,.35); color: #991b1b; }

    .settings-layout-3d {
        display: grid; grid-template-columns: 1.4fr 1fr; gap: 24px; align-items: flex-start;
    }
    @media (max-width: 1100px) { .settings-layout-3d { grid-template-columns: 1fr; } }

    /* ===== FORM ===== */
    .settings-form-3d {
        background: var(--white); border: 1px solid var(--border);
        border-radius: 22px; padding: 28px;
        box-shadow: 0 6px 20px rgba(0,0,0,.05);
        animation: settingsFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
        animation-delay: .08s;
    }

    .group-title-3d {
        display: flex; align-items: center; gap: 12px;
        font-family: var(--font-display); font-size: 16px; font-weight: 900;
        color: var(--ink); margin: 28px 0 18px;
        padding-bottom: 12px; border-bottom: 1px dashed var(--border);
    }
    .group-title-3d:first-child { margin-top: 0; }
    .group-ico-3d {
        width: 38px; height: 38px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; flex-shrink: 0; position: relative;
    }
    .group-ico-3d::before {
        content:''; position:absolute; top:3px; left:7px;
        width:13px; height:6px; border-radius:50%;
        background: rgba(255,255,255,.6); filter: blur(1px);
    }
    .gi-gold { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.5), transparent 40%), linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441); box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.2), 0 4px 10px rgba(217,164,65,.35); }
    .gi-emerald { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.4), transparent 40%), linear-gradient(145deg, #34d399, #10b981 50%, #059669); box-shadow: inset 0 2px 3px rgba(255,255,255,.6), inset 0 -2px 3px rgba(0,0,0,.2), 0 4px 10px rgba(5,150,105,.3); }
    .gi-blue { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.4), transparent 40%), linear-gradient(145deg, #60a5fa, #3b82f6 50%, #1d4ed8); box-shadow: inset 0 2px 3px rgba(255,255,255,.6), inset 0 -2px 3px rgba(0,0,0,.2), 0 4px 10px rgba(59,130,246,.3); }
    .gi-purple { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.4), transparent 40%), linear-gradient(145deg, #c4b5fd, #a78bfa 50%, #7c3aed); box-shadow: inset 0 2px 3px rgba(255,255,255,.6), inset 0 -2px 3px rgba(0,0,0,.2), 0 4px 10px rgba(124,58,237,.3); }

    .group-title-3d .group-num {
        margin-left: auto; font-size: 10px; font-weight: 900;
        letter-spacing: .1em; color: var(--muted);
    }

    .fg-3d { margin-bottom: 18px; }
    .fg-3d:last-child { margin-bottom: 0; }

    .fg-3d label {
        display: flex; align-items: center; gap: 8px;
        font-size: 11.5px; font-weight: 850;
        letter-spacing: .08em; text-transform: uppercase;
        color: var(--primary-dark); margin-bottom: 8px;
    }
    .fg-3d label .field-ico {
        display: inline-flex; align-items: center; justify-content: center;
        width: 22px; height: 22px; border-radius: 7px;
        background: linear-gradient(145deg, rgba(16,185,129,.15), rgba(5,150,105,.08));
        font-size: 11px;
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
    .fg-3d input[type="url"],
    .fg-3d textarea,
    .fg-3d select {
        width: 100%; padding: 11px 14px; border-radius: 12px;
        border: 2px solid var(--border);
        background: linear-gradient(145deg, #f6faf7, #ffffff);
        font-size: 13.5px; font-weight: 600;
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
    .fg-3d textarea:-webkit-autofill {
        -webkit-box-shadow: 0 0 0 1000px #f6faf7 inset !important;
        -webkit-text-fill-color: #03251f !important;
        caret-color: #059669 !important;
        transition: background-color 99999s ease-in-out 0s;
        border-color: var(--border) !important;
    }
    .fg-3d textarea { resize: vertical; min-height: 70px; line-height: 1.6; }
    .fg-3d input:focus, .fg-3d textarea:focus {
        outline: none; border-color: #059669; background: #ffffff;
        color: #03251f !important;
        -webkit-text-fill-color: #03251f !important;
        box-shadow: inset 0 2px 4px rgba(0,0,0,.06), 0 0 0 4px rgba(5,150,105,.12), 0 4px 12px rgba(5,150,105,.15);
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

    .form-row-3d { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    @media (max-width: 640px) { .form-row-3d { grid-template-columns: 1fr; } }

    /* ===== IMAGE CARD 3D ===== */
    .img-card-3d {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 16px; margin: 10px 0;
        background: linear-gradient(145deg, #f6faf7, #ffffff);
        border: 1px solid rgba(5,150,105,.25);
        border-radius: 14px;
        box-shadow: inset 0 1px 1px rgba(255,255,255,.9), 0 3px 10px rgba(0,0,0,.05);
    }
    .img-card-3d img {
        width: 64px; height: 64px; object-fit: contain;
        background: #fff; border: 1px solid var(--border);
        border-radius: 10px; padding: 4px;
    }
    .img-card-3d img.favicon { width: 40px; height: 40px; }
    .check-inline-3d {
        display: inline-flex; align-items: center; gap: 6px;
        margin-top: 8px; padding: 5px 11px; border-radius: 8px;
        background: rgba(220,38,38,.06); border: 1px solid rgba(220,38,38,.2);
        color: #991b1b; font-size: 11.5px; font-weight: 700; cursor: pointer;
        transition: all .2s;
    }
    .check-inline-3d:hover {
        background: rgba(220,38,38,.12); border-color: rgba(220,38,38,.35);
        transform: translateY(-1px);
    }
    .check-inline-3d input { accent-color: #dc2626; }

    /* ===== FILE DROPZONE ===== */
    .file-dropzone-3d {
        position: relative; padding: 18px; border-radius: 13px;
        border: 2px dashed rgba(217,164,65,.4);
        background: linear-gradient(145deg, rgba(253,230,138,.06), rgba(217,164,65,.03));
        text-align: center; cursor: pointer;
        transition: all .25s; overflow: hidden;
    }
    .file-dropzone-3d:hover {
        border-color: #059669;
        background: linear-gradient(145deg, rgba(16,185,129,.08), rgba(5,150,105,.04));
        transform: translateY(-1px);
    }
    .file-dropzone-3d input[type="file"] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer;
    }
    .file-dropzone-3d span { font-size: 12px; font-weight: 700; color: var(--primary-dark); }
    .file-dropzone-3d small { display: block; font-size: 10.5px; color: var(--muted); margin-top: 3px; }

    /* ===== STRUCTURE / MISSION PREVIEW ===== */
    .mission-preview, .structure-preview {
        margin-top: 10px; padding: 12px 16px; border-radius: 11px;
        background: linear-gradient(145deg, rgba(5,150,105,.06), rgba(5,150,105,.02));
        border: 1px solid rgba(5,150,105,.2);
        font-size: 12px; min-height: 40px;
    }
    .mission-preview .mp-head, .structure-preview .sp-head {
        font-size: 10px; font-weight: 900; letter-spacing: .1em;
        text-transform: uppercase; color: var(--primary-dark);
        margin-bottom: 8px;
    }
    .mission-preview ul {
        list-style: none; padding: 0; margin: 0;
    }
    .mission-preview ul li {
        position: relative; padding-left: 18px; margin-bottom: 4px;
        color: #374151; line-height: 1.5;
    }
    .mission-preview ul li::before {
        content: '✓';
        position: absolute; left: 0; top: 0;
        color: #10b981; font-weight: 900;
    }
    .mission-preview ul li.empty {
        color: var(--muted); font-style: italic; padding-left: 0;
    }
    .mission-preview ul li.empty::before { display: none; }

    .structure-preview .struct-item {
        display: flex; align-items: center; gap: 10px;
        padding: 6px 0; border-bottom: 1px dashed rgba(5,150,105,.15);
    }
    .structure-preview .struct-item:last-child { border-bottom: none; }
    .structure-preview .struct-avatar {
        width: 26px; height: 26px; border-radius: 50%;
        background: linear-gradient(145deg, #34d399, #10b981);
        color: white; font-size: 10px; font-weight: 900;
        font-family: var(--font-display);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .structure-preview .struct-info { flex: 1; min-width: 0; }
    .structure-preview .struct-name {
        font-size: 12px; font-weight: 800; color: var(--ink);
    }
    .structure-preview .struct-role {
        font-size: 10px; color: var(--primary-dark); font-weight: 600;
    }
    .structure-preview .struct-empty {
        color: var(--muted); font-style: italic; font-size: 12px;
    }

    .structure-warning {
        display: flex; align-items: center; gap: 8px;
        padding: 8px 12px; margin-top: 8px; border-radius: 9px;
        background: linear-gradient(145deg, rgba(220,38,38,.08), rgba(220,38,38,.03));
        border: 1px solid rgba(220,38,38,.25);
        color: #991b1b; font-size: 11px; font-weight: 700;
    }

    /* ===== SAVE BUTTON 3D ===== */
    .form-actions-3d {
        display: flex; gap: 12px; flex-wrap: wrap; align-items: center;
        margin-top: 28px; padding-top: 20px;
        border-top: 1px dashed var(--border);
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
        animation: settingsShine 3s ease-in-out infinite;
        pointer-events: none;
    }
    .btn-save-3d:hover {
        transform: translateY(-2px);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.8), 0 14px 30px rgba(217,164,65,.55);
    }
    .btn-save-3d:active { transform: translateY(0); }
    .btn-save-3d:disabled { opacity: .6; cursor: not-allowed; }

    .form-actions-spacer { flex: 1; }
    .form-tip-box {
        display: flex; align-items: center; gap: 8px;
        padding: 8px 12px; border-radius: 10px;
        background: linear-gradient(145deg, rgba(217,164,65,.08), rgba(217,164,65,.04));
        border: 1px solid rgba(217,164,65,.2);
        font-size: 11px; color: #92400e; font-weight: 600;
    }

    /* ===== LIVE PREVIEW MINI-BROWSER 3D ===== */
    .preview-panel-3d {
        position: sticky; top: 20px;
        background: var(--white); border: 1px solid var(--border);
        border-radius: 22px; padding: 22px;
        box-shadow: 0 6px 20px rgba(0,0,0,.05);
        animation: settingsFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
        animation-delay: .16s;
    }
    .pv-title-3d {
        display: flex; align-items: center; gap: 8px;
        font-family: var(--font-display); font-size: 14px; font-weight: 900;
        color: var(--ink); margin: 0 0 16px;
    }
    .pv-live-dot {
        width: 10px; height: 10px; border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #6ee7b7, #10b981);
        box-shadow: 0 0 8px rgba(16,185,129,.6);
        animation: settingsPulse 2s ease-in-out infinite;
    }

    .pv-browser-3d {
        border-radius: 14px; overflow: hidden;
        border: 1px solid var(--border);
        box-shadow: 0 8px 24px rgba(0,0,0,.08);
        background: #f9fafb;
    }
    .pv-bar-3d {
        display: flex; align-items: center; gap: 10px;
        padding: 8px 12px;
        background: linear-gradient(145deg, #1f2937, #111827);
        border-bottom: 1px solid rgba(0,0,0,.2);
    }
    .pv-lights { display: flex; gap: 5px; }
    .pv-light {
        width: 11px; height: 11px; border-radius: 50%;
        box-shadow: inset 0 1px 1px rgba(255,255,255,.3), 0 1px 2px rgba(0,0,0,.3);
    }
    .pl-red { background: radial-gradient(circle at 30% 30%, #fca5a5, #dc2626); }
    .pl-yellow { background: radial-gradient(circle at 30% 30%, #fde68a, #d9a441); }
    .pl-green { background: radial-gradient(circle at 30% 30%, #86efac, #16a34a); }

    .pv-url-3d {
        flex: 1; padding: 4px 10px; border-radius: 6px;
        background: rgba(255,255,255,.1);
        font-size: 10px; color: rgba(255,255,255,.7);
        font-family: 'Courier New', monospace;
        display: flex; align-items: center; gap: 6px;
    }
    .pv-url-3d::before { content: '🔒'; font-size: 9px; }
    .pv-favicon-3d { width: 12px; height: 12px; object-fit: contain; }

    .pv-header-3d {
        display: flex; align-items: center; gap: 8px;
        padding: 10px 14px;
        background: linear-gradient(145deg, #043b2c, #065f46);
        border-bottom: 1px solid rgba(255,255,255,.1);
    }
    .pv-logo-3d {
        width: 26px; height: 26px; object-fit: contain;
        border-radius: 6px; background: white; padding: 2px;
    }
    .pv-brand-3d {
        font-size: 12px; font-weight: 800; color: #fde68a;
        font-family: var(--font-display); letter-spacing: -.01em;
    }

    .pv-hero-3d {
        padding: 18px 14px; text-align: center;
        background: linear-gradient(135deg, rgba(5,150,105,.05), rgba(217,164,65,.05));
        border-bottom: 1px solid var(--border);
    }
    .pv-hero-3d h5 {
        font-family: var(--font-display); font-size: 14px; font-weight: 900;
        color: var(--ink); margin: 0 0 4px; letter-spacing: -.01em;
    }
    .pv-hero-3d p { font-size: 10px; color: var(--muted); margin: 0 0 8px; line-height: 1.4; }
    .pv-hero-btn-3d {
        display: inline-block; padding: 4px 10px; border-radius: 6px;
        background: linear-gradient(145deg, #fde68a, #d9a441);
        color: #03251f; font-size: 9px; font-weight: 800;
        box-shadow: inset 0 1px 1px rgba(255,255,255,.6), 0 2px 5px rgba(217,164,65,.3);
    }

    .pv-section-3d {
        padding: 12px 14px;
        border-bottom: 1px solid var(--border);
    }
    .pv-section-3d h6 {
        font-size: 11px; font-weight: 800; color: var(--ink);
        margin: 0 0 8px; text-align: center;
        font-family: var(--font-display);
    }
    .pv-cards-3d {
        display: grid; grid-template-columns: 1fr 1fr; gap: 6px;
    }
    .pv-card-3d {
        padding: 7px 8px; border-radius: 7px;
        background: white; border: 1px solid var(--border);
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
    }
    .pv-card-3d b {
        display: block; font-size: 10px; color: var(--ink);
        margin-bottom: 2px; line-height: 1.2;
    }
    .pv-card-3d span {
        display: block; font-size: 8px; color: var(--muted);
        line-height: 1.3; max-height: 22px; overflow: hidden;
    }

    .pv-footer-3d {
        padding: 10px 14px; text-align: center;
        background: linear-gradient(145deg, #043b2c, #065f46);
        color: rgba(255,255,255,.85); font-size: 9px;
        line-height: 1.4;
    }

    .pv-note-3d {
        display: flex; align-items: flex-start; gap: 8px;
        margin-top: 14px; padding: 10px 12px;
        background: linear-gradient(145deg, rgba(253,230,138,.08), rgba(217,164,65,.04));
        border: 1px solid rgba(217,164,65,.2);
        border-radius: 10px;
        font-size: 11px; color: #92400e; line-height: 1.5;
    }
    .pv-note-3d::before { content: '💡'; flex-shrink: 0; }

    /* ===== AUTOSAVE INDICATOR ===== */
    .autosave-indicator {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 10px; border-radius: 999px;
        font-size: 10px; font-weight: 800; letter-spacing: .05em;
        background: rgba(100,116,139,.08);
        color: var(--muted);
        transition: all .3s;
    }
    .autosave-indicator.saving {
        background: rgba(242,192,99,.12);
        color: #92400e;
    }
    .autosave-indicator.saved {
        background: rgba(16,185,129,.12);
        color: #065f46;
    }

    @media (max-width: 640px) {
        .settings-head-3d { padding: 18px 20px; flex-wrap: wrap; }
        .settings-progress { margin-left: 0; margin-top: 10px; width: 100%; }
        .settings-progress .sp-bar { margin: 6px auto 0; }
    }
</style>

<!-- ================= HEADER 3D ================= -->
<div class="settings-head-3d">
    <div class="settings-gear-3d">⚙️</div>
    <div style="position: relative; z-index: 1; flex: 1; min-width: 0;">
        <h2 class="settings-title-3d">Pengaturan Website</h2>
        <p class="settings-sub-3d">Atur konten publik. Perubahan tampil di website setelah disimpan.</p>
    </div>
    <div class="settings-progress">
        <div class="sp-value"><span id="progress-value">0</span>%</div>
        <div class="sp-label">Form Completion</div>
        <div class="sp-bar"><i id="progress-bar" style="width: 0%;"></i></div>
    </div>
</div>

<?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<div class="settings-layout-3d">

    <!-- FORM -->
    <form method="post" enctype="multipart/form-data"
          action="<?= e(url('admin/index.php?page=pengaturan-simpan')) ?>"
          class="settings-form-3d" id="settings-form">
        <?= csrf_field() ?>

        <!-- ===== BRANDING ===== -->
        <h3 class="group-title-3d">
            <div class="group-ico-3d gi-gold">💎</div>
            <span>Branding</span>
            <span class="group-num">BAGIAN 1 / 4</span>
        </h3>

        <div class="fg-3d">
            <label>
                <span class="field-ico">✏️</span>
                Nama / Brand Website
            </label>
            <input type="text" name="site_brand" value="<?= e($s['site_brand']) ?>"
                   data-pv="pv-brand" maxlength="100" autocomplete="off">
            <div class="field-helper">
                <span class="helper-tip">💡 Nama yang tampil di header website</span>
                <span class="field-counter" id="site_brand-counter">0 / 100</span>
            </div>
        </div>

        <div class="form-row-3d">
            <div class="fg-3d">
                <label>
                    <span class="field-ico">🖼️</span>
                    Logo (header)
                    <span class="opt-badge">Opsional</span>
                </label>
                <div class="file-dropzone-3d">
                    <input type="file" name="logo" id="input-logo" accept=".jpg,.jpeg,.png,.webp">
                    <span>📤 Klik untuk upload logo</span>
                    <small>JPG/PNG/WEBP, maks 1 MB</small>
                </div>

                <?php if (!empty($s['logo_path'])): ?>
                    <div class="img-card-3d">
                        <img src="<?= e(upload_url($s['logo_path'])) ?>" alt="Logo">
                        <div>
                            <p style="margin: 0; font-size: 12px; font-weight: 800; color: var(--ink);">Logo saat ini</p>
                            <p style="margin: 2px 0 0; font-size: 11px; color: var(--muted);">Akan diganti jika upload baru</p>
                        </div>
                    </div>
                    <label class="check-inline-3d">
                        <input type="checkbox" name="remove_logo" value="1" id="remove-logo">
                        🗑️ Hapus logo
                    </label>
                <?php endif; ?>
            </div>

            <div class="fg-3d">
                <label>
                    <span class="field-ico">🔖</span>
                    Favicon
                    <span class="opt-badge">Opsional</span>
                </label>
                <div class="file-dropzone-3d">
                    <input type="file" name="favicon" id="input-favicon" accept=".png,.ico">
                    <span>📤 Klik untuk upload favicon</span>
                    <small>PNG/ICO, maks 1 MB</small>
                </div>

                <?php if (!empty($s['favicon_path'])): ?>
                    <div class="img-card-3d">
                        <img src="<?= e(upload_url($s['favicon_path'])) ?>" alt="Favicon" class="favicon">
                        <div>
                            <p style="margin: 0; font-size: 12px; font-weight: 800; color: var(--ink);">Favicon saat ini</p>
                            <p style="margin: 2px 0 0; font-size: 11px; color: var(--muted);">Akan diganti jika upload baru</p>
                        </div>
                    </div>
                    <label class="check-inline-3d">
                        <input type="checkbox" name="remove_favicon" value="1" id="remove-favicon">
                        🗑️ Hapus favicon
                    </label>
                <?php endif; ?>
            </div>
        </div>

        <!-- ===== BERANDA PUBLIC ===== -->
        <h3 class="group-title-3d">
            <div class="group-ico-3d gi-emerald">🏠</div>
            <span>Beranda Public</span>
            <span class="group-num">BAGIAN 2 / 4</span>
        </h3>

        <div class="fg-3d">
            <label>
                <span class="field-ico">🎯</span>
                Judul Hero
            </label>
            <input type="text" name="home_hero_title" value="<?= e($s['home_hero_title']) ?>"
                   data-pv="pv-hero-title" maxlength="150" autocomplete="off">
            <div class="field-helper">
                <span class="helper-tip">💡 Headline utama halaman beranda</span>
                <span class="field-counter" id="hero_title-counter">0 / 150</span>
            </div>
        </div>

        <div class="fg-3d">
            <label>
                <span class="field-ico">📖</span>
                Teks Hero
            </label>
            <textarea name="home_hero_text" rows="3" data-pv="pv-hero-text"
                      maxlength="300"><?= e($s['home_hero_text']) ?></textarea>
            <div class="field-helper">
                <span class="helper-tip">💡 Sub-headline yang mendukung judul</span>
                <span class="field-counter" id="hero_text-counter">0 / 300</span>
            </div>
        </div>

        <div class="form-row-3d">
            <div class="fg-3d">
                <label>
                    <span class="field-ico">🔘</span>
                    Teks Tombol Hero
                </label>
                <input type="text" name="home_hero_button_text" value="<?= e($s['home_hero_button_text']) ?>"
                       data-pv="pv-hero-btn" maxlength="30" autocomplete="off">
            </div>
            <div class="fg-3d">
                <label>
                    <span class="field-ico">📋</span>
                    Judul Section Modul
                </label>
                <input type="text" name="home_section_title" value="<?= e($s['home_section_title']) ?>"
                       data-pv="pv-section-title" maxlength="100" autocomplete="off">
            </div>
        </div>

        <?php for ($i = 1; $i <= 4; $i++): ?>
            <div class="form-row-3d">
                <div class="fg-3d">
                    <label>
                        <span class="field-ico"><?= ['1️⃣','2️⃣','3️⃣','4️⃣'][$i-1] ?></span>
                        Judul Kartu <?= $i ?>
                    </label>
                    <input type="text" name="home_card<?= $i ?>_title" value="<?= e($s['home_card' . $i . '_title']) ?>"
                           data-pv="pv-c<?= $i ?>-title" maxlength="60" autocomplete="off">
                </div>
                <div class="fg-3d">
                    <label>
                        <span class="field-ico">📝</span>
                        Teks Kartu <?= $i ?>
                    </label>
                    <textarea name="home_card<?= $i ?>_text" rows="2"
                              data-pv="pv-c<?= $i ?>-text" maxlength="200"><?= e($s['home_card' . $i . '_text']) ?></textarea>
                </div>
            </div>
        <?php endfor; ?>

        <!-- ===== FOOTER ===== -->
        <h3 class="group-title-3d">
            <div class="group-ico-3d gi-blue">📍</div>
            <span>Footer</span>
            <span class="group-num">BAGIAN 3 / 4</span>
        </h3>

        <div class="fg-3d">
            <label>
                <span class="field-ico">📄</span>
                Teks Footer
            </label>
            <textarea name="footer_text" rows="2" data-pv="pv-footer"
                      maxlength="500"><?= e($s['footer_text']) ?></textarea>
            <div class="field-helper">
                <span class="helper-tip">💡 Copyright & informasi kontak</span>
                <span class="field-counter" id="footer-counter">0 / 500</span>
            </div>
        </div>

        <!-- ===== TENTANG ===== -->
        <h3 class="group-title-3d">
            <div class="group-ico-3d gi-purple">📄</div>
            <span>Halaman Tentang</span>
            <span class="group-num">BAGIAN 4 / 4</span>
        </h3>

        <div class="fg-3d">
            <label>
                <span class="field-ico">🎯</span>
                Judul Hero Tentang
            </label>
            <input type="text" name="about_hero_title" value="<?= e($s['about_hero_title']) ?>"
                   maxlength="100" autocomplete="off">
        </div>
        <div class="fg-3d">
            <label>
                <span class="field-ico">📖</span>
                Teks Hero Tentang
            </label>
            <textarea name="about_hero_text" rows="3" maxlength="500"><?= e($s['about_hero_text']) ?></textarea>
        </div>
        <div class="fg-3d">
            <label>
                <span class="field-ico">🏢</span>
                Profil Lembaga
            </label>
            <textarea name="about_profile_text" rows="5" maxlength="2000"><?= e($s['about_profile_text']) ?></textarea>
            <div class="field-helper">
                <span class="helper-tip">💡 Deskripsi singkat lembaga</span>
                <span class="field-counter" id="profile-counter">0 / 2000</span>
            </div>
        </div>
        <div class="fg-3d">
            <label>
                <span class="field-ico">📜</span>
                Sejarah
            </label>
            <textarea name="about_history_text" rows="5" maxlength="3000"><?= e($s['about_history_text']) ?></textarea>
            <div class="field-helper">
                <span class="helper-tip">💡 Sejarah berdirinya lembaga</span>
                <span class="field-counter" id="history-counter">0 / 3000</span>
            </div>
        </div>
        <div class="fg-3d">
            <label>
                <span class="field-ico">🔭</span>
                Visi
            </label>
            <textarea name="about_vision_text" rows="3" maxlength="500"><?= e($s['about_vision_text']) ?></textarea>
            <div class="field-helper">
                <span class="helper-tip">💡 Visi jangka panjang lembaga</span>
                <span class="field-counter" id="vision-counter">0 / 500</span>
            </div>
        </div>
        <div class="fg-3d">
            <label>
                <span class="field-ico">🎯</span>
                Misi
            </label>
            <textarea name="about_mission_text" rows="6" maxlength="2000"
                      id="mission-input"><?= e($s['about_mission_text']) ?></textarea>
            <div class="field-helper">
                <span class="helper-tip">💡 Satu butir misi per baris</span>
                <span class="field-counter" id="mission-counter">0 / 2000</span>
            </div>
            <div class="mission-preview">
                <div class="mp-head">📋 Preview Misi</div>
                <ul id="mission-list">
                    <li class="empty">Mulai mengetik untuk melihat preview...</li>
                </ul>
            </div>
        </div>
        <div class="fg-3d">
            <label>
                <span class="field-ico">👥</span>
                Struktur Organisasi
            </label>
            <textarea name="about_structure_text" rows="6" maxlength="2000"
                      id="structure-input"><?= e($s['about_structure_text']) ?></textarea>
            <div class="field-helper">
                <span class="helper-tip">💡 Format: <code style="background:rgba(217,164,65,.15);padding:1px 6px;border-radius:4px;color:#92400e;font-size:10.5px;">Jabatan | Nama</code></span>
                <span class="field-counter" id="structure-counter">0 / 2000</span>
            </div>
            <div class="structure-preview">
                <div class="sp-head">👥 Preview Struktur</div>
                <div id="structure-list">
                    <div class="struct-empty">Mulai mengetik untuk melihat preview...</div>
                </div>
            </div>
            <div class="structure-warning" id="structure-warning" style="display:none;">
                <span>⚠️</span>
                <span id="structure-warning-text">—</span>
            </div>
        </div>

        <!-- ACTIONS -->
        <div class="form-actions-3d">
            <button type="submit" class="btn-save-3d" id="btn-save">
                💾 Simpan Pengaturan
            </button>
            <span class="form-actions-spacer"></span>
            <span class="autosave-indicator" id="autosave-indicator">
                💾 Draft disimpan
            </span>
            <span class="form-tip-box">
                ⌨️ Ctrl+S untuk simpan cepat
            </span>
        </div>
    </form>

    <!-- PREVIEW PANEL -->
    <aside class="preview-panel-3d">
        <h3 class="pv-title-3d">
            <span class="pv-live-dot"></span>
            Live Preview
        </h3>

        <div class="pv-browser-3d">
            <!-- Browser bar -->
            <div class="pv-bar-3d">
                <div class="pv-lights">
                    <span class="pv-light pl-red"></span>
                    <span class="pv-light pl-yellow"></span>
                    <span class="pv-light pl-green"></span>
                </div>
                <div class="pv-url-3d">
                    <?php if (!empty($s['favicon_path'])): ?>
                        <img id="pv-favicon" class="pv-favicon-3d" src="<?= e(upload_url($s['favicon_path'])) ?>" alt="">
                    <?php endif; ?>
                    <span>localhost/lp3m</span>
                </div>
            </div>

            <!-- Mini header -->
            <div class="pv-header-3d">
                <?php if (!empty($s['logo_path'])): ?>
                    <img id="pv-logo" class="pv-logo-3d" src="<?= e(upload_url($s['logo_path'])) ?>" alt="">
                <?php endif; ?>
                <span class="pv-brand-3d" id="pv-brand"><?= e($s['site_brand']) ?></span>
            </div>

            <!-- Mini hero -->
            <div class="pv-hero-3d">
                <h5 id="pv-hero-title"><?= e($s['home_hero_title']) ?></h5>
                <p id="pv-hero-text"><?= e(excerpt($s['home_hero_text'], 60)) ?></p>
                <span class="pv-hero-btn-3d" id="pv-hero-btn"><?= e($s['home_hero_button_text']) ?></span>
            </div>

            <!-- Mini section -->
            <div class="pv-section-3d">
                <h6 id="pv-section-title"><?= e($s['home_section_title']) ?></h6>
                <div class="pv-cards-3d">
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <div class="pv-card-3d">
                            <b id="pv-c<?= $i ?>-title"><?= e($s['home_card' . $i . '_title']) ?></b>
                            <span id="pv-c<?= $i ?>-text"><?= e(excerpt($s['home_card' . $i . '_text'], 25)) ?></span>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Mini footer -->
            <div class="pv-footer-3d" id="pv-footer"><?= e(excerpt($s['footer_text'], 70)) ?></div>
        </div>

        <div class="pv-note-3d">
            Preview berubah otomatis saat kamu mengetik. Perubahan tampil di website publik setelah klik <strong>Simpan Pengaturan</strong>.
        </div>
    </aside>

</div>

<script>
(function(){
    // ===== Character counter =====
    function attachCounter(name, counterId, max) {
        var input = document.querySelector('[name="' + name + '"]');
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
    attachCounter('site_brand', 'site_brand-counter', 100);
    attachCounter('home_hero_title', 'hero_title-counter', 150);
    attachCounter('home_hero_text', 'hero_text-counter', 300);
    attachCounter('footer_text', 'footer-counter', 500);
    attachCounter('about_profile_text', 'profile-counter', 2000);
    attachCounter('about_history_text', 'history-counter', 3000);
    attachCounter('about_vision_text', 'vision-counter', 500);
    attachCounter('about_mission_text', 'mission-counter', 2000);
    attachCounter('about_structure_text', 'structure-counter', 2000);

    // ===== Live preview sync =====
    var form = document.getElementById('settings-form');
    if (!form) return;

    function sync(input) {
        var targetId = input.dataset.pv;
        if (!targetId) return;
        var target = document.getElementById(targetId);
        if (!target) return;
        // Handle excerpt untuk text panjang
        var val = input.value;
        if (targetId === 'pv-hero-text' && val.length > 60) {
            val = val.substring(0, 57) + '...';
        } else if (targetId === 'pv-footer' && val.length > 70) {
            val = val.substring(0, 67) + '...';
        } else if (targetId.match(/^pv-c\d+-text$/) && val.length > 25) {
            val = val.substring(0, 22) + '...';
        }
        target.textContent = val;
    }

    form.querySelectorAll('[data-pv]').forEach(function(input) {
        input.addEventListener('input', function() { sync(input); });
        sync(input);
    });

    // ===== Logo preview =====
    var logoInput = document.getElementById('input-logo');
    var logoPreview = document.getElementById('pv-logo');
    if (logoInput) {
        logoInput.addEventListener('change', function(e) {
            var f = e.target.files[0];
            if (f && logoPreview) {
                var r = new FileReader();
                r.onload = function(ev) {
                    logoPreview.src = ev.target.result;
                    logoPreview.style.display = 'block';
                };
                r.readAsDataURL(f);
            }
        });
    }

    // ===== Favicon preview =====
    var favInput = document.getElementById('input-favicon');
    var favPreview = document.getElementById('pv-favicon');
    if (favInput && favPreview) {
        favInput.addEventListener('change', function(e) {
            var f = e.target.files[0];
            if (f) {
                var r = new FileReader();
                r.onload = function(ev) { favPreview.src = ev.target.result; };
                r.readAsDataURL(f);
            }
        });
    }

    // ===== Mission preview =====
    var missionInput = document.getElementById('mission-input');
    var missionList = document.getElementById('mission-list');
    if (missionInput && missionList) {
        function updateMissionPreview() {
            var val = missionInput.value.trim();
            if (!val) {
                missionList.innerHTML = '<li class="empty">Mulai mengetik untuk melihat preview...</li>';
                return;
            }
            var lines = val.split('\n').filter(function(l){ return l.trim() !== ''; });
            if (lines.length === 0) {
                missionList.innerHTML = '<li class="empty">Mulai mengetik untuk melihat preview...</li>';
                return;
            }
            var html = '';
            lines.forEach(function(line) {
                html += '<li>' + line.trim() + '</li>';
            });
            missionList.innerHTML = html;
        }
        missionInput.addEventListener('input', updateMissionPreview);
        updateMissionPreview();
    }

    // ===== Structure preview + validator =====
    var structureInput = document.getElementById('structure-input');
    var structureList = document.getElementById('structure-list');
    var structureWarning = document.getElementById('structure-warning');
    var structureWarningText = document.getElementById('structure-warning-text');

    function getInitials(name) {
        var parts = name.trim().split(/\s+/);
        var first = (parts[0] || '').charAt(0).toUpperCase();
        var last = (parts[parts.length - 1] || '').charAt(0).toUpperCase();
        return (first + (parts.length > 1 ? last : '')).substring(0, 2);
    }

    if (structureInput && structureList) {
        function updateStructurePreview() {
            var val = structureInput.value.trim();
            if (!val) {
                structureList.innerHTML = '<div class="struct-empty">Mulai mengetik untuk melihat preview...</div>';
                structureWarning.style.display = 'none';
                return;
            }

            var lines = val.split('\n').filter(function(l){ return l.trim() !== ''; });
            if (lines.length === 0) {
                structureList.innerHTML = '<div class="struct-empty">Mulai mengetik untuk melihat preview...</div>';
                structureWarning.style.display = 'none';
                return;
            }

            var html = '';
            var invalidLines = [];

            lines.forEach(function(line, idx) {
                if (!line.includes('|')) {
                    invalidLines.push(idx + 1);
                    return;
                }
                var parts = line.split('|').map(function(p){ return p.trim(); });
                if (parts.length < 2 || parts[0] === '' || parts[1] === '') {
                    invalidLines.push(idx + 1);
                    return;
                }
                var jabatan = parts[0];
                var nama = parts[1];
                var initials = getInitials(nama);

                html += '<div class="struct-item">';
                html += '<div class="struct-avatar">' + initials + '</div>';
                html += '<div class="struct-info">';
                html += '<div class="struct-name">' + nama + '</div>';
                html += '<div class="struct-role">' + jabatan + '</div>';
                html += '</div>';
                html += '</div>';
            });

            structureList.innerHTML = html;

            if (invalidLines.length > 0) {
                structureWarningText.textContent = 'Baris ' + invalidLines.join(', ') + ' tidak valid. Gunakan format: Jabatan | Nama';
                structureWarning.style.display = 'flex';
            } else {
                structureWarning.style.display = 'none';
            }
        }
        structureInput.addEventListener('input', updateStructurePreview);
        updateStructurePreview();
    }

    // ===== Progress indicator =====
    var progressValue = document.getElementById('progress-value');
    var progressBar = document.getElementById('progress-bar');
    var trackedFields = [
        'site_brand', 'home_hero_title', 'home_hero_text',
        'home_hero_button_text', 'home_section_title',
        'home_card1_title', 'home_card1_text',
        'home_card2_title', 'home_card2_text',
        'home_card3_title', 'home_card3_text',
        'home_card4_title', 'home_card4_text',
        'footer_text',
        'about_hero_title', 'about_hero_text',
        'about_profile_text', 'about_history_text',
        'about_vision_text', 'about_mission_text',
        'about_structure_text'
    ];

    function updateProgress() {
        var filled = 0;
        trackedFields.forEach(function(name) {
            var input = form.querySelector('[name="' + name + '"]');
            if (input && input.value.trim() !== '') filled++;
        });
        var pct = Math.round((filled / trackedFields.length) * 100);
        if (progressValue) progressValue.textContent = pct;
        if (progressBar) progressBar.style.width = pct + '%';
    }

    trackedFields.forEach(function(name) {
        var input = form.querySelector('[name="' + name + '"]');
        if (input) {
            input.addEventListener('input', updateProgress);
        }
    });
    updateProgress();

    // ===== Auto-save draft =====
    var STORAGE_KEY = 'lp3m_settings_draft_v1';
    var autosaveIndicator = document.getElementById('autosave-indicator');
    var autosaveTimeout;

    function showAutosaveState(state, text) {
        if (!autosaveIndicator) return;
        autosaveIndicator.className = 'autosave-indicator ' + state;
        autosaveIndicator.textContent = text;
    }

    // Load draft
    var savedDraft = localStorage.getItem(STORAGE_KEY);
    if (savedDraft) {
        try {
            var draft = JSON.parse(savedDraft);
            var restored = false;
            trackedFields.forEach(function(name) {
                var input = form.querySelector('[name="' + name + '"]');
                if (input && draft[name] && input.value === '') {
                    input.value = draft[name];
                    input.dispatchEvent(new Event('input', { bubbles: true }));
                    restored = true;
                }
            });
            if (restored) {
                setTimeout(function(){
                    showAutosaveState('saved', '💾 Draft dipulihkan');
                    setTimeout(function(){
                        showAutosaveState('', '💾 Draft disimpan');
                    }, 3000);
                }, 500);
            }
        } catch (e) {
            localStorage.removeItem(STORAGE_KEY);
        }
    }

    // Save draft (debounced)
    function saveDraft() {
        var draft = {};
        trackedFields.forEach(function(name) {
            var input = form.querySelector('[name="' + name + '"]');
            if (input && input.value.trim() !== '') {
                draft[name] = input.value;
            }
        });
        if (Object.keys(draft).length > 0) {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(draft));
            showAutosaveState('saved', '💾 Draft tersimpan');
        }
    }

    form.addEventListener('input', function() {
        clearTimeout(autosaveTimeout);
        showAutosaveState('saving', '⏳ Menyimpan draft...');
        autosaveTimeout = setTimeout(saveDraft, 2000);
    });

    // Clear draft on submit
    form.addEventListener('submit', function() {
        localStorage.removeItem(STORAGE_KEY);
        var btnSave = document.getElementById('btn-save');
        if (btnSave) {
            btnSave.disabled = true;
            btnSave.textContent = '⏳ Menyimpan...';
        }
    });

    // ===== Keyboard shortcut Ctrl+S =====
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
            e.preventDefault();
            form.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
            form.submit();
        }
    });
})();
</script>