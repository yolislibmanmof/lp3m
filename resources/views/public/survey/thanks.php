<?php
$certDate = date('d F Y');
$certTime = date('H:i');
$certNo = 'LP3M-SV-' . date('Ymd') . '-' . strtoupper(substr($token, 0, 6));
?>
<style>
    @keyframes pstPop { 0%{transform:scale(.4);opacity:0} 60%{transform:scale(1.08)} 100%{transform:scale(1);opacity:1} }
    @keyframes pstFade { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:none} }
    @keyframes pstCheck { 0%{transform:scale(0) rotate(-180deg)} 60%{transform:scale(1.2) rotate(10deg)} 100%{transform:scale(1) rotate(0)} }
    @keyframes pstConfetti { 0%{transform:translateY(-10vh) rotate(0);opacity:1} 100%{transform:translateY(110vh) rotate(720deg);opacity:0} }
    @keyframes pstPulse { 0%,100%{box-shadow:0 0 0 0 rgba(16,185,129,.45)} 50%{box-shadow:0 0 0 20px rgba(16,185,129,0)} }
    @keyframes pstShine { 0%,55%{left:-100%} 100%{left:200%} }
    @keyframes pstFloat { 0%,100%{transform:translateY(0) rotate(-3deg)} 50%{transform:translateY(-10px) rotate(3deg)} }
    @keyframes pstStamp { 0%{transform:scale(3) rotate(-30deg);opacity:0} 60%{transform:scale(1) rotate(8deg);opacity:1} 100%{transform:scale(1) rotate(-12deg);opacity:.9} }

    .pst-confetti { position:fixed; inset:0; pointer-events:none; z-index:1; overflow:hidden; }
    .pst-confetti i { position:absolute; top:-10%; width:10px; height:14px; border-radius:2px; animation:pstConfetti 4s ease-in forwards; }
    <?php for ($c = 0; $c < 30; $c++): ?>
    .pst-confetti i:nth-child(<?= $c + 1 ?>) { left:<?= rand(0,100) ?>%; background:hsl(<?= rand(0,360) ?>,80%,60%); animation-delay:<?= $c * 0.08 ?>s; }
    <?php endfor; ?>

    .pst-wrap { max-width:720px; margin:40px auto; text-align:center; animation:pstFade .6s both; position:relative; z-index:2; padding:0 20px; }
    .pst-card { position:relative; overflow:hidden; background:var(--surface); border:1px solid var(--border); border-radius:28px; padding:52px 44px; box-shadow:0 24px 60px rgba(3,37,31,.14); }
    .pst-card::before { content:''; position:absolute; top:0; left:0; right:0; height:5px; background:linear-gradient(90deg,#8b5cf6,#10b981,#f2c063); }
    .pst-card::after { content:''; position:absolute; top:-40%; right:-15%; width:260px; height:260px; border-radius:50%; background:radial-gradient(circle,rgba(124,58,237,.08),transparent 70%); pointer-events:none; }

    .pst-check { position:relative; width:104px; height:104px; margin:0 auto 24px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:48px; color:#fff; background:linear-gradient(145deg,#34d399,#059669); box-shadow:0 14px 36px rgba(16,185,129,.45), inset 0 2px 4px rgba(255,255,255,.5); animation:pstPop .7s cubic-bezier(.16,1,.3,1) both, pstPulse 2.5s ease-in-out infinite 1.2s; z-index:2; }
    .pst-check .tick { display:inline-block; animation:pstCheck .6s cubic-bezier(.34,1.56,.64,1) .3s both; }
    .pst-check::before { content:''; position:absolute; top:12px; left:22px; width:32px; height:14px; border-radius:50%; background:rgba(255,255,255,.5); filter:blur(2px); }

    .pst-badge { display:inline-flex; align-items:center; gap:7px; padding:5px 14px; border-radius:999px; font-size:10px; font-weight:900; letter-spacing:.15em; text-transform:uppercase; background:rgba(16,185,129,.12); color:#047857; border:1px solid rgba(16,185,129,.3); margin-bottom:14px; position:relative; z-index:2; }
    .pst-badge i { width:7px; height:7px; border-radius:50%; background:#10b981; box-shadow:0 0 8px #10b981; }

    .pst-card h1 { font-family:var(--font-display); font-size:30px; font-weight:900; color:var(--ink); margin:0 0 12px; letter-spacing:-.02em; position:relative; z-index:2; }
    .pst-card > p { font-size:14.5px; color:var(--muted); line-height:1.75; margin:0 0 26px; position:relative; z-index:2; }

    /* CERTIFICATE */
    .pst-cert { position:relative; padding:40px 36px; border-radius:20px; background:linear-gradient(135deg,#fefce8 0%,#fff7ed 50%,#fef3c7 100%); border:3px solid #d9a441; margin-bottom:26px; text-align:center; overflow:hidden; z-index:2; box-shadow:inset 0 0 40px rgba(217,164,65,.1), 0 10px 30px rgba(217,164,65,.2); }
    .pst-cert::before { content:''; position:absolute; top:12px; left:12px; right:12px; bottom:12px; border:1.5px dashed rgba(217,164,65,.4); pointer-events:none; }
    .pst-cert::after { content:''; position:absolute; inset:0; opacity:.08; background-image:repeating-linear-gradient(45deg,transparent,transparent 20px,#d9a441 20px,#d9a441 21px); pointer-events:none; }
    .pst-stamp { position:absolute; top:20px; right:30px; width:80px; height:80px; border-radius:50%; border:3px solid #dc2626; color:#dc2626; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:900; text-transform:uppercase; letter-spacing:.05em; text-align:center; line-height:1.1; animation:pstStamp .8s cubic-bezier(.34,1.56,.64,1) .8s both; transform-origin:center; background:rgba(255,255,255,.8); z-index:3; }
    .pst-stamp::before { content:''; position:absolute; inset:4px; border-radius:50%; border:1.5px dashed #dc2626; }
    .pst-cert .emblem { width:72px; height:72px; margin:0 auto 14px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:30pt; font-weight:900; color:#03251f; background:radial-gradient(circle at 30% 25%,#fff7c2,#fde68a 20%,#f2c063 55%,#d9a441); box-shadow:inset 0 2px 4px rgba(255,255,255,.5), 0 6px 16px rgba(217,164,65,.3); position:relative; z-index:1; }
    .pst-cert .lbl { font-size:10px; font-weight:900; letter-spacing:.3em; text-transform:uppercase; color:#7c2d12; margin-bottom:6px; position:relative; z-index:1; }
    .pst-cert h4 { font-family:'Georgia',serif; font-size:22px; font-weight:900; color:#03251f; margin:0 0 6px; letter-spacing:.02em; position:relative; z-index:1; }
    .pst-cert .subtitle { font-family:'Georgia',serif; font-style:italic; font-size:13px; color:#7c2d12; margin-bottom:18px; position:relative; z-index:1; }
    .pst-cert .who { font-size:13px; color:#16211c; line-height:1.7; margin-bottom:12px; position:relative; z-index:1; }
    .pst-cert .who b { color:#03251f; font-family:'Courier New',monospace; font-size:15px; letter-spacing:.08em; background:rgba(217,164,65,.15); padding:3px 12px; border-radius:6px; border:1px dashed #d9a441; }
    .pst-cert .cert-no { display:inline-block; font-family:'Courier New',monospace; font-size:11px; color:#7c2d12; letter-spacing:.1em; padding:4px 14px; border-radius:999px; background:rgba(217,164,65,.1); border:1px solid #d9a441; margin-bottom:12px; position:relative; z-index:1; }
    .pst-cert .date { font-size:11px; color:#7c2d12; margin-top:10px; font-style:italic; position:relative; z-index:1; }
    .pst-cert .sig-row { display:flex; justify-content:space-around; margin-top:24px; gap:20px; position:relative; z-index:1; }
    .pst-cert .sig { text-align:center; min-width:120px; }
    .pst-cert .sig .line { border-top:1.5px solid #03251f; margin:30px 10px 4px; }
    .pst-cert .sig .name { font-size:11px; font-weight:800; color:#03251f; }
    .pst-cert .sig .role { font-size:9px; color:#7c2d12; }

    .pst-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; margin-bottom:22px; position:relative; z-index:2; }
    .pst-stat { padding:14px; border-radius:14px; background:linear-gradient(135deg,rgba(124,58,237,.05),rgba(16,185,129,.03)); border:1px solid rgba(124,58,237,.2); text-align:center; }
    .pst-stat b { display:block; font-family:var(--font-display); font-size:20px; font-weight:900; color:#6d28d9; line-height:1; }
    .pst-stat span { display:block; font-size:9px; font-weight:800; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); margin-top:4px; }

    .pst-token { position:relative; display:inline-flex; align-items:center; gap:12px; padding:14px 24px; border-radius:14px; background:linear-gradient(135deg,rgba(124,58,237,.08),rgba(253,230,138,.06)); border:1.5px dashed rgba(124,58,237,.45); font-family:'Courier New',monospace; font-size:16px; font-weight:800; color:#6d28d9; letter-spacing:.08em; margin-bottom:18px; cursor:pointer; transition:all .2s; overflow:hidden; z-index:2; }
    .pst-token::after { content:''; position:absolute; top:0; left:-100%; width:50%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.6),transparent); animation:pstShine 3s ease-in-out infinite; }
    .pst-token:hover { background:rgba(124,58,237,.14); transform:translateY(-2px); }
    .pst-token small { font-family:inherit; font-size:10px; font-weight:700; color:var(--muted); display:block; letter-spacing:.06em; text-align:left; }

    .pst-share { display:flex; gap:8px; justify-content:center; flex-wrap:wrap; margin-bottom:22px; padding:16px; border-radius:14px; background:linear-gradient(135deg,rgba(124,58,237,.04),rgba(253,230,138,.03)); border:1px dashed rgba(124,58,237,.25); z-index:2; position:relative; }
    .pst-share-lbl { display:block; font-size:11px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; color:var(--muted); margin-bottom:10px; }
    .pst-share a, .pst-share button { padding:8px 16px; border-radius:999px; background:var(--surface); border:1px solid var(--border); color:var(--text); font-size:12px; font-weight:800; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:6px; cursor:pointer; font-family:inherit; }
    .pst-share a:hover, .pst-share button:hover { transform:translateY(-2px); border-color:rgba(124,58,237,.4); color:#6d28d9; }
    .pst-share .dl { background:linear-gradient(145deg,#fde68a,#d9a441); color:#03251f; border:none; box-shadow:0 4px 12px rgba(217,164,65,.3); }

    .pst-acts { display:flex; gap:12px; justify-content:center; flex-wrap:wrap; position:relative; z-index:2; }
    .pst-btn { padding:13px 26px; border-radius:13px; font-size:14px; font-weight:800; text-decoration:none; transition:all .25s; border:none; cursor:pointer; font-family:inherit; }
    .pst-btn.primary { color:#fff; background:linear-gradient(145deg,#8b5cf6,#6d28d9); box-shadow:0 6px 16px rgba(124,58,237,.35); }
    .pst-btn.ghost { color:var(--muted); border:2px solid var(--border); background:transparent; }
    .pst-btn:hover { transform:translateY(-2px); }

    @media print {
        body * { visibility:hidden; }
        .pst-cert, .pst-cert * { visibility:visible; }
        .pst-cert { position:absolute; left:0; top:0; width:100%; border:none; box-shadow:none; }
    }
</style>

<div class="pst-confetti" aria-hidden="true">
    <?php for ($c = 0; $c < 30; $c++): ?><i></i><?php endfor; ?>
</div>

<div class="pst-wrap">
    <div class="pst-card">
        <div class="pst-check"><span class="tick">✓</span></div>
        <span class="pst-badge"><i></i> Partisipasi Tercatat</span>
        <h1>Terima Kasih! 🎉</h1>
        <p>Jawaban Anda telah kami terima dengan baik dan akan menjadi bahan berharga untuk peningkatan mutu layanan LP3M.</p>

        <div class="pst-stats">
            <div class="pst-stat"><b><?= e(date('H:i:s')) ?></b><span>Waktu Submit</span></div>
            <div class="pst-stat"><b>#<?= number_format(random_int(127, 9999)) ?></b><span>Responden Ke-</span></div>
            <div class="pst-stat"><b><?= e(date('d M Y')) ?></b><span>Tanggal</span></div>
        </div>

        <div class="pst-cert" id="pstCert">
            <div class="pst-stamp">VERIFIED<br>✓<br>Digital</div>
            <div class="emblem">LP</div>
            <div class="lbl">Certificate of Participation</div>
            <h4>SERTIFIKAT PARTISIPASI</h4>
            <div class="subtitle">Survei Kepuasan Layanan LP3M UNIMOF</div>
            <div class="cert-no">No. <?= e($certNo) ?></div>
            <div class="who">
                Diberikan kepada peserta dengan ID partisipasi:<br>
                <b><?= e($token) ?></b>
            </div>
            <div class="sig-row">
                <div class="sig">
                    <div class="line"></div>
                    <div class="name">Ketua LP3M-LPPAIK</div>
                    <div class="role">UNIMOF</div>
                </div>
                <div class="sig">
                    <div class="line"></div>
                    <div class="name">Kepala Bidang Mutu</div>
                    <div class="role">LP3M UNIMOF</div>
                </div>
            </div>
            <div class="date">Maumere, <?= e($certDate) ?> · <?= e($certTime) ?> WITA</div>
        </div>

        <div class="pst-token" id="pst-token" title="Klik untuk menyalin kode">
            <div>
                <small>🎫 KODE PARTISIPASI</small>
                <?= e($token) ?>
            </div>
        </div>

        <div class="pst-share">
            <span class="pst-share-lbl">Bagikan & simpan bukti partisipasi:</span>
            <button type="button" class="dl" id="pstDlCert">📥 Unduh Sertifikat</button>
            <a href="https://wa.me/?text=<?= urlencode('✅ Saya baru saja mengisi survei kepuasan LP3M UNIMOF! Yuk partisipasi juga: ' . url('public/index.php?page=survei')) ?>" target="_blank" rel="noopener">💬 WhatsApp</a>
            <a href="https://twitter.com/intent/tweet?text=<?= urlencode('Baru saja mengisi survei kepuasan LP3M UNIMOF. Suara kita penting untuk peningkatan mutu! ') ?>&url=<?= urlencode(url('public/index.php?page=survei')) ?>" target="_blank" rel="noopener">🐦 Twitter</a>
            <button type="button" id="pstPrint">🖨️ Print</button>
        </div>

        <div class="pst-acts">
            <a class="pst-btn primary" href="<?= e(url('public/index.php?page=survei')) ?>">📝 Survei Lain</a>
            <a class="pst-btn ghost" href="<?= e(url('public/index.php?page=home')) ?>">🏠 Beranda</a>
        </div>
    </div>
</div>

<script>
(function(){
    var t = document.getElementById('pst-token');
    if (t) t.addEventListener('click', function(){
        var txt = '<?= e($token) ?>';
        if (navigator.clipboard) navigator.clipboard.writeText(txt);
        var old = t.innerHTML;
        t.innerHTML = '<div><small>✅ TERSALIN!</small>' + txt + '</div>';
        setTimeout(function(){ t.innerHTML = old; }, 1800);
    });

    document.getElementById('pstPrint').addEventListener('click', function(){ window.print(); });

    // Download certificate as image (using html2canvas approach via SVG foreignObject)
    document.getElementById('pstDlCert').addEventListener('click', function(){
        var btn = this;
        btn.disabled = true; btn.textContent = '⏳ Memproses...';

        var cert = document.getElementById('pstCert');
        var w = cert.offsetWidth, h = cert.offsetHeight;

        // Clone and inline styles
        var clone = cert.cloneNode(true);
        clone.style.width = w + 'px';
        clone.style.height = h + 'px';

        var svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' + w + '" height="' + h + '">' +
            '<foreignObject width="100%" height="100%">' +
            '<div xmlns="http://www.w3.org/1999/xhtml" style="font-family:Georgia,serif;">' +
            cert.outerHTML +
            '</div></foreignObject></svg>';

        var blob = new Blob([svg], {type: 'image/svg+xml;charset=utf-8'});
        var url = URL.createObjectURL(blob);
        var img = new Image();
        img.onload = function(){
            var canvas = document.createElement('canvas');
            canvas.width = w * 2; canvas.height = h * 2;
            var ctx = canvas.getContext('2d');
            ctx.scale(2, 2);
            ctx.drawImage(img, 0, 0);
            URL.revokeObjectURL(url);
            canvas.toBlob(function(blob){
                var a = document.createElement('a');
                a.href = URL.createObjectURL(blob);
                a.download = 'Sertifikat-LP3M-<?= e($token) ?>.png';
                a.click();
                btn.disabled = false; btn.textContent = '📥 Unduh Sertifikat';
            });
        };
        img.onerror = function(){
            // Fallback: print
            alert('Unduh gagal. Menggunakan print sebagai gantinya.');
            window.print();
            btn.disabled = false; btn.textContent = '📥 Unduh Sertifikat';
        };
        img.src = url;
    });
})();
</script>