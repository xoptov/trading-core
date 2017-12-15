<?php

namespace Xoptov\TradingCore\Model;

class Currency
{
    /** @var string */
    private $symbol;

    /** @var string */
    private $name;

    /**
     * Currency constructor.
     * @param string $symbol
     * @param string $name
     */
    public function __construct($symbol, $name)
    {
        $this->symbol = $symbol;
        $this->name = $name;
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
}