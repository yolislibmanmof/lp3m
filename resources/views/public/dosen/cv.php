<?php
$siteName = Setting::all()['site_brand'] ?? 'LP3M UNIMOF';
$cvDate = date('d F Y');
$cvTime = date('H:i');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CV Akademik — <?= e($user['name']) ?></title>
    <style>
        @page {
            size: A4;
            margin: 18mm 15mm;
            @bottom-right { content: "Halaman " counter(page) " dari " counter(pages); font-size: 8pt; color: #7c9082; }
            @bottom-left { content: "CV Akademik — <?= e($user['name']) ?>"; font-size: 8pt; color: #7c9082; }
        }
        * { box-sizing: border-box; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 10.5pt; line-height: 1.55; color: #16211c;
            margin: 0; padding: 0; background: #e8ece9;
        }

        /* FLOATING TOOLBAR */
        .cv-toolbar {
            position: fixed; top: 16px; right: 16px; z-index: 9999;
            display: flex; gap: 8px; flex-wrap: wrap;
            padding: 10px 12px; border-radius: 14px;
            background: rgba(255,255,255,.96); backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(0,0,0,.12); border: 1px solid rgba(5,150,105,.2);
        }
        .cv-toolbar button {
            padding: 10px 18px; border: none; border-radius: 10px; font-size: 12.5px;
            font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
            transition: all .2s;
        }
        .cv-toolbar .print {
            color: #03251f; background: linear-gradient(145deg, #fde68a, #d9a441);
            box-shadow: 0 6px 16px rgba(217,164,65,.35);
        }
        .cv-toolbar .back { color: var(--muted); background: rgba(0,0,0,.04); border: 1px solid var(--border); }
        .cv-toolbar button:hover { transform: translateY(-2px); filter: brightness(1.05); }

        /* PAGE CONTAINER */
        .sheet {
            max-width: 210mm; margin: 20px auto; background: #fff;
            padding: 20mm 16mm; box-shadow: 0 10px 40px rgba(0,0,0,.15);
            position: relative; overflow: hidden;
        }
        .sheet::before {
            content: 'CV AKADEMIK';
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 90pt; font-weight: 900; color: rgba(5,150,105,.04);
            letter-spacing: .08em; pointer-events: none; z-index: 0;
            font-family: 'Arial Black', sans-serif;
        }
        .sheet > * { position: relative; z-index: 1; }

        /* COVER PAGE */
        .cv-cover {
            min-height: 247mm; display: flex; flex-direction: column;
            justify-content: center; align-items: center; text-align: center;
            padding: 40px; background: linear-gradient(135deg, rgba(5,150,105,.05), rgba(253,230,138,.04));
            border-radius: 8px; margin-bottom: 24px; position: relative;
            page-break-after: always;
        }
        .cv-cover::before {
            content: ''; position: absolute; inset: 8mm;
            border: 2px double #d9a441; border-radius: 4px; pointer-events: none;
        }
        .cv-cover .emblem {
            width: 100px; height: 100px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 40pt; font-weight: 900; color: #03251f;
            background: radial-gradient(circle at 30% 25%, #fff7c2, #fde68a 20%, #f2c063 55%, #d9a441);
            box-shadow: inset 0 3px 5px rgba(255,255,255,.6), inset 0 -4px 6px rgba(0,0,0,.2), 0 12px 30px rgba(217,164,65,.4);
            margin-bottom: 30px;
        }
        .cv-cover .lbl {
            font-size: 10pt; font-weight: 800; letter-spacing: .3em;
            text-transform: uppercase; color: #7c9082; margin-bottom: 10px;
        }
        .cv-cover h1 {
            font-size: 32pt; font-weight: 900; color: #065f46;
            letter-spacing: -.02em; margin: 0 0 14px; line-height: 1.1;
            font-family: Georgia, serif;
        }
        .cv-cover .who {
            font-size: 20pt; font-weight: 800; color: #16211c;
            margin: 0 0 8px; letter-spacing: -.01em;
        }
        .cv-cover .nidn {
            font-size: 11pt; color: #52705c; font-weight: 700;
            padding: 6px 18px; background: #f6fcf7; border: 1px solid #a4cdb4;
            border-radius: 999px; display: inline-block; margin-bottom: 30px;
        }
        .cv-cover .meta {
            font-size: 10pt; color: #7c9082; line-height: 1.7;
            max-width: 400px; margin-top: 40px;
        }
        .cv-cover .meta b { color: #065f46; font-weight: 800; }

        /* KOP */
        .kop {
            display: grid; grid-template-columns: 70px 1fr 110px; gap: 14px;
            align-items: center; padding-bottom: 12px;
            border-bottom: 4px double #065f46; margin-bottom: 18px;
        }
        .kop-logo {
            width: 70px; height: 70px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 26pt; font-weight: 900;
            background: radial-gradient(circle at 30% 25%, #fde68a, #d9a441);
            color: #03251f; box-shadow: inset 0 2px 4px rgba(255,255,255,.5);
        }
        .kop-info { text-align: center; }
        .kop-info .h1 { font-size: 13pt; font-weight: 900; color: #065f46; margin: 0; letter-spacing: .02em; }
        .kop-info .h2 { font-size: 11pt; font-weight: 700; margin: 2px 0; color: #16211c; }
        .kop-info .h3 { font-size: 9pt; color: #52705c; margin: 2px 0; }
        .kop-qr { text-align: center; font-size: 8pt; color: #7c9082; }
        .kop-qr .box {
            width: 70px; height: 70px; margin: 0 auto 4px;
            border: 1.5px solid #d9a441; border-radius: 6px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            font-size: 7.5pt; font-weight: 700; color: #065f46;
            background: #f6fcf7; line-height: 1.2;
        }
        .kop-qr .box b { font-size: 14pt; color: #d9a441; }

        /* HEADER DOSEN */
        .cv-head { text-align: center; margin-bottom: 20px; }
        .cv-head h1 {
            font-size: 20pt; font-weight: 900; color: #065f46;
            margin: 0 0 6px; letter-spacing: .02em;
            font-family: Georgia, serif;
        }
        .cv-head .sub { font-size: 13pt; color: #16211c; margin: 0 0 8px; font-weight: 700; }
        .cv-head .badge {
            display: inline-block; margin-top: 6px; padding: 5px 16px;
            border-radius: 999px; font-size: 9.5pt; font-weight: 800;
            background: #eef8f1; border: 1px solid #a4cdb4; color: #047857;
        }

        /* STATS TIMELINE */
        .cv-stats {
            display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px;
            margin-bottom: 22px; page-break-inside: avoid;
        }
        .cv-stat {
            padding: 14px 8px; text-align: center;
            border: 1px solid #a4cdb4; border-radius: 10px;
            background: linear-gradient(180deg, #f6fcf7, #eef8f1);
            position: relative;
        }
        .cv-stat::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 3px; background: linear-gradient(90deg, #065f46, #10b981, #f2c063);
            border-radius: 10px 10px 0 0;
        }
        .cv-stat b { display: block; font-size: 20pt; font-weight: 900; color: #065f46; line-height: 1; }
        .cv-stat span {
            display: block; font-size: 7.5pt; font-weight: 800;
            text-transform: uppercase; letter-spacing: .08em;
            color: #52705c; margin-top: 5px;
        }

        /* SECTION */
        .cv-sec { margin-bottom: 18px; page-break-inside: avoid; }
        .cv-sec h2 {
            font-size: 12pt; font-weight: 900; color: #065f46;
            margin: 0 0 10px; padding: 6px 12px;
            background: linear-gradient(90deg, #eef8f1, transparent);
            border-left: 4px solid #d9a441;
            letter-spacing: .02em;
            display: flex; align-items: center; gap: 8px;
        }
        .cv-sec h2 .count {
            margin-left: auto; padding: 2px 10px; border-radius: 999px;
            background: #d9a441; color: #03251f; font-size: 9pt; font-weight: 900;
        }
        .cv-list { list-style: none; margin: 0; padding: 0; }
        .cv-list li {
            padding: 9px 0 9px 18px; border-bottom: 1px dashed #cfe0d5;
            font-size: 10pt; position: relative;
        }
        .cv-list li:last-child { border-bottom: none; }
        .cv-list li::before {
            content: ''; position: absolute; left: 0; top: 14px;
            width: 8px; height: 8px; border-radius: 50%;
            background: radial-gradient(circle, #10b981, #059669);
            box-shadow: 0 0 0 2px rgba(16,185,129,.2);
        }
        .cv-list .t { font-weight: 700; color: #16211c; }
        .cv-list .m { font-size: 9pt; color: #52705c; margin-top: 2px; }
        .cv-list .doi {
            display: inline-block; margin-top: 3px; padding: 1px 8px;
            background: rgba(217,164,65,.12); color: #7c2d12;
            border-radius: 999px; font-size: 8pt; font-weight: 800;
            border: 1px solid rgba(217,164,65,.3);
        }
        .cv-empty {
            font-style: italic; color: #7c9082; padding: 8px 0 8px 18px;
            position: relative;
        }
        .cv-empty::before {
            content: '○'; position: absolute; left: 0; top: 8px;
            color: #cfe0d5; font-size: 14pt;
        }

        /* TANDA TANGAN */
        .cv-sig {
            margin-top: 40px; display: flex; justify-content: space-around;
            page-break-inside: avoid; padding: 0 20px;
        }
        .cv-sig div { text-align: center; width: 230px; font-size: 10.5pt; }
        .cv-sig .place { font-style: italic; color: #52705c; margin: 0 0 4px; }
        .cv-sig .role { font-weight: 700; color: #16211c; margin: 0 0 4px; }
        .cv-sig .space { height: 60px; }
        .cv-sig .line { border-top: 1.5px solid #16211c; margin: 0 15px; }
        .cv-sig .name {
            font-weight: 800; margin-top: 4px; color: #065f46;
            text-decoration: underline; text-decoration-color: #d9a441;
            text-decoration-thickness: 1.5px; text-underline-offset: 3px;
        }
        .cv-sig .nid { font-size: 9pt; color: #52705c; margin-top: 2px; }

        /* FOOTER */
        .cv-foot {
            margin-top: 30px; padding-top: 12px; border-top: 2px solid #d9a441;
            text-align: center; font-size: 8pt; color: #7c9082;
            display: flex; justify-content: space-between; align-items: center;
            gap: 10px; flex-wrap: wrap;
        }
        .cv-foot .verify {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 10px; background: #f6fcf7; border: 1px solid #a4cdb4;
            border-radius: 999px; color: #047857; font-weight: 800;
        }
        .cv-foot .verify::before {
            content: '✓'; width: 14px; height: 14px; border-radius: 50%;
            background: #10b981; color: #fff; font-size: 8pt;
            display: flex; align-items: center; justify-content: center;
            font-weight: 900;
        }

        /* PRINT */
        @media print {
            body { background: #fff; }
            .cv-toolbar { display: none; }
            .sheet { box-shadow: none; padding: 0; margin: 0; max-width: none; }
            .cv-cover { margin: 0; }
            .sheet::before { display: none; }
        }
    </style>
</head>
<body>

<div class="cv-toolbar">
    <button class="back" onclick="history.back()">← Kembali</button>
    <button class="print" onclick="window.print()">🖨️ Print / Save PDF</button>
</div>

<div class="sheet">

    <!-- ================== COVER PAGE ================== -->
    <div class="cv-cover">
        <div class="emblem">LP</div>
        <div class="lbl">Curriculum Vitae Akademik</div>
        <h1>REKAM JEJAK<br>KEILMUAN</h1>
        <div class="who"><?= e($user['name']) ?></div>
        <?php if (!empty($user['nidn'])): ?>
        <div class="nidn">NIDN · <?= e($user['nidn']) ?></div>
        <?php endif; ?>
        <div class="meta">
            <b><?= e($siteName) ?></b><br>
            Universitas Muhammadiyah Maumere<br>
            Dokumen diterbitkan otomatis pada<br>
            <b><?= e($cvDate) ?> · <?= e($cvTime) ?> WITA</b>
        </div>
    </div>

    <!-- ================== KOP ================== -->
    <div class="kop">
        <div class="kop-logo">LP</div>
        <div class="kop-info">
            <div class="h1">LEMBAGA PENELITIAN, PENGABDIAN KEPADA MASYARAKAT</div>
            <div class="h2">DAN AL-ISLAM KEMUHAMMADIYAHAN (LP3M-LPPAIK)</div>
            <div class="h3">UNIVERSITAS MUHAMMADIYAH MAUMERE</div>
            <div class="h3">Jl. Wairklau, Maumere, Sikka, NTT · lp3m@unimof.ac.id</div>
        </div>
        <div class="kop-qr">
            <div class="box">
                <b>CV</b>
                ONLINE
            </div>
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
        <h2>A. PENELITIAN <span class="count"><?= (int) $stats['total_researches'] ?></span></h2>
        <?php if (empty($researches)): ?>
        <div class="cv-empty">Belum ada data penelitian tercatat.</div>
        <?php else: ?>
        <ul class="cv-list">
            <?php foreach ($researches as $r): ?>
            <li>
                <div class="t"><?= e($r['title']) ?></div>
                <div class="m">
                    Tahun <?= (int) ($r['year'] ?? date('Y')) ?> ·
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
        <h2>B. PUBLIKASI ILMIAH <span class="count"><?= (int) $stats['total_publications'] ?></span></h2>
        <?php if (empty($publications)): ?>
        <div class="cv-empty">Belum ada data publikasi tercatat.</div>
        <?php else: ?>
        <ul class="cv-list">
            <?php foreach ($publications as $p): ?>
            <li>
                <div class="t"><?= e($p['title']) ?></div>
                <div class="m">
                    Tahun <?= (int) ($p['year'] ?? date('Y')) ?>
                    <?= !empty($p['journal']) ? ' · ' . e($p['journal']) : '' ?>
                    <?= !empty($p['volume']) ? ', Vol. ' . e($p['volume']) : '' ?>
                    <?= !empty($p['issue']) ? ' No. ' . e($p['issue']) : '' ?>
                    <?= !empty($p['page']) ? ', hal. ' . e($p['page']) : '' ?>
                </div>
                <?php if (!empty($p['doi'])): ?>
                <div class="doi">DOI: <?= e($p['doi']) ?></div>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>

    <!-- HAKI -->
    <div class="cv-sec">
        <h2>C. HAK KEKAYAAN INTELEKTUAL <span class="count"><?= (int) $stats['total_haki'] ?></span></h2>
        <?php if (empty($haki)): ?>
        <div class="cv-empty">Belum ada data HAKI tercatat.</div>
        <?php else: ?>
        <ul class="cv-list">
            <?php foreach ($haki as $h): ?>
            <li>
                <div class="t"><?= e($h['title']) ?></div>
                <div class="m">
                    Tahun <?= (int) ($h['year'] ?? date('Y')) ?> ·
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
        <h2>D. PENGABDIAN KEPADA MASYARAKAT <span class="count"><?= (int) $stats['total_cs'] ?></span></h2>
        <?php if (empty($cs)): ?>
        <div class="cv-empty">Belum ada data pengabdian tercatat.</div>
        <?php else: ?>
        <ul class="cv-list">
            <?php foreach ($cs as $c): ?>
            <li>
                <div class="t"><?= e($c['title']) ?></div>
                <div class="m">
                    Tahun <?= (int) ($c['year'] ?? date('Y')) ?> ·
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
            <p class="place">Maumere, <?= e($cvDate) ?></p>
            <p class="role">Yang bersangkutan,</p>
            <div class="space"></div>
            <div class="line"></div>
            <p class="name"><?= e($user['name']) ?></p>
            <p class="nid">
                <?= !empty($user['nidn']) ? 'NIDN. ' . e($user['nidn']) : 'NIP/NIDN. ....................' ?>
            </p>
        </div>
        <div>
            <p class="place">Maumere, <?= e($cvDate) ?></p>
            <p class="role">Mengetahui,<br>Ketua LP3M-LPPAIK</p>
            <div class="space"></div>
            <div class="line"></div>
            <p class="name">(..........................................)</p>
            <p class="nid">NIP/NIDN. ....................</p>
        </div>
    </div>

    <div class="cv-foot">
        <span>Dokumen ini dicetak otomatis dari sistem informasi <?= e($siteName) ?> pada <?= e($cvDate) ?> · <?= e($cvTime) ?> WITA</span>
        <span class="verify">Verifikasi online: lp3m.unimof.ac.id/dosen?id=<?= (int) $user['id'] ?></span>
    </div>

</div>

</body>
</html>