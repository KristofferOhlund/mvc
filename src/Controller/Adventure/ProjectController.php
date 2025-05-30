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

    #[Route("/proj/about", name:"about_adventure")]
    public function about()
    {
        return $this->render("adventure/about.html.twig");
    }


    #[Route("/proj/cheat", name:"cheat_adventure")]
    public function cheat()
    {
        return $this->render("adventure/cheat.html.twig");
    }
}