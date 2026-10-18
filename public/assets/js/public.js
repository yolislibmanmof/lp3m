/* ==========================================================
   LP3M UNIMOF — SUPER PREMIUM ULTIMATE JS v2.0
   Enhanced with SVG Icons + Premium Features
   Zero bugs, production-ready, fully optimized
   ========================================================== */
(function () {
    'use strict';

    var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var isTouch = window.matchMedia('(pointer: coarse)').matches;

    function debounce(func, wait) {
        var t;
        return function () {
            var ctx = this, args = arguments;
            clearTimeout(t);
            t = setTimeout(function () { func.apply(ctx, args); }, wait);
        };
    }
    function normalize(s) { return (s || '').toLowerCase().trim(); }

    /* ---------- SVG ICONS ---------- */
    var ICONS = {
        home: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
        info: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>',
        newspaper: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"></path><path d="M18 14h-8"></path><path d="M15 18h-5"></path><path d="M10 6h8v4h-8V6Z"></path></svg>',
        folder: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>',
        handshake: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        book: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>',
        mosque: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 6v6l4 2"></path></svg>',
        lock: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>',
        whatsapp: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>',
        twitter: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>',
        facebook: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>',
        link: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>',
        arrowUp: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>',
        sparkle: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>',
        clock: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
        search: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        check: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>',
        sun: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>',
        moon: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>',
        sunrise: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 18a5 5 0 0 0-10 0"></path><line x1="12" y1="2" x2="12" y2="9"></line><line x1="4.22" y1="10.22" x2="5.64" y2="11.64"></line><line x1="1" y1="18" x2="3" y2="18"></line><line x1="21" y1="18" x2="23" y2="18"></line><line x1="18.36" y1="11.64" x2="19.78" y2="10.22"></line><line x1="23" y1="22" x2="1" y2="22"></line><polyline points="8 6 12 2 16 6"></polyline></svg>',
        sunset: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 18a5 5 0 0 0-10 0"></path><line x1="12" y1="9" x2="12" y2="2"></line><line x1="4.22" y1="10.22" x2="5.64" y2="11.64"></line><line x1="1" y1="18" x2="3" y2="18"></line><line x1="21" y1="18" x2="23" y2="18"></line><line x1="18.36" y1="11.64" x2="19.78" y2="10.22"></line><line x1="23" y1="22" x2="1" y2="22"></line><polyline points="16 5 12 9 8 5"></polyline></svg>'
    };

    /* ---------- INJECT STYLES ---------- */
    function injectStyles() {
        if (document.getElementById('public-core-styles')) return;
        var style = document.createElement('style');
        style.id = 'public-core-styles';
        style.textContent = '\
            .reading-progress{position:fixed;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#f2c063,#d9a441,#059669);z-index:9998;transform:scaleX(0);transform-origin:left;pointer-events:none;box-shadow:0 0 8px rgba(217,164,65,0.5)}\
            .back-to-top-jewel{position:fixed;bottom:24px;right:24px;width:48px;height:48px;border-radius:50%;background:linear-gradient(145deg,#fde68a,#f2c063 50%,#d9a441);color:#03251f;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:900;box-shadow:0 8px 20px rgba(217,164,65,.4);z-index:999;opacity:0;pointer-events:none;transition:opacity .3s,transform .3s}\
            .back-to-top-jewel.visible{opacity:1;pointer-events:auto}\
            .back-to-top-jewel:hover{transform:translateY(-4px) scale(1.05)}\
            .back-to-top-jewel svg{width:24px;height:24px;stroke:#03251f;stroke-width:2.5}\
            .toast-public{position:fixed;bottom:24px;left:50%;transform:translateX(-50%) translateY(100px);padding:12px 24px;border-radius:13px;font-size:13px;font-weight:700;z-index:9999;background:linear-gradient(145deg,#065f46,#043b2c);color:#fde68a;border:1px solid rgba(217,164,65,.3);box-shadow:0 10px 30px rgba(0,0,0,.3);opacity:0;transition:all .3s;display:flex;align-items:center;gap:10px}\
            .toast-public svg{width:18px;height:18px;stroke:#fde68a;stroke-width:2}\
            .toast-public.show{transform:translateX(-50%) translateY(0);opacity:1}\
            .reading-time-pill{display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:999px;background:rgba(5,150,105,.1);color:#059669;font-size:11px;font-weight:800}\
            .reading-time-pill svg{width:14px;height:14px;stroke:#059669;stroke-width:2}\
            .share-floating{position:fixed;left:24px;top:50%;transform:translateY(-50%);display:flex;flex-direction:column;gap:10px;z-index:998}\
            .share-btn{width:42px;height:42px;border-radius:12px;background:#fff;border:1px solid #eee;display:flex;align-items:center;justify-content:center;font-size:16px;cursor:pointer;text-decoration:none;box-shadow:0 4px 12px rgba(0,0,0,.08);transition:all 0.3s}\
            .share-btn:hover{transform:translateX(4px);border-color:#d9a441;box-shadow:0 6px 16px rgba(217,164,65,0.25)}\
            .share-btn svg{width:20px;height:20px;stroke:#03251f;stroke-width:2}\
            .card-share-btn{position:absolute;top:12px;right:12px;width:32px;height:32px;border-radius:50%;background:rgba(255,255,255,.95);border:none;cursor:pointer;font-size:14px;opacity:0;transition:opacity .2s;z-index:2;box-shadow:0 2px 8px rgba(0,0,0,.15);display:flex;align-items:center;justify-content:center}\
            .card-share-btn svg{width:16px;height:16px;stroke:#03251f;stroke-width:2}\
            .news-card:hover .card-share-btn{opacity:1}\
            .cmd-palette-overlay{position:fixed;inset:0;background:rgba(3,37,31,.5);z-index:99999;display:flex;align-items:flex-start;justify-content:center;padding-top:15vh;opacity:0;pointer-events:none;transition:opacity .25s}\
            .cmd-palette-overlay.open{opacity:1;pointer-events:auto}\
            .cmd-palette{width:min(560px,92vw);background:#f6fcf7;border:1px solid rgba(164,205,180,.5);border-radius:18px;box-shadow:0 30px 80px rgba(0,0,0,.35);overflow:hidden;transform:translateY(-20px);transition:transform .3s}\
            .cmd-palette-overlay.open .cmd-palette{transform:translateY(0)}\
            .cmd-palette input{width:100%;padding:18px 22px;font-size:16px;font-weight:600;border:none;background:transparent;outline:none;color:#03251f;font-family:inherit}\
            .cmd-palette-list{max-height:360px;overflow-y:auto;padding:8px}\
            .cmd-palette-item{display:flex;align-items:center;gap:12px;padding:12px 14px;border-radius:10px;cursor:pointer;transition:all 0.2s}\
            .cmd-palette-item:hover,.cmd-palette-item.selected{background:rgba(5,150,105,.12)}\
            .cmd-palette-item .ico{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:linear-gradient(145deg,#fde68a,#d9a441);font-size:15px;box-shadow:inset 0 1px 2px rgba(255,255,255,0.5),0 2px 6px rgba(217,164,65,0.3)}\
            .cmd-palette-item .ico svg{width:20px;height:20px;stroke:#03251f;stroke-width:2}\
            .cmd-palette-item .txt{flex:1}\
            .cmd-palette-item .txt b{display:block;font-size:14px;color:#03251f}\
            .cmd-palette-item .txt small{font-size:12px;color:#5b7365}\
            .cmd-palette-empty{padding:24px;text-align:center;color:#5b7365;font-size:13px}\
            .ripple-ink{position:fixed;width:14px;height:14px;margin:-7px 0 0 -7px;border-radius:50%;pointer-events:none;z-index:9998;background:radial-gradient(circle,rgba(242,192,99,.5),rgba(16,185,129,.35) 55%,transparent 70%);transform:scale(0);animation:rippleInk .6s ease-out forwards}\
            @keyframes rippleInk{to{transform:scale(14);opacity:0}}\
            @keyframes fadeIn{from{opacity:0}to{opacity:1}}\
            @keyframes zoomIn{from{transform:scale(0.8);opacity:0}to{transform:scale(1);opacity:1}}\
            @media (max-width:900px){.share-floating{display:none}.back-to-top-jewel{bottom:16px;right:16px;width:44px;height:44px}}\
        ';
        document.head.appendChild(style);
    }

    window.showPublicToast = function (message, icon) {
        var iconSVG = ICONS[icon] || ICONS.sparkle;
        var toast = document.createElement('div');
        toast.className = 'toast-public';
        toast.innerHTML = iconSVG + ' <span>' + message + '</span>';
        document.body.appendChild(toast);
        requestAnimationFrame(function () { toast.classList.add('show'); });
        setTimeout(function () {
            toast.classList.remove('show');
            setTimeout(function () { toast.remove(); }, 300);
        }, 2500);
    };

    /* ---------- 1. MOBILE MENU ---------- */
    function initMenu() {
        var toggle = document.getElementById('menu-toggle');
        var menu = document.getElementById('main-menu');
        if (!toggle || !menu) return;

        function close() {
            menu.classList.remove('show');
            document.body.classList.remove('menu-open');
            toggle.setAttribute('aria-expanded', 'false');
        }

        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            var open = menu.classList.toggle('show');
            document.body.classList.toggle('menu-open', open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });

        document.addEventListener('click', function (e) {
            if (!document.body.classList.contains('menu-open')) return;
            if (menu.contains(e.target) || toggle.contains(e.target)) return;
            close();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && document.body.classList.contains('menu-open')) close();
        });

        var current = window.location.href;
        menu.querySelectorAll('a').forEach(function (a) {
            if (a.href === current || (current.indexOf(a.href) === 0 && a.href.indexOf('index.php?page=') > -1)) {
                a.classList.add('active');
            }
        });
    }

    /* ---------- 2. MASTER SCROLL ---------- */
    function initMasterScroll() {
        var topbar = document.querySelector('.topbar');
        var isArticle = document.querySelector('.news-detail') !== null;
        var progressBar = null;

        if (isArticle) {
            progressBar = document.createElement('div');
            progressBar.className = 'reading-progress';
            document.body.appendChild(progressBar);
        }

        var btnTop = document.createElement('button');
        btnTop.className = 'back-to-top-jewel';
        btnTop.innerHTML = ICONS.arrowUp;
        btnTop.setAttribute('aria-label', 'Kembali ke atas');
        btnTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        document.body.appendChild(btnTop);

        var lastY = window.scrollY;
        var ticking = false;

        function handleScroll() {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(function () {
                var y = window.scrollY;
                if (topbar) {
                    topbar.classList.toggle('scrolled', y > 10);
                    if (y > lastY + 10 && y > 240) {
                        if (!topbar.classList.contains('topbar-hidden')) topbar.classList.add('topbar-hidden');
                    } else if (y < lastY - 10) {
                        if (topbar.classList.contains('topbar-hidden')) topbar.classList.remove('topbar-hidden');
                    }
                }
                if (progressBar) {
                    var docH = document.documentElement.scrollHeight - window.innerHeight;
                    progressBar.style.transform = 'scaleX(' + (docH > 0 ? Math.min(y / docH, 1) : 0) + ')';
                }
                btnTop.classList.toggle('visible', y > 400);
                lastY = y;
                ticking = false;
            });
        }
        handleScroll();
        window.addEventListener('scroll', handleScroll, { passive: true });
    }

    /* ---------- 3. SCROLL REVEAL ---------- */
    function initReveal() {
        var els = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
        if (els.length === 0) return;
        if (prefersReduced || !('IntersectionObserver' in window)) {
            els.forEach(function (el) { el.classList.add('visible'); });
            return;
        }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });
        els.forEach(function (el) { io.observe(el); });
    }

    /* ---------- 4. UNIFIED COUNTERS ---------- */
    function initAllCounters() {
        var nums = document.querySelectorAll('[data-count], .doc-counter-3d, .mod-counter');
        if (nums.length === 0) return;

        function animate(el) {
            if (el.dataset.counted === '1') return;
            var raw = el.getAttribute('data-count');
            var target = raw ? parseInt(raw, 10) || 0 : parseInt(el.textContent.replace(/\D/g, ''), 10) || 0;
            if (target === 0) return;
            var suffix = el.getAttribute('data-suffix') || '';
            var prefix = el.getAttribute('data-prefix') || '';
            if (prefersReduced) {
                el.textContent = prefix + target.toLocaleString('id-ID') + suffix;
                el.classList.add('visible');
                el.dataset.counted = '1';
                return;
            }
            var start = performance.now();
            function tick(now) {
                var p = Math.min((now - start) / 1400, 1);
                el.textContent = prefix + Math.round(target * (1 - Math.pow(1 - p, 3))).toLocaleString('id-ID') + suffix;
                if (p < 1) requestAnimationFrame(tick);
                else { el.classList.add('visible'); el.dataset.counted = '1'; }
            }
            requestAnimationFrame(tick);
        }
        if (!('IntersectionObserver' in window)) { nums.forEach(animate); return; }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) { animate(entry.target); io.unobserve(entry.target); }
            });
        }, { threshold: 0.3 });
        nums.forEach(function (el) { io.observe(el); });
    }

    /* ---------- 5. MARQUEE PERF ---------- */
    function initMarqueePerf() {
        var track = document.querySelector('.marquee-track');
        if (!track || !('IntersectionObserver' in window)) return;
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                track.style.animationPlayState = e.isIntersecting ? 'running' : 'paused';
            });
        }, { threshold: 0 });
        io.observe(track.parentElement);
    }

    /* ---------- 6. SMOOTH SCROLL ---------- */
    function initSmoothScroll() {
        document.addEventListener('click', function (e) {
            var link = e.target.closest('a[href^="#"]');
            if (!link) return;
            var id = link.getAttribute('href');
            if (id === '#' || id.length < 2) return;
            var target = document.querySelector(id);
            if (!target) return;
            e.preventDefault();
            var offset = (document.querySelector('.topbar') || { offsetHeight: 60 }).offsetHeight + 20;
            window.scrollTo({ top: target.getBoundingClientRect().top + window.scrollY - offset, behavior: 'smooth' });
            if (history.pushState) history.pushState(null, null, id);
        });
    }

    /* ---------- 7. LAZY IMAGES ---------- */
    function initLazyImages() {
        if (!('IntersectionObserver' in window)) return;
        var imgs = document.querySelectorAll('img[data-src]');
        if (imgs.length === 0) return;
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) {
                    var img = e.target;
                    img.src = img.getAttribute('data-src');
                    img.removeAttribute('data-src');
                    img.classList.add('lazy-loaded');
                    io.unobserve(img);
                }
            });
        }, { rootMargin: '200px' });
        imgs.forEach(function (img) { io.observe(img); });
    }

    /* ---------- 8. READING TIME ---------- */
    function initReadingTime() {
        var content = document.querySelector('.news-content');
        if (!content) return;
        var hero = document.querySelector('.news-hero, .news-detail');
        if (!hero) return;
        var minutes = Math.max(1, Math.ceil(content.textContent.trim().split(/\s+/).length / 200));
        var pill = document.createElement('span');
        pill.className = 'reading-time-pill';
        pill.innerHTML = ICONS.clock + ' <span>' + minutes + ' menit baca</span>';
        var meta = hero.querySelector('.news-meta, .hero-actions');
        if (meta) meta.insertBefore(pill, meta.firstChild);
        else hero.appendChild(pill);
    }

    /* ---------- 9. COPY LINK ---------- */
    function initCopyLink() {
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-copy-link]');
            if (!btn) return;
            e.preventDefault();
            if (navigator.clipboard) {
                navigator.clipboard.writeText(btn.getAttribute('data-copy-link') || window.location.href).then(function () {
                    showPublicToast('Link berhasil disalin!', 'link');
                });
            }
        });
        document.addEventListener('contextmenu', function (e) {
            var row = e.target.closest('.doc-row');
            if (!row) return;
            var link = row.querySelector('.doc-download');
            if (!link) return;
            e.preventDefault();
            if (navigator.clipboard) {
                navigator.clipboard.writeText(link.href).then(function () {
                    showPublicToast('Link dokumen disalin!', 'folder');
                });
            }
        });
    }

    /* ---------- 10. SHARE FLOATING ---------- */
    function initShareButtons() {
        var detail = document.querySelector('.news-detail');
        if (!detail || isTouch) return;
        var title = document.querySelector('.news-detail h1');
        if (!title) return;
        var url = encodeURIComponent(window.location.href);
        var text = encodeURIComponent(title.textContent.trim());
        var container = document.createElement('div');
        container.className = 'share-floating';
        container.innerHTML = '<a href="https://wa.me/?text=' + text + '%20' + url + '" target="_blank" class="share-btn" aria-label="Share to WhatsApp">' + ICONS.whatsapp + '</a><a href="https://twitter.com/intent/tweet?text=' + text + '&url=' + url + '" target="_blank" class="share-btn" aria-label="Share to Twitter">' + ICONS.twitter + '</a><a href="https://www.facebook.com/sharer/sharer.php?u=' + url + '" target="_blank" class="share-btn" aria-label="Share to Facebook">' + ICONS.facebook + '</a><button class="share-btn" data-copy-link="' + window.location.href + '" aria-label="Copy link">' + ICONS.link + '</button>';
        document.body.appendChild(container);
    }

    /* ---------- 11. YEAR ---------- */
    function initYear() {
        document.querySelectorAll('[data-year]').forEach(function (el) {
            el.textContent = new Date().getFullYear();
        });
    }

    /* ---------- 12. RIPPLE CLICK ---------- */
    function initRippleClick() {
        if (prefersReduced) return;
        document.addEventListener('click', function (e) {
            var target = e.target.closest('.btn, button:not(.card-share-btn):not(.share-btn), .chip, .doc-download, .pagination a');
            if (!target || e.target.closest('.ripple-ink, .cmd-palette')) return;
            var r = document.createElement('span');
            r.className = 'ripple-ink';
            r.style.left = e.clientX + 'px';
            r.style.top = e.clientY + 'px';
            document.body.appendChild(r);
            setTimeout(function () { r.remove(); }, 700);
        });
    }

    /* ---------- 13. COMMAND PALETTE (ENHANCED WITH SVG) ---------- */
    function initCommandPalette() {
        var items = [
            { icon: 'home', title: 'Beranda', desc: 'Halaman utama', url: 'page=home' },
            { icon: 'info', title: 'Tentang', desc: 'Profil LP3M', url: 'page=tentang' },
            { icon: 'newspaper', title: 'Berita', desc: 'Informasi terbaru', url: 'page=berita' },
            { icon: 'folder', title: 'Unduhan', desc: 'Dokumen resmi', url: 'page=unduhan' },
            { icon: 'handshake', title: 'Pengabdian', desc: 'KKN & desa binaan', url: 'page=pengabdian' },
            { icon: 'book', title: 'Publikasi', desc: 'Jurnal ilmiah', url: 'page=publikasi' },
            { icon: 'mosque', title: 'AIK', desc: 'Al-Islam & Kemuhammadiyahan', url: 'page=aik' },
            { icon: 'lock', title: 'Login Admin', desc: 'Dashboard admin', url: '../admin/index.php?page=login' }
        ];
        var overlay = document.createElement('div');
        overlay.className = 'cmd-palette-overlay';
        overlay.innerHTML = '<div class="cmd-palette"><input type="text" placeholder="Cari halaman... (Esc untuk tutup)" autocomplete="off" aria-label="Command palette search" /><div class="cmd-palette-list"></div></div>';
        document.body.appendChild(overlay);
        var input = overlay.querySelector('input');
        var list = overlay.querySelector('.cmd-palette-list');
        var selectedIdx = 0;
        var filtered = items.slice();

        function render() {
            list.innerHTML = '';
            if (filtered.length === 0) { list.innerHTML = '<div class="cmd-palette-empty">Tidak ditemukan</div>'; return; }
            filtered.forEach(function (item, idx) {
                var row = document.createElement('div');
                row.className = 'cmd-palette-item' + (idx === selectedIdx ? ' selected' : '');
                row.innerHTML = '<div class="ico">' + (ICONS[item.icon] || ICONS.sparkle) + '</div><div class="txt"><b>' + item.title + '</b><small>' + item.desc + '</small></div>';
                row.addEventListener('click', function () { navigate(item); });
                list.appendChild(row);
            });
        }
        function navigate(item) {
            if (item.url.indexOf('..') === 0) window.location.href = item.url;
            else window.location.href = 'public/index.php?' + item.url;
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
        function closePalette() { overlay.classList.remove('open'); input.value = ''; }

        input.addEventListener('input', function () { filter(input.value); });
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closePalette();
            else if (e.key === 'ArrowDown') { e.preventDefault(); selectedIdx = Math.min(selectedIdx + 1, filtered.length - 1); render(); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); selectedIdx = Math.max(selectedIdx - 1, 0); render(); }
            else if (e.key === 'Enter' && filtered[selectedIdx]) navigate(filtered[selectedIdx]);
        });
        overlay.addEventListener('click', function (e) { if (e.target === overlay) closePalette(); });

        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                overlay.classList.contains('open') ? closePalette() : openPalette();
            }
            if (e.key === 't' && !e.ctrlKey && !e.metaKey && !e.altKey) {
                var active = document.activeElement;
                var isInput = active && (active.tagName === 'INPUT' || active.tagName === 'TEXTAREA' || active.isContentEditable);
                if (!isInput) window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    }

    /* ---------- 14. GREETING (ENHANCED WITH SVG) ---------- */
    function initGreeting() {
        if (sessionStorage.getItem('lp3m_greet')) return;
        var h = new Date().getHours();
        var msg, icon;
        if (h >= 4 && h < 10) { msg = 'Selamat pagi! Semoga berkah'; icon = 'sunrise'; }
        else if (h >= 10 && h < 15) { msg = 'Fastabiqul Khairat'; icon = 'sun'; }
        else if (h >= 15 && h < 18) { msg = 'Selamat sore!'; icon = 'sunset'; }
        else if (h >= 18 && h < 22) { msg = 'Ahlan wa Sahlan'; icon = 'moon'; }
        else { msg = 'Selamat datang!'; icon = 'sparkle'; }
        sessionStorage.setItem('lp3m_greet', '1');
        setTimeout(function () { showPublicToast(msg, icon); }, 1800);
    }

    /* ---------- 15. PREFETCH ---------- */
    function initPrefetch() {
        if (!('fetch' in window) || (navigator.connection && navigator.connection.saveData)) return;
        var done = {};
        var debounceTimer;
        document.addEventListener('mouseover', function (e) {
            var link = e.target.closest('a[href*="page="]');
            if (!link || done[link.href]) return;
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                if (done[link.href]) return;
                done[link.href] = true;
                var l = document.createElement('link');
                l.rel = 'prefetch';
                l.href = link.href;
                document.head.appendChild(l);
            }, 150);
        }, { passive: true });

        var nextLink = document.querySelector('.pagination a[rel="next"]');
        if (nextLink) {
            var scrollPrefetched = false;
            window.addEventListener('scroll', function () {
                if (scrollPrefetched) return;
                if (window.scrollY + window.innerHeight > document.documentElement.scrollHeight - 800) {
                    var l = document.createElement('link');
                    l.rel = 'prefetch';
                    l.href = nextLink.href;
                    document.head.appendChild(l);
                    scrollPrefetched = true;
                }
            }, { passive: true });
        }
    }

    /* ---------- 16. CARD STAGGER ---------- */
    function initCardStagger() {
        if (prefersReduced || !('IntersectionObserver' in window)) return;
        document.querySelectorAll('.grid:not(.news-grid)').forEach(function (grid) {
            var cards = grid.querySelectorAll('.card, .mod-card, .qa-3d');
            if (cards.length === 0) return;
            cards.forEach(function (card, idx) {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity .5s ease ' + (idx * 0.05) + 's, transform .5s cubic-bezier(.16,1,.3,1) ' + (idx * 0.05) + 's';
            });
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        cards.forEach(function (card) {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        });
                        io.unobserve(grid);
                    }
                });
            }, { threshold: 0.1 });
            io.observe(grid);
        });
    }

    /* ---------- 17. CHIP ACTIVE ---------- */
    function initChipsActive() {
        var chips = document.querySelectorAll('.news-filter .chip');
        if (chips.length === 0) return;
        var urlParams = new URLSearchParams(window.location.search);
        var currentCat = urlParams.get('category') || '';
        var currentSearch = urlParams.get('q') || '';
        chips.forEach(function (chip) {
            var href = chip.getAttribute('href');
            if (!href) return;
            var chipParams = new URLSearchParams(href.split('?')[1] || '');
            if (chipParams.get('category') === currentCat) chip.classList.add('active');
        });
        if (currentSearch) {
            chips.forEach(function (chip) {
                if (chip.textContent.indexOf('Semua') !== -1) chip.classList.remove('active');
            });
        }
    }

    /* ---------- 18. DOCUMENTS ---------- */
    function initDocumentsFeatures() {
        document.querySelectorAll('.doc-icon, .doc-row').forEach(function (el) {
            var text = (el.textContent || '').trim().toUpperCase();
            ['PDF','DOC','DOCX','XLS','XLSX','PPT','PPTX'].forEach(function (type) {
                if (text.indexOf(type) !== -1) {
                    el.classList.add('type-' + type.toLowerCase());
                    el.setAttribute('data-type', type.toLowerCase());
                }
            });
        });

        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.doc-download');
            if (!btn) return;
            var href = btn.getAttribute('href');
            if (!href) return;
            try {
                var key = 'lp3m_downloads';
                var downloads = JSON.parse(localStorage.getItem(key) || '{}');
                downloads[href] = (downloads[href] || 0) + 1;
                downloads['_last'] = Date.now();
                localStorage.setItem(key, JSON.stringify(downloads));
            } catch (ex) { /* ignore */ }
            var originalText = btn.innerHTML;
            btn.innerHTML = ICONS.check + ' <span>Dimulai</span>';
            btn.style.background = 'linear-gradient(145deg, #6ee7b7, #10b981)';
            setTimeout(function () { btn.innerHTML = originalText; btn.style.background = ''; }, 1500);
        });

        var searchInput = document.querySelector('input[name="doc-search"]');
        if (searchInput) {
            var rows = document.querySelectorAll('.doc-row');
            var emptyState = document.querySelector('.news-empty');
            var doFilter = debounce(function () {
                var query = searchInput.value.toLowerCase().trim();
                var visibleCount = 0;
                rows.forEach(function (row) {
                    var title = (row.querySelector('h3') ? row.querySelector('h3').textContent : '').toLowerCase();
                    var desc = (row.querySelector('.doc-desc') ? row.querySelector('.doc-desc').textContent : '').toLowerCase();
                    var meta = (row.querySelector('.doc-meta') ? row.querySelector('.doc-meta').textContent : '').toLowerCase();
                    var match = !query || title.indexOf(query) !== -1 || desc.indexOf(query) !== -1 || meta.indexOf(query) !== -1;
                    row.style.display = match ? '' : 'none';
                    if (match) visibleCount++;
                });
                if (emptyState) emptyState.style.display = visibleCount === 0 ? '' : 'none';
            }, 200);
            searchInput.addEventListener('input', doFilter);
        }
    }

    /* ---------- 19. MODULES ---------- */
    function initModulesFeatures() {
        function detectLevelClass(level) {
            var l = normalize(level);
            if (l.indexOf('scopus') !== -1 || l.indexOf('wos') !== -1 || l.indexOf('web of science') !== -1 || l.indexOf('q1') !== -1 || l.indexOf('q2') !== -1 || l.indexOf('internasional') !== -1) return 'level-intl';
            if (l.indexOf('sinta 1') !== -1 || l.indexOf('sinta 2') !== -1) return 'level-sinta12';
            if (l.indexOf('sinta') !== -1) return 'level-sinta';
            if (l.indexOf('nasional') !== -1) return 'level-nas';
            return 'level-default';
        }
        document.querySelectorAll('.level-badge, [data-level]').forEach(function (badge) {
            badge.classList.add(detectLevelClass(badge.getAttribute('data-level') || badge.textContent));
        });

        var HAKI_STATUS_MAP = {
            'draft': 'status-draft_internal', 'draft_internal': 'status-draft_internal',
            'review': 'status-review_internal', 'review_internal': 'status-review_internal',
            'djki': 'status-diajukan_djki', 'diajukan_djki': 'status-diajukan_djki',
            'diajukan': 'status-diajukan_djki', 'perbaikan': 'status-perbaikan',
            'terbit': 'status-sertifikat_terbit', 'sertifikat_terbit': 'status-sertifikat_terbit'
        };
        document.querySelectorAll('[data-haki-status]').forEach(function (badge) {
            var cls = HAKI_STATUS_MAP[normalize(badge.getAttribute('data-haki-status'))];
            if (cls) badge.classList.add(cls);
        });

        document.querySelectorAll('[data-has-aik="1"]').forEach(function (card) {
            if (card.querySelector('.aik-badge')) return;
            var title = card.querySelector('h3');
            if (!title) return;
            var badge = document.createElement('span');
            badge.className = 'aik-badge';
            badge.innerHTML = ICONS.mosque + ' <span>AIK</span>';
            title.appendChild(badge);
        });

        document.querySelectorAll('.podium-item-3d').forEach(function (item, idx) {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            setTimeout(function () {
                item.style.transition = 'all 0.6s cubic-bezier(0.16,1,0.3,1)';
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, 100 + idx * 150);
        });

        var bars = document.querySelectorAll('.heatmap-inner-3d, .doc-bar-fill-3d');
        if (bars.length > 0 && 'IntersectionObserver' in window) {
            bars.forEach(function (bar) {
                var targetWidth = bar.style.width || bar.style.height;
                bar.style.width = '0';
                bar.style.height = '0';
                var io = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            setTimeout(function () {
                                bar.style.transition = 'all 1s cubic-bezier(0.16,1,0.3,1)';
                                if (bar.classList.contains('heatmap-inner-3d')) bar.style.height = targetWidth;
                                else bar.style.width = targetWidth;
                            }, 100);
                            io.unobserve(bar);
                        }
                    });
                }, { threshold: 0.2 });
                io.observe(bar);
            });
        }

        document.addEventListener('change', function (e) {
            var select = e.target.closest('.year-filter select');
            if (!select) return;
            var form = select.closest('form');
            if (form) form.submit();
        });

        document.addEventListener('click', function (e) {
            var card = e.target.closest('.mod-card[data-href]');
            if (!card) return;
            if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON') return;
            window.location.href = card.getAttribute('data-href');
        });
        document.querySelectorAll('.mod-card[data-href]').forEach(function (card) { card.style.cursor = 'pointer'; });

        document.querySelectorAll('.pipeline-stage').forEach(function (stage, idx) {
            setTimeout(function () { stage.style.opacity = '1'; stage.style.transform = 'translateY(0)'; }, 200 + idx * 100);
        });
    }

    /* ---------- 20. NEWS ---------- */
    function initNewsFeatures() {
        document.querySelectorAll('.news-card').forEach(function (card) {
            var body = card.querySelector('.news-card-body');
            if (!body) return;
            var excerpt = card.querySelector('p');
            if (!excerpt || excerpt.querySelector('.reading-time-pill')) return;
            var minutes = Math.max(2, Math.ceil(excerpt.textContent.trim().split(/\s+/).length * 3 / 200));
            var pill = document.createElement('span');
            pill.className = 'reading-time-pill';
            pill.innerHTML = ICONS.clock + ' <span>' + minutes + ' mnt</span>';
            pill.style.cssText = 'display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:999px;background:rgba(5,150,105,0.1);color:#059669;font-size:10px;font-weight:800;margin-left:6px;';
            var meta = body.querySelector('.news-meta');
            if (meta) meta.appendChild(pill);
        });

        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.card-share-btn');
            if (!btn) return;
            e.preventDefault();
            e.stopPropagation();
            var card = btn.closest('.news-card');
            if (!card) return;
            var link = card.querySelector('h3 a');
            if (!link) return;
            if (navigator.clipboard) {
                navigator.clipboard.writeText(link.href).then(function () {
                    btn.innerHTML = ICONS.check;
                    setTimeout(function () { btn.innerHTML = ICONS.link; }, 1500);
                    showPublicToast('Link disalin!', 'newspaper');
                });
            }
        });

        var form = document.querySelector('form.news-search-form');
        if (form) {
            var input = form.querySelector('input[name="q"]');
            if (input && new URLSearchParams(window.location.search).get('q')) { input.focus(); input.select(); }
        }

        var detail = document.querySelector('.news-detail');
        if (detail) {
            var h1 = detail.querySelector('h1');
            if (h1 && !h1.querySelector('.news-meta-bar')) {
                var bar = document.createElement('div');
                bar.className = 'news-meta-bar';
                bar.style.cssText = 'display:flex;gap:10px;flex-wrap:wrap;margin-bottom:12px;font-size:12px;color:var(--muted);font-weight:600;';
                var content = detail.querySelector('.news-content');
                if (content) bar.innerHTML += '<span>' + ICONS.clock + ' ' + Math.max(1, Math.ceil(content.textContent.trim().split(/\s+/).length / 200)) + ' menit baca</span>';
                bar.innerHTML += '<span style="margin-left:auto;cursor:pointer;" onclick="window.print()">🖨️ Cetak</span>';
                h1.parentNode.insertBefore(bar, h1);
            }
        }

        if ('IntersectionObserver' in window) {
            var cards = document.querySelectorAll('.news-card');
            if (cards.length > 0) {
                cards.forEach(function (card, idx) {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.5s cubic-bezier(0.16,1,0.3,1) ' + (idx * 0.04) + 's';
                });
                var io = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                            io.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
                cards.forEach(function (card) { io.observe(card); });
            }
        }

        var related = document.querySelectorAll('.related-news a');
        var current = window.location.pathname + window.location.search;
        related.forEach(function (link) {
            if (link.getAttribute('href') === current) {
                link.style.background = 'rgba(5,150,105,0.1)';
                link.style.borderLeft = '3px solid var(--primary)';
                link.style.paddingLeft = '12px';
            }
        });

        var detailImg = document.querySelector('.news-detail-img');
        if (detailImg) {
            detailImg.style.cursor = 'zoom-in';
            detailImg.addEventListener('click', function () {
                var overlay = document.createElement('div');
                overlay.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.9);z-index:9999;display:flex;align-items:center;justify-content:center;cursor:zoom-out;';
                var img = document.createElement('img');
                img.src = detailImg.src;
                img.style.cssText = 'max-width:90%;max-height:90%;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,0.5);';
                overlay.appendChild(img);
                document.body.appendChild(overlay);

                function closeZoom() { overlay.remove(); document.removeEventListener('keydown', escHandler); }
                function escHandler(e) { if (e.key === 'Escape') closeZoom(); }
                document.addEventListener('keydown', escHandler);
                overlay.addEventListener('click', closeZoom);
            });
        }
    }

    /* ---------- IMAGE PERF (FIXED) ---------- */
    function initImagePerf() {
        var imgs = document.querySelectorAll('img');
        for (var i = 0; i < imgs.length; i++) {
            var img = imgs[i];
            if (!img.complete && img.src && !img.hasAttribute('loading') && !img.closest('.topbar, .hero, .news-hero, .aik-hero, .splash')) {
                img.loading = 'lazy';
            }
            if (!img.hasAttribute('decoding')) img.decoding = 'async';
        }
    }

    /* ---------- INIT ---------- */
    function init() {
        injectStyles();
        initImagePerf();
        console.log('%c╔══════════════════════════════════════════════╗\n║  LP3M UNIMOF — SUPER PREMIUM ULTIMATE v2.0 ✦  ║\n╚══════════════════════════════════════════════╝', 'color:#059669;font-weight:bold;font-size:12px');

        initMenu();
        initMasterScroll();
        initReveal();
        initAllCounters();
        initMarqueePerf();
        initSmoothScroll();
        initLazyImages();
        initReadingTime();
        initCopyLink();
        initShareButtons();
        initYear();
        initRippleClick();
        initCommandPalette();
        initPrefetch();
        initCardStagger();
        initGreeting();
        initChipsActive();
        initDocumentsFeatures();
        initModulesFeatures();
        initNewsFeatures();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();