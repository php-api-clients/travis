<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Resource\EmptyResourceInterface;

abstract class EmptyAnnotation implements AnnotationInterface, EmptyResourceInterface
{
    /**
     * @return int
     */
    public function id(): int
    {
        return null;
    }

    /**
     * @return int
     */
    public function jobId(): int
    {
        return null;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return null;
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return null;
    }

    /**
     * @return string
     */
    public function status(): string
    {
        return null;
    }
}
