<?php

namespace Xoptov\TradingCore\Model;

use DateTime;

class Order
{
    use RateTrait;

    use TimeTrackingTrait;

    /** @var int */
    private $id;

    /** @var mixed */
    private $externalId;

    const TYPE_BID = "bid";
    const TYPE_ASK = "ask";

    /** @var string */
    private $type;

    /** @var Active */
    private $active;

    /** @var Currency */
    private $quote;

    const STATUS_NEW = "new";
    const STATUS_PLACE = "placed";
    const STATUS_CANCELED = "canceled";
    const STATUS_DONE = "done";

    /** @var string */
    private $status = self::STATUS_NEW;

    /** @var DateTime */
    private $updatedAt;

    /**
     * Order constructor.
     * @param int $id
     * @param mixed $externalId
     * @param string $type
     * @param Active $active
     * @param Currency $quote
     * @param float $price
     * @param float $volume
     * @param DateTime $createdAt
     */
    public function __construct($id, $externalId, $type, Active $active, Currency $quote, $price, $volume, DateTime $createdAt)
    {
    	$this->id = $id;
    	$this->externalId = $externalId;
        $this->type = $type;
        $this->active = $active;
        $this->quote = $quote;
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
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
        return $order->getExternalId() === $this->externalId;
    }

    /**
     * @return bool
     */
    public function isAsk()
    {
        return $this->type === Order::TYPE_ASK;
    }

    /**
     * @return bool
     */
    public function isBid()
    {
        return $this->type === Order::TYPE_BID;
    }
}