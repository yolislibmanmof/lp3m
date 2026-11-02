<?php

declare(strict_types=1);

class Upload
{
    // 🔒 Batas dimensi gambar (lebar x tinggi dalam pixel)
    private const MAX_IMAGE_DIMENSIONS = [
        'width' => 4096,
        'height' => 4096,
    ];

    // MIME yang diizinkan untuk gambar
    private const IMAGE_MIMES = [
        'jpg'  => ['image/jpeg'],
        'jpeg' => ['image/jpeg'],
        'png'  => ['image/png'],
        'webp' => ['image/webp'],
        'gif'  => ['image/gif'],
    ];

    // 🔒 MIME yang diizinkan untuk dokumen (lebih ketat)
    private const FILE_MIMES = [
        'pdf'  => ['application/pdf'],
        'doc'  => ['application/msword'],
        'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
        'xls'  => ['application/vnd.ms-excel'],
        'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
        'ppt'  => ['application/vnd.ms-powerpoint'],
        'pptx' => ['application/vnd.openxmlformats-officedocument.presentationml.presentation'],
        'zip'  => ['application/zip', 'application/x-zip-compressed'], // Eksplicit untuk ZIP
    ];

    /**
     * Upload gambar dengan validasi ketat
     */
    public static function image(
        array $file,
        string $folder,
        int $maxBytes = 2097152, // 2 MB default
        array $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'],
        ?array $maxDimensions = null
    ): array {
        $result = self::file($file, $folder, $maxBytes, $allowed, 'uploads');

        if ($result['ok']) {
            $full = BASE_PATH . '/public/uploads/' . ltrim($result['path'], '/');

            // 🔒 Validasi ganda: benar-benar gambar
            $imageInfo = @getimagesize($full);
            if ($imageInfo === false) {
                self::remove($result['path'], 'uploads');
                self::logError('Upload gambar gagal: bukan gambar valid', $file);
                return ['ok' => false, 'path' => null, 'error' => 'File bukan gambar yang valid.'];
            }

            // 🔒 Validasi dimensi gambar
            $dims = $maxDimensions ?? self::MAX_IMAGE_DIMENSIONS;
            if ($imageInfo[0] > $dims['width'] || $imageInfo[1] > $dims['height']) {
                self::remove($result['path'], 'uploads');
                self::logError(sprintf(
                    'Upload gambar gagal: dimensi %dx%d melebihi batas %dx%d',
                    $imageInfo[0], $imageInfo[1], $dims['width'], $dims['height']
                ), $file);
                return [
                    'ok' => false,
                    'path' => null,
                    'error' => sprintf(
                        'Dimensi gambar terlalu besar. Maksimal %dx%d pixel.',
                        $dims['width'],
                        $dims['height']
                    )
                ];
            }

            // Tambah metadata gambar ke result
            $result['width'] = $imageInfo[0];
            $result['height'] = $imageInfo[1];
            $result['mime'] = $imageInfo['mime'];
        }

        return $result;
    }

    /**
     * Upload file umum dengan validasi ketat
     */
    public static function file(
        array $file,
        string $folder,
        int $maxBytes = 10485760, // 10 MB default
        array $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip'],
        string $base = 'uploads'
    ): array {
        // Validasi error code
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            self::logError('Upload error code: ' . ($file['error'] ?? 'unknown'), $file);
            return ['ok' => false, 'path' => null, 'error' => 'Gagal mengunggah file.'];
        }

