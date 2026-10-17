<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Resmi LP3M · <?= e($start) ?> → <?= e($end) ?></title>
    <style>
        @page { size: A4; margin: 12mm 12mm 16mm 12mm; }
        * { box-sizing: border-box; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 10.5pt; line-height: 1.55; color: #16211c; margin: 0; padding: 0; background: #f4f4f2; }

        /* ========== WATERMARK DIAGIONAL (ikut di tiap halaman cetak) ========== */
        .wm-big { position: fixed; inset: 0; display: flex; align-items: center; justify-content: center; transform: rotate(-28deg); font-family: Georgia, serif; font-size: 120pt; font-weight: 900; letter-spacing: .12em; color: rgba(6,95,70,.045); pointer-events: none; z-index: 0; user-select: none; }

        /* ========== FOOTER TETAP TIAP HALAMAN ========== */
        .page-foot { position: fixed; bottom: 4mm; left: 12mm; right: 12mm; z-index: 1; display: flex; justify-content: space-between; align-items: center; gap: 10px; border-top: 1px solid #a4cdb4; padding-top: 3px; font-size: 7pt; color: #7c9082; letter-spacing: .04em; }
        .page-foot .micro { font-size: 4.6pt; letter-spacing: .12em; color: #b6c8bc; white-space: nowrap; overflow: hidden; max-width: 46%; }

        /* ========== FRAME RESMI ========== */
        .sheet { position: relative; z-index: 2; background: #fff; margin: 0 auto 26px; max-width: 210mm; min-height: 297mm; padding: 12mm 11mm 18mm; border: 2px solid #065f46; outline: 1px solid #d9a441; outline-offset: 4px; box-shadow: 0 18px 50px rgba(0,0,0,.18); }
        .corner { position: absolute; width: 26px; height: 26px; border: 3px solid #d9a441; }
        .corner.tl { top: 6px; left: 6px; border-right: none; border-bottom: none; }
        .corner.tr { top: 6px; right: 6px; border-left: none; border-bottom: none; }
        .corner.bl { bottom: 6px; left: 6px; border-right: none; border-top: none; }
        .corner.br { bottom: 6px; right: 6px; border-left: none; border-top: none; }

        /* ========== KOP SURAT ========== */
        .kop { display: grid; grid-template-columns: 78px 1fr 118px; gap: 14px; align-items: center; padding-bottom: 12px; border-bottom: 4px double #065f46; margin-bottom: 6px; }
        .kop-logo { width: 78px; height: 78px; border-radius: 50%; display: flex; align-items: center; justify-content: center; overflow: hidden; background: radial-gradient(circle at 30% 25%, #fff7c2, #fde68a 30%, #d9a441 75%, #a9761b); box-shadow: inset 0 2px 4px rgba(255,255,255,.65), inset 0 -3px 5px rgba(0,0,0,.22), 0 4px 12px rgba(217,164,65,.45); }
        .kop-logo img { width: 100%; height: 100%; object-fit: contain; }
        .kop-logo span { font-family: Georgia, serif; font-size: 30pt; font-weight: 900; color: #03251f; }
        .kop-info { text-align: center; }
        .kop-info .h1 { font-size: 13.5pt; font-weight: 900; color: #065f46; margin: 0; letter-spacing: .03em; }
        .kop-info .h2 { font-size: 11.5pt; font-weight: 800; color: #16211c; margin: 1px 0; letter-spacing: .02em; }
        .kop-info .h3 { font-size: 9pt; color: #52705c; margin: 1px 0; }
        .kop-info .h4 { font-size: 8pt; color: #7c9082; margin: 3px 0 0; letter-spacing: .06em; }
        .kop-side { text-align: center; }
        .qr-img { width: 74px; height: 74px; border: 1px solid #d9a441; border-radius: 6px; padding: 3px; background: #fff; display: block; margin: 0 auto; }
        .barcode { display: flex; gap: 1.5px; align-items: stretch; height: 26px; justify-content: center; margin: 5px auto 2px; width: 96px; }
        .barcode i { background: #16211c; display: block; }
        .kop-side small { font-size: 6.6pt; font-weight: 800; letter-spacing: .08em; color: #52705c; display: block; }

        /* ========== JUDUL ========== */
        .head { text-align: center; margin: 14px 0 16px; }
        .head .klass { display: inline-block; padding: 3px 14px; border: 1px solid #b91c1c; color: #b91c1c; font-size: 7.5pt; font-weight: 900; letter-spacing: .22em; margin-bottom: 8px; }
        .head h1 { margin: 0 0 3px; font-size: 17pt; font-weight: 900; color: #065f46; letter-spacing: .04em; text-transform: uppercase; text-decoration: underline; text-underline-offset: 5px; text-decoration-thickness: 2px; }
        .head h2 { margin: 8px 0 10px; font-size: 10.5pt; font-weight: 600; color: #52705c; }
        .head .meta { display: inline-flex; flex-wrap: wrap; justify-content: center; gap: 6px 16px; padding: 6px 16px; background: #f3e7c9; border: 1px solid #d9a441; border-radius: 4px; font-size: 8.5pt; font-weight: 700; color: #78350f; }

        /* ========== SECTION ========== */
        .section { margin-bottom: 16px; page-break-inside: avoid; position: relative; z-index: 2; }
        .section > h2 { font-size: 10.5pt; font-weight: 900; color: #065f46; margin: 0 0 8px; padding: 5px 10px; background: linear-gradient(90deg, #eef8f1, rgba(238,248,241,0)); border-left: 4px solid #d9a441; letter-spacing: .05em; text-transform: uppercase; }
        .narrative { font-size: 10pt; text-align: justify; margin: 0 0 10px; }
        .narrative b { color: #065f46; }

        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
        .kpi { position: relative; padding: 10px 12px; border: 1px solid #a4cdb4; border-radius: 6px; background: linear-gradient(160deg, #ffffff, #f6fcf7); overflow: hidden; }
        .kpi::after { content: ''; position: absolute; top: 0; right: 0; width: 34px; height: 34px; background: radial-gradient(circle at top right, rgba(217,164,65,.22), transparent 70%); }
        .kpi b { display: block; font-family: Georgia, serif; font-size: 19pt; font-weight: 900; color: #065f46; line-height: 1.05; }
        .kpi span { display: block; font-size: 7.5pt; font-weight: 800; color: #52705c; margin-top: 2px; text-transform: uppercase; letter-spacing: .1em; }

        /* ========== TABEL ========== */
        table.mod { width: 100%; border-collapse: collapse; font-size: 9.5pt; }
        table.mod th { padding: 6px 9px; text-align: left; background: #065f46; color: #fff; font-weight: 800; font-size: 8pt; text-transform: uppercase; letter-spacing: .08em; border: 1px solid #043b2c; }
        table.mod td { padding: 5px 9px; border: 1px solid #a4cdb4; background: #fff; vertical-align: middle; }
        table.mod tr:nth-child(even) td { background: #f6fcf7; }
        table.mod .num { text-align: right; font-weight: 800; color: #065f46; font-family: Georgia, serif; }
        table.mod tfoot td { background: #f3e7c9 !important; font-weight: 900; border-top: 2px solid #d9a441; }
        .barwrap { width: 100%; height: 7px; background: #e5efe8; border: 1px solid #cfe0d5; border-radius: 4px; overflow: hidden; }
        .barwrap i { display: block; height: 100%; background: linear-gradient(90deg, #059669, #d9a441); }
        .rank { display: inline-flex; width: 17px; height: 17px; border-radius: 50%; align-items: center; justify-content: center; font-size: 7.5pt; font-weight: 900; background: #065f46; color: #fff; }
        .rank.g { background: linear-gradient(145deg,#fde68a,#d9a441); color: #03251f; }
        .rank.s { background: linear-gradient(145deg,#e5e7eb,#9ca3af); color: #fff; }
        .rank.b { background: linear-gradient(145deg,#fdba74,#c2410c); color: #fff; }

        /* ========== GRAFIK BULAN ========== */
        .chart { display: flex; align-items: flex-end; gap: 5px; height: 92px; padding: 8px 6px 0; border: 1px solid #a4cdb4; border-radius: 6px; background: linear-gradient(180deg,#ffffff,#f6fcf7); }
        .cbar { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: flex-end; height: 100%; gap: 3px; }
        .cbar i { width: 100%; max-width: 26px; border-radius: 3px 3px 0 0; background: linear-gradient(180deg, #d9a441, #059669); box-shadow: inset 0 1px 1px rgba(255,255,255,.5); }
        .cbar i.zero { background: #dfe9e2; }
        .cbar span { font-size: 6.6pt; font-weight: 800; color: #52705c; }
        .cbar em { font-style: normal; font-size: 6.4pt; font-weight: 800; color: #065f46; }

        /* ========== INSIGHT ========== */
        .insights { list-style: none; margin: 0; padding: 0; }
        .insights li { display: flex; gap: 8px; align-items: flex-start; padding: 5px 8px; border: 1px dashed #cfe0d5; border-radius: 5px; margin-bottom: 5px; font-size: 9.5pt; background: #fcfefc; }
        .insights li b { color: #065f46; }
        .insights .ic { flex-shrink: 0; font-size: 11pt; }

        /* ========== TANDA TANGAN + SEGEL ========== */
        .sig { margin-top: 26px; display: flex; justify-content: space-between; align-items: flex-start; page-break-inside: avoid; }
        .sig .col { text-align: center; width: 30%; font-size: 9.5pt; }
        .sig .col p { margin: 0; }
        .sig .space { height: 62px; }
        .sig .line { border-top: 1.5px solid #16211c; margin: 0 12px; }
        .sig .name { font-weight: 800; margin-top: 4px; }
        .sig .nip { font-size: 8.5pt; color: #52705c; margin-top: 2px; }
        .seal { width: 92px; height: 92px; border-radius: 50%; border: 2.5px double #065f46; display: flex; align-items: center; justify-content: center; transform: rotate(-12deg); opacity: .9; margin-top: 26px; position: relative; }
        .seal::before { content: ''; position: absolute; inset: 5px; border: 1px solid #d9a441; border-radius: 50%; }
        .seal-in { text-align: center; line-height: 1.15; }
        .seal-in .st { font-size: 12pt; color: #d9a441; }
        .seal-in .t1 { display: block; font-size: 9pt; font-weight: 900; color: #065f46; letter-spacing: .06em; }
        .seal-in .t2 { display: block; font-size: 6.4pt; font-weight: 800; color: #52705c; letter-spacing: .14em; }

        /* ========== TOOLBAR LAYAR ========== */
        .no-print { position: sticky; top: 0; z-index: 10000; padding: 10px 18px; background: linear-gradient(135deg, #043b2c, #065f46 60%, #059669); display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 10px; box-shadow: 0 6px 20px rgba(0,0,0,.25); }
        .no-print .t { color: #fde68a; font-weight: 900; font-size: 12.5px; letter-spacing: .06em; }
        .no-print .id { color: rgba(255,255,255,.75); font-size: 11px; font-family: 'Courier New', monospace; }
        .no-print button { padding: 8px 18px; border: none; border-radius: 8px; font-size: 12px; font-weight: 800; cursor: pointer; transition: all .2s; font-family: inherit; }
        .no-print .btn-print { background: linear-gradient(145deg,#fde68a,#d9a441); color: #03251f; box-shadow: 0 3px 10px rgba(217,164,65,.4); }
        .no-print .btn-print:hover { transform: translateY(-1px); filter: brightness(1.05); }
        .no-print .btn-close { background: rgba(255,255,255,.14); color: #fff; border: 1px solid rgba(255,255,255,.3); }
        .no-print .btn-close:hover { background: rgba(220,38,38,.8); }

        @media print {
            body { background: #fff; }
            .no-print { display: none; }
            .sheet { margin: 0; max-width: none; min-height: auto; box-shadow: none; border-width: 2px; }
        }
    </style>
</head>
<body>

<?php
$totalAll = array_sum(array_column($summary, 'count'));
$sorted = $summary; uasort($sorted, fn($a, $b) => $b['count'] <=> $a['count']);
$reportId = 'LP3M-RPT-' . date('Ymd', strtotime($start)) . '-' . strtoupper(substr(md5($start . $end), 0, 6));
$verifyUrl = url('admin/index.php?page=laporan-print&start=' . urlencode($start) . '&end=' . urlencode($end));

try { $set = Setting::all(); } catch (\Throwable $e) { $set = []; }
$logoUrl = !empty($set['logo_path']) ? upload_url($set['logo_path']) : null;

// Distribusi bulanan dalam periode (lintas modul)
$monthNames = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
$monthly = [];
$pdo = Database::pdo();
foreach (array_keys($modules) as $mk) {
    $info = Report::moduleInfo($mk);
    $q = $pdo->prepare("SELECT MONTH(created_at) m, COUNT(*) c FROM {$info['table']} WHERE created_at BETWEEN ? AND ? GROUP BY MONTH(created_at)");
    $q->execute([$start . ' 00:00:00', $end . ' 23:59:59']);
    foreach ($q->fetchAll() as $r) { $monthly[(int) $r['m']] = ($monthly[(int) $r['m']] ?? 0) + (int) $r['c']; }
}
ksort($monthly);
$maxMonth = max(1, ...array_values($monthly ?: [0]));

// Periode sebelumnya untuk tren
$lenDays = (int) (((strtotime($end) - strtotime($start)) / 86400) + 1);
$prevStart = date('Y-m-d', strtotime($start . " -{$lenDays} days"));
$prevEnd   = date('Y-m-d', strtotime($start . ' -1 day'));
$prevTotal = array_sum(array_column(Report::summary($prevStart, $prevEnd), 'count'));
$trendPct  = $prevTotal > 0 ? round((($totalAll - $prevTotal) / $prevTotal) * 100, 1) : null;

$topKey = array_key_first($sorted);
$topInfo = $topKey !== null ? Report::moduleInfo($topKey) : null;
$topPct  = ($topKey !== null && $totalAll > 0) ? round(($sorted[$topKey]['count'] / $totalAll) * 100, 1) : 0;
$peakM = !empty($monthly) ? array_keys($monthly, max($monthly))[0] : null;

// Barcode deterministik dari reportId
$hash = md5($reportId);
$bars = '';
for ($i = 0; $i < 42; $i++) { $w = 1 + (hexdec($hash[$i % 32]) % 4); $bars .= '<i style="width:' . $w . 'px"></i>'; }
$micro = str_repeat($reportId . ' · DOKUMEN RESMI LP3M UNIMOF · ', 6);
?>

<div class="no-print">
    <span class="t">📄 PRATINJAU CETAK RESMI</span>
    <span class="id"><?= $reportId ?></span>
    <button class="btn-print" onclick="window.print()">🖨️ Print / Save as PDF</button>
    <button class="btn-close" onclick="window.close()">✕ Tutup</button>
</div>

<div class="wm-big" aria-hidden="true">LP3M</div>

<div class="sheet">
    <span class="corner tl"></span><span class="corner tr"></span>
    <span class="corner bl"></span><span class="corner br"></span>

    <!-- KOP SURAT -->
    <div class="kop">
        <div class="kop-logo">
            <?php if ($logoUrl): ?><img src="<?= e($logoUrl) ?>" alt="Logo"><?php else: ?><span>LP</span><?php endif; ?>
        </div>
        <div class="kop-info">
            <div class="h1">LEMBAGA PENELITIAN, PENGABDIAN KEPADA MASYARAKAT</div>
            <div class="h2">DAN AL-ISLAM KEMUHAMMADIYAHAN (LP3M-LPPAIK)</div>
            <div class="h3">UNIVERSITAS MUHAMMADIYAH MAUMERE</div>
            <div class="h4">Jl. Wairklau, Maumere, Sikka, Nusa Tenggara Timur · lp3m@unimof.ac.id · lp3m.unimof.ac.id</div>
        </div>
        <div class="kop-side">
            <img class="qr-img" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&margin=4&data=<?= e(urlencode($verifyUrl)) ?>" alt="QR Verifikasi" onerror="this.style.display='none'">
            <div class="barcode" aria-hidden="true"><?= $bars ?></div>
            <small><?= $reportId ?></small>
        </div>
    </div>

    <!-- JUDUL -->
    <div class="head">
        <span class="klass">KLASIFIKASI · INTERNAL TERBATAS</span>
        <h1>Laporan Rekapitulasi Data Lembaga</h1>
        <h2>Periode <?= e(date('d F Y', strtotime($start))) ?> s.d. <?= e(date('d F Y', strtotime($end))) ?></h2>
        <div class="meta">
            <span>📄 Nomor: <b><?= $reportId ?></b></span>
            <span>🖨️ Dicetak: <b><?= date('d M Y · H:i') ?> WITA</b></span>
            <span>👤 Oleh: <b><?= e(Auth::user()['name'] ?? 'Sistem') ?></b></span>
        </div>
    </div>

    <!-- I. RINGKASAN EKSEKUTIF -->
    <div class="section">
        <h2>I. Ringkasan Eksekutif</h2>
        <p class="narrative">
            Berdasarkan rekapitulasi otomatis sistem informasi LP3M, selama periode
            <b><?= e(date('d M Y', strtotime($start))) ?></b> s.d. <b><?= e(date('d M Y', strtotime($end))) ?></b>
            tercatat <b><?= number_format($totalAll) ?> entri data</b> pada <b><?= count($summary) ?> modul layanan</b>.
            <?php if ($topInfo): ?>Kontribusi tertinggi berasal dari modul <b><?= $topInfo['ico'] ?> <?= e($topInfo['label']) ?></b> sebesar <b><?= $topPct ?>%</b> dari total keseluruhan.<?php endif; ?>
            <?php if ($peakM): ?>Aktivitas puncak terjadi pada bulan <b><?= $monthNames[$peakM - 1] ?></b> dengan <b><?= number_format($monthly[$peakM]) ?> entri</b>.<?php endif; ?>
            <?php if ($trendPct !== null): ?>Dibandingkan periode sebelumnya (<b><?= number_format($prevTotal) ?> entri</b>), terjadi <?= $trendPct >= 0 ? 'peningkatan' : 'penurunan' ?> sebesar <b><?= abs($trendPct) ?>%</b>.<?php endif; ?>
        </p>
        <div class="grid-3">
            <div class="kpi"><b><?= number_format($totalAll) ?></b><span>Total Entri Data</span></div>
            <div class="kpi"><b><?= count($summary) ?></b><span>Modul Terlibat</span></div>
            <div class="kpi"><b><?= $lenDays ?></b><span>Rentang Hari</span></div>
        </div>
    </div>

    <!-- II. RINCIAN PER MODUL -->
    <div class="section">
        <h2>II. Rincian Kontribusi Per Modul</h2>
        <table class="mod">
            <thead>
                <tr>
                    <th style="width:26px;">#</th>
                    <th>Modul Layanan</th>
                    <th style="width:26%;">Distribusi</th>
                    <th style="width:70px;" class="num">Jumlah</th>
                    <th style="width:58px;" class="num">Persen</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; foreach ($sorted as $key => $s): $i++;
                    $pct = $totalAll > 0 ? ($s['count'] / $totalAll) * 100 : 0;
                    $rc = $i === 1 ? 'g' : ($i === 2 ? 's' : ($i === 3 ? 'b' : ''));
                ?>
                <tr>
                    <td><span class="rank <?= $rc ?>"><?= $i ?></span></td>
                    <td><?= $s['ico'] ?> <b><?= e($s['label']) ?></b></td>
                    <td><div class="barwrap"><i style="width:<?= round($pct) ?>%"></i></div></td>
                    <td class="num"><?= number_format($s['count']) ?></td>
                    <td class="num"><?= number_format($pct, 2) ?>%</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right;">TOTAL KESELURUHAN</td>
                    <td class="num"><?= number_format($totalAll) ?></td>
                    <td class="num">100%</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- III. DISTRIBUSI BULANAN -->
    <?php if (!empty($monthly)): ?>
    <div class="section">
        <h2>III. Distribusi Aktivitas Bulanan</h2>
        <div class="chart">
            <?php foreach ($monthly as $m => $c): ?>
            <div class="cbar">
                <em><?= number_format($c) ?></em>
                <i class="<?= $c === 0 ? 'zero' : '' ?>" style="height:<?= max(3, (int) round($c / $maxMonth * 100)) ?>%"></i>
                <span><?= $monthNames[$m - 1] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- IV. SOROTAN & CATATAN -->
    <div class="section">
        <h2>IV. Sorotan &amp; Catatan Verifikasi</h2>
        <ul class="insights">
            <?php if ($topInfo): ?><li><span class="ic">🏆</span><span>Modul teraktif: <b><?= e($topInfo['label']) ?></b> (<?= number_format($sorted[$topKey]['count']) ?> entri · <?= $topPct ?>% dari total).</span></li><?php endif; ?>
            <?php if ($peakM): ?><li><span class="ic">📈</span><span>Bulan puncak aktivitas: <b><?= $monthNames[$peakM - 1] ?></b> (<?= number_format($monthly[$peakM]) ?> entri).</span></li><?php endif; ?>
            <?php if ($trendPct !== null): ?><li><span class="ic"><?= $trendPct >= 0 ? '▲' : '▼' ?></span><span>Tren dibanding periode sebelumnya: <b><?= $trendPct >= 0 ? 'naik' : 'turun' ?> <?= abs($trendPct) ?>%</b> (<?= number_format($prevTotal) ?> → <?= number_format($totalAll) ?> entri).</span></li><?php endif; ?>
            <li><span class="ic">🔐</span><span>Keaslian dokumen dapat diverifikasi melalui kode <b><?= $reportId ?></b> atau pemindaian QR pada kop surat.</span></li>
            <li><span class="ic">🖋️</span><span>Dokumen sah tanpa tanda tangan basah apabila dicetak langsung dari sistem informasi LP3M.</span></li>
        </ul>
    </div>

    <!-- V. TANDA TANGAN -->
    <div class="section">
        <h2>V. Pengesahan</h2>
        <div class="sig">
            <div class="col">
                <p>Maumere, <?= date('d F Y') ?></p>
                <p>Ketua LP3M-LPPAIK</p>
                <div class="space"></div>
                <div class="line"></div>
                <p class="name">(..........................................)</p>
                <p class="nip">NIP/NIDN. ...................................</p>
            </div>
            <div class="seal" aria-hidden="true">
                <div class="seal-in">
                    <span class="st">★</span>
                    <span class="t1">LP3M</span>
                    <span class="t2">UNIMOF · RESMI</span>
                </div>
            </div>
            <div class="col">
                <p>Mengetahui,</p>
                <p>Rektor Universitas Muhammadiyah Maumere</p>
                <div class="space"></div>
                <div class="line"></div>
                <p class="name">(..........................................)</p>
                <p class="nip">NIP/NIDN. ...................................</p>
            </div>
        </div>
    </div>
</div>

<div class="page-foot">
    <span><?= $reportId ?> · Dicetak <?= date('d/m/Y H:i') ?> WITA oleh <?= e(Auth::user()['name'] ?? 'Sistem') ?></span>
    <span class="micro"><?= e($micro) ?></span>
    <span>LP3M UNIMOF · Fastabiqul Khairat</span>
</div>

</body>
</html>