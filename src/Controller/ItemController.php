<?php

declare(strict_types=1);

namespace App\Controller;

use ApiClient\Service\ItemInterface;
use App\ItemDownload\ItemDownloadOptionsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends AbstractController
{
    private $itemApi;

    public function __construct(ItemInterface $itemApi)
    {
        $this->itemApi = $itemApi;
    }

    public function showItems(): Response
    {
        $items = $this->itemApi->getByParams([]);

        return $this->render('item/showItems.html.twig', [
            'items' => $items,
            'downloadOptions' => ItemDownloadOptionsInterface::AVAILABLE_DOWNLOAD_OPTIONS
        ]);
    }

    public function downloadItem()
    {
        //TODO
    }
}
