<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Command;

use WyriHaximus\Tactician\CommandHandler\Annotations\Handler;

/**
 * @Handler("ApiClients\Client\Travis\CommandBus\Handler\JobHandler")
 */
final class JobCommand
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
