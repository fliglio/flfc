<?php

namespace Fliglio\Flfc\Apps;

use Fliglio\Flfc\Context;
use Fliglio\Flfc\DefaultBody;
use Fliglio\Http\Exceptions\NotFoundException;
use Fliglio\Http\Exceptions\InternalServerErrorException;
use Fliglio\Http\Exceptions\BadRequestException;
use Fliglio\Http\Exceptions\LocationStatusException;
use Fliglio\Http\Exceptions\HttpStatusException;
use Fliglio\Http\Http;
use Fliglio\Http\RenderableResponseBody;

class RestApp extends MiddleWare {
	
	public function call(Context $context) {
		$response = $context->getResponse();

		try {
			$this->wrappedApp->call($context);

		} catch (NotFoundException $e) {
			$response->setStatus(Http::STATUS_NOT_FOUND);
			$response->setContentType('application/json');
			return;
			
		} catch (InternalServerErrorException $e) {
			$response->setStatus(Http::STATUS_INTERNAL_SERVER_ERROR);
			$response->setContentType('application/json');
			return;

		} catch (BadRequestException $e) {
			error_log((string)$e);
			$response->setStatus(Http::STATUS_BAD_REQUEST);
			$response->setContentType('application/json');
			$response->setBody(new DefaultBody($e->getMessage()));
			return;

		} catch (LocationStatusException $e) {
			$response->setStatus($e->getStatusCode());
			$response->addHeader("Location", (string)$e->getLocation());
			return;

		} catch (HttpStatusException $e) {
			$response->setStatus($e->getStatusCode());
			$response->setContentType('application/json');
			$response->setBody(new DefaultBody($e->getMessage()));
			return;

		} catch (\Exception $e) {
			error_log((string)$e);
			$response->setStatus(Http::STATUS_INTERNAL_SERVER_ERROR);
			$response->setContentType('application/json');
			$response->setBody(new DefaultBody($e->getMessage()));
			return;
		}	

		$body = $response->getBody();
		if (!is_null($body)) {
			if (!($body instanceof RenderableResponseBody)) {
				$json = is_null($body->getContent()) ? '' : json_encode($body->getContent());
				$response->setBody(new DefaultBody($json));
			}
		} else {
			$response->setBody(new DefaultBody(''));
		}

		if (is_null($response->getContentType())) {
			$response->setContentType('application/json');
		}
	}

}
