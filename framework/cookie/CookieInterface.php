<?php
/**
 * File /framework/config/CookieInterface.php contains CookieInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Cookie
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Cookie;

/**
 * Interface CookieInterface is used to be implemented by Cookie class.
 *
 * @api
 *
 * @package Framework\Cookie
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface CookieInterface
{
    /**
     * Method to return all cookies that is prepared to send.
     *
     * @return array Cookies array.
     */
    public function getCookies();

    /**
     * Method checks whether cookie with specified name $name exists or not.
     *
     * @param  string $name Cookie name to check.
     *
     * @throws \Framework\Exception\CookieException CookieException instance.
     *
     * @return bool Does cookie $name exist?
     */
    public function exists($name);

    /**
     * Method sends all defined cookies.
     *
     * @throws \Framework\Exception\CookieException CookieException instance.
     *
     * @return bool True if all cookie has been set successfully.
     */
    public function send();

    /**
     * Method adds cookie to $_cookies array.
     *
     * @param string $name Name of cookie to be added.
     * @param string $value Value of cookie $name.
     * @param int $expiry cookie expiration date.
     * @param string $path Path where cookie will be available.
     * @param bool $domain Domain where cookie will be available.
     *
     * @return void
     */
    public function add($name, $value, $expiry, $path, $domain);

    /**
     * Method checks whether specified cookie is empty or not.
     *
     * @param string $name cookie name to check.
     *
     * @throws \Framework\Exception\CookieException CookieException instance.
     *
     * @return bool Is cookie $name empty?
     */
    public function isEmpty($name);

    /**
     * Method returns cookie with specified name $name. When there's no cookie $name
     * it returns value specified in second parameter.
     *
     * @param string $name Name of cookie value of to be returned.
     * @param mixed $default Default value to be returned.
     *
     * @return mixed Value of cookie with name $name or default value.
     */
    public function get($name, $default);

    /**
     * Method removes cookie with specified name $name.
     * When $global is true then cookie also will be removed from $_COOKIE global array.
     *
     * @param  string $name Name of cookie to be removed.
     * @param  string $path Path where cookie is available.
     * @param  bool $domain Domain where cookie is available.
     * @param  bool $global Should cookie be removed from $_COOKIE global array.
     *
     * @throws \Framework\Exception\CookieException CookieException instance.
     *
     * @return bool Is cookie successfully removed?
     */
    public function remove($name, $path, $domain, $global);
}