<?php
// SVG Icon Helper untuk Audit Detail (reuse dari audit/index.php)
function renderAuditDetailIcon($name, $size = 24, $color = 'currentColor') {
    $icons = [
        'chevron-left' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>',
        'folder' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>',
        'globe' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>',
        'link' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>',
        'monitor' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>',
        'git-compare' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path d="M13 6h3a2 2 0 0 1 2 2v7"></path><line x1="6" y1="9" x2="6" y2="21"></line></svg>',
        'database' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>',
        'arrow-right' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
        'hash' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="4" y1="9" x2="20" y2="9"></line><line x1="4" y1="15" x2="20" y2="15"></line><line x1="10" y1="3" x2="8" y2="21"></line><line x1="16" y1="3" x2="14" y2="21"></line></svg>',
        'clock' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
        'user' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>',
        'award' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>',
        'copy' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>',
        'check' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>',
        'inbox' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>',
        'activity' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>',
        'plus' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>',
        'minus' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line></svg>',
        'edit' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
    ];
    return $icons[$name] ?? $icons['activity'];
}

$ai = AuditLog::actionInfo($item['action']);
$old = $item['old_value']; $new = $item['new_value'];
$oldArr = is_string($old) ? @json_decode($old, true) : null;
$newArr = is_string($new) ? @json_decode($new, true) : null;

