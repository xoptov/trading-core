<?php

namespace Xoptov\TradingCore\Response\Currencies;

use Xoptov\TradingCore\Model\Currency as OriginCurrency;

class Currency extends OriginCurrency
{
	/** @var boolean */
	private $enabled;

	/**
	 * Currency constructor.
	 * {@inheritdoc}
	 * @param boolean $enabled
	 */
	public function __construct($symbol, $name, $enabled)
	{
		parent::__construct($symbol, $name);

		$this->enabled = $enabled;
	}

	/**
	 * @return bool
	 */
	public function isEnabled()
	{
		return $this->enabled;
	}
}