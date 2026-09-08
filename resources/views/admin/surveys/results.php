<style>
    @keyframes srFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    .sr-back { display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:800; color:#a78bfa; text-decoration:none; margin-bottom:16px; padding:8px 16px; border-radius:999px; background:var(--surface); border:1px solid var(--border); }
    .sr-back:hover { transform:translateX(-4px); border-color:rgba(124,58,237,.4); }
    .sr-head { position:relative; overflow:hidden; display:flex; gap:18px; align-items:center; padding:24px 28px; border-radius:22px; background:linear-gradient(135deg,#4c1d95,#7c3aed); color:#fff; margin-bottom:20px; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:srFade .5s both; }
    .sr-gauge { width:110px; height:110px; border-radius:50%; flex-shrink:0; position:relative; display:flex; align-items:center; justify-content:center; }
    .sr-gauge .in { position:absolute; inset:10px; border-radius:50%; background:#3b2f63; display:flex; flex-direction:column; align-items:center; justify-content:center; }
    .sr-gauge b { font-family:var(--font-display); font-size:26px; font-weight:900; line-height:1; }
    .sr-gauge span { font-size:8px; font-weight:900; letter-spacing:.12em; opacity:.8; margin-top:2px; }
    .sr-head h2 { margin:0 0 4px; font-family:var(--font-display); font-size:19px; font-weight:900; }
    .sr-head p { margin:0; font-size:12px; opacity:.88; }
    .sr-cat { display:inline-block; margin-top:8px; padding:4px 14px; border-radius:999px; font-size:11px; font-weight:900; color:#03251f; }
    .sr-actions { margin-left:auto; display:flex; gap:8px; flex-wrap:wrap; }
    .sr-btn { padding:9px 16px; border-radius:10px; font-size:12.5px; font-weight:800; text-decoration:none; color:#fff; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.3); }
    .sr-btn.gold { background:linear-gradient(145deg,#fde68a,#d9a441); color:#03251f; border-color:transparent; }

    .sr-q { background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:22px; margin-bottom:16px; animation:srFade .5s both; }
    .sr-q h3 { display:flex; gap:10px; align-items:flex-start; margin:0 0 6px; font-size:14.5px; font-weight:800; color:var(--text); }
    .sr-q h3 .n { flex-shrink:0; width:26px; height:26px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:900; background:linear-gradient(145deg,#8b5cf6,#6d28d9); color:#fff; }
    .sr-q .meta { font-size:11px; color:var(--muted); margin:0 0 14px 36px; }
    .sr-bar-row { display:grid; grid-template-columns:110px 1fr 60px; gap:10px; align-items:center; margin-bottom:7px; }
    .sr-bar-row .lbl { font-size:12px; font-weight:700; color:var(--text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .sr-bar-row .track { height:14px; border-radius:999px; background:rgba(255,255,255,.05); border:1px solid var(--border); overflow:hidden; }
    .sr-bar-row .track i { display:block; height:100%; border-radius:999px; background:linear-gradient(90deg,#8b5cf6,#c4b5fd); transition:width .8s cubic-bezier(.16,1,.3,1); }
    .sr-bar-row .val { font-size:11.5px; font-weight:800; color:var(--muted); text-align:right; }
    .sr-avg { display:inline-flex; align-items:center; gap:8px; margin-left:36px; padding:6px 14px; border-radius:999px; background:rgba(124,58,237,.12); border:1px solid rgba(124,58,237,.35); color:#a78bfa; font-size:12px; font-weight:900; }
    .sr-text { padding:12px 14px; border-radius:12px; background:rgba(255,255,255,.03); border:1px solid var(--border); margin-bottom:8px; font-size:13px; color:var(--text); line-height:1.6; }
    .sr-text small { display:block; margin-top:4px; font-size:10px; color:var(--muted); }
    .sr-resp { background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:22px; animation:srFade .5s both; }
    .sr-resp h3 { margin:0 0 14px; font-family:var(--font-display); font-size:14px; font-weight:900; color:#fff; }
    .sr-resp table { width:100%; border-collapse:collapse; font-size:12px; }
    .sr-resp th { padding:9px 12px; text-align:left; font-size:10px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); border-bottom:1px solid var(--border); }
    .sr-resp td { padding:9px 12px; border-bottom:1px solid var(--border); color:var(--text); }
    .sr-resp code { font-size:10.5px; color:#a78bfa; }
</style>

<a class="sr-back" href="<?= e(url('admin/index.php?page=survei')) ?>">← Kembali ke Daftar Survei</a>

<div class="sr-head">
    <div class="sr-gauge" style="background:conic-gradient(<?= e($ikm['color']) ?> <?= round($ikm['index'] * 3.6) ?>deg, rgba(255,255,255,.15) 0);">
        <div class="in"><b><?= $ikm['index'] > 0 ? $ikm['index'] : '–' ?></b><span>IKM</span></div>
    </div>
    <div style="flex:1;min-width:0;">
        <h2><?= e($item['title']) ?></h2>
        <p><?= number_format($responseCount) ?> respons · <?= count($results) ?> pertanyaan · Status: <?= e(Survey::STATUSES[$item['status']] ?? '') ?></p>
        <?php if ($ikm['count'] > 0): ?><span class="sr-cat" style="background:<?= e($ikm['color']) ?>;">Indeks Kepuasan: <?= $ikm['index'] ?> · <?= e($ikm['category']) ?></span><?php endif; ?>
    </div>
    <div class="sr-actions">
        <a class="sr-btn gold" href="<?= e(url('admin/index.php?page=survei-export&id=' . $item['id'])) ?>">📥 Export CSV</a>
        <a class="sr-btn" href="<?= e(url('public/index.php?page=survei-isi&id=' . $item['id'])) ?>" target="_blank">🔗 Lihat Form</a>
    </div>
</div>

<?php if (empty($results)): ?>
<div style="text-align:center;padding:50px;color:var(--muted);">Belum ada pertanyaan.</div>
<?php else: ?>
<?php foreach ($results as $i => $r): $q = $r['q']; ?>
<div class="sr-q">
    <h3><span class="n"><?= $i + 1 ?></span><span><?= e($q['question']) ?></span></h3>
    <p class="meta"><?= $q['type'] === 'rating' ? '⭐ Rating 1–5' : ($q['type'] === 'choice' ? '🔘 Pilihan Ganda' : '✍️ Esai') ?> · <?= number_format($r['count']) ?> jawaban</p>

    <?php if ($q['type'] === 'rating' && $r['count'] > 0): $max = max(1, max($r['dist'])); ?>
        <?php for ($v = 5; $v >= 1; $v--): $c = $r['dist'][$v] ?? 0; $pct = round($c / $r['count'] * 100); ?>
        <div class="sr-bar-row">
            <span class="lbl"><?= Survey::RATING_LABELS[$v] ?></span>
            <div class="track"><i style="width:<?= round($c / $max * 100) ?>%"></i></div>
            <span class="val"><?= $c ?> (<?= $pct ?>%)</span>
        </div>
        <?php endfor; ?>
        <span class="sr-avg">Rata-rata: <?= $r['avg'] ?> / 5</span>
    <?php elseif ($q['type'] === 'choice' && $r['count'] > 0): $max = max(1, max(array_column($r['choices'], 'c'))); ?>
        <?php foreach ($r['choices'] as $ch): $pct = round($ch['c'] / $r['count'] * 100); ?>
        <div class="sr-bar-row">
            <span class="lbl"><?= e($ch['v']) ?></span>
            <div class="track"><i style="width:<?= round($ch['c'] / $max * 100) ?>%"></i></div>
            <span class="val"><?= $ch['c'] ?> (<?= $pct ?>%)</span>
        </div>
        <?php endforeach; ?>
    <?php elseif ($q['type'] === 'text' && !empty($r['texts'])): ?>
        <?php foreach (array_slice($r['texts'], 0, 8) as $t): ?>
        <div class="sr-text">“<?= e($t['v']) ?>”<small><?= e(date('d M Y · H:i', strtotime($t['created_at']))) ?></small></div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="meta" style="margin-left:0;">Belum ada jawaban.</p>
    <?php endif; ?>
</div>
<?php endforeach; ?>
<?php endif; ?>

<?php if (!empty($responses)): ?>
<div class="sr-resp">
    <h3>🧾 Respons Terbaru</h3>
    <table>
        <thead><tr><th>Token</th><th>Peran</th><th>Nama</th><th>Waktu</th></tr></thead>
        <tbody>
        <?php foreach ($responses as $r): ?>
        <tr>
            <td><code><?= e(substr($r['token'], 0, 10)) ?>…</code></td>
            <td><?= e($r['respondent_role'] ?: '—') ?></td>
            <td><?= e($r['respondent_name'] ?: 'Anonim') ?></td>
            <td><?= e(date('d M Y · H:i', strtotime($r['created_at']))) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>