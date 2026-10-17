<?php
$sim = (float) $item['similarity_score'];
$res = json_decode((string) $item['result_json'], true) ?: [];
$cls = $sim >= PlagiarismCheck::THRESHOLD ? '#dc2626' : ($sim >= 15 ? '#f59e0b' : '#10b981');
$lbl = $sim >= PlagiarismCheck::THRESHOLD ? 'TINGGI — PERLU REVISI' : ($sim >= 15 ? 'SEDANG — PERIKSA KUTIPAN' : 'RENDAH — AMAN');
$circ = 2 * pi() * 52;
$isDone = $item['status'] === 'completed';
$isQueued = $item['status'] === 'queued';
$hasText = !empty($item['source_text']);
$extractMethod = $item['extract_method'] ?? null;
$extractPages = (int) ($item['extract_pages'] ?? 0);
$extractChars = (int) ($item['extract_chars'] ?? 0);

// Map metode ekstraksi ke label
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
$methodLabel = $methodLabels[$extractMethod] ?? ($extractMethod ?: '—');
$methodColor = strpos($extractMethod ?? '', 'error') !== false ? '#fca5a5' : (strpos($extractMethod ?? '', '_auto') !== false ? '#6ee7b7' : '#fde68a');
?>
<style>
    @keyframes prFade { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:none; } }
    @keyframes prShine { 0%,55% { left:-90%; } 100% { left:165%; } }
    @keyframes prPulse { 0%,100% { box-shadow:0 0 0 0 rgba(217,164,65,.4); } 50% { box-shadow:0 0 0 8px rgba(217,164,65,0); } }
    @keyframes prGlow { 0%,100% { filter:drop-shadow(0 0 8px rgba(217,164,65,.35)); } 50% { filter:drop-shadow(0 0 18px rgba(217,164,65,.7)); } }
    @keyframes prBlink { 0%,100% { opacity:1; } 50% { opacity:.5; } }

    .pr-flash { position:relative; padding:14px 18px; margin-bottom:18px; border-radius:14px; font-size:13.5px; font-weight:700; display:flex; align-items:center; gap:10px; overflow:hidden; animation:prFade .4s both; }
    .pr-flash.ok { background:linear-gradient(145deg,#d1fae5,#a7f3d0); border:1px solid rgba(16,185,129,.35); color:#065f46; }
    .pr-flash.err { background:linear-gradient(145deg,#fee2e2,#fecaca); border:1px solid rgba(220,38,38,.35); color:#991b1b; }
    .pr-flash.info { background:linear-gradient(145deg,#dbeafe,#bfdbfe); border:1px solid rgba(59,130,246,.35); color:#1e40af; }

    .pr-head { display:flex; gap:24px; flex-wrap:wrap; align-items:center; margin-bottom:18px; padding:24px 28px; border-radius:22px; background:linear-gradient(135deg,#043b2c,#065f46 60%,#059669); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3); position:relative; overflow:hidden; animation:prFade .5s both; }
    .pr-head::after { content:''; position:absolute; top:-50%; right:-8%; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.2),transparent 70%); pointer-events:none; }
    .pr-dial { position:relative; width:160px; height:160px; flex-shrink:0; background:rgba(255,255,255,.06); border-radius:50%; animation:prGlow 3s ease-in-out infinite; }
    .pr-dial svg { transform:rotate(-90deg); transition:stroke-dashoffset 1.8s cubic-bezier(0.16,1,0.3,1); }
    .pr-dial .val { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
    .pr-dial .val b { font-family:var(--font-display); font-size:32px; font-weight:900; line-height:1; }
    .pr-dial .val span { font-size:8.5px; font-weight:900; letter-spacing:.16em; opacity:.8; margin-top:4px; }
    .pr-verdict { display:inline-flex; align-items:center; gap:8px; padding:7px 16px; border-radius:999px; color:#fff; font-size:11.5px; font-weight:900; letter-spacing:.06em; box-shadow:0 6px 16px rgba(0,0,0,.25); }
    .pr-chip { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.18); padding:4px 12px; border-radius:999px; font-size:11px; font-weight:800; }
    .pr-code { font-family:'Courier New',monospace; font-weight:800; letter-spacing:.04em; cursor:pointer; }
    .pr-code:hover { color:#fde68a; }

    /* ⚡ ANALISIS SEKARANG CARD */
    .pr-analyze-now { margin-bottom:18px; padding:24px 26px; border-radius:20px; background:linear-gradient(135deg,#043b2c,#065f46 60%,#059669); color:#fff; position:relative; overflow:hidden; box-shadow:0 14px 36px rgba(0,0,0,.3); animation:prFade .6s both; }
    .pr-analyze-now::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,#fde68a,#f2c063,#d9a441); }
    .pr-analyze-now::after { content:''; position:absolute; top:-50%; right:-10%; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.25),transparent 70%); pointer-events:none; animation:prGlow 4s ease-in-out infinite; }
    .pr-an-head { display:flex; align-items:center; gap:12px; margin-bottom:14px; position:relative; z-index:1; }
    .pr-an-ico { width:46px; height:46px; border-radius:14px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:22px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.5),transparent 40%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), inset 0 -3px 5px rgba(0,0,0,.22), 0 6px 16px rgba(217,164,65,.45); animation:prPulse 2s infinite; }
    .pr-an-title { font-family:var(--font-display); font-size:17px; font-weight:900; color:#fff; margin:0; background:linear-gradient(135deg,#fff,#fde68a); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .pr-an-sub { font-size:12px; opacity:.85; margin:2px 0 0; }
    .pr-an-textarea { width:100%; min-height:140px; padding:14px 16px; border-radius:14px; border:2px solid rgba(255,255,255,.2); background:rgba(255,255,255,.06); color:#fff; font-family:inherit; font-size:13.5px; line-height:1.7; outline:none; transition:all .25s; position:relative; z-index:1; }
    .pr-an-textarea::placeholder { color:rgba(255,255,255,.4); }
    .pr-an-textarea:focus { border-color:#f2c063; background:rgba(255,255,255,.1); box-shadow:0 0 0 4px rgba(217,164,65,.2); }
    .pr-an-hint { display:flex; justify-content:space-between; align-items:center; gap:10px; margin-top:10px; font-size:11.5px; color:rgba(255,255,255,.7); flex-wrap:wrap; position:relative; z-index:1; }
    .pr-an-count { font-family:var(--font-display); font-weight:800; color:#fde68a; background:rgba(217,164,65,.15); padding:2px 10px; border-radius:6px; }
    .pr-an-actions { display:flex; gap:10px; margin-top:14px; flex-wrap:wrap; position:relative; z-index:1; }
    .pr-an-info { margin-bottom:12px; padding:10px 14px; border-radius:10px; background:rgba(217,164,65,.12); border:1px solid rgba(217,164,65,.3); font-size:12px; color:#fde68a; line-height:1.6; position:relative; z-index:1; }
    .pr-an-info b { color:#fde68a; }

    .pr-steps { display:flex; gap:0; align-items:center; margin:0 0 18px; padding:16px 22px; border-radius:18px; background:var(--surface); border:1px solid var(--border); flex-wrap:wrap; }
    .pr-step { display:flex; align-items:center; gap:9px; font-size:12px; font-weight:800; color:var(--muted); }
    .pr-step .dot { width:26px; height:26px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; background:rgba(255,255,255,.06); border:1px solid var(--border); }
    .pr-step.done { color:#6ee7b7; }
    .pr-step.done .dot { background:linear-gradient(145deg,#34d399,#059669); border-color:transparent; color:#fff; }
    .pr-step.active { color:#f2c063; }
    .pr-step.active .dot { background:linear-gradient(145deg,#fde68a,#d9a441); border-color:transparent; color:#03251f; animation:prPulse 2s infinite; }
    .pr-line { flex:0 0 34px; height:2px; background:var(--border); margin:0 10px; border-radius:2px; }
    .pr-line.done { background:#10b981; }

    .pr-metrics { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:18px; }
    @media (max-width:800px){ .pr-metrics { grid-template-columns:repeat(2,1fr); } }
    .pr-metric { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:14px 12px; text-align:center; }
    .pr-metric b { display:block; font-family:var(--font-display); font-size:20px; font-weight:900; color:#6ee7b7; }
    .pr-metric span { font-size:9.5px; font-weight:800; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); }

    .pr-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px 26px; margin-bottom:18px; position:relative; overflow:hidden; }
    .pr-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,var(--gold-strong),#10b981); opacity:.75; }
    .pr-card-title { display:flex; align-items:center; gap:10px; font-size:14.5px; font-weight:900; color:#fff; font-family:var(--font-display); margin:0 0 18px; padding-bottom:13px; border-bottom:1px dashed var(--border); }
    .pr-card-title .emo { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:10px; background:linear-gradient(145deg,rgba(255,255,255,.08),rgba(255,255,255,.03)); border:1px solid var(--border); font-size:15px; }
    .pr-card-title .num { margin-left:auto; font-size:10px; font-weight:900; letter-spacing:.1em; color:var(--muted); }

    .pr-label { display:block; font-size:11px; font-weight:850; letter-spacing:.08em; text-transform:uppercase; color:#cfe7dd; margin-bottom:7px; }
    .pr-input { width:100%; padding:12px 14px; border-radius:12px; border:2px solid var(--border); background:linear-gradient(145deg,rgba(255,255,255,.05),rgba(255,255,255,.02)); font-size:14px; font-weight:600; color:var(--text); outline:none; }
    .pr-input:focus { border-color:var(--gold-strong); box-shadow:0 0 0 4px rgba(217,164,65,.16); }
    .pr-manual { display:grid; grid-template-columns:1fr 1fr 2fr auto; gap:12px; align-items:end; }
    @media (max-width:800px){ .pr-manual { grid-template-columns:1fr; } }

    /* Rekomendasi otomatis */
    .pr-rec { margin-top:14px; padding:14px 18px; border-radius:14px; border:1px solid var(--border); background:rgba(255,255,255,.03); }
    .pr-rec h4 { margin:0 0 10px; font-size:13px; font-weight:900; color:var(--text); display:flex; align-items:center; gap:8px; }
    .pr-rec ul { margin:0; padding-left:22px; font-size:13px; color:var(--muted); line-height:1.7; }
    .pr-rec li { margin-bottom:4px; }
    .pr-rec.good { background:rgba(16,185,129,.06); border-color:rgba(16,185,129,.3); }
    .pr-rec.warn { background:rgba(245,158,11,.06); border-color:rgba(245,158,11,.3); }
    .pr-rec.danger { background:rgba(220,38,38,.06); border-color:rgba(220,38,38,.3); }

    .pr-src { padding:14px 16px; border:1px solid var(--border); border-radius:14px; background:rgba(255,255,255,.03); margin-bottom:10px; }
    .pr-src:last-child { margin-bottom:0; }
    .pr-bar { height:8px; border-radius:999px; background:rgba(255,255,255,.08); overflow:hidden; margin-top:7px; }
    .pr-bar i { display:block; height:100%; border-radius:999px; background:linear-gradient(90deg,#f59e0b,#dc2626); }

    .pr-btn-gold { position:relative; overflow:hidden; padding:12px 22px; border:none; border-radius:12px; font-size:13px; font-weight:850; color:#03251f; cursor:pointer; background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441 80%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.7), 0 6px 16px rgba(217,164,65,.4); font-family:var(--font-display); transition:all .25s; }
    .pr-btn-gold::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:prShine 3s ease-in-out infinite; }
    .pr-btn-gold:hover { transform:translateY(-2px); filter:brightness(1.05); }
    .pr-btn-gold:disabled { opacity:.6; cursor:not-allowed; }
    .pr-btn-ghost { padding:12px 20px; border-radius:12px; font-size:13px; font-weight:700; color:var(--muted); background:rgba(255,255,255,.05); border:2px solid var(--border); text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all .25s; }
    .pr-btn-ghost:hover { color:#fca5a5; border-color:rgba(220,38,38,.45); }
    .pr-btn-red { padding:12px 20px; border-radius:12px; font-size:13px; font-weight:700; color:#fca5a5; background:rgba(220,38,38,.1); border:2px solid rgba(220,38,38,.35); text-decoration:none; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:all .25s; font-family:inherit; }
    .pr-btn-red:hover { background:rgba(220,38,38,.2); }

    .pr-blink { animation:prBlink 1.5s infinite; }
    
    /* Extract method chip */
    .pr-extract-chip { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border-radius:999px; font-size:11px; font-weight:800; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2); }
    .pr-extract-meta { display:flex; gap:12px; margin-top:10px; font-size:11px; opacity:.75; flex-wrap:wrap; }
</style>

<?php if (!empty($flash)): ?>
<div class="pr-flash <?= $flash['type'] === 'error' ? 'err' : ($flash['type'] === 'info' ? 'info' : 'ok') ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : ($flash['type'] === 'info' ? 'ℹ️' : '✅') ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<!-- HEADER + DIAL -->
<div class="pr-head">
    <div class="pr-dial">
        <svg width="160" height="160">
            <circle cx="80" cy="80" r="52" fill="none" stroke="rgba(255,255,255,.15)" stroke-width="11"/>
            <circle cx="80" cy="80" r="52" fill="none" stroke="<?= $isDone ? $cls : 'rgba(255,255,255,.3)' ?>" stroke-width="11" stroke-linecap="round"
                    stroke-dasharray="<?= round($circ, 2) ?>" stroke-dashoffset="<?= $isDone ? round($circ * (1 - min(100, $sim) / 100), 2) : $circ ?>"/>
        </svg>
        <div class="val">
            <b style="color:<?= $isDone ? $cls : '#fff' ?>" id="pr-gauge-num"><?= $isDone ? '0%' : '—' ?></b>
            <span><?= $isDone ? 'SIMILARITAS' : ($isQueued ? 'ANTREAN' : 'STATUS') ?></span>
        </div>
    </div>
    <div style="flex:1; min-width:240px; position:relative; z-index:1;">
        <h2 style="margin:0 0 6px; font-size:20px; font-weight:900;"><?= e($item['title']) ?></h2>
        <p style="margin:0 0 12px; font-size:12px; opacity:.85;">
            👤 <?= e($item['submitter_name']) ?><?= !empty($item['submitter_identity']) ? ' · ' . e($item['submitter_identity']) : '' ?>
            · 🏷️ <?= e(PlagiarismCheck::DOC_TYPES[$item['document_type']] ?? '-') ?>
            · 🕐 <?= e(date('d M Y, H:i', strtotime($item['created_at']))) ?>
        </p>
        <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
            <span class="pr-chip pr-code" id="pr-code" title="Klik untuk salin kode"><?= e($item['code']) ?> ⧉</span>
            <?php if ($isDone): ?><span class="pr-verdict" style="background:<?= $cls ?>;">⚖️ <?= $lbl ?></span><?php endif; ?>
            <?php if ($extractMethod): ?>
            <span class="pr-extract-chip" style="color:<?= $methodColor ?>;"><?= $methodLabel ?></span>
            <?php endif; ?>
            <?php if ($isQueued): ?><span class="pr-chip pr-blink" style="background:rgba(251,191,36,.25); border-color:rgba(251,191,36,.5); color:#fde68a;">⏳ Menunggu Teks</span><?php endif; ?>
            <?php if (!$isDone && !$isQueued): ?><span class="pr-chip"><?= $item['status'] === 'failed' ? '❌ Gagal' : '⏳ Antre' ?></span><?php endif; ?>
        </div>
        <?php if ($extractMethod && $extractPages > 0): ?>
        <div class="pr-extract-meta">
            <?php if ($extractPages > 0): ?><span>📄 <?= $extractPages ?> halaman</span><?php endif; ?>
            <?php if ($extractChars > 0): ?><span>🔤 <?= number_format($extractChars) ?> karakter</span><?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    <div style="display:flex; gap:8px; flex-wrap:wrap; position:relative; z-index:1;">
        <?php if (!empty($item['file_path'])): ?>
        <a class="pr-btn-gold" style="text-decoration:none; display:inline-flex;" href="<?= e(url('public/' . $item['file_path'])) ?>" target="_blank">📎 Unduh Berkas</a>
        <?php endif; ?>
        <?php if (!$isDone && !empty($item['file_path'])): ?>
        <form method="post" action="<?= e(url('admin/index.php?page=plagiarism-ekstrak')) ?>" style="display:inline;">
            <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
            <button class="pr-btn-gold" type="submit" title="Jalankan ulang mesin ekstraksi pada file tersimpan">🔁 Coba Ekstrak Ulang</button>
        </form>
        <?php endif; ?>
        <?php if ($isDone): ?><button type="button" class="pr-btn-gold" onclick="window.print()">🖨️ Cetak</button><?php endif; ?>
        <a class="pr-btn-ghost" href="<?= e(url('admin/index.php?page=plagiarism')) ?>">← Kembali</a>
    </div>
</div>

<!-- ⚡ ANALISIS SEKARANG — hanya muncul untuk dokumen antrean (PDF/DOCX yang gagal extract) -->
<?php if ($isQueued): ?>
<div class="pr-analyze-now">
    <div class="pr-an-head">
        <div class="pr-an-ico">⚡</div>
        <div>
            <h3 class="pr-an-title">Analisis Sekarang</h3>
            <p class="pr-an-sub">File PDF/DOCX tidak bisa dibaca otomatis (<?= $methodLabel ?>). Tempel isi dokumen di bawah untuk analisis instan.</p>
        </div>
    </div>
    <div class="pr-an-info">
        <b>💡 Cara cepat:</b> buka file <b><?= e(basename((string) $item['file_path'])) ?></b>, salin seluruh teks, lalu tempel ke kolom di bawah.
        Mesin shingle 6-gram akan langsung membandingkan dengan korpus internal LP3M.
    </div>
    <form method="post" action="<?= e(url('admin/index.php?page=plagiarism-analisis')) ?>" id="pr-an-form">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
        <textarea name="text" class="pr-an-textarea" id="pr-an-text" required placeholder="Tempel seluruh teks dokumen PDF/DOCX di sini..."></textarea>
        <div class="pr-an-hint">
            <span>Minimal ±50 kata untuk hasil akurat · Aman diproses di server lokal LP3M</span>
            <span class="pr-an-count" id="pr-an-count">0 kata</span>
        </div>
        <div class="pr-an-actions">
            <button type="submit" class="pr-btn-gold" id="pr-an-save">⚡ Jalankan Analisis Sekarang</button>
            <button type="reset" class="pr-btn-ghost">✖ Bersihkan</button>
        </div>
    </form>
</div>
<?php endif; ?>

<!-- TIMELINE STATUS -->
<div class="pr-steps">
    <div class="pr-step done"><span class="dot">✓</span> Dokumen Diterima</div>
    <div class="pr-line done"></div>
    <div class="pr-step <?= $isDone ? 'done' : ($isQueued ? 'active' : '') ?>"><span class="dot"><?= $isDone ? '✓' : ($isQueued ? '⚡' : '') ?></span> Analisis</div>
    <div class="pr-line <?= $isDone ? 'done' : '' ?>"></div>
    <div class="pr-step <?= $isDone ? 'done' : '' ?>"><span class="dot"><?= $isDone ? '✓' : '📋' ?></span> Laporan Akhir</div>
</div>

<!-- METRICS (hanya jika selesai) -->
<?php if ($isDone): ?>
<div class="pr-metrics">
    <div class="pr-metric"><b><?= number_format((int) ($res['word_count'] ?? $item['word_count'])) ?></b><span>Jumlah Kata</span></div>
    <div class="pr-metric"><b><?= number_format((float) $item['unique_score'], 1) ?>%</b><span>Keunikan</span></div>
    <div class="pr-metric"><b><?= number_format((float) $item['ai_score'], 1) ?>%</b><span>AI-Likelihood</span></div>
    <div class="pr-metric"><b><?= (int) $item['sources_found'] ?></b><span>Sumber Cocok</span></div>
</div>

<!-- REKOMENDASI OTOMATIS -->
<?php
$recClass = $sim >= PlagiarismCheck::THRESHOLD ? 'danger' : ($sim >= 15 ? 'warn' : 'good');
$recEmoji = $sim >= PlagiarismCheck::THRESHOLD ? '🚨' : ($sim >= 15 ? '⚠️' : '✅');
$recTitle = $sim >= PlagiarismCheck::THRESHOLD ? 'Rekomendasi: Wajib Revisi' : ($sim >= 15 ? 'Rekomendasi: Periksa Kutipan' : 'Dokumen Aman');
$recItems = $sim >= PlagiarismCheck::THRESHOLD
    ? ['Parafrase bagian yang mirip dengan kalimat sendiri.', 'Tambahkan kutipan langsung dengan tanda "..." dan sumber.', 'Pastikan setiap klaim memiliki referensi akademik.', 'Pertimbangkan penggunaan Turnitin resmi untuk verifikasi.']
    : ($sim >= 15
        ? ['Tinjau bagian dengan kemiripan 10%+ dan kutip sumbernya.', 'Perbaiki parafrase agar lebih orisinal.', 'Verifikasi bahwa kutipan sudah sesuai format APA/IEEE.']
        : ['Dokumen sudah memiliki tingkat orisinalitas yang baik.', 'Pertahankan kualitas kutipan dan referensi.', 'Lanjutkan konsistensi gaya penulisan.']);
?>
<div class="pr-rec <?= $recClass ?>">
    <h4><?= $recEmoji ?> <?= $recTitle ?></h4>
    <ul>
        <?php foreach ($recItems as $r): ?><li><?= $r ?></li><?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<!-- INPUT SKOR MANUAL — hanya muncul jika BELUM selesai (termasuk queued) -->
<?php if (!$isDone): ?>
<div class="pr-card">
    <h3 class="pr-card-title"><span class="emo">✍️</span><span>Input Skor Manual (Turnitin/Aplikasi Lain)</span><span class="num">REVIEW ADMIN</span></h3>
    <form method="post" action="<?= e(url('admin/index.php?page=plagiarism-manual')) ?>" class="pr-manual">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
        <div><label class="pr-label">Similaritas (%)</label><input class="pr-input" type="number" step="0.01" min="0" max="100" name="similarity" required placeholder="Contoh: 18.5"></div>
        <div><label class="pr-label">AI-Likelihood (%)</label><input class="pr-input" type="number" step="0.01" min="0" max="100" name="ai" value="0" placeholder="0"></div>
        <div><label class="pr-label">Catatan Review</label><input class="pr-input" type="text" name="note" placeholder="Misal: hasil Turnitin resmi, 20 Oktober 2026..."></div>
        <button class="pr-btn-gold" type="submit">💾 Simpan Skor</button>
    </form>
</div>
<?php endif; ?>

<!-- SUMBER KEMIRIPAN -->
<div class="pr-card">
    <h3 class="pr-card-title"><span class="emo">🔗</span><span>Sumber Kemiripan</span><span class="num"><?= count($sources) ?> SUMBER</span></h3>
    <?php if (empty($sources)): ?>
        <p style="opacity:.6; margin:0;">
            <?php if ($isQueued): ?>
                Belum ada analisis. Gunakan kartu <b>⚡ Analisis Sekarang</b> di atas atau input skor manual.
            <?php elseif (!$isDone): ?>
                Belum ada analisis.
            <?php else: ?>
                Tidak ada sumber kemiripan yang terdeteksi.
            <?php endif; ?>
        </p>
    <?php endif; ?>
    <?php foreach ($sources as $s): ?>
    <div class="pr-src">
        <div style="display:flex; justify-content:space-between; gap:10px; align-items:center;">
            <b style="font-size:13px; color:var(--text);">📑 <?= e($s['source_title']) ?></b>
            <span style="font-family:var(--font-display); font-weight:900; font-size:15px; color:<?= (float) $s['match_percentage'] >= 10 ? '#f87171' : '#fbbf24' ?>;"><?= number_format((float) $s['match_percentage'], 2) ?>%</span>
        </div>
        <div class="pr-bar"><i style="width:<?= min(100, (float) $s['match_percentage']) ?>%"></i></div>
        <?php if (!empty($s['snippet'])): ?><p style="margin:9px 0 0; font-size:12px; font-style:italic; opacity:.7; color:var(--muted);">"<?= e($s['snippet']) ?>"</p><?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>

<script>
(function(){
    // Salin kode ke clipboard
    var c = document.getElementById('pr-code');
    if (c) c.addEventListener('click', function(){
        var txt = c.textContent.replace(' ⧉','').trim();
        if (navigator.clipboard) navigator.clipboard.writeText(txt);
        c.textContent = '✅ Tersalin!';
        setTimeout(function(){ c.textContent = txt + ' ⧉'; }, 1500);
    });

    // Count-up gauge untuk hasil selesai
    var numEl = document.getElementById('pr-gauge-num');
    var target = <?= $isDone ? $sim : 0 ?>;
    if (numEl && target > 0) {
        var start = performance.now();
        var duration = 1600;
        function anim(t) {
            var p = Math.min((t - start) / duration, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            numEl.textContent = (target * eased).toFixed(1) + '%';
            if (p < 1) requestAnimationFrame(anim);
        }
        requestAnimationFrame(anim);
    }

    // Counter kata untuk form analisis
    var ta = document.getElementById('pr-an-text');
    var wc = document.getElementById('pr-an-count');
    if (ta && wc) {
        var upd = function(){ var v = ta.value.trim(); wc.textContent = (v === '' ? 0 : v.split(/\s+/).length) + ' kata'; };
        ta.addEventListener('input', upd); upd();
    }

    // Disable button setelah submit
    var form = document.getElementById('pr-an-form');
    var btn = document.getElementById('pr-an-save');
    if (form && btn) form.addEventListener('submit', function(){ btn.disabled = true; btn.textContent = '⏳ Menganalisis...'; });
})();
</script>