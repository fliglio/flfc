<?php

namespace Fliglio\Flfc;

use Fliglio\Flfc\Apps\App;
use Fliglio\Flfc\Exceptions\PageNotFoundException;
use Fliglio\Flfc\Exceptions\InternalRedirectException;

class FcDispatcher {
	
	private $chain;
	private $context;
	private $errorUrl;

	public function __construct(FcChainRegistry $chains, Context $context, $errorUrl) {
		$this->chains = $chains;
		$this->context = $context;
		$this->errorUrl = $errorUrl;
	}
	
	public function dispatch() {
		try {
			$chain = $this->chains->getChain($this->context);
			$chain->call($this->context);

		} catch (InternalRedirectException $e) {
			$this->context->getRequest()->setCurrentUrl($e->getUrl());

			$chain = $this->chains->getChain($this->context);
			$chain->call($this->context);

		} catch (\Exception $e) {
			$this->context->getRequest()->setCurrentUrl($this->errorUrl);
			$this->context->getRequest()->setProp('exception', $e);

			$chain = $this->chains->getChain($this->context);
			$chain->call($this->context);
		}	
	}
}