        // 🔒 Pastikan benar-benar file upload (cegah manipulasi tmp_name)
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            self::logError('File bukan uploaded file (possible attack)', $file);
            return ['ok' => false, 'path' => null, 'error' => 'File tidak valid.'];
        }

        // Validasi ukuran
        if ($file['size'] > $maxBytes) {
            self::logError(sprintf(
                'File terlalu besar: %d bytes (max: %d bytes)',
                $file['size'],
                $maxBytes
            ), $file);
            return [
                'ok' => false,
                'path' => null,
                'error' => 'Ukuran file maksimal ' . round($maxBytes / 1048576, 1) . ' MB.'
            ];
        }

        // Validasi ekstensi
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed, true)) {
            self::logError('Ekstensi tidak diizinkan: ' . $ext, $file);
            return ['ok' => false, 'path' => null, 'error' => 'Format file tidak diizinkan: ' . $ext . '.'];
        }

        // 🔒 Validasi MIME asli (cegah file berbahaya ber-ekstensi palsu)
        $mime = self::detectMime($file['tmp_name']);
        $allowedMimes = self::allowedMimesFor($ext);
        if ($allowedMimes !== [] && !in_array($mime, $allowedMimes, true)) {
            self::logError(sprintf(
                'MIME mismatch: ekstensi=%s, mime_detected=%s, allowed=%s',
                $ext,
                $mime,
                implode(',', $allowedMimes)
            ), $file);
            return ['ok' => false, 'path' => null, 'error' => 'Tipe file tidak sesuai dengan ekstensinya.'];
        }

        // 🔒 Cek file berbahaya berdasarkan signature
        if (self::isMaliciousFile($file['tmp_name'], $ext)) {
            self::logError('File terdeteksi berbahaya (malicious signature)', $file);
            return ['ok' => false, 'path' => null, 'error' => 'File terdeteksi berbahaya.'];
        }

        // Tentukan root directory
        $root = $base === 'storage'
            ? BASE_PATH . '/storage/'
            : BASE_PATH . '/public/uploads/';

        $dir = $root . trim($folder, '/') . '/';

        // Buat folder jika belum ada
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0750, true)) { // 🔒 Permission lebih ketat
                self::logError('Gagal membuat direktori: ' . $dir, $file);
                return ['ok' => false, 'path' => null, 'error' => 'Gagal membuat direktori.'];
            }

            // 🔒 Auto-create .htaccess untuk folder uploads (cegah eksekusi PHP)
            if ($base === 'uploads') {
                self::createHtaccess($dir);
            }
        }

        // 🔒 Cek duplikasi file (hemat storage)
        $hash = hash_file('sha256', $file['tmp_name']);
        $existingFile = self::findDuplicate($hash, $dir, $ext);
        if ($existingFile) {
            return [
                'ok' => true,
                'path' => $existingFile,
                'error' => null,
                'duplicate' => true, // Flag untuk tracking
            ];
        }

        // Generate nama file unik
        $name = 'file-' . date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
        $fullPath = $dir . $name;

        // Pindahkan file
        if (!move_uploaded_file($file['tmp_name'], $fullPath)) {
            self::logError('Gagal memindahkan file dari tmp ke: ' . $fullPath, $file);
            return ['ok' => false, 'path' => null, 'error' => 'Gagal menyimpan file.'];
        }

        // 🔒 Set permission file yang aman
        chmod($fullPath, 0640);

        // Log sukses (opsional)
        error_log(sprintf(
            '[UPLOAD] Success: %s -> %s (size: %d bytes, mime: %s)',
            $file['name'],
            trim($folder, '/') . '/' . $name,
            $file['size'],
            $mime
        ));

        return [
            'ok' => true,
            'path' => trim($folder, '/') . '/' . $name,
            'error' => null,
            'duplicate' => false,
            'hash' => $hash,
            'size' => $file['size'],
            'mime' => $mime,
        ];
    }

    /**
     * Hapus file
     */
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
            error_log('[UPLOAD] Removed: ' . $relativePath);
        }
    }

    /**
     * Deteksi MIME type
     */
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

    /**
     * Dapatkan MIME yang diizinkan untuk ekstensi tertentu
     */
    private static function allowedMimesFor(string $ext): array
    {
        $ext = strtolower($ext);
        return self::IMAGE_MIMES[$ext] ?? self::FILE_MIMES[$ext] ?? [];
    }

    /**
     * 🔒 Cek file berbahaya berdasarkan signature
     */
    private static function isMaliciousFile(string $tmpPath, string $ext): bool
    {
        $handle = @fopen($tmpPath, 'rb');
        if (!$handle) {
            return false;
        }

        $header = fread($handle, 1024);
        fclose($handle);

        // Cek PHP tags di file non-PHP
        if (!in_array($ext, ['php', 'phtml', 'php3', 'php4', 'php5'], true)) {
            if (preg_match('/<\?php|<\?=|<\s*script\s+language\s*=\s*["\']?php/i', $header)) {
                return true;
            }
        }

        // Cek executable signatures (ELF, PE, Mach-O)
        $dangerousSignatures = [
            "\x7fELF",    // ELF executable (Linux)
            "MZ",         // PE executable (Windows)
            "\xfe\xed\xfa", // Mach-O (macOS)
            "\xca\xfe\xba\xbe", // Java class
        ];

        foreach ($dangerousSignatures as $sig) {
            if (strpos($header, $sig) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * 🔒 Buat .htaccess untuk mencegah eksekusi PHP
     */
    private static function createHtaccess(string $dir): void
    {
        $htaccessPath = $dir . '.htaccess';
        if (!file_exists($htaccessPath)) {
            $content = "# Prevent PHP execution\nphp_flag engine off\n\n# Disable directory listing\nOptions -Indexes\n\n# Only allow specific file types\n<FilesMatch \"\.(php|phtml|php3|php4|php5|pl|py|jsp|asp|sh|cgi)$\">\n    Deny from all\n</FilesMatch>\n";
            @file_put_contents($htaccessPath, $content);
        }
    }

    /**
     * 🔒 Cek duplikasi file berdasarkan hash
     */
    private static function findDuplicate(string $hash, string $dir, string $ext): ?string
    {
        // Implementasi sederhana: cek file dengan nama yang sama
        // Untuk implementasi yang lebih canggih, bisa menggunakan database
        // yang menyimpan hash -> path mapping
        
        // Untuk sekarang, return null (tidak ada duplikasi check)
        // Anda bisa implementasikan ini nanti jika diperlukan
        return null;
    }

    /**
     * Log error upload
     */
    private static function logError(string $message, array $file): void
    {
        $logData = [
            'message' => $message,
            'file_name' => $file['name'] ?? 'unknown',
            'file_size' => $file['size'] ?? 0,
            'file_type' => $file['type'] ?? 'unknown',
            'timestamp' => date('Y-m-d H:i:s'),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        ];

        error_log('[UPLOAD ERROR] ' . json_encode($logData));
    }

    /**
     * Dapatkan info file
     */
    public static function info(string $relativePath, string $base = 'uploads'): ?array
    {
        $root = $base === 'storage'
            ? BASE_PATH . '/storage/'
            : BASE_PATH . '/public/uploads/';

        $full = $root . ltrim($relativePath, '/');

        if (!is_file($full)) {
            return null;
        }

        return [
            'path' => $relativePath,
            'size' => filesize($full),
            'mime' => self::detectMime($full),
            'modified' => filemtime($full),
            'hash' => hash_file('sha256', $full),
        ];
    }
}