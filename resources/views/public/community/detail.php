<style>
    @keyframes cdFadeUp { from{opacity:0;transform:translateY(22px)} to{opacity:1;transform:none} }
    .cd-wrap { max-width:860px; margin:0 auto; }
    .cd-back { display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:700; color:#059669; text-decoration:none; margin-bottom:20px; padding:8px 16px; border-radius:999px; background:#fff; border:1px solid #e3ebe5; transition:all .25s; box-shadow:0 3px 10px rgba(0,0,0,.05); }
    .cd-back:hover { transform:translateX(-4px); color:#065f46; border-color:rgba(5,150,105,.3); box-shadow:0 6px 16px rgba(5,150,105,.15); }
    .cd-hero { position:relative; overflow:hidden; border-radius:26px; padding:44px 40px; margin-bottom:26px; color:#fff; background:linear-gradient(135deg,#064e3b 0%,#065f46 45%,#059669 100%); box-shadow:0 24px 60px rgba(6,78,59,.4); animation:cdFadeUp .6s cubic-bezier(.16,1,.3,1) both; }
    .cd-hero::before { content:''; position:absolute; inset:0; opacity:.5; background-image:repeating-linear-gradient(45deg,transparent,transparent 28px,rgba(253,230,138,.05) 28px,rgba(253,230,138,.05) 29px),repeating-linear-gradient(-45deg,transparent,transparent 28px,rgba(253,230,138,.05) 28px,rgba(253,230,138,.05) 29px); pointer-events:none; }
    .cd-badge { position:relative; z-index:2; display:inline-flex; padding:5px 14px; border-radius:999px; margin-bottom:16px; font-size:11px; font-weight:800; background:rgba(253,230,138,.16); border:1px solid rgba(253,230,138,.35); color:#fde68a; }
    .cd-title { position:relative; z-index:2; font-family:var(--font-display); font-size:clamp(26px,3.8vw,40px); font-weight:900; margin:0; line-height:1.18; letter-spacing:-.025em; }
    .cd-card { background:#fff; border:1px solid #e3ebe5; border-radius:24px; padding:38px; box-shadow:0 10px 30px rgba(0,0,0,.06); animation:cdFadeUp .6s cubic-bezier(.16,1,.3,1) .1s both; }
    .cd-label { display:flex; align-items:center; gap:10px; font-family:var(--font-display); font-size:15px; font-weight:900; color:#0f2419; margin:0 0 16px; padding-bottom:12px; border-bottom:1px dashed #e3ebe5; }
    .cd-label .dot { width:8px; height:8px; border-radius:50%; background:linear-gradient(135deg,#059669,#10b981); box-shadow:0 0 0 3px rgba(5,150,105,.15); }
    .cd-info { display:grid; grid-template-columns:repeat(2,1fr); gap:16px; margin-bottom:30px; }
    .cd-info .row { display:flex; flex-direction:column; gap:5px; padding:16px 18px; border-radius:14px; background:linear-gradient(145deg,#f6faf7,#eef6f1); border:1px solid #e3ebe5; }
    .cd-info .row.full { grid-column:1/-1; }
    .cd-info .k { font-size:10.5px; font-weight:800; text-transform:uppercase; letter-spacing:.08em; color:#5b7365; }
    .cd-info .v { font-size:14.5px; font-weight:700; color:#0f2419; line-height:1.5; }
    .cd-body { font-size:15.5px; line-height:1.9; color:#374151; white-space:pre-line; margin-bottom:30px; }
    .cd-aik { position:relative; overflow:hidden; padding:22px 24px; border-radius:18px; background:linear-gradient(135deg,rgba(124,58,237,.12),rgba(124,58,237,.04)); border:1px solid rgba(124,58,237,.35); }
    .cd-aik .k { font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:.1em; color:#5b21b6; margin-bottom:8px; }
    .cd-aik .v { font-size:15px; font-weight:700; color:#0f2419; line-height:1.6; }
    @media(max-width:600px){ .cd-card{padding:24px 20px;} .cd-hero{padding:32px 24px;} .cd-info{grid-template-columns:1fr;} }
</style>

<?php
$typeLabels = ['pengabdian'=>'Pengabdian Dosen','kkn'=>'KKN Mahasiswa','desa_binaan'=>'Desa Binaan'];
?>

<div class="cd-wrap">
    <a class="cd-back" href="<?= e(url('public/index.php?page=pengabdian')) ?>">← Kembali ke Pengabdian</a>

    <div class="cd-hero">
        <span class="cd-badge">🤝 <?= e($typeLabels[$item['type']] ?? $item['type']) ?></span>
        <h1 class="cd-title"><?= e($item['title']) ?></h1>
    </div>

    <div class="cd-card">
        <h2 class="cd-label"><span class="dot"></span>Informasi Kegiatan</h2>
        <div class="cd-info">
            <div class="row">
                <span class="k">👤 Ketua Pelaksana</span>
                <span class="v"><?= e($item['leader']) ?></span>
            </div>
            <div class="row">
                <span class="k">📅 Tahun</span>
                <span class="v"><?= (int)$item['year'] ?></span>
            </div>
            <div class="row">
                <span class="k">📍 Lokasi</span>
                <span class="v"><?= e($item['location']) ?></span>
            </div>
            <div class="row">
                <span class="k">🤝 Mitra</span>
                <span class="v"><?= e($item['partner'] ?: '—') ?></span>
            </div>
            <?php if (!empty($item['members'])): ?>
            <div class="row full">
                <span class="k">👥 Anggota Tim</span>
                <span class="v"><?= e($item['members']) ?></span>
            </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($item['description'])): ?>
            <h2 class="cd-label"><span class="dot"></span>Deskripsi Kegiatan</h2>
            <div class="cd-body"><?= e($item['description']) ?></div>
        <?php endif; ?>

        <?php if (!empty($item['aik_integration'])): ?>
            <h2 class="cd-label"><span class="dot"></span>Integrasi Al-Islam & Kemuhammadiyahan</h2>
            <div class="cd-aik">
                <div class="k">🕌 Nilai AIK dalam Kegiatan</div>
                <div class="v"><?= e($item['aik_integration']) ?></div>
            </div>
        <?php endif; ?>
    </div>
</div>