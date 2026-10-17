<article class="news-card" style="position:relative; overflow:hidden; transition:all .35s cubic-bezier(.16,1,.3,1);">
    <?php if (!empty($item['thumbnail'])): ?>
        <div style="position:relative; overflow:hidden;">
            <img src="<?= e(upload_url($item['thumbnail'])) ?>" alt="<?= e($item['title']) ?>" loading="lazy"
                 style="transition:transform .6s cubic-bezier(.16,1,.3,1);"
                 onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
            <?php if (!empty($item['is_featured'])): ?>
                <span style="position:absolute; top:12px; left:12px; z-index:2; display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:999px; font-size:10px; font-weight:900; letter-spacing:.05em; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:inset 0 1px 2px rgba(255,255,255,.7),inset 0 -2px 3px rgba(0,0,0,.2),0 4px 10px rgba(217,164,65,.4);">⭐ Unggulan</span>
            <?php endif; ?>
            <span style="position:absolute; bottom:12px; right:12px; z-index:2; display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:999px; font-size:10px; font-weight:800; color:#fff; background:rgba(3,37,31,.7); backdrop-filter:blur(6px); border:1px solid rgba(255,255,255,.15);">👁️ <?= number_format((int) ($item['views'] ?? 0)) ?></span>
        </div>
    <?php else: ?>
        <div class="news-thumb-placeholder" style="position:relative;">
            <?php if (!empty($item['is_featured'])): ?>
                <span style="position:absolute; top:12px; left:12px; z-index:2; display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:999px; font-size:10px; font-weight:900; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:0 4px 10px rgba(217,164,65,.4);">⭐ Unggulan</span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="news-card-body">
        <div class="news-meta">
            <span class="badge"><?= e(ucfirst($item['category'])) ?></span>
            <span><?= e(date('d M Y', strtotime($item['published_at'] ?? $item['created_at']))) ?></span>
            <span style="margin-left:auto; font-size:11px; color:var(--muted);">⏱️ <?= max(1, (int) round(str_word_count(strip_tags($item['content'])) / 200)) ?> mnt</span>
        </div>

        <h3>
            <a href="<?= e(url('public/index.php?page=berita-detail&slug=' . urlencode($item['slug']))) ?>">
                <?= e($item['title']) ?>
            </a>
        </h3>

        <p><?= e(excerpt($item['content'])) ?></p>
    </div>
</article>