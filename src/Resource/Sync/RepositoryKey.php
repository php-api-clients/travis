<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\Travis\Resource\RepositoryKey as BaseRepositoryKey;

class RepositoryKey extends BaseRepositoryKey
{
    /**
     * @return RepositoryKey
     */
    public function refresh() : RepositoryKey
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
