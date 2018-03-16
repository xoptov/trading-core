<?php

namespace Xoptov\TradingCore\Model;

use LogicException;
use Xoptov\TradingCore\Exception\UnknownTypeException;

class Active
{
	/** @var Currency */
	private $currency;

	/** @var float */
    private $price;

    /** @var float */
    private $volume;

    /** @var Trade[] */
    private $trades = array();

    /** @var Order[] Open orders with this active */
    private $orders = array();

	/**
	 * AbstractActive constructor.
	 * @param Currency $currency
	 * @param float $volume
	 */
	public function __construct(Currency $currency, $volume)
	{
		$this->currency = $currency;
		$this->volume = $volume;
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
        array_push($this->trades, $trade);

        if ($trade->getType() === Trade::TYPE_SELL) {
            $this->volume -= $trade->getVolume();
        } elseif ($trade->getType() === Trade::TYPE_BUY) {
            $this->volume += $trade->getVolume();

            $totals = array_map(function(Trade $trade) {
                return array(
                    "rate" => $trade->getPrice(),
                    "volume" => $trade->getVolume()
                );
            }, $this->trades);

            $rates = array_sum(array_column($totals, "rate"));
            $volumes = array_sum(array_column($totals, "volume"));

            $this->price = $rates / $volumes;
        } else {
            throw new UnknownTypeException("Trade type must be set.");
        }
    }

    /**
     * @return Trade[]
     */
    public function getTrades()
    {
        $trades = array();

        foreach ($this->trades as $trade) {
            $trades[] = clone $trade;
        }

        return $trades;
    }

    /**
     * @param Order $order
     */
    public function addOrder(Order $order)
    {
        if ($order->getActive() !== $this) {
            throw new LogicException("Active in order and this active must be the same.");
        }

        array_push($this->orders, $order);
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
     * @return float
     */
    public function getVolumeInOrders()
    {
        $volume = 0.0;

        array_walk($this->orders, function(Order $order, $key, &$volume) {
            if ($order->getType() === Order::TYPE_ASK) {
                $volume += $order->getVolume();
            }
        }, $volume);

        return $volume;
    }

    /**
     * @return float
     */
    public function getAvailableVolume()
    {
        return $this->volume - $this->getVolumeInOrders();
    }
}