<style>
    @keyframes sbrPop { 0%{transform:scale(.5);opacity:0} 60%{transform:scale(1.08)} 100%{transform:scale(1);opacity:1} }
    @keyframes sbrShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes sbrFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }

    .sbr-wrap { max-width:580px; margin:60px auto; padding:0 20px; text-align:center; }
    .sbr-card { background:var(--surface); border:1px solid var(--border); border-radius:26px; padding:48px 36px; box-shadow:0 20px 50px rgba(3,37,31,.12); position:relative; overflow:hidden; }
    .sbr-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg, <?= $ok ? '#10b981,#059669,#6ee7b7' : '#f87171,#dc2626,#fca5a5' ?>); }
    .sbr-ico { width:88px; height:88px; margin:0 auto 22px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:42px; animation:sbrPop .6s cubic-bezier(.16,1,.3,1) both, sbrFloat 3s ease-in-out infinite 1s; position:relative; }
    .sbr-ico::before { content:''; position:absolute; top:10px; left:18px; width:28px; height:12px; border-radius:50%; background:rgba(255,255,255,.5); filter:blur(2px); }
    .sbr-ico.ok { background:linear-gradient(145deg,#6ee7b7,#059669); box-shadow:0 12px 30px rgba(16,185,129,.4), inset 0 -4px 6px rgba(0,0,0,.2); }
    .sbr-ico.err { background:linear-gradient(145deg,#fca5a5,#dc2626); box-shadow:0 12px 30px rgba(220,38,38,.4), inset 0 -4px 6px rgba(0,0,0,.2); }
    .sbr-card h1 { font-family:var(--font-display); font-size:26px; font-weight:900; color:var(--ink); margin:0 0 12px; letter-spacing:-.01em; }
    .sbr-card p { font-size:14px; color:var(--muted); line-height:1.75; margin:0 0 26px; }
    .sbr-card p b { color:var(--ink); }
    .sbr-email-hint { display:inline-flex; align-items:center; gap:10px; padding:12px 18px; border-radius:12px; background:rgba(14,165,233,.08); border:1px solid rgba(14,165,233,.3); color:#0369a1; font-size:12.5px; font-weight:700; margin-bottom:22px; }
    .sbr-actions { display:flex; gap:10px; justify-content:center; flex-wrap:wrap; }
    .sbr-btn { position:relative; overflow:hidden; display:inline-flex; align-items:center; gap:8px; padding:13px 26px; border-radius:13px; font-size:13.5px; font-weight:800; text-decoration:none; transition:all .25s; }
    .sbr-btn.gold { color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:0 6px 16px rgba(217,164,65,.35); }
    .sbr-btn.gold::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:sbrShine 3s ease-in-out infinite; }
    .sbr-btn.ghost { color:var(--muted); background:transparent; border:2px solid var(--border); }
    .sbr-btn:hover { transform:translateY(-2px); filter:brightness(1.05); }
</style>

<div class="sbr-wrap">
    <div class="sbr-card">
        <div class="sbr-ico <?= $ok ? 'ok' : 'err' ?>"><?= $ok ? '✅' : '⚠️' ?></div>
        <h1><?= $ok ? 'Berhasil Berlangganan!' : 'Oops!' ?></h1>
        <p><?= $message ?></p>

        <?php if ($ok && !empty($email)): ?>
        <div class="sbr-email-hint">
            <span style="font-size:18px;">📬</span>
            <span>Periksa inbox <strong><?= e($email) ?></strong> (termasuk folder Spam)</span>
        </div>
        <?php endif; ?>

        <div class="sbr-actions">
            <a class="sbr-btn gold" href="<?= e(url('public/index.php?page=home')) ?>">🏠 Kembali ke Beranda</a>
            <?php if ($ok): ?>
            <a class="sbr-btn ghost" href="<?= e(url('public/index.php?page=berita')) ?>">📰 Baca Berita</a>
            <?php endif; ?>
        </div>
    </div>
</div>