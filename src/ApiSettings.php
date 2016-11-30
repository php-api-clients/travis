<?php declare(strict_types=1);

namespace WyriHaximus\Travis;

use ApiClients\Foundation\Hydrator\Options as HydratorOptions;
use ApiClients\Foundation\Options as FoundationOptions;
use ApiClients\Foundation\Transport\Middleware\JsonDecodeMiddleware;
use ApiClients\Foundation\Transport\Options as TransportOptions;
use ApiClients\Foundation\Transport\UserAgentStrategies;
use WyriHaximus\Travis\Middleware\TokenAuthorizationHeaderMiddleware;

class ApiSettings
{
    /**
     * Travis' Pusher App ID as found on: https://docs.travis-ci.com/api?http#external-apis
     * Will automate the retrieval of that key later in the PR
     */
    const PUSHER_KEY = '5df8ac576dcccf4fd076';

    const NAMESPACE = 'WyriHaximus\\Travis\\Resource';

    const TRANSPORT_OPTIONS = [
        FoundationOptions::HYDRATOR_OPTIONS => [
            HydratorOptions::NAMESPACE => self::NAMESPACE,
            HydratorOptions::NAMESPACE_DIR => __DIR__ . DIRECTORY_SEPARATOR . 'Resource' . DIRECTORY_SEPARATOR,
        ],
        FoundationOptions::TRANSPORT_OPTIONS => [
            TransportOptions::HOST => 'api.travis-ci.org',
            TransportOptions::HEADERS => [
                'Accept' => 'application/vnd.travis-ci.2+json',
            ],
            TransportOptions::USER_AGENT_STRATEGY => UserAgentStrategies::PACKAGE_VERSION,
            TransportOptions::PACKAGE => 'wyrihaximus/travis-client',
            TransportOptions::MIDDLEWARE => [
                JsonDecodeMiddleware::class,
            ],
        ],
    ];

    public static function getOptions(
        string $token,
        string $suffix
    ): array {
        $options = self::TRANSPORT_OPTIONS;
        $options[FoundationOptions::HYDRATOR_OPTIONS][HydratorOptions::NAMESPACE_SUFFIX] = $suffix;

        if (!empty($token)) {
            $options[FoundationOptions::TRANSPORT_OPTIONS][TransportOptions::MIDDLEWARE] = [
                JsonDecodeMiddleware::class,
                TokenAuthorizationHeaderMiddleware::class,
            ];
            $options[FoundationOptions::TRANSPORT_OPTIONS][TransportOptions::DEFAULT_REQUEST_OPTIONS] = [
                TokenAuthorizationHeaderMiddleware::class => [
                    Options::TOKEN => $token,
                ],
            ];
        }

        return $options;
    }
}
