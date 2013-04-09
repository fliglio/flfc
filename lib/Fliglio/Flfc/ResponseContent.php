<?php

namespace Fliglio\Flfc;

/**
 * Generic Response interface so that custom response objects can be created
 *
 */
interface ResponseContent {
	public function render();
}
