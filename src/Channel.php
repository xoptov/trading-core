<?php

namespace Xoptov\TradingCore;

use SplSubject;
use SplObserver;
use DeepCopy\DeepCopy;
use SplDoublyLinkedList;
use Xoptov\TradingCore\Exception\ObserverDetachException;
use Xoptov\TradingCore\Model\CurrencyPair;
use Xoptov\TradingCore\Exception\ObserverAttachException;

class Channel implements SplSubject
{
    /** @var CurrencyPair */
    private $currencyPair;

	/** @var string */
	private $event;

	/** @var SplDoublyLinkedList */
	private $subscribers;

	/** @var mixed */
	private $message;

	/** @var DeepCopy */
	private $copier;

	/**
	 * Channel constructor.
	 *
     * @param CurrencyPair $currencyPair
	 * @param string $event
	 */
	public function __construct(CurrencyPair $currencyPair, $event)
	{
	    $this->currencyPair = $currencyPair;
		$this->event = $event;
		$this->copier = new DeepCopy();
		$this->subscribers = new SplDoublyLinkedList();
	}

	/**
	 * @param SplObserver $observer
	 *
	 * @return bool
	 */
	public function attach(SplObserver $observer)
	{
		if ($this->subscribers->isEmpty()) {
			$this->subscribers->push($observer);
		}

		foreach ($this->subscribers as $subscriber) {
			if ($subscriber === $observer) {
				return false;
			}
		}

		$this->subscribers->push($observer);

		return true;
	}

	/**
	 * @param SplObserver $observer
	 *
	 * @return bool
	 */
	public function detach(SplObserver $observer)
	{
		foreach ($this->subscribers as $key => $subscriber) {
			if ($subscriber === $observer) {
				$this->subscribers->offsetUnset($key);

				return true;
			}
		}

		return false;
	}

	public function notify()
	{
		/** @var SplObserver $subscriber */
		foreach ($this->subscribers as $subscriber) {
			$subscriber->update($this);
		}
	}

	/**
	 * @param $message
	 */
	public function setMessage($message)
	{
		$this->message = $message;
	}

	/**
	 * @return mixed|null
	 */
	public function getMessage()
	{
		if ($this->message) {
			return $this->copier->copy($this->message);
		}

		return null;
	}

	public function flushMessage()
	{
		$this->message = null;
	}

	/**
	 * @return CurrencyPair
	 */
	public function getCurrencyPairId()
	{
		return $this->currencyPair->getId();
	}

	/**
	 * @return string
	 */
	public function getEvent()
	{
		return $this->event;
	}

	/**
	 * @return int
	 */
	public function getSubscribersCount()
	{
		return $this->subscribers->count();
	}
}