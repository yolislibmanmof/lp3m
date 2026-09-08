<?php

declare(strict_types=1);

class CommunityService
{
    use Crud;

    public const TABLE = 'community_services';

    public const TYPES = [
        'pengabdian' => 'Pengabdian Dosen',
        'kkn' => 'KKN Mahasiswa',
        'desa_binaan' => 'Desa Binaan',
    ];
}