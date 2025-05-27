<?php

/**
 * Module for presenting the Adventure project
 */

namespace App\Controller\Adventure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ProjectController extends AbstractController
{   
    #[Route("/adventure/index", name:"index_adventure")]
    public function index()
    {
        return $this->render("adventure/base.html.twig");
    }


    #[Route("/adventure/about", name:"about_adventure")]
    public function about()
    {
        return $this->render("adventure/about.html.twig");
    }


    #[Route("/adventure/cheat", name:"chear_adventure")]
    public function cheat()
    {
        return $this->render("adventure/cheat.html.twig");
    }
}