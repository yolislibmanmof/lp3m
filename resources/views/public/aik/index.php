<?php
// === PAGINATION (untuk list kegiatan terbaru) ===
$paging = AikActivity::paginate(
    ['status' => 'published'],
    '',
    [],
    (int) ($page ?? 1),
    12, // hanya fetch 12 per halaman, bukan 200!
    'activity_date DESC'
);
$items = $paging['items'];
$totalPages = $paging['totalPages'] ?? 1;

// === AGENDA MENDATANG (query terfilter di DB, bukan PHP) ===
$upcomingStmt = Database::pdo()->prepare(
    'SELECT * FROM aik_activities 
     WHERE status = "published" AND activity_date >= CURDATE() 
     ORDER BY activity_date ASC LIMIT 5'
);
$upcomingStmt->execute();
$upcoming = $upcomingStmt->fetchAll();

// === AGENDA LALU (query terfilter di DB) ===
$pastStmt = Database::pdo()->prepare(
    'SELECT COUNT(*) FROM aik_activities 
     WHERE status = "published" AND activity_date < CURDATE()'
);
$pastStmt->execute();
$totalPast = (int) $pastStmt->fetchColumn();

$totalUpcoming = count($upcoming);

// === TOTAL (1 query count) ===
$totalStmt = Database::pdo()->query('SELECT COUNT(*) FROM aik_activities WHERE status = "published"');
$totalAik = (int) $totalStmt->fetchColumn();
// === SATU QUERY UNTUK SEMUA KATEGORI AIK ===
$aikCatStmt = Database::pdo()->query(
    'SELECT category, COUNT(*) as cnt FROM aik_activities 
     WHERE status = "published" GROUP BY category'
);
$aikCatCounts = [];
foreach ($aikCatStmt->fetchAll() as $row) {
    $aikCatCounts[$row['category']] = (int) $row['cnt'];
}
$categoryStats = [];
foreach (AikActivity::CATEGORIES as $key => $label) {
    $categoryStats[$key] = ['label' => $label, 'count' => $aikCatCounts[$key] ?? 0];
}

$timelineStmt = Database::pdo()->query(
    'SELECT DATE_FORMAT(activity_date, "%Y-%m") as ym, COUNT(*) as cnt 
     FROM aik_activities WHERE status = "published" 
     GROUP BY DATE_FORMAT(activity_date, "%Y-%m") 
     ORDER BY ym DESC LIMIT 12'
);
$timeline = $timelineStmt->fetchAll();

$locationStmt = Database::pdo()->query(
    'SELECT location, COUNT(*) as cnt FROM aik_activities WHERE status = "published" GROUP BY location ORDER BY cnt DESC LIMIT 8'
);
$locations = $locationStmt->fetchAll();

$hijriMonths = ['Muharram','Safar','Rabiul Awal','Rabiul Akhir','Jumadil Awal','Jumadil Akhir','Rajab','Syaban','Ramadhan','Syawal','Zulkaidah','Zulhijjah'];
$currentHijriMonth = $hijriMonths[((int) date('n') + 5) % 12];

$marqueeWords = ['Fastabiqul Khairat', 'Berkemajuan', 'Mencerahkan', 'Memberdayakan', "Ta'awun", 'Amal Shalih'];

$quotes = [
    ['"Sesungguhnya Allah mencintai orang-orang yang berbuat kebajikan." (QS. Al-Baqarah: 195)', 'إِنَّ اللَّهَ يُحِبُّ الْمُحْسِنِينَ'],
    ['"Dan tolong-menolonglah kamu dalam (mengerjakan) kebajikan dan takwa." (QS. Al-Maidah: 2)', 'وَتَعَاوَنُوا عَلَى الْبِرِّ وَالتَّقْوَى'],
    ['"Sebaik-baik manusia adalah yang paling bermanfaat bagi manusia." (HR. Ahmad)', 'خَيْرُ النَّاسِ أَنْفَعُهُمْ لِلنَّاسِ'],
    ['"Barangsiapa beriman kepada Allah dan hari akhir, hendaklah ia berkata baik atau diam." (HR. Bukhari-Muslim)', 'مَنْ كَانَ يُؤْمِنُ بِاللَّهِ وَالْيَوْمِ الآخِرِ فَلْيَقُلْ خَيْرًا أَوْ لِيَصْمُتْ'],
];
$randomQuote = $quotes[array_rand($quotes)];

