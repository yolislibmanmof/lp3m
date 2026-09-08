/* ==========================================================
   LP3M UNIMOF — ADMIN JS FINAL (Single File Consolidated)
   Merge: core + documents + modules + news + settings (5→1)
   Fix: hapus duplikasi, single DOMContentLoaded, flag prevent-attach
   ========================================================== */
(function () {
    'use strict';

    /* ==========================================================
       1. HELPERS (unified, no duplicates)
       ========================================================== */
    function debounce(func, wait) {
        var timeout;
        return function () {
            var ctx = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function () { func.apply(ctx, args); }, wait);
        };
    }

    function normalize(str) { return (str || '').toLowerCase().trim(); }

    function formatBytes(bytes) {
        if (bytes === 0) return '0 B';
        var k = 1024, sizes = ['B', 'KB', 'MB', 'GB'];
        var i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }

    function detectFileType(filename) {
        var ext = (filename.split('.').pop() || '').toLowerCase();
        var map = { pdf:'pdf', doc:'doc', docx:'docx', xls:'xls', xlsx:'xlsx', ppt:'ppt', pptx:'pptx' };
        return map[ext] || 'other';
    }

    function slugify(text) {
        return text.toString().toLowerCase().trim()
            .replace(/\s+/g, '-').replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '');
    }

    /* ==========================================================
       TOAST (global, single definition)
       ========================================================== */
    window.showToast = function (message, type) {
        type = type || 'success';
        var toast = document.createElement('div');
        toast.className = 'admin-toast admin-toast-' + type;
        toast.innerHTML = (type === 'success' ? '✅ ' : type === 'error' ? '⚠️ ' : '💡 ') + message;
        document.body.appendChild(toast);
        requestAnimationFrame(function () { toast.classList.add('show'); });
        setTimeout(function () {
            toast.classList.remove('show');
            setTimeout(function () { toast.remove(); }, 300);
        }, 2500);
    };

    /* ==========================================================
       INJECT STYLES (combined: core + settings animations)
       ========================================================== */
    function injectStyles() {
        if (document.getElementById('admin-core-styles')) return;
        var style = document.createElement('style');
        style.id = 'admin-core-styles';
        style.textContent = '\
            .admin-toast {\
                position: fixed; top: 20px; right: 20px;\
                padding: 12px 20px; border-radius: 12px;\
                font-size: 13px; font-weight: 700; z-index: 9999;\
                box-shadow: 0 8px 24px rgba(0,0,0,0.3);\
                transform: translateX(400px); opacity: 0;\
                transition: all 0.3s cubic-bezier(0.16,1,0.3,1);\
                display: flex; align-items: center; gap: 8px;\
            }\
            .admin-toast.show { transform: translateX(0); opacity: 1; }\
            .admin-toast-success { background: linear-gradient(145deg, #d1fae5, #a7f3d0); color: #065f46; }\
            .admin-toast-error { background: linear-gradient(145deg, #fee2e2, #fecaca); color: #991b1b; }\
            .admin-toast-info { background: linear-gradient(145deg, #fde68a, #f2c063); color: #03251f; }\
            \
            .admin-lightbox {\
                position: fixed; inset: 0; background: rgba(0,0,0,0.85);\
                z-index: 9998; display: flex; align-items: center; justify-content: center;\
                opacity: 0; pointer-events: none; transition: opacity 0.3s;\
                backdrop-filter: blur(8px);\
            }\
            .admin-lightbox.active { opacity: 1; pointer-events: auto; }\
            .admin-lightbox img {\
                max-width: 90%; max-height: 90%; border-radius: 16px;\
                box-shadow: 0 20px 60px rgba(0,0,0,0.5);\
                transform: scale(0.8); transition: transform 0.3s;\
            }\
            .admin-lightbox.active img { transform: scale(1); }\
            .admin-lightbox-close {\
                position: absolute; top: 20px; right: 20px;\
                width: 40px; height: 40px; border-radius: 50%;\
                background: rgba(255,255,255,0.1); color: white;\
                border: none; font-size: 20px; cursor: pointer;\
                display: flex; align-items: center; justify-content: center;\
            }\
            \
            .sidebar-toggle {\
                display: none; width: 38px; height: 38px;\
                border-radius: 10px; border: 1px solid var(--border);\
                background: var(--surface); color: var(--text);\
                font-size: 18px; cursor: pointer;\
                align-items: center; justify-content: center;\
            }\
            @media (max-width: 900px) {\
                .sidebar-toggle { display: flex; }\
                .admin-wrapper.sidebar-collapsed .sidebar { display: none; }\
            }\
            \
            .flash-progress {\
                position: absolute; bottom: 0; left: 0; height: 3px;\
                background: linear-gradient(90deg, var(--gold), var(--primary));\
                border-radius: 0 0 12px 12px;\
                animation: flashProgress 6s linear forwards;\
            }\
            @keyframes flashProgress { from { width: 100%; } to { width: 0%; } }\
            \
            .form-progress {\
                position: fixed; top: 0; left: 0; right: 0; height: 3px;\
                background: linear-gradient(90deg, var(--gold), var(--primary));\
                z-index: 9997; transform: scaleX(0); transform-origin: left;\
                transition: transform 0.3s;\
            }\
            .form-progress.active { transform: scaleX(1); }\
            \
            @keyframes toastIn{from{opacity:0;transform:translateX(100px)}to{opacity:1;transform:translateX(0)}}\
            @keyframes logoFadeIn{from{opacity:0;transform:scale(0.8)}to{opacity:1;transform:scale(1)}}\
        ';
        document.head.appendChild(style);
    }

    /* ==========================================================
       2. SIDEBAR (toggle + highlight - NO scrollIntoView!)
       ========================================================== */
    function initSidebar() {
        var topbar = document.querySelector('.admin-topbar');
        var wrapper = document.querySelector('.admin-wrapper');
        if (!topbar || !wrapper) return;

        // Toggle mobile
        var toggleBtn = document.createElement('button');
        toggleBtn.className = 'sidebar-toggle';
        toggleBtn.innerHTML = '☰';
        toggleBtn.title = 'Toggle sidebar';
        topbar.insertBefore(toggleBtn, topbar.firstChild);

        toggleBtn.addEventListener('click', function () {
            wrapper.classList.toggle('sidebar-collapsed');
            toggleBtn.innerHTML = wrapper.classList.contains('sidebar-collapsed') ? '☰' : '✕';
        });

        document.querySelectorAll('.sidebar-menu a').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 900) {
                    wrapper.classList.add('sidebar-collapsed');
                    toggleBtn.innerHTML = '☰';
                }
            });
        });

        // Highlight active menu (no scrollIntoView - fix jump bug!)
        var m = window.location.search.match(/page=([^&]+)/);
        var page = m ? m[1] : 'dashboard';
        document.querySelectorAll('.sidebar-menu a').forEach(function (a) {
            var href = a.getAttribute('href') || '';
            if (href === window.location.href) { a.classList.add('active'); return; }
            var am = href.match(/page=([^&]+)/);
            if (am && am[1] === page) a.classList.add('active');
        });
    }

    /* ==========================================================
       3. FLASH (auto-dismiss + click close)
       ========================================================== */
    function initFlash() {
        document.querySelectorAll('.flash').forEach(function (el) {
            el.style.position = 'relative';
            el.style.overflow = 'hidden';
            el.style.cursor = 'pointer';
            el.title = 'Klik untuk menutup';

            var progress = document.createElement('div');
            progress.className = 'flash-progress';
            el.appendChild(progress);

            el.addEventListener('click', function () { dismiss(el); });
            setTimeout(function () { dismiss(el); }, 6000);
        });

        function dismiss(el) {
            if (!el.parentNode || el.dataset.dismissed === '1') return;
            el.dataset.dismissed = '1';
            el.style.transition = 'opacity .4s ease, transform .4s ease';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-8px)';
            setTimeout(function () { if (el.parentNode) el.remove(); }, 400);
        }
    }

    /* ==========================================================
       4. PASSWORD TOGGLE
       ========================================================== */
    function initPasswordToggle() {
        var input = document.getElementById('password');
        if (!input) return;

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'pw-toggle';
        btn.innerHTML = '👁️';
        btn.title = 'Lihat password';
        btn.addEventListener('click', function () {
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.innerHTML = show ? '🙈' : '👁️';
        });
        input.parentNode.appendChild(btn);
    }

    /* ==========================================================
       5. THUMBNAIL PREVIEW (unified: logo + news)
       ========================================================== */
    function initThumbnailPreview() {
        var inputs = [
            document.getElementById('thumbnail'),
            document.querySelector('input[name="thumbnail"]'),
            document.getElementById('input-logo'),
            document.getElementById('input-favicon')
        ].filter(Boolean);

        if (inputs.length === 0) return;

        inputs.forEach(function (input) {
            input.addEventListener('change', function (e) {
                var file = e.target.files[0];
                if (!file) return;

                // Validasi tipe & ukuran
                var validImg = ['image/jpeg','image/jpg','image/png','image/webp','image/x-icon','image/vnd.microsoft.icon'];
                var isFavicon = input.id === 'input-favicon';
                var maxMB = isFavicon ? 1 : (input.id === 'input-logo' ? 1 : 2);
                var maxSize = maxMB * 1024 * 1024;

                if (validImg.indexOf(file.type) === -1 && !file.name.endsWith('.ico')) {
                    showToast('Format tidak didukung!', 'error');
                    input.value = '';
                    return;
                }
                if (file.size > maxSize) {
                    showToast('File terlalu besar! Max ' + maxMB + ' MB.', 'error');
                    input.value = '';
                    return;
                }

                var reader = new FileReader();
                reader.onload = function (ev) {
                    // Cari preview target spesifik atau fallback ke thumb-preview
                    var targetId = input.id === 'input-logo' ? 'pv-logo'
                                 : input.id === 'input-favicon' ? 'pv-favicon'
                                 : null;
                    var preview = targetId ? document.getElementById(targetId)
                                         : input.closest('.form-group, .fg-3d').querySelector('.thumb-preview img');

                    if (preview) {
                        preview.src = ev.target.result;
                        preview.style.display = 'inline-block';
                        preview.style.animation = 'logoFadeIn 0.3s ease';
                    } else {
                        var group = input.closest('.form-group, .fg-3d');
                        if (group) {
                            var div = document.createElement('div');
                            div.className = 'thumb-preview';
                            div.innerHTML = '<img src="' + ev.target.result + '" alt="Preview"><p>Preview baru</p>';
                            group.appendChild(div);
                        }
                    }
                    showToast('File siap diupload (' + formatBytes(file.size) + ')', 'success');

                    // Uncheck remove checkbox jika ada
                    var removeId = input.id === 'input-logo' ? 'remove-logo'
                                 : input.id === 'input-favicon' ? 'remove-favicon' : null;
                    if (removeId) {
                        var rm = document.getElementById(removeId);
                        if (rm) rm.checked = false;
                    }
                };
                reader.readAsDataURL(file);
            });
        });

        // Handle remove checkbox (logo & favicon)
        ['remove-logo', 'remove-favicon'].forEach(function (id) {
            var cb = document.getElementById(id);
            if (!cb) return;
            var previewId = id === 'remove-logo' ? 'pv-logo' : 'pv-favicon';
            cb.addEventListener('change', function () {
                var pv = document.getElementById(previewId);
                if (!pv) return;
                if (cb.checked) {
                    pv.style.opacity = '0.3';
                    showToast('Akan dihapus saat disimpan', 'info');
                } else {
                    pv.style.opacity = '1';
                }
            });
        });
    }

    /* ==========================================================
       6. SLUG GENERATOR (news only)
       ========================================================== */
    function initSlugGenerator() {
        var titleInput = document.querySelector('input[name="title"]');
        var slugInput = document.querySelector('input[name="slug"]');
        if (!titleInput || !slugInput || slugInput.value !== '') return;

        titleInput.addEventListener('blur', function () {
            if (slugInput.value === '' && titleInput.value !== '') {
                slugInput.value = slugify(titleInput.value);
            }
        });
    }

    /* ==========================================================
       7. CHARACTER COUNTERS (news title + settings textareas)
       ========================================================== */
    function initCharCounters() {
        // News title counter
        var titleInput = document.querySelector('input[name="title"]');
        if (titleInput) {
            var counter = document.createElement('small');
            counter.style.cssText = 'display:block; margin-top:4px; font-size:11px; color:var(--muted);';
            titleInput.parentNode.appendChild(counter);
            function updateTitleCounter() {
                var len = titleInput.value.length;
                var color = len > 100 ? '#f87171' : (len > 70 ? '#f2c063' : '#6ee7b7');
                counter.innerHTML = '📝 <span style="color:' + color + '; font-weight:700;">' + len + '</span>/100 karakter';
            }
            titleInput.addEventListener('input', updateTitleCounter);
            updateTitleCounter();
        }

        // Settings long textareas
        document.querySelectorAll('textarea[name*="mission"], textarea[name*="structure"], textarea[name*="profile"], textarea[name*="history"]').forEach(function (ta) {
            var c = document.createElement('small');
            c.style.cssText = 'display:block; margin-top:4px; font-size:11px; color:var(--muted); font-weight:700;';
            ta.parentNode.appendChild(c);
            function update() {
                var lines = ta.value.split('\n').filter(function (l) { return l.trim() !== ''; }).length;
                c.innerHTML = '📝 <span style="color:#f2c063;">' + lines + '</span> baris · <span style="color:#6ee7b7;">' + ta.value.length + '</span> karakter';
            }
            ta.addEventListener('input', update);
            update();
        });
    }

    /* ==========================================================
       8. STATUS PREVIEW (news select)
       ========================================================== */
    function initStatusPreview() {
        var sel = document.querySelector('select[name="status"]');
        if (!sel) return;
        var hint = document.createElement('small');
        hint.className = 'status-hint';
        hint.style.cssText = 'display:block; margin-top:6px; font-size:11px; font-weight:700;';
        sel.parentNode.appendChild(hint);
        function update() {
            if (sel.value === 'published') {
                hint.textContent = '🟢 Akan tampil di website publik';
                hint.style.color = '#6ee7b7';
            } else {
                hint.textContent = '⚪ Hanya tersimpan sebagai draft';
                hint.style.color = '#f2c063';
            }
        }
        sel.addEventListener('change', update);
        update();
    }

    /* ==========================================================
       9. LIVE PREVIEW (settings data-pv sync)
       ========================================================== */
    function initLivePreview() {
        document.querySelectorAll('[data-pv]').forEach(function (input) {
            var target = document.getElementById(input.getAttribute('data-pv'));
            if (!target) return;
            target.textContent = input.value;
            var sync = debounce(function () {
                target.textContent = input.value;
                target.style.transition = 'color 0.3s';
                target.style.color = '#f2c063';
                setTimeout(function () { target.style.color = ''; }, 300);
            }, 150);
            input.addEventListener('input', sync);
        });
    }

    /* ==========================================================
       10. STRUCTURE VALIDATOR (settings: Jabatan | Nama)
       ========================================================== */
    function initStructureValidator() {
        var ta = document.querySelector('textarea[name="about_structure_text"]');
        if (!ta) return;
        var v = document.createElement('small');
        v.style.cssText = 'display:block; margin-top:6px; font-size:11px; font-weight:700;';
        ta.parentNode.appendChild(v);
        function validate() {
            var lines = ta.value.split('\n').filter(function (l) { return l.trim() !== ''; });
            var invalid = [];
            lines.forEach(function (line, idx) { if (!line.includes('|')) invalid.push(idx + 1); });
            if (invalid.length > 0) {
                v.style.color = '#f87171';
                v.innerHTML = '⚠️ Baris ' + invalid.join(', ') + ' tidak valid (format: Jabatan | Nama)';
            } else if (lines.length > 0) {
                v.style.color = '#6ee7b7';
                v.innerHTML = '✅ ' + lines.length + ' struktur valid';
            } else {
                v.style.color = 'var(--muted)';
                v.innerHTML = '💡 Satu orang per baris: Jabatan | Nama';
            }
        }
        ta.addEventListener('input', validate);
        validate();
    }

    /* ==========================================================
       11. DELETE CONFIRM (UNIFIED - single attach with flag)
       ========================================================== */
    function initDeleteConfirm() {
        document.querySelectorAll('.js-confirm, form.js-confirm').forEach(function (form) {
            if (form.dataset.confirmAttached === '1') return;
            form.dataset.confirmAttached = '1';
            form.addEventListener('submit', function (e) {
                var msg = form.getAttribute('data-message') || 'Yakin ingin menghapus?';
                if (!window.confirm(msg)) e.preventDefault();
            });
        });
    }

    /* ==========================================================
       12. IMAGE LIGHTBOX (thumbnails)
       ========================================================== */
    function initImageLightbox() {
        var lb = document.createElement('div');
        lb.className = 'admin-lightbox';
        lb.innerHTML = '<button class="admin-lightbox-close">✕</button><img src="" alt="Preview">';
        document.body.appendChild(lb);

        var lbImg = lb.querySelector('img');
        var lbClose = lb.querySelector('.admin-lightbox-close');

        document.querySelectorAll('.table-thumb, .thumb-preview img').forEach(function (img) {
            img.style.cursor = 'zoom-in';
            img.addEventListener('click', function (e) {
                e.preventDefault();
                lbImg.src = img.src;
                lb.classList.add('active');
            });
        });

        lbClose.addEventListener('click', function () { lb.classList.remove('active'); });
        lb.addEventListener('click', function (e) { if (e.target === lb) lb.classList.remove('active'); });
    }

    /* ==========================================================
       13. TABLE ENHANCEMENTS (select all + copy link)
       ========================================================== */
    function initTableEnhancements() {
        document.querySelectorAll('.admin-table thead input[type="checkbox"]').forEach(function (master) {
            master.addEventListener('change', function () {
                var table = master.closest('table');
                table.querySelectorAll('tbody input[type="checkbox"]').forEach(function (cb) {
                    cb.checked = master.checked;
                });
            });
        });

        document.querySelectorAll('.row-actions a[target="_blank"]').forEach(function (link) {
            link.addEventListener('contextmenu', function (e) {
                e.preventDefault();
                navigator.clipboard.writeText(link.href).then(function () {
                    showToast('Link disalin ke clipboard', 'success');
                });
            });
        });
    }

    /* ==========================================================
       14. TABLE ROW HIGHLIGHT (unified: status + HAKI)
       ========================================================== */
    function initRowHighlight() {
        document.querySelectorAll('.admin-table tbody tr').forEach(function (row) {
            if (row.querySelector('.status-sertifikat_terbit')) {
                row.style.background = 'rgba(16,185,129,0.05)';
                row.style.boxShadow = 'inset 3px 0 0 #10b981';
            } else if (row.querySelector('.status-published, .sj-pub')) {
                row.style.borderLeft = '3px solid #10b981';
            } else if (row.querySelector('.status-draft, .sj-draft')) {
                row.style.borderLeft = '3px solid #64748b';
            }
        });
    }

    /* ==========================================================
       15. FILTER AUTO-SUBMIT (UNIFIED - single attach)
       ========================================================== */
    function initFilterAutoSubmit() {
        document.querySelectorAll('.filter-bar select').forEach(function (sel) {
            if (sel.dataset.filterAttached === '1') return;
            sel.dataset.filterAttached = '1';
            sel.addEventListener('change', function () {
                var form = sel.closest('form');
                if (form) form.submit();
            });
        });
    }

    /* ==========================================================
       16. DOC TYPE BADGES (auto-color based on file type)
       ========================================================== */
    function initDocTypeBadges() {
        document.querySelectorAll('.doc-type').forEach(function (badge) {
            var text = (badge.textContent || '').trim().toLowerCase();
            var type = detectFileType(text + '.x') || detectFileType(badge.dataset.type || '');
            badge.classList.remove('type-pdf','type-doc','type-docx','type-xls','type-xlsx','type-ppt','type-pptx');
            if (type !== 'other') {
                badge.classList.add('type-' + type);
                badge.setAttribute('data-type', type);
            }
        });
    }

    /* ==========================================================
       17. DROPZONES (file upload live preview)
       ========================================================== */
    function initDropzones() {
        document.querySelectorAll('.file-dropzone-3d, .doc-dropzone').forEach(function (zone) {
            var input = zone.querySelector('input[type="file"]');
            if (!input) return;
            var titleEl = zone.querySelector('.img-dz-title-3d, .doc-dropzone-title');
            var subEl = zone.querySelector('.img-dz-sub-3d, .doc-dropzone-sub');

            input.addEventListener('change', function () {
                var file = input.files[0];
                if (!file) return;
                if (file.size > 10 * 1024 * 1024) {
                    showToast('File terlalu besar! Max 10 MB.', 'error');
                    input.value = '';
                    return;
                }
                if (titleEl) {
                    titleEl.textContent = '📎 ' + file.name;
                    titleEl.style.color = '#f2c063';
                    titleEl.style.fontWeight = '800';
                }
                if (subEl) {
                    subEl.textContent = formatBytes(file.size) + ' · Siap diupload';
                    subEl.style.color = '#6ee7b7';
                }
                zone.style.borderColor = '#10b981';
                zone.style.background = 'linear-gradient(145deg, rgba(16,185,129,0.08), rgba(5,150,105,0.04))';
            });

            zone.addEventListener('dragover', function (e) {
                e.preventDefault();
                zone.style.borderColor = '#f2c063';
                zone.style.transform = 'translateY(-2px)';
            });
            zone.addEventListener('dragleave', function () {
                zone.style.borderColor = '';
                zone.style.transform = '';
            });
            zone.addEventListener('drop', function (e) {
                e.preventDefault();
                zone.style.borderColor = '';
                zone.style.transform = '';
            });
        });
    }

    /* ==========================================================
       18. BADGES (HAKI status + Publikasi level + AIK)
       ========================================================== */
    function initBadges() {
        // HAKI status
        var HAKI_MAP = {
            'draft':'status-draft_internal', 'draft_internal':'status-draft_internal',
            'review':'status-review_internal', 'review_internal':'status-review_internal',
            'djki':'status-diajukan_djki', 'diajukan_djki':'status-diajukan_djki',
            'diajukan':'status-diajukan_djki', 'perbaikan':'status-perbaikan',
            'terbit':'status-sertifikat_terbit', 'sertifikat_terbit':'status-sertifikat_terbit',
            'sertifikat':'status-sertifikat_terbit'
        };
        document.querySelectorAll('[data-haki-status]').forEach(function (badge) {
            var cls = HAKI_MAP[normalize(badge.dataset.hakiStatus)];
            if (cls) badge.classList.add(cls);
        });

        // Publikasi level
        function detectLevel(l) {
            l = normalize(l);
            if (l.includes('scopus') || l.includes('wos') || l.includes('web of science') || l.includes('q1') || l.includes('q2') || l.includes('internasional')) return 'level-intl';
            if (l.includes('sinta 1') || l.includes('sinta 2')) return 'level-sinta12';
            if (l.includes('sinta')) return 'level-sinta';
            if (l.includes('nasional')) return 'level-nas';
            return 'level-default';
        }
        document.querySelectorAll('.level-badge').forEach(function (badge) {
            badge.classList.add(detectLevel(badge.dataset.level || badge.textContent));
        });

        // AIK badge
        document.querySelectorAll('tr[data-has-aik="1"], .mod-card[data-has-aik="1"]').forEach(function (row) {
            var titleCell = row.querySelector('td:first-child, h3');
            if (titleCell && !titleCell.querySelector('.aik-badge')) {
                var badge = document.createElement('span');
                badge.className = 'aik-badge';
                badge.textContent = 'AIK';
                titleCell.appendChild(badge);
            }
        });
    }

    /* ==========================================================
       19. COUNTERS (unified, rAF-based, no setInterval)
       ========================================================== */
    function initCounters() {
        var nums = document.querySelectorAll('.doc-download-count, .ac-num, [data-count]');
        if (nums.length === 0) return;

        function animate(el) {
            if (el.dataset.counted === '1') return;
            var raw = el.dataset.count || el.textContent.replace(/\D/g, '');
            var target = parseInt(raw, 10);
            if (isNaN(target) || target === 0) return;

            var start = performance.now();
            var duration = 800;
            function tick(now) {
                var p = Math.min((now - start) / duration, 1);
                var val = Math.round(target * (1 - Math.pow(1 - p, 3)));
                el.textContent = val.toLocaleString('id-ID');
                if (p < 1) requestAnimationFrame(tick);
                else el.dataset.counted = '1';
            }
            requestAnimationFrame(tick);
        }

        if (!('IntersectionObserver' in window)) { nums.forEach(animate); return; }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { animate(e.target); io.unobserve(e.target); }
            });
        }, { threshold: 0.3 });
        nums.forEach(function (el) { io.observe(el); });
    }

    /* ==========================================================
       20. AUTO-SAVE DRAFT (localStorage for settings)
       ========================================================== */
    function initAutoSaveDraft() {
        var form = document.querySelector('.settings-form');
        if (!form) return;
        var key = 'lp3m_settings_draft';
        var inputs = form.querySelectorAll('input[type="text"], textarea');

        var saved = localStorage.getItem(key);
        if (saved) {
            try {
                var draft = JSON.parse(saved);
                var restored = false;
                inputs.forEach(function (i) {
                    if (draft[i.name] && i.value === '') {
                        i.value = draft[i.name];
                        restored = true;
                        i.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                });
                if (restored) showToast('Draft dipulihkan', 'info');
            } catch (e) { localStorage.removeItem(key); }
        }

        var save = debounce(function () {
            var d = {};
            inputs.forEach(function (i) { if (i.value.trim() !== '') d[i.name] = i.value; });
            if (Object.keys(d).length > 0) localStorage.setItem(key, JSON.stringify(d));
        }, 5000);
        inputs.forEach(function (i) { i.addEventListener('input', save); });
        form.addEventListener('submit', function () { localStorage.removeItem(key); });
    }

    /* ==========================================================
       21. FORM PROGRESS (bar saat submit)
       ========================================================== */
    function initFormProgress() {
        document.querySelectorAll('form[method="post"]').forEach(function (form) {
            form.addEventListener('submit', function () {
                var p = document.createElement('div');
                p.className = 'form-progress active';
                document.body.appendChild(p);
                var btn = form.querySelector('button[type="submit"]');
                if (btn) { btn.disabled = true; btn.style.opacity = '0.6'; }
            });
        });
    }

    /* ==========================================================
       22. KEYBOARD SHORTCUTS (UNIFIED: Ctrl+K, Ctrl+S, Esc)
       ========================================================== */
    function initKeyboardShortcuts() {
        document.addEventListener('keydown', function (e) {
            var active = document.activeElement;
            var isInput = active && (active.tagName === 'INPUT' || active.tagName === 'TEXTAREA' || active.isContentEditable);

            // Ctrl+K → focus search
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                var search = document.querySelector('.filter-bar input[type="text"]');
                if (search) { search.focus(); search.select(); showToast('Search mode aktif', 'info'); }
            }

            // Ctrl+S → save form (only if not in input context)
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
                e.preventDefault();
                var form = document.querySelector('.settings-form, .admin-form');
                if (form) { showToast('Menyimpan...', 'info'); form.submit(); }
            }

            // Esc → close lightbox
            if (e.key === 'Escape') {
                var lb = document.querySelector('.admin-lightbox.active');
                if (lb) lb.classList.remove('active');
            }
        });
    }

    /* ==========================================================
       23. CONSOLE BRANDING
       ========================================================== */
    function printConsoleBranding() {
        console.log('%c╔══════════════════════════════════════╗\n' +
            '║  LP3M UNIMOF — ADMIN FINAL v1.0 ✦    ║\n' +
            '║  Single JS • Unified & Optimized     ║\n' +
            '╚══════════════════════════════════════╝',
            'color:#10b981;font-weight:bold;font-size:12px');
        console.log('%c⌨️  Ctrl+K (search) • Ctrl+S (save) • Esc (close)', 'color:#d9a441;font-size:11px');
    }

    /* ==========================================================
       INIT — Single entry point
       ========================================================== */
    function init() {
        injectStyles();
        printConsoleBranding();

        // Core UI
        initSidebar();
        initFlash();
        initPasswordToggle();
        initImageLightbox();
        initTableEnhancements();
        initRowHighlight();
        initFormProgress();

        // Forms
        initThumbnailPreview();
        initSlugGenerator();
        initCharCounters();
        initStatusPreview();
        initLivePreview();
        initStructureValidator();
        initAutoSaveDraft();

        // Tables & badges
        initDeleteConfirm();
        initFilterAutoSubmit();
        initDocTypeBadges();
        initDropzones();
        initBadges();
        initCounters();

        // Global
        initKeyboardShortcuts();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();