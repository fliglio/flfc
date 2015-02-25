<?php

namespace Fliglio\Flfc;

use Fliglio\Http\RequestReader;

/**
 * Context
 *
 * @package Flfc
 */
class Context {

	private $request;
	private $response;

	private $props = array();


	public function __construct(RequestReader $request, Response $response){
		$this->request  = $request;
		$this->response = $response;
	}

	public function getRequest() {
		return $this->request;
	}
	public function setRequest(RequestReader $req) {
		$this->request = $req;
		return $this->getRequest();
	}

	public function getResponse() {
		return $this->response;
	}
	public function setResponse(Response $resp) {
		$this->response = $resp; 
		return $this->getResponse();
	}


	public function setProp($key, $val) {
		$this->props[$key] = $val;
	}
	public function isPropSet($key) {
		return isset($this->props[$key]);
	}
	public function getProp($key) {
		return $this->props[$key];
	}
	public function getProps() {
		return $this->props;
	}
	public function unsetProp($key) {
		unset($this->props[$key]);
	}

}
