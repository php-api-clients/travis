<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Pusher\CommandBus\Command\SharedAppClientCommand;
use ApiClients\Client\Travis\ApiSettings;
use ApiClients\Client\Travis\CommandBus\Command\AnnotationsCommand;
use ApiClients\Client\Travis\CommandBus\Command\JobCommand;
use ApiClients\Client\Travis\Resource\Job as BaseJob;
use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use React\Promise\PromiseInterface;
use Rx\Observable;
use Rx\ObservableInterface;
use Rx\Observer\CallbackObserver;
use Rx\ObserverInterface;
use Rx\React\Promise;
use Rx\SchedulerInterface;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
use function React\Promise\resolve;

class Job extends BaseJob
{
    public function log(): ObservableInterface
    {
        return Observable::create(function (
            ObserverInterface $observer,
            SchedulerInterface $scheduler
        ) {
            $this->handleCommand(
                new SharedAppClientCommand(ApiSettings::PUSHER_KEY)
            )->then(function ($pusher) use ($observer) {
                $pusher->channel('job-' . $this->id)->filter(function ($message) {
                    return $message->event == 'job:log';
                })->map(function ($message) {
                    return json_decode($message->data, true);
                })->flatMap(function (array $json) {
                    return Promise::toObservable($this->handleCommand(new HydrateCommand('LogLine', $json)));
                })->subscribe(new CallbackObserver(function ($repository) use ($observer) {
                    $observer->onNext($repository);
                }));
            });
        });
    }
    /**
     * @return ObservableInterface
     */
    public function annotations(): ObservableInterface
    {
        return unwrapObservableFromPromise($this->handleCommand(
            new AnnotationsCommand($this->id())
        ));
    }

    /**
     * @return PromiseInterface
     */
    public function refresh(): PromiseInterface
    {
        return $this->handleCommand(new JobCommand($this->id()));
    }
}
