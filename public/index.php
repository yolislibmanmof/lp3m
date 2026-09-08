<?php

require dirname(__DIR__) . '/app/bootstrap.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        View::render('public/home', [
            'title' => 'Beranda | ' . APP_NAME,
            'latest' => News::latest(3),
        ]);
        break;

    case 'tentang':
        View::render('public/about', [
            'title' => 'Tentang Kami | ' . APP_NAME,
        ]);
        break;

    case 'berita':
        PublicNews::index();
        break;

    case 'berita-detail':
        PublicNews::show(trim($_GET['slug'] ?? ''));
        break;

    case 'unduhan':
        PublicDocuments::index();
        break;

    case 'unduhan-unduh':
        PublicDocuments::download((int) ($_GET['id'] ?? 0));
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

    case 'penelitian':
        PublicResearch::index();
        break;

    case 'penelitian-detail':
        PublicResearch::show((int) ($_GET['id'] ?? 0));
        break;

    case 'hibah':
        View::render('public/grants/index', [
            'title' => 'Hibah Aktif | ' . APP_NAME,
            'active' => Grant::getActive(),
            'closed' => Grant::getClosed(),
        ]);
        break;

    case 'kontak':
        View::render('public/kontak/index', [
            'title'   => 'Kontak & FAQ | ' . APP_NAME,
            'contact' => ContactInfo::get(),      
            'faqs'    => Faq::allActive(),        
        ]);
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
            'title' => 'Verifikasi Sertifikat | ' . APP_NAME,
            'cert' => $cert,
            'code' => $code,
            'verifyError' => $verifyError,
        ]);
        break;    

    case 'sertifikat':
        $code = trim($_GET['code'] ?? '');
        $cert = $code !== '' ? Certificate::findByCode($code) : null;
        if ($cert === null) {
            http_response_code(404);
            echo '<h1>404</h1><p>Sertifikat tidak ditemukan.</p>';
            break;
        }
        $contact = null;
        try { $contact = ContactInfo::get(); } catch (\Throwable $e) { $contact = null; }
        View::render('public/sertifikat/template', [
            'title' => 'Sertifikat ' . $cert['code'] . ' | ' . APP_NAME,
            'cert' => $cert,
            'types' => Certificate::TYPES,
            'site' => Setting::all(),
            'contactLine' => $contact['address'] ?? '',
        ], 'layouts/print');
        break;

    case 'agenda': PublicEvent::index(); break;

    case 'cek-plagiat':
        PublicPlagiarism::index();
        break;

    case 'cek-plagiat-kirim':
        PublicPlagiarism::submit();
        break;

    case 'cek-plagiat-lengkapi': PublicPlagiarism::completeWithText(); break;

    case 'panduan':
    View::render('public/panduan/index', [
        'title' => 'Panduan Layanan | ' . APP_NAME,
    ]);
    break;

    default:
        http_response_code(404);
        echo '<h1>404</h1><p>Halaman tidak ditemukan.</p>';
        break;
}