<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use WyriHaximus\ApiClient\Resource\ResourceInterface;

interface SSHKeyInterface extends ResourceInterface
{
    /**
     * @return string
     */
    public function description() : string;

    /**
     * @return string
     */
    public function fingerprint() : string;
}
