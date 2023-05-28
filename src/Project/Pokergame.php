<?php

namespace App\Project;

use App\Project\Pokerdeck;

/**
 * Class Pokergame. Represent the Texas poker game. Holds the whole game.
 */
class Pokergame
{
    public object $deck;

    public object $player;

    public object $dealer;

    private array $community;

    private int $thePot;

    public array $playerHand;

    public array $dealerHand;

    /**
     * Constructor to create the Pokergame object.
     * this constuctor will generate a deck, shuffle the deck. also create a player and a dealer hand.
     */
    public function __construct()
    {
        $this->deck = new Pokerdeck();
        $this->deck->shuffles();
        $this->deck->getDeck();
        $this->player = new Pokerhand($this->deck);
        $this->dealer = new Pokerhand($this->deck);
        $this->community = [];
        $this->playerHand = [];
        $this->dealerHand = [];
        $this->thePot = 0;
    }

    /**
     * Method to give both player and dealer their frist 2 cards.
     * @return void
     */
    public function firstPlay(): void
    {
        $this->player->playerHand();
        $this->dealer->playerHand();
    }

    /**
     * method to show the players card
     * @return array with the players cards object
     */
    public function getPlayerCard(): array
    {
        return $this->player->getHand();
    }

     /**
     * method to show the dealers card
     * @return array with the dealers cards object
     */
    public function getDealerCard(): array
    {
        return $this->dealer->getHand();
    }

    /**
     * mthod to show the community cards
     * @return array of the community cards objects
     */
    public function getCommunityCards(): array
    {
        return $this->community;
    }

    /**
     * Method to draw 3 cards from deck and merge it with the community array
     * @return void
     */
    public function theFlop(): void
    {

        $this->community = array_merge($this->community, $this->deck->draw(3));
    }

    /**
     * method to draw the fourth card and merge it with community array
     */
    public function turn(): void
    {

        $this->community = array_merge($this->community, $this->deck->draw(1));
    }

    /**
     * method to draw the fifth card and merge it with community array
     */
    public function river(): void
    {

        $this->community = array_merge($this->community, $this->deck->draw(1));
    }

    /**
     * method to merge the community cards with the players card
     * @return array of 7 cards
     */
    public function playerFullHand(): array
    {

        $this->playerHand = array_merge($this->community, $this->getPlayerCard());

        return $this->playerHand;
    }

    /**
     * method to merge the community cards with the dealers card
     * @return array of 7 cards
     */
    public function dealerFullHand(): array
    {

        $this->dealerHand = array_merge($this->community, $this->getDealerCard());

        return $this->dealerHand;
    }

    /**
     * Set method to set the table pot
     */
    public function setPot(int $money): void
    {
        $this->thePot += $money;
    }

    /**
     * get method to get the pot
     * @return int of the pot
     */
    public function getPot(): int
    {
        return $this->thePot;
    }

    /**
     * Method to reset the pot to zero
     */
    public function resetPot(): void
    {
        $this->thePot = 0;
    }
}
