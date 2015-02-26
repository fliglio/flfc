<?php

namespace Fliglio\Flfc;

use Fliglio\Http\RenderableResponseBody;

class DefaultView implements RenderableResponseBody {
	
	private $content; // string
	
	public function __construct($content) {
		$this->content = (string)$content;
	}

	public function getContent() {
		return $this->content;
	}

	public function render() {
		print $this->getContent();
	}
}
