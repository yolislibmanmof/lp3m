<?php
$totalPub = count($publications);
$totalHaki = count($hakis);
$totalSertifikat = 0;
$hakiCounts = [];

foreach ($hakis as $h) {
    if ($h['status'] === 'sertifikat_terbit') {
        $totalSertifikat++;
    }
    $hakiCounts[$h['status']] = ($hakiCounts[$h['status']] ?? 0) + 1;
}

$byYear = [];
$byType = [];
$byLevel = [];
$scopusList = [];
$authorsMap = [];
$yearCounts = [];

foreach ($publications as $p) {
    $y = (int) $p['year'];
    $byYear[$y][] = $p;
    $yearCounts[$y] = ($yearCounts[$y] ?? 0) + 1;

    $typeKey = $p['type'] ?? 'lainnya';
    $byType[$typeKey] = ($byType[$typeKey] ?? 0) + 1;

    $levelKey = trim($p['level'] ?? 'Lainnya');
    $byLevel[$levelKey] = ($byLevel[$levelKey] ?? 0) + 1;

    $lvl = strtolower($levelKey);
    if (strpos($lvl, 'scopus') !== false
        || strpos($lvl, 'web of science') !== false
        || strpos($lvl, 'wos') !== false
        || strpos($lvl, 'sinta 1') !== false
        || strpos($lvl, 'sinta 2') !== false) {
        $scopusList[] = $p;
    }

    $raw = $p['authors'] ?? '';
    $parts = preg_split('/[,;&]+|\sdan\s/i', $raw);
    foreach ($parts as $part) {
        $name = trim(preg_replace('/\s+/', ' ', $part));
        if ($name !== '' && strlen($name) >= 3) {
            $authorsMap[$name] = ($authorsMap[$name] ?? 0) + 1;
        }
    }
}
krsort($byYear);
arsort($byType);
arsort($byLevel);
arsort($authorsMap);

$topAuthors = array_slice($authorsMap, 0, 5, true);
$yearActive = count($yearCounts);

$milestones = [];
if ($totalPub >= 5)   $milestones[] = ['🎯', '5+ Publikasi', 'Konsistensi ilmiah terbangun', 'ico-pub-gold'];
if ($totalPub >= 25)  $milestones[] = ['🏆', '25+ Publikasi', 'Produktivitas tinggi dosen', 'ico-pub-gold'];
if ($totalPub >= 50)  $milestones[] = ['💎', '50+ Publikasi', 'Pencapaian luar biasa', 'ico-pub-gold'];
if ($totalSertifikat >= 1) $milestones[] = ['🛡️', 'Sertifikat HAKI', 'Perlindungan karya intelektual aktif', 'ico-pub-blue'];

$quotes = [
    '"Riset adalah melihat apa yang dilihat semua orang dan memikirkan apa yang tidak dipikirkan siapapun." — Albert Szent-Györgyi',
    '"Ilmu tanpa amal adalah pohon tanpa buah." — Pepatah Arab',
    '"Satu artikel ilmiah yang bermanfaat lebih berharga dari seribu kata yang tidak berdampak."',
    '"Fastabiqul Khairat — berlomba-lombalah dalam kebaikan melalui karya ilmiah yang mencerahkan."',
    '"Publikasi bukan sekadar angka, tetapi jejak kontribusi peradaban."',
];
$randomQuote = $quotes[array_rand($quotes)];

$marqueeWords = ['Scopus', 'Web of Science', 'SINTA', 'Buku Ajar', 'Paten', 'Hak Cipta', 'Prosiding', 'Artikel Populer', 'Berkemajuan'];
?>

