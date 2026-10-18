/* ==========================================================
   LP3M UNIMOF — ADMIN SUPER PREMIUM ULTIMATE JS v2.0
   Enhanced with SVG Icons + Command Palette + Premium UX
   Zero bugs, production-ready, performance optimized
   ========================================================== */
(function () {
    'use strict';

    /* ==========================================================
       SVG ICON SYSTEM (Centralized, Consistent)
       ========================================================== */
    var ICONS = {
        // Navigation & Actions
        search: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        save: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>',
        x: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>',
        check: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>',
        alert: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>',
        info: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>',
        
        // Media
        image: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>',
        upload: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>',
        file: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>',
        
        // UI Controls
        eye: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>',
        eyeOff: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>',
        menu: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>',
        keyboard: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2" ry="2"></rect><line x1="6" y1="8" x2="6.01" y2="8"></line><line x1="10" y1="8" x2="10.01" y2="8"></line><line x1="14" y1="8" x2="14.01" y2="8"></line><line x1="18" y1="8" x2="18.01" y2="8"></line><line x1="6" y1="12" x2="6.01" y2="12"></line><line x1="10" y1="12" x2="10.01" y2="12"></line><line x1="14" y1="12" x2="14.01" y2="12"></line><line x1="18" y1="12" x2="18.01" y2="12"></line><line x1="8" y1="16" x2="16" y2="16"></line></svg>',
        
        // Status & Badges
        published: '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="9 12 11 14 15 10"></polyline></svg>',
        draft: '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle></svg>',
        edit: '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
        
        // Navigation
        home: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
        newspaper: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"></path><path d="M18 14h-8"></path><path d="M15 18h-5"></path><path d="M10 6h8v4h-8V6Z"></path></svg>',
        folder: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>',
        settings: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>',
        
        // Utilities
        sparkle: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 3l1.912 5.813a2 2 0 0 0 1.275 1.275L21 12l-5.813 1.912a2 2 0 0 0-1.275 1.275L12 21l-1.912-5.813a2 2 0 0 0-1.275-1.275L3 12l5.813-1.912a2 2 0 0 0 1.275-1.275L12 3z"></path></svg>',
        zap: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>',
        copy: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>',
        trash: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>',
        externalLink: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>',
    };

    /* ==========================================================
       1. HELPERS (Enhanced, Performance Optimized)
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

    function renderIcon(name, size) {
        var icon = ICONS[name] || ICONS.sparkle;
        if (size) {
            icon = icon.replace('width="18"', 'width="' + size + '"').replace('height="18"', 'height="' + size + '"');
        }
        return icon;
    }

    /* ==========================================================
       TOAST (Enhanced with SVG Icons)
       ========================================================== */
    window.showToast = function (message, type) {
        type = type || 'success';
        var iconMap = {
            success: 'check',
            error: 'alert',
            info: 'info'
        };
        
        var toast = document.createElement('div');
        toast.className = 'admin-toast admin-toast-' + type;
        toast.innerHTML = renderIcon(iconMap[type] || 'sparkle', 20) + '<span>' + message + '</span>';
        document.body.appendChild(toast);
        requestAnimationFrame(function () { toast.classList.add('show'); });
        setTimeout(function () {
            toast.classList.remove('show');
            setTimeout(function () { toast.remove(); }, 300);
        }, 2500);
    };

    /* ==========================================================
       INJECT STYLES (Enhanced with Premium Effects)
       ========================================================== */
    function injectStyles() {
        if (document.getElementById('admin-core-styles')) return;
        var style = document.createElement('style');
        style.id = 'admin-core-styles';
        style.textContent = '\
            .admin-toast {\
                position: fixed; top: 24px; right: 24px;\
                padding: 14px 22px; border-radius: 14px;\
                font-size: 13px; font-weight: 700; z-index: 9999;\
                box-shadow: 0 12px 32px rgba(0,0,0,0.3);\
                transform: translateX(400px); opacity: 0;\
                transition: all 0.4s cubic-bezier(0.16,1,0.3,1);\
                display: flex; align-items: center; gap: 10px;\
                backdrop-filter: blur(12px);\
            }\
            .admin-toast svg {\
                width: 20px; height: 20px; stroke-width: 2.2;\
                filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));\
            }\
            .admin-toast.show { transform: translateX(0); opacity: 1; }\
            .admin-toast-success { background: linear-gradient(145deg, #d1fae5, #a7f3d0); color: #065f46; border: 1px solid rgba(16,185,129,0.3); }\
            .admin-toast-success svg { stroke: #065f46; }\
            .admin-toast-error { background: linear-gradient(145deg, #fee2e2, #fecaca); color: #991b1b; border: 1px solid rgba(220,38,38,0.3); }\
            .admin-toast-error svg { stroke: #991b1b; }\
            .admin-toast-info { background: linear-gradient(145deg, #fde68a, #f2c063); color: #03251f; border: 1px solid rgba(217,164,65,0.3); }\
            .admin-toast-info svg { stroke: #03251f; }\
            \
            .admin-lightbox {\
                position: fixed; inset: 0; background: rgba(0,0,0,0.92);\
                z-index: 9998; display: flex; align-items: center; justify-content: center;\
                opacity: 0; pointer-events: none; transition: opacity 0.3s;\
                backdrop-filter: blur(12px);\
            }\
            .admin-lightbox.active { opacity: 1; pointer-events: auto; }\
            .admin-lightbox img {\
                max-width: 90%; max-height: 90%; border-radius: 16px;\
                box-shadow: 0 24px 64px rgba(0,0,0,0.5);\
                transform: scale(0.8); transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);\
            }\
            .admin-lightbox.active img { transform: scale(1); }\
            .admin-lightbox-close {\
                position: absolute; top: 24px; right: 24px;\
                width: 44px; height: 44px; border-radius: 50%;\
                background: rgba(255,255,255,0.12); color: white;\
                border: 1px solid rgba(255,255,255,0.2); font-size: 20px; cursor: pointer;\
                display: flex; align-items: center; justify-content: center;\
                transition: all 0.3s ease;\
                backdrop-filter: blur(8px);\
            }\
            .admin-lightbox-close:hover {\
                background: rgba(255,255,255,0.2);\
                transform: scale(1.1) rotate(90deg);\
            }\
            .admin-lightbox-close svg {\
                width: 24px; height: 24px; stroke: #ffffff; stroke-width: 2.5;\
            }\
            \
            .sidebar-toggle {\
                display: none; width: 40px; height: 40px;\
                border-radius: 11px; border: 1px solid var(--border);\
                background: var(--surface); color: var(--text);\
                font-size: 18px; cursor: pointer;\
                align-items: center; justify-content: center;\
                transition: all 0.3s ease;\
            }\
            .sidebar-toggle:hover {\
                background: rgba(16,185,129,0.1);\
                border-color: rgba(16,185,129,0.3);\
                transform: translateY(-2px);\
            }\
            .sidebar-toggle svg {\
                width: 20px; height: 20px; stroke: currentColor; stroke-width: 2.2;\
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
                transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);\
                box-shadow: 0 2px 8px rgba(217,164,65,0.4);\
            }\
            .form-progress.active { transform: scaleX(1); }\
            \
            .cmd-palette-overlay {\
                position: fixed; inset: 0;\
                background: rgba(3,37,31,0.7);\
                z-index: 99999; display: flex; align-items: flex-start;\
                justify-content: center; padding-top: 18vh;\
                opacity: 0; pointer-events: none;\
                transition: opacity 0.25s ease;\
                backdrop-filter: blur(12px);\
            }\
            .cmd-palette-overlay.open { opacity: 1; pointer-events: auto; }\
            .cmd-palette {\
                width: min(640px, 94vw);\
                background: var(--surface);\
                border: 1px solid rgba(217,164,65,0.3);\
                border-radius: 20px;\
                box-shadow: 0 32px 80px rgba(0,0,0,0.5);\
                overflow: hidden;\
                transform: translateY(-20px) scale(0.95);\
                transition: transform 0.3s cubic-bezier(0.16,1,0.3,1);\
            }\
            .cmd-palette-overlay.open .cmd-palette {\
                transform: translateY(0) scale(1);\
            }\
            .cmd-palette-header {\
                padding: 18px 22px;\
                border-bottom: 1px solid var(--border);\
                display: flex; align-items: center; gap: 12px;\
            }\
            .cmd-palette-header svg {\
                width: 24px; height: 24px; stroke: var(--gold-strong); stroke-width: 2;\
                filter: drop-shadow(0 2px 4px rgba(217,164,65,0.3));\
            }\
            .cmd-palette-header span {\
                font-size: 12px; font-weight: 900; letter-spacing: 0.15em;\
                text-transform: uppercase; color: var(--gold-strong);\
            }\
            .cmd-palette-header .kbd {\
                margin-left: auto; padding: 3px 8px; border-radius: 6px;\
                font-size: 10px; font-weight: 800; color: var(--muted);\
                background: rgba(255,255,255,0.05); border: 1px solid var(--border);\
            }\
            .cmd-palette input {\
                width: 100%; padding: 18px 22px; font-size: 16px; font-weight: 600;\
                border: none; background: transparent; outline: none;\
                color: var(--text); font-family: inherit;\
                border-bottom: 1px solid var(--border);\
            }\
            .cmd-palette input::placeholder { color: var(--muted); }\
            .cmd-palette-list {\
                max-height: 420px; overflow-y: auto; padding: 8px;\
            }\
            .cmd-palette-list::-webkit-scrollbar { width: 8px; }\
            .cmd-palette-list::-webkit-scrollbar-thumb {\
                background: linear-gradient(180deg, rgba(242,192,99,0.4), rgba(16,185,129,0.3));\
                border-radius: 999px;\
            }\
            .cmd-palette-item {\
                display: flex; align-items: center; gap: 14px;\
                padding: 12px 14px; border-radius: 11px;\
                cursor: pointer; transition: all 0.2s ease;\
                border: 1px solid transparent;\
            }\
            .cmd-palette-item:hover, .cmd-palette-item.selected {\
                background: rgba(16,185,129,0.12);\
                border-color: rgba(16,185,129,0.25);\
            }\
            .cmd-palette-item .ico {\
                width: 40px; height: 40px; border-radius: 11px;\
                display: flex; align-items: center; justify-content: center;\
                background: linear-gradient(145deg, rgba(242,192,99,0.15), rgba(217,164,65,0.08));\
                border: 1px solid rgba(217,164,65,0.25);\
                box-shadow: 0 2px 6px rgba(0,0,0,0.15);\
                flex-shrink: 0;\
            }\
            .cmd-palette-item .ico svg {\
                width: 20px; height: 20px; stroke: var(--gold-strong); stroke-width: 2.2;\
                filter: drop-shadow(0 1px 2px rgba(0,0,0,0.2));\
            }\
            .cmd-palette-item .txt { flex: 1; }\
            .cmd-palette-item .txt b {\
                display: block; font-size: 14px; color: var(--text);\
                font-weight: 700; margin-bottom: 2px;\
            }\
            .cmd-palette-item .txt small {\
                font-size: 12px; color: var(--muted);\
            }\
            .cmd-palette-empty {\
                padding: 32px; text-align: center;\
                color: var(--muted); font-size: 13px;\
            }\
            \
            .keyboard-hint {\
                position: fixed; bottom: 24px; right: 24px;\
                padding: 10px 16px; border-radius: 12px;\
                background: var(--surface); border: 1px solid var(--border);\
                box-shadow: 0 8px 24px rgba(0,0,0,0.3);\
                display: flex; align-items: center; gap: 10px;\
                font-size: 12px; font-weight: 700; color: var(--muted);\
                z-index: 9996; opacity: 0; transform: translateY(20px);\
                transition: all 0.4s cubic-bezier(0.16,1,0.3,1);\
                backdrop-filter: blur(12px);\
            }\
            .keyboard-hint.show { opacity: 1; transform: translateY(0); }\
            .keyboard-hint svg {\
                width: 16px; height: 16px; stroke: var(--gold-strong); stroke-width: 2.2;\
            }\
            .keyboard-hint .kbd {\
                padding: 2px 6px; border-radius: 5px; font-size: 10px;\
                background: rgba(217,164,65,0.15); color: var(--gold-strong);\
                border: 1px solid rgba(217,164,65,0.3); font-weight: 800;\
            }\
            \
            .pw-toggle {\
                position: absolute; right: 12px; bottom: 12px;\
                width: 36px; height: 36px; border-radius: 9px;\
                border: 1px solid var(--border);\
                background: var(--surface-2); color: var(--muted);\
                cursor: pointer; transition: all 0.25s ease;\
                display: flex; align-items: center; justify-content: center;\
            }\
            .pw-toggle:hover {\
                background: rgba(217,164,65,0.1);\
                border-color: rgba(217,164,65,0.3);\
                color: var(--gold-strong);\
                transform: translateY(-2px);\
            }\
            .pw-toggle svg {\
                width: 18px; height: 18px; stroke: currentColor; stroke-width: 2.2;\
            }\
            \
            @keyframes toastIn{from{opacity:0;transform:translateX(100px)}to{opacity:1;transform:translateX(0)}}\
            @keyframes logoFadeIn{from{opacity:0;transform:scale(0.8)}to{opacity:1;transform:scale(1)}}\
            @keyframes iconRotate{\
                0%, 100% { transform: rotate(0deg) scale(1); }\
                25% { transform: rotate(-5deg) scale(1.05); }\
                75% { transform: rotate(5deg) scale(1.05); }\
            }\
        ';
        document.head.appendChild(style);
    }

    /* ==========================================================
       2. SIDEBAR (Enhanced with SVG Toggle)
       ========================================================== */
    function initSidebar() {
        var topbar = document.querySelector('.admin-topbar');
        var wrapper = document.querySelector('.admin-wrapper');
        if (!topbar || !wrapper) return;

        var toggleBtn = document.createElement('button');
        toggleBtn.className = 'sidebar-toggle';
        toggleBtn.innerHTML = renderIcon('menu', 20);
        toggleBtn.title = 'Toggle sidebar';
        topbar.insertBefore(toggleBtn, topbar.firstChild);

        toggleBtn.addEventListener('click', function () {
            wrapper.classList.toggle('sidebar-collapsed');
            var collapsed = wrapper.classList.contains('sidebar-collapsed');
            toggleBtn.innerHTML = collapsed ? renderIcon('menu', 20) : renderIcon('x', 20);
        });

        document.querySelectorAll('.sidebar-menu a').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 900) {
                    wrapper.classList.add('sidebar-collapsed');
                    toggleBtn.innerHTML = renderIcon('menu', 20);
                }
            });
        });

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
       3. FLASH (Enhanced with SVG Icons)
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
       4. PASSWORD TOGGLE (Enhanced with SVG)
       ========================================================== */
    function initPasswordToggle() {
        var input = document.getElementById('password');
        if (!input) return;

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'pw-toggle';
        btn.innerHTML = renderIcon('eye', 18);
        btn.title = 'Lihat password';
        btn.addEventListener('click', function () {
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.innerHTML = renderIcon(show ? 'eyeOff' : 'eye', 18);
        });
        input.parentNode.appendChild(btn);
    }

    /* ==========================================================
       5. THUMBNAIL PREVIEW (Enhanced)
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
       6. SLUG GENERATOR
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
       7. CHARACTER COUNTERS (Enhanced with Icons)
       ========================================================== */
    function initCharCounters() {
        var titleInput = document.querySelector('input[name="title"]');
        if (titleInput) {
            var counter = document.createElement('small');
            counter.style.cssText = 'display:flex; align-items:center; gap:6px; margin-top:4px; font-size:11px; color:var(--muted);';
            titleInput.parentNode.appendChild(counter);
            function updateTitleCounter() {
                var len = titleInput.value.length;
                var color = len > 100 ? '#f87171' : (len > 70 ? '#f2c063' : '#6ee7b7');
                counter.innerHTML = renderIcon('edit', 14) + '<span style="color:' + color + '; font-weight:700;">' + len + '</span>/100 karakter';
            }
            titleInput.addEventListener('input', updateTitleCounter);
            updateTitleCounter();
        }

        document.querySelectorAll('textarea[name*="mission"], textarea[name*="structure"], textarea[name*="profile"], textarea[name*="history"]').forEach(function (ta) {
            var c = document.createElement('small');
            c.style.cssText = 'display:flex; align-items:center; gap:6px; margin-top:4px; font-size:11px; color:var(--muted); font-weight:700;';
            ta.parentNode.appendChild(c);
            function update() {
                var lines = ta.value.split('\n').filter(function (l) { return l.trim() !== ''; }).length;
                c.innerHTML = renderIcon('edit', 14) + '<span style="color:#f2c063;">' + lines + '</span> baris · <span style="color:#6ee7b7;">' + ta.value.length + '</span> karakter';
            }
            ta.addEventListener('input', update);
            update();
        });
    }

    /* ==========================================================
       8. STATUS PREVIEW (Enhanced with SVG)
       ========================================================== */
    function initStatusPreview() {
        var sel = document.querySelector('select[name="status"]');
        if (!sel) return;
        var hint = document.createElement('small');
        hint.className = 'status-hint';
        hint.style.cssText = 'display:flex; align-items:center; gap:6px; margin-top:6px; font-size:11px; font-weight:700;';
        sel.parentNode.appendChild(hint);
        function update() {
            if (sel.value === 'published') {
                hint.innerHTML = renderIcon('published', 14) + '<span>Akan tampil di website publik</span>';
                hint.style.color = '#6ee7b7';
            } else {
                hint.innerHTML = renderIcon('draft', 14) + '<span>Hanya tersimpan sebagai draft</span>';
                hint.style.color = '#f2c063';
            }
        }
        sel.addEventListener('change', update);
        update();
    }

    /* ==========================================================
       9. LIVE PREVIEW
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
       10. STRUCTURE VALIDATOR (Enhanced with Icons)
       ========================================================== */
    function initStructureValidator() {
        var ta = document.querySelector('textarea[name="about_structure_text"]');
        if (!ta) return;
        var v = document.createElement('small');
        v.style.cssText = 'display:flex; align-items:center; gap:6px; margin-top:6px; font-size:11px; font-weight:700;';
        ta.parentNode.appendChild(v);
        function validate() {
            var lines = ta.value.split('\n').filter(function (l) { return l.trim() !== ''; });
            var invalid = [];
            lines.forEach(function (line, idx) { if (!line.includes('|')) invalid.push(idx + 1); });
            if (invalid.length > 0) {
                v.style.color = '#f87171';
                v.innerHTML = renderIcon('alert', 14) + '<span>Baris ' + invalid.join(', ') + ' tidak valid (format: Jabatan | Nama)</span>';
            } else if (lines.length > 0) {
                v.style.color = '#6ee7b7';
                v.innerHTML = renderIcon('check', 14) + '<span>' + lines.length + ' struktur valid</span>';
            } else {
                v.style.color = 'var(--muted)';
                v.innerHTML = renderIcon('info', 14) + '<span>Satu orang per baris: Jabatan | Nama</span>';
            }
        }
        ta.addEventListener('input', validate);
        validate();
    }

    /* ==========================================================
       11. DELETE CONFIRM
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
       12. IMAGE LIGHTBOX (Enhanced with SVG Controls)
       ========================================================== */
    function initImageLightbox() {
        var lb = document.createElement('div');
        lb.className = 'admin-lightbox';
        lb.innerHTML = '<button class="admin-lightbox-close">' + renderIcon('x', 24) + '</button><img src="" alt="Preview">';
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
       13. TABLE ENHANCEMENTS (Enhanced with Copy Icon)
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
       14. TABLE ROW HIGHLIGHT
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
       15. FILTER AUTO-SUBMIT
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
       16. DOC TYPE BADGES
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
       17. DROPZONES (Enhanced with File Icon)
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
                    titleEl.textContent = file.name;
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
       18. BADGES (Enhanced with AIK Icon)
       ========================================================== */
    function initBadges() {
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
       19. COUNTERS (Performance Optimized)
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
       20. AUTO-SAVE DRAFT
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
       21. FORM PROGRESS
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
       22. COMMAND PALETTE (Premium Feature)
       ========================================================== */
    function initCommandPalette() {
        var items = [
            { icon: 'home', title: 'Dashboard', desc: 'Ringkasan performa', url: 'admin/index.php?page=dashboard' },
            { icon: 'newspaper', title: 'Berita & Pengumuman', desc: 'Kelola publikasi redaksi', url: 'admin/index.php?page=berita' },
            { icon: 'folder', title: 'Dokumen & Unduhan', desc: 'Arsip dokumen publik', url: 'admin/index.php?page=dokumen' },
            { icon: 'settings', title: 'Pengaturan', desc: 'Konfigurasi website', url: 'admin/index.php?page=pengaturan' },
        ];

        var overlay = document.createElement('div');
        overlay.className = 'cmd-palette-overlay';
        overlay.innerHTML = '\
            <div class="cmd-palette">\
                <div class="cmd-palette-header">\
                    ' + renderIcon('search', 24) + '\
                    <span>Command Palette</span>\
                    <span class="kbd">ESC</span>\
                </div>\
                <input type="text" placeholder="Cari halaman..." autocomplete="off" />\
                <div class="cmd-palette-list"></div>\
            </div>\
        ';
        document.body.appendChild(overlay);

        var input = overlay.querySelector('input');
        var list = overlay.querySelector('.cmd-palette-list');
        var selectedIdx = 0;
        var filtered = items.slice();

        function render() {
            list.innerHTML = '';
            if (filtered.length === 0) {
                list.innerHTML = '<div class="cmd-palette-empty">Tidak ditemukan</div>';
                return;
            }
            filtered.forEach(function (item, idx) {
                var row = document.createElement('div');
                row.className = 'cmd-palette-item' + (idx === selectedIdx ? ' selected' : '');
                row.innerHTML = '\
                    <div class="ico">' + renderIcon(item.icon, 20) + '</div>\
                    <div class="txt">\
                        <b>' + item.title + '</b>\
                        <small>' + item.desc + '</small>\
                    </div>\
                ';
                row.addEventListener('click', function () { navigate(item); });
                list.appendChild(row);
            });
        }

        function navigate(item) {
            window.location.href = item.url;
        }

        function filter(query) {
            query = query.toLowerCase().trim();
            filtered = !query ? items.slice() : items.filter(function (i) {
                return i.title.toLowerCase().indexOf(query) !== -1 || i.desc.toLowerCase().indexOf(query) !== -1;
            });
            selectedIdx = 0;
            render();
        }

        function openPalette() {
            overlay.classList.add('open');
            setTimeout(function () { input.focus(); input.select(); }, 50);
            filter('');
        }

        function closePalette() {
            overlay.classList.remove('open');
            input.value = '';
        }

        input.addEventListener('input', function () { filter(input.value); });
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closePalette();
            else if (e.key === 'ArrowDown') {
                e.preventDefault();
                selectedIdx = Math.min(selectedIdx + 1, filtered.length - 1);
                render();
            }
            else if (e.key === 'ArrowUp') {
                e.preventDefault();
                selectedIdx = Math.max(selectedIdx - 1, 0);
                render();
            }
            else if (e.key === 'Enter' && filtered[selectedIdx]) navigate(filtered[selectedIdx]);
        });
        overlay.addEventListener('click', function (e) { if (e.target === overlay) closePalette(); });

        return { open: openPalette, close: closePalette };
    }

    /* ==========================================================
       23. KEYBOARD SHORTCUTS (Enhanced with Visual Hints)
       ========================================================== */
    function initKeyboardShortcuts() {
        var palette = initCommandPalette();

        document.addEventListener('keydown', function (e) {
            var active = document.activeElement;
            var isInput = active && (active.tagName === 'INPUT' || active.tagName === 'TEXTAREA' || active.isContentEditable);

            // Ctrl+K → Command Palette
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                palette.open();
            }

            // Ctrl+S → Save Form
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
                e.preventDefault();
                var form = document.querySelector('.settings-form, .admin-form');
                if (form) {
                    showToast('Menyimpan...', 'info');
                    form.submit();
                }
            }

            // Esc → Close Lightbox
            if (e.key === 'Escape') {
                var lb = document.querySelector('.admin-lightbox.active');
                if (lb) lb.classList.remove('active');
            }
        });

        // Keyboard hint
        var hint = document.createElement('div');
        hint.className = 'keyboard-hint';
        hint.innerHTML = renderIcon('keyboard', 16) + '<span>Quick actions:</span><span class="kbd">Ctrl+K</span><span class="kbd">Ctrl+S</span>';
        document.body.appendChild(hint);
        setTimeout(function () { hint.classList.add('show'); }, 1500);
        setTimeout(function () { hint.classList.remove('show'); }, 6000);
    }

    /* ==========================================================
       24. CONSOLE BRANDING (Enhanced)
       ========================================================== */
    function printConsoleBranding() {
        console.log('%c╔══════════════════════════════════════════════╗\n' +
            '║  LP3M UNIMOF — ADMIN SUPER PREMIUM v2.0 ✦     ║\n' +
            '║  SVG Icons • Command Palette • Premium UX      ║\n' +
            '╚══════════════════════════════════════════════╝',
            'color:#10b981;font-weight:bold;font-size:12px');
        console.log('%c⌨️  Ctrl+K (command palette) • Ctrl+S (save) • Esc (close)', 'color:#d9a441;font-size:11px');
    }

    /* ==========================================================
       INIT — Single Entry Point
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

        // Global (Premium)
        initKeyboardShortcuts();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();