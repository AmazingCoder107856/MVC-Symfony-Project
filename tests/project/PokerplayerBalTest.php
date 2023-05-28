<?php

namespace App\Project;

use PHPUnit\Framework\TestCase;

use App\Project\PokerplayerBal;


/**
 * Test class for the player balance
 */

 class PokerplayerBalTest extends Testcase {


    /**
     * verify that the object is of expected instance.
    */
    public function testCreate()
    {
        $res = new PokerplayerBal();
        $this->assertInstanceOf("\App\Project\PokerplayerBal", $res);
    }

    /**
     * Test to see if default value is return if no arbment given
     */
    public function testWithNoArgs()
    {
        $res = new PokerplayerBal();

        $bal = $res->getBalance();
        $this->assertEquals($bal, 1000);
    }

    /**
     * test to see if the given argument is returned
     */
    public function testWithArgs()
    {
        $res = new PokerplayerBal(2000);

        $bal = $res->getBalance();
        $this->assertEquals($bal, 2000);
    }

    /**
     * Test to see if balance decrease if setnegative method is called
     */
    public function testsetnegativeMethod()
    {
        $res = new PokerplayerBal(2000);
        $res->setnegativeRes(1000);
        $bal = $res->getBalance();
        $this->assertEquals($bal, 1000);
    }

    /**
     * Test to see if balance increase if setpositive method is called
     */
    public function testsetPositiveMethod()
    {
       $res = new PokerplayerBal(2000);
       $res->setPositiveRes(1000);
       $bal = $res->getBalance();
       $this->assertEquals($bal, 3000);
    }
 }
 