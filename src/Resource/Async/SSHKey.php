<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\SSHKey as BaseSSHKey;
use function React\Promise\resolve;

class SSHKey extends BaseSSHKey
{
    /**
     * @return PromiseInterface
     */
    public function refresh() : PromiseInterface
    {
        return $this->getTransport()->request('settings/ssh_key/' . $this->id())->then(function ($json) {
            return resolve($this->getTransport()->getHydrator()->hydrate('SSHKey', $json['ssh_key']));
        });
    }
}
