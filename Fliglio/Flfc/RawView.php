<?php

namespace Fliglio\Flfc;

use Fliglio\Http\ResponseBody;

class RawView implements ResponseBody {
	
	protected $content;
	
	public function __construct($content) {
		$this->content = $content;
	}
	public function getContent() {
		return $this->content;
	}
	public function value() {
		return $this->content;
	}
}
