<?php

declare(strict_types=1);

class AdminProfile
{
    /** Halaman "Profil Saya" — dosen login melihat ringkasan karya sendiri */
    public static function index(): void
    {
        if (!Auth::check()) {
            redirect(url('admin/index.php?page=login'));
        }

        $user = Auth::user();
        $researches   = DosenResolver::researches($user);
        $publications = DosenResolver::publications($user);
        $haki         = DosenResolver::haki($user);
        $cs           = DosenResolver::communityServices($user);
        $stats        = DosenResolver::stats($researches, $publications, $haki, $cs);
        $hIndex       = DosenResolver::hIndex($publications);

        View::render('admin/profile/index', [
            'title'        => 'Profil Saya | ' . APP_NAME,
            'user'         => $user,
            'researches'   => $researches,
            'publications' => $publications,
            'haki'         => $haki,
            'cs'           => $cs,
            'stats'        => $stats,
            'hIndex'       => $hIndex,
            'publicUrl'    => url('public/index.php?page=dosen&id=' . $user['id']),
            'flash'        => self::getFlash(),
        ], 'layouts/admin');
    }

    private static function getFlash()
    {
        $f = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $f;
    }
}