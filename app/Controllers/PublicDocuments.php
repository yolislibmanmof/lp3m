<?php

declare(strict_types=1);

class PublicDocuments
{
    private const MIME = [
        'pdf'  => 'application/pdf',
        'doc'  => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls'  => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt'  => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    ];

    public static function index(): void
    {
        $category = trim($_GET['category'] ?? '');

        if ($category !== '' && !in_array($category, Document::CATEGORIES, true)) {
            $category = '';
        }

        $page = max(1, (int) ($_GET['hal'] ?? 1));

        $data = Document::paginate([
            'status'   => 'published',
            'category' => $category,
        ], $page, 10);

        View::render('public/documents/index', [
            'title'           => 'Dokumen & Unduhan | ' . APP_NAME,
            'items'           => $data['items'],
            'page'            => $data['page'],
            'totalPages'      => $data['total_pages'],
            'currentCategory' => $category,
        ]);
    }

    public static function download(int $id): void
    {
        $doc = Document::find($id);

        if ($doc === null || ($doc['status'] ?? '') !== 'published') {
            http_response_code(404);
            echo 'Dokumen tidak ditemukan.';
            return;
        }

        // Cegah path traversal: tolak jika file_path mengandung ".."
        if (str_contains($doc['file_path'], '..')) {
            http_response_code(400);
            echo 'Path tidak valid.';
            return;
        }

        $full = BASE_PATH . '/storage/' . ltrim($doc['file_path'], '/');

        // Pastikan tetap di dalam folder storage (realpath check)
        $real = realpath($full);
        $storageReal = realpath(BASE_PATH . '/storage');
        if ($real === false || $storageReal === false || !str_starts_with($real, $storageReal)) {
            http_response_code(404);
            echo 'File tidak ditemukan.';
            return;
        }

        Document::incrementDownload($id);

        $ext = strtolower(pathinfo($real, PATHINFO_EXTENSION));
        $mime = self::MIME[$ext] ?? 'application/octet-stream';

        // Nama file download yang aman
        $downloadName = preg_replace('/[^a-z0-9]+/', '-', strtolower($doc['title']));
        $downloadName = trim($downloadName, '-') . '.' . $ext;
        if ($downloadName === '.' . $ext) {
            $downloadName = 'dokumen-' . $id . '.' . $ext;
        }

        // Bersihkan buffer output agar file tidak corrupt
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . $downloadName . '"');
        header('Content-Length: ' . (string) filesize($real));
        header('Cache-Control: private, max-age=0');
        header('Pragma: public');

        readfile($real);
        exit;
    }
}