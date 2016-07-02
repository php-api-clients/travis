<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use WyriHaximus\ApiClient\Resource\TransportAwareTrait;

abstract class Hook implements HookInterface
{
    use TransportAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var bool
     */
    protected $active;

    /**
     * @return int
     */
    public function id() : int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function active() : bool
    {
        return $this->active;
    }
}
