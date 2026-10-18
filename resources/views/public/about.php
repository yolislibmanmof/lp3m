<?php 
$s = Setting::all();

// Parse struktur organisasi
$structure = array_filter(array_map('trim', explode("\n", $s['about_structure_text'] ?? '')));
$structureCards = [];
foreach ($structure as $line) {
    $parts = array_map('trim', explode('|', $line));
    if (!empty($parts[0])) {
        $structureCards[] = [
            'jabatan' => $parts[0] ?? '',
            'nama' => $parts[1] ?? '',
        ];
    }
}

// Parse misi
$mission = array_filter(array_map('trim', explode("\n", $s['about_mission_text'] ?? '')));

// Quote tentang lembaga
$quotes = [
    ['"Fastabiqul Khairat — berlomba-lomba dalam kebaikan." — QS. Al-Baqarah: 148', 'lightning'],
    ['"Sebaik-baik manusia adalah yang paling bermanfaat bagi manusia." — HR. Ahmad', 'handshake'],
    ['"Ilmu tanpa amal adalah pohon tanpa buah." — Pepatah Arab', 'tree'],
    ['"Pendidikan adalah senjata paling mematikan, karena dengannya Anda dapat mengubah dunia." — Nelson Mandela', 'graduation-cap'],
];
$aboutQuote = $quotes[date('z') % count($quotes)];

// Tahun berdiri
preg_match('/\b(19|20)\d{2}\b/', $s['about_history_text'] ?? '', $yearMatch);
$tahunBerdiri = $yearMatch[0] ?? '2000';
$umurLembaga = max(1, (int) date('Y') - (int) $tahunBerdiri);

// Stats real-time
$statPengabdian = CommunityService::paginate(['status' => 'published'], '', [], 1, 1)['total'];
$statPublikasi = Publication::paginate(['status' => 'published'], '', [], 1, 1)['total'];
$statHaki = IntellectualProperty::paginate([], '', [], 1, 1)['total'];
$statAik = AikActivity::paginate(['status' => 'published'], '', [], 1, 1)['total'];
$statBerita = News::paginate([], 1, 1)['total'];
$statDokumen = Document::paginate(['status' => 'published'], 1, 1)['total'];

// Values / nilai lembaga
$nilaiLembaga = [
    ['mosque', 'Islami', 'Menjiwai nilai-nilai Al-Islam dan Kemuhammadiyahan dalam setiap aktivitas.', 'ico-3d-purple'],
    ['target', 'Berkemajuan', 'Mendorong inovasi dan kemajuan yang bermanfaat bagi umat dan bangsa.', 'ico-3d-gold'],
    ['handshake', 'Kolaboratif', 'Membangun kemitraan strategis dengan berbagai pemangku kepentingan.', 'ico-3d'],
    ['microscope', 'Ilmiah', 'Mengedepankan integritas akademik dan rigoritas dalam setiap karya.', 'ico-3d-blue'],
];

$totalKarya = $statPengabdian + $statPublikasi + $statHaki + $statAik + $statBerita + $statDokumen;

// ICON HELPER FUNCTION
function renderAboutIcon($name, $size = 24, $color = 'currentColor') {
    $icons = [
        'building' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>',
        'newspaper' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"></path><path d="M18 14h-8"></path><path d="M15 18h-5"></path><path d="M10 6h8v4h-8V6Z"></path></svg>',
        'book-open' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>',
        'quote' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"></path><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"></path></svg>',
        'clock' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
        'sparkle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 3l1.912 5.813a2 2 0 0 0 1.275 1.275L21 12l-5.813 1.912a2 2 0 0 0-1.275 1.275L12 21l-1.912-5.813a2 2 0 0 0-1.275-1.275L3 12l5.813-1.912a2 2 0 0 0 1.275-1.275L12 3z"></path></svg>',
        'users' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'award' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>',
        'mosque' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 6v6l4 2"></path></svg>',
        'target' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>',
        'handshake' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'microscope' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M9 3h6v2H9V3zm-3 4h12v2H6V7zm2 4h8v10H8V11z"></path><path d="M10 15h4"></path></svg>',
        'star' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>',
        'trophy' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path></svg>',
        'graduation-cap' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>',
        'crown' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="m2 4 3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14"></path></svg>',
        'lightning' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>',
        'tree' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 22H7l5-10 5 10z"></path><path d="M12 12V2"></path><path d="M8 6l4-4 4 4"></path></svg>',
        'book' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>',
        'search' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
        'file-text' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>',
    ];
    return $icons[$name] ?? $icons['sparkle'];
}
?>

