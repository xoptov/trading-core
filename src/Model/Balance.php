<?php

namespace Xoptov\TradingCore\Model;

use DeepCopy\DeepCopy;
use SplDoublyLinkedList;

class Balance
{
    /** @var SplDoublyLinkedList */
    protected $actives;

    /** @var DeepCopy */
    protected $copier;

    /** @var bool */
    protected $loaded = false;

    /**
     * Balance constructor.
     */
    public function __construct()
    {
        $this->actives = new SplDoublyLinkedList();
        $this->copier = new DeepCopy();
    }

    /**
     * Method for getting actives.
     *
     * @return SplDoublyLinkedList
     */
    public function getActives()
    {
        return $this->copier->copy($this->actives);
    }

    /**
     * Method for adding active.
     *
     * @param Active $newActive
     * @return boolean
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
     * @return boolean
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
     * @return boolean
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
     * Method for adding trade in actives.
     *
     * @param Trade $trade
     * @return boolean
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