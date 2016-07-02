<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\Travis\Resource\Broadcast as BaseBroadcast;

class Broadcast extends BaseBroadcast
{
    public function refresh() : Broadcast
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
