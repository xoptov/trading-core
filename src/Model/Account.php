<?php

namespace Xoptov\TradingCore\Model;

class Account
{
    /** @var string */
    protected $key;

    /** @var Balance */
	protected $balance;

	/**
	 * Account constructor.
     * @param string $key Key for API connection.
	 */
	public function __construct($key)
	{
	    $this->key = $key;
		$this->balance = new Balance();
	}

    /**
     * Method for getting key.
     *
     * @return string
     */
	public function getKey()
    {
        return $this->key;
    }

	/**
     * Method for getting balance.
     *
	 * @return Balance
	 */
	public function getBalance()
	{
		$balance = clone $this->balance;

		return $balance;
	}

    /**
     * Method for adding active to balance.
     *
     * @param Active $active
     * @return boolean
     */
	public function addActive(Active $active)
    {
        return $this->balance->addActive($active);
    }

    /**
     * Method for adding order to balance.
     *
     * @param Order $order
     * @return boolean
     */
    public function addOrder(Order $order)
    {
        return $this->balance->addOrder($order);
    }

    /**
     * Method for adding trade to balance.
     *
     * @param Trade $trade
     * @return boolean
     */
    public function addTrade(Trade $trade)
    {
        return $this->balance->addTrade($trade);
    }
}