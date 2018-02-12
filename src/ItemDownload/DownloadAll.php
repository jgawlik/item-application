<?php

declare(strict_types=1);

namespace App\ItemDownload;

class DownloadAll implements ItemDownloadOptionsInterface
{
    public function getQueryOptions(): array
    {
        return [];
    }
}
