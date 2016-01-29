<?php

namespace WyriHaximus\Travis;

class Client
{
    const VERSION = '0.0.1-alpha1';
    const USER_AGENT = 'wyrihaximus/travis-client/' . self::VERSION;
    const API_VERSION = 'application/vnd.travis-ci.2+json';
    const API_HOST_OPEN_SOURCE = 'api.travis-ci.org';
    const API_HOST_PRO = 'api.travis-ci.com';
    const API_HOST = self::API_HOST_OPEN_SOURCE;
    const API_SCHEMA = 'https';
}
