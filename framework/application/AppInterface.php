<?php
/**
 * File /framework/application/AppInterface.php contains AppInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Application
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Application;

use Framework\Exception\AppException;
use Framework\Exception\ConfigException;

/**
 * Interface AppInterface is used to be implemented by App class.
 *
 * @api
 *
 * @package Framework\Application
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface AppInterface
{
    /**
     * Method to get database connection.
     *
     * @return object|null SafeSql object that represents database connection.
     */
    public static function getDbConnection();

    /**
     * Method to set database connection object.
     *
     * @param  object $dbConnection Database connection.
     *
     * @throws AppException AppException instance.
     *
     * @return void
     */
    public static function dbConnect($dbConnection);

    /**
     * Method is used to make full preparation before application startup.
     *
     * Method does next steps:
     *     - reflects namespaces to its particular directories and sets loader;
     *     - establishes app configurations;
     *     - sets exception handler for uncaught exceptions;
     *     - collects information about all needed services to successfully resolve all class dependencies;
     *     - establishes database connection
     *     - starts session.
     *
     * @throws AppException    AppException    instance.
     * @throws ConfigException ConfigException instance.
     *
     * @return void
     */
    public static function init();

    /**
     * Method to start the app.
     *
     * It defines the route and calls particular controller's action of matched route.
     *
     * @throws \Framework\Exception\ServiceException ServiceException instance.
     *
     * @return void
     */
    public static function run();
}