<style>
    @keyframes orbPulse {
        0%, 100% { box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.2), 0 6px 16px rgba(5,150,105,0.35); }
        50%      { box-shadow: inset 0 2px 3px rgba(255,255,255,0.8), inset 0 -3px 4px rgba(0,0,0,0.2), 0 8px 22px rgba(5,150,105,0.5); }
    }
    @keyframes numberGlow {
        0%, 100% { text-shadow: 0 0 20px rgba(242,192,99,0.5), 0 0 40px rgba(217,164,65,0.3); }
        50%      { text-shadow: 0 0 30px rgba(242,192,99,0.8), 0 0 60px rgba(217,164,65,0.5); }
    }
    @keyframes heroFloat1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(20px,-15px)} }
    @keyframes heroFloat2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-15px,20px)} }
    @keyframes heroFloat3 { 0%,100%{transform:translate(0,0) rotate(0)} 50%{transform:translate(10px,10px) rotate(10deg)} }
    @keyframes shineSweep {
        0%   { transform: translateX(-100%) skewX(-20deg); }
        100% { transform: translateX(300%) skewX(-20deg); }
    }
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes iconRotate {
        0%, 100% { transform: rotate(0deg) scale(1); }
        25% { transform: rotate(-5deg) scale(1.05); }
        75% { transform: rotate(5deg) scale(1.05); }
    }

    /* ===== 3D ICON ORBS (SVG Support) ===== */
    .ico-3d {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        border-radius: 18px;
        font-size: 26px;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #34d399, #10b981 50%, #059669);
        box-shadow:
            inset 0 2px 3px rgba(255,255,255,0.6),
            inset 0 -3px 4px rgba(0,0,0,0.25),
            0 6px 16px rgba(5,150,105,0.35);
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .ico-3d svg {
        width: 28px;
        height: 28px;
        stroke-width: 2.2;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }
    .ico-3d::before {
        content: '';
        position: absolute;
        top: 6px;
        left: 10px;
        width: 18px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255,255,255,0.6);
        filter: blur(2px);
        z-index: 1;
    }
    .ico-3d-lg {
        width: 72px;
        height: 72px;
        border-radius: 22px;
        font-size: 34px;
    }
    .ico-3d-lg svg {
        width: 36px;
        height: 36px;
    }
    .ico-3d-xl {
        width: 88px;
        height: 88px;
        border-radius: 26px;
        font-size: 42px;
    }
    .ico-3d-xl svg {
        width: 44px;
        height: 44px;
    }
    .ico-3d-gold {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%),
                    linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441);
        box-shadow:
            inset 0 2px 3px rgba(255,255,255,0.7),
            inset 0 -3px 4px rgba(0,0,0,0.2),
            0 6px 16px rgba(217,164,65,0.4);
    }
    .ico-3d-blue {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #60a5fa, #3b82f6 50%, #1d4ed8);
        box-shadow:
            inset 0 2px 3px rgba(255,255,255,0.6),
            inset 0 -3px 4px rgba(0,0,0,0.25),
            0 6px 16px rgba(59,130,246,0.35);
    }
    .ico-3d-red {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #fca5a5, #f87171 50%, #dc2626);
        box-shadow:
            inset 0 2px 3px rgba(255,255,255,0.6),
            inset 0 -3px 4px rgba(0,0,0,0.25),
            0 6px 16px rgba(220,38,38,0.35);
    }
    .ico-3d-purple {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #c4b5fd, #a78bfa 50%, #7c3aed);
        box-shadow:
            inset 0 2px 3px rgba(255,255,255,0.6),
            inset 0 -3px 4px rgba(0,0,0,0.25),
            0 6px 16px rgba(124,58,237,0.35);
    }
    .ico-3d:hover {
        transform: translateY(-4px) scale(1.08);
    }
    .ico-3d:hover svg {
        animation: iconRotate 0.6s ease;
    }

    /* ===== HERO FLOATING ORBS ===== */
    .hero-orb {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
    }
    .hero-orb-1 {
        width: 140px;
        height: 140px;
        top: 10%;
        right: 8%;
        background: radial-gradient(circle at 30% 30%, rgba(253,230,138,0.6), rgba(217,164,65,0.3) 60%, transparent);
        filter: blur(2px);
        animation: heroFloat1 8s ease-in-out infinite;
    }
    .hero-orb-2 {
        width: 200px;
        height: 200px;
        bottom: 15%;
        left: 5%;
        background: radial-gradient(circle at 70% 70%, rgba(110,231,183,0.4), rgba(16,185,129,0.2) 60%, transparent);
        filter: blur(3px);
        animation: heroFloat2 10s ease-in-out infinite;
    }
    .hero-orb-3 {
        width: 90px;
        height: 90px;
        top: 65%;
        right: 28%;
        background: radial-gradient(circle at 30% 30%, rgba(242,192,99,0.5), rgba(217,164,65,0.2) 60%, transparent);
        filter: blur(1px);
        animation: heroFloat3 6s ease-in-out infinite;
    }

    /* ===== 3D TICKER ===== */
    .ticker-3d {
        padding: 10px 18px;
        border-radius: 999px;
        background: linear-gradient(145deg, rgba(16,185,129,0.3), rgba(5,150,105,0.15));
        border: 1px solid rgba(110,231,183,0.3);
        backdrop-filter: blur(10px);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow:
            inset 0 1px 1px rgba(255,255,255,0.2),
            0 4px 12px rgba(0,0,0,0.3);
    }
    .ticker-3d svg {
        width: 18px;
        height: 18px;
        stroke: #6ee7b7;
        stroke-width: 2;
    }

    /* ===== 3D QUOTE CARD ===== */
    .quote-3d {
        position: relative;
        padding: 34px;
        border-radius: 24px;
        background: linear-gradient(145deg, #065f46, #03251f);
        border: 1px solid rgba(217,164,65,0.25);
        overflow: hidden;
        box-shadow:
            inset 0 1px 1px rgba(255,255,255,0.08),
            0 16px 40px rgba(0,0,0,0.35);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .quote-3d::before {
        content: '';
        position: absolute;
        top: -60%;
        right: -20%;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,0.3), transparent 70%);
        animation: orbPulse 4s ease-in-out infinite;
    }
    .quote-3d:hover {
        transform: translateY(-4px);
        box-shadow:
            inset 0 1px 1px rgba(255,255,255,0.12),
            0 20px 50px rgba(0,0,0,0.4);
    }
    .quote-mark-3d {
        position: absolute;
        top: 10px;
        left: 14px;
        font-size: 100px;
        line-height: 1;
        color: rgba(217,164,65,0.12);
        font-family: Georgia, serif;
        pointer-events: none;
    }

    /* ===== 3D COUNTER ===== */
    .counter-3d {
        font-family: var(--font-display);
        font-size: 44px;
        font-weight: 900;
        line-height: 1;
        background: linear-gradient(135deg, #fde68a, #f2c063 40%, #d9a441);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 2px 8px rgba(217,164,65,0.4));
    }

    /* ===== 3D ABOUT BOX ===== */
    .about-3d {
        position: relative;
        padding: 44px 38px 34px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 24px;
        font-size: 15.5px;
        line-height: 1.85;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: visible;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .about-3d:hover {
        box-shadow: 0 16px 40px rgba(5,150,105,0.15);
        border-color: rgba(5,150,105,0.3);
    }
    .about-badge-3d {
        position: absolute;
        top: -18px;
        left: 34px;
        padding: 8px 18px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 0.12em;
        color: #03251f;
        background: linear-gradient(145deg, #fde68a, #d9a441);
        box-shadow:
            inset 0 1px 2px rgba(255,255,255,0.7),
            inset 0 -2px 3px rgba(0,0,0,0.2),
            0 4px 10px rgba(217,164,65,0.4);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .about-badge-3d svg {
        width: 16px;
        height: 16px;
        stroke: #03251f;
        stroke-width: 2.5;
    }
    .about-badge-3d::before {
        content: '';
        position: absolute;
        top: 2px;
        left: 6px;
        width: 30%;
        height: 40%;
        border-radius: 50%;
        background: rgba(255,255,255,0.6);
        filter: blur(1.5px);
    }

    /* ===== 3D CARD NUM ===== */
    .card-num-3d {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-display);
        font-weight: 900;
        font-size: 15px;
        color: #03251f;
        background: linear-gradient(145deg, #fde68a, #d9a441);
        box-shadow:
            inset 0 1px 2px rgba(255,255,255,0.7),
            inset 0 -2px 3px rgba(0,0,0,0.2),
            0 3px 8px rgba(217,164,65,0.3);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .card:hover .card-num-3d {
        transform: scale(1.1) rotate(-5deg);
    }
    .card-num-3d::before {
        content: '';
        position: absolute;
        top: 3px;
        left: 8px;
        width: 40%;
        height: 35%;
        border-radius: 50%;
        background: rgba(255,255,255,0.6);
        filter: blur(1px);
    }

    /* ===== 3D YEAR BOX ===== */
    .year-3d {
        flex-shrink: 0;
        width: 120px;
        height: 120px;
        border-radius: 26px;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.15), transparent 40%),
                    linear-gradient(145deg, #043b2c, #065f46);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #f2c063;
        font-family: var(--font-display);
        font-weight: 900;
        font-size: 36px;
        box-shadow:
            inset 0 2px 3px rgba(255,255,255,0.1),
            inset 0 -3px 4px rgba(0,0,0,0.3),
            0 10px 30px rgba(3,37,31,0.35);
        position: relative;
        transition: all 0.3s ease;
    }
    .year-3d:hover {
        transform: scale(1.05) rotate(-3deg);
    }
    .year-3d::before {
        content: '';
        position: absolute;
        top: 10px;
        left: 16px;
        width: 40%;
        height: 30%;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        filter: blur(2px);
    }
    .year-3d::after {
        content: 'BERDIRI';
        position: absolute;
        bottom: -24px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 10px;
        font-weight: 900;
        letter-spacing: 0.2em;
        color: var(--muted);
    }

    /* ===== 3D MISSION NUMBER ===== */
    .mission-num-3d {
        flex-shrink: 0;
        width: 54px;
        height: 54px;
        border-radius: 16px;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%),
                    linear-gradient(145deg, #fde68a, #d9a441 60%, #a9761b);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #03251f;
        font-family: var(--font-display);
        font-weight: 900;
        font-size: 18px;
        box-shadow:
            inset 0 2px 3px rgba(255,255,255,0.7),
            inset 0 -2px 3px rgba(0,0,0,0.2),
            0 6px 14px rgba(217,164,65,0.35);
        position: relative;
        transition: all 0.3s ease;
    }
    .mission-num-3d:hover {
        transform: scale(1.1) rotate(-3deg);
    }
    .mission-num-3d::before {
        content: '';
        position: absolute;
        top: 4px;
        left: 10px;
        width: 45%;
        height: 35%;
        border-radius: 50%;
        background: rgba(255,255,255,0.6);
        filter: blur(1px);
    }

    /* ===== 3D AVATAR SPHERE ===== */
    .avatar-3d {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-family: var(--font-display);
        font-weight: 900;
        font-size: 26px;
        margin: 0 auto 16px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .avatar-3d::before {
        content: '';
        position: absolute;
        top: 6px;
        left: 14px;
        width: 22px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255,255,255,0.55);
        filter: blur(2px);
    }
    .avatar-3d:hover {
        transform: scale(1.1) rotate(-5deg);
    }
    .avatar-3d-gold {
        background: radial-gradient(circle at 30% 25%, #fde68a, #d9a441 60%, #a9761b);
        box-shadow:
            inset 0 2px 3px rgba(255,255,255,0.6),
            inset 0 -3px 4px rgba(0,0,0,0.25),
            0 0 0 3px rgba(217,164,65,0.2),
            0 10px 24px rgba(217,164,65,0.45);
    }
    .avatar-3d-emerald {
        background: radial-gradient(circle at 30% 25%, #6ee7b7, #10b981 60%, #047857);
        box-shadow:
            inset 0 2px 3px rgba(255,255,255,0.5),
            inset 0 -3px 4px rgba(0,0,0,0.25),
            0 0 0 3px rgba(16,185,129,0.2),
            0 10px 24px rgba(16,185,129,0.35);
    }
    .avatar-3d-teal {
        background: radial-gradient(circle at 30% 25%, #5eead4, #14b8a6 60%, #0f766e);
        box-shadow:
            inset 0 2px 3px rgba(255,255,255,0.5),
            inset 0 -3px 4px rgba(0,0,0,0.25),
            0 0 0 3px rgba(20,184,166,0.2),
            0 10px 24px rgba(20,184,166,0.35);
    }

    /* ===== 3D JABATAN BADGE ===== */
    .jabatan-3d {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 10px;
        padding: 5px 14px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 700;
    }
    .jabatan-gold {
        background: linear-gradient(145deg, #fef3c7, #fde68a);
        color: #92400e;
        border: 1px solid rgba(217,164,65,0.4);
        box-shadow:
            inset 0 1px 2px rgba(255,255,255,0.6),
            inset 0 -1px 2px rgba(0,0,0,0.05),
            0 2px 5px rgba(217,164,65,0.2);
    }
    .jabatan-emerald {
        background: rgba(5,150,105,0.1);
        color: var(--primary-dark);
        border: 1px solid rgba(5,150,105,0.2);
    }

    /* ===== 3D VISION BOX ===== */
    .vision-3d {
        position: relative;
        padding: 52px 44px;
        background: linear-gradient(135deg, #043b2c 0%, #065f46 55%, #059669 100%);
        color: white;
        border-radius: 28px;
        text-align: center;
        box-shadow: 0 24px 60px rgba(0,0,0,0.35);
        overflow: hidden;
        transition: all 0.4s ease;
    }
    .vision-3d:hover {
        transform: translateY(-4px);
        box-shadow: 0 30px 70px rgba(0,0,0,0.4);
    }
    .vision-3d::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,0.25), transparent 70%);
        animation: orbPulse 5s ease-in-out infinite;
    }
    .vision-3d::after {
        content: '';
        position: absolute;
        bottom: -40%;
        left: -10%;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(110,231,183,0.2), transparent 70%);
        animation: orbPulse 6s ease-in-out infinite;
        animation-delay: 2s;
    }

    /* ===== 3D HISTORY CARD ===== */
    .history-3d {
        position: relative;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 38px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        transition: all 0.4s ease;
    }
    .history-3d:hover {
        box-shadow: 0 16px 40px rgba(5,150,105,0.15);
        border-color: rgba(5,150,105,0.3);
    }
    .history-3d::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #d9a441, #059669, #d9a441);
    }
    .history-3d::after {
        content: '';
        position: absolute;
        top: -80px;
        right: -60px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,0.08), transparent 70%);
        pointer-events: none;
    }

    /* ===== 3D UMMAT BADGE ===== */
    .badge-3d {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        border-radius: 999px;
        background: linear-gradient(145deg, rgba(217,164,65,0.15), rgba(217,164,65,0.05));
        border: 1px solid rgba(217,164,65,0.3);
        transition: all 0.3s ease;
    }
    .badge-3d:hover {
        transform: translateX(4px);
        background: linear-gradient(145deg, rgba(217,164,65,0.25), rgba(217,164,65,0.1));
        border-color: rgba(217,164,65,0.5);
    }
    .badge-3d svg {
        width: 20px;
        height: 20px;
        stroke: #f2c063;
        stroke-width: 2;
    }

    /* ===== 3D QURAN VERSE ===== */
    .quran-3d {
        position: relative;
        padding: 50px 40px;
        background: linear-gradient(135deg, #043b2c, #065f46);
        border-radius: 28px;
        text-align: center;
        color: white;
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        overflow: hidden;
        transition: all 0.4s ease;
    }
    .quran-3d:hover {
        transform: translateY(-4px);
        box-shadow: 0 26px 60px rgba(0,0,0,0.35);
    }
    .quran-3d::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(400px 200px at 50% 0%, rgba(217,164,65,0.25), transparent 70%);
        animation: orbPulse 6s ease-in-out infinite;
    }
    .quran-mark-3d {
        font-size: 80px;
        line-height: 1;
        color: rgba(242,192,99,0.25);
        font-family: Georgia, serif;
        margin-bottom: 8px;
    }
    .quran-arabic-3d {
        font-size: clamp(24px, 3.5vw, 34px);
        line-height: 1.8;
        margin-bottom: 16px;
        color: #fde68a;
        font-weight: 500;
        direction: rtl;
        text-shadow: 0 2px 10px rgba(217,164,65,0.3);
    }

    /* ===== 3D CTA BUTTONS ===== */
    .cta-3d {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 28px;
        border-radius: 15px;
        font-weight: 700;
        font-size: 15px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
        text-decoration: none;
    }
    .cta-3d svg {
        width: 20px;
        height: 20px;
        stroke-width: 2.2;
        transition: all 0.3s ease;
    }
    .cta-3d::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,0.5), transparent);
        animation: shineSweep 3s ease-in-out infinite;
    }
    .cta-3d-primary {
        background: linear-gradient(145deg, #fde68a, #d9a441);
        color: #03251f;
        box-shadow:
            inset 0 2px 3px rgba(255,255,255,0.7),
            inset 0 -2px 3px rgba(0,0,0,0.15),
            0 8px 20px rgba(217,164,65,0.4);
    }
    .cta-3d-ghost {
        background: transparent;
        color: #fff;
        border: 2px solid rgba(255,255,255,0.35);
        backdrop-filter: blur(8px);
    }
    .cta-3d:hover { 
        transform: translateY(-4px); 
    }
    .cta-3d:hover svg {
        transform: scale(1.15);
    }
    .cta-3d-primary:hover { 
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.8), 0 14px 30px rgba(217,164,65,0.55); 
    }
    .cta-3d-ghost:hover { 
        background: rgba(255,255,255,0.12); 
        border-color: rgba(255,255,255,0.6);
        box-shadow: 0 10px 24px rgba(0,0,0,0.2);
    }

    /* ===== 3D IMPACT NUMBER ===== */
    .impact-num-3d {
        font-family: var(--font-display);
        font-size: clamp(64px, 12vw, 100px);
        font-weight: 900;
        line-height: 1;
        background: linear-gradient(135deg, #fde68a 0%, #f2c063 40%, #d9a441 70%, #a9761b);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 4px 16px rgba(217,164,65,0.5));
    }

    /* ===== ENHANCED CARD STYLES ===== */
    .card {
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 24px 48px rgba(5,150,105,0.22);
    }
    .card:hover .ico-3d {
        transform: scale(1.15) rotate(-6deg);
    }
    .card:hover .ico-3d svg {
        filter: drop-shadow(0 3px 6px rgba(0,0,0,0.3));
    }

    /* ===== ORG CARD ENHANCEMENTS ===== */
    .org-card {
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .org-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(5,150,105,0.2);
        border-color: rgba(5,150,105,0.3);
    }

    /* ===== SECTION HEAD ENHANCEMENTS ===== */
    .section-head h2 {
        display: inline-flex;
        align-items: center;
        gap: 12px;
    }
    .section-head h2 svg {
        width: 32px;
        height: 32px;
        stroke-width: 2;
        filter: drop-shadow(0 2px 6px rgba(5,150,105,0.3));
    }

    /* ===== RESPONSIVE ENHANCEMENTS ===== */
    @media (max-width: 768px) {
        .ico-3d { width: 48px; height: 48px; }
        .ico-3d svg { width: 24px; height: 24px; }
        .ico-3d-lg { width: 64px; height: 64px; }
        .ico-3d-lg svg { width: 32px; height: 32px; }
        .ico-3d-xl { width: 72px; height: 72px; }
        .ico-3d-xl svg { width: 36px; height: 36px; }
        .avatar-3d { width: 68px; height: 68px; font-size: 22px; }
        .year-3d { width: 100px; height: 100px; font-size: 28px; }
        .counter-3d { font-size: 36px; }
        .impact-num-3d { font-size: clamp(48px, 10vw, 72px); }
        .about-3d, .history-3d, .vision-3d, .quran-3d { padding: 28px 22px; }
        .quote-3d { padding: 28px 22px; }
    }

    @media (max-width: 480px) {
        .stats { grid-template-columns: 1fr !important; }
        .grid { grid-template-columns: 1fr !important; }
        .hero-orb { display: none; }
    }
</style>

<!-- ================= HERO PROFIL 3D ================= -->
<section class="hero" style="position: relative; overflow: hidden;">
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="hero-orb hero-orb-3"></div>

    <span class="hero-chip c1" style="z-index: 2;">
        <?= renderAboutIcon('building', 16, 'currentColor') ?>
        <span>Profil Lembaga</span>
    </span>
    <span class="hero-chip c2" style="z-index: 2;">
        <?= renderAboutIcon('sparkle', 14, 'currentColor') ?>
        <span>LP3M</span>
    </span>

    <span class="eyebrow eyebrow-light" style="z-index: 2;">Profil Lembaga</span>
    <h1 style="z-index: 2;"><?= e($s['about_hero_title']) ?></h1>
    <p style="z-index: 2;"><?= e($s['about_hero_text']) ?></p>

    <div class="hero-actions" style="z-index: 2;">
        <a href="<?= e(url('public/index.php?page=berita')) ?>" class="cta-3d cta-3d-primary">
            <?= renderAboutIcon('newspaper', 20, 'currentColor') ?>
            <span>Berita Terbaru</span>
        </a>
        <a href="<?= e(url('public/index.php?page=publikasi')) ?>" class="cta-3d cta-3d-ghost">
            <?= renderAboutIcon('book-open', 20, 'currentColor') ?>
            <span>Jelajahi Publikasi</span>
        </a>
    </div>

    <div class="ticker-3d" style="position: absolute; bottom: 20px; right: 20px; z-index: 2;">
        <?= renderAboutIcon('building', 18, '#6ee7b7') ?>
        <span>Berdiri sejak <?= $tahunBerdiri ?> · <?= $umurLembaga ?>+ tahun mengabdi</span>
    </div>
</section>

<!-- ================= QUOTE PEMBUKA 3D ================= -->
<section class="stats reveal">
    <div class="quote-3d" style="grid-column: span 4;">
        <div class="quote-mark-3d">"</div>
        <div style="position: relative; z-index: 1; display: flex; align-items: center; gap: 22px; flex-wrap: wrap;">
            <div class="ico-3d ico-3d-xl ico-3d-gold">
                <?= renderAboutIcon($aboutQuote[1], 44, '#ffffff') ?>
            </div>
            <div style="flex: 1; min-width: 260px;">
                <p style="font-family: var(--font-display); font-size: clamp(18px, 2.2vw, 22px); font-weight: 700; line-height: 1.5; margin-bottom: 10px; font-style: italic; color: #f2c063; letter-spacing: -0.01em;">
                    <?= $aboutQuote[0] ?>
                </p>
                <p style="font-size: 12px; opacity: 0.7; letter-spacing: 0.1em; display: flex; align-items: center; gap: 8px;">
                    <?= renderAboutIcon('sparkle', 14, 'currentColor') ?>
                    <span>MENJIWAI SETIAP LANGKAH LP3M</span>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ================= STATISTIK 3D ================= -->
<section class="stats">
    <div class="stat reveal stagger-1" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(217,164,65,0.2), transparent 70%); pointer-events: none;"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-3d ico-3d-gold">
                <?= renderAboutIcon('building', 28, '#ffffff') ?>
            </div>
            <div>
                <div class="counter-3d" data-count="<?= $umurLembaga ?>" data-suffix="+">0</div>
                <div class="stat-label">Tahun Mengabdi</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-2" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(16,185,129,0.2), transparent 70%); pointer-events: none;"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-3d">
                <?= renderAboutIcon('users', 28, '#ffffff') ?>
            </div>
            <div>
                <div class="counter-3d" data-count="<?= (int) count($structureCards) ?>">0</div>
                <div class="stat-label">Pengurus Inti</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-3" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(59,130,246,0.2), transparent 70%); pointer-events: none;"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-3d ico-3d-blue">
                <?= renderAboutIcon('sparkle', 28, '#ffffff') ?>
            </div>
            <div>
                <div class="counter-3d" data-count="<?= $statPengabdian + $statPublikasi + $statHaki + $statAik ?>" data-suffix="+">0</div>
                <div class="stat-label">Total Karya</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-4" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(124,58,237,0.2), transparent 70%); pointer-events: none;"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-3d ico-3d-purple">
                <?= renderAboutIcon('mosque', 28, '#ffffff') ?>
            </div>
            <div>
                <div class="counter-3d" data-count="4">0</div>
                <div class="stat-label">Catur Dharma</div>
            </div>
        </div>
    </div>
