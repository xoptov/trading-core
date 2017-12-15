<?php

namespace Xoptov\TradingCore\Response\CurrencyPairs;

use SplDoublyLinkedList;
use Xoptov\TradingCore\Model\Currency;
use Xoptov\TradingCore\Model\CurrencyPair;

class Response
{
	/** @var SplDoublyLinkedList */
	private $currencyPairs;

    /**
     * Response constructor.
     */
	public function __construct()
    {
        $this->currencyPairs = new SplDoublyLinkedList();
    }

    /**
	 * @return SplDoublyLinkedList
	 */
	public function getCurrencyPairs()
	{
		$currencyPairs = new SplDoublyLinkedList();

		foreach ($this->currencyPairs as $currencyPair) {
			$currencyPairs->push(clone $currencyPair);
		}

		return $currencyPairs;
	}

	/**
	 * @param Currency $base
	 * @param Currency $quote
	 */
	public function addCurrencyPair(Currency $base, Currency $quote)
	{
		$this->currencyPairs->push(new CurrencyPair($base, $quote));
	}
}