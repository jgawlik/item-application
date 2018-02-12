<?php

declare(strict_types=1);

namespace App\Controller;

use ApiClient\Exception\ItemException;
use ApiClient\Service\ItemInterface;
use App\ItemDownload\ItemDownloadOptionsFactory;
use App\ItemDownload\ItemDownloadOptionsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;

class ItemController extends AbstractController
{
    private $itemApi;

    public function __construct(ItemInterface $itemApi)
    {
        $this->itemApi = $itemApi;
    }

    public function showItems(): Response
    {
        try {
            $items = $this->itemApi->getByParams([]);
        } catch (ItemException $exception) {
            $this->addFlash('danger', $exception->getMessage());
            return $this->render('item/showItems.html.twig', [
                'items' => [],
                'downloadOptions' => ItemDownloadOptionsInterface::AVAILABLE_DOWNLOAD_OPTIONS
            ]);
        }

        return $this->render('item/showItems.html.twig', [
            'items' => $items,
            'downloadOptions' => ItemDownloadOptionsInterface::AVAILABLE_DOWNLOAD_OPTIONS
        ]);
    }

    public function downloadItem(string $downloadOption)
    {
        $itemDownloadOption = (new ItemDownloadOptionsFactory())->getItemDownloadOption($downloadOption);
        try {
            $filteredItems = $this->itemApi->getByParams($itemDownloadOption->getQueryOptions());
        } catch (ItemException $exception) {
            $this->addFlash('danger', $exception->getMessage());
            return $this->render('item/showItems.html.twig', [
                'items' => [],
                'downloadOptions' => ItemDownloadOptionsInterface::AVAILABLE_DOWNLOAD_OPTIONS
            ]);
        }


        return $this->getCsvResponse($filteredItems);
    }

    private function getCsvResponse(array $csvData): Response
    {
        $serializer = new Serializer([], [new CsvEncoder()]);
        $response = new Response(
            $serializer->serialize(
                $csvData,
                'csv',
                ['groups' => ['csv']]
            )
        );

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename=items_list.csv');

        return $response;
    }
}
