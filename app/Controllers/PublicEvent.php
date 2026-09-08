<?php
declare(strict_types=1);

class PublicEvent
{
    public static function index(): void
    {
        $month = preg_match('/^\d{4}-\d{2}$/', $_GET['month'] ?? '') ? $_GET['month'] : date('Y-m');
        View::render('public/agenda/index', [
            'title' => 'Agenda Kegiatan | ' . APP_NAME,
            'upcoming' => CalendarEvent::upcoming(10),
            'monthEvents' => CalendarEvent::byMonth($month),
            'month' => $month,
        ]);
    }
}