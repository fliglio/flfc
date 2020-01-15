<?php

namespace Fliglio\Flfc\Apps;

abstract class MiddleWare extends App {
	protected $wrappedApp;
	
	public function __construct(App $appToWrap) {
		$this->wrappedApp = $appToWrap;
	}
}