// Countdown ke agenda terdekat
$nextEvent = $upcoming[0] ?? null;
$countdownDays = 0;
$countdownHours = 0;
if ($nextEvent) {
    $diff = strtotime($nextEvent['activity_date']) - time();
    if ($diff > 0) {
        $countdownDays = (int) floor($diff / 86400);
        $countdownHours = (int) floor(($diff % 86400) / 3600);
    }
}
?>

<style>
    @keyframes aikFloat1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(20px,-15px)} }
    @keyframes aikFloat2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-15px,20px)} }
    @keyframes aikFloat3 { 0%,100%{transform:translate(0,0) rotate(0)} 50%{transform:translate(10px,10px) rotate(10deg)} }
    @keyframes aikSpin { from {transform:rotate(0)} to {transform:rotate(360deg)} }
    @keyframes aikPulse {
        0%, 100% { box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.2), 0 6px 16px rgba(5,150,105,0.35); }
        50%      { box-shadow: inset 0 2px 3px rgba(255,255,255,0.8), inset 0 -3px 4px rgba(0,0,0,0.2), 0 8px 22px rgba(5,150,105,0.5); }
    }
    @keyframes aikGlow {
        0%, 100% { text-shadow: 0 0 20px rgba(242,192,99,0.5), 0 0 40px rgba(217,164,65,0.3); }
        50%      { text-shadow: 0 0 30px rgba(242,192,99,0.8), 0 0 60px rgba(217,164,65,0.5); }
    }
    @keyframes aikShine {
        0%   { transform: translateX(-100%) skewX(-20deg); }
        100% { transform: translateX(300%) skewX(-20deg); }
    }
    @keyframes crescentGlow {
        0%, 100% { filter: drop-shadow(0 0 12px rgba(242,192,99,0.5)); }
        50%      { filter: drop-shadow(0 0 24px rgba(242,192,99,0.9)); }
    }

    /* ===== ISLAMIC GEOMETRIC PATTERN (CSS Only) ===== */
    .islamic-pattern {
        position: absolute;
        inset: 0;
        pointer-events: none;
        opacity: 0.04;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 20px, currentColor 20px, currentColor 21px),
            repeating-linear-gradient(-45deg, transparent, transparent 20px, currentColor 20px, currentColor 21px),
            repeating-linear-gradient(90deg, transparent, transparent 20px, currentColor 20px, currentColor 21px),
            repeating-linear-gradient(0deg, transparent, transparent 20px, currentColor 20px, currentColor 21px);
    }

    /* ===== FLOATING ORBS ===== */
    .aik-orb { position: absolute; border-radius: 50%; pointer-events: none; z-index: 0; }
    .aik-orb-1 { width: 140px; height: 140px; top: 12%; right: 8%; background: radial-gradient(circle at 30% 30%, rgba(253,230,138,0.6), rgba(217,164,65,0.3) 60%, transparent); filter: blur(2px); animation: aikFloat1 8s ease-in-out infinite; }
    .aik-orb-2 { width: 200px; height: 200px; bottom: 15%; left: 5%; background: radial-gradient(circle at 70% 70%, rgba(110,231,183,0.4), rgba(16,185,129,0.2) 60%, transparent); filter: blur(3px); animation: aikFloat2 10s ease-in-out infinite; }
    .aik-orb-3 { width: 90px; height: 90px; top: 60%; right: 28%; background: radial-gradient(circle at 30% 30%, rgba(167,139,250,0.5), rgba(124,58,237,0.2) 60%, transparent); filter: blur(1px); animation: aikFloat3 6s ease-in-out infinite; }

    /* ===== CRESCENT MOON 3D ===== */
    .crescent-3d {
        width: 56px; height: 56px; border-radius: 50%; flex-shrink: 0;
        background: radial-gradient(circle at 60% 40%, transparent 40%, #fde68a 41%, #d9a441 80%, #a9761b);
        box-shadow: inset -3px -2px 6px rgba(0,0,0,0.25), 0 6px 16px rgba(217,164,65,0.4);
        position: relative;
        animation: crescentGlow 3s ease-in-out infinite;
    }
    .crescent-3d-lg {
        width: 72px; height: 72px;
    }
    .crescent-3d-xl {
        width: 96px; height: 96px;
    }

    /* ===== 3D ICON ORBS ===== */
    .ico-aik {
        display: inline-flex; align-items: center; justify-content: center;
        width: 52px; height: 52px; border-radius: 16px; font-size: 24px;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #34d399, #10b981 50%, #059669);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(5,150,105,0.35);
        position: relative; overflow: hidden; flex-shrink: 0;
    }
    .ico-aik::before {
        content: ''; position: absolute; top: 5px; left: 10px;
        width: 16px; height: 7px; border-radius: 50%;
        background: rgba(255,255,255,0.6); filter: blur(2px);
    }
    .ico-aik-lg { width: 68px; height: 68px; border-radius: 20px; font-size: 32px; }
    .ico-aik-gold {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%),
                    linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -3px 4px rgba(0,0,0,0.2), 0 6px 16px rgba(217,164,65,0.4);
    }
    .ico-aik-purple {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #c4b5fd, #a78bfa 50%, #7c3aed);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(124,58,237,0.35);
    }
    .ico-aik-blue {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #60a5fa, #3b82f6 50%, #1d4ed8);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(59,130,246,0.35);
    }
    .ico-aik-pink {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #f9a8d4, #ec4899 50%, #be185d);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(236,72,153,0.35);
    }

    /* ===== 3D QURAN VERSE BOX ===== */
    .quran-verse-3d {
        position: relative; padding: 40px 36px;
        border-radius: 28px; overflow: hidden;
        background: linear-gradient(135deg, #043b2c 0%, #065f46 50%, #059669 100%);
        color: white; text-align: center;
        box-shadow: 0 20px 50px rgba(0,0,0,0.35);
    }
    .quran-verse-3d::before {
        content: ''; position: absolute; inset: 0;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 25px, rgba(255,255,255,0.03) 25px, rgba(255,255,255,0.03) 26px),
            repeating-linear-gradient(-45deg, transparent, transparent 25px, rgba(255,255,255,0.03) 25px, rgba(255,255,255,0.03) 26px);
        pointer-events: none;
    }
    .quran-verse-3d::after {
        content: ''; position: absolute; top: -50%; right: -10%;
        width: 400px; height: 400px; border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,0.25), transparent 70%);
        pointer-events: none;
    }
    .quran-arabic-3d {
        font-size: clamp(24px, 3.5vw, 38px);
        line-height: 2;
        margin-bottom: 18px;
        color: #fde68a;
        font-weight: 500;
        direction: rtl;
        font-family: 'Amiri', 'Scheherazade New', serif;
        animation: aikGlow 3s ease-in-out infinite;
        position: relative; z-index: 1;
    }

    /* ===== 3D HIJRI CALENDAR ===== */
    .hijri-card-3d {
        position: relative; padding: 24px;
        background: linear-gradient(145deg, #065f46, #043b2c);
        border: 1px solid rgba(217,164,65,0.25);
        border-radius: 22px; overflow: hidden;
        color: white;
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.08), 0 10px 30px rgba(0,0,0,0.3);
    }
    .hijri-card-3d::before {
        content: ''; position: absolute; inset: 0;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 30px, rgba(217,164,65,0.04) 30px, rgba(217,164,65,0.04) 31px),
            repeating-linear-gradient(-45deg, transparent, transparent 30px, rgba(217,164,65,0.04) 30px, rgba(217,164,65,0.04) 31px);
    }

    /* ===== 3D COUNTER ===== */
    .aik-counter-3d {
        font-family: var(--font-display); font-size: 44px; font-weight: 900; line-height: 1;
        background: linear-gradient(135deg, #fde68a, #f2c063 40%, #d9a441);
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: aikGlow 3s ease-in-out infinite;
    }

    /* ===== 3D CATEGORY CHIPS ===== */
    .aik-cat-chip {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 18px; border-radius: 999px;
        background: var(--white); border: 1px solid var(--border);
        font-size: 13px; font-weight: 700; color: var(--ink);
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.9), 0 4px 12px rgba(0,0,0,0.06);
        transition: all 0.25s;
    }
    .aik-cat-chip:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 22px rgba(5,150,105,0.18);
        border-color: rgba(5,150,105,0.3);
    }
    .aik-cat-dot {
        width: 10px; height: 10px; border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #fde68a, #d9a441);
        box-shadow: 0 0 6px rgba(217,164,65,0.6);
    }

    /* ===== 3D COUNTDOWN ===== */
    .countdown-3d {
        position: relative; padding: 32px;
        background: linear-gradient(145deg, #043b2c, #065f46);
        border: 1px solid rgba(217,164,65,0.3);
        border-radius: 26px; overflow: hidden;
        color: white;
        box-shadow: 0 16px 40px rgba(0,0,0,0.3);
    }
    .countdown-3d::before {
        content: ''; position: absolute; inset: 0;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 22px, rgba(217,164,65,0.05) 22px, rgba(217,164,65,0.05) 23px),
            repeating-linear-gradient(-45deg, transparent, transparent 22px, rgba(217,164,65,0.05) 22px, rgba(217,164,65,0.05) 23px);
    }
    .cd-num-3d {
        display: inline-flex; align-items: center; justify-content: center;
        width: 64px; height: 72px; border-radius: 16px;
        background: linear-gradient(145deg, rgba(255,255,255,0.12), rgba(255,255,255,0.04));
        border: 1px solid rgba(255,255,255,0.15);
        font-family: var(--font-display); font-size: 36px; font-weight: 900;
        color: #f2c063; line-height: 1;
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.1), inset 0 -2px 3px rgba(0,0,0,0.3);
        animation: aikGlow 3s ease-in-out infinite;
    }
    .cd-label-3d {
        font-size: 10px; font-weight: 800; letter-spacing: 0.15em;
        color: rgba(255,255,255,0.7); margin-top: 6px;
    }

    /* ===== 3D AGENDA CARD ===== */
    .agenda-3d {
        display: flex; gap: 16px; padding: 18px 22px;
        background: var(--white); border: 1px solid var(--border);
        border-radius: 20px; transition: all 0.3s;
        position: relative; overflow: hidden;
    }
    .agenda-3d::before {
        content: ''; position: absolute; left: 0; top: 0; bottom: 0;
        width: 4px; background: linear-gradient(180deg, #d9a441, #059669);
    }
    .agenda-3d:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(5,150,105,0.15);
        border-color: rgba(5,150,105,0.3);
    }
    .agenda-date-3d {
        flex-shrink: 0; width: 60px; height: 60px; border-radius: 14px;
        background: linear-gradient(145deg, #043b2c, #065f46);
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        color: white; position: relative; overflow: hidden;
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.1), inset 0 -2px 3px rgba(0,0,0,0.3), 0 4px 10px rgba(0,0,0,0.2);
    }
    .agenda-date-3d::before {
        content: ''; position: absolute; top: 3px; left: 10px;
        width: 40%; height: 30%; border-radius: 50%;
        background: rgba(255,255,255,0.1); filter: blur(2px);
    }
    .agenda-date-day {
        font-family: var(--font-display); font-size: 20px; font-weight: 900;
        color: #f2c063; line-height: 1;
    }
    .agenda-date-mon {
        font-size: 9px; font-weight: 800; letter-spacing: 0.1em;
        color: rgba(255,255,255,0.8); margin-top: 2px;
    }
    .segera-badge-3d {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 11px; border-radius: 999px;
        font-size: 10px; font-weight: 900; letter-spacing: 0.15em;
        color: #03251f;
        background: linear-gradient(145deg, #fde68a, #d9a441);
        box-shadow: inset 0 1px 2px rgba(255,255,255,0.7), inset 0 -2px 3px rgba(0,0,0,0.2), 0 3px 8px rgba(217,164,65,0.35);
        position: relative;
    }
    .segera-badge-3d::before {
        content: ''; position: absolute; top: 2px; left: 5px;
        width: 30%; height: 35%; border-radius: 50%;
        background: rgba(255,255,255,0.6); filter: blur(1px);
    }

    /* ===== 3D CATUR DHARMA CARD ===== */
    .cd-card-3d {
        position: relative; padding: 28px 22px;
        background: var(--white); border: 1px solid var(--border);
        border-radius: 22px; overflow: hidden;
        transition: all 0.35s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
    }
    .cd-card-3d::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, #d9a441, #059669);
        transform: scaleX(0); transform-origin: left;
        transition: transform 0.4s ease;
    }
    .cd-card-3d:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 36px rgba(5,150,105,0.18);
        border-color: rgba(5,150,105,0.3);
    }
    .cd-card-3d:hover::before { transform: scaleX(1); }
    .cd-card-3d:hover .cd-num-3d {
        transform: scale(1.1) rotate(-6deg);
        background: linear-gradient(145deg, #fde68a, #d9a441);
        color: #03251f;
    }
    .cd-num-3d {
        position: absolute; top: 14px; right: 14px;
        width: 42px; height: 42px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display); font-weight: 900; font-size: 16px;
        background: rgba(5,150,105,0.1); color: var(--primary-dark);
        transition: all 0.35s cubic-bezier(0.16,1,0.3,1);
    }

    /* ===== 3D DUA BOX (Doa Penutup) ===== */
    .dua-box-3d {
        position: relative; padding: 44px 38px;
        background: linear-gradient(135deg, #043b2c 0%, #065f46 60%, #059669 100%);
        border-radius: 28px; text-align: center;
        color: white; overflow: hidden;
        box-shadow: 0 24px 60px rgba(0,0,0,0.4);
    }
    .dua-box-3d::before {
        content: ''; position: absolute; inset: 0;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(217,164,65,0.04) 20px, rgba(217,164,65,0.04) 21px),
            repeating-linear-gradient(-45deg, transparent, transparent 20px, rgba(217,164,65,0.04) 20px, rgba(217,164,65,0.04) 21px);
    }
    .dua-box-3d::after {
        content: ''; position: absolute; bottom: -60%; left: 50%;
        transform: translateX(-50%);
        width: 400px; height: 400px; border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,0.2), transparent 70%);
    }
    .dua-arabic-3d {
        font-size: clamp(22px, 3vw, 32px);
        line-height: 2; color: #fde68a;
        font-family: 'Amiri', 'Scheherazade New', serif;
        margin-bottom: 16px; direction: rtl;
        animation: aikGlow 3s ease-in-out infinite;
        position: relative; z-index: 1;
    }
    .dua-transliteration-3d {
        font-size: 15px; font-style: italic;
        color: rgba(255,255,255,0.85);
        margin-bottom: 10px; font-weight: 500;
        position: relative; z-index: 1;
    }
    .dua-translation-3d {
        font-size: 15px; line-height: 1.7;
        color: rgba(255,255,255,0.9);
        max-width: 600px; margin: 0 auto;
        position: relative; z-index: 1;
    }
    .dua-source-3d {
        display: inline-flex; align-items: center; gap: 8px;
        margin-top: 18px; padding: 6px 16px;
        background: rgba(217,164,65,0.25);
        border: 1px solid rgba(217,164,65,0.4);
        border-radius: 999px;
        font-size: 12px; font-weight: 800;
        color: #f2c063; letter-spacing: 0.1em;
        position: relative; z-index: 1;
    }

    /* ===== 3D CTA ===== */
    .aik-cta-3d {
        position: relative; display: inline-flex; align-items: center; gap: 8px;
        padding: 13px 24px; border-radius: 13px;
        font-weight: 700; font-size: 14px; overflow: hidden;
        transition: transform 0.3s cubic-bezier(0.16,1,0.3,1);
        text-decoration: none;
    }
    .aik-cta-3d::after {
        content: ''; position: absolute; top: 0; left: -100%;
        width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,0.5), transparent);
        animation: aikShine 3s ease-in-out infinite;
    }
    .aik-cta-primary {
        background: linear-gradient(145deg, #fde68a, #d9a441);
        color: #03251f;
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -2px 3px rgba(0,0,0,0.15), 0 8px 20px rgba(217,164,65,0.4);
    }
    .aik-cta-ghost {
        background: transparent; color: #fff;
        border: 2px solid rgba(255,255,255,0.35);
    }
    .aik-cta-3d:hover { transform: translateY(-3px); }
    .aik-cta-primary:hover { box-shadow: inset 0 2px 3px rgba(255,255,255,0.8), 0 14px 30px rgba(217,164,65,0.55); }
    .aik-cta-ghost:hover { background: rgba(255,255,255,0.1); border-color: #fff; }

    /* ===== 3D MOD CARD (Kegiatan Terbaru) ===== */
    .aik-mod-card-3d {
        position: relative; padding: 24px;
        background: var(--white); border: 1px solid var(--border);
        border-radius: 22px; overflow: hidden;
        transition: all 0.35s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
    }
    .aik-mod-card-3d:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 36px rgba(5,150,105,0.18);
        border-color: rgba(5,150,105,0.3);
    }
    .aik-mod-card-3d::after {
        content: ''; position: absolute; bottom: 0; right: 0;
        width: 120px; height: 120px; border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,0.06), transparent 70%);
        pointer-events: none;
    }
