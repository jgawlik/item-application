<?php

declare(strict_types=1);

namespace App\ItemDownload;

interface ItemDownloadOptionsInterface
{
    const ALL = 'all';
    const NOT_AVAILABLE = 'not_available';
    const GREATER_THAN_5 = 'greater_than_5';

    const AVAILABLE_DOWNLOAD_OPTIONS = [
        self::ALL => 'Pobierz wszystkie produkty',
        self::NOT_AVAILABLE => 'Pobierz nieznajdujące się na składzie produkty',
        self::GREATER_THAN_5 => 'Pobierz znajdują się na składzie w ilości większej niż 5',
    ];

    public function getQueryOptions(): array;
}
