<?php

namespace Fliglio\Flfc;

interface HasHeadersToSet {
	public function setHeadersOnResponse(Response $response);
}
