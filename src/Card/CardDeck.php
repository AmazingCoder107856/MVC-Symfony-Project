<?php

namespace App\Card;

use App\Card\Cards;
use App\Card\DrawException;

/**
 * Class Deck. Represent a deck of 52 cards.
 */
class CardDeck
{
    /**
     * @var array $suits    Array with the four diffrent suits of cards
     * @var array $values   Key  is the value of the cards, value of the key is the point of the card.
     * @var string $color
     * @var array $deck     Empty array. When Deck constructor is called Deck will be pushed with card objects.
     * @var int $point
     */
    protected array $suits = ["&hearts;", "&diams;", "&clubs;", "&spades;"];
    protected $values = array("A" => 11, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, "J"
    => 10, "Q" => 10, "K" => 10);
    protected string $color = "";
    protected array $deck = [];
    public int $point = 0;

    /**
     * Constructor which creates the deck object with 52 card objects in an array.
     */
    public function __construct()
    {
        foreach ($this->suits as $suit) {
            if ($suit == "&hearts;" || $suit == "&diams;") {
                $color = "red";
            } else {
                $color = "black";
            }

            foreach ($this->values as $value => $point) {
                array_push($this->deck, new Cards($value, $suit, $color, $point));
            }
        }
    }

    /**
     * @return array with the card objects as its values.
     */
    public function getDeck(): array
    {
        return $this->deck;
    }

    /**
     * Shuffle the deck.
     */
    public function shuffles(): void
    {
        shuffle($this->deck);
    }

    /**
     * Draw the first card object and push in new array, and remove from deck array.
     * @param int $cards    Number of cards to draw from deck. Default 1.
     * @return array $hand  Return the new array with drawn cards
     */
    public function draw($cards = 1): array
    {
        $hand = [];

        if ($cards < 1 || $cards > 52) {
            throw new DrawException("The card amount is out of bounds");
        }

        if (count($this->deck) <= 0) {
            throw new DrawException("The Deck is empty");
        }

        for ($i = 0; $i <= $cards - 1; $i++) {
            $hand[] = $this->deck[0];
            $newDeck = array_shift($this->deck);
        }
        return $hand;
    }

    /**
     * Counting the cards with the built in function count.
     * @return int Number of cards.
     */
    public function countCards(): int
    {
        $numCards = count($this->deck);

        return $numCards;
    }
}
