<style>
@keyframes newsListShine { 0% { transform: translateX(-100%) skewX(-20deg); } 100% { transform: translateX(300%) skewX(-20deg); } }

/* ===== HEADER 3D ===== */
.news-list-head {
    display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;
    padding: 24px 28px; margin-bottom: 24px; border-radius: 24px;
    background: linear-gradient(145deg, #043b2c, #065f46); color: #fff;
    position: relative; overflow: hidden; box-shadow: 0 16px 40px rgba(0,0,0,.3);
}
.news-list-head::before {
    content: ''; position: absolute; inset: 0;
    background-image: repeating-linear-gradient(45deg, transparent, transparent 25px, rgba(217,164,65,.04) 25px, rgba(217,164,65,.04) 26px),
                    repeating-linear-gradient(-45deg, transparent, transparent 25px, rgba(217,164,65,.04) 25px, rgba(217,164,65,.04) 26px);
}
.news-list-ico {
    width: 56px; height: 56px; border-radius: 16px; flex-shrink: 0;
    background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.5), transparent 40%), linear-gradient(145deg, #fde68a, #f2c063 50%, #d9a441);
    display: flex; align-items: center; justify-content: center; font-size: 26px; position: relative;
    box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -3px 4px rgba(0,0,0,.2), 0 8px 20px rgba(217,164,65,.4);
    transition: transform 0.3s cubic-bezier(0.16,1,0.3,1);
}
.news-list-ico:hover { transform: scale(1.05) rotate(-5deg); }
.news-list-ico::before { content: ''; position: absolute; top: 6px; left: 11px; width: 16px; height: 7px; border-radius: 50%; background: rgba(255,255,255,.65); filter: blur(1.5px); }
.news-list-title { font-family: var(--font-display); font-size: 24px; font-weight: 900; letter-spacing: -.02em; margin: 0; background: linear-gradient(135deg, #fff 0%, #fde68a 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
.news-list-count { display: inline-flex; align-items: center; gap: 6px; padding: 5px 14px; border-radius: 999px; margin-top: 8px; font-size: 11.5px; font-weight: 800; background: rgba(217,164,65,.2); border: 1px solid rgba(217,164,65,.4); color: #fde68a; }

.btn-add-3d {
    position: relative; padding: 13px 24px; border-radius: 13px; font-size: 14px; font-weight: 800; color: #03251f; text-decoration: none;
    background: linear-gradient(145deg, #fde68a, #f2c063 40%, #d9a441 80%, #a9761b); overflow: hidden;
    transition: all .3s cubic-bezier(.16,1,.3,1);
    box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.15), 0 8px 20px rgba(217,164,65,.4);
    display: inline-flex; align-items: center; gap: 8px;
}
.btn-add-3d::before { content: ''; position: absolute; top: 3px; left: 10%; width: 35%; height: 35%; border-radius: 50%; background: rgba(255,255,255,.6); filter: blur(2px); }
.btn-add-3d::after { content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%; background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent); animation: newsListShine 3s ease-in-out infinite; }
.btn-add-3d:hover { transform: translateY(-3px); box-shadow: inset 0 2px 3px rgba(255,255,255,.8), 0 16px 32px rgba(217,164,65,.55); }

/* ===== FLASH ===== */
.flash-3d {
    position: relative; padding: 15px 20px; margin-bottom: 22px; border-radius: 14px; font-size: 14px; font-weight: 700;
    display: flex; align-items: center; gap: 10px; overflow: hidden;
    box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.05), 0 6px 16px rgba(0,0,0,.1);
    animation: newsListShine 0.5s ease-out;
}
.flash-3d::after { content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%; background: linear-gradient(105deg, transparent, rgba(255,255,255,.5), transparent); animation: newsListShine 3s ease-in-out infinite; }
.flash-success-3d { background: linear-gradient(145deg, #d1fae5, #a7f3d0); border: 1px solid rgba(16,185,129,.35); color: #065f46; }
.flash-error-3d { background: linear-gradient(145deg, #fee2e2, #fecaca); border: 1px solid rgba(220,38,38,.35); color: #991b1b; }

/* ===== FILTER 3D ===== */
.filter-3d {
    display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 22px; padding: 20px;
    border-radius: 20px; background: var(--white); border: 1px solid var(--border);
    box-shadow: 0 6px 20px rgba(0,0,0,.05); position: relative;
}
.filter-3d::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, #10b981, #059669, #f2c063); border-radius: 20px 20px 0 0; opacity: 0.8;
}
.filter-3d input[type="text"], .filter-3d select {
    padding: 12px 16px; border-radius: 12px; border: 2px solid var(--border);
    background: linear-gradient(145deg, #f6faf7, #ffffff); font-size: 13.5px; font-weight: 600; color: var(--ink);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: inset 0 2px 4px rgba(0,0,0,.03), 0 1px 2px rgba(255,255,255,0.8);
}
.filter-3d input[type="text"] { flex: 1; min-width: 220px; }
.filter-3d input[type="text"]::placeholder { color: #8fa69d; }

/* ===== PREMIUM ELEGANT DROPDOWN (LIGHT) ===== */
.filter-3d select {
    appearance: none; -webkit-appearance: none; -moz-appearance: none;
    cursor: pointer; min-width: 180px;
    padding: 12px 44px 12px 16px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%23059669' stroke-width='2.5' viewBox='0 0 24 24'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 14px center;
}
.filter-3d select:hover {
    border-color: rgba(5, 150, 105, 0.4); background-color: #ffffff;
    transform: translateY(-1px); box-shadow: inset 0 2px 4px rgba(0,0,0,.03), 0 6px 14px rgba(5,150,105,0.12);
}
.filter-3d select:focus {
    outline: none; border-color: #10b981;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15), inset 0 2px 4px rgba(0,0,0,.03);
    background-color: #ffffff;
}
.filter-3d select option { background: #ffffff; color: #03251f; padding: 10px; font-weight: 600; }

.btn-filter-3d {
    padding: 12px 22px; border-radius: 12px; border: none; cursor: pointer;
    font-size: 13.5px; font-weight: 800; color: #fff;
    background: linear-gradient(145deg, #34d399, #10b981 50%, #059669);
    box-shadow: inset 0 2px 3px rgba(255,255,255,.5), inset 0 -2px 3px rgba(0,0,0,.2), 0 6px 16px rgba(5,150,105,.35);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    display: inline-flex; align-items: center; gap: 8px;
}
.btn-filter-3d:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(5,150,105,.45); }

/* ===== BULK BAR 3D ===== */
.bulk-bar-3d {
    display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 16px;
    padding: 14px 18px; border-radius: 14px;
    background: linear-gradient(145deg, #0d241c, #071a13); border: 1px solid rgba(217,164,65,.25);
    box-shadow: 0 6px 16px rgba(0,0,0,.3);
}
.bulk-count-3d { font-size: 12.5px; font-weight: 800; color: #fde68a; min-width: 80px; display: flex; align-items: center; gap: 6px; }

/* ===== PREMIUM ELEGANT DROPDOWN (DARK) ===== */
.bulk-bar-3d select {
    appearance: none; -webkit-appearance: none; -moz-appearance: none;
    cursor: pointer; min-width: 200px;
    padding: 10px 42px 10px 14px; border-radius: 10px; border: 1px solid rgba(217, 164, 65, 0.25);
    background: linear-gradient(145deg, #1a332a, #0d241c);
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%23fde68a' stroke-width='2.5' viewBox='0 0 24 24'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 14px center;
    font-size: 12.5px; font-weight: 700; color: #fde68a;
    box-shadow: inset 0 1px 2px rgba(0,0,0,.3), 0 1px 1px rgba(255,255,255,0.05);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.bulk-bar-3d select:hover {
    border-color: rgba(217, 164, 65, 0.5); background: linear-gradient(145deg, #1f3d32, #122b22);
    transform: translateY(-1px);
}
.bulk-bar-3d select:focus {
    outline: none; border-color: #f2c063;
    box-shadow: 0 0 0 4px rgba(217, 164, 65, 0.15), inset 0 1px 2px rgba(0,0,0,.3);
}
.bulk-bar-3d select option { background: #0d241c; color: #fde68a; padding: 10px; font-weight: 600; }

.bulk-apply-3d {
    padding: 10px 20px; border-radius: 10px; border: none; cursor: pointer;
    font-size: 12.5px; font-weight: 800; color: #fff;
    background: linear-gradient(145deg, #34d399, #10b981 50%, #059669);
    box-shadow: inset 0 2px 3px rgba(255,255,255,.5), inset 0 -2px 3px rgba(0,0,0,.2), 0 6px 16px rgba(5,150,105,.35);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    display: inline-flex; align-items: center; gap: 6px;
}
.bulk-apply-3d:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(5,150,105,.45); }
.bulk-apply-3d:disabled { opacity: .4; cursor: not-allowed; transform: none; box-shadow: none; }

.chk-3d { width: 16px; height: 16px; accent-color: #059669; cursor: pointer; }

/* ===== TABLE 3D ===== */
.feat-star-3d {
    display: inline-flex; align-items: center; gap: 4px; margin-left: 8px; padding: 3px 10px; border-radius: 999px;
    font-size: 10.5px; font-weight: 900; background: linear-gradient(145deg, #fde68a, #d9a441); color: #03251f;
    box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -1px 2px rgba(0,0,0,.15); vertical-align: middle;
}
.views-3d { display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 800; color: var(--muted); }

.table-3d {
    width: 100%; border-collapse: separate; border-spacing: 0; background: var(--white);
    border: 1px solid var(--border); border-radius: 20px; overflow: hidden;
    box-shadow: 0 8px 24px rgba(0,0,0,.06);
}
.table-3d thead th {
    padding: 16px 20px; text-align: left; font-size: 11px; font-weight: 900; letter-spacing: .1em; text-transform: uppercase;
    color: #fde68a; background: linear-gradient(145deg, #043b2c, #065f46); border-bottom: 1px solid rgba(217,164,65,0.2);
}
.table-3d tbody td {
    padding: 16px 20px; font-size: 13.5px; color: var(--ink); border-bottom: 1px solid var(--border);
    transition: background .2s; vertical-align: middle;
}
.table-3d tbody tr:last-child td { border-bottom: none; }
.table-3d tbody tr { transition: all 0.2s ease; }
.table-3d tbody tr:hover td { background: rgba(217,164,65,.06); }

.td-title-3d { font-weight: 800; color: var(--ink); line-height: 1.4; }

.thumb-wrap-3d {
    width: 76px; height: 54px; border-radius: 12px; overflow: hidden; border: 2px solid var(--border);
    position: relative; box-shadow: 0 4px 10px rgba(0,0,0,.12);
    transition: all .3s cubic-bezier(.16,1,.3,1);
}
.thumb-wrap-3d img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .5s cubic-bezier(.16,1,.3,1); }
.thumb-wrap-3d:hover { transform: scale(1.15); border-color: rgba(217,164,65,.5); box-shadow: 0 10px 24px rgba(217,164,65,.3); z-index: 2; }
.thumb-wrap-3d:hover img { transform: scale(1.15); }

.thumb-empty-3d {
    width: 76px; height: 54px; border-radius: 12px; background: linear-gradient(135deg, #043b2c, #065f46);
    display: flex; align-items: center; justify-content: center; font-size: 20px; color: rgba(255,255,255,.4);
    border: 2px dashed rgba(217,164,65,.3);
}

.cat-badge-3d {
    display: inline-flex; padding: 5px 12px; border-radius: 999px; font-size: 11.5px; font-weight: 800;
    background: linear-gradient(145deg, rgba(52,211,153,.15), rgba(5,150,105,.1)); border: 1px solid rgba(5,150,105,.3); color: #047857;
}

.status-jewel-3d {
    display: inline-flex; align-items: center; gap: 6px; padding: 5px 13px; border-radius: 999px;
    font-size: 11.5px; font-weight: 800; position: relative; overflow: hidden;
}
.status-jewel-3d::before { content: ''; position: absolute; top: 1px; left: 5px; width: 28%; height: 40%; border-radius: 50%; background: rgba(255,255,255,.45); filter: blur(1px); }
.sj-pub { background: linear-gradient(145deg, #6ee7b7, #10b981); color: #064e3b; box-shadow: inset 0 1px 2px rgba(255,255,255,.6), inset 0 -1px 2px rgba(0,0,0,.15); }
.sj-draft { background: linear-gradient(145deg, #e5e7eb, #9ca3af); color: #374151; box-shadow: inset 0 1px 2px rgba(255,255,255,.6), inset 0 -1px 2px rgba(0,0,0,.15); }

.btn-view-3d, .btn-edit-3d, .btn-del-3d {
    padding: 8px 15px; border-radius: 10px; text-decoration: none; font-size: 12.5px; font-weight: 800;
    transition: all .2s cubic-bezier(0.16, 1, 0.3, 1); display: inline-flex; align-items: center; gap: 5px;
}
.btn-view-3d { color: #fff; background: linear-gradient(145deg, #60a5fa, #2563eb 60%, #1e3a8a); box-shadow: inset 0 1px 2px rgba(255,255,255,.5), inset 0 -1px 2px rgba(0,0,0,.2), 0 4px 10px rgba(37,99,235,.35); }
.btn-view-3d:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(37,99,235,.5); }

.btn-edit-3d { color: #03251f; background: linear-gradient(145deg, #fde68a, #d9a441); box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -1px 2px rgba(0,0,0,.15), 0 4px 10px rgba(217,164,65,.3); }
.btn-edit-3d:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(217,164,65,.45); }

.btn-del-3d { border: none; cursor: pointer; color: #fff; background: linear-gradient(145deg, #fca5a5, #dc2626 60%, #991b1b); box-shadow: inset 0 1px 2px rgba(255,255,255,.5), inset 0 -1px 2px rgba(0,0,0,.2), 0 4px 10px rgba(220,38,38,.3); }
.btn-del-3d:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(220,38,38,.45); }

.empty-3d { padding: 50px 20px; text-align: center; color: var(--muted); font-size: 14px; font-weight: 600; }
.empty-3d span { font-size: 48px; display: block; margin-bottom: 12px; opacity: 0.6; }

.pag-3d { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 24px; justify-content: center; }
.pag-3d a {
    padding: 10px 16px; border-radius: 11px; text-decoration: none; font-size: 13.5px; font-weight: 800; color: var(--ink);
    background: linear-gradient(145deg, #fff, #f6faf7); border: 1px solid var(--border);
    box-shadow: inset 0 1px 1px rgba(255,255,255,.9), 0 2px 5px rgba(0,0,0,.05); transition: all .25s cubic-bezier(0.16, 1, 0.3, 1);
}
.pag-3d a:hover { transform: translateY(-2px); border-color: rgba(217,164,65,.4); color: var(--gold-strong); }
.pag-3d a.active {
    background: linear-gradient(145deg, #065f46, #043b2c); color: #fde68a; border-color: transparent;
    box-shadow: inset 0 1px 1px rgba(255,255,255,.1), 0 6px 16px rgba(5,150,105,.35);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .news-list-head { flex-direction: column; align-items: flex-start; padding: 20px; }
    .btn-add-3d { width: 100%; justify-content: center; margin-top: 12px; }
    .filter-3d { flex-direction: column; }
    .filter-3d input[type="text"], .filter-3d select, .btn-filter-3d { width: 100%; min-width: 0; }
    .bulk-bar-3d { flex-direction: column; align-items: stretch; }
    .bulk-bar-3d select, .bulk-apply-3d { width: 100%; justify-content: center; }
    .table-3d { display: block; overflow-x: auto; }
}
</style>

<!-- ================= HEADER 3D ================= -->
<div class="news-list-head">
    <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
        <div class="news-list-ico">📰</div>
        <div>
            <h2 class="news-list-title">Berita & Pengumuman</h2>
            <span class="news-list-count">📊 Total <?= (int) $total ?> data</span>
        </div>
    </div>
    <a class="btn-add-3d" href="<?= e(url('admin/index.php?page=berita-tambah')) ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        <span>Tulis Berita</span>
    </a>
</div>

<?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<!-- ================= FILTER 3D ================= -->
<form method="get" action="<?= e(url('admin/index.php')) ?>" class="filter-3d">
    <input type="hidden" name="page" value="berita">
    <input type="text" name="q" value="<?= e($filters['q']) ?>" placeholder="🔍 Cari judul berita...">

    <select name="category">
        <option value="">📂 Semua Kategori</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= e($cat) ?>" <?= $filters['category'] === $cat ? 'selected' : '' ?>><?= e(ucfirst($cat)) ?></option>
        <?php endforeach; ?>
    </select>

    <select name="status">
        <option value="">📌 Semua Status</option>
        <option value="published" <?= $filters['status'] === 'published' ? 'selected' : '' ?>>🟢 Published</option>
        <option value="draft" <?= $filters['status'] === 'draft' ? 'selected' : '' ?>>⚪ Draft</option>>
    </select>

    <button class="btn-filter-3d" type="submit">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <span>Filter</span>
    </button>
</form>

<!-- ================= BULK ACTIONS ================= -->
<form id="bulk-form" method="post" action="<?= e(url('admin/index.php?page=berita-bulk')) ?>">
    <?= csrf_field() ?>
    <div class="bulk-bar-3d">
        <span class="bulk-count-3d" id="bulk-count">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
            <span>0 dipilih</span>
        </span>
        <select name="bulk_action" id="bulk-action">
            <option value="publish">🟢 Publish Terpilih</option>
            <option value="draft">⚪ Draftkan Terpilih</option>
            <option value="feature">⭐ Jadikan Unggulan</option>
            <option value="unfeature">☆ Hapus Unggulan</option>
            <option value="delete">🗑️ Hapus Terpilih</option>
        </select>
        <button type="submit" class="bulk-apply-3d" id="bulk-apply" disabled>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
            <span>Terapkan</span>
        </button>
    </div>
</form>

<!-- ================= TABLE 3D ================= -->
<div style="overflow-x: auto;">
    <table class="table-3d">
        <thead>
            <tr>
                <th style="width:50px; text-align:center;"><input type="checkbox" id="select-all" class="chk-3d" title="Pilih semua"></th>
                <th style="width:90px;">Gambar</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Views</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($items === []): ?>
                <tr><td colspan="8"><div class="empty-3d"><span>📰</span>Belum ada data berita.</div></td></tr>
            <?php endif; ?>

            <?php foreach ($items as $item): ?>
                <tr>
                    <td style="text-align:center;"><input type="checkbox" class="chk-3d bulk-check" value="<?= (int) $item['id'] ?>" form="bulk-form"></td>
                    <td>
                        <?php if (!empty($item['thumbnail'])): ?>
                            <div class="thumb-wrap-3d">
                                <img src="<?= e(upload_url($item['thumbnail'])) ?>" alt="Thumbnail">
                            </div>
                        <?php else: ?>
                            <div class="thumb-empty-3d">📰</div>
                        <?php endif; ?>
                    </td>
                    <td class="td-title-3d">
                        <?= e($item['title']) ?>
                        <?php if (!empty($item['is_featured'])): ?>
                            <span class="feat-star-3d">⭐ Unggulan</span>
                        <?php endif; ?>
                    </td>
                    <td><span class="cat-badge-3d">🏷️ <?= e(ucfirst($item['category'])) ?></span></td>
                    <td>
                        <span class="status-jewel-3d <?= $item['status'] === 'published' ? 'sj-pub' : 'sj-draft' ?>">
                            <?= $item['status'] === 'published' ? '🟢' : '⚪' ?> <?= e(ucfirst($item['status'])) ?>
                        </span>
                    </td>
                    <td><span class="views-3d">👁️ <?= number_format((int) ($item['views'] ?? 0)) ?></span></td>
                    <td>📅 <?= e(date('d M Y', strtotime($item['created_at']))) ?></td>
                    <td>
                        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                            <?php if ($item['status'] === 'published'): ?>
                                <a class="btn-view-3d" href="<?= e(url('public/index.php?page=berita-detail&slug=' . urlencode($item['slug']))) ?>" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    Lihat
                                </a>
                            <?php endif; ?>
                            <a class="btn-edit-3d" href="<?= e(url('admin/index.php?page=berita-edit&id=' . (int) $item['id'])) ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                Edit
                            </a>
                            <form method="post" action="<?= e(url('admin/index.php?page=berita-hapus')) ?>" class="js-confirm" data-message="Yakin ingin menghapus berita ini?" style="display:inline;">
                                <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-del-3d">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    Hapus
                                </button>
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
                'admin/index.php?page=berita&hal=' . $i
                . ($filters['q'] !== '' ? '&q=' . urlencode($filters['q']) : '')
                . ($filters['category'] !== '' ? '&category=' . urlencode($filters['category']) : '')
                . ($filters['status'] !== '' ? '&status=' . urlencode($filters['status']) : '')
            )) ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

<script>
(function () {
    'use strict';

    var bulkForm = document.getElementById('bulk-form');
    var selectAll = document.getElementById('select-all');
    var checks = Array.prototype.slice.call(document.querySelectorAll('.bulk-check'));
    var bulkCount = document.getElementById('bulk-count');
    var bulkApply = document.getElementById('bulk-apply');
    var bulkAction = document.getElementById('bulk-action');

    function removeGeneratedInputs() {
        if (!bulkForm) return;
        Array.prototype.slice.call(bulkForm.querySelectorAll('input[name="ids[]"]')).forEach(function (el) {
            el.remove();
        });
    }

    function getSelected() {
        return checks.filter(function (chk) { return chk.checked; });
    }

    function syncBulkState() {
        var selected = getSelected();
        var n = selected.length;

        if (bulkCount) {
            bulkCount.querySelector('span').textContent = n + ' dipilih';
        }

        if (bulkApply) {
            bulkApply.disabled = n === 0;
        }

        if (selectAll) {
            selectAll.checked = checks.length > 0 && n === checks.length;
            selectAll.indeterminate = n > 0 && n < checks.length;
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            checks.forEach(function (chk) { chk.checked = selectAll.checked; });
            syncBulkState();
        });
    }

    checks.forEach(function (chk) {
        chk.addEventListener('change', syncBulkState);
    });

    if (bulkForm) {
        bulkForm.addEventListener('submit', function (e) {
            var selected = getSelected();
            var action = bulkAction ? bulkAction.value : '';

            if (selected.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu berita terlebih dahulu.');
                return;
            }

            if (action === 'delete') {
                if (!confirm('Yakin ingin menghapus ' + selected.length + ' berita terpilih? Tindakan ini tidak dapat dibatalkan.')) {
                    e.preventDefault();
                    return;
                }
            } else if (!confirm('Terapkan aksi ke ' + selected.length + ' berita terpilih?')) {
                e.preventDefault();
                return;
            }

            removeGeneratedInputs();
            selected.forEach(function (chk) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = chk.value;
                bulkForm.appendChild(input);
            });
        });
    }

    syncBulkState();
})();
</script>