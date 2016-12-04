<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use ApiClients\Foundation\Resource\ResourceInterface;

interface SSHKeyInterface extends ResourceInterface
{
    const HYDRATE_CLASS = 'SSHKey';

    /**
     * @return int
     */
    public function id() : int;

    /**
     * @return string
     */
    public function description() : string;

    /**
     * @return string
     */
    public function fingerprint() : string;
}
