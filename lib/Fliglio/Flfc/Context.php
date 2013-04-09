<?php

namespace Fliglio\Flfc;

/**
 * Flfc_Context
 *
 * @package Flfc
 */
class Context {

	/* Flfc_Context */
	private static $instance;

	/* Flfc_Request */
	private $request;

	/* Flfc_Response */
	private $response;

	/* Flfc_Links */
	private $links;
	
	/** @deprecated */
	private $log;
	
	private $isDebug;

	/**
	 * Factory method to get current context
	 * 
	 * @return Flfc_Context current context instance
	 */
	public static function get() {
		if(is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Factory method to set current context
	 * 
	 * @param  Flfc_Context $context set current context
	 * @return Flfc_Context current context instance
	 */
	public static function set(Context $context) {
		self::$instance = $context;
		return self::get();
	}

	public function setDebug($isDebug) {
		$this->isDebug = $isDebug; 
		return $this;
	}
	public function isDebug() {
		return $this->isDebug; 
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