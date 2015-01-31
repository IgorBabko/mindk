<?php
/**
 * File /framework/response/ResponseRedirect.php contains ResponseRedirect class
 * to use redirection.
 *
 * PHP version 5
 *
 * @package Framework\Response
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Response;

use Framework\Config\Config;
use Framework\Exception\ResponseRedirectException;

/**
 * Class ResponseRedirect is used to make redirection.
 * Default implementation of {@link ResponseRedirectInterface}.
 *
 * @package Framework\Response
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ResponseRedirect implements ResponseRedirectInterface
{
    /**
     * @static
     * @var ResponseRedirect|null $_instance ResponseRedirect instance
     */
    private static $_instance = null;

    /**
     * ResponseRedirect constructor.
     *
     * @return object ResponseRedirect.
     */
    private function __construct()
    {
    }

    /**
     * Method to clone objects of its class.
     *
     * @return object ResponseRedirect.
     */
    private function __clone()
    {
    }

    /**
     * Method returns ResponseRedirect instance creating it if it's not been instantiated before
     * otherwise existed ResponseRedirect object will be returned.
     *
     * @return object ResponseRedirect.
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
    public function home($permanent = false)
    {
        if ($permanent) {
            header('HTTP/1.1 301 Moved Permanently');
        }
        header('Location: /');
        exit();
    }

    /**
     * {@inheritdoc}
     */
    public function back($permanent = false)
    {
        if ($permanent) {
            header('HTTP/1.1 301 Moved Permanently');
        }
        $_SERVER['HTTP_REFERER'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    /**
     * {@inheritdoc}
     */
    public function route($routeName, $permanent = false)
    {
        $routes = Config::getSetting("routes");
        if (is_string($routeName)) {
            if ($permanent) {
                header('HTTP/1.1 301 Moved Permanently');
            }

            header('Location: ' . $routes[$routeName]['pattern']);
            exit();
        } else {
            $parameterType = gettype($routeName);
            throw new ResponseRedirectException(
                500, "<strong>Internal server error:</strong> route name for ResponseRedirect::route method must be 'string', '$parameterType' is given'"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function to($url, $permanent = false)
    {
        if (is_string($url)) {
            if ($permanent) {
                header('HTTP/1.1 301 Moved Permanently');
            }
            header('Location: ' . $url);
            exit();
        } else {
            $parameterType = gettype($url);
            throw new ResponseRedirectException(
                500, "<strong>Internal server error:</strong> URL for ResponseRedirect::to method must be 'string', '$parameterType' is given'"
            );
        }
    }
}