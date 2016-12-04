<?php declare(strict_types=1);

namespace ApiClients\Tests\Client\Travis\Middleware;

use ApiClients\Tools\TestUtilities\TestCase;
use React\EventLoop\Factory;
use RingCentral\Psr7\Request;
use ApiClients\Client\Travis\Middleware\TokenAuthorizationHeaderMiddleware;
use ApiClients\Client\Travis\Options;
use function Clue\React\Block\await;
use function React\Promise\resolve;

class TokenAuthorizationHeaderMiddlewareTest extends TestCase
{
    public function preProvider()
    {
        yield [
            [],
            false,
            ''
        ];

        yield [
            [
                TokenAuthorizationHeaderMiddleware::class => [
                    Options::TOKEN => '',
                ],
            ],
            false,
            ''
        ];

        yield [
            [
                TokenAuthorizationHeaderMiddleware::class => [
                    Options::TOKEN => null,
                ],
            ],
            false,
            ''
        ];

        yield [
            [
                TokenAuthorizationHeaderMiddleware::class => [
                    Options::TOKEN => 'kroket',
                ],
            ],
            true,
            'token kroket'
        ];
    }

    /**
     * @dataProvider preProvider
     */
    public function testPre(array $options, bool $hasHeader, string $expectedHeader)
    {
        $request = new Request('GET', 'https://example.com/');
        $middleware = new TokenAuthorizationHeaderMiddleware();
        $changedRequest = await($middleware->pre($request, $options), Factory::create());

        if ($hasHeader === false) {
            $this->assertFalse($changedRequest->hasHeader('Authorization'));
            return;
        }

        $this->assertTrue($changedRequest->hasHeader('Authorization'));
        $this->assertSame($expectedHeader, $changedRequest->getHeaderLine('Authorization'));
    }
}
