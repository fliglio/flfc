<?php

namespace Fliglio\Flfc\Apps;

use Fliglio\Flfc\Context;
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

		// if rawResponse is a ResponseBody, use it
		if ($context->isPropSet('rawResponse')) {
			$to = $context->getProp('rawResponse');

			if (is_object($to)) {
				$reflector = new \ReflectionClass(get_class($to));
				if ($reflector->implementsInterface("Fliglio\Http\ResponseBody")) {
					$response->setBody($to);
					$context->unsetProp('rawResponse');
				}
			} 
		}

		// if rawResponse is unknown type, json_encode it
		if ($context->isPropSet('rawResponse')) {
			$to = $context->getProp('rawResponse');
			$json = is_null($to) ? '' : json_encode($to);
			$response->setBody(new DefaultView($json));
			$context->unsetProp('rawResponse');
		}

		if (is_null($response->getContentType())) {
			$response->setContentType('application/json');
		}
	}

}
