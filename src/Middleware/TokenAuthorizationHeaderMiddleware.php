<?php declare(strict_types=1);

namespace WyriHaximus\Travis\Middleware;

use ApiClients\Foundation\Middleware\DefaultPriorityTrait;
use ApiClients\Foundation\Middleware\MiddlewareInterface;
use ApiClients\Foundation\Middleware\PostTrait;
use Psr\Http\Message\RequestInterface;
use React\Promise\CancellablePromiseInterface;
use WyriHaximus\Travis\Options;
use function React\Promise\resolve;

class TokenAuthorizationHeaderMiddleware implements MiddlewareInterface
{
    use DefaultPriorityTrait;
    use PostTrait;

    /**
     * @param RequestInterface $request
     * @param array $options
     * @return CancellablePromiseInterface
     */
    public function pre(RequestInterface $request, array $options = []): CancellablePromiseInterface
    {
        if (!isset($options[self::class][Options::TOKEN])) {
            return resolve($request);
        }

        if (empty($options[self::class][Options::TOKEN])) {
            return resolve($request);
        }

        return resolve(
            $request->withAddedHeader(
                'Authorization',
                'token ' . $options[self::class][Options::TOKEN]
            )
        );
    }
}
