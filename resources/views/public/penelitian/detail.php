<style>
    @keyframes rsdFadeUp { from{opacity:0;transform:translateY(22px)} to{opacity:1;transform:none} }
    @keyframes rsdFloat1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(26px,-30px)} }
    @keyframes rsdFloat2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-28px,24px)} }

    .rsd-wrap { max-width:880px; margin:0 auto; }

    /* ===== TOMBOL KEMBALI ===== */
    .rsd-back {
        display:inline-flex; align-items:center; gap:8px;
        font-size:13px; font-weight:700; color:var(--primary-dark); text-decoration:none;
        margin-bottom:20px; padding:8px 16px; border-radius:999px;
        background:var(--white); border:1px solid var(--border);
        transition:all .25s; box-shadow:0 3px 10px rgba(0,0,0,.05);
    }
    .rsd-back:hover { transform:translateX(-4px); color:#1d4ed8; border-color:rgba(29,78,216,.3); box-shadow:0 6px 16px rgba(29,78,216,.15); }

    /* ===== HERO BANNER ===== */
    .rsd-hero {
        position:relative; overflow:hidden; border-radius:26px;
        padding:44px 40px; margin-bottom:26px; color:#fff;
        background:linear-gradient(135deg,#0c1f4d 0%,#1e3a8a 45%,#1d4ed8 100%);
        box-shadow:0 24px 60px rgba(12,31,77,.4);
        animation:rsdFadeUp .6s cubic-bezier(.16,1,.3,1) both;
    }
    .rsd-hero::before {
        content:''; position:absolute; inset:0; opacity:.5;
        background-image:
            repeating-linear-gradient(45deg,transparent,transparent 28px,rgba(253,230,138,.05) 28px,rgba(253,230,138,.05) 29px),
            repeating-linear-gradient(-45deg,transparent,transparent 28px,rgba(253,230,138,.05) 28px,rgba(253,230,138,.05) 29px);
        pointer-events:none;
    }
    .rsd-orb { position:absolute; border-radius:50%; pointer-events:none; filter:blur(4px); }
    .rsd-orb-1 { width:220px; height:220px; top:-70px; right:-30px; background:radial-gradient(circle at 30% 30%,rgba(253,230,138,.5),rgba(217,164,65,.18) 60%,transparent); animation:rsdFloat1 13s ease-in-out infinite; }
    .rsd-orb-2 { width:260px; height:260px; bottom:-110px; left:-50px; background:radial-gradient(circle at 70% 70%,rgba(96,165,250,.4),rgba(29,78,216,.16) 60%,transparent); animation:rsdFloat2 16s ease-in-out infinite; }
    .rsd-badge {
        position:relative; z-index:2; display:inline-flex; align-items:center; gap:6px;
        padding:5px 14px; border-radius:999px; margin-bottom:16px;
        font-size:11px; font-weight:800; letter-spacing:.04em;
        background:rgba(253,230,138,.16); border:1px solid rgba(253,230,138,.35); color:#fde68a;
    }
    .rsd-title {
        position:relative; z-index:2; font-family:var(--font-display);
        font-size:clamp(26px,3.8vw,40px); font-weight:900; color:#fff;
        margin:0; line-height:1.18; letter-spacing:-.025em;
    }

    /* ===== QUICK STATS (3 panel di bawah hero) ===== */
    .rsd-quick { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:26px; }
    .rsd-q {
        position:relative; overflow:hidden; padding:18px 20px; border-radius:18px;
        background:var(--white); border:1px solid var(--border);
        box-shadow:0 6px 18px rgba(0,0,0,.05);
        animation:rsdFadeUp .55s cubic-bezier(.16,1,.3,1) both;
    }
    .rsd-q:nth-child(2){animation-delay:.07s} .rsd-q:nth-child(3){animation-delay:.14s}
    .rsd-q .ico { font-size:20px; margin-bottom:6px; }
    .rsd-q .v { font-family:var(--font-display); font-size:20px; font-weight:900; color:var(--ink); line-height:1.1; }
    .rsd-q .v.gold { background:linear-gradient(135deg,#f2c063,#d9a441); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .rsd-q .l { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-top:4px; }

    /* ===== KARTU UTAMA ===== */
    .rsd-card {
        background:var(--white); border:1px solid var(--border); border-radius:24px;
        padding:38px; box-shadow:0 10px 30px rgba(0,0,0,.06);
        animation:rsdFadeUp .6s cubic-bezier(.16,1,.3,1) .1s both;
    }
    .rsd-section-label {
        display:flex; align-items:center; gap:10px;
        font-family:var(--font-display); font-size:15px; font-weight:900; color:var(--ink);
        margin:0 0 16px; padding-bottom:12px; border-bottom:1px dashed var(--border);
    }
    .rsd-section-label .dot { width:8px; height:8px; border-radius:50%; background:linear-gradient(135deg,#1d4ed8,#3b82f6); box-shadow:0 0 0 3px rgba(29,78,216,.15); }

    /* ===== INFO GRID ===== */
    .rsd-info { display:grid; grid-template-columns:repeat(2,1fr); gap:16px; margin-bottom:30px; }
    .rsd-info .row {
        display:flex; flex-direction:column; gap:5px; padding:16px 18px; border-radius:14px;
        background:linear-gradient(145deg,#f6faf7,#eef6f1); border:1px solid var(--border);
        transition:transform .25s, box-shadow .25s;
    }
    .rsd-info .row:hover { transform:translateY(-3px); box-shadow:0 8px 18px rgba(5,150,105,.1); }
    .rsd-info .row.full { grid-column:1/-1; }
    .rsd-info .k { font-size:10.5px; font-weight:800; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); display:flex; align-items:center; gap:6px; }
    .rsd-info .v { font-size:14.5px; font-weight:700; color:var(--ink); line-height:1.5; }

    /* ===== DESKRIPSI ===== */
    .rsd-body { font-size:15.5px; line-height:1.9; color:var(--text); white-space:pre-line; margin-bottom:30px; }

    /* ===== TARGET LUARAN ===== */
    .rsd-luaran {
        position:relative; overflow:hidden; padding:22px 24px; border-radius:18px;
        background:linear-gradient(135deg,rgba(217,164,65,.12),rgba(217,164,65,.04));
        border:1px solid rgba(217,164,65,.35);
    }
    .rsd-luaran::before {
        content:''; position:absolute; top:-30px; right:-20px; width:120px; height:120px; border-radius:50%;
        background:radial-gradient(circle,rgba(217,164,65,.2),transparent 70%); pointer-events:none;
    }
    .rsd-luaran .k { position:relative; z-index:1; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:.1em; color:#92400e; margin-bottom:8px; display:flex; align-items:center; gap:8px; }
    .rsd-luaran .v { position:relative; z-index:1; font-size:15px; font-weight:700; color:var(--ink); line-height:1.6; }

    /* ===== FOOTER ACTIONS ===== */
    .rsd-actions { display:flex; gap:12px; flex-wrap:wrap; margin-top:30px; padding-top:24px; border-top:1px dashed var(--border); }
    .rsd-btn {
        display:inline-flex; align-items:center; gap:8px; padding:12px 22px; border-radius:12px;
        font-size:13.5px; font-weight:700; text-decoration:none; cursor:pointer; border:2px solid var(--border);
        background:var(--white); color:var(--muted); transition:all .25s;
    }
    .rsd-btn:hover { transform:translateY(-2px); border-color:rgba(29,78,216,.3); color:#1d4ed8; box-shadow:0 6px 16px rgba(29,78,216,.15); }
    .rsd-btn.copied { border-color:rgba(5,150,105,.4); color:#059669; background:rgba(5,150,105,.06); }

    @media(max-width:600px){
        .rsd-card{padding:24px 20px;} .rsd-hero{padding:32px 24px;}
        .rsd-info,.rsd-quick{grid-template-columns:1fr;}
    }
</style>

<div class="rsd-wrap">
    <a class="rsd-back" href="<?= e(url('public/index.php?page=penelitian')) ?>">← Kembali ke Penelitian</a>

    <!-- ===== HERO ===== -->
    <div class="rsd-hero">
        <div class="rsd-orb rsd-orb-1"></div>
        <div class="rsd-orb rsd-orb-2"></div>
        <span class="rsd-badge">🔬 <?= e(Research::SCHEMES[$item['scheme']] ?? $item['scheme']) ?></span>
        <h1 class="rsd-title"><?= e($item['title']) ?></h1>
    </div>

    <!-- ===== QUICK STATS ===== -->
    <div class="rsd-quick">
        <div class="rsd-q">
            <div class="ico">📅</div>
            <div class="v"><?= (int)$item['year'] ?></div>
            <div class="l">Tahun Pelaksanaan</div>
        </div>
        <div class="rsd-q">
            <div class="ico">💰</div>
            <div class="v gold">Rp <?= number_format((int)$item['funding'],0,',','.') ?></div>
            <div class="l">Pendanaan</div>
        </div>
        <div class="rsd-q">
            <div class="ico">🏷️</div>
            <div class="v"><?= e(!empty($item['field']) ? (Research::FIELDS[$item['field']] ?? $item['field']) : 'Umum') ?></div>
            <div class="l">Bidang Fokus</div>
        </div>
    </div>

    <!-- ===== KARTU UTAMA ===== -->
    <div class="rsd-card">
        <h2 class="rsd-section-label"><span class="dot"></span>Tim Peneliti</h2>
        <div class="rsd-info">
            <div class="row">
                <span class="k">👤 Ketua Peneliti</span>
                <span class="v"><?= e($item['leader']) ?></span>
            </div>
            <div class="row">
                <span class="k">🔬 Skema</span>
                <span class="v"><?= e(Research::SCHEMES[$item['scheme']] ?? $item['scheme']) ?></span>
            </div>
            <?php if (!empty($item['members'])): ?>
            <div class="row full">
                <span class="k">👥 Anggota Tim</span>
                <span class="v"><?= e($item['members']) ?></span>
            </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($item['description'])): ?>
            <h2 class="rsd-section-label"><span class="dot"></span>Deskripsi Penelitian</h2>
            <div class="rsd-body"><?= e($item['description']) ?></div>
        <?php endif; ?>

        <?php if (!empty($item['output_target'])): ?>
            <h2 class="rsd-section-label"><span class="dot"></span>Target Luaran</h2>
            <div class="rsd-luaran">
                <div class="k">🎯 Luaran yang Diharapkan</div>
                <div class="v"><?= e($item['output_target']) ?></div>
            </div>
        <?php endif; ?>

        <!-- ===== ACTIONS ===== -->
        <div class="rsd-actions">
            <a class="rsd-btn" href="<?= e(url('public/index.php?page=penelitian')) ?>">← Semua Penelitian</a>
            <button type="button" class="rsd-btn" id="rsd-share" data-url="<?= e(url('public/index.php?page=penelitian-detail&id=' . $item['id'])) ?>">🔗 Bagikan</button>
        </div>
    </div>
</div>

<script>
(function(){
    var btn = document.getElementById('rsd-share');
    if (!btn) return;
    btn.addEventListener('click', function(){
        var url = btn.getAttribute('data-url');
        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(function(){
                btn.classList.add('copied');
                btn.textContent = '✅ Link disalin!';
                setTimeout(function(){ btn.classList.remove('copied'); btn.textContent = '🔗 Bagikan'; }, 2000);
            });
        }
    });
})();
</script>