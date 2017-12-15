<?php

namespace Xoptov\TradingCore\Model;

interface TradeInterface
{
    const TYPE_BUY = "buy";
    const TYPE_SELL = "sell";

    /**
     * @return string
     */
    public function getType();
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