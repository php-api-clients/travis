<?php declare(strict_types=1);

namespace WyriHaximus\Tests\Travis\Resource\Sync;

use ApiClients\Tools\ResourceTestUtilities\AbstractResourceTest;
use WyriHaximus\Travis\ApiSettings;
use WyriHaximus\Travis\Resource\Branch;

class BranchTest extends AbstractResourceTest
{
    public function getSyncAsync() : string
    {
        return 'Sync';
    }
    public function getClass() : string
    {
        return Branch::class;
    }
    public function getNamespace() : string
    {
        return Apisettings::NAMESPACE;
    }
}
