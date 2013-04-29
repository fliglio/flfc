<?php

namespace Fliglio\Flfc;

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
		$uri = $context->getRequest()->getCurrentUrl();
		$u = ltrim($uri, "/");
		$ns = ltrim($this->ns, "/");
		return substr($u, 0, strlen($ns)) == $ns;
		// $path = explode("/", ltrim($uri, "/"));
		// return isset($path[0]) && $path[0] == $this->ns;
	}

}