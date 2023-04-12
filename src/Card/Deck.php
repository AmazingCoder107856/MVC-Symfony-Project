<?php

namespace App\Card;

class Deck extends Card
{
    private $cards;
    private $counter = 0;

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
        $nr = random_int(0, count($deckCards));
        $card = $deckCards[$nr];
        unset($deckCards[$nr]);
        return $card;
    }

    /**
     * this function is to update the deck cards when a player took a card from the deck
     * @param $deckCards
     * @param $cardToBeRemoved
     * @return mixed
     */
    public function updateDeckCards($deckCards, $cardToBeRemoved)
    {

        $updatedLODeck = array_diff($deckCards, $cardToBeRemoved);
        $this->cards->setDeck($updatedLODeck);
        return $this->cards->getDeck();
    }

    /**
     * Function to get number of random cards from the deck
     * @param $leftOverDeck
     * @param $numberOfCards
     * @return array
     */
    public function getRandomCards($leftOverDeck, $numberOfCards)
    {
        $playerCard = [];
        $randomCardsKey = array_rand($leftOverDeck, $numberOfCards);
        if($numberOfCards != 1) {
            foreach ($randomCardsKey as $rand) {
                $playerCard[] = $leftOverDeck[$rand];
            }
        } else {
            $playerCard[] = $leftOverDeck[$randomCardsKey];
        }


        return $playerCard;
    }

    /**
     * Function to get the rest of the cards in the LeftOver Deck
     * @return array
     */
    public function getLeftOverDeck()
    {
        return $this->cards->getLeftOverDeck();
    }

    /**
     * Function to get All Deck Cards
     * @return mixed
     */
    public function getDeckCards()
    {
        return $this->cards->getDeck();
    }

    /**
     * Function to insert card or array of cards in deck
     * @param $cards
     * @return mixed
     */
    public function insertCardDeck($cards)
    {
        $deck = $this->cards->getDeck();
        foreach ($cards as $card) {
            array_push($deck, $card);
        }

        $this->cards->setDeck($deck);
        return $this->cards->getDeck();
    }
}
