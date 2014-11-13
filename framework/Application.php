<?php
/**
 * /framework/Application.php contains front controller "Application"
 */

namespace Framework;

use Framework\Router;

/**
 * Class Application - main class of the application (front controller)
 *
 * Application is a class that starts app and handles http request
 * defining particular controller and its action to call depending on url
 *
 * @package Framework
 * @author Igor Babko <i.i.babko@gmail.com>
 */
class Application
{

    /**
     * @var \Framework\Controller $_controller Holds the chosen controller
     */
    private $_controller;
    /**
     * @var string $_action Name of the chosen method
     */
    private $_action;
    /**
     * @var array $_config App configurations
     */
    private $_config;
    /**
     * @var \Framework\Router $_router Holds router
     */
    private $_router;
    /**
     * @var \Framework\MatchedRoute $_router Holds matched route
     */
    private $_matchedRoute;
    /**
     * @var \Framework\Request $_request Request object that represents http request
     */
    private $_request;

    /**
     * Constructor of Application class
     *
     * Constructor takes router and app configurations as parameters
     * and defines the matched router
     *
     * @param \Framework\Router $router router
     * @param string            $config app configurations
     *
     * @return \Framework\Application Application object
     */
    public function __construct($router, $config)
    {
        if (file_exists($config)) {
            $this->_config = require_once $config;
        }

        $this->_router       = $router;
        $this->_matchedRoute = $this->_router->matchCurrentRequest();
        $this->_controller   = new $this->_matchedRoute->controller();
        $this->_action       = $this->_matchedRoute->action;
    }


    /**
     * The method to start the app
     *
     * It calls the the method of the controller of matched route
     *
     * @return void
     */
    public function run()
    {
        $controller = $this->_controller;
        $action     = $this->_action;
        $parameters = $this->_matchedRoute->parameters;
        $controller->$action($parameters);
    }

    /**
     * Method to get the chosen controller
     *
     * @return \framework\Controller Chosen controller
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * Method to get the chosen action of the chosen controller
     *
     * @return string Chosen action of chosen controller
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * Method to get the application router
     *
     * @return \Framework\Router Router of app
     */
    public function getRouter()
    {
        return $this->_router;
    }

    /**
     * Method to get the matched route
     *
     * @return \Framework\MatchedRoute Matched route
     */
    public function getMatchedRoute()
    {
        return $this->_matchedRoute;
    }
}