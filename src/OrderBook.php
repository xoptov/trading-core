<?php

namespace Xoptov\TradingCore;

use Xoptov\TradingCore\Model\Rate;
use Xoptov\TradingCore\Model\Order;
use Xoptov\TradingCore\Model\CurrencyPair;
use Xoptov\TradingCore\Exception\UnknownTypeException;
use Xoptov\TradingCore\Exception\UnsupportedTypeException;

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
     * @param string       $type
     * @param CurrencyPair $currencyPair
     * @param Rate         $rate
     * @throws UnsupportedTypeException
     */
    public function add($type, CurrencyPair $currencyPair, Rate $rate)
    {
        if (!$this->currencyPair->equals($currencyPair)) {
            throw new UnsupportedTypeException("Unsupported currency pair.");
        }
        $side = $this->determine($type);
        $side->add($rate);
    }

    /**
     * Method for modify rate in side.
     *
     * @param string       $type
     * @param CurrencyPair $currencyPair
     * @param Rate         $rate
     * @return boolean
     * @throws UnsupportedTypeException
     */
    public function modify($type, CurrencyPair $currencyPair, Rate $rate)
    {
        if (!$this->currencyPair->equals($currencyPair)) {
            throw new UnsupportedTypeException("Unsupported currency pair.");
        }

        $side = $this->determine($type);

        return $side->modify($rate);
    }

    /**
     * Method for removing rate from side by price.
     *
     * @param string       $type
     * @param CurrencyPair $currencyPair
     * @param float        $price
     * @return bool
     * @throws UnsupportedTypeException
     */
    public function remove($type, CurrencyPair $currencyPair, $price)
    {
        if (!$this->currencyPair->equals($currencyPair)) {
            throw new UnsupportedTypeException("Unsupported currency pair.");
        }

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
     * Method for retrieving highest bid.
     *
     * @return null|Rate
     */
    public function getHighestBid()
    {
        return $this->bids->getHighest();
    }

    /**
     * Method for retrieving lowest bid.
     *
     * @return null|Rate
     */
    public function getLowestBid()
    {
        return $this->bids->getLowest();
    }

    /**
     * Method for retrieving highest ask.
     *
     * @return null|Rate
     */
    public function getHighestAsk()
    {
        return $this->asks->getHighest();
    }

    /**
     * Method for retrieving lowest ask.
     *
     * @return null|Rate
     */
    public function getLowestAsk()
    {
        return $this->asks->getLowest();
    }

    /**
     * Method for retrieving all bid rates.
     *
     * @return null|Rate[]
     */
    public function getBids()
    {
        return $this->bids->getRates();
    }

    /**
     * Method for retrieving all ask rates.
     *
     * @return null|Rate[]
     */
    public function getAsks()
    {
        return $this->asks->getRates();
    }

    /**
     * Method for determining side by type.
     *
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