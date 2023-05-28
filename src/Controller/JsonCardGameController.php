<?php

namespace App\Controller;

use App\Card\CardDeck;
use App\Card\CardHand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use TypeError;

class JsonCardGameController extends AbstractController
{
    #[Route("/api/deck", name: "api_deck", methods: ['GET'])]
    public function deck(): Response
    {
        $cards = new CardDeck();

        $data = [
            "cards" => $cards->getDeck()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_deck_shuffle", methods: ['GET', 'POST'])]
    public function shuffleCallback(
        Request $request
    ): Response {
        $numCard = $request->request->get('num_cards');

        $cards = new CardDeck();
        for ($i = 1; $i <= $numCard; $i++) {
            $cards->shuffles();
        }

        $data = [
            "cards" => $cards->getDeck()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }


    #[Route("/api/deck/draw", name: "api_deck_draw", methods: ['GET', 'POST'])]
    public function drawCallback(
        Request $request,
        SessionInterface $session
    ): Response {
        $numCard = $request->request->get('num_cards');

        $card = new CardDeck();
        $card->shuffles();
        for ($i = 1; $i <= $numCard; $i++) {
            $card->draw();
        }

        $session->set("card_carddraw", $card);
        $session->set("card_cardnum", $numCard);

        $data = [
            "num_cards" => $card->countCards() - 1,
            "cards" => $card->draw(1),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }


    #[Route("/api/deck/draw/{num<\d+>}", name: "api_deck_drawmany", methods: ['GET', 'POST'])]
    public function drawManyCallback(
        Request $request,
        SessionInterface $session,
        int $num
    ): Response {
        $numCard = $request->request->get('num_cards');

        $card = new CardDeck();
        $card->shuffles();

        $cards = [];
        for ($i=1; $i <= $numCard; $i++) {
            $cards[] = $card->draw();
        }

        $session->set("card_draw", $cards);
        $session->set("card_num", $numCard);

        $data = [
            "num_cards" => $card->countCards() - $num,
            "cards" => $card->draw($num),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }


    #[Route("/api/deck/play/{players<\d+>}/{cards<\d+>}", name: "api_play", methods: ['GET', 'POST'])]
    public function apiDeal(
        SessionInterface $session,
        int $players,
        int $cards
    ): Response {
        $deck = $session->get("deck") ?? new CardDeck();
        $deck->shuffles();
        $session->set("deck", $deck);
        $hands = [];

        for ($i = 0; $i < $players; $i++) {
            $hands[] = new CardHand();
        }

        foreach ($hands as $hand) {
            for ($j = 0; $j < $cards; $j++) {
                try {
                    $card = $deck->draw();
                    $hand->addCardHand($card);
                } catch (TypeError) {
                    break;
                }
            }
        }

        $data = [
            'deck' => $deck,
            'hands' => $hands,
            "cards" => $deck->draw()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
