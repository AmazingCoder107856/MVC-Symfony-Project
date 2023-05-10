<?php

namespace App\Game21;

/**
 * Class CardHand.
 */
class CardHand
{
    protected array $hand;

    /**
     * CardHand constructor.
     */
    public function __construct()
    {
        $this->hand = [];
    }

    /**
     * Method to get a hand.
     * @return array
     */
    public function getHand(): array
    {
        return $this->hand;
    }

    /**
     * Method to add card.
     * @return void
     */
    public function addCardHand(array $card): void
    {
        $this->hand[] = $card;
    }
}
