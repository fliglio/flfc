<?php

namespace Fliglio\Flfc;

use Fliglio\Http\RequestReader;

class Request implements RequestReader {
	
	private $host;

	/* protocol: http/https */
	private $protocol;

	/* url of current request */
	private $url;

	/* http method (GET, POST...) */
	private $method;

	/* array of headers */
	private $headers = array();

	/* GET request parameters, e.g. $_GET*/
	private $getParams = array();

	private $body;

	public function __construct() {

	}

	public function setHttpMethod($method) {          $this->method = $method; }
	public function getHttpMethod() {                 return $this->method; }

	public function setProtocol($protocol) {          $this->protocol = $protocol; }
	public function getProtocol() {                   return $this->protocol; }

	public function setHost($host) {                  $this->host = $host; }
	public function getHost() {                       return $this->host; }

	public function setUrl($url) {                    $this->url = $url; }
	public function getUrl() {                        return $this->url; }

	public function setGetParams(array $getParams) {  $this->getParams = $getParams; }
	public function getGetParams() {                  return $this->getParams; }

	public function setBody($body) {                  $this->body = $body; }
	public function getBody() {                       return $this->body; }
	
	public function addHeader($key, $val) { 
		$this->headers[strtolower($key)] = $val;
	}
	public function getHeaders() {
		return $this->headers;
	}
	public function isHeaderSet($key) {
		return isset($this->headers[strtolower($key)]);
	}
	public function getHeader($key) { 
		return $this->headers[strtolower($key)];
	}
}