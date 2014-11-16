<?php
/**
 * File /Framework/Cookie.php contains Cookie class to easy manipulate with cookies.
 *
 * PHP version 5
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

use Framework\Exception\CookieException;

/**
 * Class Cookie represents objects to work with cookies.
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Cookie
{

    /**
     * @const null SESSION Set cookie for a session.
     */
    const SESSION = null;
    /**
     * @const int DAY Set cookie for a day.
     */
    const DAY = 86400;
    /**
     * @const int WEEK Set cookie for a week.
     */
    const WEEK = 604800;
    /**
     * @const int MONTH Set cookie for a month.
     */
    const MONTH = 2592000;
    /**
     * @const int SIX_MONTHS Set cookie for six months.
     */
    const SIX_MONTHS = 15811200;
    /**
     * @const int YEAR Set cookie for a year.
     */
    const YEAR = 31536000;
    /**
     * @const int FOREVER Set cookie forever.
     */
    const FOREVER = -1;

    /**
     * @var array $_cookies Cookies to be sent
     */
    public $cookies = array();


    /**
     * Method checks whether cookie with specified name $name exists or not.
     *
     * @param string $name Cookie name to check.
     *
     * @return bool Does cookie $name exist?
     */
    public function exists($name)
    {
        return isset($this->cookies[$name]);
    }

    /**
     * Method sends all defined cookies.
     *
     * @throws CookieException CookieException instance.
     *
     * @return void
     */
    public function sendCookie()
    {
        if (!headers_sent()) {
            foreach ($this->cookies as $cookieName => $cookieInfo) {
                $retval = setcookie(
                    $cookieName,
                    $cookieInfo['value'],
                    $cookieInfo['expiry'],
                    $cookieInfo['path'],
                    $cookieInfo['domain']
                );
                if ($retval) {
                    $_COOKIE[$cookieName] = $cookieInfo['value'];
                }
            }
        }

        throw new CookieException("Headers has already been set.");
    }


    /**
     * Method adds cookie to $_cookies array.
     *
     * @param string $name   Name of cookie to be added.
     * @param string $value  Value of cookie $name.
     * @param int    $expiry Cookie expiration date.
     * @param string $path   Path where cookie will be available.
     * @param bool   $domain Domain where cookie will be available.
     *
     * @return void
     */
    public function add($name, $value, $expiry = self::ONE_YEAR, $path = '/', $domain = false)
    {

        if ($expiry === -1) {
            $expiry = 1893456000;
        } elseif (is_numeric($expiry)) {
            $expiry += time();
        } else {
            $expiry = strtotime($expiry);
        }
        $this->cookies[$name] = array(
            'value' => $value,
            'expiry' => $expiry,
            'path' => $path,
            'domain' => $domain?$_SERVER['HTTP_HOST']:$domain
        );
    }

    /**
     * Method gets all cookies from $cookies array.
     *
     * @return array Cookies array.
     */
    public function getCookies()
    {
        return $this->cookies;
    }


    /**
     * Method checks whether specified cookie is empty or not.
     *
     * @param string $name Cookie name to check.
     *
     * @throws CookieException CookieException instance.
     *
     * @return bool Is cookie $name empty?
     */
    public function isEmpty($name)
    {

        if ($this->exists($name)) {
            return empty($this->cookie[$name]);
        }

        throw new CookieException("Cookie $name doesn't exists.");
    }

    /**
     * Method returns cookie with specified name $name. When there's no cookie $name
     * it returns value specified in second parameter.
     *
     * @param string $name    Name of cookie value of to be returned.
     * @param mixed  $default Default value to be returned.
     *
     * @return mixed Value of Cookie with name $name or default value.
     */
    public function get($name, $default = '')
    {
        return isset($_COOKIE[$name])?$_COOKIE[$name]:$default;
    }

    /**
     * Method removes cookie with specified name $name.
     * When $global is true then cookie also will be removed from $_COOKIE global array.
     *
     * @param string $name   Name of cookie to be removed.
     * @param string $path   Path where cookie is available.
     * @param bool   $domain Domain where cookie is available.
     * @param bool   $global Should cookie be removed from $_COOKIE global array.
     *
     * @return bool Is cookie successfully removed?
     */
    public function remove($name, $path = '/', $domain = false, $global = false)
    {
        $retval = false;
        if (!headers_sent()) {
            if ($domain === false) {
                $domain = $_SERVER['HTTP_HOST'];
            }

            $retval = setcookie($name, '', time() - 3600, $path, $domain);

            if ($global) {
                unset($_COOKIE[$name]);
            }
        }
        return $retval;
    }
}