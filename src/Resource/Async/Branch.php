<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use React\Promise\PromiseInterface;
use function React\Promise\reject;
use function React\Promise\resolve;
use WyriHaximus\Travis\Resource\Branch as BaseBranch;

class Branch extends BaseBranch
{
    /**
     * @return PromiseInterface
     */
    public function refresh() : PromiseInterface
    {
        return $this->getTransport()->request('repos/' . $this->repositoryId() . '/branches')->then(function ($json) {
            foreach ($json['branches'] as $branch) {
                if ($branch['id'] != $this->id()) {
                    continue;
                }

                return resolve($this->getTransport()->getHydrator()->hydrate('Branch', $branch));
            }

            return reject();
        });
    }
}
