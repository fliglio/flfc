<?php

namespace Fliglio\Flfc\Resolvers;

use Fliglio\Flfc\Apps\App;
use Fliglio\Flfc\Context;

class NamespaceFcChainResolver implements ResolvableFcChain {
	private $chain;
	private $ns;

	public function __construct(App $chain, $ns) {
		$this->chain = $chain;
		$this->ns = $ns;
	}

	public function getChain() {
		return $this->chain;
	}
	
	public function canResolve(Context $context) {
		$uri = $context->getRequest()->getUrl();
		$u = ltrim($uri, "/");
		$ns = ltrim($this->ns, "/");
		return substr($u, 0, strlen($ns)) == $ns;
	}

}