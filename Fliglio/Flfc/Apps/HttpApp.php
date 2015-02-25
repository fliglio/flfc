<?php

namespace Fliglio\Flfc\Apps;

use Fliglio\Flfc\Context;
use Fliglio\Flfc\HasHeadersToSet;
use Fliglio\Flfc\Exceptions\RedirectException;
use Fliglio\Flfc\Exceptions\Streamable;
use Fliglio\Flfc\ResponseContent;
use Fliglio\Flfc\Response;

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


		if (is_null($response->getStatus())) {
			$response->setStatus(200);
		}
				
		$headers = $response->getHeaders();		
		foreach ($headers AS $key => $val) {
			header($key . ": " . $val);
		}

		if ($response->getBody()) {

			$chunks = $response->getBody()->value();
			foreach ($chunks as $chunk) {
				print $chunk;
			}
		}
	}
}
