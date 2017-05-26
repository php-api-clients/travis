<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\Resource\Sync;

use ApiClients\Client\Travis\ApiSettings;
use ApiClients\Client\Travis\Resource\Branch;
use ApiClients\Tools\ResourceTestUtilities\AbstractResourceTest;

class BranchTest extends AbstractResourceTest
{
    public function getSyncAsync(): string
    {
        return 'Sync';
    }

    public function getClass(): string
    {
        return Branch::class;
    }

    public function getNamespace(): string
    {
        return Apisettings::NAMESPACE;
    }
}
