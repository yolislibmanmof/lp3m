<?php
// SVG Icon Helper inline untuk memastikan konsistensi di partial ini
function renderNewsCardIcon($name, $size = 12, $color = 'currentColor') {
    $icons = [
        'star' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.5" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>',
        'eye' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.5" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>',
        'clock' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
        'calendar' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
        'folder' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>',
        'image' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>',
        'arrow-right' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
    ];
    return $icons[$name] ?? $icons['star'];
}
?>

<article class="news-card" style="position:relative; overflow:hidden; display:flex; flex-direction:column; height:100%; background:var(--white); border:1px solid var(--border); border-radius:22px; box-shadow:0 4px 14px rgba(0,0,0,0.04); transition:all .4s cubic-bezier(.16,1,.3,1);">
    
    <!-- ===== THUMBNAIL SECTION ===== -->
    <div style="position:relative; overflow:hidden; aspect-ratio: 16/9; background: linear-gradient(135deg, #043b2c, #065f46);">
        <?php if (!empty($item['thumbnail'])): ?>
            <img src="<?= e(upload_url($item['thumbnail'])) ?>" alt="<?= e($item['title']) ?>" loading="lazy"
                 style="width:100%; height:100%; object-fit:cover; transition:transform .7s cubic-bezier(.16,1,.3,1);"
                 onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
        <?php else: ?>
            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background: linear-gradient(135deg, #043b2c, #065f46);">
                <?= renderNewsCardIcon('image', 48, 'rgba(255,255,255,0.2)') ?>
            </div>
        <?php endif; ?>

        <!-- Badges Overlay (Glassmorphism) -->
        <div style="position:absolute; top:14px; left:14px; z-index:2; display:flex; gap:8px; flex-wrap:wrap;">
            <?php if (!empty($item['is_featured'])): ?>
                <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:999px; font-size:10.5px; font-weight:900; letter-spacing:.05em; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:inset 0 1px 2px rgba(255,255,255,.7),inset 0 -2px 3px rgba(0,0,0,.2),0 4px 12px rgba(217,164,65,.4);">
                    <?= renderNewsCardIcon('star', 12, '#03251f') ?>
                    <span>Unggulan</span>
                </span>
            <?php endif; ?>
            <span style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:999px; font-size:10.5px; font-weight:800; color:#fff; background:rgba(3,37,31,.75); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,.15); box-shadow:0 4px 10px rgba(0,0,0,0.2);">
                <?= renderNewsCardIcon('eye', 12, '#ffffff') ?>
                <span><?= number_format((int) ($item['views'] ?? 0)) ?></span>
            </span>
        </div>
    </div>

    <!-- ===== CONTENT SECTION ===== -->
    <div class="news-card-body" style="flex:1; display:flex; flex-direction:column; padding:22px; gap:12px;">
        
        <!-- Meta Row -->
        <div class="news-meta" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; font-size:11.5px; font-weight:700; color:var(--muted);">
            <span class="badge" style="display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:999px; font-size:10.5px; font-weight:800; background:linear-gradient(145deg,rgba(52,211,153,.15),rgba(5,150,105,.1)); border:1px solid rgba(5,150,105,.3); color:#047857;">
                <?= renderNewsCardIcon('folder', 12, 'currentColor') ?>
                <?= e(ucfirst($item['category'])) ?>
            </span>
            <span style="display:inline-flex; align-items:center; gap:4px;">
                <?= renderNewsCardIcon('calendar', 12, 'currentColor') ?>
                <?= e(date('d M Y', strtotime($item['published_at'] ?? $item['created_at']))) ?>
            </span>
            <span style="margin-left:auto; display:inline-flex; align-items:center; gap:4px; font-size:11px; color:var(--muted);">
                <?= renderNewsCardIcon('clock', 12, 'currentColor') ?>
                <?= max(1, (int) round(str_word_count(strip_tags($item['content'])) / 200)) ?> mnt
            </span>
        </div>

        <!-- Title -->
        <h3 style="margin:0; font-size:17px; font-weight:800; color:var(--ink); letter-spacing:-0.01em; line-height:1.4;">
            <a href="<?= e(url('public/index.php?page=berita-detail&slug=' . urlencode($item['slug']))) ?>" style="color:inherit; text-decoration:none; transition:color .25s ease; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                <?= e($item['title']) ?>
            </a>
        </h3>

        <!-- Excerpt -->
        <p style="margin:0; font-size:13.5px; color:var(--muted); line-height:1.65; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; flex:1;">
            <?= e(excerpt($item['content'], 120)) ?>
        </p>

        <!-- Read More Footer -->
        <div style="margin-top:auto; padding-top:14px; border-top:1px dashed var(--border);">
            <a href="<?= e(url('public/index.php?page=berita-detail&slug=' . urlencode($item['slug']))) ?>" style="display:inline-flex; align-items:center; gap:6px; font-size:12.5px; font-weight:800; color:var(--primary); text-decoration:none; transition:all .25s ease;">
                <span>Baca Selengkapnya</span>
                <?= renderNewsCardIcon('arrow-right', 14, 'currentColor') ?>
            </a>
        </div>
    </div>
</article>

<style>
    /* ===== CARD HOVER EFFECTS ===== */
    .news-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(3, 37, 31, 0.15), 0 0 0 1px rgba(5, 150, 105, 0.15);
        border-color: rgba(5, 150, 105, 0.3);
    }
    .news-card:hover h3 a {
        color: var(--primary);
    }
    .news-card:hover .news-card-body a[style*="Baca Selengkapnya"] svg {
        transform: translateX(4px);
    }
    
    /* Fallback untuk news-thumb-placeholder jika digunakan di tempat lain */
    .news-thumb-placeholder {
        width: 100%;
        aspect-ratio: 16/9;
        background: linear-gradient(135deg, #043b2c, #065f46);
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>