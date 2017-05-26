<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Resource\ResourceInterface;

interface AccountInterface extends ResourceInterface
{
    const HYDRATE_CLASS = 'Account';

    /**
     * @return int
     */
    public function id(): int;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return string
     */
    public function type(): string;

    /**
     * @return string
     */
    public function login(): string;

    /**
     * @return int
     */
    public function reposCount(): int;
}
