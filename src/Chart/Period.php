<?php

namespace Xoptov\TradingCore\Chart;

use Xoptov\TradingCore\Model\Trade;

class Period extends AbstractPeriod
{
    /** @var Trade[] */
    private $trades;

    /**
     * Period constructor.
     * {@inheritdoc}
     * @param Trade[] $trades
     */
    public function __construct($open, $close, $high, $low, \DatePeriod $period, array $trades)
    {
        parent::__construct($open, $close, $high, $low, $period);

        $this->trades = $trades;
    }
}