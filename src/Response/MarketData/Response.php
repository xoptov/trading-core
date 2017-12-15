<?php

namespace Xoptov\TradingCore\Response\MarketData;

use DatePeriod;
use SplDoublyLinkedList;

class Response
{
    /** @var SplDoublyLinkedList */
    private $data;

    /**
     * Response constructor.
     */
    public function __construct()
    {
        $this->data = new SplDoublyLinkedList();
    }

    /**
     * @return SplDoublyLinkedList
     */
    public function getData()
    {
    	$data = new SplDoublyLinkedList();

    	foreach ($this->data as $item) {
    		$data->push(clone $item);
	    }

        return $data;
    }

    /**
     * @param float $open
     * @param float $close
     * @param float $high
     * @param float $low
     * @param DatePeriod $period
     * @param float $baseVolume
     * @param float $quoteVolume
     * @param float $weightedAverage
     */
    public function addDataItem($open, $close, $high, $low, DatePeriod $period, $baseVolume, $quoteVolume, $weightedAverage)
    {
        $this->data->push(new Data($open, $close, $high, $low, $period, $baseVolume, $quoteVolume, $weightedAverage));
    }
}