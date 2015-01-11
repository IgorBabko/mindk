<?php
/**
 * File /framework/routing/RouteInterface.php contains RouteInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Routing;

/**
 * Interface RouteInterface is used to be implemented by Route class.
 *
 * @api
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface RouteInterface
{
    /**
     * Method to get parameters for action of current route.
     *
     * @return array Parameters for action of current route.
     */
    public function getParameters();

    /**
     * Method to get pattern or current route.
     *
     * @return string Pattern of current route.
     */
    public function getPattern();

    /**
     * Method to get controller name of current route.
     *
     * @return string controllers name of current route.
     */
    public function getControllerName();

    /**
     * Method to get action name of current route.
     *
     * @return string Action name of current route.
     */
    public function getActionName();

    /**
     * Method to get role for who this route is available.
     *
     * @return array|null Role for who this route is available.
     */
    public function getSecurity();

    /**
     * Method to get specific constraints for current route.
     *
     * @return array|null Specific constraints for current route.
     */
    public function getRequirements();

    /**
     * Method to set parameters for action of current route.
     *
     * @param  array $parameters Array of parameters.
     *
     * @throws \Framework\Exception\RouteException RouteException instance.
     *
     * @return void
     */
    public function setParameters($parameters);

    /**
     * Method to set action name for current route.
     *
     * @param  string $action Action name for current route.
     *
     * @throws \Framework\Exception\RouteException RouteException instance.
     *
     * @return void
     */
    public function setAction($action);

    /**
     * Method to set controller name for current route.
     *
     * @param  string $controller controllers name for current route.
     *
     * @throws \Framework\Exception\RouteException RouteException instance.
     *
     * @return void
     */
    public function setController($controller);

    /**
     * Method to set pattern for current route.
     *
     * @param  string $pattern Pattern for current route.
     *
     * @throws \Framework\Exception\RouteException RouteException instance.
     *
     * @return void
     */
    public function setPattern($pattern);

    /**
     * Method to set specific requirements for current route.
     *
     * @param  array|null $requirements Specific requirements for current route.
     *
     * @throws \Framework\Exception\RouteException RouteException instance.
     *
     * @return void
     */
    public function setRequirements($requirements);

    /**
     * Method to set role who can use current role.
     *
     * @param  array|null $security Role who can use current role.
     *
     * @throws \Framework\Exception\RouteException RouteException instance.
     *
     * @return void
     */
    public function setSecurity($security);
}