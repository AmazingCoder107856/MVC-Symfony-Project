<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\Deck;
use App\Card\CardHand;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card")]
    public function card(): Response
    {
        return $this->render('card/page.html.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function sortedCards(): Response
    {
        $card = new Card();

        $data = [
            "cards" => $card->buildDeck(),
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function shuffledCards(): Response
    {
        $card = new Deck();

        $data = [
            "cards" => $card->getDeckShuffled(),
        ];

        return $this->render('card/shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_deck_draw")]
    public function drawCard(): Response
    {
        $card = new Deck();

        $data = [
            "num_cards" => (count($card->getDeckShuffled()) - 1),
            "cardString" => $card->drawOneCard(),
        ];

        return $this->render('card/draw.html.twig', $data);
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

    #[Route("/game/card/init", name: "card_init_get", methods: ['GET'])]
    public function init(): Response
    {
        return $this->render('card/init.html.twig');
    }


    #[Route("/game/card/init", name: "card_init_post", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response {
        $numCard = $request->request->get('num_cards');

        $hand = new CardHand();
        for ($i = 1; $i <= $numCard; $i++) {
            $hand->add(new Deck());
        }
        $hand->draw();

        $session->set("card_cardhand", $hand);
        $session->set("card_cards", $numCard);
        $session->set("card_round", 0);
        $session->set("card_total", 0);

        return $this->redirectToRoute('card_play');
    }

    #[Route("/game/card/play", name: "card_play", methods: ['GET'])]
    public function play(
        SessionInterface $session
    ): Response {
        $cardhand = $session->get("card_cardhand");

        $data = [
            "cardCards" => $session->get("card_cards"),
            "cardRound" => $session->get("card_round"),
            "cardTotal" => $session->get("card_total"),
            "cardValues" => $cardhand->getString()
        ];

        return $this->render('card/play.html.twig', $data);
    }

    #[Route("/game/card/roll", name: "card_roll", methods: ['POST'])]
    public function roll(
        SessionInterface $session
    ): Response {
        $hand = $session->get("card_cardhand");
        $hand->roll();

        $roundTotal = $session->get("card_round");
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

        $session->set("card_round", $roundTotal + $round);

        return $this->redirectToRoute('card_play');
    }

    #[Route("/game/card/save", name: "card_save", methods: ['POST'])]
    public function save(
        SessionInterface $session
    ): Response {
        $roundTotal = $session->get("card_round");
        $gameTotal = $session->get("card_total");

        $session->set("card_round", 0);
        $session->set("card_total", $roundTotal + $gameTotal);

        $this->addFlash(
            'notice',
            'Your round was saved to the total!'
        );

        return $this->redirectToRoute('card_play');
    }

}
