<?php

namespace Fliglio\Flfc;

/**
 * 
 * @package Flfc
 */
class ServeHtmlApp extends App implements ResponseContent {

	private $path;

	public function __construct($path) {
		$this->path = $path;
	}

	public function call(Context $context) {
		if (!is_file($this->path)) {
			$context->getResponse()->setStatus(500);
		}
		$context->getResponse()->setContent($this);
	}
	
	public function render() {
		if (is_file($this->path)) {
			echo file_get_contents($this->path);
		}
	}
}
