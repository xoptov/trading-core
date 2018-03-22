<?php

namespace Xoptov\TradingCore\Chart;

use DatePeriod;
use SplDoublyLinkedList;
use Xoptov\TradingCore\Model\Trade;

class Period extends AbstractPeriod
{
    /** @var SplDoublyLinkedList */
    private $trades;

    /**
     * Period constructor.
     *
     * {@inheritdoc}
     */
    public function __construct($open, $close, $high, $low, DatePeriod $period)
    {
        parent::__construct($open, $close, $high, $low, $period);

        $this->trades = new SplDoublyLinkedList();
    }

    /**
     * Method for adding trade to collection.
     *
     * @param Trade $newTrade
     * @return boolean
     */
    public function addTrade(Trade $newTrade)
    {
        /** @var Trade $trade */
        foreach ($this->trades as $trade) {
            if ($trade->equal($newTrade)) {
                return false;
            }
        }

        $this->trades->push($newTrade);

        return true;
    }

    /**
     * Method for removing trade from collection.
     *
     * @param Trade $removeTrade
     * @return boolean
     */
    public function removeTrade(Trade $removeTrade)
    {
        foreach ($this->trades as $key => $trade) {
            if ($removeTrade->equal($trade)) {
                $this->trades->offsetUnset($key);

                return true;
            }
        }

        return false;
    }

    /**
     * Method for check equivalence period.
     *
     * @param Period $period
     * @return boolean
     */
    public function equal(Period $period)
    {
        //TODO: need implement this method.

        return false;
    }
}