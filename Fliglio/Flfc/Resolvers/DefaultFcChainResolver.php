<?php

namespace Fliglio\Flfc\Resolvers;

use Fliglio\Flfc\Apps\App;
use Fliglio\Flfc\Context;

class DefaultFcChainResolver implements ResolvableFcChain {

	private $chain;

	public function __construct(App $chain) {
		$this->chain = $chain;
	}

	public function getChain() {
		return $this->chain;
	}
	
	public function canResolve(Context $context) {
		return true;
	}

}