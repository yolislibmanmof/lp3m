<?php

declare(strict_types=1);

class PlagiarismCheck
{
    public const DOC_TYPES = ['skripsi' => 'Skripsi', 'tesis' => 'Tesis', 'disertasi' => 'Disertasi', 'jurnal' => 'Artikel Jurnal', 'artikel' => 'Artikel', 'makalah' => 'Makalah', 'proposal' => 'Proposal', 'lainnya' => 'Lainnya'];
    public const STATUSES = ['queued' => '⏳ Antre', 'processing' => '⚙️ Diproses', 'completed' => '✅ Selesai', 'failed' => '❌ Gagal'];
    public const THRESHOLD = 25.0;

    /** Paksa UTF-8 valid + buang byte kontrol — dipakai di SEMUA jalur simpan (anti 1366) */
    public static function sanitizeText(string $s): string
    {
        if ($s === '') return '';
        if (strpos($s, "\x00") !== false) {
            $le = (substr($s, 1, 1) === "\x00");
            $conv = @mb_convert_encoding($s, 'UTF-8', $le ? 'UTF-16LE' : 'UTF-16BE');
            if ($conv !== false && $conv !== null && strpos($conv, "\x00") === false) $s = $conv;
        }
        $clean = @iconv('UTF-8', 'UTF-8//IGNORE', $s);
        if ($clean === false || $clean === null) $clean = '';
        $clean = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $clean);
        return $clean === null ? '' : $clean;
    }

    public static function paginate(array $filters = [], string $q = '', int $page = 1, int $perPage = 10): array
    {
        $where = []; $params = [];
        if (!empty($filters['status'])) { $where[] = 'status = ?'; $params[] = $filters['status']; }
        if (!empty($filters['doc']))    { $where[] = 'document_type = ?'; $params[] = $filters['doc']; }
        if (trim($q) !== '') {
            $like = '%' . trim($q) . '%';
            $where[] = '(title LIKE ? OR submitter_name LIKE ? OR code LIKE ?)';
            $params = array_merge($params, [$like, $like, $like]);
        }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $pdo = Database::pdo();
        $c = $pdo->prepare("SELECT COUNT(*) FROM plagiarism_checks $whereSql");
        $c->execute($params);
        $total = (int) $c->fetchColumn();
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $totalPages));
        $s = $pdo->prepare("SELECT * FROM plagiarism_checks $whereSql ORDER BY created_at DESC LIMIT $perPage OFFSET " . (($page - 1) * $perPage));
        $s->execute($params);
        return ['items' => $s->fetchAll(), 'total' => $total, 'page' => $page, 'totalPages' => $totalPages];
    }

    public static function find(int $id): ?array
    {
        $s = Database::pdo()->prepare('SELECT * FROM plagiarism_checks WHERE id = ?');
        $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    public static function findByCode(string $code): ?array
    {
        $s = Database::pdo()->prepare('SELECT * FROM plagiarism_checks WHERE code = ?');
        $s->execute([$code]);
        return $s->fetch() ?: null;
    }

    public static function sources(int $checkId): array
    {
        $s = Database::pdo()->prepare('SELECT * FROM plagiarism_sources WHERE check_id = ? ORDER BY match_percentage DESC');
        $s->execute([$checkId]);
        return $s->fetchAll();
    }

    public static function create(array $d): int
    {
        $method = $d['extract_method'] ?? null;
        if ($method !== null) $method = substr((string) $method, 0, 100);

        $st = $d['source_text'] ?? null;
        if ($st !== null) {
            $st = self::sanitizeText((string) $st);
            if ($st === '') $st = null;
        }

        $s = Database::pdo()->prepare(
            'INSERT INTO plagiarism_checks 
                (code,title,submitter_name,submitter_email,submitter_identity,document_type,file_path,file_size,word_count,status,source_text,extract_method,extract_pages,extract_chars)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
        );
        $s->execute([
            $d['code'],
            $d['title'],
            $d['submitter_name'],
            $d['submitter_email'] ?: null,
            $d['submitter_identity'] ?: null,
            $d['document_type'],
            $d['file_path'] ?: null,
            (int) ($d['file_size'] ?? 0),
            (int) ($d['word_count'] ?? 0),
            $d['status'] ?? 'queued',
            $st,
            $method,
            (int) ($d['extract_pages'] ?? 0),
            (int) ($d['extract_chars'] ?? 0),
        ]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function finish(int $id, array $r): void
    {
        $pdo = Database::pdo();
        $pdo->prepare('UPDATE plagiarism_checks SET similarity_score=?,unique_score=?,ai_score=?,sources_found=?,status=?,word_count=?,result_json=?,checked_at=NOW() WHERE id=?')
            ->execute([
                $r['similarity'], $r['unique_score'], $r['ai'], count($r['sources']), 'completed', $r['word_count'],
                json_encode(['word_count' => $r['word_count'], 'unique_ratio' => $r['unique_ratio'], 'self_dup' => $r['self_dup'], 'external' => $r['external']], JSON_UNESCAPED_UNICODE),
                $id,
            ]);
        $pdo->prepare('DELETE FROM plagiarism_sources WHERE check_id = ?')->execute([$id]);
        $ins = $pdo->prepare('INSERT INTO plagiarism_sources (check_id,source_title,source_type,match_percentage,snippet) VALUES (?,?,?,?,?)');
        foreach ($r['sources'] as $src) {
            $ins->execute([$id, $src['source_title'], $src['source_type'], $src['match_percentage'], $src['snippet']]);
        }
    }

    public static function manualScore(int $id, float $sim, float $ai, string $note): void
    {
        Database::pdo()->prepare('UPDATE plagiarism_checks SET similarity_score=?,ai_score=?,unique_score=?,status=?,result_json=?,checked_at=NOW() WHERE id=?')
            ->execute([$sim, $ai, round(100 - $sim, 2), 'completed', json_encode(['manual' => true, 'note' => $note], JSON_UNESCAPED_UNICODE), $id]);
    }

    public static function analyzeAttached(int $id, string $text): array
    {
        $text = self::sanitizeText($text);
        $r = self::analyze($text);
        Database::pdo()->prepare('UPDATE plagiarism_checks SET source_text = ? WHERE id = ?')
            ->execute([$text !== '' ? mb_substr($text, 0, 200000) : null, $id]);
        self::finish($id, $r);
        return $r;
    }

    public static function recheck(int $id): ?array
    {
        $item = self::find($id);
        if (!$item || empty($item['source_text'])) return null;
        $r = self::analyze($item['source_text']);
        self::finish($id, $r);
        return $r;
    }

    public static function extractFromFile(string $filePath, string $ext): array
    {
        $fullPath = BASE_PATH . '/public/' . $filePath;
        if (!file_exists($fullPath)) {
            return ['text' => '', 'method' => 'error:file_missing', 'pages' => 0, 'chars' => 0];
        }
        if (!class_exists('TextExtractor')) {
            $f = BASE_PATH . '/app/Core/TextExtractor.php';
            if (file_exists($f)) require_once $f;
        }
        if (!class_exists('TextExtractor')) {
            return ['text' => '', 'method' => 'error:extractor_missing', 'pages' => 0, 'chars' => 0];
        }
        try {
            return TextExtractor::extract($fullPath, $ext);
        } catch (\Throwable $e) {
            return ['text' => '', 'method' => 'error:exception', 'pages' => 0, 'chars' => 0];
        }
    }

    public static function delete(int $id): void
    {
        Database::pdo()->prepare('DELETE FROM plagiarism_sources WHERE check_id = ?')->execute([$id]);
        Database::pdo()->prepare('DELETE FROM plagiarism_checks WHERE id = ?')->execute([$id]);
    }

    public static function nextCode(): string
    {
        $y = date('Y');
        $last = Database::pdo()->query("SELECT code FROM plagiarism_checks WHERE code LIKE 'PLG-$y-%' ORDER BY id DESC LIMIT 1")->fetchColumn();
        $n = 1;
        if ($last && preg_match('/PLG-\d{4}-(\d+)/', $last, $m)) $n = (int) $m[1] + 1;
        return sprintf('PLG-%s-%03d', $y, $n);
    }

    public static function stats(): array
    {
        $pdo = Database::pdo();
        return [
            'total'     => (int) $pdo->query('SELECT COUNT(*) FROM plagiarism_checks')->fetchColumn(),
            'completed' => (int) $pdo->query("SELECT COUNT(*) FROM plagiarism_checks WHERE status='completed'")->fetchColumn(),
            'queued'    => (int) $pdo->query("SELECT COUNT(*) FROM plagiarism_checks WHERE status IN ('queued','processing')")->fetchColumn(),
            'avg_sim'   => (float) $pdo->query("SELECT COALESCE(AVG(similarity_score),0) FROM plagiarism_checks WHERE status='completed'")->fetchColumn(),
            'high'      => (int) $pdo->query("SELECT COUNT(*) FROM plagiarism_checks WHERE status='completed' AND similarity_score >= " . self::THRESHOLD)->fetchColumn(),
        ];
    }

    public static function distribution(): array
    {
        $pdo = Database::pdo();
        return [
            'low'    => (int) $pdo->query("SELECT COUNT(*) FROM plagiarism_checks WHERE status='completed' AND similarity_score < 15")->fetchColumn(),
            'mid'    => (int) $pdo->query("SELECT COUNT(*) FROM plagiarism_checks WHERE status='completed' AND similarity_score >= 15 AND similarity_score < " . self::THRESHOLD)->fetchColumn(),
            'high'   => (int) $pdo->query("SELECT COUNT(*) FROM plagiarism_checks WHERE status='completed' AND similarity_score >= " . self::THRESHOLD)->fetchColumn(),
            'queued' => (int) $pdo->query("SELECT COUNT(*) FROM plagiarism_checks WHERE status IN ('queued','processing')")->fetchColumn(),
        ];
    }

    public static function verdict(float $sim): array
    {
        if ($sim >= self::THRESHOLD) return ['#dc2626', 'TINGGI — PERLU REVISI'];
        if ($sim >= 15) return ['#f59e0b', 'SEDANG — PERIKSA KUTIPAN'];
        return ['#10b981', 'RENDAH — AMAN'];
    }

    public static function analyze(string $text): array
    {
        $text = self::sanitizeText($text);
        $clean = mb_strtolower(trim(preg_replace('/\s+/u', ' ', preg_replace('/[^\p{L}\p{N}\s]/u', ' ', strip_tags($text)))));
        $words = array_values(array_filter(preg_split('/\s+/u', $clean), fn($w) => $w !== ''));
        $wordCount = count($words);
        $unique = count(array_unique($words));
        $uniqueRatio = $wordCount > 0 ? $unique / $wordCount : 0;

        $shingles = [];
        for ($i = 0; $i + 6 <= $wordCount; $i++) $shingles[] = implode(' ', array_slice($words, $i, 6));
        $shSet = array_values(array_unique($shingles));
        $selfDup = count($shingles) > 0 ? 1 - (count($shSet) / count($shingles)) : 0;

        $corpus = [];
        $pdo = Database::pdo();
        foreach ($pdo->query("SELECT title, content FROM news WHERE status='published'") as $r) $corpus[] = ['t' => 'Berita Internal', 'n' => $r['title'], 'x' => (string) $r['content']];
        foreach ($pdo->query('SELECT title, description FROM researches') as $r) $corpus[] = ['t' => 'Proposal Penelitian', 'n' => $r['title'], 'x' => (string) $r['description']];
        foreach ($pdo->query('SELECT title, description FROM community_services') as $r) $corpus[] = ['t' => 'Laporan Pengabdian', 'n' => $r['title'], 'x' => (string) $r['description']];

        $sources = [];
        foreach ($corpus as $doc) {
            $dc = mb_strtolower(trim(preg_replace('/\s+/u', ' ', preg_replace('/[^\p{L}\p{N}\s]/u', ' ', strip_tags($doc['x'])))));
            $dw = array_values(array_filter(preg_split('/\s+/u', $dc), fn($w) => $w !== ''));
            if (count($dw) < 40) continue;
            $dset = [];
            for ($i = 0; $i + 6 <= count($dw); $i++) $dset[implode(' ', array_slice($dw, $i, 6))] = $i;
            $hit = 0; $firstIdx = null;
            foreach ($shSet as $sh) {
                if (isset($dset[$sh])) { $hit++; if ($firstIdx === null) $firstIdx = $dset[$sh]; }
            }
            $contain = count($shSet) > 0 ? $hit / count($shSet) : 0;
            if ($contain >= 0.01) {
                $snippet = $firstIdx !== null ? implode(' ', array_slice($dw, $firstIdx, 24)) : mb_substr($dc, 0, 140);
                $sources[] = ['source_type' => 'internal', 'source_title' => $doc['n'] . ' (' . $doc['t'] . ')', 'match_percentage' => round($contain * 100, 2), 'snippet' => $snippet . '...'];
            }
        }

        usort($sources, fn($a, $b) => $b['match_percentage'] <=> $a['match_percentage']);
        $sources = array_slice($sources, 0, 10);
        $external = (float) ($sources[0]['match_percentage'] ?? 0);
        $similarity = round(min(100, $external * 0.6 + ($selfDup * 100) * 0.4), 2);
        $ai = round(min(100, max(0, (1 - $uniqueRatio) * 90 + $selfDup * 30)), 2);

        return [
            'word_count' => $wordCount, 'unique_ratio' => round($uniqueRatio, 4), 'self_dup' => round($selfDup, 4),
            'external' => $external, 'similarity' => $similarity, 'unique_score' => round(100 - $similarity, 2),
            'ai' => $ai, 'sources' => $sources,
        ];
    }
}