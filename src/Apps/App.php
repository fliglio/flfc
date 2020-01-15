<?php

namespace Fliglio\Flfc\Apps;

use Fliglio\Flfc\Context;

abstract class App {

	public function __construct() {}

	public function getChainData() {
		return $this->chainData;
	}

	abstract public function call(Context $context);
}
