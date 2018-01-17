<?php

namespace Xoptov\TradingCore;

use SplDoublyLinkedList;
use Xoptov\TradingCore\Model\Rate;
use Xoptov\TradingCore\Model\Order;
use Xoptov\TradingCore\Model\CurrencyPair;
use Xoptov\TradingCore\Exception\UnknownTypeException;

class OrderBook
{
	/** @var CurrencyPair */
	private $currencyPair;

    /** @var SplDoublyLinkedList */
    private $asks;

    /** @var SplDoublyLinkedList */
    private $bids;

	/**
	 * OrderBook constructor.
	 *
	 * @param CurrencyPair $currencyPair
	 */
    public function __construct(CurrencyPair $currencyPair)
    {
    	$this->currencyPair = $currencyPair;
        $this->asks = new SplDoublyLinkedList();
        $this->bids = new SplDoublyLinkedList();
    }

	/**
     * @return SplDoublyLinkedList
     */
    public function getAsks()
    {
        $asks = clone $this->asks;

        return $asks;
    }

    /**
     * @return SplDoublyLinkedList
     */
    public function getBids()
    {
        $bids = clone $this->bids;

        return $bids;
    }

    /**
     * @return Rate|null
     */
    public function getLowestAsk()
    {
        if ($this->asks->isEmpty()) {
            return null;
        }

        /** @var Rate $lowAsk */
        $lowAsk = $this->asks->top();

        /** @var Rate $ask */
        foreach ($this->asks as $ask) {
            if ($ask->getPrice() < $lowAsk->getPrice()) {
                $lowAsk = $ask;
            }
        }

        return clone $lowAsk;
    }

    /**
	 * @return Rate|null
	 */
    public function getHighestBid()
    {
        if ($this->bids->isEmpty()) {
            return null;
        }

        /** @var Rate $highBid */
        $highBid = $this->bids->top();

        /** @var Rate $bid */
        foreach ($this->bids as $bid) {
            if ($bid->getPrice() > $highBid->getPrice()) {
                $highBid = $bid;
            }
        }

        return clone $highBid;
    }

    /**
     * @param string $type
     * @param Rate $rate
     */
    public function add($type, Rate $rate)
    {
        $side = $this->determine($type);

        /** @var Rate $row */
        foreach ($side as $row) {
            if ($row->getPrice() === $rate->getPrice()) {
                $rate->setVolume($row->getVolume() + $rate->getVolume());
                break;
            }
        }

        $side->push($rate);
    }

    /**
     * @param string $type
     * @param Rate $rate
     */
    public function modify($type, Rate $rate)
    {
        $side = $this->determine($type);

        /** @var Rate $row */
        foreach ($side as $row) {
            if ($row->getPrice() === $rate->getPrice()) {
                $row->setVolume($rate->getVolume());
                break;
            }
        }

        $side->push($rate);
    }

    /**
     * @param string $type
     * @param float $price
     * @return boolean
     */
    public function remove($type, $price)
    {
        $side = $this->determine($type);

        /** @var Rate $row */
        foreach ($side as $key => $row) {
            if ($row->getPrice() === $price) {
                $side->offsetUnset($key);

                return true;
            }
        }

        return false;
    }

    public function clean()
    {
        unset($this->asks);
        $this->asks = new SplDoublyLinkedList();

        unset($this->bids);
        $this->bids = new SplDoublyLinkedList();
    }

	/**
	 * @param $type
	 * @return SplDoublyLinkedList
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