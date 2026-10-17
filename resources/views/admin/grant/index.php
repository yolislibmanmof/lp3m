<style>
    /* Table Container Dark */
    .grant-table-wrapper {
        background: var(--surface); 
        border-radius: 16px; 
        border: 1px solid var(--border); 
        overflow: hidden; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }
    
    .grant-table { width: 100%; border-collapse: collapse; text-align: left; }
    
    /* Header Gradient Emerald */
    .grant-table th { 
        background: linear-gradient(145deg, #043b2c, #065f46); 
        color: #fde68a; /* Gold text */
        font-weight: 800; 
        text-transform: uppercase; 
        font-size: 11px; 
        letter-spacing: 0.05em; 
        padding: 16px;
        border-bottom: 1px solid rgba(217,164,65,0.2);
    }
    
    .grant-table td {
        padding: 16px;
        border-bottom: 1px solid var(--border);
        color: var(--text); /* Light grey in dark mode */
        vertical-align: middle;
    }
    
    .grant-table tbody tr:last-child td { border-bottom: none; }
    .grant-table tbody tr:hover td { background: rgba(255,255,255,0.03); }

    /* Badges Dark Mode */
    .badge-status { padding: 4px 10px; border-radius: 999px; font-size: 10px; font-weight: 800; text-transform: uppercase; display: inline-block; }
    .badge-open { background: rgba(16, 185, 129, 0.15); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.3); }
    .badge-closing { background: rgba(245, 158, 11, 0.15); color: #fcd34d; border: 1px solid rgba(245, 158, 11, 0.3); }
    .badge-closed { background: rgba(107, 114, 128, 0.15); color: #9ca3af; border: 1px solid rgba(107, 114, 128, 0.3); }

    /* Action Buttons Dark Mode */
    .btn-action { padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s; border: 1px solid transparent; }
    
    .btn-edit { background: rgba(59, 130, 246, 0.1); color: #93c5fd; border-color: rgba(59, 130, 246, 0.2); }
    .btn-edit:hover { background: #2563eb; color: white; border-color: #2563eb; }
    
    .btn-del { background: rgba(239, 68, 68, 0.1); color: #fca5a5; border-color: rgba(239, 68, 68, 0.2); cursor: pointer; }
    .btn-del:hover { background: #dc2626; color: white; border-color: #dc2626; }

    /* Title Text Fix */
    .td-title { font-weight: 700; color: #fff; font-size: 14px; }
    .td-sub { font-size: 12px; color: var(--muted); margin-top: 4px; }
</style>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h2 style="font-family: var(--font-display); font-size: 24px; font-weight: 900; color: #fff; margin: 0;">Manajemen Hibah</h2>
        <p style="color: var(--muted); font-size: 14px; margin: 4px 0 0;">Kelola informasi hibah dan pendanaan yang tampil di publik.</p>
    </div>
    <a href="<?= e(url('admin/index.php?page=hibah-tambah')) ?>" style="background: linear-gradient(145deg, #10b981, #059669); color: white; padding: 10px 20px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3); transition: transform 0.2s; border: 1px solid rgba(255,255,255,0.1);">+ Tambah Hibah</a>
</div>

<?php if (!empty($flash)): ?>
    <div style="padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 600; background: <?= $flash['type'] === 'error' ? 'rgba(239, 68, 68, 0.1)' : 'rgba(16, 185, 129, 0.1)' ?>; color: <?= $flash['type'] === 'error' ? '#fca5a5' : '#6ee7b7' ?>; border: 1px solid <?= $flash['type'] === 'error' ? 'rgba(239, 68, 68, 0.2)' : 'rgba(16, 185, 129, 0.2)' ?>;">
        <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<div class="grant-table-wrapper">
    <table class="grant-table">
        <thead>
            <tr>
                <th>Judul Hibah</th>
                <th>Sumber</th>
                <th>Deadline</th>
                <th>Status</th>
                <th style="text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($items)): ?>
                <tr><td colspan="5" style="padding: 40px; text-align: center; color: var(--muted);">Belum ada data hibah.</td></tr>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td>
                        <div class="td-title"><?= e($item['title']) ?></div>
                        <div class="td-sub"><?= e(ucfirst($item['type'])) ?> · <?= e($item['funding_amount'] ?: '-') ?></div>
                    </td>
                    <td style="font-size: 13px; color: var(--text);"><?= e($item['source']) ?></td>
                    <td style="font-size: 13px; font-weight: 600; color: #fde68a;"><?= date('d M Y', strtotime($item['deadline'])) ?></td>
                    <td>
                        <span class="badge-status badge-<?= e($item['status']) ?>">
                            <?= e(Grant::STATUSES[$item['status']] ?? $item['status']) ?>
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 8px;">
                            <a href="<?= e(url('admin/index.php?page=hibah-edit&id=' . $item['id'])) ?>" class="btn-action btn-edit">✏️ Edit</a>
                            <form method="post" action="<?= e(url('admin/index.php?page=hibah-hapus')) ?>" style="display: inline;" onsubmit="return confirm('Yakin hapus hibah ini?');">
                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-action btn-del">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>