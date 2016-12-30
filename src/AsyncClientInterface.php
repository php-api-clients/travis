<?php declare(strict_types=1);

namespace ApiClients\Client\Travis;

use ApiClients\Client\Travis\CommandBus\Command;
use React\Promise\CancellablePromiseInterface;
use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObservableInterface;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
use function React\Promise\resolve;

interface AsyncClientInterface
{
    /**
     * @param string $repository
     * @return CancellablePromiseInterface
     */
    public function repository(string $repository): CancellablePromiseInterface;

    /**
     * @return ObservableInterface
     */
    public function repositories(): ObservableInterface;

    /**
     * @return PromiseInterface
     */
    public function user(): PromiseInterface;

    /**
     * @param int $id
     * @return PromiseInterface
     */
    public function sshKey(int $id): PromiseInterface;

    /**
     * @return ObservableInterface
     */
    public function hooks(): ObservableInterface;

    /**
     * @return ObservableInterface
     */
    public function accounts(): ObservableInterface;

    /**
     * @return ObservableInterface
     */
    public function broadcasts(): ObservableInterface;
}
