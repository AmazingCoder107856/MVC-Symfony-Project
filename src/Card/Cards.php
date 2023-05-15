<?php

namespace App\Card;

/**
 * Class Cards. Class that represent a card from a eck of cards.
 *
 */
class Cards
{
    /**
     * @var string $value    The value of the card example A for Ace and Q for Queen.
     * @var string $suit    The suit from UTF-charset example "&hearts;" for heart.
     * @var string $color   The color of the cards
     * @var int $point      The point of the card default 0. example 11 for Ace.
     */
    public string $value;
    public string $suit;
    public string $color;
    public int $point;

    /**
     * Constructor to create the card object.
     * @param string $value    The value of the card example A for Ass and Q for Queen.
     * @param string $suit    The suit from UTF-charset example "&hearts;" for heart.
     * @param string $color   The color of the cards
     * @param int $point      The point of the card default 0. example 11 for Ace.
     */
    public function __construct(string $value, string $suit, string $color, int $point = 0)
    {
        $this->value = $value;
        $this->suit = $suit;
        $this->color = $color;
        $this->point = $point;
    }

    /**
     * Method returning the point of the card.
     * @return int the point of a card.
     */
    public function getPoint(): int
    {
        return $this->point;
    }

    /**
     * Method to return the properties of the constructor as string value.
     * @return string
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * Method to return the properties of the constructor as string value.
     * @return string
     */
    public function getAsString(): string
    {
        return "{$this->value}, {$this->suit}, {$this->color}";
    }
}
