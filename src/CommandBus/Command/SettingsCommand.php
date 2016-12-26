<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Command;

use WyriHaximus\Tactician\CommandHandler\Annotations\Handler;

/**
 * @Handler("ApiClients\Client\Travis\CommandBus\Handler\SettingsHandler")
 */
final class SettingsCommand
{
    /**
     * @var string
     */
    private $repositoryId;

    /**
     * @param int $repositoryId
     */
    public function __construct(int $repositoryId)
    {
        $this->repositoryId = $repositoryId;
    }

    /**
     * @return int
     */
    public function getRepositoryId(): int
    {
        return $this->repositoryId;
    }
}
