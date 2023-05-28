<?php

namespace App\Project;

use PHPUnit\Framework\TestCase;

use App\Project\Pokercards;

/**
 * Test Cases for class Pokercards
 */
class PokercardsTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
    */
    public function testCreate()
    {
        $card = new Pokercards("Q", "&hearts;", "red", 10);
        $this->assertInstanceOf("\App\Project\Pokercards", $card);
    }

    /**
     * Construct object and check if a point is returned
     */
    public function testPointMethodWhenPointIsGiven()
    {
        $card = new Pokercards("Q", "@hearts;", "red", 10);
        $res = $card->getPoint();
        $this->assertEquals(10, $res);
    }

    /**
     * Construct object and check if a default point is returned when non is given
     */
    public function testPointIsDefaultZero()
    {
        $card = new Pokercards("Q", "@hearts;", "red");
        $res = $card->getPoint();
        $this->assertEquals(0, $res);
    }

    public function testGetSuitMethod()
    {
        $card = new Pokercards("K", "&clubs;", "red", 13);
        $res = $card->getSuit();
        $this->assertEquals("&clubs;", $res);

    }
}
