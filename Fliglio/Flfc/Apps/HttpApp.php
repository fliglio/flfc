<?php

namespace Fliglio\Flfc\Apps;

use Fliglio\Flfc\Context;
use Fliglio\Flfc\HasHeadersToSet;
use Fliglio\Flfc\Exceptions\RedirectException;
use Fliglio\Flfc\Exceptions\Streamable;
use Fliglio\Flfc\ResponseContent;
use Fliglio\Flfc\Response;
use Fliglio\Flfc\DefaultBody;
use Fliglio\Http\RenderableResponseBody;
use Fliglio\Http\Http;

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

		$body = $response->getBody();
		if (!is_null($body)) {
			if (!($body instanceof RenderableResponseBody)) {
				if (is_string($body->getContent())) {
					$response->setBody(new DefaultBody($body->getContent()));
				} else {
					$response->setBody(new DefaultBody(''));
				}
			}
		} else {
			$response->setBody(new DefaultBody(''));
		}


		if (is_null($response->getStatus())) {
			$response->setStatus(Http::STATUS_OK);
		}

		$response->write();
	}
}
