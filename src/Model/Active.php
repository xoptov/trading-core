<?php

namespace Xoptov\TradingCore\Model;

use LogicException;
use DeepCopy\DeepCopy;
use SplDoublyLinkedList;
use Xoptov\TradingCore\Exception\UnknownTypeException;

class Active
{
    use RateTrait;

	/** @var Currency */
	protected $currency;

    /** @var Trade[] */
    protected $trades;

    /** @var Order[] */
    protected $orders;

    /** @var DeepCopy */
    protected $copier;

	/**
	 * AbstractActive constructor.
     *
	 * @param Currency $currency
	 * @param float    $volume
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
     * This method must be call for base and quote currency.
     *
     * @param Trade $trade
     */
    public function addTrade(Trade $trade)
    {
        if (!$trade->hasSymbol($this->getSymbol())) {
            throw new LogicException("This trade unsupported by active.");
        }

        if ($trade->isType(Trade::TYPE_SELL)) {
            $this->sell($trade);
        } elseif ($trade->isType(Trade::TYPE_BUY)) {
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
            if ($order->isSide(Order::SIDE_ASK)) {
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
    public function getTotalVolume()
    {
        $total = 0.0;

        /** @var Trade $trade */
        foreach ($this->trades as $trade) {
            if ($trade->isType(Trade::TYPE_BUY)) {
                $total += $trade->getVolume();
            } else{
                $total -= $trade->getVolume();
            }
        }

        return $total;
    }

    /**
     * Method for calculating total price of active.
     *
     * @return float
     */
    public function getTotalPrice()
    {
        $total = 0.0;

        foreach ($this->trades as $trade) {
            if ($trade->isType(Trade::TYPE_BUY)) {
                $total += $trade->getTotal();
            } else {
                $total -= $trade->getTotal();
            }
        }

        return $total;
    }

    /**
     * Method for calculating weighted average price.
     *
     * @return float
     */
    public function getWeightedAveragePrice()
    {
        return $this->getTotalPrice() / $this->getTotalVolume();
    }

    /**
     * Method for calculating total buy of active.
     *
     * @return float
     */
    public function getBuyTotal()
    {
        $total = 0.0;

        foreach ($this->trades as $trade) {
            if ($trade->isType(Trade::TYPE_BUY)) {
                $total += $trade->getTotal();
            }
        }

        return $total;
    }

    /**
     * Method for calculating total sell of active.
     *
     * @return float
     */
    public function getSellTotal()
    {
        $total = 0.0;

        foreach ($this->trades as $trade) {
            if ($trade->isType(Trade::TYPE_SELL)) {
                $total += $trade->getTotal();
            }
        }

        return $total;
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
            $this->decreasePrice($trade->getTotal());
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
            $this->increasePrice($trade->getTotal());
        } else {
            $this->decreaseVolume($trade->getTotal());
        }
    }
}