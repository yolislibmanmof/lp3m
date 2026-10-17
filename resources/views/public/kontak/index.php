<?php
// Fallback Data
$c = $contact ?? [];
$address = $c['address'] ?? 'Kampus UNIMOF, Jl. Wairklau, Maumere, NTT';
$email = $c['email'] ?? 'lp3m@unimof.ac.id';
$hours = $c['office_hours'] ?? 'Senin – Jumat: 08.00 – 16.00 WITA';
$map = $c['map_embed'] ?? '';
$phone = $c['phone'] ?? '+62 812-3456-7890';
$social = [
    'facebook' => $c['facebook'] ?? 'https://facebook.com/lp3munimof',
    'instagram' => $c['instagram'] ?? 'https://instagram.com/lp3m_unimof',
    'youtube' => $c['youtube'] ?? 'https://youtube.com/@lp3munimof',
    'twitter' => $c['twitter'] ?? '',
];

// Format WA Number
$wa_raw = $c['whatsapp'] ?? '6281234567890';
$wa_num = preg_replace('/[^0-9]/', '', $wa_raw);
if (substr($wa_num, 0, 1) === '0') $wa_num = '62' . substr($wa_num, 1);
$wa_link = "https://wa.me/{$wa_num}?text=Halo%20Admin%20LP3M,%20saya%20ingin%20bertanya.";

