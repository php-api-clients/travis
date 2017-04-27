<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Hydrator\Annotation\EmptyResource;
use ApiClients\Foundation\Resource\AbstractResource;

/**
 * @EmptyResource("EmptyLogLine")
 */
abstract class LogLine extends AbstractResource implements LogLineInterface
{
    /**
     * @var int
     */
    protected $id;

    // @codingStandardsIgnoreStart
    /**
     * @var string
     */
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
}
