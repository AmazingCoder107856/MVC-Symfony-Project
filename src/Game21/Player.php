<?php

namespace App\Game21;

use App\Game21\CardDeck;

/**
 *  Class Player. Represent a player of game21 either dealer or player.
 */
class Player
{
    protected array $hand;

    public object $deck;

    public int $score;

    /**
     * Constructor. Creates the player with an empty array as a hand. And a start score set to 0.
     */
    public function __construct(CardDeck $deck)
    {
        $this->hand = [];
        $this->deck = $deck;

        $this->score = 0;
    }

    /**
     * Method to return the players card.
     * @return array $hand.
     */
    public function getHand(): array
    {
        return $this->hand;
    }

    /**
     * Method to merge the empty hand array with the array from deck method draw. hardcoded with 2 cards.
     * Use this method for first give in the game Game21 when player and dealer will receive 2 cards each.
     */
    public function firstDeal(): void
    {
        $this->hand = array_merge($this->hand, $this->deck->draw(2));
    }

    /**
     * Method to merge players hand with deck method draw with only 1 card from draw method.
     * USe this method after the first give, when player or dealer is given 1 card at the time.
     */
    public function hit(): void
    {
        $this->hand = array_merge($this->hand, $this->deck->draw(1));
    }

    /**
     * Method to count the points of a Player objects hand.
     * The ace is use to count how many ass in Player hand.
     * If there is an ass and score is over 21. 10 points will be drawn away from score for each Ace.
     * Which means Ass will then counts as 1, otherwise if score is under 21 or 21 ass will count as 11.
     * @return int $score. The amount of points the player objects hand hold.
     */
    public function scores(): int
    {
        $ace = 0;

        $this->score = 0;

        foreach ($this->hand as $card) {
            if ($card->getPoint() === 1) {
                $ace += 1;
            }
            $this->score += $card->getPoint();
        }
        while ($ace != 0 && $this->score > 21) {
            $ace -= 1;
            $this->score -= 10;
        }
        return $this->score;
    }
}