</section>

<!-- ================= PROFIL LEMBAGA 3D ================= -->
<section class="section reveal">
    <div class="section-head">
        <h2>
            <?= renderAboutIcon('building', 32, 'currentColor') ?>
            <span>Profil Lembaga</span>
        </h2>
    </div>

    <div class="about-3d">
        <span class="about-badge-3d">
            <?= renderAboutIcon('sparkle', 16, 'currentColor') ?>
            <span>TENTANG KAMI</span>
        </span>
        <div style="margin-top: 14px;">
            <?= nl2br(e($s['about_profile_text'])) ?>
        </div>
    </div>
</section>

<!-- ================= NILAI LEMBAGA 3D ================= -->
<section class="section reveal">
    <div class="section-head">
        <h2>
            <?= renderAboutIcon('award', 32, 'currentColor') ?>
            <span>Nilai-Nilai Lembaga</span>
        </h2>
        <span class="chip">4 pilar utama</span>
    </div>

    <div class="grid" style="grid-template-columns: repeat(4, 1fr);">
        <?php foreach ($nilaiLembaga as $idx => $nilai): ?>
            <div class="card reveal stagger-<?= $idx + 1 ?>" style="text-align: center; padding: 28px 20px; position: relative; overflow: hidden;">
                <div class="card-num-3d">0<?= $idx + 1 ?></div>
                <div style="display: flex; justify-content: center; margin-bottom: 16px;">
                    <div class="ico-3d ico-3d-lg <?= $nilai[3] ?>">
                        <?= renderAboutIcon($nilai[0], 36, '#ffffff') ?>
                    </div>
                </div>
                <h3 style="font-size: 18px; margin-bottom: 8px;"><?= e($nilai[1]) ?></h3>
                <p><?= e($nilai[2]) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ================= SEJARAH 3D ================= -->
