<?php

namespace Fliglio\Flfc;

class RedirectException extends \Exception {

	protected $code;
	protected $location;
	public function __construct( $message, $code, $location ) {
		parent::__construct( $message );
		$this->code = $code;
		$this->location = $location;
	}
	public function getStatusCode() { return $this->code; }
	public function getLocation() { return $this->location; }
}