</style>

<!-- ================= HERO 3D ================= -->
<section class="news-hero aik-hero" style="position: relative; overflow: hidden;">
    <div class="aik-orb aik-orb-1"></div>
    <div class="aik-orb aik-orb-2"></div>
    <div class="aik-orb aik-orb-3"></div>

    <span class="hero-chip c1" style="z-index: 2;">🕌 Dharma Keempat</span>
    <span class="hero-chip c2" style="z-index: 2;">✦ Berkemajuan</span>

    <span class="eyebrow eyebrow-light" style="z-index: 2;">Dharma Keempat</span>
    <h1 style="z-index: 2;">Al-Islam & <span class="gold-text">Kemuhammadiyahan</span></h1>
    <p style="z-index: 2;">
        Mengintegrasikan nilai-nilai Al-Islam dan Kemuhammadiyahan
        dalam seluruh aktivitas tridharma perguruan tinggi.
    </p>
</section>

<!-- ================= INSPIRASI HARI INI 3D ================= -->
<section class="section reveal">
    <div class="section-head">
        <h2>💫 Inspirasi Hari Ini</h2>
        <span class="chip">📅 Bulan <?= $currentHijriMonth ?></span>
    </div>

    <div class="quran-verse-3d">
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; justify-content: center; margin-bottom: 18px;">
                <div class="crescent-3d crescent-3d-lg"></div>
            </div>

            <p class="quran-arabic-3d"><?= e($randomQuote[1]) ?></p>

            <p style="font-size: 17px; font-style: italic; line-height: 1.6; margin-bottom: 10px; font-family: var(--font-display); font-weight: 600; position: relative; z-index: 1; color: #fff;">
                <?= $randomQuote[0] ?>
            </p>

            <p style="font-size: 12px; opacity: 0.7; margin-top: 14px; letter-spacing: 0.1em;">
                📅 <?= e(date('d M Y')) ?> · Bulan <?= $currentHijriMonth ?>
            </p>
        </div>
    </div>
