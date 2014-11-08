<?php

namespace Framework;

class Route
{

    public $pattern;
    public $controller;
    public $action;
    public $security = array();
    public $requirements = array();

    public function __construct($routeInfo)
    {
        $this->pattern      = $routeInfo['pattern'];
        $this->controller   = $routeInfo['controller'];
        $this->action       = $routeInfo['action'];
        $this->security     = isset($routeInfo['security'])?$routeInfo['security']:null;
        $this->requirements = isset($routeInfo['_requirements'])?$routeInfo['_requirements']:null;
    }
    /*public function setPattern() {

    }

    public function setController($controller) {
        $this->controller = $controller;
    }

    public function setAction($action) {
        $this->action = $action;
    }


    public function setSecurity() {

    }

    public function setRequirements() {

    }*/

}