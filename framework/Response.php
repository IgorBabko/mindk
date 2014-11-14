<?php
/**
 * /framework/Response.php contains Response class
 */
namespace Framework;

/**
 * Class Response - representation of http response
 *
 * Class contains all needed information of http response such as cookie, session variables
 * response status, response headers, response body etc.
 *
 * @package Framework
 * @author Igor Babko <i.i.babko@gmail.com>
 */
class Response
{

    /**
     * @var array $_statusCodes Response status codes with its descriptions
     */
    protected $_statusCodes = array(
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
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
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
     * @var int $_status Response status code
     */
    public $_status = 200;
    /**
     * @var string $_contentType Response content type
     */
    public $_contentType = 'text/html';
    /**
     * @var array $_headers Response headers
     */
    public $_headers = array();
    /**
     * @var array $_cacheDirectives Cache directives
     */
    public $_cacheDirectives = array();
    /**
     * @var string $_body Response body
     */
    public $_body = '';
    /**
     * @var string $_charset Response charset
     */
    public $_charset = 'UTF-8';

    /**
     * @var \Framework\Cookie $_cookie Cookie object
     */
    public $cookie;
    /**
     * @var \Framework\Session $_session Session object
     */
    public $session;

    /**
     * Response constructor.
     *
     * Response constructor sets dependencies such as:
     *  - session object;
     *  - cookie  object.
     * Also it sets default body, status code and status descriptions to the response object.
     *
     * @param \Framework\Session $session Session object
     * @param \Framework\Cookie  $cookie  Cookie  object
     * @param string             $content Content of response body
     * @param int                $code    Status code of response
     * @param string             $status  Description of response status code
     *
     * @return \Framework\Response
     */
    public function __construct($session = null, $cookie = null, $content = '', $code = 200, $status = 'OK')
    {
        $this->session = $session;
        $this->cookie  = $cookie;
    }

    /**
     * Method sets raw header e.g. "HTTP/1.1 200 OK".
     *
     * @param string $rawHeader Raw header to be set
     *
     * @return void
     */
    public function rawHeader($rawHeader)
    {
        $this->_headers['statusMessage'] = $rawHeader;
    }

    /**
     * Method sets status code of response e.g.
     *
     * @param $code
     * @param $message
     */

    /**
     * Method sets Content-Disposition header asking http client to show upload dialog
     *
     * @param string $filename Filename to download
     *
     * @return void
     */
    public function download($filename)
    {
        $this->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }


    /**
     * Method sets response header with name $name and value $value
     *
     * @param string $name  Name  of response header to set
     * @param string $value Value of response header $name
     *
     * @return void
     */
    public function header($name, $value)
    {
        $this->_headers[$name] = $value;
    }

    /**
     * Method sets response status code.
     *
     * @param string $code Response status code to set
     *
     * @return void
     */
    public function setStatusCode($code)
    {
        http_response_code($code); // PHP 5 >= 5.4.0
    }


    /**
     * Method sets content type of response
     *
     * @param string $contentType Response content type
     * @param string $charset     Response charset
     *
     * @return void
     */
    public function setContentType($contentType, $charset)
    {
        $this->_headers['Content-Type'] = $contentType.';charset='.$charset;
    }

    /**
     * Method sends all set headers.
     *
     * @return void
     */
    public function sendHeaders()
    {
        foreach ($this->_headers as $headerName => $headerValue) {
            header($headerName.": ".$headerValue);
        }
    }

    /**
     * Method reset all set response headers.
     *
     * @return void
     */
    public function resetHeaders()
    {
        $this->_headers = array();
    }

    /**
     * Method add cookie with name $name and $value value.
     *
     * @param string $name  Cookie name
     * @param string $value Cookie value
     *
     * @return void
     */
    public function addCookie($name, $value)
    {
        $this->cookie->add($name, $value);
    }

    /**
     * Method returns value of specified cookie.
     *
     * @param string $name Cookie name value of to be returned
     *
     * @return string Cookie value
     */
    public function getCookies($name)
    {
        return $this->cookie->get($name);
    }

    /**
     * Method returns all response headers.
     *
     * @return array Response headers
     */
    public function getHeaders()
    {
        return $this->_headers; // headers_list( void );
    }

    /**
     * Method sets content to response body.
     *
     * @param string $content Content to be set
     *
     * @return void
     */
    public function setContent($content)
    {
        $this->_body = $content;
    }

    /**
     * Method returns response body.
     *
     * @return string Response body.
     */
    public function getContent()
    {
        return $this->_body;
    }

    /**
     * Method appends content to response body.
     *
     * @param string $content Content to be appended to response body
     */
    public function appendContent($content)
    {
        $this->_body .= $content;
    }

    /**
     * Method sends all set cookie.
     *
     * @return void
     */
    public function sendCookies()
    {
        $this->cookie->send();
        // throw ...
    }

    /**
     * Method sends response to http client.
     *
     * @return void
     */
    public function send()
    {
        $this->sendHeaders();
        echo $this->_body;
        //$this->_headersSent = true;
    }

    /**
     * Method redirects http client to given location $location.
     *
     * @param string $location Location to be redirected to
     *
     * @return void
     */
    public function redirect($location = '/')
    {
        header('Location: '.$location);
    }

    /**
     * Method returns value of specified response header.
     *
     * @param string $name Name of response header its value to be returned
     *
     * @return string|null Value of specified header or null
     */
    public function getHeader($name)
    {
        return isset($this->_headers[$name])?$this->_headers[$name]:null;
    }

    /////////////////////////////////////////////////////////////////

    /**
     * Method sets all needed headers and cache directives related to cache.
     *
     * @param int $since Last modification time of current file
     * @param int $time  Time when response is sent
     *
     * @return void
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
     * Method sets last modification time to current file or returns value
     * of existed Last-Modified header when $time parameter is null.
     *
     * @param DateTime|int|string|null $time Last modification time of current file
     *
     * @return string|null Last modification time of current file or null
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
     * Method sets max-age cache directive if $seconds parameters isn't null.
     * It returns value of max-age cache-directive unless $seconds is null
     * and max-age cache directive was not defined before then it returns null.
     *
     * @param string $seconds Amount of seconds to cache file for
     *
     * @return string|null Value of max-age cache-directive or null
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
     * Method sets Expires header if $time parameter is not null.
     * It returns value of Expire header unless $time is null
     * and Expire header was not defined before then it returns null.
     *
     * @param DateTime|int|string|null $time Expiration time for current file
     *
     * @return string|null Value of Expire header or null
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
     * Method takes $time parameter and convert it to DateTime object.
     * If $time is already DateTime object method just clones it and returns DateTime clone.
     *
     * @param DateTime|string|int|null $time Time to convert to DateTime object
     *
     * @return DateTime DateTime object
     */
    protected function _getUTCDate($time = null)
    {
        if ($time instanceof DateTime) {
            $result = clone $time;
        } elseif (is_integer($time)) {
            $result = new DateTime(date('Y-m-d H:i:s', $time));
        } else {
            $result = new DateTime($time);
        }
        $result->setTimeZone(new DateTimeZone('UTC'));
        return $result;
    }


    /**
     * Method sets Cache-Control header.
     *
     * @return void
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