<?php

namespace Fliglio\Flfc\Exceptions;

class PageNotFoundException extends InternalRedirectException {

	public function __construct($message) {
		parent::__construct('@404', $message);
	}

}
