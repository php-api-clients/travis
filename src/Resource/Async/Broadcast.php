<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\Broadcast as BaseBroadcast;
use function React\Promise\reject;
use function React\Promise\resolve;

class Broadcast extends BaseBroadcast
{
    public function refresh() : PromiseInterface
    {
        return $this->getTransport()->request('repos/' . $this->repositoryId() . '/branches')->then(function ($json) {
            foreach ($json['broadcasts'] as $broadcast) {
                if ($broadcast['id'] != $this->id()) {
                    continue;
                }

                return resolve($this->getTransport()->getHydrator()->hydrate('Broadcast', $broadcast));
            }

            return reject();
        });
    }
}
