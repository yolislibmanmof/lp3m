<?php
declare(strict_types=1);

class AdminReviewer
{
    public static function index(): void
    {
        $filters = ['type' => $_GET['type'] ?? '', 'active' => $_GET['active'] ?? ''];
        $q = trim($_GET['q'] ?? '');
        $r = Reviewer::paginate($filters, $q, max(1, (int) ($_GET['hal'] ?? 1)), 10);
        View::render('admin/reviewers/index', [
            'title' => 'Reviewer | ' . APP_NAME,
            'items' => $r['items'], 'total' => $r['total'], 'page' => $r['page'], 'totalPages' => $r['totalPages'],
            'filters' => $filters, 'q' => $q, 'stats' => Reviewer::stats(),
            'modules' => Reviewer::MODULES, 'reviewerList' => Reviewer::activeList(),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function create(): void
    {
        View::render('admin/reviewers/form', ['title' => 'Tambah Reviewer | ' . APP_NAME, 'item' => null, 'action' => url('admin/index.php?page=reviewers-simpan'), 'flash' => self::getFlash()], 'layouts/admin');
    }

    public static function store(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error', 'Token tidak valid.'); redirect(url('admin/index.php?page=reviewers')); }
        $name = trim($_POST['name'] ?? '');
        if ($name === '') { self::flash('error', 'Nama reviewer wajib diisi.'); redirect(url('admin/index.php?page=reviewers-tambah')); }
        Reviewer::create(self::data());
        Notification::push('reviewer_created', 'Reviewer baru terdaftar', $name . ' ditambahkan ke database reviewer.', 'success', url('admin/index.php?page=reviewers'), '👥');
        self::flash('success', 'Reviewer berhasil disimpan.');
        redirect(url('admin/index.php?page=reviewers'));
    }

    public static function edit(int $id): void
    {
        $item = Reviewer::find($id);
        if (!$item) redirect(url('admin/index.php?page=reviewers'));
        View::render('admin/reviewers/form', ['title' => 'Edit Reviewer | ' . APP_NAME, 'item' => $item, 'action' => url('admin/index.php?page=reviewers-update'), 'flash' => self::getFlash()], 'layouts/admin');
    }

    public static function update(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error', 'Token tidak valid.'); redirect(url('admin/index.php?page=reviewers')); }
        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0 || trim($_POST['name'] ?? '') === '') { self::flash('error', 'Data tidak valid.'); redirect(url('admin/index.php?page=reviewers')); }
        Reviewer::update($id, self::data());
        self::flash('success', 'Perubahan reviewer disimpan.');
        redirect(url('admin/index.php?page=reviewers'));
    }

    public static function destroy(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error', 'Token tidak valid.'); redirect(url('admin/index.php?page=reviewers')); }
        Reviewer::delete((int) ($_POST['id'] ?? 0));
        self::flash('success', 'Reviewer dihapus.');
        redirect(url('admin/index.php?page=reviewers'));
    }

    public static function assign(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error', 'Token tidak valid.'); redirect(url('admin/index.php?page=reviewers')); }
        $rid = (int) ($_POST['reviewer_id'] ?? 0);
        $mod = $_POST['module_type'] ?? '';
        $mid = (int) ($_POST['module_id'] ?? 0);
        if ($rid <= 0 || !array_key_exists($mod, Reviewer::MODULES) || $mid <= 0) { self::flash('error', 'Data penugasan tidak valid.'); redirect(url('admin/index.php?page=reviewers')); }
        Reviewer::assign($rid, $mod, $mid, trim($_POST['deadline'] ?? '') ?: null, (int) (Auth::user()['id'] ?? 0));
        $rv = Reviewer::find($rid);
        Notification::push('reviewer_assigned', 'Penugasan reviewer baru', ($rv['name'] ?? 'Reviewer') . ' ditugaskan pada modul ' . Reviewer::MODULES[$mod] . ' #' . $mid . '.', 'info', url('admin/index.php?page=reviewers'), '📋');
        self::flash('success', 'Reviewer berhasil ditugaskan.');
        redirect(url('admin/index.php?page=reviewers'));
    }

    public static function complete(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error', 'Token tidak valid.'); redirect(url('admin/index.php?page=reviewers')); }
        $aid = (int) ($_POST['assignment_id'] ?? 0);
        $rating = ($_POST['rating_given'] ?? '') !== '' ? (float) $_POST['rating_given'] : null;
        Reviewer::completeAssignment($aid, trim($_POST['review_notes'] ?? ''), $rating);
        self::flash('success', 'Penugasan ditandai selesai.');
        redirect(url('admin/index.php?page=reviewers'));
    }

    private static function data(): array
    {
        return [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'nidn' => trim($_POST['nidn'] ?? ''),
            'institution' => trim($_POST['institution'] ?? ''),
            'expertise' => trim($_POST['expertise'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'type' => ($_POST['type'] ?? 'internal') === 'eksternal' ? 'eksternal' : 'internal',
            'honorarium_standard' => (int) preg_replace('/\D/', '', $_POST['honorarium_standard'] ?? '0'),
            'bank_account' => trim($_POST['bank_account'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'notes' => trim($_POST['notes'] ?? ''),
        ];
    }

    private static function flash(string $t, string $m): void { $_SESSION['flash'] = ['type' => $t, 'message' => $m]; }
    private static function getFlash() { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
}