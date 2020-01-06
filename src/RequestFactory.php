<?php

namespace Fliglio\Flfc;

use Fliglio\Http\Http;
use Fliglio\Web\Url;

class RequestFactory {

	public function createDefault() {
		$inst = new Request();

		$inst->setProtocol(self::getProtocol());
		$inst->setHost(self::getHost());
		$inst->setUrl(self::getCurrentUrl());
		$inst->setHttpMethod(self::getHttpMethod());
		$inst->setBody(self::getBody());
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

		return $isHttps ? Http::HTTPS : Http::HTTP;
	}

	private static function getHttpMethod() {
		return strtolower($_SERVER['REQUEST_METHOD']);
	}

	private static function getCurrentUrl() {
		$urlParts = parse_url($_SERVER['REQUEST_URI']);
		$str = '/' . ltrim($urlParts['path'], '/');
		return Url::fromString($str);
	}

	private static function getBody() {
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