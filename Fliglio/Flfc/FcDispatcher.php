<?php

namespace Fliglio\Flfc;

use Fliglio\Flfc\Apps\App;
use Fliglio\Http\Exceptions\NotFoundException;
use Fliglio\Flfc\Exceptions\InternalRedirectException;

class FcDispatcher {
	
	private $chain;
	private $context;
	private $notFoundUrl;
	private $errorUrl;

	public function __construct(FcChainRegistry $chains, Context $context, $notFoundUrl, $errorUrl) {
		$this->chains = $chains;
		$this->context = $context;

		$this->notFoundUrl = $notFoundUrl;
		$this->errorUrl = $errorUrl;
	}
	
	public function dispatch() {
		$chain = $this->chains->getChain($this->context);
		try {
			$chain->call($this->context);

		} catch (InternalRedirectException $e) {
			error_log($e->getMessage());

			$this->context->getRequest()->setUrl($e->getUrl());
			$chain->call($this->context);

		} catch (NotFoundException $e) {
			$this->context->getRequest()->setUrl($this->notFoundUrl);

			$chain->call($this->context);
		} catch (\Exception $e) {
			error_log($e->getMessage());
			error_log((string)$e);
			$this->context->getRequest()->setUrl($this->errorUrl);

			$chain->call($this->context);
		}	
	}
}
