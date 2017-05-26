<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis;

use ApiClients\Client\Travis\ApiSettings;
use ApiClients\Foundation\Hydrator\Options as HydratorOptions;
use ApiClients\Foundation\Options as FoundationOptions;
use ApiClients\Foundation\Transport\Options as TransportOptions;
use ApiClients\Middleware\TokenAuthorization\Options as TokenAuthorizationHeaderMiddlewareOptions;
use ApiClients\Middleware\TokenAuthorization\TokenAuthorizationHeaderMiddleware;
use ApiClients\Tools\TestUtilities\TestCase;

class ApiSettingsTest extends TestCase
{
    public function optionsProvider()
    {
        yield [
            '',
            'Async',
            [],
            (function ($options) {
                $options[FoundationOptions::HYDRATOR_OPTIONS][HydratorOptions::NAMESPACE_SUFFIX] = 'Async';

                return $options;
            })(ApiSettings::DEFAULT_TRANSPORT_OPTIONS),
        ];

        yield [
            'foo.bar',
            'Async',
            [],
            (function ($options) {
                $options[FoundationOptions::HYDRATOR_OPTIONS][HydratorOptions::NAMESPACE_SUFFIX] = 'Async';
                $transportOptions = $options[FoundationOptions::TRANSPORT_OPTIONS];
                $transportOptions[TransportOptions::MIDDLEWARE][] = TokenAuthorizationHeaderMiddleware::class;
                $transportOptions[TransportOptions::DEFAULT_REQUEST_OPTIONS] = array_merge_recursive(
                    $transportOptions[TransportOptions::DEFAULT_REQUEST_OPTIONS] ?? [],
                    [
                        TokenAuthorizationHeaderMiddleware::class => [
                            TokenAuthorizationHeaderMiddlewareOptions::TOKEN => 'foo.bar',
                        ],
                    ]
                );
                $options[FoundationOptions::TRANSPORT_OPTIONS] = $transportOptions;

                return $options;
            })(ApiSettings::DEFAULT_TRANSPORT_OPTIONS),
        ];

        yield [
            '',
            'Async',
            [
                'foo' => 'bar',
            ],
            (function ($options) {
                $options[FoundationOptions::HYDRATOR_OPTIONS][HydratorOptions::NAMESPACE_SUFFIX] = 'Async';
                $options['foo'] = 'bar';

                return $options;
            })(ApiSettings::DEFAULT_TRANSPORT_OPTIONS),
        ];
    }

    /**
     * @dataProvider optionsProvider
     */
    public function testGetOptions(string $key, string $suffix, array $options, array $expected)
    {
        self::assertSame($expected, ApiSettings::getOptions($key, $suffix, $options));
    }
}
