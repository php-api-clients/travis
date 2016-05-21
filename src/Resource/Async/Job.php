<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\Job as BaseJob;
use function React\Promise\resolve;

class Job extends BaseJob
{
    public function refresh(): PromiseInterface
    {
        return $this->getTransport()->request('jobs/' . $this->id)->then(function ($json) {
            return resolve($this->getTransport()->getHydrator()->hydrate('Job', $json['job']));
        });
    }
}
