<?php

namespace Fliglio\Flfc;

use Fliglio\Http\ResponseBody;

class UnmarshalledBody implements ResponseBody {
	
	private $content; // mixed
	
	public function __construct($content) {
		$this->content = $content;
	}

	public function getContent() {
		return $this->content;
	}
}
