<?php

namespace Fliglio\Flfc;

/**
 * Flfc_Request
 *
 * @package Fl
 **/
class Request {
	
	/* module/commandGroup/command this request maps to */
	private $command;

	/* url of current request */
	private $currentUrl;

	/* array of headers */
	private $headers = array();

	/* External request parameters, e.g. $_REQUEST */
	private $params = array();

	/* custom properties set on the request object by the application */
	private $props = array();

	private $rawInputStream;

	public static function createDefault() {
		$inst = new self();

		$urlParts = parse_url($_SERVER['REQUEST_URI']);

		$inst->setCurrentUrl('/' . ltrim($urlParts['path'], '/'));
		$inst->setRawInputStream(file_get_contents('php://input'));
		$inst->setParams($_REQUEST);

		return $inst;
	}
	
	public function getRawInputStream() {                  return $this->rawInputStream; }
	public function setRawInputStream($rawInputStream) {   $this->rawInputStream = $rawInputStream; }
	
	public function setCurrentUrl($url) {                  $this->currentUrl = $url;  return $this;}
	public function getCurrentUrl() {                      return $this->currentUrl; }

	public function setCommand($cmd) {    $this->command = $cmd;     return $this; }
	public function isCommandSet() {      return isset($this->command); }
	public function getCommand() {        return $this->command; }

	public function setParams($params) {  $this->params = $params;   return $this; }
	public function getParams() {         return $this->params; }

	public function setProp($key, $val) { $this->props[$key] = $val; return $this; }
	public function isPropSet($key) {     return isset($this->props[$key]); }
	public function getProp($key) {       return $this->props[$key]; }
	public function getProps() {          return $this->props; }
	public function unsetProp($key) {     unset($this->props[$key]); }
	


	public function addHeader($key, $val) { 
		$this->headers[strtolower($key)] = $val;
		return $this;
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