<?php
/**
 * File /framework/routing/MatchedRouteInterface.php contains MatchedRouteInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Routing;

/**
 * Interface MatchedRouteInterface is used to be implemented by MatchedRoute class.
 *
 * @api
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface MatchedRouteInterface
{
    /**
     * Method for setting controller to matched route.
     *
     * @param  string $controller controllers name for matched route.
     *
     * @throws \Framework\Exception\MatchedRouteException MatchedRouteException instance.
     *
     * @return void
     */
    public function setControllerName($controller);

    /**
     * Method to get controller name for matched route.
     *
     * @return string controllers name of matched route.
     */
    public function getControllerName();

    /**
     * Method for setting action to matched route.
     *
     * @param  string $action Action to be executed when route matches.
     *
     * @throws \Framework\Exception\MatchedRouteException MatchedRouteException instance.
     *
     * @return void
     */
    public function setActionName($action);

    /**
     * Method to get action name for matched route.
     *
     * @return string Action name for matched route.
     */
    public function getActionName();

    /**
     * Method for setting action parameters to matched route.
     *
     * @param  array $parameters Parameters for defined action.
     *
     * @throws \Framework\Exception\MatchedRouteException MatchedRouteException instance.
     *
     * @return void
     */
    public function setParameters($parameters);

    /**
     * Method for getting action parameters of matched route.
     *
     * @return array Action parameters of matched route.
     */
    public function getParameters();
}