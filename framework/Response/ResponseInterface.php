<?php
/**
 * File /framework/response/ResponseInterface.php contains ResponseInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Response
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Response;

/**
 * Interface ResponseInterface is used to be implemented by Response class.
 *
 * @api
 *
 * @package Framework\Response
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface ResponseInterface
{
    /**
     * Method to get response body.
     *
     * @return string Response body.
     */
    public function getResponseBody();

    /**
     * Method to set response body.
     *
     * @param  $responseBody Response body.
     *
     * @return void
     */
    public function setResponseBody($responseBody);

    /**
     * Method to get cache directives.
     *
     * @return array Cache directives.
     */
    public function getCacheDirectives();

    /**
     * Method to get response charset.
     *
     * @return string Response charset.
     */
    public function getCharset();

    /**
     * Method to get response content type.
     *
     * @return string Response content type.
     */
    public function getContentType();

    /**
     * Method to get cookie object.
     *
     * @return object Cookie.
     */
    public function getCookieObject();

    /**
     * Method to get session object.
     *
     * @return object Session.
     */
    public function getSessionObject();

    /**
     * Method to get value of session variable $name.
     *
     * @param  string $name Name of session variable to get.
     *
     * @throws \Framework\Exception\SessionException SessionException instance.
     *
     * @return mixed Value of session variable $name.
     */
    public function getSessionVar($name);

    /**
     * Method to get response status code.
     *
     * @return int Response status code.
     */
    public function getStatusCode();

    /**
     * Method to get response status message.
     *
     * @throws \Framework\Exception\ResponseException ResponseException instance.
     *
     * @return string Response status message.
     */
    public function getStatusMessage();

    /**
     * Method returns value of specified response header.
     *
     * @param  string $name Name of response header its value to be returned.
     *
     * @return string|null Value of specified header or null.
     */
    public function getHeader($name);

    /**
     * Method to get array of response statuses in form: statusCode => 'statusDescription'.
     *
     * @return array Response statuses.
     */
    public static function getStatuses();

    /**
     * Method sets raw header e.g. "HTTP/1.1 200 OK".
     *
     * @param  string $rawHeader Raw header to be set.
     *
     * @return void
     */
    public function rawHeader($rawHeader);

    /**
     * Method sets Content-Disposition header asking http client to show upload dialog.
     *
     * @param  string $filename Filename to download.
     *
     * @return void
     */
    public function download($filename);

    /**
     * Method sets response header with name $name and value $value.
     *
     * @param  string $name  Name  of response header to set.
     * @param  string $value Value of response header $name.
     *
     * @return void
     */
    public function header($name, $value);

    /**
     * Method sets response status code. "Http_response_code" function requires PHP 5 >= 5.4.0
     *
     * @param  string $statusCode Response status code to set.
     *
     * @throws \Framework\Exception\ResponseException ResponseException instance.
     *
     * @return void
     */
    public function setStatusCode($statusCode);

    /**
     * Method sets content type of response.
     *
     * @param  string $contentType Response content type.
     * @param  string $charset     Response charset.
     *
     * @return void
     */
    public function setContentType($contentType, $charset);

    /**
     * Method sends all set headers.
     *
     * @return void
     */
    public function sendHeaders();

    /**
     * Method reset all set response headers.
     *
     * @return void
     */
    public function resetHeaders();

    /**
     * Method add cookie with name $name and $value value.
     *
     * @param  string $name  Cookie name.
     * @param  string $value Cookie value.
     *
     * @return void
     */
    public function addCookie($name, $value);

    /**
     * Method returns value of specified cookie.
     *
     * @param  string $name cookie name value of to be returned.
     *
     * @return string Cookie value.
     */
    public function getCookie($name);

    /**
     * Method returns all response headers.
     *
     * @return array Response headers.
     */
    public function getHeaders();

    /**
     * Method appends content to response body.
     *
     * @param string $content Content to be appended to response body.
     */
    public function appendContent($content);

    /**
     * Method sends all set cookie.
     *
     * @return void
     */
    public function sendCookies();

    /**
     * Method sends response to http client.
     *
     * @return void
     */
    public function send();

    /**
     * Method sets all needed headers and cache directives related to cache.
     *
     * @param  int $since Last modification time of current file.
     * @param  int $time  Time when response is sent.
     *
     * @return void
     */
    public function cache($since, $time);

    /**
     * Method sets last modification time to current file or returns value
     * of existed Last-Modified header when $time parameter is null.
     *
     * @param  \DateTime|int|string|null $time Last modification time of current file.
     *
     * @return string|null Last modification time of current file or null.
     */
    public function modified($time);

    /**
     * Method sets max-age cache directive if $seconds parameters isn't null.
     * It returns value of max-age cache-directive unless $seconds is null
     * and max-age cache directive was not defined before then it returns null.
     *
     * @param  string $seconds Amount of seconds to cache file for.
     *
     * @return string|null Value of max-age cache-directive or null.
     */
    public function maxAge($seconds);

    /**
     * Method sets Expires header if $time parameter is not null.
     * It returns value of Expire header unless $time is null
     * and Expire header was not defined before then it returns null.
     *
     * @param  \DateTime|int|string|null $time Expiration time for current file.
     *
     * @return string|null Value of Expire header or null.
     */
    public function expires($time);

    /**
     * Method takes $time parameter and convert it to DateTime object.
     * If $time is already DateTime object method just clones it and returns DateTime clone.
     *
     * @param  \DateTime|string|int|null $time Time to convert to DateTime object.
     *
     * @return object DateTime.
     */
    public function _getUTCDate($time);

    /**
     * Method sets Cache-Control header.
     *
     * @return void
     */
    public function _setCacheControl();
}