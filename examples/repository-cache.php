<?php declare(strict_types=1);
use ApiClients\Client\Travis\Client;
use function ApiClients\Foundation\resource_pretty_print;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

$client = Client::create(require 'resolve_key.php');

$repo = $argv[1] ?? 'php-api-clients/travis';

$cacheSize = 0;
$cacheCount = 0;
foreach ($client->repository($repo)->caches() as $cache) {
    resource_pretty_print($cache);
    $cacheSize += $cache->size();
    $cacheCount++;
}
echo $repo, PHP_EOL;
echo "\t", 'Size: ', round($cacheSize / 1024 / 1024), 'MB', PHP_EOL;
echo "\t", 'Count: ', $cacheCount, PHP_EOL;
echo "\t", 'Average Size: ', round(($cacheCount === 0 ? 0 : $cacheSize / $cacheCount) / 1024 / 1024), 'MB', PHP_EOL;
