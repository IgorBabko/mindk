<?php

namespace Framework;

use Framework\Router;

class Application
{

    private $_controller;
    private $_action;
    private $_config;
    private $_router;
    private $_matchedRoute;
    private $_request;

    public function __construct($data = array())
    {

        $this->_config       = require_once $data['config'];
        $this->_router       = new Router($data['routes']);
        $this->_matchedRoute = $this->_router->matchCurrentRequest();
        /*echo '<pre>';
        print_r($this->_matchedRoute);
        echo '</pre>';*/
        $controller        = $this->_matchedRoute->controller;
        $this->_controller = new $controller();
    }


    public function run()
    {

        $action     = $this->_matchedRoute->action;
        $parameters = $this->_matchedRoute->parameters;
        $this->_controller->$action($parameters);

        //echo $this->_router->generateUrl();
        //$this->_controller = new \Blog\HelloController();
        //$this->_controller->indexAction();
        //$action = $this->_action;
        //$this->_controller->{$this->_action}();
        /*//echo $_GET['uri'];
        if (isset($_GET['uri']))
        {

            $action = '';
            $params = array();
            //echo '$_GET exists' . '<br />';
            $uri = explode('/', $_GET['uri']);

            if (!empty($uri[0]))
            {
                //echo 'controller exists' . '<br />';
                $this->controller = Loader::controller($uri[0]);

                if (isset($uri[1]) && method_exists(ucfirst($uri[0]) . 'Controller', $uri[1] . 'Action'))
                {
                    //echo 'method exists' . '<br />';
                    $action = $uri[1] . 'Action';
                    unset($uri[1]);

                    if (isset($uri[2]))
                    {
                        //echo 'params exist' . '<br />';
                        $this->controller->$action($uri);
                    }
                    else
                    {
                        $this->controller->$action();
                    }
                } else
                {
                    $action = 'indexAction';
                    $this->controller->$action();
                }
                unset($uri[0]);
            }
            else
            {
                $this->controller = Loader::controller('hello');
                $action = 'indexAction';
                $this->controller->$action();
            }
        }
        else
        {
        // @TODO ...
        }
    }*/
    }
}