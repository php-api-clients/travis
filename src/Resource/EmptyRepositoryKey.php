<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use ApiClients\Foundation\Resource\EmptyResourceInterface;

abstract class EmptyRepositoryKey implements RepositoryKeyInterface, EmptyResourceInterface
{
    /**
     * @return string
     */
    public function key() : string
    {
        return null;
    }

    /**
     * @return string
     */
    public function fingerprint() : string
    {
        return null;
    }
}
