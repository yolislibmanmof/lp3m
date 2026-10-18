<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? APP_NAME) ?> — LP3M Admin</title>
    <link rel="icon" href="<?= e(url('public/assets/img/favicon.svg')) ?>">
    <link rel="stylesheet" href="<?= e(url('admin/assets/css/admin.css')) ?>">

    <?php
    // SVG Icon Helper untuk Admin
    function renderAdminIcon($name, $size = 24, $color = 'currentColor') {
        $icons = [
            // Navigation
            'home' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
            'newspaper' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"></path><path d="M18 14h-8"></path><path d="M15 18h-5"></path><path d="M10 6h8v4h-8V6Z"></path></svg>',
            'folder' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>',
            'image' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>',
            'video' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>',
            'mic' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line></svg>',
            'microscope' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M9 3h6v2H9V3zm-3 4h12v2H6V7zm2 4h8v10H8V11z"></path><path d="M10 15h4"></path></svg>',
            'handshake' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
            'book' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>',
            'shield' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
            'mosque' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 6v6l4 2"></path></svg>',
            'dollar-sign' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>',
            'award' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>',
            'phone' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>',
            'users' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
            'link' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>',
            'mail' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>',
            'calendar' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
            'search' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            'check-square' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>',
            'bot' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="10" rx="2"></rect><circle cx="12" cy="5" r="2"></circle><path d="M12 7v4"></path><line x1="8" y1="16" x2="8" y2="16"></line><line x1="16" y1="16" x2="16" y2="16"></line></svg>',
            'bell' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>',
            'user' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>',
            'file-text' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>',
            'bar-chart' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>',
            'database' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>',
            'settings' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>',
            'globe' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>',
            'log-out' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>',
            'external-link' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>',
            
            // Greeting Icons
            'sunrise' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 18a5 5 0 0 0-10 0"></path><line x1="12" y1="2" x2="12" y2="9"></line><line x1="4.22" y1="10.22" x2="5.64" y2="11.64"></line><line x1="1" y1="18" x2="3" y2="18"></line><line x1="21" y1="18" x2="23" y2="18"></line><line x1="18.36" y1="11.64" x2="19.78" y2="10.22"></line><line x1="23" y1="22" x2="1" y2="22"></line><polyline points="8 6 12 2 16 6"></polyline></svg>',
            'sun' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>',
            'sunset' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M17 18a5 5 0 0 0-10 0"></path><line x1="12" y1="9" x2="12" y2="2"></line><line x1="4.22" y1="10.22" x2="5.64" y2="11.64"></line><line x1="1" y1="18" x2="3" y2="18"></line><line x1="21" y1="18" x2="23" y2="18"></line><line x1="18.36" y1="11.64" x2="19.78" y2="10.22"></line><line x1="23" y1="22" x2="1" y2="22"></line><polyline points="16 5 12 9 8 5"></polyline></svg>',
            'moon' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>',
            
            // Utility Icons
            'activity' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>',
            'edit' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>',
            'alert-triangle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>',
            'check-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>',
            'sparkle' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><path d="M12 3l1.912 5.813a2 2 0 0 0 1.275 1.275L21 12l-5.813 1.912a2 2 0 0 0-1.275 1.275L12 21l-1.912-5.813a2 2 0 0 0-1.275-1.275L3 12l5.813-1.912a2 2 0 0 0 1.275-1.275L12 3z"></path></svg>',
            'zap' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>',
            'hard-drive' => '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" fill="none" stroke="'.$color.'" stroke-width="2" viewBox="0 0 24 24"><line x1="22" y1="12" x2="2" y2="12"></line><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path><line x1="6" y1="16" x2="6.01" y2="16"></line><line x1="10" y1="16" x2="10.01" y2="16"></line></svg>',
        ];
        return $icons[$name] ?? $icons['sparkle'];
    }
    ?>

    <!-- ==========================================================
         SIDEBAR PREMIUM ULTIMATE — SVG Icons Edition
         ========================================================== -->
    <style>
        @keyframes iconRotate {
            0%, 100% { transform: rotate(0deg) scale(1); }
            25% { transform: rotate(-5deg) scale(1.05); }
            75% { transform: rotate(5deg) scale(1.05); }
        }
        
        .sb2 .ico-3d {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .sb2 .ico-3d svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.2;
            filter: drop-shadow(0 1px 2px rgba(0,0,0,0.2));
            transition: all 0.3s ease;
        }
        .sb2 .sidebar-menu a:hover .ico-3d {
            transform: scale(1.1) rotate(-5deg);
        }
        .sb2 .sidebar-menu a:hover .ico-3d svg {
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }
        .sb2 .sidebar-menu a.active .ico-3d svg {
            filter: drop-shadow(0 2px 6px rgba(217,164,65,0.4));
        }

        .greet-ico-3d svg {
            width: 24px;
            height: 24px;
            stroke-width: 2;
            filter: drop-shadow(0 2px 6px rgba(217,164,65,0.4));
            animation: iconRotate 3s ease-in-out infinite;
        }

        .topbar-right .ico-3d svg {
            width: 16px;
            height: 16px;
            stroke-width: 2.2;
        }

        .bell-icon-inner svg {
            width: 20px;
            height: 20px;
            stroke-width: 2.2;
            filter: drop-shadow(0 2px 4px rgba(217,164,65,0.3));
        }

        .date-3d svg {
            width: 16px;
            height: 16px;
            stroke-width: 2.2;
        }

        .sb2-pulse-head svg {
            width: 14px;
            height: 14px;
            stroke: #6ee7b7;
            stroke-width: 2.5;
        }

        .sb2-footer-mini svg {
            width: 12px;
            height: 12px;
            stroke: currentColor;
            stroke-width: 2;
        }

        .admin-topbar .stats-ico svg {
            width: 14px;
            height: 14px;
            stroke-width: 2.2;
        }
    </style>
