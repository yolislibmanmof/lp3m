<?php

declare(strict_types=1);

class IntellectualProperty
{
    use Crud;

    public const TABLE = 'intellectual_properties';

    public const TYPES = [
        'hak_cipta' => 'Hak Cipta',
        'paten' => 'Paten',
        'merek' => 'Merek',
        'desain_industri' => 'Desain Industri',
    ];

    public const STATUSES = [
        'draft_internal' => 'Draft Internal',
        'review_internal' => 'Review Internal',
        'diajukan_djki' => 'Diajukan ke DJKI',
        'perbaikan' => 'Perbaikan',
        'sertifikat_terbit' => 'Sertifikat Terbit',
    ];
}