</section>

<!-- ================= STATS COUNTER 3D ================= -->
<section class="stats">
    <div class="stat reveal stagger-1" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(217,164,65,0.2), transparent 70%);"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-aik ico-aik-gold">🕌</div>
            <div>
                <div class="aik-counter-3d" data-count="<?= $totalAik ?>" data-suffix="+">0</div>
                <div class="stat-label">Kegiatan AIK</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-2" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(16,185,129,0.2), transparent 70%);"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-aik">📅</div>
            <div>
                <div class="aik-counter-3d" data-count="<?= $totalUpcoming ?>">0</div>
                <div class="stat-label">Agenda Mendatang</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-3" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(59,130,246,0.2), transparent 70%);"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-aik ico-aik-blue">✅</div>
            <div>
                <div class="aik-counter-3d" data-count="<?= $totalPast ?>">0</div>
                <div class="stat-label">Kegiatan Terlaksana</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-4" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(124,58,237,0.2), transparent 70%);"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-aik ico-aik-purple">🏷️</div>
            <div>
                <div class="aik-counter-3d" data-count="<?= count(AikActivity::CATEGORIES) ?>">0</div>
                <div class="stat-label">Kategori Kegiatan</div>
            </div>
        </div>
    </div>
</section>

<!-- ================= MARQUEE ================= -->
<div class="marquee" aria-hidden="true">
    <div class="marquee-track">
        <?php foreach (array_merge($marqueeWords, $marqueeWords) as $m): ?>
            <span class="marquee-item"><?= e($m) ?></span>
        <?php endforeach; ?>
    </div>
