<?php

namespace Framework;

class MatchedRoute
{

    public $controller = 'Blog\\Controller\\HelloController';
    public $action = 'indexAction';
    public $parameters = array();

    public function __construct(Route $routeInfo = null, $params = array())
    {
        if ($routeInfo) {
            $this->controller = $routeInfo->controller;
            $this->action     = $routeInfo->action.'Action';
            $this->parameters = !empty($params)?$params:array();
        }
    }

    public function setController($controller)
    {
        $this->controller = $controller;
    }

    public function setAction($action)
    {
        $this->action = $action.'Action';
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
}