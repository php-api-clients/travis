<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis;

use ApiClients\Foundation\Factory;
use React\EventLoop\Factory as LoopFactory;
use React\EventLoop\LoopInterface;
use Rx\React\Promise;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Client\Travis\Resource\SSHKeyInterface;
use ApiClients\Client\Travis\Resource\UserInterface;
use function Clue\React\Block\await;
use function React\Promise\resolve;

interface ClientInterface
{
    /**
     * @param string $repository
     * @return RepositoryInterface
     */
    public function repository(string $repository): RepositoryInterface;

    /**
     * @return UserInterface
     */
    public function user(): UserInterface;

    /**
     * @param int $id
     * @return SSHKeyInterface
     */
    public function sshKey(int $id): SSHKeyInterface;

    /**
     * @return array
     */
    public function hooks(): array;

    /**
     * @return array
     */
    public function repositories(): array;

    /**
     * @return array
     */
    public function accounts(): array;

    /**
     * @return array
     */
    public function broadcasts(): array;
}
