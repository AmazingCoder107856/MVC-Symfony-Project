<?php

namespace App\Controller;

use App\Card\CardDeck;
use App\Card\CardHand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use TypeError;

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
        $cards = new CardDeck();

        $data = [
            "cards" => $cards->getDeck()
        ];

        return $this->render('card/deck.html.twig', $data);
    }


    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function shuffledCards(): Response
    {
        $cards = new CardDeck();
        $cards->shuffles();

        $data = [
            "cards" => $cards->getDeck()
        ];

        return $this->render('card/shuffle.html.twig', $data);
    }


    #[Route("/card/deck/draw", name: "card_deck_draw")]
    public function drawCard(): Response
    {
        $cards = new CardDeck();
        $cards->shuffles();

        $data = [
            "num_cards" => $cards->countCards() - 1,
            "cards" => $cards->draw(1),
        ];

        return $this->render('card/draw.html.twig', $data);
    }


    #[Route("/card/deck/draw/{num<\d+>}", name: "card_deck_draw_numbers")]
    public function drawManyCards(int $num): Response
    {
        $cards = new CardDeck();
        $cards->shuffles();

        $data = [
            "num_cards" => $cards->countCards() - $num,
            "cards" => $cards->draw($num),
        ];

        return $this->render('card/draw_many.html.twig', $data);
    }


    #[Route("/card/cardplay/{players}/{cards}", name: "card_play")]
    public function cardPlay(
        SessionInterface $session,
        int $players,
        int $cards
    ): Response {
        $deck = new CardDeck();
        $deck->shuffles();
        $deck->getDeck();
        $hands = [];

        $deck1 = $session->get("deck") ?? $deck;

        for ($i = 0; $i < $players; $i++) {
            $hands[] = new CardHand();
        }

        for ($j = 0; $j < $cards; $j++) {
            foreach ($hands as $hand) {
                try {
                    $card = $deck->draw();
                    $hand->addCardHand($card);
                } catch (TypeError $e) {
                    break;
                }
            }
            $session->set("deck", $deck1);
        }

        $data = [
            'deck' => $deck1,
            'hands' => $hands,
            "cards" => $deck1->draw()
        ];

        return $this->render('card/cardplay.html.twig', $data);
    }
}
