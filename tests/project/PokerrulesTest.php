<?php

namespace App\Project;

use PHPUnit\Framework\TestCase;

use App\Project\Pokerdeck;

use App\Project\Pokercards;

use App\Project\Pokerhand;

use App\Project\Pokerrules;

/**
 * Test Cases for class Pokerrules
 */

class PokerrulesTest extends TestCase 
{
    /**
     * setup with rule object
     */
    private $hand;

    private $deck;

    private $ruleBook;

    private $arrHand;

    protected function setUp(): void
    {   
        $this->deck = new Pokerdeck();
        $this->hand = new Pokerhand($this->deck);
        $this->hand->playerHand();
        $this->hand->playerHand();
        $this->arrHand = $this->hand->getHand();

        $this->ruleBook = new Pokerrules($this->arrHand);
    }

    /**
     * verify that the object is of expected instance.
    */
    public function testCreate()
    {
        $this->assertInstanceOf("\App\Project\Pokerrules", $this->ruleBook);
    }

    /**
     * test to see if the getPointArr method is returning an array of the points from the cards
     */
    public function testPointArr() 
    {
        $res = $this->ruleBook->getPointArr();
      
        $this->assertIsArray($res);
        $this->assertCount(4, $res);
        $this->assertEquals([2, 3, 4, 5], $res);
    }

    /**
     * test to see if the getSuitArr method is returning an array of the suit from the first 4 draw card
     */
    public function testSuitArr() 
    {
        $res = $this->ruleBook->getSuitArr();
        $this->assertIsArray($res);
        $this->assertCount(4, $res);
        $this->assertEquals(['&hearts;', '&hearts;', '&hearts;', '&hearts;'], $res);
    }

    /**
     * test to see if the highest point of the array is returned
     */
    public function testHighCard() 
    {
        $res = $this->ruleBook->highCard();
        
        $this->assertEquals(5, $res);
    }

    /**
     * test to see if a bool true is return when the hand array sent in to Crules has 1 pair
     */
    public function testOnePairOnTrue()
    {
        $card1 = new Pokercards(2, "&hearts;", "red", 2);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&hearts;", "red", 4);
        $card4 = new Pokercards(5, "&hearts;", "red", 5);
        $card5 = new Pokercards(2, "&diamond;", "red", 2);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $res = $newRule->getPointArr();

        $onePair = $newRule->onePair();
        
        $this->assertIsArray($res);
        
        $this->assertTrue($onePair);
    }

    /**
     * test to see if a bool false is returned if an array sent in to Crules without no pair
     */
     public function testOnePairOnFalse() 
    {
        $card1 = new Pokercards(2, "&hearts;", "red", 2);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&hearts;", "red", 4);
        $card4 = new Pokercards(5, "&hearts;", "red", 5);
        $card5 = new Pokercards(6, "&diamond;", "red", 6);

        $newRule2 = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $onePair = $newRule2->onePair();
        
        $this->assertNotTrue($onePair);
    }

    /**
     * test to see if a bool true is return when the hand array sent in to Crules has 2 pair
     */
    public function testTwoPairOnTrue(){
      
        $card1 = new Pokercards(2, "&hearts;", "red", 2);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&hearts;", "red", 4);
        $card4 = new Pokercards(3, "&diamond;", "red", 3);
        $card5 = new Pokercards(2, "&diamond;", "red", 2);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $twoPair = $newRule->twoPair();
    
        $this->assertTrue($twoPair);
    }

    /**
     * test to see if a bool false is returned if an array sent in to Crules without no pair
     */
    public function testTwoPairOnfalse() 
    {
        $card1 = new Pokercards(2, "&hearts;", "red", 2);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&hearts;", "red", 4);
        $card4 = new Pokercards(5, "&hearts;", "red", 5);
        $card5 = new Pokercards(6, "&diams", "red", 6);

        $newRule2 = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $twoPair = $newRule2->twoPair();
        
        $this->assertNotTrue($twoPair);
    }

