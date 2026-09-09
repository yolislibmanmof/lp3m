<style>
    @keyframes cfFade { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
    .cf-head { position:relative; overflow:hidden; display:flex; align-items:center; gap:16px; margin-bottom:22px; padding:26px 30px; border-radius:22px; background:linear-gradient(135deg,#4c1d95,#7c3aed 55%,#a78bfa); color:#fff; box-shadow:0 16px 40px rgba(0,0,0,.3); animation:cfFade .5s both; }
    .cf-head-ico { width:58px; height:58px; border-radius:17px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:26px; background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.6),transparent 45%),linear-gradient(145deg,#fde68a,#f2c063 55%,#d9a441); box-shadow:inset 0 2px 3px rgba(255,255,255,.65), 0 6px 16px rgba(217,164,65,.4); position:relative; z-index:1; }
    .cf-head h2 { margin:0 0 4px; font-family:var(--font-display); font-size:22px; font-weight:900; position:relative; z-index:1; }
    .cf-head p { margin:0; font-size:12.5px; opacity:.92; position:relative; z-index:1; }
    .cf-back { display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:800; color:#fff; text-decoration:none; padding:9px 16px; border-radius:10px; background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.3); }
    .cf-back:hover { background:rgba(255,255,255,.22); transform:translateX(-3px); }

    .cf-card { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:26px; margin-bottom:18px; animation:cfFade .5s .05s both; }
    .cf-card h3 { display:flex; align-items:center; gap:10px; margin:0 0 18px; font-family:var(--font-display); font-size:15px; font-weight:900; color:#fff; padding-bottom:12px; border-bottom:1px dashed var(--border); }
    .cf-card h3 .emo { width:34px; height:34px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; background:rgba(124,58,237,.14); }
    .cf-info { padding:14px 16px; border-radius:12px; background:rgba(124,58,237,.08); border:1px solid rgba(124,58,237,.25); font-size:12.5px; color:var(--text); line-height:1.65; margin-bottom:18px; }
    .cf-info b { color:#7c3aed; }
    .cf-info code { background:rgba(255,255,255,.06); padding:2px 7px; border-radius:6px; font-size:11px; font-weight:800; color:#a78bfa; }
    .cf-field { margin-bottom:16px; }
    .cf-field label { display:block; font-size:11px; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--muted); margin-bottom:6px; }
    .cf-field input, .cf-field select, .cf-field textarea { width:100%; padding:12px 14px; border-radius:11px; border:1px solid var(--border); background:var(--surface); font-size:13.5px; font-weight:600; color:var(--text); font-family:inherit; }
    .cf-field textarea { min-height:180px; line-height:1.65; resize:vertical; font-family:'Courier New', monospace; font-size:12.5px; }
    .cf-field input:focus, .cf-field textarea:focus { outline:none; border-color:#7c3aed; box-shadow:0 0 0 4px rgba(124,58,237,.12); }
    .cf-field small { display:block; margin-top:5px; font-size:11px; color:var(--muted); }
    .cf-submit { width:100%; padding:14px; border:none; border-radius:13px; font-size:14px; font-weight:900; cursor:pointer; color:#03251f; background:linear-gradient(145deg,#fde68a,#d9a441); box-shadow:0 6px 16px rgba(217,164,65,.35); font-family:var(--font-display); transition:all .2s; }
    .cf-submit:hover { transform:translateY(-2px); filter:brightness(1.05); }
    .cf-toggle-pwd { margin-left:8px; padding:5px 10px; border-radius:7px; border:1px solid var(--border); background:rgba(255,255,255,.04); color:var(--muted); font-size:11px; cursor:pointer; }
</style>

<div class="cf-head">
    <a class="cf-back" href="<?= e(url('admin/index.php?page=chatbot')) ?>">← Dashboard</a>
    <div style="flex:1;">
        <h2>⚙️ Konfigurasi AI Siti</h2>
        <p>Konfigurasi model AI eksternal (OpenRouter) sebagai fallback ketika knowledge base lokal tidak cukup menjawab.</p>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<form method="post" action="<?= e(url('admin/index.php?page=chatbot-config-save')) ?>">
    <?= csrf_field() ?>

    <div class="cf-card">
        <h3><span class="emo">🔑</span><span>Kredensial AI</span></h3>
        <div class="cf-info">
            💡 <b>Tips:</b> Dapatkan API key gratis dari <a href="https://openrouter.ai/keys" target="_blank" style="color:#a78bfa; text-decoration:underline;">openrouter.ai/keys</a>.
            Model free tier yang direkomendasikan: <code>google/gemini-2.0-flash-exp:free</code>, <code>meta-llama/llama-3.3-70b-instruct:free</code>, atau <code>deepseek/deepseek-chat-v3-0324:free</code>.
        </div>
        <div class="cf-field">
            <label>API Key <span style="color:#fca5a5">*</span> <small style="display:inline; margin:0; text-transform:none;">— kosongkan untuk hanya pakai knowledge base lokal</small></label>
            <div style="display:flex; gap:8px; align-items:center;">
            <input type="password" name="chatbot_ai_key" id="cf-key" value="<?= e($cfg['chatbot_ai_key']) ?>" placeholder="sk-or-v1-xxxxxxxxxxxxx" autocomplete="new-password">
                <button type="button" class="cf-toggle-pwd" onclick="var i=document.getElementById('cf-key');i.type=i.type==='password'?'text':'password';this.textContent=i.type==='password'?'👁️':'🙈'">👁️</button>
            </div>
            <small>Disimpan terenkripsi di tabel <code>system_settings</code>. Jangan bagikan.</small>
        </div>
        <div class="cf-field">
            <label>Model AI</label>
            <input type="text" name="chatbot_ai_model" value="<?= e($cfg['chatbot_ai_model'] ?: 'google/gemini-2.0-flash-exp:free') ?>" placeholder="google/gemini-2.0-flash-exp:free">
            <small>Format: <code>provider/model:variant</code> (lihat <a href="https://openrouter.ai/models" target="_blank" style="color:#a78bfa;">daftar model</a>)</small>
        </div>
    </div>

    <div class="cf-card">
        <h3><span class="emo">🎭</span><span>System Prompt (Persona Siti)</span></h3>
        <div class="cf-info">
            📝 System prompt menentukan <b>kepribadian, batas topik, dan gaya bicara</b> Siti. Edit untuk menyesuaikan dengan karakter LP3M UNIMOF.
        </div>
        <div class="cf-field">
            <label>Prompt</label>
            <textarea name="chatbot_ai_prompt" placeholder="Anda adalah Siti, asisten virtual LP3M..."><?= e($cfg['chatbot_ai_prompt'] ?: "Anda adalah \"Siti\", asisten virtual resmi LP3M UNIMOF (Lembaga Penelitian, Pengabdian kepada Masyarakat, dan Al-Islam Kemuhammadiyahan, Universitas Muhammadiyah Maumere).

Kepribadian: ramah, profesional, singkat (maks 4 kalimat), menggunakan bahasa Indonesia baku yang hangat. Selalu akhiri dengan ajakan bertindak jika memungkinkan.

Topik yang bisa dijawab: penelitian, pengabdian, publikasi, HAKI, AIK, hibah, sertifikat, cek plagiat, survei kepuasan, jadwal, dan kontak LP3M.

Jika ditanya di luar konteks LP3M/pendidikan tinggi, tolak dengan sopan dan arahkan ke topik yang relevan.

Contoh jawaban:
\"Untuk mengajukan hibah internal, login sebagai Dosen lalu buka menu Hibah → Pengajuan Baru. Tenggat periode ini adalah 30 Oktober 2026. Ada yang bisa saya bantu lebih lanjut?\"") ?></textarea>
        </div>
    </div>

    <button type="submit" class="cf-submit">💾 Simpan Konfigurasi</button>
</form>