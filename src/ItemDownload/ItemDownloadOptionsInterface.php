<?php

declare(strict_types=1);

namespace App\ItemDownload;

interface ItemDownloadOptionsInterface
{
    const AVAILABLE_DOWNLOAD_OPTIONS = [
        'all' => 'Pobierz wszystkie produkty',
        'not_available' => 'Pobierz nieznajdujące się na składzie produkty',
        'greater_than_5' => 'Pobierz znajdują się na składzie w ilości większej niż 5',
    ];

    public function getQueryOptions(): array;
}