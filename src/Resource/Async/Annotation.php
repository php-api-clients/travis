<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\CommandBus\Command\AnnotationsCommand;
use ApiClients\Client\Travis\Resource\Annotation as BaseAnnotation;
use ApiClients\Client\Travis\Resource\AnnotationInterface;
use React\Promise\PromiseInterface;
use Rx\React\Promise;
use function ApiClients\Tools\Rx\unwrapObservableFromPromise;
use function React\Promise\reject;
use function React\Promise\resolve;

class Annotation extends BaseAnnotation
{
    /**
     * @return PromiseInterface
     */
    public function refresh() : PromiseInterface
    {
        return Promise::fromObservable(unwrapObservableFromPromise($this->handleCommand(
            new AnnotationsCommand($this->jobId())
        ))->filter(function (AnnotationInterface $annotation) {
            return $this->id() === $annotation->id();
        }));
    }
}
