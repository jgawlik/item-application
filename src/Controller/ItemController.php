<?php

declare(strict_types=1);

namespace App\Controller;

use ApiClient\Exception\ItemClientException;
use ApiClient\Exception\ItemServerException;
use ApiClient\Service\ItemInterface;
use App\Form\Type\ItemFromType;
use App\ItemDownload\ItemDownloadOptionsFactory;
use App\ItemDownload\ItemDownloadOptionsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $items = [];
        try {
            $items = $this->itemApi->getByParams([]);
        } catch (ItemClientException $exception) {
            $this->addFlash('danger', $exception->getMessage());
        } catch (ItemServerException $serverException) {
            $this->addFlash('danger', 'Wystąpił błąd przy pobieraniu listy produktów, spróbuj ponownie później.');
        }

        return $this->render('item/show.html.twig', [
            'items' => $items,
            'downloadOptions' => ItemDownloadOptionsInterface::AVAILABLE_DOWNLOAD_OPTIONS
        ]);
    }

    public function addItem(Request $request): Response
    {
        $form = $this->createForm(ItemFromType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //TODO
            $this->addFlash('success', 'Poprawnie dodano nowy produkt!');
            return $this->redirectToRoute('items_show');
        }

        return $this->render('item/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function downloadItem(string $downloadOption): Response
    {
        $itemDownloadOption = (new ItemDownloadOptionsFactory())->getItemDownloadOption($downloadOption);
        try {
            $filteredItems = $this->itemApi->getByParams($itemDownloadOption->getQueryOptions());
        } catch (ItemClientException $exception) {
            $this->addFlash('danger', $exception->getMessage());

            return $this->redirectToRoute('items_show');
        } catch (ItemServerException $serverException) {
            $this->addFlash('danger', 'Wystąpił błąd przy pobieraniu listy produktów, spróbuj ponownie później.');

            return $this->redirectToRoute('items_show');
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
