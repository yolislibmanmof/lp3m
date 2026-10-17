<?php
declare(strict_types=1);

class Reviewer
{
    public const TYPES = ['internal' => 'Internal', 'eksternal' => 'Eksternal'];
    public const MODULES = ['research' => 'Penelitian', 'community' => 'Pengabdian', 'haki' => 'HAKI', 'publication' => 'Publikasi', 'plagiarism' => 'Cek Plagiat'];

    public static function paginate(array $filters = [], string $q = '', int $page = 1, int $perPage = 10): array
    {
        $where = []; $params = [];
        if (!empty($filters['type'])) { $where[] = 'type = ?'; $params[] = $filters['type']; }
        if (($filters['active'] ?? '') !== '') { $where[] = 'is_active = ?'; $params[] = (int) $filters['active']; }
        if (trim($q) !== '') { $like = '%' . trim($q) . '%'; $where[] = '(name LIKE ? OR expertise LIKE ? OR institution LIKE ?)'; $params = array_merge($params, [$like, $like, $like]); }
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $c = Database::pdo()->prepare("SELECT COUNT(*) FROM reviewers $whereSql"); $c->execute($params);
        $total = (int) $c->fetchColumn();
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = max(1, min($page, $totalPages));
        $s = Database::pdo()->prepare("SELECT * FROM reviewers $whereSql ORDER BY rating DESC, name ASC LIMIT $perPage OFFSET " . (($page - 1) * $perPage));
        $s->execute($params);
        return ['items' => $s->fetchAll(), 'total' => $total, 'page' => $page, 'totalPages' => $totalPages];
    }

    public static function find(int $id): ?array
    {
        $s = Database::pdo()->prepare('SELECT * FROM reviewers WHERE id = ?'); $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    public static function create(array $d): int
    {
        $s = Database::pdo()->prepare('INSERT INTO reviewers (name,email,nidn,institution,expertise,phone,type,honorarium_standard,bank_account,is_active,notes) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
        $s->execute([$d['name'], $d['email'] ?: null, $d['nidn'] ?: null, $d['institution'] ?: null, $d['expertise'] ?: null, $d['phone'] ?: null, $d['type'], (int) ($d['honorarium_standard'] ?? 0), $d['bank_account'] ?: null, (int) ($d['is_active'] ?? 1), $d['notes'] ?: null]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $d): void
    {
        $s = Database::pdo()->prepare('UPDATE reviewers SET name=?,email=?,nidn=?,institution=?,expertise=?,phone=?,type=?,honorarium_standard=?,bank_account=?,is_active=?,notes=? WHERE id=?');
        $s->execute([$d['name'], $d['email'] ?: null, $d['nidn'] ?: null, $d['institution'] ?: null, $d['expertise'] ?: null, $d['phone'] ?: null, $d['type'], (int) ($d['honorarium_standard'] ?? 0), $d['bank_account'] ?: null, (int) ($d['is_active'] ?? 1), $d['notes'] ?: null, $id]);
    }

    public static function delete(int $id): void
    {
        Database::pdo()->prepare('DELETE FROM reviewers WHERE id = ?')->execute([$id]);
    }

    public static function activeList(): array
    {
        return Database::pdo()->query("SELECT id,name,institution,type,expertise,rating FROM reviewers WHERE is_active=1 ORDER BY rating DESC, name ASC")->fetchAll();
    }

    public static function stats(): array
    {
        $pdo = Database::pdo();
        return [
            'total' => (int) $pdo->query('SELECT COUNT(*) FROM reviewers')->fetchColumn(),
            'internal' => (int) $pdo->query("SELECT COUNT(*) FROM reviewers WHERE type='internal'")->fetchColumn(),
            'eksternal' => (int) $pdo->query("SELECT COUNT(*) FROM reviewers WHERE type='eksternal'")->fetchColumn(),
            'avg_rating' => (float) $pdo->query('SELECT COALESCE(AVG(rating),0) FROM reviewers')->fetchColumn(),
            'pending' => (int) $pdo->query("SELECT COUNT(*) FROM reviewer_assignments WHERE status IN ('pending','in_progress')")->fetchColumn(),
        ];
    }

    public static function assignments(int $reviewerId): array
    {
        $s = Database::pdo()->prepare('SELECT * FROM reviewer_assignments WHERE reviewer_id = ? ORDER BY assigned_at DESC LIMIT 50');
        $s->execute([$reviewerId]);
        return $s->fetchAll();
    }

    public static function assign(int $reviewerId, string $moduleType, int $moduleId, ?string $deadline, int $assignedBy): int
    {
        $s = Database::pdo()->prepare('INSERT INTO reviewer_assignments (reviewer_id,module_type,module_id,assigned_by,deadline) VALUES (?,?,?,?,?)');
        $s->execute([$reviewerId, $moduleType, $moduleId, $assignedBy ?: null, $deadline ?: null]);
        Database::pdo()->prepare('UPDATE reviewers SET total_assignments = total_assignments + 1 WHERE id = ?')->execute([$reviewerId]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function completeAssignment(int $assignmentId, string $notes, ?float $ratingGiven): void
    {
        $pdo = Database::pdo();
        $s = $pdo->prepare('SELECT * FROM reviewer_assignments WHERE id = ?'); $s->execute([$assignmentId]);
        $a = $s->fetch();
        if (!$a || $a['status'] === 'completed') return;
        $pdo->prepare("UPDATE reviewer_assignments SET status='completed', completed_at=NOW(), review_notes=? , rating_given=? WHERE id=?")
            ->execute([$notes ?: null, $ratingGiven, $assignmentId]);
        if ($ratingGiven !== null) {
            $r = self::find((int) $a['reviewer_id']);
            if ($r) {
                $done = (int) $r['total_completed'] + 1;
                $newRating = round(((float) $r['rating'] * (int) $r['total_completed'] + $ratingGiven) / max(1, $done), 2);
                $pdo->prepare('UPDATE reviewers SET total_completed=?, rating=? WHERE id=?')->execute([$done, min(5, max(0, $newRating)), $r['id']]);
            }
        } else {
            $pdo->prepare('UPDATE reviewers SET total_completed = total_completed + 1 WHERE id = ?')->execute([$a['reviewer_id']]);
        }
    }
}