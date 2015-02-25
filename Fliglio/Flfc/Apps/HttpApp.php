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
			$to = $this->wrappedApp->call($context);
			if (is_object($to)) {
				$reflector = new \ReflectionClass(get_class($to));
				if ($reflector->implementsInterface("Fliglio\Flfc\ResponseContent")) {
					$context->GetResponse()->setContent($to);
				}
			} 

		} catch (RedirectException $e) {
			$context->getResponse()->addHeader("Location", (string)$e->getLocation());
			$context->getResponse()->setStatus($e->getStatusCode());
		}

		$response = $context->getResponse();

		$status = $response->getStatus();
		if ($status === null) {
			$response->setStatus(200);
			$status = $response->getStatus();
		}

		$response->addHeader("HTTP/1.1 " . $status->code, $status->message);
				
		$headers = $response->getHeaders();		
		foreach ($headers AS $key => $val) {
			header($key . ": " . $val);
		}

		if ($response->getContent()) {

			$chunks = $response->getContent()->render();
			foreach ($chunks as $chunk) {
				print $chunk;
			}
		}
	}
}
