<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Pusher\Event;
use ApiClients\Client\Pusher\Service\SharedAppClientService;
use ApiClients\Client\Travis\ApiSettings;
use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Pusher\AsyncClient as PusherAsyncClient;
use ApiClients\Client\Travis\CommandBus\Command\JobCommand;
use ApiClients\Client\Travis\CommandBus\Command\JobLogCommand;
use ApiClients\Client\Travis\Resource\LogLineInterface;
use ApiClients\Foundation\Hydrator\Hydrator;
use React\Promise\PromiseInterface;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
use function React\Promise\resolve;
use Rx\React\Promise;
use function WyriHaximus\React\futureFunctionPromise;

final class JobLogHandler
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
     * @param Hydrator $hydrator
     */
    public function __construct(SharedAppClientService $pusher, Hydrator $hydrator)
    {
        $this->pusher = $pusher;
        $this->hydrator = $hydrator;
    }

    /**
     * Fetch the given repository and hydrate it
     *
     * @param JobLogCommand $command
     * @return PromiseInterface
     */
    public function handle(JobLogCommand $command): PromiseInterface
    {
        return $this->pusher->handle(
            ApiSettings::PUSHER_KEY
        )->then(function (PusherAsyncClient $pusher) use ($command) {
            return resolve(
                $pusher->channel('job-' . (string)$command->getId())->filter(function (Event $event) {
                    return $event->getEvent() === 'job:log';
                })->map(function (Event $event) {
                    return $this->hydrator->hydrate(LogLineInterface::HYDRATE_CLASS, $event->getData());
                })
            );
        });
    }
}