<?php
$cardWords = str_word_count(strip_tags($item['content'] ?? ''));
$cardReadMin = max(1, (int) round($cardWords / 200));
$pubDate = $item['published_at'] ?? $item['created_at'];
$cardDaysAgo = (int) ((time() - strtotime($pubDate)) / 86400);

$cardCategoryEmojis = [
    'umum' => '📰', 'penelitian' => '🔬', 'pengabdian' => '🤝',
    'publikasi' => '📚', 'haki' => '🛡️', 'aik' => '🕌',
    'pengumuman' => '📢', 'agenda' => '📅',
];
$cardCatEmoji = $cardCategoryEmojis[$item['category']] ?? '📰';

$cardAuthorStmt = Database::pdo()->prepare('SELECT name FROM users WHERE id = ? LIMIT 1');
$cardAuthorStmt->execute([$item['user_id']]);
$cardAuthorRow = $cardAuthorStmt->fetch();
$cardAuthorName = $cardAuthorRow['name'] ?? 'Redaksi LP3M';
$cardAuthorInitial = strtoupper(substr($cardAuthorName, 0, 1));

if ($cardDaysAgo === 0) {
    $cardTimeLabel = 'Hari ini';
    $cardIsNew = true;
} elseif ($cardDaysAgo === 1) {
    $cardTimeLabel = 'Kemarin';
    $cardIsNew = true;
} elseif ($cardDaysAgo < 7) {
    $cardTimeLabel = $cardDaysAgo . ' hari lalu';
    $cardIsNew = true;
} elseif ($cardDaysAgo < 30) {
    $cardTimeLabel = (int) floor($cardDaysAgo / 7) . ' mgg lalu';
    $cardIsNew = false;
} else {
    $cardTimeLabel = date('d M Y', strtotime($pubDate));
    $cardIsNew = false;
}
?>

