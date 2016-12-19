<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\CommandBus\Command\UserCommand;
use ApiClients\Client\Travis\Resource\User as BaseUser;
use ApiClients\Foundation\Transport\CommandBus\Command\RequestCommand;
use GuzzleHttp\Psr7\Request;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;

class User extends BaseUser
{
    /**
     * @return PromiseInterface
     */
    public function refresh() : PromiseInterface
    {
        return $this->handleCommand(
            new UserCommand()
        );
    }

    /**
     * @return PromiseInterface
     */
    public function sync(): PromiseInterface
    {
        return $this->handleCommand(new RequestCommand(
            new Request(
                'POST',
                'users/sync'
            )
        ))->then(function () {
            return $this->refresh();
        });
    }
}
