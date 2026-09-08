<?php

declare(strict_types=1);

class Database
{
    private static ?PDO $pdo = null;

    public static function pdo(): PDO
    {
        if (self::$pdo === null) {
            // Fallback: kalau config global belum tersedia, muat ulang
            $cfg = $GLOBALS['config']['db'] ?? null;
            if ($cfg === null) {
                $config = require BASE_PATH . '/config/config.php';
                $cfg = $config['db'];
            }

            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $cfg['host'],
                $cfg['port'],
                $cfg['database'],
                $cfg['charset']
            );

            self::$pdo = new PDO(
                $dsn,
                $cfg['username'],
                $cfg['password'],
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::ATTR_TIMEOUT            => 5,
                ]
            );
        }

        return self::$pdo;
    }
}