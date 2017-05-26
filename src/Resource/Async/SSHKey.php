<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\CommandBus\Command\SSHKeyCommand;
use ApiClients\Client\Travis\Resource\SSHKey as BaseSSHKey;
use React\Promise\PromiseInterface;

class SSHKey extends BaseSSHKey
{
    /**
     * @return PromiseInterface
     */
    public function refresh(): PromiseInterface
    {
        return $this->handleCommand(new SSHKeyCommand($this->id()));
    }
}
