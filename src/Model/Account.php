<?php

namespace Xoptov\TradingCore\Model;

class Account
{
    /** @var string */
    private $apiKey;

    /** @var Balance */
	private $balance;

	/**
	 * Account constructor.
	 */
	public function __construct($apiKey)
	{
	    $this->apiKey = $apiKey;
		$this->balance = new Balance();
	}

	/**
	 * @return Balance
	 */
	public function getBalance()
	{
		$balance = clone $this->balance;

		return $balance;
	}
}