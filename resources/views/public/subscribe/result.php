<style>
    @keyframes sbrPop { 0%{transform:scale(.4);opacity:0} 60%{transform:scale(1.08)} 100%{transform:scale(1);opacity:1} }
    @keyframes sbrShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes sbrFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
    @keyframes sbrConfetti { 0%{transform:translateY(-10vh) rotate(0);opacity:1} 100%{transform:translateY(110vh) rotate(720deg);opacity:0} }
    @keyframes sbrPulse { 0%,100%{box-shadow:0 0 0 0 rgba(16,185,129,.4)} 50%{box-shadow:0 0 0 18px rgba(16,185,129,0)} }
    @keyframes sbrCheck { 0%{transform:scale(0) rotate(-180deg)} 60%{transform:scale(1.2) rotate(10deg)} 100%{transform:scale(1) rotate(0)} }
    @keyframes sbrFade { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:none} }

    .sbr-wrap { max-width:620px; margin:60px auto; padding:0 20px; text-align:center; position:relative; }

    /* CONFETTI */
    .sbr-confetti { position:fixed; inset:0; pointer-events:none; z-index:1; overflow:hidden; }
    .sbr-confetti i { position:absolute; top:-10%; width:10px; height:14px; border-radius:2px; animation:sbrConfetti 3.5s ease-in forwards; }
    .sbr-confetti i:nth-child(1){ left:5%; background:#10b981; animation-delay:0s }
    .sbr-confetti i:nth-child(2){ left:15%; background:#fde68a; animation-delay:.2s; transform:rotate(20deg) }
    .sbr-confetti i:nth-child(3){ left:25%; background:#8b5cf6; animation-delay:.4s }
    .sbr-confetti i:nth-child(4){ left:35%; background:#f87171; animation-delay:.1s; transform:rotate(-30deg) }
    .sbr-confetti i:nth-child(5){ left:50%; background:#10b981; animation-delay:.3s }
    .sbr-confetti i:nth-child(6){ left:65%; background:#fde68a; animation-delay:.5s; transform:rotate(45deg) }
    .sbr-confetti i:nth-child(7){ left:75%; background:#8b5cf6; animation-delay:.15s }
    .sbr-confetti i:nth-child(8){ left:85%; background:#f87171; animation-delay:.35s; transform:rotate(-20deg) }
    .sbr-confetti i:nth-child(9){ left:95%; background:#10b981; animation-delay:.25s }
    .sbr-confetti i:nth-child(10){ left:45%; background:#fde68a; animation-delay:.6s }

    .sbr-card { background:var(--surface); border:1px solid var(--border); border-radius:28px; padding:52px 40px; box-shadow:0 24px 60px rgba(3,37,31,.14); position:relative; overflow:hidden; animation:sbrFade .6s both; }
    .sbr-card::before { content:''; position:absolute; top:0; left:0; right:0; height:5px; background:linear-gradient(90deg, <?= $ok ? '#10b981,#059669,#f2c063' : '#f87171,#dc2626,#fca5a5' ?>); }
    .sbr-card::after { content:''; position:absolute; top:-40%; right:-15%; width:260px; height:260px; border-radius:50%; background:radial-gradient(circle, <?= $ok ? 'rgba(16,185,129,.08)' : 'rgba(220,38,38,.06)' ?>, transparent 70%); pointer-events:none; }

    .sbr-ico { position:relative; width:96px; height:96px; margin:0 auto 24px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:44px; animation:sbrPop .7s cubic-bezier(.16,1,.3,1) both, sbrFloat 3.5s ease-in-out infinite 1s; z-index:2; }
    .sbr-ico::before { content:''; position:absolute; top:10px; left:20px; width:30px; height:14px; border-radius:50%; background:rgba(255,255,255,.55); filter:blur(2px); }
    .sbr-ico.ok { background:linear-gradient(145deg,#6ee7b7,#059669); box-shadow:0 14px 36px rgba(16,185,129,.45), inset 0 -5px 7px rgba(0,0,0,.2); animation:sbrPop .7s cubic-bezier(.16,1,.3,1) both, sbrFloat 3.5s ease-in-out infinite 1s, sbrPulse 2.5s ease-in-out infinite 1.5s; }
    .sbr-ico.err { background:linear-gradient(145deg,#fca5a5,#dc2626); box-shadow:0 14px 36px rgba(220,38,38,.45), inset 0 -5px 7px rgba(0,0,0,.2); }
    .sbr-ico .check { display:inline-block; animation:sbrCheck .6s cubic-bezier(.34,1.56,.64,1) .3s both; }

    .sbr-badge { display:inline-flex; align-items:center; gap:7px; padding:5px 14px; border-radius:999px; font-size:10px; font-weight:900; letter-spacing:.15em; text-transform:uppercase; background:rgba(16,185,129,.12); color:#047857; border:1px solid rgba(16,185,129,.3); margin-bottom:14px; position:relative; z-index:2; }
    .sbr-badge i { width:7px; height:7px; border-radius:50%; background:#10b981; box-shadow:0 0 8px #10b981; }
    .sbr-badge.err { background:rgba(220,38,38,.1); color:#991b1b; border-color:rgba(220,38,38,.3); }
    .sbr-badge.err i { background:#dc2626; box-shadow:0 0 8px #dc2626; }

    .sbr-card h1 { font-family:var(--font-display); font-size:28px; font-weight:900; color:var(--ink); margin:0 0 12px; letter-spacing:-.01em; position:relative; z-index:2; }
    .sbr-card > p { font-size:14.5px; color:var(--muted); line-height:1.75; margin:0 0 26px; position:relative; z-index:2; }
    .sbr-card > p b { color:var(--ink); }

    .sbr-email-hint { display:flex; align-items:center; gap:12px; padding:14px 20px; border-radius:14px; background:linear-gradient(135deg,rgba(14,165,233,.08),rgba(59,130,246,.05)); border:1px solid rgba(14,165,233,.3); color:#0369a1; font-size:13px; font-weight:700; margin-bottom:22px; text-align:left; position:relative; z-index:2; }
    .sbr-email-hint .em-ico { font-size:22px; flex-shrink:0; }

    .sbr-share { display:flex; gap:8px; justify-content:center; flex-wrap:wrap; padding:16px; border-radius:16px; background:rgba(124,58,237,.04); border:1px dashed rgba(124,58,237,.25); margin-bottom:22px; position:relative; z-index:2; }
    .sbr-share-lbl { display:block; font-size:11px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; color:var(--muted); margin-bottom:10px; }
    .sbr-share a { padding:8px 14px; border-radius:999px; background:var(--surface); border:1px solid var(--border); color:var(--text); font-size:12px; font-weight:800; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:6px; }
    .sbr-share a:hover { transform:translateY(-2px); border-color:rgba(124,58,237,.4); color:#6d28d9; }

    .sbr-actions { display:flex; gap:10px; justify-content:center; flex-wrap:wrap; position:relative; z-index:2; }
    .sbr-btn { position:relative; overflow:hidden; display:inline-flex; align-items:center; gap:8px; padding:14px 28px; border-radius:13px; font-size:13.5px; font-weight:800; text-decoration:none; transition:all .25s; }
    .sbr-btn.gold { color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:0 8px 20px rgba(217,164,65,.35); }
    .sbr-btn.gold::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:sbrShine 3s ease-in-out infinite; }
    .sbr-btn.ghost { color:var(--muted); background:transparent; border:2px solid var(--border); }
    .sbr-btn:hover { transform:translateY(-2px); filter:brightness(1.05); }

    .sbr-countdown { font-size:11px; color:var(--muted); margin-top:16px; position:relative; z-index:2; }
    .sbr-countdown b { color:#047857; font-family:var(--font-display); font-size:13px; }
</style>

<?php if ($ok): ?>
<div class="sbr-confetti" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div>
<?php endif; ?>

<div class="sbr-wrap">
    <div class="sbr-card">
        <div class="sbr-ico <?= $ok ? 'ok' : 'err' ?>">
            <span class="check"><?= $ok ? '✅' : '⚠️' ?></span>
        </div>

        <?php if ($ok): ?>
            <span class="sbr-badge"><i></i> Subscriber Aktif</span>
        <?php else: ?>
            <span class="sbr-badge err"><i></i> Diperlukan Perhatian</span>
        <?php endif; ?>

        <h1><?= $ok ? 'Selamat Bergabung! 🎉' : 'Oops! Ada Masalah' ?></h1>
        <p><?= $message ?></p>

        <?php if ($ok && !empty($email)): ?>
        <div class="sbr-email-hint">
            <span class="em-ico">📬</span>
            <div>
                <div>Email sambutan sudah dikirim ke <strong><?= e($email) ?></strong></div>
                <div style="font-size:11px; font-weight:600; opacity:.8; margin-top:2px;">💡 Cek juga folder <strong>Spam</strong> atau <strong>Promotions</strong></div>
            </div>
        </div>

        <div class="sbr-share">
            <span class="sbr-share-lbl">Ajak rekan civitas berlangganan juga:</span>
            <a href="https://wa.me/?text=<?= urlencode('Berlangganan newsletter LP3M UNIMOF untuk info hibah, publikasi & kegiatan terbaru: ' . url('public/index.php?page=home')) ?>" target="_blank" rel="noopener">💬 WhatsApp</a>
            <a href="https://twitter.com/intent/tweet?text=<?= urlencode('Berlangganan newsletter LP3M UNIMOF — ') ?>&url=<?= urlencode(url('public/index.php?page=home')) ?>" target="_blank" rel="noopener">🐦 Twitter</a>
            <button type="button" onclick="(async()=>{try{await navigator.clipboard.writeText('<?= e(url('public/index.php?page=home')) ?>');this.textContent=\'✅ Tersalin!\';setTimeout(()=>this.textContent=\'🔗 Salin Link\',1500)}catch(e){}})()" style="padding:8px 14px; border-radius:999px; background:var(--surface); border:1px solid var(--border); color:var(--text); font-size:12px; font-weight:800; cursor:pointer;">🔗 Salin Link</button>
        </div>
        <?php endif; ?>

        <div class="sbr-actions">
            <a class="sbr-btn gold" href="<?= e(url('public/index.php?page=home')) ?>">🏠 Kembali ke Beranda</a>
            <?php if ($ok): ?>
            <a class="sbr-btn ghost" href="<?= e(url('public/index.php?page=berita')) ?>">📰 Baca Berita Terbaru</a>
            <?php else: ?>
            <a class="sbr-btn ghost" href="javascript:history.back()">← Coba Lagi</a>
            <?php endif; ?>
        </div>

        <?php if ($ok): ?>
        <div class="sbr-countdown">
            Auto-redirect ke beranda dalam <b id="sbrCD">10</b> detik...
            <a href="<?= e(url('public/index.php?page=home')) ?>" style="color:var(--muted); margin-left:8px;">Batalkan</a>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if ($ok): ?>
<script>
(function(){
    var el = document.getElementById('sbrCD');
    var cd = 10;
    var iv = setInterval(function(){
        cd--;
        if (el) el.textContent = cd;
        if (cd <= 0) { clearInterval(iv); location.href = '<?= e(url('public/index.php?page=home')) ?>'; }
    }, 1000);
    document.addEventListener('click', function(){ clearInterval(iv); if (el) el.parentElement.style.display = 'none'; }, { once:true });
})();
</script>
<?php endif; ?>