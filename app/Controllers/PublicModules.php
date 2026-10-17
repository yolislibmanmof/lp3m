<?php

declare(strict_types=1);

class PublicModules
{
    public static function community(): void
    {
        $type = trim($_GET['type'] ?? '');
        $q    = trim($_GET['q'] ?? '');

        if (!array_key_exists($type, CommunityService::TYPES)) {
            $type = '';
        }

        $data = CommunityService::paginate(
            ['status' => 'published', 'type' => $type],
            $q,
            ['title', 'leader', 'location'],
            max(1, (int) ($_GET['hal'] ?? 1)),
            9,
            'year DESC, created_at DESC, id DESC'
        );

        View::render('public/community/index', [
            'title'       => 'Pengabdian & KKN | ' . APP_NAME,
            'items'       => $data['items'],
            'page'        => $data['page'],
            'totalPages'  => $data['total_pages'],
            'total'       => $data['total'],
            'currentType' => $type,
            'q'           => $q,
        ]);
    }

    public static function publication(): void
    {
        $pubs  = Publication::paginate(['status' => 'published'], '', [], 1, 200, 'year DESC, created_at DESC');
        $hakis = IntellectualProperty::paginate(['status' => 'published'], '', [], 1, 200, 'year DESC, created_at DESC');

        View::render('public/publication/index', [
            'title'        => 'Publikasi & HAKI | ' . APP_NAME,
            'publications' => $pubs['items'],
            'hakis'        => $hakis['items'],
        ]);
    }

    public static function aik(): void
    {
        $q = trim($_GET['q'] ?? '');

        $data = AikActivity::paginate(
            ['status' => 'published'],
            $q,
            ['title', 'location'],
            max(1, (int) ($_GET['hal'] ?? 1)),
            9,
            'activity_date DESC, id DESC'  // ← activity_date ADA di aik_activities, jadi ini benar
        );

        View::render('public/aik/index', [
            'title'      => 'AIK & Catur Dharma | ' . APP_NAME,
            'items'      => $data['items'],
            'page'       => $data['page'],
            'totalPages' => $data['total_pages'],
            'total'      => $data['total'],
            'q'          => $q,
        ]);
    }
}