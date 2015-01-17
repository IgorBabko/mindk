<?php
/**
 * File /framework/cookie/Cookie.php contains Cookie class to easy manipulate with cookies.
 *
 * PHP version 5
 *
 * @package Framework\Cookie
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Cookie;

use Framework\Exception\CookieException;

/**
 * Class cookie represents objects to work with cookies.
 * Default implementation of {@link CookieInterface}.
 *
 * @package Framework\Cookie
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Cookie implements CookieInterface
{
    /**
     * @static
     * @var Cookie|null $_instance Cookie instance
     */
    private static $_instance = null;

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
    private $_cookies = array();

    /**
     * Cookie constructor.
     *
     * @return \Framework\Cookie\Cookie Cookie object.
     */
    private function __construct()
    {
    }

    /**
     * Method to clone objects of its class.
     *
     * @return \Framework\Cookie\Cookie Cookie instance.
     */
    private function __clone()
    {
    }

    /**
     * Method returns Cookie instance creating it if it's not been instantiated before
     * otherwise existed Cookie object will be returned.
     *
     * @return \Framework\Cookie\Cookie Cookie instance.
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * {@inheritdoc}
     */
    public function getCookies()
    {
        return $this->_cookies;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
        if (is_string($name)) {
            return isset($_COOKIE[$name]);
        } else {
            $parameterType = gettype($name);
            throw new CookieException("001", "Parameter for Cookie::exists method must be 'string', '$parameterType' is given");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        if (!headers_sent()) {
            foreach ($this->_cookies as $cookieName => $cookieInfo) {
                $returnValue = setcookie(
                    $cookieName,
                    $cookieInfo['value'],
                    $cookieInfo['expiry'],
                    $cookieInfo['path'],
                    $cookieInfo['domain']
                );
                if ($returnValue) {
                    $_COOKIE[$cookieName] = $cookieInfo['value'];
                } else {
                    throw new CookieException("003", "Cookie '$cookieName' has not be set successfully.");
                }
            }
        } else {
            throw new CookieException("001", "Headers has already been sent.");
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function add($name, $value, $expiry = self::YEAR, $path = '/', $domain = false)
    {
        if ($expiry === -1) {
            $expiry = 1893456000;
        } elseif (is_numeric($expiry)) {
            $expiry += time();
        } else {
            $expiry = strtotime($expiry);
        }
        $this->_cookies[$name] = array(
            'value'  => $value,
            'expiry' => $expiry,
            'path'   => $path,
            'domain' => $domain?$_SERVER['HTTP_HOST']:$domain
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty($name)
    {
        if ($this->exists($name)) {
            return empty($this->_cookies[$name]);
        } else {
            throw new CookieException("003", "cookie '$name' doesn't exists.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get($name, $default = '')
    {
        return isset($_COOKIE[$name])?$_COOKIE[$name]:$default;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($name, $path = '/', $domain = false, $global = true)
    {
        if (!headers_sent()) {
            if ($domain === false) {
                $domain = $_SERVER['HTTP_HOST'];
            }

            $returnValue = setcookie($name, '', time() - 3600, $path, $domain);

            if ($global) {
                unset($_COOKIE[$name]);
            }
            return $returnValue;
        } else {
            throw new CookieException("003", "Headers has been sent already");
        }
    }
}