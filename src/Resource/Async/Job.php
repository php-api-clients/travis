<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Resource\Async;

use Rx\ObservableInterface;
use WyriHaximus\Travis\Resource\Job as BaseJob;

class Job extends BaseJob
{
    public function log(): ObservableInterface
    {
        return $this->getPusher()->channel('job-' . $this->id)->filter(function ($message) {
            return $message->event == 'job:log';
        })->map(function ($message) {
            return json_decode($message->data, true);
        })->map(function (array $json) {
            return $this->getTransport()->getHydrator()->hydrate('LogLine', $json);
        });
    }
}
