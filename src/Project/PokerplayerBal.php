<?php

namespace App\Project;

/**
 *  Class CplayerBal. Holds the players money in casino
 */
class PokerplayerBal
{
    public int $balance;

    public function __construct(int $balance = 1000)
    {
        $this->balance = $balance;
    }
    public function getBalance(): int
    {
        return $this->balance;
    }

    public function setnegativeRes(int $amount): void
    {

        $this->balance -= $amount;
    }

    public function setPositiveRes(int $amount): void
    {
        $this->balance += $amount;
    }
}
