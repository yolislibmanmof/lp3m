<?php
// ══════════════════════════════════════════════════════════════
// Widget Chatbot "Siti" — Floating Bubble Premium LP3M
// Include hanya di layouts/public.php sebelum </body>
// ══════════════════════════════════════════════════════════════
$chatbotEndpoint = e(url('public/index.php?page=chatbot-api'));
$chatbotFeedback = e(url('public/index.php?page=chatbot-log'));
$brand = e((Setting::all()['site_brand'] ?? 'LP3M'));
?>

<!-- ============ CHATBOT WIDGET START ============ -->
<style>
    /* ── KEYFRAMES ── */
    @keyframes chatPulse { 0%,100%{box-shadow:0 0 0 0 rgba(16,185,129,.5), 0 10px 30px rgba(3,37,31,.35)} 50%{box-shadow:0 0 0 16px rgba(16,185,129,0), 0 10px 30px rgba(3,37,31,.35)} }
    @keyframes chatFadeUp { from{opacity:0;transform:translateY(16px) scale(.95)} to{opacity:1;transform:none} }
    @keyframes chatTyping { 0%,60%,100%{transform:translateY(0);opacity:.5} 30%{transform:translateY(-4px);opacity:1} }
    @keyframes chatShine { 0%,55%{left:-90%} 100%{left:165%} }
    @keyframes chatPop { from{transform:scale(.6);opacity:0} to{transform:scale(1);opacity:1} }

    /* ── FLOATING ACTION BUTTON ── */
    .cb-fab { position: fixed; bottom: 96px; right: 24px; z-index: 9998; width: 62px; height: 62px; border-radius: 50%; border: none; cursor: pointer; background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.4), transparent 45%), linear-gradient(145deg, #34d399, #10b981 50%, #059669); box-shadow: 0 10px 30px rgba(3,37,31,.35); display: flex; align-items: center; justify-content: center; transition: all .3s cubic-bezier(.16,1,.3,1); animation: chatPulse 2.8s ease-in-out infinite; }
    .cb-fab::before { content:''; position:absolute; top:8px; left:14px; width:18px; height:7px; border-radius:50%; background:rgba(255,255,255,.55); filter:blur(1.5px); }
    .cb-fab::after { content:''; position:absolute; top:0; left:-90%; width:50%; height:100%; background:linear-gradient(105deg, transparent, rgba(255,255,255,.6), transparent); transform:skewX(-20deg); animation: chatShine 4s ease-in-out infinite; }
    .cb-fab:hover { transform: scale(1.08) rotate(-5deg); }
    .cb-fab-ico { font-size: 28px; position: relative; z-index: 1; transition: transform .3s; }
    .cb-fab.open .cb-fab-ico { transform: rotate(90deg) scale(0); }
    .cb-fab-close { position: absolute; font-size: 24px; color: #fff; transform: rotate(-90deg) scale(0); transition: transform .3s; z-index: 1; }
    .cb-fab.open .cb-fab-close { transform: rotate(0) scale(1); }
    .cb-fab.open { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.3), transparent 45%), linear-gradient(145deg, #fca5a5, #dc2626 50%, #991b1b); animation: none; }
    .cb-fab-badge { position: absolute; top: -4px; right: -4px; min-width: 22px; height: 22px; border-radius: 999px; background: linear-gradient(145deg, #fde68a, #d9a441); color: #03251f; font-size: 10.5px; font-weight: 900; padding: 0 6px; display: flex; align-items: center; justify-content: center; border: 2px solid #fff; box-shadow: 0 3px 8px rgba(217,164,65,.4); z-index: 2; }

    /* ── CHAT PANEL ── */
    .cb-panel { position: fixed; bottom: 172px; right: 24px; z-index: 9997; width: 380px; max-width: calc(100vw - 32px); height: 520px; max-height: calc(100vh - 210px); background: #f4faf6; border-radius: 22px; box-shadow: 0 30px 80px rgba(3,37,31,.35), 0 0 0 1px rgba(5,150,105,.12); display: none; flex-direction: column; overflow: hidden; animation: chatFadeUp .4s cubic-bezier(.16,1,.3,1); }
    .cb-panel.open { display: flex; }

    /* ── HEADER ── */
    .cb-head { padding: 16px 18px; background: linear-gradient(135deg, #065f46 0%, #059669 100%); color: #fff; display: flex; align-items: center; gap: 12px; position: relative; overflow: hidden; }
    .cb-head::before { content:''; position:absolute; top:-40px; right:-30px; width:140px; height:140px; border-radius:50%; background:radial-gradient(circle,rgba(253,230,138,.2),transparent 70%); pointer-events:none; }
    .cb-avatar { width: 44px; height: 44px; border-radius: 50%; background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.4), transparent 45%), linear-gradient(145deg, #fde68a, #f2c063 55%, #d9a441); display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; box-shadow: inset 0 2px 3px rgba(255,255,255,.6), 0 4px 10px rgba(217,164,65,.35); position: relative; z-index: 1; }
    .cb-avatar.online::after { content:''; position: absolute; bottom: 0; right: 0; width: 12px; height: 12px; border-radius: 50%; background: #6ee7b7; border: 2px solid #065f46; box-shadow: 0 0 0 0 rgba(110,231,183,.6); animation: chatPulse 2s infinite; }
    .cb-head-info { flex: 1; min-width: 0; position: relative; z-index: 1; }
    .cb-head-info b { display: block; font-family: var(--font-display, system-ui); font-size: 15px; font-weight: 900; letter-spacing: -.01em; }
    .cb-head-info span { display: flex; align-items: center; gap: 6px; font-size: 11px; opacity: .85; margin-top: 2px; }
    .cb-head-info span i { width: 6px; height: 6px; border-radius: 50%; background: #6ee7b7; box-shadow: 0 0 6px #6ee7b7; }
    .cb-close { width: 32px; height: 32px; border-radius: 10px; border: none; background: rgba(255,255,255,.12); color: #fff; font-size: 16px; cursor: pointer; transition: all .2s; display: flex; align-items: center; justify-content: center; position: relative; z-index: 1; }
    .cb-close:hover { background: rgba(255,255,255,.2); transform: rotate(90deg); }

    /* ── BODY / CHAT AREA ── */
    .cb-body { flex: 1; overflow-y: auto; padding: 18px 14px 8px; background: linear-gradient(180deg, #f4faf6 0%, #eaf4ec 100%); scrollbar-width: thin; scrollbar-color: rgba(5,150,105,.3) transparent; }
    .cb-body::-webkit-scrollbar { width: 5px; }
    .cb-body::-webkit-scrollbar-thumb { background: rgba(5,150,105,.3); border-radius: 999px; }

    /* ── MESSAGES ── */
    .cb-msg { display: flex; gap: 8px; margin-bottom: 12px; animation: chatPop .35s cubic-bezier(.16,1,.3,1) both; }
    .cb-msg.user { flex-direction: row-reverse; }
    .cb-msg-avatar { width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 14px; }
    .cb-msg.bot .cb-msg-avatar { background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.4), transparent 45%), linear-gradient(145deg, #fde68a, #d9a441); box-shadow: 0 2px 6px rgba(217,164,65,.3); }
    .cb-msg.user .cb-msg-avatar { background: linear-gradient(145deg, #3b82f6, #1d4ed8); color: #fff; box-shadow: 0 2px 6px rgba(59,130,246,.3); font-weight: 900; font-family: var(--font-display); font-size: 11px; }
    .cb-msg-content { max-width: 78%; display: flex; flex-direction: column; gap: 4px; }
    .cb-bubble { padding: 10px 14px; border-radius: 16px; font-size: 13.5px; line-height: 1.55; color: var(--ink, #03251f); word-wrap: break-word; white-space: pre-wrap; }
    .cb-msg.bot .cb-bubble { background: #fff; border: 1px solid rgba(5,150,105,.15); border-top-left-radius: 4px; box-shadow: 0 2px 6px rgba(3,37,31,.05); }
    .cb-msg.user .cb-bubble { background: linear-gradient(145deg, #065f46, #043b2c); color: #fff; border-top-right-radius: 4px; box-shadow: 0 2px 8px rgba(3,37,31,.2); }
    .cb-bubble b { color: #065f46; font-weight: 800; }
    .cb-msg.user .cb-bubble b { color: #fde68a; }
    .cb-meta { font-size: 9.5px; color: #7c9082; padding: 0 6px; display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
    .cb-msg.user .cb-meta { justify-content: flex-end; }
    .cb-meta .src { padding: 1px 7px; border-radius: 999px; background: rgba(5,150,105,.12); color: #047857; font-weight: 800; font-size: 8.5px; letter-spacing: .05em; }
    .cb-meta .src.ai { background: rgba(124,58,237,.12); color: #7c3aed; }
    .cb-feedback { display: inline-flex; gap: 3px; }
    .cb-feedback button { background: none; border: none; cursor: pointer; font-size: 13px; padding: 1px 4px; opacity: .4; transition: all .2s; border-radius: 4px; }
    .cb-feedback button:hover { opacity: 1; background: rgba(5,150,105,.1); }
    .cb-feedback button.active { opacity: 1; }

    /* ── TYPING INDICATOR ── */
    .cb-typing { display: flex; gap: 8px; align-items: center; margin-bottom: 12px; animation: chatFadeUp .3s both; }
    .cb-typing .cb-msg-avatar { width: 30px; height: 30px; border-radius: 50%; background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.4), transparent 45%), linear-gradient(145deg, #fde68a, #d9a441); display: flex; align-items: center; justify-content: center; font-size: 14px; box-shadow: 0 2px 6px rgba(217,164,65,.3); }
    .cb-typing-dots { display: flex; gap: 4px; padding: 12px 16px; background: #fff; border: 1px solid rgba(5,150,105,.15); border-radius: 16px; border-top-left-radius: 4px; box-shadow: 0 2px 6px rgba(3,37,31,.05); }
    .cb-typing-dots i { width: 7px; height: 7px; border-radius: 50%; background: #059669; animation: chatTyping 1.4s infinite; }
    .cb-typing-dots i:nth-child(2) { animation-delay: .2s; }
    .cb-typing-dots i:nth-child(3) { animation-delay: .4s; }

    /* ── SUGGESTIONS & INPUT ── */
    .cb-suggests { display: flex; flex-wrap: wrap; gap: 6px; padding: 4px 14px 10px; }
    .cb-chip { padding: 7px 12px; border-radius: 999px; background: #fff; border: 1px solid rgba(5,150,105,.25); font-size: 11.5px; font-weight: 700; color: #047857; cursor: pointer; transition: all .2s; max-width: 100%; font-family: inherit; }
    .cb-chip:hover { background: rgba(5,150,105,.08); border-color: #059669; transform: translateY(-1px); }

    .cb-input { padding: 12px 14px; background: #fff; border-top: 1px solid rgba(5,150,105,.12); display: flex; gap: 8px; align-items: flex-end; }
    .cb-input textarea { flex: 1; padding: 10px 14px; border-radius: 14px; border: 1.5px solid rgba(5,150,105,.2); background: #f4faf6; font-size: 13.5px; font-family: inherit; color: var(--ink); resize: none; max-height: 100px; line-height: 1.5; }
    .cb-input textarea:focus { outline: none; border-color: #059669; background: #fff; box-shadow: 0 0 0 3px rgba(5,150,105,.1); }
    .cb-input button { width: 42px; height: 42px; border-radius: 12px; border: none; background: linear-gradient(145deg, #065f46, #043b2c); color: #fde68a; font-size: 18px; cursor: pointer; transition: all .2s; flex-shrink: 0; box-shadow: 0 4px 10px rgba(3,37,31,.25); }
    .cb-input button:hover { transform: translateY(-2px) rotate(-8deg); filter: brightness(1.1); }
    .cb-input button:disabled { opacity: .5; cursor: not-allowed; transform: none; }
    .cb-powered { text-align: center; font-size: 9px; color: #7c9082; padding: 6px 0 10px; letter-spacing: .08em; background: #fff; }
    .cb-powered b { color: #065f46; }

    /* ── MOBILE ── */
    @media (max-width: 480px) {
        .cb-panel { bottom: 0; right: 0; left: 0; width: 100%; max-width: 100%; height: 100vh; max-height: 100vh; border-radius: 0; }
        .cb-fab { bottom: 88px; right: 18px; width: 58px; height: 58px; }
        .cb-fab-ico { font-size: 26px; }
    }
</style>

<button class="cb-fab" id="cbFab" type="button" aria-label="Tanya Siti — Asisten LP3M" title="Tanya Siti">
    <span class="cb-fab-ico">💬</span>
    <span class="cb-fab-close">✕</span>
    <span class="cb-fab-badge" id="cbBadge" style="display:none;">💡</span>
</button>

<div class="cb-panel" id="cbPanel" role="dialog" aria-label="Asisten LP3M">
    <div class="cb-head">
        <div class="cb-avatar online">🤖</div>
        <div class="cb-head-info">
            <b>Siti · Asisten <?= $brand ?></b>
            <span><i></i> Online · Siap membantu 24/7</span>
        </div>
        <button class="cb-close" id="cbClose" type="button" aria-label="Tutup">✕</button>
    </div>

    <div class="cb-body" id="cbBody"></div>
    <div class="cb-suggests" id="cbSuggests"></div>

    <form class="cb-input" id="cbForm">
        <textarea id="cbInput" rows="1" placeholder="Ketik pertanyaan Anda..." autocomplete="off" required></textarea>
        <button type="submit" id="cbSend" aria-label="Kirim">➤</button>
    </form>
    <div class="cb-powered">Powered by <b><?= $brand ?></b> AI · Fastabiqul Khairat</div>
</div>

<script>
(function(){
    'use strict';

    // ── Anti double-init & bersihkan instance duplikat ──
    if (window.__CB_INITIALIZED__) { return; }
    window.__CB_INITIALIZED__ = true;

    var fabs = document.querySelectorAll('.cb-fab');
    for (var i = 1; i < fabs.length; i++) { fabs[i].parentNode.removeChild(fabs[i]); }
    var panels = document.querySelectorAll('.cb-panel');
    for (var j = 1; j < panels.length; j++) { panels[j].parentNode.removeChild(panels[j]); }

    // ── Konfigurasi ──
    var ENDPOINT = '<?= $chatbotEndpoint ?>';
    var FEEDBACK = '<?= $chatbotFeedback ?>';
    var BRAND    = '<?= $brand ?>';

    function lsGet(k){ try { return window.localStorage.getItem(k); } catch (e) { return null; } }
    function lsSet(k, v){ try { window.localStorage.setItem(k, v); } catch (e) {} }
    var SESSION = 'sess_' + (lsGet('cb_sess') || (function(){ var s = Math.random().toString(36).slice(2,10); lsSet('cb_sess', s); return s; })());

    // ── Elemen DOM ──
    var fab      = document.getElementById('cbFab');
    var badge    = document.getElementById('cbBadge');
    var panel    = document.getElementById('cbPanel');
    var body     = document.getElementById('cbBody');
    var suggests = document.getElementById('cbSuggests');
    var form     = document.getElementById('cbForm');
    var input    = document.getElementById('cbInput');
    var sendBtn  = document.getElementById('cbSend');

    if (!fab || !panel || !form || !input) { return; }

    var isOpen = false, isTyping = false, greeted = false;

    // ── Helpers ──
    function escapeHtml(s) {
        return String(s).replace(/[&<>"']/g, function(c){
            return ({ '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;' })[c];
        });
    }
    function formatText(s) { return escapeHtml(s).replace(/\*\*(.+?)\*\*/g, '<b>$1</b>'); }
    function timeStr() {
        var d = new Date();
        return ('0'+d.getHours()).slice(-2) + ':' + ('0'+d.getMinutes()).slice(-2);
    }
    function scrollBottom() {
        requestAnimationFrame(function(){ body.scrollTop = body.scrollHeight; });
    }

    // ── Open / Close ──
    function open() {
        if (isOpen) return;
        isOpen = true;
        fab.classList.add('open');
        panel.classList.add('open');
        if (badge) badge.style.display = 'none';
        setTimeout(function(){ try { input.focus(); } catch(e){} }, 300);
        if (!greeted) greet();
    }
    function close() {
        if (!isOpen) return;
        isOpen = false;
        fab.classList.remove('open');
        panel.classList.remove('open');
    }

    // ── Delegasi klik global (fab, X, click-outside) ──
    document.addEventListener('click', function(e){
        var t = e.target || e.srcElement;
        if (!t || !t.closest) return;
        if (t.closest('.cb-fab'))   { e.preventDefault(); e.stopPropagation(); isOpen ? close() : open(); return; }
        if (t.closest('.cb-close')) { e.preventDefault(); e.stopPropagation(); close(); return; }
        if (t.closest('.cb-chip'))    return;
        if (t.closest('.cb-feedback')) return;
        if (isOpen && !panel.contains(t) && !fab.contains(t)) close();
    }, true);

    document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && isOpen) close(); });

    // ── Rendering pesan ──
    function addMsg(who, text, meta) {
        meta = meta || {};
        var div = document.createElement('div');
        div.className = 'cb-msg ' + who;
        var avatar = who === 'bot' ? '🤖' : (BRAND.charAt(0) || 'U');
        var srcTag = '';
        if (meta.source === 'ai') srcTag = '<span class="src ai">✨ AI</span>';
        else if (meta.source === 'local') srcTag = '<span class="src">📚 Lokal</span>';
        var fbHtml = '';
        if (who === 'bot' && meta.log_id) {
            fbHtml = '<span class="cb-feedback" data-log="' + meta.log_id + '">' +
                '<button type="button" data-fb="good" title="Membantu">👍</button>' +
                '<button type="button" data-fb="bad" title="Kurang membantu">👎</button>' +
                '</span>';
        }
        div.innerHTML =
            '<div class="cb-msg-avatar">' + avatar + '</div>' +
            '<div class="cb-msg-content">' +
              '<div class="cb-bubble">' + formatText(text) + '</div>' +
              '<div class="cb-meta"><span>' + timeStr() + '</span>' + srcTag + fbHtml + '</div>' +
            '</div>';
        body.appendChild(div);
        scrollBottom();
        if (meta.log_id) bindFeedback(div);
    }

    function showTyping() {
        if (isTyping) return;
        isTyping = true;
        var div = document.createElement('div');
        div.className = 'cb-typing';
        div.id = 'cbTyping';
        div.innerHTML = '<div class="cb-msg-avatar">🤖</div><div class="cb-typing-dots"><i></i><i></i><i></i></div>';
        body.appendChild(div);
        scrollBottom();
    }

    function hideTyping() {
        isTyping = false;
        var t = document.getElementById('cbTyping');
        if (t && t.parentNode) t.parentNode.removeChild(t);
    }

    function renderSuggestions(list) {
        suggests.innerHTML = '';
        if (!list || !list.length) return;
        list.slice(0, 4).forEach(function(s){
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'cb-chip';
            btn.textContent = s;
            btn.addEventListener('click', function(){ send(s); });
            suggests.appendChild(btn);
        });
    }

    function bindFeedback(el) {
        el.querySelectorAll('.cb-feedback button').forEach(function(btn){
            btn.addEventListener('click', function(){
                var wrap = el.querySelector('.cb-feedback');
                var logId = wrap ? wrap.getAttribute('data-log') : 0;
                var fb = btn.getAttribute('data-fb');
                el.querySelectorAll('.cb-feedback button').forEach(function(b){ b.classList.remove('active'); });
                btn.classList.add('active');
                try {
                    fetch(FEEDBACK, {
                        method: 'POST',
                        headers: {'Content-Type':'application/json'},
                        body: JSON.stringify({ id: parseInt(logId, 10), feedback: fb })
                    }).catch(function(){});
                } catch(e){}
            });
        });
    }

    // ── Greeting awal ──
    function greet() {
        greeted = true;
        setTimeout(function(){
            var hour = new Date().getHours();
            var g = hour < 11 ? 'Selamat pagi! 🌅' : (hour < 15 ? 'Selamat siang! ☀️' : (hour < 18 ? 'Selamat sore! 🌇' : 'Selamat malam! 🌙'));
            addMsg('bot',
                g + ' Saya Siti, asisten virtual ' + BRAND + '. Ada yang bisa saya bantu?\n\n' +
                'Anda bisa tanyakan tentang:\n' +
                '• 📚 Penelitian & Publikasi\n' +
                '• 🛎️ Layanan LP3M\n' +
                '• 💰 Hibah & Pendanaan\n' +
                '• 🎓 Sertifikat & Verifikasi',
                { source: 'local' });
            renderSuggestions([
                'Cara mengajukan penelitian?',
                'Alamat & jam kerja?',
                'Cara cek plagiat?',
                'Info hibah aktif'
            ]);
        }, 400);
    }

    // ── Kirim pesan ──
    function send(text) {
        text = (text || '').trim();
        if (!text || isTyping) return;

        addMsg('user', text);
        input.value = '';
        input.style.height = 'auto';
        renderSuggestions([]);
        showTyping();
        sendBtn.disabled = true;

        fetch(ENDPOINT, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: text, session: SESSION })
        })
        .then(function(r){ return r.json(); })
        .then(function(data){
            hideTyping();
            if (!data || !data.ok) {
                addMsg('bot', (data && data.answer) || 'Maaf, saya mengalami gangguan. Coba lagi dalam beberapa saat.', { source: 'error' });
            } else {
                addMsg('bot', data.answer, { source: data.source, log_id: data.log_id });
                if (data.suggestions && data.suggestions.length) renderSuggestions(data.suggestions);
            }
        })
        .catch(function(){
            hideTyping();
            addMsg('bot', 'Koneksi bermasalah. Periksa internet Anda dan coba lagi.', { source: 'error' });
        })
        .finally(function(){
            sendBtn.disabled = false;
            try { input.focus(); } catch(e){}
        });
    }

    // ── Event handlers input ──
    form.addEventListener('submit', function(e){ e.preventDefault(); send(input.value); });
    input.addEventListener('keydown', function(e){
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(input.value); }
    });
    input.addEventListener('input', function(){
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 100) + 'px';
    });

    // ── Badge notifikasi setelah 3.5 detik ──
    setTimeout(function(){
        if (!isOpen && badge) { badge.style.display = 'flex'; }
    }, 3500);
})();
</script>
<!-- ============ CHATBOT WIDGET END ============ -->