<?php

namespace App\Game21;

use App\Game21\Game21;
use App\Game21\Player;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game21.
 */
class Game21Test extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
    */
    public function testGame21Construct()
    {
        $game21 = new Game21();
        $this->assertInstanceOf("App\Game21\Game21", $game21);

        $this->assertIsObject($game21);
    }

    /**
     * Test to see if firstplay gives the player object 2 cards
     */
    public function testFirstGivePlayer()
    {
        $game21 = new Game21();

        $game21->firstPlay();

        $playerCards = $game21->getPlayerCards();

        $this->assertEquals(count($playerCards), 2);
    }

    /**
     * Test to see if firstplay gives the dealer object 2 cards
     */
    public function testFirstGiveDealer()
    {
        $game21 = new Game21();

        $game21->firstPlay();

        $dealerCards = $game21->getDealerCards();

        $this->assertEquals(count($dealerCards), 2);
    }

    /**
     * Test to see if the playerHit method gives the player object 1 card
     */
    public function testHitPlayer()
    {
        $game21 = new Game21();

        $game21->playerHit();

        $playerCards = $game21->getPlayerCards();

        $this->assertEquals(count($playerCards), 1);
    }

    /**
     * Test to see that an empty string is returned if no cards is drawn
     */
    public function testFirstDrawW0Point()
    {
        $game21 = new Game21();

        $res = $game21->checkFirstDraw();


        $this->assertStringContainsString($res, "");
    }

     /**
     * Stub the Player class to assure that BlackJack can be asserted.
     */
    public function testcheckFirstDraw21All()
    {
        // Create a stub for the Player class.
        $player = $this->createMock(Player::class);
        $dealer = $this->createMock(Player::class);

        // Configure the stub.
        $player->method('scores')
            ->willReturn(21);
        $dealer->method('scores')
            ->willReturn(21);

        $game21 = new Game21();
        $game21->player = (clone $player);
        $game21->dealer = clone $dealer;

        $res = $game21->checkFirstDraw();
        $this->assertEquals("You both got 21, its a tie", $res);
    }


     /**
     * test to see if player winns on fisrt draw
     */
    public function testcheckFirstDraw21Player()
    {
        // Create a stub for the Player class.
        $player = $this->createMock(Player::class);
        $dealer = $this->createMock(Player::class);

        // Configure the stub.
        $player->method('scores')
            ->willReturn(21);
        $dealer->method('scores')
            ->willReturn(20);

        $game21 = new Game21();
        $game21->player = (clone $player);
        $game21->dealer = clone $dealer;

        $res = $game21->checkFirstDraw();
        $this->assertEquals("you won you got 21", $res);
    }

    /**
     * test to see if dealer winns on fisrt draw
     */
    public function testcheckFirstDraw21Dealer()
    {
        // Create a stub for the Player class.
        $player = $this->createMock(Player::class);
        $dealer = $this->createMock(Player::class);

        // Configure the stub.
        $player->method('scores')
            ->willReturn(5);
        $dealer->method('scores')
            ->willReturn(21);

        $game21 = new Game21();
        $game21->player = clone $player;
        $game21->dealer = clone $dealer;

        $res = $game21->checkFirstDraw();
        $this->assertEquals('Dealer won! he got 21', $res);
    }

    /**
     * test to check when player gets 21 and dealer less then 21 on second draw
     */
    public function testCheckPlayerwins()
    {
        // Create a stub for the Player class.
        $player = $this->createMock(Player::class);
        $dealer = $this->createMock(Player::class);

        // Configure the stub.
        $player->method('scores')
            ->willReturn(21);
        $dealer->method('scores')
            ->willReturn(20);

        $game21 = new Game21();
        $game21->player = (clone $player);
        $game21->dealer = (clone $dealer);

        $res = $game21->gameStop();

        $this->assertEquals("you got 21, you won!", $res);
    }

    /**
     * Test to see if a int is return when method getPlayerscore is called
     */
    public function testGetPlayerScoreReturnsInt()
    {
        $game21 = new Game21();

        $game21->firstPlay();

        $res = $game21->getPlayerScore();

        $this->assertIsInt($res);
    }


    /**
     * Test to see if a int is return when method getDelarscore is called
     */

    public function testGetDealerScoreReturnsInt()
    {
        $game21 = new Game21();

        $game21->firstPlay();

        $res = $game21->getDealerScore();

        $this->assertIsInt($res);
    }

    /**
     * test to see when both get 21 on the second draw
     */
    public function testGameStopBoth21()
    {
        // Create a stub for the Player class.
        $player = $this->createMock(Player::class);
        $dealer = $this->createMock(Player::class);

        // Configure the stub.
        $player->method('scores')
            ->willReturn(21);
        $dealer->method('scores')
            ->willReturn(21);

        $game21 = new Game21();
        $game21->player = (clone $player);
        $game21->dealer = clone $dealer;

        $res = $game21->gameStop();
        $this->assertEquals("you both got 21, its a tie!", $res);
    }

     /**
     * test to see if dealer winns on game stop
     */
    public function testcheckGamestop21Dealer()
    {
        // Create a stub for the Player class.
        $player = $this->createMock(Player::class);
        $dealer = $this->createMock(Player::class);

        // Configure the stub.
        $player->method('scores')
            ->willReturn(30);
        $dealer->method('scores')
            ->willReturn(21);

        $game21 = new Game21();
        $game21->player = (clone $player);
        $game21->dealer = clone $dealer;

        $res = $game21->gameStop();
        $this->assertEquals('dealer got 21, Dealer won!', $res);
    }
}
