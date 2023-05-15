<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use App\Card\CardDeck;
use App\Card\Cards;


/**
 * Test cases for class CardDeck.
 */
class CardDeckTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
    */

    public function testCreate()
    {
        $deck = new CardDeck();
        $this->assertInstanceOf("\App\Card\CardDeck", $deck);
    }

    /**
     * Test if a deck object contains of an array of 52 card objects
     */

    public function testCountCards()
    {
        $deck = new CardDeck();

        $res = $deck->countCards();

        $this->assertEquals($res, 52);
    }

    /**
     * Test if the getDeck method returns cardobject checking the second card objekt in array
     */
    public function testGetDeck()
    {
        $deck = new CardDeck();

        $card = new Cards(2, "&hearts;", "red", 2);

        $res = $deck->getDeck();

        $this->assertEquals($res[1], $card);

        $this->assertIsObject($res[1]);
    }

    /**
     * Test if the shuffle method is mixing the cards
     */

    public function testShuffleDeck()
    {
        $deck1 = new CardDeck();

        $deck2 = new CardDeck();

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
        $deck1 = new CardDeck();

        $card = new Cards("A", "&hearts;", "red", 11);

        $res = $deck1->draw();

        $this->assertEquals($res[0], $card);
    }

    /**
     * Testing if draw method works accordingly with many cards draw as args
     */

    public function testDrawCardWithArgs()
    {
        $deck1 = new CardDeck();

        $card = new Cards(4, "&hearts;", "red", 4);

        $res = $deck1->draw(4);

        $this->assertEquals($res[3], $card);
    }

    /**
     * Construct object and verify that a DrawException is thrown.
     * Use a faulty argument that is too high.
     * testing if an exception is thrown then try to draw more then cards in deck
     */

    public function testDrawExceptionOutofBounds()
    {
        $deck = new CardDeck();
        
        $this->expectException(DrawException::class);

        $deck->draw(53);
    }

    /**
     * Construct object and verify that a DrawException is thrown.
     * Use a faulty argument that is too low.
     * testing if exception is thrown when try to draw on a empty deck
     */

    public function testDrawExceptionEmpyDeck()
    {
        $deck = new CardDeck();

        $this->expectException(DrawException::class);       

        $deck->draw(0);
    }
}
