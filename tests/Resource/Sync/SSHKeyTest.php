<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\Resource\Sync;

use ApiClients\Client\Travis\ApiSettings;
use ApiClients\Client\Travis\Resource\SSHKey;
use ApiClients\Tools\ResourceTestUtilities\AbstractResourceTest;

class SSHKeyTest extends AbstractResourceTest
{
    public function getSyncAsync(): string
    {
        return 'Sync';
    }

    public function getClass(): string
    {
        return SSHKey::class;
    }

    public function getNamespace(): string
    {
        return Apisettings::NAMESPACE;
    }
}
