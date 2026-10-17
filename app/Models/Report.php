<?php

declare(strict_types=1);

class Report
{
    public const MODULES = [
        'news' => ['label' => 'Berita', 'table' => 'news', 'ico' => '📰', 'rgb' => '217,164,65', 'fields' => ['id','title','category','status','published_at','created_at']],
        'researches' => ['label' => 'Penelitian', 'table' => 'researches', 'ico' => '🔬', 'rgb' => '59,130,246', 'fields' => ['id','title','leader','scheme','year','funding','created_at']],
        'community_services' => ['label' => 'Pengabdian', 'table' => 'community_services', 'ico' => '🤝', 'rgb' => '16,185,129', 'fields' => ['id','title','leader','type','year','location','created_at']],
        'publications' => ['label' => 'Publikasi', 'table' => 'publications', 'ico' => '📚', 'rgb' => '124,58,237', 'fields' => ['id','title','authors','journal','year','doi','created_at']],
        'intellectual_properties' => ['label' => 'HAKI', 'table' => 'intellectual_properties', 'ico' => '🛡️', 'rgb' => '245,158,11', 'fields' => ['id','title','type','registration_number','year','created_at']],
        'aik_activities' => ['label' => 'AIK', 'table' => 'aik_activities', 'ico' => '🕌', 'rgb' => '6,182,212', 'fields' => ['id','title','type','date','created_at']],
        'certificates' => ['label' => 'Sertifikat', 'table' => 'certificates', 'ico' => '🎓', 'rgb' => '236,72,153', 'fields' => ['id','code','recipient_name','template','issued_at','created_at']],
        'grants' => ['label' => 'Hibah', 'table' => 'grants', 'ico' => '💰', 'rgb' => '234,88,12', 'fields' => ['id','title','source','type','funding_amount','deadline','created_at']],
        'events' => ['label' => 'Kegiatan', 'table' => 'events', 'ico' => '📅', 'rgb' => '20,184,166', 'fields' => ['id','title','event_type','start_date','end_date','location','created_at']],
    ];

    public static function moduleInfo(string $modul): array
    {
        return self::MODULES[$modul] ?? ['label' => ucfirst($modul), 'table' => $modul, 'ico' => '📄', 'rgb' => '100,116,139', 'fields' => []];
    }

    /** Agregasi stats per modul untuk periode tertentu */
    public static function summary(?string $start = null, ?string $end = null): array
    {
        $pdo = Database::pdo();
        $where = '';
        $params = [];
        if ($start && $end) {
            $where = 'WHERE created_at BETWEEN ? AND ?';
            $params = [$start . ' 00:00:00', $end . ' 23:59:59'];
        } elseif ($start) {
            $where = 'WHERE created_at >= ?';
            $params = [$start . ' 00:00:00'];
        }

        $result = [];
        foreach (self::MODULES as $key => $info) {
            $s = $pdo->prepare("SELECT COUNT(*) FROM {$info['table']} $where");
            $s->execute($params);
            $result[$key] = [
                'label' => $info['label'],
                'ico' => $info['ico'],
                'rgb' => $info['rgb'],
                'count' => (int) $s->fetchColumn(),
            ];
        }
        return $result;
    }

    /** Trend bulanan untuk 1 modul (12 bulan terakhir) */
    public static function monthlyTrend(string $modul): array
    {
        $info = self::MODULES[$modul] ?? null;
        if (!$info) return [];
        $pdo = Database::pdo();
        $s = $pdo->prepare("SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count FROM {$info['table']} WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH) GROUP BY month ORDER BY month");
        $s->execute();
        $data = $s->fetchAll();
        $result = [];
        foreach ($data as $r) $result[$r['month']] = (int) $r['count'];
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $m = date('Y-m', strtotime("-$i months"));
            $months[] = ['month' => $m, 'count' => $result[$m] ?? 0];
        }
        return $months;
    }

    /** Trend tahunan untuk 1 modul (5 tahun terakhir) */
    public static function yearlyTrend(string $modul): array
    {
        $info = self::MODULES[$modul] ?? null;
        if (!$info) return [];
        $pdo = Database::pdo();
        $s = $pdo->prepare("SELECT YEAR(created_at) as year, COUNT(*) as count FROM {$info['table']} WHERE created_at >= DATE_SUB(NOW(), INTERVAL 5 YEAR) GROUP BY year ORDER BY year");
        $s->execute();
        $data = $s->fetchAll();
        $result = [];
        foreach ($data as $r) $result[$r['year']] = (int) $r['count'];
        $years = [];
        for ($y = (int) date('Y') - 4; $y <= (int) date('Y'); $y++) {
            $years[] = ['year' => $y, 'count' => $result[$y] ?? 0];
        }
        return $years;
    }

    /** Ambil data mentah untuk export */
    public static function raw(string $modul, ?string $start = null, ?string $end = null): array
    {
        $info = self::MODULES[$modul] ?? null;
        if (!$info) return [];
        $pdo = Database::pdo();
        $where = '';
        $params = [];
        if ($start && $end) {
            $where = 'WHERE created_at BETWEEN ? AND ?';
            $params = [$start . ' 00:00:00', $end . ' 23:59:59'];
        }
        $fields = implode(',', $info['fields']);
        $s = $pdo->prepare("SELECT $fields FROM {$info['table']} $where ORDER BY created_at DESC");
        $s->execute($params);
        return $s->fetchAll();
    }

    /** Laporan tahunan lengkap */
    public static function annual(int $year): array
    {
        $start = "$year-01-01";
        $end = "$year-12-31";
        $summary = self::summary($start, $end);
        $trends = [];
        foreach (self::MODULES as $key => $info) {
            $trends[$key] = self::monthlyTrend($key);
        }
        return [
            'year' => $year,
            'summary' => $summary,
            'trends' => $trends,
            'total' => array_sum(array_column($summary, 'count')),
        ];
    }
}