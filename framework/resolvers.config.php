<?php

namespace Framework;

use Framework\DI\Service;

return array(
	
	'route' => 
		function ($params = array()) {
			return new Route($params['routeInfo']);
		},

	'routeCollection' => 
		function($params = array()) {
			if(file_exists($params['routes'])) {
				$routes = require $params['routes'];
				$routeCollection = new RouteCollection();
			}

			foreach($routes as $routeName => $routeInfo) {
				Service::setParams('route', array('routeInfo' => $routeInfo));
				$routeCollection->setRoute($routeName, Service::resolve('route'));
			}
			return $routeCollection;
		},

	'router' => 
		function($params = array()) {
			return new Router($params['routeCollection']);
		},

	'matchedRoute' => 
		function($params = array()) {
			$matchedRoute = new MatchedRoute($params['route']);
			unset($params['route']);
			$matchedRoute->setParameters($params);
			return $matchedRoute;
		},

	'application' =>
		function($params = array()) {
			return new Application($params['router'], $params['templateEngine'], $params['config']);
		},
	'templateEngine' =>
		function($params = array()) {
			return TemplateEngine::getInstance($params['templateDir']);
		}
);