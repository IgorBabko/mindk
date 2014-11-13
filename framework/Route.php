<?php
/**
 * /framework/Route.php contains Route class
 */

namespace Framework;

/**
 * Class Route to represent info of available routes in application.
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Route
{

    /**
     * @var string $pattern Holds pattern for the route
     */
    public $pattern;
    /**
     * @var string $controller Holds route controller
     */
    public $controller;
    /**
     * @var string $action Holds route action
     */
    public $action;
    /**
     * @var array|null Holds route security settings
     */
    public $security = array();
    /**
     * @var array|null Holds route requirements (regular expressions)
     */
    public $requirements = array();

    /**
     * Route constructor.
     *
     * Route constructor takes information of route such as pattern, controller, action and so on.
     *
     * @param $routeInfo
     *
     * @return \Framework\Route
     */
    public function __construct($routeInfo)
    {
        $this->pattern      = $routeInfo['pattern'];
        $this->controller   = $routeInfo['controller'];
        $this->action       = $routeInfo['action'];
        $this->security     = isset($routeInfo['security'])?$routeInfo['security']:null;
        $this->requirements = isset($routeInfo['_requirements'])?$routeInfo['_requirements']:null;
    }
}