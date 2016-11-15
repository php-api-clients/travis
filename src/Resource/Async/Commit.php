<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\Commit as BaseCommit;
use function React\Promise\resolve;

class Commit extends BaseCommit
{
    public function refresh(): PromiseInterface
    {
        return $this->getTransport()->request('builds/' . $this->id)->then(function ($json) {
            return resolve($this->getTransport()->getHydrator()->hydrate('Build', $json['build']));
        });
    }
}