// Hitung status OPEN/CLOSED (asumsi WITA = UTC+8)
$now = new DateTime('now', new DateTimeZone('Asia/Makassar'));
$day = (int) $now->format('N'); // 1=Senin, 7=Minggu
$hour = (int) $now->format('G');
$isWeekday = ($day >= 1 && $day <= 5);
$isOfficeHour = ($hour >= 8 && $hour < 16);
$isOpen = $isWeekday && $isOfficeHour;
$statusClass = $isOpen ? 'open' : 'closed';
$statusText = $isOpen ? '🟢 Buka Sekarang' : '🔴 Tutup';
?>
<style>
    @keyframes ctFadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:none} }
    @keyframes ctPulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.05)} }

    .ct-wrap { max-width:1200px; margin:0 auto; padding:0 20px; }

    /* ===== HERO ===== */
    .ct-hero { position:relative; overflow:hidden; border-radius:28px; padding:58px 46px; margin-bottom:32px; color:#fff; background:linear-gradient(135deg,#064e3b 0%,#065f46 50%,#059669 100%); box-shadow:0 26px 64px rgba(6,78,59,.35); animation:ctFadeUp .6s cubic-bezier(.16,1,.3,1) both; }
    .ct-hero::before { content:''; position:absolute; inset:0; opacity:.35; background-image:repeating-linear-gradient(45deg,transparent,transparent 28px,rgba(217,164,65,.06) 28px,rgba(217,164,65,.06) 29px),repeating-linear-gradient(-45deg,transparent,transparent 28px,rgba(217,164,65,.06) 28px,rgba(217,164,65,.06) 29px); pointer-events:none; }
    .ct-hero::after { content:''; position:absolute; top:-40%; right:-8%; width:500px; height:500px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.3),transparent 70%); pointer-events:none; }
    .ct-hero-inner { position:relative; z-index:2; }
    .ct-eyebrow { display:inline-flex; align-items:center; gap:7px; padding:5px 14px; border-radius:999px; margin-bottom:16px; font-size:10.5px; font-weight:900; letter-spacing:.16em; text-transform:uppercase; background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.3); color:#fde68a; }
    .ct-hero h1 { font-family:var(--font-display); font-size:clamp(28px,4vw,44px); font-weight:900; margin:0 0 12px; letter-spacing:-.025em; background:linear-gradient(135deg,#fff,#fde68a 55%,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .ct-hero p { opacity:.92; max-width:640px; font-size:15px; line-height:1.7; margin:0 0 24px; }
    .ct-stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:10px; }
    .ct-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); border-radius:14px; padding:14px 18px; backdrop-filter:blur(8px); }
    .ct-stat b { display:block; font-family:var(--font-display); font-size:14px; font-weight:900; color:#fde68a; line-height:1.3; }
    .ct-stat span { display:block; font-size:9.5px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; opacity:.88; margin-top:4px; }
    .ct-stat .status { display:inline-flex; align-items:center; gap:6px; padding:3px 10px; border-radius:999px; font-size:10px; font-weight:900; margin-top:6px; }
    .ct-stat .status.open { background:rgba(16,185,129,.2); color:#6ee7b7; border:1px solid rgba(16,185,129,.4); }
    .ct-stat .status.closed { background:rgba(220,38,38,.2); color:#fca5a5; border:1px solid rgba(220,38,38,.4); }

    /* ===== GRID ===== */
    .ct-grid { display:grid; grid-template-columns:1fr 1.5fr; gap:30px; margin-bottom:50px; }
    @media(max-width:900px){ .ct-grid { grid-template-columns:1fr; } }

    /* ===== INFO CARD ===== */
    .ct-info-card { background:var(--white); border:1px solid var(--border); border-radius:24px; padding:32px; box-shadow:0 12px 34px rgba(3,37,31,.06); height:fit-content; position:relative; overflow:hidden; animation:ctFadeUp .6s .08s both; }
    .ct-info-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#059669,#10b981,#d9a441); opacity:.85; }
    .ct-info-card::after { content:''; position:absolute; bottom:-30%; right:-20%; width:200px; height:200px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.08),transparent 70%); pointer-events:none; }
    .ct-info-head { display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:1px dashed var(--border); }
    .ct-info-head h2 { margin:0; font-family:var(--font-display); font-size:18px; font-weight:900; color:var(--ink); }
    .ct-info-head .emo { width:40px; height:40px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; background:linear-gradient(145deg,#d1fae5,#a7f3d0); box-shadow:0 4px 10px rgba(16,185,129,.2); }

    .ct-info-item { display:flex; gap:16px; margin-bottom:20px; align-items:flex-start; position:relative; z-index:1; }
    .ct-info-item:last-child { margin-bottom:0; }
    .ct-info-ico { width:46px; height:46px; border-radius:13px; background:linear-gradient(145deg,#ecfdf5,#d1fae5); border:1px solid rgba(16,185,129,.25); display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; box-shadow:0 4px 10px rgba(16,185,129,.12); }
    .ct-info-text h4 { font-size:13px; font-weight:900; color:var(--ink); margin:0 0 5px; text-transform:uppercase; letter-spacing:.08em; }
    .ct-info-text p { font-size:14px; color:var(--muted); margin:0; line-height:1.6; }
    .ct-info-text a { color:#059669; text-decoration:none; font-weight:700; transition:color .2s; }
    .ct-info-text a:hover { color:#d9a441; text-decoration:underline; }

    /* ===== MAP ===== */
    .ct-map { margin-top:24px; border-radius:18px; overflow:hidden; border:1px solid var(--border); height:240px; background:#e5e7eb; position:relative; }
    .ct-map iframe { width:100%; height:100%; border:0; display:block; }
    .ct-map-placeholder { width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#d1fae5,#a7f3d0); color:#065f46; font-weight:800; font-size:14px; flex-direction:column; gap:8px; }
    .ct-map-btn { position:absolute; bottom:12px; right:12px; padding:8px 16px; border-radius:10px; background:rgba(255,255,255,.95); color:#059669; font-size:12px; font-weight:800; text-decoration:none; box-shadow:0 4px 12px rgba(0,0,0,.15); transition:all .2s; display:inline-flex; align-items:center; gap:6px; }
    .ct-map-btn:hover { transform:translateY(-2px); background:#fff; }

    /* ===== QUICK ACTIONS ===== */
    .ct-actions { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:24px; padding-top:20px; border-top:1px dashed var(--border); position:relative; z-index:1; }
    .ct-action-btn { display:flex; align-items:center; justify-content:center; gap:8px; padding:13px; border-radius:13px; background:linear-gradient(145deg,#f6fcf7,#e9f6ec); border:1px solid var(--border); color:var(--ink); font-size:13px; font-weight:800; text-decoration:none; transition:all .25s; }
    .ct-action-btn:hover { transform:translateY(-2px); border-color:#059669; box-shadow:0 8px 18px rgba(5,150,105,.15); color:#047857; background:#fff; }
    .ct-action-btn.primary { background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); color:#03251f; border-color:transparent; box-shadow:0 6px 14px rgba(217,164,65,.3); }
    .ct-action-btn.primary:hover { filter:brightness(1.08); }

    /* ===== SOCIAL ===== */
    .ct-social { display:flex; gap:10px; margin-top:20px; padding-top:20px; border-top:1px dashed var(--border); }
    .ct-social a { width:42px; height:42px; border-radius:12px; background:linear-gradient(145deg,#f6fcf7,#e9f6ec); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:18px; text-decoration:none; transition:all .25s; }
    .ct-social a:hover { transform:translateY(-3px); border-color:#059669; box-shadow:0 6px 14px rgba(5,150,105,.15); }

    /* ===== FAQ ===== */
    .ct-faq-card { background:var(--white); border:1px solid var(--border); border-radius:24px; padding:32px; box-shadow:0 12px 34px rgba(3,37,31,.06); animation:ctFadeUp .6s .16s both; }
    .ct-faq-head { display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:2px solid var(--border); }
    .ct-faq-head h2 { margin:0; font-family:var(--font-display); font-size:20px; font-weight:900; color:var(--ink); flex:1; }
    .ct-faq-head .emo { width:44px; height:44px; border-radius:13px; display:flex; align-items:center; justify-content:center; font-size:20px; background:linear-gradient(145deg,#fef3c7,#fde68a); box-shadow:0 4px 10px rgba(217,164,65,.2); }

    .ct-search { margin-bottom:20px; }
    .ct-search-input { width:100%; padding:13px 18px; border-radius:13px; border:2px solid var(--border); background:linear-gradient(145deg,#f9fafb,#fff); font-size:14px; font-weight:600; color:var(--ink); outline:none; transition:all .25s; }
    .ct-search-input:focus { border-color:#059669; box-shadow:0 0 0 4px rgba(5,150,105,.12); }
    .ct-search-input::placeholder { color:var(--muted); }

    .ct-faq-empty { text-align:center; padding:50px 20px; background:linear-gradient(145deg,rgba(5,150,105,.04),rgba(5,150,105,.01)); border:2px dashed rgba(5,150,105,.25); border-radius:18px; }
    .ct-faq-empty-ico { font-size:48px; margin-bottom:12px; opacity:.7; }
    .ct-faq-empty h3 { font-family:var(--font-display); font-size:16px; font-weight:900; color:var(--ink); margin:0 0 6px; }
    .ct-faq-empty p { font-size:13px; color:var(--muted); margin:0; }

    .ct-accordion-item { border:1px solid var(--border); border-radius:14px; margin-bottom:12px; overflow:hidden; background:linear-gradient(165deg,#f6fcf7,#fff); transition:all .3s; }
    .ct-accordion-item:hover { border-color:rgba(5,150,105,.3); box-shadow:0 6px 16px rgba(0,0,0,.04); }
    .ct-accordion-header { width:100%; text-align:left; padding:18px 22px; background:none; border:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; font-size:14.5px; font-weight:800; color:var(--ink); font-family:inherit; transition:all .2s; }
    .ct-accordion-header::after { content:'+'; font-size:22px; font-weight:400; color:#059669; transition:transform .3s; line-height:1; }
    .ct-accordion-item.active .ct-accordion-header::after { transform:rotate(45deg); }
    .ct-accordion-item.active { border-color:#059669; background:#fff; box-shadow:0 8px 20px rgba(5,150,105,.1); }
    .ct-accordion-body { max-height:0; overflow:hidden; transition:max-height .4s ease-out; padding:0 22px; }
    .ct-accordion-item.active .ct-accordion-body { max-height:600px; padding-bottom:20px; }
    .ct-accordion-body p { font-size:14px; color:var(--muted); line-height:1.75; margin:0; }
    .ct-accordion-cat { display:inline-block; padding:3px 10px; border-radius:999px; font-size:9.5px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; background:rgba(5,150,105,.1); color:#047857; margin-bottom:8px; }

    .ct-faq-footer { margin-top:24px; padding:20px; background:linear-gradient(135deg,rgba(5,150,105,.06),rgba(5,150,105,.02)); border:1px dashed rgba(5,150,105,.3); border-radius:16px; text-align:center; }
    .ct-faq-footer p { margin:0 0 12px; font-size:14px; color:var(--muted); font-weight:700; }
    .ct-faq-footer a { display:inline-flex; align-items:center; gap:8px; padding:11px 22px; border-radius:12px; background:linear-gradient(145deg,#10b981,#059669); color:#fff; font-size:13px; font-weight:800; text-decoration:none; box-shadow:0 6px 14px rgba(5,150,105,.3); transition:all .25s; }
    .ct-faq-footer a:hover { transform:translateY(-2px); filter:brightness(1.08); }

    @media(max-width:768px){
        .ct-stats { grid-template-columns:repeat(2,1fr); }
        .ct-actions { grid-template-columns:1fr; }
    }
</style>

<div class="ct-wrap">
    <!-- ===== HERO ===== -->
    <section class="ct-hero">
        <div class="ct-hero-inner">
            <span class="ct-eyebrow">📞 Hubungi Tim LP3M</span>
            <h1>Hubungi Kami & FAQ</h1>
            <p>Punya pertanyaan seputar penelitian, pengabdian, publikasi, atau layanan LP3M? Temukan jawaban cepat atau hubungi tim kami langsung.</p>
            <div class="ct-stats">
                <div class="ct-stat"><b>📍 Maumere, NTT</b><span>Lokasi Kantor</span></div>
                <div class="ct-stat"><b>✉️ <?= e($email) ?></b><span>Email Resmi</span></div>
                <div class="ct-stat"><b>💬 +<?= e($wa_num) ?></b><span>WhatsApp Admin</span></div>
                <div class="ct-stat">
                    <b>🕒 <?= $isOpen ? '08:00–16:00' : 'Tutup' ?></b>
                    <span>Jam Layanan (WITA)</span>
                    <span class="status <?= $statusClass ?>"><?= $statusText ?></span>
                </div>
            </div>
        </div>
    </section>

    <div class="ct-grid">
        <!-- ===== LEFT: INFO KONTAK ===== -->
        <div>
            <div class="ct-info-card">
                <div class="ct-info-head">
                    <span class="emo">📋</span>
                    <h2>Informasi Kontak</h2>
                </div>

                <div class="ct-info-item">
                    <div class="ct-info-ico">📍</div>
                    <div class="ct-info-text">
                        <h4>Alamat Kantor</h4>
                        <p><?= nl2br(e($address)) ?></p>
                    </div>
                </div>

                <div class="ct-info-item">
                    <div class="ct-info-ico">✉️</div>
                    <div class="ct-info-text">
                        <h4>Email Resmi</h4>
                        <p><a href="mailto:<?= e($email) ?>"><?= e($email) ?></a></p>
                    </div>
                </div>

                <div class="ct-info-item">
                    <div class="ct-info-ico">📞</div>
                    <div class="ct-info-text">
                        <h4>Telepon Kantor</h4>
                        <p><a href="tel:<?= e($phone) ?>"><?= e($phone) ?></a></p>
                    </div>
                </div>

                <div class="ct-info-item">
                    <div class="ct-info-ico">💬</div>
                    <div class="ct-info-text">
                        <h4>WhatsApp Admin</h4>
                        <p><a href="<?= e($wa_link) ?>" target="_blank" rel="noopener">+<?= e($wa_num) ?></a></p>
                    </div>
                </div>

                <div class="ct-info-item">
                    <div class="ct-info-ico">🕒</div>
                    <div class="ct-info-text">
                        <h4>Jam Layanan</h4>
                        <p><?= nl2br(e($hours)) ?></p>
                        <span class="status <?= $statusClass ?>" style="margin-top:8px;"><?= $statusText ?></span>
                    </div>
                </div>

                <!-- MAP -->
                <div class="ct-map">
                    <?php if (!empty($map)): ?>
                        <?= $map ?>
                        <a href="https://maps.google.com/?q=<?= urlencode($address) ?>" target="_blank" rel="noopener" class="ct-map-btn">🗺️ Buka di Google Maps</a>
                    <?php else: ?>
                        <div class="ct-map-placeholder">
                            <span style="font-size:36px;">🗺️</span>
                            <span>Peta Lokasi Belum Diatur</span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- QUICK ACTIONS -->
                <div class="ct-actions">
                    <a href="<?= e($wa_link) ?>" target="_blank" rel="noopener" class="ct-action-btn primary">💬 Chat WhatsApp</a>
                    <a href="mailto:<?= e($email) ?>" class="ct-action-btn">✉️ Kirim Email</a>
                    <a href="<?= e(url('public/index.php?page=unduhan')) ?>" class="ct-action-btn">📄 Request Dokumen</a>
                    <a href="<?= e(url('public/index.php?page=panduan')) ?>" class="ct-action-btn">📖 Panduan LP3M</a>
                </div>

                <!-- SOCIAL -->
                <div class="ct-social">
                    <?php if (!empty($social['facebook'])): ?>
                    <a href="<?= e($social['facebook']) ?>" target="_blank" rel="noopener" title="Facebook">📘</a>
                    <?php endif; ?>
                    <?php if (!empty($social['instagram'])): ?>
                    <a href="<?= e($social['instagram']) ?>" target="_blank" rel="noopener" title="Instagram">📷</a>
                    <?php endif; ?>
                    <?php if (!empty($social['youtube'])): ?>
                    <a href="<?= e($social['youtube']) ?>" target="_blank" rel="noopener" title="YouTube">📺</a>
                    <?php endif; ?>
                    <?php if (!empty($social['twitter'])): ?>
                    <a href="<?= e($social['twitter']) ?>" target="_blank" rel="noopener" title="Twitter">🐦</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- ===== RIGHT: FAQ ===== -->
        <div class="ct-faq-card">
            <div class="ct-faq-head">
                <span class="emo">❓</span>
                <h2>Pertanyaan Umum (FAQ)</h2>
            </div>

            <!-- SEARCH -->
            <div class="ct-search">
                <input type="text" class="ct-search-input" id="ct-faq-search" placeholder="🔍 Cari pertanyaan... (misal: proposal, hibah, pengabdian)">
            </div>

            <?php if (empty($faqs)): ?>
                <div class="ct-faq-empty">
                    <div class="ct-faq-empty-ico">📭</div>
                    <h3>Belum Ada FAQ</h3>
                    <p>Pertanyaan umum akan segera ditambahkan oleh admin LP3M.</p>
                </div>
            <?php else: ?>
                <div id="ct-faq-list">
                    <?php foreach ($faqs as $faq): ?>
                        <div class="ct-accordion-item" data-question="<?= e(strtolower($faq['question'])) ?>" data-answer="<?= e(strtolower($faq['answer'])) ?>">
                            <button class="ct-accordion-header">
                                <span>
                                    <?php if (!empty($faq['category'])): ?>
                                    <span class="ct-accordion-cat"><?= e($faq['category']) ?></span>
                                    <?php endif; ?>
                                    <?= e($faq['question']) ?>
                                </span>
                            </button>
                            <div class="ct-accordion-body">
                                <p><?= nl2br(e($faq['answer'])) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="ct-faq-footer">
                    <p>Belum menemukan jawaban?</p>
                    <a href="<?= e($wa_link) ?>" target="_blank" rel="noopener">💬 Chat Admin via WhatsApp →</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
(function(){
    // Accordion
    document.querySelectorAll('.ct-accordion-header').forEach(function(btn){
        btn.addEventListener('click', function(){
            var item = btn.parentElement;
            var isActive = item.classList.contains('active');
            document.querySelectorAll('.ct-accordion-item').forEach(function(i){ i.classList.remove('active'); });
            if (!isActive) item.classList.add('active');
        });
    });

    // Search FAQ
    var search = document.getElementById('ct-faq-search');
    var items = document.querySelectorAll('.ct-accordion-item');
    if (search && items.length) {
        search.addEventListener('input', function(){
            var q = search.value.toLowerCase();
            items.forEach(function(item){
                var question = item.dataset.question;
                var answer = item.dataset.answer;
                var match = question.indexOf(q) !== -1 || answer.indexOf(q) !== -1;
                item.style.display = match ? '' : 'none';
            });
        });
    }

    // Reveal on scroll
    var cards = document.querySelectorAll('.ct-info-card, .ct-faq-card');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(entries){
            entries.forEach(function(en){
                if (en.isIntersecting) { en.target.style.opacity = '1'; en.target.style.transform = 'translateY(0)'; io.unobserve(en.target); }
            });
        }, { threshold: 0.12 });
        cards.forEach(function(card){
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity .6s, transform .6s';
            io.observe(card);
        });
    }
})();
</script>