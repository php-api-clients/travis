<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\ApiSettings;
use ApiClients\Client\Travis\Resource\Annotation;
use ApiClients\Tools\ResourceTestUtilities\AbstractResourceTest;

class AnnotationTest extends AbstractResourceTest
{
    public function getSyncAsync(): string
    {
        return 'Async';
    }

    public function getClass(): string
    {
        return Annotation::class;
    }

    public function getNamespace(): string
    {
        return Apisettings::NAMESPACE;
    }
}
