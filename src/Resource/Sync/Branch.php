<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\Travis\Resource\Branch as BaseBranch;

class Branch extends BaseBranch
{
    /**
     * @return Branch
     */
    public function refresh() : Branch
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
