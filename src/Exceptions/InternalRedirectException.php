<?php


namespace Fliglio\Flfc\Exceptions;

class InternalRedirectException extends \Exception {
	private $url;
	public function __construct($url, $message = "internal redirect") {
		parent::__construct($message);
		$this->url = $url;
	}
	public function getUrl() {
		return $this->url;
	}
}