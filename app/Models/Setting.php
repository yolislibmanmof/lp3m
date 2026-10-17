<?php

declare(strict_types=1);

class Setting
{
    private static ?array $cache = null;

    public static function defaults(): array
    {
        return [
            'site_brand' => 'LP3M/LPPAIK UNIMOF',
            'logo_path' => '',
            'favicon_path' => '',

            'footer_text' => '© ' . date('Y') . ' LP3M/LPPAIK UNIMOF. Sistem Informasi Berbasis Catur Dharma Perguruan Tinggi Muhammadiyah.',

            'home_hero_title' => 'Sistem Informasi LP3M/LPPAIK UNIMOF',
            'home_hero_text' => 'Platform layanan terpadu untuk Penelitian, Pengabdian kepada Masyarakat, Publikasi, HAKI, dan Al-Islam Kemuhammadiyahan berbasis Catur Dharma Perguruan Tinggi Muhammadiyah.',
            'home_hero_button_text' => 'Tentang Lembaga',
            'home_section_title' => 'Modul Utama',

            'home_card1_title' => 'Penelitian',
            'home_card1_text' => 'Pengelolaan proposal penelitian, review, laporan kemajuan, laporan akhir, dan luaran penelitian dosen.',
            'home_card2_title' => 'Pengabdian',
            'home_card2_text' => 'Pengelolaan pengabdian kepada masyarakat, KKN, desa binaan, mitra, dan dokumentasi kegiatan lapangan.',
            'home_card3_title' => 'Publikasi & HAKI',
            'home_card3_text' => 'Database publikasi ilmiah, jurnal, buku, prosiding, hak cipta, paten, dan kekayaan intelektual.',
            'home_card4_title' => 'AIK / Catur Dharma',
            'home_card4_text' => 'Dokumentasi dan integrasi nilai Al-Islam dan Kemuhammadiyahan dalam seluruh aktivitas catur dharma perguruan tinggi.',

            'about_hero_title' => 'Tentang LP3M/LPPAIK UNIMOF',
            'about_hero_text' => 'Lembaga yang mengelola penelitian, pengabdian kepada masyarakat, serta integrasi Al-Islam dan Kemuhammadiyahan dalam pelaksanaan Catur Dharma Perguruan Tinggi Muhammadiyah.',

            'about_profile_text' => 'LP3M/LPPAIK UNIMOF adalah lembaga penunjang akademik Universitas Muhammadiyah Maumere yang bertugas mengoordinasikan, melaksanakan, dan mengembangkan kegiatan penelitian, pengabdian kepada masyarakat, serta pembinaan Al-Islam dan Kemuhammadiyahan.',

            'about_history_text' => 'Cikal bakal lembaga ini bermula dari unit penelitian pada IKIP Muhammadiyah Maumere. Seiring transformasi menjadi Universitas Muhammadiyah Maumere (UNIMOF), lembaga ini berkembang menjadi LP3M/LPPAIK yang menaungi penelitian, pengabdian, dan Al-Islam Kemuhammadiyahan.',

            'about_vision_text' => 'Menjadi lembaga penelitian, pengabdian, dan pembinaan Al-Islam Kemuhammadiyahan yang unggul, berkemajuan, dan berdampak bagi masyarakat.',

            'about_mission_text' => "1. Mengembangkan penelitian berkualitas yang bermanfaat bagi ilmu pengetahuan dan masyarakat.\n2. Meningkatkan pengabdian kepada masyarakat yang memberdayakan.\n3. Mengintegrasikan nilai Al-Islam dan Kemuhammadiyahan dalam seluruh kegiatan.\n4. Memperluas publikasi ilmiah dan kekayaan intelektual.",

            'about_structure_text' => "Ketua | Nama Ketua\nSekretaris | Nama Sekretaris\nDivisi Penelitian | Nama Divisi\nDivisi Pengabdian | Nama Divisi\nDivisi AIK | Nama Divisi",
        ];
    }

    public static function all(): array
    {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $map = self::defaults();

        try {
            $rows = Database::pdo()
                ->query('SELECT setting_key, setting_value FROM settings')
                ->fetchAll();

            foreach ($rows as $row) {
                $map[$row['setting_key']] = (string) $row['setting_value'];
            }
        } catch (PDOException $e) {
            // Tabel belum ada: pakai default.
        }

        self::$cache = $map;

        return $map;
    }

    public static function get(string $key): string
    {
        $all = self::all();

        return (string) ($all[$key] ?? '');
    }

    public static function set(string $key, ?string $value): void
    {
        $stmt = Database::pdo()->prepare(
            'INSERT INTO settings (setting_key, setting_value)
             VALUES (?, ?)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)'
        );

        $stmt->execute([$key, $value]);

        self::$cache = null;
    }
}