<?php

namespace Xoptov\TradingCore\Tests;

use PHPUnit\Framework\TestCase;
use Xoptov\TradingCore\Calculator;

class CalculatorTest extends TestCase
{
    public function testAp()
    {
        $result = Calculator::ap(100, 10, 3);

        $this->assertEquals(127, $result);
    }

    public function testGp()
    {
        $result = Calculator::gp(100, 10, 3);

        $this->assertEquals(1968300, $result);
    }

    public function testCi()
    {
        $result = Calculator::ci(100, 10, 3);

        $this->assertEquals(134.39163793441, $result);
    }

    public function testIncrementNumberSequence()
    {
        $result = Calculator::ans(100, 10, 3, array(Calculator::class, "ap"));
    }

    public function testDecrementNumberSequence()
    {
        $result = Calculator::ans(100, 10, -3, array(Calculator::class, "ap"));
    }

    public function testCompoundPercentIncremented()
    {
        $result = Calculator::cins(100, 10, 3);
    }

    public function testCompoundPercentDecrement()
    {
        $result = Calculator::cins(100, 10, -3);
    }
}