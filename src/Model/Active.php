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
    private $orders;

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
        $this->currency = $currency;
        $this->volume = $volume;

        $this->trades = new SplDoublyLinkedList();
        $this->orders = new SplDoublyLinkedList();
        $this->copier = new DeepCopy();
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
     * This method must be call for base and quote currency.
     *
     * @param Trade $trade
     */
    public function addTrade(Trade $trade)
    {
        if (!$trade->hasSymbol($this->getSymbol())) {
            throw new LogicException("This trade unsupported by active.");
        }

        if ($trade->isSell()) {
            $this->sell($trade);
        } elseif ($trade->isBuy()) {
            $this->buy($trade);
        } else {
            throw new UnknownTypeException("Trade type must be \"sell\" or \"buy\".");
        }

        $this->trades->push($trade);
    }

    /**
     * Method for getting copy of Trade collection.
     *
     * @return SplDoublyLinkedList
     */
    public function getTrades()
    {
        return $this->copier->copy($this->trades);
    }

    /**
     * Method
     *
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

    /**
     * Method for remove order from collection.
     *
     * @param Order $removeOrder
     * @return bool
     */
    public function removeOrder(Order $removeOrder)
    {
        foreach ($this->orders as $key => $order) {
            if ($removeOrder->equal($order)) {
                $this->orders->offsetUnset($key);

                return true;
            }
        }

        return false;
    }

    /**
     * Method for retrieving copy of Order collection.
     *
     * @return SplDoublyLinkedList|Order[]
     */
    public function getOrders()
    {
    	return $this->copier->copy($this->orders);
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
        return $this->getVolume() - $this->getLockedVolume();
    }

    /**
     * Method for calculating volume of active.
     *
     * @return float
     */
    public function calculateVolume()
    {
        $volume = 0.0;

        /** @var Trade $trade */
        foreach ($this->trades as $trade) {
            if ($trade->isBuy()) {
                $this->increaseVolume($trade->getVolume());
            } else{
                $this->decreaseVolume($trade->getVolume());
            }
        }

        return $volume;
    }

    /**
     * Method for calculating average and weighted average price.
     *
     * @param boolean $weighted
     * @return float
     */
    public function calculateAveragePrice($weighted = false)
    {
        $totalPrice = 0.0;

        /** @var Trade $trade */
        foreach ($this->trades as $trade) {
            if ($trade->isBuy()) {
                if ($weighted) {
                    $totalPrice += $trade->getTotal();
                } else {
                    $totalPrice += $trade->getPrice();
                }
            } else {
                if ($weighted) {
                    $totalPrice -= $trade->getTotal();
                } else {
                    $totalPrice -= $trade->getPrice();
                }
            }
        }

        return $totalPrice / $this->getVolume();
    }

    /**
     * @param Active $active object for comparison.
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
     * Method for getting symbol of active.
     *
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
    private function sell(Trade $trade)
    {
        if ($trade->isBaseCurrency($this->currency)) {
            $this->decreaseVolume($trade->getVolume());
        } else {
            $this->increaseVolume($trade->getTotal());
        }
    }

    /**
     * Method for adding and calculating "buy" trade.
     *
     * @param Trade $trade
     */
    private function buy(Trade $trade)
    {
        if ($trade->isBaseCurrency($this->currency)) {
            $this->increaseVolume($trade->getVolume());
        } else {
            $this->decreaseVolume($trade->getTotal());
        }
    }

    /**
     * Method for increase volume of active.
     *
     * @param float $value
     */
    private function increaseVolume($value)
    {
        $this->volume += $value;
    }

    /**
     * Method for decrease volume for active.
     *
     * @param float $value
     */
    private function decreaseVolume($value)
    {
        $this->volume -= $value;
    }
}