<?php

declare(strict_types=1);

class PublicSurvey
{
    public static function index(): void
    {
        $surveys = Survey::openForPublic();
        foreach ($surveys as &$sv) {
            $sv['questions'] = count(Survey::questions((int) $sv['id']));
            $sv['responses'] = Survey::responseCount((int) $sv['id']);
        }
        unset($sv);
        View::render('public/survey/index', [
            'title' => 'Survei Kepuasan | ' . APP_NAME,
            'surveys' => $surveys,
        ]);
    }

    public static function fill(int $id): void
    {
        $sv = Survey::find($id);
        if (!$sv || !Survey::isOpen($sv)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Survei tidak tersedia atau sudah ditutup.'];
            redirect(url('public/index.php?page=survei'));
        }
        $questions = Survey::questions($id);
        if (empty($questions)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Survei ini belum memiliki pertanyaan.'];
            redirect(url('public/index.php?page=survei'));
        }
        View::render('public/survey/fill', [
            'title' => $sv['title'] . ' | ' . APP_NAME,
            'item' => $sv,
            'questions' => $questions,
        ]);
    }

    public static function submit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect(url('public/index.php?page=survei')); }
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Token keamanan tidak valid.'];
            redirect(url('public/index.php?page=survei'));
        }
        $id = (int) ($_POST['survey_id'] ?? 0);
        $sv = Survey::find($id);
        if (!$sv || !Survey::isOpen($sv)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Survei tidak tersedia atau sudah ditutup.'];
            redirect(url('public/index.php?page=survei'));
        }

        $questions = Survey::questions($id);
        $ratings = $_POST['rating'] ?? [];
        $choices = $_POST['choice'] ?? [];
        $texts = $_POST['text'] ?? [];

        // Validasi wajib
        foreach ($questions as $q) {
            if (empty($q['required'])) continue;
            $qid = (int) $q['id'];
            $val = $q['type'] === 'rating' ? ($ratings[$qid] ?? null) : ($q['type'] === 'choice' ? ($choices[$qid] ?? null) : ($texts[$qid] ?? null));
            if ($val === null || trim((string) $val) === '') {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Pertanyaan wajib belum terisi: "' . $q['question'] . '"'];
                redirect(url('public/index.php?page=survei-isi&id=' . $id));
            }
        }

        $answers = [];
        foreach ($questions as $q) {
            $qid = (int) $q['id'];
            $answers[$qid] = [
                'rating' => isset($ratings[$qid]) ? (int) $ratings[$qid] : null,
                'choice' => isset($choices[$qid]) ? trim((string) $choices[$qid]) : null,
                'text'   => isset($texts[$qid]) ? trim((string) $texts[$qid]) : null,
            ];
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $token = Survey::submit($id, $answers, [
            'name' => trim($_POST['respondent_name'] ?? ''),
            'email' => trim($_POST['respondent_email'] ?? ''),
            'role' => trim($_POST['respondent_role'] ?? ''),
            'ip' => $ip,
        ]);

        redirect(url('public/index.php?page=survei-sukses&token=' . urlencode($token)));
    }

    public static function thanks(): void
    {
        $token = trim($_GET['token'] ?? '');
        View::render('public/survey/thanks', [
            'title' => 'Terima Kasih | ' . APP_NAME,
            'token' => $token,
        ]);
    }
}