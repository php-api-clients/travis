<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\Resource\Async\EmptySettings;
use ApiClients\Tools\ResourceTestUtilities\AbstractEmptyResourceTest;

final class EmptySettingsTest extends AbstractEmptyResourceTest
{
    public function getSyncAsync(): string
    {
        return 'Async';
    }

    public function getClass(): string
    {
        return EmptySettings::class;
    }
}
