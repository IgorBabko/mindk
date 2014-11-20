<?php
/**
 * File framework/resolvers.config.php contains array of resolvers for all needed services in application.
 * While file requiring it returns array of resolvers.
 *
 * PHP version 5
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

use Framework\DI\Service;

return [

    'route'           =>
        function ($params = array()) {
            return new Route($params['routeInfo']);
        },
    'routeCollection' =>
        function ($params = array()) {
            if (file_exists($params['routes'])) {
                $routes          = require $params['routes'];
                $routeCollection = new RouteCollection();
            }

            foreach ($routes as $routeName => $routeInfo) {
                Service::setParams('route', array('routeInfo' => $routeInfo));
                $routeCollection->setRoute($routeName, Service::resolve('route'));
            }
            return $routeCollection;
        },
    'router'          =>
        function ($params = array()) {
            return new Router($params['routeCollection']);
        },
    'matchedRoute'    =>
        function ($params = array()) {
            $matchedRoute = new MatchedRoute($params['route']);
            unset($params['route']);
            $matchedRoute->setParameters($params);
            return $matchedRoute;
        },
    'application'     =>
        function ($params = array()) {
            return new Application($params['router'], $params['templateEngine'], $params['config']);
        },
    'templateEngine'  =>
        function ($params = array()) {
            return TemplateEngine::getInstance($params['templateDir']);
        }
];