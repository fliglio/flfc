<?php

namespace Fliglio\Flfc;

/**
 * Flfc_Response
 *
 * @package Fl
 **/
class Response {

	public static $statusCodes = array(
		100 => 'Continue',                      300 => 'Multiple Choices',      400 => 'Bad Request',                   411 => 'Length Required',
		101 => 'Switching Protocols',           301 => 'Moved Permanently',     401 => 'Unauthorized',                  412 => 'Precondition Failed',
		102 => 'Processing',                    302 => 'Found',                 402 => 'Payment Required',              413 => 'Request Entity Too Large',
                                                303 => 'See Other',             403 => 'Forbidden',                     414 => 'Request-URI Too Long',
		200 => 'OK',                            304 => 'Not Modified',          404 => 'Not Found',                     415 => 'Unsupported Media Type',
		201 => 'Created',                       305 => 'Use Proxy',             405 => 'Method Not Allowed',            416 => 'Requested Range Not Satisfiable',
		202 => 'Accepted',                      306 => 'Reserved',              406 => 'Not Acceptable',                417 => 'Expectation Failed',
		203 => 'Non-Authoritative Information', 307 => 'Temporary Redirect',    407 => 'Proxy Authentication Required', 422 => 'Unprocessable Entity',
		204 => 'No Content',                                                    408 => 'Request Timeout',               423 => 'Locked',
		205 => 'Reset Content',                 500 => 'Internal Server Error', 409 => 'Conflict',                      424 => 'Failed Dependency',
		206 => 'Partial Content',               501 => 'Not Implemented',       410 => 'Gone',                          426 => 'Upgrade Required',
		207 => 'Multi-Status',                  502 => 'Bad Gateway',           
		226 => 'IM Used',                       503 => 'Service Unavailable',   505 => 'HTTP Version Not Supported',    507 => 'Insufficient Storage',
                                                504 => 'Gateway Timeout',       506 => 'Variant Also Negotiates',       510 => 'Not Extended',
		601 => 'retry processing message asap'
	);

	/* Flfc_ResponseContent */
	private $content; 
	
	/* HTTP Response code */
	private $status  = 200;
	
	/* Headers set on response */
	private $headers = array();
	
	/* storage for additional properties */
	private $props  = array();
	

	public function setContent(ResponseContent $content) {  
		$this->content = $content;
	}
	public function getContent() {
		return $this->content;
	}
	public function hasContent() {
		return isset($this->content);
	}
	
	public function addHeader($key, $val) { 
		$this->headers[$key] = $val;
	}
	public function getHeaders() {
		return $this->headers;
	}

	public function setStatus($code) {
		$this->status = $code;
	}

	public function getStatus() {
		
		if (!isset(self::$statusCodes[$this->status])) {
			throw new ResponseException("Unknown Status Code: " . $this->status);
		}

		$status = new \stdClass();
		$status->code    = $this->status;
		$status->message = self::$statusCodes[$this->status];
		return $status;
	}
	
	public function setProp($key, $val) {
		$this->props[$key] = $val;
	}

	public function getProp($key) {
		return $this->props[$key];
	}

	public function isPropSet($key) {
		return isset($this->props[$key]);
	}
	
	public function getProps() {
		return $this->props;
	}
	
	
}

