<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController {
    #[Route("/game", name:"game_info")]
    public function game(): Response {
        return $this->render("game/game-info.html.twig");
    }

    #[Route("/game/play", name:"game_play")]
    public function gamePlay(): Response {
        return $this->render("game/game-play.html.twig");
    }
}