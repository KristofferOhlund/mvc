<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{

    #[Route("/product/view", name: "product_view_all")]
    public function viewAllProduct(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        $data = [
            "products" => $products
        ];

        return $this->render("product/view.html.twig", $data);
    }


    /**
     * Använd Doctrins Query Builder
     * 
     */
    #[Route("/product/view/{value}", name: "product_view_minimum_value")]
    public function viewProductWithMinimumValue(ProductRepository $productRepository, int $value): Response
    {
        $products = $productRepository->findByMinimumValue($value);

        $data = [
            "products" => $products
        ];

        return $this->render("product/view.html.twig", $data);
    }


    /**
     * Använd SQL i ProductRepository
     */
    #[Route('/product/show/min/{value}', name: 'product_by_min_value')]
    public function showProductByMinimumValue(
        ProductRepository $productRepository,
        int $value
    ): Response {
        $products = $productRepository->findByMinimumValue2($value);

        return $this->json($products);
    }


    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * 
    * line 13 The EntityManagerInterface $entityManager argument tells Symfony to inject the Entity Manager service into the controller method. This object is responsible for saving objects to, and fetching objects from, the database.
    * lines 15-18 In this section, you instantiate and work with the $product object like any other normal PHP object.
    * line 21 The persist($product) call tells Doctrine to "manage" the $product object. This does not cause a query to be made to the database.
    * line 24 When the flush() method is called, Doctrine looks through all of the objects that it's managing to see if they need to be persisted to the database. In this example, the $product object's data doesn't exist in the database, so the entity manager executes an INSERT query, creating a new row in the product table.
     */
    #[Route("/product/create", name: "product_create")]
    public function createProduct(ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();

        // Create new product
        $product = new Product();
        $product->setName("Keyboard_num_" . rand(1, 9));
        $product->setValue(rand(100, 999));

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    #[Route("/product/show", name:"product_show_all")]
    public function showAllProduct(ProductRepository $productRepository): Response {
        $products = $productRepository->findAll();
        
        $response = $this->json($products);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }


    #[Route("/product/show/{id}", name: "product_by_id")]
    public function showProductByid(ProductRepository $productRepository, int $id): Response
    {
        $product = $productRepository->find($id);

        $response = $this->json($product);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }


    /**
     * Använd POST för att uppdatera databasen
     * Nedan är endast ett exempel för att visa Doctrine och hur man uppdaterar databasen
     */
    #[Route("/product/delete/{id}", name: "product_delete_by_id")]
    public function deleteProductById(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                "No product found for id " . $id
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute("product_show_all");
    }


    #[Route("/product/update/{id}/{value}", name: "product_update")]
    public function updateProduct(ManagerRegistry $doctrine, int $id, int $value): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException("No product found for " . $id);
        }

        $product->setValue($value);
        // Uppdatera produkt
        $entityManager->flush();

        return $this->redirectToRoute("product_show_all");
    }
}
