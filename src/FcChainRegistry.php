<?php

namespace Fliglio\Flfc;

use Fliglio\Flfc\Resolvers\ResolvableFcChain;

class FcChainRegistry {

	const DEFAULT_CHAIN = "default";
	
	private $resolvers = array();
	
	public function addResolver(ResolvableFcChain $chain) {
		$this->resolvers[] = $chain;
	}
	
	/**
	 * Resolvers act as overrides: The first resolver on the stack should be
	 * the DefaultResolver and will always resolve the request (canResolve
	 * always returns true.) Subsequent resolvers should return true if they 
	 * want to resolve the request instead of the default resolver.
	 * 
	 * :. the last resolver which returns true is the one that will be used.
	 * 
	 * @param Flfc_Context $context  Context to use in deciding which chain to use.
	 * @return ResolvableFcChain
	 */
	public function getChain(Context $context) {
		$chain = null;
		foreach ($this->resolvers as $resolver) {
			if ($resolver->canResolve($context)) {
				$chain = $resolver->getChain();
			}
		}
		if ($chain == null) {
			throw new \Exception("Couldn't resolve a FrontControllerChain to use");
		}
		
		return $chain;
	}


}