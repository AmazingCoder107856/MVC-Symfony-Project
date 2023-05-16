<?php

namespace App\Controller;

use App\Entity\Library;
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JsonLibraryController extends AbstractController
{
    #[Route("/api/library/books", name: "api_library_books", methods: ["GET"])]
    public function apiLibraryBooks(
        LibraryRepository $libraryRepo,
    ): Response {
        $data = [];
        $libraries = $libraryRepo->findAll();
        foreach ($libraries as $library) {
            $data[] = [
                'bookTitle' => $library->getBookTitle() ?? null,
                'bookAuthor' => $library->getBookAuthor() ?? null,
                'bookIsbn' => $library->getBookIsbn() ?? null,
                'imageUrl' => $library->getImageUrl() ?? null,
            ];
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/library/book/{isbn}", name: "api_library_book", methods: ["GET"])]
    public function apiLibraryBook(
        LibraryRepository $libraryRepo,
        mixed $bookIsbn
    ): Response {
        $library = $libraryRepo->findOneBy(['bookIsbn' => $bookIsbn]);
        $data = [];

        if ($library) {
            $data[] = [
                'bookTitle' => $library->getBookTitle() ?? null,
                'bookAuthor' => $library->getBookAuthor() ?? null,
                'bookIsbn' => $library->getBookIsbn() ?? null,
                'imageUrl' => $library->getImageUrl() ?? null,
            ];
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
