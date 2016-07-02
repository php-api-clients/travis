<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use WyriHaximus\ApiClient\Resource\ResourceInterface;

interface BroadcastInterface extends ResourceInterface
{
    /**
     * @return int
     */
    public function id() : int;

    /**
     * @return string
     */
    public function message() : string;
}
