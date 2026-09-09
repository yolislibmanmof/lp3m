<?php

require dirname(__DIR__) . '/app/bootstrap.php';

// ══════════════════════════════════════════════════════════════
// 🚧 MAINTENANCE MODE — situs publik ditutup sementara
// ══════════════════════════════════════════════════════════════
if (Maintenance::isOn()) {
    Maintenance::showPage();
    exit;
}

$page = $_GET['page'] ?? 'home';

// ══════════════════════════════════════════════════════════════
// ROUTING PUBLIK
// ══════════════════════════════════════════════════════════════
switch ($page) {

    // ── Beranda & Halaman Statis ────────────────────────────
    case 'home':
        View::render('public/home', [
            'title'  => 'Beranda | ' . APP_NAME,
            'latest' => News::latest(3),
        ]);
        break;

    case 'tentang':
        View::render('public/about', [
            'title' => 'Tentang Kami | ' . APP_NAME,
        ]);
        break;

    case 'kontak':
        View::render('public/kontak/index', [
            'title'   => 'Kontak & FAQ | ' . APP_NAME,
            'contact' => ContactInfo::get(),
            'faqs'    => Faq::allActive(),
        ]);
        break;

    case 'panduan':
        View::render('public/panduan/index', [
            'title' => 'Panduan Layanan | ' . APP_NAME,
        ]);
        break;

    // ── Konten ──────────────────────────────────────────────
    case 'berita':
        PublicNews::index();
        break;

    case 'berita-detail':
        PublicNews::show(trim($_GET['slug'] ?? ''));
        break;

    case 'galeri':
        $cat = trim($_GET['cat'] ?? '');
        View::render('public/galeri/index', [
            'title' => 'Galeri Kegiatan | ' . APP_NAME,
            'items' => Gallery::byCategory($cat),
            'cats'  => Gallery::categories(),
            'cat'   => $cat,
        ]);
        break;

    // ── Catur Dharma ────────────────────────────────────────
    case 'penelitian':
        PublicResearch::index();
        break;

    case 'penelitian-detail':
        PublicResearch::show((int) ($_GET['id'] ?? 0));
        break;

    case 'pengabdian':
        PublicModules::community();
        break;

    case 'publikasi':
        PublicModules::publication();
        break;

    case 'aik':
        PublicModules::aik();
        break;

    // ── Layanan ─────────────────────────────────────────────
    case 'hibah':
        View::render('public/grants/index', [
            'title'  => 'Hibah Aktif | ' . APP_NAME,
            'active' => Grant::getActive(),
            'closed' => Grant::getClosed(),
        ]);
        break;

    case 'unduhan':
        PublicDocuments::index();
        break;

    case 'unduhan-unduh':
        PublicDocuments::download((int) ($_GET['id'] ?? 0));
        break;

    case 'sertifikat':
        $code = trim($_GET['code'] ?? '');
        $cert = $code !== '' ? Certificate::findByCode($code) : null;
        if ($cert === null) {
            http_response_code(404);
            View::render('public/errors/404', [
                'title' => 'Sertifikat Tidak Ditemukan | ' . APP_NAME,
                'message' => 'Sertifikat dengan kode <code>' . e($code) . '</code> tidak ditemukan dalam sistem kami.',
            ]);
            break;
        }
        $contact = null;
        try { $contact = ContactInfo::get(); } catch (\Throwable $e) { $contact = null; }
        View::render('public/sertifikat/template', [
            'title'       => 'Sertifikat ' . $cert['code'] . ' | ' . APP_NAME,
            'cert'        => $cert,
            'types'       => Certificate::TYPES,
            'site'        => Setting::all(),
            'contactLine' => $contact['address'] ?? '',
        ], 'layouts/print');
        break;

    case 'verifikasi-sertifikat':
        $code = trim($_GET['code'] ?? '');
        $cert = null;
        $verifyError = '';
        if ($code !== '') {
            $cert = Certificate::findByCode($code);
            if ($cert === null) {
                $verifyError = 'Kode sertifikat tidak ditemukan. Periksa kembali kode Anda.';
            }
        }
        View::render('public/verifikasi/index', [
            'title'       => 'Verifikasi Sertifikat | ' . APP_NAME,
            'cert'        => $cert,
            'code'        => $code,
            'verifyError' => $verifyError,
        ]);
        break;

    // ── Layanan Cerdas ──────────────────────────────────────
    case 'agenda':
        PublicEvent::index();
        break;

    case 'cek-plagiat':
        PublicPlagiarism::index();
        break;

    case 'cek-plagiat-kirim':
        PublicPlagiarism::submit();
        break;

    case 'cek-plagiat-lengkapi':
        PublicPlagiarism::completeWithText();
        break;

    case 'survei':
        PublicSurvey::index();
        break;

    case 'survei-isi':
        PublicSurvey::fill((int) ($_GET['id'] ?? 0));
        break;

    case 'survei-kirim':
        PublicSurvey::submit();
        break;

    case 'survei-sukses':
        PublicSurvey::thanks();
        break;

    // ── Halaman Dosen Personal ─────────────────────────────
    case 'dosen':
        PublicDosen::show(trim($_GET['slug'] ?? ($_GET['id'] ?? '')));
        break;

    case 'dosen-cv':
        PublicDosen::exportCv((int) ($_GET['id'] ?? 0));
        break;

    case 'subscribe':   PublicSubscribe::subscribe(); break;
    case 'unsubscribe': PublicSubscribe::unsubscribe(); break;

    // ── Multimedia Publik ──────────────────────────────────
    case 'video':        PublicMedia::videos(); break;
    case 'podcast':      PublicMedia::podcasts(); break;
    case 'video-view':   PublicMedia::countView(); break;
    case 'podcast-play': PublicMedia::countPlay(); break;

    // ── 🤖 CHATBOT API (dari Tahap AI-1) ─────────────────────
    case 'chatbot-api':
        ApiChatbot::reply();
        break;

    case 'chatbot-log':
        ApiChatbot::logFeedback();
        break;

    // ── 404 Fallback ────────────────────────────────────────
    default:
        http_response_code(404);
        View::render('public/errors/404', [
            'title'   => 'Halaman Tidak Ditemukan | ' . APP_NAME,
            'message' => 'Halaman <code>' . e($page) . '</code> tidak ditemukan. Mungkin URL salah atau halaman telah dipindahkan.',
        ]);
        break;
}