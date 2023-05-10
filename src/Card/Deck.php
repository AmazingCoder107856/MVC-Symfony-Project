<?php

namespace App\Card;

class Deck extends Card
{
    private $cards;

    public function __construct()
    {
        $this->cards = new Card();
    }

    /**
     * This function randomly shuffle the cards to keep everything randomized
     * @return bool|mixed
     */
    public function getDeckShuffled()
    {
        $deckCards = $this->cards->buildDeck();
        if (shuffle($deckCards)) {
            $this->cards->setDeck($deckCards);
            return $deckCards;
        } else {
            return false;
        }
    }

    public function drawOneCard(): string
    {
        $deckCards = $this->cards->buildDeck();
        $number = random_int(0, count($deckCards));
        $card = $deckCards[$number];
        unset($deckCards[$number]);
        return $card;
    }

}
