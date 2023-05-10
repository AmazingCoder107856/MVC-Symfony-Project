<?php

namespace App\Card;

class Card
{
    private $faces;
    private $deck;

    public function __construct()
    {
        $this->faces = array(
            'clubs-01.png', 'clubs-02.png', 'clubs-03.png', 'clubs-04.png', 'clubs-05.png', 'clubs-06.png', 'clubs-07.png', 'clubs-08.png', 'clubs-09.png', 'clubs-10.png', 'clubs-11.png', 'clubs-12.png', 'clubs-13.png',
            'hearts-01.png', 'hearts-02.png', 'hearts-03.png', 'hearts-04.png', 'hearts-05.png', 'hearts-06.png', 'hearts-07.png', 'hearts-08.png', 'hearts-09.png', 'hearts-10.png', 'hearts-11.png', 'hearts-12.png', 'hearts-13.png',
            'spades-01.png', 'spades-02.png', 'spades-03.png', 'spades-04.png', 'spades-05.png', 'spades-06.png', 'spades-07.png', 'spades-08.png', 'spades-09.png', 'spades-10.png', 'spades-11.png', 'spades-12.png', 'spades-13.png',
            'diamonds-01.png', 'diamonds-02.png', 'diamonds-03.png', 'diamonds-04.png', 'diamonds-05.png', 'diamonds-06.png', 'diamonds-07.png', 'diamonds-08.png', 'diamonds-09.png', 'diamonds-10.png', 'diamonds-11.png', 'diamonds-12.png', 'diamonds-13.png',
        );
    }

    /**
     * This function generate and build the deck cards
     * @return mixed
     */
    public function buildDeck()
    {
        foreach ($this->faces as $face) {
            $this->deck[] = $face;
        }
        return $this->deck;
    }

    /**
     * Deck Var Setter
     * @param mixed $deck
     */
    public function setDeck($deck)
    {
        $this->deck = $deck;
    }
    public function draw(): int
    {
        $this->deck = random_int(1, 13);
        return $this->deck;
    }

    public function getValue(): int
    {
        return $this->deck;
    }

    public function getAsString(): string
    {
        return "[{$this->deck}]";
    }
}
