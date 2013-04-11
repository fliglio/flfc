<?php

namespace Fliglio\Flfc;

interface ResolvableFcChain {
	public function getChain(); // FlfcApp
	public function canResolve(Context $context); // Boolean
}