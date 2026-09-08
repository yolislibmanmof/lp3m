<style>
    .grant-hero { position:relative; overflow:hidden; border-radius:28px; padding:56px 44px; margin-bottom:40px; color:#fff; background:linear-gradient(135deg,#7c2d12 0%,#ea580c 50%,#f59e0b 100%); box-shadow:0 24px 60px rgba(124,45,18,.3); }
    .grant-hero h1 { font-family:var(--font-display); font-size:clamp(28px,4vw,42px); font-weight:900; margin:0 0 12px; position:relative; z-index:2; }
    .grant-hero p { opacity:.9; max-width:600px; font-size:16px; line-height:1.6; position:relative; z-index:2; }
    
    .grant-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(320px, 1fr)); gap:24px; margin-bottom:40px; }
    .grant-card { background:#fff; border:1px solid var(--border); border-radius:20px; padding:24px; position:relative; overflow:hidden; transition:all .3s; display:flex; flex-direction:column; }
    .grant-card:hover { transform:translateY(-6px); box-shadow:0 20px 40px rgba(0,0,0,.08); border-color:rgba(234,88,12,.3); }
    
    /* Urgency Badge */
    .grant-badge { display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:.05em; margin-bottom:16px; width:fit-content; }
    .badge-open { background:rgba(5,150,105,.1); color:#059669; border:1px solid rgba(5,150,105,.2); }
    .badge-closing { background:rgba(234,88,12,.1); color:#ea580c; border:1px solid rgba(234,88,12,.2); animation: pulse-orange 2s infinite; }
    
    @keyframes pulse-orange { 0%{box-shadow:0 0 0 0 rgba(234,88,12,.4)} 70%{box-shadow:0 0 0 10px rgba(234,88,12,0)} 100%{box-shadow:0 0 0 0 rgba(234,88,12,0)} }

    .grant-source { font-size:12px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.05em; margin-bottom:8px; }
    .grant-title { font-family:var(--font-display); font-size:18px; font-weight:800; color:var(--ink); margin:0 0 12px; line-height:1.4; }
    .grant-meta { display:flex; flex-direction:column; gap:8px; margin-bottom:20px; font-size:13px; color:var(--text); }
    .grant-meta span { display:flex; align-items:center; gap:8px; }
    .grant-funding { font-weight:800; color:#059669; font-size:15px; }
    
    .grant-deadline { margin-top:auto; padding-top:16px; border-top:1px dashed var(--border); display:flex; justify-content:space-between; align-items:center; }
    .deadline-text { font-size:12px; font-weight:700; color:#ea580c; }
    .btn-grant { padding:8px 16px; border-radius:10px; background:linear-gradient(145deg,#ea580c,#c2410c); color:#fff; text-decoration:none; font-size:12px; font-weight:700; transition:transform .2s; }
    .btn-grant:hover { transform:scale(1.05); }
    .btn-guide { padding:8px 16px; border-radius:10px; background:rgba(5,150,105,.1); color:#059669; text-decoration:none; font-size:12px; font-weight:700; border:1px solid rgba(5,150,105,.2); }
</style>

<section class="grant-hero">
    <h1>🔥 Hibah & Pendanaan Aktif</h1>
    <p>Jangan lewatkan kesempatan pendanaan penelitian dan pengabdian. Cek deadline dan segera ajukan proposal Anda!</p>
</section>

<?php if (empty($active)): ?>
    <div style="text-align:center; padding:60px 20px; background:#fff; border-radius:20px; border:2px dashed var(--border);">
        <div style="font-size:48px; margin-bottom:16px;">📭</div>
        <h3 style="color:var(--ink); margin:0 0 8px;">Belum Ada Hibah Aktif</h3>
        <p style="color:var(--muted);">Silakan cek kembali nanti atau hubungi admin LP3M.</p>
    </div>
<?php else: ?>
    <div class="grant-grid">
        <?php foreach ($active as $g): ?>
            <?php 
                // Hitung sisa hari
                $now = new DateTime();
                $end = new DateTime($g['deadline']);
                $diff = $now->diff($end);
                $daysLeft = $diff->days;
                $isClosing = ($g['status'] === 'closing_soon' || $daysLeft <= 7);
            ?>
            <div class="grant-card">
                <span class="grant-badge <?= $isClosing ? 'badge-closing' : 'badge-open' ?>">
                    <?= $isClosing ? '⚠️ Segera Tutup' : '✅ Dibuka' ?>
                </span>
                
                <div class="grant-source"><?= e($g['source']) ?></div>
                <h3 class="grant-title"><?= e($g['title']) ?></h3>
                
                <div class="grant-meta">
                    <span>🏷️ <?= e(ucfirst($g['type'])) ?></span>
                    <?php if (!empty($g['funding_amount'])): ?>
                        <span class="grant-funding">💰 <?= e($g['funding_amount']) ?></span>
                    <?php endif; ?>
                    <span>📅 Deadline: <?= e(date('d M Y', strtotime($g['deadline']))) ?></span>
                </div>

                <div class="grant-deadline">
                    <span class="deadline-text">
                        <?= $daysLeft > 0 ? "Sisa $daysLeft hari" : "Tutup hari ini!" ?>
                    </span>
                    <div style="display:flex; gap:8px;">
                        <?php if (!empty($g['link_proposal'])): ?>
                            <a href="<?= e($g['link_proposal']) ?>" target="_blank" class="btn-guide">📄 Panduan</a>
                        <?php endif; ?>
                        <?php if (!empty($g['link_registration'])): ?>
                            <a href="<?= e($g['link_registration']) ?>" target="_blank" class="btn-grant">Daftar →</a>
                        <?php else: ?>
                            <span style="font-size:11px; color:var(--muted); align-self:center;">Via Admin</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!empty($closed)): ?>
    <section style="margin-top:60px;">
        <h3 style="font-family:var(--font-display); color:var(--muted); margin-bottom:20px; font-size:18px;">📂 Arsip Hibah (Baru-baru ini)</h3>
        <div style="display:flex; flex-direction:column; gap:12px;">
            <?php foreach ($closed as $g): ?>
                <div style="padding:16px 20px; background:#f9fafb; border:1px solid var(--border); border-radius:12px; display:flex; justify-content:space-between; align-items:center; opacity:.7;">
                    <div>
                        <div style="font-weight:700; color:var(--ink);"><?= e($g['title']) ?></div>
                        <div style="font-size:12px; color:var(--muted);">Tutup pada <?= e(date('d M Y', strtotime($g['deadline']))) ?></div>
                    </div>
                    <span style="font-size:11px; font-weight:700; color:#dc2626; background:rgba(220,38,38,.1); padding:4px 10px; border-radius:6px;">CLOSED</span>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>