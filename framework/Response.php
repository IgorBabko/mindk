<?php

namespace Framework;

class Response {

	public $cookie;
	public $session;
	public $responseHeaders = array();
	public $content = '';
	public $headersSent = false;

	public function __construct($session = null, $cookie = null, $content = '', $code = 200, $status = 'OK') {
		$this->session = $session;
		$this->cookie  = $cookie;
	}

	public function isHeadersSent() {
		return $this->headersSent;
	}

	public function setRawHeader($rawHeader) {
		$this->responseHeaders['statusMessage'] = $rawHeader;
	}

	public function setStatusCode($code, $message) {
		$this->responseHeaders['statusMessage'] = 'HTTP/1.0 ' . $code . ' ' . $message;
	}

	public function setHeaders($headers) {
		if(empty($this->responseHeaders)) {
			$this->responseHeaders = $headers;
		} else {
			foreach($headers as $headerName as $headerValue) {
				$this->responseHeaders[$headerName] = $headerValue;
			}
		}
	}

	public function setHeader($name, $value) {
		$this->responseHeaders[$name] = $value;
	}

	public function setContentType($contentType, $charset) {
		$this->responseHeaders['Content-Type'] = $contentType . ';charset=' . $charset;
	}

	public function sendHeaders() {
		foreach ($this->responseHeaders as $headerName => $headerValue) {
			header($headerName . ": " . $headerValue);
		}
	}

	public function resetHeaders() {
		$this->responseHeaders = array();
	}

	public function setCookie($name, $value) {
		$this->cookie->set($name, $value);
	}

	public function getCookies($name) {
		return $this->cookie->get($name);
	}

	public function getHeaders() {
		return $this->responseHeaders;
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
		if ($this->headersSent == false) {
			$this->cookie->send();
		}

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
		return isset($this->responseHeaders[$name]) ? $this->responseHeaders[$name] : null;
	}

	public function getHeaders() {
		return $this->responseHeaders;
	}

	public function setFileToSend() {
		// @TODO ...
	}
}