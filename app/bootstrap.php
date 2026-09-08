<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

$config = require BASE_PATH . '/config/config.php';
$GLOBALS['config'] = $config;   // ← supaya Database & helper bisa akses config

define('BASE_URL', rtrim($config['base_url'], '/'));
define('APP_NAME', $config['app_name']);

session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => '',
    'secure'   => false,
    'httponly' => true,
    'samesite' => 'Lax',
]);

session_name('LP3M_SESSION');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Core ---
require BASE_PATH . '/app/Core/Database.php';
require BASE_PATH . '/app/Core/View.php';
require BASE_PATH . '/app/Core/Auth.php';
require BASE_PATH . '/app/Core/Csrf.php';
require BASE_PATH . '/app/Core/Upload.php';
require BASE_PATH . '/app/Core/Crud.php';

// --- Models ---
require BASE_PATH . '/app/Models/News.php';
require BASE_PATH . '/app/Models/Setting.php';
require BASE_PATH . '/app/Models/Document.php';
require BASE_PATH . '/app/Models/CommunityService.php';
require BASE_PATH . '/app/Models/Publication.php';
require BASE_PATH . '/app/Models/IntellectualProperty.php';
require BASE_PATH . '/app/Models/AikActivity.php';
require BASE_PATH . '/app/Models/Research.php';
require BASE_PATH . '/app/Models/Grant.php';
require BASE_PATH . '/app/Models/Faq.php';          
require BASE_PATH . '/app/Models/ContactInfo.php';
require BASE_PATH . '/app/Models/Gallery.php';
require BASE_PATH . '/app/Models/Tag.php';
require BASE_PATH . '/app/Models/Certificate.php';

// --- Controllers ---
require BASE_PATH . '/app/Controllers/PublicNews.php';
require BASE_PATH . '/app/Controllers/AdminNews.php';
require BASE_PATH . '/app/Controllers/AdminSettings.php';
require BASE_PATH . '/app/Controllers/PublicDocuments.php';
require BASE_PATH . '/app/Controllers/AdminDocuments.php';
require BASE_PATH . '/app/Controllers/AdminCommunity.php';
require BASE_PATH . '/app/Controllers/AdminPublication.php';
require BASE_PATH . '/app/Controllers/AdminHaki.php';
require BASE_PATH . '/app/Controllers/AdminAik.php';
require BASE_PATH . '/app/Controllers/AdminResearch.php';
require BASE_PATH . '/app/Controllers/AdminGrant.php';
require BASE_PATH . '/app/Controllers/AdminContact.php';
require BASE_PATH . '/app/Controllers/PublicModules.php';
require BASE_PATH . '/app/Controllers/PublicResearch.php';
require BASE_PATH . '/app/Controllers/AdminGallery.php';
require BASE_PATH . '/app/Controllers/PublicCommunity.php';
require BASE_PATH . '/app/Controllers/AdminCertificate.php';

// --- Global Helpers ---
function e($value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    return BASE_URL . '/' . ltrim($path, '/');
}

function asset_url(string $path): string
{
    return url(ltrim($path, '/'));
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function old(string $key, string $default = ''): string
{
    $value = $_POST[$key] ?? $_SESSION['old'][$key] ?? $default;

    return is_scalar($value) ? (string)$value : $default;
}

function csrf_field(): string
{
    return Csrf::field();
}

function upload_url(?string $path): string
{
    if (!$path) {
        return '';
    }

    return url('public/uploads/' . ltrim($path, '/'));
}

function excerpt(string $text, int $length = 140): string
{
    $text = trim(preg_replace('/\s+/', ' ', strip_tags($text)));

    if (function_exists('mb_strimwidth')) {
        return mb_strimwidth($text, 0, $length, '...');
    }

    return strlen($text) > $length ? substr($text, 0, $length) . '...' : $text;
}

function format_bytes(int $bytes): string
{
    if ($bytes >= 1048576) {
        return round($bytes / 1048576, 1) . ' MB';
    }

    if ($bytes >= 1024) {
        return round($bytes / 1024, 1) . ' KB';
    }

    return $bytes . ' B';
}