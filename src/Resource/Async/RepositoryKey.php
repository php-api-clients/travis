<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use WyriHaximus\Travis\Resource\RepositoryKey as BaseRepositoryKey;

class RepositoryKey extends BaseRepositoryKey
{
    public function refresh() : RepositoryKey
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
