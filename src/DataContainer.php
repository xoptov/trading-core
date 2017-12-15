<?php

namespace Xoptov\TradingCore;

use DateTime;
use DeepCopy\DeepCopy;

class DataContainer
{
    /** @var int */
    private $ttl;

    /** @var mixed */
    private $data;

    /** @var DateTime */
    private $expireAt;

    /** @var DeepCopy */
    private $copier;

    /**
     * DataContainer constructor.
     * @param int $ttl How long core stay fresh in seconds.
     */
    public function __construct($ttl = 60)
    {
        $this->ttl = $ttl;
        $this->copier = new DeepCopy();
    }

    /**
     * @param mixed $data
     * @return DataContainer
     */
    public function setData($data)
    {
        $this->data = $data;
        $this->expireAt = new DateTime("+{$this->ttl} second");

        return $this;
    }

    /**
     * @param bool $copy Return deep copy of core or return origin object.
     * @return mixed|null
     */
    public function getData($copy = true)
    {
        if ($this->isFresh()) {
            if ($copy) {
                return $this->copier->copy($this->data);
            }
            return $this->data;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isFresh()
    {
        $now = new DateTime();

        if (empty($this->data) || empty($this->expireAt) || $now > $this->expireAt) {
            return false;
        }

        return true;
    }
}