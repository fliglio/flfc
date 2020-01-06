<?php

namespace Fliglio\Flfc;

/*
 * @Deprecated implemented by fli appmux instead
 */
class FcDispatcherFactory {
	
	public function __construct() {}
	
	public function createDefault(FcChainRegistry $chains) {
		$reqF = new RequestFactory();

		$context = new Context($reqF->createDefault(), new Response());

		return new FcDispatcher($chains, $context, '@404', '@error');
	}
	
}