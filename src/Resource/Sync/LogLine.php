<?php declare(strict_types=1);

namespace ApiClients\Client\Travis\Resource\Sync;

use ApiClients\Client\Travis\Resource\LogLine as BaseLogLine;

class LogLine extends BaseLogLine
{
    /**
     * @return LogLine
     */
    public function refresh(): LogLine
    {
        return $this;
    }
}
