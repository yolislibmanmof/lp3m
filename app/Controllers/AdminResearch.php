<?php
class AdminResearch
{
    private static function flash($type, $message) { $_SESSION['flash'] = ['type'=>$type,'message'=>$message]; }
    private static function getFlash() { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }

    public static function index()
    {
        $page = max(1, (int)($_GET['hal'] ?? 1));
        $status = $_GET['status'] ?? '';
        $year = $_GET['year'] ?? '';
        $q = trim($_GET['q'] ?? '');

        $filters = [];
        if ($status !== '') $filters['status'] = $status;
        if ($year !== '') $filters['year'] = (int)$year;

        $r = Research::paginate($filters, $q, ['title','leader'], $page, 10, 'created_at DESC');

        View::render('admin/penelitian/index', [
            'title' => 'Penelitian | ' . APP_NAME,
            'items' => $r['items'], 'page' => $r['page'], 'totalPages' => $r['totalPages'], 'total' => $r['total'],
            'status' => $status, 'year' => $year, 'q' => $q,
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function create()
    {
        View::render('admin/penelitian/form', [
            'title' => 'Tambah Penelitian | ' . APP_NAME,
            'item' => null,
            'action' => url('admin/index.php?page=penelitian-simpan'),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function store()
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error','Token tidak valid.'); redirect(url('admin/index.php?page=penelitian-tambah')); }
        $title = trim($_POST['title'] ?? ''); $leader = trim($_POST['leader'] ?? '');
        if ($title === '' || $leader === '') { self::flash('error','Judul dan ketua wajib diisi.'); redirect(url('admin/index.php?page=penelitian-tambah')); }
        Research::create(self::data());
        self::flash('success','Penelitian berhasil disimpan.');
        redirect(url('admin/index.php?page=penelitian'));
    }

    public static function edit($id)
    {
        $item = Research::find($id);
        if (!$item) { redirect(url('admin/index.php?page=penelitian')); }
        View::render('admin/penelitian/form', [
            'title' => 'Edit Penelitian | ' . APP_NAME,
            'item' => $item,
            'action' => url('admin/index.php?page=penelitian-update'),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function update()
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error','Token tidak valid.'); redirect(url('admin/index.php?page=penelitian')); }
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? ''); $leader = trim($_POST['leader'] ?? '');
        if ($id <= 0 || $title === '' || $leader === '') { self::flash('error','Data tidak valid.'); redirect(url('admin/index.php?page=penelitian')); }
        Research::update($id, self::data());
        self::flash('success','Perubahan disimpan.');
        redirect(url('admin/index.php?page=penelitian'));
    }

    public static function destroy()
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error','Token tidak valid.'); redirect(url('admin/index.php?page=penelitian')); }
        Research::delete((int)($_POST['id'] ?? 0));
        self::flash('success','Penelitian dihapus.');
        redirect(url('admin/index.php?page=penelitian'));
    }

    private static function data(): array
    {
        return [
            'title' => trim($_POST['title'] ?? ''),
            'year' => (int)($_POST['year'] ?? date('Y')),
            'scheme' => $_POST['scheme'] ?? 'internal',
            'field' => $_POST['field'] ?? null,
            'leader' => trim($_POST['leader'] ?? ''),
            'members' => trim($_POST['members'] ?? '') ?: null,
            'funding' => (int)($_POST['funding'] ?? 0),
            'status' => $_POST['status'] ?? 'draft',
            'output_target' => trim($_POST['output_target'] ?? '') ?: null,
            'description' => trim($_POST['description'] ?? '') ?: null,
        ];
    }
}