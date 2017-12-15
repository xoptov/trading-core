<?php

namespace Xoptov\TradingCore\Response\OrderBook;

use SplDoublyLinkedList;
use Xoptov\TradingCore\Model\Rate;

class Response
{
    /** @var SplDoublyLinkedList */
    private $asks;

    /** @var SplDoublyLinkedList */
    private $bids;

    /**
     * Response constructor.
     */
    public function __construct()
    {
        $this->asks = new SplDoublyLinkedList();
        $this->bids = new SplDoublyLinkedList();
    }

    /**
     * @param float $price
     * @param float $value
     */
    public function addAsk($price, $value)
    {
        $this->asks->push(new Rate($price, $value));
    }

    /**
     * @return SplDoublyLinkedList
     */
    public function getAsks()
    {
    	$asks = new SplDoublyLinkedList();

    	foreach ($this->asks as $ask) {
    		$asks->push(clone $ask);
	    }

        return $asks;
    }

    /**
     * @param float $price
     * @param float $value
     */
    public function addBid($price, $value)
    {
        $this->bids->push(new Rate($price, $value));
    }

    /**
     * @return SplDoublyLinkedList
     */
    public function getBids()
    {
    	$bids = new SplDoublyLinkedList();

    	foreach ($this->bids as $bid) {
    		$bids->push(clone $bid);
	    }

        return $bids;
    }
}