<section class="section reveal">
    <div class="section-head">
        <h2>
            <?= renderAboutIcon('clock', 32, 'currentColor') ?>
            <span>Sejarah Lembaga</span>
        </h2>
    </div>

    <div class="history-3d">
        <div style="display: flex; gap: 28px; align-items: flex-start; flex-wrap: wrap; position: relative; z-index: 1;">
            <div class="year-3d">
                <?= $tahunBerdiri ?>
            </div>

            <div style="flex: 1; min-width: 280px;">
                <p style="font-size: 11px; font-weight: 900; letter-spacing: 0.2em; color: var(--gold-strong); margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                    <?= renderAboutIcon('clock', 14, 'currentColor') ?>
                    <span>PERJALANAN KAMI</span>
                </p>
                <div style="font-size: 15.5px; line-height: 1.9; color: var(--text);">
                    <?= nl2br(e($s['about_history_text'])) ?>
                </div>

                <div class="badge-3d" style="margin-top: 22px;">
                    <?= renderAboutIcon('trophy', 20, 'currentColor') ?>
                    <span style="font-size: 13px; font-weight: 800; color: var(--gold-strong);">
                        <?= $umurLembaga ?>+ tahun mengabdi untuk umat dan bangsa
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= VISI 3D ================= -->
<section class="section reveal">
    <div class="section-head">
        <h2>
            <?= renderAboutIcon('star', 32, 'currentColor') ?>
            <span>Visi Lembaga</span>
        </h2>
    </div>

    <div class="vision-3d">
        <div style="position: relative; z-index: 1;">
            <span class="eyebrow eyebrow-light" style="margin-bottom: 16px; display: inline-block;">
                <?= renderAboutIcon('star', 16, '#f2c063') ?>
                <span>VISI KAMI</span>
            </span>

            <p style="font-family: var(--font-display); font-size: clamp(22px, 2.8vw, 30px); font-weight: 800; line-height: 1.4; letter-spacing: -0.02em; max-width: 760px; margin: 0 auto 20px;">
                <?= nl2br(e($s['about_vision_text'])) ?>
            </p>

            <span class="badge-3d" style="background: rgba(217,164,65,0.3); border-color: rgba(217,164,65,0.5);">
                <?= renderAboutIcon('sparkle', 16, '#f2c063') ?>
                <span style="font-weight: 800; color: #f2c063; letter-spacing: 0.12em;">BERKEMAJUAN UNTUK UMAT</span>
            </span>
        </div>
    </div>