    /**
     * test to see if a bool true is return when the hand array sent in to Crules has three of a kind
     */
    public function testThreeOfAKindOnTrue()
    {
        $card1 = new Pokercards(2, "&hearts;", "red", 2);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&hearts;", "red", 4);
        $card4 = new Pokercards(2, "&clubs;", "black", 2);
        $card5 = new Pokercards(2, "&diams;", "red", 2);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $threeOfAKind = $newRule->threeOfAKind();
    
        $this->assertTrue($threeOfAKind);
    }

    /**
     * test to see if a bool false is return when the hand array sent in to Crules has no three of a kind
     */
    public function testThreeOfAKindOnFalse()
    {      
        $card1 = new Pokercards(2, "&hearts;", "red", 2);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&hearts;", "red", 4);
        $card4 = new Pokercards(5, "&clubs;", "black", 5);
        $card5 = new Pokercards(2, "&diams;", "red", 2);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $threeOfAKind = $newRule->threeOfAKind();
    
        $this->assertNotTrue($threeOfAKind);
    }

    /**
     * test to see if a bool true is return when the hand array sent in to Crules has straight
     */
    public function testStraightOnTrue()
    {      
        $card1 = new Pokercards(2, "&hearts;", "red", 2);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&hearts;", "red", 4);
        $card4 = new Pokercards(5, "&hearts;", "red", 5);
        $card5 = new Pokercards(6, "&hearts;", "red", 6);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $straight = $newRule->straight();
    
        $this->assertTrue($straight);
    }

    /**
     * test to see if a bool true is return when the hand array sent in to Crules has a straight where ass is suppose to be 1
     */
    public function testStraightWithAss()
    {      
        $card1 = new Pokercards(2, "&hearts;", "red", 2);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&hearts;", "red", 4);
        $card4 = new Pokercards(5, "&hearts;", "red", 5);
        $card5 = new Pokercards("A", "&hearts;", "red", 14);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $straight = $newRule->straight();
    
        $this->assertTrue($straight);
    }

    /**
     * test to see if a bool false is return when the hand array sent in to Crules has no straight
     */
    public function testStraightOnFalse()
    {      
        $card1 = new Pokercards(2, "&hearts;", "red", 2);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&hearts;", "red", 4);
        $card4 = new Pokercards(5, "&hearts;", "red", 5);
        $card5 = new Pokercards(6, "&diams;", "red", 2);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $straight = $newRule->straight();
    
        $this->assertNotTrue($straight);
    }

    /**
     * test to see if a bool true is return when the hand array sent in to Crules has flush
     */
    public function testFlushOnTrue()
    {      
        $card1 = new Pokercards("Q", "&hearts;", "red", 13);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&hearts;", "red", 4);
        $card4 = new Pokercards(5, "&hearts;", "red", 5);
        $card5 = new Pokercards(10, "&hearts;", "red", 10);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $flush = $newRule->flush();
    
        $this->assertTrue($flush);
    }


    /**
     * test to see if a bool false is return when the hand array sent in to Crules has no flush
     */
    public function testFlushOnFalse()
    {      
        $card1 = new Pokercards("Q", "&hearts;", "red", 13);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&spades;", "black", 4);
        $card4 = new Pokercards(5, "&clubs;", "black", 5);
        $card5 = new Pokercards(10, "&diams;", "red", 10);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $flush = $newRule->flush();
    
        $this->assertNotTrue($flush);
    }

    /**
     * test to see if a bool true is return when the hand array sent in to Crules has fourOfAKind
     */
    public function testFourOfAKindOnTrue()
    {      
        $card1 = new Pokercards("Q", "&hearts;", "red", 13);  
        $card2= new Pokercards("Q", "&diams;", "red", 13);
        $card3 = new Pokercards("Q", "&clubs;", "black", 13);
        $card4 = new Pokercards("Q", "&spades;", "black", 13);
        $card5 = new Pokercards(10, "&hearts;", "red", 10);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $fourOfAKind = $newRule->fourOfAKind();
    
        $this->assertTrue($fourOfAKind);
    }