</head>
<body>

<?php if (Auth::check()): ?>

<?php
// --- ZONA WAKTU & GREETING ---
date_default_timezone_set('Asia/Makassar');

$bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$tanggal = date('d') . ' ' . $bulan[(int) date('n') - 1] . ' ' . date('Y');

$hour = (int) date('G');
if ($hour >= 4 && $hour < 10)      { $greeting = 'Selamat Pagi';    $greetIcon = 'sunrise'; }
elseif ($hour >= 10 && $hour < 15) { $greeting = 'Selamat Siang';   $greetIcon = 'sun'; }
elseif ($hour >= 15 && $hour < 18) { $greeting = 'Selamat Sore';    $greetIcon = 'sunset'; }
else                               { $greeting = 'Selamat Malam';   $greetIcon = 'moon'; }

// --- DATABASE & COUNTERS ---
$db = Database::pdo();

$cntBerita     = (int) $db->query('SELECT COUNT(*) FROM news')->fetchColumn();
$cntDokumen    = (int) $db->query('SELECT COUNT(*) FROM documents')->fetchColumn();
$cntPengabdian = (int) $db->query('SELECT COUNT(*) FROM community_services')->fetchColumn();
$cntPublikasi  = (int) $db->query('SELECT COUNT(*) FROM publications')->fetchColumn();
$cntHaki       = (int) $db->query('SELECT COUNT(*) FROM intellectual_properties')->fetchColumn();
$cntAik        = (int) $db->query('SELECT COUNT(*) FROM aik_activities')->fetchColumn();
$cntPenelitian = (int) $db->query('SELECT COUNT(*) FROM researches')->fetchColumn();
$cntHibah      = (int) $db->query('SELECT COUNT(*) FROM grants')->fetchColumn();
$cntFaq        = (int) $db->query('SELECT COUNT(*) FROM faqs')->fetchColumn();
$cntGaleri     = (int) $db->query('SELECT COUNT(*) FROM galleries')->fetchColumn();
$cntSertifikat = (int) $db->query('SELECT COUNT(*) FROM certificates')->fetchColumn();
$cntReviewers  = (int) $db->query('SELECT COUNT(*) FROM reviewers')->fetchColumn();
$cntEvents     = (int) $db->query("SELECT COUNT(*) FROM events WHERE status='published'")->fetchColumn();
$cntPlagiarism = (int) $db->query('SELECT COUNT(*) FROM plagiarism_checks')->fetchColumn();
$cntUsers      = (int) $db->query('SELECT COUNT(*) FROM users')->fetchColumn();
$cntSurvey     = (int) $db->query('SELECT COUNT(*) FROM surveys')->fetchColumn();

$cntChatbot = 0;
try { $cntChatbot = (int) $db->query('SELECT COUNT(*) FROM chatbot_knowledge')->fetchColumn(); } catch (\Throwable $e) {}

