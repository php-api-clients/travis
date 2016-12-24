<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\AnnotationsCommand;
use ApiClients\Client\Travis\CommandBus\Handler\AnnotationsHandler;
use ApiClients\Client\Travis\Resource\AnnotationInterface;
use ApiClients\Tools\Services\Client\FetchAndIterateService;
use ApiClients\Tools\TestUtilities\TestCase;

final class AnnotationsHandlerTest extends TestCase
{
    public function testBroadcasts()
    {
        $command = new AnnotationsCommand(123);
        $service = $this->prophesize(FetchAndIterateService::class);
        $service->handle('jobs/123/annotations', 'annotations', AnnotationInterface::HYDRATE_CLASS)->shouldBeCalled();
        $handler = new AnnotationsHandler($service->reveal());
        $handler->handle($command);
    }
}
