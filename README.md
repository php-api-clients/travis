# Async first TravisCI API Client for PHP 7

[![Build Status](https://travis-ci.org/php-api-clients/travis.svg?branch=master)](https://travis-ci.org/php-api-clients/travis)
[![Latest Stable Version](https://poser.pugx.org/api-clients/travis/v/stable.png)](https://packagist.org/packages/api-clients/travis)
[![Total Downloads](https://poser.pugx.org/api-clients/travis/downloads.png)](https://packagist.org/packages/api-clients/travis)
[![Code Coverage](https://scrutinizer-ci.com/g/php-api-clients/travis/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/php-api-clients/travis/?branch=master)
[![License](https://poser.pugx.org/api-clients/travis/license.png)](https://packagist.org/packages/api-clients/travis)
[![PHP 7 ready](http://php7ready.timesplinter.ch/php-api-clients/travis/badge.svg)](https://travis-ci.org/php-api-clients/travis)

# Install

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `^`.

```
composer require api-clients/travis
```

# Usage

The client needs two things, the ReactPHP event loop, and optionally an authentication token. Once you created the client you can call the `user` method to show the currently authenticated user.

```php
use React\EventLoop\Factory;
use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\UserInterface;
use function ApiClients\Foundation\resource_pretty_print;

$loop = Factory::create();
$client = AsyncClient::create(
    $loop, 
    'your travis key from https://blog.travis-ci.com/2013-01-28-token-token-token/'
);

$client->user()->then(function (UserInterface $user) {
    resource_pretty_print($user);
});

$loop->run();
```

## Results stream

The above example used a promise, when there is more then one result an observabe is returned instead. [`RxPHP`](https://github.com/reactivex/rxphp) is used for the observables. This means you can apply a huge list of methods to the stream of results

```php

use React\EventLoop\Factory;
use ApiClients\Client\Travis\AsyncClient;
use ApiClients\Client\Travis\Resource\BroadcastInterface;
use function ApiClients\Foundation\resource_pretty_print;

$loop = Factory::create();
$client = AsyncClient::create($loop, 'your key');

$client->broadcasts()->subscribe(function (BroadcastInterface $broadcast) {
    resource_pretty_print($broadcast);
});

$loop->run();
```

# Synchronous usage

The synchronous client works nearly the same as the asynchronous, infact it wraps the asynchronous client to do all the work. This examples does the same as the asynchronous usage example.

```php
use ApiClients\Client\Travis\Client;
use function ApiClients\Foundation\resource_pretty_print;

$client = Client::create('your travis key');

resource_pretty_print($client->user());
```

## Synchronous results stream

Synchronous results streams are returned as an array.

```php
use ApiClients\Client\Travis\Client;
use function ApiClients\Foundation\resource_pretty_print;

$client = Client::create('your travis key');

foreach ($client->broadcasts() as $broadcast) {
    resource_pretty_print($broadcast);
};
```

# Examples

The [`examples`](https://github.com/php-api-clients/travis/tree/master/examples) directory is filled with all kinds of examples for this package.

# License

The MIT License (MIT)

Copyright (c) 2017 Cees-Jan Kiewiet

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
