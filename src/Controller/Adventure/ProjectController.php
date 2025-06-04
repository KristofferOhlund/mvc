<?php

/**
 * Module for presenting the Adventure project
 */

namespace App\Controller\Adventure;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Room;
use App\Entity\Weapon;

class ProjectController extends AbstractController
{   
    /**
     * about page
     * 
     * @return Response
     */
    #[Route("/proj/about", name:"about_adventure")]
    public function about(): Response
    {
        return $this->render("adventure/about.html.twig");
    }

    /**
     * Cheat pge
     * 
     * @return Response
     */
    #[Route("/proj/cheat", name:"cheat_adventure")]
    public function cheat(): Response
    {
        return $this->render("adventure/cheat.html.twig");
    }
}
