<?php

namespace WyriHaximus\Travis\Resource;

use ApiClients\Foundation\Resource\ResourceInterface;

interface LogLineInterface extends ResourceInterface
{
    /**
     * @return int
     */
    public function id() : int;
    /**
     * @return string
     */
    public function log() : string;
    /**
     * @return int
     */
    public function number() : int;
    /**
     * @return bool
     */
    public function final() : bool;
}
