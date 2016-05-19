<?php
declare(strict_types=1);

namespace WyriHaximus\Travis;

class ApiSettings
{
    const TRANSPORT_OPTIONS = [
        'host' => 'api.travis-ci.org',
        'namespace' => 'WyriHaximus\\Travis\\Resource',
        'headers' => [
            'Accept' => 'application/vnd.travis-ci.2+json',
        ],
    ];
}
