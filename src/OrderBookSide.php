<?php

namespace Xoptov\TradingCore;

use SplDoublyLinkedList;
use Xoptov\TradingCore\Model\Rate;

class OrderBookSide
{
    /** @var Rate[] */
    private $rates;

    /** @var callable */
    private $sorter;

    /**
     * OrderBookSide constructor.
     *
     * @param callable $sorter callback function for sorting.
     */
    public function __construct(callable $sorter)
    {
        $this->rates = new SplDoublyLinkedList();
        $this->sorter = $sorter;
    }

    /**
     * Method for getting lowest copy of rate object from collection.
     *
     * @return null|Rate
     */
    public function getLowest()
    {
        if ($this->rates->isEmpty()) {
            return null;
        }

        /** @var Rate $low */
        $low = $this->rates->top();

        /** @var Rate $rate */
        foreach ($this->rates as $rate) {
            if ($rate->getPrice() < $low->getPrice()) {
                $low = $rate;
            }
        }

        return clone $low;
    }

    /**
     * Method for getting highest copy of rate object from collection.
     *
     * @return null|Rate
     */
    public function getHighest()
    {
        if ($this->rates->isEmpty()) {
            return null;
        }

        /** @var Rate $high */
        $high = $this->rates->top();

        /** @var Rate $rate */
        foreach ($this->rates as $rate) {
            if ($rate->getPrice() > $high->getPrice()) {
                $high = $rate;
            }
        }

        return clone $high;
    }

    /**
     * Method for adding rate to depth.
     *
     * @param Rate $rate
     */
    public function add(Rate $rate)
    {
        /** @var Rate $exist */
        foreach ($this->rates as $exist) {
            if ($exist->isEqualPrice($rate)) {
                $exist->increaseVolume($rate->getVolume());
                return;
            }
        }

        $this->rates->push($rate);
        $this->sort();
    }

    /**
     * Method for modify rate volume.
     *
     * @param Rate $rate
     * @return bool
     */
    public function modify(Rate $rate)
    {
        foreach ($this->rates as $exist) {
            if ($exist->isEqualPrice($rate)) {
                $exist->setVolume($rate->getVolume());
                return true;
            }
        }

        return false;
    }

    /**
     * Method for removing rate by price.
     *
     * @param $price
     * @return bool
     */
    public function remove($price)
    {
        foreach ($this->rates as $key => $rate) {
            if ($rate->getPrice() === $price) {
                $this->rates->offsetUnset($key);

                return true;
            }
        }

        return false;
    }

    public function clear()
    {
        $this->rates = new SplDoublyLinkedList();
    }

    /**
     * Method for calculating simple average price.
     *
     * @param int $limit
     * @return float
     */
    public function simpleAveragePrice($limit = 30)
    {
        $total = 0.0;
        $count = 1;

        for ($i = 0; $i < $this->rates->count() && $i < $limit; $i++, $count++) {
            /** @var Rate $rate */
            $rate = $this->rates->offsetGet($i);
            $total += $rate->getPrice();
        }

        return $total / $count;
    }

    /**
     * Method for calculating weighted average price.
     *
     * @param int $limit
     * @return float
     */
    public function weightedAveragePrice($limit = 30)
    {
        $totalPrice = 0.0;
        $totalVolume = 0.0;

        for ($i = 0; $i < $this->rates->count() && $i < $limit; $i++) {
            /** @var Rate $rate */
            $rate = $this->rates->offsetGet($i);
            $totalPrice += $rate->getTotal();
            $totalVolume += $rate->getVolume();
        }

        return $totalPrice / $totalVolume;
    }

    /**
     * Method for sorting collection by sorter.
     *
     * @return bool
     */
    private function sort()
    {
        $rates = [];

        foreach ($this->rates as $rate) {
            $rates[] = $rate;
        }

        unset($rate);

        if (!usort($rates, $this->sorter)) {
            return false;
        }

        $this->clear();
        foreach ($rates as $rate) {
            $this->rates->push($rate);
        }

        return true;
    }
}