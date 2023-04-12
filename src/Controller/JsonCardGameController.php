<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\Deck;

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

    #[Route("/card/deck/draw/{num<\d+>}", name: "card_deck_draw_number")]
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
}
