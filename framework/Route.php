<?php

namespace Framework;

class Route {

	public $pattern;
	public $controller;
	public $action;

	public function __construct($routeInfo) {
		$this->pattern    = $routeInfo['pattern'];
		$this->controller = $routeInfo['controller'];
		$this->action     = $routeInfo['action'];
	}
}