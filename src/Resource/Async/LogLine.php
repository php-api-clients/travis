<?php

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\Resource\LogLine as BaseLogLine;
use Exception;
use React\Promise\PromiseInterface;
use function React\Promise\reject;

class LogLine extends BaseLogLine
{
    public function refresh() : PromiseInterface
    {
        return reject(new Exception('Can\'t refresh as there is no reference to the relative job'));
    }
}
