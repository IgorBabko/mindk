<?php
/**
 * File /Framework/Routing/MatchedRoute.php contains MatchedRoute class
 * which holds information of matched route.
 *
 * PHP version 5
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Routing;

/**
 * Class MatchedRoute stores info of matched route.
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class MatchedRoute
{

    /**
     * @var string $controller Controller for matched route
     */
    public $controller;
    /**
     * @var string $action Action for matched route to be executed
     */
    public $action = 'indexAction';
    /**
     * @var array $parameters Action parameters for matched route
     */
    public $parameters = array();

    /**
     * MatchedRoute constructor.
     *
     * @param \Framework\Routing\Route $routeInfo Route which represents info of matched route.
     * @param array                    $params    Action parameters for matched route.
     *
     * @return \Framework\Routing\MatchedRoute MatchedRoute object.
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
     * @param string $controller Controller.
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
     * @param string $action Action to be executed when route matches.
     *
     * @return void
     */
    public function setAction($action)
    {
        $this->action = $action.'Action';
    }

    /**
     * Method for setting action parameters to matched route.
     *
     * @param array $parameters Parameters for defined action.
     *
     * @return void
     */
    public function setParameters($parameters)
    {
        if (empty($this->parameters)) {
            $this->parameters = $parameters;
        } else {
            foreach ($parameters as $name => $value) {
                $this->parameters[$name] = $value;
            }
        }
    }

    /**
     * Method for getting controller of matched route.
     *
     * @return string Controller of matched route.
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Method for getting action of matched route.
     *
     * @return string Action of matched route.
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Method for getting action parameters of matched route.
     *
     * @return array Action parameters of matched route.
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}