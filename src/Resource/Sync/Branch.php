<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\Travis\Resource\Branch as BaseBranch;

class Branch extends BaseBranch
{
    public function refresh() : Branch
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
