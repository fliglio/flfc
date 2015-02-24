<?php

namespace Fliglio\Flfc;

class DefaultView implements ResponseContent {
	
	protected $content;
	
	public function __construct($content) {
		$this->content = (string)$content;
	}
	
	public function render() {
		return array($this->content);
	}
}
