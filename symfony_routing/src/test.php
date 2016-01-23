<?php

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Matcher\Dumper\PhpMatcherDumper;

$loader = require __DIR__.'/../vendor/autoload.php';

function mdate_diff($endTime, $startTime)
{
    return round($endTime - $startTime, 5) * 1000;
}

$route = new Route(
    '/archive/{month}', // path
    array('controller' => 'showArchive'), // default values
    array('month' => '[0-9]{4}-[0-9]{2}'), // requirements
    array(), // options
    '', //host
    array(), // schemes
    array('GET'), // methods
    '' //condition
);

$routes = new RouteCollection();

for ($i = 0; $i <= 1000; $i++) {
    $routeClone = clone($route);
    $routeClone->setPath('/' . $i . $routeClone->getPath());
    $routes->add('test_route_' . $i, $routeClone);
}

$routes->add('match_route_name', $route);

$dump = (new PhpMatcherDumper($routes))->dump();

file_put_contents(__DIR__ . '/ProjectUrlMatcher.php', $dump);

require_once __DIR__ . '/ProjectUrlMatcher.php';

$context = new RequestContext('/');
$matcher = new ProjectUrlMatcher($context);

$startTime = microtime(true);

$parameters = $matcher->match('/archive/2012-01');

$endTime = microtime(true);

echo "Time: " . mdate_diff($endTime, $startTime) . ' ms' . PHP_EOL;