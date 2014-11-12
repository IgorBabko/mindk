<?php

namespace Framework;

class RouteCollection
{
    public $routes = array();

    public function __construct()
    {
    }

    public function setRoute($routeName, $routeInfo) 
    {
        $this->routes[$routeName] = $routeInfo;
    }

    public function add($routeName, $routeInfo)
    {
        $this->routes[$name] = $route;
    }

    public function info()
    {
        foreach ($this->routes as $name) {
            info($name);
        }
    }
}   