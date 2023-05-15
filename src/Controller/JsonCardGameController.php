<?php

namespace App\Controller;

use App\Card\CardDeck;
use App\Card\CardHand;
use TypeError;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

    #[Route("/api/deck/shuffle", name: "api_deck_shuffle_get", methods: ['GET'])]
    public function shuffle(): Response
    {
        $cards = new CardDeck();
        $cards->shuffles();

        $data = [
            "cards" => $cards->getDeck()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_deck_shuffle", methods: ['POST'])]
    public function shuffleCallback(
        Request $request
    ): Response {
        $numCard = $request->request->get('num_cards');

        $card = new CardDeck();
        for ($i = 1; $i <= $numCard; $i++) {
            $card->shuffles();
        }

        return $this->redirectToRoute('api_deck_shuffle_get');
    }

    #[Route("/api/deck/draw", name: "api_deck_draw_get", methods: ['GET'])]
    public function draw(): Response
    {
        $cards = new CardDeck();
        $cards->shuffles();

        $data = [
            "num_cards" => $cards->countCards() - 1,
            "cards" => $cards->draw(1),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw", name: "api_deck_draw", methods: ['POST'])]
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

        return $this->redirectToRoute('api_deck_draw_get');
    }

    #[Route("/api/deck/draw/{num<\d+>}", name: "api_deck_drawmany_get", methods: ['GET'])]
    public function drawMany(int $num): Response
    {
        $cards = new CardDeck();
        $cards->shuffles();

        $data = [
            "num_cards" => $cards->countCards() - $num,
            "cards" => $cards->draw($num),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw/{num<\d+>}", name: "api_deck_drawmany", methods: ['POST'])]
    public function drawManyCallback(
        Request $request,
        SessionInterface $session
    ): Response {
        $numCard = $request->request->get('num_cards');

        $cards = [];
        for ($i=1; $i <= $numCard; $i++) {
            $card = new CardDeck();
            $card->shuffles();
            $cards[] = $card->draw();
        }

        $session->set("card_draw", $cards);
        $session->set("card_num", $numCard);

        return $this->redirectToRoute('api_deck_drawmany_get');
    }


    #[Route("/api/play/{players<\d+>}/{cards<\d+>}", name: "api_play", methods: ["GET", "POST"])]
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
                    $card = $deck->draw($cards);
                    $hand->addCardHand($card);
                } catch (TypeError) {
                    break;
                }
            }
        }

        $data = [
            'deck' => $deck,
            'hands' => $hands,
            "cards" => $deck->draw($cards)
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
