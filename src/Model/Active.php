<?php

namespace Xoptov\TradingCore\Model;

use LogicException;
use DeepCopy\DeepCopy;
use SplDoublyLinkedList;
use Xoptov\TradingCore\Exception\UnknownTypeException;

class Active
{
	/** @var Currency */
	private $currency;

	/** @var float */
    private $price;

    /** @var float */
    private $volume;

    /** @var SplDoublyLinkedList */
    private $trades;

    /** @var SplDoublyLinkedList */
    private $orders = array();

    /** @var DeepCopy */
    private $copier;

	/**
	 * AbstractActive constructor.
     *
	 * @param Currency $currency
	 * @param float $volume
	 */
	public function __construct(Currency $currency, $volume)
	{
	    $this->copier = new DeepCopy();
		$this->currency = $currency;
		$this->volume = $volume;
		$this->trades = new SplDoublyLinkedList();
		$this->orders = new SplDoublyLinkedList();
	}

	/**
	 * @return Currency
	 */
	public function getCurrency()
	{
		return $this->currency;
	}

	/**
	 * @return float
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * @return float
	 */
	public function getVolume()
	{
		return $this->volume;
	}

    /**
     * @param Trade $trade
     */
    public function addTrade(Trade $trade)
    {
        $this->trades->push($trade);

        if ($trade->isSell()) {
            $this->addSellTrade($trade);
        } elseif ($trade->isBuy()) {
            $this->addBuyTrade($trade);
        } else {
            throw new UnknownTypeException("Trade type must be set to \"sell\" or \"buy\".");
        }
    }

    /**
     * @return SplDoublyLinkedList
     */
    public function getTrades()
    {
        return $this->copier->copy($this->trades);
    }

    /**
     * @param Order $newOrder
     * @return bool
     */
    public function addOrder(Order $newOrder)
    {
        if (!$this->equal($newOrder->getActive())) {
            throw new LogicException("Active in order not equal with this active.");
        }

        /** @var Order $order */
        foreach ($this->orders as $order) {
            if ($newOrder->equal($order)) {
                return false;
            }
        }

        $this->orders->push($order);

        return true;
    }

    public function removeOrder(Order $order)
    {
        //TODO: need implement logic for this method.
    }

    /**
     * @return Order[]
     */
    public function getOrders()
    {
    	$orders = array();

    	foreach ($this->orders as $order) {
    		$orders[] = clone $order;
	    }

        return $orders;
    }

    /**
     * Method return locked volume of active in open orders.
     *
     * @return float
     */
    public function getLockedVolume()
    {
        $volume = 0.0;

        /** @var Order $order */
        foreach ($this->orders as $order) {
            if ($order->isAsk()) {
                $volume += $order->getVolume();
            }
        }

        return $volume;
    }

    /**
     * Method return available volume of active without locked.
     *
     * @return float
     */
    public function getAvailableVolume()
    {
        return $this->volume - $this->getLockedVolume();
    }

    /**
     * @param Active $active object for comparison.
     *
     * @return bool
     */
    public function equal(Active $active)
    {
        $own = $this->getCurrency();
        $other = $active->getCurrency();

        if ($own && $other) {
            return $own->equal($other);
        }

        return false;
    }

    /**
     * @return null|string
     */
    public function getSymbol()
    {
        if ($this->currency) {
            return $this->currency->getSymbol();
        }

        return null;
    }

    /**
     * Method for adding and calculating "sell" trade.
     *
     * @param Trade $trade
     */
    private function addSellTrade(Trade $trade)
    {
        if ($trade->isBaseCurrency($this->currency)) {
            //TODO: need implement this logic.
        } elseif ($trade->isQuoteCurrency($this->currency)) {
            //TODO: need implement this logic.
        } else {
            throw new LogicException("This trade unsupported by active.");
        }
    }

    /**
     * Method for adding and calculating "buy" trade.
     *
     * @param Trade $trade
     */
    private function addBuyTrade(Trade $trade)
    {
        //TODO: need implement this logic.
    }
}