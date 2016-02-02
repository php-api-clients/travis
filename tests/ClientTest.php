<?php

namespace WyriHaximus\Tests\Travis;

use WyriHaximus\Travis\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testGetVersion()
    {
        $this->assertInternalType('string', Client::getVersion());
    }
}
