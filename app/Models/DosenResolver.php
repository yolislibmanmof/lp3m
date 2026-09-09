<?php

declare(strict_types=1);

/**
 * Helper menemukan data dosen dari berbagai sumber (users + modul karya).
 * Fleksibel: cari by user_id, slug, atau fuzzy-match nama.
 */
class DosenResolver
{
    public static function find(string $identifier): ?array
    {
        if ($identifier === '') return null;
        $pdo = Database::pdo();

        if (ctype_digit($identifier)) {
            $s = $pdo->prepare('SELECT * FROM users WHERE id = ?');
            $s->execute([(int) $identifier]);
            $u = $s->fetch();
            if ($u) return $u;
        }

        try {
            $s = $pdo->prepare('SELECT * FROM users WHERE slug = ? LIMIT 1');
            $s->execute([$identifier]);
            $u = $s->fetch();
            if ($u) return $u;
        } catch (\Throwable $e) { /* kolom slug mungkin belum ada */ }

        $s = $pdo->prepare('SELECT * FROM users WHERE name = ? LIMIT 1');
        $s->execute([$identifier]);
        $u = $s->fetch();
        if ($u) return $u;

        $s = $pdo->prepare('SELECT * FROM users WHERE name LIKE ? LIMIT 1');
        $s->execute(['%' . $identifier . '%']);
        return $s->fetch() ?: null;
    }

    public static function researches(array $user): array
    {
        $pdo = Database::pdo();
        $name = $user['name'] ?? '';
        $id   = (int) ($user['id'] ?? 0);
        try {
            $s = $pdo->prepare("SELECT * FROM researches WHERE leader LIKE ? OR leader LIKE ? ORDER BY year DESC, id DESC LIMIT 200");
            $s->execute([$name, '%' . $name . '%']);
            $rows = $s->fetchAll();
            try {
                $s2 = $pdo->prepare('SELECT * FROM researches WHERE user_id = ? ORDER BY year DESC, id DESC');
                $s2->execute([$id]);
                foreach ($s2->fetchAll() as $r) {
                    if (!in_array($r['id'], array_column($rows, 'id'), true)) $rows[] = $r;
                }
            } catch (\Throwable $e) {}
            usort($rows, fn($a, $b) => ($b['year'] ?? 0) <=> ($a['year'] ?? 0));
            return $rows;
        } catch (\Throwable $e) { return []; }
    }

    public static function publications(array $user): array
    {
        $pdo = Database::pdo();
        $name = $user['name'] ?? '';
        $id   = (int) ($user['id'] ?? 0);
        try {
            $s = $pdo->prepare("SELECT * FROM publications WHERE authors LIKE ? OR authors LIKE ? ORDER BY year DESC, id DESC LIMIT 300");
            $s->execute(['%' . $name . '%', '%' . self::shortName($name) . '%']);
            $rows = $s->fetchAll();
            try {
                $s2 = $pdo->prepare('SELECT * FROM publications WHERE user_id = ? ORDER BY year DESC, id DESC');
                $s2->execute([$id]);
                foreach ($s2->fetchAll() as $r) {
                    if (!in_array($r['id'], array_column($rows, 'id'), true)) $rows[] = $r;
                }
            } catch (\Throwable $e) {}
            usort($rows, fn($a, $b) => ($b['year'] ?? 0) <=> ($a['year'] ?? 0));
            return $rows;
        } catch (\Throwable $e) { return []; }
    }

    public static function haki(array $user): array
    {
        $pdo = Database::pdo();
        $name = $user['name'] ?? '';
        $id   = (int) ($user['id'] ?? 0);
        try {
            $s = $pdo->prepare("SELECT * FROM intellectual_properties WHERE inventor LIKE ? OR applicant LIKE ? ORDER BY year DESC, id DESC LIMIT 200");
            $s->execute(['%' . $name . '%', '%' . $name . '%']);
            $rows = $s->fetchAll();
            try {
                $s2 = $pdo->prepare('SELECT * FROM intellectual_properties WHERE user_id = ? ORDER BY year DESC, id DESC');
                $s2->execute([$id]);
                foreach ($s2->fetchAll() as $r) {
                    if (!in_array($r['id'], array_column($rows, 'id'), true)) $rows[] = $r;
                }
            } catch (\Throwable $e) {}
            usort($rows, fn($a, $b) => ($b['year'] ?? 0) <=> ($a['year'] ?? 0));
            return $rows;
        } catch (\Throwable $e) { return []; }
    }

