<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\Travis\Resource\Commit as BaseCommit;

class Commit extends BaseCommit
{
    public function refresh(): Commit
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
