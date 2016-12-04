<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use ApiClients\Foundation\Hydrator\Annotations\EmptyResource;
use ApiClients\Foundation\Resource\AbstractResource;

/**
 * @EmptyResource("EmptyHook")
 */
abstract class Hook extends AbstractResource implements HookInterface
{
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