<style>
    @keyframes cardShine {
        0%   { transform: translateX(-100%) skewX(-20deg); }
        100% { transform: translateX(300%) skewX(-20deg); }
    }
    @keyframes newPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(217,164,65,0.7), inset 0 1px 2px rgba(255,255,255,0.7); }
        50%      { box-shadow: 0 0 0 8px rgba(217,164,65,0), inset 0 1px 2px rgba(255,255,255,0.9); }
    }

    .news-card-3d {
        position: relative;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 22px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 4px 14px rgba(0,0,0,0.05);
    }
    .news-card-3d:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 48px rgba(5,150,105,0.18), 0 8px 20px rgba(0,0,0,0.08);
        border-color: rgba(5,150,105,0.35);
    }
    .news-card-3d:hover .card-thumb-3d img {
        transform: scale(1.1);
    }
    .news-card-3d:hover .card-cta-arrow-3d {
        transform: translateX(4px);
        background: linear-gradient(145deg, #fde68a, #d9a441);
        color: #03251f;
    }

    /* Thumbnail 3D */
    .card-thumb-3d {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: linear-gradient(135deg, #043b2c, #065f46 55%, #059669);
    }
    .card-thumb-3d img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.8s cubic-bezier(0.16,1,0.3,1);
    }
    .card-thumb-3d::after {
        content: '';
        position: absolute;
        inset: auto 0 0 0;
        height: 60%;
        background: linear-gradient(180deg, transparent, rgba(3,37,31,0.75));
        pointer-events: none;
    }

    /* Placeholder 3D */
    .thumb-ph-3d {
        height: 200px;
        background: radial-gradient(circle at 30% 30%, rgba(253,230,138,0.2), transparent 50%),
                    linear-gradient(135deg, #043b2c 0%, #065f46 55%, #059669 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 68px;
        color: rgba(255,255,255,0.18);
        position: relative;
    }

    /* 3D Category Orb */
    .cat-orb-3d {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.9), rgba(255,255,255,0.3) 40%, rgba(246,250,247,0.95));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        z-index: 2;
        box-shadow:
            inset 0 2px 3px rgba(255,255,255,0.9),
            inset 0 -2px 3px rgba(3,37,31,0.15),
            0 4px 12px rgba(0,0,0,0.25);
    }
    .cat-orb-3d::before {
        content: '';
        position: absolute;
        top: 5px;
        left: 9px;
        width: 16px;
        height: 7px;
        border-radius: 50%;
        background: rgba(255,255,255,0.85);
        filter: blur(1.5px);
    }

    /* 3D NEW badge */
    .new-badge-3d {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 900;
        letter-spacing: 0.2em;
        color: #03251f;
        background: radial-gradient(circle at 30% 25%, #fde68a, #f2c063 60%, #d9a441);
        z-index: 2;
        animation: newPulse 2.5s ease-in-out infinite;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .new-badge-3d::before {
        content: '';
        position: absolute;
        top: 2px;
        left: 6px;
        width: 30%;
        height: 35%;
        border-radius: 50%;
        background: rgba(255,255,255,0.7);
        filter: blur(1px);
    }

    /* 3D read time pill */
    .read-time-3d {
        position: absolute;
        bottom: 12px;
        right: 12px;
        padding: 4px 11px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(145deg, rgba(0,0,0,0.75), rgba(0,0,0,0.55));
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.15);
        display: inline-flex;
        align-items: center;
        gap: 4px;
        z-index: 2;
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.15);
    }

    /* 3D Category chip in body */
    .cat-chip-3d {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 11px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        color: var(--primary-dark);
        background: linear-gradient(145deg, rgba(5,150,105,0.14), rgba(217,164,65,0.12));
        border: 1px solid rgba(5,150,105,0.28);
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.3);
    }

    /* 3D author sphere */
    .author-sphere-3d {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 25%, #fde68a, #d9a441 60%, #a9761b);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #03251f;
        font-weight: 900;
        font-size: 14px;
        font-family: var(--font-display);
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
        box-shadow:
            inset 0 2px 2px rgba(255,255,255,0.6),
            inset 0 -2px 3px rgba(0,0,0,0.2),
            0 3px 8px rgba(217,164,65,0.35);
    }
    .author-sphere-3d::before {
        content: '';
        position: absolute;
        top: 3px;
        left: 7px;
        width: 11px;
        height: 5px;
        border-radius: 50%;
        background: rgba(255,255,255,0.65);
        filter: blur(1px);
    }

    /* 3D CTA */
    .card-cta-3d {
        margin-top: auto;
        padding-top: 14px;
        border-top: 1px dashed var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13px;
        font-weight: 700;
        color: var(--primary-dark);
        gap: 8px;
    }
    .card-cta-arrow-3d {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(145deg, #059669, #065f46);
        color: white;
        font-size: 13px;
        font-weight: 900;
        transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
        box-shadow:
            inset 0 1px 1px rgba(255,255,255,0.25),
            inset 0 -2px 2px rgba(0,0,0,0.25),
            0 3px 8px rgba(5,150,105,0.35);
    }
</style>

<article class="news-card-3d reveal">

    <div class="card-thumb-3d">
        <?php if (!empty($item['thumbnail'])): ?>
            <img src="<?= e(upload_url($item['thumbnail'])) ?>" alt="<?= e($item['title']) ?>" loading="lazy">
        <?php else: ?>
            <div class="thumb-ph-3d"><?= $cardCatEmoji ?></div>
        <?php endif; ?>

        <div class="cat-orb-3d"><?= $cardCatEmoji ?></div>

        <div class="read-time-3d">⏱️ <?= $cardReadMin ?> mnt</div>

        <?php if ($cardIsNew): ?>
            <div class="new-badge-3d">🔥 BARU</div>
        <?php endif; ?>
    </div>

    <div style="padding: 20px; display: flex; flex-direction: column; gap: 12px; flex: 1;">

        <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; flex-wrap: wrap;">
            <span class="cat-chip-3d"><?= $cardCatEmoji ?> <?= e(ucfirst($item['category'])) ?></span>
            <span style="font-size: 10.5px; color: var(--muted); font-weight: 700; letter-spacing: 0.02em;">
                📅 <?= e($cardTimeLabel) ?>
            </span>
        </div>

        <h3 style="font-size: 17px; line-height: 1.4; font-weight: 800; color: var(--ink); letter-spacing: -0.01em; margin: 0;">
            <a href="<?= e(url('public/index.php?page=berita-detail&slug=' . urlencode($item['slug']))) ?>" style="display: block; color: inherit;">
                <?= e($item['title']) ?>
            </a>
        </h3>

        <p style="font-size: 13.5px; color: var(--muted); line-height: 1.65; margin: 0;">
            <?= e(excerpt($item['content'], 110)) ?>
        </p>

        <div style="display: flex; align-items: center; gap: 10px; margin-top: 2px;">
            <div class="author-sphere-3d"><?= $cardAuthorInitial ?></div>
            <div style="flex: 1; min-width: 0;">
                <p style="font-size: 12px; font-weight: 800; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 0;">
                    <?= e($cardAuthorName) ?>
                </p>
                <p style="font-size: 10px; color: var(--muted); letter-spacing: 0.05em; margin: 2px 0 0;">
                    📄 <?= number_format($cardWords) ?> kata
                </p>
            </div>
        </div>

        <a class="card-cta-3d" href="<?= e(url('public/index.php?page=berita-detail&slug=' . urlencode($item['slug']))) ?>">
            <span>Baca Selengkapnya</span>
            <span class="card-cta-arrow-3d">→</span>
        </a>
    </div>
</article>