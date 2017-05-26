<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Resource\ResourceInterface;

interface RepositoryKeyInterface extends ResourceInterface
{
    const HYDRATE_CLASS = 'RepositoryKey';

    /**
     * @return string
     */
    public function key(): string;

    /**
     * @return string
     */
    public function fingerprint(): string;
}
