<?php

namespace App\Project;

use App\Project\Pokerrules;

/**
 * Class PokercompareHands. class to see who have strongest hand.
 */
class PokercompareHands
{
    public object $rule;

    /**
     * method to check what kind of hand the player has
     * @return array with a number and a string with the right rule name
     */
    public function checkPlayer(Pokerrules $rule): array
    {
        if ($rule->royalFlush()) {
            return [10, "Royal Flush"];
        } elseif ($rule->straightFlush()) {
            return [9, "Straight Flush"];
        } elseif ($rule->fourOfAKind()) {
            return [8, "Four Of A Kind"];
        } elseif ($rule->fullHouse()) {
            return [7, "Full House"];
        } elseif ($rule->flush()) {
            return [6, "Flush"];
        } elseif ($rule->straight()) {
            return [5,"Straight"];
        } elseif ($rule->threeOfAKind()) {
            return [4,"Three Of A Kind"];
        } elseif ($rule->twoPair()) {
            return [3,"Two Pair"];
        } elseif ($rule->onePair()) {
            return [2,"One Pair"];
        }
        return [1, "High Card", $rule->highCard()];
    }

    /**
     * method to check what kind of hand the dealer has
     * @return array with a number and a string with the right rule name
     */
    public function checkDealer(Pokerrules $rule): array
    {
        if ($rule->royalFlush()) {
            return [10, "Royal Flush"];
        } elseif ($rule->straightFlush()) {
            return [9, "Straight Flush"];
        } elseif ($rule->fourOfAKind()) {
            return [8, "Four Of A Kind"];
        } elseif ($rule->fullHouse()) {
            return [7, "Full House"];
        } elseif ($rule->flush()) {
            return [6, "Flush"];
        } elseif ($rule->straight()) {
            return [5,"Straight"];
        } elseif ($rule->threeOfAKind()) {
            return [4,"Three Of A Kind"];
        } elseif ($rule->twoPair()) {
            return [3,"Two Pair"];
        } elseif ($rule->onePair()) {
            return [2,"One Pair"];
        }

        return [1, "High Card", $rule->highCard()];
    }

    /**
     * method to campare the 2 diffrent arrays from check player and check dealer
     */
    public function compareHand(array $player, array $dealer)
    {
        if ($dealer[0] > $player[0]) {
            return "You lost with " . $player[1] . " Dealer have " . $dealer[1];
        }
        if ($dealer[0] < $player[0]) {
            return "You won with " . $player[1] . " Dealer have " . $dealer[1];
        }

        if ($dealer[0] == 1 && $player[0] == 1) {
            if ($dealer[2] > $player[2]) {
                return "You lost. Dealer have" . $dealer[1];
            }
            if ($dealer[2] < $player[2]) {
                return "You won with " . $player[1];
            }
        }

        if ($dealer[0] == $player[0]) {
            return "No one win its a Draw";
        }
    }
}