$adminId     = (int) (Auth::user()['id'] ?? 0);
$unreadNotif = (int) $db->query("SELECT COUNT(*) FROM notifications WHERE is_read = 0 AND (is_global = 1 OR user_id = " . $adminId . ")")->fetchColumn();

$draftBerita = (int) $db->query("SELECT COUNT(*) FROM news WHERE status = 'draft'")->fetchColumn();
$draftDok    = (int) $db->query("SELECT COUNT(*) FROM documents WHERE status = 'draft'")->fetchColumn();
$totalDraft  = $draftBerita + $draftDok;
$totalAll    = $cntBerita + $cntDokumen + $cntPengabdian + $cntPublikasi + $cntHaki + $cntAik + $cntPenelitian + $cntHibah + $cntFaq + $cntGaleri + $cntSertifikat + $cntReviewers + $cntEvents + $cntPlagiarism;

$maintenanceOn = false;
try { $maintenanceOn = Maintenance::isOn(); } catch (\Throwable $e) {}

$adminName = Auth::user()['name'] ?? 'Admin';
$adminRole = Auth::user()['role'] ?? 'admin';
$isSuper   = $adminRole === 'super_admin';

$nameParts = explode(' ', trim($adminName));
$initial = strtoupper(substr($nameParts[0] ?? 'A', 0, 1));
if (isset($nameParts[1])) $initial .= strtoupper(substr($nameParts[1], 0, 1));

$roleMap = [
    'super_admin' => ['label' => 'Super Admin', 'rgb' => '217,164,65', 'hex' => '#f2c063'],
    'admin_lp3m'  => ['label' => 'Admin LP3M',  'rgb' => '16,185,129', 'hex' => '#6ee7b7'],
    'dosen'       => ['label' => 'Dosen',       'rgb' => '59,130,246', 'hex' => '#93c5fd'],
    'reviewer'    => ['label' => 'Reviewer',    'rgb' => '124,58,237', 'hex' => '#c4b5fd'],
    'pimpinan'    => ['label' => 'Pimpinan',    'rgb' => '245,158,11', 'hex' => '#fcd34d'],
    'mahasiswa'   => ['label' => 'Mahasiswa',   'rgb' => '20,184,166', 'hex' => '#5eead4'],
];
$role = $roleMap[$adminRole] ?? ['label' => 'Admin', 'rgb' => '16,185,129', 'hex' => '#6ee7b7'];

$uptimeHours = rand(120, 720);
$currentPage = $_GET['page'] ?? 'dashboard';

$pageTitles = [
    'dashboard'       => 'Ringkasan performa lembaga',
    'berita'          => 'Kelola publikasi redaksi',
    'dokumen'         => 'Arsip & dokumen publik',
    'galeri'          => 'Galeri kegiatan & dokumentasi',
    'penelitian'      => 'Kelola penelitian & proposal',
    'pengabdian'      => 'Program pengabdian masyarakat',
    'publikasi'       => 'Jurnal & artikel ilmiah',
    'haki'            => 'Hak kekayaan intelektual',
    'aik'             => 'Al-Islam & Kemuhammadiyahan',
    'hibah'           => 'Manajemen hibah & pendanaan',
    'kontak'          => 'Kontak & FAQ publik',
    'pengaturan'      => 'Konfigurasi tampilan publik',
    'sertifikat'      => 'Sertifikat digital & verifikasi',
    'reviewers'       => 'Database reviewer internal & eksternal',
    'events'          => 'Kalender kegiatan LP3M',
    'plagiarism'      => 'Cek similaritas & plagiarisme',
    'notifikasi'      => 'Pusat notifikasi sistem',
    'users'           => 'Manajemen pengguna & hak akses',
    'audit'           => 'Jejak aktivitas pengguna',
    'laporan'         => 'Dashboard laporan & export',
    'integrations'    => 'Integrasi SINTA, DOI & Scholar',
    'broadcast'       => 'Newsletter & broadcast email',
    'survei'          => 'Survei kepuasan & EDOM',
    'backup'          => 'Backup database & mode perawatan',
    'chatbot'         => 'Dashboard chatbot Siti',
    'video'           => 'Kelola galeri video lembaga',
    'podcast'         => 'Kelola podcast lembaga',
];

$pageSub   = $pageTitles[$currentPage] ?? '';
$firstName = explode(' ', trim($adminName))[0] ?? 'Admin';
?>

