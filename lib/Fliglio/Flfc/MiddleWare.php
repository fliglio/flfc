<?php

namespace Fliglio\Flfc;

/**
 * 
 * @package Fl
 */
abstract class MiddleWare extends App {
	protected $wrappedApp;
	
	public function __construct(App $appToWrap) {
		$this->wrappedApp = $appToWrap;
	}
}
