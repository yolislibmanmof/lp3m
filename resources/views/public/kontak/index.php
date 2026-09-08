<style>
    /* ===== CONTACT HERO ===== */
    .contact-hero { position:relative; overflow:hidden; border-radius:28px; padding:56px 44px; margin-bottom:40px; color:#fff; background:linear-gradient(135deg,#064e3b 0%,#065f46 50%,#059669 100%); box-shadow:0 24px 60px rgba(6,78,59,.3); }
    .contact-hero::before { content:''; position:absolute; inset:0; background-image: repeating-linear-gradient(45deg, transparent, transparent 25px, rgba(217,164,65,0.04) 25px, rgba(217,164,65,0.04) 26px), repeating-linear-gradient(-45deg, transparent, transparent 25px, rgba(217,164,65,0.04) 25px, rgba(217,164,65,0.04) 26px); pointer-events:none; }
    .contact-hero h1 { font-family:var(--font-display); font-size:clamp(28px,4vw,42px); font-weight:900; margin:0 0 12px; position:relative; z-index:2; text-shadow: 0 2px 10px rgba(0,0,0,0.2); }
    .contact-hero p { opacity:.9; max-width:600px; font-size:16px; line-height:1.6; position:relative; z-index:2; }
    
    /* ===== GRID LAYOUT ===== */
    .contact-grid { display:grid; grid-template-columns:1fr 1.5fr; gap:30px; margin-bottom:50px; }
    @media(max-width:900px){ .contact-grid { grid-template-columns:1fr; } }

    /* ===== INFO CARD ===== */
    .info-card { background:var(--white); border:1px solid var(--border); border-radius:22px; padding:30px; box-shadow:0 4px 14px rgba(0,0,0,.04); height:fit-content; position: relative; overflow: hidden; }
    .info-card::after { content:''; position:absolute; bottom:-30%; right:-20%; width:150px; height:150px; border-radius:50%; background:radial-gradient(circle, rgba(217,164,65,0.08), transparent 70%); pointer-events:none; }
    
    .info-item { display:flex; gap:16px; margin-bottom:24px; align-items:flex-start; position:relative; z-index:1; }
    .info-item:last-child { margin-bottom:0; }
    .info-ico { width:44px; height:44px; border-radius:12px; background:linear-gradient(145deg,#e9f7ec,#d5ecdd); border:1px solid var(--border-soft); display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; color:var(--primary-dark); box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
    .info-text h4 { font-size:14px; font-weight:800; color:var(--ink); margin:0 0 4px; }
    .info-text p { font-size:13.5px; color:var(--muted); margin:0; line-height:1.6; }
    .info-text a { color:var(--primary); text-decoration:none; font-weight:600; transition: color 0.2s; }
    .info-text a:hover { color:var(--gold-deep); text-decoration:underline; }

    /* ===== QUICK ACTIONS ===== */
    .quick-actions { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:30px; padding-top:24px; border-top:1px dashed var(--border); position:relative; z-index:1; }
    .qa-btn { display:flex; align-items:center; justify-content:center; gap:8px; padding:12px; border-radius:12px; background:linear-gradient(145deg,#f6fcf7,#e9f6ec); border:1px solid var(--border); color:var(--ink); font-size:13px; font-weight:700; text-decoration:none; transition:all .25s; }
    .qa-btn:hover { transform:translateY(-2px); border-color:var(--primary); box-shadow:0 6px 16px rgba(5,150,105,.15); color:var(--primary-dark); background: #fff; }

    /* ===== FAQ ACCORDION ===== */
    .faq-section { background:var(--white); border:1px solid var(--border); border-radius:22px; padding:30px; box-shadow:0 4px 14px rgba(0,0,0,.04); }
    .faq-header { display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:2px solid var(--border-soft); }
    .faq-header h2 { font-family:var(--font-display); font-size:22px; font-weight:900; color:var(--ink); margin:0; }
    
    .accordion-item { border:1px solid var(--border); border-radius:14px; margin-bottom:12px; overflow:hidden; background:linear-gradient(165deg,#f6fcf7,#fff); transition:all .3s; }
    .accordion-item:hover { border-color:rgba(5,150,105,.3); box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
    .accordion-header { width:100%; text-align:left; padding:18px 20px; background:none; border:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; font-size:15px; font-weight:700; color:var(--ink); font-family:var(--font-body); }
    .accordion-header::after { content:'+'; font-size:22px; font-weight:400; color:var(--primary); transition:transform .3s; line-height:1; }
    .accordion-item.active .accordion-header::after { transform:rotate(45deg); }
    .accordion-item.active { border-color: var(--primary); background: #fff; }
    
    .accordion-body { max-height:0; overflow:hidden; transition:max-height .4s ease-out; padding:0 20px; }
    .accordion-item.active .accordion-body { max-height:500px; padding-bottom:20px; }
    .accordion-body p { font-size:14px; color:var(--muted); line-height:1.7; margin:0; }

    /* ===== MAP ===== */
    .map-container { margin-top:20px; border-radius:16px; overflow:hidden; border:1px solid var(--border); height:220px; background:#e5e7eb; position:relative; }
    .map-container iframe { width:100%; height:100%; border:0; display:block; }
    .map-placeholder { width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#d1fae5,#a7f3d0); color:#065f46; font-weight:700; font-size:14px; }
</style>

<?php 
    // Fallback Data (jika database kosong)
    $c = $contact ?? [];
    $address = $c['address'] ?? 'Kampus UNIMOF, Jl. Wairklau, Maumere, NTT';
    $email   = $c['email'] ?? 'lp3m@unimof.ac.id';
    $hours   = $c['office_hours'] ?? 'Senin – Jumat: 08.00 – 16.00 WITA';
    $map     = $c['map_embed'] ?? '';
    
    // Format WA Number (buang spasi/strip/+ agar valid untuk link)
    $wa_raw = $c['whatsapp'] ?? '6281234567890';
    $wa_num = preg_replace('/[^0-9]/', '', $wa_raw);
    if (substr($wa_num, 0, 1) === '0') $wa_num = '62' . substr($wa_num, 1); // 0812 -> 62812
    
    $wa_link = "https://wa.me/{$wa_num}?text=Halo%20Admin%20LP3M,%20saya%20ingin%20bertanya.";
?>

<!-- HERO -->
<section class="contact-hero">
    <h1>Hubungi Kami & FAQ</h1>
    <p>Punya pertanyaan seputar penelitian, pengabdian, atau layanan LP3M? Temukan jawaban cepat atau hubungi tim kami langsung.</p>
</section>

<div class="contact-grid">
    <!-- LEFT: INFO KONTAK -->
    <div>
        <div class="info-card">
            <div class="info-item">
                <div class="info-ico">📍</div>
                <div class="info-text">
                    <h4>Alamat Kantor</h4>
                    <p><?= nl2br(e($address)) ?></p>
                </div>
            </div>
            <div class="info-item">
                <div class="info-ico">✉️</div>
                <div class="info-text">
                    <h4>Email Resmi</h4>
                    <p><a href="mailto:<?= e($email) ?>"><?= e($email) ?></a></p>
                </div>
            </div>
            <div class="info-item">
                <div class="info-ico">📞</div>
                <div class="info-text">
                    <h4>WhatsApp Admin</h4>
                    <p><a href="<?= e($wa_link) ?>" target="_blank">+<?= e($wa_num) ?></a></p>
                </div>
            </div>
            <div class="info-item">
                <div class="info-ico">🕒</div>
                <div class="info-text">
                    <h4>Jam Layanan</h4>
                    <p><?= nl2br(e($hours)) ?></p>
                </div>
            </div>

            <div class="map-container">
                <?php if (!empty($map)): ?>
                    <?= $map ?> <!-- Raw HTML iframe dari database -->
                <?php else: ?>
                    <div class="map-placeholder">🗺️ Peta Lokasi Belum Diatur</div>
                <?php endif; ?>
            </div>

            <div class="quick-actions">
                <a href="<?= e($wa_link) ?>" class="qa-btn" target="_blank">💬 Konsultasi</a>
                <a href="<?= e(url('public/index.php?page=unduhan')) ?>" class="qa-btn">📄 Request Dokumen</a>
            </div>
        </div>
    </div>

    <!-- RIGHT: FAQ -->
    <div class="faq-section">
        <div class="faq-header">
            <span style="font-size:24px;">❓</span>
            <h2>Pertanyaan Umum (FAQ)</h2>
        </div>

        <?php if (empty($faqs)): ?>
            <div style="text-align:center; padding:30px; color:var(--muted); background:rgba(0,0,0,0.02); border-radius:12px;">
                <p style="margin:0;">Belum ada pertanyaan umum yang tersedia.</p>
            </div>
        <?php else: ?>
            <?php foreach ($faqs as $faq): ?>
                <div class="accordion-item">
                    <button class="accordion-header"><?= e($faq['question']) ?></button>
                    <div class="accordion-body">
                        <p><?= nl2br(e($faq['answer'])) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <div style="margin-top:24px; padding:16px; background:rgba(5,150,105,.05); border-radius:12px; border:1px dashed rgba(5,150,105,.3); text-align:center;">
            <p style="margin:0; font-size:13px; color:var(--muted);">Belum menemukan jawaban?</p>
            <a href="<?= e($wa_link) ?>" target="_blank" style="display:inline-block; margin-top:8px; font-weight:700; color:var(--primary); text-decoration:none;">Chat Admin via WhatsApp →</a>
        </div>
    </div>
</div>

<script>
// Accordion Logic
document.querySelectorAll('.accordion-header').forEach(button => {
    button.addEventListener('click', () => {
        const item = button.parentElement;
        const isActive = item.classList.contains('active');
        
        // Close all others (Optional: remove this loop if you want multiple open)
        document.querySelectorAll('.accordion-item').forEach(i => i.classList.remove('active'));
        
        // Toggle current
        if (!isActive) {
            item.classList.add('active');
        }
    });
});
</script>