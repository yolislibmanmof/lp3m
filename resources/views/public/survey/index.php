<style>
    @keyframes psvFade { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:none} }
    .psv-hero { position:relative; overflow:hidden; border-radius:28px; padding:56px 44px; margin-bottom:30px; color:#fff; background:linear-gradient(135deg,#4c1d95 0%,#6d28d9 55%,#7c3aed 100%); box-shadow:0 26px 60px rgba(76,29,149,.35); animation:psvFade .6s both; }
    .psv-hero::after { content:''; position:absolute; top:-40%; right:-8%; width:420px; height:420px; border-radius:50%; background:radial-gradient(circle,rgba(253,230,138,.25),transparent 70%); pointer-events:none; }
    .psv-hero .tag { display:inline-flex; padding:5px 14px; border-radius:999px; font-size:10.5px; font-weight:900; letter-spacing:.18em; text-transform:uppercase; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.3); margin-bottom:14px; }
    .psv-hero h1 { font-family:var(--font-display); font-size:clamp(28px,4vw,44px); font-weight:900; margin:0 0 12px; letter-spacing:-.02em; }
    .psv-hero p { font-size:15px; line-height:1.7; opacity:.92; max-width:620px; margin:0; }
    .psv-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:20px; }
    .psv-card { position:relative; overflow:hidden; display:flex; flex-direction:column; gap:14px; padding:26px; border-radius:22px; background:var(--surface); border:1px solid var(--border); box-shadow:0 10px 26px rgba(3,37,31,.07); transition:all .3s; animation:psvFade .5s both; }
    .psv-card:hover { transform:translateY(-6px); border-color:rgba(124,58,237,.4); box-shadow:0 20px 40px rgba(124,58,237,.16); }
    .psv-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:linear-gradient(90deg,#8b5cf6,#c4b5fd); }
    .psv-card h3 { margin:0; font-family:var(--font-display); font-size:18px; font-weight:900; color:var(--ink); line-height:1.35; }
    .psv-card p { margin:0; font-size:13px; color:var(--muted); line-height:1.6; flex:1; }
    .psv-meta { display:flex; gap:8px; flex-wrap:wrap; font-size:11px; color:var(--muted); }
    .psv-meta span { padding:3px 10px; border-radius:999px; background:rgba(124,58,237,.08); border:1px solid rgba(124,58,237,.25); color:#6d28d9; font-weight:800; }
    .psv-cta { display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:13px 22px; border-radius:13px; font-size:14px; font-weight:800; text-decoration:none; color:#fff; background:linear-gradient(145deg,#8b5cf6,#6d28d9); box-shadow:0 6px 16px rgba(124,58,237,.35); transition:all .25s; }
    .psv-cta:hover { transform:translateY(-2px); filter:brightness(1.08); }
    .psv-empty { text-align:center; padding:70px 24px; border-radius:22px; background:var(--surface); border:2px dashed var(--border); color:var(--muted); }
</style>

<section class="psv-hero">
    <span class="tag">📝 Suara Anda Berarti</span>
    <h1>Survei Kepuasan Layanan</h1>
    <p>Bantu kami meningkatkan mutu layanan penelitian, pengabdian, dan akademik LP3M. Isi survei berikut — hanya butuh beberapa menit dan dapat dilakukan anonim.</p>
</section>

<?php if (empty($surveys)): ?>
<div class="psv-empty">
    <div style="font-size:52px;margin-bottom:12px;">📭</div>
    <h3 style="margin:0 0 6px;color:var(--ink);">Belum Ada Survei Terbuka</h3>
    <p style="margin:0;">Saat ini tidak ada survei yang sedang berlangsung. Silakan kunjungi kembali beberapa waktu lagi.</p>
</div>
<?php else: ?>
<div class="psv-grid">
    <?php foreach ($surveys as $i => $sv): ?>
    <div class="psv-card" style="animation-delay:<?= min($i * 0.06, 0.4) ?>s">
        <h3><?= e($sv['title']) ?></h3>
        <?php if (!empty($sv['description'])): ?><p><?= e($sv['description']) ?></p><?php endif; ?>
        <div class="psv-meta">
            <span>🎯 <?= e(Survey::TARGETS[$sv['target_audience']] ?? 'Umum') ?></span>
            <span>❓ <?= (int) $sv['questions'] ?> pertanyaan</span>
            <span>👥 <?= number_format($sv['responses']) ?> responden</span>
            <?php if (!empty($sv['end_date'])): ?><span>⏳ s/d <?= e(date('d M Y', strtotime($sv['end_date']))) ?></span><?php endif; ?>
        </div>
        <a class="psv-cta" href="<?= e(url('public/index.php?page=survei-isi&id=' . $sv['id'])) ?>">✍️ Isi Survei Sekarang →</a>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>