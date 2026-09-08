<?php

require dirname(__DIR__) . '/app/bootstrap.php';

$page = $_GET['page'] ?? 'dashboard';

// ── Logout ──────────────────────────────────────────────
if ($page === 'logout') {
    Auth::logout();
    redirect(url('admin/index.php?page=login'));
}

// ── Login ───────────────────────────────────────────────
if ($page === 'login') {
    if (Auth::check()) {
        redirect(url('admin/index.php?page=dashboard'));
    }

    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            $error = 'Token keamanan tidak valid. Silakan coba lagi.';
        } else {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($email === '' || $password === '') {
                $error = 'Email dan password wajib diisi.';
            } else {
                $stmt = Database::pdo()->prepare(
                    'SELECT * FROM users WHERE email = ? AND is_active = 1 LIMIT 1'
                );
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    Auth::login($user);
                    redirect(url('admin/index.php?page=dashboard'));
                } else {
                    $error = 'Email atau password salah.';
                }
            }
        }
    }

    View::render('admin/login', [
        'title' => 'Login Admin | ' . APP_NAME,
        'error' => $error,
    ], 'layouts/admin');

    exit;
}

// ── Guard: harus login ─────────────────────────────────
Auth::guard();

// ── Routing ─────────────────────────────────────────────
switch ($page) {

    // ── Dashboard ───────────────────────────────────────
    case 'dashboard':
        View::render('admin/dashboard', [
            'title' => 'Dashboard Admin | ' . APP_NAME,
        ], 'layouts/admin');
        break;

    // ── Berita & Pengumuman ─────────────────────────────
    case 'berita':         AdminNews::index();                              break;
    case 'berita-tambah':  AdminNews::create();                             break;
    case 'berita-simpan':  AdminNews::store();                              break;
    case 'berita-edit':    AdminNews::edit((int) ($_GET['id'] ?? 0));       break;
    case 'berita-update':  AdminNews::update();                             break;
    case 'berita-hapus':   AdminNews::destroy();                            break;
    case 'berita-bulk': AdminNews::bulk(); break;

    // ── Dokumen & Unduhan ───────────────────────────────
    case 'dokumen':         AdminDocuments::index();                        break;
    case 'dokumen-tambah':  AdminDocuments::create();                       break;
    case 'dokumen-simpan':  AdminDocuments::store();                        break;
    case 'dokumen-edit':    AdminDocuments::edit((int) ($_GET['id'] ?? 0)); break;
    case 'dokumen-update':  AdminDocuments::update();                       break;
    case 'dokumen-hapus':   AdminDocuments::destroy();                      break;

    // ── Penelitian ──────────────────────────────────────
    case 'penelitian':         AdminResearch::index();                         break;
    case 'penelitian-tambah':  AdminResearch::create();                        break;
    case 'penelitian-simpan':  AdminResearch::store();                         break;
    case 'penelitian-edit':    AdminResearch::edit((int) ($_GET['id'] ?? 0));  break;
    case 'penelitian-update':  AdminResearch::update();                        break;
    case 'penelitian-hapus':   AdminResearch::destroy();                       break;

    // ── Pengabdian & KKN ────────────────────────────────
    case 'pengabdian':         AdminCommunity::index();                        break;
    case 'pengabdian-tambah':  AdminCommunity::create();                       break;
    case 'pengabdian-simpan':  AdminCommunity::store();                        break;
    case 'pengabdian-edit':    AdminCommunity::edit((int) ($_GET['id'] ?? 0)); break;
    case 'pengabdian-update':  AdminCommunity::update();                       break;
    case 'pengabdian-hapus':   AdminCommunity::destroy();                      break;

    // ── Publikasi Ilmiah ────────────────────────────────
    case 'publikasi':         AdminPublication::index();                        break;
    case 'publikasi-tambah':  AdminPublication::create();                       break;
    case 'publikasi-simpan':  AdminPublication::store();                        break;
    case 'publikasi-edit':    AdminPublication::edit((int) ($_GET['id'] ?? 0)); break;
    case 'publikasi-update':  AdminPublication::update();                       break;
    case 'publikasi-hapus':   AdminPublication::destroy();                      break;

    // ── HAKI ────────────────────────────────────────────
    case 'haki':         AdminHaki::index();                              break;
    case 'haki-tambah':  AdminHaki::create();                             break;
    case 'haki-simpan':  AdminHaki::store();                              break;
    case 'haki-edit':    AdminHaki::edit((int) ($_GET['id'] ?? 0));       break;
    case 'haki-update':  AdminHaki::update();                             break;
    case 'haki-hapus':   AdminHaki::destroy();                            break;

    // ── AIK & Catur Dharma ──────────────────────────────
    case 'aik':         AdminAik::index();                              break;
    case 'aik-tambah':  AdminAik::create();                             break;
    case 'aik-simpan':  AdminAik::store();                              break;
    case 'aik-edit':    AdminAik::edit((int) ($_GET['id'] ?? 0));       break;
    case 'aik-update':  AdminAik::update();                             break;
    case 'aik-hapus':   AdminAik::destroy();                            break;

    // ── Hibah & Pendanaan ───────────────────────────────
    case 'hibah':         AdminGrant::index();                              break;
    case 'hibah-tambah':  AdminGrant::create();                             break;
    case 'hibah-simpan':  AdminGrant::store();                              break;
    case 'hibah-edit':    AdminGrant::edit((int) ($_GET['id'] ?? 0));       break;
    case 'hibah-update':  AdminGrant::update();                             break;
    case 'hibah-hapus':   AdminGrant::destroy();                            break;

    // ── Kontak & FAQ ───────────────────────────────────
    case 'kontak':              AdminContact::index();                              break;
    case 'kontak-simpan':       AdminContact::updateContact();                      break;
    case 'kontak-faq-tambah':   AdminContact::createFaqForm();                      break;
    case 'kontak-faq-simpan':   AdminContact::storeFaq();                           break;
    case 'kontak-faq-edit':     AdminContact::editFaqForm((int) ($_GET['id'] ?? 0)); break;
    case 'kontak-faq-update':   AdminContact::updateFaq();                          break;
    case 'kontak-faq-hapus':    AdminContact::destroyFaq();                         break;

    case 'galeri':         AdminGallery::index();                            break;
    case 'galeri-tambah':  AdminGallery::create();                           break;
    case 'galeri-simpan':  AdminGallery::store();                            break;
    case 'galeri-edit':    AdminGallery::edit((int) ($_GET['id'] ?? 0));     break;
    case 'galeri-update':  AdminGallery::update();                           break;
    case 'galeri-hapus':   AdminGallery::destroy();                          break;

    case 'sertifikat':          AdminCertificate::index();                          break;
    case 'sertifikat-tambah':   AdminCertificate::create();                         break;
    case 'sertifikat-simpan':   AdminCertificate::store();                          break;
    case 'sertifikat-edit':     AdminCertificate::edit((int) ($_GET['id'] ?? 0));   break;
    case 'sertifikat-update':   AdminCertificate::update();                         break;
    case 'sertifikat-cabut':    AdminCertificate::revoke();                         break;
    case 'sertifikat-aktifkan': AdminCertificate::restore();                        break;
    case 'sertifikat-hapus':    AdminCertificate::destroy();                        break;

    // ── Pengaturan Website ──────────────────────────────
    case 'pengaturan':        AdminSettings::edit();   break;
    case 'pengaturan-simpan': AdminSettings::update(); break;
    
    // ── 404 ─────────────────────────────────────────────
    default:
        http_response_code(404);
        echo '<h1>404</h1><p>Halaman admin tidak ditemukan.</p>';
        break;
}