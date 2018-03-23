<?php

namespace Xoptov\TradingCore;

use Xoptov\TradingCore\Model\Rate;
use Xoptov\TradingCore\Model\Order;
use Xoptov\TradingCore\Model\CurrencyPair;
use Xoptov\TradingCore\Exception\UnknownTypeException;

class OrderBook
{
	/** @var CurrencyPair */
	private $currencyPair;

    /** @var OrderBookSide */
    private $asks;

    /** @var OrderBookSide */
    private $bids;

	/**
	 * OrderBook constructor.
	 *
	 * @param CurrencyPair $currencyPair
     * @param callable     $asksSorter
     * @param callable     $bidsSorter
	 */
    public function __construct(CurrencyPair $currencyPair, callable $asksSorter, callable $bidsSorter)
    {
    	$this->currencyPair = $currencyPair;
    	$this->asks = new OrderBookSide($asksSorter);
        $this->bids = new OrderBookSide($bidsSorter);
    }

    /**
     * Method for adding rate to side.
     *
     * @param string $type
     * @param Rate $rate
     */
    public function add($type, Rate $rate)
    {
        $side = $this->determine($type);
        $side->add($rate);
    }

    /**
     * Method for modify rate in side.
     *
     * @param string $type
     * @param Rate $rate
     * @return boolean
     */
    public function modify($type, Rate $rate)
    {
        $side = $this->determine($type);

        return $side->modify($rate);
    }

    /**
     * Method for removing rate from side by price.
     *
     * @param $type
     * @param $price
     * @return bool
     */
    public function remove($type, $price)
    {
        $side = $this->determine($type);

        return $side->remove($price);
    }

    /**
     * Method for clear side collections.
     */
    public function clear()
    {
        $this->asks->clear();
        $this->bids->clear();
    }

    /**
	 * @param $type
	 * @return OrderBookSide
	 */
    private function determine($type)
    {
    	if (Order::TYPE_ASK === $type) {
    		return $this->asks;
	    } elseif (Order::TYPE_BID === $type) {
    		return $this->bids;
        }

        throw new UnknownTypeException();
    }
}