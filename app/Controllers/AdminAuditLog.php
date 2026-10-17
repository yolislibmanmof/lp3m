<?php

declare(strict_types=1);

class AdminAuditLog
{
    private static function guard(): void
    {
        if ((Auth::user()['role'] ?? '') !== 'super_admin') {
            self::flash('error', 'Akses ditolak — audit log khusus Super Admin.');
            redirect(url('admin/index.php?page=dashboard'));
        }
    }

    public static function index(): void
    {
        self::guard();
        $filters = [
            'action'   => $_GET['action'] ?? '',
            'user_id'  => $_GET['user_id'] ?? '',
            'entity'   => $_GET['entity'] ?? '',
            'period'   => $_GET['period'] ?? 'week',
        ];
        $q = trim($_GET['q'] ?? '');
        $r = AuditLog::paginate($filters, $q, max(1, (int) ($_GET['hal'] ?? 1)), 20);

        $users = Database::pdo()->query(
            'SELECT DISTINCT user_id, user_name FROM audit_logs WHERE user_id IS NOT NULL ORDER BY user_name'
        )->fetchAll();

        View::render('admin/audit/index', [
            'title' => 'Audit Log | ' . APP_NAME,
            'items' => $r['items'],
            'total' => $r['total'],
            'page' => $r['page'],
            'totalPages' => $r['totalPages'],
            'filters' => $filters,
            'q' => $q,
            'stats' => AuditLog::stats(),
            'users' => $users,
            'entityTypes' => AuditLog::entityTypes(),
            'actions' => AuditLog::ACTIONS,
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function detail(int $id): void
    {
        self::guard();
        $item = AuditLog::find($id);
        if (!$item) { redirect(url('admin/index.php?page=audit')); }
        View::render('admin/audit/detail', [
            'title' => 'Detail Audit Log #' . $id . ' | ' . APP_NAME,
            'item' => $item,
        ], 'layouts/admin');
    }

    public static function export(): void
    {
        self::guard();
        $filters = [
            'action'   => $_GET['action'] ?? '',
            'user_id'  => $_GET['user_id'] ?? '',
            'entity'   => $_GET['entity'] ?? '',
            'period'   => $_GET['period'] ?? '',
        ];
        $q = trim($_GET['q'] ?? '');
        $r = AuditLog::paginate($filters, $q, 1, 5000);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="audit-log-' . date('Ymd-His') . '.csv"');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
        fputcsv($out, ['ID', 'Waktu', 'Pengguna', 'Role', 'Aksi', 'Entitas', 'Label', 'IP', 'URL']);
        foreach ($r['items'] as $row) {
            fputcsv($out, [
                $row['id'],
                $row['created_at'],
                $row['user_name'] ?? '—',
                $row['user_role'] ?? '—',
                $row['action'],
                $row['entity_type'] ?? '—',
                $row['entity_label'] ?? '—',
                $row['ip_address'] ?? '—',
                $row['url'] ?? '—',
            ]);
        }
        fclose($out);
        exit;
    }

    public static function destroy(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=audit')); }

        $action = $_POST['purge_action'] ?? 'one';
        if ($action === 'old') {
            $n = AuditLog::purge(90);
            self::flash('success', $n . ' log lama (>90 hari) dihapus.');
        } else {
            AuditLog::delete((int) ($_POST['id'] ?? 0));
            self::flash('success', 'Log dihapus.');
        }
        redirect(url('admin/index.php?page=audit'));
    }

    private static function flash(string $t, string $m): void { $_SESSION['flash'] = ['type' => $t, 'message' => $m]; }
    private static function getFlash() { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
}