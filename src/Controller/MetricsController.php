<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class MetricsController extends AbstractController
{
    #[Route("/metrics", name:"index_metrics")]
    public function Index(): Response
    {
        return $this->render("metrics/index.html.twig");
    }
}