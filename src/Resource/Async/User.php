<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\RequestCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\SimpleRequestCommand;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\User as BaseUser;
use function React\Promise\resolve;

class User extends BaseUser
{
    /**
     * @return PromiseInterface
     */
    public function refresh() : PromiseInterface
    {
        return $this->handleCommand(
            new SimpleRequestCommand('users/' . $this->id())
        )->then(function (ResponseInterface $response) {
            return resolve($this->handleCommand(new HydrateCommand('User', $response->getBody()->getJson()['user'])));
        });
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
