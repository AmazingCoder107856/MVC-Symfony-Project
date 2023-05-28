<?php

namespace App\Project;

/**
 * Class Pokercards. Class that represent a card from a deck of cards.
 */

class Pokercards
{
    /**
     * @var mixed $value    The value of the card example A for Ass and Q for Queen.
     * @var string $suit    The suit from UTF-charset example "&hearts;" for heart.
     * @var string $color   The color of the cards
     * @var int $point      The point of the card default 0. example 11 for Ass.
     */
    public mixed $value;
    public string $suit;
    public string $color;
    public int $point;

    /**
     * Constructor to create the card object.
     * @param int|string  $value    The value of the card example A for Ass and Q for Queen.
     * @param string $suit    The suit from UTF-charset example "&hearts;" for heart.
     * @param string $color   The color of the cards
     * @param int $point      The point of the card default 0. example 11 for Ass.
     */
    public function __construct(int | string $value, string $suit, string $color, int $point = 0)
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
     * Method returning the suit of the card.
     * @return string suit of a card.
     */
    public function getSuit(): string
    {
        return $this->suit;
    }
}
