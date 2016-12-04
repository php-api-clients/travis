<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Sync;

use WyriHaximus\Travis\Resource\LogLine as BaseLogLine;

class LogLine extends BaseLogLine
{
    /**
     * @return LogLine
     */
    public function refresh() : LogLine
    {
        return $this;
    }
}
