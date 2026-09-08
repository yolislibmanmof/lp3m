<style>
    @keyframes rspFloat1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(28px,-34px)} }
    @keyframes rspFloat2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-32px,26px)} }
    @keyframes rspShine { 0%{left:-120%} 60%,100%{left:160%} }
    @keyframes rspFadeUp { from{opacity:0;transform:translateY(22px)} to{opacity:1;transform:none} }
    @keyframes rspCount { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:none} }

    /* ===== HERO SINEMATIK ===== */
    .rsp-hero {
        position:relative; overflow:hidden; border-radius:28px;
        padding:56px 44px; margin-bottom:30px; color:#fff;
        background:linear-gradient(135deg,#0c1f4d 0%,#1e3a8a 45%,#1d4ed8 100%);
        box-shadow:0 24px 60px rgba(12,31,77,.45);
        animation:rspFadeUp .6s cubic-bezier(.16,1,.3,1) both;
    }
    .rsp-hero::before {
        content:''; position:absolute; inset:0; opacity:.5;
        background-image:
            repeating-linear-gradient(45deg,transparent,transparent 28px,rgba(253,230,138,.05) 28px,rgba(253,230,138,.05) 29px),
            repeating-linear-gradient(-45deg,transparent,transparent 28px,rgba(253,230,138,.05) 28px,rgba(253,230,138,.05) 29px);
        pointer-events:none;
    }
    .rsp-orb { position:absolute; border-radius:50%; pointer-events:none; filter:blur(4px); }
    .rsp-orb-1 { width:240px; height:240px; top:-60px; right:-40px; background:radial-gradient(circle at 30% 30%,rgba(253,230,138,.55),rgba(217,164,65,.2) 60%,transparent); animation:rspFloat1 13s ease-in-out infinite; }
    .rsp-orb-2 { width:300px; height:300px; bottom:-120px; left:-60px; background:radial-gradient(circle at 70% 70%,rgba(96,165,250,.45),rgba(29,78,216,.18) 60%,transparent); animation:rspFloat2 16s ease-in-out infinite; }
    .rsp-eyebrow {
        display:inline-flex; align-items:center; gap:8px; position:relative; z-index:2;
        padding:5px 14px; border-radius:999px; margin-bottom:18px;
        font-size:10.5px; font-weight:900; letter-spacing:.2em; text-transform:uppercase;
        background:rgba(253,230,138,.16); border:1px solid rgba(253,230,138,.35); color:#fde68a;
    }
    .rsp-hero h1 {
        position:relative; z-index:2; font-family:var(--font-display);
        font-size:clamp(28px,4.4vw,46px); font-weight:900; margin:0 0 12px; letter-spacing:-.025em; line-height:1.1;
    }
    .rsp-hero h1 .gold { background:linear-gradient(135deg,#fde68a,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
    .rsp-hero p { position:relative; z-index:2; opacity:.92; max-width:640px; font-size:15.5px; line-height:1.65; margin:0; }

    /* ===== STATS GLASS ===== */
    .rsp-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-top:30px; position:relative; z-index:2; }
    .rsp-stat {
        position:relative; overflow:hidden; padding:20px 22px; border-radius:18px;
        background:linear-gradient(145deg,rgba(255,255,255,.16),rgba(255,255,255,.06));
        border:1px solid rgba(255,255,255,.22); backdrop-filter:blur(10px);
        animation:rspCount .6s cubic-bezier(.16,1,.3,1) both;
    }
    .rsp-stat:nth-child(2){animation-delay:.08s} .rsp-stat:nth-child(3){animation-delay:.16s}
    .rsp-stat::after { content:''; position:absolute; top:-40px; right:-30px; width:110px; height:110px; border-radius:50%; background:radial-gradient(circle,rgba(253,230,138,.25),transparent 70%); pointer-events:none; }
    .rsp-stat .ico { font-size:22px; margin-bottom:8px; }
    .rsp-stat .v { font-family:var(--font-display); font-size:clamp(22px,2.6vw,30px); font-weight:900; color:#fde68a; line-height:1; }
    .rsp-stat .l { font-size:10.5px; opacity:.85; text-transform:uppercase; letter-spacing:.1em; margin-top:6px; font-weight:700; }

    /* ===== FILTER ===== */
    .rsp-filter {
        display:flex; gap:12px; flex-wrap:wrap; align-items:center;
        margin-bottom:26px; padding:18px 20px;
        background:var(--white); border:1px solid var(--border); border-radius:18px;
        box-shadow:0 6px 18px rgba(0,0,0,.05);
    }
    .rsp-filter .fld { position:relative; flex:1; min-width:200px; }
    .rsp-filter .fld input {
        width:100%; padding:12px 16px 12px 42px; border-radius:12px;
        border:2px solid var(--border); background:#fff;
        font-size:13.5px; font-weight:600; color:#03251f; transition:border-color .25s, box-shadow .25s;
    }
    .rsp-filter .fld::before { content:'🔍'; position:absolute; left:14px; top:50%; transform:translateY(-50%); font-size:14px; opacity:.6; }
    .rsp-filter .fld input:focus { outline:none; border-color:#1d4ed8; box-shadow:0 0 0 4px rgba(29,78,216,.12); }
    .rsp-filter select {
        padding:12px 40px 12px 16px; border-radius:12px; border:2px solid var(--border);
        background:#fff; font-size:13.5px; font-weight:600; color:#03251f; cursor:pointer;
        appearance:none; -webkit-appearance:none;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%231d4ed8' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:right 14px center;
    }
    .rsp-filter button {
        position:relative; overflow:hidden; padding:12px 26px; border:none; border-radius:12px;
        background:linear-gradient(145deg,#34d399,#10b981 50%,#059669); color:#fff;
        font-weight:800; font-size:13.5px; cursor:pointer; font-family:var(--font-display);
        box-shadow:inset 0 2px 3px rgba(255,255,255,.4),0 6px 16px rgba(5,150,105,.35); transition:transform .25s, box-shadow .25s;
    }
    .rsp-filter button:hover { transform:translateY(-2px); box-shadow:0 12px 24px rgba(5,150,105,.45); }

    /* ===== SECTION HEAD ===== */
    .rsp-head { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:20px; flex-wrap:wrap; }
    .rsp-head h2 { font-family:var(--font-display); font-size:20px; font-weight:900; color:var(--ink); margin:0; display:flex; align-items:center; gap:10px; }
    .rsp-head .count { font-size:12px; font-weight:800; color:#1d4ed8; background:rgba(29,78,216,.1); padding:4px 12px; border-radius:999px; }

    /* ===== GRID + KARTU 3D PREMIUM ===== */
    .rsp-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:22px; }
    .rsp-card {
        position:relative; overflow:hidden; display:flex; flex-direction:column;
        background:var(--white); border:1px solid var(--border); border-radius:20px;
        padding:24px 24px 22px; text-decoration:none; color:inherit;
        transition:transform .35s cubic-bezier(.16,1,.3,1), box-shadow .35s, border-color .35s;
        animation:rspFadeUp .55s cubic-bezier(.16,1,.3,1) both;
    }
    .rsp-card::before {
        content:''; position:absolute; top:0; left:0; right:0; height:4px;
        background:linear-gradient(90deg,#1d4ed8,#3b82f6,#f2c063);
        transform:scaleX(0); transform-origin:left; transition:transform .4s ease;
    }
    .rsp-card::after {
        content:''; position:absolute; top:0; left:-120%; width:60%; height:100%;
        background:linear-gradient(105deg,transparent,rgba(255,255,255,.55),transparent);
        transform:skewX(-20deg); pointer-events:none;
    }
    .rsp-card:hover { transform:translateY(-8px); box-shadow:0 22px 44px rgba(29,78,216,.18); border-color:rgba(29,78,216,.3); }
    .rsp-card:hover::before { transform:scaleX(1); }
    .rsp-card:hover::after { animation:rspShine .9s ease-out; }
    .rsp-card:hover .rsp-arrow { transform:translateX(4px); background:linear-gradient(145deg,#1d4ed8,#1e3a8a); color:#fff; }

    .rsp-badge {
        display:inline-flex; align-items:center; gap:5px; width:fit-content;
        padding:4px 11px; border-radius:999px; font-size:10px; font-weight:800; letter-spacing:.03em;
        background:linear-gradient(145deg,rgba(29,78,216,.14),rgba(59,130,246,.08));
        color:#1e40af; border:1px solid rgba(29,78,216,.18);
    }
    .rsp-card h3 { font-family:var(--font-display); font-size:16.5px; font-weight:800; margin:14px 0 10px; color:var(--ink); line-height:1.4; }
    .rsp-card .desc { font-size:13px; color:var(--muted); line-height:1.55; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .rsp-card .meta { font-size:11.5px; color:var(--muted); display:flex; gap:8px; flex-wrap:wrap; margin-top:16px; padding-top:14px; border-top:1px dashed var(--border); }
    .rsp-card .meta span { display:inline-flex; align-items:center; gap:4px; }
    .rsp-card .foot { display:flex; align-items:center; justify-content:space-between; margin-top:14px; }
    .rsp-card .read { font-size:12px; font-weight:800; color:#1d4ed8; }
    .rsp-arrow {
        width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center;
        background:rgba(29,78,216,.1); color:#1d4ed8; font-size:13px; font-weight:900;
        transition:transform .3s, background .3s, color .3s;
    }

    /* ===== EMPTY STATE ===== */
    .rsp-empty {
        text-align:center; padding:60px 24px; color:var(--muted);
        background:var(--white); border:2px dashed var(--border); border-radius:22px;
    }
    .rsp-empty .big { font-size:48px; margin-bottom:12px; }
    .rsp-empty h3 { font-family:var(--font-display); font-size:18px; font-weight:800; color:var(--ink); margin:0 0 6px; }

    /* ===== PAGINATION ===== */
    .rsp-pag { display:flex; gap:8px; flex-wrap:wrap; margin-top:30px; justify-content:center; }
    .rsp-pag a {
        min-width:42px; text-align:center; padding:9px 14px; border-radius:11px;
        border:1px solid var(--border); background:var(--white);
        font-weight:800; font-size:13px; color:var(--text); text-decoration:none;
        transition:transform .25s, box-shadow .25s;
    }
    .rsp-pag a:hover { transform:translateY(-2px); box-shadow:0 6px 14px rgba(0,0,0,.1); }
    .rsp-pag a.active {
        background:linear-gradient(145deg,#1d4ed8,#1e3a8a); color:#fff; border-color:transparent;
        box-shadow:0 6px 16px rgba(29,78,216,.4);
    }

    @media(max-width:900px){ .rsp-grid,.rsp-stats{grid-template-columns:1fr 1fr;} }
    @media(max-width:600px){
        .rsp-grid,.rsp-stats{grid-template-columns:1fr;}
        .rsp-hero{padding:36px 24px;}
        .rsp-filter{padding:14px;}
    }
</style>

<!-- ===== HERO ===== -->
<div class="rsp-hero">
    <div class="rsp-orb rsp-orb-1"></div>
    <div class="rsp-orb rsp-orb-2"></div>
    <span class="rsp-eyebrow">🔬 Catur Dharma · Riset</span>
    <h1>Penelitian <span class="gold">LP3M</span></h1>
    <p>Rekam jejak penelitian dosen dan lembaga — dari pendanaan hingga luaran ilmiah yang berdampak nyata bagi masyarakat dan kemajuan ilmu pengetahuan.</p>

    <div class="rsp-stats">
        <div class="rsp-stat">
            <div class="ico">🧪</div>
            <div class="v"><?= number_format($stats['total']) ?></div>
            <div class="l">Penelitian Aktif</div>
        </div>
        <div class="rsp-stat">
            <div class="ico">💰</div>
            <div class="v">Rp <?= number_format($stats['funding'],0,',','.') ?></div>
            <div class="l">Total Pendanaan</div>
        </div>
        <div class="rsp-stat">
            <div class="ico">📅</div>
            <div class="v"><?= (int)$stats['years'] ?></div>
            <div class="l">Tahun Berjalan</div>
        </div>
    </div>
</div>

<!-- ===== FILTER ===== -->
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
    <button type="submit">🔍 Filter</button>
</form>

<?php if (empty($items)): ?>
    <div class="rsp-empty">
        <div class="big">🔭</div>
        <h3>Belum ada penelitian dipublikasikan</h3>
        <p>Penelitian yang telah didanai dan berjalan akan tampil di sini.</p>
    </div>
<?php else: ?>
    <div class="rsp-head">
        <h2>📚 Daftar Penelitian</h2>
        <span class="count"><?= (int)$total ?> hasil</span>
    </div>

    <div class="rsp-grid">
        <?php foreach ($items as $idx => $it): ?>
            <a class="rsp-card" style="animation-delay:<?= min($idx * 0.05, 0.4) ?>s" href="<?= e(url('public/index.php?page=penelitian-detail&id=' . $it['id'])) ?>">
                <span class="rsp-badge"><?= e(Research::SCHEMES[$it['scheme']] ?? $it['scheme']) ?></span>
                <h3><?= e($it['title']) ?></h3>
                <?php if (!empty($it['description'])): ?>
                    <p class="desc"><?= e($it['description']) ?></p>
                <?php endif; ?>
                <div class="meta">
                    <span>👤 <?= e($it['leader']) ?></span>
                    <span>📅 <?= (int)$it['year'] ?></span>
                    <?php if (!empty($it['field'])): ?><span>🏷️ <?= e(Research::FIELDS[$it['field']] ?? $it['field']) ?></span><?php endif; ?>
                    <?php if ((int)$it['funding'] > 0): ?><span>💰 Rp <?= number_format((int)$it['funding'],0,',','.') ?></span><?php endif; ?>
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
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="<?= e(url('public/index.php?page=penelitian&hal=' . $i . ($scheme ? '&scheme=' . $scheme : '') . ($q ? '&q=' . urlencode($q) : ''))) ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>