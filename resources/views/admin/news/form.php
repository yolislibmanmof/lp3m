<style>
@keyframes newsFormShine{0%{transform:translateX(-100%) skewX(-20deg)}100%{transform:translateX(300%) skewX(-20deg)}}
@keyframes newsFormFadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
@keyframes newsFormPulse{0%,100%{box-shadow:0 0 0 0 rgba(5,150,105,.4)}50%{box-shadow:0 0 0 6px rgba(5,150,105,0)}}
@keyframes newsReqPulse{0%,100%{transform:scale(1)}50%{transform:scale(1.2)}}
@keyframes slugSpin{from{transform:rotate(0)}to{transform:rotate(360deg)}}

.news-form-head{display:flex;align-items:center;gap:16px;margin-bottom:24px;padding:22px 26px;border-radius:22px;background:linear-gradient(135deg,#043b2c 0%,#065f46 55%,#059669 100%);color:#fff;position:relative;overflow:hidden;box-shadow:0 16px 40px rgba(0,0,0,.30);animation:newsFormFadeUp .5s cubic-bezier(.16,1,.3,1) both}
.news-form-head::before{content:'';position:absolute;inset:0;background-image:repeating-linear-gradient(45deg,transparent,transparent 25px,rgba(217,164,65,.04) 25px,rgba(217,164,65,.04) 26px),repeating-linear-gradient(-45deg,transparent,transparent 25px,rgba(217,164,65,.04) 25px,rgba(217,164,65,.04) 26px)}
.news-form-head::after{content:'';position:absolute;top:-50%;right:-10%;width:320px;height:320px;border-radius:50%;background:radial-gradient(circle,rgba(217,164,65,.25),transparent 70%);pointer-events:none}
.news-form-ico{width:56px;height:56px;border-radius:16px;flex-shrink:0;background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.5),transparent 40%),linear-gradient(145deg,#fde68a,#f2c063 50%,#d9a441);display:flex;align-items:center;justify-content:center;font-size:26px;position:relative;box-shadow:inset 0 2px 3px rgba(255,255,255,.7),inset 0 -3px 4px rgba(0,0,0,.2),0 6px 16px rgba(217,164,65,.45)}
.news-form-ico::before{content:'';position:absolute;top:5px;left:10px;width:16px;height:7px;border-radius:50%;background:rgba(255,255,255,.65);filter:blur(1.5px)}
.news-form-title{font-family:var(--font-display);font-size:22px;font-weight:900;letter-spacing:-.02em;margin:0;position:relative;z-index:1;background:linear-gradient(135deg,#fff 0%,#fde68a 100%);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent}
.news-form-sub{font-size:12.5px;opacity:.85;margin:4px 0 0;position:relative;z-index:1}
.news-form-mode{margin-left:auto;padding:4px 12px;border-radius:999px;font-size:10px;font-weight:900;letter-spacing:.1em;text-transform:uppercase;position:relative;z-index:1;flex-shrink:0}
.news-form-mode.edit{background:linear-gradient(145deg,#fde68a,#d9a441);color:#03251f;box-shadow:inset 0 1px 2px rgba(255,255,255,.7),inset 0 -1px 2px rgba(0,0,0,.15)}
.news-form-mode.new{background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.3)}

.flash-3d{position:relative;padding:14px 18px;margin-bottom:20px;border-radius:14px;font-size:13.5px;font-weight:700;display:flex;align-items:center;gap:10px;overflow:hidden;box-shadow:inset 0 1px 2px rgba(255,255,255,.7),inset 0 -2px 3px rgba(0,0,0,.05),0 4px 12px rgba(0,0,0,.1);animation:newsFormFadeUp .5s cubic-bezier(.16,1,.3,1) both}
.flash-3d::after{content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent);animation:newsFormShine 3s ease-in-out infinite;pointer-events:none}
.flash-success-3d{background:linear-gradient(145deg,#d1fae5,#a7f3d0);border:1px solid rgba(16,185,129,.35);color:#065f46}
.flash-error-3d{background:linear-gradient(145deg,#fee2e2,#fecaca);border:1px solid rgba(220,38,38,.35);color:#991b1b}

.form-section-3d{background:var(--white);border:1px solid var(--border);border-radius:20px;padding:26px;margin-bottom:20px;box-shadow:0 4px 14px rgba(0,0,0,.04);position:relative;overflow:hidden;animation:newsFormFadeUp .5s cubic-bezier(.16,1,.3,1) both}
.form-section-3d:nth-of-type(2){animation-delay:.08s}
.form-section-3d:nth-of-type(3){animation-delay:.16s}
.form-section-3d:nth-of-type(4){animation-delay:.24s}
.form-section-3d::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--gold-strong),var(--primary));opacity:.7}
.form-section-title{display:flex;align-items:center;gap:10px;font-size:15px;font-weight:900;color:var(--ink);font-family:var(--font-display);margin:0 0 22px;padding-bottom:14px;border-bottom:1px dashed var(--border)}
.form-section-title .section-emoji{display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:10px;background:linear-gradient(145deg,#f6faf7,#fff);border:1px solid var(--border);font-size:15px;box-shadow:inset 0 1px 1px rgba(255,255,255,.9)}
.form-section-title .section-num{margin-left:auto;font-size:10px;font-weight:900;letter-spacing:.1em;color:var(--muted)}

.fg-3d{margin-bottom:20px;position:relative}
.fg-3d:last-child{margin-bottom:0}
.fg-3d label{display:flex;align-items:center;gap:8px;font-size:11.5px;font-weight:850;letter-spacing:.08em;text-transform:uppercase;color:var(--primary-dark);margin-bottom:9px}
.fg-3d label .field-ico{display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:7px;background:linear-gradient(145deg,rgba(16,185,129,.15),rgba(5,150,105,.08));font-size:11px}
.fg-3d label .req-badge{display:inline-flex;align-items:center;gap:4px;padding:1px 7px;border-radius:999px;font-size:8.5px;font-weight:900;letter-spacing:.08em;background:rgba(220,38,38,.10);color:#dc2626;border:1px solid rgba(220,38,38,.25);margin-left:4px;text-transform:uppercase}
.fg-3d label .req-badge::before{content:'';width:5px;height:5px;border-radius:50%;background:#dc2626;animation:newsReqPulse 1.5s ease-in-out infinite}
.fg-3d label .opt-badge{padding:1px 7px;border-radius:999px;font-size:8.5px;font-weight:800;letter-spacing:.08em;background:rgba(100,116,139,.12);color:#64748b;border:1px solid rgba(100,116,139,.25);text-transform:uppercase}

.fg-3d input[type="text"],.fg-3d input[type="date"],.fg-3d input[type="url"],.fg-3d select,.fg-3d textarea{width:100%;padding:13px 16px;border-radius:13px;border:2px solid var(--border);background:linear-gradient(145deg,#f6faf7,#fff);font-size:14px;font-weight:600;color:#03251f !important;-webkit-text-fill-color:#03251f !important;transition:all .3s cubic-bezier(.16,1,.3,1);box-shadow:inset 0 2px 4px rgba(0,0,0,.04),inset 0 -1px 0 rgba(255,255,255,.8);color-scheme:light;font-family:var(--font-body)}
.fg-3d input:-webkit-autofill,.fg-3d input:-webkit-autofill:hover,.fg-3d input:-webkit-autofill:focus,.fg-3d select:-webkit-autofill,.fg-3d textarea:-webkit-autofill{-webkit-box-shadow:0 0 0 1000px #f6faf7 inset !important;-webkit-text-fill-color:#03251f !important;caret-color:#059669 !important;transition:background-color 99999s ease-in-out 0s;border-color:var(--border) !important}
.fg-3d select{appearance:none;-webkit-appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23059669' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") !important;background-repeat:no-repeat !important;background-position:right 16px center !important;background-size:12px 8px !important;padding-right:44px;cursor:pointer}
.fg-3d select option{background:#f6faf7;color:#03251f;padding:8px}
.fg-3d textarea{resize:vertical;min-height:120px;line-height:1.7}
.fg-3d textarea.content-area{min-height:320px;font-size:14.5px;line-height:1.8}
.fg-3d input:focus,.fg-3d select:focus,.fg-3d textarea:focus{outline:none;border-color:#059669;background:#fff;color:#03251f !important;-webkit-text-fill-color:#03251f !important;box-shadow:inset 0 2px 4px rgba(0,0,0,.06),0 0 0 4px rgba(5,150,105,.12),0 4px 12px rgba(5,150,105,.15)}
.fg-3d input:invalid:not(:placeholder-shown),.fg-3d textarea:invalid:not(:placeholder-shown){border-color:rgba(220,38,38,.5)}
.fg-3d .field-helper{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-top:7px;font-size:11px;color:var(--muted);flex-wrap:wrap}
.fg-3d .field-helper .helper-tip{display:inline-flex;align-items:center;gap:4px}
.fg-3d .field-counter{font-family:var(--font-display);font-weight:850;font-size:11px;color:var(--muted);padding:2px 8px;border-radius:6px;background:rgba(100,116,139,.08);transition:color .2s}
.fg-3d .field-counter.warn{color:#f2c063;background:rgba(242,192,99,.12)}
.fg-3d .field-counter.danger{color:#dc2626;background:rgba(220,38,38,.12)}

.slug-field-wrap{display:flex;gap:8px;align-items:stretch}
.slug-field-wrap input{flex:1;font-family:'Courier New',monospace;font-size:13px;color:#059669 !important}
.slug-regen-btn{padding:0 14px;border-radius:13px;border:2px solid var(--border);background:linear-gradient(145deg,#f6faf7,#fff);color:var(--primary-dark);cursor:pointer;font-size:13px;font-weight:800;display:inline-flex;align-items:center;gap:4px;transition:all .25s;white-space:nowrap}
.slug-regen-btn:hover{border-color:var(--primary);color:var(--primary);transform:translateY(-1px)}
.slug-regen-btn:active .slug-regen-ico{animation:slugSpin .5s ease-in-out}
.slug-regen-ico{display:inline-block;transition:transform .3s}

.category-preview{display:inline-flex;align-items:center;gap:8px;padding:6px 14px;margin-top:10px;border-radius:999px;background:linear-gradient(145deg,rgba(16,185,129,.10),rgba(5,150,105,.05));border:1px solid rgba(5,150,105,.25);font-size:12px;font-weight:700;color:#065f46;transition:all .3s}
.category-preview .cat-dot{width:8px;height:8px;border-radius:50%;background:#10b981;box-shadow:0 0 0 3px rgba(16,185,129,.2)}

.status-preview-3d{margin-top:10px;padding:10px 14px;border-radius:11px;display:flex;align-items:center;gap:10px;font-size:12px;font-weight:700;border:1px solid;transition:all .3s}
.status-preview-3d.published{background:linear-gradient(145deg,rgba(16,185,129,.10),rgba(5,150,105,.05));color:#065f46;border-color:rgba(16,185,129,.3)}
.status-preview-3d.draft{background:linear-gradient(145deg,rgba(100,116,139,.08),rgba(100,116,139,.04));color:#475569;border-color:rgba(100,116,139,.25)}
.status-preview-3d .sp-dot{width:8px;height:8px;border-radius:50%}
.status-preview-3d.published .sp-dot{background:#10b981;box-shadow:0 0 0 3px rgba(16,185,129,.2);animation:newsFormPulse 2s ease-in-out infinite}
.status-preview-3d.draft .sp-dot{background:#64748b}

/* ===== FEATURED SWITCH (BARU) ===== */
.featured-switch{display:flex;align-items:center;gap:12px;cursor:pointer;padding:12px 16px;border-radius:13px;border:2px solid var(--border);background:linear-gradient(145deg,#f6faf7,#fff);transition:all .3s}
.featured-switch:hover{border-color:rgba(217,164,65,.4)}
.featured-switch input{position:absolute;opacity:0;width:0;height:0}
.fs-slider{width:46px;height:26px;border-radius:999px;background:#cbd5e1;position:relative;flex-shrink:0;transition:all .3s;box-shadow:inset 0 2px 4px rgba(0,0,0,.15)}
.fs-slider::after{content:'';position:absolute;top:3px;left:3px;width:20px;height:20px;border-radius:50%;background:#fff;box-shadow:0 2px 4px rgba(0,0,0,.2);transition:all .3s}
.featured-switch input:checked ~ .fs-slider{background:linear-gradient(145deg,#fde68a,#d9a441);box-shadow:inset 0 2px 4px rgba(0,0,0,.1),0 0 0 3px rgba(217,164,65,.2)}
.featured-switch input:checked ~ .fs-slider::after{left:23px}
.fs-text{font-size:12.5px;font-weight:700;color:var(--muted);text-transform:none;letter-spacing:0}
.featured-switch input:checked ~ .fs-text{color:#92400e}

.form-row-3d{display:grid;grid-template-columns:1fr 1fr;gap:16px}
@media(max-width:640px){.form-row-3d{grid-template-columns:1fr}}

.content-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-top:10px;padding:12px;background:linear-gradient(145deg,#f6faf7,#fff);border:1px solid var(--border);border-radius:12px}
.content-stat{text-align:center;padding:6px}
.content-stat .stat-value{font-family:var(--font-display);font-size:18px;font-weight:900;color:var(--primary-dark)}
.content-stat .stat-label{font-size:9.5px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-top:2px}
.content-stat+.content-stat{border-left:1px dashed var(--border)}

.excerpt-preview{margin-top:10px;padding:14px 16px;border-radius:12px;background:linear-gradient(145deg,rgba(217,164,65,.06),rgba(217,164,65,.02));border:1px solid rgba(217,164,65,.2)}
.excerpt-preview .exc-head{display:flex;align-items:center;gap:6px;font-size:10px;font-weight:900;letter-spacing:.1em;text-transform:uppercase;color:#92400e;margin-bottom:6px}
.excerpt-preview .exc-text{font-size:13px;color:#44403c;line-height:1.5;font-style:italic}
.excerpt-preview .exc-text.empty{color:var(--muted);font-style:italic}

.img-dropzone-3d{position:relative;padding:32px 24px;border-radius:18px;border:3px dashed rgba(217,164,65,.5);background:linear-gradient(145deg,rgba(253,230,138,.08),rgba(217,164,65,.04));text-align:center;cursor:pointer;transition:all .3s cubic-bezier(.16,1,.3,1);overflow:hidden}
.img-dropzone-3d::before{content:'';position:absolute;inset:0;background-image:repeating-linear-gradient(45deg,transparent,transparent 20px,rgba(217,164,65,.03) 20px,rgba(217,164,65,.03) 21px);pointer-events:none}
.img-dropzone-3d:hover{border-color:#059669;background:linear-gradient(145deg,rgba(16,185,129,.08),rgba(5,150,105,.04));box-shadow:0 8px 24px rgba(5,150,105,.12);transform:translateY(-2px)}
.img-dropzone-3d.dragover{border-color:#059669;background:linear-gradient(145deg,rgba(16,185,129,.15),rgba(5,150,105,.08));transform:translateY(-3px)}
.img-dropzone-3d.has-file{border-style:solid;border-color:rgba(16,185,129,.4);background:linear-gradient(145deg,rgba(16,185,129,.06),rgba(5,150,105,.03))}
.img-dropzone-3d.has-error{border-color:rgba(220,38,38,.5);background:linear-gradient(145deg,rgba(254,226,226,.3),rgba(252,165,165,.08))}
.img-dropzone-3d input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer}
.img-dz-ico-3d{width:64px;height:64px;border-radius:20px;margin:0 auto 14px;background:radial-gradient(circle at 30% 25%,rgba(255,255,255,.5),transparent 40%),linear-gradient(145deg,#34d399,#10b981 50%,#059669);display:flex;align-items:center;justify-content:center;font-size:30px;position:relative;box-shadow:inset 0 2px 3px rgba(255,255,255,.6),inset 0 -3px 4px rgba(0,0,0,.25),0 6px 16px rgba(5,150,105,.35)}
.img-dz-ico-3d::before{content:'';position:absolute;top:6px;left:12px;width:18px;height:8px;border-radius:50%;background:rgba(255,255,255,.6);filter:blur(1.5px)}
.img-dz-title-3d{font-size:15px;font-weight:800;color:var(--ink);margin-bottom:6px;font-family:var(--font-display)}
.img-dz-sub-3d{font-size:12px;color:var(--muted);margin-bottom:10px}
.img-dz-formats{display:flex;gap:6px;justify-content:center;flex-wrap:wrap}
.img-dz-format-chip{padding:3px 10px;border-radius:999px;font-size:10px;font-weight:800;background:rgba(5,150,105,.1);color:var(--primary-dark);border:1px solid rgba(5,150,105,.25)}

.img-preview-live{display:none;align-items:center;gap:14px;padding:14px;margin-top:14px;border-radius:14px;background:linear-gradient(145deg,#f6faf7,#fff);border:1px solid rgba(16,185,129,.35);box-shadow:inset 0 1px 1px rgba(255,255,255,.9),0 3px 10px rgba(16,185,129,.1);animation:newsFormFadeUp .3s ease-out}
.img-preview-live.show{display:flex}
.img-preview-live img{width:100px;height:68px;border-radius:10px;object-fit:cover;border:2px solid var(--border);box-shadow:0 3px 10px rgba(0,0,0,.1)}
.img-preview-live .ipl-info{flex:1;min-width:0}
.img-preview-live .ipl-name{font-size:13px;font-weight:800;color:var(--ink);margin:0 0 3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.img-preview-live .ipl-meta{font-size:11px;color:var(--muted);font-weight:600;display:flex;gap:8px;align-items:center;flex-wrap:wrap}
.img-preview-live .ipl-remove{padding:4px 10px;border-radius:8px;border:none;cursor:pointer;background:rgba(220,38,38,.08);color:#dc2626;font-size:11px;font-weight:800;transition:all .2s}
.img-preview-live .ipl-remove:hover{background:#dc2626;color:#fff}

.img-warning-3d{display:none;align-items:center;gap:10px;padding:10px 14px;margin-top:10px;border-radius:11px;background:linear-gradient(145deg,rgba(220,38,38,.10),rgba(220,38,38,.05));border:1px solid rgba(220,38,38,.3);color:#991b1b;font-size:12px;font-weight:700;animation:newsFormFadeUp .3s ease-out}
.img-warning-3d.show{display:flex}

.thumb-preview-3d{display:flex;align-items:center;gap:16px;padding:16px 18px;margin-top:14px;border-radius:14px;background:linear-gradient(145deg,#f6faf7,#fff);border:1px solid rgba(217,164,65,.25);box-shadow:inset 0 1px 1px rgba(255,255,255,.9),0 3px 10px rgba(0,0,0,.05)}
.thumb-img-3d{width:110px;height:75px;border-radius:12px;object-fit:cover;border:2px solid var(--border);box-shadow:0 4px 12px rgba(0,0,0,.15);transition:transform .3s}
.thumb-img-3d:hover{transform:scale(1.08)}

.form-actions-3d{display:flex;gap:12px;flex-wrap:wrap;align-items:center;padding-top:8px}
.btn-save-3d{position:relative;padding:14px 28px;border:none;border-radius:13px;font-size:14px;font-weight:850;color:#03251f;cursor:pointer;background:linear-gradient(145deg,#fde68a,#f2c063 40%,#d9a441 80%,#a9761b);overflow:hidden;transition:all .3s cubic-bezier(.16,1,.3,1);box-shadow:inset 0 2px 3px rgba(255,255,255,.7),inset 0 -2px 3px rgba(0,0,0,.15),0 8px 20px rgba(217,164,65,.4);font-family:var(--font-display)}
.btn-save-3d::before{content:'';position:absolute;top:3px;left:10%;width:35%;height:35%;border-radius:50%;background:rgba(255,255,255,.6);filter:blur(2px);pointer-events:none}
.btn-save-3d::after{content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;background:linear-gradient(105deg,transparent,rgba(255,255,255,.5),transparent);animation:newsFormShine 3s ease-in-out infinite;pointer-events:none}
.btn-save-3d:hover{transform:translateY(-2px);box-shadow:inset 0 2px 3px rgba(255,255,255,.8),0 14px 30px rgba(217,164,65,.55)}
.btn-save-3d:active{transform:translateY(0)}
.btn-save-3d:disabled{opacity:.6;cursor:not-allowed}
.btn-cancel-3d{padding:14px 24px;border-radius:13px;text-decoration:none;font-size:14px;font-weight:700;color:var(--muted);background:linear-gradient(145deg,#f6faf7,#fff);border:2px solid var(--border);transition:all .25s;box-shadow:inset 0 2px 4px rgba(0,0,0,.04);display:inline-flex;align-items:center;gap:6px}
.btn-cancel-3d:hover{transform:translateY(-2px);border-color:rgba(220,38,38,.35);color:#991b1b;box-shadow:0 6px 14px rgba(220,38,38,.12)}
.form-actions-spacer{flex:1}
.form-tip-box{display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:10px;background:linear-gradient(145deg,rgba(217,164,65,.08),rgba(217,164,65,.04));border:1px solid rgba(217,164,65,.2);font-size:11px;color:#92400e;font-weight:600}
</style>

<!-- ================= HEADER 3D ================= -->
<div class="news-form-head">
    <div class="news-form-ico">✍️</div>
    <div style="position: relative; z-index: 1; flex: 1; min-width: 0;">
        <h2 class="news-form-title"><?= $item !== null ? 'Edit Berita' : 'Tambah Berita' ?></h2>
        <p class="news-form-sub">
            <?= $item !== null ? 'Perbarui konten berita sebelum dipublikasikan.' : 'Tulis berita baru untuk dipublikasikan ke website.' ?>
        </p>
    </div>
    <span class="news-form-mode <?= $item !== null ? 'edit' : 'new' ?>">
        <?= $item !== null ? '✎ Edit' : '+ Baru' ?>
    </span>
</div>

<?php if (!empty($flash)): ?>
    <div class="flash-3d <?= $flash['type'] === 'error' ? 'flash-error-3d' : 'flash-success-3d' ?>">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?> <?= e($flash['message']) ?>
    </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" action="<?= e($action) ?>" id="news-form">
    <?= csrf_field() ?>
    <?php if ($item !== null): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>

    <!-- SECTION 1: INFORMASI DASAR -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-emoji">📋</span>
            <span>Informasi Dasar</span>
            <span class="section-num">BAGIAN 1 / 3</span>
        </h3>

        <div class="fg-3d">
            <label for="f-title">
                <span class="field-ico">✏️</span>
                Judul Berita
                <span class="req-badge">Wajib</span>
            </label>
            <input type="text" id="f-title" name="title"
                   value="<?= e($item['title'] ?? old('title')) ?>"
                   required maxlength="200"
                   placeholder="Contoh: LP3M Gelar Workshop Penulisan Jurnal Bereputasi"
                   autocomplete="off">
            <div class="field-helper">
                <span class="helper-tip">💡 Judul yang menarik dan informatif (max 200 karakter)</span>
                <span class="field-counter" id="title-counter">0 / 200</span>
            </div>
        </div>

        <div class="fg-3d">
            <label for="f-slug">
                <span class="field-ico">🔗</span>
                Slug URL
                <span class="opt-badge">Otomatis</span>
            </label>
            <div class="slug-field-wrap">
                <input type="text" id="f-slug" name="slug"
                       value="<?= e($item['slug'] ?? old('slug')) ?>"
                       maxlength="200"
                       placeholder="akan-diisi-otomatis-dari-judul"
                       autocomplete="off">
                <button type="button" class="slug-regen-btn" id="slug-regen" title="Generate dari judul">
                    <span class="slug-regen-ico">🔄</span>
                    <span>Generate</span>
                </button>
            </div>
            <div class="field-helper">
                <span class="helper-tip">💡 URL-friendly. Auto-fill dari judul, bisa edit manual.</span>
            </div>
        </div>

        <div class="form-row-3d">
            <div class="fg-3d">
                <label for="f-category">
                    <span class="field-ico">🏷️</span>
                    Kategori
                    <span class="req-badge">Wajib</span>
                </label>
                <select id="f-category" name="category" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= e($cat) ?>" <?= ($item['category'] ?? 'umum') === $cat ? 'selected' : '' ?>>
                            <?= e(ucfirst($cat)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="category-preview" id="category-preview">
                    <span class="cat-dot"></span>
                    <span id="category-text"><?= e(ucfirst($item['category'] ?? 'umum')) ?></span>
                </div>
            </div>

            <div class="fg-3d">
                <label for="f-status">
                    <span class="field-ico">🚦</span>
                    Status
                    <span class="req-badge">Wajib</span>
                </label>
                <select id="f-status" name="status" required>
                    <option value="draft" <?= ($item['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>
                        ⚪ Draft — Belum dipublikasikan
                    </option>
                    <option value="published" <?= ($item['status'] ?? '') === 'published' ? 'selected' : '' ?>>
                        🟢 Published — Langsung tayang
                    </option>
                </select>
                <div class="status-preview-3d draft" id="status-preview">
                    <span class="sp-dot"></span>
                    <span id="status-preview-text">⚪ Berita tersimpan sebagai draft, belum tayang</span>
                </div>
            </div>
        </div>

        <!-- ===== FEATURED SWITCH (BARU) ===== -->
        <div class="fg-3d">
            <label>
                <span class="field-ico">⭐</span>
                Berita Unggulan
                <span class="opt-badge">Opsional</span>
            </label>
            <label class="featured-switch">
                <input type="checkbox" id="f-featured" name="is_featured" value="1"
                    <?= ($item !== null)
                        ? (!empty($item['is_featured']) ? 'checked' : '')
                        : (old('is_featured') === '1' ? 'checked' : '') ?>>
                <span class="fs-slider"></span>
                <span class="fs-text" id="featured-text">
                    <?= ($item !== null && !empty($item['is_featured'])) || old('is_featured') === '1'
                        ? '⭐ Aktif — tampil di hero slider halaman Berita publik'
                        : 'Nonaktif — tidak tampil di hero slider' ?>
                </span>
            </label>
            <div class="field-helper">
                <span class="helper-tip">💡 Berita unggulan akan muncul di bagian atas (hero slider) halaman Berita publik.</span>
            </div>
        </div>

        <!-- ===== TAGS / LABEL (BARU) ===== -->
        <div class="fg-3d">
            <label for="f-tags">
                <span class="field-ico">🏷️</span>
                Tags / Label
                <span class="opt-badge">Opsional</span>
            </label>
            <input type="text" id="f-tags" name="tags"
                   value="<?= e($itemTags ?? old('tags')) ?>"
                   placeholder="contoh: workshop, jurnal, penelitian, KKN"
                   autocomplete="off">
            <div class="field-helper">
                <span class="helper-tip">💡 Pisahkan dengan koma. Maksimal 8 tags.</span>
            </div>
            <div id="tags-preview" style="display:flex; gap:6px; flex-wrap:wrap; margin-top:8px;"></div>
        </div>
    </div>

    <!-- SECTION 2: GAMBAR THUMBNAIL -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-emoji">🖼️</span>
            <span>Gambar Thumbnail</span>
            <span class="section-num">BAGIAN 2 / 3</span>
        </h3>

        <div class="fg-3d">
            <label for="f-thumbnail">
                <span class="field-ico">📷</span>
                Upload Gambar
                <span class="opt-badge">Opsional</span>
            </label>

            <div class="img-dropzone-3d" id="img-dropzone">
                <input type="file" id="f-thumbnail" name="thumbnail"
                       accept=".jpg,.jpeg,.png,.webp">
                <div class="img-dz-ico-3d">🖼️</div>
                <div class="img-dz-title-3d" id="img-dz-title">
                    <?= ($item !== null && !empty($item['thumbnail'])) ? 'Ganti Gambar (Opsional)' : 'Klik atau Seret Gambar ke Sini' ?>
                </div>
                <div class="img-dz-sub-3d">JPG, PNG, atau WEBP · Maksimal 2 MB</div>
                <div class="img-dz-formats">
                    <span class="img-dz-format-chip">JPG</span>
                    <span class="img-dz-format-chip">JPEG</span>
                    <span class="img-dz-format-chip">PNG</span>
                    <span class="img-dz-format-chip">WEBP</span>
                </div>
            </div>

            <!-- Image preview live -->
            <div class="img-preview-live" id="img-preview">
                <img src="" alt="Preview" id="img-preview-src">
                <div class="ipl-info">
                    <p class="ipl-name" id="img-preview-name">—</p>
                    <div class="ipl-meta">
                        <span>📦 <span id="img-preview-size">—</span></span>
                        <span>✅ Siap diupload</span>
                    </div>
                </div>
                <button type="button" class="ipl-remove" id="img-remove">✕ Hapus</button>
            </div>

            <!-- Image warning -->
            <div class="img-warning-3d" id="img-warning">
                <span>⚠️</span>
                <span id="img-warning-text">—</span>
            </div>

            <?php if ($item !== null && !empty($item['thumbnail'])): ?>
                <div class="thumb-preview-3d">
                    <img class="thumb-img-3d" src="<?= e(upload_url($item['thumbnail'])) ?>" alt="Thumbnail saat ini">
                    <div>
                        <p style="margin: 0; font-size: 13px; font-weight: 700; color: var(--ink);">
                            🖼️ Gambar saat ini
                        </p>
                        <p style="margin: 4px 0 0; font-size: 11.5px; color: var(--muted);">
                            Upload gambar baru hanya jika ingin mengganti.
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- SECTION 3: ISI BERITA -->
    <div class="form-section-3d">
        <h3 class="form-section-title">
            <span class="section-emoji">📝</span>
            <span>Isi Berita</span>
            <span class="section-num">BAGIAN 3 / 3</span>
        </h3>

        <div class="fg-3d">
            <label for="f-content">
                <span class="field-ico">📰</span>
                Konten Berita
                <span class="req-badge">Wajib</span>
            </label>
            <textarea id="f-content" name="content" rows="14" class="content-area"
                      required maxlength="10000"
                      placeholder="Tulis isi berita di sini... Gunakan baris kosong untuk memisahkan paragraf. Paragraf pertama akan otomatis menjadi excerpt (ringkasan) di kartu berita."><?= e($item['content'] ?? old('content')) ?></textarea>

            <!-- Content Stats -->
            <div class="content-stats">
                <div class="content-stat">
                    <div class="stat-value" id="stat-words">0</div>
                    <div class="stat-label">Kata</div>
                </div>
                <div class="content-stat">
                    <div class="stat-value" id="stat-chars">0</div>
                    <div class="stat-label">Karakter</div>
                </div>
                <div class="content-stat">
                    <div class="stat-value" id="stat-readtime">0m</div>
                    <div class="stat-label">⏱️ Waktu Baca</div>
                </div>
            </div>

            <!-- Excerpt Preview -->
            <div class="excerpt-preview">
                <div class="exc-head">
                    <span>📋</span>
                    <span>Preview Excerpt (paragraf pertama)</span>
                </div>
                <p class="exc-text empty" id="excerpt-text">
                    Mulai menulis konten untuk melihat preview excerpt...
                </p>
            </div>

            <div class="field-helper" style="margin-top: 10px;">
                <span class="helper-tip">💡 Tips: Gunakan baris kosong untuk memisahkan paragraf. Excerpt otomatis diambil dari paragraf pertama.</span>
                <span class="field-counter" id="content-counter">0 / 10000</span>
            </div>
        </div>
    </div>

    <!-- ACTIONS -->
    <div class="form-actions-3d">
        <button type="submit" class="btn-save-3d" id="btn-save">
            <?= $item !== null ? '💾 Simpan Perubahan' : '🚀 Publikasikan Berita' ?>
        </button>
        <a href="<?= e(url('admin/index.php?page=berita')) ?>" class="btn-cancel-3d">
            ✖ Batal
        </a>
        <span class="form-actions-spacer"></span>
        <span class="form-tip-box">
            💡 Konten tersimpan aman di database
        </span>
    </div>
</form>
<script>
(function(){
    // ===== Helpers =====
    function formatBytes(bytes) {
        if (bytes === 0) return '0 B';
        var k = 1024, sizes = ['B', 'KB', 'MB'];
        var i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }

    function slugify(text) {
        return text.toString().toLowerCase().trim()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }

    var ALLOWED_IMG = ['image/jpeg','image/jpg','image/png','image/webp'];
    var MAX_IMG_SIZE = 2 * 1024 * 1024; // 2 MB

    // ===== Character counters =====
    function attachCounter(inputId, counterId, max) {
        var input = document.getElementById(inputId);
        var counter = document.getElementById(counterId);
        if (!input || !counter) return;
        function update() {
            var len = input.value.length;
            counter.textContent = len + ' / ' + max;
            counter.className = 'field-counter'
                + (len > max * 0.9 ? ' danger' : (len > max * 0.7 ? ' warn' : ''));
        }
        input.addEventListener('input', update);
        update();
    }
    attachCounter('f-title', 'title-counter', 200);
    attachCounter('f-content', 'content-counter', 10000);

    // ===== Slug Auto-Generator =====
    var titleInput = document.getElementById('f-title');
    var slugInput = document.getElementById('f-slug');
    var slugRegen = document.getElementById('slug-regen');
    var slugInitial = (slugInput && slugInput.value) ? slugInput.value : '';
    var slugManual = slugInitial !== '';

    function generateSlug() {
        if (!titleInput || !slugInput) return;
        if (titleInput.value.trim()) {
            slugInput.value = slugify(titleInput.value);
        }
    }

    if (titleInput && slugInput) {
        titleInput.addEventListener('blur', function() {
            if (!slugManual && titleInput.value.trim()) {
                slugInput.value = slugify(titleInput.value);
            }
        });

        slugInput.addEventListener('input', function() {
            slugManual = true;
        });
    }
    if (slugRegen) {
        slugRegen.addEventListener('click', function() {
            generateSlug();
            slugManual = false;
        });
    }

    // ===== Category preview =====
    var categorySelect = document.getElementById('f-category');
    var categoryText = document.getElementById('category-text');
    if (categorySelect && categoryText) {
        categorySelect.addEventListener('change', function() {
            var text = categorySelect.options[categorySelect.selectedIndex].text;
            categoryText.textContent = text;
        });
    }

    // ===== Status preview =====
    var statusSelect = document.getElementById('f-status');
    var statusPreview = document.getElementById('status-preview');
    var statusText = document.getElementById('status-preview-text');
    function updateStatus() {
        if (!statusSelect || !statusPreview) return;
        if (statusSelect.value === 'published') {
            statusPreview.className = 'status-preview-3d published';
            statusText.textContent = '🟢 Berita akan langsung tayang di halaman Berita';
        } else {
            statusPreview.className = 'status-preview-3d draft';
            statusText.textContent = '⚪ Berita tersimpan sebagai draft, belum tayang';
        }
    }
    if (statusSelect) {
        statusSelect.addEventListener('change', updateStatus);
        updateStatus();
    }

    // ===== Featured switch (BARU) =====
    var featuredInput = document.getElementById('f-featured');
    var featuredText = document.getElementById('featured-text');
    function updateFeatured() {
        if (!featuredInput || !featuredText) return;
        if (featuredInput.checked) {
            featuredText.textContent = '⭐ Aktif — tampil di hero slider halaman Berita publik';
        } else {
            featuredText.textContent = 'Nonaktif — tidak tampil di hero slider';
        }
    }
    if (featuredInput) {
        featuredInput.addEventListener('change', updateFeatured);
        updateFeatured();
    }

    // ===== Content Stats (Word count, char count, reading time, excerpt) =====
    var contentInput = document.getElementById('f-content');
    var statWords = document.getElementById('stat-words');
    var statChars = document.getElementById('stat-chars');
    var statReadtime = document.getElementById('stat-readtime');
    var excerptText = document.getElementById('excerpt-text');

    function updateContentStats() {
        if (!contentInput) return;
        var text = contentInput.value;
        var chars = text.length;
        var words = text.trim() ? text.trim().split(/\s+/).length : 0;
        var readMin = Math.max(1, Math.ceil(words / 200));

        if (statWords) statWords.textContent = words.toLocaleString('id-ID');
        if (statChars) statChars.textContent = chars.toLocaleString('id-ID');
        if (statReadtime) statReadtime.textContent = readMin + 'm';

        if (excerptText) {
            var paragraphs = text.split(/\n\s*\n/).filter(function(p) { return p.trim() !== ''; });
            if (paragraphs.length > 0) {
                var excerpt = paragraphs[0].replace(/\s+/g, ' ').trim();
                if (excerpt.length > 150) {
                    excerpt = excerpt.substring(0, 147) + '...';
                }
                excerptText.textContent = excerpt;
                excerptText.classList.remove('empty');
            } else {
                excerptText.textContent = 'Mulai menulis konten untuk melihat preview excerpt...';
                excerptText.classList.add('empty');
            }
        }
    }
    if (contentInput) {
        contentInput.addEventListener('input', updateContentStats);
        updateContentStats();
    }

    // ===== Image upload handling =====
    var imgInput = document.getElementById('f-thumbnail');
    var imgDropzone = document.getElementById('img-dropzone');
    var imgDzTitle = document.getElementById('img-dz-title');
    var imgPreview = document.getElementById('img-preview');
    var imgPreviewSrc = document.getElementById('img-preview-src');
    var imgPreviewName = document.getElementById('img-preview-name');
    var imgPreviewSize = document.getElementById('img-preview-size');
    var imgRemove = document.getElementById('img-remove');
    var imgWarning = document.getElementById('img-warning');
    var imgWarningText = document.getElementById('img-warning-text');

    function showImgWarning(msg) {
        if (imgWarningText) imgWarningText.textContent = msg;
        if (imgWarning) imgWarning.classList.add('show');
        if (imgDropzone) {
            imgDropzone.classList.add('has-error');
            imgDropzone.classList.remove('has-file');
        }
        if (imgPreview) imgPreview.classList.remove('show');
    }
    function clearImgWarning() {
        if (imgWarning) imgWarning.classList.remove('show');
        if (imgDropzone) imgDropzone.classList.remove('has-error');
    }

    function handleImage(file) {
        clearImgWarning();

        if (!file) {
            if (imgPreview) imgPreview.classList.remove('show');
            if (imgDropzone) imgDropzone.classList.remove('has-file');
            if (imgDzTitle) imgDzTitle.textContent = 'Klik atau Seret Gambar ke Sini';
            return;
        }

        if (ALLOWED_IMG.indexOf(file.type) === -1 && !file.name.match(/\.(jpg|jpeg|png|webp)$/i)) {
            showImgWarning('Format tidak didukung. Gunakan JPG, PNG, atau WEBP.');
            if (imgInput) imgInput.value = '';
            return;
        }

        if (file.size > MAX_IMG_SIZE) {
            showImgWarning('Gambar terlalu besar (' + formatBytes(file.size) + '). Maksimal 2 MB.');
            if (imgInput) imgInput.value = '';
            return;
        }

        var reader = new FileReader();
        reader.onload = function(e) {
            if (imgPreviewSrc) imgPreviewSrc.src = e.target.result;
            if (imgPreviewName) imgPreviewName.textContent = file.name;
            if (imgPreviewSize) imgPreviewSize.textContent = formatBytes(file.size);
            if (imgPreview) imgPreview.classList.add('show');
            if (imgDropzone) {
                imgDropzone.classList.add('has-file');
            }
            if (imgDzTitle) imgDzTitle.textContent = '🖼️ Gambar dipilih — Klik untuk ganti';
        };
        reader.readAsDataURL(file);
    }

    if (imgInput) {
        imgInput.addEventListener('change', function(e) {
            handleImage(e.target.files[0]);
        });
    }

    if (imgRemove) {
        imgRemove.addEventListener('click', function() {
            if (imgInput) imgInput.value = '';
            handleImage(null);
            clearImgWarning();
        });
    }

    // Drag & drop visual feedback
    if (imgDropzone) {
        ['dragenter','dragover'].forEach(function(evt){
            imgDropzone.addEventListener(evt, function(e){
                e.preventDefault();
                imgDropzone.classList.add('dragover');
            });
        });
        ['dragleave','drop'].forEach(function(evt){
            imgDropzone.addEventListener(evt, function(e){
                e.preventDefault();
                imgDropzone.classList.remove('dragover');
            });
        });
    }

    // ===== Submit progress =====
    var form = document.getElementById('news-form');
    var btnSave = document.getElementById('btn-save');
    if (form) {
        form.addEventListener('submit', function() {
            if (btnSave) {
                btnSave.disabled = true;
                btnSave.textContent = '⏳ Menyimpan...';
            }
        });
    }

(function(){
    var input = document.getElementById('f-tags');
    var box = document.getElementById('tags-preview');
    if (!input || !box) return;
    function render(){
        var parts = input.value.split(',').map(function(s){ return s.trim(); }).filter(Boolean).slice(0, 8);
        box.innerHTML = parts.map(function(p){
            var safe = p.replace(/[<>&"']/g, '');
            return '<span style="padding:3px 10px;border-radius:999px;font-size:11px;font-weight:700;background:rgba(5,150,105,.1);border:1px solid rgba(5,150,105,.25);color:#065f46;">#' + safe + '</span>';
        }).join('');
    }
    input.addEventListener('input', render);
    render();

})();
</script>