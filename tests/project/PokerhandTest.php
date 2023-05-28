<?php

namespace App\Project;

use PHPUnit\Framework\TestCase;

use App\Project\Pokerdeck;

use App\Project\Pokercards;

use App\Project\Pokerhand;


/**
 * Test Cases for class Chand
 */
class PokerhandTest extends TestCase
{
    /**
     * setup with hand object
     */
    private $hand;

    private $deck;

    protected function setUp(): void
    {
        $this->deck = new Pokerdeck();
        $this->hand = new Pokerhand($this->deck);
    }

    /**
     * verify that the object is of expected instance.
    */
    public function testCreate()
    {      
        $this->assertInstanceOf("\App\Project\Pokerhand", $this->hand);
    }

    /*
    * Test to see get hand method return an empty array when called with no other method being called before
    */    
   public function testGetHandWEmptyHand()
   {
        $res = $this->hand->getHand();

        $this->assertEquals([], $res);
   }

   /*
    * Test to see if the playerhand method returns an array with 2 cards.
    */
    public function testPlayerHand()
    {
        $hand = $this->hand->playerHand();

        $res = $this->hand->getHand();        

        $this->assertCount(2, $res);
    }
}
