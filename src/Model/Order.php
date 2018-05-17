<?php

namespace Xoptov\TradingCore\Model;

use DateTime;
use RuntimeException;

class Order
{
    use RateTrait;

    use TimeTrackingTrait;

    /** @var mixed */
    protected $originId;

    const SIDE_ASK = "ask";
    const SIDE_BID = "bid";

    /** @var array */
    protected $supportedSides = array(
        self::SIDE_ASK,
        self::SIDE_BID
    );

    /** @var string */
    protected $side;

    /** @var Active */
    protected $active;

    /** @var Currency */
    protected $quote;

    /** @var string */
    protected $status;

    /** @var DateTime */
    protected $updatedAt;

    /**
     * Order constructor.
     *
     * @param mixed $originId
     * @param string $side
     * @param Active $active
     * @param Currency $quote
     * @param float $price
     * @param float $volume
     * @param DateTime $createdAt
     */
    public function __construct($originId, $side, Active $active, Currency $quote, $price, $volume, $status, DateTime $createdAt)
    {
        if (!$this->isSupportSide($side)) {
            throw new RuntimeException("Specified side is not supported.");
        }

    	$this->originId = $originId;
        $this->side = $side;
        $this->active = $active;
        $this->quote = $quote;
        $this->price = $price;
        $this->volume = $volume;
        $this->status = $status;
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
     * @return string
     */
    public function getSide()
    {
        return $this->side;
    }

    /**
     * @return Active
     */
    public function getActive()
    {
        $active = clone $this->active;

        return $active;
    }

    /**
     * @return Currency
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * @param string $status
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param DateTime $updatedAt
     * @return Order
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        $updatedAt = clone $this->updatedAt;

        return $updatedAt;
    }

    /**
     * Method for two order object comparison.
     *
     * @param Order $order
     * @return bool
     */
    public function equal(Order $order)
    {
        return $order->getOriginId() === $this->originId;
    }

    /**
     * Method for checking equivalent side.
     *
     * @param string $side
     * @return bool
     */
    public function isSide($side)
    {
        return $this->getSide() === $side;
    }

    /**
     * Method for checking support of side.
     *
     * @param string $side
     * @return bool
     */
    public function isSupportSide($side)
    {
        return in_array($side, $this->supportedSides);
    }
}