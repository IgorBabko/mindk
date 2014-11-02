<?php

namespace Framework;

class MatchedRoute {

	public $controller;
	public $action;
	public $parameters;

	public function __construct($routeInfo) {
		$this->controller = $routeInfo['controller'];
		$this->action = $routeInfo['action'] . 'Action';
	}

	public function getController() {
		return $this->controller;
	}

	public function getAction() {
		return $this->action;
	}

	public function getParameters() {
		return $this->parameters();
	}
}