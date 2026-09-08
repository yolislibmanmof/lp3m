<?php

declare(strict_types=1);

class Upload
{
    // MIME yang diizinkan untuk gambar
    private const IMAGE_MIMES = [
        'jpg'  => ['image/jpeg'],
        'jpeg' => ['image/jpeg'],
        'png'  => ['image/png'],
        'webp' => ['image/webp'],
    ];

    // MIME yang diizinkan untuk dokumen
    private const FILE_MIMES = [
        'pdf'  => ['application/pdf'],
        'doc'  => ['application/msword'],
        'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip'],
        'xls'  => ['application/vnd.ms-excel'],
        'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip'],
        'ppt'  => ['application/vnd.ms-powerpoint'],
        'pptx' => ['application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/zip'],
    ];

    public static function image(
        array $file,
        string $folder,
        int $maxBytes = 2097152,
        array $allowed = ['jpg', 'jpeg', 'png', 'webp']
    ): array {
        $result = self::file($file, $folder, $maxBytes, $allowed, 'uploads');

        if ($result['ok']) {
            $full = BASE_PATH . '/public/uploads/' . ltrim($result['path'], '/');

            // Validasi ganda: benar-benar gambar
            if (@getimagesize($full) === false) {
                self::remove($result['path'], 'uploads');
                return ['ok' => false, 'path' => null, 'error' => 'File bukan gambar yang valid.'];
            }
        }

        return $result;
    }

    public static function file(
        array $file,
        string $folder,
        int $maxBytes = 10485760,
        array $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'],
        string $base = 'uploads'
    ): array {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return ['ok' => false, 'path' => null, 'error' => 'Gagal mengunggah file.'];
        }

        // Pastikan benar-benar file upload (cegah manipulasi tmp_name)
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return ['ok' => false, 'path' => null, 'error' => 'File tidak valid.'];
        }

        if ($file['size'] > $maxBytes) {
            return ['ok' => false, 'path' => null, 'error' => 'Ukuran file maksimal ' . round($maxBytes / 1048576, 1) . ' MB.'];
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed, true)) {
            return ['ok' => false, 'path' => null, 'error' => 'Format file tidak diizinkan: ' . $ext . '.'];
        }

        // Validasi MIME asli (cegah file berbahaya ber-ekstensi palsu)
        $mime = self::detectMime($file['tmp_name']);
        $allowedMimes = self::allowedMimesFor($ext);
        if ($allowedMimes !== [] && !in_array($mime, $allowedMimes, true)) {
            return ['ok' => false, 'path' => null, 'error' => 'Tipe file tidak sesuai dengan ekstensinya.'];
        }

        $root = $base === 'storage'
            ? BASE_PATH . '/storage/'
            : BASE_PATH . '/public/uploads/';

        $dir = $root . trim($folder, '/') . '/';

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $name = 'file-' . date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;

        if (!move_uploaded_file($file['tmp_name'], $dir . $name)) {
            return ['ok' => false, 'path' => null, 'error' => 'Gagal menyimpan file.'];
        }

        return [
            'ok'    => true,
            'path'  => trim($folder, '/') . '/' . $name,
            'error' => null,
        ];
    }

    public static function remove(?string $relativePath, string $base = 'uploads'): void
    {
        if (!$relativePath) {
            return;
        }

        $root = $base === 'storage'
            ? BASE_PATH . '/storage/'
            : BASE_PATH . '/public/uploads/';

        $full = $root . ltrim($relativePath, '/');

        if (is_file($full)) {
            @unlink($full);
        }
    }

    private static function detectMime(string $tmpPath): string
    {
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = $finfo ? (string) finfo_file($finfo, $tmpPath) : '';
            if ($finfo) finfo_close($finfo);
            return $mime;
        }
        // Fallback: mime_content_type
        return (string) (@mime_content_type($tmpPath) ?: '');
    }

    private static function allowedMimesFor(string $ext): array
    {
        $ext = strtolower($ext);
        return self::IMAGE_MIMES[$ext] ?? self::FILE_MIMES[$ext] ?? [];
    }
}