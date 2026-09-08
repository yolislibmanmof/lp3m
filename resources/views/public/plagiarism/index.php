<?php
$done = $result !== null;
$sim = $done ? (float) $result['similarity_score'] : 0.0;
$cls = $sim >= PlagiarismCheck::THRESHOLD ? '#dc2626' : ($sim >= 15 ? '#f59e0b' : '#10b981');
$lbl = $sim >= PlagiarismCheck::THRESHOLD ? 'TINGGI — PERLU REVISI' : ($sim >= 15 ? 'SEDANG — PERIKSA KUTIPAN' : 'RENDAH — AMAN');
$circ = 2 * pi() * 52;
$res = $done ? (json_decode((string) $result['result_json'], true) ?: []) : [];
$typeLabel = $done ? (PlagiarismCheck::DOC_TYPES[$result['document_type']] ?? ucfirst((string) $result['document_type'])) : '';
$isDone = $done && $result['status'] === 'completed';
$isQueued = $done && $result['status'] === 'queued';
$extractMethod = $done ? ($result['extract_method'] ?? null) : null;
$extractPages = $done ? (int) ($result['extract_pages'] ?? 0) : 0;
$extractChars = $done ? (int) ($result['extract_chars'] ?? 0) : 0;

$methodLabels = [
    'direct' => '📄 TXT/MD (Langsung)',
    'pdf_auto' => '📕 PDF (Auto-Extract)',
    'docx_auto' => '📘 DOCX (Auto-Extract)',
    'error:file_missing' => '❌ File Tidak Ditemukan',
    'error:read' => '❌ Gagal Membaca',
    'error:encrypted' => '🔒 PDF Terenkripsi',
    'error:no_text_layer' => '🖼️ PDF Scan/Gambar',
    'error:zip_missing' => '❌ ZipArchive Tidak Tersedia',
    'error:zip_open' => '❌ Gagal Buka DOCX',
    'error:no_xml' => '❌ DOCX Rusak',
    'unsupported' => '❌ Format Tidak Didukung',
];
$methodLabel = $methodLabels[$extractMethod] ?? ($extractMethod ?: null);
$methodColor = strpos($extractMethod ?? '', 'error') !== false ? '#dc2626' : (strpos($extractMethod ?? '', '_auto') !== false ? '#059669' : '#d97706');
?>

