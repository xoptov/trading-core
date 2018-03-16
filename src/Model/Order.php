<?php

namespace Xoptov\TradingCore\Model;

use DateTime;

class Order
{
    use RateTrait;

    use TimeTrackingTrait;

    /** @var mixed */
    private $id;

    const TYPE_BID = "bid";
    const TYPE_ASK = "ask";

    /** @var string */
    private $type;

    /** @var Active */
    private $active;

    /** @var Currency */
    private $currency;

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
     * @param mixed $id
     * @param string $type
     * @param Active $active
     * @param Currency $currency
     * @param float $price
     * @param float $volume
     * @param DateTime $createdAt
     */
    public function __construct($id, $type, Active $active, Currency $currency, $price, $volume, DateTime $createdAt)
    {
    	$this->id = $id;
        $this->type = $type;
        $this->active = $active;
        $this->currency = $currency;
        $this->price = $price;
        $this->volume = $volume;
        $this->createdAt = $createdAt;
    }

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
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
    public function getCurrency()
    {
        return $this->currency;
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
}