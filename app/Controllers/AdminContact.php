<?php
declare(strict_types=1);

class AdminContact
{
    public static function index(): void
    {
        $tab = $_GET['tab'] ?? 'contact';

        View::render('admin/contact/index', [
            'title' => 'Manajemen Kontak & FAQ | ' . APP_NAME,
            'contact' => ContactInfo::get(),
            'faqs' => Faq::all(),
            'activeTab' => $tab,
            'flash' => $_SESSION['flash'] ?? null,
        ], 'layouts/admin');
        unset($_SESSION['flash']);
    }

    public static function updateContact(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token tidak valid.', 'error');
            redirect(url('admin/index.php?page=kontak'));
        }

        $data = [
            'address' => trim($_POST['address'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'whatsapp' => trim($_POST['whatsapp'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'office_hours' => trim($_POST['office_hours'] ?? ''),
            'map_embed' => trim($_POST['map_embed'] ?? ''),
        ];

        ContactInfo::save($data);
        self::flash('Informasi kontak berhasil diperbarui.');
        redirect(url('admin/index.php?page=kontak&tab=contact'));
    }

    public static function createFaqForm(): void
    {
        View::render('admin/contact/faq_form', [
            'title' => 'Tambah FAQ | ' . APP_NAME,
            'item' => null,
            'action' => url('admin/index.php?page=kontak-faq-simpan'),
        ], 'layouts/admin');
    }

    public static function storeFaq(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token tidak valid.', 'error');
            redirect(url('admin/index.php?page=kontak-faq-tambah'));
        }

        $data = self::validateFaq();
        if (isset($data['error'])) {
            $_SESSION['old'] = $_POST;
            self::flash($data['error'], 'error');
            redirect(url('admin/index.php?page=kontak-faq-tambah'));
        }

        Faq::create($data);
        self::flash('FAQ berhasil ditambahkan.');
        redirect(url('admin/index.php?page=kontak&tab=faq'));
    }

    public static function editFaqForm(int $id): void
    {
        $item = Faq::find($id);
        if (!$item) redirect(url('admin/index.php?page=kontak&tab=faq'));

        View::render('admin/contact/faq_form', [
            'title' => 'Edit FAQ | ' . APP_NAME,
            'item' => $item,
            'action' => url('admin/index.php?page=kontak-faq-update'),
        ], 'layouts/admin');
    }

    public static function updateFaq(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token tidak valid.', 'error');
            redirect(url('admin/index.php?page=kontak&tab=faq'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        $data = self::validateFaq();

        if (isset($data['error'])) {
            $_SESSION['old'] = $_POST;
            self::flash($data['error'], 'error');
            redirect(url('admin/index.php?page=kontak-faq-edit&id=' . $id));
        }

        Faq::update($id, $data);
        self::flash('FAQ berhasil diperbarui.');
        redirect(url('admin/index.php?page=kontak&tab=faq'));
    }

    public static function destroyFaq(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            self::flash('Token tidak valid.', 'error');
            redirect(url('admin/index.php?page=kontak&tab=faq'));
        }

        $id = (int) ($_POST['id'] ?? 0);
        Faq::delete($id);
        self::flash('FAQ berhasil dihapus.');
        redirect(url('admin/index.php?page=kontak&tab=faq'));
    }

    private static function validateFaq(): array
    {
        $q = trim($_POST['question'] ?? '');
        $a = trim($_POST['answer'] ?? '');

        if ($q === '' || $a === '') {
            return ['error' => 'Pertanyaan dan Jawaban wajib diisi.'];
        }

        return [
            'question' => $q,
            'answer' => $a,
            'sort_order' => $_POST['sort_order'] ?? 0,
            'is_active' => $_POST['is_active'] ?? 0,
        ];
    }

    private static function flash(string $msg, string $type = 'success'): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $msg];
    }
}