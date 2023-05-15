<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use App\Card\Cards;


/**
 * Test cases for class Cards.
 */
class CardsTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
    */

    public function testCreate()
    {
        $card = new Cards("Q", "&hearts;", "red", 10);
        $this->assertInstanceOf("\App\Card\Cards", $card);
    }

    /**
     * Construct object and check if a point is returned
     */

    public function testPointMethodWhenPointIsGiven()
    {
        $card = new Cards("Q", "@hearts;", "red", 10);
        $res = $card->getPoint();
        $this->assertEquals(10, $res);
    }

    /**
     * Construct object and check if a default point is returned when non is given
     */

    public function testPointIsDefaultZero()
    {
        $card = new Cards("Q", "@hearts;", "red");
        $res = $card->getPoint();
        $this->assertEquals(0, $res);
    }

    /**
     * Construct object and check if string method returns string with properties in
     */

    public function testGetStringBack()
    {
        $card = new Cards("Q", "@hearts;", "red", 10);
        $res = $card->getAsString();

        $this->assertStringContainsString("@hearts;", $res);
    }
}
