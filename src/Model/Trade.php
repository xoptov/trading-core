<?php

namespace Xoptov\TradingCore\Model;

use DateTime;

class Trade implements TradeInterface
{
    use RateTrait;

    use TimeTrackingTrait;

    /** @var mixed */
    private $id;

    /** @var string */
    private $type;

    /**
     * AbstractTrade constructor.
     * @param mixed $id
     * @param string $type
     * @param string $price
     * @param string $volume
     * @param DateTime $createdAt
     */
    public function __construct($id, $type, $price, $volume, DateTime $createdAt)
    {
    	$this->id = $id;
        $this->type = $type;
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
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }
}