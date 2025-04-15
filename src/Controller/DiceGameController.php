<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Dice\DiceGraphic; // vårat namespace i src
use App\Dice\DiceHand; // vårat namespace i src
use App\Dice\Dice; // vårat namespace i src

class DiceGameController extends AbstractController
{
    #[Route("/game/pig", name: "pig_start")]
    public function pighome(): Response
    {
        return $this->render('pig/home.html.twig');
    }

    #[Route("/game/pig/test/roll", name: "test_roll_dice")]
    public function testRollDice(): Response
    {
        $die = new DiceGraphic();

        $data = [
            "dice" => $die->roll(),
            "diceString" => $die->getAsString(),
        ];

        return $this->render('pig/test/roll.html.twig', $data);
    }

    #[Route("/game/pig/test/roll/{num_dices<\d+>}", name: "test_roll_dices")]
    public function testRollDices(int $num_dices): Response
    {
        if ($num_dices > 99) {
            throw new \Exception("Can not roll more than 99 dices!");
        }

        $dice_strings = [];
        for ($i = 0; $i < $num_dices; $i++) {
            $dice = new DiceGraphic();
            $dice->roll();
            $dice_strings[] = $dice->getAsString();
        }

        $data = [
            "dices" => $num_dices,
            "diceStrings" => $dice_strings,
        ];

        return $this->render('pig/test/roll_many.html.twig', $data);
    }

    #[Route("/game/pig/test/dicehand/{num<\d+>}", name: "test_dicehand")]
    public function testDiceHand(int $num): Response
    {
        if ($num > 99) {
            throw new \Exception("Can not roll more than 99 dices!");
        }

        $hand = new DiceHand();
        for ($i = 1; $i <= $num; $i++) {
            if ($i % 2 === 1) {
                $hand->add(new DiceGraphic());
            } else {
                $hand->add(new Dice());
            }
        }

        $hand->roll();

        $data = [
            "num_dices" => $hand->getNumberDices(),
            "diceRoll" => $hand->getString(),
        ];

        return $this->render('pig/test/dicehand.html.twig', $data);
    }

    #[Route("/game/pig/init", name: "pig_init_get", methods: ['GET'])]
    public function init(): Response
    {
        return $this->render('pig/init.html.twig');
    }



    #[Route("/game/pig/init", name: "pig_init_post", methods: ['POST'])]
    public function initCallBack(Request $request, SessionInterface $session): Response
    {
        $numDice = $request->request->get('num_dices');

        $hand = new DiceHand();
        for ($i = 1; $i <= $numDice; $i++) {
            $hand->add(new DiceGraphic());
        }
        $hand->roll();

        // starta session
        $session->set("pig_dicehand", $hand);
        $session->set("pig_dices", $numDice);
        $session->set("pig_round", 0);
        $session->set("pig_total", 0);
        return $this->redirectToRoute('pig_play');
    }



    #[Route("/game/pig/play", name: "pig_play", methods: ['GET'])]
    public function play(
        SessionInterface $session
    ): Response {
        $dicehand = $session->get("pig_dicehand");

        $data = [
            "pigDices" => $session->get("pig_dices"),
            "pigRound" => $session->get("pig_round"),
            "pigTotal" => $session->get("pig_total"),
            "diceValues" => $dicehand->getString(),
        ];

        return $this->render('pig/play.html.twig', $data);
    }




    #[Route("/game/pig/roll", name: "pig_roll", methods: ['POST'])]
    public function roll(SessionInterface $session): Response
    {
        // Logic to roll the dice
        $hand = $session->get("pig_dicehand");
        $hand->roll();

        $roundTotal = $session->get("pig_round");
        $round = 0;
        $values = $hand->getValues();
        foreach ($values as $value) {
            if ($value === 1) {
                $round = 0;
                $roundTotal = 0;
                $this->addFlash(
                    'warning',
                    'You got a 1 and you lost the round points!'
                );
                break;
            }
            $round += $value;
        }

        $session->set("pig_round", $roundTotal + $round);

        return $this->redirectToRoute('pig_play');
    }





    #[Route("/game/pig/save", name: "pig_save", methods: ['POST'])]
    public function save(SessionInterface $session): Response
    {
        // Logic to save the round
        $roundTotal = $session->get("pig_round");
        $gameTotal = $session->get("pig_total");

        $session->set("pig_round", 0);
        $session->set("pig_total", $gameTotal + $roundTotal);

        $this->addFlash(
            'notice',
            'Your round was saved to the total!'
        );

        return $this->redirectToRoute("pig_play");
    }
}
