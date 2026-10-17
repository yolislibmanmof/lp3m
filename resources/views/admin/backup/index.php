<style>
    @keyframes bmFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    @keyframes bmShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes bmPulse { 0%,100%{box-shadow:0 0 0 0 rgba(16,185,129,.4)} 50%{box-shadow:0 0 0 8px rgba(16,185,129,0)} }
    @keyframes bmWarn { 0%,100%{box-shadow:0 0 0 0 rgba(245,158,11,.45)} 50%{box-shadow:0 0 0 9px rgba(245,158,11,0)} }

    .bm-head { position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:26px 30px; border-radius:22px; background:linear-gradient(135deg,#0f172a 0%,#1e293b 55%,#334155 100%); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.35); animation:bmFade .5s both; }
    .bm-head::after { content:''; position:absolute; top:-50%; right:-8%; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(103,232,249,.16),transparent 70%); pointer-events:none; }
    .bm-head-ico { width:58px; height:58px; border-radius:17px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:26px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.55),transparent 45%),linear-gradient(145deg,#67e8f9,#06b6d4 55%,#0e7490); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), 0 6px 16px rgba(6,182,212,.4); position:relative; z-index:1; }
    .bm-head h2 { margin:0 0 4px; font-family:var(--font-display); font-size:22px; font-weight:900; position:relative; z-index:1; }
    .bm-head p { margin:0; font-size:12.5px; opacity:.85; position:relative; z-index:1; }
    .bm-head .stat-row { display:flex; gap:8px; flex-wrap:wrap; margin-left:auto; position:relative; z-index:1; }
    .bm-hstat { background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2); border-radius:14px; padding:10px 16px; text-align:center; min-width:92px; backdrop-filter:blur(6px); }
    .bm-hstat b { display:block; font-family:var(--font-display); font-size:17px; font-weight:900; color:#67e8f9; line-height:1.15; }
    .bm-hstat span { font-size:9px; letter-spacing:.12em; text-transform:uppercase; opacity:.8; display:block; margin-top:3px; }

    .bm-grid { display:grid; grid-template-columns:1.35fr 1fr; gap:18px; margin-bottom:20px; }
    @media(max-width:1000px){ .bm-grid{grid-template-columns:1fr;} }
    .bm-panel { position:relative; overflow:hidden; background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px; animation:bmFade .5s .06s both; }
    .bm-panel::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#06b6d4,#10b981,#f2c063); opacity:.85; }
    .bm-panel h3 { display:flex; align-items:center; gap:10px; margin:0 0 18px; font-family:var(--font-display); font-size:15px; font-weight:900; color:#fff; padding-bottom:13px; border-bottom:1px dashed var(--border); }
    .bm-panel h3 .emo { width:34px; height:34px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; background:rgba(6,182,212,.14); }

    .bm-actions { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:18px; }
    .bm-btn { position:relative; overflow:hidden; padding:12px 22px; border:none; border-radius:12px; font-size:13.5px; font-weight:900; cursor:pointer; transition:all .25s; font-family:var(--font-display); display:inline-flex; align-items:center; gap:8px; }
    .bm-btn.gold { color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), 0 6px 16px rgba(217,164,65,.35); }
    .bm-btn.gold::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:bmShine 3s ease-in-out infinite; }
    .bm-btn.teal { color:#03251f; background:linear-gradient(145deg,#67e8f9,#06b6d4 55%,#0e7490); box-shadow:inset 0 2px 3px rgba(255,255,255,.5), 0 6px 16px rgba(6,182,212,.35); }
    .bm-btn:hover { transform:translateY(-2px); filter:brightness(1.05); }
    .bm-note-input { flex:1; min-width:200px; padding:11px 15px; border-radius:12px; border:1px solid var(--border); background:var(--surface); font-size:13px; font-weight:600; color:var(--text); }
    .bm-note-input:focus { outline:none; border-color:#06b6d4; box-shadow:0 0 0 4px rgba(6,182,212,.14); }

    /* Tabel arsip */
    .bm-table { width:100%; border-collapse:collapse; }
    .bm-table th { padding:11px 12px; text-align:left; font-size:10px; font-weight:900; letter-spacing:.12em; text-transform:uppercase; color:var(--muted); border-bottom:1px solid var(--border); }
    .bm-table td { padding:12px; border-bottom:1px solid var(--border); font-size:12.5px; color:var(--text); vertical-align:middle; }
    .bm-table tr:last-child td { border-bottom:none; }
    .bm-table tr:hover td { background:rgba(6,182,212,.04); }
    .bm-file { display:flex; align-items:center; gap:10px; min-width:0; }
    .bm-file .fi { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0; }
    .bm-file .fi.db { background:rgba(6,182,212,.14); }
    .bm-file .fi.files { background:rgba(124,58,237,.14); }
    .bm-file b { display:block; font-size:12px; font-weight:800; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:220px; }
    .bm-file span { font-size:10.5px; color:var(--muted); }
    .bm-mini { padding:6px 10px; border-radius:8px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--muted); font-size:11.5px; cursor:pointer; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:4px; }
    .bm-mini:hover { border-color:rgba(6,182,212,.45); color:#06b6d4; transform:translateY(-2px); }
    .bm-mini.danger:hover { border-color:rgba(220,38,38,.5); color:#fca5a5; }

    /* Maintenance panel */
    .bm-maint { padding:18px; border-radius:16px; border:1px solid var(--border); background:rgba(255,255,255,.02); }
    .bm-maint.on { border-color:rgba(245,158,11,.5); background:rgba(245,158,11,.07); }
    .bm-switch-row { display:flex; align-items:center; gap:14px; margin-bottom:14px; }
    .bm-status { display:inline-flex; align-items:center; gap:8px; padding:6px 14px; border-radius:999px; font-size:11px; font-weight:900; letter-spacing:.08em; }
    .bm-status.on { color:#fcd34d; background:rgba(245,158,11,.15); border:1px solid rgba(245,158,11,.45); }
    .bm-status.on i { width:8px; height:8px; border-radius:50%; background:#f59e0b; animation:bmWarn 2s infinite; }
    .bm-status.off { color:#6ee7b7; background:rgba(16,185,129,.12); border:1px solid rgba(16,185,129,.4); }
    .bm-status.off i { width:8px; height:8px; border-radius:50%; background:#10b981; animation:bmPulse 2s infinite; }
    .bm-switch { position:relative; width:58px; height:30px; flex-shrink:0; cursor:pointer; }
    .bm-switch input { position:absolute; opacity:0; inset:0; cursor:pointer; z-index:2; margin:0; }
    .bm-switch span { position:absolute; inset:0; border-radius:999px; background:rgba(255,255,255,.1); border:1px solid var(--border); transition:all .3s; }
    .bm-switch span::after { content:''; position:absolute; top:3px; left:4px; width:22px; height:22px; border-radius:50%; background:linear-gradient(145deg,#e5e7eb,#9ca3af); transition:all .3s cubic-bezier(.16,1,.3,1); box-shadow:0 2px 6px rgba(0,0,0,.3); }
    .bm-switch input:checked + span { background:rgba(245,158,11,.3); border-color:rgba(245,158,11,.6); }
    .bm-switch input:checked + span::after { left:30px; background:linear-gradient(145deg,#fde68a,#d9a441); }
    .bm-textarea { width:100%; min-height:84px; padding:12px 14px; border-radius:12px; border:1px solid var(--border); background:var(--surface); font-size:13px; color:var(--text); font-family:inherit; line-height:1.6; resize:vertical; margin-bottom:12px; }
    .bm-textarea:focus { outline:none; border-color:#f59e0b; box-shadow:0 0 0 4px rgba(245,158,11,.14); }
    .bm-warn { padding:12px 15px; border-radius:12px; background:rgba(220,38,38,.07); border:1px dashed rgba(220,38,38,.4); font-size:12px; color:#fca5a5; line-height:1.65; margin-bottom:14px; }
    .bm-drop { padding:22px; border-radius:14px; border:2px dashed rgba(6,182,212,.4); background:rgba(6,182,212,.04); text-align:center; }
    .bm-drop input[type=file] { font-size:12px; color:var(--muted); margin:10px 0; }
    .bm-empty { text-align:center; padding:40px 16px; color:var(--muted); font-size:13px; }
</style>

<div class="bm-head">
    <div class="bm-head-ico">💾</div>
    <div style="position:relative;z-index:1;">
        <h2>Backup & Maintenance Center</h2>
        <p>Cadangkan database & file, pulihkan kapan saja, dan kendalikan mode perawatan situs.</p>
    </div>
    <div class="stat-row">
        <div class="bm-hstat"><b><?= e(BackupManager::human($dbSize)) ?></b><span>Ukuran DB</span></div>
        <div class="bm-hstat"><b><?= count($backups) ?></b><span>Arsip</span></div>
        <div class="bm-hstat"><b><?= $last ? e(date('d/m H:i', strtotime($last['created_at']))) : '—' ?></b><span>Backup Terakhir</span></div>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<div class="bm-grid">
    <!-- KIRI: ARSIP BACKUP -->
    <div class="bm-panel">
        <h3><span class="emo">🗄️</span><span>Arsip Backup</span><span style="margin-left:auto;font-size:10px;color:var(--muted);"><?= count($backups) ?> FILE</span></h3>

        <form method="post" action="<?= e(url('admin/index.php?page=backup-buat')) ?>" class="bm-actions">
            <?= csrf_field() ?>
            <input class="bm-note-input" type="text" name="note" placeholder="Catatan backup (opsional)… contoh: sebelum update modul">
            <button class="bm-btn gold" type="submit" onclick="this.disabled=true;this.innerHTML='⏳ Membuat…';this.form.submit();">🗄️ Backup Database Sekarang</button>
            <?php if ($zipOk): ?>
            <button class="bm-btn teal" type="submit" formaction="<?= e(url('admin/index.php?page=backup-zip')) ?>">📦 Backup File Uploads</button>
            <?php endif; ?>
        </form>

        <?php if (empty($backups)): ?>
        <div class="bm-empty">🗃️ Belum ada arsip backup.<br>Klik tombol di atas untuk membuat cadangan pertama Anda.</div>
        <?php else: ?>
        <div style="overflow-x:auto;">
        <table class="bm-table">
            <thead><tr><th>File</th><th>Ukuran</th><th>Isi</th><th>Dibuat</th><th style="width:110px;">Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($backups as $b): ?>
            <tr>
                <td>
                    <div class="bm-file">
                        <span class="fi <?= e($b['kind']) ?>"><?= $b['kind'] === 'db' ? '🗄️' : '📦' ?></span>
                        <div style="min-width:0;">
                            <b><?= e($b['filename']) ?></b>
                            <span><?= !empty($b['note']) ? e($b['note']) : '—' ?> · oleh <?= e($b['created_by'] ?? 'Sistem') ?></span>
                        </div>
                    </div>
                </td>
                <td style="font-weight:800;"><?= e(BackupManager::human((float) $b['size_bytes'])) ?></td>
                <td style="color:var(--muted);"><?= $b['kind'] === 'db' ? (int) $b['tables_count'] . ' tabel' : (int) $b['tables_count'] . ' file' ?></td>
                <td style="color:var(--muted); font-size:11.5px;"><?= e(date('d M Y · H:i', strtotime($b['created_at']))) ?></td>
                <td>
                    <div style="display:flex; gap:5px;">
                        <a class="bm-mini" href="<?= e(url('admin/index.php?page=backup-unduh&id=' . $b['id'])) ?>" title="Unduh">⬇️</a>
                        <form method="post" action="<?= e(url('admin/index.php?page=backup-hapus')) ?>" onsubmit="return confirm('Hapus arsip <?= e($b['filename']) ?>?');">
                            <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $b['id'] ?>">
                            <button class="bm-mini danger" type="submit" title="Hapus">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <?php endif; ?>
    </div>

    <!-- KANAN: MAINTENANCE + RESTORE -->
    <div style="display:flex; flex-direction:column; gap:18px;">
        <div class="bm-panel" style="animation-delay:.1s">
            <h3><span class="emo">🚧</span><span>Mode Maintenance</span></h3>
            <form method="post" action="<?= e(url('admin/index.php?page=backup-maintenance')) ?>">
                <?= csrf_field() ?>
                <div class="bm-maint <?= $maintenance ? 'on' : '' ?>">
                    <div class="bm-switch-row">
                        <label class="bm-switch">
                            <input type="hidden" name="maintenance" value="0">
                            <input type="checkbox" name="maintenance" value="1" <?= $maintenance ? 'checked' : '' ?> onchange="this.form.querySelector('.bm-status').className='bm-status '+(this.checked?'on':'off');">
                            <span></span>
                        </label>
                        <span class="bm-status <?= $maintenance ? 'on' : 'off' ?>"><i></i><?= $maintenance ? 'AKTIF — PUBLIK DITUTUP' : 'NONAKTIF — PUBLIK TERBUKA' ?></span>
                    </div>
                    <label style="display:block;font-size:11px;font-weight:900;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin-bottom:6px;">Pesan untuk Pengunjung</label>
                    <textarea class="bm-textarea" name="message"><?= e($maintenanceMessage) ?></textarea>
                    <button class="bm-btn gold" type="submit" style="width:100%; justify-content:center;">💾 Simpan Pengaturan Maintenance</button>
                </div>
            </form>
            <p style="margin:12px 0 0; font-size:11.5px; color:var(--muted); line-height:1.6;">💡 Saat aktif, seluruh halaman publik menampilkan halaman 503 "Pemeliharaan". Panel admin tetap dapat diakses normal.</p>
        </div>

        <div class="bm-panel" style="animation-delay:.14s">
            <h3><span class="emo">♻️</span><span>Restore Database</span></h3>
            <div class="bm-warn">⚠️ <b>PERHATIAN:</b> Restore akan <b>MENGGANTI SELURUH ISI DATABASE</b> sesuai file backup (termasuk menghapus tabel yang tidak ada di backup). Pastikan Anda sudah mengunduh cadangan terbaru sebelum melanjutkan.</div>
            <form method="post" action="<?= e(url('admin/index.php?page=backup-restore')) ?>" enctype="multipart/form-data" onsubmit="return confirm('RESTORE DATABASE?\nSeluruh data saat ini akan ditimpa oleh isi file backup!');">
                <?= csrf_field() ?>
                <div class="bm-drop">
                    <div style="font-size:34px;">📤</div>
                    <div style="font-size:12.5px; font-weight:800; color:var(--text); margin-top:6px;">Unggah file backup (.sql, maks 25 MB)</div>
                    <input type="file" name="sqlfile" accept=".sql" required>
                    <button class="bm-btn teal" type="submit" style="width:100%; justify-content:center;">♻️ Jalankan Restore</button>
                </div>
            </form>
        </div>
    </div>
</div>