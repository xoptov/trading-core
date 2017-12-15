<?php

namespace Xoptov\TradingCore\Response\OpenOrders;

use SplDoublyLinkedList;

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
	 * @param float $price
	 * @param float $volume
	 * @return int
	 */
	public function addOrder($id, $price, $volume)
	{
		$this->orders->push(new Order($id, $price, $volume));
	}
}