<?php

namespace App\Game21;

use PHPUnit\Framework\TestCase;
use App\Card\CardDeck;
use App\Card\Cards;
use App\Game21\Player;

/**
 * Test cases for class Player.
 */
class PlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
    */
    public function testCreatePlayer()
    {
        $deck = new CardDeck();
        $player = new Player($deck);

        $this->assertInstanceOf("\App\Game21\Player", $player);
    }

    /**
     * test to see if the gethand method return an empty array when no other method been called yet
     */
    public function testGetHandPlayer()
    {
        $deck = new CardDeck();
        $player = new Player($deck);
        $res = $player->getHand();

        $this->assertEquals($res, []);
    }

    /**
     * Test to see that the firstdeal method is pushing 2 cards into array in Player constructor.
     * Checking if the expected card is pushed into hand
     */
    public function testTheFirstDeal()
    {
        $deck = new CardDeck();
        $player = new Player($deck);
        $card = new Cards(2, "&hearts;", "red", 2);
        $player->firstDeal();

        $res = $player->getHand();

        $this->assertEquals(count($res), 2);

        $this->assertEquals($res[1], $card);
    }

    /**
     * test to see if hit method pushes 1 card to players hand array
     */
    public function testTheHitFunction()
    {
        $deck = new CardDeck();
        $player = new Player($deck);
        $card = new Cards("A", "&hearts;", "red", 11);
        $player->hit();

        $res = $player->getHand();

        $this->assertEquals(count($res), 1);

        $this->assertEquals($res[0], $card);
    }

    /**
     * Testing to see that the score method sums the points from all cards
     */
    public function testScore()
    {
        $deck = new CardDeck();
        $player = new Player($deck);

        $player->firstDeal();
        $player->hit();
        $player->hit();

        $res = $player->scores();

        $this->assertEquals($res, 20);
    }

    /**
     * test to see if scores concider 1 ass nd removes 10 when score is over 21
     */
    public function testScoreW1AceOver21()
    {
        $deck = new CardDeck();
        $player = new Player($deck);

        $player->firstDeal();
        $player->hit();
        $player->hit();
        $player->hit();

        $res = $player->scores();

        $this->assertEquals($res, 25);
    }

    /**
     * test too see if method scores takes in consider 2 asses when over 21 and removes 10 + 10
     */
    public function testScoreW2AceOver21()
    {
        $deck = new CardDeck();
        $player = new Player($deck);

        $player->firstDeal();
        $player->firstDeal();
        $player->firstDeal();
        $player->firstDeal();
        $player->firstDeal();
        $player->firstDeal();
        $player->firstDeal();
        $player->hit();


        $res = $player->scores();

        $this->assertEquals($res, 108);
    }
}
