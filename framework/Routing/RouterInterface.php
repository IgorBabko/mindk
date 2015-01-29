<?php
/**
 * File /framework/routing/RouterInterface.php contains RouterInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Routing;

use Framework\Exception\ForbiddenException;
use Framework\Exception\HttpNotFoundException;

/**
 * Interface RouterInterface is used to be implemented by Router class.
 *
 * @api
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface RouterInterface
{
    /**
     * Method to get route collection.
     *
     * @return object|null Route collection.
     */
    public function getRouteCollection();

    /**
     * Method to set route collection.
     *
     * @param $routeCollection Route collection to set.
     *
     * @return void
     */
    public function setRouteCollection($routeCollection);

    /**
     * Method to get host.
     *
     * @return string Host.
     */
    public function getHost();

    /**
     * Method to add route to routeCollection.
     *
     * @param  string $routeName Name of new route.
     * @param  Route  $route     New route.
     *
     * @return void
     */
    public function addRoute($routeName, Route $route);

    /**
     * Method which defines matched route.
     *
     * Method runs foreach loop to take each route and check it for matching with request. It's necessary to check
     * whether current route has some http method restrictions. Empty array which is supposed to hold all allowed http methods
     * for route means that any method is allowed, but if http methods array specified and current http request does not match
     * any of methods from method array loop gets next iteration with next route to check.
     * If current route holds any placeholders they have to be replaced with its regular expressions from requirements array.
     * If all specified parameters in url satisfy its regular expressions route object that satisfies route pattern is returned from route collection.
     * When there's no placeholders in url it simply compares url with each route pattern and if match happens
     * route that satisfies route pattern will be returned.
     * If method could not detect any valid route from routeCollection for specified url it throws an HttpNotFountException instance.
     *
     * @throws HttpNotFoundException HttpNotFoundException instance.
     * @throws ForbiddenException    ForbiddenException    instance.
     *
     * @return object Route which will handle http request.
     */
    public function matchCurrentRequest();

    /**
     * Method to generate url according to given parameters and route name.
     *
     * Method generates url according to specified name (first parameter)
     * and list of parameters of the route (second parameter). If no such name of route is found
     * in routeCollection exception throws. If search of route by name succeed it gets pattern of found route.
     * In case parameters array for url to be generated isn't set then method immediately returns pattern but
     * when parameters array isn't empty it replaces all placeholders from pattern on its particular values from
     * parameters array and only then generated url will be returned.
     *
     * @param string $routeName Name of route to generate.
     * @param array  $params    Params for route to generate.
     *
     * @throws \Framework\Exception\RouterException RouterException instance.
     *
     * @return string Generated url.
     */
    public function generateRoute($routeName, $params);
}