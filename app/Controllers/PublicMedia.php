<?php

declare(strict_types=1);

class PublicMedia
{
    /** Halaman galeri video publik */
    public static function videos(): void
    {
        $cat = trim($_GET['cat'] ?? '');
        if ($cat !== '' && !array_key_exists($cat, Video::CATEGORIES)) $cat = '';
        View::render('public/media/videos', [
            'title'      => 'Galeri Video | ' . APP_NAME,
            'videos'     => Video::published($cat),
            'categories' => Video::CATEGORIES,
            'currentCat' => $cat,
            'stats'      => Video::stats(),
        ]);
    }

    /** Halaman podcast publik */
    public static function podcasts(): void
    {
        $cat = trim($_GET['cat'] ?? '');
        if ($cat !== '' && !array_key_exists($cat, Podcast::CATEGORIES)) $cat = '';
        View::render('public/media/podcasts', [
            'title'      => 'Podcast | ' . APP_NAME,
            'pods'       => Podcast::published($cat),
            'categories' => Podcast::CATEGORIES,
            'currentCat' => $cat,
            'stats'      => Podcast::stats(),
        ]);
    }

    /** AJAX: tambah counter views video */
    public static function countView(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) Video::incrViews($id);
        echo json_encode(['ok' => true]);
    }

    /** AJAX: tambah counter plays podcast */
    public static function countPlay(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) Podcast::incrPlays($id);
        echo json_encode(['ok' => true]);
    }
}