<?php

namespace Xoptov\TradingCore\Response\MarketData;

use DatePeriod;
use Xoptov\TradingCore\Chart\AbstractPeriod;

class Data extends AbstractPeriod
{
    /** @var float */
    private $baseVolume;

    /** @var float */
    private $quoteVolume;

    /** @var float */
    private $weightedAverage;

    /**
     * Data constructor.
     * {@inheritdoc}
     * @param float $baseVolume
     * @param float $quoteVolume
     * @param float $weightedAverage
     */
    public function __construct($open, $close, $high, $low, DatePeriod $period, $baseVolume, $quoteVolume, $weightedAverage)
    {
        parent::__construct($open, $close, $high, $low, $period);

        $this->baseVolume = $baseVolume;
        $this->quoteVolume = $quoteVolume;
        $this->weightedAverage = $weightedAverage;
    }

    /**
     * @return float
     */
    public function getBaseVolume()
    {
        return $this->baseVolume;
    }

    /**
     * @return float
     */
    public function getQuoteVolume()
    {
        return $this->quoteVolume;
    }

    /**
     * @return float
     */
    public function getWeightedAverage()
    {
        return $this->weightedAverage;
    }
}