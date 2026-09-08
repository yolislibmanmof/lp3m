<style>
    @keyframes pdFade { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:none} }
    @keyframes pdFloat1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(26px,-30px)} }
    @keyframes pdFloat2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-28px,24px)} }
    @keyframes pdShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes pdWiggle { 0%,100%{transform:rotate(0)} 25%{transform:rotate(-10deg) scale(1.12)} 75%{transform:rotate(10deg) scale(1.12)} }
    @keyframes pdCaret { 0%,100%{border-color:transparent} 50%{border-color:#fde68a} }
    @keyframes pdPulse { 0%,100%{box-shadow:0 0 0 0 rgba(217,164,65,.5)} 50%{box-shadow:0 0 0 9px rgba(217,164,65,0)} }

    .pd-wrap { max-width:1080px; margin:0 auto; padding:0 20px; }

    /* ===== SCROLL PROGRESS ===== */
    #pd-progress { position:fixed; top:0; left:0; right:0; height:4px; z-index:1200; background:linear-gradient(90deg,#f2c063,#d9a441,#10b981); transform:scaleX(0); transform-origin:left; box-shadow:0 1px 8px rgba(217,164,65,.5); pointer-events:none; }

    /* ===== HERO ===== */
    .pd-hero { position:relative; overflow:hidden; border-radius:30px; padding:64px 48px; margin-bottom:26px; color:#fff; background:linear-gradient(135deg,#064e3b 0%,#065f46 45%,#059669 100%); box-shadow:0 28px 70px rgba(6,78,59,.4); animation:pdFade .6s both; }
    .pd-hero::before { content:''; position:absolute; inset:0; opacity:.35; background-image:repeating-linear-gradient(45deg,transparent,transparent 28px,rgba(217,164,65,.06) 28px,rgba(217,164,65,.06) 29px),repeating-linear-gradient(-45deg,transparent,transparent 28px,rgba(217,164,65,.06) 28px,rgba(217,164,65,.06) 29px); pointer-events:none; }
    .pd-orb { position:absolute; border-radius:50%; pointer-events:none; filter:blur(4px); }
    .pd-orb-1 { width:260px; height:260px; top:-70px; right:-40px; background:radial-gradient(circle at 30% 30%,rgba(253,230,138,.5),rgba(217,164,65,.18) 60%,transparent); animation:pdFloat1 13s ease-in-out infinite; }
    .pd-orb-2 { width:300px; height:300px; bottom:-130px; left:-60px; background:radial-gradient(circle at 70% 70%,rgba(110,231,183,.4),rgba(5,150,105,.16) 60%,transparent); animation:pdFloat2 16s ease-in-out infinite; }
    .pd-hero-inner { position:relative; z-index:2; }
    .pd-eyebrow { display:inline-flex; align-items:center; gap:8px; padding:6px 15px; border-radius:999px; margin-bottom:18px; font-size:10.5px; font-weight:900; letter-spacing:.2em; text-transform:uppercase; background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.3); color:#fde68a; backdrop-filter:blur(6px); }
    .pd-eyebrow i { width:7px; height:7px; border-radius:50%; background:#fde68a; box-shadow:0 0 8px rgba(253,230,138,.9); animation:pdPulse 2s infinite; }
    .pd-hero h1 { font-family:var(--font-display); font-size:clamp(30px,4.6vw,50px); font-weight:900; margin:0 0 14px; letter-spacing:-.03em; line-height:1.08; background:linear-gradient(135deg,#fff 20%,#fde68a 60%,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .pd-type { display:inline-block; font-size:15px; font-weight:800; color:#a7f3d0; margin-bottom:14px; border-right:2px solid #fde68a; padding-right:5px; animation:pdCaret 1s infinite; min-height:1.2em; }
    .pd-hero p { opacity:.92; max-width:660px; font-size:15.5px; line-height:1.75; margin:0 0 26px; }
    .pd-hero-stats { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:26px; }
    .pd-hstat { padding:10px 18px; border-radius:14px; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); backdrop-filter:blur(8px); font-size:12.5px; font-weight:800; }
    .pd-hstat b { color:#fde68a; font-family:var(--font-display); font-size:15px; margin-right:5px; }
    .pd-hero-cta { display:flex; gap:12px; flex-wrap:wrap; }
    .pd-btn { position:relative; overflow:hidden; display:inline-flex; align-items:center; gap:9px; padding:13px 26px; border-radius:13px; font-size:13.5px; font-weight:900; text-decoration:none; transition:all .25s; }
    .pd-btn.gold { color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 50%,#d9a441); box-shadow:inset 0 2px 3px rgba(255,255,255,.7), 0 8px 18px rgba(217,164,65,.4); }
    .pd-btn.gold::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.55),transparent); animation:pdShine 3.2s ease-in-out infinite; }
    .pd-btn.ghost { color:#fff; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.3); backdrop-filter:blur(6px); }
    .pd-btn:hover { transform:translateY(-3px); filter:brightness(1.06); }

    /* ===== STICKY SCROLLSPY NAV ===== */
    .pd-nav { position:sticky; top:78px; z-index:60; display:flex; gap:8px; flex-wrap:wrap; margin-bottom:26px; padding:10px 14px; background:rgba(255,255,255,.86); backdrop-filter:blur(12px); border:1px solid var(--border); border-radius:999px; box-shadow:0 8px 22px rgba(3,37,31,.08); animation:pdFade .55s .06s both; }
    .pd-nav a { padding:8px 16px; border-radius:999px; font-size:12px; font-weight:800; color:var(--muted); text-decoration:none; transition:all .25s; border:1px solid transparent; }
    .pd-nav a:hover { color:#059669; background:rgba(5,150,105,.08); }
    .pd-nav a.active { color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); border-color:transparent; box-shadow:0 5px 12px rgba(217,164,65,.35); }
    @media(max-width:760px){ .pd-nav { border-radius:20px; top:70px; } }

    /* ===== BENTO GRID ===== */
    .pd-bento { display:grid; grid-template-columns:repeat(6,1fr); gap:16px; margin-bottom:34px; }
    .pd-bento .b3 { grid-column:span 3; }
    .pd-bento .b2 { grid-column:span 2; }
    .pd-bento .b6 { grid-column:span 6; }
    @media(max-width:900px){ .pd-bento .b3,.pd-bento .b2 { grid-column:span 6; } }
    .pd-bcard { position:relative; overflow:hidden; display:flex; flex-direction:column; gap:10px; padding:24px 24px 20px; border-radius:22px; background:var(--white); border:1px solid var(--border); box-shadow:0 10px 26px rgba(3,37,31,.06); text-decoration:none; color:inherit; transition:all .3s cubic-bezier(.16,1,.3,1); opacity:0; transform:translateY(18px); }
    .pd-bcard.in { opacity:1; transform:translateY(0); }
    .pd-bcard::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:var(--ac,#10b981); opacity:.85; }
    .pd-bcard::after { content:''; position:absolute; top:-40%; right:-20%; width:180px; height:180px; border-radius:50%; background:radial-gradient(circle,var(--acg,rgba(16,185,129,.14)),transparent 70%); pointer-events:none; }
    .pd-bcard.in:hover { transform:translateY(-6px); border-color:var(--ac,#10b981); box-shadow:0 20px 40px rgba(3,37,31,.12); }
    .pd-bcard.in:hover .pd-bico { animation:pdWiggle .5s ease; }
    .pd-bico { width:50px; height:50px; border-radius:15px; display:flex; align-items:center; justify-content:center; font-size:23px; background:var(--acbg,rgba(16,185,129,.12)); box-shadow:inset 0 2px 4px rgba(255,255,255,.5), 0 5px 12px rgba(3,37,31,.08); }
    .pd-bcard h3 { margin:0; font-family:var(--font-display); font-size:17px; font-weight:900; color:var(--ink); }
    .pd-bcard p { margin:0; font-size:12.5px; color:var(--muted); line-height:1.6; flex:1; }
    .pd-blink { display:inline-flex; align-items:center; gap:6px; font-size:11.5px; font-weight:900; color:var(--ac,#059669); }
    .pd-bcard.wide { flex-direction:row; align-items:center; gap:20px; background:linear-gradient(135deg,#064e3b,#065f46 55%,#059669); color:#fff; }
    .pd-bcard.wide h3 { color:#fff; }
    .pd-bcard.wide p { color:rgba(255,255,255,.85); }
    .pd-bcard.wide .pd-bico { background:rgba(255,255,255,.14); }
    .pd-bcard.wide .pd-blink { color:#fde68a; }

    /* ===== SECTION + TIMELINE ===== */
    .pd-section { background:var(--white); border:1px solid var(--border); border-radius:26px; padding:34px 38px; margin-bottom:24px; box-shadow:0 12px 34px rgba(3,37,31,.06); position:relative; overflow:hidden; opacity:0; transform:translateY(20px); transition:opacity .6s, transform .6s; }
    .pd-section.in { opacity:1; transform:translateY(0); }
    .pd-section::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,var(--ac,#10b981),#d9a441); opacity:.9; }
    .pd-head { display:flex; align-items:center; gap:15px; margin-bottom:22px; padding-bottom:17px; border-bottom:1px dashed var(--border); }
    .pd-head .emo { width:50px; height:50px; border-radius:15px; display:flex; align-items:center; justify-content:center; font-size:23px; background:var(--acbg,rgba(16,185,129,.12)); box-shadow:0 5px 12px rgba(3,37,31,.08); }
    .pd-head h2 { margin:0; font-family:var(--font-display); font-size:20px; font-weight:900; color:var(--ink); }
    .pd-head p { margin:3px 0 0; font-size:12.5px; color:var(--muted); }
    .pd-head .dur { margin-left:auto; padding:5px 13px; border-radius:999px; font-size:10px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; background:rgba(5,150,105,.08); color:#047857; border:1px solid rgba(5,150,105,.25); white-space:nowrap; }

    .pd-tl { position:relative; padding-left:38px; }
    .pd-tl::before { content:''; position:absolute; left:13px; top:8px; bottom:8px; width:2px; background:linear-gradient(180deg,var(--ac,#10b981),#d9a441); opacity:.35; border-radius:2px; }
    .pd-tl-item { position:relative; margin-bottom:14px; padding:14px 18px; border-radius:15px; background:linear-gradient(145deg,#f8fcf9,#eef6f1); border:1px solid var(--border); transition:all .3s; }
    .pd-tl-item:last-child { margin-bottom:0; }
    .pd-tl-item:hover { border-color:var(--ac,#10b981); transform:translateX(5px); box-shadow:0 8px 18px rgba(3,37,31,.07); }
    .pd-tl-item::before { content:attr(data-n); position:absolute; left:-38px; top:14px; width:28px; height:28px; border-radius:50%; background:linear-gradient(145deg,#fde68a,#d9a441); color:#03251f; font-family:var(--font-display); font-weight:900; font-size:12.5px; display:flex; align-items:center; justify-content:center; box-shadow:0 0 0 4px var(--white), 0 4px 10px rgba(217,164,65,.35); transition:box-shadow .4s; }
    .pd-tl-item.in::before { box-shadow:0 0 0 4px var(--white), 0 0 16px rgba(217,164,65,.85); }
    .pd-tl-item b { display:block; font-size:14px; color:var(--ink); margin-bottom:4px; }
    .pd-tl-item p { margin:0; font-size:13px; color:var(--muted); line-height:1.65; }
    .pd-tl-item code { background:rgba(5,150,105,.1); color:#047857; padding:1px 7px; border-radius:6px; font-size:11.5px; font-weight:800; }

    /* ===== MINI TOOL INTERAKTIF ===== */
    .pd-tool { display:flex; gap:9px; align-items:center; margin-top:18px; padding:13px 15px; border-radius:15px; background:rgba(5,150,105,.06); border:1px dashed rgba(5,150,105,.45); flex-wrap:wrap; }
    .pd-tool .lbl { font-size:11.5px; font-weight:900; color:#047857; letter-spacing:.06em; text-transform:uppercase; }
    .pd-tool input { flex:1; min-width:180px; padding:10px 14px; border-radius:11px; border:2px solid var(--border); background:#fff; font-size:13px; font-weight:700; color:var(--ink); font-family:'Courier New',monospace; letter-spacing:.04em; outline:none; transition:all .2s; }
    .pd-tool input:focus { border-color:#059669; box-shadow:0 0 0 4px rgba(5,150,105,.12); }
    .pd-tool button { padding:10px 18px; border:none; border-radius:11px; font-size:12.5px; font-weight:900; cursor:pointer; color:#03251f; background:linear-gradient(145deg,#6ee7b7,#10b981 55%,#047857); box-shadow:0 5px 12px rgba(16,185,129,.3); transition:all .2s; }
    .pd-tool button:hover { transform:translateY(-2px); filter:brightness(1.06); }

    .pd-cta { position:relative; overflow:hidden; display:inline-flex; align-items:center; gap:8px; margin-top:20px; padding:12px 24px; border-radius:12px; font-size:13px; font-weight:900; text-decoration:none; color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:0 6px 14px rgba(217,164,65,.3); transition:all .25s; }
    .pd-cta::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:pdShine 3.2s ease-in-out infinite; }
    .pd-cta.green { background:linear-gradient(145deg,#6ee7b7,#10b981 55%,#047857); box-shadow:0 6px 14px rgba(16,185,129,.3); }
    .pd-cta:hover { transform:translateY(-2px); filter:brightness(1.05); }
    .pd-note { margin-top:16px; padding:13px 17px; border-radius:13px; background:rgba(217,164,65,.08); border:1px dashed rgba(217,164,65,.45); font-size:12.5px; color:#92400e; line-height:1.65; }

    /* ===== FAQ ===== */
    .pd-faq { background:var(--white); border:1px solid var(--border); border-radius:26px; padding:34px 38px; margin-bottom:24px; box-shadow:0 12px 34px rgba(3,37,31,.06); }
    .pd-faq h2 { display:flex; align-items:center; gap:12px; margin:0 0 20px; font-family:var(--font-display); font-size:20px; font-weight:900; color:var(--ink); }
    .pd-acc { border:1px solid var(--border); border-radius:14px; margin-bottom:10px; overflow:hidden; background:linear-gradient(165deg,#f8fcf9,#fff); transition:all .3s; }
    .pd-acc:hover { border-color:rgba(5,150,105,.35); }
    .pd-acc-h { width:100%; text-align:left; padding:16px 20px; background:none; border:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:12px; font-size:14px; font-weight:800; color:var(--ink); font-family:inherit; }
    .pd-acc-h::after { content:'+'; font-size:20px; font-weight:400; color:#059669; transition:transform .3s; line-height:1; }
    .pd-acc.open .pd-acc-h::after { transform:rotate(45deg); }
    .pd-acc-b { max-height:0; overflow:hidden; transition:max-height .4s ease; padding:0 20px; }
    .pd-acc.open .pd-acc-b { max-height:300px; padding-bottom:18px; }
    .pd-acc-b p { margin:0; font-size:13px; color:var(--muted); line-height:1.7; }

    /* ===== BANNER BANTUAN ===== */
    .pd-help { position:relative; overflow:hidden; border-radius:26px; padding:40px 42px; color:#fff; background:linear-gradient(135deg,#312e81 0%,#4338ca 55%,#6366f1 100%); box-shadow:0 22px 54px rgba(49,46,129,.35); display:flex; gap:22px; align-items:center; flex-wrap:wrap; margin-bottom:40px; }
    .pd-help::after { content:''; position:absolute; top:-40%; right:-8%; width:360px; height:360px; border-radius:50%; background:radial-gradient(circle,rgba(253,230,138,.28),transparent 70%); pointer-events:none; }
    .pd-help h2 { margin:0 0 6px; font-family:var(--font-display); font-size:22px; font-weight:900; position:relative; z-index:1; }
    .pd-help p { margin:0; font-size:13.5px; opacity:.9; max-width:520px; position:relative; z-index:1; }
    .pd-help .pd-btn { margin-left:auto; position:relative; z-index:1; }

    @media(max-width:640px){ .pd-hero,.pd-section,.pd-faq{padding:26px 20px;} .pd-help{padding:28px 22px;} .pd-help .pd-btn{margin-left:0;} }
</style>

<div id="pd-progress"></div>

<div class="pd-wrap">
    <!-- ===== HERO ===== -->
    <section class="pd-hero">
        <div class="pd-orb pd-orb-1"></div>
        <div class="pd-orb pd-orb-2"></div>
        <div class="pd-hero-inner">
            <span class="pd-eyebrow"><i></i> Pusat Bantuan · 24/7</span>
            <h1>Panduan Layanan<br>LP3M</h1>
            <span class="pd-type" id="pd-type"></span>
            <p>Semua yang Anda butuhkan untuk memanfaatkan layanan digital lembaga — verifikasi sertifikat, pemeriksaan plagiarisme, hibah, unduhan, hingga agenda kegiatan — dijelaskan langkah demi langkah.</p>
            <div class="pd-hero-stats">
                <span class="pd-hstat"><b>6</b> Layanan Digital</span>
                <span class="pd-hstat"><b>&lt;1'</b> Verifikasi Sertifikat</span>
                <span class="pd-hstat"><b>24/7</b> Akses Mandiri</span>
                <span class="pd-hstat"><b>WITA</b> Sen–Jam 08.00–16.00</span>
            </div>
            <div class="pd-hero-cta">
                <a class="pd-btn gold" href="#pd-layanan">🧭 Mulai Jelajah</a>
                <a class="pd-btn ghost" href="<?= e(url('public/index.php?page=kontak')) ?>">💬 Hubungi Admin</a>
            </div>
        </div>
    </section>

    <!-- ===== STICKY SCROLLSPY NAV ===== -->
    <nav class="pd-nav" id="pd-nav">
        <a href="#pd-sertifikat" data-spy="pd-sertifikat">🎓 Sertifikat</a>
        <a href="#pd-plagiat" data-spy="pd-plagiat">🔍 Plagiarisme</a>
        <a href="#pd-hibah" data-spy="pd-hibah">🔥 Hibah</a>
        <a href="#pd-unduhan" data-spy="pd-unduhan">📄 Unduhan</a>
        <a href="#pd-agenda" data-spy="pd-agenda">📅 Agenda</a>
        <a href="#pd-faq" data-spy="pd-faq">❓ FAQ</a>
    </nav>

    <!-- ===== BENTO GRID ===== -->
    <div class="pd-bento" id="pd-layanan">
        <a class="pd-bcard b3" href="#pd-sertifikat" style="--ac:#d9a441; --acbg:rgba(217,164,65,.14); --acg:rgba(217,164,65,.16);">
            <span class="pd-bico">🎓</span>
            <h3>Verifikasi Sertifikat</h3>
            <p>Uji keaslian sertifikat lewat kode unik atau pindai QR. Hasil instan: VALID atau DICABUT lengkap dengan detail pemilik & kegiatan.</p>
            <span class="pd-blink">Lihat panduan ↓</span>
        </a>
        <a class="pd-bcard b3" href="#pd-plagiat" style="--ac:#ea580c; --acbg:rgba(234,88,12,.12); --acg:rgba(234,88,12,.14);">
            <span class="pd-bico">🔍</span>
            <h3>Cek Plagiarisme</h3>
            <p>Mesin similaritas internal dengan auto-extract PDF/DOCX. Dapatkan skor, daftar sumber kemiripan, dan kode laporan untuk dicek ulang kapan saja.</p>
            <span class="pd-blink">Lihat panduan ↓</span>
        </a>
        <a class="pd-bcard b2" href="#pd-hibah" style="--ac:#f59e0b; --acbg:rgba(245,158,11,.12); --acg:rgba(245,158,11,.14);">
            <span class="pd-bico">🔥</span>
            <h3>Hibah & Pendanaan</h3>
            <p>Pantau skema terbuka, countdown deadline, dan tautan panduan proposal.</p>
            <span class="pd-blink">Lihat panduan ↓</span>
        </a>
        <a class="pd-bcard b2" href="#pd-unduhan" style="--ac:#10b981; --acbg:rgba(16,185,129,.12); --acg:rgba(16,185,129,.14);">
            <span class="pd-bico">📄</span>
            <h3>Unduhan Dokumen</h3>
            <p>Template, formulir, dan dokumen resmi lembaga dalam satu pusat unduhan.</p>
            <span class="pd-blink">Lihat panduan ↓</span>
        </a>
        <a class="pd-bcard b2" href="#pd-agenda" style="--ac:#6366f1; --acbg:rgba(99,102,241,.12); --acg:rgba(99,102,241,.14);">
            <span class="pd-bico">📅</span>
            <h3>Agenda Kegiatan</h3>
            <p>Kalender pelatihan, seminar, workshop & AIK dengan hitung mundur real-time.</p>
            <span class="pd-blink">Lihat panduan ↓</span>
        </a>
        <a class="pd-bcard b6 wide" href="#pd-faq">
            <span class="pd-bico">💡</span>
            <div style="flex:1;">
                <h3>Butuh Jawaban Cepat?</h3>
                <p>Kumpulan pertanyaan paling sering diajukan beserta jawaban ringkasnya — atau langsung chat admin via WhatsApp pada jam layanan.</p>
            </div>
            <span class="pd-blink">Buka FAQ →</span>
        </a>
    </div>

    <!-- ===== 1. SERTIFIKAT ===== -->
    <section class="pd-section" id="pd-sertifikat" style="--ac:#d9a441; --acbg:rgba(217,164,65,.14);">
        <div class="pd-head">
            <span class="emo">🎓</span>
            <div><h2>Verifikasi Sertifikat</h2><p>Pastikan keaslian sertifikat yang Anda terima.</p></div>
            <span class="dur">⏱️ ± 1 menit</span>
        </div>
        <div class="pd-tl">
            <div class="pd-tl-item" data-n="1"><b>Siapkan kode sertifikat</b><p>Kode berbentuk seperti <code>LP3M-2026-A1B2C3</code> — tercetak di bagian bawah sertifikat & pada barcode.</p></div>
            <div class="pd-tl-item" data-n="2"><b>Buka halaman verifikasi</b><p>Klik tombol di bawah atau gunakan mini tool untuk mengisi kode secara otomatis.</p></div>
            <div class="pd-tl-item" data-n="3"><b>Lihat hasil verifikasi</b><p>Sistem menampilkan status <b>VALID</b> atau <b>DICABUT</b> beserta detail pemilik, kegiatan, dan penandatangan.</p></div>
        </div>
        <div class="pd-tool">
            <span class="lbl">⚡ Mini Tool</span>
            <input type="text" id="pd-cert-code" placeholder="Tempel kode sertifikat… contoh LP3M-2026-A1B2C3">
            <button type="button" id="pd-cert-go">Verifikasi →</button>
        </div>
        <a class="pd-cta" href="<?= e(url('public/index.php?page=verifikasi-sertifikat')) ?>">🎓 Buka Halaman Verifikasi →</a>
    </section>

    <!-- ===== 2. PLAGIAT ===== -->
    <section class="pd-section" id="pd-plagiat" style="--ac:#ea580c; --acbg:rgba(234,88,12,.12);">
        <div class="pd-head">
            <span class="emo">🔍</span>
            <div><h2>Cek Plagiarisme</h2><p>Periksa similaritas dokumen terhadap korpus internal LP3M.</p></div>
            <span class="dur">⏱️ ± 3 menit</span>
        </div>
        <div class="pd-tl">
            <div class="pd-tl-item" data-n="1"><b>Siapkan dokumen</b><p><code>TXT/MD</code> dianalisis instan. <code>PDF/DOCX</code> dibaca otomatis mesin ekstraksi; bila berupa scan/gambar, Anda dapat menempel teksnya kemudian.</p></div>
            <div class="pd-tl-item" data-n="2"><b>Isi formulir & kirim</b><p>Lengkapi judul dan nama penulis, lalu unggah file atau tempel teks dokumen.</p></div>
            <div class="pd-tl-item" data-n="3"><b>Simpan kode laporan</b><p>Kode seperti <code>PLG-2026-001</code> dipakai untuk melihat hasil kapan saja via form "Cek Hasil per Kode".</p></div>
        </div>
        <div class="pd-tool">
            <span class="lbl">⚡ Mini Tool</span>
            <input type="text" id="pd-plg-code" placeholder="Punya kode laporan? contoh PLG-2026-001">
            <button type="button" id="pd-plg-go">Lihat Hasil →</button>
        </div>
        <div class="pd-note">💡 Ambang similaritas yang disarankan LP3M adalah <b>&lt; 25%</b>. Di atas angka tersebut, kutipan dokumen perlu direvisi.</div>
        <a class="pd-cta green" href="<?= e(url('public/index.php?page=cek-plagiat')) ?>">🔍 Mulai Pemeriksaan →</a>
    </section>

    <!-- ===== 3. HIBAH ===== -->
    <section class="pd-section" id="pd-hibah" style="--ac:#f59e0b; --acbg:rgba(245,158,11,.12);">
        <div class="pd-head">
            <span class="emo">🔥</span>
            <div><h2>Hibah & Pendanaan</h2><p>Ikuti peluang pendanaan penelitian & pengabdian.</p></div>
            <span class="dur">⏱️ ± 2 menit</span>
        </div>
        <div class="pd-tl">
            <div class="pd-tl-item" data-n="1"><b>Pantau halaman hibah</b><p>Semua skema terbuka tampil lengkap dengan countdown deadline & nominal pendanaan.</p></div>
            <div class="pd-tl-item" data-n="2"><b>Unduh panduan proposal</b><p>Setiap hibah menyediakan tautan panduan resmi agar proposal sesuai template.</p></div>
            <div class="pd-tl-item" data-n="3"><b>Daftar sebelum deadline</b><p>Gunakan tombol "Daftar" pada kartu hibah, atau hubungi admin bila pendaftaran via internal.</p></div>
        </div>
        <a class="pd-cta" href="<?= e(url('public/index.php?page=hibah')) ?>">🔥 Lihat Hibah Aktif →</a>
    </section>

    <!-- ===== 4. UNDUHAN ===== -->
    <section class="pd-section" id="pd-unduhan" style="--ac:#10b981; --acbg:rgba(16,185,129,.12);">
        <div class="pd-head">
            <span class="emo">📄</span>
            <div><h2>Unduhan Dokumen</h2><p>Template, formulir, dan dokumen resmi lembaga.</p></div>
            <span class="dur">⏱️ ± 1 menit</span>
        </div>
        <div class="pd-tl">
            <div class="pd-tl-item" data-n="1"><b>Buka pusat unduhan</b><p>Dokumen dikelompokkan per kategori untuk memudahkan pencarian.</p></div>
            <div class="pd-tl-item" data-n="2"><b>Klik tombol unduh</b><p>File langsung terunduh; perhatikan ukuran file yang tertera pada kartu dokumen.</p></div>
        </div>
        <a class="pd-cta green" href="<?= e(url('public/index.php?page=unduhan')) ?>">📄 Ke Pusat Unduhan →</a>
    </section>

    <!-- ===== 5. AGENDA ===== -->
    <section class="pd-section" id="pd-agenda" style="--ac:#6366f1; --acbg:rgba(99,102,241,.12);">
        <div class="pd-head">
            <span class="emo">📅</span>
            <div><h2>Agenda Kegiatan</h2><p>Jadwal pelatihan, seminar, workshop, dan kegiatan AIK.</p></div>
            <span class="dur">⏱️ ± 1 menit</span>
        </div>
        <div class="pd-tl">
            <div class="pd-tl-item" data-n="1"><b>Lihat kalender & countdown</b><p>Kegiatan mendatang ditampilkan dengan hitung mundur real-time dan filter jenis kegiatan.</p></div>
            <div class="pd-tl-item" data-n="2"><b>Daftar melalui tautan</b><p>Kegiatan dengan pendaftaran online menyediakan tombol "Daftar Sekarang" pada kartunya.</p></div>
        </div>
        <a class="pd-cta" href="<?= e(url('public/index.php?page=agenda')) ?>">📅 Buka Agenda →</a>
    </section>

    <!-- ===== FAQ ===== -->
    <section class="pd-faq" id="pd-faq">
        <h2><span style="font-size:22px;">❓</span> Pertanyaan yang Sering Diajukan</h2>
        <div class="pd-acc">
            <button class="pd-acc-h" type="button">Apakah verifikasi sertifikat dipungut biaya?</button>
            <div class="pd-acc-b"><p>Tidak. Verifikasi sertifikat melalui website LP3M sepenuhnya gratis dan dapat dilakukan kapan saja tanpa login.</p></div>
        </div>
        <div class="pd-acc">
            <button class="pd-acc-h" type="button">Berapa lama hasil cek plagiarisme keluar?</button>
            <div class="pd-acc-b"><p>Dokumen TXT/MD dan PDF/DOCX berteks dianalisis seketika setelah dikirim. PDF hasil scan memerlukan penempelan teks atau review admin, biasanya selesai pada hari kerja yang sama.</p></div>
        </div>
        <div class="pd-acc">
            <button class="pd-acc-h" type="button">Kode sertifikat saya tertulis "DICABUT", apa artinya?</button>
            <div class="pd-acc-b"><p>Sertifikat tersebut telah dibatalkan oleh lembaga karena alasan tertentu (mis. kesalahan data atau pelanggaran). Silakan hubungi admin untuk klarifikasi.</p></div>
        </div>
        <div class="pd-acc">
            <button class="pd-acc-h" type="button">Bagaimana cara mengajukan dokumen untuk diunggah ke pusat unduhan?</button>
            <div class="pd-acc-b"><p>Kirim berkas beserta surat pengantar melalui email resmi LP3M atau WhatsApp admin pada jam layanan. Tim akan meninjau sebelum dipublikasikan.</p></div>
        </div>
    </section>

    <!-- ===== BANNER BANTUAN ===== -->
    <section class="pd-help">
        <div>
            <h2>🤝 Masih Butuh Bantuan?</h2>
            <p>Tim layanan LP3M siap membantu pada hari kerja Senin–Jumat, 08.00–16.00 WITA. Di luar jam tersebut, pesan Anda akan dijawab pada hari kerja berikutnya.</p>
        </div>
        <a class="pd-btn gold" href="<?= e(url('public/index.php?page=kontak')) ?>">💬 Chat Admin Sekarang</a>
    </section>
</div>

<script>
(function(){
    // Typing tagline
    var phrases = ['Verifikasi sertifikat dalam hitungan detik.', 'Periksa plagiarisme secara mandiri.', 'Pantau hibah & agenda lembaga.', 'Unduh dokumen resmi kapan saja.'];
    var el = document.getElementById('pd-type');
    if (el) {
        var pi = 0, ci = 0, del = false;
        (function tick(){
            var p = phrases[pi];
            el.textContent = p.slice(0, ci);
            if (!del && ci < p.length) { ci++; setTimeout(tick, 45); }
            else if (!del) { del = true; setTimeout(tick, 1600); }
            else if (ci > 0) { ci--; setTimeout(tick, 22); }
            else { del = false; pi = (pi + 1) % phrases.length; setTimeout(tick, 300); }
        })();
    }

    // Scroll progress
    var bar = document.getElementById('pd-progress');
    if (bar) window.addEventListener('scroll', function(){
        var h = document.documentElement;
        var p = h.scrollTop / (h.scrollHeight - h.clientHeight || 1);
        bar.style.transform = 'scaleX(' + p + ')';
    }, { passive: true });

    // Smooth scroll semua anchor internal
    document.querySelectorAll('a[href^="#"]').forEach(function(a){
        a.addEventListener('click', function(e){
            var t = document.querySelector(a.getAttribute('href'));
            if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
        });
    });

    // Scrollspy pill nav
    var spies = document.querySelectorAll('[data-spy]');
    if ('IntersectionObserver' in window && spies.length) {
        var io2 = new IntersectionObserver(function(es){
            es.forEach(function(en){
                if (en.isIntersecting) {
                    spies.forEach(function(s){ s.classList.toggle('active', s.dataset.spy === en.target.id); });
                }
            });
        }, { rootMargin: '-40% 0px -55% 0px' });
        spies.forEach(function(s){ var t = document.getElementById(s.dataset.spy); if (t) io2.observe(t); });
    }

    // Reveal on scroll (bento, section, timeline item)
    var revs = document.querySelectorAll('.pd-bcard, .pd-section, .pd-tl-item');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(es){
            es.forEach(function(en){ if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); } });
        }, { threshold: 0.12 });
        revs.forEach(function(r){ io.observe(r); });
    } else {
        revs.forEach(function(r){ r.classList.add('in'); });
    }

    // Mini tools
    var certIn = document.getElementById('pd-cert-code');
    var certGo = document.getElementById('pd-cert-go');
    if (certGo) certGo.addEventListener('click', function(){
        var v = (certIn.value || '').trim();
        window.location.href = '<?= e(url('public/index.php?page=verifikasi-sertifikat')) ?>' + (v ? '&code=' + encodeURIComponent(v) : '');
    });
    var plgIn = document.getElementById('pd-plg-code');
    var plgGo = document.getElementById('pd-plg-go');
    if (plgGo) plgGo.addEventListener('click', function(){
        var v = (plgIn.value || '').trim();
        window.location.href = '<?= e(url('public/index.php?page=cek-plagiat')) ?>' + (v ? '&kode=' + encodeURIComponent(v) : '');
    });

    // FAQ accordion
    document.querySelectorAll('.pd-acc-h').forEach(function(h){
        h.addEventListener('click', function(){
            var item = h.parentElement;
            var open = item.classList.contains('open');
            document.querySelectorAll('.pd-acc').forEach(function(a){ a.classList.remove('open'); });
            if (!open) item.classList.add('open');
        });
    });
})();
</script>