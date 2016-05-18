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

use Fliglio\Http\Exceptions\MovedPermanentlyException;
use Fliglio\Http\Exceptions\FoundException;

class HttpApp extends MiddleWare {

	public function call(Context $context) {
		try {
			$this->wrappedApp->call($context);

		} catch (MovedPermanentlyException $e) {
			$context->getResponse()->addHeader("Location", (string)$e->getLocation());
			$context->getResponse()->setStatus(Http::STATUS_MOVED_PERMANENTLY);

		} catch (FoundException $e) {
			$context->getResponse()->addHeader("Location", (string)$e->getLocation());
			$context->getResponse()->setStatus(Http::STATUS_FOUND);
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

		$context->getResponse()->write();
	}

}
