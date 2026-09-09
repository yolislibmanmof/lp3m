<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CV Akademik — <?= e($user['name']) ?></title>
    <style>
        @page { size: A4; margin: 18mm 15mm; }
        * { box-sizing: border-box; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        body { font-family: 'Segoe UI', Tahoma, sans-serif; font-size: 10.5pt; line-height: 1.55; color: #16211c; margin: 0; padding: 0; background: #f4f4f2; }
        .sheet { max-width: 210mm; margin: 0 auto; background: #fff; padding: 20mm 16mm; box-shadow: 0 10px 40px rgba(0,0,0,.15); }

        /* KOP */
        .kop { display: grid; grid-template-columns: 70px 1fr 110px; gap: 14px; align-items: center; padding-bottom: 12px; border-bottom: 4px double #065f46; margin-bottom: 18px; }
        .kop-logo { width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 26pt; font-weight: 900; background: radial-gradient(circle at 30% 25%, #fde68a, #d9a441); color: #03251f; }
        .kop-info { text-align: center; }
        .kop-info .h1 { font-size: 13pt; font-weight: 900; color: #065f46; margin: 0; }
        .kop-info .h2 { font-size: 11pt; font-weight: 700; margin: 2px 0; }
        .kop-info .h3 { font-size: 9pt; color: #52705c; margin: 2px 0; }
        .kop-qr { text-align: center; font-size: 8pt; color: #7c9082; }
        .kop-qr .box { width: 70px; height: 70px; margin: 0 auto 4px; border: 1px solid #d9a441; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 7pt; font-weight: 700; color: #065f46; }

        /* HEADER DOSEN */
        .cv-head { text-align: center; margin-bottom: 16px; }
        .cv-head h1 { font-size: 18pt; font-weight: 900; color: #065f46; margin: 0 0 4px; letter-spacing: .02em; }
        .cv-head .sub { font-size: 10pt; color: #52705c; margin: 0; }
        .cv-head .badge { display: inline-block; margin-top: 8px; padding: 4px 14px; border-radius: 999px; font-size: 9pt; font-weight: 800; background: #eef8f1; border: 1px solid #a4cdb4; color: #047857; }

        /* STATS */
        .cv-stats { display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; margin-bottom: 18px; }
        .cv-stat { padding: 10px; text-align: center; border: 1px solid #a4cdb4; border-radius: 8px; background: #f6fcf7; }
        .cv-stat b { display: block; font-size: 16pt; font-weight: 900; color: #065f46; line-height: 1; }
        .cv-stat span { display: block; font-size: 7.5pt; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; color: #52705c; margin-top: 3px; }

        /* SECTION */
        .cv-sec { margin-bottom: 16px; page-break-inside: avoid; }
        .cv-sec h2 { font-size: 11.5pt; font-weight: 900; color: #065f46; margin: 0 0 8px; padding: 5px 10px; background: #eef8f1; border-left: 4px solid #d9a441; }
        .cv-list { list-style: none; margin: 0; padding: 0; }
        .cv-list li { padding: 6px 0; border-bottom: 1px dashed #cfe0d5; font-size: 10pt; }
        .cv-list li:last-child { border-bottom: none; }
        .cv-list .t { font-weight: 700; color: #16211c; }
        .cv-list .m { font-size: 9pt; color: #52705c; margin-top: 2px; }

        /* TANDA TANGAN */
        .cv-sig { margin-top: 30px; display: flex; justify-content: space-around; page-break-inside: avoid; }
        .cv-sig div { text-align: center; width: 220px; font-size: 10pt; }
        .cv-sig .space { height: 60px; }
        .cv-sig .line { border-top: 1.5px solid #16211c; margin: 0 10px; }
        .cv-sig .name { font-weight: 800; margin-top: 4px; }

        /* FOOTER */
        .cv-foot { margin-top: 24px; padding-top: 10px; border-top: 2px solid #d9a441; text-align: center; font-size: 8pt; color: #7c9082; }

        /* PRINT BUTTON */
        .no-print { position: fixed; top: 16px; right: 16px; z-index: 9999; }
        .no-print button { padding: 12px 24px; border: none; border-radius: 12px; font-size: 14px; font-weight: 800; cursor: pointer; color: #03251f; background: linear-gradient(145deg, #fde68a, #d9a441); box-shadow: 0 6px 18px rgba(217,164,65,.4); }
        @media print { .no-print { display: none; } body { background: #fff; } .sheet { box-shadow: none; padding: 0; } }
    </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()">🖨️ Print / Save as PDF</button>
</div>

<div class="sheet">

    <!-- KOP -->
    <div class="kop">
        <div class="kop-logo">LP</div>
        <div class="kop-info">
            <div class="h1">LEMBAGA PENELITIAN, PENGABDIAN KEPADA MASYARAKAT</div>
            <div class="h2">DAN AL-ISLAM KEMUHAMMADIYAHAN (LP3M-LPPAIK)</div>
            <div class="h3">UNIVERSITAS MUHAMMADIYAH MAUMERE</div>
            <div class="h3">Jl. Wairklau, Maumere, Sikka, NTT · lp3m@unimof.ac.id</div>
        </div>
        <div class="kop-qr">
            <div class="box">CV<br>ONLINE</div>
            <span>lp3m.unimof.ac.id</span>
        </div>
    </div>

    <!-- HEADER DOSEN -->
    <div class="cv-head">
        <h1>CURRICULUM VITAE AKADEMIK</h1>
        <p class="sub"><?= e($user['name']) ?></p>
        <span class="badge">
            <?= !empty($user['nidn']) ? 'NIDN: ' . e($user['nidn']) . ' · ' : '' ?>
            <?= e($user['institution'] ?? 'LP3M UNIMOF') ?>
        </span>
    </div>

    <!-- STATS -->
    <div class="cv-stats">
        <div class="cv-stat"><b><?= (int) $stats['total_all'] ?></b><span>Total Karya</span></div>
        <div class="cv-stat"><b><?= (int) $stats['total_researches'] ?></b><span>Penelitian</span></div>
        <div class="cv-stat"><b><?= (int) $stats['total_publications'] ?></b><span>Publikasi</span></div>
        <div class="cv-stat"><b><?= (int) $stats['total_haki'] ?></b><span>HAKI</span></div>
        <div class="cv-stat"><b><?= (int) $stats['total_cs'] ?></b><span>Pengabdian</span></div>
    </div>

    <!-- PENELITIAN -->
    <div class="cv-sec">
        <h2>A. PENELITIAN</h2>
        <?php if (empty($researches)): ?>
        <p style="margin:0; font-size:10pt; color:#7c9082;">Belum ada data penelitian.</p>
        <?php else: ?>
        <ul class="cv-list">
            <?php foreach ($researches as $r): ?>
            <li>
                <div class="t"><?= e($r['title']) ?></div>
                <div class="m">
                    Tahun <?= (int) ($r['year'] ?? '-') ?> ·
                    Skema: <?= e(ucfirst(str_replace('_', ' ', $r['scheme'] ?? 'Internal'))) ?>
                    <?= !empty($r['funding']) ? ' · Pendanaan: ' . e($r['funding']) : '' ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>

    <!-- PUBLIKASI -->
    <div class="cv-sec">
        <h2>B. PUBLIKASI ILMIAH</h2>
        <?php if (empty($publications)): ?>
        <p style="margin:0; font-size:10pt; color:#7c9082;">Belum ada data publikasi.</p>
        <?php else: ?>
        <ul class="cv-list">
            <?php foreach ($publications as $p): ?>
            <li>
                <div class="t"><?= e($p['title']) ?></div>
                <div class="m">
                    Tahun <?= (int) ($p['year'] ?? '-') ?>
                    <?= !empty($p['journal']) ? ' · ' . e($p['journal']) : '' ?>
                    <?= !empty($p['doi']) ? ' · DOI: ' . e($p['doi']) : '' ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>

    <!-- HAKI -->
    <div class="cv-sec">
        <h2>C. HAK KEKAYAAN INTELEKTUAL</h2>
        <?php if (empty($haki)): ?>
        <p style="margin:0; font-size:10pt; color:#7c9082;">Belum ada data HAKI.</p>
        <?php else: ?>
        <ul class="cv-list">
            <?php foreach ($haki as $h): ?>
            <li>
                <div class="t"><?= e($h['title']) ?></div>
                <div class="m">
                    Tahun <?= (int) ($h['year'] ?? '-') ?> ·
                    Jenis: <?= e(ucfirst(str_replace('_', ' ', $h['type'] ?? 'Hak Cipta'))) ?>
                    <?= !empty($h['registration_number']) ? ' · No. Reg: ' . e($h['registration_number']) : '' ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>

    <!-- PENGABDIAN -->
    <div class="cv-sec">
        <h2>D. PENGABDIAN KEPADA MASYARAKAT</h2>
        <?php if (empty($cs)): ?>
        <p style="margin:0; font-size:10pt; color:#7c9082;">Belum ada data pengabdian.</p>
        <?php else: ?>
        <ul class="cv-list">
            <?php foreach ($cs as $c): ?>
            <li>
                <div class="t"><?= e($c['title']) ?></div>
                <div class="m">
                    Tahun <?= (int) ($c['year'] ?? '-') ?> ·
                    Skema: <?= e(ucfirst(str_replace('_', ' ', $c['type'] ?? 'Reguler'))) ?>
                    <?= !empty($c['location']) ? ' · Lokasi: ' . e($c['location']) : '' ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>

    <!-- TANDA TANGAN -->
    <div class="cv-sig">
        <div>
            <p>Maumere, <?= date('d F Y') ?></p>
            <p>Yang bersangkutan,</p>
            <div class="space"></div>
            <div class="line"></div>
            <p class="name"><?= e($user['name']) ?></p>
            <p style="font-size:9pt; color:#52705c; margin-top:2px;">
                <?= !empty($user['nidn']) ? 'NIDN. ' . e($user['nidn']) : 'NIP/NIDN. ....................' ?>
            </p>
        </div>
        <div>
            <p>Mengetahui,</p>
            <p>Ketua LP3M-LPPAIK</p>
            <div class="space"></div>
            <div class="line"></div>
            <p class="name">(..........................................)</p>
            <p style="font-size:9pt; color:#52705c; margin-top:2px;">NIP/NIDN. ....................</p>
        </div>
    </div>

    <div class="cv-foot">
        Dokumen ini dicetak otomatis dari sistem informasi LP3M UNIMOF pada <?= date('d M Y · H:i') ?> WITA ·
        Verifikasi online: lp3m.unimof.ac.id/dosen?id=<?= (int) $user['id'] ?>
    </div>

</div>

</body>
</html>