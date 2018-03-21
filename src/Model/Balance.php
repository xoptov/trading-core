<?php

namespace Xoptov\TradingCore\Model;

use DeepCopy\DeepCopy;
use SplDoublyLinkedList;

class Balance
{
    /** @var SplDoublyLinkedList */
    private $actives;

    /** @var DeepCopy */
    private $copier;

    /** @var bool */
    private $loaded = false;

    /**
     * Balance constructor.
     */
    public function __construct()
    {
        $this->actives = new SplDoublyLinkedList();
        $this->copier = new DeepCopy();
    }

    /**
     * @return SplDoublyLinkedList
     */
    public function getActives()
    {
        return $this->copier->copy($this->actives);
    }

    /**
     * @param Active $newActive
     * @return bool
     */
    public function addActive(Active $newActive)
    {
        if ($this->loaded) {
            return false;
        }

        /** @var Active $active */
        foreach ($this->actives as $active) {
            if ($active->equal($newActive)) {
                return false;
            }
        }

        $this->actives->push($newActive);

        return true;
    }

    /**
     * Method for adding order to active.
     *
     * @param Order $order
     * @return bool
     */
    public function addOrder(Order $order)
    {
        /** @var Active $active */
        foreach ($this->actives as $active) {
            if ($active->equal($order->getActive())) {
                $active->addOrder($order);

                return true;
            }
        }

        return false;
    }

    /**
     * Method for removing order object from active.
     *
     * @param Order $order
     * @return bool
     */
    public function removeOrder(Order $order)
    {
        /** @var Active $active */
        foreach ($this->actives as $active) {
            if ($active->equal($order->getActive())) {
                $active->removeOrder($order);

                return true;
            }
        }

        return false;
    }

    /**
     * @param Trade $trade
     * @return bool
     */
    public function addTrade(Trade $trade)
    {
        $result = false;

        for ($x = 0, $founded = 0; $x < count($this->actives) && $founded < 2; $x++) {
            /** @var Active $active */
            $active = $this->actives[$x];

            if ($trade->hasSymbol($active->getSymbol())) {
                $active->addTrade($trade);
                $result = true;
                $founded++;
            }
        }

        return $result;
    }

    /**
     * Method for clean actives.
     */
    public function clear()
    {
        $this->actives = new SplDoublyLinkedList();
    }
}