<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonLibraryController extends AbstractController
{
    #[Route("api/library/books", name: "view_books_json")]
    public function viewBookJson(BookRepository $bookRepository): JsonResponse
    {   
        $books = $bookRepository->findAll();

        // this->json serialiserar mina objekt i books
        // JsonResponse kräver redan serialiserad data
        $response = $this->json($books);
        
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }


    #[Route("api/library/books/{isbn}", name: "view_single_book_json", requirements:["isbn" => "[1-9-]+"])]
    public function viewSingleBookJson(BookRepository $bookRepository, string $isbn): JsonResponse
    {   

        $book = $bookRepository->findByIsbn($isbn);

        // this->json serialiserar mina objekt i books
        // JsonResponse kräver redan serialiserad data
        $response = $this->json($book);
        
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        
        return $response;
       
    }
}