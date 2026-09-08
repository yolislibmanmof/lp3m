<style>
    @keyframes verifyFadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:none} }
    @keyframes verifyPulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.05)} }
    @keyframes verifyShine { 0%{transform:translateX(-100%) skewX(-20deg)} 100%{transform:translateX(300%) skewX(-20deg)} }

    .verify-hero { position:relative; padding:60px 24px 50px; border-radius:28px; background:linear-gradient(135deg,#043b2c 0%,#065f46 55%,#059669 100%); color:#fff; text-align:center; overflow:hidden; box-shadow:0 20px 50px rgba(0,0,0,.35); margin-bottom:32px; }
    .verify-hero::before { content:''; position:absolute; inset:0; background-image:repeating-linear-gradient(45deg,transparent,transparent 30px,rgba(217,164,65,.05) 30px,rgba(217,164,65,.05) 31px),repeating-linear-gradient(-45deg,transparent,transparent 30px,rgba(217,164,65,.05) 30px,rgba(217,164,65,.05) 31px); }
    .verify-hero::after { content:''; position:absolute; top:-40%; right:-15%; width:350px; height:350px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.3),transparent 70%); pointer-events:none; }
    .verify-hero-ico { width:80px; height:80px; border-radius:24px; margin:0 auto 20px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.5),transparent 40%),linear-gradient(145deg,#fde68a,#f2c063 50%,#d9a441); display:flex; align-items:center; justify-content:center; font-size:38px; position:relative; box-shadow:inset 0 2px 3px rgba(255,255,255,.7),inset 0 -3px 4px rgba(0,0,0,.2),0 8px 20px rgba(217,164,65,.5); animation:verifyPulse 3s ease-in-out infinite; }
    .verify-hero-ico::before { content:''; position:absolute; top:8px; left:14px; width:22px; height:10px; border-radius:50%; background:rgba(255,255,255,.65); filter:blur(2px); }
    .verify-hero-title { font-family:var(--font-display); font-size:clamp(24px,4vw,32px); font-weight:900; letter-spacing:-.02em; margin:0 0 12px; position:relative; z-index:1; background:linear-gradient(135deg,#fff 0%,#fde68a 100%); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .verify-hero-sub { font-size:15px; opacity:.85; max-width:520px; margin:0 auto; line-height:1.6; position:relative; z-index:1; }

    .verify-form-box { background:var(--white); border:1px solid var(--border); border-radius:22px; padding:28px; margin-bottom:32px; box-shadow:0 6px 20px rgba(0,0,0,.06); }
    .verify-form-box form { display:flex; gap:12px; flex-wrap:wrap; }
    .verify-input { flex:1; min-width:240px; padding:14px 18px; border-radius:13px; border:2px solid var(--border); background:linear-gradient(145deg,#f6faf7,#fff); font-size:15px; font-weight:700; color:var(--ink); font-family:'Courier New',monospace; letter-spacing:.05em; transition:all .3s; }
    .verify-input:focus { outline:none; border-color:#059669; background:#fff; box-shadow:0 0 0 4px rgba(5,150,105,.12); }
    .verify-input::placeholder { color:var(--muted); font-weight:600; letter-spacing:0; font-family:inherit; }
    .verify-btn { padding:14px 28px; border-radius:13px; border:none; cursor:pointer; font-size:14px; font-weight:800; color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441); box-shadow:inset 0 2px 3px rgba(255,255,255,.7),inset 0 -2px 3px rgba(0,0,0,.15),0 6px 16px rgba(217,164,65,.4); transition:all .3s; position:relative; overflow:hidden; }
    .verify-btn::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:verifyShine 3s ease-in-out infinite; }
    .verify-btn:hover { transform:translateY(-2px); box-shadow:0 10px 24px rgba(217,164,65,.5); }

    .verify-result { animation:verifyFadeUp .6s ease-out both; }
    .verify-card { background:var(--white); border:1px solid var(--border); border-radius:24px; overflow:hidden; box-shadow:0 12px 36px rgba(0,0,0,.12); position:relative; }
    .verify-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,var(--gold-strong),var(--primary)); }

    .verify-header { padding:32px 28px 24px; background:linear-gradient(135deg,#043b2c,#065f46); color:#fff; position:relative; overflow:hidden; }
    .verify-header::before { content:''; position:absolute; inset:0; background-image:repeating-linear-gradient(45deg,transparent,transparent 25px,rgba(217,164,65,.04) 25px,rgba(217,164,65,.04) 26px); }
    .verify-header-ico { width:56px; height:56px; border-radius:16px; margin-bottom:16px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.5),transparent 40%),linear-gradient(145deg,#fde68a,#f2c063 50%,#d9a441); display:flex; align-items:center; justify-content:center; font-size:26px; position:relative; box-shadow:inset 0 2px 3px rgba(255,255,255,.7),inset 0 -3px 4px rgba(0,0,0,.2); }
    .verify-header-ico::before { content:''; position:absolute; top:5px; left:10px; width:16px; height:7px; border-radius:50%; background:rgba(255,255,255,.65); filter:blur(1.5px); }
    .verify-header-title { font-family:var(--font-display); font-size:20px; font-weight:900; margin:0 0 6px; position:relative; z-index:1; }
    .verify-header-sub { font-size:13px; opacity:.8; position:relative; z-index:1; }

    .verify-body { padding:28px; }
    .verify-row { display:flex; gap:16px; margin-bottom:20px; padding-bottom:20px; border-bottom:1px dashed var(--border); }
    .verify-row:last-child { border-bottom:none; margin-bottom:0; padding-bottom:0; }
    .verify-label { flex-shrink:0; width:140px; font-size:11px; font-weight:900; letter-spacing:.12em; text-transform:uppercase; color:var(--muted); padding-top:4px; }
    .verify-value { flex:1; min-width:0; }
    .verify-value-title { font-size:16px; font-weight:800; color:var(--ink); margin:0 0 4px; line-height:1.4; }
    .verify-value-sub { font-size:13px; color:var(--muted); margin:0; }
    .verify-code-box { font-family:'Courier New',monospace; font-size:15px; font-weight:900; color:#047857; background:rgba(5,150,105,.08); border:1px solid rgba(5,150,105,.25); padding:8px 14px; border-radius:10px; display:inline-block; letter-spacing:.08em; }

    .verify-status-badge { display:inline-flex; align-items:center; gap:8px; padding:8px 16px; border-radius:999px; font-size:13px; font-weight:800; letter-spacing:.05em; }
    .verify-status-valid { background:linear-gradient(145deg,#6ee7b7,#10b981); color:#064e3b; box-shadow:inset 0 1px 2px rgba(255,255,255,.6),0 4px 12px rgba(16,185,129,.3); }
    .verify-status-revoked { background:linear-gradient(145deg,#fca5a5,#dc2626); color:#fff; box-shadow:inset 0 1px 2px rgba(255,255,255,.4),0 4px 12px rgba(220,38,38,.3); }

    .verify-qr-section { margin-top:28px; padding:24px; background:linear-gradient(145deg,#f6faf7,#fff); border:1px solid var(--border); border-radius:16px; text-align:center; }
    .verify-qr-section-title { font-size:11px; font-weight:900; letter-spacing:.15em; text-transform:uppercase; color:var(--muted); margin-bottom:14px; }
    .verify-qr-box { display:inline-block; padding:16px; background:#fff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,.08); }
    .verify-qr-img { width:160px; height:160px; display:block; }
    .verify-qr-hint { font-size:11px; color:var(--muted); margin-top:12px; }

    .verify-error-box { padding:24px; background:linear-gradient(145deg,#fee2e2,#fecaca); border:1px solid rgba(220,38,38,.35); border-radius:16px; text-align:center; }
    .verify-error-ico { font-size:48px; margin-bottom:12px; }
    .verify-error-title { font-size:18px; font-weight:800; color:#991b1b; margin:0 0 8px; }
    .verify-error-msg { font-size:14px; color:#7f1d1d; margin:0; line-height:1.6; }

    .verify-actions { margin-top:28px; display:flex; gap:10px; flex-wrap:wrap; justify-content:center; }
    .verify-cta { padding:12px 22px; border-radius:12px; font-weight:700; font-size:14px; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all .3s; position:relative; overflow:hidden; }
    .verify-cta::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:verifyShine 3s ease-in-out infinite; }
    .verify-cta-primary { background:linear-gradient(145deg,#fde68a,#d9a441); color:#03251f; box-shadow:inset 0 2px 3px rgba(255,255,255,.7),inset 0 -2px 3px rgba(0,0,0,.15),0 6px 16px rgba(217,164,65,.4); }
    .verify-cta-ghost { background:transparent; color:var(--primary-dark); border:2px solid rgba(5,150,105,.35); }
    .verify-cta:hover { transform:translateY(-2px); }
</style>

<!-- ================= HERO ================= -->
<section class="verify-hero reveal">
    <div class="verify-hero-ico">🎓</div>
    <h1 class="verify-hero-title">Verifikasi Sertifikat Digital</h1>
    <p class="verify-hero-sub">
        Masukkan kode sertifikat untuk memverifikasi keaslian dan validitas sertifikat yang diterbitkan oleh LP3M/LPPAIK UNIMOF.
    </p>
</section>

<!-- ================= FORM VERIFIKASI ================= -->
<div class="verify-form-box reveal">
    <form method="get" action="<?= e(url('public/index.php')) ?>">
        <input type="hidden" name="page" value="verifikasi-sertifikat">
        <input type="text" name="code" class="verify-input"
               value="<?= e($code ?? '') ?>"
               placeholder="Masukkan kode sertifikat (contoh: LP3M-2026-A1B2C3)"
               autocomplete="off"
               autofocus>
        <button type="submit" class="verify-btn">🔍 Verifikasi</button>
    </form>
</div>

<!-- ================= HASIL VERIFIKASI ================= -->
<?php if (!empty($verifyError)): ?>
    <!-- ERROR: Kode tidak ditemukan -->
    <div class="verify-error-box verify-result reveal">
        <div class="verify-error-ico">❌</div>
        <h2 class="verify-error-title">Sertifikat Tidak Ditemukan</h2>
        <p class="verify-error-msg"><?= e($verifyError) ?></p>
    </div>
    <div class="verify-actions">
        <a href="<?= e(url('public/index.php?page=verifikasi-sertifikat')) ?>" class="verify-cta verify-cta-primary">🔄 Coba Lagi</a>
        <a href="<?= e(url('public/index.php?page=home')) ?>" class="verify-cta verify-cta-ghost">🏠 Beranda</a>
    </div>

<?php elseif ($cert !== null): ?>
    <!-- SUCCESS: Sertifikat ditemukan -->
    <div class="verify-card verify-result reveal">
        <div class="verify-header">
            <div class="verify-header-ico">🎓</div>
            <h2 class="verify-header-title">Sertifikat Ditemukan</h2>
            <p class="verify-header-sub">Verifikasi berhasil. Berikut detail sertifikat:</p>
        </div>

        <div class="verify-body">
            <!-- Status -->
            <div class="verify-row">
                <div class="verify-label">Status</div>
                <div class="verify-value">
                    <span class="verify-status-badge <?= $cert['status'] === 'valid' ? 'verify-status-valid' : 'verify-status-revoked' ?>">
                        <?= $cert['status'] === 'valid' ? '✅ VALID' : '🚫 DICABUT' ?>
                    </span>
                    <?php if ($cert['status'] === 'revoked' && !empty($cert['revoke_reason'])): ?>
                        <p style="font-size:12px; color:var(--muted); margin:8px 0 0;">Alasan pencabutan: <?= e($cert['revoke_reason']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Kode -->
            <div class="verify-row">
                <div class="verify-label">Kode Sertifikat</div>
                <div class="verify-value">
                    <span class="verify-code-box"><?= e($cert['code']) ?></span>
                </div>
            </div>

            <!-- Penerima -->
            <div class="verify-row">
                <div class="verify-label">Penerima</div>
                <div class="verify-value">
                    <p class="verify-value-title"><?= e($cert['holder_name']) ?></p>
                    <?php if (!empty($cert['holder_identity'])): ?>
                        <p class="verify-value-sub"><?= e($cert['holder_identity']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Kegiatan -->
            <div class="verify-row">
                <div class="verify-label">Kegiatan</div>
                <div class="verify-value">
                    <p class="verify-value-title"><?= e($cert['activity_title']) ?></p>
                    <p class="verify-value-sub"><?= e($types[$cert['activity_type']] ?? ucfirst($cert['activity_type'])) ?></p>
                </div>
            </div>

            <!-- Tanggal Terbit -->
            <div class="verify-row">
                <div class="verify-label">Tanggal Terbit</div>
                <div class="verify-value">
                    <p class="verify-value-title"><?= e(date('d F Y', strtotime($cert['issue_date']))) ?></p>
                </div>
            </div>

            <!-- Penandatangan -->
            <div class="verify-row">
                <div class="verify-label">Penandatangan</div>
                <div class="verify-value">
                    <p class="verify-value-title"><?= e($cert['signer_name']) ?></p>
                    <p class="verify-value-sub"><?= e($cert['signer_title']) ?></p>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="verify-qr-section">
                <div class="verify-qr-section-title">📱 Scan QR untuk Verifikasi Cepat</div>
                <div class="verify-qr-box">
                    <img class="verify-qr-img"
                         src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=<?= urlencode(url('public/index.php?page=verifikasi-sertifikat&code=' . urlencode($cert['code']))) ?>"
                         alt="QR Code Sertifikat <?= e($cert['code']) ?>">
                </div>
                <p class="verify-qr-hint">Scan dengan kamera HP atau aplikasi QR reader</p>
            </div>
        </div>
    </div>

    <div class="verify-actions">
        <a target="_blank" href="<?= e(url('public/index.php?page=sertifikat&code=' . urlencode($cert['code']))) ?>" class="verify-cta verify-cta-primary">🖨️ Cetak Sertifikat</a>
        <a href="<?= e(url('public/index.php?page=verifikasi-sertifikat')) ?>" class="verify-cta verify-cta-ghost">🔄 Verifikasi Lagi</a>
        <a href="<?= e(url('public/index.php?page=home')) ?>" class="verify-cta verify-cta-ghost">🏠 Beranda</a>
    </div>

<?php else: ?>
    <!-- INITIAL: Belum ada input -->
    <div style="text-align:center; padding:40px 20px; color:var(--muted); animation:verifyFadeUp .6s ease-out both;">
        <div style="font-size:48px; margin-bottom:16px;">🔍</div>
        <h3 style="font-size:18px; font-weight:800; color:var(--ink); margin:0 0 8px;">Masukkan Kode Sertifikat</h3>
        <p style="font-size:14px; margin:0; line-height:1.6;">
            Gunakan form di atas untuk memverifikasi keaslian sertifikat yang diterbitkan oleh LP3M/LPPAIK UNIMOF.
        </p>
    </div>
<?php endif; ?>

<!-- ================= INFO TAMBAHAN ================= -->
<section class="section reveal" style="margin-top:48px;">
    <div class="section-head">
        <h2>ℹ️ Informasi Verifikasi</h2>
    </div>
    <div style="background:var(--white); border:1px solid var(--border); border-radius:20px; padding:26px; box-shadow:0 6px 20px rgba(0,0,0,.04);">
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:20px;">
            <div>
                <div style="font-size:13px; font-weight:800; color:var(--primary-dark); margin-bottom:8px;">✅ Sertifikat Valid</div>
                <p style="font-size:13px; color:var(--muted); margin:0; line-height:1.6;">Sertifikat asli dan sah diterbitkan oleh LP3M/LPPAIK UNIMOF.</p>
            </div>
            <div>
                <div style="font-size:13px; font-weight:800; color:var(--primary-dark); margin-bottom:8px;">🚫 Sertifikat Dicabut</div>
                <p style="font-size:13px; color:var(--muted); margin:0; line-height:1.6;">Sertifikat telah dicabut dan tidak lagi berlaku.</p>
            </div>
            <div>
                <div style="font-size:13px; font-weight:800; color:var(--primary-dark); margin-bottom:8px;">❌ Tidak Ditemukan</div>
                <p style="font-size:13px; color:var(--muted); margin:0; line-height:1.6;">Kode tidak terdaftar. Periksa kembali atau hubungi admin.</p>
            </div>
        </div>
    </div>
</section>