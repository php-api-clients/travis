<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\ApiSettings;
use ApiClients\Client\Travis\Resource\Settings;
use ApiClients\Tools\ResourceTestUtilities\AbstractResourceTest;

class SettingsTest extends AbstractResourceTest
{
    public function getSyncAsync(): string
    {
        return 'Async';
    }

    public function getClass(): string
    {
        return Settings::class;
    }

    public function getNamespace(): string
    {
        return Apisettings::NAMESPACE;
    }
}
