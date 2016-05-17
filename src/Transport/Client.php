<?php
declare(strict_types=1);

namespace WyriHaximus\Travis\Transport;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\LoopInterface;
use React\Promise\Deferred;
use WyriHaximus\Travis\Resource\Async;
use WyriHaximus\Travis\Resource\Sync;

class Client
{
    const VERSION = '0.0.1-alpha1';
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
    protected $loop;
    protected $options = [];
    protected $hydrator;

    public function __construct(LoopInterface $loop, callable $handler = null, $options = [])
    {
        $this->loop = $loop;
        if ($handler === null) {
            $handler = \Aws\default_http_handler();
        }

        $this->handler = $handler;
        $this->options = $options;
        $this->hydrator = new Hydrator($this, $options);
    }

    public function request($path)
    {
        $deferred = new Deferred();
        $handler = $this->handler;
        $handler($this->createRequest('GET', $path))->then(function (ResponseInterface $response) use ($deferred) {
            $deferred->resolve(json_decode($response->getBody()->getContents(), true));
        }, function ($error) use ($deferred) {
            $deferred->reject($error);
        });
        return $deferred->promise();
    }

    public function getHydrator(): Hydrator
    {
        return $this->hydrator;
    }

    protected function createRequest(string $method, string $path)
    {
        $url = self::API_SCHEMA . '://' . self::API_HOST . '/' . $path;
        return new Request($method, $url, [
            'User-Agent' => self::USER_AGENT,
            'Accept' => self::API_VERSION,
        ]);
    }

    /**
     * @return LoopInterface
     */
    public function getLoop()
    {
        return $this->loop;
    }
}
