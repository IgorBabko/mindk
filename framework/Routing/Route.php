<?php
/**
 * File /framework/routing/Route.php contains Route class which keeps information of particular route
 *
 * PHP version 5
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Routing;

use Framework\Exception\RouteException;

/**
 * Class Route to represent info of available routes in application.
 * Default implementation of {@link RouteInterface}.
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Route implements RouteInterface
{
    /**
     * @var string $_pattern Holds pattern for the route
     */
    private $_pattern;

    /**
     * @var string $_controller Holds route controller
     */
    private $_controller;

    /**
     * @var string $_action Holds route action
     */
    private $_action;

    /**
     * @var array $_security Holds route security settings
     */
    private $_security = array();

    /**
     * @var array $_requirements Holds route requirements (regular expressions)
     */
    private $_requirements = array();

    /**
     * @var array $_parameters Parameters for action of current route.
     */
    private $_parameters = array();

    /**
     * Route constructor.
     *
     * Route constructor takes information of route such as pattern, controller, action and so on.
     *
     * @param  array $routeInfo Information of particular route.
     *
     * @return object Route.
     */
    public function __construct($routeInfo)
    {
        $this->_pattern = $routeInfo['pattern'];
        $this->_controller = $routeInfo['controller'];
        $this->_action = $routeInfo['action'];

        $this->_security = isset($routeInfo['security']) ? $routeInfo['security'] : null;
        $this->_requirements = isset($routeInfo['_requirements']) ? $routeInfo['_requirements'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        return $this->_parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function setParameters($parameters)
    {
        if (is_array($parameters)) {
            $this->_parameters = $parameters;
        } else {
            $parameterType = gettype($parameters);
            throw new RouteException(
                500, "<strong>Internal server error:</strong> parameter for Route::setParameters method must be 'array', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPattern()
    {
        return $this->_pattern;
    }

    /**
     * {@inheritdoc}
     */
    public function getControllerName()
    {
        return $this->_controller;
    }

    /**
     * {@inheritdoc}
     */
    public function getActionName()
    {
        return $this->_action;
    }

    /**
     * {@inheritdoc}
     */
    public function getSecurity()
    {
        return $this->_security;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequirements()
    {
        return $this->_requirements;
    }

    /**
     * {@inheritdoc}
     */
    public function setAction($action)
    {
        if (is_string($action)) {
            $this->_action = $action;
        } else {
            $parameterType = gettype($action);
            throw new RouteException(
                500, "<strong>Internal server error:</strong> parameter for Route::setAction method must be 'string', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setController($controller)
    {
        if (is_string($controller)) {
            $this->_controller = $controller;
        } else {
            $parameterType = gettype($controller);
            throw new RouteException(
                500, "<strong>Internal server error:</strong> parameter for Route::setController method must be 'string', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setPattern($pattern)
    {
        if (is_string($pattern)) {
            $this->_pattern = $pattern;
        } else {
            $parameterType = gettype($pattern);
            throw new RouteException(
                500, "<strong>Internal server error:</strong> parameter for Route::setPattern method must be 'string', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setRequirements($requirements)
    {
        if (is_array($requirements)) {
            $this->_requirements = $requirements;
        } else {
            $parameterType = gettype($requirements);
            throw new RouteException(
                500, "<strong>Internal server error:</strong> parameter for Route::setRequirements method must be 'array', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setSecurity($security)
    {
        if (is_array($security)) {
            $this->_security = $security;
        } else {
            $parameterType = gettype($security);
            throw new RouteException(
                500, "<strong>Internal server error:</strong> parameter for Route::setSecurity method must be 'array', '$parameterType' is given"
            );
        }
    }
}