</section>

<!-- ================= MISI 3D ================= -->
<section class="section reveal">
    <div class="section-head">
        <h2>
            <?= renderAboutIcon('target', 32, 'currentColor') ?>
            <span>Misi Lembaga</span>
        </h2>
        <span class="chip"><?= count($mission) ?> poin strategis</span>
    </div>

    <div style="background: var(--white); border: 1px solid var(--border); border-radius: 24px; padding: 12px 28px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <?php foreach ($mission as $idx => $line): 
            $num = sprintf('%02d', $idx + 1);
        ?>
            <div style="display: flex; gap: 20px; align-items: flex-start; padding: 22px 0; border-bottom: 1px dashed var(--border);">
                <div class="mission-num-3d"><?= $num ?></div>
                <div style="flex: 1; padding-top: 12px;">
                    <p style="font-size: 16px; line-height: 1.7; color: var(--text); font-weight: 500;">
                        <?= e($line) ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ================= STRUKTUR ORGANISASI 3D ================= -->
<section class="section reveal">
    <div class="section-head">
        <h2>
            <?= renderAboutIcon('users', 32, 'currentColor') ?>
            <span>Struktur Organisasi</span>
        </h2>
        <span class="chip"><?= count($structureCards) ?> pengurus inti</span>
    </div>

    <div class="org-grid">
        <?php foreach ($structureCards as $idx => $s_card): 
            $namaParts = explode(' ', trim($s_card['nama']));
            $initial = strtoupper(substr($namaParts[0] ?? 'A', 0, 1));
            if (isset($namaParts[1])) {
                $initial .= strtoupper(substr($namaParts[1], 0, 1));
            }
            $jabatan = $s_card['jabatan'];
            $isKetua = stripos($jabatan, 'ketua') !== false;
            $isWakil = stripos($jabatan, 'wakil') !== false;
            $avatarClass = $isKetua ? 'avatar-3d-gold' : ($isWakil ? 'avatar-3d-emerald' : 'avatar-3d-teal');
        ?>
            <div class="org-card reveal stagger-<?= ($idx % 4) + 1 ?>" style="padding: 28px 20px; position: relative; overflow: hidden; text-align: center;">
                <?php if ($isKetua): ?>
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #d9a441, #f2c063, #d9a441);"></div>
                    <div style="position: absolute; top: 10px; right: 10px; background: linear-gradient(145deg, #fde68a, #d9a441); color: #03251f; padding: 4px 10px; border-radius: 999px; font-size: 9px; font-weight: 900; letter-spacing: 0.1em; display: flex; align-items: center; gap: 4px;">
                        <?= renderAboutIcon('crown', 12, 'currentColor') ?>
                        <span>PIMPINAN</span>
                    </div>
                <?php endif; ?>

                <div class="avatar-3d <?= $avatarClass ?>">
                    <?= e($initial) ?>
                </div>

                <b style="display: block; font-size: 16px; color: var(--ink); font-family: var(--font-display); margin-bottom: 4px; line-height: 1.3;">
                    <?= e($s_card['nama']) ?>
                </b>

                <span class="jabatan-3d <?= $isKetua ? 'jabatan-gold' : 'jabatan-emerald' ?>">
                    <?= e($jabatan) ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ================= QURAN VERSE 3D ================= -->
