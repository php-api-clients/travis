<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Resource\ResourceInterface;

interface HookInterface extends ResourceInterface
{
    const HYDRATE_CLASS = 'Hook';

    /**
     * @return int
     */
    public function id(): int;

    /**
     * @return bool
     */
    public function active(): bool;
}
