<?php

declare(strict_types=1);

class PublicDosen
{
    /** Direktori dosen (grid semua dosen) — dipakai bila tidak ada ID/slug */
    public static function index(): void
    {
        $pdo = Database::pdo();
        $q = trim($_GET['q'] ?? '');

        $where = "role IN ('dosen','admin_lp3m','super_admin','pimpinan','reviewer')";
        $params = [];
        if ($q !== '') { $where .= ' AND name LIKE ?'; $params[] = '%' . $q . '%'; }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE $where ORDER BY name ASC LIMIT 120");
        $stmt->execute($params);
        $users = $stmt->fetchAll();

        foreach ($users as &$u) {
            $r = DosenResolver::researches($u);
            $p = DosenResolver::publications($u);
            $h = DosenResolver::haki($u);
            $c = DosenResolver::communityServices($u);
            $u['counts'] = [
                'r'     => count($r),
                'p'     => count($p),
                'h'     => count($h),
                'c'     => count($c),
                'total' => count($r) + count($p) + count($h) + count($c),
            ];
        }
        unset($u);

        View::render('public/dosen/index', [
            'title' => 'Direktori Dosen | ' . APP_NAME,
            'users' => $users,
            'q'     => $q,
        ]);
    }

    /** Halaman publik profil dosen */
    public static function show(string $identifier): void
    {
        if ($identifier === '') { self::index(); return; }

        $user = DosenResolver::find($identifier);
        if ($user === null) {
            http_response_code(404);
            View::render('public/errors/404', [
                'title'   => 'Dosen Tidak Ditemukan | ' . APP_NAME,
                'message' => 'Profil dosen dengan identifier <code>' . e($identifier) . '</code> tidak ditemukan.',
            ]);
            return;
        }

        $allowedRoles = ['dosen', 'admin_lp3m', 'super_admin', 'pimpinan', 'reviewer'];
        if (!in_array($user['role'] ?? '', $allowedRoles, true)) {
            http_response_code(404);
            View::render('public/errors/404', [
                'title'   => 'Bukan Dosen | ' . APP_NAME,
                'message' => 'Akun ini bukan profil dosen.',
            ]);
            return;
        }

        $researches   = DosenResolver::researches($user);
        $publications = DosenResolver::publications($user);
        $haki         = DosenResolver::haki($user);
        $cs           = DosenResolver::communityServices($user);
        $stats        = DosenResolver::stats($researches, $publications, $haki, $cs);
        $hIndex       = DosenResolver::hIndex($publications);

        View::render('public/dosen/profile', [
            'title'        => $user['name'] . ' — Profil Dosen | ' . APP_NAME,
            'user'         => $user,
            'researches'   => $researches,
            'publications' => $publications,
            'haki'         => $haki,
            'cs'           => $cs,
            'stats'        => $stats,
            'hIndex'       => $hIndex,
            'seo'          => [
                'description' => 'Profil akademik ' . $user['name'] . ': penelitian, publikasi, HAKI, dan pengabdian di LP3M UNIMOF.',
                'image'       => !empty($user['photo']) ? upload_url($user['photo']) : '',
            ],
        ]);
    }

    /** Export CV Akademik (HTML-printable) */
    public static function exportCv(int $id): void
    {
        $user = DosenResolver::find((string) $id);
        if ($user === null) {
            http_response_code(404);
            echo 'Dosen tidak ditemukan.';
            return;
        }

        $allowedRoles = ['dosen', 'admin_lp3m', 'super_admin', 'pimpinan', 'reviewer'];
        if (!in_array($user['role'] ?? '', $allowedRoles, true)) {
            http_response_code(404);
            echo 'Bukan profil dosen.';
            return;
        }

        $researches   = DosenResolver::researches($user);
        $publications = DosenResolver::publications($user);
        $haki         = DosenResolver::haki($user);
        $cs           = DosenResolver::communityServices($user);
        $stats        = DosenResolver::stats($researches, $publications, $haki, $cs);

        $viewFile = BASE_PATH . '/resources/views/public/dosen/cv.php';
        if (!is_file($viewFile)) {
            http_response_code(404);
            echo 'View file not found.';
            return;
        }

        ob_start();
        extract([
            'user'         => $user,
            'researches'   => $researches,
            'publications' => $publications,
            'haki'         => $haki,
            'cs'           => $cs,
            'stats'        => $stats,
        ]);
        require $viewFile;
        echo ob_get_clean();
    }
}