<?php

declare(strict_types=1);

class Maintenance
{
    public static function isOn(): bool
    {
        return self::get('maintenance') === '1';
    }

    public static function message(): string
    {
        $m = trim((string) self::get('maintenance_message'));
        return $m !== '' ? $m : 'Sistem informasi LP3M sedang dalam peningkatan layanan. Kami akan kembali dalam beberapa saat. Terima kasih atas pengertian Anda.';
    }

    public static function set(bool $on, ?string $message = null): void
    {
        self::put('maintenance', $on ? '1' : '0');
        if ($message !== null) self::put('maintenance_message', trim($message));
    }

    /** Tampilkan halaman maintenance 503 (standalone, tanpa layout) */
    public static function showPage(): void
    {
        http_response_code(503);
        header('Retry-After: 3600');
        $viewFile = BASE_PATH . '/resources/views/public/maintenance.php';
        if (!is_file($viewFile)) { echo 'Maintenance mode is active.'; return; }
        $message = self::message();
        $title = 'Pemeliharaan Sistem | ' . APP_NAME;
        ob_start();
        require $viewFile;
        echo ob_get_clean();
    }

    private static function get(string $key): ?string
    {
        try {
            $s = Database::pdo()->prepare('SELECT svalue FROM system_settings WHERE skey = ?');
            $s->execute([$key]);
            $v = $s->fetchColumn();
            return $v === false ? null : (string) $v;
        } catch (\Throwable $e) { return null; }
    }

    private static function put(string $key, string $value): void
    {
        Database::pdo()->prepare(
            'INSERT INTO system_settings (skey, svalue) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE svalue = VALUES(svalue)'
        )->execute([$key, $value]);
    }
}