<section class="section reveal">
    <div class="quran-3d">
        <div style="position: relative; z-index: 1; max-width: 720px; margin: 0 auto;">
            <div class="quran-mark-3d">❝</div>
            <p class="quran-arabic-3d">
                إِنَّ اللَّهَ لَا يُغَيِّرُ مَا بِقَوْمٍ حَتَّىٰ يُغَيِّرُوا مَا بِأَنفُسِهِمْ
            </p>
            <p style="font-size: 18px; font-style: italic; line-height: 1.6; color: #fff; font-weight: 600; margin-bottom: 10px;">
                "Sesungguhnya Allah tidak mengubah keadaan suatu kaum sehingga mereka mengubah keadaan yang ada pada diri mereka sendiri."
            </p>
            <p style="font-size: 13px; color: #f2c063; font-weight: 700; letter-spacing: 0.1em;">
                — QS. AR-RA'D: 11
            </p>
        </div>
    </div>
</section>

<!-- ================= CTA FASTABIQUL KHAIRAT 3D ================= -->
<section class="cta-band reveal">
    <div>
        <span class="eyebrow eyebrow-light">
            <?= renderAboutIcon('lightning', 16, '#f2c063') ?>
            <span>SEMBOYAN KAMI</span>
        </span>
        <h3 style="margin-top: 10px;">Fastabiqul Khairat</h3>
        <p>Berlomba-lomba dalam kebaikan — menjiwai Catur Dharma Perguruan Tinggi Muhammadiyah untuk umat dan bangsa.</p>
    </div>
