<?php

namespace App\Project;

use App\Project\Pokerdeck;
use App\Project\Pokercards;

/**
 *  Class Pokerhand. Represent a hand in texas holdem
 */
class Pokerhand
{
    protected array $hand;

    public object $deck;


    /**
     * Constructor. Creates the player with an empty array as a hand.and finally yhe 5 card hand
     */
    public function __construct(Pokerdeck $deck)
    {
        $this->hand = [];
        $this->deck = $deck;
    }

    /**
     * Method to return the player or dealers card.
     * @return array $hand.
     */

    public function getHand(): array
    {
        return $this->hand;
    }

    /**
     * method to create a hand with 2 cards
     */
    public function playerHand(): void
    {
        $this->hand = array_merge($this->hand, $this->deck->draw(2));
    }
}
