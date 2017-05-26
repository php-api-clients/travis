<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\CommandBus\Handler;

use ApiClients\Client\Pusher\AsyncClient as PusherAsyncClient;
use ApiClients\Client\Pusher\Event;
use ApiClients\Client\Pusher\Service\SharedAppClientService;
use ApiClients\Client\Travis\ApiSettings;
use ApiClients\Client\Travis\CommandBus\Command\JobLogCommand;
use ApiClients\Client\Travis\Resource\LogLineInterface;
use ApiClients\Foundation\Hydrator\Hydrator;
use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObserverInterface;
use function React\Promise\resolve;

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
     * @param  JobLogCommand    $command
     * @return PromiseInterface
     */
    public function handle(JobLogCommand $command): PromiseInterface
    {
        return $this->pusher->share(
            ApiSettings::PUSHER_KEY
        )->then(function (PusherAsyncClient $pusher) use ($command) {
            return resolve(Observable::create(function (
                ObserverInterface $observer
            ) use (
                $pusher,
                $command
            ) {
                $subscription = $pusher->channel('job-' . (string)$command->getId())->filter(function (Event $event) {
                    return $event->getEvent() === 'job:log';
                })->map(function (Event $event) {
                    return $this->hydrator->hydrate(LogLineInterface::HYDRATE_CLASS, $event->getData());
                })->subscribe(
                    function (LogLineInterface $line) use ($observer, &$subscription) {
                        $observer->onNext($line);

                        if ($line->final()) {
                            $subscription->dispose();
                        }
                    },
                    function ($error) use ($observer) {
                        $observer->onError($error);
                    },
                    function () use ($observer) {
                        $observer->onComplete();
                    }
                );
            }));
        });
    }
}
