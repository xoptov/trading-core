<?php

namespace Xoptov\TradingCore\Model;

trait TimeTrackingTrait
{
    /** @var \DateTime */
    protected $createdAt;

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        $createdAt = clone $this->createdAt;

        return $createdAt;
    }
}