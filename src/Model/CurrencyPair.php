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

    /**
     * Method for checking symbol in this pair.
     *
     * @param string $symbol
     * @return bool
     */
    public function hasSymbol($symbol)
    {
        if (!$this->isValid()) {
            return false;
        }

        if ($this->base->getSymbol() === $symbol || $this->quote->getSymbol() === $symbol) {
            return true;
        }

        return false;
    }

    /**
     * Method for validation pair.
     *
     * @return bool
     */
    public function isValid()
    {
        if ($this->base && $this->quote) {
            return true;
        }

        return false;
    }

    /**
     * Method for checking currency side.
     *
     * @param Currency $currency
     * @return bool
     */
    public function isBase(Currency $currency)
    {
        return $this->base->equal($currency);
    }

    /**
     * Method for checking currency side.
     *
     * @param Currency $currency
     * @return bool
     */
    public function isQuote(Currency $currency)
    {
        return $this->quote->equal($currency);
    }
}