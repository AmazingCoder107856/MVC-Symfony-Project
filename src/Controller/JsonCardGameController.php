<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\Deck;
use App\Card\DeckofCards;
use App\Card\CardHand;
use App\Game21\Game21;
use Exception;
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
        $card = new Card();

        $data = [
            "cards" => $card->buildDeck(),
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
        $card = new Deck();

        $data = [
            "cards" => $card->getDeckShuffled(),
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

        $card = new Deck();
        for ($i = 1; $i <= $numCard; $i++) {
            $card->getDeckShuffled();
        }

        return $this->redirectToRoute('api_deck_shuffle_get');
    }

    #[Route("/api/deck/draw", name: "api_deck_draw_get", methods: ['GET'])]
    public function draw(): Response
    {
        $card = new Deck();

        $data = [
            "num_cards" => (count($card->getDeckShuffled()) - 1),
            "cardString" => $card->drawOneCard(),
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

        $card = new Deck();
        for ($i = 1; $i <= $numCard; $i++) {
            $card->drawOneCard();
        }

        $session->set("card_carddraw", $card);
        $session->set("card_cardnum", $numCard);

        return $this->redirectToRoute('api_deck_draw_get');
    }

    #[Route("/api/deck/draw/{num<\d+>}", name: "api_deck_drawmany_get", methods: ['GET'])]
    public function drawMany(int $num): Response
    {
        $cards = [];
        for ($i=1; $i <= $num; $i++) {
            $card = new Deck();
            $cards[] = $card->drawOneCard();
        }

        $data = [
            "num_cards" => (52 - $num),
            "cardString" => $cards
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
            $card = new Deck();
            $cards[] = $card->drawOneCard();
        }

        $session->set("card_draw", $cards);
        $session->set("card_num", $numCard);

        return $this->redirectToRoute('api_deck_drawmany_get');
    }

    #[Route("/api/deck/draw/{num<\d+>}", name: "api_deck_draw_number")]
    public function drawManyCards(int $num): Response
    {
        $cards = [];
        for ($i=1; $i <= $num; $i++) {
            $card = new Deck();
            $cards[] = $card->drawOneCard();
        }

        $data = [
            "num_cards" => (count($card->getDeckShuffled()) - $num),
            "cardString" => $cards
        ];

        return $this->render('card/draw_many.html.twig', $data);
    }

    #[Route("/api/play/{players<\d+>}/{cards<\d+>}", name: "api_play", methods: ["GET", "POST"])]
    public function apiDeal(
        SessionInterface $session,
        int $players,
        int $cards
    ): Response {
        $deck = $session->get("deck") ?? new DeckofCards();
        $session->set("deck", $deck);
        $hands = [];

        for ($i = 1; $i <= $players; $i++) {
            $hands["player" . $i] = new CardHand();
        }

        for ($j = 0; $j < $cards; $j++) {
            foreach ($hands as $hand) {
                try {
                    $hand->add($deck->draw());
                } catch (TypeError $e) {
                    break;
                }
            }
        }

        $data = [
            'cardsRemaining' => $deck->getCardsRemaining(),
            'hands' => array_map(function ($hand) { return $hand->peekAllCards(); }, $hands)
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/game", name: "api_game", methods: ["GET"])]
    public function apiGame(SessionInterface $session): Response
    {
        $game21 = $session->get("game21") ?? new Game21();
        // $session->set("deck", $game21);

        // $play = $request->request->get('play');

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
