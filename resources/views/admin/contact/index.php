<style>
    @keyframes kcShine { 0%{left:-100%} 100%{left:160%} }
    @keyframes kcFadeUp { from{opacity:0; transform:translateY(14px)} to{opacity:1; transform:none} }
    @keyframes kcDot { 0%,100%{box-shadow:0 0 0 0 rgba(110,231,183,.4)} 50%{box-shadow:0 0 0 4px rgba(110,231,183,0)} }

    /* ===== HEADER ===== */
    .kc-head { display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:22px; animation:kcFadeUp .5s ease both; flex-wrap:wrap; }
    .kc-head-left { display:flex; align-items:center; gap:14px; }
    .kc-head-ico { width:52px; height:52px; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:24px; background:radial-gradient(circle at 30% 25%, rgba(255,255,255,.5), transparent 40%), linear-gradient(145deg,#5eead4,#14b8a6 50%,#0f766e); box-shadow: inset 0 2px 3px rgba(255,255,255,.6), inset 0 -3px 4px rgba(0,0,0,.25), 0 6px 14px rgba(20,184,166,.35); position:relative; flex-shrink:0; }
    .kc-head-ico::before { content:''; position:absolute; top:5px; left:10px; width:16px; height:7px; border-radius:50%; background:rgba(255,255,255,.6); filter:blur(1.5px); }
    .kc-title { font-family:var(--font-display); font-size:24px; font-weight:900; color:#fff; margin:0; }
    .kc-sub { color:var(--muted); font-size:13px; margin:3px 0 0; }

    .kc-btn-add { position:relative; overflow:hidden; display:inline-flex; align-items:center; gap:8px; background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441); color:#03251f; padding:11px 20px; border-radius:12px; text-decoration:none; font-weight:800; font-size:13px; box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.15), 0 8px 18px rgba(217,164,65,.35); transition:all .25s; }
    .kc-btn-add:hover { transform:translateY(-2px); box-shadow:0 12px 26px rgba(217,164,65,.45); }
    .kc-btn-add::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.6),transparent); transition:left .6s; }
    .kc-btn-add:hover::after { left:160%; }

    /* ===== TABS ===== */
    .kc-tabs { display:flex; gap:10px; margin-bottom:22px; border-bottom:1px solid var(--border); }
    .kc-tab { position:relative; display:inline-flex; align-items:center; gap:8px; padding:10px 18px; font-size:13px; font-weight:800; color:var(--muted); text-decoration:none; border:1px solid transparent; border-bottom:none; border-radius:12px 12px 0 0; transition:all .25s; }
    .kc-tab:hover { color:#fff; background:rgba(255,255,255,.04); }
    .kc-tab.active { color:#6ee7b7; background:rgba(16,185,129,.10); border-color:rgba(16,185,129,.30); }
    .kc-tab.active::after { content:''; position:absolute; left:0; right:0; bottom:-1px; height:2px; background:linear-gradient(90deg,#10b981,#f2c063); }
    .kc-tab-count { font-size:10px; font-weight:900; padding:2px 8px; border-radius:999px; background:rgba(255,255,255,.08); color:var(--muted); }
    .kc-tab.active .kc-tab-count { background:rgba(16,185,129,.2); color:#6ee7b7; }

    /* ===== FLASH ===== */
    .kc-flash { display:flex; align-items:center; gap:10px; position:relative; overflow:hidden; padding:13px 18px; border-radius:14px; margin-bottom:20px; font-size:14px; font-weight:700; animation:kcFadeUp .4s ease both; }
    .kc-flash.ok { background:rgba(16,185,129,.12); color:#6ee7b7; border:1px solid rgba(16,185,129,.3); }
    .kc-flash.err { background:rgba(239,68,68,.12); color:#fca5a5; border:1px solid rgba(239,68,68,.3); }
    .kc-flash::after { content:''; position:absolute; top:0; left:-100%; width:50%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.15),transparent); animation:kcShine 2.8s ease-in-out infinite; }

    /* ===== CARD & FORM ===== */
    .kc-card { position:relative; background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:30px; box-shadow:0 10px 30px rgba(0,0,0,.2); max-width:880px; animation:kcFadeUp .5s .05s ease both; }
    .kc-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; border-radius:20px 20px 0 0; background:linear-gradient(90deg,#f2c063,#10b981,#f2c063); opacity:.7; }
    .kc-section-title { display:flex; align-items:center; gap:10px; font-size:14px; font-weight:800; color:#fff; margin:0 0 18px; font-family:var(--font-display); }
    .kc-section-title::before { content:''; width:8px; height:8px; border-radius:50%; background:radial-gradient(circle at 30% 30%, #fde68a, #d9a441); box-shadow:0 0 10px rgba(217,164,65,.6); }

    .kc-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    .kc-group { display:flex; flex-direction:column; gap:8px; }
    .kc-group.full { grid-column:span 2; }
    .kc-label { font-size:11px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; color:#f2c063; display:flex; align-items:center; gap:6px; }
    .kc-input { padding:12px 16px; border-radius:12px; border:1px solid var(--border); background:rgba(255,255,255,.05); color:#fff; font-size:14px; transition:all .25s; font-family:inherit; width:100%; box-sizing:border-box; }
    .kc-input:focus { outline:none; border-color:#10b981; background:rgba(255,255,255,.08); box-shadow:0 0 0 3px rgba(16,185,129,.18), 0 4px 14px rgba(0,0,0,.2); }
    .kc-input::placeholder { color:rgba(255,255,255,.3); }
    textarea.kc-input { resize:vertical; min-height:100px; }
    .kc-hint { color:var(--muted); font-size:11px; }

    .kc-btn-primary { position:relative; overflow:hidden; background:linear-gradient(145deg,#34d399,#10b981 50%,#059669); color:#fff; padding:12px 26px; border-radius:12px; border:none; font-weight:800; font-size:14px; cursor:pointer; box-shadow: inset 0 2px 3px rgba(255,255,255,.4), inset 0 -2px 3px rgba(0,0,0,.2), 0 8px 18px rgba(5,150,105,.35); transition:all .25s; }
    .kc-btn-primary:hover { transform:translateY(-2px); box-shadow:0 12px 26px rgba(5,150,105,.45); }
    .kc-btn-primary::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); transition:left .6s; }
    .kc-btn-primary:hover::after { left:160%; }

    /* ===== TABLE FAQ ===== */
    .kc-table { width:100%; border-collapse:collapse; text-align:left; }
    .kc-table th { background:linear-gradient(145deg, rgba(5,150,105,.12), rgba(5,150,105,.05)); color:#6ee7b7; font-weight:800; text-transform:uppercase; font-size:10.5px; letter-spacing:.08em; padding:14px 16px; border-bottom:1px solid var(--border); }
    .kc-table td { padding:16px; border-bottom:1px solid var(--border); vertical-align:middle; }
    .kc-table tbody tr { transition:background .2s; }
    .kc-table tbody tr:hover { background:rgba(255,255,255,.03); }
    .kc-table tbody tr:last-child td { border-bottom:none; }
    .kc-order { display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:10px; font-weight:900; font-size:12px; color:#03251f; background:radial-gradient(circle at 30% 25%, rgba(255,255,255,.5), transparent 40%), linear-gradient(145deg,#fde68a,#f2c063 50%,#d9a441); box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.2), 0 3px 8px rgba(217,164,65,.3); }
    .kc-q { font-weight:700; color:#fff; margin-bottom:4px; font-size:14px; }
    .kc-a { font-size:12px; color:var(--muted); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:520px; }
    .kc-badge { display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:999px; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.05em; }
    .kc-badge::before { content:''; width:6px; height:6px; border-radius:50%; }
    .kc-badge.on { background:rgba(16,185,129,.15); color:#6ee7b7; border:1px solid rgba(16,185,129,.3); }
    .kc-badge.on::before { background:#6ee7b7; animation:kcDot 2s infinite; }
    .kc-badge.off { background:rgba(107,114,128,.15); color:#9ca3af; border:1px solid rgba(107,114,128,.3); }
    .kc-badge.off::before { background:#9ca3af; }
    .kc-act { padding:7px 12px; border-radius:9px; font-size:12px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:5px; transition:all .2s; border:1px solid transparent; cursor:pointer; font-family:inherit; }
    .kc-act.edit { background:rgba(59,130,246,.12); color:#93c5fd; border-color:rgba(59,130,246,.25); }
    .kc-act.edit:hover { background:#2563eb; color:#fff; transform:translateY(-1px); }
    .kc-act.del { background:rgba(239,68,68,.12); color:#fca5a5; border-color:rgba(239,68,68,.25); }
    .kc-act.del:hover { background:#dc2626; color:#fff; transform:translateY(-1px); }
    .kc-empty { text-align:center; padding:50px 20px; color:var(--muted); }
    .kc-empty .emo { font-size:40px; display:block; margin-bottom:10px; }

    @media (max-width:700px) {
        .kc-grid { grid-template-columns:1fr; }
        .kc-group.full { grid-column:span 1; }
        .kc-a { max-width:220px; }
    }
</style>

<!-- ===== HEADER ===== -->
<div class="kc-head">
    <div class="kc-head-left">
        <div class="kc-head-ico">📞</div>
        <div>
            <h2 class="kc-title">Kontak & FAQ</h2>
            <p class="kc-sub">Kelola informasi kontak lembaga dan pertanyaan umum.</p>
        </div>
    </div>
    <?php if ($activeTab === 'faq'): ?>
        <a href="<?= e(url('admin/index.php?page=kontak-faq-tambah')) ?>" class="kc-btn-add">＋ Tambah FAQ</a>
    <?php endif; ?>
</div>

<!-- ===== TABS ===== -->
<div class="kc-tabs">
    <a href="<?= e(url('admin/index.php?page=kontak&tab=contact')) ?>" class="kc-tab <?= $activeTab === 'contact' ? 'active' : '' ?>">📍 Info Kontak</a>
    <a href="<?= e(url('admin/index.php?page=kontak&tab=faq')) ?>" class="kc-tab <?= $activeTab === 'faq' ? 'active' : '' ?>">❓ Daftar FAQ <span class="kc-tab-count"><?= count($faqs) ?></span></a>
</div>

<?php if (!empty($flash)): ?>
    <div class="kc-flash <?= $flash['type'] === 'error' ? 'err' : 'ok' ?>">
        <span><?= $flash['type'] === 'error' ? '⚠️' : '✅' ?></span>
        <span><?= e($flash['message']) ?></span>
    </div>
<?php endif; ?>

<?php if ($activeTab === 'contact'): ?>

    <!-- ============ FORM KONTAK ============ -->
    <div class="kc-card">
        <form method="post" action="<?= e(url('admin/index.php?page=kontak-simpan')) ?>">
            <?= csrf_field() ?>

            <h3 class="kc-section-title">Informasi Dasar</h3>
            <div class="kc-grid">
                <div class="kc-group full">
                    <label class="kc-label">📍 Alamat Lengkap</label>
                    <textarea name="address" class="kc-input" placeholder="Contoh: Kampus UNIMOF, Jl. Wairklau..."><?= e($contact['address'] ?? '') ?></textarea>
                </div>

                <div class="kc-group">
                    <label class="kc-label">📞 Nomor Telepon Kantor</label>
                    <input type="text" name="phone" class="kc-input" value="<?= e($contact['phone'] ?? '') ?>" placeholder="+62 ...">
                </div>

                <div class="kc-group">
                    <label class="kc-label">💬 Nomor WhatsApp (628...)</label>
                    <input type="text" name="whatsapp" class="kc-input" value="<?= e($contact['whatsapp'] ?? '') ?>" placeholder="6281234567890">
                </div>

                <div class="kc-group">
                    <label class="kc-label">✉️ Email Resmi</label>
                    <input type="email" name="email" class="kc-input" value="<?= e($contact['email'] ?? '') ?>" placeholder="lp3m@unimof.ac.id">
                </div>

                <div class="kc-group">
                    <label class="kc-label">🕒 Jam Operasional</label>
                    <input type="text" name="office_hours" class="kc-input" value="<?= e($contact['office_hours'] ?? '') ?>" placeholder="Senin - Jumat: 08.00 - 16.00">
                </div>
            </div>

            <div style="height:26px;"></div>
            <h3 class="kc-section-title">Lokasi & Peta</h3>
            <div class="kc-grid">
                <div class="kc-group full">
                    <label class="kc-label">🗺️ Embed Google Maps (Iframe)</label>
                    <textarea name="map_embed" class="kc-input" rows="4" placeholder="<iframe src='...' ...></iframe>"><?= e($contact['map_embed'] ?? '') ?></textarea>
                    <small class="kc-hint">Paste kode embed dari Google Maps (Share → Embed a map). Kosongkan jika tidak ingin menampilkan peta.</small>
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; margin-top:26px; padding-top:20px; border-top:1px solid var(--border);">
                <button type="submit" class="kc-btn-primary">💾 Simpan Perubahan</button>
            </div>
        </form>
    </div>

<?php else: ?>

    <!-- ============ LIST FAQ ============ -->
    <div class="kc-card" style="max-width:none; padding:0; overflow:hidden;">
        <table class="kc-table">
            <thead>
                <tr>
                    <th style="width:70px; text-align:center;">Urutan</th>
                    <th>Pertanyaan</th>
                    <th style="width:110px;">Status</th>
                    <th style="width:140px; text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($faqs)): ?>
                    <tr>
                        <td colspan="4">
                            <div class="kc-empty">
                                <span class="emo">💬</span>
                                Belum ada data FAQ. Klik <strong>＋ Tambah FAQ</strong> untuk membuat pertanyaan pertama.
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($faqs as $faq): ?>
                    <tr>
                        <td style="text-align:center;"><span class="kc-order"><?= (int) $faq['sort_order'] ?></span></td>
                        <td>
                            <div class="kc-q"><?= e($faq['question']) ?></div>
                            <div class="kc-a"><?= e($faq['answer']) ?></div>
                        </td>
                        <td>
                            <span class="kc-badge <?= $faq['is_active'] ? 'on' : 'off' ?>">
                                <?= $faq['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex; justify-content:flex-end; gap:8px;">
                                <a href="<?= e(url('admin/index.php?page=kontak-faq-edit&id=' . $faq['id'])) ?>" class="kc-act edit">✏️ Edit</a>
                                <form method="post" action="<?= e(url('admin/index.php?page=kontak-faq-hapus')) ?>" style="display:inline;" onsubmit="return confirm('Yakin hapus FAQ ini?');">
                                    <input type="hidden" name="id" value="<?= $faq['id'] ?>">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="kc-act del">🗑️ Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>