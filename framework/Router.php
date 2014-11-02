<?php

namespace Framework;

class Router {

	public $routeCollection = array();
	public $host;
	public $matcher;
	public $generator;

	public function __construct($routes) {
		$this->host   = 'http://' . $_SERVER['HTTP_HOST'];
		$this->routeCollection = Loader::loadCoreComponent('RouteCollection', $routes);
	}

	public function addRoute($routeName, $routeInfo) {
		$this->routeCollection->add($routeName, $routeInfo);
	}

	public function matchRequest($uri) {
		foreach($this->routeCollection->routes as $route) {
			if($route->pattern === $uri) {
				return Loader::loadCoreComponent('MatchedRoute', array('controller' => $route->controller, 
														  			   'action'     => $route->action     ) );
			}
		}
	}
}