<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;
use WyriHaximus\Travis\Resource\Settings as BaseSettings;
use WyriHaximus\Travis\Resource\SettingsInterface;

class Settings extends BaseSettings
{
    public function refresh() : Settings
    {
        return $this->wait($this->handleCommand(
            new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
        )->then(function (SettingsInterface $settings) {
            return $settings->refresh();
        }));
    }
}
