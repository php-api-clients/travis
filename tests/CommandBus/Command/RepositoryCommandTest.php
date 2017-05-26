<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\CommandBus\Command;

use ApiClients\Client\Travis\CommandBus\Command\RepositoryCommand;
use ApiClients\Tools\TestUtilities\TestCase;

final class RepositoryCommandTest extends TestCase
{
    public function testRepository()
    {
        $repository = 'wyrihaximus/tactician-command-handler-mapper';
        $command = new RepositoryCommand($repository);
        self::assertSame($repository, $command->getRepository());
    }
}
