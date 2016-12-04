<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\SimpleRequestCommand;
use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\Branch as BaseBranch;
use function React\Promise\reject;
use function React\Promise\resolve;

class Branch extends BaseBranch
{
    /**
     * @return PromiseInterface
     */
    public function refresh() : PromiseInterface
    {
        return $this->handleCommand(
            new SimpleRequestCommand('repos/' . $this->repositoryId() . '/branches')
        )->then(function ($json) {
            foreach ($json['branches'] as $branch) {
                if ($branch['id'] != $this->id()) {
                    continue;
                }

                return resolve($this->handleCommand(new HydrateCommand('Branch', $branch)));
            }

            return reject();
        });
    }
}
