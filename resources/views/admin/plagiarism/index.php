<style>
    @keyframes plgFade { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:none; } }

    .plg-head {
        display:flex; align-items:center; gap:16px;
        margin-bottom:22px; padding:22px 26px; border-radius:22px;
        background:linear-gradient(135deg,#043b2c,#065f46 55%,#059669);
        color:#fff; position:relative; overflow:hidden;
        box-shadow:0 14px 36px rgba(0,0,0,.3);
        animation:plgFade .5s both;
    }
    .plg-head::after { content:''; position:absolute; top:-50%; right:-10%; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.22),transparent 70%); pointer-events:none; }
    .plg-ico { width:54px; height:54px; border-radius:16px; flex-shrink:0; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.5),transparent 40%),linear-gradient(145deg,#6ee7b7,#10b981 55%,#047857); display:flex; align-items:center; justify-content:center; font-size:26px; position:relative; z-index:1; box-shadow:inset 0 2px 3px rgba(255,255,255,.6), inset 0 -3px 5px rgba(0,0,0,.25), 0 6px 16px rgba(5,150,105,.4); }
    .plg-title { font-family:var(--font-display); font-size:21px; font-weight:900; letter-spacing:-.02em; margin:0; background:linear-gradient(135deg,#fff,#fde68a); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; position:relative; z-index:1; }
    .plg-sub { font-size:12.5px; opacity:.85; margin:3px 0 0; position:relative; z-index:1; }

    .plg-stats { display:flex; gap:8px; position:relative; z-index:1; flex-wrap:wrap; }
    .plg-stat { background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2); border-radius:14px; padding:10px 16px; text-align:center; min-width:78px; backdrop-filter:blur(8px); }
    .plg-stat b { display:block; font-size:20px; font-weight:900; font-family:var(--font-display); line-height:1.1; }
    .plg-stat span { font-size:9px; letter-spacing:.12em; text-transform:uppercase; opacity:.8; display:block; margin-top:3px; }

    .plg-actions { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:16px; }
    .plg-btn-primary { display:inline-flex; align-items:center; gap:7px; padding:11px 20px; border-radius:12px; text-decoration:none; font-size:13px; font-weight:800; color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441 80%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.15), 0 6px 16px rgba(217,164,65,.4); transition:transform .25s; }
    .plg-btn-primary:hover { transform:translateY(-2px); }
    .plg-btn-ghost { display:inline-flex; align-items:center; gap:7px; padding:11px 20px; border-radius:12px; text-decoration:none; font-size:13px; font-weight:700; color:var(--text); background:var(--surface); border:1px solid var(--border); transition:all .25s; }
    .plg-btn-ghost:hover { border-color:var(--gold-strong); color:var(--gold-strong); }

    .plg-dist { display:grid; grid-template-columns:repeat(4,1fr); gap:10px; margin-bottom:18px; }
    @media (max-width:700px){ .plg-dist { grid-template-columns:repeat(2,1fr); } .plg-stats { width:100%; justify-content:flex-start; } }
    .plg-dist-card { background:var(--surface); border:1px solid var(--border); border-radius:14px; padding:12px 14px; position:relative; overflow:hidden; transition:transform .25s; }
    .plg-dist-card:hover { transform:translateY(-2px); }
    .plg-dist-head { display:flex; justify-content:space-between; align-items:center; font-size:11px; font-weight:800; margin-bottom:8px; }
    .plg-dist-bar { height:6px; border-radius:99px; background:rgba(255,255,255,.08); overflow:hidden; }
    .plg-dist-bar i { display:block; height:100%; border-radius:99px; position:relative; overflow:hidden; }
    .plg-dist-bar i::after { content:''; position:absolute; top:0; left:-60%; width:42%; height:100%; background:linear-gradient(105deg, transparent, rgba(255,255,255,.45), transparent); animation:plgShine 2.8s linear infinite; }
    @keyframes plgShine { 0%,55%{left:-60%} 100%{left:140%} }

    .plg-filter { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:14px; padding:14px; background:var(--surface); border:1px solid var(--border); border-radius:14px; }
    .plg-filter input[type="text"] { flex:1; min-width:200px; padding:10px 14px; border-radius:10px; border:1px solid var(--border); background:var(--surface-2); color:var(--text); font-size:13px; }
    .plg-filter select { padding:10px 14px; border-radius:10px; border:1px solid var(--border); background:var(--surface-2); color:var(--text); font-size:13px; cursor:pointer; }
    .plg-filter button { padding:10px 20px; border-radius:10px; border:none; background:linear-gradient(145deg,#10b981,#059669); color:#fff; font-weight:800; font-size:13px; cursor:pointer; box-shadow:0 4px 12px rgba(5,150,105,.3); }
    .plg-filter button:hover { filter:brightness(1.08); }

    .pg-sim { font-family:var(--font-display); font-weight:900; font-size:16px; }
    .pg-sim.low { color:#6ee7b7; }
    .pg-sim.mid { color:#fbbf24; }
    .pg-sim.high { color:#f87171; }
    .pg-code { font-family:'Courier New',monospace; font-weight:800; letter-spacing:.04em; color:var(--gold-strong); font-size:11px; }
    
    /* Extract method badge di tabel */
    .pg-method { display:inline-block; font-size:10px; font-weight:700; padding:2px 8px; border-radius:6px; margin-top:4px; }
    .pg-method.auto { background:rgba(16,185,129,.12); color:#065f46; }
    .pg-method.manual { background:rgba(245,158,11,.12); color:#92400e; }
    .pg-method.error { background:rgba(220,38,38,.12); color:#991b1b; }
</style>

<!-- ========== HEADER ========== -->
<div class="plg-head">
    <div class="plg-ico">🔍</div>
    <div style="flex:1; position:relative; z-index:1; min-width:0;">
        <h2 class="plg-title">Cek Plagiat & Similaritas</h2>
        <p class="plg-sub">Mesin analisis lokal (shingle 6-gram) vs korpus internal + auto-extract PDF/DOCX.</p>
    </div>
    <div class="plg-stats">
        <div class="plg-stat"><b style="color:#fde68a"><?= number_format($stats['total']) ?></b><span>Total</span></div>
        <div class="plg-stat"><b style="color:#6ee7b7"><?= number_format($stats['completed']) ?></b><span>Selesai</span></div>
        <div class="plg-stat"><b style="color:#fca5a5"><?= number_format($stats['high']) ?></b><span>≥ <?= PlagiarismCheck::THRESHOLD ?>%</span></div>
        <div class="plg-stat"><b style="color:#fde68a"><?= number_format($stats['avg_sim'], 1) ?>%</b><span>Rata-rata</span></div>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<!-- ========== ACTIONS ========== -->
<div class="plg-actions">
    <a class="plg-btn-primary" href="<?= e(url('admin/index.php?page=plagiarism-tambah')) ?>">➕ Submit Dokumen</a>
    <a class="plg-btn-ghost" href="<?= e(url('admin/index.php?page=plagiarism-export')) ?>">📥 Export CSV</a>
</div>

<!-- ========== DISTRIBUSI ========== -->
<?php $maxD = max(1, $dist['low'], $dist['mid'], $dist['high'], $dist['queued']); ?>
<div class="plg-dist">
    <div class="plg-dist-card">
        <div class="plg-dist-head">
            <span style="color:#6ee7b7">🟢 Rendah &lt;15%</span>
            <span style="color:#6ee7b7; font-family:var(--font-display)"><?= $dist['low'] ?></span>
        </div>
        <div class="plg-dist-bar"><i style="width:<?= round($dist['low'] / $maxD * 100) ?>%; background:linear-gradient(90deg,#10b981,#059669);"></i></div>
    </div>
    <div class="plg-dist-card">
        <div class="plg-dist-head">
            <span style="color:#fbbf24">🟡 Sedang 15–<?= PlagiarismCheck::THRESHOLD ?>%</span>
            <span style="color:#fbbf24; font-family:var(--font-display)"><?= $dist['mid'] ?></span>
        </div>
        <div class="plg-dist-bar"><i style="width:<?= round($dist['mid'] / $maxD * 100) ?>%; background:linear-gradient(90deg,#fbbf24,#f59e0b);"></i></div>
    </div>
    <div class="plg-dist-card">
        <div class="plg-dist-head">
            <span style="color:#f87171">🔴 Tinggi ≥<?= PlagiarismCheck::THRESHOLD ?>%</span>
            <span style="color:#f87171; font-family:var(--font-display)"><?= $dist['high'] ?></span>
        </div>
        <div class="plg-dist-bar"><i style="width:<?= round($dist['high'] / $maxD * 100) ?>%; background:linear-gradient(90deg,#f87171,#dc2626);"></i></div>
    </div>
    <div class="plg-dist-card">
        <div class="plg-dist-head">
            <span style="color:#93c5fd">⏳ Antrean</span>
            <span style="color:#93c5fd; font-family:var(--font-display)"><?= $dist['queued'] ?></span>
        </div>
        <div class="plg-dist-bar"><i style="width:<?= round($dist['queued'] / $maxD * 100) ?>%; background:linear-gradient(90deg,#60a5fa,#3b82f6);"></i></div>
    </div>
</div>

<!-- ========== FILTER ========== -->
<form method="get" action="<?= e(url('admin/index.php')) ?>" class="plg-filter">
    <input type="hidden" name="page" value="plagiarism">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="🔍 Cari kode / judul / penulis...">
    <select name="status">
        <option value="">Semua Status</option>
        <?php foreach (PlagiarismCheck::STATUSES as $k => $l): ?>
        <option value="<?= e($k) ?>" <?= $filters['status'] === $k ? 'selected' : '' ?>><?= e($l) ?></option>
        <?php endforeach; ?>
    </select>
    <select name="doc">
        <option value="">Semua Jenis</option>
        <?php foreach (PlagiarismCheck::DOC_TYPES as $k => $l): ?>
        <option value="<?= e($k) ?>" <?= $filters['doc'] === $k ? 'selected' : '' ?>><?= e($l) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">🔍 Filter</button>
</form>

<!-- ========== TABLE ========== -->
<table class="admin-table">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Dokumen</th>
            <th>Jenis</th>
            <th>Ekstraksi</th>
            <th>Similaritas</th>
            <th>Status</th>
            <th style="width:120px">Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($items)): ?>
        <tr><td colspan="7" style="text-align:center; padding:40px; opacity:.6;">Belum ada pemeriksaan.</td></tr>
    <?php endif; ?>
    <?php foreach ($items as $it):
        $sim = (float) $it['similarity_score'];
        $cls = $sim >= PlagiarismCheck::THRESHOLD ? 'high' : ($sim >= 15 ? 'mid' : 'low');
        $method = $it['extract_method'] ?? null;
        $methodClass = 'manual';
        $methodLabel = '—';
        if ($method) {
            if (strpos($method, '_auto') !== false) { $methodClass = 'auto'; $methodLabel = '✅ Auto'; }
            elseif (strpos($method, 'error') !== false) { $methodClass = 'error'; $methodLabel = '❌ Gagal'; }
            elseif ($method === 'direct') { $methodClass = 'auto'; $methodLabel = '📄 TXT/MD'; }
            else { $methodLabel = ucfirst($method); }
        }
    ?>
    <tr>
        <td><span class="pg-code"><?= e($it['code']) ?></span></td>
        <td>
            <b style="color:var(--text);"><?= e($it['title']) ?></b>
            <div style="font-size:11px; opacity:.65; margin-top:2px;">
                👤 <?= e($it['submitter_name']) ?>
                <?= !empty($it['submitter_identity']) ? ' · ' . e($it['submitter_identity']) : '' ?>
            </div>
        </td>
        <td><?= e(PlagiarismCheck::DOC_TYPES[$it['document_type']] ?? '-') ?></td>
        <td>
            <span class="pg-method <?= $methodClass ?>"><?= $methodLabel ?></span>
            <?php if ((int)($it['extract_pages'] ?? 0) > 0): ?>
            <div style="font-size:10px; opacity:.5; margin-top:2px;"><?= (int)$it['extract_pages'] ?> hal</div>
            <?php endif; ?>
        </td>
        <td>
            <?php if ($it['status'] === 'completed'): ?>
                <span class="pg-sim <?= $cls ?>"><?= number_format($sim, 1) ?>%</span>
            <?php else: ?>
                <span style="opacity:.5">—</span>
            <?php endif; ?>
        </td>
        <td><span class="status-badge status-<?= e($it['status']) ?>"><?= e(PlagiarismCheck::STATUSES[$it['status']] ?? $it['status']) ?></span></td>
        <td>
            <div style="display:flex; gap:6px;">
                <a class="btn-admin" href="<?= e(url('admin/index.php?page=plagiarism-lihat&id=' . $it['id'])) ?>" title="Lihat laporan">📄</a>
                <form method="post" action="<?= e(url('admin/index.php?page=plagiarism-hapus')) ?>" onsubmit="return confirm('Hapus laporan ini?');" style="display:inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= (int) $it['id'] ?>">
                    <button class="btn-admin btn-danger" type="submit" title="Hapus">🗑️</button>
                </form>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if ($totalPages > 1): ?>
<div style="margin-top:18px; display:flex; justify-content:center; gap:6px; flex-wrap:wrap;">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="<?= e(url('admin/index.php?page=plagiarism&hal=' . $i . '&q=' . urlencode($q) . '&status=' . urlencode($filters['status']) . '&doc=' . urlencode($filters['doc']))) ?>"
           class="pag-3d <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>