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

	private $pageNotFoundUrl;
	private $errorUrl;

	public function getRawInputStream() {                  return $this->rawInputStream; }
	public function setRawInputStream($rawInputStream) {   $this->rawInputStream = $rawInputStream; }
	
	public function setCurrentUrl($url) {                  $this->currentUrl = $url;  return $this;}
	public function getCurrentUrl() {                      return $this->currentUrl; }

	public function getPageNotFoundUrl() {                 return $this->pageNotFoundUrl; }
	public function setPageNotFoundUrl($pageNotFoundUrl) { $this->pageNotFoundUrl = $pageNotFoundUrl; }

	public function getErrorUrl() {                        return $this->errorUrl; }
	public function setErrorUrl($errorUrl) {               $this->errorUrl = $errorUrl; }

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