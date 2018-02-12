<?php

declare(strict_types=1);

namespace App\ItemDownload;

class DownloadGreaterThan5 implements ItemDownloadOptionsInterface
{
    public function getQueryOptions(): array
    {
        return ['amount_greater' => 5];
    }
}
