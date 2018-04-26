<?php

namespace Xoptov\TradingCore\Model;

class CurrencyPair
{
	/** @var mixed */
	protected $originId;

    /** @var Currency */
    protected $base;

    /** @var Currency */
    protected $quote;

    /**
     * CurrencyPair constructor.
     *
     * @param mixed $originId
     * @param Currency $base
     * @param Currency $quote
     */
    public function __construct($originId, Currency $base, Currency $quote)
    {
    	$this->originId = $originId;
        $this->base = $base;
        $this->quote = $quote;
    }

    /**
	 * @return mixed
	 */
    public function getOriginId()
    {
    	return $this->originId;
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
     * Method for retrieving currency pair symbol.
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->getBaseSymbol() . $this->getQuoteSymbol();
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

    /**
     * Method for retrieving symbols as array.
     *
     * @return array|null
     */
    public function getCurrencySymbols()
    {
        if ($this->isValid()) {
            return [$this->getBaseSymbol(), $this->getQuoteSymbol()];
        }

        return null;
    }

    /**
     * Method for retrieving currencies as array.
     *
     * @return array|null
     */
    public function getCurrencies()
    {
        if ($this->isValid()) {
            return [$this->base, $this->quote];
        }

        return null;
    }

    /**
     * Method for compare two currency pairs.
     *
     * @param CurrencyPair $currencyPair
     * @return bool
     */
    public function equals(CurrencyPair $currencyPair)
    {
        return $this->getSymbol() === $currencyPair->getSymbol();
    }
}