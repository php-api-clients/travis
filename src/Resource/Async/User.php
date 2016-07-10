<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use GuzzleHttp\Psr7\Request;
use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\User as BaseUser;
use function React\Promise\resolve;

class User extends BaseUser
{
    public function refresh() : PromiseInterface
    {
        return $this->getTransport()->request('users/' . $this->id())->then(function ($json) {
            return resolve($this->getTransport()->getHydrator()->hydrate('User', $json['user']));
        });
    }

    /**
     * @return PromiseInterface
     */
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
