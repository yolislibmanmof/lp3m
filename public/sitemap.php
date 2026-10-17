<?php
require dirname(__DIR__) . '/app/bootstrap.php';

header('Content-Type: application/xml; charset=utf-8');

$base  = rtrim(BASE_URL, '/');
$urls  = [];

$static = [
    '' => ['1.0', 'daily'], 'tentang' => ['0.8', 'monthly'], 'berita' => ['0.9', 'daily'],
    'galeri' => ['0.6', 'weekly'], 'penelitian' => ['0.8', 'weekly'], 'pengabdian' => ['0.8', 'weekly'],
    'publikasi' => ['0.8', 'weekly'], 'haki' => ['0.7', 'monthly'], 'aik' => ['0.7', 'monthly'],
    'hibah' => ['0.8', 'weekly'], 'unduhan' => ['0.7', 'monthly'], 'kontak' => ['0.5', 'monthly'],
    'panduan' => ['0.6', 'monthly'], 'agenda' => ['0.8', 'daily'], 'cek-plagiat' => ['0.7', 'weekly'],
    'verifikasi-sertifikat' => ['0.7', 'weekly'],
];
foreach ($static as $p => [$pr, $cf]) {
    $urls[] = ['loc' => $p === '' ? $base . '/public/index.php' : $base . '/public/index.php?page=' . $p, 'priority' => $pr, 'changefreq' => $cf, 'lastmod' => null];
}

try {
    $pdo = Database::pdo();
    $dyn = [
        ["SELECT id, created_at FROM news WHERE status='published' ORDER BY id DESC LIMIT 300", 'berita-detail', '0.6', 'monthly'],
        ['SELECT id, created_at FROM researches ORDER BY id DESC LIMIT 300', 'penelitian-detail', '0.6', 'monthly'],
        ['SELECT id, created_at FROM community_services ORDER BY id DESC LIMIT 300', 'pengabdian-detail', '0.6', 'monthly'],
        ['SELECT id, created_at FROM certificates WHERE status=\'valid\' ORDER BY id DESC LIMIT 300', 'sertifikat-detail', '0.5', 'yearly'],
    ];
    foreach ($dyn as [$sql, $page, $pr, $cf]) {
        foreach ($pdo->query($sql) as $r) {
            $urls[] = ['loc' => $base . '/public/index.php?page=' . $page . '&id=' . (int) $r['id'], 'priority' => $pr, 'changefreq' => $cf, 'lastmod' => date('Y-m-d', strtotime($r['created_at']))];
        }
    }
} catch (\Throwable $e) { /* abaikan bila tabel belum ada */ }

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $u) {
    echo "  <url>\n";
    echo '    <loc>' . htmlspecialchars($u['loc'], ENT_XML1) . "</loc>\n";
    if ($u['lastmod']) echo '    <lastmod>' . $u['lastmod'] . "</lastmod>\n";
    echo '    <changefreq>' . $u['changefreq'] . "</changefreq>\n";
    echo '    <priority>' . $u['priority'] . "</priority>\n";
    echo "  </url>\n";
}
echo "</urlset>\n";