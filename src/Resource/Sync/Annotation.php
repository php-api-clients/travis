<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Sync;

use ApiClients\Foundation\Hydrator\CommandBus\Command\BuildAsyncFromSyncCommand;
use ApiClients\Client\Travis\Resource\Annotation as BaseAnnotation;
use ApiClients\Client\Travis\Resource\AnnotationInterface;

class Annotation extends BaseAnnotation
{
    public function refresh() : Annotation
    {
        return $this->wait($this->handleCommand(
            new BuildAsyncFromSyncCommand(self::HYDRATE_CLASS, $this)
        )->then(function (AnnotationInterface $annotation) {
            return $annotation->refresh();
        }));
    }
}
