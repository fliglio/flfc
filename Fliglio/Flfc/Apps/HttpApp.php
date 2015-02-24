<?php

namespace Fliglio\Flfc\Apps;

use Fliglio\Flfc\Context;
use Fliglio\Flfc\HasHeadersToSet;
use Fliglio\Flfc\Exceptions\RedirectException;
use Fliglio\Flfc\Exceptions\Streamable;
use Fliglio\Flfc\ResponseContent;

class HttpApp extends MiddleWare {
	public function call(Context $context) {
		
		/* Call Child App
		 */
		try {
			$this->wrappedApp->call($context);
		} catch (RedirectException $e) {
			$context->getResponse()->addHeader("Location", (string)$e->getLocation());
			$context->getResponse()->setStatus($e->getStatusCode());
		}

		$response = $context->getResponse();

		$status = $response->getStatus();

		$response->addHeader("HTTP/1.1 " . $status->code, $status->message);
		
		if ($response->getContent() instanceof HasHeadersToSet) {
			$response->getContent()->setHeadersOnResponse($response);
		}
		
		$headers = $response->getHeaders();
		
		foreach ($headers AS $key => $val) {
			header($key . ": " . $val);
		}

		if ($response->getContent()) {
			switch (true) {
			case $response->getContent() instanceof Streamable :
				$response->getContent()->stream();
				break;
			case $response->getContent() instanceof ResponseContent :
				print $response->getContent()->render();
				break;
			}
		}
	}
}
