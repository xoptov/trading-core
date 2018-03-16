<?php

namespace Xoptov\TradingCore\Chart;

use DatePeriod;

abstract class AbstractPeriod
{
    /** @var DatePeriod */
    protected $period;

    /** @var float */
    protected $open;

    /** @var float */
    protected $close;

    /** @var float */
    protected $high;

    /** @var float */
    protected $low;

    /**
     * AbstractPeriod constructor.
     * @param float $open
     * @param float $close
     * @param float $high
     * @param float $low
     * @param DatePeriod $period
     */
    public function __construct($open, $close, $high, $low, DatePeriod $period)
    {
        $this->open = $open;
        $this->close = $close;
        $this->high = $high;
        $this->low = $low;
        $this->period = $period;
    }

    /**
     * @return float
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * @return float
     */
    public function getClose()
    {
        return $this->close;
    }

    /**
     * @return float
     */
    public function getHigh()
    {
        return $this->high;
    }

    /**
     * @return float
     */
    public function getLow()
    {
        return $this->low;
    }

    /**
     * @return DatePeriod
     */
    public function getPeriod()
    {
        $period = clone $this->period;

        return $period;
    }
}