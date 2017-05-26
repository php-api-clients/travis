<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Resource\ResourceInterface;

interface LogLineInterface extends ResourceInterface
{
    const HYDRATE_CLASS = 'LogLine';

    /**
     * @return int
     */
    public function id(): int;

    /**
     * @return string
     */
    public function log(): string;

    /**
     * @return int
     */
    public function number(): int;

    /**
     * @return bool
     */
    public function final(): bool;
}
