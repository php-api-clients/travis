<?php

namespace WyriHaximus\Travis;

use GuzzleHttp\Psr7\Request;
use PackageVersions\Versions;
use Psr\Http\Message\ResponseInterface;
use React\Promise\Deferred;

class Client
{
    const USER_AGENT = 'wyrihaximus/travis-client/' . self::VERSION;
    const API_VERSION = 'application/vnd.travis-ci.2+json';
    const API_HOST_OPEN_SOURCE = 'api.travis-ci.org';
    const API_HOST_PRO = 'api.travis-ci.com';
    const API_HOST = self::API_HOST_OPEN_SOURCE;
    const API_SCHEMA = 'https';

    /**
     * @var callable
     */
    protected $handler;

    public function __construct(callable $handler = null)
    {
        if ($handler === null) {
            $handler = \Aws\default_http_handler();
        }

        $this->handler = $handler;
    }

    public function request(EndpointInterface $endpoint)
    {
        $handler = $this->handler;
        return $endpoint->fromResponse($handler($endpoint->getRequest())->wait());
    }

    public function requestAsync(EndpointInterface $endpoint)
    {
        $deferred = new Deferred();
        $handler = $this->handler;
        $handler($endpoint->getRequest())->then(function (ResponseInterface $response) use ($deferred, $endpoint) {
            var_export($endpoint->fromResponse($response));
            $deferred->resolve($endpoint->fromResponse($response));
        });
        return $deferred->promise();
    }

    public function createRequest(string $method, string $path)
    {
        $url = self::API_SCHEMA . '://' . self::API_HOST . '/' . $path;
        return new Request($method, $url, [
            'User-Agent' => self::USER_AGENT,
            'Accept' => self::getVersion(),
        ]);
    }

    public static function getVersion()
    {
        return Versions::getVersion('wyrihaximus/travis-client');
    }
}
