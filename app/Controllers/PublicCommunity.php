<?php

declare(strict_types=1);

class PublicCommunity
{
    public static function show(int $id): void
    {
        $item = CommunityService::find($id);

        // Hanya tampilkan kegiatan yang sudah published
        if (!$item || ($item['status'] ?? '') !== 'published') {
            http_response_code(404);
            echo '<h1>404</h1><p>Kegiatan tidak ditemukan.</p>';
            return;
        }

        View::render('public/community/detail', [
            'title' => $item['title'] . ' | ' . APP_NAME,
            'item'  => $item,
        ]);
    }
}