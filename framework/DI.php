<?php
/**
 * /framework/DI contains DI class.
 */

namespace Framework;

/**
 * Class DI for representing and storing class dependencies.
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class DI
{

    /**
     * @static
     * @var array $services Holds all needed services (objects) for application
     */
    public static $services = array();

    /**
     * Method for setting new service based on passing parameters.
     *
     * @param string $name         Service name
     * @param string $className    Classname of service
     * @param null   $resolver     Function to create an instance of service with all needed dependencies
     * @param array  $params       Parameters for resolver
     * @param array  $dependencies List of classes service depends on
     * @param bool   $isSingleton  Whether service is singleton or not
     */
    public static function setService(
        $name,
        $className,
        $resolver = null,
        $params = array(),
        $dependencies = array(),
        $isSingleton = false
    ) {

        self::$services[$name]                = array();
        self::$services[$name]['className']   = $className;
        self::$services[$name]['isSingleton'] = $isSingleton;
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
     * 'cause for resolvers of singleton services (objects) parameters is set only once in /web/index.php
     *
     * @param string $name   Service name
     * @param array  $params Parameters array of particular service resolver
     *
     * @return void
     */
    public static function setParams($name, $params)
    {

        if (isset(self::$services[$name]['instance'])) {
            return;
        } elseif (!isset(self::$services[$name]['parameters'])) {
            self::$services[$name]['parameters'] = $params;
        } else {
            foreach ($params as $paramName => $value) {
                self::$services[$name]['parameters'][$paramName] = $value;
            }
        }
    }

    /**
     * Method for setting dependencies to the service
     *
     * @param string $name         Service name to set dependencies to
     * @param        $dependencies List of classes current service depends on
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
     * @param string $name    Service name
     * @param object $resolve Resolver function
     */
    public static function setResolver($name, $resolve)
    {
        self::$services[$name]['resolver'] = $resolve;
    }

    /**
     * Method to check whether specified in parameters service has any resolvers.
     *
     * @param string $name Service name
     *
     * @return bool Service has resolver(s) or doesn't have
     */
    public static function hasResolver($name)
    {
        return isset(self::$services[$name]['resolver']);
    }

    /**
     * @param $name
     */
    /*public static function resolveAsSingleton($name)
    {
    }*/

    /**
     * Method which resolves all dependencies for particular service (object) and create its instance
     *
     * Method checks if the request service is singleton and if so it immediately returns its instance
     * otherwise there's check whether request service has resolver
     * and if method can't find one then exceptions is thrown. When service has resolver then parameters for
     * the resolver is taken from service information array and there calls resolver with these parameters
     * to instantiate service object. Service that must be instantiated may have some dependencies then
     * names of each dependency will be taken from service information array and current method calls for each
     * dependency to instantiate all dependencies respectively.
     *
     * @param string $name Service name to be instantiated
     *
     * @return mixed Needed instance of requested service
     */
    public static function resolve($name)
    {

        if (isset(self::$services[$name]['instance'])) {
            return self::$services[$name]['instance'];
        }

        if (self::hasResolver($name)) {
            $params = self::$services[$name]['parameters'];

            if (!empty(self::$services[$name]['dependencies'])) {
                $dependencies = self::$services[$name]['dependencies'];
                foreach ($dependencies as $n => $className) {
                    $params[$n] = self::resolve($n);
                    if (self::$services[$n]['isSingleton'] && !isset(self::$services[$n]['instance'])) {
                        self::$services[$n]['instance'] = $params[$n];
                    }
                }
            }

            $resolver = self::$services[$name]['resolver'];
            $service  = $resolver($params);
            if (self::$services[$name]['isSingleton']) {
                self::$services[$name]['instance'] = $service;
            }

            return $service;
        }
        echo 'error';
        //throw new Exception('Nothing registered with that name, fool.');
    }
}