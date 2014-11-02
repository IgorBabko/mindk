<?php

namespace Framework;


class RouteCollection {

	public $routes = array();

	public function __construct($routes = '') {
		
		if(file_exists($routes)) {
			$routes = require $routes;
			foreach($routes as $routeName => $routeInfo) {
				$this->routes[$routeName] = Loader::loadCoreComponent('Route', $routeInfo);
			}
		}
	}

	public function add($routeName, $routeInfo) {
		$this->routes[$name] = $route;
	}

	public function info() {
		foreach($this->routes as $name) {
			info($name);
		}
	}

}