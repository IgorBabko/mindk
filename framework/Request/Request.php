<?php
/**
 * File /framework/request/Request.php contains Request class is used
 * to manipulated with http request easily.
 *
 * PHP version 5
 *
 * @package Framework\Request
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Request;

/**
 * Class Request - representation of http request.
 * Default implementation of {@link RequestInterface}.
 *
 * Class contains all needed information of http request such as cookie, session variables
 * http method, request headers, http uri, GET data, POST data, SERVER data etc.
 *
 * @package Framework\Request
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Request implements RequestInterface
{
    /**
     * @static
     * @var \Framework\Request\Request|null Request instance
     */
    private static $_instance = null;

    /**
     * @var \Framework\Cookie\Cookie $_cookie cookie object
     */
    private $_cookie;

    /**
     * @var \Framework\Session\Session $_session Session object
     */
    private $_session;

    /**
     * @var string $_uri request uri
     */
    private $_uri;

    /**
     * @var string $_method request method
     */
    private $_method;

    /**
     * @var array $_headers Array of request headers
     */
    private $_headers = array();

    /**
     * {@inheritdoc}
     */
    public function getRequestHeaders()
    {
        $out = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == "HTTP_") {
                $key       = str_replace(" ", "-", ucwords(strtolower(str_replace("_", " ", substr($key, 5)))));
                $out[$key] = $value;
            } else {
                $out[$key] = $value;
            }
        }
        return $out;
    }

    /**
     * Request constructor.
     *
     * Request constructor:
     *  - takes Session object and Cookie object as parameters;
     *  - defines request method and request uri.
     *
     * @param  \Framework\Session\Session|null $session Session object.
     * @param  \Framework\Cookie\Cookie|null   $cookie  Cookie  object.
     *
     * @return object Request.
     */
    private function __construct($session = null, $cookie = null)
    {
        $this->_headers = $this->getRequestHeaders();
        $this->_method  = $_SERVER['REQUEST_METHOD'];
        $this->_uri     = $_SERVER['REQUEST_URI'];
        $this->_session = $session;
        $this->_cookie  = $cookie;
    }

    /**
     * Method to clone objects of its class.
     *
     * @return object Request.
     */
    private function __clone()
    {
    }

    /**
     * Method returns Request instance creating it if it's not been instantiated before
     * otherwise existed Request object will be returned.
     *
     * @param  \Framework\Session\Session|null $session Session object.
     * @param  \Framework\Cookie\Cookie|null   $cookie  Cookie  object.
     *
     * @return object Request.
     */
    public static function getInstance($session = null, $cookie = null)
    {
        if (null === self::$_instance) {
            self::$_instance = new self($session, $cookie);
        }
        return self::$_instance;
    }

    /**
     * {@inheritdoc}
     */
    public function getURI()
    {
        return $this->_uri;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return $this->_headers;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader($name)
    {
        return $this->_headers[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestMethod()
    {
        return $this->_method;
    }

    /**
     * {@inheritdoc}
     */
    public function getCookie()
    {
        return $this->_cookie;
    }

    /**
     * {@inheritdoc}
     */
    public function getSession()
    {
        return $this->_session;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnv($name)
    {
        return isset($_ENV[$name])?$_ENV[$name]:null;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        return isset($_REQUEST[$name])?$_REQUEST[$name]:null;
    }

    /**
     * {@inheritdoc}
     */
    public function getPost($name)
    {
        return isset($_POST[$name])?$_POST[$name]:null;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery($name)
    {
        return isset($_GET[$name])?$_GET[$name]:null;
    }

    /**
     * {@inheritdoc}
     */
    public function getServer($name)
    {
        return isset($_SERVER[$name])?$_SERVER[$name]:null;
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        return isset($_REQUEST[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function hasPost($name)
    {
        return isset($_POST[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function hasQuery($name)
    {
        return isset($_GET[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function hasServer($name)
    {
        return isset($_SERVER[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getScheme()
    {
        $scheme = parse_url($_SERVER['REQUEST_URI'])['scheme'];
        return $scheme;
    }

    /**
     * {@inheritdoc}
     */
    public function isAjax()
    {
        return $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    }

    /**
     * {@inheritdoc}
     */
    public function getServerAddress()
    {
        return $_SERVER['SERVER_ADDR'];
    }

    /**
     * {@inheritdoc}
     */
    public function getServerName()
    {
        return gethostname();
    }

    /**
     * {@inheritdoc}
     */
    public function getHttpHost()
    {
        $parsed_url = parse_url($_SERVER('REQUEST_URI'));
        return $parsed_url['scheme'].$parsed_url['host'].$parsed_url['port'];
    }

    /**
     * {@inheritdoc}
     */
    public function getClientAddress()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * {@inheritdoc}
     */
    public function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * {@inheritdoc}
     */
    public function isMethod($name)
    {
        return $_SERVER['REQUEST_METHOD'] === strtoupper($name);
    }
}