<?php

namespace Fliglio\Flfc;

use Fliglio\Http\ResponseWriter;
use Fliglio\Http\ResponseBody;

class Response implements ResponseWriter {

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
	private $status  = null;

	/* HTTP content type */
	private $contentType  = null;
	
	/* Headers set on response */
	private $headers = array();
	

	public function setBody(ResponseBody $content) {  
		$this->content = $content;
	}
	public function getBody() {
		return $this->content;
	}
	
	public function addHeader($key, $val) { 
		$this->headers[$key] = $val;
	}
	public function getHeaders() {
		$headers = $this->headers;

		if (!is_null($this->contentType)) {
			$headers['Content-Type'] = $this->contentType;
		}
		if (!is_null($this->status)) {
			$key = "HTTP/1.1 " . $this->status;
			$val = self::$statusCodes[$this->status];
			$headers[$key] = $val;
		}
		return $headers;
	}
	public function hasHeader($key) {
		return isset($this->headers[$key]);
	}

	public function setContentType($type) {  
		$this->contentType = $type;
	}
	public function getContentType() {
		return $this->contentType;
	}

	public function setStatus($code) {
		$this->status = $code;
	}

	public function getStatus() {
		return $this->status;
	}
	
}

