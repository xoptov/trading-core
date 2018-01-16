<?php

namespace Xoptov\TradingCore\Model;

class CurrencyPair
{
	/** @var mixed */
	private $id;

    /** @var Currency */
    private $base;

    /** @var Currency */
    private $quote;

    /**
     * CurrencyPair constructor.
     *
     * @param integer $id
     * @param Currency $base
     * @param Currency $quote
     */
    public function __construct($id, Currency $base, Currency $quote)
    {
    	$this->id = $id;
        $this->base = $base;
        $this->quote = $quote;
    }

	/**
	 * @return mixed
	 */
    public function getId()
    {
    	return $this->id;
    }

    /**
     * @return Currency
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * @return Currency
     */
    public function getQuote()
    {
        return $this->quote;
    }
}