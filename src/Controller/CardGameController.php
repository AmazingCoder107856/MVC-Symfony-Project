<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\Deck;
use App\Card\DeckofCards;
use App\Card\CardHand;
use Exception;
use TypeError;
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

    #[Route("/card/deck/draw/{num<\d+>}", name: "card_deck_draw_numbers")]
    public function drawManyCards(int $num): Response
    {
        $cards = [];
        $totcards = 52;
        for ($i=1; $i <= $num; $i++) {
            $card = new Deck();
            $cards[] = $card->drawOneCard();
        }

        $data = [
            "num_cards" => ($totcards - $num),
            "cardString" => $cards
        ];

        return $this->render('card/draw_many.html.twig', $data);
    }

    #[Route("/card/cardplay/{players<\d+>}/{cards<\d+>}", name: "card_play")]
    public function cardPlay(
        SessionInterface $session,
        int $players,
        int $cards
    ): Response {
        $deck = $session->get("deck") ?? new DeckofCards();
        $session->set("deck", $deck);
        $hands = [];

        // ge varje spela en hand
        for ($i = 0; $i < $players; $i++) {
            $hands[] = new CardHand();
        }

        // dela ut ett kort per spelare ända tills det är färdigt eller leken är slut
        for ($j = 0; $j < $cards; $j++) {
            foreach ($hands as $hand) {
                try {
                    $hand->add($deck->draw());
                } catch (TypeError $e) {
                    break;
                }
            }
        }

        return $this->render('card/cardplay.html.twig', [
            'deck' => $deck,
            'hands' => $hands,
        ]);
    }
}
