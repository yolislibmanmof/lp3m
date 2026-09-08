<?php
$ai = AuditLog::actionInfo($item['action']);
$old = $item['old_value']; $new = $item['new_value'];
$oldArr = is_string($old) ? @json_decode($old, true) : null;
$newArr = is_string($new) ? @json_decode($new, true) : null;

function al_pretty($v) {
    if ($v === null) return '<i style="opacity:.5;">(kosong)</i>';
    if (is_string($v)) { $j = @json_decode($v, true); if ($j !== null) $v = $j; else return nl2br(e($v)); }
    $j = json_encode($v, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    return '<pre style="margin:0; font-size:12px; line-height:1.5; white-space:pre-wrap; word-break:break-word;">' . e($j) . '</pre>';
}

function al_diff(?array $old, ?array $new): array {
    $changed = [];
    $allKeys = array_unique(array_merge(array_keys($old ?? []), array_keys($new ?? [])));
    foreach ($allKeys as $k) {
        $a = $old[$k] ?? null;
        $b = $new[$k] ?? null;
        if ($a !== $b && $k !== 'password') {
            $changed[$k] = ['old' => $a, 'new' => $b];
        }
    }
    return $changed;
}
$diff = al_diff(is_array($oldArr) ? $oldArr : null, is_array($newArr) ? $newArr : null);
?>
<style>
    @keyframes aldFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    .ald-back { display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:700; color:#3b82f6; text-decoration:none; margin-bottom:18px; padding:8px 16px; border-radius:999px; background:var(--surface); border:1px solid var(--border); transition:all .25s; }
    .ald-back:hover { transform:translateX(-4px); border-color:rgba(59,130,246,.35); }
    .ald-head { position:relative; overflow:hidden; display:flex; gap:16px; padding:22px 26px; border-radius:20px; background:linear-gradient(135deg,rgba(var(--rgb),.14),rgba(var(--rgb),.04)); border:1px solid rgba(var(--rgb),.35); margin-bottom:18px; animation:aldFade .5s both; }
    .ald-head .ico { width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:24px; flex-shrink:0; background:rgba(var(--rgb),.18); color:var(--hex); }
    .ald-head h2 { margin:0 0 4px; font-family:var(--font-display); font-size:18px; font-weight:900; color:var(--text); }
    .ald-head p { margin:0; font-size:12.5px; color:var(--muted); }
    .ald-id { margin-left:auto; padding:4px 12px; border-radius:999px; font-size:10px; font-weight:900; letter-spacing:.1em; background:rgba(var(--rgb),.16); color:var(--hex); border:1px solid rgba(var(--rgb),.35); }

    .ald-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:18px; }
    @media(max-width:800px){ .ald-grid{grid-template-columns:1fr;} }
    .ald-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:18px 22px; animation:aldFade .5s .05s both; }
    .ald-card h3 { display:flex; align-items:center; gap:8px; margin:0 0 14px; font-family:var(--font-display); font-size:13px; font-weight:900; color:#fff; padding-bottom:10px; border-bottom:1px dashed var(--border); }
    .ald-row { display:flex; justify-content:space-between; gap:10px; padding:8px 0; border-bottom:1px dashed var(--border); font-size:13px; }
    .ald-row:last-child { border-bottom:none; }
    .ald-row .k { color:var(--muted); font-weight:700; font-size:11.5px; text-transform:uppercase; letter-spacing:.08em; }
    .ald-row .v { color:var(--text); font-weight:700; text-align:right; max-width:60%; word-break:break-all; }

    .ald-diff { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:22px; margin-bottom:18px; animation:aldFade .5s .1s both; }
    .ald-diff h3 { display:flex; align-items:center; gap:8px; margin:0 0 16px; font-family:var(--font-display); font-size:14px; font-weight:900; color:#fff; }
    .ald-diff-empty { text-align:center; padding:30px 16px; color:var(--muted); font-size:13px; }
    .ald-diff-row { display:grid; grid-template-columns:1fr auto 1fr; gap:12px; align-items:start; padding:12px 14px; border-radius:12px; background:rgba(255,255,255,.02); border:1px solid var(--border); margin-bottom:10px; }
    .ald-diff-row:last-child { margin-bottom:0; }
    .ald-diff-field { font-size:10.5px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); margin-bottom:6px; grid-column:1/-1; }
    .ald-diff-old { padding:10px 12px; border-radius:10px; background:rgba(220,38,38,.06); border:1px solid rgba(220,38,38,.25); font-size:12.5px; color:#fca5a5; min-height:36px; }
    .ald-diff-arrow { display:flex; align-items:center; justify-content:center; font-size:18px; color:var(--muted); padding-top:22px; }
    .ald-diff-new { padding:10px 12px; border-radius:10px; background:rgba(16,185,129,.06); border:1px solid rgba(16,185,129,.25); font-size:12.5px; color:#6ee7b7; min-height:36px; }

    .ald-raw { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:22px; animation:aldFade .5s .15s both; }
    .ald-raw h3 { display:flex; align-items:center; gap:8px; margin:0 0 12px; font-family:var(--font-display); font-size:14px; font-weight:900; color:#fff; }
    .ald-raw-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    @media(max-width:800px){ .ald-raw-grid{grid-template-columns:1fr;} }
    .ald-raw-box { padding:12px 14px; border-radius:10px; background:rgba(255,255,255,.03); border:1px solid var(--border); }
    .ald-raw-box h4 { margin:0 0 8px; font-size:10.5px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); }
</style>

<a class="ald-back" href="<?= e(url('admin/index.php?page=audit')) ?>">← Kembali ke Audit Log</a>

<div class="ald-head" style="--rgb:<?= $ai['rgb'] ?>; --hex:<?= $ai['hex'] ?>;">
    <span class="ico"><?= $ai['ico'] ?></span>
    <div style="flex:1; min-width:0;">
        <h2><?= e($ai['label']) ?> oleh <span style="color:var(--hex);"><?= e($item['user_name'] ?? 'Sistem') ?></span></h2>
        <p><?= e($item['user_role'] ?? '—') ?> · <?= e(date('d M Y · H:i:s', strtotime($item['created_at']))) ?></p>
    </div>
    <span class="ald-id">#<?= (int) $item['id'] ?></span>
</div>

<div class="ald-grid">
    <div class="ald-card">
        <h3>🗂️ Entitas</h3>
        <div class="ald-row"><span class="k">Tipe</span><span class="v"><?= e($item['entity_type'] ?? '—') ?></span></div>
        <div class="ald-row"><span class="k">ID</span><span class="v"><?= (int) ($item['entity_id'] ?? 0) ?: '—' ?></span></div>
        <div class="ald-row"><span class="k">Label</span><span class="v"><?= e($item['entity_label'] ?? '—') ?></span></div>
    </div>
    <div class="ald-card">
        <h3>🌐 Konteks</h3>
        <div class="ald-row"><span class="k">IP Address</span><span class="v"><?= e($item['ip_address'] ?? '—') ?></span></div>
        <div class="ald-row"><span class="k">URL</span><span class="v"><?= e($item['url'] ?? '—') ?></span></div>
        <div class="ald-row"><span class="k">User Agent</span><span class="v" style="font-size:11px;"><?= e($item['user_agent'] ?? '—') ?></span></div>
    </div>
</div>

<?php if (!empty($diff)): ?>
<div class="ald-diff">
    <h3>🔀 Perubahan Data (<?= count($diff) ?> field)</h3>
    <?php foreach ($diff as $field => $vals): ?>
    <div class="ald-diff-row">
        <div class="ald-diff-field"><?= e($field) ?></div>
        <div class="ald-diff-old">
            <?php if ($vals['old'] === null): ?><i style="opacity:.5;">(kosong)</i>
            <?php elseif (is_array($vals['old'])): ?><pre style="margin:0; font-size:11px;"><?= e(json_encode($vals['old'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)) ?></pre>
            <?php else: ?><?= e((string) $vals['old']) ?><?php endif; ?>
        </div>
        <div class="ald-diff-arrow">→</div>
        <div class="ald-diff-new">
            <?php if ($vals['new'] === null): ?><i style="opacity:.5;">(kosong)</i>
            <?php elseif (is_array($vals['new'])): ?><pre style="margin:0; font-size:11px;"><?= e(json_encode($vals['new'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)) ?></pre>
            <?php else: ?><?= e((string) $vals['new']) ?><?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (!empty($old) || !empty($new)): ?>
<div class="ald-raw">
    <h3>📦 Data Mentah (JSON)</h3>
    <div class="ald-raw-grid">
        <div class="ald-raw-box">
            <h4>Nilai Lama</h4>
            <?= al_pretty($old) ?>
        </div>
        <div class="ald-raw-box">
            <h4>Nilai Baru</h4>
            <?= al_pretty($new) ?>
        </div>
    </div>
</div>
<?php endif; ?>