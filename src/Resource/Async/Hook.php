<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use function React\Promise\reject;
use function React\Promise\resolve;
use WyriHaximus\Travis\Resource\Hook as BaseHook;

class Hook extends BaseHook
{
    public function refresh() : Hook
    {
        return $this->getTransport()->request('hooks')->then(function ($json) {
            foreach ($json['hooks'] as $hook) {
                if ($hook['id'] != $this->id()) {
                    continue;
                }

                return resolve($this->getTransport()->getHydrator()->hydrate('Hook', $hook));
            }

            return reject();
        });
    }
}