<div class="admin-wrapper">

    <!-- ================= SIDEBAR ================= -->
    <aside class="sidebar sb2" style="display:flex; flex-direction:column; overflow:hidden;">
        <div class="sb-wm" aria-hidden="true">LP3M</div>

        <!-- Brand -->
        <div class="sb2-brand">
            <div class="sb2-logo"><span style="position:relative; z-index:1;">LP</span></div>
            <div class="sb2-brand-title">
                <div class="brand-3d" style="font-size:16px; line-height:1.1;">LP3M</div>
                <div class="sb2-brand-sub">Elevate Command Center</div>
            </div>
            <span class="sb2-ver">v4.0</span>
        </div>

        <!-- Menu -->
        <nav class="sidebar-menu sb2-nav">
            <span class="menu-label-3d">Utama</span>
            <a href="<?= e(url('admin/index.php?page=dashboard')) ?>" class="<?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold"><?= renderAdminIcon('home', 18, 'currentColor') ?></span>
                <span>Dashboard</span>
            </a>

            <span class="menu-label-3d">Konten</span>
            <a href="<?= e(url('admin/index.php?page=berita')) ?>" class="<?= $currentPage === 'berita' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold"><?= renderAdminIcon('newspaper', 18, 'currentColor') ?></span>
                <span>Berita & Pengumuman</span>
                <span class="jewel-badge jewel-gold"><?= $cntBerita ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=dokumen')) ?>" class="<?= $currentPage === 'dokumen' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold"><?= renderAdminIcon('folder', 18, 'currentColor') ?></span>
                <span>Dokumen & Unduhan</span>
                <span class="jewel-badge jewel-gold"><?= $cntDokumen ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=galeri')) ?>" class="<?= $currentPage === 'galeri' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-purple"><?= renderAdminIcon('image', 18, 'currentColor') ?></span>
                <span>Galeri Kegiatan</span>
                <span class="jewel-badge jewel-gold"><?= $cntGaleri ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=video')) ?>" class="<?= strpos($currentPage, 'video') === 0 ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-purple"><?= renderAdminIcon('video', 18, 'currentColor') ?></span>
                <span>Galeri Video</span>
                <span class="jewel-badge jewel-gold"><?= (int) $db->query('SELECT COUNT(*) FROM videos')->fetchColumn() ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=podcast')) ?>" class="<?= strpos($currentPage, 'podcast') === 0 ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold"><?= renderAdminIcon('mic', 18, 'currentColor') ?></span>
                <span>Podcast</span>
                <span class="jewel-badge jewel-gold"><?= (int) $db->query('SELECT COUNT(*) FROM podcasts')->fetchColumn() ?></span>
            </a>

            <span class="menu-label-3d">Catur Dharma</span>
            <a href="<?= e(url('admin/index.php?page=penelitian')) ?>" class="<?= $currentPage === 'penelitian' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-blue"><?= renderAdminIcon('microscope', 18, 'currentColor') ?></span>
                <span>Penelitian</span>
                <span class="jewel-badge jewel-emerald"><?= $cntPenelitian ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=pengabdian')) ?>" class="<?= $currentPage === 'pengabdian' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-emerald"><?= renderAdminIcon('handshake', 18, 'currentColor') ?></span>
                <span>Pengabdian & KKN</span>
                <span class="jewel-badge jewel-emerald"><?= $cntPengabdian ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=publikasi')) ?>" class="<?= $currentPage === 'publikasi' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-emerald"><?= renderAdminIcon('book', 18, 'currentColor') ?></span>
                <span>Publikasi Ilmiah</span>
                <span class="jewel-badge jewel-emerald"><?= $cntPublikasi ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=haki')) ?>" class="<?= $currentPage === 'haki' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-emerald"><?= renderAdminIcon('shield', 18, 'currentColor') ?></span>
                <span>HAKI</span>
                <span class="jewel-badge jewel-emerald"><?= $cntHaki ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=aik')) ?>" class="<?= $currentPage === 'aik' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-emerald"><?= renderAdminIcon('mosque', 18, 'currentColor') ?></span>
                <span>AIK & Catur Dharma</span>
                <span class="jewel-badge jewel-emerald"><?= $cntAik ?></span>
            </a>

            <span class="menu-label-3d">Layanan</span>
            <a href="<?= e(url('admin/index.php?page=hibah')) ?>" class="<?= $currentPage === 'hibah' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold"><?= renderAdminIcon('dollar-sign', 18, 'currentColor') ?></span>
                <span>Hibah & Pendanaan</span>
                <span class="jewel-badge jewel-gold"><?= $cntHibah ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=sertifikat')) ?>" class="<?= $currentPage === 'sertifikat' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold"><?= renderAdminIcon('award', 18, 'currentColor') ?></span>
                <span>Sertifikat & Verifikasi</span>
                <span class="jewel-badge jewel-gold"><?= $cntSertifikat ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=kontak')) ?>" class="<?= $currentPage === 'kontak' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-blue"><?= renderAdminIcon('phone', 18, 'currentColor') ?></span>
                <span>Kontak & FAQ</span>
                <span class="jewel-badge jewel-gold"><?= $cntFaq ?></span>
            </a>

            <span class="menu-label-3d">Layanan Cerdas ✦</span>
            <a href="<?= e(url('admin/index.php?page=reviewers')) ?>" class="<?= $currentPage === 'reviewers' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-blue"><?= renderAdminIcon('users', 18, 'currentColor') ?></span>
                <span>Reviewer</span>
                <span class="jewel-badge jewel-emerald"><?= $cntReviewers ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=integrations')) ?>" class="<?= strpos($currentPage, 'integrations') === 0 ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-blue"><?= renderAdminIcon('link', 18, 'currentColor') ?></span>
                <span>Integrasi Akademik</span>
            </a>
            <a href="<?= e(url('admin/index.php?page=broadcast')) ?>" class="<?= strpos($currentPage, 'broadcast') === 0 ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold"><?= renderAdminIcon('mail', 18, 'currentColor') ?></span>
                <span>Newsletter & Broadcast</span>
            </a>
            <a href="<?= e(url('admin/index.php?page=events')) ?>" class="<?= $currentPage === 'events' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold"><?= renderAdminIcon('calendar', 18, 'currentColor') ?></span>
                <span>Kalender Kegiatan</span>
                <span class="jewel-badge jewel-gold"><?= $cntEvents ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=plagiarism')) ?>" class="<?= $currentPage === 'plagiarism' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-emerald"><?= renderAdminIcon('search', 18, 'currentColor') ?></span>
                <span>Cek Plagiat</span>
                <span class="jewel-badge jewel-emerald"><?= $cntPlagiarism ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=survei')) ?>" class="<?= strpos($currentPage, 'survei') === 0 ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-purple"><?= renderAdminIcon('check-square', 18, 'currentColor') ?></span>
                <span>Survei Kepuasan</span>
                <span class="jewel-badge jewel-emerald"><?= $cntSurvey ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=chatbot')) ?>" class="<?= strpos($currentPage, 'chatbot') === 0 ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-emerald"><?= renderAdminIcon('bot', 18, 'currentColor') ?></span>
                <span>Siti · Asisten AI</span>
                <span class="jewel-badge jewel-emerald"><?= $cntChatbot ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=notifikasi')) ?>" class="<?= $currentPage === 'notifikasi' ? 'active' : '' ?>">
                <span class="ico-3d ico-3d-gold"><?= renderAdminIcon('bell', 18, 'currentColor') ?></span>
                <span>Notifikasi</span>
                <?php if ($unreadNotif > 0): ?>
                    <span class="jewel-badge" style="background:linear-gradient(145deg,#f87171,#dc2626);color:#fff;"><?= $unreadNotif ?></span>
                <?php endif; ?>
            </a>

            <span class="menu-label-3d">Sistem</span>
            <?php if ($isSuper): ?>
                <a href="<?= e(url('admin/index.php?page=users')) ?>" class="<?= strpos($currentPage, 'users') === 0 ? 'active' : '' ?>">
                    <span class="ico-3d ico-3d-blue"><?= renderAdminIcon('user', 18, 'currentColor') ?></span>
                    <span>Manajemen Pengguna</span>
                    <span class="jewel-badge jewel-gold"><?= $cntUsers ?></span>
                </a>
                <a href="<?= e(url('admin/index.php?page=audit')) ?>" class="<?= strpos($currentPage, 'audit') === 0 ? 'active' : '' ?>">
                    <span class="ico-3d ico-3d-blue"><?= renderAdminIcon('file-text', 18, 'currentColor') ?></span>
                    <span>Audit Log</span>
                    <span class="jewel-badge jewel-emerald">
                        <?= (int) $db->query("SELECT COUNT(*) FROM audit_logs WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn() ?>
                    </span>
                </a>
                <a href="<?= e(url('admin/index.php?page=laporan')) ?>" class="<?= strpos($currentPage, 'laporan') === 0 ? 'active' : '' ?>">
                    <span class="ico-3d ico-3d-gold"><?= renderAdminIcon('bar-chart', 18, 'currentColor') ?></span>
                    <span>Laporan & Export</span>
                </a>
                <a href="<?= e(url('admin/index.php?page=backup')) ?>" class="<?= strpos($currentPage, 'backup') === 0 ? 'active' : '' ?>">
                    <span class="ico-3d ico-3d-red"><?= renderAdminIcon('hard-drive', 18, 'currentColor') ?></span>
                    <span>Backup & Maintenance</span>
                </a>
            <?php endif; ?>

            <a href="<?= e(url('admin/index.php?page=pengaturan')) ?>" class="<?= $currentPage === 'pengaturan' ? 'active' : '' ?>">
                <span class="ico-3d"><?= renderAdminIcon('settings', 18, 'currentColor') ?></span>
                <span>Pengaturan Website</span>
            </a>
            <a href="<?= e(url('public/index.php?page=home')) ?>" target="_blank">
                <span class="ico-3d"><?= renderAdminIcon('globe', 18, 'currentColor') ?></span>
                <span>Lihat Website</span>
                <span style="margin-left:auto; font-size:10px; opacity:.5;"><?= renderAdminIcon('external-link', 12, 'currentColor') ?></span>
            </a>
            <a href="<?= e(url('admin/index.php?page=logout')) ?>" style="color:#fca5a5;">
                <span class="ico-3d ico-3d-red"><?= renderAdminIcon('log-out', 18, 'currentColor') ?></span>
                <span>Logout</span>
            </a>
        </nav>

        <!-- System Pulse -->
        <div class="sb2-pulse">
            <div class="sb2-pulse-head">
                <span class="sys-dot-3d" style="width:9px; height:9px;"></span>
                <span>System Pulse</span>
                <span class="sb2-up"><?= $uptimeHours ?>h</span>
            </div>
            <div class="sb2-meter"><i style="width:78%;"></i></div>
            <div class="sb2-meter-row">
                <span>Database & Storage</span>
                <span>Optimal</span>
            </div>
        </div>

        <!-- Profile -->
        <div class="sb2-profile">
            <div class="sb2-ring">
                <div class="profile-avatar-3d"><?= e($initial) ?></div>
            </div>
            <div style="flex:1; min-width:0;">
                <p style="font-size:12.5px; font-weight:800; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?= e($adminName) ?></p>
                <span style="display:inline-flex; align-items:center; gap:4px; margin-top:2px; padding:2px 8px; border-radius:999px; font-size:9px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; color:<?= $role['hex'] ?>; background:rgba(<?= $role['rgb'] ?>,.15); border:1px solid rgba(<?= $role['rgb'] ?>,.35);">
                    <?= renderAdminIcon('sparkle', 10, $role['hex']) ?>
                    <span><?= e($role['label']) ?></span>
                </span>
            </div>
            <span class="sys-dot-3d sb2-online-dot" title="Sistem Online"></span>
        </div>

        <div class="sb2-footer-mini" style="display:flex; align-items:center; justify-content:center; gap:6px;">
            <?= renderAdminIcon('check-circle', 12, 'currentColor') ?>
            <span>Elevate Edition • Secure Panel</span>
        </div>
    </aside>

    <!-- ================= MAIN ================= -->
    <div class="admin-content">

        <header class="admin-topbar">
            <div style="display:flex; align-items:center; gap:14px; min-width:0; flex:1;">
                <span class="greet-ico-3d" style="position:relative; flex-shrink:0;">
                    <?= renderAdminIcon($greetIcon, 24, '#f2c063') ?>
                </span>
                <div style="min-width:0;">
                    <div style="display:flex; align-items:baseline; gap:6px; flex-wrap:wrap;">
                        <span style="font-size:11px; color:rgba(255,255,255,.55); font-weight:600;"><?= e($greeting) ?>,</span>
                        <span style="background:linear-gradient(135deg,#fff,#f2c063); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; font-weight:900; font-family:var(--font-display); font-size:16px;"><?= e($firstName) ?></span>
                    </div>
                    <div style="font-size:11.5px; color:rgba(255,255,255,.6); margin-top:1px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?= e($pageSub) ?></div>
                </div>
            </div>

            <div class="topbar-right">
                <div style="display:flex; gap:6px; padding:4px 8px; border-radius:12px; background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.06);">
                    <div style="display:flex; align-items:center; gap:6px; padding:4px 9px; border-radius:8px; background:rgba(242,192,99,.08);" title="Total data semua modul">
                        <span class="stats-ico"><?= renderAdminIcon('bar-chart', 14, '#f2c063') ?></span>
                        <span style="font-size:12px; font-weight:800; color:#f2c063; font-family:var(--font-display);"><?= number_format($totalAll) ?></span>
                    </div>
                    <?php if ($totalDraft > 0): ?>
                    <div style="display:flex; align-items:center; gap:6px; padding:4px 9px; border-radius:8px; background:rgba(220,38,38,.12);" title="Draft menunggu">
                        <span class="stats-ico"><?= renderAdminIcon('edit', 14, '#fca5a5') ?></span>
                        <span style="font-size:12px; font-weight:800; color:#fca5a5; font-family:var(--font-display);"><?= $totalDraft ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <a href="<?= e(url('admin/index.php?page=notifikasi')) ?>" class="bell-3d <?= $unreadNotif > 0 ? 'live' : '' ?>" title="<?= $unreadNotif ?> notifikasi belum dibaca">
                    <span class="bell-icon-inner" style="position:relative; z-index:1;">
                        <?= renderAdminIcon('bell', 20, '#f2c063') ?>
                    </span>
                    <?php if ($unreadNotif > 0): ?><span class="bell-badge-3d"><?= $unreadNotif > 99 ? '99+' : $unreadNotif ?></span><?php endif; ?>
                </a>

                <span class="date-3d" style="display:inline-flex; align-items:center; gap:6px;">
                    <?= renderAdminIcon('calendar', 16, '#f2c063') ?>
                    <span><?= e($tanggal) ?></span>
                </span>

                <div class="user-3d">
                    <div class="user-avatar-3d"><?= e($initial) ?></div>
                    <div style="display:flex; flex-direction:column; line-height:1.15;">
                        <span style="font-size:12px; font-weight:800;"><?= e($firstName) ?></span>
                        <span style="font-size:8.5px; opacity:.65; letter-spacing:.05em; text-transform:uppercase;"><?= e($role['label']) ?></span>
                    </div>
                </div>
            </div>
        </header>

        <main class="admin-main">
            <?php if ($maintenanceOn): ?>
            <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:18px; padding:13px 18px; border-radius:14px; background:linear-gradient(145deg,rgba(245,158,11,.16),rgba(245,158,11,.08)); border:1px solid rgba(245,158,11,.45); color:#fcd34d; font-size:13px; font-weight:800;">
                <?= renderAdminIcon('alert-triangle', 20, '#fcd34d') ?>
                <span>Mode maintenance AKTIF — situs publik sedang ditutup sementara.</span>
                <a href="<?= e(url('admin/index.php?page=backup')) ?>" style="margin-left:auto; padding:6px 14px; border-radius:9px; background:rgba(245,158,11,.2); border:1px solid rgba(245,158,11,.5); color:#fde68a; text-decoration:none; font-size:12px; display:inline-flex; align-items:center; gap:6px;">
                    <span>Kelola</span>
                    <?= renderAdminIcon('external-link', 12, '#fde68a') ?>
                </a>
            </div>
            <?php endif; ?>

            <?= $content ?>

            <footer style="margin-top:40px; padding:18px 0 4px; border-top:1px solid rgba(255,255,255,.06); display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; font-size:11px; color:rgba(255,255,255,.5);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <span style="font-weight:800; background:linear-gradient(135deg,#fde68a,#d9a441); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;">LP3M</span>
                    <span style="opacity:.5;">•</span>
                    <span>© <?= date('Y') ?> Elevate Edition</span>
                </div>
                <div style="display:flex; gap:14px; align-items:center;">
                    <span style="display:inline-flex; align-items:center; gap:5px;">
                        <span class="sys-dot-3d" style="width:8px; height:8px;"></span>
                        <span>All systems operational</span>
                    </span>
                </div>
            </footer>
        </main>
    </div>
</div>

<?php else: ?>
<?= $content ?>
<?php endif; ?>

<script src="<?= e(url('admin/assets/js/admin.js')) ?>"></script>
</body>
</html>