<?php

declare(strict_types=1);

namespace App\ItemDownload;

class DownloadInStock implements ItemDownloadOptionsInterface
{
    public function getQueryOptions(): array
    {
        return ['amount_greater' => 0];
    }
}
