<?php
namespace Fliglio\Flfc;


use Fliglio\Flfc\Resolvers\DefaultFcChainResolver;
use Fliglio\Flfc\Resolvers\NamespaceFcChainResolver;
use Fliglio\Http\Http;

class ResolverTest extends \PHPUnit_Framework_TestCase {

	private $fooApp;
	private $barApp;
	private $chainReg;

	public function createContext($url) {
		$request = new Request();
		$request->setProtocol(Http::HTTP);
		$request->setHttpMethod(Http::METHOD_GET);
		$request->setUrl($url);
		$context = new Context($request, new Response());

		return $context;
	}

	public function setup() {
		$this->fooApp = new StubApp("foo");
		$this->barApp = new StubApp("bar");

		$this->chainReg = new FcChainRegistry();
		$this->chainReg->addResolver(new DefaultFcChainResolver($this->fooApp));
		$this->chainReg->addResolver(new NamespaceFcChainResolver($this->barApp, 'bar'));
	}

	public function testDefaultResolver() {

		// when
		$context = $this->createContext("/foo/hello");
		$dispatcher = new FcDispatcher($this->chainReg, $context, '@404', '@error');
		$dispatcher->dispatch();
		
		// then
		$this->assertEquals($this->fooApp->called, 1);
		$this->assertEquals($this->barApp->called, 0);
	}
	
	public function testNamespaceResolver() {

		// when
		$context = $this->createContext("/bar/hello");
		$dispatcher = new FcDispatcher($this->chainReg, $context, '@404', '@error');
		$dispatcher->dispatch();
		
		// then
		$this->assertEquals($this->fooApp->called, 0);
		$this->assertEquals($this->barApp->called, 1);
	}

}
