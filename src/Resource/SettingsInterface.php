<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use WyriHaximus\ApiClient\Resource\ResourceInterface;

interface SettingsInterface extends ResourceInterface
{
    /**
     * @return bool
     */
    public function buildsOnlyWithTravisYml() : bool;

    /**
     * @return bool
     */
    public function buildPushes() : bool;

    /**
     * @return bool
     */
    public function buildPullRequests() : bool;

    /**
     * @return int
     */
    public function maximumNumberOfBuilds() : int;
}
