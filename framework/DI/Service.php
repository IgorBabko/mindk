<?php
/**
 * File /Framework/DI/Service.php contains Service class which allows simply resolve all dependencies
 * instantiating particular object.
 *
 * PHP version 5
 *
 * @package Framework\DI
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\DI;

use Framework\Exception\ServiceException;

/**
 * Class Service for representing and storing class dependencies.
 *
 * @package Framework\DI
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Service
{

    /**
     * @static
     * @var array $services Holds all needed services (objects) for application
     */
    public static $services = array();

    /**
     * Method for setting new service based on passing parameters.
     *
     * @param string $name         Service name.
     * @param string $className    Service classname.
     * @param null   $resolver     Function to create an instance of service with all needed dependencies.
     * @param array  $params       Parameters for resolver.
     * @param array  $dependencies List of classes service depends on.
     *
     * @return void
     */
    public static function setService(
        $name,
        $className,
        $resolver = null,
        $params = array(),
        $dependencies = array()
    ) {
        self::$services[$name]              = array();
        self::$services[$name]['className'] = $className;
        self::setParams($name, $params);
        self::setDependencies($name, $dependencies);
        self::setResolver($name, $resolver);
    }

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
     * @return void
     */
    public static function setParams($name, $params)
    {
        if (!isset(self::$services[$name]['parameters'])) {
            self::$services[$name]['parameters'] = $params;
        } else {
            foreach ($params as $paramName => $value) {
                self::$services[$name]['parameters'][$paramName] = $value;
            }
        }
    }

    /**
     * Method for setting dependencies to the service.
     *
     * @param string $name         Service name to set dependencies to.
     * @param array  $dependencies List of classes current service depends on.
     *
     * @return void
     */
    public static function setDependencies($name, $dependencies)
    {
        self::$services[$name]['dependencies'] = $dependencies;
    }

    /**
     * Method to set resolvers for specified service.
     *
     * @param string $name    Service name.
     * @param object $resolve Resolver function.
     *
     * @return void
     */
    public static function setResolver($name, $resolve)
    {
        self::$services[$name]['resolver'] = $resolve;
    }

    /**
     * Method to check whether specified in parameters service has any resolvers.
     *
     * @param string $name Service name.
     *
     * @return bool Service has resolver(s) or doesn't have.
     */
    public static function hasResolver($name)
    {
        return isset(self::$services[$name]['resolver']);
    }

    /**
     * Method which resolves all dependencies for particular service (object) and create its instance.
     *
     * Method whether request service has resolver and if method can't find one then Exception is thrown.
     * When service has resolver then parameters for the resolver is taken from service information
     * array and there calls resolver with these parameters to instantiate service object.
     * Service that must be instantiated may have some dependencies then names
     * of each dependency will be taken from service information array and current method calls for each
     * dependency to instantiate all dependencies respectively.
     *
     * @param  string $name Service name to be instantiated.
     *
     * @throws ServiceException ServiceException instance.
     *
     * @return mixed Needed instance of requested service.
     */
    public static function resolve($name)
    {
        if (self::hasResolver($name)) {
            $params = self::$services[$name]['parameters'];

            if (!empty(self::$services[$name]['dependencies'])) {
                $dependencies = self::$services[$name]['dependencies'];
                foreach ($dependencies as $n => $className) {
                    $params[$n] = self::resolve($n);
                }
            }

            $resolver = self::$services[$name]['resolver'];
            $service = $resolver($params);

            return $service;
        }

        throw new ServiceException("$name service has not been registered.");
    }
}