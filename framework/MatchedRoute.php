<?php
/**
 * /framework/MatchedRoute.php contains MatchedRoute class
 */

namespace Framework;

/**
 * Class MatchedRoute stores info of matched route
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class MatchedRoute
{

    /**
     * @var string $controller Controller for matched route
     */
    public $controller = 'Blog\\Controller\\HelloController';
    /**
     * @var string $action Action for matched route to be executed
     */
    public $action = 'indexAction';
    /**
     * @var array $parameters Action parameters for matched route
     */
    public $parameters = array();

    /**
     * MatchedRoute constructor
     *
     * @param Route $routeInfo Route which represents info of matched route
     * @param array $params    Action parameters for matched route
     *
     * @return \Framework\MatchedRoute
     */
    public function __construct(Route $routeInfo = null, $params = array())
    {
        if ($routeInfo) {
            $this->controller = $routeInfo->controller;
            $this->action     = $routeInfo->action.'Action';
            $this->parameters = !empty($params)?$params:array();
        }
    }

    /**
     * Method for setting controller to matched route.
     *
     * @param string $controller
     *
     * @return void
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * Method for setting action to matched route.
     *
     * @param $action
     *
     * @return void
     */
    public function setAction($action)
    {
        $this->action = $action.'Action';
    }

    /**
     * Method for setting action parameters to matched route
     *
     * @param $parameters
     *
     * @return void
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Method for getting controller of matched route.
     *
     * @return string Controller of matched route
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Method for getting action of matched route.
     *
     * @return string Action of matched route
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Method for getting action parameters of matched route.
     *
     * @return array Action parameters of matched route
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}