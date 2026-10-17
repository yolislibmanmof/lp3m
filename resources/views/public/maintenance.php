<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60">
    <title><?= e($title ?? 'Pemeliharaan Sistem') ?></title>
    <style>
        @keyframes mtSpin { to { transform: rotate(360deg); } }
        @keyframes mtSpinR { to { transform: rotate(-360deg); } }
        @keyframes mtFade { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:none} }
        @keyframes mtBar { 0%{left:-40%} 100%{left:110%} }
        @keyframes mtFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-14px)} }
        * { box-sizing: border-box; }
        body { margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center; font-family:'Segoe UI',Tahoma,sans-serif; color:#fff; background:linear-gradient(135deg,#031510 0%,#065f46 55%,#043b2c 100%); overflow:hidden; position:relative; }
        body::before { content:''; position:absolute; inset:0; background-image:repeating-linear-gradient(45deg,transparent,transparent 34px,rgba(217,164,65,.05) 34px,rgba(217,164,65,.05) 35px),repeating-linear-gradient(-45deg,transparent,transparent 34px,rgba(217,164,65,.05) 34px,rgba(217,164,65,.05) 35px); }
        .orb { position:absolute; border-radius:50%; filter:blur(6px); pointer-events:none; }
        .orb1 { width:340px; height:340px; top:-120px; left:-100px; background:radial-gradient(circle at 30% 30%,rgba(253,230,138,.28),transparent 70%); animation:mtFloat 9s ease-in-out infinite; }
        .orb2 { width:400px; height:400px; bottom:-160px; right:-120px; background:radial-gradient(circle at 70% 70%,rgba(110,231,183,.22),transparent 70%); animation:mtFloat 12s ease-in-out infinite reverse; }
        .wrap { position:relative; z-index:2; text-align:center; max-width:640px; padding:40px 26px; animation:mtFade .8s cubic-bezier(.16,1,.3,1) both; }
        .gears { position:relative; width:150px; height:110px; margin:0 auto 26px; }
        .gear { position:absolute; display:flex; align-items:center; justify-content:center; filter:drop-shadow(0 8px 18px rgba(0,0,0,.4)); }
        .gear.g1 { font-size:74px; left:6px; top:8px; animation:mtSpin 6s linear infinite; }
        .gear.g2 { font-size:46px; right:8px; top:38px; animation:mtSpinR 4s linear infinite; }
        .badge { display:inline-flex; align-items:center; gap:8px; padding:6px 16px; border-radius:999px; font-size:10.5px; font-weight:900; letter-spacing:.22em; text-transform:uppercase; background:rgba(253,230,138,.14); border:1px solid rgba(253,230,138,.4); color:#fde68a; margin-bottom:18px; }
        .badge i { width:8px; height:8px; border-radius:50%; background:#fde68a; box-shadow:0 0 10px rgba(253,230,138,.9); animation:mtFloat 2s ease-in-out infinite; }
        h1 { font-size:clamp(30px,6vw,52px); font-weight:900; letter-spacing:-.03em; margin:0 0 14px; line-height:1.1; }
        h1 em { font-style:normal; background:linear-gradient(135deg,#fde68a,#f2c063 60%,#d9a441); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
        p.msg { font-size:15.5px; line-height:1.75; color:rgba(255,255,255,.88); margin:0 auto 30px; max-width:520px; }
        .bar { position:relative; width:280px; max-width:80%; height:8px; margin:0 auto 14px; border-radius:999px; background:rgba(255,255,255,.12); overflow:hidden; }
        .bar i { position:absolute; top:0; height:100%; width:40%; border-radius:999px; background:linear-gradient(90deg,transparent,#fde68a,transparent); animation:mtBar 1.8s ease-in-out infinite; }
        .pct { font-size:11px; font-weight:800; letter-spacing:.18em; color:rgba(255,255,255,.6); text-transform:uppercase; margin-bottom:30px; }
        .chips { display:flex; gap:10px; justify-content:center; flex-wrap:wrap; }
        .chip { display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:999px; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.22); backdrop-filter:blur(8px); font-size:12.5px; font-weight:700; color:rgba(255,255,255,.9); text-decoration:none; transition:all .25s; }
        .chip:hover { background:rgba(253,230,138,.18); border-color:rgba(253,230,138,.5); color:#fde68a; transform:translateY(-2px); }
        .foot { margin-top:36px; font-size:10.5px; letter-spacing:.16em; text-transform:uppercase; color:rgba(255,255,255,.4); }
    </style>
</head>
<body>
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>
    <div class="wrap">
        <div class="gears" aria-hidden="true">
            <span class="gear g1">⚙️</span>
            <span class="gear g2">⚙️</span>
        </div>
        <span class="badge"><i></i> 503 · Service Unavailable</span>
        <h1>Sedang Dalam<br><em>Pemeliharaan Sistem</em></h1>
        <p class="msg"><?= e($message ?? '') ?></p>
        <div class="bar"><i></i></div>
        <div class="pct">Halaman akan memuat ulang otomatis setiap 60 detik</div>
        <div class="chips">
            <?php try { $ci = ContactInfo::get(); } catch (\Throwable $e) { $ci = []; } ?>
            <?php if (!empty($ci['email'])): ?><a class="chip" href="mailto:<?= e($ci['email']) ?>">✉️ <?= e($ci['email']) ?></a><?php endif; ?>
            <?php if (!empty($ci['phone'])): ?><a class="chip" href="tel:<?= e(preg_replace('/[^0-9+]/', '', $ci['phone'])) ?>">📞 <?= e($ci['phone']) ?></a><?php endif; ?>
            <span class="chip">🕒 <?= e($ci['office_hours'] ?? 'Senin–Jumat, 08.00–16.00 WITA') ?></span>
        </div>
        <div class="foot">LP3M · Fastabiqul Khairat</div>
    </div>
</body>
</html>