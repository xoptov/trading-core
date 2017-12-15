<?php

namespace Xoptov\TradingCore\Response\TradeHistory;

use DateTime;
use SplDoublyLinkedList;
use Xoptov\TradingCore\Model\Trade;

class Response
{
    /** @var SplDoublyLinkedList */
    private $trades;

    /**
     * Response constructor.
     */
    public function __construct()
    {
        $this->trades = new SplDoublyLinkedList();
    }

    /**
     * @return SplDoublyLinkedList
     */
    public function getTrades()
    {
        $trades = new SplDoublyLinkedList();

        foreach ($this->trades as $trade) {
            $trades->push(clone $trade);
        }

        return $trades;
    }

    /**
     * @param mixed $id
     * @param string $type
     * @param float $price
     * @param float $volume
     * @param DateTime $createdAt
     */
    public function addTrade($id, $type, $price, $volume, DateTime $createdAt)
    {
        $this->trades->push(new Trade($id, $type, $price, $volume, $createdAt));
    }
}