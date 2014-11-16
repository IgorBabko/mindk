<?php
/**
 * File /Framework/RouteCollection.php contains RouteCollection class
 * which keeps information of all available in application routes.
 *
 * PHP version 5
 *
 * @package Framework.
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

/**
 * Class RouteCollection to store information about all available routes.
 *
 * @package Framework
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
     * @param string           $routeName Name of new route.
     * @param \Framework\Route $routeInfo Info of new route (pattern, controller, action).
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