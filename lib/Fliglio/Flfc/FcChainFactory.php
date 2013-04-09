<?php

namespace Fliglio\Flfc;

class FcChainFactory {

	const DEFAULT_CHAIN = "default";
	
	private static $resolvers = array();
	private static $oldChain;
	
	/** @deprecated  use resolvers instead of setting chain explicitely */
	public static function setChain(App $chain) {
		self::$oldChain = $chain;
	}

	public static function addResolver(ResolvableFcChain $chain) {
		self::$resolvers[] = $chain;
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
	 * @return Flfc_FcChainRunner
	 */
	public static function getChainRunner(Context $context) {
		$chain = null;
		if (isset(self::$oldChain)) {
			$chain = self::$oldChain;
		} else {
			foreach (self::$resolvers as $resolver) {
				if ($resolver->canResolve($context)) {
					$chain = $resolver->getChain();
				}
			}
		}
		if ($chain == null) {
			throw new Exception("Couldn't resolve a FrontControllerChain to use");
		}
		
		return new FcChainRunner($chain);
	}

	public static function getChain(Context $context) {
		$chain = null;
		foreach (self::$resolvers as $resolver) {
			if ($resolver->canResolve($context)) {
				$chain = $resolver->getChain();
			}
		}
		if ($chain == null) {
			throw new Exception("Couldn't resolve a FrontControllerChain to use");
		}
		
		return $chain;
	}


}