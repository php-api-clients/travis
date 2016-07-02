<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use WyriHaximus\Travis\Resource\Settings as BaseSettings;

class Settings extends BaseSettings
{
    public function refresh() : Settings
    {
        return $this->wait($this->callAsync('refresh'));
    }
}
