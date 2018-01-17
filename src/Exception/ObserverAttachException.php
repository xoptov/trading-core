<?php

namespace Xoptov\TradingCore\Exception;

use Exception;
use Throwable;
use SplObserver;
use Xoptov\TradingCore\Channel;

class ObserverAttachException extends Exception
{
	/** @var SplObserver */
	protected $observer;

	/** @var Channel */
	protected $channel;

	/**
	 * ObserverDetachException constructor.
	 *
	 * @param SplObserver $observer
	 * @param Channel $channel
	 * @param string $message
	 * @param int $code
	 * @param Throwable|null $previous
	 */
	public function __construct(SplObserver $observer, Channel $channel, $message = "", $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);

		$this->observer = $observer;
		$this->channel = $channel;
	}

	/**
	 * @return SplObserver
	 */
	public function getObserver()
	{
		return $this->observer;
	}

	/**
	 * @return Channel
	 */
	public function getChannel()
	{
		return $this->channel;
	}
}