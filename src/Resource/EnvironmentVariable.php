<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource;

use ApiClients\Foundation\Hydrator\Annotation\EmptyResource;
use ApiClients\Foundation\Resource\AbstractResource;

/**
 * @EmptyResource("EmptyEnvironmentVariable")
 */
abstract class EnvironmentVariable extends AbstractResource implements EnvironmentVariableInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var bool
     */
    protected $public;

    /**
     * @var int
     */
    protected $repository_id;

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function public(): bool
    {
        return $this->public;
    }

    /**
     * @return int
     */
    public function repositoryId(): int
    {
        return $this->repository_id;
    }
}
