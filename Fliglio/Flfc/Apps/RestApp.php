<?php

namespace Fliglio\Flfc\Apps;

use Fliglio\Flfc\Context;
use Fliglio\Flfc\DefaultView;
use Fliglio\Flfc\Exceptions\PageNotFoundException;
use Fliglio\Flfc\Exceptions\BadRequestException;

class RestApp extends MiddleWare {
	
	public function call(Context $context) {
		$resp = $context->getResponse();

		$content = null;
		$to = null;
		try {
			$to = $this->wrappedApp->call($context);
		} catch (PageNotFoundException $e) {
			$resp->setStatus(404);
			$resp->addHeader('Content-Type', 'text/json');
		} catch (BadRequestException $e) {
			error_log((string)$e);
			$resp->setStatus(500);
			$resp->addHeader('Content-Type', 'text/json');
		}	

		if (is_object($to)) {
			$reflector = new \ReflectionClass(get_class($to));
			if ($reflector->implementsInterface("Fliglio\Flfc\ResponseContent")) {
				$content = $to;
			}
		} 

		if (is_null($content)) {
			$json = is_null($to) ? '' : json_encode($to);
			$content = new DefaultView($json);
		}

		$resp->setContent($content);

		if (!$resp->hasHeader('Content-Type')) {
			$resp->addHeader('Content-Type', 'text/json');
		}
	}

}
