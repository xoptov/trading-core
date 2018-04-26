<?php

namespace Xoptov\TradingCore\Model;

use DateTime;

class Trade implements TradeInterface
{
    use RateTrait;

    use TimeTrackingTrait;

    /** @var mixed */
    protected $originId;

    /** @var CurrencyPair */
    protected $currencyPair;

    /** @var string */
    protected $type;

    /**
     * AbstractTrade constructor.
     * @param mixed $originId;
     * @param CurrencyPair $currencyPair
     * @param string $type
     * @param string $price
     * @param string $volume
     * @param DateTime $createdAt
     */
    public function __construct($originId, CurrencyPair $currencyPair, $type, $price, $volume, DateTime $createdAt)
    {
    	$this->originId = $originId;
    	$this->currencyPair = $currencyPair;
        $this->type = $type;
        $this->price = $price;
        $this->volume = $volume;
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getOriginId()
    {
        return $this->originId;
    }

    /**
     * @return CurrencyPair
     */
    public function getCurrencyPair()
    {
        return $this->currencyPair;
    }

    /**
     * @return null|string
     */
    public function getBaseSymbol()
    {
        return $this->currencyPair->getBaseSymbol();
    }

    /**
     * @return null|string
     */
    public function getQuoteSymbol()
    {
        return $this->currencyPair->getQuoteSymbol();
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Method for two trade object comparison.
     *
     * @param Trade $trade
     * @return bool
     */
    public function equal(Trade $trade)
    {
        return $trade->getOriginId() === $this->originId;
    }

    /**
     * Method for checking symbol association with.
     *
     * @param $symbol
     * @return bool
     */
    public function hasSymbol($symbol)
    {
        return $this->currencyPair->hasSymbol($symbol);
    }

    /**
     * Method return true if trade side is "sell" or return false otherwise.
     *
     * @return bool
     */
    public function isSell()
    {
        return TradeInterface::TYPE_SELL === $this->type;
    }

    /**
     * Method return true if trade side is "buy" or return false otherwise.
     *
     * @return bool
     */
    public function isBuy()
    {
        return TradeInterface::TYPE_BUY === $this->type;
    }

    /**
     * Method for checking currency base side.
     *
     * @param Currency $currency
     * @return bool
     */
    public function isBaseCurrency(Currency $currency)
    {
        return $this->currencyPair->isBase($currency);
    }

    /**
     * Method for checking currency quote side.
     *
     * @param Currency $currency
     * @return bool
     */
    public function isQuoteCurrency(Currency $currency)
    {
        return $this->currencyPair->isQuote($currency);
    }
}