</section>

<!-- ================= CATUR DHARMA 3D ================= -->
<section class="section reveal">
    <div class="section-head">
        <h2>
            <?= renderAboutIcon('graduation-cap', 32, 'currentColor') ?>
            <span>Catur Dharma Perguruan Tinggi Muhammadiyah</span>
        </h2>
        <span class="chip">4 pilar utama</span>
    </div>

    <div class="grid">
        <div class="card reveal stagger-1" style="position: relative; overflow: hidden;">
            <div class="card-num-3d">01</div>
            <div style="display: flex; justify-content: flex-start; margin-bottom: 14px;">
                <div class="ico-3d ico-3d-gold">
                    <?= renderAboutIcon('graduation-cap', 28, '#ffffff') ?>
                </div>
            </div>
            <h3>Pendidikan & Pengajaran</h3>
            <p>Mendukung peningkatan mutu pembelajaran, kurikulum, dan kompetensi dosen untuk mencetak lulusan unggul dan berkarakter.</p>
        </div>

        <div class="card reveal stagger-2" style="position: relative; overflow: hidden;">
            <div class="card-num-3d">02</div>
            <div style="display: flex; justify-content: flex-start; margin-bottom: 14px;">
                <div class="ico-3d ico-3d-blue">
                    <?= renderAboutIcon('microscope', 28, '#ffffff') ?>
                </div>
            </div>
            <h3>Penelitian</h3>
            <p>Mendorong riset dosen dan mahasiswa yang berdampak pada pengembangan ilmu pengetahuan, teknologi, dan pemberdayaan masyarakat.</p>
        </div>

        <div class="card reveal stagger-3" style="position: relative; overflow: hidden;">
            <div class="card-num-3d">03</div>
            <div style="display: flex; justify-content: flex-start; margin-bottom: 14px;">
                <div class="ico-3d">
                    <?= renderAboutIcon('handshake', 28, '#ffffff') ?>
                </div>
            </div>
            <h3>Pengabdian kepada Masyarakat</h3>
            <p>Mengelola program pengabdian, KKN, desa binaan, dan kemitraan strategis dengan masyarakat luas.</p>
        </div>

        <div class="card reveal stagger-4" style="position: relative; overflow: hidden;">
            <div class="card-num-3d">04</div>
            <div style="display: flex; justify-content: flex-start; margin-bottom: 14px;">
                <div class="ico-3d ico-3d-purple">
                    <?= renderAboutIcon('mosque', 28, '#ffffff') ?>
                </div>
            </div>
            <h3>Al-Islam & Kemuhammadiyahan</h3>
            <p>Mengintegrasikan nilai-nilai Islam dan Kemuhammadiyahan dalam seluruh aktivitas akademik, sosial, dan amal usaha kampus.</p>
        </div>
    </div>
