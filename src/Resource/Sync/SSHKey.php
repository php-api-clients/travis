<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\Travis\Resource\SSHKey as BaseSSHKey;

class SSHKey extends BaseSSHKey
{
    /**
     * @return SSHKey
     */
    public function refresh() : SSHKey
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
