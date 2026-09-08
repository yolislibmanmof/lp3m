<style>
    @keyframes pstPop { 0%{transform:scale(.4);opacity:0} 60%{transform:scale(1.08)} 100%{transform:scale(1);opacity:1} }
    @keyframes pstFade { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:none} }
    .pst-wrap { max-width:640px; margin:40px auto; text-align:center; animation:pstFade .6s both; }
    .pst-card { position:relative; overflow:hidden; background:var(--surface); border:1px solid var(--border); border-radius:26px; padding:48px 40px; box-shadow:0 20px 50px rgba(3,37,31,.1); }
    .pst-card::before { content:''; position:absolute; top:0; left:0; right:0; height:5px; background:linear-gradient(90deg,#8b5cf6,#10b981,#f2c063); }
    .pst-check { width:96px; height:96px; margin:0 auto 22px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:44px; color:#fff; background:linear-gradient(145deg,#34d399,#059669); box-shadow:0 12px 30px rgba(16,185,129,.4), inset 0 2px 4px rgba(255,255,255,.5); animation:pstPop .7s cubic-bezier(.16,1,.3,1) both; }
    .pst-card h1 { font-family:var(--font-display); font-size:30px; font-weight:900; color:var(--ink); margin:0 0 10px; letter-spacing:-.02em; }
    .pst-card p { font-size:14.5px; color:var(--muted); line-height:1.7; margin:0 0 22px; }
    .pst-token { display:inline-flex; align-items:center; gap:10px; padding:12px 20px; border-radius:14px; background:rgba(124,58,237,.08); border:1px dashed rgba(124,58,237,.4); font-family:'Courier New',monospace; font-size:15px; font-weight:800; color:#6d28d9; letter-spacing:.06em; margin-bottom:26px; cursor:pointer; }
    .pst-token:hover { background:rgba(124,58,237,.14); }
    .pst-acts { display:flex; gap:12px; justify-content:center; flex-wrap:wrap; }
    .pst-btn { padding:13px 26px; border-radius:13px; font-size:14px; font-weight:800; text-decoration:none; transition:all .25s; }
    .pst-btn.primary { color:#fff; background:linear-gradient(145deg,#8b5cf6,#6d28d9); box-shadow:0 6px 16px rgba(124,58,237,.35); }
    .pst-btn.ghost { color:var(--muted); border:2px solid var(--border); }
    .pst-btn:hover { transform:translateY(-2px); }
</style>

<div class="pst-wrap">
    <div class="pst-card">
        <div class="pst-check">✓</div>
        <h1>Terima Kasih!</h1>
        <p>Jawaban Anda telah kami terima dan akan menjadi bahan berharga untuk peningkatan mutu layanan LP3M. Simpan kode partisipasi berikut sebagai bukti:</p>
        <div class="pst-token" id="pst-token" title="Klik untuk menyalin">🎫 <?= e($token) ?></div>
        <div class="pst-acts">
            <a class="pst-btn primary" href="<?= e(url('public/index.php?page=survei')) ?>">📝 Survei Lain</a>
            <a class="pst-btn ghost" href="<?= e(url('public/index.php?page=home')) ?>">🏠 Kembali ke Beranda</a>
        </div>
    </div>
</div>

<script>
(function(){
    var t = document.getElementById('pst-token');
    if (t) t.addEventListener('click', function(){
        var txt = t.textContent.replace('🎫', '').trim();
        if (navigator.clipboard) navigator.clipboard.writeText(txt);
        var old = t.textContent;
        t.textContent = '✅ Tersalin!';
        setTimeout(function(){ t.textContent = old; }, 1500);
    });
})();
</script>