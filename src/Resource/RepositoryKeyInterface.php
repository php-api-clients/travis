<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use WyriHaximus\ApiClient\Resource\ResourceInterface;

interface RepositoryKeyInterface extends ResourceInterface
{
    /**
     * @return string
     */
    public function publicKey() : string;

    /**
     * @return string
     */
    public function fingerprint() : string;
}