</section>

<!-- ================= IMPACT BOX 3D ================= -->
<section class="section reveal">
    <div style="background: linear-gradient(135deg, #043b2c 0%, #065f46 60%, #059669 100%); color: white; padding: 52px 44px; border-radius: 28px; text-align: center; box-shadow: 0 30px 70px rgba(0,0,0,0.4); position: relative; overflow: hidden;">
        <!-- Ornamen 3D -->
        <div style="position: absolute; top: -80px; right: -60px; width: 260px; height: 260px; border-radius: 50%; background: radial-gradient(circle, rgba(217,164,65,0.3), transparent 70%); pointer-events: none;"></div>
        <div style="position: absolute; bottom: -80px; left: -40px; width: 200px; height: 200px; border-radius: 50%; background: radial-gradient(circle, rgba(110,231,183,0.25), transparent 70%); pointer-events: none;"></div>

        <div style="position: relative; z-index: 1;">
            <span class="about-badge-3d" style="position: static; display: inline-flex; margin-bottom: 16px;">
                <?= renderAboutIcon('sparkle', 16, 'currentColor') ?>
                <span>JEJAK KAMI DALAM ANGKA</span>
            </span>

            <div class="impact-num-3d">
                <?= number_format($totalKarya) ?>+
            </div>

            <p style="font-size: 17px; opacity: 0.9; max-width: 540px; margin: 12px auto 0; line-height: 1.6;">
                Karya ilmiah, pengabdian, HAKI, kegiatan AIK, berita, dan dokumen
                yang telah kami dokumentasikan untuk umat dan bangsa.
            </p>

            <div style="margin-top: 30px; display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
                <a href="<?= e(url('public/index.php?page=publikasi')) ?>" class="cta-3d cta-3d-primary">
                    <?= renderAboutIcon('book-open', 20, 'currentColor') ?>
                    <span>Jelajahi Publikasi</span>
                </a>
                <a href="<?= e(url('public/index.php?page=pengabdian')) ?>" class="cta-3d cta-3d-ghost">
                    <?= renderAboutIcon('handshake', 20, 'currentColor') ?>
                    <span>Lihat Pengabdian</span>
                </a>
            </div>
        </div>
    </div>
</section>