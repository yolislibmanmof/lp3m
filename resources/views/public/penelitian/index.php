<style>
    @keyframes rspFloat1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(28px,-34px)} }
    @keyframes rspFloat2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-32px,26px)} }
    @keyframes rspShine { 0%{left:-120%} 60%,100%{left:160%} }
    @keyframes rspFadeUp { from{opacity:0;transform:translateY(22px)} to{opacity:1;transform:none} }
    @keyframes rspCount { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:none} }

    .rsp-wrap { max-width:1200px; margin:0 auto; padding:0 20px; }

    /* ===== HERO ===== */
    .rsp-hero { position:relative; overflow:hidden; border-radius:28px; padding:56px 44px; margin-bottom:30px; color:#fff; background:linear-gradient(135deg,#0c1f4d 0%,#1e3a8a 45%,#1d4ed8 100%); box-shadow:0 26px 64px rgba(12,31,77,.45); animation:rspFadeUp .6s cubic-bezier(.16,1,.3,1) both; }
    .rsp-hero::before { content:''; position:absolute; inset:0; opacity:.4; background-image:repeating-linear-gradient(45deg,transparent,transparent 28px,rgba(253,230,138,.06) 28px,rgba(253,230,138,.06) 29px),repeating-linear-gradient(-45deg,transparent,transparent 28px,rgba(253,230,138,.06) 28px,rgba(253,230,138,.06) 29px); pointer-events:none; }
    .rsp-hero::after { content:''; position:absolute; top:-40%; right:-10%; width:500px; height:500px; border-radius:50%; background:radial-gradient(circle,rgba(217,164,65,.3),transparent 70%); pointer-events:none; }
    .rsp-orb { position:absolute; border-radius:50%; pointer-events:none; filter:blur(4px); }
    .rsp-orb-1 { width:240px; height:240px; top:-60px; right:-40px; background:radial-gradient(circle at 30% 30%,rgba(253,230,138,.55),rgba(217,164,65,.2) 60%,transparent); animation:rspFloat1 13s ease-in-out infinite; }
    .rsp-orb-2 { width:300px; height:300px; bottom:-120px; left:-60px; background:radial-gradient(circle at 70% 70%,rgba(96,165,250,.45),rgba(29,78,216,.18) 60%,transparent); animation:rspFloat2 16s ease-in-out infinite; }
    .rsp-eyebrow { display:inline-flex; align-items:center; gap:8px; position:relative; z-index:2; padding:5px 14px; border-radius:999px; margin-bottom:18px; font-size:10.5px; font-weight:900; letter-spacing:.2em; text-transform:uppercase; background:rgba(253,230,138,.16); border:1px solid rgba(253,230,138,.35); color:#fde68a; }
    .rsp-hero h1 { position:relative; z-index:2; font-family:var(--font-display); font-size:clamp(28px,4.4vw,46px); font-weight:900; margin:0 0 12px; letter-spacing:-.025em; line-height:1.1; background:linear-gradient(135deg,#fff,#fde68a 55%,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .rsp-hero p { position:relative; z-index:2; opacity:.92; max-width:640px; font-size:15.5px; line-height:1.65; margin:0; }

    /* ===== STATS GLASS ===== */
    .rsp-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-top:30px; position:relative; z-index:2; }
    .rsp-stat { position:relative; overflow:hidden; padding:20px 22px; border-radius:18px; background:linear-gradient(145deg,rgba(255,255,255,.16),rgba(255,255,255,.06)); border:1px solid rgba(255,255,255,.22); backdrop-filter:blur(10px); animation:rspCount .6s cubic-bezier(.16,1,.3,1) both; }
    .rsp-stat:nth-child(2){animation-delay:.08s} .rsp-stat:nth-child(3){animation-delay:.16s}
    .rsp-stat::after { content:''; position:absolute; top:-40px; right:-30px; width:110px; height:110px; border-radius:50%; background:radial-gradient(circle,rgba(253,230,138,.25),transparent 70%); pointer-events:none; }
    .rsp-stat .ico { font-size:22px; margin-bottom:8px; }
    .rsp-stat .v { font-family:var(--font-display); font-size:clamp(22px,2.6vw,30px); font-weight:900; color:#fde68a; line-height:1; }
    .rsp-stat .l { font-size:10.5px; opacity:.85; text-transform:uppercase; letter-spacing:.1em; margin-top:6px; font-weight:700; }

    /* ===== FILTER ===== */
    .rsp-filter { display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:14px; padding:16px 20px; background:var(--white); border:1px solid var(--border); border-radius:18px; box-shadow:0 6px 18px rgba(0,0,0,.05); animation:rspFadeUp .55s .08s both; }
    .rsp-filter .fld { position:relative; flex:1; min-width:220px; }
    .rsp-filter .fld input { width:100%; padding:11px 16px 11px 40px; border-radius:11px; border:2px solid var(--border); background:#fff; font-size:13px; font-weight:600; color:#03251f; transition:all .25s; }
    .rsp-filter .fld::before { content:'🔍'; position:absolute; left:14px; top:50%; transform:translateY(-50%); font-size:13px; opacity:.6; }
    .rsp-filter .fld input:focus { outline:none; border-color:#1d4ed8; box-shadow:0 0 0 4px rgba(29,78,216,.12); }
    .rsp-filter select { padding:11px 38px 11px 14px; border-radius:11px; border:2px solid var(--border); background:#fff; font-size:13px; font-weight:600; color:#03251f; cursor:pointer; appearance:none; -webkit-appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%231d4ed8' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 14px center; }
    .rsp-filter button { position:relative; overflow:hidden; padding:11px 22px; border:none; border-radius:11px; background:linear-gradient(145deg,#1d4ed8,#1e3a8a); color:#fff; font-weight:800; font-size:13px; cursor:pointer; font-family:var(--font-display); box-shadow:inset 0 2px 3px rgba(255,255,255,.3), 0 6px 16px rgba(29,78,216,.35); transition:all .25s; }
    .rsp-filter button:hover { transform:translateY(-2px); box-shadow:0 12px 24px rgba(29,78,216,.45); }

    /* ===== FILTER PILLS ===== */
    .rsp-pills { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:22px; padding:10px; background:var(--white); border:1px solid var(--border); border-radius:14px; animation:rspFadeUp .55s .12s both; }
    .rsp-pill { padding:8px 16px; border-radius:999px; border:1px solid var(--border); background:transparent; font-size:12px; font-weight:800; color:var(--text); cursor:pointer; transition:all .25s; text-decoration:none; }
    .rsp-pill:hover { border-color:rgba(29,78,216,.4); color:#1d4ed8; transform:translateY(-2px); }
    .rsp-pill.active { background:linear-gradient(145deg,#1d4ed8,#1e3a8a); color:#fff; border-color:transparent; box-shadow:0 6px 14px rgba(29,78,216,.3); }

    /* ===== HEAD + VIEW TOGGLE ===== */
    .rsp-head { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:20px; flex-wrap:wrap; animation:rspFadeUp .55s .16s both; }
    .rsp-head h2 { font-family:var(--font-display); font-size:20px; font-weight:900; color:var(--ink); margin:0; display:flex; align-items:center; gap:10px; }
    .rsp-head .count { font-size:12px; font-weight:800; color:#1d4ed8; background:rgba(29,78,216,.1); padding:5px 13px; border-radius:999px; }
    .rsp-view-toggle { display:flex; gap:4px; padding:4px; background:var(--surface); border:1px solid var(--border); border-radius:10px; }
    .rsp-view-btn { width:34px; height:34px; border-radius:8px; border:none; background:transparent; font-size:13px; cursor:pointer; color:var(--muted); transition:all .2s; }
    .rsp-view-btn.active { background:#fff; color:#1d4ed8; box-shadow:0 2px 6px rgba(0,0,0,.08); }

    /* ===== GRID ===== */
    .rsp-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:22px; }
    .rsp-grid.list { grid-template-columns:1fr; }
    .rsp-card { position:relative; overflow:hidden; display:flex; flex-direction:column; background:var(--white); border:1px solid var(--border); border-radius:20px; padding:24px 24px 22px; text-decoration:none; color:inherit; transition:all .35s cubic-bezier(.16,1,.3,1); opacity:0; transform:translateY(18px); }
    .rsp-card.in { opacity:1; transform:translateY(0); }
    .rsp-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,#1d4ed8,#3b82f6,#f2c063); transform:scaleX(0); transform-origin:left; transition:transform .4s ease; }
    .rsp-card::after { content:''; position:absolute; top:0; left:-120%; width:60%; height:100%; background:linear-gradient(105deg,transparent,rgba(255,255,255,.55),transparent); transform:skewX(-20deg); pointer-events:none; }
    .rsp-card:hover { transform:translateY(-8px); box-shadow:0 22px 44px rgba(29,78,216,.18); border-color:rgba(29,78,216,.3); }
    .rsp-card.in:hover { transform:translateY(-8px); }
    .rsp-card:hover::before { transform:scaleX(1); }
    .rsp-card:hover::after { animation:rspShine .9s ease-out; }
    .rsp-card:hover .rsp-arrow { transform:translateX(4px); background:linear-gradient(145deg,#1d4ed8,#1e3a8a); color:#fff; }

    /* List view */
    .rsp-grid.list .rsp-card { flex-direction:row; gap:20px; align-items:center; padding:20px 24px; }
    .rsp-grid.list .rsp-card-top { flex:0 0 auto; }
    .rsp-grid.list .rsp-card h3 { font-size:15px; margin:8px 0; }
    .rsp-grid.list .rsp-card .meta { margin-top:8px; padding-top:10px; }
    .rsp-grid.list .rsp-card .foot { margin-top:8px; }

    .rsp-badge { display:inline-flex; align-items:center; gap:5px; width:fit-content; padding:4px 11px; border-radius:999px; font-size:10px; font-weight:800; letter-spacing:.05em; background:linear-gradient(145deg,rgba(29,78,216,.14),rgba(59,130,246,.08)); color:#1e40af; border:1px solid rgba(29,78,216,.18); }
    .rsp-badge.ongoing { background:rgba(16,185,129,.12); color:#047857; border-color:rgba(16,185,129,.3); }
    .rsp-badge.completed { background:rgba(100,116,139,.1); color:#475569; border-color:rgba(100,116,139,.25); }
    .rsp-card h3 { font-family:var(--font-display); font-size:16px; font-weight:800; margin:14px 0 10px; color:var(--ink); line-height:1.4; }
    .rsp-card .desc { font-size:13px; color:var(--muted); line-height:1.55; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; flex:1; }
    .rsp-card .meta { font-size:11.5px; color:var(--muted); display:flex; gap:8px; flex-wrap:wrap; margin-top:16px; padding-top:14px; border-top:1px dashed var(--border); }
    .rsp-card .meta span { display:inline-flex; align-items:center; gap:4px; }
    .rsp-card .foot { display:flex; align-items:center; justify-content:space-between; margin-top:14px; }
    .rsp-card .read { font-size:12px; font-weight:800; color:#1d4ed8; }
    .rsp-arrow { width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:rgba(29,78,216,.1); color:#1d4ed8; font-size:13px; font-weight:900; transition:all .3s; }

    /* Highlight search term */
    mark { background:rgba(253,230,138,.4); color:inherit; padding:0 3px; border-radius:4px; }

    /* ===== EMPTY ===== */
    .rsp-empty { text-align:center; padding:70px 24px; color:var(--muted); background:linear-gradient(145deg,rgba(29,78,216,.04),rgba(29,78,216,.01)); border:2px dashed rgba(29,78,216,.25); border-radius:22px; }
    .rsp-empty .big { font-size:56px; margin-bottom:14px; opacity:.8; }
    .rsp-empty h3 { font-family:var(--font-display); font-size:20px; font-weight:900; color:var(--ink); margin:0 0 8px; }
    .rsp-empty p { font-size:14px; margin:0; max-width:420px; margin-left:auto; margin-right:auto; }

    /* ===== PAGINATION ===== */
    .rsp-pag { display:flex; gap:8px; flex-wrap:wrap; margin-top:30px; justify-content:center; }
    .rsp-pag a { min-width:42px; text-align:center; padding:9px 14px; border-radius:11px; border:1px solid var(--border); background:var(--white); font-weight:800; font-size:13px; color:var(--text); text-decoration:none; transition:all .25s; }
    .rsp-pag a:hover { transform:translateY(-2px); box-shadow:0 6px 14px rgba(0,0,0,.1); border-color:rgba(29,78,216,.3); color:#1d4ed8; }
    .rsp-pag a.active { background:linear-gradient(145deg,#1d4ed8,#1e3a8a); color:#fff; border-color:transparent; box-shadow:0 6px 16px rgba(29,78,216,.4); }

    @media(max-width:900px){ .rsp-grid,.rsp-stats{grid-template-columns:1fr 1fr;} }
    @media(max-width:600px){
        .rsp-grid,.rsp-stats{grid-template-columns:1fr;}
        .rsp-hero{padding:36px 24px;}
        .rsp-filter{padding:14px; flex-direction:column;}
        .rsp-filter .fld, .rsp-filter select, .rsp-filter button { width:100%; }
        .rsp-grid.list .rsp-card { flex-direction:column; align-items:stretch; }
    }
</style>

<div class="rsp-wrap">
    <!-- ===== HERO ===== -->
    <div class="rsp-hero">
        <div class="rsp-orb rsp-orb-1"></div>
        <div class="rsp-orb rsp-orb-2"></div>
        <span class="rsp-eyebrow">🔬 Catur Dharma · Riset</span>
        <h1>Penelitian <span style="background:linear-gradient(135deg,#fde68a,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;">LP3M</span></h1>
        <p>Rekam jejak penelitian dosen dan lembaga — dari pendanaan hingga luaran ilmiah yang berdampak nyata bagi masyarakat dan kemajuan ilmu pengetahuan.</p>

        <div class="rsp-stats">
            <div class="rsp-stat">
                <div class="ico">🧪</div>
                <div class="v"><?= number_format($stats['total']) ?></div>
                <div class="l">Penelitian Aktif</div>
            </div>
            <div class="rsp-stat">
                <div class="ico">💰</div>
                <div class="v">Rp <?= number_format($stats['funding'], 0, ',', '.') ?></div>
                <div class="l">Total Pendanaan</div>
            </div>
            <div class="rsp-stat">
                <div class="ico">📅</div>
                <div class="v"><?= (int)$stats['years'] ?></div>
                <div class="l">Tahun Berjalan</div>
            </div>
        </div>
    </div>

    <!-- ===== FILTER FORM ===== -->
    <form method="get" action="<?= e(url('public/index.php')) ?>" class="rsp-filter">
        <input type="hidden" name="page" value="penelitian">
        <div class="fld">
            <input type="text" name="q" value="<?= e($q) ?>" placeholder="Cari judul atau ketua peneliti...">
        </div>
        <select name="scheme">
            <option value="">Semua Skema</option>
            <?php foreach (Research::SCHEMES as $k => $l): ?>
                <option value="<?= e($k) ?>" <?= $scheme === $k ? 'selected' : '' ?>><?= e($l) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="sort">
            <option value="newest" <?= ($sort ?? 'newest') === 'newest' ? 'selected' : '' ?>>📅 Terbaru</option>
            <option value="oldest" <?= ($sort ?? '') === 'oldest' ? 'selected' : '' ?>>📅 Terlama</option>
            <option value="funding-desc" <?= ($sort ?? '') === 'funding-desc' ? 'selected' : '' ?>>💰 Pendanaan ↓</option>
            <option value="funding-asc" <?= ($sort ?? '') === 'funding-asc' ? 'selected' : '' ?>>💰 Pendanaan ↑</option>
        </select>
        <button type="submit">🔍 Filter</button>
    </form>

    <!-- ===== FILTER PILLS (Skema cepat) ===== -->
    <div class="rsp-pills">
        <a class="rsp-pill <?= $scheme === '' ? 'active' : '' ?>" href="<?= e(url('public/index.php?page=penelitian')) ?>">✨ Semua</a>
        <?php foreach (Research::SCHEMES as $k => $l): ?>
            <a class="rsp-pill <?= $scheme === $k ? 'active' : '' ?>" href="<?= e(url('public/index.php?page=penelitian&scheme=' . urlencode($k))) ?>"><?= e($l) ?></a>
        <?php endforeach; ?>
    </div>

    <?php if (empty($items)): ?>
        <div class="rsp-empty">
            <div class="big">🔭</div>
            <h3>Belum Ada Penelitian yang Cocok</h3>
            <p>Coba ubah kata kunci atau filter skema untuk menemukan penelitian yang Anda cari.</p>
        </div>
    <?php else: ?>
        <!-- ===== HEAD + VIEW TOGGLE ===== -->
        <div class="rsp-head">
            <h2>📚 Daftar Penelitian <span class="count"><?= (int)$total ?> hasil</span></h2>
            <div class="rsp-view-toggle">
                <button type="button" class="rsp-view-btn active" data-view="grid" title="Grid">▦</button>
                <button type="button" class="rsp-view-btn" data-view="list" title="List">☰</button>
            </div>
        </div>

        <div class="rsp-grid" id="rsp-grid">
            <?php
            $currentYear = (int) date('Y');
            foreach ($items as $idx => $it):
                $year = (int) $it['year'];
                $status = $year >= $currentYear ? 'ongoing' : 'completed';
                $statusLabel = $status === 'ongoing' ? 'Berjalan' : 'Selesai';
                $schemeLabel = Research::SCHEMES[$it['scheme']] ?? $it['scheme'];
            ?>
                <a class="rsp-card" style="animation-delay:<?= min($idx * 0.05, 0.4) ?>s" href="<?= e(url('public/index.php?page=penelitian-detail&id=' . $it['id'])) ?>">
                    <div class="rsp-card-top">
                        <span class="rsp-badge"><?= e($schemeLabel) ?></span>
                        <span class="rsp-badge <?= $status ?>" style="margin-left:6px;"><?= $status === 'ongoing' ? '⚙️' : '✅' ?> <?= $statusLabel ?></span>
                    </div>
                    <h3><?= e($it['title']) ?></h3>
                    <?php if (!empty($it['description'])): ?>
                        <p class="desc"><?= e($it['description']) ?></p>
                    <?php endif; ?>
                    <div class="meta">
                        <span>👤 <?= e($it['leader']) ?></span>
                        <span>📅 <?= $year ?></span>
                        <?php if (!empty($it['field'])): ?><span>🏷️ <?= e(Research::FIELDS[$it['field']] ?? $it['field']) ?></span><?php endif; ?>
                        <?php if ((int)$it['funding'] > 0): ?><span>💰 Rp <?= number_format((int)$it['funding'], 0, ',', '.') ?></span><?php endif; ?>
                    </div>
                    <div class="foot">
                        <span class="read">Baca selengkapnya</span>
                        <span class="rsp-arrow">→</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="rsp-pag">
                <?php
                $qParam = $q ? '&q=' . urlencode($q) : '';
                $schemeParam = $scheme ? '&scheme=' . urlencode($scheme) : '';
                $sortParam = !empty($sort) && $sort !== 'newest' ? '&sort=' . urlencode($sort) : '';
                for ($i = 1; $i <= $totalPages; $i++):
                    $url = url('public/index.php?page=penelitian&hal=' . $i . $qParam . $schemeParam . $sortParam);
                ?>
                    <a href="<?= e($url) ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
(function(){
    // View toggle
    var viewBtns = document.querySelectorAll('.rsp-view-btn');
    var grid = document.getElementById('rsp-grid');
    viewBtns.forEach(function(btn){
        btn.addEventListener('click', function(){
            viewBtns.forEach(function(b){ b.classList.remove('active'); });
            btn.classList.add('active');
            if (grid) {
                if (btn.dataset.view === 'list') grid.classList.add('list');
                else grid.classList.remove('list');
            }
        });
    });

    // Highlight search term di judul & deskripsi
    var q = <?= json_encode($q ?? '') ?>.toString().trim();
    if (q.length >= 3) {
        var cards = document.querySelectorAll('.rsp-card h3, .rsp-card .desc');
        var re = new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
        cards.forEach(function(el){
            var text = el.textContent;
            if (re.test(text)) {
                el.innerHTML = el.innerHTML.replace(re, '<mark>$1</mark>');
            }
        });
    }

    // Reveal on scroll
    var cards = document.querySelectorAll('.rsp-card');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(entries){
            entries.forEach(function(en){
                if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
            });
        }, { threshold: 0.1 });
        cards.forEach(function(card){ io.observe(card); });
    } else {
        cards.forEach(function(card){ card.classList.add('in'); });
    }
})();
</script>