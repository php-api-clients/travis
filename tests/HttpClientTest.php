<?php

namespace WyriHaximus\Tests\Travis;

use WyriHaximus\Travis\HttpClient;

class HttpClientTest extends \PHPUnit_Framework_TestCase
{
    public function testVersion()
    {
        $this->assertSame('0.0.1-alpha1', HttpClient::VERSION);
        $this->assertSame('wyrihaximus/travis-client/0.0.1-alpha1', HttpClient::USER_AGENT);
        $this->assertSame('application/vnd.travis-ci.2+json', HttpClient::API_VERSION);
        $this->assertSame('api.travis-ci.org', HttpClient::API_HOST_OPEN_SOURCE);
        $this->assertSame('api.travis-ci.com', HttpClient::API_HOST_PRO);
        $this->assertSame('api.travis-ci.org', HttpClient::API_HOST);
        $this->assertSame('https', HttpClient::API_SCHEMA);
    }
}
