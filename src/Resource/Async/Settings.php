<?php
declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Async;

use ApiClients\Client\Travis\Resource\Settings as BaseSettings;
use Exception;
use React\Promise\PromiseInterface;
use function React\Promise\reject;

class Settings extends BaseSettings
{
    public function refresh(): PromiseInterface
    {
        return reject(new Exception('Can\'t refresh as there is no reference to the relative repository'));
    }
}
