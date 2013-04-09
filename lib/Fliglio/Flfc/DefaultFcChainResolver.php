<?php

namespace Fliglio\Flfc;

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