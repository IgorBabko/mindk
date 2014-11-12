<?php

use Framework\Autoloader;
use Framework\Application;
use Framework\DI;
use Framework\RouteCollection;
use Framework\Route;
use Framework\Router;
use Framework\MatchedRoute;

function info($obj)
{
    echo '<pre>';
    print_r($obj);
    echo '</pre>';
}

define('CONFIG', __DIR__.'/../app/config/config.php');
define('ROUTES', __DIR__.'/../app/config/routes.php');
define('RESOLVERS', __DIR__.'/../framework/resolvers.config.php');
define('VIEWS', __DIR__.'/../src/Blog/views/');

require_once(__DIR__.'/../framework/Autoloader.php');
$resolvers = require(RESOLVERS);

Autoloader::addNamespacePath("Blog\\Controller\\", __DIR__.'/../src/Blog/Controller/');
Autoloader::addNamespacePath('Framework\\', __DIR__.'/../framework/');
Autoloader::register();


DI::setService('route', 'Route', $resolvers['route']);
DI::setService('routeCollection', 'RouteCollection', $resolvers['routeCollection'], array('routes' => ROUTES));
DI::setService('router', 'Router', $resolvers['router'], array(), array('routeCollection' => 'RouteCollection'));
DI::setService('matchedRoute', 'MatchedRoute', $resolvers['matchedRoute'], array('params' => null), array('route' => 'Route'));
DI::setService('application', 'Application', $resolvers['application'], array('config' => CONFIG), array('router' => 'Router'));


$app = DI::resolve('application');
$app->run();
