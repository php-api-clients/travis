<?php

namespace WyriHaximus\Travis\Resource;

use ApiClients\Foundation\Resource\TransportAwareTrait;

abstract class LogLine implements LogLineInterface
{
    use TransportAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    // @codingStandardsIgnoreStart
    protected $_log;
    // @codingStandardsIgnoreEnd

    /**
     * @var int
     */
    protected $number;

    /**
     * @var bool
     */
    protected $final;

    /**
     * @return int
     */
    public function id() : int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function log() : string
    {
        return $this->_log;
    }

    /**
     * @return int
     */
    public function number() : int
    {
        return $this->number;
    }

    /**
     * @return bool
     */
    public function final() : bool
    {
        return $this->final;
    }

    public function refresh()
    {
        throw new \Exception();
    }
}
