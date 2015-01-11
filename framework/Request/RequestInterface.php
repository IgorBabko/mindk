<?php
/**
 * File /framework/request/RequestInterface.php contains RequestInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Request
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Request;

use Framework\Cookie\Cookie;
use Framework\Session\Session;

/**
 * Interface RequestInterface is used to be implemented by Request class.
 *
 * @api
 *
 * @package Framework\Request
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface RequestInterface
{
    /**
     * Method which returns request uri.
     *
     * @return string Request uri.
     */
    public function getURI();

    /**
     * Method which returns all request headers.
     *
     * @return array Request headers.
     */
    public function getHeaders();

    /**
     * Method returns particular header specified in $name parameter.
     *
     * @param  string $name Name of request header to be returned.
     *
     * @return string|null Request header.
     */
    public function getHeader($name);

    /**
     * Method returns http request method.
     *
     * @return string Http Request method.
     */
    public function getRequestMethod();

    /**
     * Method returns Cookie object to work with http cookies using oop paradigm.
     *
     * @return Cookie Cookie value.
     */
    public function getCookie();

    /**
     * Method returns Session object to work with http session using oop paradigm.
     *
     * @return Session Session object.
     */
    public function getSession();

    /**
     * Method to return value of environment variable $name.
     *
     * @param  string $name Name of environment variable value of to be returned.
     *
     * @return string|null Value of environment variable $name.
     */
    public function getEnv($name);

    /**
     * Method to return values from $_REQUEST global array.
     *
     * @param  string $name $_REQUEST variable name.
     *
     * @return string|null Value of $_REQUEST $name variable.
     */
    public function get($name);

    /**
     * Method to return values from $_POST global array.
     *
     * @param  string $name $_POST variable name.
     *
     * @return string|null Value of $_POST $name variable.
     */
    public function getPost($name);

    /**
     * Method to return values from $_GET global array.
     *
     * @param  string $name $_GET variable name.
     *
     * @return string|null Value of $_GET $name variable.
     */
    public function getQuery($name);

    /**
     * Method to return values from $_SERVER global array.
     *
     * @param  string $name $_SERVER variable name.
     *
     * @return string|null Value of $_SERVER $name variable.
     */
    public function getServer($name);

    /**
     * Method checks whether variable with specified name exists in $_REQUEST global array or not.
     *
     * @param  string $name $_REQUEST variable name.
     *
     * @return bool Does variable exist in $_REQUEST global array?
     */
    public function has($name);

    /**
     * Method checks whether variable with specified name exists in $_POST global array or not.
     *
     * @param  string $name $_POST variable name.
     *
     * @return bool Does variable exist in $_POST global array?
     */
    public function hasPost($name);

    /**
     * Method checks whether variable with specified name exists in $_GET global array or not.
     *
     * @param  string $name $_GET variable name.
     *
     * @return bool Does variable exist in $_GET global array?
     */
    public function hasQuery($name);

    /**
     * Method checks whether variable with specified name exists in $_SERVER global array or not.
     *
     * @param  string $name $_SERVER variable name.
     *
     * @return bool Does variable exist in $_SERVER global array?
     */
    public function hasServer($name);

    /**
     * Method returns http scheme.
     *
     * @return string Http scheme.
     */
    public function getScheme();

    /**
     * Method checks whether request is ajax.
     *
     * @return bool Is request ajax?
     */
    public function isAjax();

    /**
     * Method returns server address.
     *
     * @return string Server address.
     */
    public function getServerAddress();

    /**
     * Method returns server name.
     *
     * @return string Server name.
     */
    public function getServerName();

    /**
     * Method returns http host.
     *
     * @return string Http host.
     */
    public function getHttpHost();

    /**
     * Method returns client address.
     *
     * @return string Client address.
     */
    public function getClientAddress();

    /**
     * Method returns user agent.
     *
     * @return string User agent.
     */
    public function getUserAgent();

    /**
     * Compare http request method with specified method in $name parameter.
     *
     * @param  string $name Http method name to compare to current request method.
     *
     * @return bool Does current http request method matches $name request method?
     */
    public function isMethod($name);
}