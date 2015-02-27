<?php

namespace Fliglio\Flfc;

use Fliglio\Flfc\Apps\App;
use Fliglio\Flfc\Exceptions\InternalRedirectException;

class FcDispatcherFactory {
	
	private $chain;
	
	public function __construct() {
	}
	
	public function createDefault(FcChainRegistry $chains) {
		$reqF = new RequestFactory();

		$context = new Context($reqF->createDefault(), new Response());

		return new FcDispatcher($chains, $context, '@404', '@error');
	}

	
}