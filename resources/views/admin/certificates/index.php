<?php
// SVG Icon Helper untuk Sertifikat
function renderCertIcon($name, $size = 16, $color = 'currentColor') {
    $icons = [
        'award' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>',
        'plus' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>',
        'alert-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>',
        'check-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>',
        'x-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>',
        'search' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        'filter' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>',
        'printer' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>',
        'link' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>',
        'edit' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
        'ban' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>',
        'refresh' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>',
        'trash' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',
        'file-text' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>',
        'calendar' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
        'user' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>',
        'tag' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>',
        'hash' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="4" y1="9" x2="20" y2="9"></line><line x1="4" y1="15" x2="20" y2="15"></line><line x1="10" y1="3" x2="8" y2="21"></line><line x1="16" y1="3" x2="14" y2="21"></line></svg>',
        'inbox' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>',
        'chevron-down' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>',
        'info' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>',
    ];
    return $icons[$name] ?? $icons['award'];
}
?>

<style>
    @keyframes certFade { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
    @keyframes certShine { 0%, 55% { left: -90%; } 100% { left: 165%; } }
    @keyframes iconRotate { 0%, 100% { transform: rotate(0deg) scale(1); } 25% { transform: rotate(-5deg) scale(1.05); } 75% { transform: rotate(5deg) scale(1.05); } }
    @keyframes orbPulse { 0%, 100% { opacity: 0.3; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.1); } }

    .cert-svg { display: inline-flex; align-items: center; justify-content: center; vertical-align: middle; }
    .cert-svg svg { display: block; transition: all 0.3s ease; }

    /* ===== HEADER ===== */
    .cert-head {
        display: flex; align-items: center; justify-content: space-between; gap: 18px; flex-wrap: wrap;
        padding: 28px 32px; margin-bottom: 26px; border-radius: 24px;
        background: linear-gradient(135deg, #043b2c 0%, #065f46 55%, #059669 100%);
        color: #fff; position: relative; overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,.3);
        animation: certFade .5s cubic-bezier(.16,1,.3,1) both;
    }
    .cert-head::before {
        content: ''; position: absolute; inset: 0;
        background-image: repeating-linear-gradient(45deg, transparent, transparent 25px, rgba(217,164,65,.04) 25px, rgba(217,164,65,.04) 26px),
                        repeating-linear-gradient(-45deg, transparent, transparent 25px, rgba(217,164,65,.04) 25px, rgba(217,164,65,.04) 26px);
    }
    .cert-head::after {
        content: ''; position: absolute; top: -50%; right: -10%;
        width: 340px; height: 340px; border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,.25), transparent 70%);
        pointer-events: none;
        animation: orbPulse 5s ease-in-out infinite;
    }
    .cert-head-ico {
        width: 60px; height: 60px; border-radius: 17px; flex-shrink: 0;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.5), transparent 40%),
                    linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441);
        display: flex; align-items: center; justify-content: center;
        box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -3px 4px rgba(0,0,0,.2), 0 8px 20px rgba(217,164,65,.4);
        position: relative; z-index: 1;
        transition: transform 0.3s ease;
    }
    .cert-head-ico:hover { transform: scale(1.05) rotate(-5deg); }
    .cert-head-ico svg { width: 28px; height: 28px; stroke: #03251f; stroke-width: 2.2; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2)); }
    
    .cert-title {
        font-family: var(--font-display); font-size: 23px; font-weight: 900; margin: 0;
        background: linear-gradient(135deg, #fff, #fde68a);
        -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
        position: relative; z-index: 1;
    }
    .cert-total-badge {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 5px 14px; border-radius: 999px; margin-top: 8px;
        font-size: 11.5px; font-weight: 800;
        background: rgba(217,164,65,.2); border: 1px solid rgba(217,164,65,.4); color: #fde68a;
        position: relative; z-index: 1;
    }
    .cert-total-badge svg { width: 13px; height: 13px; stroke: #fde68a; stroke-width: 2.2; }

    .cert-add-btn {
        position: relative; overflow: hidden; padding: 13px 24px; border-radius: 13px;
        font-size: 14px; font-weight: 800; color: #03251f; text-decoration: none;
        background: linear-gradient(145deg, #fde68a, #f2c063 40%, #d9a441);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.15), 0 8px 20px rgba(217,164,65,.4);
        transition: all .3s cubic-bezier(.16,1,.3,1);
        display: inline-flex; align-items: center; gap: 8px;
        position: relative; z-index: 1;
    }
    .cert-add-btn svg { width: 18px; height: 18px; stroke: #03251f; stroke-width: 2.5; filter: drop-shadow(0 1px 2px rgba(0,0,0,0.15)); }
    .cert-add-btn::before { content: ''; position: absolute; top: 3px; left: 10%; width: 35%; height: 35%; border-radius: 50%; background: rgba(255,255,255,.6); filter: blur(2px); pointer-events: none; }
    .cert-add-btn::after {
        content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent);
        animation: certShine 3s ease-in-out infinite;
    }
    .cert-add-btn:hover { transform: translateY(-3px); box-shadow: inset 0 2px 3px rgba(255,255,255,.8), 0 16px 34px rgba(217,164,65,.55); }
    .cert-add-btn:hover svg { animation: iconRotate 0.5s ease; }

    /* ===== FLASH ===== */
    .flash-3d {
        position: relative; padding: 15px 20px; margin-bottom: 22px; border-radius: 14px;
        font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 10px;
        overflow: hidden; box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.05), 0 6px 16px rgba(0,0,0,.1);
        animation: certFade .5s cubic-bezier(.16,1,.3,1) both;
    }
    .flash-3d svg { width: 20px; height: 20px; stroke-width: 2.2; flex-shrink: 0; }
    .flash-3d::after {
        content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent);
        animation: certShine 3s ease-in-out infinite; pointer-events: none;
    }
    .flash-success-3d { background: linear-gradient(145deg, #d1fae5, #a7f3d0); border: 1px solid rgba(16,185,129,.35); color: #065f46; }
    .flash-success-3d svg { stroke: #065f46; }
    .flash-error-3d { background: linear-gradient(145deg, #fee2e2, #fecaca); border: 1px solid rgba(220,38,38,.35); color: #991b1b; }
    .flash-error-3d svg { stroke: #991b1b; }

    /* ===== FILTER BAR ===== */
    .cert-filter {
        display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 22px;
        padding: 18px 20px; border-radius: 18px;
        background: var(--white); border: 1px solid var(--border);
        box-shadow: 0 4px 16px rgba(0,0,0,0.05);
        animation: certFade .5s .05s both;
        position: relative;
    }
    .cert-filter::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, #10b981, #059669, #f2c063);
        border-radius: 18px 18px 0 0; opacity: 0.8;
    }
    .cert-filter input[type="text"], .cert-filter select {
        padding: 12px 16px; border-radius: 12px; border: 2px solid var(--border);
        background: linear-gradient(145deg, #f6faf7, #fff); font-size: 13.5px; font-weight: 600;
        color: var(--ink); transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: inset 0 2px 4px rgba(0,0,0,.04); outline: none;
    }
    .cert-filter input[type="text"] { flex: 1; min-width: 220px; }
    .cert-filter input[type="text"]::placeholder { color: var(--muted); }
    
    .cert-filter select {
        appearance: none; -webkit-appearance: none; -moz-appearance: none;
        cursor: pointer; min-width: 170px; padding-right: 44px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='none' stroke='%23059669' stroke-width='2.5' viewBox='0 0 24 24'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 14px center !important;
        background-size: 18px 18px !important;
    }
    .cert-filter select:hover {
        border-color: rgba(5, 150, 105, 0.4); background-color: #ffffff;
        transform: translateY(-1px); box-shadow: inset 0 2px 4px rgba(0,0,0,.04), 0 6px 16px rgba(5,150,105,0.12);
    }
    .cert-filter select:focus {
        border-color: #10b981; background-color: #ffffff;
        box-shadow: inset 0 2px 4px rgba(0,0,0,.04), 0 0 0 4px rgba(16, 185, 129, 0.15), 0 6px 16px rgba(5,150,105,0.15);
    }
    .cert-filter select option { background: #ffffff; color: #03251f; padding: 10px; font-weight: 600; }

    .cert-filter-btn {
        padding: 12px 22px; border-radius: 12px; border: none; cursor: pointer;
        font-size: 13.5px; font-weight: 800; color: #fff;
        background: linear-gradient(145deg, #34d399, #10b981 50%, #059669);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.5), inset 0 -2px 3px rgba(0,0,0,.2), 0 6px 16px rgba(5,150,105,.35);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex; align-items: center; gap: 8px;
    }
    .cert-filter-btn svg { width: 16px; height: 16px; stroke: #ffffff; stroke-width: 2.5; }
    .cert-filter-btn:hover { transform: translateY(-2px); box-shadow: inset 0 2px 3px rgba(255,255,255,.6), 0 10px 24px rgba(5,150,105,.45); }

    /* ===== TABLE ===== */
    .cert-table {
        width: 100%; border-collapse: separate; border-spacing: 0;
        background: var(--white); border: 1px solid var(--border);
        border-radius: 20px; overflow: hidden; animation: certFade .5s .08s both;
        box-shadow: 0 6px 20px rgba(0,0,0,.05);
    }
    .cert-table thead th {
        padding: 15px 18px; text-align: left; font-size: 11px; font-weight: 900;
        letter-spacing: .1em; text-transform: uppercase; color: #fde68a;
        background: linear-gradient(145deg, #043b2c, #065f46);
        border-bottom: 1px solid rgba(217,164,65,0.2);
    }
    .cert-table tbody td {
        padding: 15px 18px; font-size: 13px; color: var(--ink);
        border-bottom: 1px solid var(--border); vertical-align: middle;
    }
    .cert-table tbody tr:last-child td { border-bottom: none; }
    .cert-table tbody tr { transition: background .2s; }
    .cert-table tbody tr:hover td { background: rgba(217,164,65,.05); }

    .cert-mono {
        font-family: 'Courier New', monospace; font-weight: 800; font-size: 12.5px;
        color: #047857; background: rgba(5,150,105,.08); border: 1px solid rgba(5,150,105,.25);
        padding: 4px 10px; border-radius: 8px; display: inline-flex; align-items: center; gap: 5px;
    }
    .cert-mono svg { width: 12px; height: 12px; stroke: currentColor; stroke-width: 2.5; }

    .cert-type {
        display: inline-flex; align-items: center; gap: 5px; padding: 4px 11px;
        border-radius: 999px; font-size: 10.5px; font-weight: 800;
        background: rgba(59,130,246,.1); border: 1px solid rgba(59,130,246,.3); color: #1e40af;
    }
    .cert-type svg { width: 11px; height: 11px; stroke: currentColor; stroke-width: 2.5; }

    .cert-status {
        display: inline-flex; align-items: center; gap: 6px; padding: 5px 13px;
        border-radius: 999px; font-size: 11px; font-weight: 800;
    }
    .cert-status svg { width: 12px; height: 12px; stroke: currentColor; stroke-width: 2.5; }
    .cert-status.valid {
        background: linear-gradient(145deg, #6ee7b7, #10b981); color: #064e3b;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.6);
    }
    .cert-status.revoked {
        background: linear-gradient(145deg, #fca5a5, #dc2626); color: #fff;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.4);
    }

    .cert-revoke-reason {
        font-size: 10.5px; color: var(--muted); margin-top: 5px; max-width: 160px;
        display: flex; align-items: flex-start; gap: 4px;
    }
    .cert-revoke-reason svg { width: 11px; height: 11px; stroke: currentColor; stroke-width: 2.2; flex-shrink: 0; margin-top: 1px; }

    /* ===== ACTION BUTTONS ===== */
    .cert-act {
        padding: 7px 13px; border-radius: 10px; font-size: 12px; font-weight: 800;
        text-decoration: none; display: inline-flex; align-items: center; gap: 5px;
        border: 1px solid transparent; cursor: pointer; transition: all .2s;
        font-family: inherit;
    }
    .cert-act svg { width: 13px; height: 13px; stroke: currentColor; stroke-width: 2.2; transition: all 0.3s ease; }
    .cert-act.view { background: rgba(59,130,246,.1); color: #93c5fd; border-color: rgba(59,130,246,.25); }
    .cert-act.view:hover { background: #2563eb; color: #fff; }
    .cert-act.view:hover svg { animation: iconRotate 0.5s ease; }
    .cert-act.edit { background: rgba(217,164,65,.12); color: #b45309; border-color: rgba(217,164,65,.3); }
    .cert-act.edit:hover { background: #d9a441; color: #03251f; }
    .cert-act.edit:hover svg { animation: iconRotate 0.5s ease; }
    .cert-act.revoke { background: rgba(220,38,38,.1); color: #fca5a5; border-color: rgba(220,38,38,.25); }
    .cert-act.revoke:hover { background: #dc2626; color: #fff; }
    .cert-act.revoke:hover svg { animation: iconRotate 0.5s ease; }
    .cert-act.restore { background: rgba(16,185,129,.12); color: #6ee7b7; border-color: rgba(16,185,129,.3); }
    .cert-act.restore:hover { background: #059669; color: #fff; }
    .cert-act.restore:hover svg { animation: iconRotate 0.5s ease; }

    /* ===== EMPTY STATE ===== */
    .cert-empty {
        padding: 60px 24px; text-align: center; color: var(--muted);
        display: flex; flex-direction: column; align-items: center; gap: 12px;
    }
    .cert-empty-ico {
        width: 80px; height: 80px; margin: 0 auto;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; background: linear-gradient(145deg, rgba(5,150,105,0.15), rgba(5,150,105,0.05));
        border: 2px dashed rgba(5,150,105,0.3);
    }
    .cert-empty-ico svg { width: 40px; height: 40px; stroke: var(--muted); stroke-width: 1.5; opacity: 0.6; }
    .cert-empty h3 { margin: 0; color: var(--ink); font-size: 18px; font-weight: 900; }
    .cert-empty p { margin: 0; font-size: 14px; }

    /* ===== PAGINATION ===== */
    .cert-pag { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 24px; justify-content: center; }
    .cert-pag a {
        padding: 10px 16px; border-radius: 11px; text-decoration: none;
        font-size: 13.5px; font-weight: 800; color: var(--ink);
        background: linear-gradient(145deg, #fff, #f6faf7); border: 1px solid var(--border);
        box-shadow: inset 0 1px 1px rgba(255,255,255,.9), 0 2px 5px rgba(0,0,0,.05);
        transition: all .25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .cert-pag a:hover { transform: translateY(-2px); border-color: rgba(217,164,65,.4); color: var(--gold-strong); }
    .cert-pag a.active {
        background: linear-gradient(145deg, #065f46, #043b2c); color: #fde68a; border-color: transparent;
        box-shadow: inset 0 1px 1px rgba(255,255,255,.1), 0 6px 16px rgba(5,150,105,.35);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .cert-head { flex-direction: column; align-items: flex-start; padding: 22px; }
        .cert-add-btn { width: 100%; justify-content: center; margin-top: 12px; }
        .cert-filter { flex-direction: column; }
        .cert-filter input[type="text"], .cert-filter select, .cert-filter-btn { width: 100%; min-width: 0; }
        .cert-table { display: block; overflow-x: auto; }
    }
</style>

<!-- HEADER -->
<div class="cert-head">
    <div style="display:flex; align-items:center; gap:16px; position:relative; z-index:1;">
        <div class="cert-head-ico">
            <?= renderCertIcon('award', 28, '#03251f') ?>
        </div>
        <div>
            <h2 class="cert-title">Sertifikat & Verifikasi</h2>
            <span class="cert-total-badge">
                <?= renderCertIcon('file-text', 13, 'currentColor') ?>
                <span>Total <?= (int) $total ?> sertifikat</span>
            </span>
        </div>
    </div>
    <a href="<?= e(url('admin/index.php?page=sertifikat-tambah')) ?>" class="cert-add-btn">
        <?= renderCertIcon('plus', 18, 'currentColor') ?>
        <span>Terbitkan Sertifikat</span>
    </a>
</div>

<?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
        <?= $flash['type'] === 'error' ? renderCertIcon('alert-circle', 20, 'currentColor') : renderCertIcon('check-circle', 20, 'currentColor') ?>
        <span><?= e($flash['message']) ?></span>
    </div>
<?php endif; ?>

<!-- FILTER BAR -->
<form method="get" action="<?= e(url('admin/index.php')) ?>" class="cert-filter">
    <input type="hidden" name="page" value="sertifikat">
    <input type="text" name="q" value="<?= e($filters['q']) ?>" placeholder="Cari kode / nama / kegiatan...">
    <select name="status">
        <option value="">Semua Status</option>
        <option value="valid" <?= $filters['status'] === 'valid' ? 'selected' : '' ?>>Valid</option>
        <option value="revoked" <?= $filters['status'] === 'revoked' ? 'selected' : '' ?>>Dicabut</option>
    </select>
    <button type="submit" class="cert-filter-btn">
        <?= renderCertIcon('filter', 16, 'currentColor') ?>
        <span>Filter</span>
    </button>
</form>

<!-- TABLE -->
<div style="overflow-x:auto;">
    <table class="cert-table">
        <thead>
            <tr>
                <th style="width:140px;">Kode</th>
                <th>Penerima</th>
                <th>Kegiatan</th>
                <th style="width:130px;">Terbit</th>
                <th style="width:140px;">Status</th>
                <th style="text-align:right; width:280px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($items === []): ?>
                <tr>
                    <td colspan="6">
                        <div class="cert-empty">
                            <div class="cert-empty-ico">
                                <?= renderCertIcon('inbox', 40, 'currentColor') ?>
                            </div>
                            <h3>Belum Ada Sertifikat</h3>
                            <p>Klik "Terbitkan Sertifikat" untuk membuat sertifikat pertama.</p>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td>
                        <span class="cert-mono">
                            <?= renderCertIcon('hash', 12, 'currentColor') ?>
                            <?= e($item['code']) ?>
                        </span>
                    </td>
                    <td>
                        <strong style="display:flex; align-items:center; gap:6px;">
                            <?= renderCertIcon('user', 14, 'currentColor') ?>
                            <?= e($item['holder_name']) ?>
                        </strong>
                        <?php if (!empty($item['holder_identity'])): ?>
                            <div style="font-size:11.5px; color:var(--muted); margin-top:3px; padding-left:20px;"><?= e($item['holder_identity']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="font-weight:700; color:var(--ink); line-height:1.4;"><?= e(excerpt($item['activity_title'], 60)) ?></div>
                        <div style="margin-top:5px;">
                            <span class="cert-type">
                                <?= renderCertIcon('tag', 11, 'currentColor') ?>
                                <?= e($types[$item['activity_type']] ?? ucfirst($item['activity_type'])) ?>
                            </span>
                        </div>
                    </td>
                    <td>
                        <span style="display:inline-flex; align-items:center; gap:5px; color:var(--muted); font-size:12.5px;">
                            <?= renderCertIcon('calendar', 12, 'currentColor') ?>
                            <?= e(date('d M Y', strtotime($item['issue_date']))) ?>
                        </span>
                    </td>
                    <td>
                        <span class="cert-status <?= $item['status'] === 'valid' ? 'valid' : 'revoked' ?>">
                            <?= $item['status'] === 'valid' ? renderCertIcon('check-circle', 12, 'currentColor') : renderCertIcon('x-circle', 12, 'currentColor') ?>
                            <?= $item['status'] === 'valid' ? 'VALID' : 'DICABUT' ?>
                        </span>
                        <?php if ($item['status'] === 'revoked' && !empty($item['revoke_reason'])): ?>
                            <div class="cert-revoke-reason">
                                <?= renderCertIcon('info', 11, 'currentColor') ?>
                                <span><?= e(excerpt($item['revoke_reason'], 40)) ?></span>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display:flex; gap:6px; justify-content:flex-end; flex-wrap:wrap;">
                            <a class="cert-act edit" target="_blank" href="<?= e(url('public/index.php?page=sertifikat&code=' . urlencode($item['code']))) ?>">
                                <?= renderCertIcon('printer', 13, 'currentColor') ?>
                                <span>Cetak</span>
                            </a>
                            <a class="cert-act view" target="_blank" href="<?= e(url('public/index.php?page=verifikasi-sertifikat&code=' . urlencode($item['code']))) ?>">
                                <?= renderCertIcon('link', 13, 'currentColor') ?>
                                <span>Verifikasi</span>
                            </a>
                            <a class="cert-act edit" href="<?= e(url('admin/index.php?page=sertifikat-edit&id=' . (int) $item['id'])) ?>">
                                <?= renderCertIcon('edit', 13, 'currentColor') ?>
                                <span>Edit</span>
                            </a>
                            <?php if ($item['status'] === 'valid'): ?>
                                <form method="post" action="<?= e(url('admin/index.php?page=sertifikat-cabut')) ?>" class="js-confirm" data-message="Cabut sertifikat <?= e($item['code']) ?>? Status akan jadi TIDAK VALID di halaman verifikasi." style="display:inline;">
                                    <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                                    <input type="hidden" name="reason" value="Dicabut oleh admin">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="cert-act revoke">
                                        <?= renderCertIcon('ban', 13, 'currentColor') ?>
                                        <span>Cabut</span>
                                    </button>
                                </form>
                            <?php else: ?>
                                <form method="post" action="<?= e(url('admin/index.php?page=sertifikat-aktifkan')) ?>" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="cert-act restore">
                                        <?= renderCertIcon('refresh', 13, 'currentColor') ?>
                                        <span>Aktifkan</span>
                                    </button>
                                </form>
                            <?php endif; ?>
                            <form method="post" action="<?= e(url('admin/index.php?page=sertifikat-hapus')) ?>" class="js-confirm" data-message="Hapus permanen sertifikat <?= e($item['code']) ?>?" style="display:inline;">
                                <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                                <?= csrf_field() ?>
                                <button type="submit" class="cert-act revoke" title="Hapus">
                                    <?= renderCertIcon('trash', 13, 'currentColor') ?>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- PAGINATION -->
<?php if ($totalPages > 1): ?>
    <div class="cert-pag">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= e(url('admin/index.php?page=sertifikat&hal=' . $i . ($filters['q'] !== '' ? '&q=' . urlencode($filters['q']) : '') . ($filters['status'] !== '' ? '&status=' . urlencode($filters['status']) : ''))) ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>