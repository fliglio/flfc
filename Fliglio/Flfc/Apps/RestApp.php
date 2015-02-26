<?php

namespace Fliglio\Flfc\Apps;

use Fliglio\Flfc\Context;
use Fliglio\Flfc\UnmarshalledView;
use Fliglio\Flfc\DefaultView;
use Fliglio\Flfc\Exceptions\PageNotFoundException;
use Fliglio\Flfc\Exceptions\BadRequestException;

class RestApp extends MiddleWare {
	
	public function call(Context $context) {
		$response = $context->getResponse();

		try {
			$this->wrappedApp->call($context);

		} catch (PageNotFoundException $e) {
			$response->setStatus(404);
			$response->setContentType('application/json');
			return;
		} catch (BadRequestException $e) {
			error_log((string)$e);
			$response->setStatus(500);
			$response->setContentType('application/json');
			return;
		}	

		$body = $response->getBody();
		if (!is_null($body)) {
			if (!($body instanceof RenderableResponseBody)) {
				$json = is_null($body->getContent()) ? '' : json_encode($body->getContent());
				$response->setBody(new DefaultView($json));
			}
		} else {
			$response->setBody(new DefaultView(''));
		}

		if (is_null($response->getContentType())) {
			$response->setContentType('application/json');
		}
	}

}
