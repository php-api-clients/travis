<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\ApiClient\Resource\CallAsyncTrait;
use WyriHaximus\Travis\Resource\Commit as BaseCommit;

class Commit extends BaseCommit
{
    use CallAsyncTrait;

    public function refresh(): Commit
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
