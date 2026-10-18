<?php
// SVG Icon Helper untuk Audit
function renderAuditIcon($name, $size = 24, $color = 'currentColor') {
    $icons = [
        'file-text' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>',
        'user' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>',
        'users' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'folder' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>',
        'search' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        'clock' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
        'globe' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>',
        'link' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>',
        'trash' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',
        'download' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>',
        'calendar' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
        'sparkle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 3l1.912 5.813a2 2 0 0 0 1.275 1.275L21 12l-5.813 1.912a2 2 0 0 0-1.275 1.275L12 21l-1.912-5.813a2 2 0 0 0-1.275-1.275L3 12l5.813-1.912a2 2 0 0 0 1.275-1.275L12 3z"></path></svg>',
        'filter' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>',
        'activity' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>',
        'shield' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
        'alert-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>',
        'log-in' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>',
        'log-out' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>',
        'plus' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>',
        'edit' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
        'eye' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>',
        'x' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>',
        'arrow-right' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
        'inbox' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>',
        'award' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>',
        'bar-chart' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>',
        'database' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>',
    ];
    return $icons[$name] ?? $icons['sparkle'];
}

function al_ago(?string $d): string {
    if (!$d) return '—';
    $diff = time() - strtotime($d);
    if ($diff < 60) return 'Baru saja';
    if ($diff < 3600) return floor($diff / 60) . ' menit lalu';
    if ($diff < 86400) return floor($diff / 3600) . ' jam lalu';
    if ($diff < 604800) return floor($diff / 86400) . ' hari lalu';
    return date('d M Y · H:i', strtotime($d));
}
?>

