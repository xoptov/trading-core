<?php

namespace Xoptov\TradingCore\Model;

trait RateTrait
{
    /** @var float */
    protected $price = 0.0;

    /** @var float */
    protected $volume = 0.0;

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return float
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->price * $this->volume;
    }

    /**
     * @param float $value
     */
    public function increasePrice($value)
    {
        $this->price += $value;
    }

    /**
     * @param float $value
     */
    public function decreasePrice($value)
    {
        $this->price -= $value;
    }

    /**
     * @param $value
     */
    public function increaseVolume($value)
    {
        $this->volume += $value;
    }

    /**
     * @param $value
     */
    public function decreaseVolume($value)
    {
        $this->volume -= $value;
    }
}