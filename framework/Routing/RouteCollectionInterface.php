<?php
/**
 * File /framework/routing/RouteCollectionInterface.php contains RouteCollectionInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Routing;

/**
 * Interface RouteCollectionInterface is used to be implemented by RouteCollection class.
 *
 * @api
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface RouteCollectionInterface
{
    /**
     * Method to set new route to the routeCollection.
     *
     * @param  string                   $routeName Name of new route.
     * @param  \Framework\Routing\Route $routeInfo Info of new route (pattern, controller, action).
     *
     * @throws \Framework\Exception\RouteCollectionException RouteCollectionException instance.
     * @return void
     */
    public function setRoute($routeName, Route $routeInfo);

    /**
     * Method to get available routes in route collection.
     *
     * @return array Available routes in route collection.
     */
    public function getRoutes();

    /**
     * Method to get info of specified route.
     *
     * @param  string $routeName Name of route to get.
     *
     * @throws \Framework\Exception\RouteCollectionException RouteCollectionException instance.
     *
     * @return Route Route object that represents info of current route.
     */
    public function getRoute($routeName);

    /**
     * Method to display info about all available routes.
     *
     * @return void
     */
    public function info();
}