<style>
    @keyframes alFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    @keyframes iconRotate {
        0%, 100% { transform: rotate(0deg) scale(1); }
        25% { transform: rotate(-5deg) scale(1.05); }
        75% { transform: rotate(5deg) scale(1.05); }
    }
    @keyframes orbPulse {
        0%, 100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.1); }
    }
    @keyframes timelinePulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(59,130,246,0.5); }
        50% { box-shadow: 0 0 0 6px rgba(59,130,246,0); }
    }
    @keyframes dotPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); }
    }

    /* ===== SVG BASE ===== */
    .al-svg {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        vertical-align: middle;
    }
    .al-svg svg {
        display: block;
        transition: all 0.3s ease;
    }

    /* ===== HERO HEADER ===== */
    .al-head {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 24px;
        padding: 28px 32px;
        border-radius: 24px;
        background:
            radial-gradient(360px 200px at 10% 0%, rgba(217,164,65,0.22), transparent 70%),
            linear-gradient(135deg, #1e3a8a 0%, #3b82f6 55%, #60a5fa 100%);
        color: #fff;
        box-shadow: 0 20px 50px rgba(0,0,0,0.35);
        animation: alFade 0.5s both;
    }
    .al-head::before {
        content: '';
        position: absolute;
        inset: 0;
        opacity: 0.2;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 25px, rgba(255,255,255,0.04) 25px, rgba(255,255,255,0.04) 26px);
        pointer-events: none;
    }
    .al-head::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -8%;
        width: 340px;
        height: 340px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,0.25), transparent 70%);
        pointer-events: none;
        animation: orbPulse 5s ease-in-out infinite;
    }
    .al-head-ico {
        width: 60px;
        height: 60px;
        border-radius: 17px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.55), transparent 45%),
                    linear-gradient(145deg, #fde68a, #f2c063 55%, #a9761b);
        box-shadow:
            inset 0 2px 3px rgba(255,255,255,0.6),
            inset 0 -3px 4px rgba(0,0,0,0.2),
            0 8px 20px rgba(217,164,65,0.45);
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
    }
    .al-head-ico:hover {
        transform: scale(1.08) rotate(-5deg);
    }
    .al-head-ico svg {
        width: 30px;
        height: 30px;
        stroke: #03251f;
        stroke-width: 2.2;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }
    .al-head h2 {
        margin: 0;
        font-family: var(--font-display);
        font-size: 23px;
        font-weight: 900;
        position: relative;
        z-index: 1;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 10px;
        text-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .al-head p {
        margin: 4px 0 0;
        font-size: 13px;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }

    /* ===== STATS ===== */
    .al-stats {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-left: auto;
        position: relative;
        z-index: 1;
    }
    .al-stat {
        background: rgba(255,255,255,0.14);
        border: 1px solid rgba(255,255,255,0.22);
        border-radius: 15px;
        padding: 11px 18px;
        text-align: center;
        min-width: 90px;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }
    .al-stat:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px);
    }
    .al-stat b {
        display: block;
        font-family: var(--font-display);
        font-size: 20px;
        font-weight: 900;
        color: #fde68a;
        line-height: 1.1;
        filter: drop-shadow(0 2px 4px rgba(217,164,65,0.3));
    }
    .al-stat b.warn { color: #fca5a5; }
    .al-stat span {
        font-size: 9.5px;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        opacity: 0.85;
        display: block;
        margin-top: 3px;
    }

    /* ===== FILTER BAR ===== */
    .al-bar {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
        margin-bottom: 18px;
        padding: 16px 20px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 18px;
        animation: alFade 0.5s 0.06s both;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        position: relative;
    }
    .al-bar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #3b82f6, #1e3a8a, #f2c063);
        border-radius: 18px 18px 0 0;
    }
    .al-bar label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 800;
        color: var(--muted);
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    .al-bar label svg {
        width: 14px;
        height: 14px;
        stroke: var(--gold-strong);
        stroke-width: 2.2;
    }
    .al-bar select, .al-bar input {
        padding: 10px 16px;
        border-radius: 11px;
        border: 1px solid var(--border);
        background: var(--surface-2);
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
        transition: all 0.25s ease;
        outline: none;
    }
    .al-bar select {
        cursor: pointer;
        min-width: 160px;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23f2c063' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 38px;
    }
    .al-bar input[type="text"] {
        min-width: 230px;
        flex: 1;
    }
    .al-bar select:focus, .al-bar input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59,130,246,0.15);
        background: rgba(255,255,255,0.06);
    }
    .al-bar select option {
        background: var(--surface-2);
        color: var(--text);
    }
    .al-bar .spacer { flex: 1; }

    /* ===== BUTTONS ===== */
    .al-btn-primary {
        padding: 10px 18px;
        border-radius: 11px;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.16,1,0.3,1);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        position: relative;
        overflow: hidden;
    }
    .al-btn-primary svg {
        width: 16px;
        height: 16px;
        stroke: currentColor;
        stroke-width: 2.2;
        transition: all 0.3s ease;
    }
    .al-btn-primary.filter-btn {
        color: #fff;
        background: linear-gradient(145deg, #3b82f6, #1e3a8a);
        box-shadow: inset 0 1px 2px rgba(255,255,255,0.2), 0 4px 12px rgba(59,130,246,0.3);
    }
    .al-btn-primary.export-btn {
        color: #03251f;
        background: linear-gradient(145deg, #fde68a, #f2c063 55%, #d9a441);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -2px 3px rgba(0,0,0,0.15), 0 6px 16px rgba(217,164,65,0.35);
    }
    .al-btn-primary:hover {
        transform: translateY(-2px);
        filter: brightness(1.05);
    }
    .al-btn-primary:hover svg {
        animation: iconRotate 0.5s ease;
    }
    .al-btn-primary.export-btn::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,0.5), transparent);
        animation: alFade 3s ease-in-out infinite;
    }

    /* ===== ACTION CHIPS ===== */
    .al-chips {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 18px;
        animation: alFade 0.5s 0.1s both;
    }
    .al-chip {
        padding: 8px 16px;
        border-radius: 999px;
        border: 1px solid var(--border);
        background: var(--surface);
        font-size: 12px;
        font-weight: 800;
        color: var(--text);
        text-decoration: none;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    }
    .al-chip svg {
        width: 15px;
        height: 15px;
        stroke: currentColor;
        stroke-width: 2.2;
        transition: all 0.3s ease;
    }
    .al-chip:hover {
        border-color: rgba(59,130,246,0.45);
        color: #3b82f6;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(59,130,246,0.15);
    }
    .al-chip:hover svg {
        animation: iconRotate 0.5s ease;
    }
    .al-chip.active {
        background: linear-gradient(145deg, #3b82f6, #1e3a8a);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 6px 16px rgba(59,130,246,0.35);
    }
    .al-chip b {
        font-size: 10px;
        background: rgba(255,255,255,0.18);
        padding: 2px 8px;
        border-radius: 999px;
        font-weight: 900;
    }
    .al-chip.active b {
        background: rgba(255,255,255,0.25);
    }

    /* ===== TIMELINE ===== */
    .al-tl {
        position: relative;
        padding-left: 34px;
        animation: alFade 0.5s 0.14s both;
    }
    .al-tl::before {
        content: '';
        position: absolute;
        left: 14px;
        top: 8px;
        bottom: 8px;
        width: 2px;
        background: linear-gradient(180deg,
            rgba(59,130,246,0.5),
            rgba(59,130,246,0.3) 50%,
            rgba(59,130,246,0.08));
        border-radius: 2px;
    }
    .al-tl::after {
        content: '';
        position: absolute;
        left: 8px;
        top: 0;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #60a5fa, #3b82f6 60%, #1e3a8a);
        box-shadow: 0 0 0 3px var(--bg), 0 0 14px rgba(59,130,246,0.5);
        animation: timelinePulse 2.5s ease-in-out infinite;
    }

    /* ===== TIMELINE ITEMS ===== */
    .al-item {
        position: relative;
        margin-bottom: 14px;
        padding: 16px 20px;
        border-radius: 16px;
        background: var(--surface);
        border: 1px solid var(--border);
        transition: all 0.35s cubic-bezier(0.16,1,0.3,1);
        display: flex;
        gap: 16px;
        align-items: flex-start;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .al-item:hover {
        border-color: rgba(59,130,246,0.35);
        transform: translateX(4px);
        box-shadow: 0 12px 28px rgba(3,37,31,0.1);
    }
    .al-item::before {
        content: '';
        position: absolute;
        left: -28px;
        top: 20px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%,
            rgba(var(--rgb,59,130,246),1),
            rgba(var(--rgb,59,130,246),0.8));
        box-shadow: 0 0 0 3px var(--surface),
                    0 0 12px rgba(var(--rgb,59,130,246),0.5);
        animation: dotPulse 2s ease-in-out infinite;
    }

    /* ===== ICON CONTAINER ===== */
    .al-ico {
        width: 44px;
        height: 44px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: linear-gradient(145deg,
            rgba(var(--rgb,59,130,246),0.18),
            rgba(var(--rgb,59,130,246),0.08));
        border: 1px solid rgba(var(--rgb,59,130,246),0.25);
        color: var(--hex,#3b82f6);
        transition: all 0.3s ease;
    }
    .al-item:hover .al-ico {
        transform: scale(1.08) rotate(-5deg);
    }
    .al-ico svg {
        width: 22px;
        height: 22px;
        stroke: var(--hex,#3b82f6);
        stroke-width: 2.2;
        filter: drop-shadow(0 2px 4px rgba(var(--rgb,59,130,246),0.3));
    }

    /* ===== BODY ===== */
    .al-body { flex: 1; min-width: 0; }
    .al-title {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        font-size: 14px;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 6px;
    }
    .al-user {
        color: var(--ink);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .al-user svg {
        width: 14px;
        height: 14px;
        stroke: var(--muted);
        stroke-width: 2.2;
    }
    .al-action {
        padding: 3px 11px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 900;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        background: rgba(var(--rgb,59,130,246),0.15);
        color: var(--hex,#3b82f6);
        border: 1px solid rgba(var(--rgb,59,130,246),0.3);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .al-action svg {
        width: 11px;
        height: 11px;
        stroke: currentColor;
        stroke-width: 2.5;
    }
    .al-role {
        font-size: 11px;
        color: var(--muted);
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 999px;
        background: rgba(255,255,255,0.05);
        border: 1px solid var(--border);
    }
    .al-entity {
        font-size: 12.5px;
        color: var(--muted);
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .al-entity svg {
        width: 13px;
        height: 13px;
        stroke: var(--gold-strong);
        stroke-width: 2.2;
        flex-shrink: 0;
    }
    .al-entity b {
        color: var(--ink);
        font-weight: 800;
    }
    .al-entity i {
        color: var(--gold-strong);
        font-style: italic;
    }
    .al-entity code {
        font-family: 'Courier New', monospace;
        font-size: 10.5px;
        padding: 1px 6px;
        background: rgba(59,130,246,0.12);
        color: #60a5fa;
        border-radius: 4px;
        border: 1px solid rgba(59,130,246,0.2);
    }

    /* ===== META ===== */
    .al-meta {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        font-size: 11.5px;
        color: var(--muted);
    }
    .al-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .al-meta svg {
        width: 13px;
        height: 13px;
        stroke: currentColor;
        stroke-width: 2;
        opacity: 0.7;
    }
    .al-meta code {
        font-family: 'Courier New', monospace;
        font-size: 10px;
        padding: 2px 7px;
        background: rgba(255,255,255,0.05);
        border: 1px solid var(--border);
        border-radius: 4px;
        color: var(--text);
    }

    /* ===== ACTION BUTTONS ===== */
    .al-act {
        display: flex;
        gap: 6px;
        flex-shrink: 0;
        align-items: center;
    }
    .al-btn {
        padding: 8px 11px;
        border-radius: 10px;
        border: 1px solid var(--border);
        background: rgba(255,255,255,0.04);
        color: var(--muted);
        font-size: 12px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .al-btn svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2.2;
        transition: all 0.3s ease;
    }
    .al-btn:hover {
        border-color: rgba(59,130,246,0.45);
        color: #3b82f6;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(59,130,246,0.15);
    }
    .al-btn:hover svg {
        animation: iconRotate 0.5s ease;
    }
    .al-btn.danger:hover {
        border-color: rgba(220,38,38,0.5);
        color: #fca5a5;
        background: rgba(220,38,38,0.08);
        box-shadow: 0 4px 10px rgba(220,38,38,0.15);
    }

    /* ===== EMPTY STATE ===== */
    .al-empty {
        text-align: center;
        padding: 70px 24px;
        color: var(--muted);
        background: linear-gradient(145deg, rgba(59,130,246,0.04), rgba(59,130,246,0.01));
        border: 2px dashed rgba(59,130,246,0.25);
        border-radius: 22px;
        animation: alFade 0.5s both;
    }
    .al-empty-ico {
        width: 80px;
        height: 80px;
        margin: 0 auto 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: linear-gradient(145deg, rgba(59,130,246,0.15), rgba(59,130,246,0.08));
        border: 2px dashed rgba(59,130,246,0.3);
        opacity: 0.7;
    }
    .al-empty-ico svg {
        width: 40px;
        height: 40px;
        stroke: var(--muted);
        stroke-width: 1.5;
    }
    .al-empty h3 {
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 900;
        color: var(--ink);
        margin: 0 0 8px;
    }
    .al-empty p {
        font-size: 14px;
        margin: 0;
    }

    /* ===== PAGINATION ===== */
    .pag-3d {
        padding: 9px 15px;
        border-radius: 11px;
        font-size: 13px;
        font-weight: 800;
        color: var(--text);
        background: var(--surface);
        border: 1px solid var(--border);
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        text-decoration: none;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
    }
    .pag-3d:hover {
        transform: translateY(-2px);
        border-color: rgba(59,130,246,0.45);
        color: #3b82f6;
        box-shadow: 0 6px 14px rgba(59,130,246,0.15);
    }
    .pag-3d.active {
        background: linear-gradient(145deg, #3b82f6, #1e3a8a);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 6px 16px rgba(59,130,246,0.35);
    }

    /* ===== PURGE SECTION ===== */
    .al-purge {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        background: linear-gradient(145deg, rgba(220,38,38,0.08), rgba(220,38,38,0.03));
        border: 1px dashed rgba(220,38,38,0.35);
        border-radius: 14px;
        margin-top: 22px;
        font-size: 12.5px;
        color: #991b1b;
        flex-wrap: wrap;
        animation: alFade 0.5s 0.2s both;
    }
    .al-purge svg {
        width: 20px;
        height: 20px;
        stroke: #dc2626;
        stroke-width: 2.2;
        flex-shrink: 0;
        filter: drop-shadow(0 2px 4px rgba(220,38,38,0.3));
    }
    .al-purge b {
        color: #991b1b;
        font-weight: 900;
    }
    .al-purge button {
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 800;
        border: 1px solid rgba(220,38,38,0.35);
        background: rgba(220,38,38,0.1);
        color: #dc2626;
        cursor: pointer;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .al-purge button svg {
        width: 14px;
        height: 14px;
        stroke: #dc2626;
        stroke-width: 2.5;
    }
    .al-purge button:hover {
        background: rgba(220,38,38,0.2);
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(220,38,38,0.2);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .al-head {
            flex-direction: column;
            align-items: flex-start;
            padding: 22px;
        }
        .al-stats {
            margin-left: 0;
            margin-top: 16px;
            width: 100%;
        }
        .al-stat {
            flex: 1;
            min-width: 80px;
        }
        .al-bar {
            flex-direction: column;
            align-items: stretch;
        }
        .al-bar select, .al-bar input {
            min-width: 0;
            width: 100%;
        }
        .al-tl {
            padding-left: 28px;
        }
        .al-item {
            flex-direction: column;
            padding: 14px;
        }
        .al-ico {
            width: 40px;
            height: 40px;
        }
        .al-ico svg {
            width: 20px;
            height: 20px;
        }
        .al-act {
            width: 100%;
            justify-content: flex-end;
            margin-top: 8px;
        }
    }
</style>

<!-- ===== HERO ===== -->
<div class="al-head">
    <div class="al-head-ico">
        <?= renderAuditIcon('file-text', 30, '#03251f') ?>
    </div>
    <div style="position:relative;z-index:1;">
        <h2>
            <?= renderAuditIcon('activity', 22, '#fde68a') ?>
            <span>Audit Log · Activity Trail</span>
        </h2>
        <p>Jejak lengkap aktivitas pengguna untuk akuntabilitas SPMI dan audit AMI.</p>
    </div>
    <div class="al-stats">
        <div class="al-stat">
            <b><?= number_format($stats['total']) ?></b>
            <span>Total Log</span>
        </div>
        <div class="al-stat">
            <b><?= number_format($stats['today']) ?></b>
            <span>Hari Ini</span>
        </div>
        <div class="al-stat">
            <b><?= number_format($stats['week']) ?></b>
            <span>7 Hari</span>
        </div>
        <div class="al-stat">
            <b><?= number_format($stats['unique']) ?></b>
            <span>Pengguna</span>
        </div>
        <?php if ($stats['login_fail'] > 0): ?>
        <div class="al-stat">
            <b class="warn"><?= (int) $stats['login_fail'] ?></b>
            <span>Login Gagal</span>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? renderAuditIcon('alert-circle', 18, 'currentColor') : renderAuditIcon('shield', 18, 'currentColor') ?>
    <span><?= e($flash['message']) ?></span>
</div>
<?php endif; ?>

<!-- ===== FILTER BAR ===== -->
<form method="get" action="<?= e(url('admin/index.php')) ?>" class="al-bar">
    <input type="hidden" name="page" value="audit">

    <label>
        <?= renderAuditIcon('calendar', 14, 'currentColor') ?>
        <span>Periode</span>
    </label>
    <select name="period">
        <option value="" <?= $filters['period'] === '' ? 'selected' : '' ?>>Semua Waktu</option>
        <option value="today" <?= $filters['period'] === 'today' ? 'selected' : '' ?>>Hari Ini</option>
        <option value="week" <?= $filters['period'] === 'week' ? 'selected' : '' ?>>7 Hari Terakhir</option>
        <option value="month" <?= $filters['period'] === 'month' ? 'selected' : '' ?>>30 Hari Terakhir</option>
    </select>

    <label>
        <?= renderAuditIcon('user', 14, 'currentColor') ?>
        <span>Pengguna</span>
    </label>
    <select name="user_id">
        <option value="">Semua Pengguna</option>
        <?php foreach ($users as $u): ?>
        <option value="<?= (int) $u['user_id'] ?>" <?= (string) $filters['user_id'] === (string) $u['user_id'] ? 'selected' : '' ?>>
            <?= e($u['user_name']) ?>
        </option>
        <?php endforeach; ?>
    </select>

    <label>
        <?= renderAuditIcon('folder', 14, 'currentColor') ?>
        <span>Entitas</span>
    </label>
    <select name="entity">
        <option value="">Semua Entitas</option>
        <?php foreach ($entityTypes as $et): ?>
        <option value="<?= e($et) ?>" <?= $filters['entity'] === $et ? 'selected' : '' ?>><?= e($et) ?></option>
        <?php endforeach; ?>
    </select>

    <label>
        <?= renderAuditIcon('search', 14, 'currentColor') ?>
        <span>Cari</span>
    </label>
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="Cari pengguna, URL, IP...">

    <button type="submit" class="al-btn-primary filter-btn">
        <?= renderAuditIcon('filter', 16, 'currentColor') ?>
        <span>Filter</span>
    </button>

    <span class="spacer"></span>

    <a class="al-btn-primary export-btn" href="<?= e(url('admin/index.php?page=audit-export&' . http_build_query($filters + ['q' => $q]))) ?>">
        <?= renderAuditIcon('download', 16, 'currentColor') ?>
        <span>Export CSV</span>
    </a>
</form>

<!-- ===== ACTION CHIPS ===== -->
<div class="al-chips">
    <a class="al-chip <?= $filters['action'] === '' ? 'active' : '' ?>"
       href="<?= e(url('admin/index.php?page=audit&period=' . urlencode($filters['period']) . '&user_id=' . urlencode($filters['user_id']) . '&entity=' . urlencode($filters['entity']) . '&q=' . urlencode($q))) ?>">
        <?= renderAuditIcon('sparkle', 15, 'currentColor') ?>
        <span>Semua</span>
        <b><?= number_format($stats['total']) ?></b>
    </a>
    <?php foreach ($actions as $ak => $av): ?>
    <a class="al-chip <?= $filters['action'] === $ak ? 'active' : '' ?>"
       href="<?= e(url('admin/index.php?page=audit&action=' . urlencode($ak) . '&period=' . urlencode($filters['period']) . '&user_id=' . urlencode($filters['user_id']) . '&entity=' . urlencode($filters['entity']) . '&q=' . urlencode($q))) ?>"
       style="--rgb:<?= $av['rgb'] ?>; --hex:<?= $av['hex'] ?>;">
        <?= renderAuditIcon($av['icon'] ?? 'activity', 15, 'currentColor') ?>
        <span><?= e($av['label']) ?></span>
    </a>
    <?php endforeach; ?>
</div>

<!-- ===== TIMELINE / EMPTY STATE ===== -->
<?php if (empty($items)): ?>
    <div class="al-empty">
        <div class="al-empty-ico">
            <?= renderAuditIcon('inbox', 40, 'currentColor') ?>
        </div>
        <h3>Tidak Ada Log yang Cocok</h3>
        <p>Coba ubah filter atau kata kunci pencarian Anda.</p>
    </div>
<?php else: ?>
<div class="al-tl">
    <?php foreach ($items as $row):
        $ai = AuditLog::actionInfo($row['action']);
    ?>
    <div class="al-item" style="--rgb:<?= $ai['rgb'] ?>; --hex:<?= $ai['hex'] ?>;">
        <div class="al-ico">
            <?= renderAuditIcon($ai['icon'] ?? 'activity', 22, 'currentColor') ?>
        </div>
        <div class="al-body">
            <div class="al-title">
                <span class="al-user">
                    <?= renderAuditIcon('user', 14, 'currentColor') ?>
                    <span><?= e($row['user_name'] ?? 'Sistem') ?></span>
                </span>
                <span class="al-action">
                    <?= renderAuditIcon($ai['icon'] ?? 'activity', 11, 'currentColor') ?>
                    <span><?= e($ai['label']) ?></span>
                </span>
                <?php if (!empty($row['user_role'])): ?>
                <span class="al-role">
                    <?= renderAuditIcon('award', 10, 'currentColor') ?>
                    <span><?= e(ucfirst($row['user_role'])) ?></span>
                </span>
                <?php endif; ?>
            </div>
            <?php if (!empty($row['entity_type'])): ?>
            <div class="al-entity">
                <?= renderAuditIcon('folder', 13, 'currentColor') ?>
                <b><?= e($row['entity_type']) ?></b>
                <?php if (!empty($row['entity_label'])): ?>
                    <span>·</span>
                    <i><?= e($row['entity_label']) ?></i>
                <?php endif; ?>
                <?php if (!empty($row['entity_id'])): ?>
                    <code>#<?= (int) $row['entity_id'] ?></code>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="al-meta">
                <span>
                    <?= renderAuditIcon('clock', 13, 'currentColor') ?>
                    <span><?= e(al_ago($row['created_at'])) ?></span>
                </span>
                <span>
                    <?= renderAuditIcon('globe', 13, 'currentColor') ?>
                    <code><?= e($row['ip_address'] ?? '—') ?></code>
                </span>
                <?php if (!empty($row['url'])): ?>
                <span>
                    <?= renderAuditIcon('link', 13, 'currentColor') ?>
                    <code><?= e(substr($row['url'], 0, 45)) ?><?= strlen($row['url'] ?? '') > 45 ? '…' : '' ?></code>
                </span>
                <?php endif; ?>
            </div>
        </div>
        <div class="al-act">
            <a class="al-btn" href="<?= e(url('admin/index.php?page=audit-detail&id=' . $row['id'])) ?>" title="Detail">
                <?= renderAuditIcon('eye', 14, 'currentColor') ?>
                <span>Detail</span>
            </a>
            <form method="post" action="<?= e(url('admin/index.php?page=audit-hapus')) ?>" style="display:inline;" onsubmit="return confirm('Hapus log ini?');">
                <?= csrf_field() ?>
                <input type="hidden" name="purge_action" value="one">
                <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                <button class="al-btn danger" type="submit" title="Hapus">
                    <?= renderAuditIcon('trash', 14, 'currentColor') ?>
                </button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- ===== PAGINATION ===== -->
<?php if ($totalPages > 1): ?>
<div style="margin-top:22px; display:flex; justify-content:center; gap:6px; flex-wrap:wrap;">
    <?php
    $qp = http_build_query(array_filter([
        'period' => $filters['period'], 'action' => $filters['action'],
        'user_id' => $filters['user_id'], 'entity' => $filters['entity'], 'q' => $q,
    ]));
    for ($i = 1; $i <= $totalPages; $i++):
    ?>
    <a href="<?= e(url('admin/index.php?page=audit&hal=' . $i . '&' . $qp)) ?>" class="pag-3d <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<!-- ===== PURGE ===== -->
<form method="post" action="<?= e(url('admin/index.php?page=audit-hapus')) ?>" class="al-purge" onsubmit="return confirm('Hapus semua log yang lebih lama dari 90 hari? Aksi tidak dapat dibatalkan.');">
    <?= csrf_field() ?>
    <input type="hidden" name="purge_action" value="old">
    <?= renderAuditIcon('trash', 20, '#dc2626') ?>
    <span><b>Pembersihan Otomatis:</b> hapus log yang lebih lama dari 90 hari untuk menjaga ukuran tabel.</span>
    <button type="submit" style="margin-left:auto;">
        <?= renderAuditIcon('trash', 14, 'currentColor') ?>
        <span>Hapus Log Lama</span>
    </button>
</form>
<?php endif; ?>