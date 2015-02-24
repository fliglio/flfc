<?php

namespace Fliglio\Flfc;

use Fliglio\Web\HttpAttributes;

class RequestFactory {

	public function createDefault() {
		$inst = new Request();

		$inst->setHost(self::getHost());
		$inst->setProtocol(self::getProtocol());
		$inst->setCurrentUrl(self::getCurrentUrl());
		$inst->setPostData(self::getPostData());
		$inst->setGetParams(self::getGetParams());

		$headers = self::getRequestHeaders();
		foreach ($headers as $key => $val) {
			$inst->addHeader($key, $val);
		}

		return $inst;
	}

	private static function getHost() {
		return isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : (
				isset($_SERVER['HOSTNAME']) ? $_SERVER['HOSTNAME'] : (
					isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (
						isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : (
							'localhost'
						)
					)
				)
			);
	}

	private static function getProtocol() {
		$isHttps = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on';

		return $isHttps ? HttpAttributes::HTTPS : HttpAttributes::HTTP;
	}

	private static function getCurrentUrl() {
		$urlParts = parse_url($_SERVER['REQUEST_URI']);
		return '/' . ltrim($urlParts['path'], '/');
	}

	private static function getPostData() {
		return file_get_contents('php://input');
	}

	private static function getGetParams() {
		return $_GET;
	}

	private static function getRequestHeaders() {
		$headers = array();
		if (function_exists('apache_request_headers')) {
			$headers = apache_request_headers();
		} else {
			foreach ($_SERVER as $key => $val) {
				if (substr($key, 0, 5) == 'HTTP_') {
					$key = substr($key, 5);
					$headers[strtolower(str_replace('_', '-', $key))] = $val;
				} else if (strtolower($key) == 'authorization') {
					$headers['authorization'] = $val;
				}
					
			}
		}
		return $headers;
	}

}