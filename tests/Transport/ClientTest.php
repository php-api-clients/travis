<?php

namespace WyriHaximus\Tests\Travis\Transport;

use WyriHaximus\Travis\Transport\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testVersion()
    {
        $this->assertSame('0.0.1-alpha1', Client::VERSION);
        $this->assertSame('wyrihaximus/travis-client/0.0.1-alpha1', Client::USER_AGENT);
        $this->assertSame('application/vnd.travis-ci.2+json', Client::API_VERSION);
        $this->assertSame('api.travis-ci.org', Client::API_HOST_OPEN_SOURCE);
        $this->assertSame('api.travis-ci.com', Client::API_HOST_PRO);
        $this->assertSame('api.travis-ci.org', Client::API_HOST);
        $this->assertSame('https', Client::API_SCHEMA);
    }
}
