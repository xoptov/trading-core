<?php

namespace Xoptov\TradingCore\Model;

use DateTime;

class Trade implements TradeInterface
{
    use RateTrait;

    use TimeTrackingTrait;

    /** @var int */
    protected $id;

    /** @var mixed */
    protected $externalId;

    /** @var CurrencyPair */
    protected $currencyPair;

    /** @var string */
    protected $type;

    /**
     * AbstractTrade constructor.
     * @param int $id
     * @param mixed $externalId;
     * @param CurrencyPair $currencyPair
     * @param string $type
     * @param string $price
     * @param string $volume
     * @param DateTime $createdAt
     */
    public function __construct($id, $externalId, CurrencyPair $currencyPair, $type, $price, $volume, DateTime $createdAt)
    {
    	$this->id = $id;
    	$this->externalId = $externalId;
    	$this->currencyPair = $currencyPair;
        $this->type = $type;
        $this->price = $price;
        $this->volume = $volume;
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getId()
    {
		return $this->id;
    }

    /**
     * @return mixed
     */
    public function getExternalId()
    {
        return $this->externalId;
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
        return $trade->getExternalId() === $this->externalId;
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
        return Trade::TYPE_SELL === $this->type;
    }

    /**
     * Method return true if trade side is "buy" or return false otherwise.
     *
     * @return bool
     */
    public function isBuy()
    {
        return Trade::TYPE_BUY === $this->type;
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