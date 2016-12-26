<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Command;

use WyriHaximus\Tactician\CommandHandler\Annotations\Handler;

/**
 * @Handler("ApiClients\Client\Travis\CommandBus\Handler\JobsHandler")
 */
final class JobsCommand
{
    /**
     * @var string
     */
    private $buildId;

    /**
     * @param int $buildId
     */
    public function __construct(int $buildId)
    {
        $this->buildId = $buildId;
    }

    /**
     * @return int
     */
    public function getBuildId(): int
    {
        return $this->buildId;
    }
}
