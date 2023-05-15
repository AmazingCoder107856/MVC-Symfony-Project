<?php

namespace App\Card;

use App\Card\CardDeck;
use App\Card\CardHand;
use App\Card\Cards;
use PHPUnit\Framework\TestCase;


/**
 * Test cases for class CardHand.
 */
class CardHandTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
    */

    public function testCreateHand()
    {
        $hand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $hand);
    }

    /**
     * Test to see get hand method return an empty array when called with no other method being called before
     */

    public function testGetHandWEmptyHand()
    {
        $hand = new CardHand();

        $res = $hand->getHand();

        $this->assertEquals([], $res);
    }

    /**
     * Test to see if assCardtoHand works accordingly
     */

    public function testGetHand1Card()
    {
        $hand = new CardHand();

        $deck1 = new CardDeck();

        $card = $deck1->draw();

        $card2 = new Cards("A", "&hearts;", "red", 11);

        $hand->addCardHand($card);

        $res = $hand->getHand();

        $this->assertEquals($res[0][0], $card2);
    }
}
