<?php

declare(strict_types=1);

class AdminChatbot
{
    private static function guard(): void
    {
        $role = Auth::user()['role'] ?? '';
        if (!in_array($role, ['super_admin', 'admin_lp3m'], true)) {
            self::flash('error', 'Akses ditolak — hanya Super Admin & Admin LP3M.');
            redirect(url('admin/index.php?page=dashboard'));
        }
    }

    public static function index(): void
    {
        self::guard();
        View::render('admin/chatbot/index', [
            'title'      => 'Dashboard Chatbot | ' . APP_NAME,
            'stats'      => Chatbot::stats(),
            'topQ'       => Chatbot::topQuestions(10),
            'recentLogs' => Chatbot::recentLogs(25),
            'knowledge'  => Chatbot::knowledge(),
            'flash'      => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function knowledge(): void
    {
        self::guard();
        $cat = trim($_GET['cat'] ?? '');
        View::render('admin/chatbot/knowledge', [
            'title'      => 'Knowledge Base | ' . APP_NAME,
            'items'      => Chatbot::knowledge($cat),
            'categories' => Chatbot::CATEGORIES,
            'currentCat' => $cat,
            'flash'      => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function knowledgeSave(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=chatbot-knowledge')); }

        $data = [
            'id'       => (int) ($_POST['id'] ?? 0),
            'category' => in_array($_POST['category'] ?? '', array_keys(Chatbot::CATEGORIES), true) ? $_POST['category'] : 'umum',
            'keywords' => trim($_POST['keywords'] ?? ''),
            'question' => trim($_POST['question'] ?? ''),
            'answer'   => trim($_POST['answer'] ?? ''),
            'priority' => (int) ($_POST['priority'] ?? 50),
            'active'   => !empty($_POST['active']),
        ];

        if ($data['question'] === '' || $data['answer'] === '' || $data['keywords'] === '') {
            self::flash('error', 'Pertanyaan, jawaban, dan kata kunci wajib diisi.');
            redirect(url('admin/index.php?page=chatbot-knowledge'));
        }

        $id = Chatbot::saveKnowledge($data);
        AuditLog::log($data['id'] ? 'update' : 'create', [
            'entity_type'  => 'chatbot_knowledge',
            'entity_id'    => $id,
            'entity_label' => mb_substr($data['question'], 0, 80),
        ]);
        self::flash('success', ($data['id'] ? 'Pengetahuan diperbarui.' : 'Pengetahuan baru ditambahkan.') . ' (ID: ' . $id . ')');
        redirect(url('admin/index.php?page=chatbot-knowledge'));
    }

    public static function knowledgeDelete(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=chatbot-knowledge')); }
        $id = (int) ($_POST['id'] ?? 0);
        Chatbot::deleteKnowledge($id);
        AuditLog::log('delete', ['entity_type' => 'chatbot_knowledge', 'entity_id' => $id]);
        self::flash('success', 'Pengetahuan dihapus.');
        redirect(url('admin/index.php?page=chatbot-knowledge'));
    }

    public static function knowledgeToggle(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=chatbot-knowledge')); }
        $id = (int) ($_POST['id'] ?? 0);
        Chatbot::toggleKnowledge($id);
        self::flash('success', 'Status aktif/nonaktif diperbarui.');
        redirect(url('admin/index.php?page=chatbot-knowledge'));
    }

    public static function config(): void
    {
        self::guard();
        $keys = ['chatbot_ai_key', 'chatbot_ai_model', 'chatbot_ai_prompt'];
        $cfg = [];
        foreach ($keys as $k) $cfg[$k] = self::getSettingValue($k);
        View::render('admin/chatbot/config', [
            'title' => 'Konfigurasi AI | ' . APP_NAME,
            'cfg'   => $cfg,
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function configSave(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=chatbot-config')); }

        $key    = trim($_POST['chatbot_ai_key'] ?? '');
        $model  = trim($_POST['chatbot_ai_model'] ?? '') ?: 'google/gemini-2.0-flash-exp:free';
        $prompt = trim($_POST['chatbot_ai_prompt'] ?? '');

        Chatbot::setSetting('chatbot_ai_key', $key);
        Chatbot::setSetting('chatbot_ai_model', $model);
        Chatbot::setSetting('chatbot_ai_prompt', $prompt);

        AuditLog::log('update', ['entity_type' => 'system_settings', 'entity_label' => 'chatbot_config']);
        self::flash('success', 'Konfigurasi AI disimpan. ' . ($key === '' ? '⚠️ API key kosong — bot hanya menjawab dari knowledge base lokal.' : '✅ AI fallback aktif.'));
        redirect(url('admin/index.php?page=chatbot-config'));
    }

    public static function exportLogs(): void
    {
        self::guard();
        $rows = Database::pdo()->query('SELECT * FROM chatbot_logs ORDER BY id DESC LIMIT 5000')->fetchAll();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="chatbot-logs-' . date('Ymd-His') . '.csv"');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
        if (!empty($rows)) {
            fputcsv($out, array_keys($rows[0]));
            foreach ($rows as $r) fputcsv($out, $r);
        }
        fclose($out);
        exit;
    }

    public static function clearLogs(): void
    {
        self::guard();
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=chatbot')); }
        $days = max(1, (int) ($_POST['days'] ?? 30));
        Database::pdo()->prepare("DELETE FROM chatbot_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)")->execute([$days]);
        self::flash('success', "Log percakapan lama (>$days hari) dihapus.");
        redirect(url('admin/index.php?page=chatbot'));
    }

    private static function getSettingValue(string $k): string
    {
        try {
            $s = Database::pdo()->prepare('SELECT svalue FROM system_settings WHERE skey = ?');
            $s->execute([$k]);
            $v = $s->fetchColumn();
            return $v === false ? '' : (string) $v;
        } catch (\Throwable $e) { return ''; }
    }

    private static function flash(string $t, string $m): void { $_SESSION['flash'] = ['type' => $t, 'message' => $m]; }
    private static function getFlash() { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
}