<?php

namespace App\Controller;

use App\Entity\Library;
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'library')]
    public function index(
        LibraryRepository $libraryRepo
    ): Response {
        $libraries = $libraryRepo->findAll();

        return $this->render('library/index.html.twig', [
            'libraries' => $libraries
        ]);
    }

    #[Route('/library/create', name: 'library_create', methods: ["GET", "POST"])]
    public function createLibrary(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        if ($request->isMethod("GET")) {
            return $this->render('library/create.html.twig');
        }

        $book_title = strval($request->request->get('book_title'));
        $book_author = strval($request->request->get('book_author'));
        $book_isbn = strval($request->request->get('book_isbn'));
        $image_url = strval($request->request->get('image_url'));

        $library = new Library();
        $library->setBookTitle($book_title);
        $library->setBookAuthor($book_author);
        $library->setBookIsbn($book_isbn);
        $library->setImageUrl($image_url);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($library);
        $entityManager->flush();

        $this->addFlash('notification:', "Another book is successfully added.");

        return $this->redirectToRoute('library');
    }

    #[Route('/library/read/{id<\d+>}', name: 'library_read')]
    public function ReadABook(
        LibraryRepository $libraryRepo,
        int $id
    ): Response {
        $library = $libraryRepo->find($id);

        if (!$library) {
            $this->addFlash('notification:', "The book is not available.");

            return $this->redirectToRoute('library');
        }

        return $this->render('library/book.html.twig', [
            'library' => $library
        ]);
    }

    #[Route('/library/delete', name: 'library_delete', methods: ["GET", "POST"])]
    public function libraryDelete(
        Request $request,
        LibraryRepository $libraryRepo,
        ManagerRegistry $doctrine
    ): Response {
        $libraryId = $request->request->get('library_id');
        $library = $libraryRepo->find($libraryId);
        $flash = "Book cannot be found in the database.";

        if ($library) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($library);
            $entityManager->flush();
            $flash = $library->getBookTitle() . "has been deleted.";
        }

        $this->addFlash('notification', $flash);

        return $this->redirectToRoute('library');
    }

    #[Route('/library/update/{id<\d+>}', name: 'library_update', methods: ["GET", "POST"])]
    public function UpdateABook(
        LibraryRepository $libraryRepo,
        Request $request,
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $library = $libraryRepo->find($id);

        if (!$library) {
            $this->addFlash('notification:', "The book is not available.");

            return $this->redirectToRoute('library_update');
        }

        if ($request->isMethod("GET")) {
            return $this->render('library/update.html.twig', [
                'library' => $library
            ]);
        }

        $book_title = strval($request->request->get('book_title'));
        $book_author = strval($request->request->get('book_author'));
        $book_isbn = strval($request->request->get('book_isbn'));
        $image_url = strval($request->request->get('image_url'));

        $library->setBookTitle($book_title);
        $library->setBookAuthor($book_author);
        $library->setBookIsbn($book_isbn);
        $library->setImageUrl($image_url);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($library);
        $entityManager->flush();

        $this->addFlash('notification', "Changes has been saved.");

        return $this->redirectToRoute('library');
    }
}
