<?php

namespace Xoptov\TradingCore\Response\OpenOrders;

use DateTime;
use SplDoublyLinkedList;
use Xoptov\TradingCore\Model\Order;
use Xoptov\TradingCore\Model\Active;
use Xoptov\TradingCore\Model\Currency;

class Response
{
	/** @var SplDoublyLinkedList */
	private $orders;

    /**
     * Response constructor.
     */
	public function __construct()
    {
        $this->orders = new SplDoublyLinkedList();
    }

    /**
	 * @return SplDoublyLinkedList
	 */
	public function getOrders()
	{
		$orders = new SplDoublyLinkedList();

		foreach ($this->orders as $order) {
			$orders->push(clone $order);
		}

		return $orders;
	}

	/**
	 * @param string $id
     * @param string $type
     * @param Active $active
     * @param Currency $currency
     * @param float $price
     * @param float $volume
     * @param DateTime $createdAt
	 */
	public function addOrder($id, $type, Active $active, Currency $currency, $price, $volume, DateTime $createdAt)
	{
		$this->orders->push(new Order($id, $type, $active, $currency, $price, $volume, $createdAt));
	}
}