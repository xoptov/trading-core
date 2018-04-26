<?php

namespace Xoptov\TradingCore\Model;

class Currency
{
    /** @var int */
    protected $originId;

    /** @var string */
    protected $symbol;

    /** @var string */
    protected $name;

    /**
     * Currency constructor.
     *
     * @param mixed $originId
     * @param string $symbol
     * @param string $name
     */
    public function __construct($originId, $symbol, $name)
    {
        $this->originId = $originId;
        $this->symbol = $symbol;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getOriginId()
    {
        return $this->originId;
    }

    /**
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Currency $currency
     *
     * @return bool
     */
    public function equal(Currency $currency)
    {
        return $currency->getSymbol() === $this->symbol;
    }
}