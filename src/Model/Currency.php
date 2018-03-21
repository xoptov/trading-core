<?php

namespace Xoptov\TradingCore\Model;

class Currency
{
    /** @var int */
    private $id;

    /** @var string */
    private $symbol;

    /** @var string */
    private $name;

    /**
     * Currency constructor.
     *
     * @param int $id
     * @param string $symbol
     * @param string $name
     */
    public function __construct($id, $symbol, $name)
    {
        $this->id = $id;
        $this->symbol = $symbol;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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