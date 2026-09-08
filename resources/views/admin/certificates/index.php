<style>
    .cert-head { display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; padding:22px 26px; margin-bottom:24px; border-radius:22px; background:linear-gradient(145deg,#043b2c,#065f46); color:#fff; position:relative; overflow:hidden; box-shadow:0 12px 32px rgba(0,0,0,.25); }
    .cert-head-ico { width:54px; height:54px; border-radius:16px; flex-shrink:0; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.5),transparent 40%),linear-gradient(145deg,#fde68a,#f2c063 50%,#d9a441); display:flex; align-items:center; justify-content:center; font-size:26px; box-shadow:inset 0 2px 3px rgba(255,255,255,.7),inset 0 -3px 4px rgba(0,0,0,.2),0 6px 14px rgba(217,164,65,.4); }
    .cert-title { font-family:var(--font-display); font-size:22px; font-weight:900; margin:0; background:linear-gradient(135deg,#fff,#fde68a); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .cert-table { width:100%; border-collapse:separate; border-spacing:0; background:var(--white); border:1px solid var(--border); border-radius:20px; overflow:hidden; box-shadow:0 6px 20px rgba(0,0,0,.05); }
    .cert-table thead th { padding:14px 16px; text-align:left; font-size:11px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:#fde68a; background:linear-gradient(145deg,#043b2c,#065f46); }
    .cert-table tbody td { padding:14px 16px; font-size:13px; color:var(--ink); border-bottom:1px solid var(--border); vertical-align:middle; }
    .cert-table tbody tr:last-child td { border-bottom:none; }
    .cert-table tbody tr:hover td { background:rgba(217,164,65,.05); }
    .cert-mono { font-family:'Courier New',monospace; font-weight:800; font-size:12.5px; color:#047857; background:rgba(5,150,105,.08); border:1px solid rgba(5,150,105,.25); padding:3px 8px; border-radius:8px; display:inline-block; }
    .cert-type { display:inline-flex; padding:3px 10px; border-radius:999px; font-size:10px; font-weight:800; background:rgba(59,130,246,.1); border:1px solid rgba(59,130,246,.3); color:#1e40af; }
    .cert-status { display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:800; }
    .cert-status.valid { background:linear-gradient(145deg,#6ee7b7,#10b981); color:#064e3b; box-shadow:inset 0 1px 2px rgba(255,255,255,.6); }
    .cert-status.revoked { background:linear-gradient(145deg,#fca5a5,#dc2626); color:#fff; box-shadow:inset 0 1px 2px rgba(255,255,255,.4); }
    .cert-act { padding:6px 12px; border-radius:9px; font-size:11.5px; font-weight:800; text-decoration:none; display:inline-flex; align-items:center; gap:4px; border:1px solid transparent; cursor:pointer; transition:all .2s; font-family:inherit; }
    .cert-act.view { background:rgba(59,130,246,.1); color:#93c5fd; border-color:rgba(59,130,246,.25); }
    .cert-act.view:hover { background:#2563eb; color:#fff; }
    .cert-act.edit { background:rgba(217,164,65,.12); color:#b45309; border-color:rgba(217,164,65,.3); }
    .cert-act.edit:hover { background:#d9a441; color:#03251f; }
    .cert-act.revoke { background:rgba(220,38,38,.1); color:#fca5a5; border-color:rgba(220,38,38,.25); }
    .cert-act.revoke:hover { background:#dc2626; color:#fff; }
    .cert-act.restore { background:rgba(16,185,129,.12); color:#6ee7b7; border-color:rgba(16,185,129,.3); }
    .cert-act.restore:hover { background:#059669; color:#fff; }
    .cert-empty { padding:40px 20px; text-align:center; color:var(--muted); font-weight:600; }
    .cert-empty span { font-size:40px; display:block; margin-bottom:10px; }
</style>

<div class="cert-head">
    <div style="display:flex; align-items:center; gap:16px; position:relative; z-index:1;">
        <div class="cert-head-ico">🎓</div>
        <div>
            <h2 class="cert-title">Sertifikat & Verifikasi</h2>
            <span style="display:inline-flex; padding:4px 12px; border-radius:999px; margin-top:6px; font-size:11px; font-weight:800; background:rgba(217,164,65,.25); border:1px solid rgba(217,164,65,.4); color:#fde68a;">📜 Total <?= (int) $total ?> sertifikat</span>
        </div>
    </div>
    <a href="<?= e(url('admin/index.php?page=sertifikat-tambah')) ?>" style="position:relative; padding:12px 22px; border-radius:13px; font-size:13.5px; font-weight:800; color:#03251f; text-decoration:none; background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441); box-shadow:inset 0 2px 3px rgba(255,255,255,.7),inset 0 -2px 3px rgba(0,0,0,.15),0 8px 20px rgba(217,164,65,.4);">🎓 Terbitkan Sertifikat</a>
</div>

<?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>" style="position:relative; padding:14px 18px; margin-bottom:20px; border-radius:14px; font-size:13.5px; font-weight:700; display:flex; align-items:center; gap:10px; <?= $flash['type'] === 'error' ? 'background:linear-gradient(145deg,#fee2e2,#fecaca); border:1px solid rgba(220,38,38,.35); color:#991b1b;' : 'background:linear-gradient(145deg,#d1fae5,#a7f3d0); border:1px solid rgba(16,185,129,.35); color:#065f46;' ?>">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<form method="get" action="<?= e(url('admin/index.php')) ?>" style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px; padding:16px; border-radius:18px; background:var(--white); border:1px solid var(--border);">
    <input type="hidden" name="page" value="sertifikat">
    <input type="text" name="q" value="<?= e($filters['q']) ?>" placeholder="🔍 Cari kode / nama / kegiatan..." style="flex:1; min-width:200px; padding:11px 15px; border-radius:12px; border:2px solid var(--border); background:linear-gradient(145deg,#f6faf7,#fff); font-size:13px; font-weight:600; color:var(--ink);">
    <select name="status" style="padding:11px 15px; border-radius:12px; border:2px solid var(--border); background:#fff; font-size:13px; font-weight:600; color:var(--ink); cursor:pointer;">
        <option value="">Semua Status</option>
        <option value="valid" <?= $filters['status'] === 'valid' ? 'selected' : '' ?>>✅ Valid</option>
        <option value="revoked" <?= $filters['status'] === 'revoked' ? 'selected' : '' ?>>🚫 Dicabut</option>
    </select>
    <button type="submit" style="padding:11px 20px; border-radius:12px; border:none; cursor:pointer; font-size:13px; font-weight:800; color:#fff; background:linear-gradient(145deg,#34d399,#10b981 50%,#059669);">🔍 Filter</button>
</form>

<div style="overflow-x:auto;">
    <table class="cert-table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Penerima</th>
                <th>Kegiatan</th>
                <th>Terbit</th>
                <th>Status</th>
                <th style="text-align:right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($items === []): ?>
                <tr><td colspan="6"><div class="cert-empty"><span>🎓</span>Belum ada sertifikat diterbitkan.</div></td></tr>
            <?php endif; ?>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><span class="cert-mono"><?= e($item['code']) ?></span></td>
                    <td>
                        <strong><?= e($item['holder_name']) ?></strong>
                        <?php if (!empty($item['holder_identity'])): ?>
                            <div style="font-size:11px; color:var(--muted);"><?= e($item['holder_identity']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= e(excerpt($item['activity_title'], 60)) ?>
                        <div style="margin-top:4px;"><span class="cert-type"><?= e($types[$item['activity_type']] ?? ucfirst($item['activity_type'])) ?></span></div>
                    </td>
                    <td>📅 <?= e(date('d M Y', strtotime($item['issue_date']))) ?></td>
                    <td>
                        <span class="cert-status <?= $item['status'] === 'valid' ? 'valid' : 'revoked' ?>">
                            <?= $item['status'] === 'valid' ? '✅ VALID' : '🚫 DICABUT' ?>
                        </span>
                        <?php if ($item['status'] === 'revoked' && !empty($item['revoke_reason'])): ?>
                            <div style="font-size:10.5px; color:var(--muted); margin-top:4px; max-width:140px;">Alasan: <?= e(excerpt($item['revoke_reason'], 40)) ?></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display:flex; gap:6px; justify-content:flex-end; flex-wrap:wrap;">
                            <a class="cert-act edit" target="_blank" href="<?= e(url('public/index.php?page=sertifikat&code=' . urlencode($item['code']))) ?>">🖨️ Cetak</a>
                            <a class="cert-act view" target="_blank" href="<?= e(url('public/index.php?page=verifikasi-sertifikat&code=' . urlencode($item['code']))) ?>">🔗 Verifikasi</a> <a class="cert-act view" target="_blank" href="<?= e(url('public/index.php?page=verifikasi-sertifikat&code=' . urlencode($item['code']))) ?>">🔗 Verifikasi</a>
                            <a class="cert-act edit" href="<?= e(url('admin/index.php?page=sertifikat-edit&id=' . (int) $item['id'])) ?>">✏️ Edit</a>
                            <?php if ($item['status'] === 'valid'): ?>
                                <form method="post" action="<?= e(url('admin/index.php?page=sertifikat-cabut')) ?>" class="js-confirm" data-message="Cabut sertifikat <?= e($item['code']) ?>? Status akan jadi TIDAK VALID di halaman verifikasi." style="display:inline;">
                                    <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                                    <input type="hidden" name="reason" value="Dicabut oleh admin">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="cert-act revoke">🚫 Cabut</button>
                                </form>
                            <?php else: ?>
                                <form method="post" action="<?= e(url('admin/index.php?page=sertifikat-aktifkan')) ?>" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="cert-act restore">✅ Aktifkan</button>
                                </form>
                            <?php endif; ?>
                            <form method="post" action="<?= e(url('admin/index.php?page=sertifikat-hapus')) ?>" class="js-confirm" data-message="Hapus permanen sertifikat <?= e($item['code']) ?>?" style="display:inline;">
                                <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                                <?= csrf_field() ?>
                                <button type="submit" class="cert-act revoke">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if ($totalPages > 1): ?>
    <div style="display:flex; gap:6px; flex-wrap:wrap; margin-top:22px;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= e(url('admin/index.php?page=sertifikat&hal=' . $i . ($filters['q'] !== '' ? '&q=' . urlencode($filters['q']) : '') . ($filters['status'] !== '' ? '&status=' . urlencode($filters['status']) : ''))) ?>" style="padding:9px 14px; border-radius:11px; text-decoration:none; font-size:13px; font-weight:800; color:var(--ink); background:linear-gradient(145deg,#fff,#f6faf7); border:1px solid var(--border); <?= $i === $page ? 'background:linear-gradient(145deg,#065f46,#043b2c); color:#fde68a; border-color:transparent;' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>