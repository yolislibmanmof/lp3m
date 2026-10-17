<style>
    .e404 { max-width:560px; margin:60px auto; text-align:center; padding:60px 40px; background:var(--surface); border:1px solid var(--border); border-radius:24px; box-shadow:0 16px 44px rgba(0,0,0,.12); }
    .e404 .big { font-family:var(--font-display); font-size:120px; font-weight:900; line-height:1; background:linear-gradient(135deg,#fde68a,#d9a441); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; margin-bottom:10px; }
    .e404 h1 { font-family:var(--font-display); font-size:26px; font-weight:900; color:var(--ink); margin:0 0 8px; }
    .e404 p { font-size:14px; color:var(--muted); margin:0 0 24px; }
    .e404 code { background:rgba(5,150,105,.1); color:#047857; padding:3px 10px; border-radius:7px; font-size:12px; font-weight:800; }
    .e404 a { display:inline-flex; align-items:center; gap:8px; padding:12px 24px; border-radius:12px; font-size:13px; font-weight:900; color:#03251f; text-decoration:none; background:linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:0 6px 16px rgba(217,164,65,.35); transition:all .25s; }
    .e404 a:hover { transform:translateY(-2px); filter:brightness(1.05); }
</style>

<div class="e404">
    <div class="big">404</div>
    <h1>Halaman Tidak Ditemukan</h1>
    <p>Rute <code><?= e($page ?? '—') ?></code> tidak dikenali oleh sistem.<br>Mungkin URL salah atau modul sudah dipindahkan.</p>
    <a href="<?= e(url('admin/index.php?page=dashboard')) ?>">🏠 Kembali ke Dashboard</a>
</div>