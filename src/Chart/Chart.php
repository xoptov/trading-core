<?php

namespace Xoptov\TradingCore\Chart;

use DatePeriod;
use DeepCopy\DeepCopy;
use SplDoublyLinkedList;
use Xoptov\TradingCore\Model\Trade;

class Chart
{
    /** @var DatePeriod */
    private $period;

    /** @var SplDoublyLinkedList */
    private $periods;

    /** @var DeepCopy */
    private $copier;

    /**
     * Chart constructor.
     *
     * @param DatePeriod $period
     */
    public function __construct(DatePeriod $period)
    {
        $this->period = $period;
        $this->periods = new SplDoublyLinkedList();

        $this->copier = new DeepCopy();
    }

    /**
     * @return DatePeriod
     */
    public function getPeriod()
    {
        return clone $this->period;
    }

    /**
     * @return SplDoublyLinkedList
     */
    public function getPeriods()
    {
        return $this->copier->copy($this->periods);
    }

    /**
     * Method for adding period to collection.
     *
     * @param Period $newPeriod
     * @return boolean
     */
    public function addPeriod(Period $newPeriod)
    {
        foreach ($this->periods as $period) {
            if ($newPeriod->equal($period)) {
                return false;
            }
        }

        $this->periods->push($newPeriod);

        return true;
    }

    /**
     * Method for removing period from collection.
     *
     * @param Period $removePeriod
     * @return boolean
     */
    public function removePeriod(Period $removePeriod)
    {
        foreach ($this->periods as $key => $period) {
            if ($removePeriod->equal($period)) {
                $this->periods->offsetUnset($key);

                return true;
            }
        }

        return false;
    }

    /**
     * Method for adding trade to period.
     *
     * @param Trade $trade
     */
    public function addTrade(Trade $trade)
    {
        //TODO: need implement this method.
    }

    /**
     * Method for removing trade from period.
     *
     * @param Trade $trade
     */
    public function removeTrade(Trade $trade)
    {
        //TODO: need implement this method.
    }
}