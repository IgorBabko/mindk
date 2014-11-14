<?php
/**
 * File /framework/Request.php contains Request class is used
 * to manipulated with http request easily.
 *
 * PHP version 5
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

/**
 * Class Request - representation of http request.
 *
 * Class contains all needed information of http request such as cookie, session variables
 * http method, request headers, http url, GET data, POST data, SERVER data etc.
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Request
{

    /**
     * @var \Framework\Cookie $_cookie Cookie object
     */
    public $cookie;
    /**
     * @var \Framework\Session $_session Session object
     */
    public $session;
    /**
     * @var string $_uri Request uri
     */
    public $uri;
    /**
     * @var string $_method Request method
     */
    public $method;
    /**
     * @var array $_headers Array of request headers
     */
    public $headers = array();

    /**
     * Request constructor.
     *
     * Request constructor:
     *  - takes session object and cookie object as parameters;
     *  - defines request method and request uri.
     *
     * @param \Framework\Session|null $session Session object.
     * @param \Framework\Cookie|null  $cookie  Cookie  object.
     *
     * @return \Framework\Request Request object.
     */
    public function __construct($session = null, $cookie = null)
    {
        $this->headers = apache_request_headers();
        $this->method  = $_SERVER['REQUEST_METHOD'];
        $this->url     = $_SERVER['REQUEST_URI'];
        $this->session = $session;
        $this->cookie  = $cookie;
    }

    /**
     * Method which returns request uri.
     *
     * @return string Request uri.
     */
    public function getURI()
    {
        return $this->uri;
    }

    /**
     * Method which returns all request headers.
     *
     * @return array Request headers.
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Method returns particular header specified in $name parameter.
     *
     * @param string $name Name of request header to be returned.
     *
     * @return string|null Request header.
     */
    public function getHeader($name)
    {
        return isset($headers[$name])?$headers[$name]:null;
    }

    /**
     * Method returns http request method.
     *
     * @return string Http request method.
     */
    public function getRequestMethod()
    {
        return $this->method;
    }

    /**
     * Method returns cookie value with name $name.
     *
     * @param string $name Cookie name value of to be returned.
     *
     * @return string|null Cookie value.
     */
    public function getCookie($name)
    {
        return $this->cookie->get($name);
    }

    /**
     * Method returns session variable $name.
     *
     * @param string $name Name of session variable.
     *
     * @return string|null value of session variable $name.
     */
    public function getSessionVar($name)
    {
        return $this->session->get($name);
    }

    /**
     * Method to return value of environment variable $name.
     *
     * @param string $name Name of environment variable value of to be returned.
     *
     * @return string|null Value of environment variable $name.
     */
    public function getEnv($name)
    {
        return isset($_ENV[$name])?$_ENV[$name]:null;
    }

    /**
     * Method to return values from $_REQUEST global array.
     *
     * @param string $name $_REQUEST variable name.
     *
     * @return string|null Value of $_REQUEST $name variable.
     */
    public function get($name)
    {
        return isset($_REQUEST[$name])?$_REQUEST[$name]:null;
    }

    /**
     * Method to return values from $_POST global array.
     *
     * @param string $name $_POST variable name.
     *
     * @return string|null Value of $_POST $name variable.
     */
    public function getPost($name)
    {
        return isset($_POST[$name])?$_POST[$name]:null;
    }

    /**
     * Method to return values from $_GET global array.
     *
     * @param string $name $_GET variable name.
     *
     * @return string|null Value of $_GET $name variable.
     */
    public function getQuery($name)
    {
        return isset($_GET[$name])?$_GET[$name]:null;
    }

    /**
     * Method to return values from $_SERVER global array.
     *
     * @param string $name $_SERVER variable name.
     *
     * @return string|null Value of $_SERVER $name variable.
     */
    public function getServer($name)
    {
        return isset($_SERVER[$name])?$_SERVER[$name]:null;
    }

    /**
     * Method checks whether variable with specified name exists in $_REQUEST global array or not.
     *
     * @param string $name $_REQUEST variable name.
     *
     * @return bool Does variable exist in $_REQUEST global array?
     */
    public function has($name)
    {
        return isset($_REQUEST[$name]);
    }

    /**
     * Method checks whether variable with specified name exists in $_POST global array or not.
     *
     * @param string $name $_POST variable name.
     *
     * @return bool Does variable exist in $_POST global array?
     */
    public function hasPost($name)
    {
        return isset($_POST[$name]);
    }

    /**
     * Method checks whether variable with specified name exists in $_GET global array or not.
     *
     * @param string $name $_GET variable name.
     *
     * @return bool Does variable exist in $_GET global array?
     */
    public function hasQuery($name)
    {
        return isset($_GET[$name]);
    }

    /**
     * Method checks whether variable with specified name exists in $_SERVER global array or not.
     *
     * @param string $name $_SERVER variable name.
     *
     * @return bool Does variable exist in $_SERVER global array?
     */
    public function hasServer($name)
    {
        return isset($_SERVER[$name]);
    }

    /**
     * Method returns http scheme.
     *
     * @return string Http scheme.
     */
    public function getScheme()
    {
        $scheme = parse_url($_SERVER['REQUEST_URI'])['scheme'];
        return $scheme;
    }

    /**
     * Method checks whether request is ajax.
     *
     * @return bool Is request ajax?
     */
    public function isAjax()
    {
        return $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    }

    /**
     * Method returns server address.
     *
     * @return string Server address.
     */
    public function getServerAddress()
    {
        return $_SERVER['SERVER_ADDR'];
    }

    /**
     * Method returns server name.
     *
     * @return string Server name.
     */
    public function getServerName()
    {
        return gethostname();
    }

    /**
     * Method returns http host.
     *
     * @return string Http host.
     */
    public function getHttpHost()
    {
        $parsed_url = parse_url($_SERVER('REQUEST_URI'));
        return $parsed_url['scheme'].$parsed_url['host'].$parsed_url['port'];
    }

    /**
     * Method returns client address.
     *
     * @return string Client address.
     */
    public function getClientAddress()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Method returns user agent.
     *
     * @return string User agent.
     */
    public function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * Compare http request method with specified method in $name parameter.
     *
     * @param string $name Http method name to compare to current request method.
     *
     * @return bool Does current http request method matches $name request method?
     */
    public function isMethod($name)
    {
        return $_SERVER['REQUEST_METHOD'] === strtoupper($name);
    }

    /**
     *
     */
    public function hasFiles()
    {
    }

    /**
     *
     */
    public function getUploadedFiles()
    {
    }
}