<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\Travis\Resource\Settings as BaseSettings;

class Settings extends BaseSettings
{
    /**
     * @return Settings
     */
    public function refresh() : Settings
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
