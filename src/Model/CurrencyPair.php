<?php

namespace Xoptov\TradingCore\Model;

class CurrencyPair
{
    /** @var Currency */
    private $base;

    /** @var Currency */
    private $quote;

    /**
     * CurrencyPair constructor.
     * @param Currency $base
     * @param Currency $quote
     */
    public function __construct(Currency $base, Currency $quote)
    {
        $this->base = $base;
        $this->quote = $quote;
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