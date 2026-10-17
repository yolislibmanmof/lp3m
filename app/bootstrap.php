<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

$config = require BASE_PATH . '/config/config.php';
$GLOBALS['config'] = $config;

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
// Zona waktu lembaga (WITA) — berlaku global untuk semua halaman
date_default_timezone_set('Asia/Makassar');

// ============================================
// CORE — load dulu supaya helper & class dasar siap
// ============================================
require BASE_PATH . '/app/Core/Database.php';
require BASE_PATH . '/app/Core/View.php';
require BASE_PATH . '/app/Core/Auth.php';
require BASE_PATH . '/app/Core/Csrf.php';
require BASE_PATH . '/app/Core/Upload.php';
require BASE_PATH . '/app/Core/Crud.php';
require BASE_PATH . '/app/Core/TextExtractor.php';

// ============================================
// MODELS — MODUL INTI (dari GitHub)
// ============================================
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
require BASE_PATH . '/app/Models/Reviewer.php';
require BASE_PATH . '/app/Models/CalendarEvent.php';
require BASE_PATH . '/app/Models/Notification.php';
require BASE_PATH . '/app/Models/PlagiarismCheck.php';
require BASE_PATH . '/app/Models/User.php';
require BASE_PATH . '/app/Models/AuditLog.php';
require BASE_PATH . '/app/Models/Report.php';
require BASE_PATH . '/app/Models/Survey.php';
require BASE_PATH . '/app/Models/Maintenance.php';
require BASE_PATH . '/app/Models/BackupManager.php';

// ============================================
// MODELS — FITUR BARU (Chatbot · Dosen · Newsletter · Integrasi)
// ============================================
require BASE_PATH . '/app/Models/Chatbot.php';
require BASE_PATH . '/app/Models/DosenResolver.php';
require BASE_PATH . '/app/Models/MailSender.php';
require BASE_PATH . '/app/Models/Subscriber.php';
require BASE_PATH . '/app/Models/Broadcast.php';
require BASE_PATH . '/app/Models/IntegrationsLog.php';
require BASE_PATH . '/app/Models/IntegrationsDoi.php';
require BASE_PATH . '/app/Models/IntegrationsSinta.php';
require BASE_PATH . '/app/Models/IntegrationsScholar.php';
require BASE_PATH . '/app/Models/Video.php';
require BASE_PATH . '/app/Models/Podcast.php';

// ============================================
// CONTROLLERS — MODUL INTI
// ============================================
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
require BASE_PATH . '/app/Controllers/AdminReviewer.php';
require BASE_PATH . '/app/Controllers/AdminEvent.php';
require BASE_PATH . '/app/Controllers/AdminNotification.php';
require BASE_PATH . '/app/Controllers/AdminPlagiarism.php';
require BASE_PATH . '/app/Controllers/PublicEvent.php';
require BASE_PATH . '/app/Controllers/PublicPlagiarism.php';
require BASE_PATH . '/app/Controllers/AdminDashboard.php';
require BASE_PATH . '/app/Controllers/AdminUser.php';
require BASE_PATH . '/app/Controllers/AdminAuditLog.php';
require BASE_PATH . '/app/Controllers/AdminReport.php';
require BASE_PATH . '/app/Controllers/AdminSurvey.php';
require BASE_PATH . '/app/Controllers/PublicSurvey.php';
require BASE_PATH . '/app/Controllers/AdminBackup.php';
require BASE_PATH . '/app/Controllers/AdminVideo.php';
require BASE_PATH . '/app/Controllers/AdminPodcast.php';

// ============================================
// CONTROLLERS — FITUR BARU (Chatbot · Dosen · Newsletter · Integrasi)
// ============================================
require BASE_PATH . '/app/Controllers/ApiChatbot.php';
require BASE_PATH . '/app/Controllers/AdminChatbot.php';
require BASE_PATH . '/app/Controllers/PublicDosen.php';
require BASE_PATH . '/app/Controllers/AdminProfile.php';
require BASE_PATH . '/app/Controllers/AdminIntegrations.php';
require BASE_PATH . '/app/Controllers/AdminBroadcast.php';
require BASE_PATH . '/app/Controllers/PublicSubscribe.php';
require BASE_PATH . '/app/Controllers/PublicMedia.php';

// ============================================
// GLOBAL HELPERS
// ============================================
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
    if (!$path) return '';
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
    if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' MB';
    if ($bytes >= 1024) return round($bytes / 1024, 1) . ' KB';
    return $bytes . ' B';
}