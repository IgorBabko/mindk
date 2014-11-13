<?php

namespace Framework;

class Response {

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

	public $_status = 200;
	public $_contentType = 'text/html';
	public $_headers = array();
	public $_body = null;
	public $_charset = 'UTF-8';

	public $cookie;
	public $session;

	public function __construct($session = null, $cookie = null, $content = '', $code = 200, $status = 'OK') {
		$this->session = $session;
		$this->cookie  = $cookie;
	}

	public function rawHeader($rawHeader) {
		$this->_headers['statusMessage'] = $rawHeader;
	}

	public function statusCode($code, $message) {
		$this->_headers['statusMessage'] = 'HTTP/1.1 ' . $code . ' ' . $message;
	}

	public function download() {
		$this->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
	}


	public function header($name, $value) {
		$this->_headers[$name] = $value;
	}

	public function setStatusCode($code, $status) {
		http_response_code($code); // PHP 5 >= 5.4.0
	}


	public function setRawHeader($name) {

	}

	public function setContentType($contentType, $charset) {
		$this->_headers['Content-Type'] = $contentType . ';charset=' . $charset;
	}

	public function sendHeaders() {
		foreach ($this->_headers as $headerName => $headerValue) {
			header($headerName . ": " . $headerValue);
		}
	}

	public function resetHeaders() {
		$this->_headers = array();
	}

	public function setCookie($name, $value) {
		$this->cookie->set($name, $value);
	}

	public function getCookies($name) {
		return $this->cookie->get($name);
	}

	public function getHeaders() {
		return $this->_headers; // headers_list( void );
	}

	public function setContent($content) {
		$this->content = $content;
	}

	public function getContent() {
		return $this->content;
	}

	public function appendContent($content) {
		$this->content .= $content;
	}

	public function sendCookies() {
		$this->cookie->send();

		// throw ...
	}

	public function send() {
		$this-.sendHeaders();
		echo $this->content;
		$this->headersSent = true;
	}

	public function redirect($location = '/', $externalRedirect = false, $statusCode = 200) {
		header('Location: ' . $location);
	}

	public function getHeader($name) {
		return isset($this->_headers[$name]) ? $this->responseHeaders[$name] : null;
	}

	public function setFileToSend() {
		// @TODO ...
	}
}