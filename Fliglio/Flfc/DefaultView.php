<?php

namespace Fliglio\Flfc;

use Fliglio\Http\ResponseBody;

class DefaultView implements ResponseBody {
	
	protected $content;
	
	public function __construct($content) {
		$this->content = (string)$content;
	}
	
	public function value() {
		return array($this->content);
	}
}
