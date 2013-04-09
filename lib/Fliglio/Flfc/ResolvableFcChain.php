<?php

namespace Fliglio\Flfc;

interface ResolvableFcChain {
	public function __construct(App $chain);
	public function getChain(); // FlfcApp
	public function canResolve(Context $context); // Boolean
}