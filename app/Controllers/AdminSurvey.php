<?php

declare(strict_types=1);

class AdminSurvey
{
    public static function index(): void
    {
        $q = trim($_GET['q'] ?? '');
        $r = Survey::paginate($q, max(1, (int) ($_GET['hal'] ?? 1)), 10);
        $items = $r['items'];
        foreach ($items as &$sv) {
            $sv['responses'] = Survey::responseCount((int) $sv['id']);
            $sv['questions'] = count(Survey::questions((int) $sv['id']));
            $sv['ikm'] = Survey::ikm((int) $sv['id']);
        }
        unset($sv);
        View::render('admin/surveys/index', [
            'title' => 'Survei Kepuasan | ' . APP_NAME,
            'items' => $items, 'total' => $r['total'], 'page' => $r['page'], 'totalPages' => $r['totalPages'],
            'q' => $q, 'stats' => Survey::stats(),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function create(): void
    {
        View::render('admin/surveys/form', [
            'title' => 'Buat Survei | ' . APP_NAME,
            'item' => null, 'questions' => [],
            'action' => url('admin/index.php?page=survei-simpan'),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function store(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error', 'Token tidak valid.'); redirect(url('admin/index.php?page=survei')); }
        $d = self::data();
        $questions = self::questionsFromPost();
        if ($d['title'] === '' || empty($questions)) {
            self::flash('error', 'Judul survei dan minimal satu pertanyaan wajib diisi.');
            redirect(url('admin/index.php?page=survei-tambah'));
        }
        $id = Survey::create($d, $questions);
        AuditLog::log('create', ['entity_type' => 'surveys', 'entity_id' => $id, 'entity_label' => $d['title']]);
        self::flash('success', 'Survei "' . $d['title'] . '" dibuat dengan ' . count($questions) . ' pertanyaan.');
        redirect(url('admin/index.php?page=survei'));
    }

    public static function edit(int $id): void
    {
        $item = Survey::find($id);
        if (!$item) { redirect(url('admin/index.php?page=survei')); }
        View::render('admin/surveys/form', [
            'title' => 'Edit Survei | ' . APP_NAME,
            'item' => $item, 'questions' => Survey::questions($id),
            'action' => url('admin/index.php?page=survei-update'),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function update(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { self::flash('error', 'Token tidak valid.'); redirect(url('admin/index.php?page=survei')); }
        $id = (int) ($_POST['id'] ?? 0);
        if (!Survey::find($id)) { redirect(url('admin/index.php?page=survei')); }
        $d = self::data();
        $questions = self::questionsFromPost();
        if ($d['title'] === '' || empty($questions)) {
            self::flash('error', 'Judul survei dan minimal satu pertanyaan wajib diisi.');
            redirect(url('admin/index.php?page=survei-edit&id=' . $id));
        }
        Survey::update($id, $d, $questions);
        AuditLog::log('update', ['entity_type' => 'surveys', 'entity_id' => $id, 'entity_label' => $d['title']]);
        self::flash('success', 'Survei diperbarui.');
        redirect(url('admin/index.php?page=survei'));
    }

    public static function destroy(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=survei')); }
        $id = (int) ($_POST['id'] ?? 0);
        $sv = Survey::find($id);
        Survey::delete($id);
        AuditLog::log('delete', ['entity_type' => 'surveys', 'entity_id' => $id, 'entity_label' => $sv['title'] ?? '']);
        self::flash('success', 'Survei dihapus beserta seluruh responsnya.');
        redirect(url('admin/index.php?page=survei'));
    }

    public static function toggle(): void
    {
        if (!Csrf::verify($_POST['_csrf'] ?? null)) { redirect(url('admin/index.php?page=survei')); }
        $id = (int) ($_POST['id'] ?? 0);
        $sv = Survey::find($id);
        if (!$sv) { redirect(url('admin/index.php?page=survei')); }
        $new = $sv['status'] === 'open' ? 'closed' : 'open';
        Survey::setStatus($id, $new);
        AuditLog::log('toggle', ['entity_type' => 'surveys', 'entity_id' => $id, 'entity_label' => $sv['title'], 'new_value' => ['status' => $new]]);
        self::flash('success', 'Status survei diubah menjadi "' . Survey::STATUSES[$new] . '".');
        redirect(url('admin/index.php?page=survei'));
    }

    public static function results(int $id): void
    {
        $sv = Survey::find($id);
        if (!$sv) { redirect(url('admin/index.php?page=survei')); }
        View::render('admin/surveys/results', [
            'title' => 'Hasil Survei | ' . APP_NAME,
            'item' => $sv,
            'results' => Survey::results($id),
            'ikm' => Survey::ikm($id),
            'responses' => Survey::responses($id, 20),
            'responseCount' => Survey::responseCount($id),
            'flash' => self::getFlash(),
        ], 'layouts/admin');
    }

    public static function export(int $id): void
    {
        $sv = Survey::find($id);
        if (!$sv) { redirect(url('admin/index.php?page=survei')); }
        $questions = Survey::questions($id);
        $responses = Survey::responses($id, 5000);
        $pdo = Database::pdo();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="survei-' . $id . '-' . date('Ymd-His') . '.csv"');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

        $head = ['Token', 'Tanggal', 'Nama', 'Email', 'Peran', 'IP'];
        foreach ($questions as $i => $q) $head[] = 'P' . ($i + 1) . '. ' . $q['question'];
        fputcsv($out, $head);

        $ansStmt = $pdo->prepare('SELECT question_id, rating_value, choice_value, text_value FROM survey_answers WHERE response_id = ?');
        foreach ($responses as $r) {
            $ansStmt->execute([$r['id']]);
            $map = [];
            foreach ($ansStmt->fetchAll() as $a) {
                $map[(int) $a['question_id']] = $a['rating_value'] !== null ? $a['rating_value'] : ($a['choice_value'] ?? ($a['text_value'] ?? ''));
            }
            $row = [$r['token'], $r['created_at'], $r['respondent_name'], $r['respondent_email'], $r['respondent_role'], $r['ip_address']];
            foreach ($questions as $q) $row[] = $map[(int) $q['id']] ?? '';
            fputcsv($out, $row);
        }
        fclose($out);
        exit;
    }

    private static function data(): array
    {
        return [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'target_audience' => array_key_exists($_POST['target_audience'] ?? '', Survey::TARGETS) ? $_POST['target_audience'] : 'umum',
            'status' => array_key_exists($_POST['status'] ?? '', Survey::STATUSES) ? $_POST['status'] : 'draft',
            'start_date' => trim($_POST['start_date'] ?? '') ?: null,
            'end_date' => trim($_POST['end_date'] ?? '') ?: null,
        ];
    }

    private static function questionsFromPost(): array
    {
        $qs = $_POST['q_text'] ?? [];
        $types = $_POST['q_type'] ?? [];
        $opts = $_POST['q_options'] ?? [];
        $reqs = $_POST['q_required'] ?? [];
        $out = [];
        foreach ((array) $qs as $i => $text) {
            if (trim((string) $text) === '') continue;
            $out[] = [
                'question' => $text,
                'type' => $types[$i] ?? 'rating',
                'options' => $opts[$i] ?? '',
                'required' => !empty($reqs[$i]),
            ];
        }
        return $out;
    }

    private static function flash(string $t, string $m): void { $_SESSION['flash'] = ['type' => $t, 'message' => $m]; }
    private static function getFlash() { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
}