<?php

declare(strict_types=1);

class Publication
{
    use Crud;

    public const TABLE = 'publications';

    public const TYPES = [
        'jurnal' => 'Jurnal',
        'prosiding' => 'Prosiding',
        'buku' => 'Buku',
        'book_chapter' => 'Book Chapter',
        'artikel_populer' => 'Artikel Populer',
    ];
}