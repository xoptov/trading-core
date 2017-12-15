<?php

namespace Xoptov\TradingCore\Response\Currencies;

use SplDoublyLinkedList;

class Response
{
	/** @var SplDoublyLinkedList */
	private $currencies;

    /**
     * Response constructor.
     */
	public function __construct()
    {
        $this->currencies = new SplDoublyLinkedList();
    }

    /**
	 * @return SplDoublyLinkedList
	 */
	public function getCurrencies()
	{
		$currencies = new SplDoublyLinkedList();

		foreach ($this->currencies as $currency) {
			$currencies->push(clone $currency);
		}

		return $currencies;
	}

    /**
     * @param string $symbol
     * @param string $name
     * @param boolean $enabled
     */
	public function addCurrency($symbol, $name, $enabled)
	{
		$this->currencies->push(new Currency($symbol, $name, $enabled));
	}
}