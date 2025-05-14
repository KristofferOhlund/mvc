<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LibraryController extends AbstractController
{
    #[Route("/library", name: "library_index")]
    public function index(): Response
    {   
        return $this->render("library/index.html.twig");
    }


    #[Route("/library/books", name: "book_view_all")]
    public function viewAllBook(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();

        $data = [
            "böcker" => $books
        ];

        return $this->render("library/view-all.html.twig", $data);
    }


    #[Route("/library/book/{num}", name: "read_one", requirements: ['num' => '\d+'])]
    public function viewBook(BookRepository $bookRepository, int $num): Response
    {   
        $book = $bookRepository->find($num);

        $data = [
            "bok" => $book
        ];

        return $this->render("library/view.html.twig", $data);
    }


    #[Route("/library/book/delete/{num}", name: "confirm_delete")]
    public function confirmDelete(BookRepository $bookRepository, int $num, Request $request): Response
    {   
        $book = $bookRepository->find($num);

        $data = [
            "bok" => $book
        ];

        return $this->render("library/delete.html.twig", $data);
    }


    #[Route("/library/book/delete", name: "delete_book")]
    public function deleteBook(BookRepository $bookRepository, Request $request, EntityManagerInterface $entityManager): Response
    {   
        $bookId = $request->request->get("book_id");
        if (!$bookId) {
            return $this->redirectToRoute("index");
        }
        $book = $bookRepository->find($bookId);

        $entityManager->remove($book);

        $entityManager->flush();

        $this->addFlash("notice", "Book with id $bookId has been removed");

        return $this->redirectToRoute("book_view_all");
    }



    #[Route("/library/book/update/{num}", name: "init_update_book", requirements: ['num' => '\d+'], methods:["GET"])]
    public function initUpdateBook(BookRepository $bookRepository, int $num): Response
    {   
        $book = $bookRepository->find($num);

        $data = [
            "book" => $book
        ];

        return $this->render("library/update-book.html.twig", $data);
    }


    #[Route("/library/book/update", name: "update_book", methods:["POST"])]
    public function updateBook(BookRepository $bookRepository, EntityManagerInterface $entityManager, Request $request): Response
    {   
        $bookId = $request->request->get("book_id");
        
        $book = $bookRepository->find($bookId);

        if (!$book) {
            throw new NotFoundHttpException("Book with id $bookId cannot be found!");
        }

        // Uppdatera objekt
        $book->setTitle($request->request->get("title"));
        $book->setIsbn($request->request->get("isbn"));
        $book->setAuthor($request->request->get("author"));
        $book->setPublisher($request->request->get("publisher"));
        $imgUrl = $request->request->get("img_url");
        $imgUrlFull = $imgUrl ? $imgUrl : "na.png";
        $book->setImgUrl($imgUrlFull);

        // Uppdatera databas
        $entityManager->persist($book);
        $entityManager->flush();

        $this->addFlash("notice", "Book with id $bookId has been updated!");

        return $this->redirectToRoute("init_update_book", ["num" => intval($bookId)]);
    }


    #[Route("/library/book/register", name: "register_book", methods:["GET"])]
    public function registerBook(): Response
    {   
        return $this->render("library/register-book.html.twig");
    }


    /**
     * Add new book to the database
     */
    #[Route("/library/book/add", name: "add_book", methods:["POST"])]
    public function addBook(Request $request, EntityManagerInterface $entityManager): Response
    {   
        $request->request->get("title");
        $book = new Book();
        $book->setTitle($request->request->get("title"));
        $book->setIsbn($request->request->get("isbn"));
        $book->setAuthor($request->request->get("author"));
        $book->setPublisher($request->request->get("publisher"));
        
        $img = $request->request->get("img_url");
        $book->setImgUrl($img ? $img . ".png" : "na.png");
        
        $entityManager->persist($book);

        $entityManager->flush();
        return $this->redirectToRoute("book_view_all");
    }
}