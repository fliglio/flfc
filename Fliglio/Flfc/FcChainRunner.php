<?php

namespace Fliglio\Flfc;

class FcChainRunner {
	
	private $chain;
	
	public function __construct(App $chain = null) {
		$this->chain = $chain;
	}
	
	public function dispatchRequest(Context $context, $pnfUrl, $errorUrl) {
		try {
			$chain = FcChainFactory::getChain($context);
			$chain->call($context);

		} catch (PageNotFoundException $e) {
			$context->getRequest()->setCurrentUrl($pnfUrl);
			$chain = FcChainFactory::getChain($context);

			$chain->call($context);

		} catch (InternalRedirectException $e) {
			$context->getRequest()->setCurrentUrl($e->getUrl());
			$chain = FcChainFactory::getChain($context);

			$chain->call($context);

		} catch (Exception $e) {
			$context->getRequest()->setCurrentUrl($errorUrl);
			$context->getRequest()->setProp('exception', $e);
			$chain = FcChainFactory::getChain($context);

			$chain->call($context);
		}
	
	}
	
}