    /**
     * test to see if a bool false is return when the hand array sent in to Crules has no fourOfAKind
     */
    public function testFourOfAKindOnFalse()
    {      
        $card1 = new Pokercards("Q", "&hearts;", "red", 13);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&spades;", "black", 4);
        $card4 = new Pokercards(5, "&clubs;", "black", 5);
        $card5 = new Pokercards(10, "&diams;", "red", 10);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $fourOfAKind = $newRule->fourOfAKind();
    
        $this->assertNotTrue($fourOfAKind);
    }

    /**
     * test to see if a bool true is return when the hand array sent in to Crules has straightFlush
     */
    public function testStraightFlushOnTrue()
    {      
        $card1 = new Pokercards(2, "&hearts;", "red", 2);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&hearts;", "red", 4);
        $card4 = new Pokercards(5, "&hearts;", "red", 5);
        $card5 = new Pokercards(6, "&hearts;", "red", 6);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $straightFlush = $newRule->straightFlush();
    
        $this->assertTrue($straightFlush);
    }

    /**
     * test to see if a bool false is return when the hand array sent in to Crules has no straightFlush
     */
    public function testStraightFlushOnFalse()
    {      
        $card1 = new Pokercards(2, "&hearts;", "red", 2);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&hearts;", "red", 4);
        $card4 = new Pokercards(6, "&hearts;", "red", 6);
        $card5 = new Pokercards(10, "&diams;", "red", 10);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $straightFlush = $newRule->straightFlush();
    
        $this->assertNotTrue($straightFlush);
    }

    /**
     * test to see if a bool true is return when the hand array sent in to Crules has royalFlush
     */
    public function testroyalFlushOnTrue()
    {      
        $card1 = new Pokercards("A", "&hearts;", "red", 14);  
        $card2= new Pokercards("K", "&hearts;", "red", 13);
        $card3 = new Pokercards("J", "&hearts;", "red", 11);
        $card4 = new Pokercards("Q", "&hearts;", "red", 12);
        $card5 = new Pokercards(10, "&hearts;", "red", 10);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $royalFlush = $newRule->royalFlush();
    
        $this->assertTrue($royalFlush);
    }

    /**
     * test to see if a bool false is return when the hand array sent in to Crules has no royalFlush
     */
    public function testroyalFlushOnFalse()
    {      
        $card1 = new Pokercards(2, "&hearts;", "red", 2);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&hearts;", "red", 4);
        $card4 = new Pokercards(6, "&hearts;", "red", 6);
        $card5 = new Pokercards(10, "&diams;", "red", 10);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $royalFlush = $newRule->royalFlush();
    
        $this->assertNotTrue($royalFlush);
    }

    /**
     * test to see if a bool true is return when the hand array sent in to Crules has fullHouse
     */
    public function testFullHouseOnTrue()
    {      
        $card1 = new Pokercards("A", "&hearts;", "red", 14);  
        $card2= new Pokercards("A", "&diams;", "red", 14);
        $card3 = new Pokercards("J", "&hearts;", "red", 11);
        $card4 = new Pokercards("Q", "&hearts;", "red", 12);
        $card5 = new Pokercards("A", "&clubs;", "black", 14);
        $card6 = new Pokercards("J", "&clubs;", "black", 11);
        $card7 = new Pokercards(4, "&hearts;", "red", 4);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5, $card6, $card7));

        $fullHouse = $newRule->fullHouse();
    
        $this->assertTrue($fullHouse);
    }

    /**
     * test to see if a bool false is return when the hand array sent in to Crules has no fullHouse
     */
    public function testFullHouseOnFalse()
    {      
        $card1 = new Pokercards(3, "&spades;", "black", 3);  
        $card2= new Pokercards(3, "&hearts;", "red", 3);
        $card3 = new Pokercards(4, "&hearts;", "red", 4);
        $card4 = new Pokercards(6, "&hearts;", "red", 6);
        $card5 = new Pokercards(3, "&diams;", "red", 3);

        $newRule = new Pokerrules(array($card1, $card2, $card3, $card4, $card5));

        $fullHouse = $newRule->fullHouse();
    
        $this->assertNotTrue($fullHouse);
    }
}
