<?php

$loader = require __DIR__.'/../vendor/autoload.php';

function mdate_diff($endTime, $startTime)
{
    return round($endTime - $startTime, 5) * 1000;
}

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    for ($i = 0; $i <= 1000; $i++) {
        $r->addRoute('GET', '/' . $i++ . '/archive/{month:[0-9]{4}-[0-9]{2}}', 'showArchive');
    }

    $r->addRoute('GET', '/archive/{month:[0-9]{4}-[0-9]{2}}', 'showArchive');
});

$startTime = microtime(true);

$routeInfo = $dispatcher->dispatch('GET', '/archive/2012-01');

$endTime   = microtime(true);

echo "Time: " . mdate_diff($endTime, $startTime) . ' ms' .  PHP_EOL;