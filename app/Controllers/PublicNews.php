<?php

declare(strict_types=1);

class PublicNews
{
    public static function index(): void
    {
        $category = trim($_GET['category'] ?? '');
        $tagSlug = trim($_GET['tag'] ?? '');
        $searchQ = trim($_GET['q'] ?? '');

        if ($category !== '' && !in_array($category, News::CATEGORIES, true)) {
            $category = '';
        }

        $page = max(1, (int) ($_GET['hal'] ?? 1));

        $data = News::paginate([
            'status' => 'published',
            'category' => $category,
            'tag' => $tagSlug,
            'q' => $searchQ,
        ], $page, 6);

        $featuredSlider = News::featured(5);

        View::render('public/news/index', [
            'title' => 'Berita & Pengumuman | ' . APP_NAME,
            'items' => $data['items'],
            'page' => $data['page'],
            'totalPages' => $data['total_pages'],
            'categories' => News::CATEGORIES,
            'currentCategory' => $category,
            'currentTag' => $tagSlug,
            'searchQ' => $searchQ,
            'featuredSlider' => $featuredSlider,
            'tagCloud' => Tag::cloud(10),
        ]);
    }

    public static function show(string $slug): void
    {
        $item = News::findBySlug($slug);

        if ($item === null) {
            http_response_code(404);
            echo '<h1>404</h1><p>Berita tidak ditemukan.</p>';
            return;
        }

        News::incrementViews((int) $item['id']);
        $item['views'] = (int) ($item['views'] ?? 0) + 1;

        // Ambil tags berita ini (BARU)
        $itemTags = Tag::tagsForNews((int) $item['id']);

        View::render('public/news/show', [
            'title' => $item['title'] . ' | ' . APP_NAME,
            'item' => $item,
            'itemTags' => $itemTags,
            'ogTitle' => $item['title'],
            'ogDesc' => excerpt(strip_tags($item['content']), 160),
            'ogImage' => !empty($item['thumbnail']) ? upload_url($item['thumbnail']) : null,
            'ogUrl' => url('public/index.php?page=berita-detail&slug=' . $item['slug']),
        ]);
    }
}