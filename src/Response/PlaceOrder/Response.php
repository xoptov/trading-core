<?php

namespace Xoptov\TradingCore\Response\PlaceOrder;

use DateTime;
use SplDoublyLinkedList;
use Xoptov\TradingCore\Model\Trade;

class Response
{
	/** @var string */
	private $orderId;

	/** @var SplDoublyLinkedList */
	private $trades;

	/**
	 * Response constructor.
	 * @param $orderId
	 */
	public function __construct($orderId)
	{
		$this->orderId;
		$this->trades = new SplDoublyLinkedList();
	}

	/**
	 * @return string
	 */
	public function getOrderId()
	{
		return $this->orderId;
	}

	/**
	 * @return SplDoublyLinkedList
	 */
	public function getTrades()
	{
		$trades = new SplDoublyLinkedList();

		foreach ($this->trades as $trade) {
			$trades->push(clone $trade);
		}

		return $trades;
	}

	/**
	 * @param mixed $id
	 * @param string $type
	 * @param float $price
	 * @param float $volume
	 * @param DateTime $createdAt
	 */
	public function addTrade($id, $type, $price, $volume, DateTime $createdAt)
	{
		$this->trades->push(new Trade($id, $type, $price, $volume, $createdAt));
	}
}