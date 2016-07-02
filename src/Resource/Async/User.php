<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use GuzzleHttp\Psr7\Request;
use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\User as BaseUser;

class User extends BaseUser
{
    public function refresh() : User
    {
        return $this->wait($this->callAsync('refresh'));
    }

    public function sync(): PromiseInterface
    {
        return $this->getTransport()->requestPsr7(
            new Request(
                'POST',
                $this->getTransport()->getBaseURL() . 'users/sync',
                $this->getTransport()->getHeaders()
            )
        )->then(function () {
            return $this->refresh();
        });
    }
}
