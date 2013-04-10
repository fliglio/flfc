<?php

namespace Fliglio\Flfc;

/**
 * Context
 *
 * @package Flfc
 */
class Context {

	private static $instance;
	private $request;
	private $response;

	public static function get() {
		if(is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public static function set(Context $context) {
		self::$instance = $context;
		return self::get();
	}

	public function getRequest() {
		return $this->request;
	}
	public function setRequest(Request $req) {
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

}