<?php

namespace Fliglio\Flfc\Apps;

use Fliglio\Flfc\Context;
use Fliglio\Flfc\ChainData;

abstract class App {

	public function __construct() {
	}

	public function getChainData() {
		return $this->chainData;
	}

	abstract public function call(Context $context);
}
