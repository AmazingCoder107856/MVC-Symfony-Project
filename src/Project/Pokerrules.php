<?php

namespace App\Project;

/**
 *  Class PokerRules.
 */
class Pokerrules
{
    protected array $handPoints = [];

    protected array $handSuits = [];

    protected array $hand;

    protected array $ruleList;

    /**
     * Constructor.
     * @param array $hand
     */
    public function __construct(array $hand)
    {
        $this->hand = $hand;

        $this->handPoints = $this->getPointArr();

        $this->handSuits = $this->getSuitArr();
    }

    /**
     * method to get the points each card is worth in to its own array
     * @return array with the point ints
     */
    public function getPointArr()
    {
        $pointHand = [];
        foreach ($this->hand as $card) {
            array_push($pointHand, $card->getPoint());
        }

        return $pointHand;
    }

    /**
     * method to get the suit each card has into its own array
     * @return array with the strings from suits
     */
    public function getSuitArr()
    {
        $suitHand = [];
        foreach ($this->hand as $card) {
            array_push($suitHand, $card->getSuit());
        }

        return $suitHand;
    }

    /**
     * mnethod to get the highest card from an array of points
     * @return int from the first key of array of hand points
     */
    public function highCard()
    {
        $cards = $this->handPoints;

        rsort($cards);

        return $cards[0];
    }


    /**
     * method to see if hand have one pair
     * @return bool
     */
    public function onePair()
    {
        $countArr = array_count_values($this->handPoints);

        foreach ($countArr as $val) {
            if ($val == 2) {
                return true;
            }
        }

        return false;
    }

    /**
     * method to see if hand have two pair
     * @return bool
     */
    public function twoPair()
    {
        $countArr = array_count_values($this->handPoints);
        $counter = 0;

        foreach ($countArr as $val) {
            if ($val == 2) {
                $counter += 1;
            }
        }

        if ($counter == 2) {
            return true;
        }

        return false;
    }

    /**
     * method to see if hand have three of a kind
     * @return bool
     */
    public function threeOfAKind()
    {
        $countArr = array_count_values($this->handPoints);

        foreach ($countArr as $val) {
            if ($val == 3) {
                return true;
            }
        }

        return false;
    }

    /**
     * method to see if hand have stright
     * @return bool
     */
    public function straight()
    {
        $cards = array_unique($this->handPoints);

        sort($cards);

        if ($cards[0] == 2 && $cards[1] == 3 && $cards[2] == 4) {
            foreach ($cards as $key => $value) {
                if ($value === 14) {
                    $cards[$key] = 1;
                }
            }
        }

        rsort($cards);

        $set = array(array_shift($cards));
        foreach ($cards as $card) {
            $lastCard = $set[count($set) - 1];
            if ($lastCard - 1 != $card) {

                $set = array($card);
            } else {
                $set[] = $card;
            }
            if (count($set) == 5) {
                break;
            }
        }

        if (count($set) == 5) {
            return true;
        }

        return false;
    }

    /**
     * method to see if hand have flush
     * @return bool
     */
    public function flush()
    {
        $cardsSuit = $this->handSuits;

        $countArr = array_count_values($cardsSuit);

        foreach ($countArr as $val) {
            if ($val >= 5) {
                return true;
            }
        }

        return false;
    }

    /**
     * method to see if hand have full house
     * @return bool
     */
    public function fullHouse()
    {
        if ($this->threeOfAKind() && $this->onePair()) {
            return true;
        }

        return false;
    }

    /**
     * method to see if hand have four of a kind
     * @return bool
     */
    public function fourOfAKind()
    {
        $countArr = array_count_values($this->handPoints);

        foreach ($countArr as $val) {
            if ($val == 4) {
                return true;
            }
        }

        return false;
    }

    /**
     * method to see if hand have straight flush
     * @return bool
     */
    public function straightFlush()
    {
        if ($this->straight() && $this->flush()) {
            return true;
        }

        return false;
    }

    /**
     * method to see if hand have royal flush
     * @return bool
     */
    public function royalFlush()
    {
        $cards = $this->handPoints;

        rsort($cards);

        if ($this->straightFlush()) {
            if ($cards[0] == 14) {
                return true;
            }
        }

        return false;
    }
}
