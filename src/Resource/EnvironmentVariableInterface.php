<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use WyriHaximus\ApiClient\Resource\ResourceInterface;

interface EnvironmentVariableInterface extends ResourceInterface
{
    /**
     * @return string
     */
    public function id() : string;

    /**
     * @return string
     */
    public function name() : string;

    /**
     * @return string
     */
    public function value() : string;

    /**
     * @return bool
     */
    public function public() : bool;

    /**
     * @return int
     */
    public function repositoryId() : int;
}
