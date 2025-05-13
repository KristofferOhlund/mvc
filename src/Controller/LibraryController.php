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


    #[Route("/library/book/", name: "read_one")]
    public function viewBook(): Response
    {   

        $data = [
            "böcker" => []
        ];

        return $this->render("library/index.html.twig", $data);
    }


    #[Route("/library/book/register", name: "register_book", methods:["GET"])]
    public function registerBook(): Response
    {   
        return $this->render("library/register-book.html.twig");
    }


    #[Route("/library/book/add", name: "add_book", methods:["POST"])]
    public function addBook(): Response
    {   
        return $this->redirectToRoute("book_view_all");
    }
}