</div>

<!-- ================= COUNTDOWN AGENDA TERDEKAT 3D ================= -->
<?php if ($nextEvent !== null): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>⏳ Agenda Terdekat</h2>
        <span class="chip">Hitung mundur</span>
    </div>

    <div class="countdown-3d">
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; justify-content: center; margin-bottom: 14px;">
                <div class="crescent-3d crescent-3d-lg"></div>
            </div>

            <p style="font-size: 11px; letter-spacing: 0.2em; color: #f2c063; font-weight: 900; margin-bottom: 10px; text-align: center;">
                MENUJU ACARA BERIKUTNYA
            </p>

            <h3 style="font-size: clamp(18px, 2.5vw, 24px); font-weight: 800; margin: 0 0 6px; text-align: center; line-height: 1.3;">
                <?= e($nextEvent['title']) ?>
            </h3>

            <p style="font-size: 13px; opacity: 0.8; margin-bottom: 22px; text-align: center;">
                📅 <?= e(date('d M Y', strtotime($nextEvent['activity_date']))) ?>
                · 📍 <?= e($nextEvent['location']) ?>
            </p>

            <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                <div style="text-align: center;">
                    <div class="cd-num-3d"><?= $countdownDays ?></div>
                    <div class="cd-label-3d">HARI</div>
                </div>
                <div style="text-align: center;">
                    <div class="cd-num-3d"><?= $countdownHours ?></div>
                    <div class="cd-label-3d">JAM</div>
                </div>
                <div style="text-align: center;">
                    <div class="cd-num-3d"><?= max(0, 59 - (int)date('i')) ?></div>
                    <div class="cd-label-3d">MENIT</div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================= STATISTIK PER KATEGORI 3D ================= -->
