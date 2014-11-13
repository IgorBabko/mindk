<?php
/**
 * /framework/RouteCollection.php contains RouteCollection class
 */

namespace Framework;

/**
 * Class RouteCollection to store information about all available paths.
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
     * Method to set
     *
     * @param string           $routeName Name of new route
     * @param \Framework\Route $routeInfo Info of new route (pattern, controller, action)
     */
    /*public function setRoute($routeName, $routeInfo)
    {
        $this->routes[$routeName] = $routeInfo;
    }*/

    /**
     * Method to add new rote to the routeCollection.
     *
     * @param string           $routeName Name of new route
     * @param \Framework\Route $routeInfo Info of new route (pattern, controller, action)
     *
     * @return void
     */
    public function add($routeName, $routeInfo)
    {
        $this->routes[$name] = $route;
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