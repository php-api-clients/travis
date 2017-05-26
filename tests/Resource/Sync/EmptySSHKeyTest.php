<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\Resource\Sync;

use ApiClients\Client\Travis\Resource\Sync\EmptySSHKey;
use ApiClients\Tools\ResourceTestUtilities\AbstractEmptyResourceTest;

final class EmptySSHKeyTest extends AbstractEmptyResourceTest
{
    public function getSyncAsync(): string
    {
        return 'Sync';
    }

    public function getClass(): string
    {
        return EmptySSHKey::class;
    }
}
