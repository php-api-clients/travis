<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\Travis\Resource\Hook as BaseHook;

class Hook extends BaseHook
{
    /**
     * @return Hook
     */
    public function refresh() : Hook
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
