<?php
// SVG Icon Helper (reuse dari index.php atau definisikan di sini)
function renderBroadcastFormIcon($name, $size = 16, $color = 'currentColor') {
    $icons = [
        'edit' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
        'alert-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>',
        'check-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>',
        'save' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>',
        'x' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>',
        'info' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>',
        'chevron-down' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>',
        'users' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'mail' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>',
    ];
    return $icons[$name] ?? $icons['info'];
}
?>

<style>
    @keyframes bfFade { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }
    @keyframes iconRotate { 0%, 100% { transform: rotate(0deg) scale(1); } 25% { transform: rotate(-5deg) scale(1.05); } 75% { transform: rotate(5deg) scale(1.05); } }

    .bf-svg { display: inline-flex; align-items: center; justify-content: center; vertical-align: middle; }
    .bf-svg svg { display: block; transition: all 0.3s ease; }

    .bf-head {
        position: relative; overflow: hidden; display: flex; align-items: center; gap: 18px;
        margin-bottom: 24px; padding: 28px 32px; border-radius: 24px;
        background: linear-gradient(135deg, #7c2d12 0%, #c2410c 55%, #ea580c 100%);
        color: #fff; box-shadow: 0 20px 50px rgba(0,0,0,.3);
        animation: bfFade .5s cubic-bezier(.16,1,.3,1) both;
    }
    .bf-head-ico {
        width: 60px; height: 60px; border-radius: 17px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.55), transparent 45%),
                    linear-gradient(145deg, #fde68a, #f2c063 55%, #a9761b);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.6), 0 8px 20px rgba(217,164,65,.4);
        transition: transform 0.3s ease;
    }
    .bf-head-ico:hover { transform: scale(1.05) rotate(-5deg); }
    .bf-head-ico svg { width: 28px; height: 28px; stroke: #03251f; stroke-width: 2.2; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2)); }
    
    .bf-head h2 {
        margin: 0 0 5px; font-family: var(--font-display); font-size: 23px; font-weight: 900;
        letter-spacing: -0.02em;
    }
    .bf-head p { margin: 0; font-size: 13px; opacity: .9; }

    .bf-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 22px; padding: 28px; margin-bottom: 20px;
        animation: bfFade .5s both; position: relative; overflow: hidden;
        box-shadow: 0 6px 20px rgba(0,0,0,.05);
    }
    .bf-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, #ea580c, #f2c063); opacity: .85;
    }
    .bf-label {
        display: flex; align-items: center; gap: 8px;
        font-size: 12px; font-weight: 850; letter-spacing: .08em;
        text-transform: uppercase; color: var(--primary-dark); margin-bottom: 10px;
    }
    .bf-label .field-ico {
        display: inline-flex; align-items: center; justify-content: center;
        width: 24px; height: 24px; border-radius: 8px;
        background: linear-gradient(145deg, rgba(234,88,12,.15), rgba(234,88,12,.08));
        border: 1px solid rgba(234,88,12,0.2);
    }
    .bf-label .field-ico svg { width: 13px; height: 13px; stroke: #ea580c; stroke-width: 2.5; }

    .bf-input, .bf-select, .bf-textarea {
        width: 100%; padding: 13px 16px; border-radius: 13px;
        border: 2px solid var(--border); background: linear-gradient(145deg, #f6faf7, #fff);
        font-size: 14px; font-weight: 600; color: #03251f !important;
        -webkit-text-fill-color: #03251f !important;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: inset 0 2px 4px rgba(0,0,0,.04), inset 0 -1px 0 rgba(255,255,255,.8);
        font-family: var(--font-body);
    }
    .bf-textarea { min-height: 240px; line-height: 1.7; resize: vertical; }
    
    .bf-select {
        appearance: none; -webkit-appearance: none; -moz-appearance: none;
        cursor: pointer; padding-right: 46px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='none' stroke='%23ea580c' stroke-width='2.5' viewBox='0 0 24 24'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 14px center !important;
        background-size: 18px 18px !important;
    }
    .bf-select option { background: #ffffff; color: #03251f; padding: 10px; font-weight: 600; }

    .bf-input:focus, .bf-select:focus, .bf-textarea:focus {
        outline: none; border-color: #ea580c; background: #fff;
        box-shadow: inset 0 2px 4px rgba(0,0,0,.06), 0 0 0 4px rgba(234, 88, 12, 0.15), 0 6px 16px rgba(234,88,12,0.15);
    }

    .bf-hint {
        display: flex; align-items: flex-start; gap: 7px;
        font-size: 12px; color: var(--muted); margin-top: 8px; line-height: 1.6;
    }
    .bf-hint svg { width: 14px; height: 14px; stroke: #f2c063; stroke-width: 2.2; flex-shrink: 0; margin-top: 2px; }

    .bf-actions { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; padding-top: 8px; }
    
    .bf-save {
        position: relative; overflow: hidden; padding: 15px 30px; border: none; border-radius: 14px;
        font-size: 14.5px; font-weight: 850; cursor: pointer; color: #03251f;
        background: linear-gradient(145deg, #fde68a, #d9a441);
        box-shadow: inset 0 2px 3px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.15), 0 10px 24px rgba(217,164,65,.4);
        font-family: var(--font-display);
        display: inline-flex; align-items: center; gap: 8px;
        transition: all .3s cubic-bezier(.16,1,.3,1);
    }
    .bf-save svg { width: 18px; height: 18px; stroke: #03251f; stroke-width: 2.5; filter: drop-shadow(0 1px 2px rgba(0,0,0,0.15)); }
    .bf-save::before {
        content: ''; position: absolute; top: 3px; left: 10%; width: 35%; height: 35%;
        border-radius: 50%; background: rgba(255,255,255,.6); filter: blur(2px); pointer-events: none;
    }
    .bf-save:hover { transform: translateY(-3px); box-shadow: inset 0 2px 3px rgba(255,255,255,.8), 0 16px 34px rgba(217,164,65,.55); }
    .bf-save:active { transform: translateY(0); }

    .bf-cancel {
        padding: 15px 26px; border-radius: 14px; text-decoration: none;
        font-size: 14.5px; font-weight: 700; color: var(--muted);
        background: linear-gradient(145deg, #f6faf7, #fff);
        border: 2px solid var(--border);
        transition: all .25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: inset 0 2px 4px rgba(0,0,0,.04);
        display: inline-flex; align-items: center; gap: 7px;
    }
    .bf-cancel svg { width: 16px; height: 16px; stroke: currentColor; stroke-width: 2.5; }
    .bf-cancel:hover {
        transform: translateY(-2px); border-color: rgba(220,38,38,.35); color: #991b1b;
        box-shadow: 0 8px 18px rgba(220,38,38,.12);
    }

    /* Flash messages */
    .flash-3d {
        position: relative; padding: 15px 20px; margin-bottom: 22px; border-radius: 14px;
        font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 10px;
        overflow: hidden; box-shadow: inset 0 1px 2px rgba(255,255,255,.7), inset 0 -2px 3px rgba(0,0,0,.05), 0 6px 16px rgba(0,0,0,.1);
        animation: bfFade .5s cubic-bezier(.16,1,.3,1) both;
    }
    .flash-3d svg { width: 20px; height: 20px; stroke-width: 2.2; flex-shrink: 0; }
    .flash-success-3d { background: linear-gradient(145deg, #d1fae5, #a7f3d0); border: 1px solid rgba(16,185,129,.35); color: #065f46; }
    .flash-success-3d svg { stroke: #065f46; }
    .flash-error-3d { background: linear-gradient(145deg, #fee2e2, #fecaca); border: 1px solid rgba(220,38,38,.35); color: #991b1b; }
    .flash-error-3d svg { stroke: #991b1b; }
</style>

<div class="bf-head">
    <div class="bf-head-ico">
        <?= renderBroadcastFormIcon('edit', 28, '#03251f') ?>
    </div>
    <div>
        <h2>Tulis Broadcast Baru</h2>
        <p>Komposisikan pengumuman — tersimpan sebagai draft hingga Anda klik Kirim.</p>
    </div>
</div>

<?php if (!empty($flash)): ?>
<div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
    <?= $flash['type'] === 'error' ? renderBroadcastFormIcon('alert-circle', 20, 'currentColor') : renderBroadcastFormIcon('check-circle', 20, 'currentColor') ?>
    <span><?= e($flash['message']) ?></span>
</div>
<?php endif; ?>

<form method="post" action="<?= e(url('admin/index.php?page=broadcast-simpan')) ?>">
    <?= csrf_field() ?>
    <div class="bf-card">
        <div style="margin-bottom:22px;">
            <label class="bf-label" for="f-title">
                <span class="field-ico"><?= renderBroadcastFormIcon('edit', 13, 'currentColor') ?></span>
                Judul / Subjek Email
                <span style="color:#dc2626; margin-left:4px;">*</span>
            </label>
            <input class="bf-input" id="f-title" type="text" name="title" required placeholder="Contoh: Pembukaan Hibah Internal Penelitian 2026">
        </div>
        
        <div style="margin-bottom:22px;">
            <label class="bf-label" for="f-segment">
                <span class="field-ico"><?= renderBroadcastFormIcon('users', 13, 'currentColor') ?></span>
                Segment Penerima
            </label>
            <select class="bf-select" id="f-segment" name="segment">
                <?php foreach ($segments as $k => $l): ?>
                <option value="<?= e($k) ?>"><?= e($l) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="bf-hint">
                <?= renderBroadcastFormIcon('info', 14, 'currentColor') ?>
                <span><b>Subscriber Publik</b> = pendaftar footer website. Segment role = pengguna aktif dengan role terkait. Email dideduplikasi otomatis.</span>
            </div>
        </div>
        
        <div>
            <label class="bf-label" for="f-content">
                <span class="field-ico"><?= renderBroadcastFormIcon('mail', 13, 'currentColor') ?></span>
                Isi Pengumuman
                <span style="color:#dc2626; margin-left:4px;">*</span>
            </label>
            <textarea class="bf-textarea" id="f-content" name="content" required placeholder="Tulis isi pengumuman di sini...&#10;&#10;Baris baru akan ditampilkan sebagai paragraf pada email."></textarea>
            <div class="bf-hint">
                <?= renderBroadcastFormIcon('info', 14, 'currentColor') ?>
                <span>Email dikirim dengan template resmi LP3M (header hijau-emas + footer unsubscribe otomatis untuk subscriber).</span>
            </div>
        </div>
    </div>
    
    <div class="bf-actions">
        <button type="submit" class="bf-save">
            <?= renderBroadcastFormIcon('save', 18, 'currentColor') ?>
            <span>Simpan sebagai Draft</span>
        </button>
        <a class="bf-cancel" href="<?= e(url('admin/index.php?page=broadcast')) ?>">
            <?= renderBroadcastFormIcon('x', 16, 'currentColor') ?>
            <span>Batal</span>
        </a>
    </div>
</form>