<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\Resource\Sync;

use ApiClients\Client\Travis\ApiSettings;
use ApiClients\Client\Travis\Resource\LogLine;
use ApiClients\Tools\ResourceTestUtilities\AbstractResourceTest;

class LogLineTest extends AbstractResourceTest
{
    public function getSyncAsync(): string
    {
        return 'Sync';
    }

    public function getClass(): string
    {
        return LogLine::class;
    }

    public function getNamespace(): string
    {
        return Apisettings::NAMESPACE;
    }
}
