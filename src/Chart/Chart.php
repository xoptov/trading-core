<?php

namespace Xoptov\TradingCore\Chart;

use DatePeriod;

class Chart
{
    /** @var DatePeriod */
    private $period;

    /** @var AbstractPeriod[] */
    private $periods = array();
}