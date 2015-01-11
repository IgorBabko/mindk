<?php
/**
 * File /framework/DI/ServiceInterface.php contains ServiceInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\DI
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\DI;

/**
 * Interface ServiceInterface is used to be implemented by Service class.
 *
 * @api
 *
 * @package Framework\DI
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface ServiceInterface
{
    /**
     * Method to get information of all services used in application.
     *
     * @return array Information of services.
     */
    public static function getServices();

    /**
     * Method for setting new service based on passing parameters.
     *
     * @param string        $name         Service name.
     * @param string        $className    Service class name.
     * @param \Closure|null $resolver     Function to create an instance of service with all needed dependencies.
     * @param array         $params       Parameters for resolver.
     * @param array         $dependencies List of classes service depends on.
     *
     * @return void
     */
    public static function setService($name, $className, $resolver, $params, $dependencies);

    /**
     * Method for setting parameters to particular resolver.
     *
     * Method sets parameters to particular resolver and if no parameters
     * set to resolver yet then all array of parameters will be assigned to resolver parameters
     * otherwise each parameter sets to its particular place of resolver parameters array
     * For a case service parameters have to be set to is singleton setting parameters step will be ignored
     * 'cause for resolvers of singleton services (objects) parameters is set only once in /web/index.php .
     *
     * @param string $name   Service name.
     * @param array  $params Parameters array of particular service resolver.
     *
     * @throws \Framework\Exception\ServiceException ServiceException instance.
     *
     * @return void
     */
    public static function setParams($name, $params);

    /**
     * Method for setting dependencies to the service.
     *
     * @param string $name         Service name to set dependencies to.
     * @param array  $dependencies List of classes current service depends on.
     *
     * @throws \Framework\Exception\ServiceException ServiceException instance.
     *
     * @return void
     */
    public static function setDependencies($name, $dependencies);

    /**
     * Method to set resolvers for specified service.
     *
     * @param string $name    Service name.
     * @param object $resolve Resolver function.
     *
     * @throws \Framework\Exception\ServiceException ServiceException instance.
     *
     * @return void
     */
    public static function setResolver($name, $resolve);

    /**
     * Method to check whether specified in parameters service has any resolvers.
     *
     * @param string $name Service name.
     *
     * @throws \Framework\Exception\ServiceException ServiceException instance.
     *
     * @return bool Service has resolver(s) or doesn't have.
     */
    public static function hasResolver($name);

    /**
     * Method which resolves all dependencies for particular service (object) and create its instance.
     *
     * Method checks whether requested service has resolver and if method can't find one then exception is thrown.
     * When service has resolver then parameters for the resolver is taken from service information
     * array and there will be called resolver with these parameters to instantiate service object.
     * Service that must be instantiated may have some dependencies then names
     * of each dependency will be taken from service information array and current method calls for each
     * dependency to instantiate all dependencies respectively.
     *
     * @param  string $name Service name to be instantiated.
     *
     * @throws \Framework\Exception\ServiceException ServiceException instance.
     *
     * @return mixed Needed instance of requested service.
     */
    public static function resolve($name);
}