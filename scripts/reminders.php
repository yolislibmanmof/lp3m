<?php
require dirname(__DIR__) . '/app/bootstrap.php';

$events = Database::pdo()->query("SELECT * FROM events WHERE status='published' AND start_date >= CURDATE() AND start_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)")->fetchAll();
foreach ($events as $ev) {
    $diff = (int) ((strtotime($ev['start_date']) - strtotime(date('Y-m-d'))) / 86400);
    $flags = [7 => 'reminder_h7', 3 => 'reminder_h3', 1 => 'reminder_h1'];
    if (isset($flags[$diff]) && !empty($ev[$flags[$diff]])) {
        $key = 'rem_' . $ev['id'] . '_h' . $diff;
        $exists = Database::pdo()->prepare("SELECT id FROM notifications WHERE module_type='event_reminder' AND module_id=? AND type=?");
        $exists->execute([$ev['id'], $key]);
        if (!$exists->fetch()) {
            Notification::push($key, '⏰ Reminder H-' . $diff, 'Kegiatan "' . $ev['title'] . '" akan dilaksanakan ' . ($diff === 1 ? 'BESOK' : 'dalam ' . $diff . ' hari') . ' (' . date('d M Y', strtotime($ev['start_date'])) . ').', 'reminder', url('public/index.php?page=agenda'), '⏰', null, true, 'event_reminder', (int) $ev['id']);
        }
    }
}
echo "Reminders processed: " . count($events) . " events checked.\n";