function al_pretty($v) {
    if ($v === null) return '<span style="opacity:.5; font-style:italic;">(kosong)</span>';
    if (is_string($v)) { 
        $j = @json_decode($v, true); 
        if ($j !== null) $v = $j; 
        else return '<span style="white-space:pre-wrap;">' . e($v) . '</span>'; 
    }
    $j = json_encode($v, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    return e($j);
}

function al_diff(?array $old, ?array $new): array {
    $changed = [];
    $allKeys = array_unique(array_merge(array_keys($old ?? []), array_keys($new ?? [])));
    foreach ($allKeys as $k) {
        $a = $old[$k] ?? null;
        $b = $new[$k] ?? null;
        if ($a !== $b && $k !== 'password') {
            $changed[$k] = ['old' => $a, 'new' => $b];
        }
    }
    return $changed;
}
$diff = al_diff(is_array($oldArr) ? $oldArr : null, is_array($newArr) ? $newArr : null);
?>

<style>
    @keyframes aldFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    @keyframes iconRotate {
        0%, 100% { transform: rotate(0deg) scale(1); }
        25% { transform: rotate(-5deg) scale(1.05); }
        75% { transform: rotate(5deg) scale(1.05); }
    }
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    @keyframes diffHighlight {
        0%, 100% { box-shadow: 0 0 0 0 rgba(59,130,246,0); }
        50% { box-shadow: 0 0 0 3px rgba(59,130,246,0.2); }
    }

    /* ===== BACK BUTTON ===== */
    .ald-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #3b82f6;
        text-decoration: none;
        margin-bottom: 20px;
        padding: 9px 18px;
        border-radius: 999px;
        background: var(--surface);
        border: 1px solid var(--border);
        transition: all 0.25s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }
    .ald-back svg {
        width: 16px;
        height: 16px;
        stroke: currentColor;
        stroke-width: 2.5;
        transition: all 0.3s ease;
    }
    .ald-back:hover {
        transform: translateX(-4px);
        border-color: rgba(59,130,246,0.45);
        background: rgba(59,130,246,0.08);
        box-shadow: 0 6px 14px rgba(59,130,246,0.15);
    }
    .ald-back:hover svg {
        animation: iconRotate 0.5s ease;
    }

    /* ===== HEADER ===== */
    .ald-head {
        position: relative;
        overflow: hidden;
        display: flex;
        gap: 18px;
        align-items: center;
        padding: 26px 30px;
        border-radius: 22px;
        background:
            radial-gradient(360px 200px at 10% 0%, rgba(var(--rgb),0.22), transparent 70%),
            linear-gradient(135deg, rgba(var(--rgb),0.14), rgba(var(--rgb),0.04));
        border: 1px solid rgba(var(--rgb),0.35);
        margin-bottom: 20px;
        animation: aldFade 0.5s both;
        box-shadow: 0 8px 24px rgba(var(--rgb),0.12);
    }
    .ald-head::before {
        content: '';
        position: absolute;
        inset: 0;
        opacity: 0.15;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(255,255,255,0.03) 20px, rgba(255,255,255,0.03) 21px);
        pointer-events: none;
    }
    .ald-head::after {
        content: '';
        position: absolute;
        top: -40%;
        right: -5%;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(var(--rgb),0.15), transparent 70%);
        pointer-events: none;
    }
    .ald-head .ico {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: linear-gradient(145deg,
            rgba(var(--rgb),0.25),
            rgba(var(--rgb),0.12));
        border: 1px solid rgba(var(--rgb),0.35);
        color: var(--hex);
        position: relative;
        z-index: 1;
        box-shadow:
            inset 0 1px 2px rgba(255,255,255,0.08),
            0 4px 12px rgba(var(--rgb),0.2);
        transition: all 0.3s ease;
    }
    .ald-head:hover .ico {
        transform: scale(1.05) rotate(-3deg);
    }
    .ald-head .ico svg {
        width: 28px;
        height: 28px;
        stroke: var(--hex);
        stroke-width: 2.2;
        filter: drop-shadow(0 2px 4px rgba(var(--rgb),0.3));
    }
    .ald-head-info {
        flex: 1;
        min-width: 0;
        position: relative;
        z-index: 1;
    }
    .ald-head h2 {
        margin: 0 0 5px;
        font-family: var(--font-display);
        font-size: 20px;
        font-weight: 900;
        color: var(--text);
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .ald-head h2 .action-label {
        color: var(--hex);
        background: rgba(var(--rgb),0.18);
        padding: 2px 10px;
        border-radius: 999px;
        font-size: 12px;
        border: 1px solid rgba(var(--rgb),0.35);
    }
    .ald-head p {
        margin: 0;
        font-size: 13px;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .ald-head p svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2;
        opacity: 0.7;
    }
    .ald-head p .sep {
        width: 3px;
        height: 3px;
        border-radius: 50%;
        background: var(--muted);
        opacity: 0.5;
    }
    .ald-id {
        margin-left: auto;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 900;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.1em;
        background: rgba(var(--rgb),0.18);
        color: var(--hex);
        border: 1px solid rgba(var(--rgb),0.35);
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.05);
    }
    .ald-id svg {
        width: 12px;
        height: 12px;
        stroke: currentColor;
        stroke-width: 2.5;
    }

    /* ===== INFO GRID ===== */
    .ald-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 20px;
    }
    @media(max-width:800px) { .ald-grid { grid-template-columns: 1fr; } }
    
    .ald-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 22px 24px;
        animation: aldFade 0.5s 0.05s both;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .ald-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        border-color: rgba(59,130,246,0.25);
    }
    .ald-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #3b82f6, #60a5fa, #1e3a8a);
        opacity: 0.7;
    }
    .ald-card h3 {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 16px;
        font-family: var(--font-display);
        font-size: 14px;
        font-weight: 900;
        color: #fff;
        padding-bottom: 12px;
        border-bottom: 1px dashed var(--border);
    }
    .ald-card h3 .card-ico {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(145deg, rgba(59,130,246,0.18), rgba(59,130,246,0.08));
        border: 1px solid rgba(59,130,246,0.25);
        transition: all 0.3s ease;
    }
    .ald-card:hover h3 .card-ico {
        transform: scale(1.08) rotate(-5deg);
    }
    .ald-card h3 .card-ico svg {
        width: 18px;
        height: 18px;
        stroke: #60a5fa;
        stroke-width: 2.2;
        filter: drop-shadow(0 1px 2px rgba(59,130,246,0.3));
    }
    .ald-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px dashed var(--border);
        font-size: 13px;
        transition: all 0.2s ease;
    }
    .ald-row:last-child { border-bottom: none; }
    .ald-row:hover {
        background: rgba(59,130,246,0.04);
        padding-left: 8px;
        margin-left: -8px;
        padding-right: 8px;
        margin-right: -8px;
        border-radius: 8px;
    }
    .ald-row .k {
        color: var(--muted);
        font-weight: 700;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }
    .ald-row .k svg {
        width: 13px;
        height: 13px;
        stroke: var(--gold-strong);
        stroke-width: 2.2;
    }
    .ald-row .v {
        color: var(--text);
        font-weight: 700;
        text-align: right;
        max-width: 65%;
        word-break: break-all;
        font-family: 'Courier New', monospace;
        font-size: 12px;
        padding: 2px 8px;
        background: rgba(59,130,246,0.08);
        border-radius: 6px;
        border: 1px solid rgba(59,130,246,0.15);
    }
    .ald-row .v.plain {
        font-family: var(--font-body);
        background: transparent;
        border: none;
        padding: 0;
        font-size: 13px;
    }
    .ald-row .v.small {
        font-size: 10.5px;
        line-height: 1.5;
    }

    /* ===== DIFF SECTION ===== */
    .ald-diff {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 24px;
        margin-bottom: 20px;
        animation: aldFade 0.5s 0.1s both;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
    }
    .ald-diff::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #f59e0b, #f2c063, #d9a441);
        opacity: 0.85;
    }
    .ald-diff h3 {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 18px;
        font-family: var(--font-display);
        font-size: 15px;
        font-weight: 900;
        color: #fff;
    }
    .ald-diff h3 .card-ico {
        width: 36px;
        height: 36px;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(145deg, rgba(245,158,11,0.18), rgba(245,158,11,0.08));
        border: 1px solid rgba(245,158,11,0.25);
    }
    .ald-diff h3 .card-ico svg {
        width: 20px;
        height: 20px;
        stroke: #f59e0b;
        stroke-width: 2.2;
        filter: drop-shadow(0 1px 2px rgba(245,158,11,0.3));
    }
    .ald-diff h3 .count {
        margin-left: auto;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 900;
        background: rgba(245,158,11,0.15);
        color: #f59e0b;
        border: 1px solid rgba(245,158,11,0.3);
    }

    .ald-diff-empty {
        text-align: center;
        padding: 40px 20px;
        color: var(--muted);
        font-size: 13px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }
    .ald-diff-empty svg {
        width: 48px;
        height: 48px;
        stroke: var(--muted);
        stroke-width: 1.5;
        opacity: 0.4;
    }

    .ald-diff-row {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 14px;
        align-items: start;
        padding: 14px 16px;
        border-radius: 14px;
        background: rgba(255,255,255,0.02);
        border: 1px solid var(--border);
        margin-bottom: 12px;
        transition: all 0.3s ease;
        animation: diffHighlight 2s ease-in-out;
    }
    .ald-diff-row:last-child { margin-bottom: 0; }
    .ald-diff-row:hover {
        background: rgba(255,255,255,0.04);
        border-color: rgba(59,130,246,0.25);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }
    .ald-diff-field {
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--gold-strong);
        margin-bottom: 8px;
        grid-column: 1/-1;
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Courier New', monospace;
        padding: 4px 10px;
        background: rgba(217,164,65,0.08);
        border-radius: 6px;
        border: 1px solid rgba(217,164,65,0.2);
    }
    .ald-diff-field svg {
        width: 12px;
        height: 12px;
        stroke: var(--gold-strong);
        stroke-width: 2.5;
    }
    .ald-diff-col {
        min-width: 0;
    }
    .ald-diff-col-label {
        font-size: 9.5px;
        font-weight: 900;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .ald-diff-col-label svg {
        width: 12px;
        height: 12px;
        stroke-width: 2.5;
    }
    .ald-diff-col-label.old { color: #fca5a5; }
    .ald-diff-col-label.old svg { stroke: #fca5a5; }
    .ald-diff-col-label.new { color: #6ee7b7; }
    .ald-diff-col-label.new svg { stroke: #6ee7b7; }
    
    .ald-diff-old {
        padding: 12px 14px;
        border-radius: 11px;
        background: rgba(220,38,38,0.06);
        border: 1px solid rgba(220,38,38,0.25);
        font-size: 12.5px;
        color: #fca5a5;
        min-height: 40px;
        word-break: break-word;
        font-family: 'Courier New', monospace;
        line-height: 1.55;
        animation: slideInRight 0.4s ease;
    }
    .ald-diff-old pre {
        margin: 0;
        font-size: 11px;
        line-height: 1.5;
        white-space: pre-wrap;
        word-break: break-word;
    }
    .ald-diff-new {
        padding: 12px 14px;
        border-radius: 11px;
        background: rgba(16,185,129,0.06);
        border: 1px solid rgba(16,185,129,0.25);
        font-size: 12.5px;
        color: #6ee7b7;
        min-height: 40px;
        word-break: break-word;
        font-family: 'Courier New', monospace;
        line-height: 1.55;
        animation: slideInLeft 0.4s ease;
    }
    .ald-diff-new pre {
        margin: 0;
        font-size: 11px;
        line-height: 1.5;
        white-space: pre-wrap;
        word-break: break-word;
    }
    .ald-diff-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 26px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(145deg, rgba(59,130,246,0.15), rgba(59,130,246,0.05));
        border: 1px solid rgba(59,130,246,0.25);
        flex-shrink: 0;
    }
    .ald-diff-arrow svg {
        width: 18px;
        height: 18px;
        stroke: #60a5fa;
        stroke-width: 2.5;
        filter: drop-shadow(0 2px 4px rgba(59,130,246,0.3));
    }
    .ald-diff-empty-val {
        opacity: 0.5;
        font-style: italic;
        font-family: var(--font-body);
    }

    /* ===== RAW DATA ===== */
    .ald-raw {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 24px;
        animation: aldFade 0.5s 0.15s both;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
    }
    .ald-raw::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #6366f1, #a78bfa, #7c3aed);
        opacity: 0.85;
    }
    .ald-raw h3 {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 18px;
        font-family: var(--font-display);
        font-size: 15px;
        font-weight: 900;
        color: #fff;
    }
    .ald-raw h3 .card-ico {
        width: 36px;
        height: 36px;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(145deg, rgba(99,102,241,0.18), rgba(99,102,241,0.08));
        border: 1px solid rgba(99,102,241,0.25);
    }
    .ald-raw h3 .card-ico svg {
        width: 20px;
        height: 20px;
        stroke: #a78bfa;
        stroke-width: 2.2;
        filter: drop-shadow(0 1px 2px rgba(99,102,241,0.3));
    }

    .ald-raw-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    @media(max-width:800px) { .ald-raw-grid { grid-template-columns: 1fr; } }
    
    .ald-raw-box {
        padding: 16px 18px;
        border-radius: 12px;
        background: linear-gradient(145deg, rgba(11,21,18,0.8), rgba(10,23,18,0.6));
        border: 1px solid var(--border);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .ald-raw-box:hover {
        border-color: rgba(99,102,241,0.3);
        box-shadow: 0 4px 14px rgba(99,102,241,0.15);
    }
    .ald-raw-box-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 1px dashed var(--border);
    }
    .ald-raw-box h4 {
        margin: 0;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .ald-raw-box h4 svg {
        width: 14px;
        height: 14px;
        stroke: var(--gold-strong);
        stroke-width: 2.2;
    }
    .ald-copy-btn {
        padding: 4px 10px;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 800;
        border: 1px solid var(--border);
        background: rgba(255,255,255,0.04);
        color: var(--muted);
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .ald-copy-btn svg {
        width: 12px;
        height: 12px;
        stroke: currentColor;
        stroke-width: 2.2;
    }
    .ald-copy-btn:hover {
        border-color: rgba(59,130,246,0.45);
        color: #3b82f6;
        background: rgba(59,130,246,0.08);
        transform: translateY(-1px);
    }
    .ald-copy-btn.copied {
        color: #6ee7b7;
        border-color: rgba(16,185,129,0.35);
        background: rgba(16,185,129,0.1);
    }
    .ald-raw-box pre {
        margin: 0;
        font-size: 11.5px;
        line-height: 1.55;
        white-space: pre-wrap;
        word-break: break-word;
        color: #c4b5fd;
        font-family: 'JetBrains Mono', 'Courier New', monospace;
        max-height: 340px;
        overflow-y: auto;
        padding: 8px 0;
    }
    .ald-raw-box pre::-webkit-scrollbar { width: 6px; }
    .ald-raw-box pre::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, rgba(167,139,250,0.4), rgba(124,58,237,0.3));
        border-radius: 999px;
    }
    .ald-raw-box .empty {
        opacity: 0.5;
        font-style: italic;
        color: var(--muted);
        font-family: var(--font-body);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .ald-head {
            flex-direction: column;
            align-items: flex-start;
            padding: 22px;
        }
        .ald-id {
            margin-left: 0;
            margin-top: 12px;
        }
        .ald-diff-row {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        .ald-diff-arrow {
            justify-self: center;
            transform: rotate(90deg);
            padding-top: 0;
        }
        .ald-diff-col-label { justify-content: center; }
        .ald-row .v {
            max-width: 100%;
            text-align: left;
        }
    }
</style>

<!-- ===== BACK BUTTON ===== -->
<a class="ald-back" href="<?= e(url('admin/index.php?page=audit')) ?>">
    <?= renderAuditDetailIcon('chevron-left', 16, 'currentColor') ?>
    <span>Kembali ke Audit Log</span>
</a>

<!-- ===== HEADER ===== -->
<div class="ald-head" style="--rgb:<?= $ai['rgb'] ?>; --hex:<?= $ai['hex'] ?>;">
    <span class="ico">
        <?= renderAuditDetailIcon($ai['icon'] ?? 'activity', 28, 'currentColor') ?>
    </span>
    <div class="ald-head-info">
        <h2>
            <span><?= e($ai['label']) ?></span>
            <span class="action-label">
                <?= renderAuditDetailIcon($ai['icon'] ?? 'activity', 12, 'currentColor') ?>
                <?= e($item['action']) ?>
            </span>
        </h2>
        <p>
            <span style="display:inline-flex; align-items:center; gap:5px;">
                <?= renderAuditDetailIcon('user', 14, 'currentColor') ?>
                <span>oleh <b style="color:var(--hex);"><?= e($item['user_name'] ?? 'Sistem') ?></b></span>
            </span>
            <span class="sep"></span>
            <span style="display:inline-flex; align-items:center; gap:5px;">
                <?= renderAuditDetailIcon('award', 14, 'currentColor') ?>
                <span><?= e($item['user_role'] ?? '—') ?></span>
            </span>
            <span class="sep"></span>
            <span style="display:inline-flex; align-items:center; gap:5px;">
                <?= renderAuditDetailIcon('clock', 14, 'currentColor') ?>
                <span><?= e(date('d M Y · H:i:s', strtotime($item['created_at']))) ?></span>
            </span>
        </p>
    </div>
    <span class="ald-id">
        <?= renderAuditDetailIcon('hash', 12, 'currentColor') ?>
        <span><?= (int) $item['id'] ?></span>
    </span>
</div>

<!-- ===== INFO GRID ===== -->
<div class="ald-grid">
    <div class="ald-card">
        <h3>
            <span class="card-ico"><?= renderAuditDetailIcon('folder', 18, 'currentColor') ?></span>
            <span>Informasi Entitas</span>
        </h3>
        <div class="ald-row">
            <span class="k">
                <?= renderAuditDetailIcon('folder', 13, 'currentColor') ?>
                <span>Tipe</span>
            </span>
            <span class="v plain"><?= e($item['entity_type'] ?? '—') ?></span>
        </div>
        <div class="ald-row">
            <span class="k">
                <?= renderAuditDetailIcon('hash', 13, 'currentColor') ?>
                <span>ID Entitas</span>
            </span>
            <span class="v"><?= (int) ($item['entity_id'] ?? 0) ?: '—' ?></span>
        </div>
        <div class="ald-row">
            <span class="k">
                <?= renderAuditDetailIcon('edit', 13, 'currentColor') ?>
                <span>Label</span>
            </span>
            <span class="v plain"><?= e($item['entity_label'] ?? '—') ?></span>
        </div>
    </div>
    <div class="ald-card">
        <h3>
            <span class="card-ico"><?= renderAuditDetailIcon('globe', 18, 'currentColor') ?></span>
            <span>Konteks Request</span>
        </h3>
        <div class="ald-row">
            <span class="k">
                <?= renderAuditDetailIcon('globe', 13, 'currentColor') ?>
                <span>IP Address</span>
            </span>
            <span class="v"><?= e($item['ip_address'] ?? '—') ?></span>
        </div>
        <div class="ald-row">
            <span class="k">
                <?= renderAuditDetailIcon('link', 13, 'currentColor') ?>
                <span>URL</span>
            </span>
            <span class="v small"><?= e($item['url'] ?? '—') ?></span>
        </div>
        <div class="ald-row">
            <span class="k">
                <?= renderAuditDetailIcon('monitor', 13, 'currentColor') ?>
                <span>User Agent</span>
            </span>
            <span class="v small" style="max-width:75%;"><?= e(substr($item['user_agent'] ?? '—', 0, 120)) ?><?= strlen($item['user_agent'] ?? '') > 120 ? '…' : '' ?></span>
        </div>
    </div>
</div>

<!-- ===== DIFF SECTION ===== -->
<?php if (!empty($diff)): ?>
<div class="ald-diff">
    <h3>
        <span class="card-ico"><?= renderAuditDetailIcon('git-compare', 20, 'currentColor') ?></span>
        <span>Perubahan Data</span>
        <span class="count"><?= count($diff) ?> field berubah</span>
    </h3>
    <?php foreach ($diff as $field => $vals): ?>
    <div class="ald-diff-row">
        <div class="ald-diff-field">
            <?= renderAuditDetailIcon('edit', 12, 'currentColor') ?>
            <span><?= e($field) ?></span>
        </div>
        <div class="ald-diff-col">
            <div class="ald-diff-col-label old">
                <?= renderAuditDetailIcon('minus', 12, 'currentColor') ?>
                <span>Nilai Lama</span>
            </div>
            <div class="ald-diff-old">
                <?php if ($vals['old'] === null): ?>
                    <span class="ald-diff-empty-val">(kosong)</span>
                <?php elseif (is_array($vals['old'])): ?>
                    <pre><?= e(json_encode($vals['old'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)) ?></pre>
                <?php else: ?>
                    <?= e((string) $vals['old']) ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="ald-diff-arrow">
            <?= renderAuditDetailIcon('arrow-right', 18, 'currentColor') ?>
        </div>
        <div class="ald-diff-col">
            <div class="ald-diff-col-label new">
                <?= renderAuditDetailIcon('plus', 12, 'currentColor') ?>
                <span>Nilai Baru</span>
            </div>
            <div class="ald-diff-new">
                <?php if ($vals['new'] === null): ?>
                    <span class="ald-diff-empty-val">(kosong)</span>
                <?php elseif (is_array($vals['new'])): ?>
                    <pre><?= e(json_encode($vals['new'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)) ?></pre>
                <?php else: ?>
                    <?= e((string) $vals['new']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="ald-diff">
    <h3>
        <span class="card-ico"><?= renderAuditDetailIcon('git-compare', 20, 'currentColor') ?></span>
        <span>Perubahan Data</span>
    </h3>
    <div class="ald-diff-empty">
        <?= renderAuditDetailIcon('inbox', 48, 'currentColor') ?>
        <span>Tidak ada perubahan field yang tercatat pada log ini.</span>
    </div>
</div>
<?php endif; ?>

<!-- ===== RAW DATA ===== -->
<?php if (!empty($old) || !empty($new)): ?>
<div class="ald-raw">
    <h3>
        <span class="card-ico"><?= renderAuditDetailIcon('database', 20, 'currentColor') ?></span>
        <span>Data Mentah (JSON)</span>
    </h3>
    <div class="ald-raw-grid">
        <div class="ald-raw-box">
            <div class="ald-raw-box-header">
                <h4>
                    <?= renderAuditDetailIcon('minus', 14, 'currentColor') ?>
                    <span>Nilai Lama</span>
                </h4>
                <button type="button" class="ald-copy-btn" data-target="raw-old">
                    <?= renderAuditDetailIcon('copy', 12, 'currentColor') ?>
                    <span>Copy</span>
                </button>
            </div>
            <?php if ($old === null || $old === ''): ?>
                <pre class="empty">(tidak ada data)</pre>
            <?php else: ?>
                <pre id="raw-old"><?= al_pretty($old) ?></pre>
            <?php endif; ?>
        </div>
        <div class="ald-raw-box">
            <div class="ald-raw-box-header">
                <h4>
                    <?= renderAuditDetailIcon('plus', 14, 'currentColor') ?>
                    <span>Nilai Baru</span>
                </h4>
                <button type="button" class="ald-copy-btn" data-target="raw-new">
                    <?= renderAuditDetailIcon('copy', 12, 'currentColor') ?>
                    <span>Copy</span>
                </button>
            </div>
            <?php if ($new === null || $new === ''): ?>
                <pre class="empty">(tidak ada data)</pre>
            <?php else: ?>
                <pre id="raw-new"><?= al_pretty($new) ?></pre>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
(function() {
    // Copy JSON button
    document.querySelectorAll('.ald-copy-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var targetId = btn.dataset.target;
            var target = document.getElementById(targetId);
            if (!target) return;
            
            var text = target.textContent || target.innerText;
            navigator.clipboard.writeText(text).then(function() {
                var originalHTML = btn.innerHTML;
                btn.innerHTML = '<?= htmlspecialchars(renderAuditDetailIcon('check', 12, 'currentColor'), ENT_QUOTES) ?> <span>Tersalin!</span>';
                btn.classList.add('copied');
                setTimeout(function() {
                    btn.innerHTML = originalHTML;
                    btn.classList.remove('copied');
                }, 2000);
            });
        });
    });
})();
</script>