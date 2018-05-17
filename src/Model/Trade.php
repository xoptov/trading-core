<?php

namespace Xoptov\TradingCore\Model;

use DateTime;
use RuntimeException;

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

    const TYPE_SELL = "sell";
    const TYPE_BUY = "buy";

    /** @var array */
    protected $supportedTypes = array(
        self::TYPE_SELL,
        self::TYPE_BUY
    );

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
        if (!$this->isSupportType($type)) {
            throw new RuntimeException("Type is not support.");
        }

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
     * Method for checking type.
     *
     * @param string $type
     * @return bool
     */
    public function isType($type)
    {
        return $this->getType() === $type;
    }

    /**
     * Method for checking supported type.
     *
     * @param string $type
     * @return bool
     */
    public function isSupportType($type)
    {
        return in_array($type, $this->supportedTypes);
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