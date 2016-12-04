<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use ApiClients\Foundation\Hydrator\CommandBus\Command\HydrateCommand;
use ApiClients\Foundation\Transport\CommandBus\Command\SimpleRequestCommand;
use React\Promise\PromiseInterface;
use WyriHaximus\Travis\Resource\Annotation as BaseAnnotation;
use function React\Promise\reject;
use function React\Promise\resolve;

class Annotation extends BaseAnnotation
{
    /**
     * @return PromiseInterface
     */
    public function refresh() : PromiseInterface
    {
        return $this->handleCommand(
            new SimpleRequestCommand('jobs/' . $this->jobId() . '/annotations')
        )->then(function ($json) {
            foreach ($json['annotations'] as $annotation) {
                if ($annotation['id'] != $this->id()) {
                    continue;
                }

                return resolve($this->handleCommand(new HydrateCommand('Annotation', $annotation)));
            }

            return reject();
        });
    }
}
