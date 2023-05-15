<?php

namespace App\Controller;

use App\Game21\Game21;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonGame21Controller extends AbstractController
{

    #[Route("/api/game", name: "api_game", methods: ["GET"])]
    public function apiGame(SessionInterface $session): Response
    {
        $game21 = $session->get("game21") ?? new Game21();

        if ($game21) {
            $game21->firstPlay();
            $session->set('game21', $game21);
        }

        $data = [
            'dealer' => $game21 ->getDealerCards(),
            'player' => $game21 ->getPlayerCards(),
            'dealerscore' => $game21 ->getDealerScore(),
            'playerscore' => $game21->getPlayerScore(),
            'firstdraw' => $game21 ->checkFirstDraw()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
