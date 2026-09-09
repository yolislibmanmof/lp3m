<?php

require dirname(__DIR__) . '/app/bootstrap.php';

$page = $_GET['page'] ?? 'dashboard';

// ══════════════════════════════════════════════════════════════
// LOGOUT
// ══════════════════════════════════════════════════════════════
if ($page === 'logout') {
    Auth::logout();
    redirect(url('admin/index.php?page=login'));
}

// ══════════════════════════════════════════════════════════════
// LOGIN (publik, sebelum guard)
// ══════════════════════════════════════════════════════════════
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

// ══════════════════════════════════════════════════════════════
// GUARD: wajib login sebelum mengakses route lain
// ══════════════════════════════════════════════════════════════
Auth::guard();

// ══════════════════════════════════════════════════════════════
// ROUTING
// ══════════════════════════════════════════════════════════════
switch ($page) {

    // ── Dashboard ─────────────────────────────────────────────
    case 'dashboard':
        AdminDashboard::index();
        break;

    // ── Berita & Pengumuman ───────────────────────────────────
    case 'berita':
        AdminNews::index();
        break;
    case 'berita-tambah':
        AdminNews::create();
        break;
    case 'berita-simpan':
        AdminNews::store();
        break;
    case 'berita-edit':
        AdminNews::edit((int) ($_GET['id'] ?? 0));
        break;
    case 'berita-update':
        AdminNews::update();
        break;
    case 'berita-hapus':
        AdminNews::destroy();
        break;
    case 'berita-bulk':
        AdminNews::bulk();
        break;

    // ── Dokumen & Unduhan ─────────────────────────────────────
    case 'dokumen':
        AdminDocuments::index();
        break;
    case 'dokumen-tambah':
        AdminDocuments::create();
        break;
    case 'dokumen-simpan':
        AdminDocuments::store();
        break;
    case 'dokumen-edit':
        AdminDocuments::edit((int) ($_GET['id'] ?? 0));
        break;
    case 'dokumen-update':
        AdminDocuments::update();
        break;
    case 'dokumen-hapus':
        AdminDocuments::destroy();
        break;

    // ── Galeri Kegiatan ───────────────────────────────────────
    case 'galeri':
        AdminGallery::index();
        break;
    case 'galeri-tambah':
        AdminGallery::create();
        break;
    case 'galeri-simpan':
        AdminGallery::store();
        break;
    case 'galeri-edit':
        AdminGallery::edit((int) ($_GET['id'] ?? 0));
        break;
    case 'galeri-update':
        AdminGallery::update();
        break;
    case 'galeri-hapus':
        AdminGallery::destroy();
        break;

    // ── Penelitian ────────────────────────────────────────────
    case 'penelitian':
        AdminResearch::index();
        break;
    case 'penelitian-tambah':
        AdminResearch::create();
        break;
    case 'penelitian-simpan':
        AdminResearch::store();
        break;
    case 'penelitian-edit':
        AdminResearch::edit((int) ($_GET['id'] ?? 0));
        break;
    case 'penelitian-update':
        AdminResearch::update();
        break;
    case 'penelitian-hapus':
        AdminResearch::destroy();
        break;

    // ── Pengabdian & KKN ──────────────────────────────────────
    case 'pengabdian':
        AdminCommunity::index();
        break;
    case 'pengabdian-tambah':
        AdminCommunity::create();
        break;
    case 'pengabdian-simpan':
        AdminCommunity::store();
        break;
    case 'pengabdian-edit':
        AdminCommunity::edit((int) ($_GET['id'] ?? 0));
        break;
    case 'pengabdian-update':
        AdminCommunity::update();
        break;
    case 'pengabdian-hapus':
        AdminCommunity::destroy();
        break;

    // ── Publikasi Ilmiah ──────────────────────────────────────
    case 'publikasi':
        AdminPublication::index();
        break;
    case 'publikasi-tambah':
        AdminPublication::create();
        break;
    case 'publikasi-simpan':
        AdminPublication::store();
        break;
    case 'publikasi-edit':
        AdminPublication::edit((int) ($_GET['id'] ?? 0));
        break;
    case 'publikasi-update':
        AdminPublication::update();
        break;
    case 'publikasi-hapus':
        AdminPublication::destroy();
        break;

    // ── HAKI (Hak Kekayaan Intelektual) ───────────────────────
    case 'haki':
        AdminHaki::index();
        break;
    case 'haki-tambah':
        AdminHaki::create();
        break;
    case 'haki-simpan':
        AdminHaki::store();
        break;
    case 'haki-edit':
        AdminHaki::edit((int) ($_GET['id'] ?? 0));
        break;
    case 'haki-update':
        AdminHaki::update();
        break;
    case 'haki-hapus':
        AdminHaki::destroy();
        break;

    // ── AIK & Catur Dharma ────────────────────────────────────
    case 'aik':
        AdminAik::index();
        break;
    case 'aik-tambah':
        AdminAik::create();
        break;
    case 'aik-simpan':
        AdminAik::store();
        break;
    case 'aik-edit':
        AdminAik::edit((int) ($_GET['id'] ?? 0));
        break;
    case 'aik-update':
        AdminAik::update();
        break;
    case 'aik-hapus':
        AdminAik::destroy();
        break;

    // ── Hibah & Pendanaan ─────────────────────────────────────
    case 'hibah':
        AdminGrant::index();
        break;
    case 'hibah-tambah':
        AdminGrant::create();
        break;
    case 'hibah-simpan':
        AdminGrant::store();
        break;
    case 'hibah-edit':
        AdminGrant::edit((int) ($_GET['id'] ?? 0));
        break;
    case 'hibah-update':
        AdminGrant::update();
        break;
    case 'hibah-hapus':
        AdminGrant::destroy();
        break;

    // ── Kontak & FAQ ──────────────────────────────────────────
    case 'kontak':
        AdminContact::index();
        break;
    case 'kontak-simpan':
        AdminContact::updateContact();
        break;
    case 'kontak-faq-tambah':
        AdminContact::createFaqForm();
        break;
    case 'kontak-faq-simpan':
        AdminContact::storeFaq();
        break;
    case 'kontak-faq-edit':
        AdminContact::editFaqForm((int) ($_GET['id'] ?? 0));
        break;
    case 'kontak-faq-update':
        AdminContact::updateFaq();
        break;
    case 'kontak-faq-hapus':
        AdminContact::destroyFaq();
        break;

    // ── Sertifikat Digital & Verifikasi ───────────────────────
    case 'sertifikat':
        AdminCertificate::index();
        break;
    case 'sertifikat-tambah':
        AdminCertificate::create();
        break;
    case 'sertifikat-simpan':
        AdminCertificate::store();
        break;
    case 'sertifikat-edit':
        AdminCertificate::edit((int) ($_GET['id'] ?? 0));
        break;
    case 'sertifikat-update':
        AdminCertificate::update();
        break;
    case 'sertifikat-cabut':
        AdminCertificate::revoke();
        break;
    case 'sertifikat-aktifkan':
        AdminCertificate::restore();
        break;
    case 'sertifikat-hapus':
        AdminCertificate::destroy();
        break;

    // ── Reviewer (Database Pakar) ─────────────────────────────
    case 'reviewers':
        AdminReviewer::index();
        break;
    case 'reviewers-tambah':
        AdminReviewer::create();
        break;
    case 'reviewers-simpan':
        AdminReviewer::store();
        break;
    case 'reviewers-edit':
        AdminReviewer::edit((int) ($_GET['id'] ?? 0));
        break;
    case 'reviewers-update':
        AdminReviewer::update();
        break;
    case 'reviewers-hapus':
        AdminReviewer::destroy();
        break;
    case 'reviewers-assign':
        AdminReviewer::assign();
        break;
    case 'reviewers-selesai':
        AdminReviewer::complete();
        break;

    // ── Kalender Kegiatan & Event ─────────────────────────────
    case 'events':
        AdminEvent::index();
        break;
    case 'events-tambah':
        AdminEvent::create();
        break;
    case 'events-simpan':
        AdminEvent::store();
        break;
    case 'events-edit':
        AdminEvent::edit((int) ($_GET['id'] ?? 0));
        break;
    case 'events-update':
        AdminEvent::update();
        break;
    case 'events-hapus':
        AdminEvent::destroy();
        break;

    // ── Cek Plagiat & Similaritas ─────────────────────────────
    case 'plagiarism':
        AdminPlagiarism::index();
        break;
    case 'plagiarism-tambah':
        AdminPlagiarism::create();
        break;
    case 'plagiarism-simpan':
        AdminPlagiarism::store();
        break;
    case 'plagiarism-lihat':
        AdminPlagiarism::show((int) ($_GET['id'] ?? 0));
        break;
    case 'plagiarism-manual':
        AdminPlagiarism::manualScore();
        break;
    case 'plagiarism-ekstrak':
        AdminPlagiarism::reextract();
        break;
    case 'plagiarism-ulang':
        AdminPlagiarism::recheck();
        break;
    case 'plagiarism-export':
        AdminPlagiarism::export();
        break;
    case 'plagiarism-analisis':
        AdminPlagiarism::analyzeNow();
        break;
    case 'plagiarism-hapus':
        AdminPlagiarism::destroy();
        break;

    // ── Notifikasi & Pusat Informasi ──────────────────────────
    case 'notifikasi':
        AdminNotification::index();
        break;
    case 'notifikasi-baca':
        AdminNotification::markRead();
        break;
    case 'notifikasi-baca-semua':
        AdminNotification::markAll();
        break;
    case 'notifikasi-bulk-baca':
        AdminNotification::bulkMarkRead();
        break;
    case 'notifikasi-bersihkan':
        AdminNotification::clearRead();
        break;
    case 'notifikasi-hapus':
        AdminNotification::destroy();
        break;

    // ── Pengaturan Website ────────────────────────────────────
    case 'pengaturan':
        AdminSettings::edit();
        break;
    case 'pengaturan-simpan':
        AdminSettings::update();
        break;

    // ── Audit Log (Activity Trail) ──────────────────────────
    case 'audit':
        AdminAuditLog::index();
        break;
    case 'audit-detail':
        AdminAuditLog::detail((int) ($_GET['id'] ?? 0));
        break;
    case 'audit-export':
        AdminAuditLog::export();
        break;
    case 'audit-hapus':
        AdminAuditLog::destroy();
        break;

    // ── Laporan & Export ───────────────────────────────────
    case 'laporan':
        AdminReport::index();
        break;
    case 'laporan-modul':
        AdminReport::module((string) ($_GET['modul'] ?? ''), $_GET['start'] ?? '', $_GET['end'] ?? '');
        break;
    case 'laporan-export-csv':
        AdminReport::exportCsv((string) ($_GET['modul'] ?? ''), $_GET['start'] ?? '', $_GET['end'] ?? '');
        break;
    case 'laporan-print':
        AdminReport::printView($_GET['start'] ?? '', $_GET['end'] ?? '');
        break;
    case 'laporan-tahunan':
        AdminReport::annualReport((int) ($_GET['tahun'] ?? date('Y')));
        break;

    // ── Survei Kepuasan ────────────────────────────────────
    case 'survei':             AdminSurvey::index();  break;
    case 'survei-tambah':      AdminSurvey::create(); break;
    case 'survei-simpan':      AdminSurvey::store();  break;
    case 'survei-edit':        AdminSurvey::edit((int) ($_GET['id'] ?? 0)); break;
    case 'survei-update':      AdminSurvey::update(); break;
    case 'survei-hapus':       AdminSurvey::destroy(); break;
    case 'survei-status':      AdminSurvey::toggle(); break;
    case 'survei-hasil':       AdminSurvey::results((int) ($_GET['id'] ?? 0)); break;
    case 'survei-export':      AdminSurvey::export((int) ($_GET['id'] ?? 0)); break;

    // ── Backup & Maintenance ───────────────────────────────
    case 'backup':           AdminBackup::index();  break;
    case 'backup-buat':      AdminBackup::create(); break;
    case 'backup-zip':       AdminBackup::zipUploads(); break;
    case 'backup-unduh':    AdminBackup::download(); break;
    case 'backup-hapus':     AdminBackup::destroy(); break;
    case 'backup-restore':   AdminBackup::restore(); break;
    case 'backup-maintenance': AdminBackup::toggleMaintenance(); break;

    // ── Profil Saya (untuk semua role yang login) ──────────
    case 'profil-saya':
        AdminProfile::index();
        break;

    // ── Newsletter & Broadcast ─────────────────────────────
    case 'broadcast':                    AdminBroadcast::index(); break;
    case 'broadcast-tambah':             AdminBroadcast::create(); break;
    case 'broadcast-simpan':             AdminBroadcast::store(); break;
    case 'broadcast-kirim':              AdminBroadcast::sendNow(); break;
    case 'broadcast-hapus':              AdminBroadcast::destroy(); break;
    case 'broadcast-subscribers':        AdminBroadcast::subscribers(); break;
    case 'broadcast-subscriber-hapus':   AdminBroadcast::subscriberDelete(); break;
    case 'broadcast-subscriber-export':  AdminBroadcast::subscriberExport(); break;
    case 'broadcast-log':                AdminBroadcast::logs(); break;
    case 'broadcast-test':               AdminBroadcast::testSmtp(); break;

    // ── Integrations (SINTA, DOI, Scholar) ─────────────────
    case 'integrations':
        AdminIntegrations::index();
        break;

    case 'integrations-doi':
        AdminIntegrations::fetchDoi();
        break;

    case 'integrations-doi-live':
        AdminIntegrations::fetchDoiLive();
        break;

    case 'integrations-sinta-import':
        AdminIntegrations::importSintaCsv();
        break;

    case 'integrations-scholar':
        AdminIntegrations::fetchScholar();
        break;

    case 'integrations-log-export':
        AdminIntegrations::exportLog();
        break;

    // ── Chatbot API (endpoint publik & admin) ──────────────
    case 'chatbot-api':
        ApiChatbot::reply();
        break;

    case 'chatbot-log':
        ApiChatbot::logFeedback();
        break;

    // ── Chatbot Siti (Admin Panel) ─────────────────────────
    case 'chatbot':
        AdminChatbot::index();
        break;

    case 'chatbot-knowledge':
        AdminChatbot::knowledge();
        break;

    case 'chatbot-knowledge-save':
        AdminChatbot::knowledgeSave();
        break;

    case 'chatbot-knowledge-delete':
        AdminChatbot::knowledgeDelete();
        break;

    case 'chatbot-knowledge-toggle':
        AdminChatbot::knowledgeToggle();
        break;

    case 'chatbot-config':
        AdminChatbot::config();
        break;

    case 'chatbot-config-save':
        AdminChatbot::configSave();
        break;

    case 'chatbot-export':
        AdminChatbot::exportLogs();
        break;

    case 'chatbot-clear':
        AdminChatbot::clearLogs();
        break;

    // ── Manajemen Pengguna (khusus Super Admin) ───────────────
    case 'users':
        AdminUser::index();
        break;
    case 'users-tambah':
        AdminUser::create();
        break;
    case 'users-simpan':
        AdminUser::store();
        break;
    case 'users-edit':
        AdminUser::edit((int) ($_GET['id'] ?? 0));
        break;
    case 'users-update':
        AdminUser::update();
        break;
    case 'users-toggle':
        AdminUser::toggle();
        break;
    case 'users-reset':
        AdminUser::reset();
        break;
    case 'users-hapus':
        AdminUser::destroy();
        break;

    // ── 404 Fallback ──────────────────────────────────────────
    default:
        http_response_code(404);
        View::render('admin/errors/404', [
            'title' => '404 | Tidak Ditemukan',
            'page'  => $page,
        ], 'layouts/admin');
        break;
}