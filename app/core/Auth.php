<?php

declare(strict_types=1);

class Auth
{
    private const SESSION_LIFETIME = 7200; // 2 jam (dalam detik)
    private const REMEMBER_LIFETIME = 2592000; // 30 hari (dalam detik)

    /**
     * Cek apakah user sudah login
     */
    public static function check(): bool
    {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user'])) {
            return false;
        }

        // 🔒 Cek idle timeout
        if (isset($_SESSION['last_activity'])) {
            $elapsed = time() - $_SESSION['last_activity'];
            if ($elapsed > self::SESSION_LIFETIME) {
                self::logout('Session expired due to inactivity');
                return false;
            }
        }

        // 🔒 Cek session fingerprint (cegah session hijacking)
        if (!self::validateFingerprint()) {
            self::logout('Session fingerprint mismatch - possible hijacking attempt');
            return false;
        }

        // Update last activity
        $_SESSION['last_activity'] = time();

        return true;
    }

    /**
     * Dapatkan data user yang sedang login
     */
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Dapatkan ID user yang sedang login
     */
    public static function id(): ?int
    {
        return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
    }

    /**
     * Login user
     * 
     * @param array $user Data user dari database
     * @param bool $remember Aktifkan remember me (cookie 30 hari)
     */
    public static function login(array $user, bool $remember = false): void
    {
        // 🔒 Regenerate session ID untuk mencegah session fixation
        session_regenerate_id(true);

        // Set session data
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];
        $_SESSION['last_activity'] = time();
        $_SESSION['login_time'] = time();

        // 🔒 Set session fingerprint
        $_SESSION['fingerprint'] = self::generateFingerprint();

        // Remember me functionality
        if ($remember) {
            self::setRememberCookie($user['id']);
        }
    }

    /**
     * Logout user
     * 
     * @param string $reason Alasan logout (untuk logging)
     */
    public static function logout(string $reason = 'User initiated logout'): void
    {
        // Log logout event (opsional, bisa diintegrasikan dengan AuditLog)
        if (isset($_SESSION['user_id'])) {
            error_log(sprintf(
                '[AUTH] User %d logged out. Reason: %s',
                $_SESSION['user_id'],
                $reason
            ));
        }

        // Clear all session data
        $_SESSION = [];

        // Delete session cookie
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Delete remember me cookie
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/', '', false, true);
        }

        // Destroy session
        session_destroy();
    }

    /**
     * Guard middleware - pastikan user sudah login
     */
    public static function guard(): void
    {
        if (!self::check()) {
            // Cek apakah ada remember me cookie
            if (self::tryRememberLogin()) {
                return; // Berhasil login otomatis
            }

            // Redirect ke login
            redirect(url('admin/index.php?page=login'));
        }
    }

    /**
     * Guard dengan pengecekan role
     * 
     * @param array $allowedRoles Role yang diizinkan
     */
    public static function guardRole(array $allowedRoles): void
    {
        self::guard();

        $userRole = self::user()['role'] ?? '';
        if (!in_array($userRole, $allowedRoles, true)) {
            http_response_code(403);
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => '🚫 Akses ditolak. Role Anda tidak memiliki izin.'
            ];
            redirect(url('admin/index.php?page=dashboard'));
        }
    }

    /**
     * Generate session fingerprint
     * Kombinasi IP + User-Agent untuk deteksi hijacking
     */
    private static function generateFingerprint(): string
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        return hash('sha256', $ip . $ua . session_id());
    }

    /**
     * Validasi session fingerprint
     */
    private static function validateFingerprint(): bool
    {
        if (!isset($_SESSION['fingerprint'])) {
            return true; // Backward compatibility
        }

        $current = self::generateFingerprint();
        return hash_equals($_SESSION['fingerprint'], $current);
    }

    /**
     * Set remember me cookie
     */
    private static function setRememberCookie(int $userId): void
    {
        $token = bin2hex(random_bytes(32));
        $expires = time() + self::REMEMBER_LIFETIME;

        // Simpan token hash di database (implementasi terpisah)
        // Database::pdo()->prepare('UPDATE users SET remember_token = ?, remember_expires = ? WHERE id = ?')
        //     ->execute([hash('sha256', $token), date('Y-m-d H:i:s', $expires), $userId]);

        // Set cookie
        setcookie(
            'remember_token',
            $userId . ':' . $token,
            $expires,
            '/',
            '',
            false, // Set true jika menggunakan HTTPS
            true   // httponly
        );
    }

    /**
     * Coba login otomatis via remember me cookie
     */
    private static function tryRememberLogin(): bool
    {
        if (!isset($_COOKIE['remember_token'])) {
            return false;
        }

        $parts = explode(':', $_COOKIE['remember_token'], 2);
        if (count($parts) !== 2) {
            return false;
        }

        [$userId, $token] = $parts;
        $userId = (int) $userId;

        // Query database untuk validasi token
        // $stmt = Database::pdo()->prepare('SELECT * FROM users WHERE id = ? AND remember_token = ? AND remember_expires > NOW()');
        // $stmt->execute([$userId, hash('sha256', $token)]);
        // $user = $stmt->fetch();

        // if ($user) {
        //     self::login($user, true); // Renew cookie
        //     return true;
        // }

        // Untuk sekarang, return false (implementasi database terpisah)
        return false;
    }
}