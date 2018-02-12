<?php

declare(strict_types=1);

namespace App\ItemDownload;

class DownloadNotAvailable implements ItemDownloadOptionsInterface
{
    public function getQueryOptions(): array
    {
        return ['amount_equals' => 0];
    }
}
