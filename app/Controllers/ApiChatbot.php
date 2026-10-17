<?php

declare(strict_types=1);

class ApiChatbot
{
    /** Endpoint utama: POST /public/index.php?page=chatbot-api */
    public static function reply(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        header('X-Robots-Tag: noindex');

        $ip = self::clientIp();
        if (!self::rateLimit($ip)) {
            http_response_code(429);
            echo json_encode([
                'ok' => false,
                'answer' => 'Terlalu banyak permintaan. Silakan tunggu sebentar.',
                'confidence' => 0,
                'source' => 'rate_limited',
            ]);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true) ?: [];
        $message = trim((string) ($input['message'] ?? ($_POST['message'] ?? '')));
        $sessionId = trim((string) ($input['session'] ?? ($_POST['session'] ?? '')));
        if ($sessionId === '') $sessionId = 'sess_' . md5($ip . date('Ymd'));

        if ($message === '' || mb_strlen($message) < 2 || mb_strlen($message) > 500) {
            echo json_encode([
                'ok' => false,
                'answer' => 'Mohon kirim pertanyaan yang lebih jelas (2–500 karakter).',
                'confidence' => 0,
                'source' => 'invalid',
            ]);
            return;
        }

        $matches = Chatbot::findLocal($message);
        $result = Chatbot::buildResponse($matches);

        if ($result['confidence'] < 65) {
            $ai = Chatbot::askAI($message, ['local_matches' => $matches]);
            if ($ai !== null) $result = $ai;
        }

        Chatbot::log($sessionId, $message, $result['answer'], $result['source'], $result['confidence'], $ip, $_SERVER['HTTP_USER_AGENT'] ?? null);

        $logId = 0;
        try { $logId = (int) Database::pdo()->lastInsertId(); } catch (\Throwable $e) {}

        echo json_encode([
            'ok' => true,
            'log_id' => $logId,
            'answer' => $result['answer'],
            'confidence' => $result['confidence'],
            'source' => $result['source'],
            'suggestions' => $result['suggestions'] ?? [],
            'category' => $result['category'] ?? null,
        ], JSON_UNESCAPED_UNICODE);
    }

    /** Endpoint feedback: POST /public/index.php?page=chatbot-log */
    public static function logFeedback(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
        $id = (int) ($input['id'] ?? 0);
        $fb = (string) ($input['feedback'] ?? '');
        $ok = $id > 0 && Chatbot::setFeedback($id, $fb);
        echo json_encode(['ok' => $ok]);
    }

    private static function clientIp(): string
    {
        foreach (['HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'] as $k) {
            if (!empty($_SERVER[$k])) {
                $ip = trim(explode(',', (string) $_SERVER[$k])[0]);
                if (filter_var($ip, FILTER_VALIDATE_IP)) return $ip;
            }
        }
        return '127.0.0.1';
    }

    private static function rateLimit(string $ip, int $max = 20, int $window = 60): bool
    {
        $dir = BASE_PATH . '/storage/cache';
        if (!is_dir($dir)) @mkdir($dir, 0775, true);
        $file = $dir . '/chatbot_rl_' . md5($ip) . '.tmp';
        $now = time();
        $records = [];
        if (is_file($file)) {
            $data = @file_get_contents($file);
            if ($data !== false) {
                $records = array_filter(json_decode($data, true) ?: [], fn($t) => $t > $now - $window);
            }
        }
        if (count($records) >= $max) return false;
        $records[] = $now;
        @file_put_contents($file, json_encode($records), LOCK_EX);
        return true;
    }
}