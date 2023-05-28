<?php

namespace App\Project;

use PHPUnit\Framework\TestCase;

use App\Project\Pokercards;

use App\Project\Pokerdeck;

use App\Project\Pokerhand;

/**
 * Test Cases for Pokergame class
 */
class PokergameTest extends TestCase
{
   private $game;

   protected function setUp(): void
   {
      $this->game = new Pokergame();
   }

   /**
    * Construct object and verify that the object is of expected instance.
   */
   public function testGameConstruct()
   {

      $this->assertInstanceOf("\App\Project\Pokergame", $this->game);

      $this->assertIsObject($this->game);
   }

   /***
    * test to see if player and dealer get 2 card each
    */
   public function testFirstPlayMethod()
   {
      $this->game->firstPlay();

      $resPlayer = $this->game->getPlayerCard();

      $this->assertEquals(count($resPlayer), 2);
      $this->assertIsArray($resPlayer);

      $resDealer = $this->game->getDealerCard();

      $this->assertEquals(count($resDealer), 2);
      $this->assertIsArray($resDealer);
   }

   /***
    * test to see if the getcommunity method returns an empty array when no other method been called
    */
   public function testGetCommunityMethodIsEmptyArray()
   {
      $res = $this->game->getCommunityCards();

      $this->assertIsArray($res);
      $this->assertEmpty($res);
   }
   
   /**
   * test to see if community array have 3 cards after flop method is called
   */
   public function testFlopMethod()
   {
      $this->game->theFlop();
      $res = $this->game->getCommunityCards();

      $this->assertEquals(count($res), 3);
   }

   /**
   * test to see if community array have 4 cards after flop and turn method is called
   */

   public function testTurnMethod()
   {
      $this->game->theFlop();
      $this->game->turn();
      $res = $this->game->getCommunityCards();

      $this->assertEquals(count($res), 4);
   }

   /**
   * test to see if community array have 5 cards after flop and turn and river method is called
   */
   public function testRiverMethod()
   {
      $this->game->theFlop();
      $this->game->turn();
      $this->game->river();

      $res = $this->game->getCommunityCards();

      $this->assertEquals(count($res), 5);
   }

   /**
    * test to see if playerhand is empty if no other method been called after PlayerFullHand
    */
   public function testPlayerHandIsEmpty()
   {
      $res = $this->game->playerFullHand();

      $this->assertIsArray($res);
      $this->assertEmpty($res);
   }

   /**
    * test to see if dealerhand is empty if no other method been called after dealerFullHand
    */
   public function testDealerHandIsEmpty()
   {
      $res = $this->game->dealerFullHand();

      $this->assertIsArray($res);
      $this->assertEmpty($res);
   }

   /**
    * test to see if 7 cards is return when all methods is called and then playerfullhand
    */
   public function testPlayerHandWhenAllMethodsCalled()
   {
      $this->game->firstPlay();
      $this->game->theFlop();
      $this->game->turn();
      $this->game->river();

      $res = $this->game->playerFullHand();

      $this->assertEquals(count($res), 7);
   }

   /**
    * test to see if 7 cards is return when all methods is called and then dealerfullhand
    */
   public function testDealerHandWhenAllMethodsCalled()
   {
      $this->game->firstPlay();
      $this->game->theFlop();
      $this->game->turn();
      $this->game->river();

      $res = $this->game->dealerFullHand();

      $this->assertEquals(count($res), 7);
   }
}
