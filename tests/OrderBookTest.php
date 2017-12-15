<?php

namespace Xoptov\TradingCore\Tests;

use PHPUnit\Framework\TestCase;
use Xoptov\TradingCore\OrderBook;
use Xoptov\TradingCore\Model\Rate;
use Xoptov\TradingCore\Model\Order;

class OrderBookTest extends TestCase
{
	public function testAdd()
	{
		$asks = array(
			array(1.7261, 22),
			array(1.7270, 1),
			array(1.7280, 1),
			array(1.7271, 1),
			array(1.7260, 3),
            array(1.7262, 1),
            array(1.7281, 1)
		);

		$bids = array(
			array(1.7210, 1),
			array(1.7240, 1),
			array(1.7200, 1),
			array(1.7220, 1),
			array(1.7230, 1)
		);

		$orderBook = new OrderBook();

		foreach ($asks as $ask) {
			$rate = new Rate($ask[0], $ask[1]);
			$orderBook->add(Order::TYPE_ASK, $rate);
		}

		foreach ($bids as $bid) {
			$rate = new Rate($bid[0], $bid[1]);
			$orderBook->add(Order::TYPE_BID, $rate);
		}

		unset($ask, $bid, $rate);

		$highBid = $orderBook->getHighestBid();
		$this->assertEquals($bids[1][0], $highBid->getPrice());

		$lowAsk = $orderBook->getLowestAsk();
		$this->assertEquals($asks[4][0], $lowAsk->getPrice());

		$result = $orderBook->remove(Order::TYPE_ASK, 1.7261);
		$this->assertTrue($result);
		$this->assertCount(6, $orderBook->getAsks());

		$orderBook->clean();
		$this->assertCount(0, $orderBook->getAsks());
        $this->assertCount(0, $orderBook->getBids());
	}
}