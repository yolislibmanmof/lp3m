<style>
    @keyframes loginFloat1 { 0%,100%{transform:translate(0,0) rotate(0)} 50%{transform:translate(30px,-40px) rotate(180deg)} }
    @keyframes loginFloat2 { 0%,100%{transform:translate(0,0) rotate(0)} 50%{transform:translate(-40px,30px) rotate(-180deg)} }
    @keyframes loginFloat3 { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(20px,20px) scale(1.1)} }
    @keyframes loginPulse { 0%,100%{opacity:.6} 50%{opacity:1} }
    @keyframes loginShine { 0%{transform:translateX(-100%) skewX(-20deg)} 100%{transform:translateX(300%) skewX(-20deg)} }
    @keyframes loginFadeIn { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

    .login-page {
        min-height: 100vh;
        display: flex; align-items: center; justify-content: center;
        padding: 24px; position: relative; overflow: hidden;
        background: linear-gradient(135deg, #043b2c 0%, #065f46 50%, #059669 100%);
    }
    .login-page::before {
        content:''; position:absolute; inset:0;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(217,164,65,.04) 35px, rgba(217,164,65,.04) 36px),
            repeating-linear-gradient(-45deg, transparent, transparent 35px, rgba(217,164,65,.04) 35px, rgba(217,164,65,.04) 36px);
        pointer-events:none;
    }
    .login-orb-1{position:absolute;top:10%;left:15%;width:200px;height:200px;border-radius:50%;background:radial-gradient(circle at 30% 30%,rgba(253,230,138,.5),rgba(217,164,65,.2) 60%,transparent);filter:blur(3px);animation:loginFloat1 12s ease-in-out infinite;pointer-events:none;}
    .login-orb-2{position:absolute;bottom:15%;right:10%;width:260px;height:260px;border-radius:50%;background:radial-gradient(circle at 70% 70%,rgba(110,231,183,.4),rgba(16,185,129,.15) 60%,transparent);filter:blur(4px);animation:loginFloat2 15s ease-in-out infinite;pointer-events:none;}
    .login-orb-3{position:absolute;top:50%;right:25%;width:140px;height:140px;border-radius:50%;background:radial-gradient(circle at 30% 30%,rgba(167,139,250,.4),rgba(124,58,237,.15) 60%,transparent);filter:blur(2px);animation:loginFloat3 10s ease-in-out infinite;pointer-events:none;}

    /* ===== SATU-SATUNYA tombol Kembali ke Beranda (floating kiri-atas) ===== */
    .login-home-float {
        position: absolute; top: 20px; left: 20px; z-index: 5;
        display: inline-flex; align-items: center; gap: 8px;
        padding: 9px 16px; border-radius: 999px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.28);
        backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
        color: #fff; font-size: 12px; font-weight: 800;
        text-decoration: none;
        transition: all .25s cubic-bezier(0.16,1,0.3,1);
        box-shadow: inset 0 1px 2px rgba(255,255,255,.25), 0 4px 12px rgba(0,0,0,.25);
    }
    .login-home-float:hover {
        background: rgba(255,255,255,0.22);
        transform: translateY(-2px);
        box-shadow: inset 0 1px 2px rgba(255,255,255,.3), 0 8px 18px rgba(0,0,0,.3);
    }

    .login-box {
        position: relative; width: 100%; max-width: 440px;
        padding: 40px 40px 32px; border-radius: 28px;
        background: rgba(255,255,255,0.98);
        backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(217,164,65,0.3);
        box-shadow: 0 30px 80px rgba(0,0,0,.4), 0 15px 40px rgba(0,0,0,.25), inset 0 1px 0 rgba(255,255,255,.8);
        animation: loginFadeIn .6s cubic-bezier(0.16,1,0.3,1);
        z-index: 2;
    }
    .login-box::before { content:''; position:absolute; top:-50%; right:-20%; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.15),transparent 70%); pointer-events:none; }
    .login-box::after { content:''; position:absolute; bottom:-40%; left:-15%; width:240px; height:240px; border-radius:50%; background:radial-gradient(circle,rgba(16,185,129,.1),transparent 70%); pointer-events:none; }

    .login-brand-row { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; position: relative; z-index: 1; }
    .login-logo-3d {
        width: 52px; height: 52px; border-radius: 16px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display); font-weight: 900; font-size: 18px; color: #03251f;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.6), transparent 40%),
                    linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -3px 4px rgba(0,0,0,.2), 0 6px 14px rgba(217,164,65,.45);
        position: relative;
    }
    .login-logo-3d::before { content:''; position:absolute; top:5px; left:10px; width:16px; height:7px; border-radius:50%; background:rgba(255,255,255,.65); filter:blur(1.5px); }
    /* FIX: warna eksplisit gelap (var(--ink) tak terdefinisi di admin.css) */
    .login-brand-name {
        font-family: var(--font-display); font-size: 18px; font-weight: 900;
        letter-spacing: -.02em; color: #043b2c; line-height: 1.1;
    }
    .login-brand-badge {
        display: inline-block; margin-top: 4px; padding: 2px 9px; border-radius: 6px;
        font-size: 9px; font-weight: 900; letter-spacing: .18em; text-transform: uppercase;
        color: #03251f;
        background: linear-gradient(145deg, #fde68a, #d9a441);
        box-shadow: inset 0 1px 1px rgba(255,255,255,.7), inset 0 -1px 2px rgba(0,0,0,.15), 0 2px 5px rgba(217,164,65,.3);
    }

    .login-eyebrow {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 14px; border-radius: 999px;
        font-size: 10px; font-weight: 900; letter-spacing: .2em; text-transform: uppercase;
        color: #92400e;
        background: linear-gradient(145deg, #fde68a, #d9a441);
        box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.15), 0 3px 8px rgba(217,164,65,.35);
        margin-bottom: 16px; position: relative; overflow: hidden;
        animation: loginPulse 2s ease-in-out infinite;
    }
    .login-eyebrow::before { content:''; position:absolute; top:2px; left:6px; width:30%; height:40%; border-radius:50%; background:rgba(255,255,255,.6); filter:blur(1px); }

    .login-box h1 {
        font-family: var(--font-display); font-size: 30px; font-weight: 900;
        letter-spacing: -.02em; margin: 0 0 6px;
        background: linear-gradient(135deg, #043b2c 0%, #065f46 55%, #059669 100%);
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent;
        position: relative; z-index: 1;
    }
    .login-box .login-sub { font-size: 13.5px; color: #5b7365; margin: 0 0 24px; line-height: 1.6; position: relative; z-index: 1; }

    .alert-error {
        position: relative; padding: 13px 16px; margin-bottom: 20px; border-radius: 14px;
        background: linear-gradient(145deg, #fef2f2, #fee2e2);
        border: 1px solid rgba(220,38,38,.3); color: #991b1b;
        font-size: 13px; font-weight: 600;
        display: flex; align-items: center; gap: 10px;
        box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.05), 0 4px 12px rgba(220,38,38,.15);
    }
    .alert-error::before { content:'⚠️'; font-size: 18px; flex-shrink: 0; }

    .form-group { margin-bottom: 18px; position: relative; }
    /* FIX: label hijau tua agar terbaca di kartu putih */
    .form-group label {
        display: block; font-size: 11.5px; font-weight: 800; letter-spacing: .08em;
        text-transform: uppercase; color: #065f46; margin-bottom: 8px;
    }
    .form-group .input-wrap { position: relative; }
    .form-group .input-ico {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        font-size: 15px; pointer-events: none; opacity: .7;
    }
    .form-group input {
        width: 100%; padding: 14px 44px 14px 42px; border-radius: 14px;
        border: 2px solid #d9ebe2;
        background: linear-gradient(145deg, #f6faf7, #ffffff);
        font-size: 14px; font-weight: 600;
        color: #03251f !important;
        -webkit-text-fill-color: #03251f !important;
        color-scheme: light;
        transition: all .3s cubic-bezier(0.16,1,0.3,1);
        box-shadow: inset 0 2px 4px rgba(0,0,0,.04), inset 0 -1px 0 rgba(255,255,255,.8);
    }
    .form-group input:focus {
        outline: none; border-color: #059669; background: #fff;
        box-shadow: inset 0 2px 4px rgba(0,0,0,.06), 0 0 0 4px rgba(5,150,105,.12), 0 4px 12px rgba(5,150,105,.15);
    }
    .form-group input:-webkit-autofill,
    .form-group input:-webkit-autofill:hover,
    .form-group input:-webkit-autofill:focus,
    .form-group input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
        -webkit-text-fill-color: #03251f !important;
        caret-color: #03251f;
        transition: background-color 99999s ease-in-out 0s;
    }
    .form-group input::placeholder { color: #9ca3af !important; -webkit-text-fill-color: #9ca3af !important; font-weight: 500; }

    .btn-login {
        position: relative; width: 100%; padding: 15px; border: none; border-radius: 14px;
        font-size: 15px; font-weight: 800; letter-spacing: .02em; color: #03251f;
        background: linear-gradient(145deg, #fde68a, #f2c063 40%, #d9a441 80%, #a9761b);
        cursor: pointer; overflow: hidden;
        transition: all .3s cubic-bezier(0.16,1,0.3,1);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.15), 0 8px 20px rgba(217,164,65,.4);
        margin-top: 6px;
    }
    .btn-login::before { content:''; position:absolute; top:3px; left:10%; width:35%; height:35%; border-radius:50%; background:rgba(255,255,255,.6); filter:blur(2px); }
    .btn-login::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:loginShine 3s ease-in-out infinite; }
    .btn-login:hover { transform: translateY(-2px); box-shadow: inset 0 2px 3px rgba(255,255,255,.8), inset 0 -2px 3px rgba(0,0,0,.15), 0 14px 30px rgba(217,164,65,.55); }
    .btn-login:active { transform: translateY(0); }

    .login-foot {
        margin: 24px 0 0; padding-top: 18px; border-top: 1px solid #d9ebe2;
        font-size: 11.5px; text-align: center; color: #5b7365;
        position: relative; z-index: 1;
    }
    .login-foot strong {
        background: linear-gradient(135deg, #043b2c, #059669);
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent; font-weight: 800;
    }

    @media (max-width: 480px) {
        .login-box { padding: 32px 24px 26px; }
        .login-home-float { top: 12px; left: 12px; }
    }
</style>

<div class="login-page">
    <div class="login-orb-1"></div>
    <div class="login-orb-2"></div>
    <div class="login-orb-3"></div>

    <!-- SATU-SATUNYA tombol Kembali ke Beranda -->
    <a href="<?= e(url('public/index.php?page=home')) ?>" class="login-home-float">
        🏠 Kembali ke Beranda
    </a>

    <div class="login-box">
        <div class="login-brand-row">
            <div class="login-logo-3d">LP</div>
            <div>
                <div class="login-brand-name">LP3M</div>
                <span class="login-brand-badge">Admin Panel</span>
            </div>
        </div>

        <span class="login-eyebrow">✦ Elevate Edition</span>
        <h1>Login Admin</h1>
        <p class="login-sub">Masuk ke sistem LP3M</p>

        <?php if (!empty($error)): ?>
            <div class="alert-error"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= e(url('admin/index.php?page=login')) ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <span class="input-ico">📧</span>
                    <input type="email" id="email" name="email" value="<?= e(old('email')) ?>"
                           required autocomplete="email" placeholder="nama@unimof.ac.id">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <span class="input-ico">🔒</span>
                    <input type="password" id="password" name="password"
                           required autocomplete="current-password" placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="btn-login">Masuk →</button>
        </form>

        <p class="login-foot">
            &copy; <?= date('Y') ?> <strong>LP3M</strong> — Catur Dharma Berkemajuan.
        </p>
    </div>
</div>