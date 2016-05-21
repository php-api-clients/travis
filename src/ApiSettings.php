<?php
declare(strict_types=1);

namespace WyriHaximus\Travis;

class ApiSettings
{
    /**
     * Travis' Pusher App ID as found on: https://docs.travis-ci.com/api?http#external-apis
     */
    const PUSHER_KEY = '5df8ac576dcccf4fd076';

    const TRANSPORT_OPTIONS = [
        'host' => 'api.travis-ci.org',
        'namespace' => 'WyriHaximus\\Travis\\Resource',
        'headers' => [
            'Accept' => 'application/vnd.travis-ci.2+json',
        ],
    ];
}
