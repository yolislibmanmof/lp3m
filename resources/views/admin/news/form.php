<?php
// SVG Icon Helper inline untuk konsistensi
function renderNewsFormIcon($name, $size = 16, $color = 'currentColor') {
    $icons = [
        'edit' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
        'file-text' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>',
        'link' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>',
        'tag' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>',
        'activity' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>',
        'star' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>',
        'camera' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>',
        'image' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>',
        'type' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="4 7 4 4 20 4 20 7"></polyline><line x1="9" y1="20" x2="15" y2="20"></line><line x1="12" y1="4" x2="12" y2="20"></line></svg>',
        'save' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>',
        'rocket' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path><path d="M12 15l-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path></svg>',
        'x' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>',
        'info' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>',
        'alert' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>',
        'check' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>',
        'refresh' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>',
        'upload' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>',
        'clock' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
        'clipboard' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>',
        'shield' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
        'eye' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>',
        'hash' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><line x1="4" y1="9" x2="20" y2="9"></line><line x1="4" y1="15" x2="20" y2="15"></line><line x1="10" y1="3" x2="8" y2="21"></line><line x1="16" y1="3" x2="14" y2="21"></line></svg>',
        'chevron-down' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>',
        'dot' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="'.$color.'" viewBox="0 0 24 24"><circle cx="12" cy="12" r="6"></circle></svg>',
        'trash' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',
        'package' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>',
    ];
    return $icons[$name] ?? $icons['info'];
}
?>

<style>
@keyframes newsFormShine { 0% { transform: translateX(-100%) skewX(-20deg); } 100% { transform: translateX(300%) skewX(-20deg); } }
@keyframes newsFormFadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }
@keyframes newsFormPulse { 0%, 100% { box-shadow: 0 0 0 0 rgba(5,150,105,.4); } 50% { box-shadow: 0 0 0 6px rgba(5,150,105,0); } }
@keyframes newsReqPulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.25); } }
@keyframes slugSpin { from { transform: rotate(0); } to { transform: rotate(360deg); } }
@keyframes iconRotate { 0%, 100% { transform: rotate(0deg) scale(1); } 25% { transform: rotate(-5deg) scale(1.05); } 75% { transform: rotate(5deg) scale(1.05); } }

/* ===== SVG BASE ===== */
.nf-svg { display: inline-flex; align-items: center; justify-content: center; vertical-align: middle; }
.nf-svg svg { display: block; transition: all 0.3s ease; }

