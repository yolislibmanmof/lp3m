<style>
    @keyframes cbFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    .cb-head { position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:26px 30px; border-radius:22px; background:linear-gradient(135deg,#065f46 0%,#059669 55%,#10b981 100%); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:cbFade .5s both; }
    .cb-head::after { content:''; position:absolute; top:-50%; right:-8%; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(253,230,138,.22),transparent 70%); pointer-events:none; }
    .cb-head-ico { width:58px; height:58px; border-radius:17px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:26px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.6),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:inset 0 2px 3px rgba(255,255,255,.65), 0 6px 16px rgba(217,164,65,.4); position:relative; z-index:1; }
    .cb-head h2 { margin:0 0 4px; font-family:var(--font-display); font-size:22px; font-weight:900; letter-spacing:-.015em; position:relative; z-index:1; }
    .cb-head p { margin:0; font-size:12.5px; opacity:.92; position:relative; z-index:1; }
    .cb-head .acts { margin-left:auto; display:flex; gap:8px; flex-wrap:wrap; position:relative; z-index:1; }
    .cb-act { padding:9px 16px; border-radius:10px; font-size:12.5px; font-weight:800; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:6px; }
    .cb-act.gold { color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:0 4px 12px rgba(217,164,65,.35); }
    .cb-act.ghost { color:#fff; background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.3); }
    .cb-act:hover { transform:translateY(-2px); filter:brightness(1.05); }

    .cb-stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:14px; margin-bottom:24px; animation:cbFade .5s .06s both; }
    .cb-stat { position:relative; overflow:hidden; padding:20px; border-radius:18px; background:var(--surface); border:1px solid var(--border); box-shadow:0 8px 22px rgba(3,37,31,.06); }
    .cb-stat::after { content:''; position:absolute; top:-40px; right:-30px; width:110px; height:110px; border-radius:50%; background:radial-gradient(circle,rgba(var(--rgb),.16),transparent 70%); pointer-events:none; }
    .cb-stat .ico { font-size:20px; margin-bottom:8px; }
    .cb-stat b { display:block; font-family:var(--font-display); font-size:30px; font-weight:900; color:var(--ink); line-height:1; position:relative; z-index:1; }
    .cb-stat span { display:block; font-size:10px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--muted); margin-top:5px; }

    .cb-2col { display:grid; grid-template-columns:1.3fr 1fr; gap:18px; margin-bottom:22px; }
    @media(max-width:1000px){ .cb-2col{grid-template-columns:1fr;} }
    .cb-panel { position:relative; background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:22px; animation:cbFade .5s .1s both; }
    .cb-panel::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#065f46,#10b981,#f2c063); opacity:.85; border-radius:20px 20px 0 0; }
    .cb-panel h3 { display:flex; align-items:center; gap:10px; margin:0 0 16px; font-family:var(--font-display); font-size:14px; font-weight:900; color:#fff; padding-bottom:12px; border-bottom:1px dashed var(--border); }
    .cb-panel h3 .emo { width:30px; height:30px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:15px; background:rgba(5,150,105,.14); }
    .cb-panel h3 .num { margin-left:auto; font-size:10px; font-weight:900; letter-spacing:.1em; color:var(--muted); }

    .cb-top { list-style:none; margin:0; padding:0; }
    .cb-top li { display:flex; align-items:center; gap:12px; padding:10px 12px; border-radius:10px; background:rgba(255,255,255,.02); border:1px solid var(--border); margin-bottom:8px; transition:all .2s; }
    .cb-top li:hover { border-color:rgba(5,150,105,.4); transform:translateX(3px); }
    .cb-top .rank { flex-shrink:0; width:26px; height:26px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:900; background:rgba(5,150,105,.12); color:#059669; }
    .cb-top .rank.r1 { background:linear-gradient(145deg,#fde68a,#d9a441); color:#03251f; }
    .cb-top .rank.r2 { background:linear-gradient(145deg,#e5e7eb,#9ca3af); color:#fff; }
    .cb-top .rank.r3 { background:linear-gradient(145deg,#fdba74,#c2410c); color:#fff; }
    .cb-top .q { flex:1; min-width:0; font-size:12.5px; color:var(--text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .cb-top .cnt { font-family:var(--font-display); font-size:14px; font-weight:900; color:var(--muted); }

    .cb-log { list-style:none; margin:0; padding:0; }
    .cb-log li { padding:11px 0; border-bottom:1px dashed var(--border); }
    .cb-log li:last-child { border-bottom:none; }
    .cb-log .row { display:flex; gap:8px; align-items:flex-start; }
    .cb-log .role { flex-shrink:0; width:24px; height:24px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; }
    .cb-log .role.u { background:linear-gradient(145deg,#3b82f6,#1d4ed8); color:#fff; }
    .cb-log .role.b { background:linear-gradient(145deg,#fde68a,#d9a441); }
    .cb-log .txt { flex:1; min-width:0; font-size:12.5px; color:var(--text); line-height:1.55; }
    .cb-log .txt small { display:block; font-size:10.5px; color:var(--muted); margin-top:2px; }
    .cb-log .txt .src-tag { padding:1px 7px; border-radius:999px; font-size:8.5px; font-weight:800; }
    .cb-log .txt .src-tag.local { background:rgba(5,150,105,.12); color:#047857; }
    .cb-log .txt .src-tag.ai { background:rgba(124,58,237,.12); color:#7c3aed; }

    .cb-actions-row { display:flex; gap:8px; flex-wrap:wrap; margin-top:14px; padding-top:14px; border-top:1px dashed var(--border); }
    .cb-mini { padding:7px 13px; border-radius:9px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--muted); font-size:11.5px; font-weight:800; text-decoration:none; transition:all .2s; display:inline-flex; align-items:center; gap:5px; cursor:pointer; }
    .cb-mini:hover { border-color:rgba(5,150,105,.45); color:var(--text); transform:translateY(-2px); }
    .cb-mini.danger:hover { border-color:rgba(220,38,38,.5); color:#fca5a5; }
    .cb-mini.primary { background:linear-gradient(145deg,#065f46,#043b2c); color:#fde68a; border-color:transparent; }
</style>

<div class="cb-head">
    <div class="cb-head-ico">🤖</div>
    <div style="flex:1; min-width:0;">
        <h2>Siti · Asisten AI LP3M</h2>
        <p>Monitor performa chatbot, kelola pengetahuan, dan analisis pertanyaan pengunjung.</p>
    </div>
    <div class="acts">
        <a class="cb-act gold" href="<?= e(url('admin/index.php?page=chatbot-knowledge')) ?>">📚 Knowledge Base</a>
        <a class="cb-act ghost" href="<?= e(url('admin/index.php?page=chatbot-config')) ?>">⚙️ Config AI</a>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<!-- STATISTIK UTAMA -->
<div class="cb-stats">
    <div class="cb-stat" style="--rgb:5,150,105">
        <div class="ico">💬</div>
        <b data-count="<?= (int) $stats['total'] ?>"><?= number_format($stats['total']) ?></b>
        <span>Total Percakapan</span>
    </div>
    <div class="cb-stat" style="--rgb:59,130,246">
        <div class="ico">📅</div>
        <b data-count="<?= (int) $stats['today'] ?>"><?= number_format($stats['today']) ?></b>
        <span>Hari Ini</span>
    </div>
    <div class="cb-stat" style="--rgb:124,58,237">
        <div class="ico">✨</div>
        <b data-count="<?= (int) $stats['ai'] ?>"><?= number_format($stats['ai']) ?></b>
        <span>Jawaban AI</span>
    </div>
    <div class="cb-stat" style="--rgb:16,185,129">
        <div class="ico">📚</div>
        <b data-count="<?= (int) $stats['local'] ?>"><?= number_format($stats['local']) ?></b>
        <span>Jawaban Lokal</span>
    </div>
    <div class="cb-stat" style="--rgb:16,185,129">
        <div class="ico">👍</div>
        <b data-count="<?= (int) $stats['good'] ?>"><?= number_format($stats['good']) ?></b>
        <span>Feedback Positif</span>
    </div>
    <div class="cb-stat" style="--rgb:220,38,38">
        <div class="ico">👎</div>
        <b data-count="<?= (int) $stats['bad'] ?>"><?= number_format($stats['bad']) ?></b>
        <span>Feedback Negatif</span>
    </div>
    <div class="cb-stat" style="--rgb:217,164,65">
        <div class="ico">📚</div>
        <b data-count="<?= count($knowledge) ?>"><?= count($knowledge) ?></b>
        <span>Knowledge Items</span>
    </div>
    <div class="cb-stat" style="--rgb:5,150,105">
        <div class="ico">⭐</div>
        <?php $sat = ($stats['good'] + $stats['bad']) > 0 ? round($stats['good'] / ($stats['good'] + $stats['bad']) * 100, 1) : 0; ?>
        <b><?= $sat ?>%</b>
        <span>Satisfaction Rate</span>
    </div>
</div>

<div class="cb-2col">
    <!-- TOP QUESTIONS -->
    <div class="cb-panel">
        <h3><span class="emo">🔥</span><span>Top Questions</span><span class="num">TERPOPULER</span></h3>
        <?php if (empty($topQ)): ?>
        <div style="text-align:center; padding:30px 10px; color:var(--muted); font-size:12.5px;">📭 Belum ada percakapan.</div>
        <?php else: ?>
        <ul class="cb-top">
            <?php foreach ($topQ as $i => $q): $rank = $i + 1; $cls = $rank === 1 ? 'r1' : ($rank === 2 ? 'r2' : ($rank === 3 ? 'r3' : '')); ?>
            <li>
                <span class="rank <?= $cls ?>"><?= $rank ?></span>
                <span class="q" title="<?= e($q['user_message']) ?>"><?= e($q['user_message']) ?></span>
                <span class="cnt">× <?= (int) $q['cnt'] ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>

    <!-- RECENT LOGS -->
    <div class="cb-panel">
        <h3><span class="emo">📜</span><span>Percakapan Terbaru</span><span class="num">REAL-TIME</span></h3>
        <?php if (empty($recentLogs)): ?>
        <div style="text-align:center; padding:30px 10px; color:var(--muted); font-size:12.5px;">📭 Belum ada percakapan.</div>
        <?php else: ?>
        <ul class="cb-log">
            <?php foreach ($recentLogs as $l): ?>
            <li>
                <div class="row">
                    <span class="role u">👤</span>
                    <div class="txt">
                        <?= e(mb_strimwidth($l['user_message'], 0, 120, '…')) ?>
                        <small><?= e(date('d M · H:i', strtotime($l['created_at']))) ?></small>
                    </div>
                </div>
                <div class="row" style="margin-top:6px;">
                    <span class="role b">🤖</span>
                    <div class="txt">
                        <?= e(mb_strimwidth($l['bot_response'], 0, 140, '…')) ?>
                        <small>
                            <span class="src-tag <?= e($l['source']) ?>"><?= $l['source'] === 'ai' ? '✨ AI' : '📚 Lokal' ?></span>
                            · confidence: <?= (int) $l['confidence'] ?>%
                            · <?= $l['feedback'] === 'good' ? '👍' : ($l['feedback'] === 'bad' ? '👎' : '—') ?>
                        </small>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <div class="cb-actions-row">
            <a class="cb-mini primary" href="<?= e(url('admin/index.php?page=chatbot-export')) ?>">📥 Export CSV (5000)</a>
            <form method="post" action="<?= e(url('admin/index.php?page=chatbot-clear')) ?>" style="display:inline-flex; gap:6px; align-items:center;" onsubmit="return confirm('Hapus log lama?');">
                <?= csrf_field() ?>
                <input type="number" name="days" value="30" min="1" max="365" style="width:55px; padding:7px 8px; border-radius:8px; border:1px solid var(--border); background:var(--surface); font-size:11.5px; font-weight:800; color:var(--text);">
                <button class="cb-mini danger" type="submit">🗑️ Bersihkan</button>
            </form>
        </div>
    </div>
</div>

<script>
(function(){
    document.querySelectorAll('[data-count]').forEach(function(el){
        var target = parseInt(el.getAttribute('data-count'), 10) || 0;
        if (target === 0) return;
        var start = null;
        function step(t){
            if (!start) start = t;
            var p = Math.min((t - start) / 900, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(target * eased).toLocaleString('id-ID');
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    });
})();
</script>