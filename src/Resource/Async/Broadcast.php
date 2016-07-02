<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\Broadcast as BaseBroadcast;
use function React\Promise\resolve;

class Broadcast extends BaseBroadcast
{
    public function refresh() : PromiseInterface
    {
        return resolve($this);
    }
}
