<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\SimpleRequestCommand;
use React\Promise\PromiseInterface;
use ApiClients\Client\Travis\Resource\SSHKey as BaseSSHKey;
use function React\Promise\resolve;

class SSHKey extends BaseSSHKey
{
    /**
     * @return PromiseInterface
     */
    public function refresh() : PromiseInterface
    {
        return $this->handleCommand(
            new SimpleRequestCommand('settings/ssh_key/' . $this->id())
        )->then(function ($json) {
            return resolve($this->handleCommand(new HydrateCommand('SSHKey', $json['ssh_key'])));
        });
    }
}
