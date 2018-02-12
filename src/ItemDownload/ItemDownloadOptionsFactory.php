<?php

declare(strict_types=1);

namespace App\ItemDownload;

use App\Exception\InvalidDownloadItemOptionException;

class ItemDownloadOptionsFactory
{
    const ITEM_DOWNLOAD_CLASSES = [
        ItemDownloadOptionsInterface::ALL => DownloadAll::class,
        ItemDownloadOptionsInterface::NOT_AVAILABLE => DownloadNotAvailable::class,
        ItemDownloadOptionsInterface::GREATER_THAN_5 => DownloadGreaterThan5::class,
    ];

    public function getItemDownloadOption(string $downloadType): ItemDownloadOptionsInterface
    {
        if (!array_key_exists($downloadType, self::ITEM_DOWNLOAD_CLASSES)) {
            throw new InvalidDownloadItemOptionException();
        }
        $itemDownloadOptionsClassName = self::ITEM_DOWNLOAD_CLASSES[$downloadType];

        return new $itemDownloadOptionsClassName;
    }
}
