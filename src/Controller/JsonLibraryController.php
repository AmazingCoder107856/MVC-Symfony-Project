<?php

namespace App\Controller;

use App\Repository\LibraryRepository;
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
                'booK_title' => $library->getBookTitle() ?? null,
                'book_author' => $library->getBookAuthor() ?? null,
                'book_isbn' => $library->getBookIsbn() ?? null,
                'image_url' => $library->getImageUrl() ?? null,
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
        mixed $book_isbn
    ): Response {
        $library = $libraryRepo->findOneBy(['book_isbn' => $book_isbn]);
        $data = [];

        if ($library) {
            $data[] = [
                'book_title' => $library->getBookTitle() ?? null,
                'book_author' => $library->getBookAuthor() ?? null,
                'book_isbn' => $library->getBookIsbn() ?? null,
                'image_url' => $library->getImageUrl() ?? null,
            ];
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