<style>
    @keyframes pubFloat1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(20px,-15px)} }
    @keyframes pubFloat2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-15px,20px)} }
    @keyframes pubFloat3 { 0%,100%{transform:translate(0,0) rotate(0)} 50%{transform:translate(10px,10px) rotate(10deg)} }
    @keyframes pubShine {
        0%   { transform: translateX(-100%) skewX(-20deg); }
        100% { transform: translateX(300%) skewX(-20deg); }
    }
    @keyframes pubGlow {
        0%, 100% { text-shadow: 0 0 20px rgba(242,192,99,0.5), 0 0 40px rgba(217,164,65,0.3); }
        50%      { text-shadow: 0 0 30px rgba(242,192,99,0.8), 0 0 60px rgba(217,164,65,0.5); }
    }

    /* ===== FLOATING ORBS ===== */
    .pub-orb { position: absolute; border-radius: 50%; pointer-events: none; z-index: 0; }
    .pub-orb-1 { width: 140px; height: 140px; top: 12%; right: 8%; background: radial-gradient(circle at 30% 30%, rgba(253,230,138,0.6), rgba(217,164,65,0.3) 60%, transparent); filter: blur(2px); animation: pubFloat1 8s ease-in-out infinite; }
    .pub-orb-2 { width: 200px; height: 200px; bottom: 15%; left: 5%; background: radial-gradient(circle at 70% 70%, rgba(110,231,183,0.4), rgba(16,185,129,0.2) 60%, transparent); filter: blur(3px); animation: pubFloat2 10s ease-in-out infinite; }
    .pub-orb-3 { width: 90px; height: 90px; top: 60%; right: 28%; background: radial-gradient(circle at 30% 30%, rgba(242,192,99,0.5), rgba(217,164,65,0.2) 60%, transparent); filter: blur(1px); animation: pubFloat3 6s ease-in-out infinite; }

    /* ===== 3D ICON ORBS ===== */
    .ico-pub {
        display: inline-flex; align-items: center; justify-content: center;
        width: 52px; height: 52px; border-radius: 16px; font-size: 24px;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #34d399, #10b981 50%, #059669);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(5,150,105,0.35);
        position: relative; overflow: hidden; flex-shrink: 0;
    }
    .ico-pub::before {
        content: ''; position: absolute; top: 5px; left: 10px;
        width: 16px; height: 7px; border-radius: 50%;
        background: rgba(255,255,255,0.6); filter: blur(2px);
    }
    .ico-pub-lg { width: 72px; height: 72px; border-radius: 22px; font-size: 34px; }
    .ico-pub-gold {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%),
                    linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -3px 4px rgba(0,0,0,0.2), 0 6px 16px rgba(217,164,65,0.4);
    }
    .ico-pub-blue {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #60a5fa, #3b82f6 50%, #1d4ed8);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(59,130,246,0.35);
    }
    .ico-pub-purple {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #c4b5fd, #a78bfa 50%, #7c3aed);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(124,58,237,0.35);
    }
    .ico-pub-red {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #fca5a5, #f87171 50%, #dc2626);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(220,38,38,0.35);
    }

    /* ===== 3D QUOTE BOX ===== */
    .pub-quote-3d {
        position: relative; padding: 34px; border-radius: 24px;
        background: linear-gradient(145deg, #065f46, #03251f);
        border: 1px solid rgba(217,164,65,0.25);
        overflow: hidden;
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.08), 0 16px 40px rgba(0,0,0,0.35);
    }
    .pub-quote-3d::before {
        content: ''; position: absolute; top: -60%; right: -20%;
        width: 300px; height: 300px; border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,0.3), transparent 70%);
    }
    .pub-quote-mark {
        position: absolute; top: 4px; left: 12px;
        font-size: 90px; line-height: 1;
        color: rgba(217,164,65,0.12); font-family: Georgia, serif;
        pointer-events: none;
    }

    /* ===== 3D COUNTER ===== */
    .pub-counter-3d {
        font-family: var(--font-display); font-size: 44px; font-weight: 900; line-height: 1;
        background: linear-gradient(135deg, #fde68a, #f2c063 40%, #d9a441);
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: pubGlow 3s ease-in-out infinite;
    }

    /* ===== 3D MILESTONE CARD ===== */
    .pub-milestone-3d {
        position: relative; padding: 26px 20px; text-align: center;
        background: var(--white); border: 1px solid var(--border);
        border-radius: 22px; overflow: hidden;
        transition: all 0.35s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
    }
    .pub-milestone-3d::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, #d9a441, #059669);
        transform: scaleX(0); transform-origin: left;
        transition: transform 0.4s ease;
    }
    .pub-milestone-3d:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 36px rgba(5,150,105,0.18);
        border-color: rgba(5,150,105,0.3);
    }
    .pub-milestone-3d:hover::before { transform: scaleX(1); }
    .pub-milestone-3d:hover .ico-pub { transform: scale(1.1) rotate(-6deg); }

    /* ===== 3D AUTHOR RANK SPHERE ===== */
    .pub-rank-sphere {
        width: 56px; height: 56px; border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display); font-weight: 900; font-size: 22px;
        color: white; flex-shrink: 0; position: relative; overflow: hidden;
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.5), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 16px rgba(0,0,0,0.25);
    }
    .pub-rank-sphere::before {
        content: ''; position: absolute; top: 6px; left: 11px;
        width: 18px; height: 8px; border-radius: 50%;
        background: rgba(255,255,255,0.55); filter: blur(2px);
    }
    .prs-gold { background: linear-gradient(145deg, #fde68a, #d9a441 60%, #a9761b); color: #03251f; }
    .prs-silver { background: linear-gradient(145deg, #e2e8f0, #94a3b8 60%, #64748b); }
    .prs-bronze { background: linear-gradient(145deg, #fdba74, #b45309 60%, #92400e); }
    .prs-emerald { background: linear-gradient(145deg, #34d399, #10b981 60%, #059669); }
    .prs-teal { background: linear-gradient(145deg, #5eead4, #14b8a6 60%, #0f766e); }

    /* ===== 3D AUTHOR AVATAR SPHERE ===== */
    .pub-author-sphere {
        width: 44px; height: 44px; border-radius: 50%;
        background: radial-gradient(circle at 30% 25%, #fde68a, #d9a441 60%, #a9761b);
        display: flex; align-items: center; justify-content: center;
        color: #03251f; font-weight: 900; font-size: 15px;
        font-family: var(--font-display); flex-shrink: 0;
        position: relative; overflow: hidden;
        box-shadow:
            inset 0 2px 2px rgba(255,255,255,0.6),
            inset 0 -2px 3px rgba(0,0,0,0.2),
            0 3px 8px rgba(217,164,65,0.35);
    }
    .pub-author-sphere::before {
        content: ''; position: absolute; top: 4px; left: 9px;
        width: 13px; height: 6px; border-radius: 50%;
        background: rgba(255,255,255,0.65); filter: blur(1.5px);
    }

    /* ===== 3D AUTHOR ROW ===== */
    .pub-author-row {
        display: flex; align-items: center; gap: 16px;
        padding: 16px 20px; background: var(--white);
        border: 1px solid var(--border); border-radius: 18px;
        transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }
    .pub-author-row:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(5,150,105,0.15);
        border-color: rgba(5,150,105,0.3);
    }

    /* ===== 3D PROGRESS BAR ===== */
    .pub-bar-3d {
        height: 12px; border-radius: 999px;
        background: rgba(5,150,105,0.08);
        overflow: hidden; position: relative;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.08);
    }
    .pub-bar-fill-3d {
        height: 100%; border-radius: 999px;
        background: linear-gradient(145deg, #fde68a, #f2c063 40%, #d9a441 80%, #a9761b);
        position: relative; overflow: hidden;
        box-shadow: inset 0 1px 2px rgba(255,255,255,0.6), inset 0 -1px 2px rgba(0,0,0,0.15), 0 2px 6px rgba(217,164,65,0.3);
    }
    .pub-bar-fill-3d::before {
        content: ''; position: absolute; top: 1px; left: 4px; right: 4px;
        height: 40%; border-radius: 999px;
        background: linear-gradient(180deg, rgba(255,255,255,0.5), transparent);
    }
    .pub-bar-fill-emerald {
        background: linear-gradient(145deg, #6ee7b7, #10b981 50%, #059669);
        box-shadow: inset 0 1px 2px rgba(255,255,255,0.5), inset 0 -1px 2px rgba(0,0,0,0.2), 0 2px 6px rgba(16,185,129,0.3);
    }

    /* ===== 3D SCOPUS SPOTLIGHT ===== */
    .pub-scopus-3d {
        display: flex; align-items: center; gap: 16px;
        padding: 18px 22px; background: var(--white);
        border: 1px solid rgba(217,164,65,0.3); border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 6px 18px rgba(217,164,65,0.08);
    }
    .pub-scopus-3d:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 32px rgba(217,164,65,0.2);
        border-color: rgba(217,164,65,0.5);
    }
    .pub-star-jewel {
        width: 56px; height: 56px; border-radius: 18px; flex-shrink: 0;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%),
                    linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441);
        display: flex; align-items: center; justify-content: center;
        font-size: 26px;
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -3px 4px rgba(0,0,0,0.2), 0 6px 16px rgba(217,164,65,0.45);
        position: relative;
    }
    .pub-star-jewel::before {
        content: ''; position: absolute; top: 5px; left: 11px;
        width: 18px; height: 8px; border-radius: 50%;
        background: rgba(255,255,255,0.65); filter: blur(1.5px);
    }
    .pub-level-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 999px;
        font-size: 10px; font-weight: 800; letter-spacing: 0.08em;
        background: linear-gradient(145deg, #fef3c7, #fde68a);
        color: #92400e; border: 1px solid rgba(217,164,65,0.4);
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.6);
    }

    /* ===== 3D YEAR BOX ===== */
    .pub-year-box-3d {
        flex-shrink: 0; width: 80px; height: 80px; border-radius: 20px;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.15), transparent 40%),
                    linear-gradient(145deg, #043b2c, #065f46);
        display: flex; align-items: center; justify-content: center;
        color: #f2c063; font-family: var(--font-display); font-weight: 900; font-size: 22px;
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.1), inset 0 -3px 4px rgba(0,0,0,0.3), 0 8px 20px rgba(3,37,31,0.3);
        position: relative;
    }
    .pub-year-box-3d::before {
        content: ''; position: absolute; top: 8px; left: 12px;
        width: 40%; height: 30%; border-radius: 50%;
        background: rgba(255,255,255,0.12); filter: blur(2px);
    }

    /* ===== 3D HAKI STAGE TRACKER ===== */
    .pub-stage-tracker {
        display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px;
        padding: 24px; background: var(--white);
        border: 1px solid var(--border); border-radius: 22px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.05);
        position: relative; overflow: hidden;
    }
    @media (max-width: 768px) {
        .pub-stage-tracker { grid-template-columns: 1fr; }
    }
    .pub-stage {
        text-align: center; position: relative; padding: 12px 8px;
    }
    .pub-stage-dot {
        width: 52px; height: 52px; border-radius: 50%;
        margin: 0 auto 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; position: relative;
    }
    .pub-stage-dot::before {
        content: ''; position: absolute; top: 5px; left: 10px;
        width: 16px; height: 7px; border-radius: 50%;
        background: rgba(255,255,255,0.55); filter: blur(1.5px);
    }
    .pub-stage-dot-empty {
        background: linear-gradient(145deg, #e5e7eb, #d1d5db);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -2px 3px rgba(0,0,0,0.1), 0 4px 10px rgba(0,0,0,0.1);
    }
    .pub-stage-dot-fill {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%),
                    linear-gradient(145deg, #6ee7b7, #10b981 50%, #059669);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.2), 0 6px 14px rgba(16,185,129,0.4);
    }
    .pub-stage-dot-gold {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.6), transparent 40%),
                    linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -3px 4px rgba(0,0,0,0.2), 0 6px 14px rgba(217,164,65,0.5);
    }

    /* ===== 3D HAKI ROW ===== */
    .pub-haki-row {
        display: flex; align-items: center; gap: 16px;
        padding: 16px 20px; background: var(--white);
        border: 1px solid var(--border); border-radius: 18px;
        transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
    }
    .pub-haki-row:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(59,130,246,0.12);
        border-color: rgba(59,130,246,0.3);
    }
    .pub-shield-3d {
        width: 52px; height: 52px; border-radius: 16px; flex-shrink: 0;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #60a5fa, #3b82f6 50%, #1d4ed8);
        display: flex; align-items: center; justify-content: center;
        font-size: 24px;
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 6px 14px rgba(59,130,246,0.35);
        position: relative;
    }
    .pub-shield-3d::before {
        content: ''; position: absolute; top: 5px; left: 10px;
        width: 16px; height: 7px; border-radius: 50%;
        background: rgba(255,255,255,0.55); filter: blur(1.5px);
    }
    .pub-status-jewel {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 12px; border-radius: 999px;
        font-size: 11px; font-weight: 800; letter-spacing: 0.05em;
        position: relative; overflow: hidden;
    }
    .pub-status-jewel::before {
        content: ''; position: absolute; top: 1px; left: 5px;
        width: 28%; height: 40%; border-radius: 50%;
        background: rgba(255,255,255,0.45); filter: blur(1px);
    }
    .psj-draft { background: linear-gradient(145deg, #e5e7eb, #9ca3af); color: #374151; }
    .psj-review { background: linear-gradient(145deg, #fde68a, #d9a441); color: #03251f; }
    .psj-djki { background: linear-gradient(145deg, #bfdbfe, #3b82f6); color: #fff; }
    .psj-perbaikan { background: linear-gradient(145deg, #fed7aa, #f97316); color: #7c2d12; }
    .psj-terbit { background: linear-gradient(145deg, #6ee7b7, #10b981); color: #064e3b; }

    /* ===== 3D INSIGHT CARD ===== */
    .pub-insight-3d {
        position: relative; padding: 28px 26px;
        background: var(--white); border: 1px solid var(--border);
        border-radius: 22px; overflow: hidden;
        transition: all 0.35s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 6px 18px rgba(0,0,0,0.04);
    }
    .pub-insight-3d::before {
        content: ''; position: absolute; top: -50%; right: -20%;
        width: 200px; height: 200px; border-radius: 50%;
        background: radial-gradient(circle, rgba(217,164,65,0.08), transparent 70%);
    }
    .pub-insight-3d:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 32px rgba(5,150,105,0.12);
    }

    /* ===== 3D CTA ===== */
    .pub-cta-3d {
        position: relative; display: inline-flex; align-items: center; gap: 8px;
        padding: 13px 24px; border-radius: 13px;
        font-weight: 700; font-size: 14px; overflow: hidden;
        transition: transform 0.3s cubic-bezier(0.16,1,0.3,1);
        text-decoration: none;
    }
    .pub-cta-3d::after {
        content: ''; position: absolute; top: 0; left: -100%;
        width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,0.5), transparent);
        animation: pubShine 3s ease-in-out infinite;
    }
    .pub-cta-primary {
        background: linear-gradient(145deg, #fde68a, #d9a441);
        color: #03251f;
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -2px 3px rgba(0,0,0,0.15), 0 8px 20px rgba(217,164,65,0.4);
    }
    .pub-cta-ghost {
        background: transparent; color: #fff;
        border: 2px solid rgba(255,255,255,0.35);
    }
    .pub-cta-3d:hover { transform: translateY(-3px); }
    .pub-cta-primary:hover { box-shadow: inset 0 2px 3px rgba(255,255,255,0.8), 0 14px 30px rgba(217,164,65,0.55); }
    .pub-cta-ghost:hover { background: rgba(255,255,255,0.1); border-color: #fff; }

    /* ===== 3D PUBLICATION ROW ===== */
    .pub-row-3d {
        display: flex; align-items: center; gap: 16px;
        padding: 16px 20px; background: var(--white);
        border: 1px solid var(--border); border-radius: 18px;
        transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
    }
    .pub-row-3d:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(5,150,105,0.12);
        border-color: rgba(5,150,105,0.3);
    }
    .pub-book-3d {
        width: 48px; height: 48px; border-radius: 14px; flex-shrink: 0;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.4), transparent 40%),
                    linear-gradient(145deg, #34d399, #10b981 50%, #059669);
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.6), inset 0 -3px 4px rgba(0,0,0,0.25), 0 4px 12px rgba(5,150,105,0.3);
        position: relative;
    }
    .pub-book-3d::before {
        content: ''; position: absolute; top: 4px; left: 9px;
        width: 15px; height: 6px; border-radius: 50%;
        background: rgba(255,255,255,0.55); filter: blur(1.5px);
    }
    .pub-link-btn {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 14px; border-radius: 999px;
        font-size: 11px; font-weight: 800; letter-spacing: 0.05em;
        text-decoration: none; flex-shrink: 0;
        background: linear-gradient(145deg, #059669, #065f46);
        color: white;
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.25), inset 0 -2px 2px rgba(0,0,0,0.2), 0 3px 8px rgba(5,150,105,0.3);
        transition: all 0.25s;
    }
    .pub-link-btn:hover {
        background: linear-gradient(145deg, #10b981, #059669);
        transform: translateX(3px);
    }

    /* ===== 3D CHIP ===== */
    .pub-chip-3d {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 999px;
        font-size: 11px; font-weight: 700;
        background: linear-gradient(145deg, #fff, #f6faf7);
        border: 1px solid var(--border); color: var(--text);
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.9), 0 2px 5px rgba(0,0,0,0.04);
    }
</style>

<!-- ================= HERO 3D ================= -->
<section class="news-hero" style="position: relative; overflow: hidden;">
    <div class="pub-orb pub-orb-1"></div>
    <div class="pub-orb pub-orb-2"></div>
    <div class="pub-orb pub-orb-3"></div>

    <span class="hero-chip c1" style="z-index: 2;">📚 Reputasi Ilmiah</span>
    <span class="hero-chip c2" style="z-index: 2;">🛡️ HAKI</span>

    <span class="eyebrow eyebrow-light" style="z-index: 2;">Rekam Jejak Ilmiah</span>
    <h1 style="z-index: 2;">Publikasi & <span class="gold-text">HAKI</span></h1>
    <p style="z-index: 2;">Rekam jejak publikasi ilmiah dan kekayaan intelektual dosen UNIMOF.</p>
</section>

<!-- ================= QUOTE REFLEKSI 3D ================= -->
<section class="section reveal">
    <div class="pub-quote-3d">
        <div class="pub-quote-mark">"</div>
        <div style="position: relative; z-index: 1; display: flex; align-items: center; gap: 22px; flex-wrap: wrap;">
            <div class="ico-pub ico-pub-lg ico-pub-gold">💡</div>
            <div style="flex: 1; min-width: 260px;">
                <span class="eyebrow eyebrow-light" style="display: inline-block; margin-bottom: 10px;">✦ REFLEKSI ILMIAH</span>
                <p style="font-family: var(--font-display); font-size: clamp(16px, 2vw, 19px); font-weight: 600; line-height: 1.55; font-style: italic; color: #f2c063; letter-spacing: -0.01em;">
                    <?= $randomQuote ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ================= STATS COUNTER 3D ================= -->
<section class="stats">
    <div class="stat reveal stagger-1" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(217,164,65,0.2), transparent 70%);"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-pub ico-pub-gold">📚</div>
            <div>
                <div class="pub-counter-3d" data-count="<?= (int) $totalPub ?>" data-suffix="+">0</div>
                <div class="stat-label">Publikasi Ilmiah</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-2" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(59,130,246,0.2), transparent 70%);"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-pub ico-pub-blue">🛡️</div>
            <div>
                <div class="pub-counter-3d" data-count="<?= (int) $totalHaki ?>" data-suffix="+">0</div>
                <div class="stat-label">HAKI Terdaftar</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-3" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(16,185,129,0.2), transparent 70%);"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-pub">🏅</div>
            <div>
                <div class="pub-counter-3d" data-count="<?= (int) $totalSertifikat ?>">0</div>
                <div class="stat-label">Sertifikat Terbit</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-4" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(124,58,237,0.2), transparent 70%);"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-pub ico-pub-purple">📅</div>
            <div>
                <div class="pub-counter-3d" data-count="<?= (int) $yearActive ?>">0</div>
                <div class="stat-label">Tahun Aktif Riset</div>
            </div>
        </div>
    </div>
    <div class="stat reveal stagger-5" style="position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: radial-gradient(circle, rgba(220,38,38,0.2), transparent 70%);"></div>
        <div style="display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;">
            <div class="ico-pub ico-pub-red">⭐</div>
            <div>
                <div class="pub-counter-3d" data-count="<?= count($scopusList) ?>">0</div>
                <div class="stat-label">Reputasi Tinggi</div>
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

<!-- ================= MILESTONES 3D ================= -->
<?php if ($milestones !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>🏆 Milestone Kami</h2>
        <span class="chip">Pencapaian otomatis</span>
    </div>

    <div class="grid" style="grid-template-columns: repeat(<?= min(count($milestones), 4) ?>, 1fr);">
        <?php foreach ($milestones as $m): ?>
            <div class="pub-milestone-3d reveal">
                <div style="display: flex; justify-content: center; margin-bottom: 14px;">
                    <div class="ico-pub ico-pub-lg <?= $m[3] ?>"><?= $m[0] ?></div>
                </div>
                <h3 style="font-size: 17px;"><?= e($m[1]) ?></h3>
                <p style="font-size: 13px;"><?= e($m[2]) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= TOP KONTRIBUTOR 3D ================= -->
<?php if ($topAuthors !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>👨‍🔬 Top Kontributor</h2>
        <span class="chip">Peneliti paling produktif</span>
    </div>

    <div style="display: flex; flex-direction: column; gap: 10px;">
        <?php 
        $rank = 1;
        $rankClasses = ['prs-gold', 'prs-silver', 'prs-bronze', 'prs-emerald', 'prs-teal'];
        foreach ($topAuthors as $name => $count):
            $rankClass = $rankClasses[$rank - 1] ?? 'prs-teal';
            $initial = strtoupper(substr(trim(explode(',', $name)[0]), 0, 1));
        ?>
            <div class="pub-author-row reveal">
                <div class="pub-rank-sphere <?= $rankClass ?>">
                    <?= $rank === 1 ? '👑' : $rank ?>
                </div>
                <div class="pub-author-sphere"><?= $initial ?></div>
                <div style="flex: 1; min-width: 0;">
                    <h3 style="color: var(--ink); font-size: 15px; font-weight: 800; margin: 0 0 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <?= e($name) ?>
                    </h3>
                    <div style="display: flex; gap: 10px; font-size: 12px; color: var(--muted); flex-wrap: wrap; align-items: center;">
                        <span>📚 <strong style="color: var(--primary-dark);"><?= (int) $count ?></strong> publikasi</span>
                        <?php if ($rank === 1): ?>
                            <span class="pub-level-badge">⭐ TOP RESEARCHER</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div style="flex-shrink: 0; font-family: var(--font-display); font-weight: 900; font-size: 26px; color: var(--gold-strong);">
                    #<?= $rank ?>
                </div>
            </div>
        <?php $rank++; endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= BREAKDOWN TIPE 3D ================= -->
<?php if ($byType !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>📊 Breakdown Tipe Publikasi</h2>
        <span class="chip">Distribusi jenis karya</span>
    </div>

    <div style="background: var(--white); border: 1px solid var(--border); border-radius: 22px; padding: 26px; box-shadow: 0 6px 20px rgba(0,0,0,0.04);">
        <?php foreach ($byType as $type => $count):
            $pct = $totalPub > 0 ? round(($count / $totalPub) * 100) : 0;
        ?>
            <div style="margin-bottom: 18px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13.5px; align-items: center;">
                    <span style="font-weight: 800; color: var(--ink);"><?= e(Publication::TYPES[$type] ?? ucfirst($type)) ?></span>
                    <span style="color: var(--muted); font-weight: 600;">
                        <strong style="color: var(--primary-dark);"><?= (int) $count ?></strong> (<?= $pct ?>%)
                    </span>
                </div>
                <div class="pub-bar-3d">
                    <div class="pub-bar-fill-3d" style="width: <?= $pct ?>%;"></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= SEBARAN LEVEL 3D ================= -->
<?php if ($byLevel !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>🎯 Sebaran Level / Indeks</h2>
        <span class="chip">Kualitas ilmiah</span>
    </div>

    <div style="background: var(--white); border: 1px solid var(--border); border-radius: 22px; padding: 26px; box-shadow: 0 6px 20px rgba(0,0,0,0.04);">
        <?php foreach ($byLevel as $level => $count):
            $pct = $totalPub > 0 ? round(($count / $totalPub) * 100) : 0;
        ?>
            <div style="margin-bottom: 18px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13.5px; align-items: center;">
                    <span style="font-weight: 800; color: var(--ink);"><?= e($level) ?></span>
                    <span style="color: var(--muted); font-weight: 600;">
                        <strong style="color: var(--primary-dark);"><?= (int) $count ?></strong> (<?= $pct ?>%)
                    </span>
                </div>
                <div class="pub-bar-3d">
                    <div class="pub-bar-fill-3d pub-bar-fill-emerald" style="width: <?= $pct ?>%;"></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= SCOPUS SPOTLIGHT 3D ================= -->
<?php if ($scopusList !== []): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>⭐ Publikasi Reputasi Tinggi</h2>
        <span class="chip"><?= count($scopusList) ?> karya unggulan</span>
    </div>

    <div style="display: flex; flex-direction: column; gap: 12px;">
        <?php foreach (array_slice($scopusList, 0, 5) as $item): ?>
            <div class="pub-scopus-3d reveal">
                <div class="pub-star-jewel">⭐</div>
                <div style="flex: 1; min-width: 0;">
                    <h3 style="color: var(--ink); font-size: 15px; font-weight: 800; line-height: 1.4; margin: 0 0 8px;">
                        <?= e($item['title']) ?>
                    </h3>
                    <div style="display: flex; gap: 8px; font-size: 12px; color: var(--muted); flex-wrap: wrap; align-items: center;">
                        <span class="pub-level-badge">⭐ <?= e($item['level']) ?></span>
                        <span class="pub-chip-3d">📖 <?= e(Publication::TYPES[$item['type']] ?? $item['type']) ?></span>
                        <span class="pub-chip-3d">📅 <?= (int) $item['year'] ?></span>
                    </div>
                    <?php if (!empty($item['source'])): ?>
                        <p style="font-size: 12.5px; color: var(--muted); margin: 8px 0 0; line-height: 1.5;">
                            <?= e($item['source']) ?>
                        </p>
                    <?php endif; ?>
                </div>
                <?php if (!empty($item['link'])): ?>
                    <a class="pub-link-btn" href="<?= e($item['link']) ?>" target="_blank" rel="noopener">
                        Lihat →
                    </a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ================= ARSIP PER TAHUN 3D ================= -->
<section class="section">
    <div class="section-head">
        <h2>📚 Arsip Publikasi Ilmiah</h2>
    </div>

    <?php if ($publications === []): ?>
        <p class="news-empty">Belum ada publikasi yang dipublikasikan.</p>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 28px;">
            <?php foreach ($byYear as $year => $group): ?>
                <div class="reveal">
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 14px; flex-wrap: wrap;">
                        <div class="pub-year-box-3d"><?= (int) $year ?></div>
                        <div>
                            <h3 style="font-size: 18px; font-weight: 800; margin: 0; color: var(--ink);">
                                Arsip <?= (int) $year ?>
                            </h3>
                            <span class="pub-chip-3d" style="margin-top: 4px;">
                                📚 <?= count($group) ?> publikasi
                            </span>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 10px; padding-left: 12px; border-left: 3px solid rgba(217,164,65,0.25);">
                        <?php foreach ($group as $item): ?>
                            <div class="pub-row-3d">
                                <div class="pub-book-3d">📚</div>
                                <div style="flex: 1; min-width: 0;">
                                    <h4 style="color: var(--ink); font-size: 14.5px; font-weight: 700; line-height: 1.4; margin: 0 0 6px;">
                                        <?= e($item['title']) ?>
                                    </h4>
                                    <div style="display: flex; gap: 8px; font-size: 11.5px; color: var(--muted); flex-wrap: wrap;">
                                        <span class="pub-chip-3d"><?= e(Publication::TYPES[$item['type']] ?? $item['type']) ?></span>
                                        <span class="pub-chip-3d"><?= e($item['level']) ?></span>
                                        <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">
                                            👤 <?= e(excerpt($item['authors'], 35)) ?>
                                        </span>
                                    </div>
                                    <?php if (!empty($item['source'])): ?>
                                        <p style="font-size: 12px; color: var(--muted); margin: 6px 0 0; line-height: 1.5;">
                                            📖 <?= e(excerpt($item['source'], 80)) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($item['link'])): ?>
                                    <a class="pub-link-btn" href="<?= e($item['link']) ?>" target="_blank" rel="noopener">
                                        🔗 Lihat
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- ================= HAKI SECTION 3D ================= -->
<section class="section">
    <div class="section-head">
        <h2>🛡️ HAKI / Kekayaan Intelektual</h2>
    </div>

    <?php if ($hakis !== [] && $hakiCounts !== []): ?>
        <!-- Stage Tracker 3D -->
        <div style="margin-bottom: 24px;">
            <div class="section-head" style="margin-bottom: 14px;">
                <h3 style="font-size: 16px;">🔄 Pipeline Status HAKI</h3>
            </div>

            <div class="pub-stage-tracker">
                <?php
                $statusOrder = ['draft_internal', 'review_internal', 'diajukan_djki', 'perbaikan', 'sertifikat_terbit'];
                $stageIcons = ['📝', '🔍', '📤', '✏️', '🏅'];
                $stageLabels = ['Draft', 'Review', 'DJKI', 'Perbaikan', 'Terbit'];
                
                foreach ($statusOrder as $idx => $st):
                    $cnt = $hakiCounts[$st] ?? 0;
                    $pct = $totalHaki > 0 ? round(($cnt / $totalHaki) * 100) : 0;
                    $dotClass = $cnt > 0 ? ($st === 'sertifikat_terbit' ? 'pub-stage-dot-gold' : 'pub-stage-dot-fill') : 'pub-stage-dot-empty';
                ?>
                    <div class="pub-stage">
                        <div class="pub-stage-dot <?= $dotClass ?>"><?= $stageIcons[$idx] ?></div>
                        <p style="font-size: 11px; font-weight: 800; color: var(--ink); margin: 0 0 2px; letter-spacing: 0.02em;">
                            <?= $stageLabels[$idx] ?>
                        </p>
                        <p style="font-family: var(--font-display); font-size: 20px; font-weight: 900; color: var(--primary-dark); margin: 0;">
                            <?= $cnt ?>
                        </p>
                        <p style="font-size: 10px; color: var(--muted); margin: 2px 0 0;"><?= $pct ?>%</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Status chips -->
        <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 18px;">
            <?php foreach ($hakiCounts as $st => $n): ?>
                <span class="pub-chip-3d">
                    <?= e(IntellectualProperty::STATUSES[$st] ?? $st) ?>
                    <span style="opacity: 0.5;">·</span>
                    <strong><?= (int) $n ?></strong>
                </span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($hakis === []): ?>
        <p class="news-empty">Belum ada data HAKI.</p>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <?php 
            $statusJewelMap = [
                'draft_internal' => 'psj-draft',
                'review_internal' => 'psj-review',
                'diajukan_djki' => 'psj-djki',
                'perbaikan' => 'psj-perbaikan',
                'sertifikat_terbit' => 'psj-terbit',
            ];
            foreach ($hakis as $item):
                $sjClass = $statusJewelMap[$item['status']] ?? 'psj-draft';
            ?>
                <div class="pub-haki-row reveal">
                    <div class="pub-shield-3d">🛡️</div>
                    <div style="flex: 1; min-width: 0;">
                        <h3 style="color: var(--ink); font-size: 15px; font-weight: 800; line-height: 1.4; margin: 0 0 8px;">
                            <?= e($item['title']) ?>
                        </h3>
                        <div style="display: flex; gap: 8px; font-size: 12px; color: var(--muted); flex-wrap: wrap;">
                            <span class="pub-chip-3d">🏷️ <?= e(IntellectualProperty::TYPES[$item['type']] ?? $item['type']) ?></span>
                            <span class="pub-chip-3d">👤 <?= e(excerpt($item['inventors'], 40)) ?></span>
                            <span class="pub-chip-3d">📅 <?= (int) $item['year'] ?></span>
                            <?php if (!empty($item['registration_number'])): ?>
                                <span class="pub-chip-3d">🔢 <?= e($item['registration_number']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <span class="pub-status-jewel <?= $sjClass ?>">
                        <?= e(IntellectualProperty::STATUSES[$item['status']] ?? $item['status']) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- ================= INSIGHT 3D ================= -->
<?php if ($totalPub > 0 || $totalHaki > 0): ?>
<section class="section reveal">
    <div class="section-head">
        <h2>📈 Insight Rekam Jejak</h2>
        <span class="chip">Ringkasan performa</span>
    </div>

    <div class="grid" style="grid-template-columns: repeat(2, 1fr);">
        <div class="pub-insight-3d">
            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 14px; position: relative; z-index: 1;">
                <div class="ico-pub ico-pub-gold">📚</div>
                <h3 style="margin: 0; font-size: 18px;">Publikasi</h3>
            </div>
            <p style="position: relative; z-index: 1; font-size: 14px; line-height: 1.7; margin: 0;">
                <strong style="color: var(--primary-dark); font-family: var(--font-display); font-size: 28px;"><?= (int) $totalPub ?></strong>
                publikasi ilmiah tercatat dalam <strong><?= (int) $yearActive ?></strong> tahun aktif.
                <?php if (count($scopusList) > 0): ?>
                    <strong style="color: var(--gold-strong);"><?= count($scopusList) ?> di antaranya</strong> berindeks reputasi tinggi (Scopus / WoS / SINTA 1-2).
                <?php endif; ?>
            </p>
        </div>

        <div class="pub-insight-3d">
            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 14px; position: relative; z-index: 1;">
                <div class="ico-pub ico-pub-blue">🛡️</div>
                <h3 style="margin: 0; font-size: 18px;">HAKI</h3>
            </div>
            <p style="position: relative; z-index: 1; font-size: 14px; line-height: 1.7; margin: 0;">
                <strong style="color: var(--primary-dark); font-family: var(--font-display); font-size: 28px;"><?= (int) $totalHaki ?></strong>
                kekayaan intelektual terdaftar, dengan
                <strong style="color: var(--gold-strong); font-family: var(--font-display); font-size: 22px;"><?= (int) $totalSertifikat ?></strong>
                sertifikat telah resmi terbit dari DJKI.
            </p>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================= CTA 3D ================= -->
<section class="cta-band reveal">
    <div>
        <h3>Inspirasi dari lapangan</h3>
        <p>Sebagian besar publikasi lahir dari kegiatan pengabdian kepada masyarakat.</p>
    </div>
    <div class="cta-actions">
        <a href="<?= e(url('public/index.php?page=pengabdian')) ?>" class="pub-cta-3d pub-cta-primary">🤝 Pengabdian & KKN</a>
        <a href="<?= e(url('public/index.php?page=aik')) ?>" class="pub-cta-3d pub-cta-ghost">🕌 Kegiatan AIK</a>
    </div>
</section>