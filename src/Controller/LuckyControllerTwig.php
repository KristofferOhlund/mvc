<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/lucky", name: "lucky")]
    public function dynamic(): Response
    {
        $images = array("one.png", "two.png", "three.png", "four.png", "five.png", "six.png");
        $number = random_int(0, count($images) - 1);
        $slicedImages = array_slice($images, $number);
        $data = [
            "images" => $slicedImages
        ];

        return $this->render("lucky.html.twig", $data);
    }
}