<style>
    @keyframes plgFade { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:none; } }
    @keyframes plgGlow { 0%,100% { filter:drop-shadow(0 0 8px rgba(217,164,65,.35)); } 50% { filter:drop-shadow(0 0 18px rgba(217,164,65,.7)); } }
    @keyframes plgPulse { 0%,100% { box-shadow:0 0 0 0 rgba(245,158,11,.4); } 50% { box-shadow:0 0 0 8px rgba(245,158,11,0); } }
    @keyframes plgBlink { 0%,100% { opacity:1; } 50% { opacity:.5; } }

    .plg-card { background: linear-gradient(165deg, #f6fcf7 0%, #e9f6ec 60%, #e0f1e4 100%); border: 1px solid var(--border); border-radius: 22px; padding: 26px 28px; box-shadow: 0 8px 26px rgba(3,37,31,.07); position: relative; overflow: hidden; animation: plgFade .5s both; }
    .plg-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background: linear-gradient(90deg, var(--gold-strong), #10b981, var(--gold-strong)); opacity:.85; }
    .plg-head { display:flex; align-items:center; gap:14px; margin-bottom:20px; }
    .plg-head-ico { width:52px; height:52px; border-radius:16px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:24px; background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.65), transparent 45%), linear-gradient(145deg, #34d399, #10b981 55%, #047857); box-shadow: inset 0 2px 3px rgba(255,255,255,.55), inset 0 -3px 5px rgba(0,0,0,.22), 0 6px 16px rgba(5,150,105,.35); }
    .plg-head-ico.gold { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.65), transparent 45%), linear-gradient(145deg, #fde68a, #f2c063 55%, #b8860b); box-shadow: inset 0 2px 3px rgba(255,255,255,.6), inset 0 -3px 5px rgba(0,0,0,.2), 0 6px 16px rgba(217,164,65,.4); }
    .plg-head h2 { margin:0; font-size:19px; font-weight:800; color:var(--ink); letter-spacing:-.01em; }
    .plg-head p { margin:2px 0 0; font-size:12.5px; color:var(--muted); }
    .plg-grid2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    @media (max-width:700px){ .plg-grid2 { grid-template-columns:1fr; } .plg-result-top { flex-direction:column; align-items:center; text-align:center; } }

    .plg-field { margin-bottom:16px; }
    .plg-field:last-child { margin-bottom:0; }
    .plg-label { display:flex; align-items:center; gap:8px; font-size:11.5px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; color:#065f46; margin-bottom:8px; }
    .plg-req { padding:1px 8px; border-radius:999px; font-size:8.5px; font-weight:900; background:rgba(220,38,38,.1); color:#dc2626; border:1px solid rgba(220,38,38,.28); }
    .plg-opt { padding:1px 8px; border-radius:999px; font-size:8.5px; font-weight:800; background:rgba(100,116,139,.12); color:#64748b; border:1px solid rgba(100,116,139,.25); }
    .plg-input, .plg-select, .plg-textarea { width:100%; padding:13px 16px; border-radius:13px; border:2px solid var(--border); background:linear-gradient(145deg,#eef9f1,#ddf0e2); font-size:14px; font-weight:600; color:var(--ink); outline:none; transition:all .25s; font-family:inherit; }
    .plg-input:focus, .plg-select:focus, .plg-textarea:focus { border-color:#059669; background:#fff; box-shadow:0 0 0 4px rgba(5,150,105,.12), 0 4px 12px rgba(5,150,105,.14); }
    .plg-input::placeholder, .plg-textarea::placeholder { color:#8aa896; font-weight:500; }
    .plg-select { appearance:none; -webkit-appearance:none; cursor:pointer; padding-right:44px; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23059669' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 16px center; }
    .plg-textarea { min-height:150px; resize:vertical; line-height:1.7; }
    .plg-hint { display:flex; justify-content:space-between; gap:10px; margin-top:7px; font-size:11px; color:var(--muted); flex-wrap:wrap; }
    .plg-count { font-weight:800; color:#065f46; background:rgba(5,150,105,.1); padding:1px 8px; border-radius:6px; }

    .plg-drop { position:relative; border:2px dashed rgba(5,150,105,.45); border-radius:16px; padding:22px; text-align:center; cursor:pointer; transition:all .25s; background:rgba(5,150,105,.04); }
    .plg-drop:hover, .plg-drop.drag { border-color:#059669; background:rgba(5,150,105,.09); transform:translateY(-2px); }
    .plg-drop input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; }
    .plg-drop-ico { font-size:30px; display:block; margin-bottom:6px; }
    .plg-drop b { color:#065f46; font-size:13.5px; }
    .plg-drop small { display:block; color:var(--muted); font-size:11px; margin-top:4px; }
    .plg-file-chip { display:none; margin-top:10px; padding:8px 14px; border-radius:999px; background:linear-gradient(145deg,#d1fae5,#a7f3d0); border:1px solid rgba(16,185,129,.4); color:#065f46; font-size:12px; font-weight:800; }

    .plg-btn { display:inline-flex; align-items:center; gap:8px; padding:14px 26px; border:none; border-radius:13px; font-size:14px; font-weight:800; cursor:pointer; text-decoration:none; transition:all .25s; font-family:inherit; }
    .plg-btn-gold { color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441 80%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.15), 0 8px 20px rgba(217,164,65,.4); }
    .plg-btn-green { color:#fff; background:linear-gradient(145deg,#34d399,#10b981 50%,#047857); box-shadow:inset 0 2px 3px rgba(255,255,255,.4), inset 0 -2px 3px rgba(0,0,0,.2), 0 8px 20px rgba(5,150,105,.35); }
    .plg-btn-ghost { color:#065f46; background:transparent; border:2px solid rgba(5,150,105,.35); }
    .plg-btn:hover { transform:translateY(-2px); filter:brightness(1.05); }
    .plg-btn:disabled { opacity:.6; cursor:not-allowed; }

    .plg-result-top { display:flex; gap:30px; align-items:center; flex-wrap:wrap; }
    .plg-gauge { position:relative; width:170px; height:170px; flex-shrink:0; animation:plgGlow 3s ease-in-out infinite; }
    .plg-gauge svg circle:nth-child(2) { transition: stroke-dashoffset 1.8s cubic-bezier(0.16,1,0.3,1); }
    .plg-gauge-center { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
    .plg-gauge-num { font-family:var(--font-display); font-size:34px; font-weight:900; line-height:1; }
    .plg-gauge-lbl { font-size:9px; font-weight:900; letter-spacing:.16em; color:var(--muted); margin-top:4px; }
    .plg-verdict { display:inline-flex; align-items:center; gap:8px; padding:8px 16px; border-radius:999px; color:#fff; font-size:12px; font-weight:900; letter-spacing:.06em; box-shadow:0 6px 16px rgba(0,0,0,.18); }
    .plg-metrics { display:grid; grid-template-columns:repeat(4,1fr); gap:10px; margin-top:18px; }
    @media (max-width:700px){ .plg-metrics { grid-template-columns:repeat(2,1fr); } }
    .plg-metric { background:rgba(255,255,255,.75); border:1px solid var(--border); border-radius:14px; padding:12px 10px; text-align:center; }
    .plg-metric b { display:block; font-family:var(--font-display); font-size:19px; font-weight:900; color:#065f46; }
    .plg-metric span { font-size:9.5px; font-weight:800; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); }

    .plg-notice { margin-top:16px; padding:12px 16px; border-radius:12px; font-size:13px; font-weight:600; }
    .plg-notice.warn { color:#92400e; background:rgba(245,158,11,.12); border:1px solid rgba(245,158,11,.4); }

    /* 🧩 COMPLETE QUEUE CARD */
    .plg-complete { margin-top:20px; padding:24px 26px; border-radius:20px; background:linear-gradient(135deg,#78350f 0%,#92400e 50%,#b45309 100%); color:#fff; position:relative; overflow:hidden; box-shadow:0 14px 36px rgba(120,53,15,.3); }
    .plg-complete::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,#fde68a,#f59e0b,#fde68a); }
    .plg-complete::after { content:''; position:absolute; top:-50%; right:-10%; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle,rgba(253,230,138,.25),transparent 70%); pointer-events:none; }
    .plg-complete-head { display:flex; align-items:center; gap:12px; margin-bottom:14px; position:relative; z-index:1; }
    .plg-complete-ico { width:46px; height:46px; border-radius:14px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:22px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.5),transparent 40%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), inset 0 -3px 5px rgba(0,0,0,.22); animation:plgPulse 2s infinite; }
    .plg-complete-title { font-family:var(--font-display); font-size:17px; font-weight:900; color:#fff; margin:0; background:linear-gradient(135deg,#fff,#fde68a); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .plg-complete-sub { font-size:12px; opacity:.9; margin:2px 0 0; }
    .plg-complete-textarea { width:100%; min-height:140px; padding:14px 16px; border-radius:14px; border:2px solid rgba(255,255,255,.25); background:rgba(255,255,255,.08); color:#fff; font-family:inherit; font-size:13.5px; line-height:1.7; outline:none; transition:all .25s; position:relative; z-index:1; }
    .plg-complete-textarea::placeholder { color:rgba(255,255,255,.5); }
    .plg-complete-textarea:focus { border-color:#fde68a; background:rgba(255,255,255,.12); box-shadow:0 0 0 4px rgba(253,230,138,.2); }
    .plg-complete-info { margin-bottom:12px; padding:10px 14px; border-radius:10px; background:rgba(253,230,138,.15); border:1px solid rgba(253,230,138,.35); font-size:12px; color:#fef3c7; line-height:1.6; position:relative; z-index:1; }
    .plg-complete-info b { color:#fde68a; }
    .plg-complete-hint { display:flex; justify-content:space-between; gap:10px; margin-top:10px; font-size:11.5px; color:rgba(255,255,255,.8); flex-wrap:wrap; position:relative; z-index:1; }
    .plg-complete-count { font-family:var(--font-display); font-weight:800; color:#fde68a; background:rgba(253,230,138,.2); padding:2px 10px; border-radius:6px; }

    /* Rekomendasi otomatis */
    .plg-rec { margin-top:16px; padding:16px 20px; border-radius:14px; border:1px solid var(--border); background:rgba(255,255,255,.7); }
    .plg-rec h4 { margin:0 0 10px; font-size:14px; font-weight:900; color:var(--ink); display:flex; align-items:center; gap:8px; }
    .plg-rec ul { margin:0; padding-left:22px; font-size:13px; color:var(--muted); line-height:1.7; }
    .plg-rec li { margin-bottom:4px; }
    .plg-rec.good { background:rgba(16,185,129,.08); border-color:rgba(16,185,129,.35); }
    .plg-rec.warn { background:rgba(245,158,11,.08); border-color:rgba(245,158,11,.35); }
    .plg-rec.danger { background:rgba(220,38,38,.08); border-color:rgba(220,38,38,.35); }

    .plg-src { display:flex; gap:14px; align-items:flex-start; padding:14px 16px; border:1px solid var(--border); border-radius:14px; background:rgba(255,255,255,.7); margin-bottom:10px; }
    .plg-src-ico { width:40px; height:40px; border-radius:12px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:18px; background:linear-gradient(145deg,#e2f3e6,#cfe9d6); border:1px solid var(--border); }
    .plg-src h4 { margin:0 0 4px; font-size:13.5px; color:var(--ink); }
    .plg-src p { margin:0; font-size:11.5px; font-style:italic; color:var(--muted); }
    .plg-src-right { margin-left:auto; text-align:right; flex-shrink:0; min-width:110px; }
    .plg-src-pct { font-family:var(--font-display); font-size:16px; font-weight:900; }
    .plg-bar { height:6px; border-radius:999px; background:rgba(0,0,0,.08); overflow:hidden; margin-top:6px; }
    .plg-bar i { display:block; height:100%; border-radius:999px; background:linear-gradient(90deg,#f59e0b,#dc2626); }

    .plg-steps { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; }
    @media (max-width:700px){ .plg-steps { grid-template-columns:1fr; } }
    .plg-step { background:rgba(255,255,255,.75); border:1px solid var(--border); border-radius:16px; padding:18px; text-align:center; }
    .plg-step-num { width:34px; height:34px; margin:0 auto 10px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-weight:900; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:0 4px 10px rgba(217,164,65,.4); }
    .plg-step h4 { margin:0 0 6px; font-size:14px; color:var(--ink); }
    .plg-step p { margin:0; font-size:12px; color:var(--muted); line-height:1.6; }

    .plg-blink { animation:plgBlink 1.5s infinite; }
    .plg-code { font-family:'Courier New',monospace; font-weight:800; letter-spacing:.04em; color:#065f46; background:rgba(5,150,105,.12); padding:3px 10px; border-radius:6px; cursor:pointer; transition:all .2s; }
    .plg-code:hover { background:rgba(5,150,105,.2); }
    
    /* Extract method chip */
    .plg-extract-chip { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border-radius:999px; font-size:11px; font-weight:800; margin-left:8px; }
    .plg-extract-meta { display:flex; gap:12px; margin-top:10px; font-size:11px; color:var(--muted); flex-wrap:wrap; }
</style>

<!-- ================= HERO ================= -->
<section class="news-hero">
    <span class="eyebrow eyebrow-light">Layanan Cerdas ✦</span>
    <h1>Cek Plagiarisme <span class="gold-text">Online</span></h1>
    <p>Periksa tingkat similaritas dokumen Anda terhadap korpus internal LP3M — berita, proposal penelitian, dan laporan pengabdian — menggunakan mesin analisis shingle 6-gram.</p>
    <div style="display:flex; gap:10px; flex-wrap:wrap; justify-content:center; margin-top:18px;">
        <span class="chip">📄 <?= number_format((int) $stats['total']) ?> dokumen diperiksa</span>
        <span class="chip">✅ <?= number_format((int) $stats['completed']) ?> laporan selesai</span>
        <span class="chip">📊 Rata-rata similaritas <?= number_format((float) $stats['avg_sim'], 1) ?>%</span>
    </div>
</section>

<?php if (!empty($flash)): ?>
<div class="section">
    <div class="plg-card" style="border-left:5px solid <?= $flash['type'] === 'error' ? '#dc2626' : ($flash['type'] === 'info' ? '#3b82f6' : '#10b981') ?>;">
        <p style="margin:0; font-weight:700; color:var(--ink);">
            <?= $flash['type'] === 'error' ? '⚠️' : ($flash['type'] === 'info' ? 'ℹ️' : '✅') ?> <?= e($flash['message']) ?>
        </p>
    </div>
</div>
<?php endif; ?>

<?php if ($done): ?>
<!-- ================= HASIL PEMERIKSAAN ================= -->
<section class="section reveal">
    <div class="plg-card">
        <div class="plg-head">
            <div class="plg-head-ico">📋</div>
            <div style="flex:1; min-width:0;">
                <h2>Laporan Hasil Pemeriksaan</h2>
                <p>Kode <span class="plg-code" id="plg-code"><?= e($result['code']) ?></span> · <?= e(date('d M Y, H:i', strtotime($result['created_at']))) ?> WIB</p>
                <?php if ($extractMethod): ?>
                <div class="plg-extract-meta">
                    <span class="plg-extract-chip" style="background:<?= $methodColor ?>15; color:<?= $methodColor ?>; border:1px solid <?= $methodColor ?>40;"><?= $methodLabel ?></span>
                    <?php if ($extractPages > 0): ?><span>📄 <?= $extractPages ?> halaman</span><?php endif; ?>
                    <?php if ($extractChars > 0): ?><span>🔤 <?= number_format($extractChars) ?> karakter</span><?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php if ($isDone): ?><span class="plg-verdict" style="background:<?= $cls ?>;">⚖️ <?= $lbl ?></span><?php endif; ?>
            <?php if ($isQueued): ?><span class="plg-verdict plg-blink" style="background:#f59e0b;">⏳ ANTREAN</span><?php endif; ?>
        </div>

        <div class="plg-result-top">
            <div class="plg-gauge">
                <svg width="170" height="170" style="transform:rotate(-90deg)">
                    <circle cx="85" cy="85" r="52" fill="none" stroke="rgba(0,0,0,.08)" stroke-width="12"/>
                    <circle cx="85" cy="85" r="52" fill="none" stroke="<?= $isDone ? $cls : '#94a3b8' ?>" stroke-width="12" stroke-linecap="round"
                            stroke-dasharray="<?= round($circ, 2) ?>" stroke-dashoffset="<?= $isDone ? round($circ * (1 - min(100, $sim) / 100), 2) : $circ ?>" id="plg-gauge-ring"/>
                </svg>
                <div class="plg-gauge-center">
                    <span class="plg-gauge-num" style="color:<?= $isDone ? $cls : '#64748b' ?>" id="plg-gauge-num"><?= $isDone ? '0%' : '—' ?></span>
                    <span class="plg-gauge-lbl"><?= $isDone ? 'SIMILARITAS' : ($isQueued ? 'ANTREAN' : 'STATUS') ?></span>
                </div>
            </div>
            <div style="flex:1; min-width:250px;">
                <h3 style="margin:0 0 6px; font-size:18px; color:var(--ink);"><?= e($result['title']) ?></h3>
                <p style="margin:0 0 10px; color:var(--muted); font-size:13px;">
                    👤 <?= e($result['submitter_name']) ?><?= !empty($result['submitter_identity']) ? ' · ' . e($result['submitter_identity']) : '' ?>
                    &nbsp;·&nbsp; 🏷️ <?= e($typeLabel) ?>
                </p>
                <?php if ($isDone): ?>
                <div class="plg-metrics">
                    <div class="plg-metric"><b><?= number_format((int) ($res['word_count'] ?? $result['word_count'])) ?></b><span>Kata</span></div>
                    <div class="plg-metric"><b><?= number_format((float) $result['unique_score'], 1) ?>%</b><span>Keunikan</span></div>
                    <div class="plg-metric"><b><?= number_format((float) $result['ai_score'], 1) ?>%</b><span>AI-Likelihood</span></div>
                    <div class="plg-metric"><b><?= (int) $result['sources_found'] ?></b><span>Sumber Cocok</span></div>
                </div>

                <!-- REKOMENDASI OTOMATIS -->
                <?php
                $recClass = $sim >= PlagiarismCheck::THRESHOLD ? 'danger' : ($sim >= 15 ? 'warn' : 'good');
                $recEmoji = $sim >= PlagiarismCheck::THRESHOLD ? '🚨' : ($sim >= 15 ? '⚠️' : '✅');
                $recTitle = $sim >= PlagiarismCheck::THRESHOLD ? 'Rekomendasi: Wajib Revisi' : ($sim >= 15 ? 'Rekomendasi: Periksa Kutipan' : 'Dokumen Aman');
                $recItems = $sim >= PlagiarismCheck::THRESHOLD
                    ? ['Parafrase bagian yang mirip dengan kalimat sendiri.', 'Tambahkan kutipan langsung dengan tanda "..." dan sumber.', 'Pastikan setiap klaim memiliki referensi akademik.']
                    : ($sim >= 15
                        ? ['Tinjau bagian dengan kemiripan 10%+ dan kutip sumbernya.', 'Perbaiki parafrase agar lebih orisinal.', 'Verifikasi bahwa kutipan sudah sesuai format APA/IEEE.']
                        : ['Dokumen sudah memiliki tingkat orisinalitas yang baik.', 'Pertahankan kualitas kutipan dan referensi.']);
                ?>
                <div class="plg-rec <?= $recClass ?>">
                    <h4><?= $recEmoji ?> <?= $recTitle ?></h4>
                    <ul>
                        <?php foreach ($recItems as $r): ?><li><?= $r ?></li><?php endforeach; ?>
                    </ul>
                </div>
                <?php else: ?>
                <div class="plg-notice warn">⏳ Dokumen PDF/DOCX menunggu teks untuk dianalisis. Gunakan form <b>🧩 Lengkapi Antrean dengan Teks</b> di bawah.</div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($isDone && !empty($sources)): ?>
        <div style="margin-top:26px;">
            <h3 style="font-size:15px; font-weight:800; color:var(--ink); margin:0 0 12px;">🔗 Sumber Kemiripan Terdeteksi</h3>
            <?php foreach ($sources as $s): ?>
            <div class="plg-src">
                <div class="plg-src-ico">📑</div>
                <div style="flex:1; min-width:0;">
                    <h4><?= e($s['source_title']) ?></h4>
                    <?php if (!empty($s['snippet'])): ?><p>"<?= e($s['snippet']) ?>"</p><?php endif; ?>
                </div>
                <div class="plg-src-right">
                    <span class="plg-src-pct" style="color:<?= (float) $s['match_percentage'] >= 10 ? '#dc2626' : '#f59e0b' ?>"><?= number_format((float) $s['match_percentage'], 2) ?>%</span>
                    <div class="plg-bar"><i style="width:<?= min(100, (float) $s['match_percentage']) ?>%"></i></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:20px;">
            <?php if ($isDone): ?><button type="button" class="plg-btn plg-btn-gold" onclick="window.print()">🖨️ Cetak Laporan</button><?php endif; ?>
            <a class="plg-btn plg-btn-ghost" href="<?= e(url('public/index.php?page=cek-plagiat')) ?>">🔄 Pemeriksaan Baru</a>
        </div>

        <!-- 🧩 COMPLETE QUEUE CARD — hanya muncul jika status = queued -->
        <?php if ($isQueued): ?>
        <div class="plg-complete">
            <div class="plg-complete-head">
                <div class="plg-complete-ico">🧩</div>
                <div>
                    <h3 class="plg-complete-title">Lengkapi Antrean dengan Teks</h3>
                    <p class="plg-complete-sub">Dokumen PDF/DOCX tidak bisa dibaca otomatis (<?= $methodLabel ?>). Tempel isi teksnya di bawah untuk analisis instan.</p>
                </div>
            </div>
            <div class="plg-complete-info">
                <b>💡 Cara cepat:</b> buka file <b><?= e(basename((string) $result['file_path'])) ?></b>, salin seluruh teks, lalu tempel di kolom bawah.
                Skor similaritas akan langsung muncul dalam hitungan detik.
            </div>
            <form method="post" action="<?= e(url('public/index.php?page=cek-plagiat-lengkapi')) ?>" id="plg-complete-form">
                <?= csrf_field() ?>
                <input type="hidden" name="kode" value="<?= e($result['code']) ?>">
                <textarea name="text" class="plg-complete-textarea" id="plg-complete-text" required placeholder="Tempel seluruh teks dokumen PDF/DOCX di sini..."></textarea>
                <div class="plg-complete-hint">
                    <span>Minimal ±50 kata untuk hasil akurat · Analisis berjalan di server LP3M</span>
                    <span class="plg-complete-count" id="plg-complete-count">0 kata</span>
                </div>
                <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:14px; position:relative; z-index:1;">
                    <button type="submit" class="plg-btn plg-btn-gold" id="plg-complete-save">⚡ Analisis Sekarang</button>
                    <button type="reset" class="plg-btn plg-btn-ghost" style="color:#fef3c7; border-color:rgba(253,230,138,.4);">✖ Bersihkan</button>
                </div>
            </form>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php elseif ($kode !== ''): ?>
<section class="section reveal">
    <div class="plg-card" style="text-align:center; border-left:5px solid #dc2626;">
        <div style="font-size:46px;">🔎</div>
        <h3 style="margin:10px 0 6px; color:var(--ink);">Kode Tidak Ditemukan</h3>
        <p style="color:var(--muted); margin:0;">Kode <b style="font-family:'Courier New',monospace;"><?= e($kode) ?></b> tidak terdaftar dalam sistem. Periksa kembali penulisan kode Anda.</p>
    </div>
</section>
<?php endif; ?>

<!-- ================= FORM SUBMIT ================= -->
<section class="section reveal">
    <div class="plg-card">
        <div class="plg-head">
            <div class="plg-head-ico gold">📤</div>
            <div>
                <h2>Submit Dokumen Baru</h2>
                <p>⚡ PDF/DOCX otomatis dibaca · TXT/MD langsung dianalisis</p>
            </div>
        </div>

        <form method="post" action="<?= e(url('public/index.php?page=cek-plagiat-kirim')) ?>" enctype="multipart/form-data" id="plg-submit-form">
            <?= csrf_field() ?>

            <div class="plg-field">
                <label class="plg-label" for="p-title">Judul Dokumen <span class="plg-req">WAJIB</span></label>
                <input class="plg-input" type="text" id="p-title" name="title" required maxlength="250" placeholder="Contoh: Skripsi: Analisis Sistem Informasi LP3M">
            </div>

            <div class="plg-grid2">
                <div class="plg-field">
                    <label class="plg-label" for="p-name">Nama Penulis <span class="plg-req">WAJIB</span></label>
                    <input class="plg-input" type="text" id="p-name" name="submitter_name" required placeholder="Nama mahasiswa / dosen">
                </div>
                <div class="plg-field">
                    <label class="plg-label" for="p-id">NIM / NIDN <span class="plg-opt">OPSIONAL</span></label>
                    <input class="plg-input" type="text" id="p-id" name="submitter_identity" placeholder="Nomor identitas">
                </div>
            </div>

            <div class="plg-grid2">
                <div class="plg-field">
                    <label class="plg-label" for="p-email">Email <span class="plg-opt">OPSIONAL</span></label>
                    <input class="plg-input" type="email" id="p-email" name="submitter_email" placeholder="nama@email.ac.id">
                </div>
                <div class="plg-field">
                    <label class="plg-label" for="p-type">Jenis Dokumen</label>
                    <select class="plg-select" id="p-type" name="document_type">
                        <?php foreach (PlagiarismCheck::DOC_TYPES as $k => $l): ?>
                        <option value="<?= e($k) ?>"><?= e($l) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="plg-field">
                <label class="plg-label">Unggah File <span class="plg-opt">OPSIONAL · MAKS 10 MB · AUTO-EXTRACT</span></label>
                <div class="plg-drop" id="plg-drop">
                    <input type="file" id="p-file" name="document" accept=".txt,.md,.pdf,.docx">
                    <span class="plg-drop-ico">📎</span>
                    <b>Klik atau seret file ke sini</b>
                    <small>PDF dan DOCX akan dibaca otomatis · Format: TXT, MD, PDF, DOCX</small>
                </div>
                <span class="plg-file-chip" id="plg-file-chip"></span>
            </div>

            <div class="plg-field">
                <label class="plg-label" for="p-text">Atau Tempel Teks Dokumen <span class="plg-opt">OPSIONAL</span></label>
                <textarea class="plg-textarea" id="p-text" name="text" placeholder="Tempel seluruh isi dokumen di sini untuk analisis instan..."></textarea>
                <div class="plg-hint">
                    <span>💡 Analisis berjalan lokal di server LP3M — dokumen tidak dikirim ke pihak ketiga.</span>
                    <span class="plg-count" id="plg-words">0 kata</span>
                </div>
            </div>

            <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:6px;">
                <button type="submit" class="plg-btn plg-btn-gold" id="plg-save">🔍 Jalankan Pemeriksaan</button>
                <button type="reset" class="plg-btn plg-btn-ghost">✖ Bersihkan Form</button>
            </div>
        </form>
    </div>
</section>

<!-- ================= CEK PER KODE ================= -->
<section class="section reveal">
    <div class="plg-card">
        <div class="plg-head">
            <div class="plg-head-ico">🔎</div>
            <div>
                <h2>Cek Hasil per Kode</h2>
                <p>Sudah memiliki kode laporan sebelumnya?</p>
            </div>
        </div>
        <form method="get" action="<?= e(url('public/index.php')) ?>" style="display:flex; gap:10px; flex-wrap:wrap;">
            <input type="hidden" name="page" value="cek-plagiat">
            <input class="plg-input" type="text" name="kode" placeholder="Contoh: PLG-2026-001" style="flex:1; min-width:220px; font-family:'Courier New',monospace; font-weight:700; letter-spacing:.04em;">
            <button type="submit" class="plg-btn plg-btn-green">Lihat Hasil</button>
        </form>
    </div>
</section>

<!-- ================= CARA KERJA ================= -->
<section class="section reveal">
    <div class="plg-steps">
        <div class="plg-step">
            <div class="plg-step-num">1</div>
            <h4>Unggah atau Tempel</h4>
            <p>Kirim dokumen TXT/MD/PDF/DOCX. File akan dibaca otomatis oleh sistem.</p>
        </div>
        <div class="plg-step">
            <div class="plg-step-num">2</div>
            <h4>Mesin Analisis</h4>
            <p>Shingle 6-gram membandingkan dokumen Anda dengan korpus internal LP3M.</p>
        </div>
        <div class="plg-step">
            <div class="plg-step-num">3</div>
            <h4>Laporan & Kode</h4>
            <p>Terima skor similaritas, daftar sumber kemiripan, dan kode unik untuk verifikasi.</p>
        </div>
    </div>
</section>

<script>
(function(){
    // Counter kata untuk form submit
    var ta = document.getElementById('p-text');
    var wc = document.getElementById('plg-words');
    if (ta && wc) {
        var upd = function(){ var t = ta.value.trim(); wc.textContent = (t === '' ? 0 : t.split(/\s+/).length).toLocaleString('id-ID') + ' kata'; };
        ta.addEventListener('input', upd); upd();
    }

    // Counter kata untuk form lengkapi antrean
    var ct = document.getElementById('plg-complete-text');
    var cc = document.getElementById('plg-complete-count');
    if (ct && cc) {
        var ucc = function(){ var v = ct.value.trim(); cc.textContent = (v === '' ? 0 : v.split(/\s+/).length).toLocaleString('id-ID') + ' kata'; };
        ct.addEventListener('input', ucc); ucc();
    }

    // File drop zone
    var file = document.getElementById('p-file');
    var chip = document.getElementById('plg-file-chip');
    var drop = document.getElementById('plg-drop');
    if (file && chip) {
        file.addEventListener('change', function(){
            var f = file.files && file.files[0];
            if (!f) { chip.style.display = 'none'; return; }
            chip.style.display = 'inline-block';
            chip.textContent = '📎 ' + f.name + ' · ' + (f.size / 1024 / 1024).toFixed(2) + ' MB';
        });
    }
    if (drop) {
        ['dragenter','dragover'].forEach(function(ev){ drop.addEventListener(ev, function(e){ e.preventDefault(); drop.classList.add('drag'); }); });
        ['dragleave','drop'].forEach(function(ev){ drop.addEventListener(ev, function(e){ e.preventDefault(); drop.classList.remove('drag'); }); });
    }

    // Disable button setelah submit
    var form = document.getElementById('plg-submit-form');
    var btn = document.getElementById('plg-save');
    if (form && btn) form.addEventListener('submit', function(){ btn.disabled = true; btn.textContent = '⏳ Menganalisis...'; });
    var cform = document.getElementById('plg-complete-form');
    var cbtn = document.getElementById('plg-complete-save');
    if (cform && cbtn) cform.addEventListener('submit', function(){ cbtn.disabled = true; cbtn.textContent = '⏳ Menganalisis...'; });

    // Count-up gauge
    var numEl = document.getElementById('plg-gauge-num');
    var ringEl = document.getElementById('plg-gauge-ring');
    var target = <?= $isDone ? $sim : 0 ?>;
    if (numEl && target > 0) {
        var start = performance.now();
        var duration = 1600;
        function anim(t) {
            var p = Math.min((t - start) / duration, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            numEl.textContent = (target * eased).toFixed(1) + '%';
            if (ringEl) ringEl.setAttribute('stroke-dashoffset', (<?= round($circ, 2) ?> * (1 - (target * eased) / 100)).toFixed(2));
            if (p < 1) requestAnimationFrame(anim);
        }
        requestAnimationFrame(anim);
    }

    // Salin kode ke clipboard
    var codeEl = document.getElementById('plg-code');
    if (codeEl) codeEl.addEventListener('click', function(){
        var txt = codeEl.textContent.trim();
        if (navigator.clipboard) navigator.clipboard.writeText(txt);
        var orig = codeEl.textContent;
        codeEl.textContent = '✅ Tersalin!';
        setTimeout(function(){ codeEl.textContent = orig; }, 1500);
    });
})();
</script>