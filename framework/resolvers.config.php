<?php

namespace Framework;

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
				DI::setParams('route', array('routeInfo' => $routeInfo));
				$routeCollection->setRoute($routeName, DI::resolve('route'));
			}
			return $routeCollection;
		},

	'router' => 
		function($params = array()) {
			return new Router($params['routeCollection']);
		},

	'matchedRoute' => 
		function($params = array()) {
			return new MatchedRoute($params['route'], $params['params']);
		},

	'application' =>
		function($params = array()) {
			return new Application($params['router'], $params['config']);
		}
);