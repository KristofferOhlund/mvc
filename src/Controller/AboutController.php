<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController {
    #[Route("/", name:"home")]
    public function home(): Response {
        return $this->render("home.html.twig");
    }


    #[Route("/about", name:"about")]
    public function about(): Response {
        return $this->render("about.html.twig");
    }
}


// class LuckyController
// {
//     #[Route('/lucky/number')]
//     public function number(): Response
//     {
//         $number = random_int(0, 100);

//         return new Response(
//             '<html><body>Lucky MEGA number: '.$number.'</body></html>'
//         );
//     }

//     #[Route("/lucky/hi")]
//     public function hi(): Response{
//         return new Response(
//             "<html><body>Hi to you!</body></html>"
//         );
//     }
// }


