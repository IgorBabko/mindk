<?php
/**
 * File /framework/routing\RouteCollection.php contains RouteCollection class
 * which keeps information of all available in application routes.
 *
 * PHP version 5
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Routing;

use Framework\Exception\RouteCollectionException;

/**
 * Class RouteCollection to store information about all available routes.
 * Default implementation of {@link RouteCollectionInterface}.
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class RouteCollection implements RouteCollectionInterface
{
    /**
     * @static
     * @var RouteCollection|null $_instance RouteCollection instance
     */
    private static $_instance = null;

    /**
     * @var array $_routes Array to store info of all available routes
     */
    private $_routes = array();

    /**
     * RouteCollection constructor.
     *
     * @return \Framework\Routing\RouteCollection RouteCollection object.
     */
    private function __construct()
    {
    }

    /**
     * Method to clone objects of its class.
     *
     * @return \Framework\Routing\RouteCollection RouteCollection instance.
     */
    private function __clone()
    {
    }

    /**
     * Method returns RouteCollection instance creating it if it's not been instantiated before
     * otherwise existed RouteCollection object will be returned.
     *
     * @return \Framework\Routing\RouteCollection RouteCollection instance.
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * {@inheritdoc}
     */
    public function setRoute($routeName, Route $routeInfo)
    {
        if (is_string($routeName)) {
            $this->_routes[$routeName] = $routeInfo;
        } else {
            $parameterType = gettype($routeName);
            throw new RouteCollectionException("001", "First parameter for RouteCollection::setRoute method must be 'string', '$parameterType' is given'");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        return $this->_routes;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoute($routeName) {
        if (isset($this->_routes[$routeName])) {
            return $this->_routes[$routeName];
        } else {
            throw new RouteCollectionException("001", "'$routeName' doesn't exist");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function info()
    {
        foreach ($this->_routes as $name) {
            info($name);
        }
    }
}   