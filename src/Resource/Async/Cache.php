<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use WyriHaximus\Travis\Resource\Cache as BaseCache;

class Cache extends BaseCache
{
    public function refresh() : Cache
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
