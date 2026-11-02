<?php
// 🛡️ MANDIRI: SVG Icon Helper khusus halaman ini (Mencegah error undefined function)
function renderMarketplaceIcon($name, $size = 24, $color = 'currentColor') {
    $icons = [
        'search' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        'sparkle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 3l1.912 5.813a2 2 0 0 0 1.275 1.275L21 12l-5.813 1.912a2 2 0 0 0-1.275 1.275L12 21l-1.912-5.813a2 2 0 0 0-1.275-1.275L3 12l5.813-1.912a2 2 0 0 0 1.275-1.275L12 3z"></path></svg>',
        'target' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>',
        'users' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'microscope' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M9 3h6v2H9V3zm-3 4h12v2H6V7zm2 4h8v10H8V11z"></path><path d="M10 15h4"></path></svg>',
        'award' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>',
        'trending-up' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>',
        'external-link' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>',
        'arrow-right' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
        'handshake' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'briefcase' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>',
    ];
    return $icons[$name] ?? $icons['sparkle'];
}

// Ekstrak statistik sederhana untuk Hero
$totalResearchers = count($researchers);
$totalInterests = 0;
foreach ($researchers as $r) {
    if (!empty($r['research_interests'])) {
        $totalInterests += count(array_filter(explode(',', $r['research_interests'])));
    }
}
?>

