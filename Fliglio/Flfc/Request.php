<?php

namespace Fliglio\Flfc;

class Request {
	
	private $host;

	/* protocol: http/https */
	private $protocol;

	/* url of current request */
	private $currentUrl;

	/* http method (GET, POST...) */
	private $method;

	/* array of headers */
	private $headers = array();

	/* GET request parameters, e.g. $_GET*/
	private $getParams = array();



	/* module/commandGroup/command this request maps to */
	private $command;

	/* custom properties set on the request object by the application */
	private $props = array();

	private $postData;

	public function __construct() {

	}

	public function setHost($host) {                  $this->host = $host; }
	public function getHost() {                       return $this->host; }

	public function setProtocol($protocol) {          $this->protocol = $protocol; }
	public function getProtocol() {                   return $this->protocol; }

	public function setCurrentUrl($url) {             $this->currentUrl = $url; }
	public function getCurrentUrl() {                 return $this->currentUrl; }

	public function setHttpMethod($method) {          $this->method = $method; }
	public function getHttpMethod() {                 return $this->method; }

	public function setGetParams(array $getParams) {  $this->getParams = $getParams; }
	public function getGetParams() {                  return $this->getParams; }

	public function setPostData($postData) {          $this->postData = $postData; }
	public function getPostData() {                   return $this->postData; }
	


	public function setCommand($cmd) {    $this->command = $cmd; }
	public function isCommandSet() {      return isset($this->command); }
	public function getCommand() {        return $this->command; }


	public function setProp($key, $val) { $this->props[$key] = $val; }
	public function isPropSet($key) {     return isset($this->props[$key]); }
	public function getProp($key) {       return $this->props[$key]; }
	public function getProps() {          return $this->props; }
	public function unsetProp($key) {     unset($this->props[$key]); }
	


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