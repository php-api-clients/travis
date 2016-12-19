<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Travis\CommandBus\Command\AccountsCommand;
use ApiClients\Client\Travis\CommandBus\Handler\AccountsHandler;
use ApiClients\Client\Travis\Resource\AccountInterface;
use ApiClients\Client\Travis\Service\FetchAndIterateService;
use ApiClients\Tools\TestUtilities\TestCase;

final class AccountsHandlerTest extends TestCase
{
    public function testBroadcasts()
    {
        $command = new AccountsCommand();
        $service = $this->prophesize(FetchAndIterateService::class);
        $service->handle('accounts', 'accounts', AccountInterface::HYDRATE_CLASS)->shouldBeCalled();
        $handler = new AccountsHandler($service->reveal());
        $handler->handle($command);
    }
}
