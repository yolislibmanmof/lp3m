<?php
class PublicResearch
{
    public static function index()
    {
        $page = max(1, (int)($_GET['hal'] ?? 1));
        $scheme = $_GET['scheme'] ?? '';
        $year = $_GET['year'] ?? '';
        $q = trim($_GET['q'] ?? '');

        $filters = [];
        if ($scheme !== '') $filters['scheme'] = $scheme;
        if ($year !== '') $filters['year'] = (int)$year;

        $r = Research::publicList($filters, $q, $page, 9);

        View::render('public/penelitian/index', [
            'title' => 'Penelitian | ' . APP_NAME,
            'items' => $r['items'], 'page' => $r['page'], 'totalPages' => $r['totalPages'], 'total' => $r['total'],
            'scheme' => $scheme, 'year' => $year, 'q' => $q,
            'stats' => Research::publicStats(),
        ]);
    }

    public static function show($id)
    {
        $item = Research::find($id);
        if (!$item || !in_array($item['status'], Research::PUBLIC_STATUSES, true)) {
            http_response_code(404);
            echo '<h1>404</h1><p>Penelitian tidak ditemukan.</p>';
            return;
        }
        View::render('public/penelitian/detail', [
            'title' => $item['title'] . ' | ' . APP_NAME,
            'item' => $item,
        ]);
    }
}