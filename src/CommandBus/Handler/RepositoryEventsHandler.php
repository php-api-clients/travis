<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Pusher\AsyncClient as PusherAsyncClient;
use ApiClients\Client\Pusher\Event;
use ApiClients\Client\Pusher\Service\SharedAppClientService;
use ApiClients\Client\Travis\ApiSettings;
use ApiClients\Client\Travis\CommandBus\Command\RepositoryEventsCommand;
use ApiClients\Client\Travis\Resource\RepositoryInterface;
use ApiClients\Foundation\Hydrator\Hydrator;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;

final class RepositoryEventsHandler
{
    /**
     * @var SharedAppClientService
     */
    private $pusher;

    /**
     * @var Hydrator
     */
    private $hydrator;

    /**
     * JobLogHandler constructor.
     * @param SharedAppClientService $pusher
     * @param Hydrator               $hydrator
     */
    public function __construct(SharedAppClientService $pusher, Hydrator $hydrator)
    {
        $this->pusher = $pusher;
        $this->hydrator = $hydrator;
    }

    /**
     * Fetch the given repository and hydrate it.
     *
     * @param  RepositoryEventsCommand $command
     * @return PromiseInterface
     */
    public function handle(RepositoryEventsCommand $command): PromiseInterface
    {
        return $this->pusher->share(
            ApiSettings::PUSHER_KEY
        )->then(function (PusherAsyncClient $pusher) use ($command) {
            return resolve(
                $pusher->channel('repo-' . (string)$command->getId())->filter(function (Event $event) {
                    return in_array($event->getEvent(), [
                        'build:created',
                        'build:started',
                        'build:finished',
                    ], true);
                })->filter(function (Event $event) {
                    return isset($event->getData()['repository']);
                })->map(function (Event $event) {
                    return $this->hydrator->hydrate(
                        RepositoryInterface::HYDRATE_CLASS,
                        $event->getData()['repository']
                    );
                })
            );
        });
    }
}