<?php if ($categoryStats !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>📊 Statistik per Kategori</h2>
        <span class="chip">Distribusi kegiatan</span>
    </div>

    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <?php foreach ($categoryStats as $key => $stat): ?>
            <span class="aik-cat-chip">
                <span class="aik-cat-dot"></span>
                <?= e($stat['label']) ?>
                <span style="opacity: 0.5;">·</span>
                <strong style="color: var(--primary-dark);"><?= (int) $stat['count'] ?></strong>
            </span>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= TIMELINE 3D ================= -->
<?php if ($timeline !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>📅 Timeline Kegiatan</h2>
    </div>

    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <?php foreach ($timeline as $t): ?>
            <?php
            $ym = explode('-', $t['ym']);
            $bulanNama = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            $label = $bulanNama[(int)$ym[1]-1] . ' ' . $ym[0];
            ?>
            <span class="aik-cat-chip">
                📅 <?= e($label) ?>
                <span style="opacity: 0.5;">·</span>
                <strong style="color: var(--primary-dark);"><?= (int) $t['cnt'] ?></strong>
            </span>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= LOKASI 3D ================= -->
<?php if ($locations !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>📍 Lokasi Kegiatan</h2>
        <span class="chip"><?= count($locations) ?> lokasi</span>
    </div>

    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <?php foreach ($locations as $loc): ?>
            <span class="aik-cat-chip">
                📍 <?= e($loc['location']) ?>
                <?php if ((int) $loc['cnt'] > 1): ?>
                    <span style="opacity: 0.5;">·</span>
                    <strong style="color: var(--primary-dark);"><?= (int) $loc['cnt'] ?></strong>
                <?php endif; ?>
            </span>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= AGENDA MENDATANG 3D ================= -->
<?php if ($upcoming !== []): ?>
<section class="section">
    <div class="section-head">
        <h2>📅 Agenda Mendatang</h2>
        <span class="chip"><?= count($upcoming) ?> acara</span>
    </div>

    <div style="display: flex; flex-direction: column; gap: 12px;">
        <?php foreach (array_slice($upcoming, 0, 5) as $idx => $u): 
            $eventDay = date('d', strtotime($u['activity_date']));
            $eventMon = strtoupper(date('M', strtotime($u['activity_date'])));
        ?>
            <div class="agenda-3d reveal">
                <div class="agenda-date-3d">
                    <div class="agenda-date-day"><?= $eventDay ?></div>
                    <div class="agenda-date-mon"><?= $eventMon ?></div>
                </div>

                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 6px; flex-wrap: wrap;">
                        <span class="segera-badge-3d">⏰ SEGERA</span>
                        <span style="font-size: 11px; color: var(--muted); font-weight: 700;">
                            <?= e(AikActivity::CATEGORIES[$u['category']] ?? $u['category']) ?>
                        </span>
                    </div>

                    <h3 style="color: var(--ink); font-size: 15px; font-weight: 800; line-height: 1.4; margin: 0 0 6px;">
                        <?= e($u['title']) ?>
                    </h3>

                    <div style="display: flex; gap: 10px; font-size: 12px; color: var(--muted); flex-wrap: wrap;">
                        <span>📅 <?= e(date('d M Y', strtotime($u['activity_date']))) ?></span>
                        <span>📍 <?= e($u['location']) ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= CATUR DHARMA 3D ================= -->
<section class="section">
    <div class="section-head">
        <h2>🎓 Catur Dharma Perguruan Tinggi Muhammadiyah</h2>
        <span class="chip">4 pilar utama</span>
    </div>

    <div class="grid">
        <div class="cd-card-3d reveal stagger-1">
            <div class="cd-num-3d">01</div>
            <div style="display: flex; justify-content: flex-start; margin-bottom: 14px;">
                <div class="ico-aik ico-aik-gold">🎓</div>
            </div>
            <h3>Pendidikan & Pengajaran</h3>
            <p>Pembelajaran yang unggul dan berkemajuan.</p>
        </div>
        <div class="cd-card-3d reveal stagger-2">
            <div class="cd-num-3d">02</div>
            <div style="display: flex; justify-content: flex-start; margin-bottom: 14px;">
                <div class="ico-aik ico-aik-blue">🔬</div>
            </div>
            <h3>Penelitian</h3>
            <p>Riset yang bermanfaat bagi umat dan bangsa.</p>
        </div>
        <div class="cd-card-3d reveal stagger-3">
            <div class="cd-num-3d">03</div>
            <div style="display: flex; justify-content: flex-start; margin-bottom: 14px;">
                <div class="ico-aik">🤝</div>
            </div>
            <h3>Pengabdian</h3>
            <p>Pemberdayaan masyarakat yang berkelanjutan.</p>
        </div>
        <div class="cd-card-3d reveal stagger-4">
            <div class="cd-num-3d">04</div>
            <div style="display: flex; justify-content: flex-start; margin-bottom: 14px;">
                <div class="ico-aik ico-aik-purple">🕌</div>
            </div>
            <h3>AIK</h3>
            <p>Penjiwaan nilai Islam dan Kemuhammadiyahan dalam seluruh amal usaha.</p>
        </div>
    </div>
</section>

<!-- ================= KEGIATAN AIK TERBARU 3D ================= -->
<section class="section">
    <div class="section-head">
        <h2>📰 Kegiatan AIK Terbaru</h2>
    </div>

    <?php if ($items === []): ?>
        <p class="news-empty">Belum ada kegiatan AIK yang dipublikasikan.</p>
    <?php else: ?>
        <div class="mod-grid">
            <?php foreach ($items as $item): ?>
                <div class="aik-mod-card-3d reveal">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <div class="ico-aik ico-aik-purple">🕌</div>
                        <div class="news-meta" style="margin: 0; gap: 8px;">
                            <span class="badge"><?= e(AikActivity::CATEGORIES[$item['category']] ?? $item['category']) ?></span>
                            <span>📅 <?= e(date('d M Y', strtotime($item['activity_date']))) ?></span>
                        </div>
                    </div>

                    <h3 style="margin-bottom: 8px;"><?= e($item['title']) ?></h3>

                    <div class="mod-meta">
                        <span>📍 <b>Lokasi:</b> <?= e($item['location']) ?></span>
                    </div>

                    <?php if (!empty($item['description'])): ?>
                        <p class="mod-desc" style="margin-top: 10px;"><?= e(excerpt($item['description'], 120)) ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- ================= PAGINATION ================= -->
<?php if ($totalPages > 1): ?>
    <div class="pagination" style="display: flex; gap: 6px; flex-wrap: wrap; margin-top: 22px;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= e(url('public/index.php?page=aik&hal=' . $i)) ?>" class="aik-cat-chip <?= $i === $page ? 'active' : '' ?>" style="padding: 8px 14px; <?= $i === $page ? 'background: linear-gradient(145deg, #065f46, #043b2c); color: #f2c063; border-color: transparent;' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

<!-- ================= DOA PENUTUP 3D ================= -->
<section class="section reveal">
    <div class="section-head">
        <h2>🤲 Doa Penutup</h2>
    </div>

    <div class="dua-box-3d">
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; justify-content: center; margin-bottom: 18px;">
                <div class="crescent-3d crescent-3d-xl"></div>
            </div>

            <p class="dua-arabic-3d">
                رَبَّنَا آتِنَا فِي الدُّنْيَا حَسَنَةً وَفِي الْآخِرَةِ حَسَنَةً وَقِنَا عَذَابَ النَّارِ
            </p>

            <p class="dua-transliteration-3d">
                "Rabbana atina fiddunya hasanah wa fil akhirati hasanah wa qina adzaban nar."
            </p>

            <p class="dua-translation-3d">
                "Ya Tuhan kami, berilah kami kebaikan di dunia dan kebaikan di akhirat,
                serta lindungilah kami dari azab neraka."
            </p>

            <span class="dua-source-3d">📖 QS. AL-BAQARAH: 201</span>
        </div>
    </div>
</section>

<!-- ================= CTA BAND 3D ================= -->
<section class="cta-band reveal">
    <div>
        <h3>Fastabiqul Khairat</h3>
        <p>Berlomba-lomba dalam kebaikan — hidupkan nilai AIK dalam setiap karya dan pengabdian.</p>
    </div>
    <div class="cta-actions">
        <a href="<?= e(url('public/index.php?page=berita')) ?>" class="aik-cta-3d aik-cta-primary">📰 Berita Terbaru</a>
        <a href="<?= e(url('public/index.php?page=pengabdian')) ?>" class="aik-cta-3d aik-cta-ghost">🤝 Pengabdian</a>
    </div>
</section>