<?php

namespace App\Card;

use App\Card\CardAbstract;

class CardHand extends CardAbstract
{
    public function revealAll(): void
    {
        foreach ($this->cards as $card) {
            $card->reveal();
        }
    }

    public function hideAll(): void
    {
        foreach ($this->cards as $card) {
            $card->hide();
        }
    }
}
