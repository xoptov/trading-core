<?php

namespace Xoptov\TradingCore\Model;

interface TradeInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @param string $type
     * @return bool
     */
    public function isType($type);

    /**
     * @return float
     */
    public function getPrice();

    /**
     * @return float
     */
    public function getVolume();

    /**
     * @return float
     */
    public function getTotal();

    /**
     * @return \DateTime
     */
    public function getCreatedAt();
}