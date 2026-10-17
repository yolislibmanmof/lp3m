<style>
@keyframes newsListShine{0%{transform:translateX(-100%) skewX(-20deg)}100%{transform:translateX(300%) skewX(-20deg)}}
.news-list-head{display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;padding:22px 26px;margin-bottom:24px;border-radius:22px;background:linear-gradient(145deg,#043b2c,#065f46);color:#fff;position:relative;overflow:hidden;box-shadow:0 12px 32px rgba(0,0,0,.25)}
.news-list-head::before{content:'';position:absolute;inset:0;background-image:repeating-linear-gradient(45deg,transparent,transparent 25px,rgba(217,164,65,.04) 25px,rgba(217,164,65,.04) 26px),repeating-linear-gradient(-45deg,transparent,transparent 25px,rgba(217,164,65,.04) 25px,rgba(217,164,65,.04) 26px)}
.news-list-ico{width:54px;height:54px;border-radius:16px;flex-shrink:0;background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.5),transparent 40%),linear-gradient(145deg,#fde68a,#f2c063 50%,#d9a441);display:flex;align-items:center;justify-content:center;font-size:26px;position:relative;box-shadow:inset 0 2px 3px rgba(255,255,255,.7),inset 0 -3px 4px rgba(0,0,0,.2),0 6px 14px rgba(217,164,65,.4)}
.news-list-ico::before{content:'';position:absolute;top:5px;left:10px;width:16px;height:7px;border-radius:50%;background:rgba(255,255,255,.65);filter:blur(1.5px)}
.news-list-title{font-family:var(--font-display);font-size:22px;font-weight:900;letter-spacing:-.02em;margin:0;background:linear-gradient(135deg,#fff 0%,#fde68a 100%);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent}
.news-list-count{display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:999px;margin-top:6px;font-size:11px;font-weight:800;background:rgba(217,164,65,.25);border:1px solid rgba(217,164,65,.4);color:#fde68a}
.btn-add-3d{position:relative;padding:12px 22px;border-radius:13px;font-size:13.5px;font-weight:800;color:#03251f;text-decoration:none;background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441 80%,#a9761b);overflow:hidden;transition:all .3s cubic-bezier(.16,1,.3,1);box-shadow:inset 0 2px 3px rgba(255,255,255,.7),inset 0 -2px 3px rgba(0,0,0,.15),0 8px 20px rgba(217,164,65,.4)}
.btn-add-3d::before{content:'';position:absolute;top:3px;left:10%;width:35%;height:35%;border-radius:50%;background:rgba(255,255,255,.6);filter:blur(2px)}
.btn-add-3d::after{content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent);animation:newsListShine 3s ease-in-out infinite}
.btn-add-3d:hover{transform:translateY(-2px);box-shadow:inset 0 2px 3px rgba(255,255,255,.8),0 14px 30px rgba(217,164,65,.55)}
.flash-3d{position:relative;padding:14px 18px;margin-bottom:20px;border-radius:14px;font-size:13.5px;font-weight:700;display:flex;align-items:center;gap:10px;overflow:hidden;box-shadow:inset 0 1px 2px rgba(255,255,255,.7),inset 0 -2px 3px rgba(0,0,0,.05),0 4px 12px rgba(0,0,0,.1)}
.flash-3d::after{content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent);animation:newsListShine 3s ease-in-out infinite}
.flash-success-3d{background:linear-gradient(145deg,#d1fae5,#a7f3d0);border:1px solid rgba(16,185,129,.35);color:#065f46}
.flash-error-3d{background:linear-gradient(145deg,#fee2e2,#fecaca);border:1px solid rgba(220,38,38,.35);color:#991b1b}
.filter-3d{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;padding:18px;border-radius:18px;background:var(--white);border:1px solid var(--border);box-shadow:0 4px 14px rgba(0,0,0,.04)}
.filter-3d input[type="text"],.filter-3d select{padding:11px 15px;border-radius:12px;border:2px solid var(--border);background:linear-gradient(145deg,#f6faf7,#fff);font-size:13px;font-weight:600;color:var(--ink);transition:all .25s;box-shadow:inset 0 2px 4px rgba(0,0,0,.04)}
.filter-3d input[type="text"]{flex:1;min-width:200px}
.filter-3d select{appearance:none;-webkit-appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23059669' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 14px center;padding-right:38px;cursor:pointer}
.filter-3d input:focus,.filter-3d select:focus{outline:none;border-color:#059669;box-shadow:0 0 0 4px rgba(5,150,105,.12)}
.btn-filter-3d{padding:11px 20px;border-radius:12px;border:none;cursor:pointer;font-size:13px;font-weight:800;color:#fff;background:linear-gradient(145deg,#34d399,#10b981 50%,#059669);box-shadow:inset 0 2px 3px rgba(255,255,255,.5),inset 0 -2px 3px rgba(0,0,0,.2),0 5px 12px rgba(5,150,105,.3);transition:all .25s}
.btn-filter-3d:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(5,150,105,.4)}
.bulk-bar-3d{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:14px;padding:12px 16px;border-radius:14px;background:linear-gradient(145deg,#0d241c,#071a13);border:1px solid rgba(217,164,65,.25);box-shadow:0 4px 12px rgba(0,0,0,.3)}
.bulk-count-3d{font-size:12px;font-weight:800;color:#fde68a;min-width:76px}
.bulk-bar-3d select{padding:9px 34px 9px 12px;border-radius:10px;border:1px solid var(--border);background:#f6faf7 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23059669' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") no-repeat right 12px center;font-size:12px;font-weight:700;color:var(--ink);appearance:none;-webkit-appearance:none;cursor:pointer}
.bulk-apply-3d{padding:9px 18px;border-radius:10px;border:none;cursor:pointer;font-size:12px;font-weight:800;color:#fff;background:linear-gradient(145deg,#34d399,#10b981 50%,#059669);box-shadow:inset 0 2px 3px rgba(255,255,255,.5),inset 0 -2px 3px rgba(0,0,0,.2),0 5px 12px rgba(5,150,105,.3);transition:all .25s}
.bulk-apply-3d:hover:not(:disabled){transform:translateY(-2px);box-shadow:0 8px 18px rgba(5,150,105,.4)}
.bulk-apply-3d:disabled{opacity:.45;cursor:not-allowed}
.chk-3d{width:16px;height:16px;accent-color:#059669;cursor:pointer}
.feat-star-3d{display:inline-flex;align-items:center;gap:4px;margin-left:8px;padding:2px 9px;border-radius:999px;font-size:10px;font-weight:900;background:linear-gradient(145deg,#fde68a,#d9a441);color:#03251f;box-shadow:inset 0 1px 2px rgba(255,255,255,.7),inset 0 -1px 2px rgba(0,0,0,.15);vertical-align:middle}
.views-3d{display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:800;color:var(--muted)}
.table-3d{width:100%;border-collapse:separate;border-spacing:0;background:var(--white);border:1px solid var(--border);border-radius:20px;overflow:hidden;box-shadow:0 6px 20px rgba(0,0,0,.05)}
.table-3d thead th{padding:15px 18px;text-align:left;font-size:11px;font-weight:900;letter-spacing:.1em;text-transform:uppercase;color:#fde68a;background:linear-gradient(145deg,#043b2c,#065f46)}
.table-3d tbody td{padding:15px 18px;font-size:13.5px;color:var(--ink);border-bottom:1px solid var(--border);transition:background .2s;vertical-align:middle}
.table-3d tbody tr:last-child td{border-bottom:none}
.table-3d tbody tr:hover td{background:rgba(217,164,65,.05)}
.td-title-3d{font-weight:800;color:var(--ink)}
.thumb-wrap-3d{width:72px;height:50px;border-radius:12px;overflow:hidden;border:2px solid var(--border);position:relative;box-shadow:0 3px 8px rgba(0,0,0,.12);transition:all .3s cubic-bezier(.16,1,.3,1)}
.thumb-wrap-3d img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s cubic-bezier(.16,1,.3,1)}
.thumb-wrap-3d:hover{transform:scale(1.12);border-color:rgba(217,164,65,.5);box-shadow:0 8px 20px rgba(217,164,65,.3);z-index:2}
.thumb-wrap-3d:hover img{transform:scale(1.15)}
.thumb-empty-3d{width:72px;height:50px;border-radius:12px;background:linear-gradient(135deg,#043b2c,#065f46);display:flex;align-items:center;justify-content:center;font-size:18px;color:rgba(255,255,255,.4);border:2px dashed rgba(217,164,65,.3)}
.cat-badge-3d{display:inline-flex;padding:4px 11px;border-radius:999px;font-size:11px;font-weight:800;background:linear-gradient(145deg,rgba(52,211,153,.15),rgba(5,150,105,.1));border:1px solid rgba(5,150,105,.3);color:#047857}
.status-jewel-3d{display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:999px;font-size:11px;font-weight:800;position:relative;overflow:hidden}
.status-jewel-3d::before{content:'';position:absolute;top:1px;left:5px;width:28%;height:40%;border-radius:50%;background:rgba(255,255,255,.45);filter:blur(1px)}
.sj-pub{background:linear-gradient(145deg,#6ee7b7,#10b981);color:#064e3b;box-shadow:inset 0 1px 2px rgba(255,255,255,.6),inset 0 -1px 2px rgba(0,0,0,.15)}
.sj-draft{background:linear-gradient(145deg,#e5e7eb,#9ca3af);color:#374151;box-shadow:inset 0 1px 2px rgba(255,255,255,.6),inset 0 -1px 2px rgba(0,0,0,.15)}
.btn-view-3d{padding:7px 14px;border-radius:10px;text-decoration:none;font-size:12px;font-weight:800;color:#fff;background:linear-gradient(145deg,#60a5fa,#2563eb 60%,#1e3a8a);box-shadow:inset 0 1px 2px rgba(255,255,255,.5),inset 0 -1px 2px rgba(0,0,0,.2),0 3px 8px rgba(37,99,235,.35);transition:all .2s}
.btn-view-3d:hover{transform:translateY(-2px);box-shadow:0 6px 14px rgba(37,99,235,.5)}
.btn-edit-3d{padding:7px 14px;border-radius:10px;text-decoration:none;font-size:12px;font-weight:800;color:#03251f;background:linear-gradient(145deg,#fde68a,#d9a441);box-shadow:inset 0 1px 2px rgba(255,255,255,.7),inset 0 -1px 2px rgba(0,0,0,.15),0 3px 8px rgba(217,164,65,.3);transition:all .2s}
.btn-edit-3d:hover{transform:translateY(-2px);box-shadow:0 6px 14px rgba(217,164,65,.45)}
.btn-del-3d{padding:7px 14px;border-radius:10px;border:none;cursor:pointer;font-size:12px;font-weight:800;color:#fff;background:linear-gradient(145deg,#fca5a5,#dc2626 60%,#991b1b);box-shadow:inset 0 1px 2px rgba(255,255,255,.5),inset 0 -1px 2px rgba(0,0,0,.2),0 3px 8px rgba(220,38,38,.3);transition:all .2s}
.btn-del-3d:hover{transform:translateY(-2px);box-shadow:0 6px 14px rgba(220,38,38,.45)}
.empty-3d{padding:40px 20px;text-align:center;color:var(--muted);font-size:14px;font-weight:600}
.empty-3d span{font-size:40px;display:block;margin-bottom:10px}
.pag-3d{display:flex;gap:6px;flex-wrap:wrap;margin-top:22px}
.pag-3d a{padding:9px 14px;border-radius:11px;text-decoration:none;font-size:13px;font-weight:800;color:var(--ink);background:linear-gradient(145deg,#fff,#f6faf7);border:1px solid var(--border);box-shadow:inset 0 1px 1px rgba(255,255,255,.9),0 2px 5px rgba(0,0,0,.05);transition:all .25s}
.pag-3d a:hover{transform:translateY(-2px);border-color:rgba(217,164,65,.4)}
.pag-3d a.active{background:linear-gradient(145deg,#065f46,#043b2c);color:#fde68a;border-color:transparent;box-shadow:inset 0 1px 1px rgba(255,255,255,.1),0 5px 12px rgba(5,150,105,.3)}
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
    <a class="btn-add-3d" href="<?= e(url('admin/index.php?page=berita-tambah')) ?>">✍️ Tulis Berita</a>
</div>

<?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<!-- ================= FILTER 3D ================= -->
<form method="get" action="<?= e(url('admin/index.php')) ?>" class="filter-3d">
    <input type="hidden" name="page" value="berita">
    <input type="text" name="q" value="<?= e($filters['q']) ?>" placeholder="🔍 Cari judul...">

    <select name="category">
        <option value="">Semua Kategori</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= e($cat) ?>" <?= $filters['category'] === $cat ? 'selected' : '' ?>><?= e(ucfirst($cat)) ?></option>
        <?php endforeach; ?>
    </select>

    <select name="status">
        <option value="">Semua Status</option>
        <option value="published" <?= $filters['status'] === 'published' ? 'selected' : '' ?>>🟢 Published</option>
        <option value="draft" <?= $filters['status'] === 'draft' ? 'selected' : '' ?>>⚪ Draft</option>
    </select>

    <button class="btn-filter-3d" type="submit">🔍 Filter</button>
</form>

<!-- ================= BULK ACTIONS (BARU) ================= -->
<form id="bulk-form" method="post" action="<?= e(url('admin/index.php?page=berita-bulk')) ?>">
    <?= csrf_field() ?>
    <div class="bulk-bar-3d">
        <span class="bulk-count-3d" id="bulk-count">0 dipilih</span>
        <select name="bulk_action" id="bulk-action">
            <option value="publish">🟢 Publish Terpilih</option>
            <option value="draft">⚪ Draftkan Terpilih</option>
            <option value="feature">⭐ Jadikan Unggulan</option>
            <option value="unfeature">☆ Hapus Unggulan</option>
            <option value="delete">🗑️ Hapus Terpilih</option>
        </select>
        <button type="submit" class="bulk-apply-3d" id="bulk-apply" disabled>⚡ Terapkan</button>
    </div>
</form>

<!-- ================= TABLE 3D ================= -->
<div style="overflow-x: auto;">
    <table class="table-3d">
        <thead>
            <tr>
                <th style="width:40px;"><input type="checkbox" id="select-all" class="chk-3d" title="Pilih semua"></th>
                <th>Gambar</th>
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
                    <td><input type="checkbox" class="chk-3d bulk-check" value="<?= (int) $item['id'] ?>" form="bulk-form"></td>
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
                                <a class="btn-view-3d" href="<?= e(url('public/index.php?page=berita-detail&slug=' . urlencode($item['slug']))) ?>" target="_blank">👁️ Lihat</a>
                            <?php endif; ?>
                            <a class="btn-edit-3d" href="<?= e(url('admin/index.php?page=berita-edit&id=' . (int) $item['id'])) ?>">✏️ Edit</a>
                            <form method="post" action="<?= e(url('admin/index.php?page=berita-hapus')) ?>" class="js-confirm" data-message="Yakin ingin menghapus berita ini?">
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
        return checks.filter(function (chk) {
            return chk.checked;
        });
    }

    function syncBulkState() {
        var selected = getSelected();
        var n = selected.length;

        if (bulkCount) {
            bulkCount.textContent = n + ' dipilih';
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
            checks.forEach(function (chk) {
                chk.checked = selectAll.checked;
            });
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