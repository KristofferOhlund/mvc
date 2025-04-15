<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiJsonController extends AbstractController
{
    #[Route("/api", name:"jsonRoutes")]
    public function apiRoute(): Response
    {
        $apiRoutes = array();
        return $this->render("api.home.twig", $apiRoutes);
    }

    #[Route("/api/quote", name:"quote")]
    public function quote(): Response
    {
        $quotes = array(
            "quote1" => array(
                "citat" => "Den längsta resan för var och en är den inre resan.",
                "author" => "Dag Hammarskjöld"
            ),
            "quote2" => array(
                "citat" => "Alla människor borde behandlas som luft - något absolut livsnödvändigt.",
                "author" => "Stig Johansson"
            ),
            "quote3" => array(
                "citat" => "Allt stort som skedde i världen skedde först i någon människas fantasi",
                "author" => "Astrid Lindgren"
            ),
            "quote4" => array(
                "citat" => "Happy wife happy life",
                "author" => "Kristoffer Öhlund"
            ),
            "quote5" => array(
                "citat" => "Blommorna äro växternas blottade kärlek",
                "author" => "Carl von Linné"
            ),
        );

        $randomQuote = array_values($quotes)[random_int(0, count($quotes) - 1)];

        $responseQuote = array(
            "citat" => $randomQuote["citat"],
            "skapare" => $randomQuote["author"],
            "Current date" => date("Y-m-d"),
            "time_stamp" => date("c")
        );

        $response = new JsonResponse($responseQuote);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
