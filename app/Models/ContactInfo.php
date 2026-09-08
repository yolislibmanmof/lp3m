<?php
declare(strict_types=1);

class ContactInfo
{
    public static function get(): ?array
    {
        // Ambil baris pertama (kita asumsikan hanya ada 1 konfigurasi kontak utama)
        return Database::pdo()->query("SELECT * FROM contact_info LIMIT 1")->fetch() ?: null;
    }

    public static function save(array $data): void
    {
        $existing = self::get();
        if ($existing) {
            $stmt = Database::pdo()->prepare("UPDATE contact_info SET address = ?, phone = ?, whatsapp = ?, email = ?, office_hours = ?, map_embed = ? WHERE id = ?");
            $stmt->execute([$data['address'], $data['phone'], $data['whatsapp'], $data['email'], $data['office_hours'], $data['map_embed'], $existing['id']]);
        } else {
            $stmt = Database::pdo()->prepare("INSERT INTO contact_info (address, phone, whatsapp, email, office_hours, map_embed) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$data['address'], $data['phone'], $data['whatsapp'], $data['email'], $data['office_hours'], $data['map_embed']]);
        }
    }
}