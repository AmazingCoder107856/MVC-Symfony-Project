<?php

namespace App\Card;

class Card
{
    private $faces;
    private $deck;
    private $leftOverDeck;

    public function __construct()
    {
        $this->faces = array(
            'Ac.png', '2c.png', '3c.png', '4c.png', '5c.png', '6c.png', '7c.png', '8c.png', '9c.png', '10c.png', 'jc.png', 'qc.png', 'kc.png',
            'Ah.png', '2h.png', '3h.png', '4h.png', '5h.png', '6h.png', '7h.png', '8h.png', '9h.png', '10h.png', 'jh.png', 'qh.png', 'kh.png',
            'As.png', '2s.png', '3s.png', '4s.png', '5s.png', '6s.png', '7s.png', '8s.png', '9s.png', '10s.png', 'js.png', 'qs.png', 'ks.png',
            'Ad.png', '2d.png', '3d.png', '4d.png', '5d.png', '6d.png', '7d.png', '8d.png', '9d.png', '10d.png', 'jd.png', 'qd.png', 'kd.png',
        );

        $this->leftOverDeck = [];
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
     * This function remove array of cards that the player took
     * @param $leftOverDeck
     * @param $cardToBeRemoved
     * @return array
     */
    public function updateLeftOverDeck($leftOverDeck, $cardToBeRemoved)
    {

        $updatedLODeck = array_diff($leftOverDeck, $cardToBeRemoved);
        $this->leftOverDeck = $updatedLODeck;
        return $this->leftOverDeck;
    }

    /**
     * Deck Var Setter
     * @param mixed $deck
     */
    public function setDeck($deck)
    {
        $this->deck = $deck;
    }

    /**
     * leftOverDeck Var Setter
     * @param array $leftOverDeck
     */
    public function setLeftOverDeck($leftOverDeck)
    {
        $this->leftOverDeck = $leftOverDeck;
    }

    /**
     * leftOverDeck Var Getter
     * @return array
     */
    public function getLeftOverDeck()
    {
        return $this->leftOverDeck;
    }

    /**
     * Deck Var Getter
     * @return mixed
     */
    public function getDeck()
    {
        return $this->deck;
    }

    public function draw(): int
    {
        $this->deck = random_int(1, 52);
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
