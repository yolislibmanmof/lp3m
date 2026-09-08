<style>
    @keyframes docListShine { 0%{transform:translateX(-100%) skewX(-20deg)} 100%{transform:translateX(300%) skewX(-20deg)} }

    .doc-list-head {
        display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;
        padding: 22px 26px; margin-bottom: 24px; border-radius: 22px;
        background: linear-gradient(145deg, #043b2c, #065f46);
        color: white; position: relative; overflow: hidden;
        box-shadow: 0 12px 32px rgba(0,0,0,0.25);
    }
    .doc-list-head::before {
        content: ''; position: absolute; inset: 0;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 25px, rgba(217,164,65,0.04) 25px, rgba(217,164,65,0.04) 26px),
            repeating-linear-gradient(-45deg, transparent, transparent 25px, rgba(217,164,65,0.04) 25px, rgba(217,164,65,0.04) 26px);
    }
    .doc-list-ico {
        width: 54px; height: 54px; border-radius: 16px; flex-shrink: 0;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 40%),
                    linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441);
        display: flex; align-items: center; justify-content: center;
        font-size: 26px; position: relative;
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -3px 4px rgba(0,0,0,0.2), 0 6px 14px rgba(217,164,65,0.4);
    }
    .doc-list-ico::before {
        content: ''; position: absolute; top: 5px; left: 10px;
        width: 16px; height: 7px; border-radius: 50%;
        background: rgba(255,255,255,0.65); filter: blur(1.5px);
    }
    .doc-list-title {
        font-family: var(--font-display); font-size: 22px; font-weight: 900;
        letter-spacing: -0.02em; margin: 0;
        background: linear-gradient(135deg, #fff 0%, #fde68a 100%);
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .doc-list-count {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 12px; border-radius: 999px; margin-top: 6px;
        font-size: 11px; font-weight: 800;
        background: rgba(217,164,65,0.25); border: 1px solid rgba(217,164,65,0.4);
        color: #fde68a;
    }
    .btn-add-3d {
        position: relative; padding: 12px 22px; border-radius: 13px;
        font-size: 13.5px; font-weight: 800; color: #03251f; text-decoration: none;
        background: linear-gradient(145deg, #fde68a, #f2c063 40%, #d9a441 80%, #a9761b);
        overflow: hidden; transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.7), inset 0 -2px 3px rgba(0,0,0,0.15), 0 8px 20px rgba(217,164,65,0.4);
    }
    .btn-add-3d::before {
        content: ''; position: absolute; top: 3px; left: 10%;
        width: 35%; height: 35%; border-radius: 50%;
        background: rgba(255,255,255,0.6); filter: blur(2px);
    }
    .btn-add-3d::after {
        content: ''; position: absolute; top: 0; left: -100%;
        width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,0.5), transparent);
        animation: docListShine 3s ease-in-out infinite;
    }
    .btn-add-3d:hover { transform: translateY(-2px); box-shadow: inset 0 2px 3px rgba(255,255,255,0.8), 0 14px 30px rgba(217,164,65,0.55); }

    .flash-3d {
        position: relative; padding: 14px 18px; margin-bottom: 20px;
        border-radius: 14px; font-size: 13.5px; font-weight: 700;
        display: flex; align-items: center; gap: 10px; overflow: hidden;
        box-shadow: inset 0 1px 2px rgba(255,255,255,0.7), inset 0 -2px 3px rgba(0,0,0,0.05), 0 4px 12px rgba(0,0,0,0.1);
    }
    .flash-3d::after {
        content: ''; position: absolute; top: 0; left: -100%;
        width: 60%; height: 100%;
        background: linear-gradient(105deg, transparent, rgba(255,255,255,0.5), transparent);
        animation: docListShine 3s ease-in-out infinite;
    }
    .flash-success-3d { background: linear-gradient(145deg, #d1fae5, #a7f3d0); border: 1px solid rgba(16,185,129,0.35); color: #065f46; }
    .flash-error-3d { background: linear-gradient(145deg, #fee2e2, #fecaca); border: 1px solid rgba(220,38,38,0.35); color: #991b1b; }

    .filter-3d {
        display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px;
        padding: 18px; border-radius: 18px;
        background: var(--white); border: 1px solid var(--border);
        box-shadow: 0 4px 14px rgba(0,0,0,0.04);
    }
    .filter-3d input[type="text"], .filter-3d select {
        padding: 11px 15px; border-radius: 12px;
        border: 2px solid var(--border);
        background: linear-gradient(145deg, #f6faf7, #ffffff);
        font-size: 13px; font-weight: 600; color: var(--ink);
        transition: all 0.25s;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.04);
    }
    .filter-3d input[type="text"] { flex: 1; min-width: 200px; }
    .filter-3d select {
        appearance: none; -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23059669' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 14px center;
        padding-right: 38px; cursor: pointer;
    }
    .filter-3d input:focus, .filter-3d select:focus {
        outline: none; border-color: #059669;
        box-shadow: 0 0 0 4px rgba(5,150,105,0.12);
    }
    .btn-filter-3d {
        padding: 11px 20px; border-radius: 12px; border: none; cursor: pointer;
        font-size: 13px; font-weight: 800; color: #fff;
        background: linear-gradient(145deg, #34d399, #10b981 50%, #059669);
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.5), inset 0 -2px 3px rgba(0,0,0,0.2), 0 5px 12px rgba(5,150,105,0.3);
        transition: all 0.25s;
    }
    .btn-filter-3d:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(5,150,105,0.4); }

    .table-3d {
        width: 100%; border-collapse: separate; border-spacing: 0;
        background: var(--white); border: 1px solid var(--border);
        border-radius: 20px; overflow: hidden;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
    }
    .table-3d thead th {
        padding: 15px 18px; text-align: left;
        font-size: 11px; font-weight: 900; letter-spacing: 0.1em;
        text-transform: uppercase; color: #fde68a;
        background: linear-gradient(145deg, #043b2c, #065f46);
    }
    .table-3d tbody td {
        padding: 15px 18px; font-size: 13.5px; color: var(--ink);
        border-bottom: 1px solid var(--border);
        transition: background 0.2s;
    }
    .table-3d tbody tr:last-child td { border-bottom: none; }
    .table-3d tbody tr:hover td { background: rgba(217,164,65,0.05); }
    .td-title-3d { font-weight: 800; color: var(--ink); }

    /* File type orbs 3D */
    .ft-orb-3d {
        display: inline-flex; align-items: center; justify-content: center;
        width: 44px; height: 44px; border-radius: 13px;
        font-family: var(--font-display); font-weight: 900; font-size: 11px;
        color: white; letter-spacing: 0.02em; position: relative; overflow: hidden;
        box-shadow: inset 0 2px 3px rgba(255,255,255,0.5), inset 0 -3px 4px rgba(0,0,0,0.25), 0 4px 10px rgba(0,0,0,0.2);
    }
    .ft-orb-3d::before {
        content: ''; position: absolute; top: 4px; left: 8px;
        width: 14px; height: 6px; border-radius: 50%;
        background: rgba(255,255,255,0.55); filter: blur(1.5px);
    }
    .ft-pdf { background: linear-gradient(145deg, #fca5a5, #dc2626 60%, #991b1b); }
    .ft-doc, .ft-docx { background: linear-gradient(145deg, #93c5fd, #2563eb 60%, #1e3a8a); }
    .ft-xls, .ft-xlsx { background: linear-gradient(145deg, #86efac, #16a34a 60%, #14532d); }
    .ft-ppt, .ft-pptx { background: linear-gradient(145deg, #fdba74, #ea580c 60%, #9a3412); }
    .ft-default { background: linear-gradient(145deg, #a78bfa, #7c3aed 60%, #5b21b6); }

    .cat-badge-3d {
        display: inline-flex; padding: 4px 11px; border-radius: 999px;
        font-size: 11px; font-weight: 800;
        background: linear-gradient(145deg, rgba(217,164,65,0.15), rgba(169,118,27,0.1));
        border: 1px solid rgba(217,164,65,0.3); color: #92400e;
    }
    .dl-count-3d {
        display: inline-flex; align-items: center; gap: 5px;
        font-family: var(--font-display); font-weight: 900; font-size: 14px;
        color: var(--gold-strong);
    }
    .size-3d { font-size: 12px; color: var(--muted); font-weight: 600; }

    .status-jewel-3d {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 12px; border-radius: 999px;
        font-size: 11px; font-weight: 800; position: relative; overflow: hidden;
    }
    .status-jewel-3d::before {
        content: ''; position: absolute; top: 1px; left: 5px;
        width: 28%; height: 40%; border-radius: 50%;
        background: rgba(255,255,255,0.45); filter: blur(1px);
    }
    .sj-pub { background: linear-gradient(145deg, #6ee7b7, #10b981); color: #064e3b; box-shadow: inset 0 1px 2px rgba(255,255,255,0.6), inset 0 -1px 2px rgba(0,0,0,0.15); }
    .sj-draft { background: linear-gradient(145deg, #e5e7eb, #9ca3af); color: #374151; box-shadow: inset 0 1px 2px rgba(255,255,255,0.6), inset 0 -1px 2px rgba(0,0,0,0.15); }

    .btn-edit-3d {
        padding: 7px 14px; border-radius: 10px; text-decoration: none;
        font-size: 12px; font-weight: 800; color: #03251f;
        background: linear-gradient(145deg, #fde68a, #d9a441);
        box-shadow: inset 0 1px 2px rgba(255,255,255,0.7), inset 0 -1px 2px rgba(0,0,0,0.15), 0 3px 8px rgba(217,164,65,0.3);
        transition: all 0.2s;
    }
    .btn-edit-3d:hover { transform: translateY(-2px); box-shadow: 0 6px 14px rgba(217,164,65,0.45); }
    .btn-del-3d {
        padding: 7px 14px; border-radius: 10px; border: none; cursor: pointer;
        font-size: 12px; font-weight: 800; color: #fff;
        background: linear-gradient(145deg, #fca5a5, #dc2626 60%, #991b1b);
        box-shadow: inset 0 1px 2px rgba(255,255,255,0.5), inset 0 -1px 2px rgba(0,0,0,0.2), 0 3px 8px rgba(220,38,38,0.3);
        transition: all 0.2s;
    }
    .btn-del-3d:hover { transform: translateY(-2px); box-shadow: 0 6px 14px rgba(220,38,38,0.45); }

    .empty-3d {
        padding: 40px 20px; text-align: center; color: var(--muted);
        font-size: 14px; font-weight: 600;
    }
    .empty-3d span { font-size: 40px; display: block; margin-bottom: 10px; }

    .pag-3d { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 22px; }
    .pag-3d a {
        padding: 9px 14px; border-radius: 11px; text-decoration: none;
        font-size: 13px; font-weight: 800; color: var(--ink);
        background: linear-gradient(145deg, #fff, #f6faf7);
        border: 1px solid var(--border);
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.9), 0 2px 5px rgba(0,0,0,0.05);
        transition: all 0.25s;
    }
    .pag-3d a:hover { transform: translateY(-2px); border-color: rgba(217,164,65,0.4); }
    .pag-3d a.active {
        background: linear-gradient(145deg, #065f46, #043b2c);
        color: #fde68a; border-color: transparent;
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.1), 0 5px 12px rgba(5,150,105,0.3);
    }
</style>

<!-- ================= HEADER 3D ================= -->
<div class="doc-list-head">
    <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
        <div class="doc-list-ico">📁</div>
        <div>
            <h2 class="doc-list-title">Dokumen & Unduhan</h2>
            <span class="doc-list-count">📊 Total <?= (int) $total ?> dokumen</span>
        </div>
    </div>
    <a class="btn-add-3d" href="<?= e(url('admin/index.php?page=dokumen-tambah')) ?>">📤 Upload Dokumen</a>
</div>

<?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<!-- ================= FILTER 3D ================= -->
<form method="get" action="<?= e(url('admin/index.php')) ?>" class="filter-3d">
    <input type="hidden" name="page" value="dokumen">
    <input type="text" name="q" value="<?= e($filters['q']) ?>" placeholder="🔍 Cari judul dokumen...">

    <select name="category">
        <option value="">Semua Kategori</option>
        <?php foreach (Document::CATEGORY_LABELS as $key => $label): ?>
            <option value="<?= e($key) ?>" <?= $filters['category'] === $key ? 'selected' : '' ?>><?= e($label) ?></option>
        <?php endforeach; ?>
    </select>

    <select name="status">
        <option value="">Semua Status</option>
        <option value="published" <?= $filters['status'] === 'published' ? 'selected' : '' ?>>🟢 Published</option>
        <option value="draft" <?= $filters['status'] === 'draft' ? 'selected' : '' ?>>⚪ Draft</option>
    </select>

    <button class="btn-filter-3d" type="submit">🔍 Filter</button>
</form>

<!-- ================= TABLE 3D ================= -->
<div style="overflow-x: auto;">
    <table class="table-3d">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Tipe</th>
                <th>Ukuran</th>
                <th>Download</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($items === []): ?>
                <tr><td colspan="7"><div class="empty-3d"><span>📁</span>Belum ada dokumen.</div></td></tr>
            <?php endif; ?>

            <?php foreach ($items as $item):
                $ftClass = 'ft-' . strtolower($item['file_type']);
            ?>
                <tr>
                    <td class="td-title-3d"><?= e($item['title']) ?></td>
                    <td><span class="cat-badge-3d">🏷️ <?= e(Document::CATEGORY_LABELS[$item['category']] ?? $item['category']) ?></span></td>
                    <td><span class="ft-orb-3d <?= $ftClass ?>"><?= e(strtoupper($item['file_type'])) ?></span></td>
                    <td><span class="size-3d">📦 <?= e(format_bytes((int) $item['file_size'])) ?></span></td>
                    <td><span class="dl-count-3d">⬇️ <?= (int) $item['download_count'] ?>x</span></td>
                    <td>
                        <span class="status-jewel-3d <?= $item['status'] === 'published' ? 'sj-pub' : 'sj-draft' ?>">
                            <?= $item['status'] === 'published' ? '🟢' : '⚪' ?> <?= e(ucfirst($item['status'])) ?>
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 6px;">
                            <a class="btn-edit-3d" href="<?= e(url('admin/index.php?page=dokumen-edit&id=' . (int) $item['id'])) ?>">✏️ Edit</a>
                            <form method="post" action="<?= e(url('admin/index.php?page=dokumen-hapus')) ?>" class="js-confirm" data-message="Yakin ingin menghapus dokumen ini?">
                                <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-del-3d">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if ($totalPages > 1): ?>
    <div class="pag-3d">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= e(url(
                'admin/index.php?page=dokumen&hal=' . $i
                . ($filters['q'] !== '' ? '&q=' . urlencode($filters['q']) : '')
                . ($filters['category'] !== '' ? '&category=' . urlencode($filters['category']) : '')
                . ($filters['status'] !== '' ? '&status=' . urlencode($filters['status']) : '')
            )) ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>