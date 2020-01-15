<?php

namespace Fliglio\Flfc;

use Fliglio\Http\ResponseWriter;
use Fliglio\Http\ResponseBody;
use Fliglio\Http\Http;

class Response implements ResponseWriter {

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

	public function write() {
		if (!is_null($this->status)) {
			$statusMsg = Http::getStatusMessage($this->status);
			header(sprintf("HTTP/1.1 %s %s", $this->status, $statusMsg));
		}

		foreach ($this->getHeaders() AS $key => $val) {
			header($key . ": " . $val);
		}

		if ($this->getBody()) {
			$this->getBody()->render();
		}
	}
}

