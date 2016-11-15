<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use WyriHaximus\ApiClient\Resource\ResourceInterface;

interface AnnotationInterface extends ResourceInterface
{
    /**
     * @return int
     */
    public function id() : int;

    /**
     * @return int
     */
    public function jobId() : int;

    /**
     * @return string
     */
    public function description() : string;

    /**
     * @return string
     */
    public function url() : string;

    /**
     * @return string
     */
    public function status() : string;
}
