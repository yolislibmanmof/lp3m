<?php
declare(strict_types=1);

class AdminEvent
{
    public static function index(): void
    {
        $filters = ['type' => $_GET['type'] ?? '', 'status' => $_GET['status'] ?? '', 'month' => $_GET['month'] ?? ''];
        $q = trim($_GET['q'] ?? '');
        $r = CalendarEvent::paginate($filters, $q, max(1, (int) ($_GET['hal'] ?? 1)), 12);
        $month = $filters['month'] ?: date('Y-m');
        View::render('admin/events/index', [
            'title' => 'Kalender Kegiatan | ' . APP_NAME,
            'items' => $r['items'], 'total' => $r['total'], 'page' => $r['page'], 'totalPages' => $r['totalPages'],
            'filters' => $filters, 'q' => $q, 'stats' => CalendarEvent::stats(),
            'monthEvents' => CalendarEvent::byMonth($month, false), 'month' => $month,
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function create(): void
    {
        View::render('admin/events/form', ['title' => 'Tambah Kegiatan | ' . APP_NAME, 'item' => null, 'action' => url('admin/index.php?page=events-simpan'), 'flash' => self::getFlash()], 'layouts/admin');
    }

    public static function store(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error', 'Token tidak valid.'); redirect(url('admin/index.php?page=events')); }
        $title = trim($_POST['title'] ?? ''); $start = $_POST['start_date'] ?? '';
        if ($title === '' || $start === '') { self::flash('error', 'Judul dan tanggal mulai wajib diisi.'); redirect(url('admin/index.php?page=events-tambah')); }
        $id = CalendarEvent::create(self::data());
        Notification::push('event_created', 'Kegiatan baru dijadwalkan', $title . ' pada ' . date('d M Y', strtotime($start)) . '.', 'info', url('admin/index.php?page=events'), '📅');
        self::flash('success', 'Kegiatan berhasil disimpan.');
        redirect(url('admin/index.php?page=events'));
    }

    public static function edit(int $id): void
    {
        $item = CalendarEvent::find($id);
        if (!$item) redirect(url('admin/index.php?page=events'));
        View::render('admin/events/form', ['title' => 'Edit Kegiatan | ' . APP_NAME, 'item' => $item, 'action' => url('admin/index.php?page=events-update'), 'flash' => self::getFlash()], 'layouts/admin');
    }

    public static function update(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error', 'Token tidak valid.'); redirect(url('admin/index.php?page=events')); }
        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0 || trim($_POST['title'] ?? '') === '') { self::flash('error', 'Data tidak valid.'); redirect(url('admin/index.php?page=events')); }
        CalendarEvent::update($id, self::data());
        self::flash('success', 'Kegiatan diperbarui.');
        redirect(url('admin/index.php?page=events'));
    }

    public static function destroy(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error', 'Token tidak valid.'); redirect(url('admin/index.php?page=events')); }
        CalendarEvent::delete((int) ($_POST['id'] ?? 0));
        self::flash('success', 'Kegiatan dihapus.');
        redirect(url('admin/index.php?page=events'));
    }

    private static function data(): array
    {
        return [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'event_type' => $_POST['event_type'] ?? 'lainnya',
            'start_date' => $_POST['start_date'] ?? date('Y-m-d'),
            'end_date' => trim($_POST['end_date'] ?? '') ?: null,
            'start_time' => trim($_POST['start_time'] ?? '') ?: null,
            'end_time' => trim($_POST['end_time'] ?? '') ?: null,
            'is_all_day' => isset($_POST['is_all_day']) ? 1 : 0,
            'location' => trim($_POST['location'] ?? ''),
            'organizer' => trim($_POST['organizer'] ?? ''),
            'max_participants' => (int) ($_POST['max_participants'] ?? 0) ?: null,
            'registration_link' => trim($_POST['registration_link'] ?? ''),
            'status' => $_POST['status'] ?? 'published',
            'reminder_h7' => isset($_POST['reminder_h7']) ? 1 : 0,
            'reminder_h3' => isset($_POST['reminder_h3']) ? 1 : 0,
            'reminder_h1' => isset($_POST['reminder_h1']) ? 1 : 0,
        ];
    }

    private static function flash(string $t, string $m): void { $_SESSION['flash'] = ['type' => $t, 'message' => $m]; }
    private static function getFlash() { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
}