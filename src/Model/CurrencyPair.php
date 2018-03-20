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

    /**
     * Method for retrieving symbol for base currency.
     *
     * @return null|string
     */
    public function getBaseSymbol()
    {
        if ($this->base) {
            return $this->base->getSymbol();
        }

        return null;
    }

    /**
     * Method for retrieving symbol for quote currency.
     *
     * @return null|string
     */
    public function getQuoteSymbol()
    {
        if ($this->quote) {
            return $this->quote->getSymbol();
        }

        return null;
    }
}