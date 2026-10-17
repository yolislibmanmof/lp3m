<style>
    @keyframes igFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    @keyframes igShine { 0%,55%{left:-90%} 100%{left:165%} }
    .ig-head { position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:26px 30px; border-radius:22px; background:linear-gradient(135deg,#0c4a6e 0%,#0369a1 55%,#0ea5e9 100%); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:igFade .5s both; }
    .ig-head::after { content:''; position:absolute; top:-50%; right:-8%; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(125,211,252,.25),transparent 70%); pointer-events:none; }
    .ig-head-ico { width:56px; height:56px; border-radius:16px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:26px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.55),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#a9761b); box-shadow:inset 0 2px 3px rgba(255,255,255,.6), 0 6px 16px rgba(217,164,65,.4); position:relative; z-index:1; }
    .ig-head h2 { margin:0 0 4px; font-family:var(--font-display); font-size:21px; font-weight:900; position:relative; z-index:1; }
    .ig-head p { margin:0; font-size:12.5px; opacity:.9; position:relative; z-index:1; }
    .ig-stats { display:flex; gap:8px; flex-wrap:wrap; margin-left:auto; position:relative; z-index:1; }
    .ig-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); border-radius:14px; padding:10px 16px; text-align:center; min-width:86px; backdrop-filter:blur(6px); }
    .ig-stat b { display:block; font-family:var(--font-display); font-size:18px; font-weight:900; color:#bae6fd; line-height:1.1; }
    .ig-stat span { font-size:9px; letter-spacing:.12em; text-transform:uppercase; opacity:.85; display:block; margin-top:3px; }

    .ig-grid { display:grid; grid-template-columns:1.2fr 1fr; gap:18px; margin-bottom:22px; }
    @media(max-width:1000px){ .ig-grid{grid-template-columns:1fr;} }
    .ig-card { position:relative; overflow:hidden; background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:24px; animation:igFade .5s .06s both; }
    .ig-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#0ea5e9,#38bdf8,#f2c063); opacity:.85; }
    .ig-card h3 { display:flex; align-items:center; gap:10px; margin:0 0 6px; font-family:var(--font-display); font-size:15px; font-weight:900; color:#fff; }
    .ig-card h3 .emo { width:32px; height:32px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; background:rgba(14,165,233,.14); }
    .ig-card .desc { font-size:12px; color:var(--muted); margin:0 0 16px; line-height:1.6; }
    .ig-field { margin-bottom:12px; }
    .ig-field label { display:block; font-size:11px; font-weight:900; letter-spacing:.08em; text-transform:uppercase; color:var(--muted); margin-bottom:6px; }
    .ig-field input { width:100%; padding:11px 14px; border-radius:11px; border:1px solid var(--border); background:var(--surface); font-size:13px; font-weight:600; color:var(--text); }
    .ig-field input:focus { outline:none; border-color:#0ea5e9; box-shadow:0 0 0 4px rgba(14,165,233,.14); }
    .ig-row { display:flex; gap:8px; }
    .ig-btn { position:relative; overflow:hidden; padding:11px 18px; border:none; border-radius:11px; font-size:12.5px; font-weight:900; cursor:pointer; transition:all .2s; display:inline-flex; align-items:center; gap:6px; }
    .ig-btn.primary { color:#03251f; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:0 5px 14px rgba(217,164,65,.35); }
    .ig-btn.primary::after { content:''; position:absolute; top:0; left:-100%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent); animation:igShine 3s ease-in-out infinite; }
    .ig-btn.blue { color:#fff; background:linear-gradient(145deg,#38bdf8,#0284c7); box-shadow:0 5px 14px rgba(14,165,233,.35); }
    .ig-btn:hover { transform:translateY(-2px); filter:brightness(1.05); }
    .ig-preview { margin-top:12px; padding:14px; border-radius:12px; background:rgba(14,165,233,.06); border:1px dashed rgba(14,165,233,.4); font-size:12.5px; color:var(--text); line-height:1.7; min-height:44px; }
    .ig-preview b { color:#0ea5e9; }
    .ig-preview .m { display:block; font-size:11.5px; color:var(--muted); }

    .ig-log { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:22px; animation:igFade .5s .1s both; }
    .ig-log h3 { display:flex; align-items:center; gap:10px; margin:0 0 14px; font-family:var(--font-display); font-size:15px; font-weight:900; color:#fff; }
    .ig-log h3 .num { margin-left:auto; font-size:10px; font-weight:900; letter-spacing:.1em; color:var(--muted); }
    .ig-log table { width:100%; border-collapse:collapse; font-size:12px; }
    .ig-log th { padding:9px 10px; text-align:left; font-size:9.5px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); border-bottom:1px solid var(--border); }
    .ig-log td { padding:9px 10px; border-bottom:1px solid var(--border); color:var(--text); vertical-align:top; }
    .ig-log tr:last-child td { border-bottom:none; }
    .ig-tag { padding:2px 9px; border-radius:999px; font-size:9.5px; font-weight:900; white-space:nowrap; }
    .ig-tag.success { background:rgba(16,185,129,.14); color:#047857; }
    .ig-tag.partial { background:rgba(245,158,11,.14); color:#92400e; }
    .ig-tag.failed { background:rgba(220,38,38,.14); color:#991b1b; }
    .ig-empty { text-align:center; padding:30px 10px; color:var(--muted); font-size:12.5px; }
</style>

<div class="ig-head">
    <div class="ig-head-ico">🔗</div>
    <div style="position:relative;z-index:1;">
        <h2>Integrasi Ekosistem Akademik</h2>
        <p>Tarik data otomatis dari CrossRef DOI, CSV SINTA Kemdikbud, dan Google Scholar.</p>
    </div>
    <div class="ig-stats">
        <div class="ig-stat"><b><?= (int) $stats['total'] ?></b><span>Total Sync</span></div>
        <div class="ig-stat"><b><?= (int) $stats['success'] ?></b><span>Sukses</span></div>
        <div class="ig-stat"><b><?= (int) $stats['failed'] ?></b><span>Gagal</span></div>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<div class="ig-grid">
    <!-- DOI LOOKUP -->
    <div class="ig-card">
        <h3><span class="emo">🔗</span><span>CrossRef DOI Lookup</span></h3>
        <p class="desc">Ketik DOI → pratinjau metadata langsung → simpan sebagai publikasi lengkap (judul, penulis, jurnal, tahun, volume, halaman).</p>
        <form method="post" action="<?= e(url('admin/index.php?page=integrations-doi')) ?>">
            <?= csrf_field() ?>
            <div class="ig-field">
                <label>DOI (mendukung format URL penuh)</label>
                <input type="text" id="ig-doi-input" name="doi" placeholder="10.1038/nature12373  atau  https://doi.org/10.1038/nature12373" required>
            </div>
            <div class="ig-row">
                <button type="button" class="ig-btn blue" id="ig-doi-preview">👁️ Pratinjau</button>
                <button type="submit" class="ig-btn primary">💾 Simpan ke Publikasi</button>
            </div>
        </form>
        <div class="ig-preview" id="ig-doi-result">ℹ️ Hasil pratinjau metadata akan tampil di sini.</div>
    </div>

    <div style="display:flex; flex-direction:column; gap:18px;">
        <!-- SINTA CSV -->
        <div class="ig-card" style="animation-delay:.08s">
            <h3><span class="emo">📊</span><span>Import CSV SINTA</span></h3>
            <p class="desc">Unggah file export SINTA (.csv). Kolom judul/penulis/jurnal/tahun/DOI dikenali otomatis. Duplikat dilewati.</p>
            <form method="post" action="<?= e(url('admin/index.php?page=integrations-sinta-import')) ?>" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="ig-field">
                    <label>File CSV (maks 5 MB)</label>
                    <input type="file" name="csvfile" accept=".csv,.txt" required style="padding:9px;">
                </div>
                <button type="submit" class="ig-btn primary">📥 Import Sekarang</button>
            </form>
        </div>

        <!-- SCHOLAR -->
        <div class="ig-card" style="animation-delay:.1s">
            <h3><span class="emo">🎓</span><span>Google Scholar</span></h3>
            <p class="desc">Tempel URL profil Scholar publik (scholar.google.com/citations?user=XXX). Maks 20 publikasi pertama ditarik.</p>
            <form method="post" action="<?= e(url('admin/index.php?page=integrations-scholar')) ?>">
                <?= csrf_field() ?>
                <div class="ig-field">
                    <label>URL Profil Scholar</label>
                    <input type="url" name="scholar_url" placeholder="https://scholar.google.com/citations?user=XXXXXX" required>
                </div>
                <button type="submit" class="ig-btn primary">🎓 Tarik Publikasi</button>
            </form>
        </div>
    </div>
</div>

<!-- LOG -->
<div class="ig-log">
    <h3>📜 Riwayat Sinkronisasi
        <span class="num"><?= count($logs) ?> ENTRI</span>
        <a class="ig-btn blue" style="margin-left:auto;" href="<?= e(url('admin/index.php?page=integrations-log-export')) ?>">📥 Export CSV</a>
    </h3>
    <?php if (empty($logs)): ?>
    <div class="ig-empty">📭 Belum ada aktivitas sinkronisasi.</div>
    <?php else: ?>
    <div style="overflow-x:auto;">
    <table>
        <thead><tr><th>Waktu</th><th>Provider</th><th>Aksi</th><th>Input</th><th>Item</th><th>Status</th><th>Pesan</th></tr></thead>
        <tbody>
        <?php foreach ($logs as $l): ?>
        <tr>
            <td style="white-space:nowrap; color:var(--muted);"><?= e(date('d M · H:i', strtotime($l['created_at']))) ?></td>
            <td><?= e(IntegrationsLog::PROVIDERS[$l['provider']] ?? $l['provider']) ?></td>
            <td><?= e($l['action']) ?></td>
            <td style="max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="<?= e($l['input_query'] ?? '') ?>"><?= e($l['input_query'] ?? '—') ?></td>
            <td style="text-align:center; font-weight:900;"><?= (int) $l['items_count'] ?></td>
            <td><span class="ig-tag <?= e($l['status']) ?>"><?= e(strtoupper($l['status'])) ?></span></td>
            <td style="max-width:300px; color:var(--muted);"><?= e(mb_substr((string) $l['message'], 0, 110)) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <?php endif; ?>
</div>

<script>
(function(){
    var btn = document.getElementById('ig-doi-preview');
    var input = document.getElementById('ig-doi-input');
    var box = document.getElementById('ig-doi-result');
    if (!btn || !input || !box) return;
    btn.addEventListener('click', function(){
        var doi = input.value.trim();
        if (!doi) { box.innerHTML = '⚠️ Isi DOI terlebih dahulu.'; return; }
        box.innerHTML = '⏳ Mengambil metadata dari CrossRef...';
        fetch('<?= e(url('admin/index.php?page=integrations-doi-live')) ?>&doi=' + encodeURIComponent(doi))
            .then(function(r){ return r.json(); })
            .then(function(d){
                if (!d.ok) { box.innerHTML = '❌ ' + (d.error || 'Gagal mengambil metadata.'); return; }
                var m = d.meta;
                box.innerHTML =
                    '<b>' + (m.title || '(tanpa judul)') + '</b>' +
                    '<span class="m">✍️ ' + (m.authors || '-') + '</span>' +
                    '<span class="m">📖 ' + (m.journal || '-') + ' · ' + m.year + (m.volume ? ' · Vol ' + m.volume : '') + (m.page ? ' · hal ' + m.page : '') + '</span>' +
                    '<span class="m">🏢 ' + (m.publisher || '-') + ' · 🔗 Sitasi: ' + m.citations + '</span>';
            })
            .catch(function(){ box.innerHTML = '❌ Gagal koneksi ke server.'; });
    });
})();
</script>