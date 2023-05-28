<?php

namespace App\Project;

use PHPUnit\Framework\TestCase;

use App\Project\Pokerdeck;

use App\Project\Pokercards;

/**
 * Test Cases for class Deck
 */
class PokerdeckTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
    */
    private $deck;

    protected function setUp(): void
    {
        $this->deck = new Pokerdeck();
    }

    public function testCreate()
    {      
        $this->assertInstanceOf("\App\Project\Pokerdeck", $this->deck);
    }

    /**
     * Test if a deck object contains of an array of 52 card objects
     */
    public function testCountCards()
    {       
        $res = $this->deck->countCards();

        $this->assertEquals($res, 52);
    }

     /**
     * Test if the getDeck method returns cardobject checking the second card objekt in array
     */
    public function testGetDeck()
    {       
        $card = new Pokercards(3, "&hearts;", "red", 3);

        $res = $this->deck->getDeck();

        $this->assertEquals($res[1], $card);

        $this->assertIsObject($res[1]);
    }

    /**
     * Test if the shuffle method is mixing the cards
     */
    public function testShuffleDeck()
    {
        $deck1 = $this->deck;

        $deck2 = new Pokerdeck();

        $deck2->shuffles();

        $res1 = $deck1->getDeck();

        $res2 = $deck2->getDeck();

        $this->assertNotEquals($res1, $res2);
    }

    /**
     * Testing to see if draw method working accordingly
     */
    public function testDrawCardWithNoArgs()
    {
        $card = new Pokercards(2, "&hearts;", "red", 2);

        $res = $this->deck->draw();

        $this->assertEquals($res[0], $card);
    }

    /**
     * Testing if draw method works accordingly with many cards draw as args
     */
    public function testDrawCardWithArgs()
    {       
        $card = new Pokercards(5, "&hearts;", "red", 5);

        $res = $this->deck->draw(4);

        $this->assertEquals($res[3], $card);
    }

    /**
     * testing if an exception is thrown then try to draw more then cards in deck
     */
    public function testDrawExceptionOutofBounds()
    {
        $deck1 = $this->deck;

        $this->expectException(DrawException::class);

        $res = $deck1->draw(54);
    }

    /**
     *
     * testing if exception is thrown when try to draw on a empty deck
     */
    public function testDrawExceptionEmpyDeck()
    {
        $deck1 = new Pokerdeck();

        $deck1->draw(52);

        $this->expectException(DrawException::class);

        $res = $deck1->draw();
    }
}
