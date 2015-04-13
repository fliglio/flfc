<?php

namespace Fliglio\Flfc;

use Fliglio\Flfc\Apps\App;
use Fliglio\Flfc\Context;


class StubApp extends App {
	public $context;
	public $id;

	public $called = 0;

	public function __construct($id) {
		$this->id = $id;
	}

	public function call(Context $context) {
		$this->called++;
		$this->context = $context;
	}
}