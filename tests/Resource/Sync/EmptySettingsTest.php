<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\Resource\Sync;

use ApiClients\Client\Travis\Resource\Sync\EmptySettings;
use ApiClients\Tools\ResourceTestUtilities\AbstractEmptyResourceTest;

final class EmptySettingsTest extends AbstractEmptyResourceTest
{
    public function getSyncAsync(): string
    {
        return 'Sync';
    }

    public function getClass(): string
    {
        return EmptySettings::class;
    }
}
