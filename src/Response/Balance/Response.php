<?php

namespace Xoptov\TradingCore\Response\Balance;

use SplDoublyLinkedList;
use Xoptov\TradingCore\Model\Active;
use Xoptov\TradingCore\Model\Currency;

class Response
{
	/** @var SplDoublyLinkedList */
	private $actives;

    /**
     * Response constructor.
     */
	public function __construct()
    {
        $this->actives = new SplDoublyLinkedList();
    }

    /**
	 * @return SplDoublyLinkedList
	 */
	public function getActives()
	{
		$actives = new SplDoublyLinkedList();

		foreach ($this->actives as $active) {
			$actives->push(clone $active);
		}

		return $actives;
	}

	/**
	 * @param Currency $currency
	 * @param float $volume
	 */
	public function addActive(Currency $currency, $volume)
	{
		$this->actives->push(new Active($currency, $volume));
	}
}