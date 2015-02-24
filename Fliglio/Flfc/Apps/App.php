<?php

namespace Fliglio\Flfc\Apps;

use Fliglio\Flfc\Context;

/**
 * 
 */
abstract class App {
	abstract public function call(Context $context);
}
