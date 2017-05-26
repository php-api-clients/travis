<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Resource\ResourceInterface;

interface BroadcastInterface extends ResourceInterface
{
    const HYDRATE_CLASS = 'Broadcast';

    /**
     * @return int
     */
    public function id(): int;

    /**
     * @return string
     */
    public function message(): string;
}
