<?php

namespace Fliglio\Flfc\Resolvers;

use Fliglio\Flfc\Context;

interface ResolvableFcChain {
	public function getChain(); // FlfcApp
	public function canResolve(Context $context); // Boolean
}