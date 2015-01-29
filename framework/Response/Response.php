<?php
/**
 * File /framework/response/Response.php contains Response class to easily manipulate with http response.
 *
 * PHP version 5
 *
 * @package Framework\Response
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Response;

use Framework\Exception\ResponseException;

/**
 * Class Response - representation of http response.
 * Default implementation of {@link ResponseInterface}
 *
 * Class contains all needed information of http response such as cookie, session variables
 * response status, response headers, response body etc.
 *
 * @package Framework\Response
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Response implements ResponseInterface
{
    /**
     * @static
     * @var \Framework\Response\Response|null Response instance
     */
    private static $_instance = null;

    /**
     * @static
     * @var array $_statuses Response status codes with its descriptions
     */
    private static $_statuses = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'request Entity Too Large',
        414 => 'request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out'
    );

    /**
     * @var int $_statusCode Response status code
     */
    private $_statusCode = 200;

    /**
     * @var string $_contentType Response content type
     */
    private $_contentType = 'text/html';

    /**
     * @var array $_headers Response headers
     */
    private $_headers = array();

    /**
     * @var array $_cacheDirectives Cache directives
     */
    private $_cacheDirectives = array();

    /**
     * @var string $_responseBody Response body
     */
    private $_responseBody = '';

    /**
     * @var string $_charset Response charset
     */
    private $_charset = 'UTF-8';

    /**
     * @var \Framework\Cookie\Cookie $_cookie Cookie object
     */
    private $_cookie;

    /**
     * @var \Framework\Session\Session $_session Session object
     */
    private $_session;

    /**
     * Response constructor.
     *
     * Response constructor sets dependencies such as:
     *  - Session object;
     *  - Cookie  object.
     *
     * @param  \Framework\Session\Session $session Session object.
     * @param  \Framework\Cookie\Cookie   $cookie  Cookie  object.
     *
     * @return object Response.
     */
    private function __construct($session = null, $cookie = null)
    {
        $this->_session = $session;
        $this->_cookie  = $cookie;
    }

    /**
     * Method to clone objects of its class.
     *
     * @return object Response.
     */
    private function __clone()
    {
    }

    /**
     * Method returns Response instance creating it if it's not been instantiated before
     * otherwise existed Response object will be returned.
     *
     * @param  \Framework\Session\Session $session Session object.
     * @param  \Framework\Cookie\Cookie   $cookie  Cookie  object.
     *
     * @return object Response.
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
    public function getResponseBody()
    {
        return $this->_responseBody;
    }

    /**
     * {@inheritdoc}
     */
    public function setResponseBody($responseBody)
    {
        $this->_responseBody = $responseBody;
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDirectives()
    {
        return $this->_cacheDirectives;
    }

    /**
     * {@inheritdoc}
     */
    public function getCharset()
    {
        return $this->_charset;
    }

    /**
     * {@inheritdoc}
     */
    public function getContentType()
    {
        return $this->_contentType;
    }

    /**
     * {@inheritdoc}
     */
    public function getCookieObject()
    {
        return $this->_cookie;
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionObject()
    {
        return $this->_session;
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionVar($name)
    {
        return $this->_session->get($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode()
    {
        return $this->_statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusMessage()
    {
        if (is_int($this->_statusCode)) {
            return self::$_statuses[$this->_statusCode];
        } else {
            throw new ResponseException(
                500,
                "<strong>Internal server error:</strong> status code for Response::getStatusMessage is not specified"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader($name)
    {
        return isset($this->_headers[$name])?$this->_headers[$name]:null;
    }

    /**
     * {@inheritdoc}
     */
    public static function getStatuses()
    {
        return self::$_statuses;
    }

    /**
     * {@inheritdoc}
     */
    public function rawHeader($rawHeader)
    {
        $this->_headers['statusMessage'] = $rawHeader;
    }

    /**
     * {@inheritdoc}
     */
    public function download($filename)
    {
        $this->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    /**
     * {@inheritdoc}
     */
    public function header($name, $value)
    {
        $this->_headers[$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatusCode($statusCode)
    {
        if (is_int($statusCode)) {
            http_response_code($statusCode);
        } else {
            $parameterType = gettype($statusCode);
            throw new ResponseException(
                500, "<strong>Internal server error:</strong> status code for Response::setStatusCode method must be 'int', '$parameterType is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setContentType($contentType, $charset)
    {
        $this->_contentType             = $contentType;
        $this->_charset                 = $charset;
        $this->_headers['Content-Type'] = $contentType.';charset='.$charset;
    }

    /**
     * {@inheritdoc}
     */
    public function sendHeaders()
    {
        foreach ($this->_headers as $headerName => $headerValue) {
            header($headerName.": ".$headerValue);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function resetHeaders()
    {
        $this->_headers = array();
    }

    /**
     * {@inheritdoc}
     */
    public function addCookie($name, $value)
    {
        $this->_cookie->add($name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getCookie($name)
    {
        return $this->_cookie->get($name);
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
    public function appendContent($content)
    {
        $this->_responseBody .= $content;
    }

    /**
     * {@inheritdoc}
     */
    public function sendCookies()
    {
        $this->_cookie->send();
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        $this->sendCookies();
        $this->sendHeaders();
        echo $this->_responseBody;
    }

    /**
     * {@inheritdoc}
     */
    public function cache($since, $time = 0)
    {
        if (!is_integer($time)) {
            $time = strtotime($time);
        }
        $this->header('Date', gmdate("D, j M Y G:i:s ", time()).'GMT');
        $this->modified($since);
        $this->expires($time);
        $this->maxAge($time - time());
    }

    /**
     * {@inheritdoc}
     */
    public function modified($time = null)
    {
        if ($time !== null) {
            $date                            = $this->_getUTCDate($time);
            $this->_headers['Last-Modified'] = $date->format('D, j M Y H:i:s').' GMT';
        }
        if (isset($this->_headers['Last-Modified'])) {
            return $this->_headers['Last-Modified'];
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function maxAge($seconds = null)
    {
        if ($seconds !== null) {
            $this->_cacheDirectives['max-age'] = $seconds;
            $this->_setCacheControl();
        }
        if (isset($this->_cacheDirectives['max-age'])) {
            return $this->_cacheDirectives['max-age'];
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function expires($time = null)
    {
        if ($time !== null) {
            $date                      = $this->_getUTCDate($time);
            $this->_headers['Expires'] = $date->format('D, j M Y H:i:s').' GMT';
        }
        if (isset($this->_headers['Expires'])) {
            return $this->_headers['Expires'];
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function _getUTCDate($time = null)
    {
        if ($time instanceof \DateTime) {
            $result = clone $time;
        } elseif (is_integer($time)) {
            $result = new \DateTime(date('Y-m-d H:i:s', $time));
        } else {
            $result = new \DateTime($time);
        }
        $result->setTimeZone(new \DateTimeZone('UTC'));
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function _setCacheControl()
    {
        $control = '';
        foreach ($this->_cacheDirectives as $key => $val) {
            $control .= $val === true?$key:sprintf('%s=%s', $key, $val);
            $control .= ', ';
        }
        $control = rtrim($control, ', ');
        $this->header('Cache-Control', $control);
    }
}