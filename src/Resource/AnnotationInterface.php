<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource;

use ApiClients\Foundation\Resource\ResourceInterface;

interface AnnotationInterface extends ResourceInterface
{
    const HYDRATE_CLASS = 'Annotation';

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
