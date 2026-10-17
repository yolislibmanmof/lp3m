<?php

declare(strict_types=1);

class Survey
{
    public const STATUSES = ['draft' => 'Draft', 'open' => 'Terbuka', 'closed' => 'Ditutup'];
    public const TARGETS  = ['umum' => 'Umum', 'mahasiswa' => 'Mahasiswa', 'dosen' => 'Dosen', 'mitra' => 'Mitra'];
    public const RATING_LABELS = [1 => '😞 Sangat Kurang', 2 => '😕 Kurang', 3 => '😐 Cukup', 4 => '🙂 Baik', 5 => '🤩 Sangat Baik'];

    public static function paginate(string $q = '', int $page = 1, int $perPage = 10): array
    {
        $where = []; $params = [];
        if (trim($q) !== '') { $where[] = 'title LIKE ?'; $params[] = '%' . trim($q) . '%'; }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $pdo = Database::pdo();
        $c = $pdo->prepare("SELECT COUNT(*) FROM surveys $whereSql"); $c->execute($params);
        $total = (int) $c->fetchColumn();
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $totalPages));
        $s = $pdo->prepare("SELECT * FROM surveys $whereSql ORDER BY id DESC LIMIT $perPage OFFSET " . (($page - 1) * $perPage));
        $s->execute($params);
        return ['items' => $s->fetchAll(), 'total' => $total, 'page' => $page, 'totalPages' => $totalPages];
    }

    public static function find(int $id): ?array
    {
        $s = Database::pdo()->prepare('SELECT * FROM surveys WHERE id = ?'); $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    public static function questions(int $surveyId): array
    {
        $s = Database::pdo()->prepare('SELECT * FROM survey_questions WHERE survey_id = ? ORDER BY sort_order, id');
        $s->execute([$surveyId]);
        $rows = $s->fetchAll();
        foreach ($rows as &$r) { $r['options_arr'] = $r['options'] ? (json_decode($r['options'], true) ?: []) : []; }
        return $rows;
    }

    public static function openForPublic(): array
    {
        return Database::pdo()->query(
            "SELECT * FROM surveys WHERE status='open'
             AND (start_date IS NULL OR start_date <= CURDATE())
             AND (end_date IS NULL OR end_date >= CURDATE())
             ORDER BY id DESC"
        )->fetchAll();
    }

    public static function isOpen(array $sv): bool
    {
        if ($sv['status'] !== 'open') return false;
        $today = date('Y-m-d');
        if (!empty($sv['start_date']) && $sv['start_date'] > $today) return false;
        if (!empty($sv['end_date']) && $sv['end_date'] < $today) return false;
        return true;
    }

    public static function create(array $d, array $questions): int
    {
        $pdo = Database::pdo();
        $pdo->beginTransaction();
        try {
            $s = $pdo->prepare('INSERT INTO surveys (title,description,target_audience,status,start_date,end_date) VALUES (?,?,?,?,?,?)');
            $s->execute([$d['title'], $d['description'] ?: null, $d['target_audience'], $d['status'], $d['start_date'] ?: null, $d['end_date'] ?: null]);
            $id = (int) $pdo->lastInsertId();
            self::saveQuestions($id, $questions);
            $pdo->commit();
            return $id;
        } catch (\Throwable $e) { $pdo->rollBack(); throw $e; }
    }

    public static function update(int $id, array $d, array $questions): void
    {
        $pdo = Database::pdo();
        $pdo->beginTransaction();
        try {
            $s = $pdo->prepare('UPDATE surveys SET title=?,description=?,target_audience=?,status=?,start_date=?,end_date=? WHERE id=?');
            $s->execute([$d['title'], $d['description'] ?: null, $d['target_audience'], $d['status'], $d['start_date'] ?: null, $d['end_date'] ?: null, $id]);
            $pdo->prepare('DELETE FROM survey_questions WHERE survey_id = ?')->execute([$id]);
            self::saveQuestions($id, $questions);
            $pdo->commit();
        } catch (\Throwable $e) { $pdo->rollBack(); throw $e; }
    }

    private static function saveQuestions(int $surveyId, array $questions): void
    {
        $pdo = Database::pdo();
        $ins = $pdo->prepare('INSERT INTO survey_questions (survey_id,question,type,options,required,sort_order) VALUES (?,?,?,?,?,?)');
        $i = 0;
        foreach ($questions as $q) {
            $text = trim((string) ($q['question'] ?? ''));
            if ($text === '') continue;
            $type = in_array($q['type'] ?? 'rating', ['rating', 'choice', 'text'], true) ? $q['type'] : 'rating';
            $opts = null;
            if ($type === 'choice') {
                $arr = array_values(array_filter(array_map('trim', explode("\n", (string) ($q['options'] ?? ''))), fn($x) => $x !== ''));
                $opts = json_encode($arr, JSON_UNESCAPED_UNICODE);
            }
            $ins->execute([$surveyId, $text, $type, $opts, (int) !empty($q['required']), $i++]);
        }
    }

    public static function delete(int $id): void
    {
        Database::pdo()->prepare('DELETE FROM surveys WHERE id = ?')->execute([$id]);
    }

    public static function setStatus(int $id, string $status): void
    {
        Database::pdo()->prepare('UPDATE surveys SET status=? WHERE id=?')->execute([$status, $id]);
    }

    public static function responseCount(int $surveyId): int
    {
        $s = Database::pdo()->prepare('SELECT COUNT(*) FROM survey_responses WHERE survey_id = ?'); $s->execute([$surveyId]);
        return (int) $s->fetchColumn();
    }

    /** Simpan respons publik; kembalikan token bukti partisipasi */
    public static function submit(int $surveyId, array $answers, array $meta): string
    {
        $pdo = Database::pdo();
        $token = bin2hex(random_bytes(8));
        $pdo->beginTransaction();
        try {
            $s = $pdo->prepare('INSERT INTO survey_responses (survey_id,token,respondent_name,respondent_email,respondent_role,ip_address) VALUES (?,?,?,?,?,?)');
            $s->execute([$surveyId, $token, $meta['name'] ?: null, $meta['email'] ?: null, $meta['role'] ?: null, $meta['ip'] ?? null]);
            $rid = (int) $pdo->lastInsertId();
            $ins = $pdo->prepare('INSERT INTO survey_answers (response_id,question_id,rating_value,choice_value,text_value) VALUES (?,?,?,?,?)');
            foreach ($answers as $qid => $a) {
                $ins->execute([$rid, (int) $qid, $a['rating'] ?? null, $a['choice'] ?? null, $a['text'] ?? null]);
            }
            $pdo->commit();
            return $token;
        } catch (\Throwable $e) { $pdo->rollBack(); throw $e; }
    }

    /** Hasil per pertanyaan + distribusi */
    public static function results(int $surveyId): array
    {
        $pdo = Database::pdo();
        $questions = self::questions($surveyId);
        $out = [];
        foreach ($questions as $q) {
            $item = ['q' => $q, 'count' => 0];
            if ($q['type'] === 'rating') {
                $dist = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
                $s = $pdo->prepare('SELECT rating_value v, COUNT(*) c FROM survey_answers WHERE question_id = ? AND rating_value IS NOT NULL GROUP BY rating_value');
                $s->execute([$q['id']]);
                $sum = 0; $n = 0;
                foreach ($s->fetchAll() as $r) { $dist[(int) $r['v']] = (int) $r['c']; $sum += (int) $r['v'] * (int) $r['c']; $n += (int) $r['c']; }
                $item['dist'] = $dist;
                $item['count'] = $n;
                $item['avg'] = $n > 0 ? round($sum / $n, 2) : 0;
            } elseif ($q['type'] === 'choice') {
                $s = $pdo->prepare('SELECT choice_value v, COUNT(*) c FROM survey_answers WHERE question_id = ? AND choice_value IS NOT NULL GROUP BY choice_value ORDER BY c DESC');
                $s->execute([$q['id']]);
                $rows = $s->fetchAll();
                $item['choices'] = $rows;
                $item['count'] = array_sum(array_column($rows, 'c'));
            } else {
                $s = $pdo->prepare("SELECT text_value v, created_at FROM survey_answers WHERE question_id = ? AND text_value IS NOT NULL AND text_value <> '' ORDER BY id DESC LIMIT 50");
                $s->execute([$q['id']]);
                $item['texts'] = $s->fetchAll();
                $item['count'] = count($item['texts']);
            }
            $out[] = $item;
        }
        return $out;
    }

    /** Indeks Kepuasan (0–100) dari seluruh pertanyaan rating */
    public static function ikm(int $surveyId): array
    {
        $pdo = Database::pdo();
        $s = $pdo->prepare("SELECT COUNT(*) c, AVG(rating_value) a FROM survey_answers sa
                            JOIN survey_questions sq ON sq.id = sa.question_id
                            WHERE sq.survey_id = ? AND sa.rating_value IS NOT NULL");
        $s->execute([$surveyId]);
        $r = $s->fetch();
        $n = (int) ($r['c'] ?? 0);
        $avg = $n > 0 ? (float) $r['a'] : 0;
        $index = $n > 0 ? round((($avg - 1) / 4) * 100, 1) : 0;
        $category = $index >= 85 ? 'Sangat Baik' : ($index >= 70 ? 'Baik' : ($index >= 55 ? 'Cukup' : 'Kurang'));
        $color = $index >= 85 ? '#10b981' : ($index >= 70 ? '#3b82f6' : ($index >= 55 ? '#f59e0b' : '#dc2626'));
        return ['count' => $n, 'avg' => round($avg, 2), 'index' => $index, 'category' => $category, 'color' => $color];
    }

    public static function responses(int $surveyId, int $limit = 500): array
    {
        $s = Database::pdo()->prepare('SELECT * FROM survey_responses WHERE survey_id = ? ORDER BY id DESC LIMIT ' . (int) $limit);
        $s->execute([$surveyId]);
        return $s->fetchAll();
    }

    public static function stats(): array
    {
        $pdo = Database::pdo();
        return [
            'total'   => (int) $pdo->query('SELECT COUNT(*) FROM surveys')->fetchColumn(),
            'open'    => (int) $pdo->query("SELECT COUNT(*) FROM surveys WHERE status='open'")->fetchColumn(),
            'closed'  => (int) $pdo->query("SELECT COUNT(*) FROM surveys WHERE status='closed'")->fetchColumn(),
            'answers' => (int) $pdo->query('SELECT COUNT(*) FROM survey_responses')->fetchColumn(),
        ];
    }
}