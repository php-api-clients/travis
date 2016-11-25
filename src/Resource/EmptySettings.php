<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use ApiClients\Foundation\Resource\EmptyResourceInterface;

abstract class EmptySettings implements SettingsInterface, EmptyResourceInterface
{
    /**
     * @return bool
     */
    public function buildsOnlyWithTravisYml() : bool
    {
        return null;
    }

    /**
     * @return bool
     */
    public function buildPushes() : bool
    {
        return null;
    }

    /**
     * @return bool
     */
    public function buildPullRequests() : bool
    {
        return null;
    }

    /**
     * @return int
     */
    public function maximumNumberOfBuilds() : int
    {
        return null;
    }
}
