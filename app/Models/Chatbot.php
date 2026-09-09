<?php

declare(strict_types=1);

class Chatbot
{
    public const CATEGORIES = [
        'umum' => '📋 Umum',
        'layanan' => '🛎️ Layanan',
        'info' => 'ℹ️ Informasi',
        'teknis' => '🔧 Teknis',
    ];

    /** Pencarian lokal: kecocokan keyword + fulltext */
    public static function findLocal(string $message, int $limit = 3): array
    {
        $pdo = Database::pdo();
        $clean = mb_strtolower(trim($message));

        $stmt = $pdo->prepare("
            SELECT * FROM chatbot_knowledge
            WHERE active = 1 AND (
                ? LIKE CONCAT('%', LOWER(keywords), '%')
                OR LOWER(question) LIKE ?
            )
            ORDER BY priority DESC
            LIMIT ?
        ");
        $stmt->bindValue(1, $clean);
        $stmt->bindValue(2, '%' . $clean . '%');
        $stmt->bindValue(3, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        $exact = $stmt->fetchAll();

        if (!empty($exact)) {
            foreach ($exact as &$row) {
                $keywords = array_filter(array_map('trim', explode(',', mb_strtolower($row['keywords']))));
                $hits = 0;
                foreach ($keywords as $kw) {
                    if ($kw !== '' && str_contains($clean, $kw)) $hits++;
                }
                $row['confidence'] = $keywords ? (int) round(($hits / count($keywords)) * 100) : 30;
            }
            unset($row);
            usort($exact, fn($a, $b) => $b['confidence'] <=> $a['confidence']);
            return $exact;
        }

        try {
            $stmt = $pdo->prepare("
                SELECT *, MATCH(keywords, question, answer) AGAINST(? IN NATURAL LANGUAGE MODE) AS relevance
                FROM chatbot_knowledge
                WHERE active = 1 AND MATCH(keywords, question, answer) AGAINST(? IN NATURAL LANGUAGE MODE)
                ORDER BY relevance DESC
                LIMIT ?
            ");
            $stmt->execute([$clean, $clean, $limit]);
            $ft = $stmt->fetchAll();
            foreach ($ft as &$row) {
                $row['confidence'] = (int) min(90, max(20, round((float) $row['relevance'] * 15)));
            }
            unset($row);
            return $ft;
        } catch (\Throwable $e) {
            return [];
        }
    }

    public static function buildResponse(array $matches): array
    {
        if (empty($matches)) {
            return [
                'answer' => "Maaf, saya belum menemukan informasi yang tepat untuk pertanyaan Anda.\n\nSilakan coba:\n• Tanyakan tentang: layanan, hibah, penelitian, pengabdian, HAKI, sertifikat, atau kontak LP3M\n• Hubungi admin di lp3m@unimof.ac.id\n• Kunjungi halaman Kontak di website",
                'confidence' => 0,
                'source' => 'local',
                'suggestions' => ['Cara mengajukan penelitian?', 'Alamat LP3M?', 'Cara cek plagiat?'],
            ];
        }

        $best = $matches[0];
        $confidence = (int) $best['confidence'];

        if ($confidence >= 60) {
            return [
                'answer' => $best['answer'],
                'confidence' => $confidence,
                'source' => 'local',
                'suggestions' => self::buildSuggestions($matches),
                'category' => $best['category'],
            ];
        }

        $answer = "Saya menemukan beberapa topik yang mungkin relevan:\n\n";
        foreach (array_slice($matches, 0, 3) as $m) {
            $answer .= '• ' . $m['question'] . "\n";
        }
        $answer .= "\nKlik salah satu atau tanyakan lebih spesifik.";

        return [
            'answer' => $answer,
            'confidence' => $confidence,
            'source' => 'local',
            'suggestions' => array_slice(array_column($matches, 'question'), 0, 3),
        ];
    }

    private static function buildSuggestions(array $matches): array
    {
        $suggestions = [];
        foreach ($matches as $m) {
            if ($m['confidence'] < 70) $suggestions[] = $m['question'];
        }
        if (empty($suggestions)) {
            $suggestions = ['Cara daftar hibah?', 'Jam kerja LP3M?', 'Verifikasi sertifikat'];
        }
        return array_slice($suggestions, 0, 3);
    }

    /** Panggilan AI eksternal (OpenRouter) sebagai fallback cerdas */
    public static function askAI(string $message, array $context = []): ?array
    {
        $apiKey = trim((string) self::getSetting('chatbot_ai_key'));
        if ($apiKey === '' || $apiKey === 'ISI_API_KEY_OPENROUTER') return null;

        $systemPrompt = self::getSetting('chatbot_ai_prompt') ?: self::defaultPrompt();

        $payload = [
            'model' => self::getSetting('chatbot_ai_model') ?: 'google/gemini-2.0-flash-exp:free',
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $message],
            ],
            'temperature' => 0.4,
            'max_tokens' => 400,
        ];

        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey,
                'HTTP-Referer: ' . (BASE_URL ?? ''),
                'X-Title: LP3M UNIMOF Bot',
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => 15,
            CURLOPT_CONNECTTIMEOUT => 5,
        ]);
        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code !== 200 || !$resp) return null;
        $data = json_decode($resp, true);
        $text = trim($data['choices'][0]['message']['content'] ?? '');
        if ($text === '') return null;

        return [
            'answer' => $text,
            'confidence' => 75,
            'source' => 'ai',
            'model' => $data['model'] ?? 'ai',
        ];
    }

    private static function defaultPrompt(): string
    {
        return <<<PROMPT
Anda adalah "Siti", asisten virtual resmi LP3M UNIMOF (Lembaga Penelitian, Pengabdian kepada Masyarakat, dan Al-Islam Kemuhammadiyahan, Universitas Muhammadiyah Maumere).

Kepribadian: ramah, profesional, singkat (maks 4 kalimat), menggunakan bahasa Indonesia baku yang hangat. Selalu akhiri dengan ajakan bertindak jika memungkinkan.

Topik yang bisa dijawab: penelitian, pengabdian, publikasi, HAKI, AIK, hibah, sertifikat, cek plagiat, survei kepuasan, jadwal, dan kontak LP3M.

Jika ditanya di luar konteks LP3M/pendidikan tinggi, tolak dengan sopan dan arahkan ke topik yang relevan.
PROMPT;
    }

    public static function log(string $sessionId, string $userMsg, string $botMsg, string $source, int $confidence, ?string $ip = null, ?string $ua = null): void
    {
        try {
            Database::pdo()->prepare(
                'INSERT INTO chatbot_logs (session_id, user_message, bot_response, source, confidence, ip_address, user_agent)
                 VALUES (?,?,?,?,?,?,?)'
            )->execute([
                $sessionId,
                mb_substr($userMsg, 0, 1000),
                mb_substr($botMsg, 0, 2000),
                $source,
                min(100, max(0, $confidence)),
                $ip ? substr($ip, 0, 45) : null,
                $ua ? substr($ua, 0, 250) : null,
            ]);
        } catch (\Throwable $e) { /* silent */ }
    }

    public static function setFeedback(int $logId, string $feedback): bool
    {
        if (!in_array($feedback, ['good', 'bad'], true)) return false;
        try {
            return (bool) Database::pdo()->prepare('UPDATE chatbot_logs SET feedback = ? WHERE id = ?')->execute([$feedback, $logId]);
        } catch (\Throwable $e) { return false; }
    }

    public static function stats(): array
    {
        $pdo = Database::pdo();
        $day = date('Y-m-d');
        return [
            'total' => (int) $pdo->query('SELECT COUNT(*) FROM chatbot_logs')->fetchColumn(),
            'today' => (int) $pdo->query("SELECT COUNT(*) FROM chatbot_logs WHERE DATE(created_at) = '$day'")->fetchColumn(),
            'good'  => (int) $pdo->query("SELECT COUNT(*) FROM chatbot_logs WHERE feedback='good'")->fetchColumn(),
            'bad'   => (int) $pdo->query("SELECT COUNT(*) FROM chatbot_logs WHERE feedback='bad'")->fetchColumn(),
            'ai'    => (int) $pdo->query("SELECT COUNT(*) FROM chatbot_logs WHERE source='ai'")->fetchColumn(),
            'local' => (int) $pdo->query("SELECT COUNT(*) FROM chatbot_logs WHERE source='local'")->fetchColumn(),
        ];
    }

    public static function knowledge(string $category = ''): array
    {
        $pdo = Database::pdo();
        if ($category !== '') {
            $s = $pdo->prepare('SELECT * FROM chatbot_knowledge WHERE category = ? ORDER BY priority DESC, id DESC');
            $s->execute([$category]);
            return $s->fetchAll();
        }
        return $pdo->query('SELECT * FROM chatbot_knowledge ORDER BY priority DESC, id DESC')->fetchAll();
    }

    public static function saveKnowledge(array $d): int
    {
        $pdo = Database::pdo();
        if (!empty($d['id'])) {
            $pdo->prepare('UPDATE chatbot_knowledge SET category=?, keywords=?, question=?, answer=?, priority=?, active=? WHERE id=?')
                ->execute([$d['category'], $d['keywords'], $d['question'], $d['answer'], (int) $d['priority'], (int) !empty($d['active']), (int) $d['id']]);
            return (int) $d['id'];
        }
        $pdo->prepare('INSERT INTO chatbot_knowledge (category,keywords,question,answer,priority,active) VALUES (?,?,?,?,?,?)')
            ->execute([$d['category'], $d['keywords'], $d['question'], $d['answer'], (int) ($d['priority'] ?? 50), 1]);
        return (int) $pdo->lastInsertId();
    }

    public static function deleteKnowledge(int $id): void
    {
        Database::pdo()->prepare('DELETE FROM chatbot_knowledge WHERE id = ?')->execute([$id]);
    }

    public static function toggleKnowledge(int $id): void
    {
        Database::pdo()->prepare('UPDATE chatbot_knowledge SET active = NOT active WHERE id = ?')->execute([$id]);
    }

    public static function recentLogs(int $limit = 30): array
    {
        $s = Database::pdo()->prepare('SELECT * FROM chatbot_logs ORDER BY id DESC LIMIT ?');
        $s->execute([$limit]);
        return $s->fetchAll();
    }

    public static function topQuestions(int $limit = 10): array
    {
        try {
            return Database::pdo()->query(
                "SELECT user_message, COUNT(*) as cnt FROM chatbot_logs
                 WHERE user_message <> '' GROUP BY user_message ORDER BY cnt DESC LIMIT $limit"
            )->fetchAll();
        } catch (\Throwable $e) { return []; }
    }

    private static function getSetting(string $key): string
    {
        try {
            $s = Database::pdo()->prepare('SELECT svalue FROM system_settings WHERE skey = ?');
            $s->execute([$key]);
            $v = $s->fetchColumn();
            return $v === false ? '' : (string) $v;
        } catch (\Throwable $e) { return ''; }
    }

    public static function setSetting(string $key, string $value): void
    {
        try {
            Database::pdo()->prepare(
                'INSERT INTO system_settings (skey, svalue) VALUES (?, ?)
                 ON DUPLICATE KEY UPDATE svalue = VALUES(svalue)'
            )->execute([$key, $value]);
        } catch (\Throwable $e) {}
    }
}