/* ===== HEADER ===== */
.news-form-head {
    display: flex; align-items: center; gap: 18px; margin-bottom: 26px;
    padding: 26px 30px; border-radius: 24px;
    background: linear-gradient(135deg, #043b2c 0%, #065f46 55%, #059669 100%);
    color: #fff; position: relative; overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,.3);
    animation: newsFormFadeUp .5s cubic-bezier(.16,1,.3,1) both;
}
.news-form-head::before {
    content: ''; position: absolute; inset: 0;
    background-image: repeating-linear-gradient(45deg, transparent, transparent 25px, rgba(217,164,65,.04) 25px, rgba(217,164,65,.04) 26px),
                    repeating-linear-gradient(-45deg, transparent, transparent 25px, rgba(217,164,65,.04) 25px, rgba(217,164,65,.04) 26px);
}
.news-form-head::after {
    content: ''; position: absolute; top: -50%; right: -10%;
    width: 340px; height: 340px; border-radius: 50%;
    background: radial-gradient(circle, rgba(217,164,65,.25), transparent 70%);
    pointer-events: none;
}
.news-form-ico {
    width: 60px; height: 60px; border-radius: 17px; flex-shrink: 0;
    background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.5), transparent 40%),
                linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441);
    display: flex; align-items: center; justify-content: center;
    position: relative;
    box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -3px 4px rgba(0,0,0,.2), 0 8px 20px rgba(217,164,65,.45);
    transition: transform 0.3s ease;
}
.news-form-ico:hover { transform: scale(1.05) rotate(-5deg); }
.news-form-ico::before { content: ''; position: absolute; top: 6px; left: 11px; width: 17px; height: 7px; border-radius: 50%; background: rgba(255,255,255,.65); filter: blur(1.5px); }
.news-form-ico svg { width: 28px; height: 28px; stroke: #03251f; stroke-width: 2.2; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2)); }

.news-form-title {
    font-family: var(--font-display); font-size: 23px; font-weight: 900; letter-spacing: -.02em;
    margin: 0; position: relative; z-index: 1;
    background: linear-gradient(135deg, #fff 0%, #fde68a 100%);
    -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
}
.news-form-sub { font-size: 13px; opacity: .88; margin: 5px 0 0; position: relative; z-index: 1; }

.news-form-mode {
    margin-left: auto; padding: 6px 14px; border-radius: 999px;
    font-size: 11px; font-weight: 900; letter-spacing: .1em; text-transform: uppercase;
    position: relative; z-index: 1; flex-shrink: 0;
    display: inline-flex; align-items: center; gap: 6px;
}
.news-form-mode svg { width: 13px; height: 13px; stroke-width: 2.5; }
.news-form-mode.edit {
    background: linear-gradient(145deg, #fde68a, #d9a441); color: #03251f;
    box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -1px 2px rgba(0,0,0,.15);
}
.news-form-mode.edit svg { stroke: #03251f; }
.news-form-mode.new {
    background: rgba(255,255,255,.15); color: #fff; border: 1px solid rgba(255,255,255,.3);
}
.news-form-mode.new svg { stroke: #fff; }

/* ===== FLASH ===== */
.flash-3d {
    position: relative; padding: 15px 20px; margin-bottom: 22px; border-radius: 14px;
    font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 10px;
    overflow: hidden;
    box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.05), 0 6px 16px rgba(0,0,0,.1);
    animation: newsFormFadeUp .5s cubic-bezier(.16,1,.3,1) both;
}
.flash-3d svg { width: 20px; height: 20px; stroke-width: 2.2; flex-shrink: 0; }
.flash-3d::after { content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%; background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent); animation: newsFormShine 3s ease-in-out infinite; pointer-events: none; }
.flash-success-3d { background: linear-gradient(145deg, #d1fae5, #a7f3d0); border: 1px solid rgba(16,185,129,.35); color: #065f46; }
.flash-success-3d svg { stroke: #065f46; }
.flash-error-3d { background: linear-gradient(145deg, #fee2e2, #fecaca); border: 1px solid rgba(220,38,38,.35); color: #991b1b; }
.flash-error-3d svg { stroke: #991b1b; }

/* ===== FORM SECTIONS ===== */
.form-section-3d {
    background: var(--white); border: 1px solid var(--border); border-radius: 22px;
    padding: 28px; margin-bottom: 22px;
    box-shadow: 0 6px 20px rgba(0,0,0,.05);
    position: relative; overflow: hidden;
    animation: newsFormFadeUp .5s cubic-bezier(.16,1,.3,1) both;
}
.form-section-3d:nth-of-type(2) { animation-delay: .08s; }
.form-section-3d:nth-of-type(3) { animation-delay: .16s; }
.form-section-3d:nth-of-type(4) { animation-delay: .24s; }
.form-section-3d::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, var(--gold-strong), var(--primary)); opacity: .7;
}

.form-section-title {
    display: flex; align-items: center; gap: 12px;
    font-size: 16px; font-weight: 900; color: var(--ink);
    font-family: var(--font-display); margin: 0 0 24px;
    padding-bottom: 16px; border-bottom: 1px dashed var(--border);
}
.form-section-title .section-ico {
    display: inline-flex; align-items: center; justify-content: center;
    width: 36px; height: 36px; border-radius: 11px;
    background: linear-gradient(145deg, rgba(217,164,65,0.15), rgba(217,164,65,0.05));
    border: 1px solid rgba(217,164,65,0.25);
    box-shadow: inset 0 1px 2px rgba(255,255,255,0.5), 0 2px 6px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}
.form-section-title:hover .section-ico { transform: scale(1.08) rotate(-5deg); }
.form-section-title .section-ico svg { width: 18px; height: 18px; stroke: var(--gold-strong); stroke-width: 2.2; filter: drop-shadow(0 1px 2px rgba(217,164,65,0.3)); }
.form-section-title .section-num {
    margin-left: auto; font-size: 10px; font-weight: 900; letter-spacing: .12em;
    color: var(--muted); padding: 3px 10px; border-radius: 999px;
    background: rgba(100,116,139,0.08); border: 1px solid var(--border);
}

/* ===== FORM GROUPS ===== */
.fg-3d { margin-bottom: 22px; position: relative; }
.fg-3d:last-child { margin-bottom: 0; }

.fg-3d label {
    display: flex; align-items: center; gap: 8px;
    font-size: 12px; font-weight: 850; letter-spacing: .08em; text-transform: uppercase;
    color: var(--primary-dark); margin-bottom: 10px;
}
.fg-3d label .field-ico {
    display: inline-flex; align-items: center; justify-content: center;
    width: 24px; height: 24px; border-radius: 8px;
    background: linear-gradient(145deg, rgba(16,185,129,.15), rgba(5,150,105,.08));
    border: 1px solid rgba(5,150,105,0.2);
}
.fg-3d label .field-ico svg { width: 13px; height: 13px; stroke: var(--primary); stroke-width: 2.5; }

.fg-3d label .req-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 2px 8px; border-radius: 999px;
    font-size: 9px; font-weight: 900; letter-spacing: .08em;
    background: rgba(220,38,38,.10); color: #dc2626;
    border: 1px solid rgba(220,38,38,.25); margin-left: 4px; text-transform: uppercase;
}
.fg-3d label .req-badge::before {
    content: ''; width: 5px; height: 5px; border-radius: 50%;
    background: #dc2626; animation: newsReqPulse 1.5s ease-in-out infinite;
}
.fg-3d label .opt-badge {
    padding: 2px 8px; border-radius: 999px;
    font-size: 9px; font-weight: 800; letter-spacing: .08em;
    background: rgba(100,116,139,.10); color: #64748b;
    border: 1px solid rgba(100,116,139,.2); text-transform: uppercase;
}

/* ===== INPUTS ===== */
.fg-3d input[type="text"], .fg-3d input[type="date"], .fg-3d input[type="url"],
.fg-3d select, .fg-3d textarea {
    width: 100%; padding: 13px 16px; border-radius: 13px;
    border: 2px solid var(--border);
    background: linear-gradient(145deg, #f6faf7, #fff);
    font-size: 14px; font-weight: 600; color: #03251f !important;
    -webkit-text-fill-color: #03251f !important;
    transition: all .3s cubic-bezier(.16,1,.3,1);
    box-shadow: inset 0 2px 4px rgba(0,0,0,.04), inset 0 -1px 0 rgba(255,255,255,.8);
    color-scheme: light; font-family: var(--font-body);
}
.fg-3d input:-webkit-autofill, .fg-3d input:-webkit-autofill:hover, .fg-3d input:-webkit-autofill:focus,
.fg-3d select:-webkit-autofill, .fg-3d textarea:-webkit-autofill {
    -webkit-box-shadow: 0 0 0 1000px #f6faf7 inset !important;
    -webkit-text-fill-color: #03251f !important; caret-color: #059669 !important;
    transition: background-color 99999s ease-in-out 0s; border-color: var(--border) !important;
}

/* ===== PREMIUM ELEGANT DROPDOWN ===== */
.fg-3d select {
    appearance: none; -webkit-appearance: none; -moz-appearance: none;
    cursor: pointer;
    padding: 13px 46px 13px 16px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='none' stroke='%23059669' stroke-width='2.5' viewBox='0 0 24 24'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 14px center !important;
    background-size: 18px 18px !important;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.fg-3d select:hover {
    border-color: rgba(5, 150, 105, 0.4);
    background-color: #ffffff;
    transform: translateY(-1px);
    box-shadow: inset 0 2px 4px rgba(0,0,0,.04), 0 6px 16px rgba(5,150,105,0.12);
}
.fg-3d select:focus {
    outline: none; border-color: #10b981;
    background-color: #ffffff;
    box-shadow: inset 0 2px 4px rgba(0,0,0,.04), 0 0 0 4px rgba(16, 185, 129, 0.15), 0 6px 16px rgba(5,150,105,0.15);
}
.fg-3d select option {
    background: #ffffff; color: #03251f; padding: 10px; font-weight: 600;
}

.fg-3d textarea { resize: vertical; min-height: 120px; line-height: 1.7; }
.fg-3d textarea.content-area { min-height: 340px; font-size: 14.5px; line-height: 1.8; }

.fg-3d input:focus, .fg-3d select:focus, .fg-3d textarea:focus {
    outline: none; border-color: #059669; background: #fff;
    color: #03251f !important; -webkit-text-fill-color: #03251f !important;
    box-shadow: inset 0 2px 4px rgba(0,0,0,.06), 0 0 0 4px rgba(5,150,105,.12), 0 6px 16px rgba(5,150,105,.15);
}
.fg-3d input:invalid:not(:placeholder-shown), .fg-3d textarea:invalid:not(:placeholder-shown) {
    border-color: rgba(220,38,38,.5);
}

/* ===== HELPERS ===== */
.fg-3d .field-helper {
    display: flex; align-items: center; justify-content: space-between; gap: 8px;
    margin-top: 8px; font-size: 11.5px; color: var(--muted); flex-wrap: wrap;
}
.fg-3d .field-helper .helper-tip {
    display: inline-flex; align-items: center; gap: 5px;
}
.fg-3d .field-helper .helper-tip svg {
    width: 13px; height: 13px; stroke: var(--gold-strong); stroke-width: 2.2;
    flex-shrink: 0;
}
.fg-3d .field-counter {
    font-family: var(--font-display); font-weight: 850; font-size: 11px;
    color: var(--muted); padding: 3px 9px; border-radius: 7px;
    background: rgba(100,116,139,.08); border: 1px solid rgba(100,116,139,0.15);
    transition: all .2s;
}
.fg-3d .field-counter.warn { color: #92400e; background: rgba(242,192,99,.15); border-color: rgba(242,192,99,0.3); }
.fg-3d .field-counter.danger { color: #991b1b; background: rgba(220,38,38,.12); border-color: rgba(220,38,38,0.25); }

/* ===== SLUG ===== */
.slug-field-wrap { display: flex; gap: 8px; align-items: stretch; }
.slug-field-wrap input { flex: 1; font-family: 'Courier New', monospace; font-size: 13px; color: #059669 !important; }
.slug-regen-btn {
    padding: 0 16px; border-radius: 13px; border: 2px solid var(--border);
    background: linear-gradient(145deg, #f6faf7, #fff); color: var(--primary-dark);
    cursor: pointer; font-size: 12.5px; font-weight: 800;
    display: inline-flex; align-items: center; gap: 6px;
    transition: all .25s cubic-bezier(0.16, 1, 0.3, 1); white-space: nowrap;
}
.slug-regen-btn svg { width: 14px; height: 14px; stroke: currentColor; stroke-width: 2.2; }
.slug-regen-btn:hover {
    border-color: var(--primary); color: var(--primary);
    transform: translateY(-2px); box-shadow: 0 4px 12px rgba(5,150,105,0.15);
}
.slug-regen-btn:hover svg { animation: iconRotate 0.5s ease; }
.slug-regen-btn:active .slug-regen-ico { animation: slugSpin .5s ease-in-out; }
.slug-regen-ico { display: inline-flex; transition: transform .3s; }

/* ===== CATEGORY PREVIEW ===== */
.category-preview {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 7px 15px; margin-top: 10px; border-radius: 999px;
    background: linear-gradient(145deg, rgba(16,185,129,.10), rgba(5,150,105,.05));
    border: 1px solid rgba(5,150,105,.25);
    font-size: 12.5px; font-weight: 700; color: #065f46;
    transition: all .3s;
}
.category-preview svg { width: 12px; height: 12px; stroke: #10b981; stroke-width: 2.5; }
.category-preview .cat-dot {
    width: 8px; height: 8px; border-radius: 50%; background: #10b981;
    box-shadow: 0 0 0 3px rgba(16,185,129,.2);
}

/* ===== STATUS PREVIEW ===== */
.status-preview-3d {
    margin-top: 10px; padding: 11px 16px; border-radius: 12px;
    display: flex; align-items: center; gap: 10px;
    font-size: 12.5px; font-weight: 700; border: 1px solid;
    transition: all .3s;
}
.status-preview-3d svg { width: 14px; height: 14px; stroke-width: 2.5; flex-shrink: 0; }
.status-preview-3d.published {
    background: linear-gradient(145deg, rgba(16,185,129,.10), rgba(5,150,105,.05));
    color: #065f46; border-color: rgba(16,185,129,.3);
}
.status-preview-3d.published svg { stroke: #10b981; }
.status-preview-3d.draft {
    background: linear-gradient(145deg, rgba(100,116,139,.08), rgba(100,116,139,.04));
    color: #475569; border-color: rgba(100,116,139,.25);
}
.status-preview-3d.draft svg { stroke: #64748b; }
.status-preview-3d .sp-dot {
    width: 9px; height: 9px; border-radius: 50%;
}
.status-preview-3d.published .sp-dot {
    background: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,.2);
    animation: newsFormPulse 2s ease-in-out infinite;
}
.status-preview-3d.draft .sp-dot { background: #64748b; }

/* ===== FEATURED SWITCH ===== */
.featured-switch {
    display: flex; align-items: center; gap: 14px; cursor: pointer;
    padding: 14px 18px; border-radius: 14px;
    border: 2px solid var(--border);
    background: linear-gradient(145deg, #f6faf7, #fff);
    transition: all .3s cubic-bezier(0.16, 1, 0.3, 1);
}
.featured-switch:hover {
    border-color: rgba(217,164,65,.4);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(217,164,65,0.1);
}
.featured-switch input { position: absolute; opacity: 0; width: 0; height: 0; }
.fs-slider {
    width: 48px; height: 28px; border-radius: 999px;
    background: #cbd5e1; position: relative; flex-shrink: 0;
    transition: all .3s;
    box-shadow: inset 0 2px 4px rgba(0,0,0,.15);
}
.fs-slider::after {
    content: ''; position: absolute; top: 3px; left: 3px;
    width: 22px; height: 22px; border-radius: 50%;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,.2);
    transition: all .3s cubic-bezier(0.16, 1, 0.3, 1);
}
.featured-switch input:checked ~ .fs-slider {
    background: linear-gradient(145deg, #fde68a, #d9a441);
    box-shadow: inset 0 2px 4px rgba(0,0,0,.1), 0 0 0 3px rgba(217,164,65,.2);
}
.featured-switch input:checked ~ .fs-slider::after { left: 23px; }
.fs-text {
    font-size: 13px; font-weight: 700; color: var(--muted);
    text-transform: none; letter-spacing: 0;
    display: flex; align-items: center; gap: 6px;
}
.fs-text svg { width: 14px; height: 14px; stroke-width: 2.2; }
.featured-switch input:checked ~ .fs-text { color: #92400e; }
.featured-switch input:checked ~ .fs-text svg { stroke: #d97706; }

/* ===== FORM ROW ===== */
.form-row-3d { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
@media(max-width:640px) { .form-row-3d { grid-template-columns: 1fr; } }

/* ===== CONTENT STATS ===== */
.content-stats {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;
    margin-top: 12px; padding: 14px;
    background: linear-gradient(145deg, #f6faf7, #fff);
    border: 1px solid var(--border); border-radius: 14px;
    box-shadow: inset 0 1px 2px rgba(255,255,255,0.5);
}
.content-stat { text-align: center; padding: 8px; }
.content-stat .stat-value {
    font-family: var(--font-display); font-size: 20px; font-weight: 900;
    color: var(--primary-dark);
}
.content-stat .stat-label {
    font-size: 10px; font-weight: 800; letter-spacing: .08em;
    text-transform: uppercase; color: var(--muted); margin-top: 3px;
    display: flex; align-items: center; justify-content: center; gap: 4px;
}
.content-stat .stat-label svg { width: 12px; height: 12px; stroke: currentColor; stroke-width: 2.2; }
.content-stat + .content-stat { border-left: 1px dashed var(--border); }

/* ===== EXCERPT PREVIEW ===== */
.excerpt-preview {
    margin-top: 12px; padding: 16px 18px; border-radius: 14px;
    background: linear-gradient(145deg, rgba(217,164,65,.06), rgba(217,164,65,.02));
    border: 1px solid rgba(217,164,65,.2);
}
.excerpt-preview .exc-head {
    display: flex; align-items: center; gap: 7px;
    font-size: 10.5px; font-weight: 900; letter-spacing: .1em;
    text-transform: uppercase; color: #92400e; margin-bottom: 8px;
}
.excerpt-preview .exc-head svg { width: 13px; height: 13px; stroke: #92400e; stroke-width: 2.2; }
.excerpt-preview .exc-text {
    font-size: 13.5px; color: #44403c; line-height: 1.6; font-style: italic;
}
.excerpt-preview .exc-text.empty { color: var(--muted); font-style: italic; }

/* ===== IMAGE DROPZONE ===== */
.img-dropzone-3d {
    position: relative; padding: 36px 26px; border-radius: 20px;
    border: 3px dashed rgba(217,164,65,.5);
    background: linear-gradient(145deg, rgba(253,230,138,.08), rgba(217,164,65,.04));
    text-align: center; cursor: pointer;
    transition: all .3s cubic-bezier(.16,1,.3,1); overflow: hidden;
}
.img-dropzone-3d::before {
    content: ''; position: absolute; inset: 0;
    background-image: repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(217,164,65,.03) 20px, rgba(217,164,65,.03) 21px);
    pointer-events: none;
}
.img-dropzone-3d:hover {
    border-color: #059669;
    background: linear-gradient(145deg, rgba(16,185,129,.08), rgba(5,150,105,.04));
    box-shadow: 0 10px 28px rgba(5,150,105,.12);
    transform: translateY(-2px);
}
.img-dropzone-3d.dragover {
    border-color: #059669;
    background: linear-gradient(145deg, rgba(16,185,129,.15), rgba(5,150,105,.08));
    transform: translateY(-3px);
}
.img-dropzone-3d.has-file {
    border-style: solid; border-color: rgba(16,185,129,.4);
    background: linear-gradient(145deg, rgba(16,185,129,.06), rgba(5,150,105,.03));
}
.img-dropzone-3d.has-error {
    border-color: rgba(220,38,38,.5);
    background: linear-gradient(145deg, rgba(254,226,226,.3), rgba(252,165,165,.08));
}
.img-dropzone-3d input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }

.img-dz-ico-3d {
    width: 70px; height: 70px; border-radius: 22px; margin: 0 auto 16px;
    background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.5), transparent 40%),
                linear-gradient(145deg, #34d399, #10b981 50%, #059669);
    display: flex; align-items: center; justify-content: center;
    position: relative;
    box-shadow: inset 0 2px 3px rgba(255,255,255,.6), inset 0 -3px 4px rgba(0,0,0,.25), 0 8px 20px rgba(5,150,105,.35);
    transition: transform 0.3s ease;
}
.img-dropzone-3d:hover .img-dz-ico-3d { transform: scale(1.05) rotate(-3deg); }
.img-dz-ico-3d::before { content: ''; position: absolute; top: 7px; left: 13px; width: 19px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.6); filter: blur(1.5px); }
.img-dz-ico-3d svg { width: 32px; height: 32px; stroke: #ffffff; stroke-width: 2.2; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2)); }

.img-dz-title-3d { font-size: 15.5px; font-weight: 800; color: var(--ink); margin-bottom: 6px; font-family: var(--font-display); }
.img-dz-sub-3d { font-size: 12.5px; color: var(--muted); margin-bottom: 12px; }
.img-dz-formats { display: flex; gap: 6px; justify-content: center; flex-wrap: wrap; }
.img-dz-format-chip {
    padding: 4px 11px; border-radius: 999px; font-size: 10.5px; font-weight: 800;
    background: rgba(5,150,105,.1); color: var(--primary-dark);
    border: 1px solid rgba(5,150,105,.25);
}

/* ===== IMAGE PREVIEW ===== */
.img-preview-live {
    display: none; align-items: center; gap: 16px; padding: 16px;
    margin-top: 16px; border-radius: 16px;
    background: linear-gradient(145deg, #f6faf7, #fff);
    border: 1px solid rgba(16,185,129,.35);
    box-shadow: inset 0 1px 1px rgba(255,255,255,.9), 0 4px 12px rgba(16,185,129,.1);
    animation: newsFormFadeUp .3s ease-out;
}
.img-preview-live.show { display: flex; }
.img-preview-live img {
    width: 110px; height: 74px; border-radius: 12px; object-fit: cover;
    border: 2px solid var(--border); box-shadow: 0 4px 12px rgba(0,0,0,.1);
    transition: transform 0.3s ease;
}
.img-preview-live img:hover { transform: scale(1.05); }
.img-preview-live .ipl-info { flex: 1; min-width: 0; }
.img-preview-live .ipl-name {
    font-size: 13.5px; font-weight: 800; color: var(--ink); margin: 0 0 4px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    display: flex; align-items: center; gap: 6px;
}
.img-preview-live .ipl-name svg { width: 14px; height: 14px; stroke: var(--primary); stroke-width: 2.2; flex-shrink: 0; }
.img-preview-live .ipl-meta {
    font-size: 11.5px; color: var(--muted); font-weight: 600;
    display: flex; gap: 10px; align-items: center; flex-wrap: wrap;
}
.img-preview-live .ipl-meta span { display: inline-flex; align-items: center; gap: 4px; }
.img-preview-live .ipl-meta svg { width: 12px; height: 12px; stroke: currentColor; stroke-width: 2.2; }
.img-preview-live .ipl-remove {
    padding: 6px 12px; border-radius: 9px; border: none; cursor: pointer;
    background: rgba(220,38,38,.08); color: #dc2626;
    font-size: 11.5px; font-weight: 800;
    transition: all .2s; display: inline-flex; align-items: center; gap: 5px;
}
.img-preview-live .ipl-remove svg { width: 12px; height: 12px; stroke: currentColor; stroke-width: 2.5; }
.img-preview-live .ipl-remove:hover { background: #dc2626; color: #fff; }

/* ===== IMAGE WARNING ===== */
.img-warning-3d {
    display: none; align-items: center; gap: 10px;
    padding: 12px 16px; margin-top: 12px; border-radius: 12px;
    background: linear-gradient(145deg, rgba(220,38,38,.10), rgba(220,38,38,.05));
    border: 1px solid rgba(220,38,38,.3); color: #991b1b;
    font-size: 12.5px; font-weight: 700;
    animation: newsFormFadeUp .3s ease-out;
}
.img-warning-3d.show { display: flex; }
.img-warning-3d svg { width: 16px; height: 16px; stroke: #dc2626; stroke-width: 2.2; flex-shrink: 0; }

/* ===== THUMB PREVIEW ===== */
.thumb-preview-3d {
    display: flex; align-items: center; gap: 18px; padding: 18px 20px;
    margin-top: 16px; border-radius: 16px;
    background: linear-gradient(145deg, #f6faf7, #fff);
    border: 1px solid rgba(217,164,65,.25);
    box-shadow: inset 0 1px 1px rgba(255,255,255,.9), 0 4px 12px rgba(0,0,0,.05);
}
.thumb-img-3d {
    width: 120px; height: 80px; border-radius: 13px; object-fit: cover;
    border: 2px solid var(--border); box-shadow: 0 4px 14px rgba(0,0,0,.15);
    transition: transform .3s;
}
.thumb-img-3d:hover { transform: scale(1.08); }
.thumb-preview-3d .thumb-info p { margin: 0; }
.thumb-preview-3d .thumb-info p:first-child {
    font-size: 13.5px; font-weight: 700; color: var(--ink);
    display: flex; align-items: center; gap: 6px;
}
.thumb-preview-3d .thumb-info p:first-child svg { width: 15px; height: 15px; stroke: var(--gold-strong); stroke-width: 2.2; }
.thumb-preview-3d .thumb-info p:last-child {
    margin-top: 4px; font-size: 12px; color: var(--muted);
}

/* ===== ACTIONS ===== */
.form-actions-3d { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; padding-top: 10px; }

.btn-save-3d {
    position: relative; padding: 15px 30px; border: none; border-radius: 14px;
    font-size: 14.5px; font-weight: 850; color: #03251f; cursor: pointer;
    background: linear-gradient(145deg, #fde68a, #f2c063 40%, #d9a441 80%, #a9761b);
    overflow: hidden;
    transition: all .3s cubic-bezier(.16,1,.3,1);
    box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.15), 0 10px 24px rgba(217,164,65,.4);
    font-family: var(--font-display);
    display: inline-flex; align-items: center; gap: 8px;
}
.btn-save-3d svg { width: 18px; height: 18px; stroke: #03251f; stroke-width: 2.5; filter: drop-shadow(0 1px 2px rgba(0,0,0,0.15)); }
.btn-save-3d::before { content: ''; position: absolute; top: 3px; left: 10%; width: 35%; height: 35%; border-radius: 50%; background: rgba(255,255,255,.6); filter: blur(2px); pointer-events: none; }
.btn-save-3d::after { content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%; background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent); animation: newsFormShine 3s ease-in-out infinite; pointer-events: none; }
.btn-save-3d:hover { transform: translateY(-3px); box-shadow: inset 0 2px 3px rgba(255,255,255,.8), 0 16px 34px rgba(217,164,65,.55); }
.btn-save-3d:active { transform: translateY(0); }
.btn-save-3d:disabled { opacity: .6; cursor: not-allowed; }

.btn-cancel-3d {
    padding: 15px 26px; border-radius: 14px; text-decoration: none;
    font-size: 14.5px; font-weight: 700; color: var(--muted);
    background: linear-gradient(145deg, #f6faf7, #fff);
    border: 2px solid var(--border);
    transition: all .25s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: inset 0 2px 4px rgba(0,0,0,.04);
    display: inline-flex; align-items: center; gap: 7px;
}
.btn-cancel-3d svg { width: 16px; height: 16px; stroke: currentColor; stroke-width: 2.5; }
.btn-cancel-3d:hover {
    transform: translateY(-2px);
    border-color: rgba(220,38,38,.35); color: #991b1b;
    box-shadow: 0 8px 18px rgba(220,38,38,.12);
}

.form-actions-spacer { flex: 1; }

.form-tip-box {
    display: flex; align-items: center; gap: 7px;
    padding: 9px 14px; border-radius: 11px;
    background: linear-gradient(145deg, rgba(217,164,65,.08), rgba(217,164,65,.04));
    border: 1px solid rgba(217,164,65,.2);
    font-size: 11.5px; color: #92400e; font-weight: 600;
}
.form-tip-box svg { width: 14px; height: 14px; stroke: #92400e; stroke-width: 2.2; flex-shrink: 0; }

/* ===== TAGS PREVIEW ===== */
.tag-chip {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 4px 11px; border-radius: 999px;
    font-size: 11px; font-weight: 700;
    background: rgba(5,150,105,.1); border: 1px solid rgba(5,150,105,.25);
    color: #065f46;
    transition: all 0.2s ease;
}
.tag-chip svg { width: 10px; height: 10px; stroke: #059669; stroke-width: 2.5; }
.tag-chip:hover { background: rgba(5,150,105,.18); transform: translateY(-1px); }

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .news-form-head { flex-direction: column; align-items: flex-start; padding: 22px; }
    .news-form-mode { margin-left: 0; margin-top: 8px; }
    .form-actions-3d { flex-direction: column; align-items: stretch; }
    .btn-save-3d, .btn-cancel-3d { width: 100%; justify-content: center; }
    .form-actions-spacer { display: none; }
    .form-tip-box { justify-content: center; }
}
</style>

<!-- ================= HEADER ================= -->
<div class="news-form-head">
    <div class="news-form-ico">
        <?= renderNewsFormIcon('edit', 28, '#03251f') ?>
    </div>
    <div style="position: relative; z-index: 1; flex: 1; min-width: 0;">
        <h2 class="news-form-title"><?= $item !== null ? 'Edit Berita' : 'Tambah Berita' ?></h2>
        <p class="news-form-sub">
            <?= $item !== null ? 'Perbarui konten berita sebelum dipublikasikan.' : 'Tulis berita baru untuk dipublikasikan ke website.' ?>
        </p>
    </div>
    <span class="news-form-mode <?= $item !== null ? 'edit' : 'new' ?>">
        <?= $item !== null ? renderNewsFormIcon('edit', 13, 'currentColor') : renderNewsFormIcon('save', 13, 'currentColor') ?>
        <span><?= $item !== null ? 'Edit' : 'Baru' ?></span>
    </span>
</div>

<?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
        <?= $flash['type'] === 'error' ? renderNewsFormIcon('alert', 20, 'currentColor') : renderNewsFormIcon('check', 20, 'currentColor') ?>
        <span><?= e($flash['message']) ?></span>
    </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" action="<?= e($action) ?>" id="news-form">
    <?= csrf_field() ?>
    <?php if ($item !== null): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>

    <!-- SECTION 1: INFORMASI DASAR -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-ico"><?= renderNewsFormIcon('file-text', 18, 'currentColor') ?></span>
            <span>Informasi Dasar</span>
            <span class="section-num">BAGIAN 1 / 3</span>
        </h3>

        <div class="fg-3d">
            <label for="f-title">
                <span class="field-ico"><?= renderNewsFormIcon('edit', 13, 'currentColor') ?></span>
                Judul Berita
                <span class="req-badge">Wajib</span>
            </label>
            <input type="text" id="f-title" name="title"
                   value="<?= e($item['title'] ?? old('title')) ?>"
                   required maxlength="200"
                   placeholder="Contoh: LP3M Gelar Workshop Penulisan Jurnal Bereputasi"
                   autocomplete="off">
            <div class="field-helper">
                <span class="helper-tip"><?= renderNewsFormIcon('info', 13, 'currentColor') ?> Judul yang menarik dan informatif (max 200 karakter)</span>
                <span class="field-counter" id="title-counter">0 / 200</span>
            </div>
        </div>

        <div class="fg-3d">
            <label for="f-slug">
                <span class="field-ico"><?= renderNewsFormIcon('link', 13, 'currentColor') ?></span>
                Slug URL
                <span class="opt-badge">Otomatis</span>
            </label>
            <div class="slug-field-wrap">
                <input type="text" id="f-slug" name="slug"
                       value="<?= e($item['slug'] ?? old('slug')) ?>"
                       maxlength="200"
                       placeholder="akan-diisi-otomatis-dari-judul"
                       autocomplete="off">
                <button type="button" class="slug-regen-btn" id="slug-regen" title="Generate dari judul">
                    <span class="slug-regen-ico"><?= renderNewsFormIcon('refresh', 14, 'currentColor') ?></span>
                    <span>Generate</span>
                </button>
            </div>
            <div class="field-helper">
                <span class="helper-tip"><?= renderNewsFormIcon('info', 13, 'currentColor') ?> URL-friendly. Auto-fill dari judul, bisa edit manual.</span>
            </div>
        </div>

        <div class="form-row-3d">
            <div class="fg-3d">
                <label for="f-category">
                    <span class="field-ico"><?= renderNewsFormIcon('tag', 13, 'currentColor') ?></span>
                    Kategori
                    <span class="req-badge">Wajib</span>
                </label>
                <select id="f-category" name="category" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= e($cat) ?>" <?= ($item['category'] ?? 'umum') === $cat ? 'selected' : '' ?>>
                            <?= e(ucfirst($cat)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="category-preview" id="category-preview">
                    <?= renderNewsFormIcon('dot', 8, 'currentColor') ?>
                    <span id="category-text"><?= e(ucfirst($item['category'] ?? 'umum')) ?></span>
                </div>
            </div>

            <div class="fg-3d">
                <label for="f-status">
                    <span class="field-ico"><?= renderNewsFormIcon('activity', 13, 'currentColor') ?></span>
                    Status
                    <span class="req-badge">Wajib</span>
                </label>
                <select id="f-status" name="status" required>
                    <option value="draft" <?= ($item['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>
                        Draft — Belum dipublikasikan
                    </option>
                    <option value="published" <?= ($item['status'] ?? '') === 'published' ? 'selected' : '' ?>>
                        Published — Langsung tayang
                    </option>
                </select>
                <div class="status-preview-3d draft" id="status-preview">
                    <span class="sp-dot"></span>
                    <span id="status-preview-text">Berita tersimpan sebagai draft, belum tayang</span>
                </div>
            </div>
        </div>

        <!-- FEATURED SWITCH -->
        <div class="fg-3d">
            <label>
                <span class="field-ico"><?= renderNewsFormIcon('star', 13, 'currentColor') ?></span>
                Berita Unggulan
                <span class="opt-badge">Opsional</span>
            </label>
            <label class="featured-switch">
                <input type="checkbox" id="f-featured" name="is_featured" value="1"
                    <?= ($item !== null)
                        ? (!empty($item['is_featured']) ? 'checked' : '')
                        : (old('is_featured') === '1' ? 'checked' : '') ?>>
                <span class="fs-slider"></span>
                <span class="fs-text" id="featured-text">
                    <?= renderNewsFormIcon('star', 14, 'currentColor') ?>
                    <span><?= ($item !== null && !empty($item['is_featured'])) || old('is_featured') === '1'
                        ? 'Aktif — tampil di hero slider halaman Berita publik'
                        : 'Nonaktif — tidak tampil di hero slider' ?></span>
                </span>
            </label>
            <div class="field-helper">
                <span class="helper-tip"><?= renderNewsFormIcon('info', 13, 'currentColor') ?> Berita unggulan akan muncul di bagian atas (hero slider) halaman Berita publik.</span>
            </div>
        </div>

        <!-- TAGS -->
        <div class="fg-3d">
            <label for="f-tags">
                <span class="field-ico"><?= renderNewsFormIcon('hash', 13, 'currentColor') ?></span>
                Tags / Label
                <span class="opt-badge">Opsional</span>
            </label>
            <input type="text" id="f-tags" name="tags"
                   value="<?= e($itemTags ?? old('tags')) ?>"
                   placeholder="contoh: workshop, jurnal, penelitian, KKN"
                   autocomplete="off">
            <div class="field-helper">
                <span class="helper-tip"><?= renderNewsFormIcon('info', 13, 'currentColor') ?> Pisahkan dengan koma. Maksimal 8 tags.</span>
            </div>
            <div id="tags-preview" style="display:flex; gap:6px; flex-wrap:wrap; margin-top:10px;"></div>
        </div>
    </div>

    <!-- SECTION 2: GAMBAR THUMBNAIL -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-ico"><?= renderNewsFormIcon('image', 18, 'currentColor') ?></span>
            <span>Gambar Thumbnail</span>
            <span class="section-num">BAGIAN 2 / 3</span>
        </h3>

        <div class="fg-3d">
            <label for="f-thumbnail">
                <span class="field-ico"><?= renderNewsFormIcon('camera', 13, 'currentColor') ?></span>
                Upload Gambar
                <span class="opt-badge">Opsional</span>
            </label>

            <div class="img-dropzone-3d" id="img-dropzone">
                <input type="file" id="f-thumbnail" name="thumbnail" accept=".jpg,.jpeg,.png,.webp">
                <div class="img-dz-ico-3d">
                    <?= renderNewsFormIcon('upload', 32, '#ffffff') ?>
                </div>
                <div class="img-dz-title-3d" id="img-dz-title">
                    <?= ($item !== null && !empty($item['thumbnail'])) ? 'Ganti Gambar (Opsional)' : 'Klik atau Seret Gambar ke Sini' ?>
                </div>
                <div class="img-dz-sub-3d">JPG, PNG, atau WEBP · Maksimal 2 MB</div>
                <div class="img-dz-formats">
                    <span class="img-dz-format-chip">JPG</span>
                    <span class="img-dz-format-chip">JPEG</span>
                    <span class="img-dz-format-chip">PNG</span>
                    <span class="img-dz-format-chip">WEBP</span>
                </div>
            </div>

            <!-- Image preview live -->
            <div class="img-preview-live" id="img-preview">
                <img src="" alt="Preview" id="img-preview-src">
                <div class="ipl-info">
                    <p class="ipl-name">
                        <?= renderNewsFormIcon('image', 14, 'currentColor') ?>
                        <span id="img-preview-name">—</span>
                    </p>
                    <div class="ipl-meta">
                        <span><?= renderNewsFormIcon('package', 12, 'currentColor') ?> <span id="img-preview-size">—</span></span>
                        <span><?= renderNewsFormIcon('check', 12, '#10b981') ?> Siap diupload</span>
                    </div>
                </div>
                <button type="button" class="ipl-remove" id="img-remove">
                    <?= renderNewsFormIcon('x', 12, 'currentColor') ?>
                    <span>Hapus</span>
                </button>
            </div>

            <!-- Image warning -->
            <div class="img-warning-3d" id="img-warning">
                <?= renderNewsFormIcon('alert', 16, 'currentColor') ?>
                <span id="img-warning-text">—</span>
            </div>

            <?php if ($item !== null && !empty($item['thumbnail'])): ?>
                <div class="thumb-preview-3d">
                    <img class="thumb-img-3d" src="<?= e(upload_url($item['thumbnail'])) ?>" alt="Thumbnail saat ini">
                    <div class="thumb-info">
                        <p>
                            <?= renderNewsFormIcon('image', 15, 'currentColor') ?>
                            <span>Gambar saat ini</span>
                        </p>
                        <p>Upload gambar baru hanya jika ingin mengganti.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- SECTION 3: ISI BERITA -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-ico"><?= renderNewsFormIcon('type', 18, 'currentColor') ?></span>
            <span>Isi Berita</span>
            <span class="section-num">BAGIAN 3 / 3</span>
        </h3>

        <div class="fg-3d">
            <label for="f-content">
                <span class="field-ico"><?= renderNewsFormIcon('file-text', 13, 'currentColor') ?></span>
                Konten Berita
                <span class="req-badge">Wajib</span>
            </label>
            <textarea id="f-content" name="content" rows="14" class="content-area"
                      required maxlength="10000"
                      placeholder="Tulis isi berita di sini... Gunakan baris kosong untuk memisahkan paragraf. Paragraf pertama akan otomatis menjadi excerpt (ringkasan) di kartu berita."><?= e($item['content'] ?? old('content')) ?></textarea>

            <!-- Content Stats -->
            <div class="content-stats">
                <div class="content-stat">
                    <div class="stat-value" id="stat-words">0</div>
                    <div class="stat-label">Kata</div>
                </div>
                <div class="content-stat">
                    <div class="stat-value" id="stat-chars">0</div>
                    <div class="stat-label">Karakter</div>
                </div>
                <div class="content-stat">
                    <div class="stat-value" id="stat-readtime">0m</div>
                    <div class="stat-label"><?= renderNewsFormIcon('clock', 12, 'currentColor') ?> Waktu Baca</div>
                </div>
            </div>

            <!-- Excerpt Preview -->
            <div class="excerpt-preview">
                <div class="exc-head">
                    <?= renderNewsFormIcon('clipboard', 13, 'currentColor') ?>
                    <span>Preview Excerpt (paragraf pertama)</span>
                </div>
                <p class="exc-text empty" id="excerpt-text">
                    Mulai menulis konten untuk melihat preview excerpt...
                </p>
            </div>

            <div class="field-helper" style="margin-top: 12px;">
                <span class="helper-tip"><?= renderNewsFormIcon('info', 13, 'currentColor') ?> Tips: Gunakan baris kosong untuk memisahkan paragraf. Excerpt otomatis diambil dari paragraf pertama.</span>
                <span class="field-counter" id="content-counter">0 / 10000</span>
            </div>
        </div>
    </div>

    <!-- ACTIONS -->
    <div class="form-actions-3d">
        <button type="submit" class="btn-save-3d" id="btn-save">
            <?= $item !== null ? renderNewsFormIcon('save', 18, 'currentColor') : renderNewsFormIcon('rocket', 18, 'currentColor') ?>
            <span><?= $item !== null ? 'Simpan Perubahan' : 'Publikasikan Berita' ?></span>
        </button>
        <a href="<?= e(url('admin/index.php?page=berita')) ?>" class="btn-cancel-3d">
            <?= renderNewsFormIcon('x', 16, 'currentColor') ?>
            <span>Batal</span>
        </a>
        <span class="form-actions-spacer"></span>
        <span class="form-tip-box">
            <?= renderNewsFormIcon('shield', 14, 'currentColor') ?>
            <span>Konten tersimpan aman di database</span>
        </span>
    </div>
</form>

<script>
(function(){
    'use strict';

    // ===== Helpers =====
    function formatBytes(bytes) {
        if (bytes === 0) return '0 B';
        var k = 1024, sizes = ['B', 'KB', 'MB'];
        var i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }

    function slugify(text) {
        return text.toString().toLowerCase().trim()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }

    var ALLOWED_IMG = ['image/jpeg','image/jpg','image/png','image/webp'];
    var MAX_IMG_SIZE = 2 * 1024 * 1024; // 2 MB

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
    attachCounter('f-content', 'content-counter', 10000);

    // ===== Slug Auto-Generator =====
    var titleInput = document.getElementById('f-title');
    var slugInput = document.getElementById('f-slug');
    var slugRegen = document.getElementById('slug-regen');
    var slugInitial = (slugInput && slugInput.value) ? slugInput.value : '';
    var slugManual = slugInitial !== '';

    function generateSlug() {
        if (!titleInput || !slugInput) return;
        if (titleInput.value.trim()) {
            slugInput.value = slugify(titleInput.value);
        }
    }

    if (titleInput && slugInput) {
        titleInput.addEventListener('blur', function() {
            if (!slugManual && titleInput.value.trim()) {
                slugInput.value = slugify(titleInput.value);
            }
        });

        slugInput.addEventListener('input', function() {
            slugManual = true;
        });
    }
    if (slugRegen) {
        slugRegen.addEventListener('click', function() {
            generateSlug();
            slugManual = false;
        });
    }

    // ===== Category preview =====
    var categorySelect = document.getElementById('f-category');
    var categoryText = document.getElementById('category-text');
    if (categorySelect && categoryText) {
        categorySelect.addEventListener('change', function() {
            var text = categorySelect.options[categorySelect.selectedIndex].text;
            categoryText.textContent = text;
        });
    }

    // ===== Status preview =====
    var statusSelect = document.getElementById('f-status');
    var statusPreview = document.getElementById('status-preview');
    var statusText = document.getElementById('status-preview-text');
    function updateStatus() {
        if (!statusSelect || !statusPreview) return;
        if (statusSelect.value === 'published') {
            statusPreview.className = 'status-preview-3d published';
            statusText.textContent = 'Berita akan langsung tayang di halaman Berita';
        } else {
            statusPreview.className = 'status-preview-3d draft';
            statusText.textContent = 'Berita tersimpan sebagai draft, belum tayang';
        }
    }
    if (statusSelect) {
        statusSelect.addEventListener('change', updateStatus);
        updateStatus();
    }

    // ===== Featured switch =====
    var featuredInput = document.getElementById('f-featured');
    var featuredText = document.getElementById('featured-text');
    function updateFeatured() {
        if (!featuredInput || !featuredText) return;
        var span = featuredText.querySelector('span');
        if (!span) return;
        if (featuredInput.checked) {
            span.textContent = 'Aktif — tampil di hero slider halaman Berita publik';
        } else {
            span.textContent = 'Nonaktif — tidak tampil di hero slider';
        }
    }
    if (featuredInput) {
        featuredInput.addEventListener('change', updateFeatured);
    }

    // ===== Content Stats =====
    var contentInput = document.getElementById('f-content');
    var statWords = document.getElementById('stat-words');
    var statChars = document.getElementById('stat-chars');
    var statReadtime = document.getElementById('stat-readtime');
    var excerptText = document.getElementById('excerpt-text');

    function updateContentStats() {
        if (!contentInput) return;
        var text = contentInput.value;
        var chars = text.length;
        var words = text.trim() ? text.trim().split(/\s+/).length : 0;
        var readMin = Math.max(1, Math.ceil(words / 200));

        if (statWords) statWords.textContent = words.toLocaleString('id-ID');
        if (statChars) statChars.textContent = chars.toLocaleString('id-ID');
        if (statReadtime) statReadtime.textContent = readMin + 'm';

        if (excerptText) {
            var paragraphs = text.split(/\n\s*\n/).filter(function(p) { return p.trim() !== ''; });
            if (paragraphs.length > 0) {
                var excerpt = paragraphs[0].replace(/\s+/g, ' ').trim();
                if (excerpt.length > 150) {
                    excerpt = excerpt.substring(0, 147) + '...';
                }
                excerptText.textContent = excerpt;
                excerptText.classList.remove('empty');
            } else {
                excerptText.textContent = 'Mulai menulis konten untuk melihat preview excerpt...';
                excerptText.classList.add('empty');
            }
        }
    }
    if (contentInput) {
        contentInput.addEventListener('input', updateContentStats);
        updateContentStats();
    }

    // ===== Image upload handling =====
    var imgInput = document.getElementById('f-thumbnail');
    var imgDropzone = document.getElementById('img-dropzone');
    var imgDzTitle = document.getElementById('img-dz-title');
    var imgPreview = document.getElementById('img-preview');
    var imgPreviewSrc = document.getElementById('img-preview-src');
    var imgPreviewName = document.getElementById('img-preview-name');
    var imgPreviewSize = document.getElementById('img-preview-size');
    var imgRemove = document.getElementById('img-remove');
    var imgWarning = document.getElementById('img-warning');
    var imgWarningText = document.getElementById('img-warning-text');

    function showImgWarning(msg) {
        if (imgWarningText) imgWarningText.textContent = msg;
        if (imgWarning) imgWarning.classList.add('show');
        if (imgDropzone) {
            imgDropzone.classList.add('has-error');
            imgDropzone.classList.remove('has-file');
        }
        if (imgPreview) imgPreview.classList.remove('show');
    }
    function clearImgWarning() {
        if (imgWarning) imgWarning.classList.remove('show');
        if (imgDropzone) imgDropzone.classList.remove('has-error');
    }

    function handleImage(file) {
        clearImgWarning();

        if (!file) {
            if (imgPreview) imgPreview.classList.remove('show');
            if (imgDropzone) imgDropzone.classList.remove('has-file');
            if (imgDzTitle) imgDzTitle.textContent = 'Klik atau Seret Gambar ke Sini';
            return;
        }

        if (ALLOWED_IMG.indexOf(file.type) === -1 && !file.name.match(/\.(jpg|jpeg|png|webp)$/i)) {
            showImgWarning('Format tidak didukung. Gunakan JPG, PNG, atau WEBP.');
            if (imgInput) imgInput.value = '';
            return;
        }

        if (file.size > MAX_IMG_SIZE) {
            showImgWarning('Gambar terlalu besar (' + formatBytes(file.size) + '). Maksimal 2 MB.');
            if (imgInput) imgInput.value = '';
            return;
        }

        var reader = new FileReader();
        reader.onload = function(e) {
            if (imgPreviewSrc) imgPreviewSrc.src = e.target.result;
            if (imgPreviewName) imgPreviewName.textContent = file.name;
            if (imgPreviewSize) imgPreviewSize.textContent = formatBytes(file.size);
            if (imgPreview) imgPreview.classList.add('show');
            if (imgDropzone) imgDropzone.classList.add('has-file');
            if (imgDzTitle) imgDzTitle.textContent = 'Gambar dipilih — Klik untuk ganti';
        };
        reader.readAsDataURL(file);
    }

    if (imgInput) {
        imgInput.addEventListener('change', function(e) {
            handleImage(e.target.files[0]);
        });
    }

    if (imgRemove) {
        imgRemove.addEventListener('click', function() {
            if (imgInput) imgInput.value = '';
            handleImage(null);
            clearImgWarning();
        });
    }

    // Drag & drop
    if (imgDropzone) {
        ['dragenter','dragover'].forEach(function(evt){
            imgDropzone.addEventListener(evt, function(e){
                e.preventDefault();
                imgDropzone.classList.add('dragover');
            });
        });
        ['dragleave','drop'].forEach(function(evt){
            imgDropzone.addEventListener(evt, function(e){
                e.preventDefault();
                imgDropzone.classList.remove('dragover');
            });
        });
    }

    // ===== Tags preview =====
    var tagsInput = document.getElementById('f-tags');
    var tagsBox = document.getElementById('tags-preview');
    if (tagsInput && tagsBox) {
        function renderTags() {
            var parts = tagsInput.value.split(',').map(function(s) { return s.trim(); }).filter(Boolean).slice(0, 8);
            if (parts.length === 0) {
                tagsBox.innerHTML = '';
                return;
            }
            tagsBox.innerHTML = parts.map(function(p) {
                var safe = p.replace(/[<>&"']/g, '');
                return '<span class="tag-chip"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="4" y1="9" x2="20" y2="9"></line><line x1="4" y1="15" x2="20" y2="15"></line><line x1="10" y1="3" x2="8" y2="21"></line><line x1="16" y1="3" x2="14" y2="21"></line></svg>#' + safe + '</span>';
            }).join('');
        }
        tagsInput.addEventListener('input', renderTags);
        renderTags();
    }

    // ===== Submit progress =====
    var form = document.getElementById('news-form');
    var btnSave = document.getElementById('btn-save');
    if (form) {
        form.addEventListener('submit', function() {
            if (btnSave) {
                btnSave.disabled = true;
                btnSave.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="#03251f" stroke-width="2.5" viewBox="0 0 24 24" style="animation: slugSpin 1s linear infinite;"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg><span>Menyimpan...</span>';
            }
        });
    }

})();
</script>