<style>
    @keyframes dmFade { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:none} }
    @keyframes dmShine { 0%,55%{left:-120%} 100%{left:200%} }
    @keyframes dmPulse { 0%,100%{box-shadow:0 0 0 0 rgba(217,164,65,.5)} 50%{box-shadow:0 0 0 10px rgba(217,164,65,0)} }
    @keyframes dmFloat { 0%,100%{transform:translateY(0) rotate(-4deg)} 50%{transform:translateY(-12px) rotate(4deg)} }
    @keyframes iconRotate { 0%,100%{transform:rotate(0) scale(1)} 25%{transform:rotate(-5deg) scale(1.05)} 75%{transform:rotate(5deg) scale(1.05)} }

    .dm-wrap { max-width: 1180px; margin: 0 auto; padding: 0 20px; }

    /* ===== HERO ===== */
    .dm-hero { 
        position: relative; overflow: hidden; padding: 60px 50px; border-radius: 28px; 
        background: linear-gradient(135deg, #043b2c 0%, #065f46 45%, #10b981 100%); 
        color: #fff; box-shadow: 0 26px 60px rgba(3,37,31,.35); margin-bottom: 32px; 
        animation: dmFade .6s both; 
    }
    .dm-hero::before { 
        content: ''; position: absolute; inset: 0; opacity: .25; 
        background-image: repeating-linear-gradient(45deg, transparent, transparent 30px, rgba(253,230,138,.08) 30px, rgba(253,230,138,.08) 31px); 
        pointer-events: none; 
    }
    .dm-hero-bg-icon {
        position: absolute; right: 40px; bottom: -30px; opacity: .08; pointer-events: none;
        animation: dmFloat 7s ease-in-out infinite;
    }
    .dm-hero-bg-icon svg { width: 200px; height: 200px; stroke: #fde68a; stroke-width: 1; }
    
    .dm-hero .tag { 
        display: inline-flex; align-items: center; gap: 10px; padding: 8px 18px; border-radius: 999px; 
        font-size: 11px; font-weight: 900; letter-spacing: .18em; text-transform: uppercase; 
        background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.3); margin-bottom: 18px; 
        position: relative; z-index: 1; backdrop-filter: blur(8px); 
    }
    .dm-hero .tag .dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #fde68a, #d9a441);
        animation: dmPulse 2s infinite; box-shadow: 0 0 10px rgba(217,164,65,0.6);
    }
    .dm-hero h1 { 
        font-family: var(--font-display); font-size: clamp(28px, 4.5vw, 44px); font-weight: 900; 
        letter-spacing: -.02em; margin: 0 0 12px; position: relative; z-index: 1; 
    }
    .dm-hero h1 em { 
        font-style: normal; background: linear-gradient(135deg, #fde68a, #f2c063); 
        -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 2px 8px rgba(217,164,65,0.4));
    }
    .dm-hero p { 
        font-size: 15px; line-height: 1.7; opacity: .92; max-width: 640px; 
        margin: 0 0 28px; position: relative; z-index: 1; 
    }

    /* ===== SEARCH BAR ===== */
    .dm-search-wrap { position: relative; max-width: 560px; z-index: 2; margin-bottom: 28px; }
    .dm-search { 
        width: 100%; padding: 18px 24px 18px 58px; border-radius: 18px; 
        border: 2px solid rgba(255,255,255,.3); background: rgba(255,255,255,.15); 
        backdrop-filter: blur(12px); color: #fff; font-size: 15px; font-weight: 600; 
        transition: all .3s; outline: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .dm-search::placeholder { color: rgba(255,255,255,.7); }
    .dm-search:focus { 
        border-color: #fde68a; background: rgba(255,255,255,.25); 
        box-shadow: 0 0 0 6px rgba(253,230,138,.25), 0 15px 40px rgba(0,0,0,0.2); 
    }
    .dm-search-ico { 
        position: absolute; left: 22px; top: 50%; transform: translateY(-50%); 
        display: flex; align-items: center; pointer-events: none;
    }
    .dm-search-ico svg { width: 22px; height: 22px; stroke: rgba(255,255,255,0.85); stroke-width: 2.2; }

    /* ===== HERO STATS ===== */
    .dm-stats { display: flex; gap: 14px; flex-wrap: wrap; position: relative; z-index: 1; }
    .dm-stat-box { 
        background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.25); 
        border-radius: 16px; padding: 14px 22px; text-align: center; min-width: 120px; 
        backdrop-filter: blur(8px); transition: all 0.3s;
    }
    .dm-stat-box:hover { background: rgba(255,255,255,.18); transform: translateY(-2px); }
    .dm-stat-box b { 
        display: block; font-family: var(--font-display); font-size: 24px; font-weight: 900; 
        color: #fde68a; line-height: 1.1; filter: drop-shadow(0 2px 4px rgba(217,164,65,0.3));
    }
    .dm-stat-box span { 
        font-size: 10px; letter-spacing: .12em; text-transform: uppercase; 
        opacity: .9; display: block; margin-top: 4px; font-weight: 700;
    }

    /* ===== GRID CARDS ===== */
    .dm-grid { 
        display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); 
        gap: 24px; margin-bottom: 40px; 
    }
    .dm-card { 
        position: relative; overflow: hidden; display: flex; flex-direction: column; gap: 16px; 
        padding: 28px; border-radius: 24px; background: var(--surface); border: 1px solid var(--border); 
        box-shadow: 0 8px 24px rgba(3,37,31,.06); transition: all .4s cubic-bezier(.16,1,.3,1); 
        opacity: 0; transform: translateY(20px);
    }
    .dm-card.in { opacity: 1; transform: none; }
    .dm-card::before { 
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 5px; 
        background: linear-gradient(90deg, #065f46, #10b981, #f2c063); opacity: .85; 
    }
    .dm-card::after { 
        content: ''; position: absolute; top: 0; left: -120%; width: 60%; height: 100%; 
        background: linear-gradient(105deg, transparent, rgba(255,255,255,.6), transparent); 
        transform: skewX(-20deg); pointer-events: none; 
    }
    .dm-card:hover { 
        transform: translateY(-8px); border-color: rgba(5,150,105,.4); 
        box-shadow: 0 20px 45px rgba(5,150,105,.18); 
    }
    .dm-card:hover::after { animation: dmShine 1s ease-out; }
    .dm-card:hover .dm-av { transform: scale(1.08) rotate(-4deg); }

    /* Badge Open to Collaborate */
    .dm-badge-collab {
        position: absolute; top: 18px; right: 18px; display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 12px; border-radius: 999px; background: linear-gradient(145deg, #fde68a, #d9a441);
        color: #03251f; font-size: 9px; font-weight: 900; letter-spacing: .08em; text-transform: uppercase;
        box-shadow: 0 4px 12px rgba(217,164,65,.35); z-index: 2;
    }
    .dm-badge-collab svg { width: 12px; height: 12px; stroke: #03251f; stroke-width: 2.5; }

    .dm-top { display: flex; gap: 18px; align-items: center; }
    .dm-av { 
        position: relative; width: 72px; height: 72px; border-radius: 50%; flex-shrink: 0; 
        display: flex; align-items: center; justify-content: center; font-family: var(--font-display); 
        font-size: 24px; font-weight: 900; color: #03251f; 
        background: radial-gradient(circle at 30% 25%, #fff7c2, #fde68a 20%, #f2c063 55%, #d9a441); 
        box-shadow: inset 0 2px 4px rgba(255,255,255,.65), inset 0 -3px 5px rgba(0,0,0,.2), 0 8px 20px rgba(217,164,65,.4); 
        transition: transform .4s cubic-bezier(.16,1,.3,1); overflow: hidden; 
    }
    .dm-av img { width: 100%; height: 100%; object-fit: cover; }
    
    .dm-name { 
        font-family: var(--font-display); font-size: 18px; font-weight: 900; 
        color: var(--ink); line-height: 1.3; margin: 0 0 6px; 
    }
    .dm-inst { 
        font-size: 12px; color: var(--muted); font-weight: 600; 
        display: flex; align-items: center; gap: 6px;
    }
    .dm-inst svg { width: 14px; height: 14px; stroke: currentColor; stroke-width: 2; opacity: 0.7; }

    .dm-bio { 
        font-size: 13px; line-height: 1.65; color: var(--text); margin: 0; 
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; 
    }

    /* Interest Chips */
    .dm-interests { margin-top: 4px; }
    .dm-label { 
        font-size: 10px; font-weight: 900; letter-spacing: .1em; text-transform: uppercase; 
        color: var(--muted); margin-bottom: 8px; display: block; 
    }
    .dm-chips { display: flex; flex-wrap: wrap; gap: 6px; }
    .dm-chip { 
        padding: 5px 12px; border-radius: 8px; font-size: 11.5px; font-weight: 700; 
        background: rgba(5,150,105,.08); color: #047857; border: 1px solid rgba(5,150,105,.15);
        transition: all 0.2s;
    }
    .dm-chip:hover { background: rgba(5,150,105,.15); transform: translateY(-1px); }

    /* Action Links */
    .dm-links { 
        margin-top: auto; padding-top: 16px; border-top: 1px dashed var(--border); 
        display: flex; gap: 8px; flex-wrap: wrap; align-items: center; 
    }
    .dm-link { 
        display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 10px; 
        font-size: 12px; font-weight: 800; text-decoration: none; transition: all .25s;
        border: 1px solid transparent;
    }
    .dm-link svg { width: 14px; height: 14px; stroke: currentColor; stroke-width: 2.2; transition: all 0.3s; }
    .dm-link:hover { transform: translateY(-2px); filter: brightness(1.1); }
    .dm-link:hover svg { animation: iconRotate 0.5s ease; }
    
    .dm-link.sinta { background: rgba(16,185,129,.1); color: #047857; border-color: rgba(16,185,129,.2); }
    .dm-link.scholar { background: rgba(59,130,246,.1); color: #1d4ed8; border-color: rgba(59,130,246,.2); }
    .dm-link.orcid { background: rgba(217,164,65,.12); color: #92400e; border-color: rgba(217,164,65,.25); }
    
    .dm-link.primary { 
        margin-left: auto; background: linear-gradient(145deg, #fde68a, #d9a441); color: #03251f; 
        box-shadow: 0 4px 12px rgba(217,164,65,.3); 
    }
    .dm-link.primary:hover { box-shadow: 0 6px 16px rgba(217,164,65,.45); }

    /* ===== EMPTY STATE ===== */
    .dm-empty { 
        text-align: center; padding: 80px 24px; border-radius: 24px; background: var(--surface); 
        border: 2px dashed var(--border); color: var(--muted); animation: dmFade .6s both; 
    }
    .dm-empty-icon { 
        width: 90px; height: 90px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; 
        border-radius: 50%; background: linear-gradient(145deg, #e9f7ec, #d5ecdd); border: 2px dashed var(--border); 
    }
    .dm-empty-icon svg { width: 44px; height: 44px; stroke: var(--muted); stroke-width: 1.5; opacity: 0.6; }
    .dm-empty h3 { margin: 0 0 8px; color: var(--ink); font-size: 20px; font-family: var(--font-display); }
    .dm-empty p { margin: 0; font-size: 14px; max-width: 400px; margin: 0 auto; }

    /* ===== RESPONSIVE ===== */
    @media(max-width: 768px) { 
        .dm-hero { padding: 40px 28px; } 
        .dm-hero-bg-icon { display: none; }
        .dm-stats { gap: 10px; }
        .dm-stat-box { min-width: 90px; padding: 12px 14px; }
        .dm-stat-box b { font-size: 20px; }
        .dm-grid { grid-template-columns: 1fr; }
        .dm-link.primary { margin-left: 0; width: 100%; justify-content: center; }
    }
</style>

<div class="dm-wrap">

    <!-- ===== HERO SECTION ===== -->
    <div class="dm-hero">
        <div class="dm-hero-bg-icon">
            <?= renderMarketplaceIcon('handshake', 200, '#fde68a') ?>
        </div>

        <span class="tag">
            <span class="dot"></span>
            <?= renderMarketplaceIcon('sparkle', 14, '#ffffff') ?>
            <span>Researcher Marketplace</span>
        </span>
        <h1>Temukan Rekan <em>Kolaborasi</em> Penelitian</h1>
        <p>Jelajahi database pakar dan dosen berdasarkan bidang keahlian, minat riset, dan rekam jejak akademik untuk membangun tim proposal hibah yang solid dan lintas disiplin.</p>

        <form class="dm-search-wrap" method="get" action="<?= e(url('public/index.php')) ?>" id="dmSearchForm">
            <input type="hidden" name="page" value="dosen-marketplace">
            <span class="dm-search-ico"><?= renderMarketplaceIcon('search', 22, 'rgba(255,255,255,0.85)') ?></span>
            <input type="text" name="q" id="dmSearchInput" class="dm-search" value="<?= e($q) ?>" placeholder="Cari bidang keahlian... (Cth: Smart Farming, Machine Learning, AIK)">
        </form>

        <div class="dm-stats">
            <div class="dm-stat-box">
                <b><?= $totalResearchers ?></b>
                <span>Peneliti Aktif</span>
            </div>
            <div class="dm-stat-box">
                <b><?= $totalInterests ?></b>
                <span>Minat Riset</span>
            </div>
            <div class="dm-stat-box">
                <b>100%</b>
                <span>Open Collab</span>
            </div>
        </div>
    </div>

    <!-- ===== RESULTS GRID ===== -->
    <?php if (empty($researchers)): ?>
        <div class="dm-empty">
            <div class="dm-empty-icon">
                <?= renderMarketplaceIcon('users', 44, 'currentColor') ?>
            </div>
            <h3>Tidak Ada Peneliti Ditemukan</h3>
            <p>Coba gunakan kata kunci yang lebih umum, atau hubungi admin LP3M untuk memperbarui profil riset dosen.</p>
        </div>
    <?php else: ?>
        <div class="dm-grid" id="dmGrid">
            <?php foreach ($researchers as $i => $r): 
                $init = strtoupper(substr(trim($r['name'] ?? 'U'), 0, 1));
                $interests = !empty($r['research_interests']) ? array_filter(array_map('trim', explode(',', $r['research_interests']))) : [];
            ?>
            <div class="dm-card" style="animation-delay: <?= min($i * 0.05, 0.5) ?>s">
                
                <span class="dm-badge-collab">
                    <?= renderMarketplaceIcon('handshake', 12, 'currentColor') ?>
                    <span>Open to Collab</span>
                </span>

                <div class="dm-top">
                    <div class="dm-av">
                        <?php if (!empty($r['photo'])): ?>
                            <img src="<?= e(upload_url($r['photo'])) ?>" alt="<?= e($r['name']) ?>">
                        <?php else: ?>
                            <?= e($init) ?>
                        <?php endif; ?>
                    </div>
                    <div style="min-width: 0; flex: 1;">
                        <h3 class="dm-name"><?= e($r['name']) ?></h3>
                        <div class="dm-inst">
                            <?= renderMarketplaceIcon('briefcase', 14, 'currentColor') ?>
                            <span><?= e($r['institution'] ?? 'LP3M UNIMOF') ?></span>
                        </div>
                    </div>
                </div>

                <?php if (!empty($r['bio'])): ?>
                    <p class="dm-bio"><?= e($r['bio']) ?></p>
                <?php endif; ?>

                <?php if (!empty($interests)): ?>
                <div class="dm-interests">
                    <span class="dm-label">Fokus & Minat Riset:</span>
                    <div class="dm-chips">
                        <?php foreach (array_slice($interests, 0, 5) as $interest): ?>
                            <span class="dm-chip"><?= e($interest) ?></span>
                        <?php endforeach; ?>
                        <?php if (count($interests) > 5): ?>
                            <span class="dm-chip" style="background: rgba(0,0,0,0.04); color: var(--muted); border-color: var(--border);">+<?= count($interests) - 5 ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="dm-links">
                    <?php if (!empty($r['sinta_url'])): ?>
                        <a href="<?= e($r['sinta_url']) ?>" target="_blank" rel="noopener" class="dm-link sinta" title="Profil SINTA">
                            <?= renderMarketplaceIcon('trending-up', 14, 'currentColor') ?> SINTA
                        </a>
                    <?php endif; ?>
                    
                    <?php if (!empty($r['scholar_url'])): ?>
                        <a href="<?= e($r['scholar_url']) ?>" target="_blank" rel="noopener" class="dm-link scholar" title="Google Scholar">
                            <?= renderMarketplaceIcon('award', 14, 'currentColor') ?> Scholar
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($r['orcid'])): ?>
                        <a href="https://orcid.org/<?= e($r['orcid']) ?>" target="_blank" rel="noopener" class="dm-link orcid" title="ORCID ID">
                            <?= renderMarketplaceIcon('users', 14, 'currentColor') ?> ORCID
                        </a>
                    <?php endif; ?>

                    <a href="<?= e(url('public/index.php?page=dosen&id=' . $r['id'])) ?>" class="dm-link primary">
                        <span>Lihat Profil</span>
                        <?= renderMarketplaceIcon('arrow-right', 14, 'currentColor') ?>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<script>
(function(){
    // 1. Scroll Reveal Animation
    var cards = document.querySelectorAll('.dm-card');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(entries) {
            entries.forEach(function(en) {
                if (en.isIntersecting) { 
                    en.target.classList.add('in'); 
                    io.unobserve(en.target); 
                }
            });
        }, { threshold: 0.1 });
        cards.forEach(function(c) { io.observe(c); });
    } else {
        cards.forEach(function(c) { c.classList.add('in'); });
    }

    // 2. Live Client-Side Search Filter (UX Tingkat Dewa)
    var searchInput = document.getElementById('dmSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            var val = this.value.toLowerCase();
            cards.forEach(function(card) {
                var text = card.textContent.toLowerCase();
                card.style.display = text.includes(val) ? '' : 'none';
            });
        });
    }
})();
</script>