    public static function communityServices(array $user): array
    {
        $pdo = Database::pdo();
        $name = $user['name'] ?? '';
        $id   = (int) ($user['id'] ?? 0);
        try {
            $s = $pdo->prepare("SELECT * FROM community_services WHERE leader LIKE ? OR members LIKE ? ORDER BY year DESC, id DESC LIMIT 200");
            $s->execute(['%' . $name . '%', '%' . $name . '%']);
            $rows = $s->fetchAll();
            try {
                $s2 = $pdo->prepare('SELECT * FROM community_services WHERE user_id = ? ORDER BY year DESC, id DESC');
                $s2->execute([$id]);
                foreach ($s2->fetchAll() as $r) {
                    if (!in_array($r['id'], array_column($rows, 'id'), true)) $rows[] = $r;
                }
            } catch (\Throwable $e) {}
            usort($rows, fn($a, $b) => ($b['year'] ?? 0) <=> ($a['year'] ?? 0));
            return $rows;
        } catch (\Throwable $e) { return []; }
    }

    public static function stats(array $researches, array $publications, array $haki, array $cs): array
    {
        $years = [];
        foreach (array_merge($researches, $publications, $haki, $cs) as $r) {
            $y = (int) ($r['year'] ?? 0);
            if ($y > 0) $years[$y] = ($years[$y] ?? 0) + 1;
        }
        ksort($years);

        $journalCount = 0;
        $doiCount = 0;
        foreach ($publications as $p) {
            if (!empty($p['journal'])) $journalCount++;
            if (!empty($p['doi'])) $doiCount++;
        }

        return [
            'total_researches'   => count($researches),
            'total_publications' => count($publications),
            'total_haki'         => count($haki),
            'total_cs'           => count($cs),
            'total_all'          => count($researches) + count($publications) + count($haki) + count($cs),
            'journal_count'      => $journalCount,
            'doi_count'          => $doiCount,
            'years'              => $years,
            'first_year'         => !empty($years) ? (int) min(array_keys($years)) : (int) date('Y'),
            'latest_year'        => !empty($years) ? (int) max(array_keys($years)) : (int) date('Y'),
        ];
    }

    public static function hIndex(array $publications): int
    {
        $n = count($publications);
        return $n > 0 ? (int) ceil(sqrt($n)) : 0;
    }

    private static function shortName(string $name): string
    {
        $name = preg_replace('/^(dr|dr\.|prof|prof\.|ir\.|drh\.|apt\.|drs\.|dra\.|h\.|hj\.)\s+/i', '', $name);
        $name = preg_replace('/,\s*(s\.?h\.?|s\.?t\.?|s\.?p\.?|s\.?si\.?|s\.?kom\.?|s\.?pd\.?|m\.?si\.?|m\.?kom\.?|m\.?pd\.?|m\.?m\.?|ph\.?d\.?)$/i', '', $name);
        return trim((string) $name);
    }

    public static function slug(string $name): string
    {
        $s = self::shortName($name);
        $s = preg_replace('/[^a-zA-Z0-9\s\-]/', '', (string) $s);
        $s = preg_replace('/\s+/', '-', trim($s));
        return strtolower($s);
    }

    public static function initials(string $name): string
    {
        $parts = preg_split('/\s+/', trim(self::shortName($name)));
        $parts = array_filter($parts, fn($p) => strlen($p) > 0);
        if (empty($parts)) return 'A';
        if (count($parts) === 1) return strtoupper(substr($parts[0], 0, 2));
        return strtoupper(substr($parts[0], 0, 1) . substr((string) end($parts), 0, 1));
    }
}