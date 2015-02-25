<?php

namespace Fliglio\Flfc\Resolvers;

use Fliglio\Flfc\Context;

interface ResolvableFcChain {
	public function getChain(); // Flfc\Apps\App
	public function canResolve(Context $context); // bool
}