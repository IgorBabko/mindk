<?php
/**
 * File /framework/Routing\RouteCollection.php contains RouteCollection class
 * which keeps information of all available in application routes.
 *
 * PHP version 5
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Routing;

/**
 * Class RouteCollection to store information about all available routes.
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class RouteCollection
{
    /**
     * @var array $routes Array to store info of all available routes
     */
    public $routes = array();

    /**
     * Method to set new route to the routeCollection.
     *
     * @param string                   $routeName Name of new route.
     * @param \Framework\Routing\Route $routeInfo Info of new route (pattern, controller, action).
     *
     * @return void
     */
    public function setRoute($routeName, $routeInfo)
    {
        $this->routes[$routeName] = $routeInfo;
    }

    /**
     * Method to display info about all available routes.
     *
     * @return void
     */
    public function info()
    {
        foreach ($this->routes as $name) {
            info($name);
        }
    }
}   