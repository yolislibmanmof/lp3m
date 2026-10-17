<?php

declare(strict_types=1);

class AikActivity
{
    use Crud;

    public const TABLE = 'aik_activities';

    public const CATEGORIES = [
        'kajian' => 'Kajian',
        'pembinaan' => 'Pembinaan',
        'dakwah' => 'Dakwah',
        'sosial' => 'Sosial',
        'pendidikan' => 'Pendidikan',
        'ramadhan' => 'Ramadhan',
        'lainnya' => 'Lainnya',
    ];
}